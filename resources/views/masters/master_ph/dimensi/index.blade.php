@extends('layouts.app')

@section('title', 'PH Dimensi')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tes Dimensi Management</h1>

        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All Dimensi</h6>

            </div>
            <div class="card-body">
                <form action="{{ route('ph.dimensi.filter') }}" method="GET">
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
                                <th width="15%">Populasi</th>
                                <th width="10%">Status</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dimensis as $dimensi)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($dimensi->created_at)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                                    <td>{{ $dimensi->shift_id }}</td>
                                    <td>{{ $dimensi->order_id }}</td>
                                    <td>{{ $dimensi->user->nama }}</td>
                                    <td>{{ $dimensi->populasi }}</td>
                                    <td>
                                        @if ($dimensi->is_confirm == 0)
                                            <span class="badge badge-danger">Not Confirm</span>
                                        @elseif ($dimensi->is_confirm == 1)
                                            <span class="badge badge-success">Confirmed</span>
                                        @endif
                                    </td>
                                    <td style="display: flex">
                                        <a href="{{ route('ph.dimensi.detail', ['dimensi' => $dimensi->id]) }}"
                                            class="btn btn-primary m-2">
                                            <i class="fas fa-tasks"></i>
                                        </a>
                                        <a href="{{ route('ph.dimensi.edit', ['dimensi' => $dimensi->id]) }}"
                                            class="btn btn-primary m-2">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                        <a class="btn btn-danger m-2" href="#" data-toggle="modal" data-target="#deleteModal" onclick="event.preventDefault(); document.getElementById('user-delete-form').action = '{{ route('ph.dimensi.destroy', ['dimensi' => $dimensi->id]) }}'">
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
