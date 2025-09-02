@extends('layouts.app')

@section('title', 'SR Hasil Produksi List')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">SR Hasil Produksi</h1>
            <div class="row">
            </div>
        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All SR Hasil Produksi</h6>

            </div>
            <div class="card-body">
                <form action="{{ route('sr.hasilProduksi.filter') }}" method="GET">
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
                                <th width="15%">Action</th>
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
                                    <td style="display: flex">

                                        <a href="{{ route('sr.hasilProduksi.edit', ['hasilProduksi' => $hasilProduksi->id]) }}"
                                            class="btn btn-primary m-2">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                        <a class="btn btn-danger m-2" href="#" data-toggle="modal" data-target="#deleteModal" onclick="event.preventDefault(); document.getElementById('user-delete-form').action = '{{ route('sr.hasilProduksi.destroy', ['hasilProduksi' => $hasilProduksi->id]) }}'">
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
