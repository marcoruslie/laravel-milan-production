<?php

namespace App\Http\Controllers;

use App\Models\detail_qc_po;
use App\Models\Headers;
use App\Models\itp_standards;
use App\Models\list_header_po;
use App\Models\mesin;
use App\Models\Shift;
use App\Models\standard_Ph;
use App\Models\temp_car;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Header as Psr7Header;
use Illuminate\Http\Request;

class ListHeaderController extends Controller
{

    public function createHeader(Request $request)
    {
        $request->validate([
            'po_id' => 'required',
            'po_date' => 'required',
            'material_desc' => 'required',
        ]);

        $baru = list_header_po::create([
            'po_id' => $request->po_id,
            'po_date' => $request->po_date,
            'material_desc' => $request->material_desc,
            'status_qc' => '',
        ]);
        return response()->json(['message' => 'sukses', 'body' => $baru]);
    }

    public function getHeader($date)
    {
        $parsedDate = Carbon::createFromFormat('d F Y', $date);
        $dayBefore = $parsedDate->subDay()->format('d F Y'); // Subtract one day
        $dayAfter = $parsedDate->addDays(2)->format('d F Y'); // Add one day
        $list_header_po = list_header_po::where('po_date', $date)->orWhere('po_date', $dayBefore)->orWhere('po_date', $dayAfter)->get();
        return response()->json(['headerResponse' => $list_header_po]);
    }

    public function getOneHeader($po_id)
    {
        $header = list_header_po::where('po_id', $po_id)->get();
        return response()->json(['headerResponse' => $header]);
    }

    public function updateStatusQcHeader(Request $request, $po_id)
    {
        $header = list_header_po::where('po_id', $po_id)->first();
        $header->status_qc = $request->status_qc;
        $header->user_id = $request->user_id;
        $header->approval_at = Carbon::now();
        $header->save();
        return response()->json(['message' => 'berhasil']);
    }
    public function createDetailQcPo(Request $request)
    {
        $request->validate([
            'po_id' => 'required',
            'nip_user' => 'required',
            'keterangan' => 'required',
            'status' => 'required',
        ]);

        $baru = detail_qc_po::create([
            'po_id' => $request->po_id,
            'nip_user' => $request->nip_user,
            'keterangan' => $request->keterangan,
            'status' => $request->status,
        ]);
        return response()->json(['message' => 'sukses', 'data' => $baru]);
    }
    public function deleteDetailQcPo(Request $request)
    {
        $detail = detail_qc_po::where('id', $request->id)->first();
        $detail->delete();
        return response()->json(['message' => 'berhasil']);
    }
    public function getDetailQcPo($po_id)
    {
        $detail = detail_qc_po::where('po_id', $po_id)->with('user')->get();
        return response()->json(['data' => $detail]);
    }
    public function getOne($kode)
    {
        $header = Headers::where('id', $kode)->first();
        return response()->json(['header' => $header]);
    }

    public function getCar()
    {
        // $car = temp_car::where('status', '0')->get();
        $car = temp_car::all();
        return response()->json(['car' => $car]);
    }

    public function addHeader(Request $request)
    {
        $validated = $request->validate([
            'sales_order' => 'required',
            'tanggal' => 'required',
            'time_start' => 'required',
            'time_stop' => 'required',
            'ph' => 'required',
            'cycle' => 'required',
            'size' => 'required',
            'jenis' => 'required',
            'motive' => 'required',
            'target' => 'required',
            'hasil' => 'required',
            'status' => 'required',
        ]);

        $lastCode = Headers::max('kode');
        $lastSequence = (int)substr($lastCode, 1);
        $nextSequence = $lastSequence + 1;
        $formattedSequence = str_pad($nextSequence, 6, '0', STR_PAD_LEFT);
        $generatedCode = 'K' . $formattedSequence;

        $baru = Headers::create([
            'kode' => $generatedCode,
            'sales_order' => $request->sales_order,
            'tanggal' => $request->tanggal,
            'time_start' => $request->time_start,
            'time_stop' => $request->time_stop,
            'ph' => $request->ph,
            'cycle' => $request->cycle,
            'size' => $request->size,
            'jenis' => $request->jenis,
            'motive' => $request->motive,
            'target' => $request->target,
            'hasil' => $request->hasil,
            'status' => $request->status,
        ]);
        return response()->json([
            'message' => "berhasil",
            'body' => $baru
        ]);
    }
}
