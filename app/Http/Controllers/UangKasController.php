<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UangKas;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class UangKasController extends Controller
{
    public function list()
    {
        $uangKas = UangKas::all();
        return view('uang-kas', compact('uangKas'));
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('perPage', 5);

        $uangKasQuery = UangKas::query()
            ->when($search, function ($query, $search) {
                return $query->where('id', 'LIKE', '%' . $search . '%')
                    ->orWhere('tanggal', 'LIKE', '%' . $search . '%')
                    ->orWhere('keterangan', 'LIKE', '%' . $search . '%')
                    ->orWhere('debit', 'LIKE', '%' . $search . '%')
                    ->orWhere('kredit', 'LIKE', '%' . $search . '%')
                    ->orWhere('saldo', 'LIKE', '%' . $search . '%');
            });

        $uangKas = $uangKasQuery->paginate($perPage)->withQueryString();

        $isEmpty = $uangKas->isEmpty();

        return view('uang-kas', compact('uangKas', 'isEmpty'));
    }

    public function create()
    {
        $uangKas = new UangKas();
        $uangKas->saldo = 0;

        return view('uang-kas.create', compact('uangKas'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required',
            'jenis' => 'required|in:debit,kredit',
            'debit' => 'required_if:jenis,debit|numeric|min:0',
            'kredit' => 'required_if:jenis,kredit|numeric|min:0',
        ]);

        // Get the current saldo from the database
        $currentSaldo = UangKas::orderBy('id', 'desc')->value('saldo');

        if ($request->jenis === 'debit') {
            // Check if saldo is 0 or insufficient for debit transaction
            if ($currentSaldo <= 0 || $currentSaldo - $request->debit < 0) {
                return redirect()->back()->with('error', 'Transaksi debit tidak dapat dilakukan karena saldo tidak mencukupi.');
            }

            $saldo = $currentSaldo - $request->debit;
        } elseif ($request->jenis === 'kredit') {
            $saldo = $currentSaldo + $request->kredit;
        }

        $uangKas = new UangKas;
        $uangKas->tanggal = $request->tanggal;
        $uangKas->keterangan = $request->keterangan;
        $uangKas->debit = ($request->jenis === 'debit') ? $request->debit : null;
        $uangKas->kredit = ($request->jenis === 'kredit') ? $request->kredit : null;
        $uangKas->saldo = $saldo;
        $uangKas->save();

        return redirect()->back()->with('success', 'Data uang kas berhasil disimpan.');
    }

    public function delete($id)
{
    try {
        \DB::beginTransaction();

        $deletedUangKas = UangKas::findOrFail($id);

        // Delete the entry
        $deletedUangKas->delete();

        // Update saldo for the remaining entries
        $entries = UangKas::orderBy('id', 'asc')->get();
        $saldo = 0;
        foreach ($entries as $entry) {
            if ($entry->debit !== null) {
                $saldo -= $entry->debit;
            } elseif ($entry->kredit !== null) {
                $saldo += $entry->kredit;
            }

            // Check if saldo is less than 0
            if ($saldo < 0) {
                throw new \Exception('Perubahan saldo tidak valid. Saldo tidak boleh kurang dari 0.');
            }

            $entry->saldo = $saldo;
            $entry->save();
        }

        \DB::commit();

        return redirect()->back()->with('success', 'Data uang kas berhasil dihapus.');
    } catch (\Exception $e) {
        \DB::rollback();

        return redirect()->back()->with('error', $e->getMessage());
    }
}



    public function exportToExcel(Request $request)
{
    $request->validate([
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
    ]);

    $startDate = $request->start_date;
    $endDate = $request->end_date;

    // Mendapatkan data dari database berdasarkan rentang tanggal
    $data = UangKas::whereBetween('tanggal', [$startDate, $endDate])->get();

    // Membuat objek Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Menulis judul kolom
    $sheet->setCellValue('A1', 'Tanggal');
    $sheet->setCellValue('B1', 'Keterangan');
    $sheet->setCellValue('C1', 'Debit');
    $sheet->setCellValue('D1', 'Kredit');
    $sheet->setCellValue('E1', 'Saldo');

    // Menulis data
    $row = 2;
    foreach ($data as $uangKas) {
        $sheet->setCellValue('A' . $row, $uangKas->tanggal);
        $sheet->setCellValue('B' . $row, $uangKas->keterangan);
        $sheet->setCellValue('C' . $row, $uangKas->debit);
        $sheet->setCellValue('D' . $row, $uangKas->kredit);
        $sheet->setCellValue('E' . $row, $uangKas->saldo);
        $row++;
    }

    // Membuat objek Writer untuk menulis ke file
    $writer = new Xlsx($spreadsheet);

    // Menyimpan file Excel
    $filename = 'data_uang_kas.xlsx';
    $writer->save($filename);

    // Mengirim file Excel ke browser untuk diunduh
    return response()->download($filename)->deleteFileAfterSend(true);
}

}
