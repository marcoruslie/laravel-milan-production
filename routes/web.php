<?php

use App\Http\Controllers\admin\adminBpController;
use App\Http\Controllers\admin\adminCarController;
use App\Http\Controllers\admin\adminDownTimeController;
use App\Http\Controllers\admin\adminGlController;
use App\Http\Controllers\admin\adminHelperController;
use App\Http\Controllers\admin\adminHomeController;
use App\Http\Controllers\admin\adminItpController;
use App\Http\Controllers\admin\adminLoginCotntroller;
use App\Http\Controllers\admin\adminPhController;
use App\Http\Controllers\admin\adminRkController;
use App\Http\Controllers\admin\adminShiftController;
use App\Http\Controllers\admin\adminSrController;
use App\Http\Controllers\admin\adminUserController;
use App\Http\Controllers\ReportPengawasController;
use App\Models\sr_analisa_kualitas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});
Route::get('/tes', function () {
    $result = sr_analisa_kualitas::with('srListKualitas.srCacat')->get();
    $data = $result->groupBy('size')->map(function ($group) {
        $size = $group->first()->size;

        $jenisCacat = [];
        foreach ($group as $item) {
            foreach ($item->srListKualitas as $list) {
                $cacatKey = $list->srCacat->jenis_cacat;

                if (!isset($jenisCacat[$cacatKey])) {
                    $jenisCacat[$cacatKey] = [
                        'jenis_cacat' => $list->srCacat->jenis_cacat,
                        'quantity' => 0,
                        'percentage' => 0,
                        'grouped_posisi' => []
                    ];
                }

                // UPDATE QUANTITY
                $jenisCacat[$cacatKey]['quantity'] += $list->kw2 + $list->kw3 + $list->kw4;

                // ADD POSISI GROUPED BY MATERIAL DESC
                $materialDescKey = $item->material_desc;

                if (!isset($jenisCacat[$cacatKey]['grouped_posisi'][$materialDescKey])) {
                    $jenisCacat[$cacatKey]['grouped_posisi'][$materialDescKey] = [
                        'material_desc' => $materialDescKey,
                        'total_quantity' => 0,
                        'percentage' => 0,
                        'positions' => []
                    ];
                }

                // UPDATE TOTAL QUANTITY FOR THE MATERIAL DESC
                $jenisCacat[$cacatKey]['grouped_posisi'][$materialDescKey]['total_quantity'] += $list->kw2 + $list->kw3 + $list->kw4;

                // ADD DETAIL POSITIONS
                $newPosition = [
                    'no_ph' => $item->no_ph,
                    'no_hd' => $item->no_hd,
                    'no_kiln' => $item->no_kiln,
                    'no_gl' => $item->no_gl,
                    'quantity' => $list->kw2 + $list->kw3 + $list->kw4,
                    'percentage' => 0 // To be calculated later
                ];

                // CHECK IF A SIMILAR POSITION EXISTS, THEN SUM
                $existingPositionKey = collect($jenisCacat[$cacatKey]['grouped_posisi'][$materialDescKey]['positions'])->search(function ($position) use ($newPosition) {
                    return $position['no_ph'] === $newPosition['no_ph'] &&
                        $position['no_hd'] === $newPosition['no_hd'] &&
                        $position['no_kiln'] === $newPosition['no_kiln'] &&
                        $position['no_gl'] === $newPosition['no_gl'];
                });

                if ($existingPositionKey !== false) {
                    $jenisCacat[$cacatKey]['grouped_posisi'][$materialDescKey]['positions'][$existingPositionKey]['quantity'] += $newPosition['quantity'];
                } else {
                    $jenisCacat[$cacatKey]['grouped_posisi'][$materialDescKey]['positions'][] = $newPosition;
                }
            }
        }

        // CALCULATE TOTAL QUANTITY AND SORT BY TOP 5
        $allQuantity = collect($jenisCacat)->sum('quantity');
        $topJenisCacat = collect($jenisCacat)
            ->sortByDesc('quantity')
            ->take(5)
            ->map(function ($cacat) use ($allQuantity) {
                // CALCULATE PERCENTAGE FOR JENIS CACAT
                $cacat['percentage'] = $allQuantity > 0
                    ? round(($cacat['quantity'] / $allQuantity) * 100, 2)
                    : 0;

                // PROCESS grouped_posisi
                $cacat['grouped_posisi'] = collect($cacat['grouped_posisi'])
                    ->map(function ($material) use ($cacat) {
                        // CALCULATE PERCENTAGE FOR MATERIAL DESC
                        $material['percentage'] = $cacat['quantity'] > 0
                            ? round(($material['total_quantity'] / $cacat['quantity']) * 100, 2)
                            : 0;

                        // PROCESS POSITIONS
                        $material['positions'] = collect($material['positions'])
                            ->map(function ($position) use ($material) {
                                // CALCULATE PERCENTAGE FOR POSITION
                                $position['percentage'] = $material['total_quantity'] > 0
                                    ? round(($position['quantity'] / $material['total_quantity']) * 100, 2)
                                    : 0;
                                return $position;
                            })
                            ->values()
                            ->toArray();

                        return $material;
                    })
                    ->values()
                    ->toArray();

                return $cacat;
            })
            ->values()
            ->toArray();

        return [
            'size' => $size,
            'quantity' => $allQuantity,
            'top_jenis_cacat' => $topJenisCacat
        ];
    })->values();


    return view('tes', compact('data'));
});
Route::get('/master', function () {
    return view('layouts.master');
});
Route::get('/app', function () {
    return view('layouts.app');
});


