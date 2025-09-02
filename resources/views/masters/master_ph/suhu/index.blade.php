@extends('layouts.app')

@section('title', 'PH Suhu')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tes Suhu Management</h1>

        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All Control</h6>

            </div>
            <div class="card-body">
                <form action="{{ route('ph.temps.filter') }}" method="GET">
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
                                <th width="10%">Diebox Setting</th>
                                <th width="10%">Diebox Actual</th>
                                <th width="10%">Upper Setting</th>
                                <th width="10%">Upper Setting</th>
                                <th width="10%">Lower Actual</th>
                                <th width="10%">Lower Actual</th>
                                <th width="10%">Status</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($temps as $temp)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($temp->created_at)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                                    <td>{{ $temp->shift_id }}</td>
                                    <td>{{ $temp->order_id }}</td>
                                    <td>{{ $temp->user->nama }}</td>
                                    <td>{{ $temp->DB_setting }}</td>
                                    <td>{{ $temp->DB_actual }}</td>
                                    <td>{{ $temp->UP_setting }}</td>
                                    <td>{{ $temp->UP_actual }}</td>
                                    <td>{{ $temp->LW_setting }}</td>
                                    <td>{{ $temp->LW_actual }}</td>
                                    <td>
                                        @if ($temp->is_confirm == 0)
                                            <span class="badge badge-danger">Not Confirm</span>
                                        @elseif ($temp->is_confirm == 1)
                                            <span class="badge badge-success">Confirmed</span>
                                        @endif
                                    </td>
                                    <td style="display: flex">

                                        <a href="{{ route('ph.temps.edit', ['temp' => $temp->id]) }}"
                                            class="btn btn-primary m-2">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                        <a class="btn btn-danger m-2" href="#" data-toggle="modal" data-target="#deleteModal" onclick="event.preventDefault(); document.getElementById('user-delete-form').action = '{{ route('ph.temps.destroy', ['temp' => $temp->id]) }}'">
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

    @include('masters.master_ph.suhu.delete-modal')

@endsection

@section('scripts')

@endsection
