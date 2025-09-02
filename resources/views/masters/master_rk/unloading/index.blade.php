@extends('layouts.app')

@section('title', 'RK Unloading List')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">RK Unloading</h1>
            <div class="row">
            </div>
        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All RK Unloading</h6>

            </div>
            <div class="card-body">
                <form action="{{ route('rk.unloading.filter') }}" method="GET">
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
                                <th width="30%">Tanggal</th>
                                <th width="5%">Shift</th>
                                <th width="10%">Order</th>
                                <th width="10%">User</th>
                                <th width="6%">From</th>
                                <th width="6%">No</th>
                                <th width="6%">Jumlah</th>
                                <th width="6%">Kompensator</th>
                                <th width="10%">Start</th>
                                <th width="10%">Stop</th>
                                <th width="10%">Menit</th>
                                <th width="6%">Unloading</th>
                                <th width="10%">Status</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($unloadings as $unloading)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($unloading->created_at)->locale('id')->isoFormat('D MMMM YYYY') }}</td>

                                    <td>{{ $unloading->shift_id }}</td>
                                    <td>{{ $unloading->order_id }}</td>
                                    <td>{{ $unloading->user->nama }}</td>
                                    <td>{{ $unloading->from }}</td>
                                    <td>{{ $unloading->no }}</td>
                                    <td>{{ $unloading->jumlah }}</td>
                                    <td>{{ $unloading->kompensator }}</td>
                                    <td>{{ $unloading->start }}</td>
                                    <td>{{ $unloading->stop }}</td>
                                    <td>{{ $unloading->menit }}</td>
                                    <td>{{ $unloading->unloading }}</td>
                                    <td>
                                        @if ($unloading->is_confirm == 0)
                                            <span class="badge badge-danger">Not Confirm</span>
                                        @elseif ($unloading->is_confirm == 1)
                                            <span class="badge badge-success">Confirmed</span>
                                        @endif
                                    </td>
                                    <td style="display: flex">

                                        <a href="{{ route('rk.unloading.edit', ['unloading' => $unloading->id]) }}"
                                            class="btn btn-primary m-2">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                        <a class="btn btn-danger m-2" href="#" data-toggle="modal" data-target="#deleteModal" onclick="event.preventDefault(); document.getElementById('user-delete-form').action = '{{ route('rk.unloading.destroy', ['unloading' => $unloading->id]) }}'">
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
