@extends('layouts.app')

@section('title', 'Edit User')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Users</h1>
        <a href="{{route('users.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
    </div>

    {{-- Alert Messages --}}
    @include('common.alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit User</h6>
        </div>
        <form method="POST" action="{{route('users.update', ['user' => $user->id])}}">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="form-group row">

                    {{-- First Name --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>NIP</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('nip') is-invalid @enderror"
                            id="examplenip"
                            placeholder="First Name"
                            name="nip"
                            value="{{ old('nip') ?  old('nip') : $user->nip}}">

                        @error('nip')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Last Name --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Nama</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('nama') is-invalid @enderror"
                            id="exampleNama"
                            placeholder="Nama"
                            name="nama"
                            value="{{ old('nama') ? old('nama') : $user->nama }}">

                        @error('nama')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Kode Divisi --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Kode Divisi</label>
                        <input
                            type="kode_divisi"
                            class="form-control form-control-user @error('kode_divisi') is-invalid @enderror"
                            id="exampleKodeDivisi"
                            placeholder="kode divisi"
                            name="kode_divisi"
                            value="{{ old('kode_divisi') ? old('kode_divisi') : $user->kode_divisi }}">

                        @error('kode_divisi')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Kode Bagian --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Kode Bagian</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('kode_bagian') is-invalid @enderror"
                            id="exampleKodeBagian"
                            placeholder="Kode Bagian"
                            name="kode_bagian"
                            value="{{ old('kode_bagian') ? old('kode_bagian') : $user->kode_bagian }}">

                        @error('kode_bagian')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Kode Jabatan --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Kode Jabatan</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('kode_jabatan') is-invalid @enderror"
                            id="exampleKodeJabatan"
                            placeholder="Kode Jabatan"
                            name="kode_jabatan"
                            value="{{ old('kode_jabatan') ? old('kode_jabatan') : $user->kode_jabatan }}">

                        @error('kode_jabatan')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Kode Grup --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Kode Grup</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('kode_grup') is-invalid @enderror"
                            id="exampleKodeGrup"
                            placeholder="Kode Grup"
                            name="kode_grup"
                            value="{{ old('kode_grup') ? old('kode_grup') : $user->kode_grup }}">

                        @error('kode_grup')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Role --}}
                    {{-- <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Role</label>
                        <select class="form-control form-control-user @error('role_id') is-invalid @enderror" name="role_id">
                            <option selected disabled>Select Role</option>
                            @foreach ($roles as $role)
                                <option value="{{$role->id}}"
                                    {{old('role_id') ? ((old('role_id') == $role->id) ? 'selected' : '') : (($user->role_id == $role->id) ? 'selected' : '')}}>
                                    {{$role->name}}
                                </option>
                            @endforeach
                        </select>
                        @error('role_id')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div> --}}

                    {{-- Status --}}
                    {{-- <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Status</label>
                        <select class="form-control form-control-user @error('status') is-invalid @enderror" name="status">
                            <option selected disabled>Select Status</option>
                            <option value="1" {{old('role_id') ? ((old('role_id') == 1) ? 'selected' : '') : (($user->status == 1) ? 'selected' : '')}}>Active</option>
                            <option value="0" {{old('role_id') ? ((old('role_id') == 0) ? 'selected' : '') : (($user->status == 0) ? 'selected' : '')}}>Inactive</option>
                        </select>
                        @error('status')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div> --}}

                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-success btn-user float-right mb-3">Update</button>
                <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('users.index') }}">Cancel</a>
            </div>
        </form>
    </div>

</div>


@endsection
