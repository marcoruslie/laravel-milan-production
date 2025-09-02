@extends('layouts.app')

@section('title', 'Edit GL pengendalian')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit GL pengendalian</h1>
        <a href="{{route('gl.pengendalian.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
    </div>

    {{-- Alert Messages --}}
    @include('common.alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit GL pengendalian</h6>
        </div>
        <form method="POST" action="{{route('gl.pengendalian.update', ['pengendalian' => $pengendalian->id])}}">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="form-group row">

                    {{-- Jenis Aplikasi --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Jenis Aplikasi</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('jenis_aplikasi') is-invalid @enderror"
                            id="examplejenis_aplikasi"
                            placeholder="Jenis Aplikasi"
                            name="jenis_aplikasi"
                            value="{{ old('jenis_aplikasi') ?  old('jenis_aplikasi') : $pengendalian->jenis_aplikasi}}">

                        @error('jenis_aplikasi')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Engobe --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Engobe</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('engobe') is-invalid @enderror"
                            id="exampleengobe"
                            placeholder="Engobe"
                            name="engobe"
                            value="{{ old('engobe') ?  old('engobe') : $pengendalian->engobe}}">

                        @error('engobe')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Engobe Visco --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Engobe Visco</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('engobe_visco') is-invalid @enderror"
                            id="exampleengobe_visco"
                            placeholder="Engobe Visco"
                            name="engobe_visco"
                            value="{{ old('engobe_visco') ?  old('engobe_visco') : $pengendalian->engobe_visco}}">

                        @error('engobe_visco')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Engobe Densi --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Engobe Densi</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('engobe_densi') is-invalid @enderror"
                            id="exampleengobe_densi"
                            placeholder="Engobe Densi"
                            name="engobe_densi"
                            value="{{ old('engobe_densi') ?  old('engobe_densi') : $pengendalian->engobe_densi}}">

                        @error('engobe_densi')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Engobe Berat --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Engobe Berat</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('engobe_berat') is-invalid @enderror"
                            id="exampleengobe_berat"
                            placeholder="Engobe Berat"
                            name="engobe_berat"
                            value="{{ old('engobe_berat') ?  old('engobe_berat') : $pengendalian->engobe_berat}}">

                        @error('engobe_berat')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Glaze --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Glaze</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('glaze') is-invalid @enderror"
                            id="exampleglaze"
                            placeholder="Glaze"
                            name="glaze"
                            value="{{ old('glaze') ?  old('glaze') : $pengendalian->glaze}}">

                        @error('glaze')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Glaze Visco --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Glaze Visco</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('glaze_visco') is-invalid @enderror"
                            id="exampleglaze_visco"
                            placeholder="Glaze Visco"
                            name="glaze_visco"
                            value="{{ old('glaze_visco') ?  old('glaze_visco') : $pengendalian->glaze_visco}}">

                        @error('glaze_visco')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Glaze Densi --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Glaze Densi</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('glaze_densi') is-invalid @enderror"
                            id="exampleglaze_densi"
                            placeholder="Glaze Densi"
                            name="glaze_densi"
                            value="{{ old('glaze_densi') ?  old('glaze_densi') : $pengendalian->glaze_densi}}">

                        @error('glaze_densi')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Glaze Berat --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Glaze Berat</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('glaze_berat') is-invalid @enderror"
                            id="exampleglaze_berat"
                            placeholder="Glaze Berat"
                            name="glaze_berat"
                            value="{{ old('glaze_berat') ?  old('glaze_berat') : $pengendalian->glaze_berat}}">

                        @error('glaze_berat')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Pasta --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Pasta</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('pasta') is-invalid @enderror"
                            id="examplepasta"
                            placeholder="Pasta"
                            name="pasta"
                            value="{{ old('pasta') ?  old('pasta') : $pengendalian->pasta}}">

                        @error('pasta')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Pasta Visco --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Pasta Visco</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('pasta_visco') is-invalid @enderror"
                            id="examplepasta_visco"
                            placeholder="Pasta Visco"
                            name="pasta_visco"
                            value="{{ old('pasta_visco') ?  old('pasta_visco') : $pengendalian->pasta_visco}}">

                        @error('pasta_visco')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Pasta Densi --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Pasta Densi</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('pasta_densi') is-invalid @enderror"
                            id="examplepasta_densi"
                            placeholder="Pasta Densi"
                            name="pasta_densi"
                            value="{{ old('pasta_densi') ?  old('pasta_densi') : $pengendalian->pasta_densi}}">

                        @error('pasta_densi')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Temp Body --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Temp Body</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('temp_body') is-invalid @enderror"
                            id="exampletemp_body"
                            placeholder="Temp Body"
                            name="temp_body"
                            value="{{ old('temp_body') ?  old('temp_body') : $pengendalian->temp_body}}">

                        @error('temp_body')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Set Pemukul --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Set Pemukul</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('set_pemukul') is-invalid @enderror"
                            id="exampleset_pemukul"
                            placeholder="Set Pemukul"
                            name="set_pemukul"
                            value="{{ old('set_pemukul') ?  old('set_pemukul') : $pengendalian->set_pemukul}}">

                        @error('set_pemukul')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Sikat --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Sikat</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('sikat') is-invalid @enderror"
                            id="examplesikat"
                            placeholder="Sikat"
                            name="sikat"
                            value="{{ old('sikat') ?  old('sikat') : $pengendalian->sikat}}">

                        @error('sikat')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Saringan --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Saringan</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('saringan') is-invalid @enderror"
                            id="examplesaringan"
                            placeholder="Saringan"
                            name="saringan"
                            value="{{ old('saringan') ?  old('saringan') : $pengendalian->saringan}}">

                        @error('saringan')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-success btn-user float-right mb-3">Update</button>
                <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('gl.pengendalian.index') }}">Cancel</a>
            </div>
        </form>
    </div>

</div>


@endsection
