<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use App\Models\sr_cek_mesin;
use App\Models\sr_hasil_produksi;
use App\Models\sr_hasil_sortir;
use App\Models\sr_unloading_rk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class adminSrController extends Controller
{
    // Proccess Control
    public function index()
    {
        $hasilProduksis = sr_hasil_produksi::with('user')
            ->whereDate('created_at', Carbon::today())
            ->where('shift_id', 1)
            ->get();
        $hasilSortirs = sr_hasil_sortir::with('user')
            ->whereDate('created_at', Carbon::today())
            ->where('shift_id', 1)
            ->get();
        $cekMesins = sr_cek_mesin::with('user')
            ->whereDate('created_at', Carbon::today())
            ->where('shift_id', 1)
            ->get();

        // Ambil semua data shift
        $shifts = Shift::all();

        // Set default value untuk shift
        $shift = 1;

        // Set default values untuk tanggal
        $date = Carbon::today()->toDateString();

        return view('masters.master_sr.proccess_control.index', compact('hasilProduksis', 'hasilSortirs', 'cekMesins', 'shifts', 'shift', 'date'));
    }

    public function filter(Request $request)
    {
        $date = $request->input('date');
        $shift = $request->input('shift');

        // Set default value for date input
        $date = $date ?: Carbon::today()->toDateString();

        $hasilProduksis = sr_hasil_produksi::with('user')
            ->whereDate('created_at', $date);
        if ($shift) {
            $hasilProduksis->where('shift_id', $shift);
        }
        $hasilProduksis = $hasilProduksis->get();

        $hasilSortirs = sr_hasil_sortir::with('user')
            ->whereDate('created_at', $date);
        if ($shift) {
            $hasilSortirs->where('shift_id', $shift);
        }
        $hasilSortirs = $hasilSortirs->get();

        $cekMesins = sr_cek_mesin::with('user')
            ->whereDate('created_at', $date);
        if ($shift) {
            $cekMesins->where('shift_id', $shift);
        }
        $cekMesins = $cekMesins->get();

        $shifts = Shift::all();

        return view('masters.master_sr.proccess_control.index', compact('hasilProduksis', 'hasilSortirs', 'cekMesins', 'date', 'shift', 'shifts'));
    }

    //unloading -----------------------

    public function indexUnloading()
    {
        $unloadings = sr_unloading_rk::with('user')->get();
        return view('masters.master_sr.unloading.index', ['unloadings' => $unloadings]);
    }

    public function editUnloading(sr_unloading_rk $unloading)
    {
        return view('masters.master_sr.unloading.edit', ['unloading'  => $unloading]);
    }

    public function updateUnloading(Request $request, sr_unloading_rk $unloading)
    {
        // Validations
        // $request->validate([
        //     'first_name'    => 'required',
        //     'last_name'     => 'required',
        //     'email'         => 'required|unique:users,email,'.$user->id.',id',
        //     'mobile_number' => 'required|numeric|digits:10',
        //     'role_id'       =>  'required|exists:roles,id',
        //     'status'       =>  'required|numeric|in:0,1',
        // ]);

        DB::beginTransaction();
        try {

            // Store Data
            $unloading_updated = sr_unloading_rk::whereId($unloading->id)->update([
                'from'      => $request->from,
                'no'      => $request->no,
                'jumlah'      => $request->jumlah,
                'start'      => $request->start,
                'stop'      => $request->stop,
                'menit'      => $request->menit,
                'unloading'      => $request->unloading,
            ]);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('sr.unloading.index')->with('success', 'Data Updated Successfully.');
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function deleteUnloading(sr_unloading_rk $unloading)
    {
        DB::beginTransaction();
        try {
            // Delete User
            sr_unloading_rk::whereId($unloading->id)->delete();

            DB::commit();
            return redirect()->route('sr.unloading.index')->with('success', 'Data Deleted Successfully!.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    //hasil produksi -----------------------

    public function indexHasilProduksi()
    {
        $hasilProduksis = sr_hasil_produksi::with('user')
            ->whereDate('created_at', Carbon::today())
            ->get();

        // Set default values for date inputs
        $start_date = Carbon::today()->toDateString();
        $end_date = Carbon::today()->toDateString();

        // Return the view with hasilProduksis and default date values
        return view('masters.master_sr.hasil_produksi.index', compact('hasilProduksis', 'start_date', 'end_date'));
    }

    public function filterHasilProduksi(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Set default values for date inputs
        $start_date = $start_date ?: Carbon::today()->toDateString();
        $end_date = $end_date ?: Carbon::today()->toDateString();

        $hasilProduksis = sr_hasil_produksi::with('user');

        // Adjusting date format to match the format used by PHPMyAdmin
        $start_date_formatted = date('Y-m-d 00:00:00', strtotime($start_date));
        $end_date_formatted = date('Y-m-d 23:59:59', strtotime($end_date));

        if ($start_date && $end_date) {
            $hasilProduksis->whereBetween('created_at', [$start_date_formatted, $end_date_formatted]);
        }

        $hasilProduksis = $hasilProduksis->get();

        // Pass back the start and end dates to the view
        return view('masters.master_sr.hasil_produksi.index', compact('hasilProduksis', 'start_date', 'end_date'));
    }

    public function editHasilProduksi(sr_hasil_produksi $hasilProduksi)
    {
        return view('masters.master_sr.hasil_produksi.edit', ['hasilProduksi'  => $hasilProduksi]);
    }

    public function updateHasilProduksi(Request $request, sr_hasil_produksi $hasilProduksi)
    {
        // Validations
        // $request->validate([
        //     'first_name'    => 'required',
        //     'last_name'     => 'required',
        //     'email'         => 'required|unique:users,email,'.$user->id.',id',
        //     'mobile_number' => 'required|numeric|digits:10',
        //     'role_id'       =>  'required|exists:roles,id',
        //     'status'       =>  'required|numeric|in:0,1',
        // ]);

        DB::beginTransaction();
        try {

            // Store Data
            $hasilProduksi_updated = sr_hasil_produksi::whereId($hasilProduksi->id)->update([
                'from'      => $request->from,
                'no'      => $request->no,
                'jumlah'      => $request->jumlah,
                'unloading'      => $request->unloading,
                'a'      => $request->a,
                's'      => $request->s,
                'm'      => $request->m,
                'l'      => $request->l,
                'll'      => $request->ll,
                'xm'      => $request->xm,
                'xl'      => $request->xl,
                'b'      => $request->b,
                'e'      => $request->e,
                'g'      => $request->g,
                'h'      => $request->h,
                'f'      => $request->f,
                'c'      => $request->c,
                'q'      => $request->q,
                'kw4'      => $request->kw4,
                'jumlah_total'      => $request->jumlah_total,
                'karton'      => $request->karton,
                'kw4ket'      => $request->kw4ket,
                'bs'      => $request->bs,
                'afal'      => $request->afal,
                'total'      => $request->total,
            ]);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('sr.hasilProduksi.index')->with('success', 'Data Updated Successfully.');
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function deleteHasilProduksi(sr_hasil_produksi $hasilProduksi)
    {
        DB::beginTransaction();
        try {
            // Delete User
            sr_hasil_produksi::whereId($hasilProduksi->id)->delete();

            DB::commit();
            return redirect()->route('sr.hasilProduksi.index')->with('success', 'Data Deleted Successfully!.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    // hasil sortir ----------------

    public function indexHasilSortir()
    {
        $hasilSortirs = sr_hasil_sortir::with('user')
            ->whereDate('created_at', Carbon::today())
            ->get();

        // Set default values for date inputs
        $start_date = Carbon::today()->toDateString();
        $end_date = Carbon::today()->toDateString();

        // Return the view with hasilSortirs and default date values
        return view('masters.master_sr.hasil_sortir.index', compact('hasilSortirs', 'start_date', 'end_date'));
    }

    public function filterHasilSortir(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Set default values for date inputs
        $start_date = $start_date ?: Carbon::today()->toDateString();
        $end_date = $end_date ?: Carbon::today()->toDateString();

        $hasilSortirs = sr_hasil_sortir::with('user');

        // Adjusting date format to match the format used by PHPMyAdmin
        $start_date_formatted = date('Y-m-d 00:00:00', strtotime($start_date));
        $end_date_formatted = date('Y-m-d 23:59:59', strtotime($end_date));

        if ($start_date && $end_date) {
            $hasilSortirs->whereBetween('created_at', [$start_date_formatted, $end_date_formatted]);
        }

        $hasilSortirs = $hasilSortirs->get();

        // Pass back the start and end dates to the view
        return view('masters.master_sr.hasil_sortir.index', compact('hasilSortirs', 'start_date', 'end_date'));
    }

    public function editHasilSortir(sr_hasil_sortir $hasilSortir)
    {
        return view('masters.master_sr.hasil_sortir.edit', ['hasilSortir'  => $hasilSortir]);
    }

    public function updateHasilSortir(Request $request, sr_hasil_sortir $hasilSortir)
    {
        // Validations
        // $request->validate([
        //     'first_name'    => 'required',
        //     'last_name'     => 'required',
        //     'email'         => 'required|unique:users,email,'.$user->id.',id',
        //     'mobile_number' => 'required|numeric|digits:10',
        //     'role_id'       =>  'required|exists:roles,id',
        //     'status'       =>  'required|numeric|in:0,1',
        // ]);

        DB::beginTransaction();
        try {

            // Store Data
            $hasilSortir_updated = sr_hasil_sortir::whereId($hasilSortir->id)->update([
                'description'      => $request->description,
                'pcs'      => $request->pcs,
                'persen'      => $request->persen,
            ]);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('sr.hasilSortir.index')->with('success', 'Data Updated Successfully.');
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function deleteHasilSortir(sr_hasil_sortir $hasilSortir)
    {
        DB::beginTransaction();
        try {
            // Delete User
            sr_hasil_sortir::whereId($hasilSortir->id)->delete();

            DB::commit();
            return redirect()->route('sr.hasilSortir.index')->with('success', 'Data Deleted Successfully!.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    //cek mesin ------------------------------

    public function indexCekMesin()
    {
        $cekMesins = sr_cek_mesin::with('user')
            ->whereDate('created_at', Carbon::today())
            ->get();

        // Set default values for date inputs
        $start_date = Carbon::today()->toDateString();
        $end_date = Carbon::today()->toDateString();

        // Return the view with cekMesins and default date values
        return view('masters.master_sr.cek_mesin.index', compact('cekMesins', 'start_date', 'end_date'));
    }

    public function filterCekMesin(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Set default values for date inputs
        $start_date = $start_date ?: Carbon::today()->toDateString();
        $end_date = $end_date ?: Carbon::today()->toDateString();

        $cekMesins = sr_cek_mesin::with('user');

        // Adjusting date format to match the format used by PHPMyAdmin
        $start_date_formatted = date('Y-m-d 00:00:00', strtotime($start_date));
        $end_date_formatted = date('Y-m-d 23:59:59', strtotime($end_date));

        if ($start_date && $end_date) {
            $cekMesins->whereBetween('created_at', [$start_date_formatted, $end_date_formatted]);
        }

        $cekMesins = $cekMesins->get();

        // Pass back the start and end dates to the view
        return view('masters.master_sr.cek_mesin.index', compact('cekMesins', 'start_date', 'end_date'));
    }

    public function editCekMesin(sr_cek_mesin $cekMesin)
    {
        return view('masters.master_sr.cek_mesin.edit', ['cekMesin'  => $cekMesin]);
    }

    public function updateCekMesin(Request $request, sr_cek_mesin $cekMesin)
    {
        // Validations
        // $request->validate([
        //     'first_name'    => 'required',
        //     'last_name'     => 'required',
        //     'email'         => 'required|unique:users,email,'.$user->id.',id',
        //     'mobile_number' => 'required|numeric|digits:10',
        //     'role_id'       =>  'required|exists:roles,id',
        //     'status'       =>  'required|numeric|in:0,1',
        // ]);

        DB::beginTransaction();
        try {

            // Store Data
            $cekMesin_updated = sr_cek_mesin::whereId($cekMesin->id)->update([
                'mesin'      => $request->mesin,
                'kondisi'      => $request->kondisi,
            ]);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('sr.cekMesin.index')->with('success', 'Data Updated Successfully.');
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function deleteCekMesin(sr_cek_mesin $cekMesin)
    {
        DB::beginTransaction();
        try {
            // Delete User
            sr_cek_mesin::whereId($cekMesin->id)->delete();

            DB::commit();
            return redirect()->route('sr.cekMesin.index')->with('success', 'Data Deleted Successfully!.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
