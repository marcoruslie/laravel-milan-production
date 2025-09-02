@extends('layouts.app')

@section('title', 'Edit PH Temp')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit PH Temp</h1>
        <a href="{{route('ph.temps.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
    </div>

    {{-- Alert Messages --}}
    @include('common.alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit PH Temp</h6>
        </div>
        <form method="POST" action="{{route('ph.temps.update', ['temp' => $temp->id])}}">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="form-group row">

                    {{-- Diebox Setting --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Diebox Setting</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('DB_setting') is-invalid @enderror"
                            id="exampleDB_setting"
                            placeholder="Diebox Setting"
                            name="DB_setting"
                            value="{{ old('DB_setting') ?  old('DB_setting') : $temp->DB_setting}}">

                        @error('DB_setting')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Diebox Actual --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Diebox Actual</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('DB_actual') is-invalid @enderror"
                            id="exampleDB_actual"
                            placeholder="Diebox Actual"
                            name="DB_actual"
                            value="{{ old('DB_actual') ? old('DB_actual') : $temp->DB_actual }}">

                        @error('DB_actual')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Upper Setting --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Upper Setting</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('UP_setting') is-invalid @enderror"
                            id="exampleUP_setting"
                            placeholder="Upper Setting"
                            name="UP_setting"
                            value="{{ old('UP_setting') ? old('UP_setting') : $temp->UP_setting }}">

                        @error('UP_setting')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Upper Actual --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Upper Actual</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('UP_actual') is-invalid @enderror"
                            id="exampleUP_actual"
                            placeholder="Upper Actual"
                            name="UP_actual"
                            value="{{ old('UP_actual') ? old('UP_actual') : $temp->UP_actual }}">

                        @error('UP_actual')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Lower Setting --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Lower Setting</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('LW_setting') is-invalid @enderror"
                            id="exampleLW_setting"
                            placeholder="Lower Setting"
                            name="LW_setting"
                            value="{{ old('LW_setting') ? old('LW_setting') : $temp->LW_setting }}">

                        @error('LW_setting')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Lower Actual --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Lower Actual</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('LW_actual') is-invalid @enderror"
                            id="exampleLW_actual"
                            placeholder="Lower Actual"
                            name="LW_actual"
                            value="{{ old('LW_actual') ? old('LW_actual') : $temp->LW_actual }}">

                        @error('LW_actual')
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
                <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('ph.temps.index') }}">Cancel</a>
            </div>
        </form>
    </div>

</div>


@endsection