Route::get('/home', [adminHomeController::class, 'index'])->middleware('adminRoutes')->name('home');
Route::get('/pengawas', [adminHomeController::class, 'indexPengawas'])->middleware('adminRoutes')->name('dashboard');
Route::get('/head_plant', [adminHomeController::class, 'indexHeadPlant'])->middleware('adminRoutes')->name('head_plant');
Route::get('/importData', function () {

    return view('masters.importData');
})->middleware('adminRoutes')->name('importData');
//Route::get('/home2', [adminHomeController::class, 'index2'])->middleware('adminRoutes')->name('home2');


//Route::get('/line-chart', [adminHomeController::class, 'AreaChart'])->middleware('adminRoutes')->name('line-chart');

Route::get('indexByFilter', [adminHomeController::class, 'indexByFilter'])->name('indexByFilter');
Route::get('indexFilterPengawas', [adminHomeController::class, 'indexFilterPengawas'])->name('indexFilterPengawas');
//Route::get('ajaxupdatedates', [AdditionalController::class, 'ajaxUpdateDates'])->name('ajaxupdatedates');

Route::post('/login', [adminLoginCotntroller::class, 'authenticate'])->name('doLogin');
Route::post('/logout', [adminLoginCotntroller::class, 'logout'])->name('logout');

Route::name('report.')->prefix('report')->group(function () {
    Route::middleware(['adminRoutes'])->group(function () {
        Route::get('/absensi', [ReportPengawasController::class, 'getReportAbsensi'])->name('reportAbsensi');
        Route::get('/hasil_produksi', [ReportPengawasController::class, 'getReportHasilProduksi'])->name('reportProduksi');
    });
});

Route::name("users.")->prefix("users")->group(function ($router) {
    Route::middleware(['adminRoutes'])->group(function () {
        Route::get('/', [adminUserController::class, 'index'])->name('index');
        Route::get('/edit/{user}', [adminUserController::class, 'edit'])->name('edit');
        Route::put('/update/{user}', [adminUserController::class, 'update'])->name('update');
        Route::delete('/delete/{user}', [adminUserController::class, 'delete'])->name('destroy');
    });
});

Route::name("downtime.")->prefix("downtime")->group(function ($router) {
    Route::middleware(['adminRoutes'])->group(function () {
        Route::get('/', [adminDownTimeController::class, 'indexDownTime'])->name('index');
        Route::get('/filter', [adminDownTimeController::class, 'filterDownTime'])->name('filter');
    });
});

Route::name("cars.")->prefix("cars")->group(function ($router) {
    Route::middleware(['adminRoutes'])->group(function () {
        Route::get('/', [adminCarController::class, 'index'])->name('index');
        Route::get('/create', [adminCarController::class, 'create'])->name('create');
        Route::post('/store', [adminCarController::class, 'store'])->name('store');
        Route::get('/edit/{car}', [adminCarController::class, 'edit'])->name('edit');
        Route::put('/update/{car}', [adminCarController::class, 'update'])->name('update');
        Route::delete('/delete/{car}', [adminCarController::class, 'delete'])->name('destroy');
    });
});

