@extends('layouts.app')

@section('title', 'BP Rekap Hasil Powder List')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">BP Rekap Hasil Powder</h1>
        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All BP Rekap Hasil Powder</h6>

            </div>
            <div class="card-body">
                <form action="{{ route('bp.rekapPowder.filter') }}" method="GET">
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
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rekapPowders as $rekapPowder)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($rekapPowder->created_at)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
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
                                    <td style="display: flex">
                                        <a href="{{ route('bp.rekapPowder.edit', ['rekapPowder' => $rekapPowder->id]) }}"
                                            class="btn btn-primary m-2">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                        <a class="btn btn-danger m-2" href="#" data-toggle="modal" data-target="#deleteModal" onclick="event.preventDefault(); document.getElementById('user-delete-form').action = '{{ route('bp.rekapPowder.destroy', ['rekapPowder' => $rekapPowder->id]) }}'">
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
