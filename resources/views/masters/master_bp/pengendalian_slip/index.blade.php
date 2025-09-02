@extends('layouts.app')

@section('title', 'BP Pengendalian Slip List')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">BP Pengendalian SLip</h1>
        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All BP Pengendalian SLip</h6>

            </div>
            <div class="card-body">
                <form action="{{ route('bp.pengendalianSlip.filter') }}" method="GET">
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
                                <th width="10%">Action</th>
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
                                    <td style="display: flex">

                                        <a href="{{ route('bp.pengendalianSlip.edit', ['pengendalianSlip' => $pengendalianSlip->id]) }}"
                                            class="btn btn-primary m-2">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                        <a class="btn btn-danger m-2" href="#" data-toggle="modal" data-target="#deleteModal" onclick="event.preventDefault(); document.getElementById('user-delete-form').action = '{{ route('bp.pengendalianSlip.destroy', ['pengendalianSlip' => $pengendalianSlip->id]) }}'">
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
