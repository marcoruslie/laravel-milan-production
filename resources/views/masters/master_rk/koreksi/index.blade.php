@extends('layouts.app')

@section('title', 'Rk Koreksi')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Koreksi Tiles Management</h1>
        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All Koreksi Tiles</h6>

            </div>
            <div class="card-body">
                <form action="{{ route('rk.koreksi.filter') }}" method="GET">
                    <div class="form-row mb-3">
                        <div class="col">
                            <input type="date" class="form-control" name="start_date" placeholder="Start Date" value="{{ $start_date }}">
                        </div>
                        <div class="col">
                            <input type="date" class="form-control" name="end_date" placeholder="End Date" value="{{ $end_date }}">
                        </div>
                        <div class="col">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="10%">Timestamp</th>
                                <th width="5%">Shift</th>
                                <th width="10%">Order</th>
                                <th width="15%">User</th>
                                <th width="10%">Mode</th>
                                <th width="10%">Koreksi KILN</th>
                                <th width="10%">AS</th>
                                <th width="10%">AT</th>
                                <th width="10%">Status</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($koreksis as $koreksi)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($koreksi->created_at)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                                    <td>{{ $koreksi->shift_id }}</td>
                                    <td>{{ $koreksi->order_id }}</td>
                                    <td>{{ $koreksi->user->nama }}</td>
                                    <td>{{ $koreksi->mode }}</td>
                                    <td>{{ $koreksi->koreksi_kiln_kiri . '/' . $koreksi->koreksi_kiln_kanan}} </td>
                                    <td>{{ $koreksi->as}} </td>
                                    <td>{{ $koreksi->at}} </td>
                                    <td>
                                        @if ($koreksi->is_confirm == 0)
                                            <span class="badge badge-danger">Not Confirm</span>
                                        @elseif ($koreksi->is_confirm == 1)
                                            <span class="badge badge-success">Confirmed</span>
                                        @endif
                                    </td>
                                    <td style="display: flex">
                                        <a href="{{ route('rk.koreksi.detail', ['koreksi' => $koreksi->id]) }}"
                                            class="btn btn-primary m-2">
                                            <i class="fa fa-external-link"></i>
                                        </a>
                                        <a href="{{ route('rk.koreksi.edit', ['koreksi' => $koreksi->id]) }}"
                                            class="btn btn-primary m-2">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                        <a class="btn btn-danger m-2" href="#" data-toggle="modal" data-target="#deleteModal" onclick="event.preventDefault(); document.getElementById('user-delete-form').action = '{{ route('rk.koreksi.destroy', ['koreksi' => $koreksi->id]) }}'">
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
