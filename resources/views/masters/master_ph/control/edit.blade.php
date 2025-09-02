@extends('layouts.app')

@section('title', 'Edit PH Counter')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit PH Control</h1>
        <a href="{{route('ph.control.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
    </div>

    {{-- Alert Messages --}}
    @include('common.alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit PH Control</h6>
        </div>
        <form method="POST" action="{{route('ph.control.update', ['control' => $control->id])}}">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="form-group row">

                    {{-- Tekanan Max --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Tekanan Max</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('tekanan_max') is-invalid @enderror"
                            id="exampletekanan_max"
                            placeholder="Tekanan Max"
                            name="tekanan_max"
                            value="{{ old('tekanan_max') ?  old('tekanan_max') : $control->tekanan_max}}">

                        @error('tekanan_max')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Tekanan Init --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Tekanan Init</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('tekanan_init') is-invalid @enderror"
                            id="exampletekanan_init"
                            placeholder="Tekanan Init"
                            name="tekanan_init"
                            value="{{ old('tekanan_init') ? old('tekanan_init') : $control->tekanan_init }}">

                        @error('tekanan_init')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Cycle PH --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Cycle PH</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('cycle_ph') is-invalid @enderror"
                            id="examplecycle_ph"
                            placeholder="Cycle PH"
                            name="cycle_ph"
                            value="{{ old('cycle_ph') ? old('cycle_ph') : $control->cycle_ph }}">

                        @error('cycle_ph')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Keutuhan Body --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Keutuhan Body</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('keutuhan_body') is-invalid @enderror"
                            id="examplekeutuhan_body"
                            placeholder="Keutuhan Body"
                            name="keutuhan_body"
                            value="{{ old('keutuhan_body') ? old('keutuhan_body') : $control->keutuhan_body }}">

                        @error('keutuhan_body')
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
                <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('ph.control.index') }}">Cancel</a>
            </div>
        </form>
    </div>

</div>


@endsection
