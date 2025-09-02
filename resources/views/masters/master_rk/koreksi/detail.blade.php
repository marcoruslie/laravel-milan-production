@extends('layouts.app')

@section('title', 'Rk Detail Koreksi')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Detail Koreksi Management</h1>
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ route('rk.koreksi.index') }}" class="btn btn-md btn-primary">
                        <i class="fas fa-reorder"></i> Back
                    </a>
                </div>
            </div>
        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All Detail</h6>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="10%">Timestamp</th>
                                <th width="10%">Order</th>
                                <th width="5%">T1</th>
                                <th width="5%">T2</th>
                                <th width="5%">T3</th>
                                <th width="5%">T4</th>
                                <th width="5%">T5</th>
                                <th width="5%">T6</th>
                                <th width="5%">T7</th>
                                <th width="5%">T8</th>
                                <th width="5%">T9</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($details as $detail)
                                <tr>
                                    <td>{{ $detail->created_at->format('d - m - Y') }}</td>
                                    <td>{{ $detail->h_koreksi->order_id }}</td>
                                    <td>{{ $detail->T1 }}</td>
                                    <td>{{ $detail->T2 }}</td>
                                    <td>{{ $detail->T3 }}</td>
                                    <td>{{ $detail->T4 }}</td>
                                    <td>{{ $detail->T5 }}</td>
                                    <td>{{ $detail->T6 }}</td>
                                    <td>{{ $detail->T7 }}</td>
                                    <td>{{ $detail->T8 }}</td>
                                    <td>{{ $detail->T9 }}</td>
                                    <td style="display: flex">
                                        {{-- <a href="{{ route('rk.dimensi.edit', ['dimensi' => $dimensi->id]) }}"
                                            class="btn btn-primary m-2">
                                            <i class="fa fa-pen"></i>
                                        </a> --}}
                                        <a class="btn btn-danger m-2" href="#" data-toggle="modal" data-target="#deleteModal" onclick="event.preventDefault(); document.getElementById('user-delete-form').action = '{{ route('rk.dimensi.destroy', ['dimensi' => $detail->id]) }}'">
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
