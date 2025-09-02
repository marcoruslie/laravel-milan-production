<?php

namespace App\Http\Controllers;

use App\Models\confirmation_log;
use App\Models\ph_control;
use App\Models\ph_counter;
use App\Models\ph_d_dimensi;
use App\Models\ph_d_tebal;
use App\Models\ph_dimensi;
use App\Models\ph_dryer;
use App\Models\ph_tebal;
use App\Models\ph_temp;
use App\Models\ph_temp_out;
use App\Models\ph_setcol;
use App\Models\update_log;
use Illuminate\Http\Request;

class PHController extends Controller
{
    public function confirmPh(Request $request)
    {
        if ($request->form == 'control') {
            ph_control::where('order_id', $request->order)
                ->where('shift_id', $request->shift)
                ->update(['is_confirm' => true]);
            // return response()->json(['message' => 'PhControl records updated successfully'], 200);
        } else if ($request->form == 'dimensi') {
            ph_dimensi::where('order_id', $request->order)
                ->where('shift_id', $request->shift)
                ->update(['is_confirm' => true]);
        } else if ($request->form == 'suhu') {
            ph_temp::where('order_id', $request->order)
                ->where('shift_id', $request->shift)
                ->update(['is_confirm' => true]);
        } else if ($request->form == 'tebal') {
            ph_tebal::where('order_id', $request->order)
                ->where('shift_id', $request->shift)
                ->update(['is_confirm' => true]);
        } else if ($request->form == 'counter') {
            ph_counter::where('order_id', $request->order)
                ->where('shift_id', $request->shift)
                ->update(['is_confirm' => true]);
        } else if ($request->form == 'dryer') {
            ph_dryer::where('order_id', $request->order)
                ->where('shift_id', $request->shift)
                ->update(['is_confirm' => true]);
        } else if ($request->form == 'tempOut') {
            ph_temp_out::where('order_id', $request->order)
                ->where('shift_id', $request->shift)
                ->update(['is_confirm' => true]);
        } else if ($request->form == 'setCol') {
            ph_setcol::where('order_id', $request->order)
                ->where('shift_id', $request->shift)
                ->update(['is_confirm' => true]);
        }
        confirmation_log::create([
            'shift_id' => $request->shift,
            'order_id' => $request->order,
            'user_id' => $request->user,
            'keterangan' => $request->keterangan
        ]);

        // Return a response indicating success
    }

    public function createPhControl(Request $request)
    {
        $validated = $request->validate([
            'shift_id' => 'required',
            'order_id' => 'required',
            'user_id' => 'required',
            'tekanan_max' => 'required',
            'tekanan_init' => 'required',
            'cycle_ph' => 'required',
            'keutuhan_body' => 'required',
        ]);

        // create tes bakar

        $baru = ph_control::create($request->all());
        return response()->json(['message' => 'sukses', 'body' => $baru]);
    }

    public function getPhControl($kode, $shift)
    {
        $val = ph_control::where('shift_id', $shift)
            ->where('order_id', $kode)
            ->get();
        return response()->json(['control' => $val]);
    }

    public function updatePhControl(Request $request, int $id)
    {
        $phControl = ph_control::find($id);
        $phControl->update($request->all());
        $phControl->is_confirm = false;
        $phControl->save();
        return response()->json(['message' => 'sukses', 'body' => $phControl]);

        // update_log::create([
        //     'kode' => $request->order_id,
        //     'shift' => $request->shift_id,
        //     'user' => $request->user_id,
        //     'param1' => 'PH',
        //     'param2' => 'Tes Bakar',
        //     'param3' => $request->id,
        //     'param4' => $field,
        //     'value_before' => $request->vb,
        //     'value_after' => $request->val,
        // ]);
    }

    public function createPhTemp(Request $request)
    {
        $baru = ph_temp::create($request->all());
        return response()->json(['message' => 'sukses', 'body' => $baru]);
    }

    public function getPhTemp($kode, $shift)
    {
        $val = ph_temp::where('shift_id', $shift)
            ->where('order_id', $kode)
            ->get();
        return response()->json(['temp' => $val]);
    }

    public function updatePhTemp(Request $request, int $id)
    {
        $data = ph_temp::find($id);
        $data->update($request->all());
        $data->is_confirm = false;
        $data->save();
        return response()->json(['message' => 'sukses', 'body' => $data]);

        // update_log::create([
        //     'kode' => $shift->kode_header,
        //     'shift' => $shift->shift,
        //     'user' => $request->user,
        //     'param1' => 'PH',
        //     'param2' => 'Temp',
        //     'param3' => $request->id,
        //     'param4' => $field,
        //     'value_before' => $request->vb,
        //     'value_after' => $request->val,
        // ]);
    }

