@extends('layouts.app')

@section('title', 'Edit BP Pengendalian Powder')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit BP Pengendalian Powder</h1>
        <a href="{{route('bp.pengendalianPowder.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
    </div>

    {{-- Alert Messages --}}
    @include('common.alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit BP Pengendalian Powder</h6>
        </div>
        <form method="POST" action="{{route('bp.pengendalianPowder.update', ['pengendalianPowder' => $pengendalianPowder->id])}}">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="form-group row">

                    {{-- Start Spray --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Start Spray</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('start_spray') is-invalid @enderror"
                            id="examplestart_spray"
                            placeholder="Start Spray"
                            name="start_spray"
                            value="{{ old('start_spray') ?  old('start_spray') : $pengendalianPowder->start_spray}}">

                        @error('start_spray')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Powder Masuk --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Powder Masuk</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('powder_masuk') is-invalid @enderror"
                            id="examplepowder_masuk"
                            placeholder="Powder Masuk"
                            name="powder_masuk"
                            value="{{ old('powder_masuk') ? old('powder_masuk') : $pengendalianPowder->powder_masuk }}">

                        @error('powder_masuk')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Stop Spray --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Stop Spray</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('stop_spray') is-invalid @enderror"
                            id="examplestop_spray"
                            placeholder="Stop Spray"
                            name="stop_spray"
                            value="{{ old('stop_spray') ? old('stop_spray') : $pengendalianPowder->stop_spray }}">

                        @error('stop_spray')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Dari Tanki --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Dari Tanki</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('dari_tanki') is-invalid @enderror"
                            id="exampledari_tanki"
                            placeholder="Dari Tanki"
                            name="dari_tanki"
                            value="{{ old('dari_tanki') ? old('dari_tanki') : $pengendalianPowder->dari_tanki }}">

                        @error('dari_tanki')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                     {{-- Ke Tanki --}}
                     <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Ke Tanki</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('ke_tanki') is-invalid @enderror"
                            id="exampleke_tanki"
                            placeholder="Ke Tanki"
                            name="ke_tanki"
                            value="{{ old('ke_tanki') ?  old('ke_tanki') : $pengendalianPowder->ke_tanki}}">

                        @error('ke_tanki')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                     {{-- Reologi --}}
                     <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Reologi</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('reologi') is-invalid @enderror"
                            id="examplereologi"
                            placeholder="Reologi"
                            name="reologi"
                            value="{{ old('reologi') ?  old('reologi') : $pengendalianPowder->reologi}}">

                        @error('reologi')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                     {{-- Kapasitas --}}
                     <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Kapasitas</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('kapasitas') is-invalid @enderror"
                            id="examplekapasitas"
                            placeholder="Kapasitas"
                            name="kapasitas"
                            value="{{ old('kapasitas') ?  old('kapasitas') : $pengendalianPowder->kapasitas}}">

                        @error('kapasitas')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                     {{-- Granulasi --}}
                     <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Granulasi</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('granulasi') is-invalid @enderror"
                            id="examplegranulasi"
                            placeholder="Granulasi"
                            name="granulasi"
                            value="{{ old('granulasi') ?  old('granulasi') : $pengendalianPowder->granulasi}}">

                        @error('granulasi')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                     {{-- Indicator --}}
                     <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Indicator</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('indicator') is-invalid @enderror"
                            id="exampleindicator"
                            placeholder="Indicator"
                            name="indicator"
                            value="{{ old('indicator') ?  old('indicator') : $pengendalianPowder->indicator}}">

                        @error('indicator')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                     {{-- Nozle 1 --}}
                     <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Nozle 1</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('nozle_1') is-invalid @enderror"
                            id="examplenozle_1"
                            placeholder="Nozle 1"
                            name="nozle_1"
                            value="{{ old('nozle_1') ?  old('nozle_1') : $pengendalianPowder->nozle_1}}">

                        @error('nozle_1')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                     {{-- Nozle 2 --}}
                     <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Nozle 2</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('nozle_2') is-invalid @enderror"
                            id="examplenozle_2"
                            placeholder="Nozle 2"
                            name="nozle_2"
                            value="{{ old('nozle_2') ?  old('nozle_2') : $pengendalianPowder->nozle_2}}">

                        @error('nozle_2')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                     {{-- Jumlah --}}
                     <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Jumlah</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('jumlah') is-invalid @enderror"
                            id="examplejumlah"
                            placeholder="Jumlah"
                            name="jumlah"
                            value="{{ old('jumlah') ?  old('jumlah') : $pengendalianPowder->jumlah}}">

                        @error('jumlah')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Role --}}
                    {{-- <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Role</label>
                        <select class="form-control form-control-user @error('role_id') is-invalid @enderror" name="role_id">
                            <option selected disabled>Select Role</option>
                            @foreach ($roles as $role)
                                <option value="{{$role->id}}"
                                    {{old('role_id') ? ((old('role_id') == $role->id) ? 'selected' : '') : (($user->role_id == $role->id) ? 'selected' : '')}}>
                                    {{$role->name}}
                                </option>
                            @endforeach
                        </select>
                        @error('role_id')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div> --}}

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
                <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('bp.pengendalianPowder.index') }}">Cancel</a>
            </div>
        </form>
    </div>

</div>


@endsection
