@extends('layouts.app')

@section('title', 'Edit User')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Itp</h1>
        <a href="{{route('users.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
    </div>

    {{-- Alert Messages --}}
    @include('common.alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Car</h6>
        </div>
        <form method="POST" action="{{route('itps.update', ['itp' => $itp->id])}}">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="form-group row">
                    {{-- Mesin --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Mesin</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('mesin') is-invalid @enderror"
                            id="exampleMesin"
                            placeholder="Mesin"
                            name="mesin"
                            value="{{ old('mesin') ?  old('mesin') : $itp->mesin}}">

                        @error('Mesin')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Form --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Form</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('form') is-invalid @enderror"
                            id="exampleForm"
                            placeholder="Form"
                            name="form"
                            value="{{ old('form') ?  old('form') : $itp->form}}">

                        @error('Form')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Field --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Field</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('field') is-invalid @enderror"
                            id="exampleField"
                            placeholder="field"
                            name="field"
                            value="{{ old('field') ? old('field') : $itp->field }}">

                        @error('field')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Var 1 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Var 1</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('var1') is-invalid @enderror"
                            id="exampleVar1"
                            placeholder="Var 1"
                            name="var1"
                            value="{{ old('var1') ? old('var1') : $itp->var1 }}">

                        @error('var1')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Var 2 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Var 2</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('var2') is-invalid @enderror"
                            id="exampleVar2"
                            placeholder="Var 2"
                            name="var2"
                            value="{{ old('var2') ? old('var2') : $itp->var2 }}">

                        @error('var2')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Var 3 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Var 3</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('var3') is-invalid @enderror"
                            id="exampleVar3"
                            placeholder="Var 3"
                            name="var3"
                            value="{{ old('var3') ? old('var3') : $itp->var3 }}">

                        @error('var3')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Var 4 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Var 4</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('var4') is-invalid @enderror"
                            id="exampleVar4"
                            placeholder="Var 4"
                            name="var4"
                            value="{{ old('var4') ? old('var4') : $itp->var4 }}">

                        @error('var4')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Var 5 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Var 5</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('var5') is-invalid @enderror"
                            id="exampleVar5"
                            placeholder="Var 5"
                            name="var5"
                            value="{{ old('var5') ? old('var5') : $itp->var5 }}">

                        @error('var5')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Valfr --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Valfr</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('valfr') is-invalid @enderror"
                            id="examplevalfr"
                            placeholder="Valfr"
                            name="valfr"
                            value="{{ old('valfr') ? old('valfr') : $itp->valfr }}">

                        @error('valfr')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Valto --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Valto</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('valto') is-invalid @enderror"
                            id="examplevalto"
                            placeholder="Valto"
                            name="valto"
                            value="{{ old('valto') ? old('valto') : $itp->valto }}">

                        @error('valto')
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
                <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('itps.index') }}">Cancel</a>
            </div>
        </form>
    </div>

</div>


@endsection
