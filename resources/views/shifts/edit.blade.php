@extends('layouts.app')

@section('title', 'Edit Shift')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Shifts</h1>
        <a href="{{route('shifts.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
    </div>

    {{-- Alert Messages --}}
    @include('common.alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Shifts</h6>
        </div>
        <form method="POST" action="{{route('shifts.update', ['shift' => $shift->id])}}">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="form-group row">

                    {{-- Shift --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Shift</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('nama_shift') is-invalid @enderror"
                            id="examplenama_shift"
                            placeholder="Shift"
                            name="nama_shift"
                            value="{{ old('nama_shift') ?  old('nama_shift') : $shift->nama_shift}}">

                        @error('nama_shift')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Jam Mulai Shift --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Jam Mulai Shift</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('jam_mulai_shift') is-invalid @enderror"
                            id="examplejam_mulai_shift"
                            placeholder="Jam Mulai Shift"
                            name="jam_mulai_shift"
                            value="{{ old('jam_mulai_shift') ? old('jam_mulai_shift') : $shift->jam_mulai_shift }}">

                        @error('jam_mulai_shift')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Jam Akhir Shift --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Jam Akhir Shift</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('jam_akhir_shift') is-invalid @enderror"
                            id="exampleAssignTo"
                            placeholder="Jam Akhir Shift"
                            name="jam_akhir_shift"
                            value="{{ old('jam_akhir_shift') ? old('jam_akhir_shift') : $shift->jam_akhir_shift }}">

                        @error('jam_akhir_shift')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-success btn-user float-right mb-3">Update</button>
                <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('shifts.index') }}">Cancel</a>
            </div>
        </form>
    </div>

</div>


@endsection
