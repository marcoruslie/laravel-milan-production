@extends('layouts.app')

@section('title', 'GL Analisa List')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">GL Analisa</h1>
        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All GL Analisa</h6>

            </div>
            <div class="card-body">
                <form action="{{ route('gl.analisa.filter') }}" method="GET">
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
                                <th width="10%">Grup Motive</th>
                                <th width="15%">Jenis Cacat</th>
                                <th width="10%">No Mould</th>
                                <th width="10%">Jenis Perbaikan</th>
                                <th width="10%">Status</th>
                                <th width="10%">Confirm</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($analisas as $analisa)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($analisa->created_at)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                                    <td>{{ $analisa->shift_id }}</td>
                                    <td>{{ $analisa->order_id }}</td>
                                    <td>{{ $analisa->user->nama }}</td>
                                    <td>{{ $analisa->grup_motive }}</td>
                                    <td>{{ $analisa->jenis_cacat }}</td>
                                    <td>{{ $analisa->no_mould }}</td>
                                    <td>{{ $analisa->jenis_perbaikan }}</td>
                                    <td>{{ $analisa->status }}</td>
                                    <td>
                                        @if ($analisa->is_confirm == 0)
                                            <span class="badge badge-danger">Not Confirm</span>
                                        @elseif ($analisa->is_confirm == 1)
                                            <span class="badge badge-success">Confirmed</span>
                                        @endif
                                    </td>
                                    <td style="display: flex">

                                        <a href="{{ route('gl.analisa.edit', ['analisa' => $analisa->id]) }}"
                                            class="btn btn-primary m-2">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                        <a class="btn btn-danger m-2" href="#" data-toggle="modal" data-target="#deleteModal" onclick="event.preventDefault(); document.getElementById('user-delete-form').action = '{{ route('gl.analisa.destroy', ['analisa' => $analisa->id]) }}'">
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
