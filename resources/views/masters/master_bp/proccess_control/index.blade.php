@extends('layouts.app')

@section('title', 'BP Proccess Control List')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">BP Proccess Control</h1>
        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- Filter Form -->
        <form action="{{ route('bp.proccessControl.filter') }}" method="GET">
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
                <h6 class="m-0 font-weight-bold text-primary">Pengendalian Proses SLip</h6>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="10%">Tanggal</th>
                                <th width="10%">Shift</th>
                                <th width="10%">Order</th>
                                <th width="10%">User</th>
                                <th width="10%">BM</th>
                                <th width="10%">Komposisi</th>
                                <th width="10%">Liter Air</th>
                                <th width="10%">Start</th>
                                <th width="10%">Finish</th>
                                <th width="10%">STTP</th>
                                <th width="10%">Water Glass</th>
                                <th width="10%">Air</th>
                                <th width="10%">Jam Giling</th>
                                <th width="10%">Alumina</th>
                                <th width="10%">Setting Jam Giling</th>
                                <th width="10%">Total Jam Giling</th>
                                <th width="10%">Masuk Tanki No</th>
                                <th width="10%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pengendalianSlips as $pengendalianSlip)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($pengendalianSlip->created_at)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                                    <td>{{ $pengendalianSlip->shift_id }}</td>
                                    <td>{{ $pengendalianSlip->order_id }}</td>
                                    <td>{{ $pengendalianSlip->user->nama }}</td>
                                    <td>{{ $pengendalianSlip->bm }}</td>
                                    <td>{{ $pengendalianSlip->komposisi }}</td>
                                    <td>{{ $pengendalianSlip->air_liter }}</td>
                                    <td>{{ $pengendalianSlip->start }}</td>
                                    <td>{{ $pengendalianSlip->finish }}</td>
                                    <td>{{ $pengendalianSlip->sttp }}</td>
                                    <td>{{ $pengendalianSlip->water_glass }}</td>
                                    <td>{{ $pengendalianSlip->air }}</td>
                                    <td>{{ $pengendalianSlip->jam_giling }}</td>
                                    <td>{{ $pengendalianSlip->alumina }}</td>
                                    <td>{{ $pengendalianSlip->setting_jam_giling }}</td>
                                    <td>{{ $pengendalianSlip->total_jam_giling }}</td>
                                    <td>{{ $pengendalianSlip->masuk_tanki_no }}</td>
                                    <td>
                                        @if ($pengendalianSlip->is_confirm == 0)
                                            <span class="badge badge-danger">Not Confirm</span>
                                        @elseif ($pengendalianSlip->is_confirm == 1)
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
                <h6 class="m-0 font-weight-bold text-primary">Pengendalian Proses Powder</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="10%">Shift</th>
                            <th width="10%">Order</th>
                            <th width="10%">User</th>
                            <th width="10%">Start Spray</th>
                            <th width="10%">Powder Masuk</th>
                            <th width="10%">Stop Spray</th>
                            <th width="10%">Dari Tanki</th>
                            <th width="10%">Ke Tanki</th>
                            <th width="10%">Reologi</th>
                            <th width="10%">Kapasitas</th>
                            <th width="10%">Granulasi</th>
                            <th width="10%">Indicator</th>
                            <th width="10%">Nozle 1</th>
                            <th width="10%">Nozle 2</th>
                            <th width="10%">Jumlah</th>
                            <th width="10%">Status</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengendalianPowders as $pengendalianPowder)
                            <tr>
                                <td>{{ $pengendalianPowder->shift_id }}</td>
                                <td>{{ $pengendalianPowder->order_id }}</td>
                                <td>{{ $pengendalianPowder->user->nama }}</td>
                                <td>{{ $pengendalianPowder->start_spray }}</td>
                                <td>{{ $pengendalianPowder->powder_masuk }}</td>
                                <td>{{ $pengendalianPowder->stop_spray }}</td>
                                <td>{{ $pengendalianPowder->dari_tanki }}</td>
                                <td>{{ $pengendalianPowder->ke_tanki }}</td>
                                <td>{{ $pengendalianPowder->reologi }}</td>
                                <td>{{ $pengendalianPowder->kapasitas }}</td>
                                <td>{{ $pengendalianPowder->granulasi }}</td>
                                <td>{{ $pengendalianPowder->indicator }}</td>
                                <td>{{ $pengendalianPowder->nozle_1 }}</td>
                                <td>{{ $pengendalianPowder->nozle_2 }}</td>
                                <td>{{ $pengendalianPowder->jumlah }}</td>
                                <td>
                                    @if ($pengendalianPowder->is_confirm == 0)
                                        <span class="badge badge-danger">Not Confirm</span>
                                    @elseif ($pengendalianPowder->is_confirm == 1)
                                        <span class="badge badge-success">Confirmed</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Rekap Hasil Slip</h6>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="10%">Shift</th>
                                <th width="10%">Order</th>
                                <th width="10%">User</th>
                                <th width="10%">Komposisi Body</th>
                                <th width="10%">Tab</th>
                                <th width="10%">A2</th>
                                <th width="10%">A3</th>
                                <th width="10%">A4</th>
                                <th width="10%">B1</th>
                                <th width="10%">B4</th>
                                <th width="10%">B5</th>
                                <th width="10%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rekapSlips as $rekapSlip)
                                <tr>
                                    <td>{{ $rekapSlip->shift_id }}</td>
                                    <td>{{ $rekapSlip->order_id }}</td>
                                    <td>{{ $rekapSlip->user->nama }}</td>
                                    <td>{{ $rekapSlip->komposisi_body }}</td>
                                    <td>{{ $rekapSlip->tab }}</td>
                                    <td>{{ $rekapSlip->a2 }}</td>
                                    <td>{{ $rekapSlip->a3 }}</td>
                                    <td>{{ $rekapSlip->a4 }}</td>
                                    <td>{{ $rekapSlip->b1 }}</td>
                                    <td>{{ $rekapSlip->b4 }}</td>
                                    <td>{{ $rekapSlip->b5 }}</td>
                                    <td>
                                        @if ($rekapSlip->is_confirm == 0)
                                            <span class="badge badge-danger">Not Confirm</span>
                                        @elseif ($rekapSlip->is_confirm == 1)
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
                <h6 class="m-0 font-weight-bold text-primary">Rekap Hasil Powder</h6>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="10%">Shift</th>
                                <th width="10%">Order</th>
                                <th width="10%">User</th>
                                <th width="10%">Stok 1</th>
                                <th width="10%">Stok 2</th>
                                <th width="10%">Stok 3</th>
                                <th width="10%">Stok 4</th>
                                <th width="10%">Stok 5</th>
                                <th width="10%">Total Powder</th>
                                <th width="10%">ATM 40</th>
                                <th width="10%">Kapasitas ATM40</th>
                                <th width="10%">ATM 90</th>
                                <th width="10%">Kapasitas ATM90</th>
                                <th width="10%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rekapPowders as $rekapPowder)
                                <tr>
                                    <td>{{ $rekapPowder->shift_id }}</td>
                                    <td>{{ $rekapPowder->order_id }}</td>
                                    <td>{{ $rekapPowder->user->nama }}</td>
                                    <td>{{ $rekapPowder->stok1 }}</td>
                                    <td>{{ $rekapPowder->stok2 }}</td>
                                    <td>{{ $rekapPowder->stok3 }}</td>
                                    <td>{{ $rekapPowder->stok4 }}</td>
                                    <td>{{ $rekapPowder->stok5 }}</td>
                                    <td>{{ $rekapPowder->total_powder }}</td>
                                    <td>{{ $rekapPowder->atm40 }}</td>
                                    <td>{{ $rekapPowder->kapasitas40 }}</td>
                                    <td>{{ $rekapPowder->atm90 }}</td>
                                    <td>{{ $rekapPowder->kapasitas90 }}</td>
                                    <td>
                                        @if ($rekapPowder->is_confirm == 0)
                                            <span class="badge badge-danger">Not Confirm</span>
                                        @elseif ($rekapPowder->is_confirm == 1)
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


@endsection

@section('scripts')

@endsection
