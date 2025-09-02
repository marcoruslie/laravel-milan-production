@extends('layouts.app')

@section('title', 'Users List')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Users</h1>
        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All Users</h6>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="10%">NIP</th>
                                <th width="25%">Nama</th>
                                <th width="15%">Kode Divisi</th>
                                <th width="15%">Kode Bagian</th>
                                <th width="15%">Kode Jabatan</th>
                                <th width="10%">Kode Grup</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->nip }}</td>
                                    <td>{{ $user->nama }}</td>
                                    <td>{{ $user->kode_divisi }}</td>
                                    <td>{{ $user->kode_bagian }}</td>
                                    <td>{{ $user->kode_jabatan }}</td>
                                    <td>{{ $user->kode_grup }}</td>
                                    <td style="display: flex">

                                        <a href="{{ route('users.edit', ['user' => $user->id]) }}"
                                            class="btn btn-primary m-2">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                        <a class="btn btn-danger m-2" href="#" data-toggle="modal" data-target="#deleteModal">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    @include('users.delete-modal')

@endsection

@section('scripts')

@endsection
