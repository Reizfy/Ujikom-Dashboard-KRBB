@extends('layouts.user_type.auth')

@section('content')



<div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Data Uang Kas</h5>
                        </div>
                        <a href="#" id="addKasButton" data-bs-toggle="modal" data-bs-target="#addKasModal" class="btn bg-gradient-primary btn-sm mb-0" type="button">+&nbsp; Data Baru</a>
                    </div>
                        <div class="d-flex align-items-center mt-3">
                            <div class="mb-3">
                                <form action="{{ route('uang-kas.index') }}" method="GET" class="mb-3">
                                    <div class="input-group">
                                        <select name="perPage" id="perPage" class="form-select form-select-sm" style="width: 60px;" onchange="this.form.submit()">
                                            <option value="5"{{ request('perPage') == 5 ? ' selected' : '' }}>5</option>
                                            <option value="10"{{ request('perPage') == 10 ? ' selected' : '' }}>10</option>
                                            <option value="15"{{ request('perPage') == 15 ? ' selected' : '' }}>15</option>
                                            <option value="20"{{ request('perPage') == 20 ? ' selected' : '' }}>20</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <div class="mb-3" style="margin-left: 10px;">
                                <form action="{{ route('uang-kas.index') }}" method="GET" class="mb-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" placeholder="Search" name="search" value="{{ request('search') }}">
                                        <button type="submit" class="btn btn-primary btn-sm" style="margin-bottom: 0;">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="modal fade" id="addKasModal" tabindex="-1" aria-labelledby="addKasModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addKasModalLabel">Add Uang Kas</h5>
                                    </div>
                                    <div class="modal-body">
                                        <form id="addMemberForm" method="POST" action="{{ route('uang-kas.store') }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3">
                                                <input type="number" class="form-control" id="saldo" name="saldo" style="display: none;" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label for="tanggal" class="form-label">Tanggal</label>
                                                <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="keterangan" class="form-label">Keterangan</label>
                                                <input type="text" class="form-control" id="keterangan" name="keterangan" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="jenis" class="form-label">Jenis</label>
                                                <select class="form-select" id="jenis" name="jenis" onchange="changeJenis()" required>
                                                    <option value="" disabled selected>Pilih Jenis</option>
                                                    <option value="debit">Debit</option>
                                                    <option value="kredit">Kredit</option>
                                                </select>
                                            </div>
                                            <div class="mb-3" id="fieldDebit">
                                                <label for="debit" class="form-label">Debit</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">Rp.</span>
                                                    <input type="number" class="form-control" id="debit" name="debit" min="0" step="0.01" oninput="calculateSaldo()" required>
                                                </div>
                                            </div>
                                            <div class="mb-3" id="fieldKredit">
                                                <label for="kredit" class="form-label">Kredit</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">Rp.</span>
                                                    <input type="number" class="form-control" id="kredit" name="kredit" min="0" step="0.01" oninput="calculateSaldo()" required>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        @if(session()->has('success'))
                        <div class="m-3 alert alert-success alert-dismissible fade show" id="alert-success" role="alert">
                            <span class="alert-text text-white">{{ session('success') }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                <i class="fa fa-close" aria-hidden="true"></i>
                            </button>
                        </div>
                        @php
                            Session::forget('success');
                        @endphp
                        @endif
                        @if(session()->has('error'))
                        <div class="m-3 alert alert-danger alert-dismissible fade show" id="alert-error" role="alert">
                            <span class="alert-text text-white">{{ session('error') }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                <i class="fa fa-close" aria-hidden="true"></i>
                            </button>
                        </div>
                        @php
                            Session::forget('error');
                        @endphp
                        @endif
                        <table id="membersTable" class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        No
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Tanggal
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Keterangan
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Debit
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Kredit
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Saldo
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($uangKas as $index => $item)
                            <tr>
                                <td class="ps-4">
                                    <p class="text-xs font-weight-bold mb-0">{{ $index + 1 }}</p>
                                </td>
                                <td>
                                    <div>
                                        <p class="text-xs font-weight-bold mb-0">{{ $item->tanggal }}</p>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <p class="text-xs font-weight-bold mb-0">{{ $item->keterangan }}</p>
                                </td>
                                <td class="text-center">
                                    <p class="text-xs font-weight-bold mb-0">{{ $item->debit }}</p>
                                </td>
                                <td class="text-center">
                                    <p class="text-xs font-weight-bold mb-0">{{ $item->kredit }}</p>
                                </td>
                                <td class="text-center">
                                    <p class="text-xs font-weight-bold mb-0">{{ $item->saldo }}</p>
                                </td>
                                <td class="align-middle text-center">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#deleteUangKasModal{{ $item->id }}" class="text-secondary font-weight-bold text-xs">
                                        <i class="fas fa-trash-alt text-secondary"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        @if($isEmpty)
                            <tr>
                                <td colspan="7" class="text-center">
                                    <p class="text-xs font-weight-bold mb-0">Tabel Kosong</p>
                                </td>
                            </tr>
                        @endif
                            </tbody>
                        </table>
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center">
                                {{ $uangKas->links('pagination::bootstrap-4') }}
                            </ul>
                        </nav>
                        @foreach($uangKas as $item)
                        <div class="modal fade" id="deleteUangKasModal{{ $item->id }}" tabindex="-1" aria-labelledby="deleteModal{{ $item->id }}Label" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModal{{ $item->id }}Label">Delete Uang Kas</h5>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to delete this entry?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route('uang-kas.delete', ['id' => $item->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div class="modal fade" id="exportToExcelModal" tabindex="-1" aria-labelledby="exportToExcelModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exportToExcelModalLabel">Export to Excel</h5>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('export-to-excel') }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="start_date" class="form-label">Start Date</label>
                                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="end_date" class="form-label">End Date</label>
                                                <input type="date" class="form-control" id="end_date" name="end_date" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Export</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exportToExcelModal" style="width: 150px; margin-left: 25px;">Export to Excel</button>
        </div>
    </div>
</div>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    function changeJenis() {
    var jenis = document.getElementById("jenis").value;
    var fieldDebit = document.getElementById("fieldDebit");
    var fieldKredit = document.getElementById("fieldKredit");

    if (jenis === "debit") {
        fieldDebit.style.display = "block";
        fieldKredit.style.display = "none";
        document.getElementById("debit").disabled = false;
        document.getElementById("kredit").disabled = true;
    } else if (jenis === "kredit") {
        fieldDebit.style.display = "none";
        fieldKredit.style.display = "block";
        document.getElementById("debit").disabled = true;
        document.getElementById("kredit").disabled = false;
    } else {
        fieldDebit.style.display = "none";
        fieldKredit.style.display = "none";
        document.getElementById("debit").disabled = true;
        document.getElementById("kredit").disabled = true;
    }
}
changeJenis();
</script>
@endsection