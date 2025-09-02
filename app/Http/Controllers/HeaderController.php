<?php

namespace App\Http\Controllers;

use App\Models\Headers;
use App\Models\itp_standards;
use App\Models\list_header_po;
use App\Models\mesin;
use App\Models\Shift;
use App\Models\standard_Ph;
use App\Models\temp_car;
use App\Nova\header;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Header as Psr7Header;
use Illuminate\Http\Request;

class HeaderController extends Controller
{


    public function getHeader($date)
    {
        $parsedDate = Carbon::createFromFormat('d F Y', $date);
        $dayBefore = $parsedDate->subDay()->format('d F Y'); // Subtract one day
        $dayAfter = $parsedDate->addDays(2)->format('d F Y'); // Add one day
        $list_header_po = list_header_po::where('po_date', $date)->orWhere('po_date', $dayBefore)->orWhere('po_date', $dayAfter)->get();
        return response()->json(['headerResponse' => $list_header_po]);
    }

    public function getAllbyPh($ph)
    {
        $header = Headers::where('ph', $ph)->get();
        return response()->json(['header' => $header]);
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
