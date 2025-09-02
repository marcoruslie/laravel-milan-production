@extends('layouts.app')

@section('title', 'Edit RK Cek Gumpil')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit RK Cek Gumpil</h1>
        <a href="{{route('rk.cek.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
    </div>

    {{-- Alert Messages --}}
    @include('common.alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit RK Cek Gumpil</h6>
        </div>
        <form method="POST" action="{{route('rk.cek.update', ['cek' => $cek->id])}}">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="form-group row">

                    {{-- Motive --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Motive</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('motif') is-invalid @enderror"
                            id="examplemotif"
                            placeholder="Motive"
                            name="motif"
                            value="{{ old('motif') ?  old('motif') : $cek->motif}}">

                        @error('motif')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Size --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Size</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('size') is-invalid @enderror"
                            id="examplesize"
                            placeholder="Size"
                            name="size"
                            value="{{ old('size') ?  old('size') : $cek->size}}">

                        @error('size')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Sample --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Sample</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('sample') is-invalid @enderror"
                            id="examplesample"
                            placeholder="Sample"
                            name="sample"
                            value="{{ old('sample') ?  old('sample') : $cek->sample}}">

                        @error('sample')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Pcs Gumpil --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Pcs Gumpil</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('pcs_gumpil') is-invalid @enderror"
                            id="examplepcs_gumpil"
                            placeholder="Pcs Gumpil"
                            name="pcs_gumpil"
                            value="{{ old('pcs_gumpil') ?  old('pcs_gumpil') : $cek->pcs_gumpil}}">

                        @error('pcs_gumpil')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Persen Gumpil --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Persen Gumpil</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('persen_gumpil') is-invalid @enderror"
                            id="examplepersen_gumpil"
                            placeholder="Persen Gumpil"
                            name="persen_gumpil"
                            value="{{ old('persen_gumpil') ?  old('persen_gumpil') : $cek->persen_gumpil}}">

                        @error('persen_gumpil')
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
                <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('rk.cek.index') }}">Cancel</a>
            </div>
        </form>
    </div>

</div>


@endsection
