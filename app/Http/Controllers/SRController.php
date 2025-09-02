<?php

namespace App\Http\Controllers;

use App\Models\confirmation_log;
use App\Models\sr_analisa_kualitas;
use App\Models\sr_cek_mesin;
use App\Models\sr_hasil_produksi;
use App\Models\sr_hasil_sortir;
use App\Models\sr_jenis_cacat;
use App\Models\sr_list_kualitas;
use App\Models\sr_loading_rk;
use App\Models\sr_unloading_rk;
use App\Models\temp_car;
use Illuminate\Http\Request;

class SRController extends Controller
{
    // FUCNTION SR CONFIRMATION
    public function confirmSr(Request $request)
    {
        if ($request->form == 'hasil produksi') {
            sr_hasil_produksi::where('order_id', $request->order)
                ->where('shift_id', $request->shift)
                ->update(['is_confirm' => true]);
        } else if ($request->form == 'hasil sortir') {
            sr_hasil_sortir::where('order_id', $request->order)
                ->where('shift_id', $request->shift)
                ->update(['is_confirm' => true]);
        } else if ($request->form == 'cek') {
            sr_cek_mesin::where('order_id', $request->order)
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

    // FUNCTION FOR SR HASIL PRODUKSI
    public function createSrHasilProduksi(Request $request)
    {

        $baru = sr_hasil_produksi::create($request->all());
        if ($request->from == 'Car') {
            $update = temp_car::where('id', '=',  $request->no)->first();
            if ($update->status - $request->unloading == 0) {
                $update->status = 0;
                $update->assign_to = '-';
            } else {
                $update->status = $update->status - $request->unloading;
            }
            $update->save();
        }
        return response()->json(['message' => 'sukses', 'body' => $baru]);
    }
    public function getSrHasilProduksi($kode, $shift)
    {
        $val = sr_hasil_produksi::where('shift_id', $shift)
            ->where('order_id', $kode)
            ->get();
        return response()->json(['hasil' => $val]);
    }

    // FUNCTION FOR SR LOADING RK
    public function getSrUnloadingRk($kode, $shift)
    {
        $val = sr_unloading_rk::where('shift_id', $shift)
            ->where('order_id', $kode)
            ->get();
        return response()->json(['unloadingRk' => $val]);
    }
    public function createSrUnloadingRk(Request $request)
    {
        $baru = sr_unloading_rk::create($request->all());

        if ($request->from == 'Car') {
            $update = temp_car::where('id', '=',  $request->no)->first();
            if ($update->status - $request->unloading == 0) {
                $update->status = 0;
                $update->assign_to = '-';
            } else {
                $update->status = $update->status - $request->unloading;
            }
            $update->save();
        }
        return response()->json(['message' => 'sukses', 'body' => $baru]);
    }
    public function accSrHasilProduksi(Request $request)
    {
        $Update = temp_car::where('id', '=',  $request->no)->first();
        $Update->assign_to = $request->assign;
        $Update->save();

        return response()->json(['message' => 'sukses', 'body' => $Update]);
    }

    // FUCNTION FOR SR HASIL SORTIR
    public function createSrHasilSortir(Request $request)
    {
        $baru = sr_hasil_sortir::create($request->all());
        return response()->json(['message' => 'sukses', 'body' => $baru]);
    }
    public function getSrHasilSortir($kode, $shift)
    {
        $val = sr_hasil_sortir::where('shift_id', $shift)
            ->where('order_id', $kode)
            ->get();
        return response()->json(['sortir' => $val]);
    }
    public function updateSrHasilSortir(Request $request, int $id)
    {
        $data = sr_hasil_sortir::find($id);
        $data->update($request->all());
        $data->is_confirm = false;
        $data->save();
        return response()->json(['message' => 'sukses', 'body' => $data]);
    }

    // FUCNTION FOR SR CEK MESIN
    public function createSrCekMesin(Request $request)
    {
        $baru = sr_cek_mesin::create($request->all());
        return response()->json(['message' => 'sukses', 'body' => $baru]);
    }
    public function getSrCekMesin($kode, $shift)
    {
        $val = sr_cek_mesin::where('shift_id', $shift)
            ->where('order_id', $kode)
            ->get();
        return response()->json(['mesin' => $val]);
    }
    public function updateSrCekMesin(Request $request, int $id)
    {
        $data = sr_cek_mesin::find($id);
        $data->update($request->all());
        $data->is_confirm = false;
        $data->save();
        return response()->json(['message' => 'sukses', 'body' => $data]);
    }

    // FUCNTION FOR SR ANALISA KUALITAS TILE
    public function createAnalisaKualitas(Request $request)
    {
        // CHECK EXISTING DATA FROM ID
        $check = sr_analisa_kualitas::where('id', $request->id)->first();
        if ($check) {
            $update = sr_analisa_kualitas::find($request->id);
            $update->update($request->all());
            $update->save();
            return response()->json(['message' => 'sukses edit', 'check' => $check, 'analisa' => $update]);
        } else {
            $baru = sr_analisa_kualitas::create($request->all());
            return response()->json(['message' => 'sukses tambah', 'check' => $check, 'analisa' => $baru]);
        }
    }
    public function getAnalisaKualitas($order_id)
    {
        $val = sr_analisa_kualitas::where('order_id', $order_id)->get();
        return response()->json(['analisa' => $val]);
    }
    public function updateAnalisaKualitas(Request $request, $id)
    {
        $data = sr_analisa_kualitas::find($id);
        $data->update($request->all());
        $data->save();
        return response()->json(['message' => 'sukses', 'analisa' => $data]);
    }

    // FUNCTION FOR SR LIST ANALISA KUALITAS
    public function createListAnalisaKualitas(Request $request)
    {
        $baru = sr_list_kualitas::create($request->all());
        return response()->json(['message' => 'sukses', 'data' => $baru]);
    }
    public function getListAnalisaKualitas($id)
    {
        $val = sr_list_kualitas::where('sr_analisa_id', $id)->get();
        return response()->json(['list' => $val]);
    }
    public function deleteListAnalisaKualitas(Request $request)
    {
        $data = sr_list_kualitas::find($request->id);
        $data->delete();
        return response()->json(['message' => 'sukses']);
    }
    public function updateListAnalisaKualitas($id, Request $request)
    {
        $data = sr_list_kualitas::find($id);
        $data->update($request->all());
        $data->save();
        return response()->json(['message' => 'sukses', 'data' => $data]);
    }
    // FUNCTION FOR JENIS CACAT
    public function getJenisCacat()
    {
        $val = sr_jenis_cacat::all()->unique('jenis_cacat');
        return response()->json(['jenis' => $val]);
    }
    public function getJenisCacatByAnalisa($id)
    {
        $val = sr_list_kualitas::select('jenis_cacat')->where('sr_analisa_id', $id)->distinct()->get();
        return response()->json(['jenis' => $val]);
    }
    public function createJenisCacat(Request $request)
    {
        $baru = sr_list_kualitas::create($request->all());
        return response()->json(['message' => 'sukses', 'data' => $baru]);
    }
}
