@extends('layouts.app')

@section('title', 'RK Proccess Control List')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">RK Proccess Control</h1>
        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- Filter Form -->
        <form action="{{ route('rk.proccessControl.filter') }}" method="GET">
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
                <h6 class="m-0 font-weight-bold text-primary">Unloading</h6>

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
                                <th width="6%">From</th>
                                <th width="6%">No</th>
                                <th width="6%">Jumlah</th>
                                <th width="6%">Kompensator</th>
                                <th width="10%">Start</th>
                                <th width="10%">Stop</th>
                                <th width="10%">Menit</th>
                                <th width="6%">Unloading</th>
                                <th width="10%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($unloadings as $unloading)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($unloading->created_at)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                                    <td>{{ $unloading->shift_id }}</td>
                                    <td>{{ $unloading->order_id }}</td>
                                    <td>{{ $unloading->user->nama }}</td>
                                    <td>{{ $unloading->from }}</td>
                                    <td>{{ $unloading->no }}</td>
                                    <td>{{ $unloading->jumlah }}</td>
                                    <td>{{ $unloading->kompensator }}</td>
                                    <td>{{ $unloading->start }}</td>
                                    <td>{{ $unloading->stop }}</td>
                                    <td>{{ $unloading->menit }}</td>
                                    <td>{{ $unloading->unloading }}</td>
                                    <td>
                                        @if ($unloading->is_confirm == 0)
                                            <span class="badge badge-danger">Not Confirm</span>
                                        @elseif ($unloading->is_confirm == 1)
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
                                <th width="5%">No</th>
                                <th width="5%">Out Kiln</th>
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
                                    <td>{{ $loading->outKiln }}</td>
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
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Koreksi Tiles</h6>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="10%">Timestamp</th>
                                <th width="5%">Shift</th>
                                <th width="10%">Order</th>
                                <th width="15%">User</th>
                                <th width="10%">Mode</th>
                                <th width="10%">Koreksi KILN</th>
                                <th width="10%">AS</th>
                                <th width="10%">AT</th>
                                <th width="10%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($koreksis as $koreksi)
                                <tr>
                                    <td>{{ $koreksi->created_at->format('d - m - Y') }}</td>
                                    <td>{{ $koreksi->shift_id }}</td>
                                    <td>{{ $koreksi->order_id }}</td>
                                    <td>{{ $koreksi->user->nama }}</td>
                                    <td>{{ $koreksi->mode }}</td>
                                    <td>{{ $koreksi->koreksi_kiln_kiri . '/' . $koreksi->koreksi_kiln_kanan}} </td>
                                    <td>{{ $koreksi->as}} </td>
                                    <td>{{ $koreksi->at}} </td>
                                    <td>
                                        @if ($koreksi->is_confirm == 0)
                                            <span class="badge badge-danger">Not Confirm</span>
                                        @elseif ($koreksi->is_confirm == 1)
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
                                <th width="10%">Fan Vacum Min</th>
                                <th width="10%">Fan Vacum Max</th>
                                <th width="10%">Fan Temp</th>
                                <th width="10%">Gas Preasure Min</th>
                                <th width="10%">Gas Preasure Max</th>
                                <th width="10%">h28</th>
                                <th width="10%">h27</th>
                                <th width="10%">h1</th>
                                <th width="10%">h2</th>
                                <th width="10%">h3</th>
                                <th width="10%">f4</th>
                                <th width="10%">h5</th>
                                <th width="10%">f6</th>
                                <th width="10%">f6 Setting</th>
                                <th width="10%">h7</th>
                                <th width="10%">f8</th>
                                <th width="10%">a9</th>
                                <th width="10%">a9 Setting</th>
                                <th width="10%">a10</th>
                                <th width="10%">a10 Setting</th>
                                <th width="10%">a11</th>
                                <th width="10%">a11 Setting</th>
                                <th width="10%">a12</th>
                                <th width="10%">a12 Setting</th>
                                <th width="10%">a13</th>
                                <th width="10%">a13 Setting</th>
                                <th width="10%">a14</th>
                                <th width="10%">a14 Setting</th>
                                <th width="10%">a15</th>
                                <th width="10%">a15 Setting</th>
                                <th width="10%">a16</th>
                                <th width="10%">a16 Setting</th>
                                <th width="10%">a17</th>
                                <th width="10%">a17 Setting</th>
                                <th width="10%">a18</th>
                                <th width="10%">a18 Setting</th>
                                <th width="10%">a19</th>
                                <th width="10%">a19 Setting</th>
                                <th width="10%">a20</th>
                                <th width="10%">a20 Setting</th>
                                <th width="10%">a21</th>
                                <th width="10%">a21 Setting</th>
                                <th width="10%">a22</th>
                                <th width="10%">a22 Setting</th>
                                <th width="10%">a23</th>
                                <th width="10%">a24</th>
                                <th width="10%">f25</th>
                                <th width="10%">f26</th>
                                <th width="10%">f26 Setting</th>
                                <th width="10%">Comb Preasure</th>
                                <th width="10%">Comb Temp</th>
                                <th width="10%">Zero Point</th>
                                <th width="10%">Hot Air Fan</th>
                                <th width="10%">Speedy Preasure</th>
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
                                    <td>{{ explode('/', $pengendalian->fan_vacum)[0] }}</td>
                                    <td>{{ explode('/', $pengendalian->fan_vacum)[1] }}</td>
                                    <td>{{ $pengendalian->fan_temp }}</td>
                                    <td>{{ explode('/', $pengendalian->gas_preasure)[0] }}</td>
                                    <td>{{ explode('/', $pengendalian->gas_preasure)[1] }}</td>
                                    <td>{{ $pengendalian->h28 }}</td>
                                    <td>{{ $pengendalian->h27 }}</td>
                                    <td>{{ $pengendalian->h1 }}</td>
                                    <td>{{ $pengendalian->h2 }}</td>
                                    <td>{{ $pengendalian->h3 }}</td>
                                    <td>{{ $pengendalian->f4 }}</td>
                                    <td>{{ $pengendalian->h5 }}</td>
                                    <td>{{ $pengendalian->f6 }}</td>
                                    <td>{{ $pengendalian->f6_setting }}</td>
                                    <td>{{ $pengendalian->h7 }}</td>
                                    <td>{{ $pengendalian->f8 }}</td>
                                    <td>{{ $pengendalian->a9 }}</td>
                                    <td>{{ $pengendalian->a9_setting }}</td>
                                    <td>{{ $pengendalian->a10 }}</td>
                                    <td>{{ $pengendalian->a10_Setting }}</td>
                                    <td>{{ $pengendalian->a11 }}</td>
                                    <td>{{ $pengendalian->a11_setting }}</td>
                                    <td>{{ $pengendalian->a12 }}</td>
                                    <td>{{ $pengendalian->a12_setting }}</td>
                                    <td>{{ $pengendalian->a13 }}</td>
                                    <td>{{ $pengendalian->a13_setting }}</td>
                                    <td>{{ $pengendalian->a14 }}</td>
                                    <td>{{ $pengendalian->a14_setting }}</td>
                                    <td>{{ $pengendalian->a15 }}</td>
                                    <td>{{ $pengendalian->a15_setting }}</td>
                                    <td>{{ $pengendalian->a16 }}</td>
                                    <td>{{ $pengendalian->a16_setting }}</td>
                                    <td>{{ $pengendalian->a17 }}</td>
                                    <td>{{ $pengendalian->a17_setting }}</td>
                                    <td>{{ $pengendalian->a18 }}</td>
                                    <td>{{ $pengendalian->a18_setting }}</td>
                                    <td>{{ $pengendalian->a19 }}</td>
                                    <td>{{ $pengendalian->a19_setting }}</td>
                                    <td>{{ $pengendalian->a20 }}</td>
                                    <td>{{ $pengendalian->a20_setting }}</td>
                                    <td>{{ $pengendalian->a21 }}</td>
                                    <td>{{ $pengendalian->a21_setting }}</td>
                                    <td>{{ $pengendalian->a22 }}</td>
                                    <td>{{ $pengendalian->a22_setting }}</td>
                                    <td>{{ $pengendalian->a23 }}</td>
                                    <td>{{ $pengendalian->a24 }}</td>
                                    <td>{{ $pengendalian->f25 }}</td>
                                    <td>{{ $pengendalian->f26 }}</td>
                                    <td>{{ $pengendalian->f26_setting }}</td>
                                    <td>{{ $pengendalian->comb_preasure }}</td>
                                    <td>{{ $pengendalian->comb_temp }}</td>
                                    <td>{{ $pengendalian->zero_point }}</td>
                                    <td>{{ $pengendalian->hot_air_fan }}</td>
                                    <td>{{ $pengendalian->speedy_preasure }}</td>
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
