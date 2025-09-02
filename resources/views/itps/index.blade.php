@extends('layouts.app')

@section('title', 'ITP List')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Standard ITP</h1>
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ route('itps.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Add New
                    </a>
                </div>
            </div>
        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All ITPs</h6>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="10%">Mesin</th>
                                <th width="10%">Form</th>
                                <th width="10%">Field</th>
                                <th width="10%">Var 1</th>
                                <th width="10%">Var 2</th>
                                <th width="10%">Var 3</th>
                                <th width="10%">Var 4</th>
                                <th width="10%">Var 5</th>
                                <th width="10%">Valfr</th>
                                <th width="10%">Valto</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($itps as $itp)
                                <tr>
                                    <td>{{ $itp->mesin }}</td>
                                    <td>{{ $itp->form }}</td>
                                    <td>{{ $itp->field }}</td>
                                    <td>{{ $itp->var1 }}</td>
                                    <td>{{ $itp->var2 }}</td>
                                    <td>{{ $itp->var3 }}</td>
                                    <td>{{ $itp->var4 }}</td>
                                    <td>{{ $itp->var5 }}</td>
                                    <td>{{ $itp->valfr }}</td>
                                    <td>{{ $itp->valto }}</td>
                                    <td style="display: flex">

                                        <a href="{{ route('itps.edit', ['itp' => $itp->id]) }}"
                                            class="btn btn-primary m-2">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                        <a class="btn btn-danger m-2" href="#" data-toggle="modal" data-target="#deleteModal">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    @include('itps.delete-modal')

@endsection

@section('scripts')

@endsection