Route::name("itps.")->prefix("itp")->group(function ($router) {
    Route::middleware(['adminRoutes'])->group(function () {
        Route::get('/', [adminItpController::class, 'index'])->name('index');
        Route::get('/create', [adminItpController::class, 'create'])->name('create');
        Route::post('/store', [adminItpController::class, 'store'])->name('store');
        Route::get('/edit/{itp}', [adminItpController::class, 'edit'])->name('edit');
        Route::put('/update/{itp}', [adminItpController::class, 'update'])->name('update');
        Route::delete('/delete/{itp}', [adminItpController::class, 'delete'])->name('destroy');
    });
});

Route::name("shifts.")->prefix("shift")->group(function ($router) {
    Route::middleware(['adminRoutes'])->group(function () {
        Route::get('/', [adminShiftController::class, 'index'])->name('index');
        Route::get('/create', [adminShiftController::class, 'create'])->name('create');
        Route::post('/store', [adminShiftController::class, 'store'])->name('store');
        Route::get('/edit/{shift}', [adminShiftController::class, 'edit'])->name('edit');
        Route::put('/update/{shift}', [adminShiftController::class, 'update'])->name('update');
        Route::delete('/delete/{shift}', [adminShiftController::class, 'delete'])->name('destroy');
    });
});

Route::name("bp.")->prefix("bp")->group(function ($router) {
    Route::middleware(['adminRoutes'])->group(function () {
        Route::name("proccessControl.")->prefix("proccessControl")->group(function ($router) {
            Route::get('/', [adminBpController::class, 'index'])->name('index');
            Route::get('/filter', [adminBpController::class, 'filter'])->name('filter');
        });
        Route::name("pengendalianSlip.")->prefix("pengendalianSlip")->group(function ($router) {
            Route::get('/', [adminBpController::class, 'indexPengendalianSlip'])->name('index');
            Route::get('/filter', [adminBpController::class, 'filterPengendalianSlip'])->name('filter');
            Route::get('/edit/{pengendalianSlip}', [adminBpController::class, 'editPengendalianSlip'])->name('edit');
            Route::put('/update/{pengendalianSlip}', [adminBpController::class, 'updatePengendalianSlip'])->name('update');
            Route::delete('/delete/{pengendalianSlip}', [adminBpController::class, 'deletePengendalianSlip'])->name('destroy');
        });
        Route::name("pengendalianPowder.")->prefix("pengendalianPowder")->group(function ($router) {
            Route::get('/', [adminBpController::class, 'indexPengendalianPowder'])->name('index');
            Route::get('/filter', [adminBpController::class, 'filterPengendalianPowder'])->name('filter');
            Route::get('/detail/{pengendalianPowder}', [adminBpController::class, 'detailPengendalianPowder'])->name('detail');
            Route::get('/edit/{pengendalianPowder}', [adminBpController::class, 'editPengendalianPowder'])->name('edit');
            Route::put('/update/{pengendalianPowder}', [adminBpController::class, 'updatePengendalianPowder'])->name('update');
            Route::delete('/delete/{pengendalianPowder}', [adminBpController::class, 'deletePengendalianPowder'])->name('destroy');
        });
        Route::name("rekapSlip.")->prefix("rekapSlip")->group(function ($router) {
            Route::get('/', [adminBpController::class, 'indexRekapSlip'])->name('index');
            Route::get('/filter', [adminBpController::class, 'filterRekapSlip'])->name('filter');
            Route::get('/edit/{rekapSlip}', [adminBpController::class, 'editRekapSlip'])->name('edit');
            Route::put('/update/{rekapSlip}', [adminBpController::class, 'updateRekapSlip'])->name('update');
            Route::delete('/delete/{rekapSlip}', [adminBpController::class, 'deleteRekapSlip'])->name('destroy');
        });
        Route::name("rekapPowder.")->prefix("rekapPowder")->group(function ($router) {
            Route::get('/', [adminBpController::class, 'indexRekapPowder'])->name('index');
            Route::get('/filter', [adminBpController::class, 'filterRekapPowder'])->name('filter');
            Route::get('/edit/{rekapPowder}', [adminBpController::class, 'editRekapPowder'])->name('edit');
            Route::put('/update/{rekapPowder}', [adminBpController::class, 'updateRekapPowder'])->name('update');
            Route::delete('/delete/{rekapPowder}', [adminBpController::class, 'deleteRekapPowder'])->name('destroy');
        });
    });
});

