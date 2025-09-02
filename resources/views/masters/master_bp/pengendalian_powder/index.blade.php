@extends('layouts.app')

@section('title', 'BP Pengendalian Powder List')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">BP Pengendalian Powder</h1>
        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All BP Pengendalian Powder</h6>

            </div>
            <div class="card-body">
                <form action="{{ route('bp.pengendalianPowder.filter') }}" method="GET">
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
                                    <td>{{ \Carbon\Carbon::parse($pengendalianPowder->created_at)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
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
                                    <td style="display: flex">
                                        <a href="{{ route('bp.pengendalianPowder.detail', ['pengendalianPowder' => $pengendalianPowder->id]) }}"
                                            class="btn btn-primary m-2">
                                            <i class="fas fa-tasks"></i>
                                        </a>
                                        <a href="{{ route('bp.pengendalianPowder.edit', ['pengendalianPowder' => $pengendalianPowder->id]) }}"
                                            class="btn btn-primary m-2">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                        <a class="btn btn-danger m-2" href="#" data-toggle="modal" data-target="#deleteModal" onclick="event.preventDefault(); document.getElementById('user-delete-form').action = '{{ route('bp.pengendalianPowder.destroy', ['pengendalianPowder' => $pengendalianPowder->id]) }}'">
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
