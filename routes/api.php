<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\admin\adminHomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BPController;
use App\Http\Controllers\downTimeController;
use App\Http\Controllers\GLController;
use App\Http\Controllers\HeaderController;
use App\Http\Controllers\ListHeaderController;
use App\Http\Controllers\PHController;
use App\Http\Controllers\post_controller;
use App\Http\Controllers\qcController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RKController;
use App\Http\Controllers\shiftController;
use App\Http\Controllers\SRController;
use App\Http\Controllers\StdController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//AUTHENTICATION
Route::post('/login', [AuthController::class, 'login']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/getDataUserLogin', [AuthController::class, 'getDataUserLogin']);
});
Route::post('/home/addDataSortir', [adminHomeController::class, 'add'])->name('add');
Route::post('/home/addDataKiln', [adminHomeController::class, 'addHasilKiln'])->name('addHasilKiln');
Route::get('/home/getUser/{nip}', [AuthController::class, 'getDataUser']);
//Header Section
Route::name("header.")->prefix("header")->group(function ($router) {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/add', [HeaderController::class, 'addHeader']);
        Route::get('/getOne/{kode}', [HeaderController::class, 'getOne']);
        Route::get('/getHeader', [HeaderController::class, 'getHeader']);
        Route::get('/getAllbyPh/{ph}', [HeaderController::class, 'getAllbyPh']);
        Route::get('/getCar', [HeaderController::class, 'getCar']);
    });
});

Route::name("shift.")->prefix("shift")->group(function ($router) {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/create', [shiftController::class, 'create']);
        Route::get('/get', [shiftController::class, 'get']);
        // Route::post('/updateCounter', [PHController::class, 'updateCounter']);
    });
});

//PH Section
Route::name("ph.")->prefix("ph")->group(function ($router) {
    Route::middleware(['auth:sanctum'])->group(function () {
        //confirm
        Route::post('/confirmPh', [PHController::class, 'confirmPh']);
        //control
        Route::post('/createPhControl', [PHController::class, 'createPhControl']);
        Route::get('/getPhControl/{kode}/{shift}', [PHController::class, 'getPhControl']);
        Route::post('/updatePhControl/{id}', [PHController::class, 'updatePhControl']);
        //temp
        Route::post('/createPhTemp', [PHController::class, 'createPhTemp']);
        Route::get('/getPhTemp/{kode}/{shift}', [PHController::class, 'getPhTemp']);
        Route::post('/updatePhTemp/{id}', [PHController::class, 'updatePhTemp']);
        //dimensi
        Route::post('/createPhDimensi', [PHController::class, 'createPhDimensi']);
        Route::post('/createPhDetailDimensi', [PHController::class, 'createPhDetailDimensi']);
        Route::get('/getPhDimensi/{kode}/{shift}', [PHController::class, 'getPhDimensi']);
        Route::post('/updateDetailDimensi/{id}', [PHController::class, 'updateDetailDimensi']);
        Route::post('/updatePhPopulasiDimensi', [PHController::class, 'updatePhPopulasiDimensi']);
        //tebal
        Route::post('/createPhTebal', [PHController::class, 'createPhTebal']);
        Route::post('/createPhDetailTebal', [PHController::class, 'createPhDetailTebal']);
        Route::get('/getPhTebal/{kode}/{shift}', [PHController::class, 'getPhTebal']);
        Route::post('/updateDetailTebal/{id}', [PHController::class, 'updateDetailTebal']);
        //counter
        Route::post('/createPhCounter', [PHController::class, 'createPhCounter']);
        Route::get('/getPhCounter/{kode}/{shift}', [PHController::class, 'getPhCounter']);
        Route::post('/updatePhCounter/{id}', [PHController::class, 'updatePhCounter']);
        //dryer
        Route::post('/createPhDryer', [PHController::class, 'createPhDryer']);
        Route::get('/getPhDryer/{kode}/{shift}', [PHController::class, 'getPhDryer']);
        Route::post('/updatePhDryer/{id}', [PHController::class, 'updatePhDryer']);
        //set-cool
        Route::post('/createPhSetCool', [PHController::class, 'createPhSetCool']);
        Route::get('/getPhSetCool/{kode}/{shift}', [PHController::class, 'getPhSetCool']);
        Route::post('/updatePhSetCool/{id}', [PHController::class, 'updatePhSetCool']);
        //temp out
        Route::post('/createPhTempOut', [PHController::class, 'createPhTempOut']);
        Route::get('/getPhTempOut/{kode}/{shift}', [PHController::class, 'getPhTempOut']);
        Route::post('/updatePhTempOut/{id}', [PHController::class, 'updatePhTempOut']);
    });
});