Route::name("ph.")->prefix("ph")->group(function ($router) {
    Route::middleware(['adminRoutes'])->group(function () {
        Route::name("proccessControl.")->prefix("proccessControl")->group(function ($router) {
            Route::get('/', [adminPhController::class, 'index'])->name('index');
            Route::get('/filter', [adminPhController::class, 'filter'])->name('filter');
        });
        Route::name("control.")->prefix("control")->group(function ($router) {
            Route::get('/', [adminPhController::class, 'indexControl'])->name('index');
            Route::get('/filter', [adminPhController::class, 'filterControls'])->name('filter');
            Route::get('/edit/{control}', [adminPhController::class, 'editControl'])->name('edit');
            Route::put('/update/{control}', [adminPhController::class, 'updateControl'])->name('update');
            Route::delete('/delete/{control}', [adminPhController::class, 'deleteControl'])->name('destroy');
        });
        Route::name("dimensi.")->prefix("dimensi")->group(function ($router) {
            Route::get('/', [adminPhController::class, 'indexDimensi'])->name('index');
            Route::get('/detail/{dimensi}', [adminPhController::class, 'detailDimensi'])->name('detail');
            Route::get('/filter', [adminPhController::class, 'filterDimensi'])->name('filter');
            Route::get('/edit/{dimensi}', [adminPhController::class, 'editDimensi'])->name('edit');
            Route::put('/update/{dimensi}', [adminPhController::class, 'updateDimensi'])->name('update');
            Route::delete('/delete/{dimensi}', [adminPhController::class, 'deleteDimensi'])->name('destroy');
        });
        Route::name("counter.")->prefix("counter")->group(function ($router) {
            Route::get('/', [adminPhController::class, 'indexCounter'])->name('index');
            Route::get('/filter', [adminPhController::class, 'filterCounter'])->name('filter');
            Route::get('/edit/{counter}', [adminPhController::class, 'editCounter'])->name('edit');
            Route::put('/update/{counter}', [adminPhController::class, 'updateCounter'])->name('update');
            Route::delete('/delete/{counter}', [adminPhController::class, 'deleteCounter'])->name('destroy');
        });
        Route::name("tebal.")->prefix("tebal")->group(function ($router) {
            Route::get('/', [adminPhController::class, 'indexTebal'])->name('index');
            Route::get('/detail/{tebal}', [adminPhController::class, 'detailTebal'])->name('detail');
            Route::get('/filter', [adminPhController::class, 'filterTebal'])->name('filter');
            Route::get('/edit/{tebal}', [adminPhController::class, 'editTebal'])->name('edit');
            Route::put('/update/{tebal}', [adminPhController::class, 'updateTebal'])->name('update');
            Route::delete('/delete/{tebal}', [adminPhController::class, 'deleteTebal'])->name('destroy');
        });
        Route::name("dryer.")->prefix("dryer")->group(function ($router) {
            Route::get('/', [adminPhController::class, 'indexDryer'])->name('index');
            Route::get('/filter', [adminPhController::class, 'filterDryer'])->name('filter');
            Route::get('/edit/{dryer}', [adminPhController::class, 'editDryer'])->name('edit');
            Route::put('/update/{dryer}', [adminPhController::class, 'updateDryer'])->name('update');
            Route::delete('/delete/{dryer}', [adminPhController::class, 'deleteDryer'])->name('destroy');
        });
        Route::name("temps.")->prefix("temps")->group(function ($router) {
            Route::get('/', [adminPhController::class, 'indexTemp'])->name('index');
            Route::get('/filter', [adminPhController::class, 'filterTemp'])->name('filter');
            Route::get('/edit/{temp}', [adminPhController::class, 'editTemp'])->name('edit');
            Route::put('/update/{temp}', [adminPhController::class, 'updateTemp'])->name('update');
            Route::delete('/delete/{temp}', [adminPhController::class, 'deleteTemp'])->name('destroy');
        });
    });
});

