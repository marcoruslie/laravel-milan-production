@extends('layouts.app')

@section('title', 'Rk Cek Gumpil List')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">RK Cek Gumpil</h1>
        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All RK Cek Gumpil</h6>

            </div>
            <div class="card-body">
                <form action="{{ route('rk.cek.filter') }}" method="GET">
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
                                <th width="10%">User</th>
                                <th width="10%">Motive</th>
                                <th width="5%">Size</th>
                                <th width="5%">Sample</th>
                                <th width="10%">Pcs Gumpil</th>
                                <th width="10%">Persen Gumpil</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ceks as $cek)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($cek->created_at)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                                    <td>{{ $cek->shift_id }}</td>
                                    <td>{{ $cek->order_id }}</td>
                                    <td>{{ $cek->user->nama }}</td>
                                    <td>{{ $cek->motif }}</td>
                                    <td>{{ $cek->size }}</td>
                                    <td>{{ $cek->sample }}</td>
                                    <td>{{ $cek->pcs_gumpil }}</td>
                                    <td>{{ $cek->persen_gumpil }}</td>
                                    <td style="display: flex">

                                        <a href="{{ route('rk.cek.edit', ['cek' => $cek->id]) }}"
                                            class="btn btn-primary m-2">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                        <a class="btn btn-danger m-2" href="#" data-toggle="modal" data-target="#deleteModal" onclick="event.preventDefault(); document.getElementById('user-delete-form').action = '{{ route('rk.cek.destroy', ['cek' => $cek->id]) }}'">
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
