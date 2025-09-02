@extends('layouts.app')

@section('title', 'Edit GL analisa')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit GL analisa</h1>
        <a href="{{route('gl.analisa.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
    </div>

    {{-- Alert Messages --}}
    @include('common.alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit GL analisa</h6>
        </div>
        <form method="POST" action="{{route('gl.analisa.update', ['analisa' => $analisa->id])}}">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="form-group row">

                    {{-- Grup Motive --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Grup Motive</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('grup_motive') is-invalid @enderror"
                            id="examplegrup_motive"
                            placeholder="Grup Motive"
                            name="grup_motive"
                            value="{{ old('grup_motive') ?  old('grup_motive') : $analisa->grup_motive}}">

                        @error('grup_motive')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Jenis Cacat --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Jenis Cacat</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('jenis_cacat') is-invalid @enderror"
                            id="examplejenis_cacat"
                            placeholder="Jenis Cacat"
                            name="jenis_cacat"
                            value="{{ old('jenis_cacat') ? old('jenis_cacat') : $analisa->jenis_cacat }}">

                        @error('jenis_cacat')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- No Mould --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>No Mould</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('no_mould') is-invalid @enderror"
                            id="exampleno_mould"
                            placeholder="No Mould"
                            name="no_mould"
                            value="{{ old('no_mould') ? old('no_mould') : $analisa->no_mould }}">

                        @error('no_mould')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Jenis Perbaikan --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Jenis Perbaikan</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('jenis_perbaikan') is-invalid @enderror"
                            id="examplejenis_perbaikan"
                            placeholder="Jenis Perbaikan"
                            name="jenis_perbaikan"
                            value="{{ old('jenis_perbaikan') ? old('jenis_perbaikan') : $analisa->jenis_perbaikan }}">

                        @error('jenis_perbaikan')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Status</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('status') is-invalid @enderror"
                            id="examplestatus"
                            placeholder="Status"
                            name="status"
                            value="{{ old('status') ? old('status') : $analisa->status }}">

                        @error('status')
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
                <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('gl.analisa.index') }}">Cancel</a>
            </div>
        </form>
    </div>

</div>


@endsection
