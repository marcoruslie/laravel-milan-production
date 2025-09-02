@extends('layouts.app')

@section('title', 'SR Hasil Sortir List')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">SR Hasil Sortir</h1>
            <div class="row">
            </div>
        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All SR Hasil Sortir</h6>

            </div>
            <div class="card-body">
                <form action="{{ route('sr.hasilSortir.filter') }}" method="GET">
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
                                <th width="15%">User</th>
                                <th width="15%">Description</th>
                                <th width="10%">Pcs</th>
                                <th width="15%">Persen</th>
                                <th width="10%">Status</th>
                                <th width="10%">Action</th>
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
                                    <td style="display: flex">

                                        <a href="{{ route('sr.hasilSortir.edit', ['hasilSortir' => $hasilSortir->id]) }}"
                                            class="btn btn-primary m-2">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                        <a class="btn btn-danger m-2" href="#" data-toggle="modal" data-target="#deleteModal" onclick="event.preventDefault(); document.getElementById('user-delete-form').action = '{{ route('sr.hasilSortir.destroy', ['hasilSortir' => $hasilSortir->id]) }}'">
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
