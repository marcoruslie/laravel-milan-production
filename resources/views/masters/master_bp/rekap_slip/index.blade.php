@extends('layouts.app')

@section('title', 'BP Rekap Hasil Slip List')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">BP Rekap Hasil SLip</h1>
        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All BP Rekap Hasil SLip</h6>

            </div>
            <div class="card-body">
                <form action="{{ route('bp.rekapSlip.filter') }}" method="GET">
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
                                <th width="10%">Komposisi Body</th>
                                <th width="10%">Tab</th>
                                <th width="10%">A2</th>
                                <th width="10%">A3</th>
                                <th width="10%">A4</th>
                                <th width="10%">B1</th>
                                <th width="10%">B4</th>
                                <th width="10%">B5</th>
                                <th width="10%">Status</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rekapSlips as $rekapSlip)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($rekapSlip->created_at)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
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
                                    <td style="display: flex">

                                        <a href="{{ route('bp.rekapSlip.edit', ['rekapSlip' => $rekapSlip->id]) }}"
                                            class="btn btn-primary m-2">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                        <a class="btn btn-danger m-2" href="#" data-toggle="modal" data-target="#deleteModal" onclick="event.preventDefault(); document.getElementById('user-delete-form').action = '{{ route('bp.rekapSlip.destroy', ['rekapSlip' => $rekapSlip->id]) }}'">
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
