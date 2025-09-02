@extends('layouts.app')

@section('title', 'Edit PH Counter')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit PH Counter</h1>
        <a href="{{route('ph.control.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
    </div>

    {{-- Alert Messages --}}
    @include('common.alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit PH Counter</h6>
        </div>
        <form method="POST" action="{{route('ph.counter.update', ['counter' => $counter->id])}}">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="form-group row">

                    {{-- Diebox --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Diebox</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('db') is-invalid @enderror"
                            id="exampleDb"
                            placeholder="Diebox"
                            name="db"
                            value="{{ old('db') ?  old('db') : $counter->db}}">

                        @error('db')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Upper Mould 1 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Upper Mould 1</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('up_m1') is-invalid @enderror"
                            id="exampleup_m1"
                            placeholder="Upper Mould 1"
                            name="up_m1"
                            value="{{ old('up_m1') ? old('up_m1') : $counter->up_m1 }}">

                        @error('up_m1')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Upper Mould 2 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Upper Mould 2</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('up_m2') is-invalid @enderror"
                            id="exampleup_m2"
                            placeholder="Upper Mould 2"
                            name="up_m2"
                            value="{{ old('up_m2') ? old('up_m2') : $counter->up_m2 }}">

                        @error('up_m2')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Upper Mould 3 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Upper Mould 3</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('up_m3') is-invalid @enderror"
                            id="exampleup_m3"
                            placeholder="Upper Mould 3"
                            name="up_m3"
                            value="{{ old('up_m3') ? old('up_m3') : $counter->up_m3 }}">

                        @error('up_m3')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Upper Mould 4 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Upper Mould 4</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('up_m4') is-invalid @enderror"
                            id="exampleup_m4"
                            placeholder="Upper Mould 4"
                            name="up_m4"
                            value="{{ old('up_m4') ? old('up_m4') : $counter->up_m4 }}">

                        @error('up_m4')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Lower Mould 1 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Lower Mould 1</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('lw_m1') is-invalid @enderror"
                            id="examplelw_m1"
                            placeholder="Lower Mould 1"
                            name="lw_m1"
                            value="{{ old('lw_m1') ? old('lw_m1') : $counter->lw_m1 }}">

                        @error('lw_m1')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Lower Mould 2 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Lower Mould 2</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('lw_m2') is-invalid @enderror"
                            id="examplelw_m2"
                            placeholder="Lower Mould 2"
                            name="lw_m2"
                            value="{{ old('lw_m2') ? old('lw_m2') : $counter->lw_m2 }}">

                        @error('lw_m2')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Lower Mould 3 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Lower Mould 3</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('lw_m3') is-invalid @enderror"
                            id="examplelw_m3"
                            placeholder="Lower Mould 3"
                            name="lw_m3"
                            value="{{ old('lw_m3') ? old('lw_m3') : $counter->lw_m3 }}">

                        @error('lw_m3')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Lower Mould 4 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Lower Mould 4</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('lw_m4') is-invalid @enderror"
                            id="examplelw_m4"
                            placeholder="Lower Mould 4"
                            name="lw_m4"
                            value="{{ old('lw_m4') ? old('lw_m4') : $counter->lw_m4 }}">

                        @error('lw_m4')
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
                <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('ph.counter.index') }}">Cancel</a>
            </div>
        </form>
    </div>

</div>


@endsection
