@extends('layouts.app')

@section('title', 'Down Time List')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Down Time</h1>
        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All Down Time</h6>

            </div>
            <div class="card-body">
                <form action="{{ route('downtime.filter') }}" method="GET">
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
                                <th width="10%">Order</th>
                                <th width="10%">Work Center</th>
                                <th width="10%">Start Date</th>
                                <th width="10%">Start Time</th>
                                <th width="10%">Respond Date</th>
                                <th width="10%">Respond Time</th>
                                <th width="10%">Finish Date</th>
                                <th width="10%">Finish Time</th>
                                <th width="10%">Grund</th>
                                <th width="10%">Keterangan</th>
                                <th width="10%">Cancel?</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($times as $time)
                                <tr>
                                    <td>{{ $time->order_id }}</td>
                                    <td>{{ $time->work_center }}</td>
                                    <td>{{ $time->start_date }}</td>
                                    <td>{{ $time->start_time }}</td>
                                    <td>{{ $time->respond_date }}</td>
                                    <td>{{ $time->respond_time }}</td>
                                    <td>{{ $time->finish_date }}</td>
                                    <td>{{ $time->finish_time }}</td>
                                    <td>{{ $time->grund }}</td>
                                    <td>{{ $time->lngtxt }}</td>
                                    <td>{{ $time->cancel }}</td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

@endsection
