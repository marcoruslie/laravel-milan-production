<?php

namespace App\Http\Controllers;

use App\Models\report_target_produksi;
use Illuminate\Http\Request;

class ReportPengawasController extends Controller
{
    public function getReportAbsensi()
    {
        return view('report.absensi_karu');
    }
    public function getReportHasilProduksi()
    {
        return view('report.hasil_produksi');
    }
}
