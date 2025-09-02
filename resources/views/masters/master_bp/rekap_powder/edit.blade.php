@extends('layouts.app')

@section('title', 'Edit BP Rekap Hasil Powder')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit BP Rekap Hasil Powder</h1>
        <a href="{{route('bp.rekapPowder.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
    </div>

    {{-- Alert Messages --}}
    @include('common.alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit BP Rekap Hasil Powder</h6>
        </div>
        <form method="POST" action="{{route('bp.rekapPowder.update', ['rekapPowder' => $rekapPowder->id])}}">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="form-group row">

                    {{-- Stok 1 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Stok 1</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('stok1') is-invalid @enderror"
                            id="examplestok1"
                            placeholder="Stok 1"
                            name="stok1"
                            value="{{ old('stok1') ?  old('stok1') : $rekapPowder->stok1}}">

                        @error('stok1')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Stok 2 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Stok 2</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('stok2') is-invalid @enderror"
                            id="examplestok2"
                            placeholder="Stok 2"
                            name="stok2"
                            value="{{ old('stok2') ?  old('stok2') : $rekapPowder->stok2}}">

                        @error('stok2')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Stok 3 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Stok 3</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('stok3') is-invalid @enderror"
                            id="examplestok3"
                            placeholder="Stok 3"
                            name="stok3"
                            value="{{ old('stok3') ?  old('stok3') : $rekapPowder->stok3}}">

                        @error('stok3')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Stok 4 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Stok 4</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('stok4') is-invalid @enderror"
                            id="examplestok4"
                            placeholder="Stok 4"
                            name="stok4"
                            value="{{ old('stok4') ?  old('stok4') : $rekapPowder->stok4}}">

                        @error('stok4')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Stok 5 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Stok 5</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('stok5') is-invalid @enderror"
                            id="examplestok5"
                            placeholder="Stok 5"
                            name="stok5"
                            value="{{ old('stok5') ?  old('stok5') : $rekapPowder->stok5}}">

                        @error('stok5')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Total Powder --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Total Powder</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('total_powder') is-invalid @enderror"
                            id="exampletotal_powder"
                            placeholder="Total Powder"
                            name="total_powder"
                            value="{{ old('total_powder') ? old('total_powder') : $rekapPowder->total_powder }}">

                        @error('total_powder')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- ATM 40 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>ATM 40</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('atm40') is-invalid @enderror"
                            id="exampleatm40"
                            placeholder="ATM 40"
                            name="atm40"
                            value="{{ old('atm40') ? old('atm40') : $rekapPowder->atm40 }}">

                        @error('atm40')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Kapasitas ATM 40 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Kapasitas ATM 40</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('kapasitas40') is-invalid @enderror"
                            id="examplekapasitas40"
                            placeholder="Kapasitas ATM 40"
                            name="kapasitas40"
                            value="{{ old('kapasitas40') ? old('kapasitas40') : $rekapPowder->kapasitas40 }}">

                        @error('kapasitas40')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- ATM 90 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>ATM 90</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('atm90') is-invalid @enderror"
                            id="exampleatm90"
                            placeholder="ATM 90"
                            name="atm90"
                            value="{{ old('atm90') ? old('atm90') : $rekapPowder->atm90 }}">

                        @error('atm90')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Kapasitas ATM 90 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Kapasitas ATM 90</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('kapasitas90') is-invalid @enderror"
                            id="examplekapasitas90"
                            placeholder="Kapasitas ATM 90"
                            name="kapasitas90"
                            value="{{ old('kapasitas90') ? old('kapasitas90') : $rekapPowder->kapasitas90 }}">

                        @error('kapasitas90')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-success btn-user float-right mb-3">Update</button>
                <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('bp.rekapPowder.index') }}">Cancel</a>
            </div>
        </form>
    </div>

</div>


@endsection
