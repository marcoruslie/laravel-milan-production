@extends('layouts.app')

@section('title', 'Add Users')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add Itp</h1>
        <a href="{{route('users.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
    </div>

    {{-- Alert Messages --}}
    @include('common.alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add New Itp</h6>
        </div>
        <form method="POST" action="{{route('itps.store')}}">
            @csrf
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
                            value="{{ old('mesin') }}">

                        @error('mesin')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Form --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Form</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('form') is-invalid @enderror"
                            id="exampleForms"
                            placeholder="Form"
                            name="form"
                            value="{{ old('form') }}">

                        @error('form')
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
                            placeholder="Field"
                            name="field"
                            value="{{ old('field') }}">

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
                            value="{{ old('var1') }}">

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
                            value="{{ old('var2') }}">

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
                            value="{{ old('var3') }}">

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
                            value="{{ old('var4') }}">

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
                            value="{{ old('var5') }}">

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
                            id="exampleValfr"
                            placeholder="Valfr"
                            name="valfr"
                            value="{{ old('valfr') }}">

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
                            id="exampleValto"
                            placeholder="Valto"
                            name="valto"
                            value="{{ old('valto') }}">

                        @error('valto')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-success btn-user float-right mb-3">Save</button>
                <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('itps.index') }}">Cancel</a>
            </div>
        </form>
    </div>

</div>


@endsection
