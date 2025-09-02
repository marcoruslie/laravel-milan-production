@extends('layouts.app')

@section('title', 'RK Pengendalian Proses List')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">RK Pengendalian Proses</h1>
        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All RK Pengendalian Proses</h6>

            </div>
            <div class="card-body">
                <form action="{{ route('rk.pengendalian.filter') }}" method="GET">
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
                                    <td>{{ \Carbon\Carbon::parse($pengendalian->created_at)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
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
                                    <td style="display: flex">

                                        <a href="{{ route('rk.pengendalian.edit', ['pengendalian' => $pengendalian->id]) }}"
                                            class="btn btn-primary m-2">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                        <a class="btn btn-danger m-2" href="#" data-togrke="modal" data-target="#deleteModal" onclick="event.preventDefault(); document.getElementById('user-delete-form').action = '{{ route('rk.pengendalian.destroy', ['pengendalian' => $pengendalian->id]) }}'">
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