    //dryer

    public function createPhDryer(Request $request)
    {
        $baru = ph_dryer::create($request->all());

        return response()->json(['message' => 'sukses', 'body' => $baru]);
    }

    public function getPhDryer($kode, $shift)
    {
        $res = ph_dryer::where('shift_id', $shift)
            ->where('order_id', $kode)
            ->get();
        return response()->json([
            'dryer' => $res
        ]);
    }

    public function updatePhDryer(Request $request, int $id)
    {
        $data = ph_dryer::find($id);
        $data->update($request->all());
        $data->is_confirm = false;
        $data->save();
        return response()->json(['message' => 'sukses', 'body' => $data]);
    }

    //dimensi

    public function createPhDimensi(Request $request)
    {
        $baru = ph_dimensi::create($request->all());

        return response()->json(['message' => 'sukses', 'body' => $baru]);
    }

    public function createPhDetailDimensi(Request $request)
    {
        $myArray = [];
        for ($i = 1; $i <= 8; $i++) {
            $columnName = 'D' . $i;
            $columnValue = floatVal($request->$columnName);

            if ($columnValue > 0 && $columnValue != null) {
                if ($columnValue < 20) {
                    $columnValue += 100;
                }
                $myArray[$columnName] = $columnValue;
            }
        }
        $maxVal = max($myArray);
        $minVal = min($myArray);
        $center = $maxVal - $minVal;
        if ($center < 0) {
            $center *= -1;
        }

        $baru = ph_d_dimensi::create([
            'h_dimensi_id' => $request->h_dimensi_id,
            'D1' => $request->D1,
            'D2' => $request->D2,
            'D3' => $request->D3,
            'D4' => $request->D4,
            'D5' => $request->D5,
            'D6' => $request->D6,
            'D7' => $request->D7,
            'D8' => $request->D8,
            'center' => $center
        ]);

        return response()->json(['message' => 'sukses', 'body' => $baru]);
    }

    public function updateDetailDimensi(Request $request, int $id)
    {
        $existing = ph_d_dimensi::find($id);

        if ($existing) {
            $myArray = [];
            for ($i = 1; $i <= 8; $i++) {
                $columnName = 'D' . $i;
                $columnValue = floatVal($request->$columnName);

                if ($columnValue > 0 && $columnValue != null) {
                    if ($columnValue < 20) {
                        $columnValue += 100;
                    }
                    $myArray[$columnName] = $columnValue;
                }
            }
            $maxVal = max($myArray);
            $minVal = min($myArray);
            $center = $maxVal - $minVal;
            if ($center < 0) {
                $center *= -1;
            }
            // Update the fields with new values from the request
            $existing->h_dimensi_id = $request->h_dimensi_id;
            $existing->D1 = $request->D1;
            $existing->D2 = $request->D2;
            $existing->D3 = $request->D3;
            $existing->D4 = $request->D4;
            $existing->D5 = $request->D5;
            $existing->D6 = $request->D6;
            $existing->D7 = $request->D7;
            $existing->D8 = $request->D8;
            $existing->center = $center;

            // Save the updated record
            $existing->save();
            return response()->json(['message' => 'sukses', 'body' => $existing]);
        } else {
            // Handle the case where the record does not exist
            // For example, throw an exception or return an error response
            return response()->json(['error' => 'Record not found'], 404);
        }
    }

    public function getPhDimensi($kode, $shift)
    {
        $dimensi = ph_dimensi::with('ph_d_dimensi')
            ->where('shift_id', $shift)
            ->where('order_id', $kode)
            ->get();
        return response()->json(['dimensi' => $dimensi]);
    }

    public function updatePhPopulasiDimensi(Request $request)
    {
        $Update = ph_dimensi::where('id', '=',  $request->id)->first();
        $Update->populasi = $request->populasi;
        $Update->save();

        return response()->json(['message' => 'sukses', 'body' => $Update]);
    }

    //counter

    public function createPhCounter(Request $request)
    {
        $baru = ph_counter::create($request->all());
        return response()->json(['message' => 'sukses', 'body' => $baru]);
    }

