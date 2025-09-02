@extends('layouts.app')

@section('title', 'SR Proccess Control List')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">SR Proccess Control</h1>
        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- Filter Form -->
        <form action="{{ route('sr.proccessControl.filter') }}" method="GET">
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
                <h6 class="m-0 font-weight-bold text-primary">Hasil Produksi</h6>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="10%">Shift</th>
                                <th width="10%">Order</th>
                                <th width="20%">User</th>
                                <th width="5%">From</th>
                                <th width="5%">No</th>
                                <th width="5%">Jumlah</th>
                                <th width="5%">hasilProduksi</th>
                                <th width="4%">a</th>
                                <th width="4%">s</th>
                                <th width="4%">m</th>
                                <th width="4%">l</th>
                                <th width="4%">ll</th>
                                <th width="4%">xm</th>
                                <th width="4%">xl</th>
                                <th width="4%">b</th>
                                <th width="4%">e</th>
                                <th width="4%">g</th>
                                <th width="4%">h</th>
                                <th width="4%">f</th>
                                <th width="4%">c</th>
                                <th width="4%">q</th>
                                <th width="4%">kw4</th>
                                <th width="5%">Jumlah Total</th>
                                <th width="5%">karton</th>
                                <th width="5%">Keterangan KW4</th>
                                <th width="5%">bs</th>
                                <th width="5%">afal</th>
                                <th width="10%">total</th>
                                <th width="10%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hasilProduksis as $hasilProduksi)
                                <tr>
                                    <td>{{ $hasilProduksi->shift_id }}</td>
                                    <td>{{ $hasilProduksi->order_id }}</td>
                                    <td>{{ $hasilProduksi->user->nama }}</td>
                                    <td>{{ $hasilProduksi->from }}</td>
                                    <td>{{ $hasilProduksi->no }}</td>
                                    <td>{{ $hasilProduksi->jumlah }}</td>
                                    <td>{{ $hasilProduksi->unloading }}</td>
                                    <td>{{ $hasilProduksi->a }}</td>
                                    <td>{{ $hasilProduksi->s }}</td>
                                    <td>{{ $hasilProduksi->m }}</td>
                                    <td>{{ $hasilProduksi->l }}</td>
                                    <td>{{ $hasilProduksi->ll }}</td>
                                    <td>{{ $hasilProduksi->xm }}</td>
                                    <td>{{ $hasilProduksi->xl }}</td>
                                    <td>{{ $hasilProduksi->b }}</td>
                                    <td>{{ $hasilProduksi->e }}</td>
                                    <td>{{ $hasilProduksi->g }}</td>
                                    <td>{{ $hasilProduksi->h }}</td>
                                    <td>{{ $hasilProduksi->f }}</td>
                                    <td>{{ $hasilProduksi->c }}</td>
                                    <td>{{ $hasilProduksi->q }}</td>
                                    <td>{{ $hasilProduksi->kw4 }}</td>
                                    <td>{{ $hasilProduksi->jumlah_total }}</td>
                                    <td>{{ $hasilProduksi->karton }}</td>
                                    <td>{{ $hasilProduksi->kw4ket }}</td>
                                    <td>{{ $hasilProduksi->bs }}</td>
                                    <td>{{ $hasilProduksi->afal }}</td>
                                    <td>{{ $hasilProduksi->total }}</td>
                                    <td>
                                        @if ($hasilProduksi->is_confirm == 0)
                                            <span class="badge badge-danger">Not Confirm</span>
                                        @elseif ($hasilProduksi->is_confirm == 1)
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
                <h6 class="m-0 font-weight-bold text-primary">Hasil Sortir</h6>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="10%">Shift</th>
                                <th width="10%">Order</th>
                                <th width="15%">User</th>
                                <th width="15%">Description</th>
                                <th width="10%">Pcs</th>
                                <th width="15%">Persen</th>
                                <th width="10%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hasilSortirs as $hasilSortir)
                                <tr>
                                    <td>{{ $hasilSortir->shift_id }}</td>
                                    <td>{{ $hasilSortir->order_id }}</td>
                                    <td>{{ $hasilSortir->user->nama }}</td>
                                    <td>{{ $hasilSortir->description }}</td>
                                    <td>{{ $hasilSortir->pcs }}</td>
                                    <td>{{ $hasilSortir->persen }}</td>
                                    <td>
                                        @if ($hasilSortir->is_confirm == 0)
                                            <span class="badge badge-danger">Not Confirm</span>
                                        @elseif ($hasilSortir->is_confirm == 1)
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
                <h6 class="m-0 font-weight-bold text-primary">Cek Mesin</h6>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="10%">Shift</th>
                                <th width="10%">Order</th>
                                <th width="15%">User</th>
                                <th width="15%">Mesin</th>
                                <th width="15%">Kondisi</th>
                                <th width="10%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cekMesins as $cekMesin)
                                <tr>
                                    <td>{{ $cekMesin->shift_id }}</td>
                                    <td>{{ $cekMesin->order_id }}</td>
                                    <td>{{ $cekMesin->user->nama }}</td>
                                    <td>{{ $cekMesin->mesin }}</td>
                                    <td>{{ $cekMesin->kondisi }}</td>
                                    <td>
                                        @if ($cekMesin->is_confirm == 0)
                                            <span class="badge badge-danger">Not Confirm</span>
                                        @elseif ($cekMesin->is_confirm == 1)
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
