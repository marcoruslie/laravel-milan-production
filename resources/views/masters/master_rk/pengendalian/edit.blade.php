@extends('layouts.app')

@section('title', 'Edit RK pengendalian')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit RK pengendalian</h1>
        <a href="{{route('rk.pengendalian.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
    </div>

    {{-- Alert Messages --}}
    @include('common.alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit RK pengendalian</h6>
        </div>
        <form method="POST" action="{{route('rk.pengendalian.update', ['pengendalian' => $pengendalian->id])}}">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="form-group row">

                    {{-- Fan Vacum --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Fan Vacum</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('fan_vacum') is-invalid @enderror"
                            id="examplefan_vacum"
                            placeholder="Fan Vacum"
                            name="fan_vacum"
                            value="{{ old('fan_vacum') ?  old('fan_vacum') : $pengendalian->fan_vacum}}">

                        @error('fan_vacum')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Fan Temp --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Fan Temp</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('fan_temp') is-invalid @enderror"
                            id="examplefan_temp"
                            placeholder="Fan Temp"
                            name="fan_temp"
                            value="{{ old('fan_temp') ?  old('fan_temp') : $pengendalian->fan_temp}}">

                        @error('fan_temp')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Gas Preasure --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Gas Preasure</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('gas_preasure') is-invalid @enderror"
                            id="examplegas_preasure"
                            placeholder="Gas Preasure"
                            name="gas_preasure"
                            value="{{ old('gas_preasure') ?  old('gas_preasure') : $pengendalian->gas_preasure}}">

                        @error('gas_preasure')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- h28 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>h28</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('h28') is-invalid @enderror"
                            id="exampleh28"
                            placeholder="h28"
                            name="h28"
                            value="{{ old('h28') ?  old('h28') : $pengendalian->h28}}">

                        @error('h28')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- h27 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>h27</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('h27') is-invalid @enderror"
                            id="exampleh27"
                            placeholder="h27"
                            name="h27"
                            value="{{ old('h27') ?  old('h27') : $pengendalian->h27}}">

                        @error('h27')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- h1 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>h1</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('h1') is-invalid @enderror"
                            id="exampleh1"
                            placeholder="h1"
                            name="h1"
                            value="{{ old('h1') ?  old('h1') : $pengendalian->h1}}">

                        @error('h1')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- h2 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>h2</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('h2') is-invalid @enderror"
                            id="exampleh2"
                            placeholder="h2"
                            name="h2"
                            value="{{ old('h2') ?  old('h2') : $pengendalian->h2}}">

                        @error('h2')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- h3 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>h3</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('h3') is-invalid @enderror"
                            id="exampleh3"
                            placeholder="h3"
                            name="h3"
                            value="{{ old('h3') ?  old('h3') : $pengendalian->h3}}">

                        @error('h3')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- f4 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>f4</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('f4') is-invalid @enderror"
                            id="examplef4"
                            placeholder="f4"
                            name="f4"
                            value="{{ old('f4') ?  old('f4') : $pengendalian->f4}}">

                        @error('f4')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- h5 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>h5</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('h5') is-invalid @enderror"
                            id="exampleh5"
                            placeholder="h5"
                            name="h5"
                            value="{{ old('h5') ?  old('h5') : $pengendalian->h5}}">

                        @error('h5')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- f6 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>f6</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('f6') is-invalid @enderror"
                            id="examplef6"
                            placeholder="f6"
                            name="f6"
                            value="{{ old('f6') ?  old('f6') : $pengendalian->f6}}">

                        @error('f6')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- f6 Setting --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>f6 Setting</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('f6_setting') is-invalid @enderror"
                            id="examplef6_setting"
                            placeholder="f6 Setting"
                            name="f6_setting"
                            value="{{ old('f6_setting') ?  old('f6_setting') : $pengendalian->f6_setting}}">

                        @error('f6_setting')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- h7 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>h7</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('h7') is-invalid @enderror"
                            id="exampleh7"
                            placeholder="h7"
                            name="h7"
                            value="{{ old('h7') ?  old('h7') : $pengendalian->h7}}">

                        @error('h7')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- f8 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>f8</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('f8') is-invalid @enderror"
                            id="examplef8"
                            placeholder="f8"
                            name="f8"
                            value="{{ old('f8') ?  old('f8') : $pengendalian->f8}}">

                        @error('f8')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- a9 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>a9</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('a9') is-invalid @enderror"
                            id="examplea9"
                            placeholder="a9"
                            name="a9"
                            value="{{ old('a9') ?  old('a9') : $pengendalian->a9}}">

                        @error('a9')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- a9 Setting --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>a9 Setting</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('a9_setting') is-invalid @enderror"
                            id="examplea9_setting"
                            placeholder="a9 Setting"
                            name="a9_setting"
                            value="{{ old('a9_setting') ?  old('a9_setting') : $pengendalian->a9_setting}}">

                        @error('a9_setting')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- a10 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>a10</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('a10') is-invalid @enderror"
                            id="examplea10"
                            placeholder="a10"
                            name="a10"
                            value="{{ old('a10') ?  old('a10') : $pengendalian->a10}}">

                        @error('a10')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- a10 Setting --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>a10 Setting</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('a10_Setting') is-invalid @enderror"
                            id="examplea10_Setting"
                            placeholder="a10 Setting"
                            name="a10_Setting"
                            value="{{ old('a10_Setting') ?  old('a10_Setting') : $pengendalian->a10_Setting}}">

                        @error('a10_Setting')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- a11 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>a11</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('a11') is-invalid @enderror"
                            id="examplea11"
                            placeholder="a11"
                            name="a11"
                            value="{{ old('a11') ?  old('a11') : $pengendalian->a11}}">

                        @error('a11')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- a11 Setting --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>a11 Setting</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('a11_setting') is-invalid @enderror"
                            id="examplea11_setting"
                            placeholder="a11 Setting"
                            name="a11_setting"
                            value="{{ old('a11_setting') ?  old('a11_setting') : $pengendalian->a11_setting}}">

                        @error('a11_setting')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- a12 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>a12</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('a12') is-invalid @enderror"
                            id="examplea12"
                            placeholder="a12"
                            name="a12"
                            value="{{ old('a12') ?  old('a12') : $pengendalian->a12}}">

                        @error('a12')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- a12 Setting --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>a12 Setting</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('a12_setting') is-invalid @enderror"
                            id="examplea12_setting"
                            placeholder="a12 Setting"
                            name="a12_setting"
                            value="{{ old('a12_setting') ?  old('a12_setting') : $pengendalian->a12_setting}}">

                        @error('a12_setting')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- a13 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>a13</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('a13') is-invalid @enderror"
                            id="examplea13"
                            placeholder="a13"
                            name="a13"
                            value="{{ old('a13') ?  old('a13') : $pengendalian->a13}}">

                        @error('a13')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- a13 Setting --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>a13 Setting</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('a13_setting') is-invalid @enderror"
                            id="examplea13_setting"
                            placeholder="a13 Setting"
                            name="a13_setting"
                            value="{{ old('a13_setting') ?  old('a13_setting') : $pengendalian->a13_setting}}">

                        @error('a13_setting')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- a14 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>a14</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('a14') is-invalid @enderror"
                            id="examplea14"
                            placeholder="a14"
                            name="a14"
                            value="{{ old('a14') ?  old('a14') : $pengendalian->a14}}">

                        @error('a14')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- a14 Setting --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>a14 Setting</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('a14_setting') is-invalid @enderror"
                            id="examplea14_setting"
                            placeholder="a14 Setting"
                            name="a14_setting"
                            value="{{ old('a14_setting') ?  old('a14_setting') : $pengendalian->a14_setting}}">

                        @error('a14_setting')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- a15 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>a15</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('a15') is-invalid @enderror"
                            id="examplea15"
                            placeholder="a15"
                            name="a15"
                            value="{{ old('a15') ?  old('a15') : $pengendalian->a15}}">

                        @error('a15')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- a15 Setting --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>a15 Setting</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('a15_setting') is-invalid @enderror"
                            id="examplea15_setting"
                            placeholder="a15 Setting"
                            name="a15_setting"
                            value="{{ old('a15_setting') ?  old('a15_setting') : $pengendalian->a15_setting}}">

                        @error('a15_setting')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- a16 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>a16</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('a16') is-invalid @enderror"
                            id="examplea16"
                            placeholder="a16"
                            name="a16"
                            value="{{ old('a16') ?  old('a16') : $pengendalian->a16}}">

                        @error('a16')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- a16 Setting --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>a16 Setting</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('a16_setting') is-invalid @enderror"
                            id="examplea16_setting"
                            placeholder="a16 Setting"
                            name="a16_setting"
                            value="{{ old('a16_setting') ?  old('a16_setting') : $pengendalian->a16_setting}}">

                        @error('a16_setting')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- a17 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>a17</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('a17') is-invalid @enderror"
                            id="examplea17"
                            placeholder="a17"
                            name="a17"
                            value="{{ old('a17') ?  old('a17') : $pengendalian->a17}}">

                        @error('a17')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- a17 Setting --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>a17 Setting</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('a17_setting') is-invalid @enderror"
                            id="examplea17_setting"
                            placeholder="a17 Setting"
                            name="a17_setting"
                            value="{{ old('a17_setting') ?  old('a17_setting') : $pengendalian->a17_setting}}">

                        @error('a17_setting')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- a18 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>a18</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('a18') is-invalid @enderror"
                            id="examplea18"
                            placeholder="a18"
                            name="a18"
                            value="{{ old('a18') ?  old('a18') : $pengendalian->a18}}">

                        @error('a18')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- a18 Setting --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>a18 Setting</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('a18_setting') is-invalid @enderror"
                            id="examplea18_setting"
                            placeholder="a18 Setting"
                            name="a18_setting"
                            value="{{ old('a18_setting') ?  old('a18_setting') : $pengendalian->a18_setting}}">

                        @error('a18_setting')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- a19 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>a19</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('a19') is-invalid @enderror"
                            id="examplea19"
                            placeholder="a19"
                            name="a19"
                            value="{{ old('a19') ?  old('a19') : $pengendalian->a19}}">

                        @error('a19')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- a19 Setting --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>a19 Setting</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('a19_setting') is-invalid @enderror"
                            id="examplea19_setting"
                            placeholder="a19 Setting"
                            name="a19_setting"
                            value="{{ old('a19_setting') ?  old('a19_setting') : $pengendalian->a19_setting}}">

                        @error('a19_setting')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- a20 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>a20</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('a20') is-invalid @enderror"
                            id="examplea20"
                            placeholder="a20"
                            name="a20"
                            value="{{ old('a20') ?  old('a20') : $pengendalian->a20}}">

                        @error('a20')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- a20 Setting --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>a20 Setting</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('a20_setting') is-invalid @enderror"
                            id="examplea20_setting"
                            placeholder="a20 Setting"
                            name="a20_setting"
                            value="{{ old('a20_setting') ?  old('a20_setting') : $pengendalian->a20_setting}}">

                        @error('a20_setting')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- a21 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>a21</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('a21') is-invalid @enderror"
                            id="examplea21"
                            placeholder="a21"
                            name="a21"
                            value="{{ old('a21') ?  old('a21') : $pengendalian->a21}}">

                        @error('a21')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- a21 Setting --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>a21 Setting</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('a21_setting') is-invalid @enderror"
                            id="examplea21_setting"
                            placeholder="a21 Setting"
                            name="a21_setting"
                            value="{{ old('a21_setting') ?  old('a21_setting') : $pengendalian->a21_setting}}">

                        @error('a21_setting')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- a22 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>a22</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('a22') is-invalid @enderror"
                            id="examplea22"
                            placeholder="a22"
                            name="a22"
                            value="{{ old('a22') ?  old('a22') : $pengendalian->a22}}">

                        @error('a22')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- a22 Setting --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>a22 Setting</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('a22_setting') is-invalid @enderror"
                            id="examplea22_setting"
                            placeholder="a22 Setting"
                            name="a22_setting"
                            value="{{ old('a22_setting') ?  old('a22_setting') : $pengendalian->a22_setting}}">

                        @error('a22_setting')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- a23 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>a23</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('a23') is-invalid @enderror"
                            id="examplea23"
                            placeholder="a23"
                            name="a23"
                            value="{{ old('a23') ?  old('a23') : $pengendalian->a23}}">

                        @error('a23')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- a24 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>a24</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('a24') is-invalid @enderror"
                            id="examplea24"
                            placeholder="a24"
                            name="a24"
                            value="{{ old('a24') ?  old('a24') : $pengendalian->a24}}">

                        @error('a24')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- f25 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>f25</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('f25') is-invalid @enderror"
                            id="examplef25"
                            placeholder="f25"
                            name="f25"
                            value="{{ old('f25') ?  old('f25') : $pengendalian->f25}}">

                        @error('f25')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- f26 --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>f26</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('f26') is-invalid @enderror"
                            id="examplef26"
                            placeholder="f26"
                            name="f26"
                            value="{{ old('f26') ?  old('f26') : $pengendalian->f26}}">

                        @error('f26')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- f26 Setting --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>f26 Setting</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('f26_setting') is-invalid @enderror"
                            id="examplef26_setting"
                            placeholder="f26 Setting"
                            name="f26_setting"
                            value="{{ old('f26_setting') ?  old('f26_setting') : $pengendalian->f26_setting}}">

                        @error('f26_setting')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Comb Preasure --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Comb Preasure</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('comb_preasure') is-invalid @enderror"
                            id="examplecomb_preasure"
                            placeholder="Comb Preasure"
                            name="comb_preasure"
                            value="{{ old('comb_preasure') ?  old('comb_preasure') : $pengendalian->comb_preasure}}">

                        @error('comb_preasure')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Comb Temp --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Comb Temp</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('comb_temp') is-invalid @enderror"
                            id="examplecomb_temp"
                            placeholder="Comb Temp"
                            name="comb_temp"
                            value="{{ old('comb_temp') ?  old('comb_temp') : $pengendalian->comb_temp}}">

                        @error('comb_temp')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Zero Point --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Zero Point</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('zero_point') is-invalid @enderror"
                            id="examplezero_point"
                            placeholder="Zero Point"
                            name="zero_point"
                            value="{{ old('zero_point') ?  old('zero_point') : $pengendalian->zero_point}}">

                        @error('zero_point')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Hot Air Fan --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Hot Air Fan</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('hot_air_fan') is-invalid @enderror"
                            id="examplehot_air_fan"
                            placeholder="Hot Air Fan"
                            name="hot_air_fan"
                            value="{{ old('hot_air_fan') ?  old('hot_air_fan') : $pengendalian->hot_air_fan}}">

                        @error('hot_air_fan')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Speedy Preasure --}}
                    <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        <span style="color:red;">*</span>Speedy Preasure</label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('speedy_preasure') is-invalid @enderror"
                            id="examplespeedy_preasure"
                            placeholder="Speedy Preasure"
                            name="speedy_preasure"
                            value="{{ old('speedy_preasure') ?  old('speedy_preasure') : $pengendalian->speedy_preasure}}">

                        @error('speedy_preasure')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-success btn-user float-right mb-3">Update</button>
                <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('rk.pengendalian.index') }}">Cancel</a>
            </div>
        </form>
    </div>

</div>


@endsection
