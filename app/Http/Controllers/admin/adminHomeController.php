<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\down_time;
use App\Models\gl_hasil_produksi;
use App\Models\hasil_sortir_api;
use App\Models\rk_hasil_produksi;
use App\Http\Controllers\admin\adminDownTimeController;
use App\Models\sr_analisa_kualitas;
use App\Models\target_saps;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class adminHomeController extends Controller
{
    protected $periode;
    protected $weeklyPeriode;



    public function add(Request $request)
    {
        try {
            set_time_limit(360000);
            ini_set('max_execution_time', 360000);

            // Get the date range from the request
            $date_start = $request->date_start;
            $date_end = $request->date_end;

            // Fetch data from the API
            $response = Http::timeout(360000)
                ->get('http://172.31.3.13/ci-milan-restserver/index.php/HasilSortir', [
                    'prdplant' => '5011',
                    'tgll' => $date_start, // Insert $date_start
                    'tglh' => $date_end,   // Insert $date_end
                ]);

            // Decode the API response
            $data = $response->body();
            $hasilSortir = json_decode($data);

            if (!empty($hasilSortir)) {
                foreach ($hasilSortir as $item) {
                    // Check if the record already exists in the local database
                    $existingRecord = hasil_sortir_api::where('AUFNR', $item->AUFNR)
                        ->where('MATNR', $item->MATNR)
                        ->where('MBLNR', $item->MBLNR)
                        ->where('MJAHR', $item->MJAHR)
                        ->first();

                    if ($existingRecord) {
                        // Compare the fields to check if there are any differences
                        $isDifferent = false;
                        $fieldsToCompare = [
                            'WERKS',
                            'LGORT',
                            'BWART',
                            'MENGE',
                            'ERFMG',
                            'ERFME',
                            'MAKTX',
                            'BUDAT',
                            'WRHZET',
                            'ARBPL',
                            'MVGR4',
                            'IDNRK'
                        ];

                        foreach ($fieldsToCompare as $field) {
                            if ($existingRecord->$field != $item->$field) {
                                $isDifferent = true;
                                break;
                            }
                        }

                        // If there are differences, update the record
                        if ($isDifferent) {
                            $existingRecord->update([
                                'WERKS' => $item->WERKS,
                                'LGORT' => $item->LGORT,
                                'BWART' => $item->BWART,
                                'MENGE' => $item->MENGE,
                                'ERFMG' => $item->ERFMG,
                                'ERFME' => $item->ERFME,
                                'MAKTX' => $item->MAKTX,
                                'BUDAT' => $item->BUDAT,
                                'WRHZET' => $item->WRHZET,
                                'ARBPL' => $item->ARBPL,
                                'MVGR4' => $item->MVGR4,
                                'IDNRK' => $item->IDNRK,
                            ]);
                        }
                    } else {
                        // If the record does not exist, create a new one
                        hasil_sortir_api::create([
                            'AUFNR' => $item->AUFNR,
                            'MATNR' => $item->MATNR,
                            'WERKS' => $item->WERKS,
                            'LGORT' => $item->LGORT,
                            'BWART' => $item->BWART,
                            'MENGE' => $item->MENGE,
                            'ERFMG' => $item->ERFMG,
                            'ERFME' => $item->ERFME,
                            'MAKTX' => $item->MAKTX,
                            'MBLNR' => $item->MBLNR,
                            'MJAHR' => $item->MJAHR,
                            'BUDAT' => $item->BUDAT,
                            'WRHZET' => $item->WRHZET,
                            'ARBPL' => $item->ARBPL,
                            'MVGR4' => $item->MVGR4,
                            'IDNRK' => $item->IDNRK,
                        ]);
                    }
                }
            }

            return response()->json(['status' => 'completed', 'hasil' => sizeof($hasilSortir)]);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    public function addHasilKiln(Request $request)
    {
        set_time_limit(36000);
        ini_set('max_execution_time', 36000);
        // Get the date range from the request
        $date_start = $request->date_start;
        $date_end = $request->date_end;

        // Fetch data from the API
        $response = Http::timeout(120000)
            ->get("http://172.31.3.13/ci-milan-restserver/index.php/HasilKiln", [
                'tgll' => $date_start,
                'tglh' => $date_end,
            ]);

        // Decode the API response
        $data = $response->body();
        $hasilKiln = json_decode($data);
        if (!empty($hasilKiln)) {
            foreach ($hasilKiln as $item) {
                // Check if the record already exists in the local database
                $existingRecord = rk_hasil_produksi::where('order_id', intval($item->AUFNR))
                    ->where('kode_material', intval($item->MATNR))
                    ->where('mesin_id', 'RK ' . Str::substr($item->VERID, -2))
                    ->first();

                if ($existingRecord) {
                    // Compare the fields to check if there are any differences
                    $isDifferent = false;
                    $fieldsToCompare = [
                        'size' => $item->BEZEI5,
                        'jenis' => $item->BEZEI1,
                        'jumlah' => $item->MENGE,
                        'created_at' => Carbon::createFromFormat('Ymd', $item->BUDAT),
                    ];

                    foreach ($fieldsToCompare as $field => $value) {
                        if ($existingRecord->$field != $value) {
                            $isDifferent = true;
                            break;
                        }
                    }

                    // If there are differences, update the record
                    if ($isDifferent) {
                        $existingRecord->update([
                            'size' => $item->BEZEI5,
                            'jenis' => $item->BEZEI1,
                            'jumlah' => $existingRecord->jumlah + $item->MENGE,
                            'created_at' => Carbon::createFromFormat('Ymd', $item->BUDAT),
                            'updated_at' => Carbon::now(),
                        ]);
                    }
                } else {
                    // If the record does not exist, create a new one
                    DB::table('rk_hasil_produksis')->insert([
                        'shift_id' => 1,
                        'order_id' => intval($item->AUFNR),
                        'user_id' => 10,
                        'kode_material' => intval($item->MATNR),
                        'mesin_id' => 'RK ' . Str::substr($item->VERID, -2),
                        'lane' => '',
                        'size' => $item->BEZEI5,
                        'jenis' => $item->BEZEI1,
                        'from' => 'Car',
                        'no' => '3',
                        'outKiln' => '0',
                        'start' => '00:00',
                        'stop' => '00:00',
                        'menit' => '0 Menit',
                        'jumlah' => $item->MENGE,
                        'created_at' => Carbon::createFromFormat('Ymd', $item->BUDAT)->toDateTimeString(),
                    ]);
                }
            }
        }

        return response()->json(['status' => 'completed']);
    }

    public function getProgress()
    {

        return response()->json(['progress' => Session::get('progress', 0)]);
    }

    private function getDowntimeByMachine()
    {
        //$periode = $this->getDefaultPeriode();
        // $startDate = $this->periode['startDate'];
        // $endDate = $this->periode['endDate'];

        $downtimeByMachine = down_time::select('work_center', DB::raw('SUM(total) as downTime'))
            ->whereBetween('created_at', [$this->periode['startDate'], $this->periode['endDate']])
            ->groupBy('work_center')
            ->get();
        return $downtimeByMachine;
    }

    private function getDowntimeByType()
    {
        // $startDate = Carbon::create(2024, 5, 1, 0, 0, 0);
        // $endDate = Carbon::create(2024, 5, 31, 23, 59, 59);
        $downtimeByType = down_time::select('work_center', 'grund', DB::raw('SUM(total) as downTime'))
            ->whereBetween('created_at', [$this->periode['startDate'], $this->periode['endDate']])
            ->groupBy('work_center', 'grund')
            ->get();

        return $downtimeByType;
    }

    private function getAvailabilityByMachine()
    {
        $DowntimeByMachine = $this->getDowntimeByMachine();
        $planProdDay = $this->periode['totalDays'];
        $planProdTime = 1440; //minutes of 24hour

        $sumPlanProdTime = $planProdDay * $planProdTime;
        $availabilityByMachine = [];
        foreach ($DowntimeByMachine as $rowDowntimeByMachine) {
            $operatingTime = $sumPlanProdTime - $rowDowntimeByMachine->downTime;
            $availability = number_format($operatingTime / $sumPlanProdTime * 100, 2);

            $data =
                [
                    'work_center' =>  $rowDowntimeByMachine['work_center'],
                    'planProdTime' =>  $sumPlanProdTime,
                    'downTime' => $rowDowntimeByMachine['downTime'],
                    'operatingTime' => $operatingTime,
                    'availability' => $availability,
                ];

            $availabilityByMachine[] = $data;
        }
        // dd($availabilityByMachine);
        return $availabilityByMachine;
    }

    private function getDetailAvailabilityByType()
    {
        $downtimeByMachine = $this->getDowntimeByMachine();
        $downtimeByType = $this->getDowntimeByType();
        $detailAvailabilityByType = [];
        foreach ($downtimeByMachine as $rowDowntimeByMachine) {
            foreach ($downtimeByType as $rowDowntimeByType) {
                if ($rowDowntimeByType['work_center'] == $rowDowntimeByMachine['work_center']) {
                    if ($rowDowntimeByMachine['downTime'] == 0) {
                        $downTimePercent = 0;
                    } else {
                        $downTimePercent = number_format($rowDowntimeByType['downTime'] / $rowDowntimeByMachine['downTime'] * 100, 2);
                        $data =
                            [
                                'work_center' =>  $rowDowntimeByType['work_center'],
                                'grund' =>  $rowDowntimeByType['grund'],
                                'downTime' => $rowDowntimeByType['downTime'],
                                'downTimePercent' => $downTimePercent,
                            ];

                        $detailAvailabilityByType[] = $data;
                    }
                }
            }
        }
        //dd($detailAvailabilityByType);
        return $detailAvailabilityByType;
    }

    private function getSumAvailability()
    {
        $availabilityByMachine = $this->getavailabilityByMachine();
        $cavailabilityByMachine = collect($availabilityByMachine);
        if ($cavailabilityByMachine->count() == 0) {
            return 0;
        }
        $sumAvailability = $cavailabilityByMachine->sum('availability') / $cavailabilityByMachine->count();
        $sumAvailability = number_format($sumAvailability, 2);
        //dd($sumAvailability);
        return $sumAvailability;
    }

    private function getHasilKilnByMachine()
    {
        // $startDate = Carbon::create(2024, 5, 1, 0, 0, 0);
        // $endDate = Carbon::create(2024, 5, 31, 23, 59, 59);

        $hasilKilnByMachine = rk_hasil_produksi::select('rk_hasil_produksis.mesin_id', DB::raw('SUM(rk_hasil_produksis.jumlah) as hasil'), DB::raw('SUM(rk_hasil_produksis.jumlah/target_saps.ipb) as hasilm2'), DB::raw('SUM(rk_hasil_produksis.jumlah/target_saps.pcs_per_hour*60) as operatingTime'))
            ->leftJoin('target_saps', function ($join) {
                $join->on('rk_hasil_produksis.mesin_id', '=', 'target_saps.kiln')
                    ->on('rk_hasil_produksis.size', '=', 'target_saps.size');
            })
            ->whereBetween('rk_hasil_produksis.created_at', [$this->periode['startDate'], $this->periode['endDate']])
            ->groupBy('mesin_id')
            ->get();

        return $hasilKilnByMachine;
    }

    private function getHasilKilnBySize()
    {
        // $startDate = Carbon::create(2024, 5, 1, 0, 0, 0);
        // $endDate = Carbon::create(2024, 5, 31, 23, 59, 59);

        $hasilKilnBySize = rk_hasil_produksi::select('rk_hasil_produksis.mesin_id', 'rk_hasil_produksis.size', DB::raw('SUM(rk_hasil_produksis.jumlah) as hasil'), DB::raw('SUM(rk_hasil_produksis.jumlah/target_saps.pcs_per_hour*60) as operatingTime'))
            ->leftJoin('target_saps', function ($join) {
                $join->on('rk_hasil_produksis.mesin_id', '=', 'target_saps.kiln')
                    ->on('rk_hasil_produksis.size', '=', 'target_saps.size');
            })
            ->whereBetween('created_at', [$this->periode['startDate'], $this->periode['endDate']])
            ->groupBy('mesin_id', 'size')
            ->get();
        //dd($hasilKilnBySize);
        return $hasilKilnBySize;
    }

    private function getHasilKilnByMachineWeek()
    {
        $hasilKilnByMachineWeek = [];
        foreach ($this->weeklyPeriode as $week) {
            $hasilKilnByMachineWeek[] = rk_hasil_produksi::select('rk_hasil_produksis.mesin_id', DB::raw('SUM(rk_hasil_produksis.jumlah) as hasilpcs'), DB::raw('SUM(rk_hasil_produksis.jumlah/target_saps.ipb) as hasilm2'), DB::raw('SUM(target_saps.ipb) as hasil'))
                ->leftJoin('target_saps', function ($join) {
                    $join->on('rk_hasil_produksis.mesin_id', '=', 'target_saps.kiln')
                        ->on('rk_hasil_produksis.size', '=', 'target_saps.size');
                })
                ->whereBetween('created_at', [$week['startWeek'], $week['endWeek']])
                ->groupBy('mesin_id')
                ->get();
        }
        return $hasilKilnByMachineWeek;
    }

    private function getPerformanceByMachine()
    {
        $hasilKilnByMachine = $this->getHasilKilnByMachine();
        $availabilityByMachine = $this->getAvailabilityByMachine();

        // dd($hasilKilnByMachine);
        $performanceByMachine = [];
        foreach ($hasilKilnByMachine as $rowhasilKilnByMachine) {
            foreach ($availabilityByMachine as $rowavailabilityByMachine) {
                if ($rowavailabilityByMachine['work_center'] === $rowhasilKilnByMachine['mesin_id']) {
                    if ($rowavailabilityByMachine['operatingTime'] == 0) {
                        $performance = 0;
                    } else {
                        $performance = $rowhasilKilnByMachine['operatingTime'] / $rowavailabilityByMachine['operatingTime'] * 100;
                        $data =
                            [
                                'work_center' =>  $rowavailabilityByMachine['work_center'],
                                'hasil' =>  $rowhasilKilnByMachine['hasil'],
                                'kilnOperatingTime' => number_format($rowhasilKilnByMachine['operatingTime'], 2),
                                'actualOperatingTime' => number_format($rowavailabilityByMachine['operatingTime'], 2),
                                'performance' => number_format($performance, 2),
                            ];
                        $performanceByMachine[] = $data;
                    }
                }
            }
        }
        // dd($performanceByMachine);
        return $performanceByMachine;
    }

    private function getDetailPerformanceBySize()
    {
        $hasilKilnByMachine = $this->getHasilKilnByMachine();
        $hasilKilnBySize = $this->getHasilKilnBySize();

        $detailPerformanceBySize = [];
        foreach ($hasilKilnByMachine as $rowhasilKilnByMachine) {
            foreach ($hasilKilnBySize as $rowhasilKilnBySize) {
                if ($rowhasilKilnBySize['mesin_id'] == $rowhasilKilnByMachine['mesin_id']) {
                    if ($rowhasilKilnByMachine['hasil'] == 0) {
                        $hasilPercent = 0;
                    } else {
                        $hasilPercent = number_format($rowhasilKilnBySize['hasil'] / $rowhasilKilnByMachine['hasil'] * 100, 2);
                        $data =
                            [
                                'work_center' =>  $rowhasilKilnBySize['mesin_id'],
                                'size' =>  $rowhasilKilnBySize['size'],
                                'hasil' => $rowhasilKilnBySize['hasil'],
                                'hasilPercent' => $hasilPercent,
                            ];

                        $detailPerformanceBySize[] = $data;
                    }
                }
            }
        }
        //dd($detailPerformanceBySize);
        return $detailPerformanceBySize;
    }

    private function getSumPerformance()
    {
        $performanceByMachine = $this->getperformanceByMachine();
        $cperformanceByMachine = collect($performanceByMachine);
        if ($cperformanceByMachine->count() == 0) {
            return 0;
        }
        $sumPerformance = $cperformanceByMachine->sum('performance') / $cperformanceByMachine->count();
        $sumPerformance = number_format($sumPerformance, 2);
        //dd($sumPerformance);
        return $sumPerformance;
    }

    private function getHasilSortir()
    {
        // $startDate = Carbon::create(2024, 5, 1, 0, 0, 0);
        // $endDate = Carbon::create(2024, 5, 31, 23, 59, 59);
        $hasilSortir = hasil_sortir_api::whereBetween(DB::raw("STR_TO_DATE(BUDAT, '%Y%m%d')"), [$this->periode['startDate'], $this->periode['endDate']])
            ->get();
        //dd($hasilSortir);
        return $hasilSortir;
    }

    private function getHasilSortirbyWeek()
    {
        $hasilSortirbyWeek = [];
        foreach ($this->weeklyPeriode as $week) {
            $hasilSortirbyWeek[] = hasil_sortir_api::select(DB::raw('SUM(MENGE) as hasilPcs'), DB::raw('SUM(ERFMG) as hasilBox'))
                ->whereBetween(DB::raw("STR_TO_DATE(BUDAT, '%Y%m%d')"), [$week['startWeek'], $week['endWeek']])
                //->groupBy('MVGR4')
                ->get();
        }
        //dd($hasilSortirbyWeek);
        return $hasilSortirbyWeek;
    }

    private function getHasilSortirbyQualityWeek()
    {
        $hasilSortirbyQualityWeek = [];
        foreach ($this->weeklyPeriode as $week) {
            $hasilSortirbyQualityWeek[] = hasil_sortir_api::select('MVGR4', DB::raw('SUM(MENGE) as hasilPerKwPcs'), DB::raw('SUM(ERFMG) as hasilPerKwBox'))
                ->whereBetween(DB::raw("STR_TO_DATE(BUDAT, '%Y%m%d')"), [$week['startWeek'], $week['endWeek']])
                ->groupBy('MVGR4')
                ->get();
        }
        //dd($hasilSortirbyQualityWeek);
        return $hasilSortirbyQualityWeek;
    }

    private function getHasilSortirbyGradeSizeMotive()
    {
        $hasilSortirbyGradeSizeMotive = DB::table('hasil_sortir_apis')
            ->selectRaw('MVGR4, UPPER(REGEXP_SUBSTR(MAKTX, "[0-9]+x[0-9]+")) as size, MATNR, MAKTX, COUNT(MATNR) as dataCount, SUM(MENGE) as hasilPcs, SUM(ERFMG) as hasilBox')
            ->whereBetween(DB::raw("STR_TO_DATE(BUDAT, '%Y%m%d')"), [$this->periode['startDate'], $this->periode['endDate']])
            ->groupBy('MVGR4', 'size', 'MATNR')
            ->get();
        //dd($hasilSortirbyGradeSizeMotive);
        return $hasilSortirbyGradeSizeMotive;
    }

    public function getHasilSortirWeekReport()
    {
        $hasilSortirbyWeek = $this->getHasilSortirbyWeek();
        $hasilSortirbyQualityWeek = $this->getHasilSortirbyQualityWeek();
        $hasilSortirWeekReport = [];
        $i = 0;
        foreach ($hasilSortirbyQualityWeek as $rowhasilSortirbyQualityWeek) {
            $hasilPcs = $hasilSortirbyWeek[$i][0]['hasilPcs'];
            $hasilBox = $hasilSortirbyWeek[$i][0]['hasilBox'];
            //dd($hasilTotal);
            $data = [];
            foreach ($rowhasilSortirbyQualityWeek as $item) {
                $data[] =
                    [
                        'KW' =>  $item['MVGR4'],
                        'hasilPcs' => $hasilPcs,
                        'hasilBox' => $hasilBox,
                        'hasilPerKwPcs' => $item['hasilPerKwPcs'],
                        'hasilPerKwBox' => $item['hasilPerKwBox'],
                        'hasilPercentPcs' =>  number_format($item['hasilPerKwPcs'] / $hasilPcs * 100, 2),
                        'hasilPercentBox' =>  number_format($item['hasilPerKwBox'] / $hasilBox * 100, 2),
                    ];
            }
            $hasilSortirWeekReport[] = $data;
            $i++;
        }
        //dd($hasilSortirWeekReport);
        return $hasilSortirWeekReport;
    }

    private function getMappingSortirKiln()
    {
        // $startDate = Carbon::create(2024, 5, 1, 0, 0, 0);
        // $endDate = Carbon::create(2024, 5, 31, 23, 59, 59);
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
        $mappingSortirKiln = DB::table('rk_hasil_produksis as r')
            ->leftJoin('target_saps as ts', function ($join) {
                $join->on('r.mesin_id', '=', 'ts.kiln')
                    ->on('r.size', '=', 'ts.size');
            })
            ->select('r.mesin_id', 'r.size', 'r.kode_material', 'ts.pcs_per_hour')
            ->whereBetween('r.created_at', [$this->periode['startDate'], $this->periode['endDate']])
            ->groupBy('r.kode_material')
            ->get();
        // dd($mappingSortirKiln);
        return $mappingSortirKiln;
    }

    private function getFixHasilSortir()
    {
        $hasilSortir = $this->getHasilSortir();
        $mappingSortirKiln = $this->getMappingSortirKiln();
        //$groupHasilSortirByMachine = collect($hasilSortir)->sum('MENGE');
        //dd($groupHasilSortirByMachine);
        $fixHasilSortir = [];
        $data = [];
        $flag = false;
        $bs = 0;
        foreach ($hasilSortir as $rowhasilSortir) {
            $flag = false;
            foreach ($mappingSortirKiln as $rowmappingSortirKiln) {
                //dd($rowmappingSortirKiln->kode_material);
                if ($rowmappingSortirKiln->kode_material == ltrim($rowhasilSortir['IDNRK'], '0')) {
                    $flag = true;
                    if ($rowmappingSortirKiln->pcs_per_hour == 0) {
                        $operatingTime = 0;
                    } else {
                        $operatingTime = $rowhasilSortir['MENGE'] / $rowmappingSortirKiln->pcs_per_hour * 60;
                        $fixHasilSortir[] =
                            [
                                'work_center' =>  $rowmappingSortirKiln->mesin_id,
                                'size' => $rowmappingSortirKiln->size,
                                'operatingTime' => $operatingTime,
                                'BUDAT' => $rowhasilSortir['BUDAT'],
                                'MATNR' => $rowhasilSortir['MATNR'],
                                'MAKTX' => $rowhasilSortir['MAKTX'],
                                'MVGR4' => $rowhasilSortir['MVGR4'],
                                'MENGE' => $rowhasilSortir['MENGE'],
                                'ERFMG' => $rowhasilSortir['ERFMG'],
                                'ERFME' => $rowhasilSortir['ERFME'],
                            ];
                    }
                }
            }

            if ($flag == false) {
                /*
                $data[] =
                    [
                        'MATNR' => $rowhasilSortir['MATNR'],
                        'MENGE' => $rowhasilSortir['MENGE'],
                    ];
                */
                $bs += $rowhasilSortir['MENGE'];
            }
        }

        /*
        $group = collect($data)->groupBy('MATNR');
        $arr = [];
        foreach($group as $matnr => $item)
        {
            $sumMenge = $item->sum('MENGE');
            $arr[] =
            [
                'MATNR' =>  $matnr,
                'MENGE' =>  $sumMenge,
            ];
        }
        */
        //dd($bs);
        return $fixHasilSortir;
    }

    private function getQualityByMachine()
    {
        $fixHasilSortir = $this->getFixHasilSortir();
        $hasilKilnByMachine = $this->getHasilKilnByMachine();
        $groupHasilSortirByMachine = collect($fixHasilSortir)->groupBy('work_center');
        //$groupHasilSortirByMachine = collect($fixHasilSortir)->sum('MENGE');
        //dd($groupHasilSortirByMachine);
        $qualityByMachine = [];
        $total = 0;
        foreach ($groupHasilSortirByMachine as $work_center => $rowhasilSortirByMachine) {
            //dd($rowhasilSortirByMachine);
            //==hanya kw1 dan 2
            $sortirHasil = $rowhasilSortirByMachine->filter(function ($item) {
                return $item['MVGR4'] === 'Q01';
            })->sum('MENGE');
            $sortirHasil += $rowhasilSortirByMachine->filter(function ($item) {
                return $item['MVGR4'] === 'Q02';
            })->sum('MENGE');
            //==hanya kw1 dan 2
            $sortirOperatingTime = $rowhasilSortirByMachine->filter(function ($item) {
                return $item['MVGR4'] === 'Q01';
            })->sum('operatingTime');
            $sortirOperatingTime += $rowhasilSortirByMachine->filter(function ($item) {
                return $item['MVGR4'] === 'Q02';
            })->sum('operatingTime');
            //$sortirHasil = $rowhasilSortirByMachine->sum('MENGE');
            //$sortirOperatingTime = $rowhasilSortirByMachine->sum('operatingTime');
            //$total += $sortirHasil;
            //dd($sortirOperatingTime);
            foreach ($hasilKilnByMachine as $rowhasilKilnByMachine) {
                if ($work_center === $rowhasilKilnByMachine['mesin_id']) {
                    $quality = $sortirOperatingTime / $rowhasilKilnByMachine['operatingTime'] * 100;
                    $qualityByMachine[] =
                        [
                            'work_center' =>  $work_center,
                            'sortirHasil' => number_format($sortirHasil, 2),
                            'kilnHasil' => number_format($rowhasilKilnByMachine['hasil'], 2),
                            'sortirOperatingTime' => number_format($sortirOperatingTime, 2),
                            'kilnOperatingTime' => number_format($rowhasilKilnByMachine['operatingTime'], 2),
                            'quality' =>  number_format($quality, 2),
                        ];
                }
            }
        }
        //dd($total);
        return $qualityByMachine;
    }

    private function getDetailQualityByMachineGrade()
    {
        $fixHasilSortir = $this->getFixHasilSortir();
        $hasilKilnByMachine = $this->getHasilKilnByMachine();
        $groupHasilSortirByMachine = collect($fixHasilSortir)->groupBy('work_center');
        $groupHasilSortirByMachineGrade = [];
        foreach ($fixHasilSortir as $rowfixHasilSortir) {
            $groupHasilSortirByMachineGrade[$rowfixHasilSortir['work_center']][$rowfixHasilSortir['MVGR4']][] = $rowfixHasilSortir;
        }
        $cgroupHasilSortirByMachineGrade = collect($groupHasilSortirByMachineGrade);
        $detailQualityByMachineGrade = [];
        foreach ($cgroupHasilSortirByMachineGrade as $work_center => $MVGR4) {
            foreach ($MVGR4 as $rowMVGR4) {
                $sortirHasilByMachineGrade = collect($rowMVGR4)->sum('MENGE');
                foreach ($groupHasilSortirByMachine as $wc => $rowhasilSortirByMachine) {
                    $sortirHasilByMachine = $rowhasilSortirByMachine->sum('MENGE');
                    if ($wc == $work_center) {
                        $qualityByMachineGradePercent = $sortirHasilByMachineGrade / $sortirHasilByMachine * 100;
                        $detailQualityByMachineGrade[] =
                            [
                                'work_center' =>  $work_center,
                                'grade' =>  $rowMVGR4[0]['MVGR4'],
                                'sortirHasilByMachineGrade' => number_format($sortirHasilByMachineGrade, 2),
                                'qualityByMachineGradePercent' => number_format($qualityByMachineGradePercent, 2),
                            ];
                    }
                }
            }
        }
        //dd($detailQualityByMachineGrade);
        return $detailQualityByMachineGrade;
    }
    private function getQualityByGrade()
    {
        $hasilSortirbyGradeSizeMotive = $this->getHasilSortirbyGradeSizeMotive();
        $grouphasilSortirbyGrade = $hasilSortirbyGradeSizeMotive->groupBy('MVGR4');
        $qualityByGrade = [];

        foreach ($grouphasilSortirbyGrade as $MVGR4 => $rowgrouphasilSortirbyGrade) {
            $hasilTotalPcs = $hasilSortirbyGradeSizeMotive->sum('hasilPcs') ?: 1;
            $hasilTotalBox = $hasilSortirbyGradeSizeMotive->sum('hasilBox') ?: 1;

            $hasilGradePcs = $rowgrouphasilSortirbyGrade->sum('hasilPcs');
            $hasilGradeBox = $rowgrouphasilSortirbyGrade->sum('hasilBox');

            $hasilGradePercentPcs = number_format($hasilGradePcs / $hasilTotalPcs * 100, 2);
            $hasilGradePercentPcs = number_format($hasilGradeBox / $hasilTotalBox * 100, 2);

            $qualityByGrade[] =
                [
                    'MVGR4' =>  $MVGR4,
                    'hasilTotalPcs' =>  $hasilTotalPcs,
                    'hasilTotalBox' =>  $hasilTotalBox,
                    'hasilPcs' =>  $hasilGradePcs,
                    'hasilBox' =>  $hasilGradeBox,
                    'hasilPercentPcs' =>  $hasilGradePercentPcs,
                    'hasilPercentBox' =>  $hasilGradePercentPcs,
                ];
        }
        //dd($qualityByGrade);
        return $qualityByGrade;
    }

    private function getQualityByGradeSize()
    {
        $hasilSortirbyGradeSizeMotive = $this->getHasilSortirbyGradeSizeMotive();
        $grouphasilSortirbyGrade = $hasilSortirbyGradeSizeMotive->groupBy('MVGR4');
        $grouphasilSortirbySize = $hasilSortirbyGradeSizeMotive->groupBy('size');
        $grouphasilSortirbyMotive = $hasilSortirbyGradeSizeMotive->groupBy('MAKTX');
        $qualityByGradeSize = [];
        //dd($grouphasilSortirbyMotive);
        // $hasilPerGradeSize[] = $grouphasilSortirbySize->groupBy('MVGR4')->map(function ($items)
        // {
        //     return
        //     [
        //         'MVGR4' => $items[0][0]->MVGR4,
        //         'hasilPcs' => $items[0]->sum('hasilPcs'),
        //     ];
        // })->values()->toArray();
        //dd($grouphasilSortirbySize);

        foreach ($grouphasilSortirbyGrade as $MVGR4 => $rowgrouphasilSortirbyGrade) {
            foreach ($grouphasilSortirbySize as $size => $rowgrouphasilSortirbySize) {
                // if(Str::substr($size, -1) === "1")
                // {
                //     continue;
                // }
                // if($size === "25X50" || $size === "30X60" || $size === "39X39" || $size === "30X50")
                // {
                //     continue;
                // }

                //====================
                $hasilSizePcs = $rowgrouphasilSortirbySize->sum('hasilPcs') ?: 1;
                $hasilSizeBox = $rowgrouphasilSortirbySize->sum('hasilBox') ?: 1;

                //=====================
                $hasilGradeSizePcs = $rowgrouphasilSortirbySize->filter(function ($item) use ($MVGR4) {
                    return $item->MVGR4 === $MVGR4;
                })->sum('hasilPcs');

                $hasilGradeSizeBox = $rowgrouphasilSortirbySize->filter(function ($item) use ($MVGR4) {
                    return $item->MVGR4 === $MVGR4;
                })->sum('hasilBox');

                //=====================
                // if($size === "26X51" || $size === "31X61" || $size === "40X40")
                // {
                //     $arrSize = explode('X', $size);
                //     $p = $arrSize[0]-1;
                //     $l = $arrSize[1]-1;
                //     $modSize = $p."X".$l;

                //     //================
                //     $hasilSizePcsAdd = $hasilSortirbyGradeSizeMotive->filter(function ($item) use ($modSize)
                //     {
                //         return $item->size === $modSize;
                //     })->sum('hasilPcs');
                //     $hasilSizePcs += $hasilSizePcsAdd;

                //     $hasilSizeBoxAdd = $hasilSortirbyGradeSizeMotive->filter(function ($item) use ($modSize)
                //     {
                //         return $item->size === $modSize;
                //     })->sum('hasilBox');
                //     $hasilSizeBox += $hasilSizeBoxAdd;

                //     //================
                //     $hasilGradeSizePcsAdd = $hasilSortirbyGradeSizeMotive->filter(function ($item) use ($MVGR4, $modSize)
                //     {
                //         return $item->MVGR4 === $MVGR4 && $item->size === $modSize;
                //     })->sum('hasilPcs');
                //     $hasilGradeSizePcs += $hasilGradeSizePcsAdd;

                //     $hasilGradeSizeBoxAdd = $hasilSortirbyGradeSizeMotive->filter(function ($item) use ($MVGR4, $modSize)
                //     {
                //         return $item->MVGR4 === $MVGR4 && $item->size === $modSize;
                //     })->sum('hasilBox');
                //     $hasilGradeSizeBox += $hasilGradeSizeBoxAdd;
                // }

                //$dataCount = $rowgrouphasilSortirbySize->count('hasilPcs') ?: 1;

                //=====================
                $hasilGradePercentPcs = number_format($hasilGradeSizePcs / $hasilSizePcs * 100, 2);
                $hasilGradePercentBox = number_format($hasilGradeSizeBox / $hasilSizeBox * 100, 2);

                if ($hasilGradeSizePcs <= 0) {
                    continue;
                };

                $qualityByGradeSize[] =
                    [
                        'MVGR4' =>  $MVGR4,
                        'size' => $size,
                        //'dataCount' =>  $dataCount,
                        'hasilSizePcs' =>  $hasilSizePcs,
                        'hasilSizeBox' =>  $hasilSizeBox,
                        'hasilPcs' =>  $hasilGradeSizePcs,
                        'hasilBox' =>  $hasilGradeSizeBox,
                        'hasilPercentPcs' =>  $hasilGradePercentPcs,
                        'hasilPercentBox' =>  $hasilGradePercentBox,
                        //'motive' =>  $arrMotive,
                    ];
            }
        }
        //dd($qualityByGradeSize);
        /*
        foreach($grouphasilSortirbySize as $size => $rowgrouphasilSortirbySize)
        {
            $hasilPerSize[] =
            [
                'size' =>  $size,
                'hasilPcs' =>  $rowgrouphasilSortirbySize->sum('hasilPcs'),
                'hasilBox' =>  $rowgrouphasilSortirbySize->sum('hasilBox'),
            ];
        }

        $grouphasilSortirbyMotive = $hasilSortirbyGradeSizeMotive->groupBy('MAKTX');
        $hasilPerMotive = [];
        foreach($grouphasilSortirbyMotive as $MAKTX => $rowgrouphasilSortirbyMotive)
        {
            $hasilPerMotive[] =
            [
                'MAKTX' =>  $MAKTX,
                'hasilPcs' =>  $rowgrouphasilSortirbyMotive->sum('hasilPcs'),
                'hasilBox' =>  $rowgrouphasilSortirbyMotive->sum('hasilBox'),
            ];
        }
        */

        // $sumHasilPcsQ01 = 0;
        // foreach ($grouphasilSortirbyGradeSizeMotive['Q01'] as $size => $sizeData) {
        //     foreach ($sizeData as $code => $codeData) {
        //         $sumHasilPcsQ01 += $codeData['hasilBox'] ?? 0; //Menangani kasus jika 'hasilpcs' tidak ada
        //     }
        // }
        // $sumQ01 = $data['Q01']
        // ->flatMap(function ($sizeData) {
        //     return $sizeData->pluck('menge'); //Asumsi ada key 'menge'
        // })
        // ->sum();

        // $sumQ01 = 0;
        // foreach ($data['Q01'] as $size => $sizeData) {
        //     foreach ($sizeData as $code => $codeData) {
        //         $sumQ01 += $codeData['menge']; //Asumsi ada key 'menge'
        //     }
        // }
        //dd($qualityByGradeSize);
        return $qualityByGradeSize;
    }

    private function getQualityBySizeMotive()
    {
        $hasilSortirbyGradeSizeMotive = $this->getHasilSortirbyGradeSizeMotive();
        $grouphasilSortirbyGrade = $hasilSortirbyGradeSizeMotive->groupBy('MVGR4');
        $grouphasilSortirbySize = $hasilSortirbyGradeSizeMotive->groupBy('size');
        $grouphasilSortirbyMotive = $hasilSortirbyGradeSizeMotive->groupBy('MAKTX');
        $qualityByGradeSize = [];
        $qualityBySizeMotive = [];
        //dd($grouphasilSortirbyMotive);
        foreach ($grouphasilSortirbyGrade as $MVGR4 => $rowgrouphasilSortirbyGrade) {
            if ($MVGR4 !== "Q01") {
                continue;
            }
            foreach ($grouphasilSortirbySize as $size => $rowgrouphasilSortirbySize) {
                // if($size === "25X50" || $size === "30X60" || $size === "39X39" || $size === "30X50")
                // {
                //     continue;
                // }

                //=====================
                $hasilGradeSizePcs = $rowgrouphasilSortirbySize->filter(function ($item) use ($MVGR4) {
                    return $item->MVGR4 === $MVGR4;
                })->sum('hasilPcs') ?: 1;

                $hasilGradeSizeBox = $rowgrouphasilSortirbySize->filter(function ($item) use ($MVGR4) {
                    return $item->MVGR4 === $MVGR4;
                })->sum('hasilBox') ?: 1;

                //=====================
                // if($size === "26X51" || $size === "31X61" || $size === "40X40")
                // {
                //     $arrSize = explode('X', $size);
                //     $p = $arrSize[0]-1;
                //     $l = $arrSize[1]-1;
                //     $modSize = $p."X".$l;

                //     //================
                //     $hasilGradeSizePcsAdd = $hasilSortirbyGradeSizeMotive->filter(function ($item) use ($MVGR4, $modSize)
                //     {
                //         return $item->MVGR4 === $MVGR4 && $item->size === $modSize;
                //     })->sum('hasilPcs');
                //     $hasilGradeSizePcs += $hasilGradeSizePcsAdd;

                //     $hasilGradeSizeBoxAdd = $hasilSortirbyGradeSizeMotive->filter(function ($item) use ($MVGR4, $modSize)
                //     {
                //         return $item->MVGR4 === $MVGR4 && $item->size === $modSize;
                //     })->sum('hasilBox');
                //     $hasilGradeSizeBox += $hasilGradeSizeBoxAdd;
                // }

                foreach ($grouphasilSortirbyMotive as $Motive => $rowgrouphasilSortirbyMotive) {
                    $hasilSizeMotivePcs = 0;
                    $hasilSizeMotiveBox = 0;
                    if ($rowgrouphasilSortirbyMotive[0]->size === $size) {
                        $hasilSizeMotivePcs = $rowgrouphasilSortirbyMotive->filter(function ($item) use ($MVGR4) {
                            return $item->MVGR4 === $MVGR4;
                        })->sum('hasilPcs');

                        $hasilSizeMotiveBox = $rowgrouphasilSortirbyMotive->filter(function ($item) use ($MVGR4) {
                            return $item->MVGR4 === $MVGR4;
                        })->sum('hasilBox');

                        if ($hasilSizeMotivePcs <= 0) {
                            continue;
                        };
                        //=====================
                        $hasilSizeMotivePcsPercent = number_format($hasilSizeMotivePcs / $hasilGradeSizePcs * 100, 2);
                        $hasilSizeMotiveBoxPercent = number_format($hasilSizeMotiveBox / $hasilGradeSizeBox * 100, 2);

                        $qualityBySizeMotive[] =
                            [
                                'MVGR4' => $MVGR4,
                                'size' => $size,
                                'motive' => $Motive,
                                'hasilGradeSizePcs' =>  $hasilGradeSizePcs,
                                'hasilGradeSizeBox' =>  $hasilGradeSizeBox,
                                'hasilPcs' =>  $hasilSizeMotivePcs,
                                'hasilBox' =>  $hasilSizeMotiveBox,
                                'hasilPercentPcs' =>  $hasilSizeMotivePcsPercent,
                                'hasilPercentBox' =>  $hasilSizeMotiveBoxPercent,
                            ];
                    }
                }
            }
        }
        //dd($qualityBySizeMotive);
        return $qualityBySizeMotive;
    }

    private function getSumQuality()
    {
        $qualityByMachine = $this->getqualityByMachine();
        $cqualityByMachine = collect($qualityByMachine);

        if ($cqualityByMachine->count() == 0) {
            return 0;
        }
        $sumQuality = $cqualityByMachine->sum('quality') / $cqualityByMachine->count();
        $sumQuality = number_format($sumQuality, 2);
        //dd($sumQuality);
        return $sumQuality;
    }

    private function getOeeByMachine()
    {
        $availabilityByMachine = $this->getAvailabilityByMachine();
        $performanceByMachine = $this->getPerformanceByMachine();
        $qualityByMachine = $this->getQualityByMachine();
        if (collect($availabilityByMachine)->count() == 0 || collect($performanceByMachine)->count() == 0 || collect($qualityByMachine)->count() == 0) {
            return [];
        }
        $oeeByMachine = [];
        $i = 0;
        foreach ($availabilityByMachine as $rowAvailabilityByMachine) {
            $work_center = $rowAvailabilityByMachine['work_center'];
            $availability = $rowAvailabilityByMachine['availability'] / 100;
            $performance = $performanceByMachine[$i]['performance'] / 100;
            $quality = $qualityByMachine[$i]['quality'] / 100;
            $oee = $availability * $performance * $quality;
            $oee = number_format($oee * 100, 2);
            $oeeByMachine[] =
                [
                    'work_center' => $work_center,
                    'oee' => $oee,
                ];
        }
        //dd($oeeByMachine);
        return $oeeByMachine;
    }

    private function getSumOee()
    {
        $oeeByMachine = $this->getOeeByMachine();
        $coeeByMachine = collect($oeeByMachine);
        if ($coeeByMachine->count() == 0) {
            return 0;
        }
        $sumOee = $coeeByMachine->sum('oee') / $coeeByMachine->count();
        $sumOee = number_format($sumOee, 2);
        //dd($sumOee);
        return $sumOee;
    }

    private function getAllMonthYear()
    {
        $allMonthYear = hasil_sortir_api::select(DB::raw("DATE_FORMAT(budat,'%M %Y') as BULAN"))
            ->distinct()
            ->orderBy('BULAN')
            ->get();
        //dd($allMonthYear);
        return $allMonthYear;
    }

    private function getDefaultPeriode()
    {
        $monthYear = Carbon::today()->format('F Y');
        $startDate = Carbon::create($monthYear)->startOfMonth();
        $endDate = Carbon::create($monthYear)->endOfMonth();
        $totalDays = $startDate->daysInMonth;
        $periode = [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'totalDays' => $totalDays
        ];
        return $periode;
    }

    public function getPeriode($monthYear)
    {
        $startDate = Carbon::create($monthYear)->startOfMonth();
        $endDate = Carbon::create($monthYear)->endOfMonth();
        $totalDays = $startDate->daysInMonth;
        $periode = [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'totalDays' => $totalDays
        ];

        return $periode;
    }

    public function getDefaultWeeklyPeriode()
    {
        $allMonthYear = $this->getAllMonthYear();
        $monthYear = Carbon::today()->format('F Y');

        $startDate = Carbon::create($monthYear)->startOfMonth();
        $endDate = Carbon::create($monthYear)->endOfMonth();
        $weeklyPeriode = [];
        $dayOfWeek = 0;
        if ($startDate->dayOfWeek <= 0) {
            $startWeek = $startDate->copy();
            $endWeek = $startDate->copy()->endOfDay();
            $weeklyPeriode[] = [
                'startWeek' => $startWeek,
                'endWeek' => $endWeek,
                'dayCount' => $startWeek->diffInDays($endWeek) + 1,
            ];
            $startDate = $startDate->addDays(1);
            $startWeek = $startDate->copy();
        } else {
            $startWeek = $startDate->copy();
            $endWeek = $startDate->copy()->endOfWeek();

            $weeklyPeriode[] = [
                'startWeek' => $startWeek,
                'endWeek' => $endWeek,
                'dayCount' => $startWeek->diffInDays($endWeek) + 1,
            ];
            $startDate = $startDate->addDays(8 - $startDate->dayOfWeek);
            $startWeek = $startDate->copy();
        }

        while ($startDate->lte($endDate)) {
            $startWeek = $startDate->copy()->startOfDay();
            $endWeek = $startDate->copy()->endOfWeek();

            if ($endWeek > $endDate->endOfMonth()) {
                $endWeek = $endDate->copy();
            }

            $weeklyPeriode[] = [
                'startWeek' => $startWeek,
                'endWeek' => $endWeek,
                'dayCount' => $startWeek->diffInDays($endWeek) + 1,
            ];
            $startDate->addWeek();
            $startWeek = $startDate->copy();
        }
        //dd($weeklyPeriode);
        return $weeklyPeriode;
    }

    public function getWeeklyPeriode($monthYear)
    {
        $startDate = Carbon::create($monthYear)->startOfMonth();
        $endDate = Carbon::create($monthYear)->endOfMonth();
        $weeklyPeriode = [];
        $dayOfWeek = 0;
        if ($startDate->dayOfWeek <= 0) {
            $startWeek = $startDate->copy();
            $endWeek = $startDate->copy()->endOfDay();
            $weeklyPeriode[] = [
                'startWeek' => $startWeek,
                'endWeek' => $endWeek,
                'dayCount' => $startWeek->diffInDays($endWeek) + 1,
            ];
            $startDate = $startDate->addDays(1);
            $startWeek = $startDate->copy();
        } else {
            $startWeek = $startDate->copy();
            $endWeek = $startDate->copy()->endOfWeek();

            $weeklyPeriode[] = [
                'startWeek' => $startWeek,
                'endWeek' => $endWeek,
                'dayCount' => $startWeek->diffInDays($endWeek) + 1,
            ];
            $startDate = $startDate->addDays(8 - $startDate->dayOfWeek);
            $startWeek = $startDate->copy();
        }

        while ($startDate->lte($endDate)) {
            $startWeek = $startDate->copy()->startOfDay();
            $endWeek = $startDate->copy()->endOfWeek();

            if ($endWeek > $endDate->endOfMonth()) {
                $endWeek = $endDate->copy();
            }

            $weeklyPeriode[] = [
                'startWeek' => $startWeek,
                'endWeek' => $endWeek,
                'dayCount' => $startWeek->diffInDays($endWeek) + 1,
            ];
            $startDate->addWeek();
            $startWeek = $startDate->copy();
        }
        //dd($weeklyPeriode);
        return $weeklyPeriode;
    }

    public function generatePeriodeReport()
    {
        $periodeReport = [];
        foreach ($this->weeklyPeriode as $week) {
            $periodeReport[] =
                [
                    'week' => "[" . $week['startWeek']->format('d/m') . " - " . $week['endWeek']->format('d/m') . "]",
                    'dayCount' => $week['dayCount'],
                ];
        }
        //dd($periodeReport[0]['dayCount']);
        return $periodeReport;
    }

    public function generateDataAnalisaKualitasTile($date_start, $date_end, $shift)
    {

        $allResults = collect();
        if ($date_start != '' && $date_end != '') {
            $startDate = Carbon::parse($date_start);
            $endDate = Carbon::parse($date_end);

            $shiftTimes = [
                0 => ['startTime' => '00:00:00', 'endTime' => '23:59:59'],
                1 => ['startTime' => '08:00:00', 'endTime' => '15:59:59'],
                2 => ['startTime' => '16:00:00', 'endTime' => '23:59:59'],
                3 => ['startTime' => '00:00:00', 'endTime' => '07:59:59']
            ];

            if (!isset($shiftTimes[$shift])) {
                return collect(); // Return empty collection jika shift tidak valid
            }


            // Loop per tanggal
            while ($startDate->lte($endDate)) {
                if ($shift == 3) {
                    // Shift 3: Ambil data jam 00:00 - 07:59 di tanggal ini
                    $queryDate = $startDate->copy()->subDay();
                } else {
                    $queryDate = $startDate->copy();
                }

                $startDateTime = $queryDate->format('Y-m-d') . ' ' . $shiftTimes[$shift]['startTime'];
                $endDateTime = $queryDate->format('Y-m-d') . ' ' . $shiftTimes[$shift]['endTime'];

                $result = sr_analisa_kualitas::with('srListKualitas.srCacat')
                    ->whereBetween('created_at', [$startDateTime, $endDateTime])
                    ->get();

                $allResults = $allResults->merge($result);

                $startDate->addDay(); // ke tanggal berikutnya
            }
        } else {
            $allResults = sr_analisa_kualitas::with('srListKualitas.srCacat')
                ->whereBetween('created_at', [
                    Carbon::parse($this->periode['startDate'])->startOfDay(),
                    Carbon::parse($this->periode['endDate'])->endOfDay()
                ])
                ->get();
        }
        // Proses hasil seperti biasa
        $data = $allResults->groupBy('size')->map(function ($group) {
            $size = $group->first()->size;

            $jenisCacat = [];
            foreach ($group as $item) {
                foreach ($item->srListKualitas as $list) {
                    $cacatKey = $list->srCacat->jenis_cacat;

                    if (!isset($jenisCacat[$cacatKey])) {
                        $jenisCacat[$cacatKey] = [
                            'jenis_cacat' => $list->srCacat->jenis_cacat,
                            'sample_cacat' => $item->kw1 + $item->kw2 + $item->kw3 + $item->kw4,
                            'quantity' => 0,
                            'percentage' => 0,
                            'grouped_posisi' => []
                        ];
                    }

                    $jenisCacat[$cacatKey]['quantity'] += $list->kw2 + $list->kw3 + $list->kw4;

                    $materialDescKey = $item->material_desc;

                    if (!isset($jenisCacat[$cacatKey]['grouped_posisi'][$materialDescKey])) {
                        $jenisCacat[$cacatKey]['grouped_posisi'][$materialDescKey] = [
                            'material_desc' => $materialDescKey,
                            'total_quantity' => 0,
                            'percentage' => 0,
                            'positions' => []
                        ];
                    }

                    $jenisCacat[$cacatKey]['grouped_posisi'][$materialDescKey]['total_quantity'] += $list->kw2 + $list->kw3 + $list->kw4;

                    $newPosition = [
                        'no_ph' => $item->no_ph,
                        'no_hd' => $item->no_hd,
                        'no_kiln' => $item->no_kiln,
                        'no_gl' => $item->no_gl,
                        'quantity' => $list->kw2 + $list->kw3 + $list->kw4,
                        'percentage' => 0
                    ];

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

            $allQuantity = collect($jenisCacat)->sum('quantity');
            $allSample = collect($jenisCacat)->sum('sample_cacat');

            $topJenisCacat = collect($jenisCacat)
                ->sortByDesc('quantity')
                ->take(5)
                ->map(function ($cacat) use ($allSample) {
                    $cacat['percentage'] = $allSample > 0
                        ? round(($cacat['quantity'] / $allSample) * 100, 2)
                        : 0;

                    $cacat['grouped_posisi'] = collect($cacat['grouped_posisi'])
                        ->map(function ($material) use ($cacat) {
                            $material['percentage'] = $cacat['sample_cacat'] > 0
                                ? round(($material['total_quantity'] / $cacat['sample_cacat']) * 100, 2)
                                : 0;

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
                'sample_size' => $allSample,
                'top_jenis_cacat' => $topJenisCacat
            ];
        })->values();

        return $data;
    }
    public function index()
    {

        $this->periode = $this->getDefaultPeriode();
        $this->weeklyPeriode = $this->getDefaultWeeklyPeriode();
        $allMonthYear = $this->getAllMonthYear();

        //==Report Weekly
        $periodeReport = $this->generatePeriodeReport();
        $hasilKilnByMachineWeek = $this->getHasilKilnByMachineWeek();
        $hasilSortirWeekReport = $this->getHasilSortirWeekReport();

        //== availability
        //$downtimeByMachine = $this->getDowntimeByMachine();
        //$downtimeByType = $this->getDowntimeByType();
        $availabilityByMachine = $this->getAvailabilityByMachine();
        $detailAvailabilityByType = $this->getdetailAvailabilityByType();
        $sumAvailability = $this->getSumAvailability();
        //== performance
        $performanceByMachine = $this->getPerformanceByMachine();
        $detailPerformanceBySize = $this->getDetailPerformanceBySize();
        $sumPerformance = $this->getSumPerformance();
        //== quality
        //$fixHasilSortir  = $this->getFixHasilSortir();
        $qualityByMachine = $this->getQualityByMachine();
        $detailQualityByMachineGrade = $this->getDetailQualityByMachineGrade();
        //$detailQualityByGrade = $this->getDetailQualityByGrade();
        //$detailQualityByGradeSize = $this->getDetailQualityByGradeSize();
        $sumQuality = $this->getSumQuality();
        $qualityByGrade = $this->getQualityByGrade();
        $qualityByGradeSize = $this->getQualityByGradeSize();
        $qualityBySizeMotive = $this->getQualityBySizeMotive();
        /*
        $performanceMesin = $this->getSumPerformanceMesin();
        $this->add();
        $performance = 0;
        $performanceMesin = $this->getPerformance();

        if ($performanceMesin) {
            $total = 0;
            foreach ($performanceMesin as $value) {
                $total += $value;
            }
            $performance = $total / count($performanceMesin);
            $performance = number_format($performance, 2); // Format to 2 decimal places
        }
        */

        //$quality = $this->getQuality();
        //$quality = 84;
        // $oee = ($sumAvailability/100) * ($sumPerformance/100) * ($sumQuality/100);
        // $oee = $oee*100;
        // $oee = number_format($oee, 2);
        $oeeByMachine = $this->getOeeByMachine();
        $sumOee = $this->getSumOee();

        $dataAnalisaKualitasTile = $this->generateDataAnalisaKualitasTile('', '', 0);
        //dd($oee);
        //$chart= $this->getLineChart();
        //dd($qualityByMachine->toArray());
        return view('home', compact('oeeByMachine', 'sumOee', 'periodeReport', 'hasilKilnByMachineWeek', 'hasilSortirWeekReport', 'allMonthYear', 'availabilityByMachine', 'detailAvailabilityByType', 'sumAvailability', 'performanceByMachine', 'detailPerformanceBySize', 'sumPerformance', 'qualityByMachine', 'detailQualityByMachineGrade', 'qualityByGrade', 'qualityByGradeSize', 'qualityBySizeMotive', 'sumQuality', 'dataAnalisaKualitasTile'));
        // return view('home', compact('detailPerformanceSize', 'detailPerformanceMesin', 'performanceMesin'));
    }

    public function indexByFilter(Request $request)
    {
        $monthYear = $request->input('selectBulan');
        $this->periode = $this->getPeriode($monthYear);
        $this->weeklyPeriode = $this->getWeeklyPeriode($monthYear);
        ///$this->periode = $this->getDefaultPeriode();
        $allMonthYear = $this->getAllMonthYear();

        //==Report Weekly
        $periodeReport = $this->generatePeriodeReport();
        $hasilKilnByMachineWeek = $this->getHasilKilnByMachineWeek();
        $hasilSortirWeekReport = $this->getHasilSortirWeekReport();
        //dd($hasilSortirWeekReport);
        //== availability
        //$downtimeByMachine = $this->getDowntimeByMachine();
        //$downtimeByType = $this->getDowntimeByType();
        $availabilityByMachine = $this->getAvailabilityByMachine();
        $detailAvailabilityByType = $this->getdetailAvailabilityByType();
        $sumAvailability = $this->getSumAvailability();
        //== performance
        $performanceByMachine = $this->getPerformanceByMachine();
        $detailPerformanceBySize = $this->getDetailPerformanceBySize();
        $sumPerformance = $this->getSumPerformance();
        //== quality
        //$fixHasilSortir  = $this->getFixHasilSortir();
        $qualityByMachine = $this->getQualityByMachine();
        $detailQualityByMachineGrade = $this->getDetailQualityByMachineGrade();
        //$detailQualityByGrade = $this->getDetailQualityByGrade();
        //$detailQualityByGradeSize = $this->getDetailQualityByGradeSize();
        $sumQuality = $this->getSumQuality();
        $qualityByGrade = $this->getQualityByGrade();
        $qualityByGradeSize = $this->getQualityByGradeSize();
        $qualityBySizeMotive = $this->getQualityBySizeMotive();
        //dd($qualityByGradeSize);
        /*
        $performanceMesin = $this->getSumPerformanceMesin();
        $this->add();
        $performance = 0;
        $performanceMesin = $this->getPerformance();

        if ($performanceMesin) {
            $total = 0;
            foreach ($performanceMesin as $value) {
                $total += $value;
            }
            $performance = $total / count($performanceMesin);
            $performance = number_format($performance, 2); // Format to 2 decimal places
        }
        */

        //$quality = $this->getQuality();
        //$quality = 84;
        $oeeByMachine = $this->getOeeByMachine();
        $sumOee = $this->getSumOee();

        // $oee = ($sumAvailability/100) * ($sumPerformance/100) * ($sumQuality/100);
        // $oee = $oee*100;
        // $oee = number_format($oee, 2);
        //dd($oee);
        //$chart= $this->getLineChart();
        //dd($qualityByMachine->toArray());
        $dataAnalisaKualitasTile = $this->generateDataAnalisaKualitasTile($this->periode['startDate'], $this->periode['endDate'], 0);
        return view('home', compact('qualityByGrade', 'qualityByGradeSize', 'qualityBySizeMotive', 'sumOee', 'oeeByMachine', 'periodeReport', 'hasilKilnByMachineWeek', 'hasilSortirWeekReport', 'allMonthYear', 'availabilityByMachine', 'detailAvailabilityByType', 'sumAvailability', 'performanceByMachine', 'detailPerformanceBySize', 'sumPerformance', 'qualityByMachine', 'detailQualityByMachineGrade', 'sumQuality', 'dataAnalisaKualitasTile'));
        // return view('home', compact('detailPerformanceSize', 'detailPerformanceMesin', 'performanceMesin'));
    }

    public function indexPengawas()
    {
        $this->periode = $this->getDefaultPeriode();
        $periode = $this->periode;
        $periode['startDate'] = Carbon::parse($periode['startDate'])->format('Y-m-d');
        $periode['endDate'] = Carbon::parse($periode['endDate'])->format('Y-m-d');
        $dataAnalisaKualitasTile = $this->generateDataAnalisaKualitasTile('', '', '');
        return view('pengawas', compact('dataAnalisaKualitasTile', 'periode'));
    }

    public function indexFilterPengawas(Request $request)
    {
        $date_start = $request->input('date_start');
        $date_end = $request->input('date_end');
        $shift = $request->input('shift');
        $dataAnalisaKualitasTile = $this->generateDataAnalisaKualitasTile($date_start, $date_end, $shift);

        $this->periode = $this->getDefaultPeriode();
        $periode = $this->periode;
        $periode['startDate'] = Carbon::parse($periode['startDate'])->format('Y-m-d');
        $periode['endDate'] = Carbon::parse($periode['endDate'])->format('Y-m-d');
        return view('pengawas', compact('dataAnalisaKualitasTile', 'periode'));
    }

    private function getDetailQualityByGrade()
    {
        $fixHasilSortir = $this->getFixHasilSortir();
        $groupHasilSortirByGrade = collect($fixHasilSortir)->groupBy('MVGR4');
        $detailQualityByGrade = [];
        foreach ($groupHasilSortirByGrade as $MVGR4 => $rowHasilSortirByGrade) {
            $sortirHasilTotal = collect($fixHasilSortir)->sum('MENGE');
            $sortirHasilByGrade = collect($rowHasilSortirByGrade)->sum('MENGE');

            $qualityByGradePercent = $sortirHasilByGrade / $sortirHasilTotal * 100;
            $detailQualityByGrade[] =
                [
                    'grade' =>  $MVGR4,
                    'sortirHasilTotal' =>  number_format($sortirHasilTotal, 2),
                    'sortirHasilByGrade' => number_format($sortirHasilByGrade, 2),
                    'qualityByGradePercent' => number_format($qualityByGradePercent, 2),
                ];
        }
        //dd($detailQualityByGrade);
        return $detailQualityByGrade;
    }

    private function getDetailQualityByGradeSize()
    {
        $fixHasilSortir = $this->getFixHasilSortir();
        $groupHasilSortirBySize = collect($fixHasilSortir)->groupBy('size');
        $groupHasilSortirByGradeSize = [];
        foreach ($fixHasilSortir as $rowfixHasilSortir) {
            $groupHasilSortirByGradeSize[$rowfixHasilSortir['MVGR4']][$rowfixHasilSortir['size']][] = $rowfixHasilSortir;
        }
        $cgroupHasilSortirByGradeSize = collect($groupHasilSortirByGradeSize);
        $detailQualityByGradeSize = [];
        foreach ($cgroupHasilSortirByGradeSize as $MVGR4 => $size) {
            foreach ($size as $rowsize) {
                $sortirHasilByGradeSize = collect($rowsize)->sum('MENGE');
                foreach ($groupHasilSortirBySize as $sz => $rowHasilSortirBySize) {
                    $sortirHasilBySize = $rowHasilSortirBySize->sum('MENGE');
                    //dd($sortirHasilByGrade);
                    if ($sz == $rowsize[0]['size']) {
                        $qualityByGradeSizePercent = $sortirHasilByGradeSize / $sortirHasilBySize * 100;
                        $detailQualityByGradeSize[] =
                            [
                                'grade' =>  $MVGR4,
                                'size' =>  $sz,
                                'sortirHasilByGradeSize' => number_format($sortirHasilByGradeSize, 2),
                                'qualityByGradeSizePercent' => number_format($qualityByGradeSizePercent, 2),
                            ];
                    }
                }
            }
        }
        //dd($detailQualityByGradeSize);
        return $detailQualityByGradeSize;
    }
}