    public function getPhCounter($kode, $shift)
    {
        $val = ph_counter::where('shift_id', $shift)
            ->where('order_id', $kode)
            ->get();
        return response()->json(['counter' => $val]);
    }

    public function updatePhCounter(Request $request, int $id)
    {
        $data = ph_counter::find($id);
        $data->update($request->all());
        return response()->json(['message' => 'sukses', 'body' => $data]);
    }

    //tebal

    public function createPhTebal(Request $request)
    {
        $baru = ph_tebal::create($request->all());

        return response()->json(['message' => 'sukses', 'body' => $baru]);
    }

    public function createPhDetailTebal(Request $request)
    {
        $baru = ph_d_tebal::create($request->all());

        //update selisih
        $data = ph_d_tebal::where('h_tebal_id', $request->h_tebal_id)->get();
        // return response()->json($data);
        $dataSize = sizeof($data);
        $myArray = [];
        for ($j = 0; $j < $dataSize; $j++) {
            for ($i = 1; $i <= 9; $i++) {
                $columnName = 'T' . $i;
                $columnValue = floatVal($data[$j]->$columnName);

                if ($columnValue > 0) {
                    if ($columnValue < 20) {
                        $columnValue += 100;
                    }
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
        $Update = ph_tebal::where('id', '=',  $request->h_tebal_id)->first();
        $Update->populasi = $populasi;
        $Update->save();

        return response()->json(['message' => 'sukses', 'body' => $baru]);
    }

    public function getPhTebal($kode, $shift)
    {
        $Tebal = ph_tebal::with('d_tebal')
            ->where('shift_id', $shift)
            ->where('order_id', $kode)
            ->get();


        return response()->json(['tebal' => $Tebal]);
    }

    public function updateDetailTebal(Request $request, int $id)
    {
        $existing = ph_d_tebal::find($id);

        if ($existing) {
            $data = ph_d_tebal::where('h_tebal_id', $request->h_tebal_id)->get();
            // return response()->json($data);
            $dataSize = sizeof($data);
            $myArray = [];
            for ($j = 0; $j < $dataSize; $j++) {
                for ($i = 1; $i <= 9; $i++) {
                    $columnName = 'T' . $i;
                    $columnValue = floatVal($data[$j]->$columnName);

                    if ($columnValue > 0) {
                        if ($columnValue < 20) {
                            $columnValue += 100;
                        }
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
            $Update = ph_tebal::where('id', '=',  $request->h_tebal_id)->first();
            $Update->populasi = $populasi;
            $Update->save();
            // Update the fields with new values from the request
            $existing->h_tebal_id = $request->h_tebal_id;
            $existing->T1 = $request->T1;
            $existing->T2 = $request->T2;
            $existing->T3 = $request->T3;
            $existing->T4 = $request->T4;
            $existing->T5 = $request->T5;
            $existing->T6 = $request->T6;
            $existing->T7 = $request->T7;
            $existing->T8 = $request->T8;
            $existing->T9 = $request->T9;

            // Save the updated record
            $existing->save();
            return response()->json(['message' => 'sukses', 'body' => $existing]);
        } else {
            return response()->json(['error' => 'Record not found'], 404);
        }
    }

    //set-cool

    public function createPhSetCool(Request $request)
    {
        $baru = ph_setcol::create($request->all());
        return response()->json(['message' => 'sukses', 'body' => $baru]);
    }

    public function getPhSetCool($kode, $shift)
    {
        $val = ph_setcol::where('shift_id', $shift)
            ->where('order_id', $kode)
            ->get();
        return response()->json(['setCol' => $val]);
    }

    public function updatePhSetCool(Request $request, int $id)
    {
        $data = ph_setcol::find($id);
        $data->update($request->all());
        $data->is_confirm = false;
        $data->save();
        return response()->json(['message' => 'sukses', 'body' => $data]);
    }

    public function createPhTempOut(Request $request)
    {
        $baru = ph_temp_out::create($request->all());
        return response()->json(['message' => 'sukses', 'body' => $baru]);
    }

    public function getPhTempOut($kode, $shift)
    {
        $val = ph_temp_out::where('shift_id', $shift)
            ->where('order_id', $kode)
            ->get();
        return response()->json(['tempOut' => $val]);
    }

    public function updatePhTempOut(Request $request, int $id)
    {
        $data = ph_temp_out::find($id);
        $data->update($request->all());
        $data->is_confirm = false;
        $data->save();
        return response()->json(['message' => 'sukses', 'body' => $data]);
    }
}
