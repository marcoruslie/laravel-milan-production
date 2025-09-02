@extends('layouts.app')

@section('title', 'GL Proccess Control List')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">GL Proccess Control</h1>
        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- Filter Form -->
        <form action="{{ route('gl.proccessControl.filter') }}" method="GET">
            <div class="form-row mb-3">
                <div class="col">
                    <input type="date" class="form-control" name="date" placeholder="Date" value="{{ $date }}">
                </div>
                <div class="col">
                    <select class="form-control" name="shift">
                        @foreach($shifts as $shiftOption)
                            <option value="{{ $shiftOption->id }}" @if($shift == $shiftOption->id) selected @endif>{{ $shiftOption->nama_shift }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Analisa Tes Bakar</h6>

            </div>
            <div class="card-body">


                {{-- Analisa --}}
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
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Loading</h6>

            </div>
            <div class="card-body">
                {{-- Loading --}}
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="10%">Shift</th>
                                <th width="10%">Order</th>
                                <th width="10%">User</th>
                                <th width="10%">From</th>
                                <th width="10%">No</th>
                                <th width="10%">Start</th>
                                <th width="10%">Stop</th>
                                <th width="10%">Menit</th>
                                <th width="10%">Jumlah</th>
                                <th width="10%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($loadings as $loading)
                                <tr>
                                    <td>{{ $loading->shift_id }}</td>
                                    <td>{{ $loading->order_id }}</td>
                                    <td>{{ $loading->user->nama }}</td>
                                    <td>{{ $loading->from }}</td>
                                    <td>{{ $loading->no }}</td>
                                    <td>{{ $loading->start }}</td>
                                    <td>{{ $loading->stop }}</td>
                                    <td>{{ $loading->menit }}</td>
                                    <td>{{ $loading->jumlah }}</td>
                                    <td>
                                        @if ($loading->is_confirm == 0)
                                            <span class="badge badge-danger">Not Confirm</span>
                                        @elseif ($loading->is_confirm == 1)
                                            <span class="badge badge-success">Confirmed</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Pengendalian Proses</h6>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
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
