@extends('layouts.app')

@section('title', 'Add Users')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add Cars</h1>
        <a href="{{route('users.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
    </div>

    {{-- Alert Messages --}}
    @include('common.alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add New Cars</h6>
        </div>
        <form method="POST" action="{{route('cars.store')}}">
            @csrf
            <div class="card-body">
                <div class="form-group row">

                    {{-- No Cars --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>No Cars</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('nocar') is-invalid @enderror"
                            id="exampleNocars"
                            placeholder="No Cars"
                            name="nocar"
                            value="{{ old('nocar') }}">

                        @error('nocar')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Status</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('status') is-invalid @enderror"
                            id="exampleStatus"
                            placeholder="Status"
                            name="status"
                            value="{{ old('status') }}">

                        @error('status')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Assign To --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Assign To</label>
                        <input
                            type="assign_to"
                            class="form-control form-control-user @error('assign_to') is-invalid @enderror"
                            id="exampleAssignTo"
                            placeholder="Assign To"
                            name="assign_to"
                            value="{{ old('assign_to') }}">

                        @error('assign_to')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-success btn-user float-right mb-3">Save</button>
                <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('cars.index') }}">Cancel</a>
            </div>
        </form>
    </div>

</div>


@endsection
