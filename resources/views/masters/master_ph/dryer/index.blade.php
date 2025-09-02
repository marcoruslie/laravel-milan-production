@extends('layouts.app')

@section('title', 'PH Dryer')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tes Dryer Management</h1>

        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All Control</h6>

            </div>
            <div class="card-body">
                <form action="{{ route('ph.dryer.filter') }}" method="GET">
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
                                <th width="6%">Dryers</th>
                                <th width="5%">S11/BT11</th>
                                <th width="5%">S12/BT12</th>
                                <th width="5%">BT13</th>
                                <th width="5%">KA%</th>
                                <th width="5%">Counter VD</th>
                                <th width="5%">Temp Aplikasi</th>
                                <th width="6%">Kondisi ET</th>
                                <th width="6%">Floating Grid</th>
                                <th width="6%">Sikat & Roll</th>
                                <th width="6%">Below</th>
                                <th width="10%">Status</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dryers as $dryer)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($dryer->created_at)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                                    <td>{{ $dryer->shift_id }}</td>
                                    <td>{{ $dryer->order_id }}</td>
                                    <td>{{ $dryer->user->nama }}</td>
                                    <td>{{ $dryer->dryers }}</td>
                                    <td>{{ $dryer->param1 }}</td>
                                    <td>{{ $dryer->param2 }}</td>
                                    <td>{{ $dryer->param3 }}</td>
                                    <td>{{ $dryer->param4 }}</td>
                                    <td>{{ $dryer->counterVd }}</td>
                                    <td>{{ $dryer->tempAplikasi }}</td>
                                    <td>{{ $dryer->kondisi_et }}</td>
                                    <td>{{ $dryer->floating_grid }}</td>
                                    <td>{{ $dryer->sikat_rol }}</td>
                                    <td>{{ $dryer->below }}</td>
                                    <td>
                                        @if ($dryer->is_confirm == 0)
                                            <span class="badge badge-danger">Not Confirm</span>
                                        @elseif ($dryer->is_confirm == 1)
                                            <span class="badge badge-success">Confirmed</span>
                                        @endif
                                    </td>
                                    <td style="display: flex">

                                        <a href="{{ route('ph.dryer.edit', ['dryer' => $dryer->id])}}"
                                            class="btn btn-primary m-2">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                        <a class="btn btn-danger m-2" href="#" data-toggle="modal" data-target="#deleteModal" onclick="event.preventDefault(); document.getElementById('user-delete-form').action = '{{ route('ph.dryer.destroy', ['dryer' => $dryer->id]) }}'">
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

    @include('masters.master_ph.dryer.delete-modal')

@endsection

@section('scripts')

@endsection
