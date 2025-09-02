<?php

namespace App\Http\Controllers;

use App\Models\report_target_produksi;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function getReport(Request $request)
    {
        $val = report_target_produksi::where('po_date', $request->po_date)->where('po_id', $request->po_id)->get();
        return response()->json(['reportResponse' => $val]);
    }
    public function getReportById($po_id)
    {
        $val = report_target_produksi::where('po_id', $po_id)->orderBy('start_hour', 'desc')->get();
        return response()->json(['reportResponse' => $val]);
    }
    public function getReportHasil($po_id, $po_date, $start_hour)
    {
        $val = report_target_produksi::where('po_id', $po_id)->where('po_date', $po_date)->where('start_hour', $start_hour)->first();
        return response()->json(['reportResponse' => $val]);
    }
    public function addReport(Request $request)
    {
        $val = report_target_produksi::create([
            'po_id' => $request->po_id,
            'po_date' => $request->po_date,
            'start_hour' => $request->start_hour,
            'material_desc' => $request->material_desc,
            'hasil' => $request->hasil,
            'target' => $request->target,
            'keterangan' => $request->keterangan,
        ]);
        return response()->json(['reportResponse' => $val]);
    }
    public function updateReport(Request $request)
    {
        $val = report_target_produksi::where('id', $request->id)->first();
        $val->hasil = $request->hasil;
        $val->keterangan = $request->keterangan;
        $val->save();
        return response()->json(['reportResponse' => $val]);
    }
}