//GL Section
Route::name("gl.")->prefix("gl")->group(function ($router) {
    Route::middleware(['auth:sanctum'])->group(function () {
        //confirm
        Route::post('/confirmGl', [GLController::class, 'confirmGl']);
        //hasil produksi
        Route::post('/createGlHasilProduksi', [GLController::class, 'createGlHasilProduksi']);
        Route::get('/getGlHasilProduksi/{kode}/{shift}', [GLController::class, 'getGlHasilProduksi']);
        Route::get('/getAllGlHasilProduksi', [GLController::class, 'getAllGlHasilProduksi']);
        Route::post('/updateGlHasilProduksi/{id}', [GLController::class, 'updateGlHasilProduksi']);
        //pengendalian proses
        Route::post('/createGlPengendalian', [GLController::class, 'createGlPengendalian']);
        Route::get('/getGlPengendalian/{kode}/{shift}', [GLController::class, 'getGlPengendalian']);
        Route::post('/updateGlPengendalian/{id}', [GLController::class, 'updateGlPengendalian']);
        //analisa tes bakar
        Route::post('/createGlAnalisaTesBakar', [GLController::class, 'createGlAnalisaTesBakar']);
        Route::get('/getGlAnalisaTesBakar/{kode}/{shift}', [GLController::class, 'getGlAnalisaTesBakar']);
        Route::post('/updateGlAnalisaTesBakar/{id}', [GLController::class, 'updateGlAnalisaTesBakar']);
    });
});

//BP Section
Route::name("bp.")->prefix("bp")->group(function ($router) {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/confirmBp', [BPController::class, 'confirmBp']);
        //rekap hasil Slip
        Route::post('/createBpRekapSlip', [BPController::class, 'createBpRekapSlip']);
        Route::get('/getBpRekapSlip/{kode}/{shift}', [BPController::class, 'getBpRekapSlip']);
        Route::post('/updateBpRekapSlip/{id}', [BPController::class, 'updateBpRekapSlip']);
        //rekap hasil Powder
        Route::post('/createBpRekapPowder', [BPController::class, 'createBpRekapPowder']);
        Route::get('/getBpRekapPowder/{kode}/{shift}', [BPController::class, 'getBpRekapPowder']);
        Route::post('/updateBpRekapPowder/{id}', [BPController::class, 'updateBpRekapPowder']);
        //pengendalian proses Slip
        Route::post('/createBpPengendalianSlip', [BPController::class, 'createBpPengendalianSlip']);
        Route::get('/getBpPengendalianSlip/{kode}/{shift}', [BPController::class, 'getBpPengendalianSlip']);
        Route::post('/updateBpPengendalianSlip/{id}', [BPController::class, 'updateBpPengendalianSlip']);
        //pengendalian proses Powder
        Route::post('/createBpPengendalianPowder', [BPController::class, 'createBpPengendalianPowder']);
        Route::post('/createBpDetailPengendalianPowder', [BPController::class, 'createBpDetailPengendalianPowder']);
        Route::get('/getBpPengendalianPowder/{kode}/{shift}', [BPController::class, 'getBpPengendalianPowder']);
        Route::post('/updateBpPengendalianPowder/{id}', [BPController::class, 'updateBpPengendalianPowder']);
        Route::post('/updateBpDetailPengendalianPowder/{id}', [BPController::class, 'updateBpDetailPengendalianPowder']);
    });
});

