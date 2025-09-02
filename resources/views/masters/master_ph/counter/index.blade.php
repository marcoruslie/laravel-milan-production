@extends('layouts.app')

@section('title', 'PH Counter')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tes Counter Management</h1>

        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All Counter</h6>

            </div>
            <div class="card-body">
                <form action="{{ route('ph.counter.filter') }}" method="GET">
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
                                <th width="15%">Diebox</th>
                                <th width="5%">Upper M1</th>
                                <th width="5%">Upper M2</th>
                                <th width="5%">Upper M3</th>
                                <th width="5%">Upper M4</th>
                                <th width="5%">Lower M1</th>
                                <th width="5%">Lower M2</th>
                                <th width="5%">Lower M3</th>
                                <th width="5%">Lower M4</th>
                                <th width="10%">Status</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($counters as $counter)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($counter->created_at)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                                    <td>{{ $counter->shift_id }}</td>
                                    <td>{{ $counter->order_id }}</td>
                                    <td>{{ $counter->user->nama }}</td>
                                    <td>{{ $counter->db }}</td>
                                    <td>{{ $counter->up_m1 }}</td>
                                    <td>{{ $counter->up_m2 }}</td>
                                    <td>{{ $counter->up_m3 }}</td>
                                    <td>{{ $counter->up_m4 }}</td>
                                    <td>{{ $counter->lw_m1 }}</td>
                                    <td>{{ $counter->lw_m2 }}</td>
                                    <td>{{ $counter->lw_m3 }}</td>
                                    <td>{{ $counter->lw_m4 }}</td>
                                    <td>
                                        @if ($counter->is_confirm == 0)
                                            <span class="badge badge-danger">Not Confirm</span>
                                        @elseif ($counter->is_confirm == 1)
                                            <span class="badge badge-success">Confirmed</span>
                                        @endif
                                    </td>
                                    <td style="display: flex">

                                        <a href="{{ route('ph.counter.edit', ['counter' => $counter->id]) }}"
                                            class="btn btn-primary m-2">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                        <a class="btn btn-danger m-2" href="#" data-toggle="modal" data-target="#deleteModal" onclick="event.preventDefault(); document.getElementById('user-delete-form').action = '{{ route('ph.counter.destroy', ['counter' => $counter->id]) }}'">
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

    @include('masters.master_ph.counter.delete-modal')

@endsection

@section('scripts')

@endsection
