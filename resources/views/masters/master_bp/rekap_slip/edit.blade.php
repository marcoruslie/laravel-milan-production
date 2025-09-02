@extends('layouts.app')

@section('title', 'Edit BP Rekap Slip')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit BP Rekap Slip</h1>
        <a href="{{route('bp.rekapSlip.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
    </div>

    {{-- Alert Messages --}}
    @include('common.alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit BP Rekap Slip</h6>
        </div>
        <form method="POST" action="{{route('bp.rekapSlip.update', ['rekapSlip' => $rekapSlip->id])}}">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="form-group row">

                    {{-- Komposisi Body --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Komposisi Body</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('komposisi_body') is-invalid @enderror"
                            id="examplekomposisi_body"
                            placeholder="Komposisi Body"
                            name="komposisi_body"
                            value="{{ old('komposisi_body') ? old('komposisi_body') : $rekapSlip->komposisi_body }}">

                        @error('komposisi_body')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Tab --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Tab</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('tab') is-invalid @enderror"
                            id="exampletab"
                            placeholder="Tab"
                            name="tab"
                            value="{{ old('tab') ? old('tab') : $rekapSlip->tab }}">

                        @error('tab')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- A2 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>A2</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('a2') is-invalid @enderror"
                            id="examplea2"
                            placeholder="A2"
                            name="a2"
                            value="{{ old('a2') ? old('a2') : $rekapSlip->a2 }}">

                        @error('a2')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- A3 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>A3</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('a3') is-invalid @enderror"
                            id="examplea3"
                            placeholder="A3"
                            name="a3"
                            value="{{ old('a3') ? old('a3') : $rekapSlip->a3 }}">

                        @error('a3')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- A4 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>A4</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('a4') is-invalid @enderror"
                            id="examplea4"
                            placeholder="A4"
                            name="a4"
                            value="{{ old('a4') ? old('a4') : $rekapSlip->a4 }}">

                        @error('a4')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- B1 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>B1</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('b1') is-invalid @enderror"
                            id="exampleb1"
                            placeholder="B1"
                            name="b1"
                            value="{{ old('b1') ? old('b1') : $rekapSlip->b1 }}">

                        @error('b1')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- B4 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>B4</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('b4') is-invalid @enderror"
                            id="exampleb4"
                            placeholder="B4"
                            name="b4"
                            value="{{ old('b4') ? old('b4') : $rekapSlip->b4 }}">

                        @error('b4')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- B5 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>B5</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('b5') is-invalid @enderror"
                            id="exampleb5"
                            placeholder="B5"
                            name="b5"
                            value="{{ old('b5') ? old('b5') : $rekapSlip->b5 }}">

                        @error('b5')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-success btn-user float-right mb-3">Update</button>
                <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('bp.rekapSlip.index') }}">Cancel</a>
            </div>
        </form>
    </div>

</div>


@endsection
