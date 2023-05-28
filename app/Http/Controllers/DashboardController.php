<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Models\UangKas;


class DashboardController extends Controller
{
    public function index()
    {
        $members = Member::all();
        return view('dashboard', compact('members'));
    }
    
    public function dashboard()
{
    $totalDebit = UangKas::whereNotNull('debit')->sum('debit');
    $totalKredit = UangKas::whereNotNull('kredit')->sum('kredit');
    $saldo = UangKas::orderBy('id', 'desc')->value(\DB::raw('coalesce(saldo, 0)'));
    $totalMember = Member::count();

    return view('dashboard', [
        'totalDebit' => $totalDebit,
        'totalKredit' => $totalKredit,
        'saldo' => $saldo,
        'totalMember' => $totalMember,
    ]);
}


}
