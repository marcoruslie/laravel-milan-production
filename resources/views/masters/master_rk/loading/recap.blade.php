@extends('layouts.app')

@section('title', 'RK Loading Recap')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">RK Loading Recap</h1>
        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All RK Loading Recap</h6>

            </div>
            <div class="card-body">
                <form action="{{ route('rk.loading.filterRecap') }}" method="GET">
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
                                <th width="10%">Tanggal</th>
                                <th width="10%">Shift</th>
                                <th width="10%">Order</th>
                                <th width="10%">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($loadings as $loading)
                                <tr>
                                    <td>{{ $loading->day }}</td>
                                    <td>{{ $loading->shift_id }}</td>
                                    <td>{{ $loading->order_id }}</td>
                                    <td>{{ $loading->total_jumlah }}</td>
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
