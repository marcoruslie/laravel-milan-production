<?php

namespace App\Http\Controllers;

use App\Models\qc_ballmill;
use App\Models\qc_dalam_box_hasil_sortir;
use App\Models\qc_detail_tile_out;
use App\Models\qc_laporan_pengecekan_gl;
use App\Models\qc_pengamatan_tes_bakar_gl;
use App\Models\qc_pengecekan_dimensi_sr;
use App\Models\qc_pengecekan_pembacaan_sr;
use App\Models\qc_pengecekan_tile_out;
use App\Models\qc_spraydryer;
use Illuminate\Http\Request;

class qcController extends Controller
{
    public function createQcBallMill(Request $request)
    {
        $baru = qc_ballmill::create($request->all());
        return response()->json(['message' => 'sukses', 'body' => $baru]);
    }

    public function getQcBallMill($kode, $shift)
    {
        $val = qc_ballmill::where('shift_id', $shift)
            ->where('order_id', $kode)
            ->get();
        return response()->json(['ballmill' => $val]);
    }

    public function updateQcBallMill(Request $request, int $id)
    {
        $data = qc_ballmill::find($id);
        $data->update($request->all());
        return response()->json(['message' => 'sukses', 'body' => $data]);
    }

    public function createQcPengecekanGl(Request $request)
    {
        $baru = qc_laporan_pengecekan_gl::create($request->all());
        return response()->json(['message' => 'sukses', 'body' => $baru]);
    }

    public function getQcPengecekanGl($kode, $shift)
    {
        $val = qc_laporan_pengecekan_gl::where('shift_id', $shift)
            ->where('order_id', $kode)
            ->get();
        return response()->json(['gl' => $val]);
    }

    public function updateQcPengecekanGl(Request $request, int $id)
    {
        $data = qc_laporan_pengecekan_gl::find($id);
        $data->update($request->all());
        return response()->json(['message' => 'sukses', 'body' => $data]);
    }

    public function createQcPengamatanGl(Request $request)
    {
        $baru = qc_pengamatan_tes_bakar_gl::create($request->all());
        return response()->json(['message' => 'sukses', 'body' => $baru]);
    }

    public function getQcPengamatanGl($kode, $shift)
    {
        $val = qc_pengamatan_tes_bakar_gl::where('shift_id', $shift)
            ->where('order_id', $kode)
            ->get();
        return response()->json(['pengamatan' => $val]);
    }

    public function updateQcPengamatanGl(Request $request, int $id)
    {
        $data = qc_pengamatan_tes_bakar_gl::find($id);
        $data->update($request->all());
        return response()->json(['message' => 'sukses', 'body' => $data]);
    }

    public function createQcPengecekanDimensi(Request $request)
    {
        $baru = qc_pengecekan_dimensi_sr::create($request->all());
        return response()->json(['message' => 'sukses', 'body' => $baru]);
    }

    public function getQcPengecekanDimensi($kode, $shift)
    {
        $val = qc_pengecekan_dimensi_sr::where('shift_id', $shift)
            ->where('order_id', $kode)
            ->get();
        return response()->json(['dimensi' => $val]);
    }

    public function updateQcPengecekanDimensi(Request $request, int $id)
    {
        $data = qc_pengecekan_dimensi_sr::find($id);
        $data->update($request->all());
        return response()->json(['message' => 'sukses', 'body' => $data]);
    }

    public function createQcPengecekanPembacaan(Request $request)
    {
        $baru = qc_pengecekan_pembacaan_sr::create($request->all());
        return response()->json(['message' => 'sukses', 'body' => $baru]);
    }

    public function getQcPengecekanPembacaan($kode, $shift)
    {
        $val = qc_pengecekan_pembacaan_sr::where('shift_id', $shift)
            ->where('order_id', $kode)
            ->get();
        return response()->json(['baca' => $val]);
    }

    public function updateQcPengecekanPembacaan(Request $request, int $id)
    {
        $data = qc_pengecekan_pembacaan_sr::find($id);
        $data->update($request->all());
        return response()->json(['message' => 'sukses', 'body' => $data]);
    }

    public function createQcDalamBox(Request $request)
    {
        $baru = qc_dalam_box_hasil_sortir::create($request->all());
        return response()->json(['message' => 'sukses', 'body' => $baru]);
    }

    public function getQcDalamBox($kode, $shift)
    {
        $val = qc_dalam_box_hasil_sortir::where('shift_id', $shift)
            ->where('order_id', $kode)
            ->get();
        return response()->json(['box' => $val]);
    }

    public function updateQcDalamBox(Request $request, int $id)
    {
        $data = qc_dalam_box_hasil_sortir::find($id);
        $data->update($request->all());
        return response()->json(['message' => 'sukses', 'body' => $data]);
    }

    public function createQcCekTileOut(Request $request)
    {
        $baru = qc_pengecekan_tile_out::create($request->all());
        return response()->json(['message' => 'sukses', 'body' => $baru]);
    }

    public function createDetailQcCekTileOut(Request $request)
    {
        $baru = qc_detail_tile_out::create($request->all());
        return response()->json(['message' => 'sukses', 'body' => $baru]);
    }

    public function getQcCekTileOut($kode, $shift)
    {
        $val = qc_pengecekan_tile_out::with('d_tile')
            ->where('shift_id', $shift)
            ->where('order_id', $kode)
            ->get();
        return response()->json(['tiles' => $val]);
    }

    public function updateQcCekTileOut(Request $request, int $id)
    {
        $data = qc_pengecekan_tile_out::find($id);
        $data->update($request->all());
        return response()->json(['message' => 'sukses', 'body' => $data]);
    }

    public function updateDetailQcCekTileOut(Request $request, int $id)
    {
        $data = qc_detail_tile_out::find($id);
        $data->update($request->all());
        return response()->json(['message' => 'sukses', 'body' => $data]);
    }
}