//RK Section
Route::name("rk.")->prefix("rk")->group(function ($router) {
    Route::middleware(['auth:sanctum'])->group(function () {
        //confirm
        Route::post('/confirmRk', [RKController::class, 'confirmRk']);
        //unloading gl
        Route::post('/createRkUnloadingGl', [RKController::class, 'createRkUnloadingGl']);
        Route::get('/getRkUnloadingGl/{kode}/{shift}', [RKController::class, 'getRkUnloadingGl']);
        //acc
        Route::post('/accRkHasilProduksi', [RKController::class, 'accRkHasilProduksi']);
        //hasil produksi
        Route::post('/createRkHasilProduksi', [RKController::class, 'createRkHasilProduksi']);
        Route::get('/getRkHasilProduksi/{kode}/{shift}', [RKController::class, 'getRkHasilProduksi']);
        Route::post('/updateRkHasilProduksi/{id}', [RKController::class, 'updateRkHasilProduksi']);
        //pengendalian proses
        Route::post('/createRkPengendalian', [RKController::class, 'createRkPengendalian']);
        Route::get('/getRkPengendalian/{kode}/{shift}', [RKController::class, 'getRkPengendalian']);
        Route::post('/updateRkPengendalian/{id}', [RKController::class, 'updateRkPengendalian']);
        //koreksi tiles
        Route::post('/createRkKoreksi', [RKController::class, 'createRkKoreksi']);
        Route::post('/createRkDetailKoreksi', [RKController::class, 'createRkDetailKoreksi']);
        Route::get('/getRkKoreksi/{kode}/{shift}', [RKController::class, 'getRkKoreksi']);
        Route::post('/updateDetailKoreksi/{id}', [RKController::class, 'updateDetailKoreksi']);
        // get target SAP
        Route::get('/getTargetSap', [RKController::class, 'getTargetSap']);
    });
});
// SR SECTION
Route::name("sr.")->prefix("sr")->group(function ($router) {
    Route::middleware(['auth:sanctum'])->group(function () {
        //confirm
        Route::post('/confirmSr', [SRController::class, 'confirmSr']);
        //unloading rk
        Route::post('/createSrUnloadingRk', [SRController::class, 'createSrUnloadingRk']);
        Route::get('/getSrUnloadingRk/{kode}/{shift}', [SRController::class, 'getSrUnloadingRk']);
        //acc
        Route::post('/accSrHasilProduksi', [SRController::class, 'accSrHasilProduksi']);
        //hasil produksi
        Route::post('/createSrHasilProduksi', [SRController::class, 'createSrHasilProduksi']);
        Route::get('/getSrHasilProduksi/{kode}/{shift}', [SRController::class, 'getSrHasilProduksi']);
        Route::post('/updateSrHasilProduksi', [SRController::class, 'updateSrHasilProduksi']);
        //hasil sortir
        Route::post('/createSrHasilSortir', [SRController::class, 'createSrHasilSortir']);
        Route::get('/getSrHasilSortir/{kode}/{shift}', [SRController::class, 'getSrHasilSortir']);
        Route::post('/updateSrHasilSortir/{id}', [SRController::class, 'updateSrHasilSortir']);
        //cek mesin
        Route::post('/createSrCekMesin', [SRController::class, 'createSrCekMesin']);
        Route::get('/getSrCekMesin/{kode}/{shift}', [SRController::class, 'getSrCekMesin']);
        Route::post('/updateSrCekMesin/{id}', [SRController::class, 'updateSrCekMesin']);
        //kontrol hasil
        Route::post('/createSrKontrolHasil', [SRController::class, 'createSrKontrolHasil']);
        Route::get('/getSrKontrolHasil/{kode}/{shift}', [SRController::class, 'getSrKontrolHasil']);
        Route::post('/updateSrKontrolHasil{id}', [SRController::class, 'updateSrKontrolHasil']);

        // ANALISA KUALITAS TILE
        Route::post('/createSrAnalisaKualitas', [SRController::class, 'createAnalisaKualitas']);
        Route::get('/getSrAnalisaKualitas/{order_id}', [SRController::class, 'getAnalisaKualitas']);
        Route::post('/updateSrAnalisaKualitas/{id}', [SRController::class, 'updateAnalisaKualitas']);

        // LIST ANALISA KUALITAS TILE
        Route::post('/createListAnalisaKualitas', [SRController::class, 'createListAnalisaKualitas']);
        Route::get('/getListAnalisaKualitas/{id}', [SRController::class, 'getListAnalisaKualitas']);
        Route::post('/updateListAnalisaKualitas/{id}', [SRController::class, 'updateListAnalisaKualitas']);
        Route::post('/deleteListAnalisaKualitas', [SRController::class, 'deleteListAnalisaKualitas']);

        // LIST JENIS CACAT
        Route::post('/createListJenisCacat', [SRController::class, 'createListJenisCacat']);
        Route::get('/getListJenisCacat', [SRController::class, 'getJenisCacat']);
    });
});
// STD SECTION
Route::name("std.")->prefix("std")->group(function ($router) {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/getStd/{mesin}/{form}', [StdController::class, 'getStd']);
    });
});
// QC SECTION
Route::name("qc.")->prefix("qc")->group(function ($router) {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/createQcBallMill', [qcController::class, 'createQcBallMill']);
        Route::get('/getQcBallMill/{kode}/{shift}', [qcController::class, 'getQcBallMill']);
        Route::post('/updateQcBallMill/{id}', [qcController::class, 'updateQcBallMill']);

        Route::post('/createQcPengecekanGl', [qcController::class, 'createQcPengecekanGl']);
        Route::get('/getQcPengecekanGl/{kode}/{shift}', [qcController::class, 'getQcPengecekanGl']);
        Route::post('/updateQcPengecekanGl/{id}', [qcController::class, 'updateQcPengecekanGl']);

        Route::post('/createQcPengamatanGl', [qcController::class, 'createQcPengamatanGl']);
        Route::get('/getQcPengamatanGl/{kode}/{shift}', [qcController::class, 'getQcPengamatanGl']);
        Route::post('/updateQcPengamatanGl/{id}', [qcController::class, 'updateQcPengamatanGl']);

        Route::post('/createQcPengecekanDimensi', [qcController::class, 'createQcPengecekanDimensi']);
        Route::get('/getQcPengecekanDimensi/{kode}/{shift}', [qcController::class, 'getQcPengecekanDimensi']);
        Route::post('/updateQcPengecekanDimensi/{id}', [qcController::class, 'updateQcPengecekanDimensi']);

        Route::post('/createQcPengecekanPembacaan', [qcController::class, 'createQcPengecekanPembacaan']);
        Route::get('/getQcPengecekanPembacaan/{kode}/{shift}', [qcController::class, 'getQcPengecekanPembacaan']);
        Route::post('/updateQcPengecekanPembacaan/{id}', [qcController::class, 'updateQcPengecekanPembacaan']);

        Route::post('/createQcDalamBox', [qcController::class, 'createQcDalamBox']);
        Route::get('/getQcDalamBox/{kode}/{shift}', [qcController::class, 'getQcDalamBox']);
        Route::post('/updateQcDalamBox/{id}', [qcController::class, 'updateQcDalamBox']);

        Route::post('/createQcCekTileOut', [qcController::class, 'createQcCekTileOut']);
        Route::post('/createDetailQcCekTileOut', [qcController::class, 'createDetailQcCekTileOut']);
        Route::get('/getQcCekTileOut/{kode}/{shift}', [qcController::class, 'getQcCekTileOut']);
        Route::post('/updateQcCekTileOut/{id}', [qcController::class, 'updateQcCekTileOut']);
        Route::post('/updateDetailQcCekTileOut/{id}', [qcController::class, 'updateDetailQcCekTileOut']);
    });
});
// DOWNTIME SECTION
Route::name("downtime.")->prefix("downtime")->group(function ($router) {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/createDownTime', [downTimeController::class, 'createDownTime']);
        Route::get('/getDownTime/{mesin}/{order}', [downTimeController::class, 'getDownTime']);
        Route::post('/updateDownTime/{id}', [downTimeController::class, 'updateDownTime']);
    });
});

