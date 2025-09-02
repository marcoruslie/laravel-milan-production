<?php

namespace App\Http\Controllers;

use App\Models\bp_d_powder;
use App\Models\bp_pengendalian_powder;
use App\Models\bp_pengendalian_slip;
use App\Models\bp_rekap_hasil_powder;
use App\Models\bp_rekap_hasil_slip;
use App\Models\confirmation_log;
use Illuminate\Http\Request;

class BPController extends Controller
{
    //confirm
    public function confirmBp(Request $request)
    {
        if ($request->form == 'rekap powder') {
            bp_rekap_hasil_powder::where('order_id', $request->order)
                ->where('shift_id', $request->shift)
                ->update(['is_confirm' => true]);
        } else if ($request->form == 'rekap slip') {
            bp_rekap_hasil_slip::where('order_id', $request->order)
                ->where('shift_id', $request->shift)
                ->update(['is_confirm' => true]);
        } else if ($request->form == 'pengendalian powder') {
            bp_pengendalian_powder::where('order_id', $request->order)
                ->where('shift_id', $request->shift)
                ->update(['is_confirm' => true]);
        } else if ($request->form == 'pengendalian slip') {
            bp_pengendalian_slip::where('order_id', $request->order)
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

    public function createBpPengendalianSlip(Request $request)
    {
        $baru = bp_pengendalian_slip::create($request->all());
        return response()->json(['message' => 'sukses', 'body' => $baru]);
    }

    public function getBpPengendalianSlip($kode, $shift)
    {
        $val = bp_pengendalian_slip::where('shift_id', $shift)
            ->where('order_id', $kode)
            ->get();
        return response()->json(['pengendalian' => $val]);
    }

    public function updateBpPengendalianSlip(Request $request, int $id)
    {
        $data = bp_pengendalian_slip::find($id);
        $data->update($request->all());
        $data->is_confirm = false;
        $data->save();
        return response()->json(['message' => 'sukses', 'body' => $data]);
    }

    public function createBpPengendalianPowder(Request $request)
    {
        $baru = bp_pengendalian_powder::create($request->all());
        return response()->json(['message' => 'sukses', 'body' => $baru]);
    }

    public function createBpDetailPengendalianPowder(Request $request)
    {
        $baru = bp_d_powder::create($request->all());
        return response()->json(['message' => 'sukses', 'body' => $baru]);
    }

    public function getBpPengendalianPowder($kode, $shift)
    {
        $val = bp_pengendalian_powder::with('detail_powder')
            ->where('shift_id', $shift)
            ->where('order_id', $kode)
            ->get();
        return response()->json(['pengendalian' => $val]);
    }

    public function updateBpPengendalianPowder(Request $request, int $id)
    {
        $data = bp_pengendalian_powder::find($id);
        $data->update($request->all());
        $data->is_confirm = false;
        $data->save();
        return response()->json(['message' => 'sukses', 'body' => $data]);
    }

    public function updateBpDetailPengendalianPowder(Request $request, int $id)
    {
        $data = bp_d_powder::find($id);
        $data->update($request->all());
        return response()->json(['message' => 'sukses', 'body' => $data]);
    }

    public function createBpRekapSlip(Request $request)
    {
        $baru = bp_rekap_hasil_slip::create($request->all());
        return response()->json(['message' => 'sukses', 'body' => $baru]);
    }

    public function getBpRekapSlip($kode, $shift)
    {
        $val = bp_rekap_hasil_slip::where('shift_id', $shift)
            ->where('order_id', $kode)
            ->get();
        return response()->json(['rekap' => $val]);
    }

    public function updateBpRekapSlip(Request $request, int $id)
    {
        $data = bp_rekap_hasil_slip::find($id);
        $data->update($request->all());
        $data->is_confirm = false;
        $data->save();
        return response()->json(['message' => 'sukses', 'body' => $data]);
    }

    public function createBpRekapPowder(Request $request)
    {
        $baru = bp_rekap_hasil_powder::create($request->all());
        return response()->json(['message' => 'sukses', 'body' => $baru]);
    }

    public function getBpRekapPowder($kode, $shift)
    {
        $val = bp_rekap_hasil_powder::where('shift_id', $shift)
            ->where('order_id', $kode)
            ->get();
        return response()->json(['rekap' => $val]);
    }

    public function updateBpRekapPowder(Request $request, int $id)
    {
        $data = bp_rekap_hasil_powder::find($id);
        $data->update($request->all());
        $data->is_confirm = false;
        $data->save();
        return response()->json(['message' => 'sukses', 'body' => $data]);
    }
}
