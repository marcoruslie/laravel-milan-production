@extends('layouts.app')

@section('title', 'GL Pengendalian Proses List')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">GL Pengendalian Proses</h1>
        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All GL Pengendalian Proses</h6>

            </div>
            <div class="card-body">
                <form action="{{ route('gl.pengendalian.filter') }}" method="GET">
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
                                <th width="10%">Jenis Aplikasi</th>
                                <th width="10%">Engobe</th>
                                <th width="10%">Engobe Visco</th>
                                <th width="10%">Engobe Densi</th>
                                <th width="10%">Engobe Berat</th>
                                <th width="10%">Glaze</th>
                                <th width="10%">Glaze Visco</th>
                                <th width="10%">Glaze Densi</th>
                                <th width="10%">Glaze Berat</th>
                                <th width="10%">Pasta</th>
                                <th width="10%">Pasta Visco</th>
                                <th width="10%">Pasta Densi</th>
                                <th width="10%">Temp Body</th>
                                <th width="10%">Set Pemukul</th>
                                <th width="10%">Sikat</th>
                                <th width="10%">Saringan</th>
                                <th width="10%">Status</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pengendalians as $pengendalian)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($pengendalian->created_at)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                                    <td>{{ $pengendalian->shift_id }}</td>
                                    <td>{{ $pengendalian->order_id }}</td>
                                    <td>{{ $pengendalian->user->nama }}</td>
                                    <td>{{ $pengendalian->jenis_aplikasi }}</td>
                                    <td>{{ $pengendalian->engobe }}</td>
                                    <td>{{ $pengendalian->engobe_visco }}</td>
                                    <td>{{ $pengendalian->engobe_densi }}</td>
                                    <td>{{ $pengendalian->engobe_berat }}</td>
                                    <td>{{ $pengendalian->glaze }}</td>
                                    <td>{{ $pengendalian->glaze_visco }}</td>
                                    <td>{{ $pengendalian->glaze_densi }}</td>
                                    <td>{{ $pengendalian->glaze_berat }}</td>
                                    <td>{{ $pengendalian->pasta }}</td>
                                    <td>{{ $pengendalian->pasta_visco }}</td>
                                    <td>{{ $pengendalian->pasta_densi }}</td>
                                    <td>{{ $pengendalian->temp_body }}</td>
                                    <td>{{ $pengendalian->set_pemukul }}</td>
                                    <td>{{ $pengendalian->sikat }}</td>
                                    <td>{{ $pengendalian->saringan }}</td>
                                    <td>
                                        @if ($pengendalian->is_confirm == 0)
                                            <span class="badge badge-danger">Not Confirm</span>
                                        @elseif ($pengendalian->is_confirm == 1)
                                            <span class="badge badge-success">Confirmed</span>
                                        @endif
                                    </td>
                                    <td style="display: flex">

                                        <a href="{{ route('gl.pengendalian.edit', ['pengendalian' => $pengendalian->id]) }}"
                                            class="btn btn-primary m-2">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                        <a class="btn btn-danger m-2" href="#" data-toggle="modal" data-target="#deleteModal" onclick="event.preventDefault(); document.getElementById('user-delete-form').action = '{{ route('gl.pengendalian.destroy', ['pengendalian' => $pengendalian->id]) }}'">
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
