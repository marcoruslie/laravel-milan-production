@extends('layouts.app')

@section('title', 'BP Detail Powder')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Detail Powder Management</h1>
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
                                <th width="5%">T3</th>
                                <th width="5%">Silo</th>
                                <th width="5%">Kadar Air</th>
                                <th width="5%">PPB</th>
                                <th width="5%">VC</th>
                                <th width="5%">MF</th>
                                <th width="5%">AF</th>
                                {{-- <th width="10%">Action</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($details as $detail)
                                <tr>
                                    <td>{{ $detail->created_at->format('H:i') }}</td>
                                    <td>{{ $detail->h_pengendalian_powder->order_id }}</td>
                                    <td>{{ $detail->t1 }}</td>
                                    <td>{{ $detail->t3 }}</td>
                                    <td>{{ $detail->silo }}</td>
                                    <td>{{ $detail->kadar_air }}</td>
                                    <td>{{ $detail->ppb }}</td>
                                    <td>{{ $detail->vc }}</td>
                                    <td>{{ $detail->mf }}</td>
                                    <td>{{ $detail->af }}</td>
                                    {{-- <td style="display: flex">
                                        <a href="{{ route('ph.dimensi.edit', ['dimensi' => $dimensi->id]) }}"
                                            class="btn btn-primary m-2">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                        <a class="btn btn-danger m-2" href="#" data-toggle="modal" data-target="#deleteModal" onclick="event.preventDefault(); document.getElementById('user-delete-form').action = '{{ route('ph.dimensi.destroy', ['dimensi' => $detail->id]) }}'">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td> --}}
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