Route::name("rk.")->prefix("rk")->group(function ($router) {
    Route::middleware(['adminRoutes'])->group(function () {
        Route::name("proccessControl.")->prefix("proccessControl")->group(function ($router) {
            Route::get('/', [adminRkController::class, 'index'])->name('index');
            Route::get('/filter', [adminRkController::class, 'filter'])->name('filter');
        });
        Route::name("unloading.")->prefix("unloading")->group(function ($router) {
            Route::get('/', [adminRkController::class, 'indexUnloading'])->name('index');
            Route::get('/filter', [adminRkController::class, 'filterUnloading'])->name('filter');
            Route::get('/recap', [adminRkController::class, 'recapUnloading'])->name('recap');
            Route::get('/recap/filter', [adminRkController::class, 'recapUnloadingFilter'])->name('filterRecap');
            Route::get('/edit/{unloading}', [adminRkController::class, 'editUnloading'])->name('edit');
            Route::put('/update/{unloading}', [adminRkController::class, 'updateUnloading'])->name('update');
            Route::delete('/delete/{unloading}', [adminRkController::class, 'deleteUnloading'])->name('destroy');
        });
        Route::name("loading.")->prefix("loading")->group(function ($router) {
            Route::get('/', [adminRkController::class, 'indexloading'])->name('index');
            Route::get('/filter', [adminRkController::class, 'filterLoading'])->name('filter');
            Route::get('/recap', [adminRkController::class, 'recapLoading'])->name('recap');
            Route::get('/recap/filter', [adminRkController::class, 'recapLoadingFilter'])->name('filterRecap');
            Route::get('/edit/{loading}', [adminRkController::class, 'editLoading'])->name('edit');
            Route::put('/update/{loading}', [adminRkController::class, 'updateLoading'])->name('update');
            Route::delete('/delete/{loading}', [adminRkController::class, 'deleteLoading'])->name('destroy');
        });
        Route::name("pengendalian.")->prefix("pengendalian")->group(function ($router) {
            Route::get('/', [adminRkController::class, 'indexPengendalian'])->name('index');
            Route::get('/filter', [adminRkController::class, 'filterPengendalian'])->name('filter');
            Route::get('/edit/{pengendalian}', [adminRkController::class, 'editPengendalian'])->name('edit');
            Route::put('/update/{pengendalian}', [adminRkController::class, 'updatePengendalian'])->name('update');
            Route::delete('/delete/{pengendalian}', [adminRkController::class, 'deletePengendalian'])->name('destroy');
        });
        Route::name("cek.")->prefix("cek")->group(function ($router) {
            Route::get('/', [adminRkController::class, 'indexCek'])->name('index');
            Route::get('/filter', [adminRkController::class, 'filterCek'])->name('filter');
            Route::get('/edit/{cek}', [adminRkController::class, 'editCek'])->name('edit');
            Route::put('/update/{cek}', [adminRkController::class, 'updateCek'])->name('update');
            Route::delete('/delete/{cek}', [adminRkController::class, 'deleteCek'])->name('destroy');
        });
        Route::name("koreksi.")->prefix("koreksi")->group(function ($router) {
            Route::get('/', [adminRkController::class, 'indexKoreksi'])->name('index');
            Route::get('/filter', [adminRkController::class, 'filterKoreksi'])->name('filter');
            Route::get('/detail/{koreksi}', [adminRkController::class, 'detailKoreksi'])->name('detail');
            Route::get('/edit/{koreksi}', [adminRkController::class, 'editKoreksi'])->name('edit');
            Route::put('/update/{koreksi}', [adminRkController::class, 'updateKoreksi'])->name('update');
            Route::delete('/delete/{koreksi}', [adminRkController::class, 'deleteKoreksi'])->name('destroy');
        });
    });
});

