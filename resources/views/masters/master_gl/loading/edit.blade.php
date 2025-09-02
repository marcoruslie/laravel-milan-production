@extends('layouts.app')

@section('title', 'Edit GL loading')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit GL loading</h1>
        <a href="{{route('gl.loading.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
    </div>

    {{-- Alert Messages --}}
    @include('common.alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit GL loading</h6>
        </div>
        <form method="POST" action="{{route('gl.loading.update', ['loading' => $loading->id])}}">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="form-group row">

                    {{-- From --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>From</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('from') is-invalid @enderror"
                            id="examplefrom"
                            placeholder="From"
                            name="from"
                            value="{{ old('from') ?  old('from') : $loading->from}}">

                        @error('from')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- No --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>No</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('no') is-invalid @enderror"
                            id="exampleno"
                            placeholder="No"
                            name="no"
                            value="{{ old('no') ? old('no') : $loading->no }}">

                        @error('no')
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
                            value="{{ old('start') ? old('start') : $loading->start }}">

                        @error('start')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Stop --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Stop</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('stop') is-invalid @enderror"
                            id="examplestop"
                            placeholder="Stop"
                            name="stop"
                            value="{{ old('stop') ? old('stop') : $loading->stop }}">

                        @error('stop')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Menit --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Menit</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('menit') is-invalid @enderror"
                            id="examplemenit"
                            placeholder="Menit"
                            name="menit"
                            value="{{ old('menit') ? old('menit') : $loading->menit }}">

                        @error('menit')
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
                            value="{{ old('jumlah') ? old('jumlah') : $loading->jumlah }}">

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
                <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('gl.loading.index') }}">Cancel</a>
            </div>
        </form>
    </div>

</div>


@endsection
