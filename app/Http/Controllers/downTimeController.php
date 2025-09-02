<?php

namespace App\Http\Controllers;

use App\Models\down_time;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class downTimeController extends Controller
{
    public function createDownTime(Request $request)
    {
        $baru = down_time::create($request->all());
        return response()->json(['message' => 'sukses', 'body' => $baru]);
    }

    public function getDownTime($mesin, $order)
    {
        $val = down_time::where('order_id', $order)
            ->where('work_center', $mesin)
            ->get();


        return response()->json(['time' => $val]);
    }

    public function updateDownTime(Request $request, int $id)
    {
        $data = down_time::find($id);
        $data->update($request->all());

        if ($request->status == 1) {
            try {
                $response = Http::timeout(50)
                    ->get('http://172.31.3.13/ci-milan-restserver/index.php/inputdowntime', [
                        'order' => $request->order_id,
                        'workcenter' => $request->work_center,
                        'startdate' => $request->start_date,
                        'starttime' => $request->start_time,
                        'respdate' => $request->respond_date,
                        'resptime' => $request->respond_time,
                        'finishdate' => $request->finish_date,
                        'finishtime' => $request->finish_time,
                        'reason' => $request->grund,
                        'desc' => $request->lngtxt
                    ]);
                // print($response);
                if ($response) {
                    return response()->json(['message' => 'sukses', 'body' => $data]);
                }
            } catch (\Exception $e) {
                // Catch and log any exceptions
                Log::error('API Request exception: ', ['message' => $e->getMessage()]);
            }
        }

        return response()->json(['message' => 'sukses', 'body' => $data]);
    }
}
