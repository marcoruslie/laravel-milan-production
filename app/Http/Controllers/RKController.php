<?php

namespace App\Http\Controllers;

use App\Models\confirmation_log;
use App\Models\rk_d_koreksi;
use App\Models\rk_hasil_produksi;
use App\Models\rk_koreksi_tile;
use App\Models\rk_pengendalian_proses;
use App\Models\rk_unloading_hasil_produksi_gl;
use App\Models\target_saps;
use App\Models\temp_car;
use Illuminate\Http\Request;

class RKController extends Controller
{
    //confirm
    public function confirmRk(Request $request)
    {
        if ($request->form == 'loading') {
            rk_hasil_produksi::where('order_id', $request->order)
                ->where('shift_id', $request->shift)
                ->update(['is_confirm' => true]);
        } else if ($request->form == 'unloading') {
            rk_unloading_hasil_produksi_gl::where('order_id', $request->order)
                ->where('shift_id', $request->shift)
                ->update(['is_confirm' => true]);
        } else if ($request->form == 'pengendalian') {
            rk_pengendalian_proses::where('order_id', $request->order)
                ->where('shift_id', $request->shift)
                ->update(['is_confirm' => true]);
        } else if ($request->form == 'koreksi') {
            rk_koreksi_tile::where('order_id', $request->order)
                ->where('shift_id', $request->shift)
                ->update(['is_confirm' => true]);
        }
        confirmation_log::create([
            'shift_id' => $request->shift,
            'order_id' => $request->order,
            'user_id' => $request->user,
            'keterangan' => $request->keterangan
        ]);
    }

    public function createRkUnloadingGl(Request $request)
    {
        $baru = rk_unloading_hasil_produksi_gl::create($request->all());
        if ($request->from == 'Car') {
            $update = temp_car::where('id', '=',  $request->no)->first();
            if ($update->status - $request->unloading <= 0) {
                $update->status = 0;
                $update->assign_to = '-';
            } else {
                $update->status = $update->status - $request->unloading;
            }
            $update->save();
        }
        return response()->json(['message' => 'sukses', 'body' => $baru]);
    }

    public function getRkUnloadingGl($kode, $shift)
    {
        $val = rk_unloading_hasil_produksi_gl::where('shift_id', $shift)
            ->where('order_id', $kode)
            ->get();
        return response()->json(['unloadingGl' => $val]);
    }

    // public function createRkHasilProduksi(Request $request)
    // {
    //     if ($request->from == 'Car') {
    //         $UpdateCar = temp_car::where('nocar', '=',  $request->no)->first();
    //         if ($UpdateCar->status == 0) {
    //             $UpdateCar->status = $request->jumlah;
    //             $UpdateCar->assign_to = 'SR';
    //             $UpdateCar->save();
    //         } else {
    //             return response()->json(['message' => 'Car sedang tidak available!'], 422);
    //         }
    //     }
    //     $baru = rk_hasil_produksi::create($request->all());
    //     return response()->json(['message' => 'sukses', 'body' => $baru]);
    // }

    public function createRkHasilProduksi(Request $request)
    {
        if ($request->from == 'Car') {
            $UpdateCar = temp_car::where('nocar', '=',  $request->no)->first();
            $UpdateCar->status = $request->jumlah;
            $UpdateCar->assign_to = 'SR';
            $UpdateCar->save();
        }
        $baru = rk_hasil_produksi::create($request->all());

        return response()->json(['message' => 'sukses', 'body' => $baru]);
    }

    // public function createRkHasilProduksi(Request $request)
    // {
    //     if ($request->from == 'Car') {
    //         $UpdateCar = temp_car::where('nocar', '=',  $request->no)->first();

    //         $UpdateCar->status = $request->jumlah;
    //         $UpdateCar->assign_to = 'SR';
    //         $UpdateCar->save();
    //     }
    //     $baru = rk_hasil_produksi::create($request->all());
    //     return response()->json(['message' => 'sukses', 'body' => $baru]);
    // }