Route::name("list_header.")->prefix("list_header")->group(function ($router) {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/getHeader/{date}', [ListHeaderController::class, 'getHeader']);
        Route::get('/getOneHeader/{po_id}', [ListHeaderController::class, 'getOneHeader']);
        Route::post('/createHeader', [ListHeaderController::class, 'createHeader']);
        Route::post('/updateHeader/{po_id}', [ListHeaderController::class, 'updateStatusQcHeader']);
        Route::post('/createDetailQcPo', [ListHeaderController::class, 'createDetailQcPo']);
        Route::post('/deleteDetailQcPo', [ListHeaderController::class, 'deleteDetailQcPo']);
        Route::get('/getDetailQcPo/{po_id}', [ListHeaderController::class, 'getDetailQcPo']);
    });
});

Route::name("report.")->prefix("report")->group(function ($router) {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/getReport/{po_id}/{po_date}/{start_hour}', [ReportController::class, 'getReportHasil']);
        Route::post('/getReport', [ReportController::class, 'getReport']);
        Route::post('/addReport', [ReportController::class, 'addReport']);
        Route::post('/updateReport', [ReportController::class, 'updateReport']);
    });
});

Route::name("absensi.")->prefix("absensi")->group(function ($router) {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/getAbsensi', [AbsensiController::class, 'getAbsensi']);
        Route::post('/createAbsensi', [AbsensiController::class, 'createAbsensi']);
        Route::post('/updateAbsensi', [AbsensiController::class, 'updateAbsensi']);
        // GET DATA USER OPERATOR
        Route::get('/getDataUser/{kode_grup}', [AbsensiController::class, 'getDataUser']);
    });
});
// Route::get('/post', [HeaderController::class, 'index'])->middleware(['auth:sanctum']);
