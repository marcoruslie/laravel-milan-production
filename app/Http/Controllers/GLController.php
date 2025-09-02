<?php

namespace App\Http\Controllers;

use App\Models\confirmation_log;
use App\Models\gl_analisa_tes_bakar;
use App\Models\gl_hasil_produksi;
use App\Models\gl_pengendalian_proses;
use App\Models\temp_car;
use Illuminate\Http\Request;

class GLController extends Controller
{
    //confirm
    public function confirmGl(Request $request)
    {
        if ($request->form == 'loading') {
            gl_hasil_produksi::where('order_id', $request->order)
                ->where('shift_id', $request->shift)
                ->update(['is_confirm' => true]);
        } else if ($request->form == 'analisa') {
            gl_analisa_tes_bakar::where('order_id', $request->order)
                ->where('shift_id', $request->shift)
                ->update(['is_confirm' => true]);
        } else if ($request->form == 'pengendalian') {
            gl_pengendalian_proses::where('order_id', $request->order)
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

    //hasil produksi
    // public function createGlHasilProduksi(Request $request)
    // {
    //     if ($request->from == 'Car') {
    //         $UpdateCar = temp_car::where('nocar', '=',  $request->no)->first();
    //         if ($UpdateCar->status == '0') {
    //             $UpdateCar->status = $request->jumlah;
    //             $UpdateCar->assign_to = 'RK';
    //             $UpdateCar->save();
    //         } else {
    //             return response()->json(['message' => 'Car sedang tidak available!'], 422);
    //         }
    //     }
    //     $baru = gl_hasil_produksi::create($request->all());

    //     return response()->json(['message' => 'sukses', 'body' => $baru]);
    // }

    //hasil produksi
    public function createGlHasilProduksi(Request $request)
    {
        if ($request->from == 'Car') {
            $UpdateCar = temp_car::where('nocar', '=',  $request->no)->first();
            $UpdateCar->status = $request->jumlah;
            $UpdateCar->assign_to = 'RK';
            $UpdateCar->save();
        }
        $baru = gl_hasil_produksi::create($request->all());

        return response()->json(['message' => 'sukses', 'body' => $baru]);
    }

    public function getGlHasilProduksi($kode, $shift)
    {
        $val = gl_hasil_produksi::where('shift_id', $shift)
            ->where('order_id', $kode)
            ->get();
        return response()->json(['hasilGl' => $val]);
    }

    public function getAllGlHasilProduksi()
    {
        $val = gl_hasil_produksi::all();
        return response()->json(['hasilGl' => $val]);
    }

    // public function updateGlHasilProduksi(Request $request, int $id)
    // {
    //     $data = gl_hasil_produksi::find($id);
    //     $cekstatus = temp_car::find($data->no);
    //     if ($cekstatus->assign_to == 'RK') {
    //         if ($data->no != $request->no) {
    //             $cekCar = temp_car::find($request->no);
    //             if ($cekCar->status == 0) {
    //                 $cekCar->status = $request->jumlah;
    //                 $cekCar->assign_to = 'RK';
    //                 $cekCar->save();
    //                 $cekstatus->status = 0;
    //                 $cekstatus->assign_to = '-';
    //                 $cekstatus->save();
    //                 $data->update($request->all());
    //                 return response()->json(['message' => 'sukses', 'body' => $data]);
    //             }
    //         } else {
    //             $cekstatus->status = $request->jumlah;
    //             $cekstatus->save();
    //             $data->update($request->all());
    //             return response()->json(['message' => 'sukses', 'body' => $data]);
    //         }
    //     }
    // }

    public function updateGlHasilProduksi(Request $request, int $id)
    {
        $data = gl_hasil_produksi::find($id);
        $cekstatus = temp_car::find($data->no);
        if ($cekstatus->assign_to == 'RK') {
            if ($data->no != $request->no) {
                $cekCar = temp_car::find($request->no);
                $cekCar->status = $request->jumlah;
                $cekCar->assign_to = 'RK';
                $cekCar->save();
                $cekstatus->status = 0;
                $cekstatus->assign_to = '-';
                $cekstatus->save();
                $data->update($request->all());
                $data->is_confirm = false;
                $data->save();
                return response()->json(['message' => 'sukses', 'body' => $data]);
            } else {
                $cekstatus->status = $request->jumlah;
                $cekstatus->save();
                $data->update($request->all());
                $data->is_confirm = false;
                $data->save();
                return response()->json(['message' => 'sukses', 'body' => $data]);
            }
        }
    }

    //pengendalian proses

    public function createGlPengendalian(Request $request)
    {
        $baru = gl_pengendalian_proses::create($request->all());
        return response()->json(['message' => 'sukses', 'body' => $baru]);
    }

    public function getGlPengendalian($kode, $shift)
    {
        $val = gl_pengendalian_proses::where('shift_id', $shift)
            ->where('order_id', $kode)
            ->get();
        return response()->json(['pengendalian' => $val]);
    }

    public function updateGlPengendalian(Request $request, int $id)
    {
        $data = gl_pengendalian_proses::find($id);
        $data->update($request->all());
        $data->is_confirm = false;
        $data->save();
        return response()->json(['message' => 'sukses', 'body' => $data]);
    }

    //analisa tes bakar

    public function createGlAnalisaTesBakar(Request $request)
    {
        $baru = gl_analisa_tes_bakar::create($request->all());
        return response()->json(['message' => 'sukses', 'body' => $baru]);
    }

    public function getGlAnalisaTesBakar($kode, $shift)
    {
        $val = gl_analisa_tes_bakar::where('shift_id', $shift)
            ->where('order_id', $kode)
            ->get();
        return response()->json(['analisa' => $val]);
    }

    public function updateGlAnalisaTesBakar(Request $request, int $id)
    {
        $data = gl_analisa_tes_bakar::find($id);
        $data->update($request->all());
        $data->is_confirm = false;
        $data->save();
        return response()->json(['message' => 'sukses', 'body' => $data]);
    }
}