Route::name("gl.")->prefix("gl")->group(function ($router) {
    Route::middleware(['adminRoutes'])->group(function () {
        Route::name("proccessControl.")->prefix("proccessControl")->group(function ($router) {
            Route::get('/', [adminGlController::class, 'index'])->name('index');
            Route::get('/filter', [adminGlController::class, 'filter'])->name('filter');
        });
        Route::name("analisa.")->prefix("analisa")->group(function ($router) {
            Route::get('/', [adminGlController::class, 'indexAnalisa'])->name('index');
            Route::get('/filter', [adminGlController::class, 'filterAnalisa'])->name('filter');
            Route::get('/edit/{analisa}', [adminGlController::class, 'editAnalisa'])->name('edit');
            Route::put('/update/{analisa}', [adminGlController::class, 'updateAnalisa'])->name('update');
            Route::delete('/delete/{analisa}', [adminGlController::class, 'deleteAnalisa'])->name('destroy');
        });
        Route::name("pengendalian.")->prefix("pengendalian")->group(function ($router) {
            Route::get('/', [adminGlController::class, 'indexPengendalian'])->name('index');
            Route::get('/filter', [adminGlController::class, 'filterPengendalian'])->name('filter');
            Route::get('/edit/{pengendalian}', [adminGlController::class, 'editPengendalian'])->name('edit');
            Route::put('/update/{pengendalian}', [adminGlController::class, 'updatePengendalian'])->name('update');
            Route::delete('/delete/{pengendalian}', [adminGlController::class, 'deletePengendalian'])->name('destroy');
        });
        Route::name("loading.")->prefix("loading")->group(function ($router) {
            Route::get('/', [adminGlController::class, 'indexloading'])->name('index');
            Route::get('/filter', [adminGlController::class, 'filterLoading'])->name('filter');
            Route::get('/recap', [adminGlController::class, 'recapLoading'])->name('recap');
            Route::get('/recap/filter', [adminGlController::class, 'recapFilter'])->name('filterRecap');
            Route::get('/edit/{loading}', [adminGlController::class, 'editLoading'])->name('edit');
            Route::put('/update/{loading}', [adminGlController::class, 'updateLoading'])->name('update');
            Route::delete('/delete/{loading}', [adminGlController::class, 'deleteLoading'])->name('destroy');
        });
    });
});

Route::name("sr.")->prefix("sr")->group(function ($router) {
    Route::middleware(['adminRoutes'])->group(function () {
        Route::name("proccessControl.")->prefix("proccessControl")->group(function ($router) {
            Route::get('/', [adminSrController::class, 'index'])->name('index');
            Route::get('/filter', [adminSrController::class, 'filter'])->name('filter');
        });
        Route::name("hasilProduksi.")->prefix("hasilProduksi")->group(function ($router) {
            Route::get('/', [adminSrController::class, 'indexHasilProduksi'])->name('index');
            Route::get('/filter', [adminSrController::class, 'filterHasilProduksi'])->name('filter');
            Route::get('/edit/{hasilProduksi}', [adminSrController::class, 'editHasilProduksi'])->name('edit');
            Route::put('/update/{hasilProduksi}', [adminSrController::class, 'updateHasilProduksi'])->name('update');
            Route::delete('/delete/{hasilProduksi}', [adminSrController::class, 'deleteHasilProduksi'])->name('destroy');
        });
        Route::name("hasilSortir.")->prefix("hasilSortir")->group(function ($router) {
            Route::get('/', [adminSrController::class, 'indexHasilSortir'])->name('index');
            Route::get('/filter', [adminSrController::class, 'filterHasilSortir'])->name('filter');
            Route::get('/edit/{hasilSortir}', [adminSrController::class, 'editHasilSortir'])->name('edit');
            Route::put('/update/{hasilSortir}', [adminSrController::class, 'updateHasilSortir'])->name('update');
            Route::delete('/delete/{hasilSortir}', [adminSrController::class, 'deleteHasilSortir'])->name('destroy');
        });
        Route::name("cekMesin.")->prefix("cekMesin")->group(function ($router) {
            Route::get('/', [adminSrController::class, 'indexCekMesin'])->name('index');
            Route::get('/filter', [adminSrController::class, 'filterCekMesin'])->name('filter');
            Route::get('/edit/{cekMesin}', [adminSrController::class, 'editCekMesin'])->name('edit');
            Route::put('/update/{cekMesin}', [adminSrController::class, 'updateCekMesin'])->name('update');
            Route::delete('/delete/{cekMesin}', [adminSrController::class, 'deleteCekMesin'])->name('destroy');
        });
        Route::name("unloading.")->prefix("unloading")->group(function ($router) {
            Route::get('/', [adminSrController::class, 'indexUnloading'])->name('index');
            Route::get('/filter', [adminSrController::class, 'filterUnloading'])->name('filter');
            Route::get('/recap', [adminSrController::class, 'recapUnloading'])->name('recap');
            Route::get('/recap/filter', [adminSrController::class, 'recapUnloadingFilter'])->name('filterRecap');
            Route::get('/edit/{unloading}', [adminSrController::class, 'editUnloading'])->name('edit');
            Route::put('/update/{unloading}', [adminSrController::class, 'updateUnloading'])->name('update');
            Route::delete('/delete/{unloading}', [adminSrController::class, 'deleteUnloading'])->name('destroy');
        });
    });
});