    public function getRkHasilProduksi($kode, $shift)
    {
        $val = rk_hasil_produksi::where('shift_id', $shift)
            ->where('order_id', $kode)
            ->get();
        return response()->json(['hasilRk' => $val]);
    }

    public function getAllRkHasilProduksi()
    {
        $val = rk_hasil_produksi::all();
        return response()->json(['hasilRk' => $val]);
    }

    public function updateRkHasilProduksi(Request $request, int $id)
    {
        $data = rk_hasil_produksi::find($id);
        $cekstatus = temp_car::find($data->no);
        if ($cekstatus->assign_to == 'SR') {
            if ($data->no != $request->no) {
                $cekCar = temp_car::find($request->no);
                if ($cekCar->status == 0) {
                    $cekCar->status = $request->jumlah;
                    $cekCar->assign_to = 'SR';
                    $cekCar->save();
                    $cekstatus->status = 0;
                    $cekstatus->assign_to = '-';
                    $cekstatus->save();
                    $data->update($request->all());
                    $data->is_confirm = false;
                    $data->save();
                    return response()->json(['message' => 'sukses', 'body' => $data]);
                }
            } else {
                $cekstatus->status = $request->jumlah;
                $cekstatus->save();
                $data->update($request->all());
                return response()->json(['message' => 'sukses', 'body' => $data]);
            }
        }
    }

    public function accRkHasilProduksi(Request $request)
    {
        $Update = temp_car::where('id', '=',  $request->no)->first();
        $Update->assign_to = $request->assign;
        $Update->save();

        return response()->json(['message' => 'sukses', 'body' => $Update]);
    }

    public function createRkPengendalian(Request $request)
    {
        $baru = rk_pengendalian_proses::create($request->all());
        return response()->json(['message' => 'sukses', 'body' => $baru]);
    }

    public function getRkPengendalian($kode, $shift)
    {
        $val = rk_pengendalian_proses::where('shift_id', $shift)
            ->where('order_id', $kode)
            ->get();
        return response()->json(['pengendalian' => $val]);
    }

    public function updateRkPengendalian(Request $request, int $id)
    {
        $data = rk_pengendalian_proses::find($id);
        $data->update($request->all());
        $data->is_confirm = false;
        $data->save();
        return response()->json(['message' => 'sukses', 'body' => $data]);
    }

    public function createRkKoreksi(Request $request)
    {
        $baru = rk_koreksi_tile::create($request->all());

        return response()->json(['message' => 'sukses', 'body' => $baru]);
    }

    public function createRkDetailKoreksi(Request $request)
    {
        $baru = rk_d_koreksi::create($request->all());

        // Koreksi Kiln
        $this->updateKoreksiKiln($request, 'T4', 'koreksi_kiln_kiri');
        $this->updateKoreksiKiln($request, 'T6', 'koreksi_kiln_kanan');

        // Koreksi AS
        $this->updateKoreksiAS($request);

        // Koreksi AT
        $this->updateKoreksiAT($request);

        return response()->json(['message' => 'sukses', 'body' => $baru]);
    }

    public function updateDetailKoreksi(Request $request, int $id)
    {
        $existing = rk_d_koreksi::find($id);
        if ($existing) {
            $existing->rk_koreksi_id = $request->rk_koreksi_id;
            $existing->T1 = $request->T1;
            $existing->T2 = $request->T2;
            $existing->T3 = $request->T3;
            $existing->T4 = $request->T4;
            $existing->T5 = $request->T5;
            $existing->T6 = $request->T6;
            $existing->T7 = $request->T7;
            $existing->T8 = $request->T8;
            $existing->T9 = $request->T9;
            $existing->save();

            // Koreksi Kiln
            $this->updateKoreksiKiln($request, 'T4', 'koreksi_kiln_kiri');
            $this->updateKoreksiKiln($request, 'T6', 'koreksi_kiln_kanan');

            // Koreksi AS
            $this->updateKoreksiAS($request);

            // Koreksi AT
            $this->updateKoreksiAT($request);

            return response()->json(['message' => 'sukses', 'body' => $existing]);
        } else {
            return response()->json(['error' => 'Record not found'], 404);
        }
    }

