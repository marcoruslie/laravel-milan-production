@extends('layouts.app')

@section('title', 'Edit SR Hasil Produksi')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit SR Hasil Produksi</h1>
        <a href="{{route('sr.hasilProduksi.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
    </div>

    {{-- Alert Messages --}}
    @include('common.alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit SR Hasil Produksi</h6>
        </div>
        <form method="POST" action="{{route('sr.hasilProduksi.update', ['hasilProduksi' => $hasilProduksi->id])}}">
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
                            value="{{ old('from') ?  old('from') : $hasilProduksi->from}}">

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
                            value="{{ old('no') ? old('no') : $hasilProduksi->no }}">

                        @error('no')
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
                            value="{{ old('jumlah') ? old('jumlah') : $hasilProduksi->jumlah }}">

                        @error('jumlah')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Unloading --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Unloading</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('unloading') is-invalid @enderror"
                            id="exampleunloading"
                            placeholder="Unloading"
                            name="unloading"
                            value="{{ old('unloading') ? old('unloading') : $hasilProduksi->unloading }}">

                        @error('unloading')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- a --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>a</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('a') is-invalid @enderror"
                            id="examplea"
                            placeholder="a"
                            name="a"
                            value="{{ old('a') ? old('a') : $hasilProduksi->a }}">

                        @error('a')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- s --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>s</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('s') is-invalid @enderror"
                            id="examples"
                            placeholder="s"
                            name="s"
                            value="{{ old('s') ? old('s') : $hasilProduksi->s }}">

                        @error('s')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- m --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>m</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('m') is-invalid @enderror"
                            id="examplem"
                            placeholder="m"
                            name="m"
                            value="{{ old('m') ? old('m') : $hasilProduksi->m }}">

                        @error('m')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- l --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>l</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('l') is-invalid @enderror"
                            id="examplel"
                            placeholder="l"
                            name="l"
                            value="{{ old('l') ? old('l') : $hasilProduksi->l }}">

                        @error('l')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- ll --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>ll</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('ll') is-invalid @enderror"
                            id="examplell"
                            placeholder="ll"
                            name="ll"
                            value="{{ old('ll') ? old('ll') : $hasilProduksi->ll }}">

                        @error('ll')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- xm --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>xm</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('xm') is-invalid @enderror"
                            id="examplexm"
                            placeholder="xm"
                            name="xm"
                            value="{{ old('xm') ? old('xm') : $hasilProduksi->xm }}">

                        @error('xm')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- xl --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>xl</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('xl') is-invalid @enderror"
                            id="examplexl"
                            placeholder="xl"
                            name="xl"
                            value="{{ old('xl') ? old('xl') : $hasilProduksi->xl }}">

                        @error('xl')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- b --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>b</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('b') is-invalid @enderror"
                            id="exampleb"
                            placeholder="b"
                            name="b"
                            value="{{ old('b') ? old('b') : $hasilProduksi->b }}">

                        @error('b')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- e --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>e</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('e') is-invalid @enderror"
                            id="examplee"
                            placeholder="e"
                            name="e"
                            value="{{ old('e') ? old('e') : $hasilProduksi->e }}">

                        @error('e')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- g --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>g</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('g') is-invalid @enderror"
                            id="exampleg"
                            placeholder="g"
                            name="g"
                            value="{{ old('g') ? old('g') : $hasilProduksi->g }}">

                        @error('g')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- h --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>h</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('h') is-invalid @enderror"
                            id="exampleh"
                            placeholder="h"
                            name="h"
                            value="{{ old('h') ? old('h') : $hasilProduksi->h }}">

                        @error('h')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- f --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>f</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('f') is-invalid @enderror"
                            id="examplef"
                            placeholder="f"
                            name="f"
                            value="{{ old('f') ? old('f') : $hasilProduksi->f }}">

                        @error('f')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- c --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>c</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('c') is-invalid @enderror"
                            id="examplec"
                            placeholder="c"
                            name="c"
                            value="{{ old('c') ? old('c') : $hasilProduksi->c }}">

                        @error('c')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- q --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>q</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('q') is-invalid @enderror"
                            id="exampleq"
                            placeholder="q"
                            name="q"
                            value="{{ old('q') ? old('q') : $hasilProduksi->q }}">

                        @error('q')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- kw4 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>kw4</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('kw4') is-invalid @enderror"
                            id="examplekw4"
                            placeholder="kw4"
                            name="kw4"
                            value="{{ old('kw4') ? old('kw4') : $hasilProduksi->kw4 }}">

                        @error('kw4')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Jumlah Total --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Jumlah Total</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('jumlah_total') is-invalid @enderror"
                            id="examplejumlah_total"
                            placeholder="Jumlah Total"
                            name="jumlah_total"
                            value="{{ old('jumlah_total') ? old('jumlah_total') : $hasilProduksi->jumlah_total }}">

                        @error('jumlah_total')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Karton --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Karton</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('karton') is-invalid @enderror"
                            id="examplekarton"
                            placeholder="Karton"
                            name="karton"
                            value="{{ old('karton') ? old('karton') : $hasilProduksi->karton }}">

                        @error('karton')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Keterangan Kw4 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Keterangan Kw4</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('kw4ket') is-invalid @enderror"
                            id="examplekw4ket"
                            placeholder="Keterangan Kw4"
                            name="kw4ket"
                            value="{{ old('kw4ket') ? old('kw4ket') : $hasilProduksi->kw4ket }}">

                        @error('kw4ket')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- bs --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>bs</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('bs') is-invalid @enderror"
                            id="examplebs"
                            placeholder="bs"
                            name="bs"
                            value="{{ old('bs') ? old('bs') : $hasilProduksi->bs }}">

                        @error('bs')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- afal --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>afal</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('afal') is-invalid @enderror"
                            id="exampleafal"
                            placeholder="afal"
                            name="afal"
                            value="{{ old('afal') ? old('afal') : $hasilProduksi->afal }}">

                        @error('afal')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Total --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Total</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('total') is-invalid @enderror"
                            id="exampletotal"
                            placeholder="Total"
                            name="total"
                            value="{{ old('total') ? old('total') : $hasilProduksi->total }}">

                        @error('total')
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
                <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('sr.hasilProduksi.index') }}">Cancel</a>
            </div>
        </form>
    </div>

</div>


@endsection
