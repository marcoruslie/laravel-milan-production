<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\bp_d_powder;
use App\Models\bp_pengendalian_powder;
use App\Models\bp_pengendalian_slip;
use App\Models\bp_rekap_hasil_powder;
use App\Models\bp_rekap_hasil_slip;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class adminBpController extends Controller
{
    // Proccess Control
    public function index()
    {
        $pengendalianPowders = bp_pengendalian_powder::with('user')
            ->whereDate('created_at', Carbon::today())
            ->where('shift_id', 1)
            ->get();
        $pengendalianSlips = bp_pengendalian_slip::with('user')
            ->whereDate('created_at', Carbon::today())
            ->where('shift_id', 1)
            ->get();
        $rekapPowders = bp_rekap_hasil_powder::with('user')
            ->whereDate('created_at', Carbon::today())
            ->where('shift_id', 1)
            ->get();
        $rekapSlips = bp_rekap_hasil_slip::with('user')
            ->whereDate('created_at', Carbon::today())
            ->where('shift_id', 1)
            ->get();

        // Ambil semua data shift
        $shifts = Shift::all();

        // Set default value untuk shift
        $shift = 1;

        // Set default values untuk tanggal
        $date = Carbon::today()->toDateString();

        return view('masters.master_bp.proccess_control.index', compact('pengendalianPowders', 'pengendalianSlips', 'rekapPowders', 'rekapSlips', 'shifts', 'shift', 'date'));
    }

    public function filter(Request $request)
    {
        $date = $request->input('date');
        $shift = $request->input('shift');

        // Set default value for date input
        $date = $date ?: Carbon::today()->toDateString();

        $pengendalianPowders = bp_pengendalian_powder::with('user')
            ->whereDate('created_at', $date);
        if ($shift) {
            $pengendalianPowders->where('shift_id', $shift);
        }
        $pengendalianPowders = $pengendalianPowders->get();

        $pengendalianSlips = bp_pengendalian_slip::with('user')
            ->whereDate('created_at', $date);
        if ($shift) {
            $pengendalianSlips->where('shift_id', $shift);
        }
        $pengendalianSlips = $pengendalianSlips->get();

        $rekapPowders = bp_rekap_hasil_powder::with('user')
            ->whereDate('created_at', $date);
        if ($shift) {
            $rekapPowders->where('shift_id', $shift);
        }
        $rekapPowders = $rekapPowders->get();

        $rekapSlips = bp_rekap_hasil_slip::with('user')
            ->whereDate('created_at', $date);
        if ($shift) {
            $rekapSlips->where('shift_id', $shift);
        }
        $rekapSlips = $rekapSlips->get();

        $shifts = Shift::all();

        return view('masters.master_bp.proccess_control.index', compact('pengendalianPowders', 'pengendalianSlips', 'rekapSlips', 'rekapPowders', 'date', 'shift', 'shifts'));
    }

    // Pengendalian Slip
    public function indexPengendalianSlip()
    {
        $pengendalianSlips = bp_pengendalian_slip::with('user')
            ->whereDate('created_at', Carbon::today())
            ->get();

        // Set default values for date inputs
        $start_date = Carbon::today()->toDateString();
        $end_date = Carbon::today()->toDateString();

        return view('masters.master_bp.pengendalian_slip.index', compact('pengendalianSlips', 'start_date', 'end_date'));
    }

    public function filterPengendalianSlip(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Set default values for date inputs
        $start_date = $start_date ?: Carbon::today()->toDateString();
        $end_date = $end_date ?: Carbon::today()->toDateString();

        $pengendalianSlips = bp_pengendalian_slip::with('user');

        // Adjusting date format to match the format used by PHPMyAdmin
        $start_date_formatted = date('Y-m-d 00:00:00', strtotime($start_date));
        $end_date_formatted = date('Y-m-d 23:59:59', strtotime($end_date));

        if ($start_date && $end_date) {
            $pengendalianSlips->whereBetween('created_at', [$start_date_formatted, $end_date_formatted]);
        }

        $pengendalianSlips = $pengendalianSlips->get();

        // Pass back the start and end dates to the view
        return view('masters.master_bp.pengendalian_slip.index', compact('pengendalianSlips', 'start_date', 'end_date'));
    }

    public function editPengendalianSlip(bp_pengendalian_slip $pengendalianSlip)
    {
        return view('masters.master_bp.pengendalian_slip.edit', ['pengendalianSlip'  => $pengendalianSlip]);
    }

    public function updatePengendalianSlip(Request $request, bp_pengendalian_slip $pengendalianSlip)
    {
        DB::beginTransaction();
        try {
            // Store Data
            $pengendalian_updated = bp_pengendalian_slip::whereId($pengendalianSlip->id)->update([
                'bm'      => $request->bm,
                'komposisi'      => $request->komposisi,
                'air_liter'      => $request->air_liter,
                'start'      => $request->start,
                'finish'      => $request->finish,
                'sttp'      => $request->sttp,
                'water_glass'      => $request->water_glass,
                'air'      => $request->air,
                'jam_giling'      => $request->jam_giling,
                'alumina'      => $request->alumina,
                'setting_jam_giling'      => $request->setting_jam_giling,
                'total_jam_giling'      => $request->total_jam_giling,
                'masuk_tanki_no'      => $request->masuk_tanki_no,
            ]);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('bp.pengendalianSlip.index')->with('success', 'Data Updated Successfully.');
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function deletePengendalianSlip(bp_pengendalian_slip $pengendalianSlip)
    {
        DB::beginTransaction();
        try {
            // Delete User
            bp_pengendalian_slip::whereId($pengendalianSlip->id)->delete();

            DB::commit();
            return redirect()->route('bp.pengendalianSlip.index')->with('success', 'Data Deleted Successfully!.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    // Pengendalian Powder
    public function indexPengendalianPowder()
    {
        $pengendalianPowders = bp_pengendalian_powder::with('user')
            ->whereDate('created_at', Carbon::today())
            ->get();

        // Set default values for date inputs
        $start_date = Carbon::today()->toDateString();
        $end_date = Carbon::today()->toDateString();

        return view('masters.master_bp.pengendalian_powder.index', compact('pengendalianPowders', 'start_date', 'end_date'));
    }

    public function detailPengendalianPowder(bp_pengendalian_powder $pengendalianPowder)
    {
        $details = bp_d_powder::with('h_pengendalian_powder')
            ->where('pengendalian_id', $pengendalianPowder->id)
            ->get();

        // dd($details);

        return view('masters.master_bp.pengendalian_powder.detail', ['details' => $details]);
    }

    public function filterPengendalianPowder(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Set default values for date inputs
        $start_date = $start_date ?: Carbon::today()->toDateString();
        $end_date = $end_date ?: Carbon::today()->toDateString();

        $pengendalianPowders = bp_pengendalian_powder::with('user');

        // Adjusting date format to match the format used by PHPMyAdmin
        $start_date_formatted = date('Y-m-d 00:00:00', strtotime($start_date));
        $end_date_formatted = date('Y-m-d 23:59:59', strtotime($end_date));

        if ($start_date && $end_date) {
            $pengendalianPowders->whereBetween('created_at', [$start_date_formatted, $end_date_formatted]);
        }

        $pengendalianPowders = $pengendalianPowders->get();

        // Pass back the start and end dates to the view
        return view('masters.master_bp.pengendalian_powder.index', compact('pengendalianPowders', 'start_date', 'end_date'));
    }

    public function editPengendalianPowder(bp_pengendalian_powder $pengendalianPowder)
    {
        return view('masters.master_bp.pengendalian_powder.edit', ['pengendalianPowder'  => $pengendalianPowder]);
    }

    public function updatePengendalianPowder(Request $request, bp_pengendalian_powder $pengendalianPowder)
    {
        DB::beginTransaction();
        try {
            // Store Data
            $pengendalian_updated = bp_pengendalian_powder::whereId($pengendalianPowder->id)->update([
                'start_spray'      => $request->start_spray,
                'powder_masuk'      => $request->powder_masuk,
                'stop_spray'      => $request->stop_spray,
                'dari_tanki'      => $request->dari_tanki,
                'ke_tanki'      => $request->ke_tanki,
                'reologi'      => $request->reologi,
                'kapasitas'      => $request->kapasitas,
                'granulasi'      => $request->granulasi,
                'indicator'      => $request->indicator,
                'nozle_1'      => $request->nozle_1,
                'nozle_2'      => $request->nozle_2,
                'jumlah'      => $request->jumlah,
            ]);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('bp.pengendalianPowder.index')->with('success', 'Data Updated Successfully.');
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function deletePengendalianPowder(bp_pengendalian_powder $pengendalianPowder)
    {
        DB::beginTransaction();
        try {
            // Delete User
            bp_pengendalian_powder::whereId($pengendalianPowder->id)->delete();

            DB::commit();
            return redirect()->route('bp.pengendalianPowder.index')->with('success', 'Data Deleted Successfully!.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    // Rekap Slip
    public function indexRekapSlip()
    {
        $rekapSlips = bp_rekap_hasil_slip::with('user')
            ->whereDate('created_at', Carbon::today())
            ->get();

        // Set default values for date inputs
        $start_date = Carbon::today()->toDateString();
        $end_date = Carbon::today()->toDateString();

        return view('masters.master_bp.rekap_slip.index', compact('rekapSlips', 'start_date', 'end_date'));
    }

    public function filterRekapSlip(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Set default values for date inputs
        $start_date = $start_date ?: Carbon::today()->toDateString();
        $end_date = $end_date ?: Carbon::today()->toDateString();

        $rekapSlips = bp_rekap_hasil_slip::with('user');

        // Adjusting date format to match the format used by PHPMyAdmin
        $start_date_formatted = date('Y-m-d 00:00:00', strtotime($start_date));
        $end_date_formatted = date('Y-m-d 23:59:59', strtotime($end_date));

        if ($start_date && $end_date) {
            $rekapSlips->whereBetween('created_at', [$start_date_formatted, $end_date_formatted]);
        }

        $rekapSlips = $rekapSlips->get();

        // Pass back the start and end dates to the view
        return view('masters.master_bp.rekap_slip.index', compact('rekapSlips', 'start_date', 'end_date'));
    }

    public function editRekapSlip(bp_rekap_hasil_slip $rekapSlip)
    {
        return view('masters.master_bp.rekap_slip.edit', ['rekapSlip'  => $rekapSlip]);
    }

    public function updateRekapSlip(Request $request, bp_rekap_hasil_slip $rekapSlip)
    {
        DB::beginTransaction();
        try {
            // Store Data
            $rekap_updated = bp_rekap_hasil_slip::whereId($rekapSlip->id)->update([
                'komposisi_body'      => $request->komposisi_body,
                'tab'      => $request->tab,
                'a2'      => $request->a2,
                'a3'      => $request->a3,
                'a4'      => $request->a4,
                'b1'      => $request->b1,
                'b4'      => $request->b4,
                'b5'      => $request->b5,
            ]);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('bp.rekapSlip.index')->with('success', 'Data Updated Successfully.');
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function deleteRekapSlip(bp_rekap_hasil_slip $rekapSlip)
    {
        DB::beginTransaction();
        try {
            // Delete User
            bp_rekap_hasil_slip::whereId($rekapSlip->id)->delete();

            DB::commit();
            return redirect()->route('bp.rekapSlip.index')->with('success', 'Data Deleted Successfully!.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    // Rekap Powder
    public function indexRekapPowder()
    {
        $rekapPowders = bp_rekap_hasil_powder::with('user')
            ->whereDate('created_at', Carbon::today())
            ->get();

        // Set default values for date inputs
        $start_date = Carbon::today()->toDateString();
        $end_date = Carbon::today()->toDateString();

        return view('masters.master_bp.rekap_powder.index', compact('rekapPowders', 'start_date', 'end_date'));
    }

    public function filterRekapPowder(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Set default values for date inputs
        $start_date = $start_date ?: Carbon::today()->toDateString();
        $end_date = $end_date ?: Carbon::today()->toDateString();

        $rekapPowders = bp_rekap_hasil_powder::with('user');

        // Adjusting date format to match the format used by PHPMyAdmin
        $start_date_formatted = date('Y-m-d 00:00:00', strtotime($start_date));
        $end_date_formatted = date('Y-m-d 23:59:59', strtotime($end_date));

        if ($start_date && $end_date) {
            $rekapPowders->whereBetween('created_at', [$start_date_formatted, $end_date_formatted]);
        }

        $rekapPowders = $rekapPowders->get();

        // Pass back the start and end dates to the view
        return view('masters.master_bp.rekap_powder.index', compact('rekapPowders', 'start_date', 'end_date'));
    }

    public function editRekapPowder(bp_rekap_hasil_powder $rekapPowder)
    {
        return view('masters.master_bp.rekap_powder.edit', ['rekapPowder'  => $rekapPowder]);
    }

    public function updateRekapPowder(Request $request, bp_rekap_hasil_powder $rekapPowder)
    {
        DB::beginTransaction();
        try {
            // Store Data
            $rekap_updated = bp_rekap_hasil_powder::whereId($rekapPowder->id)->update([
                'stok1'      => $request->stok1,
                'stok2'      => $request->stok2,
                'stok3'      => $request->stok3,
                'stok4'      => $request->stok4,
                'stok5'      => $request->stok5,
                'total_powder'      => $request->total_powder,
                'atm40'      => $request->atm40,
                'kapasitas40'      => $request->kapasitas40,
                'atm90'      => $request->atm90,
                'kapasitas90'      => $request->kapasitas90,
            ]);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('bp.rekapPowder.index')->with('success', 'Data Updated Successfully.');
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function deleteRekapPowder(bp_rekap_hasil_powder $rekapPowder)
    {
        DB::beginTransaction();
        try {
            // Delete User
            bp_rekap_hasil_powder::whereId($rekapPowder->id)->delete();

            DB::commit();
            return redirect()->route('bp.rekapPowder.index')->with('success', 'Data Deleted Successfully!.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
