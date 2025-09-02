@extends('layouts.app')

@section('title', 'PH Proccess Control List')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">PH Proccess Control</h1>
        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- Filter Form -->
        <form action="{{ route('ph.proccessControl.filter') }}" method="GET">
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
                <h6 class="m-0 font-weight-bold text-primary">Control</h6>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="10%">Tanggal</th>
                                <th width="5%">Shift</th>
                                <th width="10%">Order</th>
                                <th width="10%">Mesin ID</th>
                                <th width="15%">User</th>
                                <th width="10%">Tekanan Max</th>
                                <th width="10%">Tekanan Init</th>
                                <th width="10%">Cycle PH</th>
                                <th width="10%">Keutuhan Body</th>
                                <th width="10%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($controls as $control)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($control->created_at)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                                    <td>{{ $control->shift_id }}</td>
                                    <td>{{ $control->order_id }}</td>
                                    <td>{{ $control->mesin_id }}</td>
                                    <td>{{ $control->user->nama }}</td>
                                    <td>{{ $control->tekanan_max }}</td>
                                    <td>{{ $control->tekanan_init }}</td>
                                    <td>{{ $control->cycle_ph }}</td>
                                    <td>{{ $control->keutuhan_body }}</td>
                                    <td>
                                        @if ($control->is_confirm == 0)
                                            <span class="badge badge-danger">Not Confirm</span>
                                        @elseif ($control->is_confirm == 1)
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
                <h6 class="m-0 font-weight-bold text-primary">Dimensi</h6>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="10%">Tanggal</th>
                                <th width="5%">Shift</th>
                                <th width="10%">Order</th>
                                <th width="15%">User</th>
                                <th width="15%">Populasi</th>
                                <th width="10%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dimensis as $dimensi)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($dimensi->created_at)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                                    <td>{{ $dimensi->shift_id }}</td>
                                    <td>{{ $dimensi->order_id }}</td>
                                    <td>{{ $dimensi->user->nama }}</td>
                                    <td>{{ $dimensi->populasi }}</td>
                                    <td>
                                        @if ($dimensi->is_confirm == 0)
                                            <span class="badge badge-danger">Not Confirm</span>
                                        @elseif ($dimensi->is_confirm == 1)
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
                <h6 class="m-0 font-weight-bold text-primary">Counter</h6>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="10%">Tanggal</th>
                                <th width="5%">Shift</th>
                                <th width="10%">Order</th>
                                <th width="15%">User</th>
                                <th width="15%">Diebox</th>
                                <th width="5%">Upper M1</th>
                                <th width="5%">Upper M2</th>
                                <th width="5%">Upper M3</th>
                                <th width="5%">Upper M4</th>
                                <th width="5%">Lower M1</th>
                                <th width="5%">Lower M2</th>
                                <th width="5%">Lower M3</th>
                                <th width="5%">Lower M4</th>
                                <th width="10%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($counters as $counter)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($counter->created_at)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                                    <td>{{ $counter->shift_id }}</td>
                                    <td>{{ $counter->order_id }}</td>
                                    <td>{{ $counter->user->nama }}</td>
                                    <td>{{ $counter->db }}</td>
                                    <td>{{ $counter->up_m1 }}</td>
                                    <td>{{ $counter->up_m2 }}</td>
                                    <td>{{ $counter->up_m3 }}</td>
                                    <td>{{ $counter->up_m4 }}</td>
                                    <td>{{ $counter->lw_m1 }}</td>
                                    <td>{{ $counter->lw_m2 }}</td>
                                    <td>{{ $counter->lw_m3 }}</td>
                                    <td>{{ $counter->lw_m4 }}</td>
                                    <td>
                                        @if ($counter->is_confirm == 0)
                                            <span class="badge badge-danger">Not Confirm</span>
                                        @elseif ($counter->is_confirm == 1)
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
                <h6 class="m-0 font-weight-bold text-primary">Suhu</h6>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="10%">Tanggal</th>
                                <th width="5%">Shift</th>
                                <th width="10%">Order</th>
                                <th width="15%">User</th>
                                <th width="10%">Diebox Setting</th>
                                <th width="10%">Diebox Actual</th>
                                <th width="10%">Upper Setting</th>
                                <th width="10%">Upper Setting</th>
                                <th width="10%">Lower Actual</th>
                                <th width="10%">Lower Actual</th>
                                <th width="10%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($temps as $temp)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($temp->created_at)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                                    <td>{{ $temp->shift_id }}</td>
                                    <td>{{ $temp->order_id }}</td>
                                    <td>{{ $temp->user->nama }}</td>
                                    <td>{{ $temp->DB_setting }}</td>
                                    <td>{{ $temp->DB_actual }}</td>
                                    <td>{{ $temp->UP_setting }}</td>
                                    <td>{{ $temp->UP_actual }}</td>
                                    <td>{{ $temp->LW_setting }}</td>
                                    <td>{{ $temp->LW_actual }}</td>
                                    <td>
                                        @if ($temp->is_confirm == 0)
                                            <span class="badge badge-danger">Not Confirm</span>
                                        @elseif ($temp->is_confirm == 1)
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
                <h6 class="m-0 font-weight-bold text-primary">Tebal</h6>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="10%">Tanggal</th>
                                <th width="5%">Shift</th>
                                <th width="10%">Order</th>
                                <th width="15%">User</th>
                                <th width="15%">Selisih</th>
                                <th width="10%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tebals as $tebal)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($tebal->created_at)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                                    <td>{{ $tebal->shift_id }}</td>
                                    <td>{{ $tebal->order_id }}</td>
                                    <td>{{ $tebal->user->nama }}</td>
                                    <td>{{ $tebal->populasi }}</td>
                                    <td>
                                        @if ($tebal->is_confirm == 0)
                                            <span class="badge badge-danger">Not Confirm</span>
                                        @elseif ($tebal->is_confirm == 1)
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
                <h6 class="m-0 font-weight-bold text-primary">Dryer</h6>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="10%">Tanggal</th>
                                <th width="5%">Shift</th>
                                <th width="10%">Order</th>
                                <th>Mesin ID</th>
                                <th width="15%">User</th>
                                <th width="6%">Dryers</th>
                                <th width="5%">S11/BT11</th>
                                <th width="5%">S12/BT12</th>
                                <th width="5%">BT13</th>
                                <th width="5%">KA%</th>
                                <th width="5%">Counter VD</th>
                                <th width="5%">Temp Aplikasi</th>
                                <th width="6%">Kondisi ET</th>
                                <th width="6%">Floating Grid</th>
                                <th width="6%">Sikat & Roll</th>
                                <th width="6%">Below</th>
                                <th width="10%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dryers as $dryer)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($dryer->created_at)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                                    <td>{{ $dryer->shift_id }}</td>
                                    <td>{{ $dryer->order_id }}</td>
                                    <td>{{ $dryer->mesin_id }}</td>
                                    <td>{{ $dryer->user->nama }}</td>
                                    <td>{{ $dryer->dryers }}</td>
                                    <td>{{ $dryer->param1 }}</td>
                                    <td>{{ $dryer->param2 }}</td>
                                    <td>{{ $dryer->param3 }}</td>
                                    <td>{{ $dryer->param4 }}</td>
                                    <td>{{ $dryer->counterVd }}</td>
                                    <td>{{ $dryer->tempAplikasi }}</td>
                                    <td>{{ $dryer->kondisi_et }}</td>
                                    <td>{{ $dryer->floating_grid }}</td>
                                    <td>{{ $dryer->sikat_rol }}</td>
                                    <td>{{ $dryer->below }}</td>
                                    <td>
                                        @if ($dryer->is_confirm == 0)
                                            <span class="badge badge-danger">Not Confirm</span>
                                        @elseif ($dryer->is_confirm == 1)
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
