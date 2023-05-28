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
                        <a href="#" id="addMemberButton" data-bs-toggle="modal" data-bs-target="#addMemberModal" class="btn bg-gradient-primary btn-sm mb-0" type="button">+&nbsp; Data Baru</a>
                    </div>
                        <div class="d-flex align-items-center mt-3">
                            <div class="mb-3">
                                <form action="{{ route('members.index') }}" method="GET" class="mb-3">
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
                                <form action="{{ route('members.index') }}" method="GET" class="mb-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" placeholder="Search" name="search" value="{{ request('search') }}">
                                        <button type="submit" class="btn btn-primary btn-sm" style="margin-bottom: 0;">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <div class="modal fade" id="addMemberModal" tabindex="-1" aria-labelledby="addMemberModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addMemberModalLabel">Add Member</h5>
                                </div>
                                <div class="modal-body">
                                    <form id="addMemberForm" method="POST" action="{{ route('members.store') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="name" name="name" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="age" class="form-label">Age</label>
                                            <input type="number" class="form-control" id="age" name="age" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="text" class="form-control" id="email" name="email" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">Phone</label>
                                            <input type="number" class="form-control" id="phone" name="phone" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="photo" class="form-label">Photo</label>
                                            <input type="file" class="form-control" id="photo" name="photo" accept="image/*" required>
                                        </div>
                                        <!-- Add more fields for address, phone, and photo if needed -->
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
                                        Photo
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Nama
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Umur
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Email
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Nomor Handphone
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($members as $index => $member)
                                <tr>
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{ $index + 1 }}</p>
                                    </td>
                                    <td>
                                        <div>
                                            <img src="{{ asset('assets/img/tables-photo/' . $member->photo) }}" class="avatar avatar-sm me-3">
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $member->name }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $member->age }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $member->email }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $member->phone }}</p>
                                    </td>
                            
                                    <td class="align-middle text-center">
                                            <a href="{{ route('members.update', $member->id) }}" data-bs-toggle="modal" data-bs-target="#editMemberModal{{ $member->id }}" class="text-secondary font-weight-bold text-xs">
                                                <i class="fas fa-user-edit text-secondary"></i>
                                            </a>
                                            <a href="{{ route('members.delete', $member->id) }}" data-bs-toggle="modal" data-bs-target="#deleteMemberModal{{ $member->id }}" class="text-secondary font-weight-bold text-xs">
                                                <i class="fas fa-trash-alt text-secondary"></i>
                                            </a>
                                    </td>
                                </tr>
                                @endforeach
                                @if($members->isEmpty())
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
                                {{ $members->links('pagination::bootstrap-4') }}
                            </ul>
                        </nav>
                        @foreach($members as $member)
                            <div class="modal fade" id="deleteMemberModal{{ $member->id }}" tabindex="-1" aria-labelledby="deleteModal{{ $member->id }}Label" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteMemberModal{{ $member->id }}Label">Delete Member</h5>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete this member?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('members.delete', $member->id) }}" method="POST">
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
                        @foreach($members as $member)
                            <div class="modal fade" id="editMemberModal{{ $member->id }}" tabindex="-1" aria-labelledby="editModal{{ $member->id }}Label" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editMemberModal{{ $member->id }}"Label">Edit Member</h5>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('members.update', $member->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Name</label>
                                                    <input type="text" class="form-control" id="name" name="name" value="{{ $member->name }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="age" class="form-label">Age</label>
                                                    <input type="text" class="form-control" id="age" name="age" value="{{ $member->age }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="email" name="email" value="{{ $member->email }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="phone" class="form-label">Phone</label>
                                                    <input type="text" class="form-control" id="phone" name="phone" value="{{ $member->phone }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="photo" class="form-label">Photo</label>
                                                    <input type="file" class="form-control" id="photo" name="photo">
                                                </div>

                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<meta name="csrf-token" content="{{ csrf_token() }}">
@push('scripts')
<script>
    var deleteMemberUrl = "{{ route('members.delete', ['id' => ':id']) }}";
</script>
<script src="{{ asset('js/edit.js') }}"></script>\
<script src="{{ asset('js/delete.js') }}"></script>
<script src="{{ asset('js/search.js') }}"></script>
@endpush
@endsection