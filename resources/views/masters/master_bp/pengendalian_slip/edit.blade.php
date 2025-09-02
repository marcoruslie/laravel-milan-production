@extends('layouts.app')

@section('title', 'Edit BP Pengendalian Slip')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit BP Pengendalian Slip</h1>
        <a href="{{route('bp.pengendalianSlip.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
    </div>

    {{-- Alert Messages --}}
    @include('common.alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit BP Pengendalian Slip</h6>
        </div>
        <form method="POST" action="{{route('bp.pengendalianSlip.update', ['pengendalianSlip' => $pengendalianSlip->id])}}">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="form-group row">

                    {{-- BM --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>BM</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('bm') is-invalid @enderror"
                            id="examplebm"
                            placeholder="BM"
                            name="bm"
                            value="{{ old('bm') ?  old('bm') : $pengendalianSlip->bm}}">

                        @error('bm')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Komposisi --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Komposisi</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('komposisi') is-invalid @enderror"
                            id="examplekomposisi"
                            placeholder="Komposisi"
                            name="komposisi"
                            value="{{ old('komposisi') ? old('komposisi') : $pengendalianSlip->komposisi }}">

                        @error('komposisi')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Liter Air --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Liter Air</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('air_liter') is-invalid @enderror"
                            id="exampleair_liter"
                            placeholder="Liter Air"
                            name="air_liter"
                            value="{{ old('air_liter') ? old('air_liter') : $pengendalianSlip->air_liter }}">

                        @error('air_liter')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Start --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Start</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('start') is-invalid @enderror"
                            id="examplestart"
                            placeholder="Start"
                            name="start"
                            value="{{ old('start') ? old('start') : $pengendalianSlip->start }}">

                        @error('start')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Finish --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Finish</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('finish') is-invalid @enderror"
                            id="examplefinish"
                            placeholder="Finish"
                            name="finish"
                            value="{{ old('finish') ?  old('finish') : $pengendalianSlip->finish}}">

                        @error('finish')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- STTP --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>STTP</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('sttp') is-invalid @enderror"
                            id="examplesttp"
                            placeholder="STTP"
                            name="sttp"
                            value="{{ old('sttp') ?  old('sttp') : $pengendalianSlip->sttp}}">

                        @error('sttp')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Water Glass --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Water Glass</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('water_glass') is-invalid @enderror"
                            id="examplewater_glass"
                            placeholder="Water Glass"
                            name="water_glass"
                            value="{{ old('water_glass') ?  old('water_glass') : $pengendalianSlip->water_glass}}">

                        @error('water_glass')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Air --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Air</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('air') is-invalid @enderror"
                            id="exampleair"
                            placeholder="Air"
                            name="air"
                            value="{{ old('air') ?  old('air') : $pengendalianSlip->air}}">

                        @error('air')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Jam Giling --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Jam Giling</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('jam_giling') is-invalid @enderror"
                            id="examplejam_giling"
                            placeholder="Jam Giling"
                            name="jam_giling"
                            value="{{ old('jam_giling') ?  old('jam_giling') : $pengendalianSlip->jam_giling}}">

                        @error('jam_giling')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Alumina --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Alumina</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('alumina') is-invalid @enderror"
                            id="examplealumina"
                            placeholder="Alumina"
                            name="alumina"
                            value="{{ old('alumina') ?  old('alumina') : $pengendalianSlip->alumina}}">

                        @error('alumina')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Setting Jam Giling --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Setting Jam Giling</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('setting_jam_giling') is-invalid @enderror"
                            id="examplesetting_jam_giling"
                            placeholder="Setting Jam Giling"
                            name="setting_jam_giling"
                            value="{{ old('setting_jam_giling') ?  old('setting_jam_giling') : $pengendalianSlip->setting_jam_giling}}">

                        @error('setting_jam_giling')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Total Jam Giling --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Total Jam Giling</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('total_jam_giling') is-invalid @enderror"
                            id="exampletotal_jam_giling"
                            placeholder="Total Jam Giling"
                            name="total_jam_giling"
                            value="{{ old('total_jam_giling') ?  old('total_jam_giling') : $pengendalianSlip->total_jam_giling}}">

                        @error('total_jam_giling')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Masuk Tanki No --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Masuk Tanki No</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('masuk_tanki_no') is-invalid @enderror"
                            id="examplemasuk_tanki_no"
                            placeholder="Masuk Tanki No"
                            name="masuk_tanki_no"
                            value="{{ old('masuk_tanki_no') ?  old('masuk_tanki_no') : $pengendalianSlip->masuk_tanki_no}}">

                        @error('masuk_tanki_no')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Status --}}
                    {{-- <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Status</label>
                        <select class="form-control form-control-user @error('status') is-invalid @enderror" name="status">
                            <option selected disabled>Select Status</option>
                            <option value="1" {{old('role_id') ? ((old('role_id') == 1) ? 'selected' : '') : (($user->status == 1) ? 'selected' : '')}}>Active</option>
                            <option value="0" {{old('role_id') ? ((old('role_id') == 0) ? 'selected' : '') : (($user->status == 0) ? 'selected' : '')}}>Inactive</option>
                        </select>
                        @error('status')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div> --}}

                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-success btn-user float-right mb-3">Update</button>
                <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('bp.pengendalianSlip.index') }}">Cancel</a>
            </div>
        </form>
    </div>

</div>


@endsection
