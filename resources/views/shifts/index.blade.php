@extends('layouts.app')

@section('title', 'Shift List')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Shifts</h1>
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ route('shifts.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Add New
                    </a>
                </div>
            </div>
        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All Shifts</h6>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="10%">Shift</th>
                                <th width="10%">Jam Mulai</th>
                                <th width="10%">Jam Akhir</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($shifts as $shift)
                                <tr>
                                    <td>{{ $shift->nama_shift }}</td>
                                    <td>{{ $shift->jam_mulai_shift }}</td>
                                    <td>{{ $shift->jam_akhir_shift }}</td>
                                    <td style="display: flex">

                                        <a href="{{ route('shifts.edit', ['shift' => $shift->id]) }}"
                                            class="btn btn-primary m-2">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                        <a class="btn btn-danger m-2" href="#" data-toggle="modal" data-target="#deleteModal" onclick="event.preventDefault(); document.getElementById('user-delete-form').action = '{{ route('shifts.destroy', ['shift' => $shift->id]) }}'">
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

    @include('common.delete-modal')

@endsection

@section('scripts')

@endsection
