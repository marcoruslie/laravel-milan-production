@extends('layouts.app')

@section('title', 'Edit PH Dryer')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit PH Dryer</h1>
        <a href="{{route('ph.dryer.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
    </div>

    {{-- Alert Messages --}}
    @include('common.alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit PH Dryer</h6>
        </div>
        <form method="POST" action="{{route('ph.dryer.update', ['dryer' => $dryer->id])}}">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="form-group row">

                    {{-- Dryers --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Dryers</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('dryers') is-invalid @enderror"
                            id="exampledryers"
                            placeholder="Dryers"
                            name="dryers"
                            value="{{ old('dryers') ?  old('dryers') : $dryer->dryers}}">

                        @error('dryers')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- S11/BT11 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>S11/BT11</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('param1') is-invalid @enderror"
                            id="exampleparam1"
                            placeholder="S11/BT11"
                            name="param1"
                            value="{{ old('param1') ? old('param1') : $dryer->param1 }}">

                        @error('param1')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- S12/BT12 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>S12/BT12</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('param2') is-invalid @enderror"
                            id="exampleparam2"
                            placeholder="S12/BT12"
                            name="param2"
                            value="{{ old('param2') ? old('param2') : $dryer->param2 }}">

                        @error('param2')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- BT13 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>BT13</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('param3') is-invalid @enderror"
                            id="exampleparam3"
                            placeholder="BT13"
                            name="param3"
                            value="{{ old('param3') ? old('param3') : $dryer->param3 }}">

                        @error('param3')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- KA% --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>KA%</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('param4') is-invalid @enderror"
                            id="exampleparam4"
                            placeholder="KA%"
                            name="param4"
                            value="{{ old('param4') ? old('param4') : $dryer->param4 }}">

                        @error('param4')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Counter VD --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Counter VD</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('counterVd') is-invalid @enderror"
                            id="examplecounterVd"
                            placeholder="Counter VD"
                            name="counterVd"
                            value="{{ old('counterVd') ? old('counterVd') : $dryer->counterVd }}">

                        @error('counterVd')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Temp Aplikasi --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Temp Aplikasi</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('tempAplikasi') is-invalid @enderror"
                            id="exampletempAplikasi"
                            placeholder="Temp Aplikasi"
                            name="tempAplikasi"
                            value="{{ old('tempAplikasi') ? old('tempAplikasi') : $dryer->tempAplikasi }}">

                        @error('tempAplikasi')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Kondisi ET --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Kondisi ET</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('kondisi_et') is-invalid @enderror"
                            id="examplekondisi_et"
                            placeholder="Kondisi ET"
                            name="kondisi_et"
                            value="{{ old('kondisi_et') ? old('kondisi_et') : $dryer->kondisi_et }}">

                        @error('kondisi_et')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Floating Grid --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Floating Grid</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('floating_grid') is-invalid @enderror"
                            id="examplefloating_grid"
                            placeholder="Floating Grid"
                            name="floating_grid"
                            value="{{ old('floating_grid') ? old('floating_grid') : $dryer->floating_grid }}">

                        @error('floating_grid')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Sikat & Rol --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Sikat & Rol</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('sikat_rol') is-invalid @enderror"
                            id="examplesikat_rol"
                            placeholder="Sikat & Rol"
                            name="sikat_rol"
                            value="{{ old('sikat_rol') ? old('sikat_rol') : $dryer->sikat_rol }}">

                        @error('sikat_rol')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Below --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Below</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('below') is-invalid @enderror"
                            id="examplebelow"
                            placeholder="Below"
                            name="below"
                            value="{{ old('below') ? old('below') : $dryer->below }}">

                        @error('below')
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