    private function updateKoreksiKiln($request, $columnName, $koreksiField)
    {
        $data = rk_d_koreksi::where('rk_koreksi_id', $request->rk_koreksi_id)->get();
        $dataSize = sizeof($data);
        $myArray = [];

        for ($j = 0; $j < $dataSize; $j++) {
            $columnValue = floatVal($data[$j]->$columnName);
            $myArray[$j] = $columnValue;
        }

        $maxVal = max($myArray);
        $minVal = min($myArray);
        $populasi = $maxVal - $minVal;

        if ($populasi < 0) {
            $populasi *= -1;
        }

        $populasi /= 10; // Bagi 10
        $Update = rk_koreksi_tile::where('id', '=', $request->rk_koreksi_id)->first();
        $Update->$koreksiField = $populasi;
        $Update->save();
    }

    private function updateKoreksiAS($request)
    {
        $data = rk_d_koreksi::where('rk_koreksi_id', $request->rk_koreksi_id)->get();
        $dataSize = sizeof($data);
        $max = -99;
        $myArray = [];

        for ($j = 0; $j < $dataSize; $j++) {
            for ($i = 1; $i <= 9; $i++) {
                $columnName = 'T' . $i;
                $columnValue = floatVal($request->$columnName);

                if ($columnValue > 0 && $columnValue != null) {
                    $myArray[$columnName] = $columnValue;
                }
            }

            $maxVal = max($myArray);
            $minVal = min($myArray);
            $center = $maxVal - $minVal;

            if ($center < 0) {
                $center *= -1;
            }

            if ($center > $max) {
                $max = $center;
            }
        }

        $max /= 10; // Bagi 10
        $Update = rk_koreksi_tile::where('id', '=', $request->rk_koreksi_id)->first();
        $Update->as = $max;
        $Update->save();
    }

    private function updateKoreksiAT($request)
    {
        $data = rk_d_koreksi::where('rk_koreksi_id', $request->rk_koreksi_id)->get();
        $dataSize = sizeof($data);
        $myArray = [];

        for ($j = 0; $j < $dataSize; $j++) {
            for ($i = 1; $i <= 9; $i++) {
                $columnName = 'T' . $i;
                $columnValue = floatVal($data[$j]->$columnName);

                if ($columnValue > 0) {
                    $myArray[$columnName . $j] = $columnValue;
                }
            }
        }

        $maxVal = max($myArray);
        $minVal = min($myArray);
        $populasi = $maxVal - $minVal;

        if ($populasi < 0) {
            $populasi *= -1;
        }

        $populasi /= 10; // Bagi 10
        $Update = rk_koreksi_tile::where('id', '=', $request->rk_koreksi_id)->first();
        $Update->at = $populasi;
        $Update->save();
    }


    public function getRkKoreksi($kode, $shift)
    {
        $koreksi = rk_koreksi_tile::with('rk_d_koreksi')
            ->where('shift_id', $shift)
            ->where('order_id', $kode)
            ->get();
        return response()->json(['koreksi' => $koreksi]);
    }

    public function updateRkKoreksi(Request $request)
    {
        $Update = rk_koreksi_tile::where('id', '=',  $request->id)->first();
        $Update->rkSize = $request->rkSize;
        $Update->standar_koreksi = $request->standar_koreksi;
        $Update->koreksi_kiln = $request->koreksi_kiln;
        $Update->keterangan = $request->keterangan;
        $Update->is_confirm = false;
        $Update->save();


        return response()->json(['message' => 'sukses', 'body' => $Update]);
    }
    public function getTargetSap()
    {
        $targetSap = target_saps::all();
        return response()->json(['target' => $targetSap]);
    }
}
