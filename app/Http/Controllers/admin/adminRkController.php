<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\rk_cek_gumpil;
use App\Models\rk_d_koreksi;
use App\Models\rk_hasil_produksi;
use App\Models\rk_koreksi_tile;
use App\Models\rk_pengendalian_proses;
use App\Models\rk_unloading_hasil_produksi_gl;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class adminRkController extends Controller
{
    // Proccess Control
    public function index()
    {
        $unloadings = rk_unloading_hasil_produksi_gl::with('user')
            ->whereDate('created_at', Carbon::today())
            ->where('shift_id', 1)
            ->get();
        $loadings = rk_hasil_produksi::with('user')
            ->whereDate('created_at', Carbon::today())
            ->where('shift_id', 1)
            ->get();
        $koreksis = rk_koreksi_tile::with('user')
            ->whereDate('created_at', Carbon::today())
            ->where('shift_id', 1)
            ->get();
        $pengendalians = rk_pengendalian_proses::with('user')
            ->whereDate('created_at', Carbon::today())
            ->where('shift_id', 1)
            ->get();

        // Ambil semua data shift
        $shifts = Shift::all();

        // Set default value untuk shift
        $shift = 1;

        // Set default values untuk tanggal
        $date = Carbon::today()->toDateString();

        return view('masters.master_rk.proccess_control.index', compact('unloadings', 'loadings', 'koreksis', 'pengendalians', 'shifts', 'shift', 'date'));
    }

    public function filter(Request $request)
    {
        $date = $request->input('date');
        $shift = $request->input('shift');

        // Set default value for date input
        $date = $date ?: Carbon::today()->toDateString();

        $unloadings = rk_unloading_hasil_produksi_gl::with('user')
            ->whereDate('created_at', $date);
        if ($shift) {
            $unloadings->where('shift_id', $shift);
        }
        $unloadings = $unloadings->get();

        $loadings = rk_hasil_produksi::with('user')
            ->whereDate('created_at', $date);
        if ($shift) {
            $loadings->where('shift_id', $shift);
        }
        $loadings = $loadings->get();

        $koreksis = rk_koreksi_tile::with('user')
            ->whereDate('created_at', $date);
        if ($shift) {
            $koreksis->where('shift_id', $shift);
        }
        $koreksis = $koreksis->get();

        $pengendalians = rk_pengendalian_proses::with('user')
            ->whereDate('created_at', $date);
        if ($shift) {
            $pengendalians->where('shift_id', $shift);
        }
        $pengendalians = $pengendalians->get();


        $shifts = Shift::all();

        return view('masters.master_rk.proccess_control.index', compact('unloadings', 'loadings', 'koreksis', 'pengendalians', 'date', 'shift', 'shifts'));
    }

    //unloading -----------------------

    public function indexUnloading()
    {
        $unloadings = rk_unloading_hasil_produksi_gl::with('user')
            ->whereDate('created_at', Carbon::today())
            ->get();

        // Set default values for date inputs
        $start_date = Carbon::today()->toDateString();
        $end_date = Carbon::today()->toDateString();

        // Return the view with unloadings and default date values
        return view('masters.master_rk.unloading.index', compact('unloadings', 'start_date', 'end_date'));
    }

    public function filterUnloading(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Set default values for date inputs
        $start_date = $start_date ?: Carbon::today()->toDateString();
        $end_date = $end_date ?: Carbon::today()->toDateString();

        $unloadings = rk_unloading_hasil_produksi_gl::with('user');

        // Adjusting date format to match the format used by PHPMyAdmin
        $start_date_formatted = date('Y-m-d 00:00:00', strtotime($start_date));
        $end_date_formatted = date('Y-m-d 23:59:59', strtotime($end_date));

        if ($start_date && $end_date) {
            $unloadings->whereBetween('created_at', [$start_date_formatted, $end_date_formatted]);
        }

        $unloadings = $unloadings->get();

        // Pass back the start and end dates to the view
        return view('masters.master_rk.unloading.index', compact('unloadings', 'start_date', 'end_date'));
    }

    public function recapUnloading()
    {
        $unloadings = rk_unloading_hasil_produksi_gl::selectRaw('order_id, shift_id, DATE(created_at) as day, SUM(unloading) as total_jumlah')
            ->whereDate('created_at', Carbon::today())
            ->groupBy('order_id', 'shift_id', 'day')
            ->orderBy('order_id', 'ASC')
            ->with('user')
            ->get();

        // Set default values for date inputs
        $start_date = Carbon::today()->toDateString();
        $end_date = Carbon::today()->toDateString();

        return view('masters.master_rk.unloading.recap', compact('unloadings', 'start_date', 'end_date'));
    }

    public function recapUnloadingFilter(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Set default values for date inputs
        $start_date = $start_date ?: Carbon::today()->toDateString();
        $end_date = $end_date ?: Carbon::today()->toDateString();

        $unloadings = rk_unloading_hasil_produksi_gl::selectRaw('order_id, shift_id, DATE(created_at) as day, SUM(unloading) as total_jumlah')
            ->groupBy('order_id', 'shift_id', 'day')
            ->orderBy('created_at', 'ASC')
            ->with('user');

        // Adjusting date format to match the format used by PHPMyAdmin
        $start_date_formatted = date('Y-m-d 00:00:00', strtotime($start_date));
        $end_date_formatted = date('Y-m-d 23:59:59', strtotime($end_date));

        if ($start_date && $end_date) {
            $unloadings->whereBetween('created_at', [$start_date_formatted, $end_date_formatted]);
        }

        $unloadings = $unloadings->get();

        // Pass back the start and end dates to the view
        return view('masters.master_rk.unloading.recap', compact('unloadings', 'start_date', 'end_date'));
    }

    public function editUnloading(rk_unloading_hasil_produksi_gl $unloading)
    {
        return view('masters.master_rk.unloading.edit', ['unloading'  => $unloading]);
    }

    public function updateUnloading(Request $request, rk_unloading_hasil_produksi_gl $unloading)
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
            $unloading_updated = rk_unloading_hasil_produksi_gl::whereId($unloading->id)->update([
                'from'      => $request->from,
                'no'      => $request->no,
                'jumlah'      => $request->jumlah,
                'kompensator'      => $request->kompensator,
                'start'      => $request->start,
                'stop'      => $request->stop,
                'menit'      => $request->menit,
                'unloading'      => $request->unloading,
            ]);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('rk.unloading.index')->with('success', 'Data Updated Successfully.');
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function deleteUnloading(rk_unloading_hasil_produksi_gl $unloading)
    {
        DB::beginTransaction();
        try {
            // Delete User
            rk_unloading_hasil_produksi_gl::whereId($unloading->id)->delete();

            DB::commit();
            return redirect()->route('rk.unloading.index')->with('success', 'Data Deleted Successfully!.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    // loading -----------------------

    public function indexLoading()
    {
        $loadings = rk_hasil_produksi::with('user')
            ->whereDate('created_at', Carbon::today())
            ->get();

        $start_date = Carbon::today()->toDateString();
        $end_date = Carbon::today()->toDateString();

        // Return the view with loadings and default date values
        return view('masters.master_rk.loading.index', compact('loadings', 'start_date', 'end_date'));
    }

    public function filterLoading(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Set default values for date inputs
        $start_date = $start_date ?: Carbon::today()->toDateString();
        $end_date = $end_date ?: Carbon::today()->toDateString();

        $loadings = rk_hasil_produksi::with('user');

        // Adjusting date format to match the format used by PHPMyAdmin
        $start_date_formatted = date('Y-m-d 00:00:00', strtotime($start_date));
        $end_date_formatted = date('Y-m-d 23:59:59', strtotime($end_date));

        if ($start_date && $end_date) {
            $loadings->whereBetween('created_at', [$start_date_formatted, $end_date_formatted]);
        }

        $loadings = $loadings->get();

        // Pass back the start and end dates to the view
        return view('masters.master_rk.loading.index', compact('loadings', 'start_date', 'end_date'));
    }

    public function recapLoading()
    {
        $loadings = rk_hasil_produksi::selectRaw('order_id, shift_id, DATE(created_at) as day, SUM(jumlah) as total_jumlah')
            ->whereDate('created_at', Carbon::today())
            ->groupBy('order_id', 'shift_id', 'day')
            ->orderBy('order_id', 'ASC')
            ->with('user')
            ->get();

        // Set default values for date inputs
        $start_date = Carbon::today()->toDateString();
        $end_date = Carbon::today()->toDateString();

        return view('masters.master_rk.loading.recap', compact('loadings', 'start_date', 'end_date'));
    }

    public function recapLoadingFilter(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Set default values for date inputs
        $start_date = $start_date ?: Carbon::today()->toDateString();
        $end_date = $end_date ?: Carbon::today()->toDateString();

        $loadings = rk_hasil_produksi::selectRaw('order_id, shift_id, DATE(created_at) as day, SUM(jumlah) as total_jumlah')
            ->groupBy('order_id', 'shift_id', 'day')
            ->orderBy('created_at', 'ASC')
            ->with('user');

        // Adjusting date format to match the format used by PHPMyAdmin
        $start_date_formatted = date('Y-m-d 00:00:00', strtotime($start_date));
        $end_date_formatted = date('Y-m-d 23:59:59', strtotime($end_date));

        if ($start_date && $end_date) {
            $loadings->whereBetween('created_at', [$start_date_formatted, $end_date_formatted]);
        }

        $loadings = $loadings->get();

        // Pass back the start and end dates to the view
        return view('masters.master_rk.loading.recap', compact('loadings', 'start_date', 'end_date'));
    }

    public function editLoading(rk_hasil_produksi $loading)
    {
        return view('masters.master_rk.loading.edit', ['loading'  => $loading]);
    }

    public function updateLoading(Request $request, rk_hasil_produksi $loading)
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
            $loading_updated = rk_hasil_produksi::whereId($loading->id)->update([
                'from'      => $request->from,
                'no'      => $request->no,
                'outKiln'      => $request->outKiln,
                'start'      => $request->start,
                'stop'      => $request->stop,
                'menit'      => $request->menit,
                'jumlah'      => $request->jumlah,
            ]);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('rk.loading.index')->with('success', 'Data Updated Successfully.');
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function deleteLoading(rk_hasil_produksi $loading)
    {
        DB::beginTransaction();
        try {
            // Delete User
            rk_hasil_produksi::whereId($loading->id)->delete();

            DB::commit();
            return redirect()->route('rk.loading.index')->with('success', 'Data Deleted Successfully!.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    // pengendalian proses -----------------

    public function indexPengendalian()
    {
        $pengendalians = rk_pengendalian_proses::with('user')
            ->whereDate('created_at', Carbon::today())
            ->get();

        $start_date = Carbon::today()->toDateString();
        $end_date = Carbon::today()->toDateString();

        // Return the view with pengendalians and default date values
        return view('masters.master_rk.pengendalian.index', compact('pengendalians', 'start_date', 'end_date'));
    }

    public function filterPengendalian(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Set default values for date inputs
        $start_date = $start_date ?: Carbon::today()->toDateString();
        $end_date = $end_date ?: Carbon::today()->toDateString();

        $pengendalians = rk_pengendalian_proses::with('user');

        // Adjusting date format to match the format used by PHPMyAdmin
        $start_date_formatted = date('Y-m-d 00:00:00', strtotime($start_date));
        $end_date_formatted = date('Y-m-d 23:59:59', strtotime($end_date));

        if ($start_date && $end_date) {
            $pengendalians->whereBetween('created_at', [$start_date_formatted, $end_date_formatted]);
        }

        $pengendalians = $pengendalians->get();

        // Pass back the start and end dates to the view
        return view('masters.master_rk.pengendalian.index', compact('pengendalians', 'start_date', 'end_date'));
    }

    public function editPengendalian(rk_pengendalian_proses $pengendalian)
    {
        return view('masters.master_rk.pengendalian.edit', ['pengendalian'  => $pengendalian]);
    }

    public function updatePengendalian(Request $request, rk_pengendalian_proses $pengendalian)
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
            $pengendalian_updated = rk_pengendalian_proses::whereId($pengendalian->id)->update([
                'fan_vacum'      => $request->fan_vacum,
                'fan_temp'      => $request->fan_temp,
                'gas_preasure'      => $request->gas_preasure,
                'h28'      => $request->h28,
                'h27'      => $request->h27,
                'h1'      => $request->h1,
                'h2'      => $request->h2,
                'h3'      => $request->h3,
                'f4'      => $request->f4,
                'h5'      => $request->h5,
                'f6'      => $request->f6,
                'f6_setting'      => $request->f6_setting,
                'h7'      => $request->h7,
                'f8'      => $request->f8,
                'a9'      => $request->a9,
                'a9_setting'      => $request->a9_setting,
                'a10'      => $request->a10,
                'a10_Setting'      => $request->a10_Setting,
                'a11'      => $request->a11,
                'a11_setting'      => $request->a11_setting,
                'a12'      => $request->a12,
                'a12_setting'      => $request->a12_setting,
                'a13'      => $request->a13,
                'a13_setting'      => $request->a13_setting,
                'a14'      => $request->a14,
                'a14_setting'      => $request->a14_setting,
                'a15'      => $request->a15,
                'a15_setting'      => $request->a15_setting,
                'a16'      => $request->a16,
                'a16_setting'      => $request->a16_setting,
                'a17'      => $request->a17,
                'a17_setting'      => $request->a17_setting,
                'a18'      => $request->a18,
                'a18_setting'      => $request->a18_setting,
                'a19'      => $request->a19,
                'a19_setting'      => $request->a19_setting,
                'a20'      => $request->a20,
                'a20_setting'      => $request->a20_setting,
                'a21'      => $request->a21,
                'a21_setting'      => $request->a21_setting,
                'a22'      => $request->a22,
                'a22_setting'      => $request->a22_setting,
                'a23'      => $request->a23,
                'a24'      => $request->a24,
                'f25'      => $request->f25,
                'f26'      => $request->f26,
                'f26_setting'      => $request->f26_setting,
                'comb_preasure'      => $request->comb_preasure,
                'comb_temp'      => $request->comb_temp,
                'zero_point'      => $request->zero_point,
                'hot_air_fan'      => $request->hot_air_fan,
                'speedy_preasure'      => $request->speedy_preasure,
            ]);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('rk.pengendalian.index')->with('success', 'Data Updated Successfully.');
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function deletePengendalian(rk_pengendalian_proses $pengendalian)
    {
        DB::beginTransaction();
        try {
            // Delete User
            rk_pengendalian_proses::whereId($pengendalian->id)->delete();

            DB::commit();
            return redirect()->route('rk.pengendalian.index')->with('success', 'Data Deleted Successfully!.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    // cek gumpil -------------

    public function indexCek()
    {
        $ceks = rk_cek_gumpil::with('user')
            ->whereDate('created_at', Carbon::today())
            ->get();

        // Set default values for date inputs
        $start_date = Carbon::today()->toDateString();
        $end_date = Carbon::today()->toDateString();

        return view('masters.master_rk.cek.index', compact('ceks', 'start_date', 'end_date'));
    }

    public function filterCek(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Set default values for date inputs
        $start_date = $start_date ?: Carbon::today()->toDateString();
        $end_date = $end_date ?: Carbon::today()->toDateString();

        $ceks = rk_cek_gumpil::with('user');

        // Adjusting date format to match the format used by PHPMyAdmin
        $start_date_formatted = date('Y-m-d 00:00:00', strtotime($start_date));
        $end_date_formatted = date('Y-m-d 23:59:59', strtotime($end_date));

        if ($start_date && $end_date) {
            $ceks->whereBetween('created_at', [$start_date_formatted, $end_date_formatted]);
        }

        $ceks = $ceks->get();

        // Pass back the start and end dates to the view
        return view('masters.master_rk.cek.index', compact('ceks', 'start_date', 'end_date'));
    }

    public function editCek(rk_cek_gumpil $cek)
    {
        return view('masters.master_rk.cek.edit', ['cek'  => $cek]);
    }

    public function updateCek(Request $request, rk_cek_gumpil $cek)
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
            $cek_updated = rk_cek_gumpil::whereId($cek->id)->update([
                'motif'      => $request->motif,
                'size'      => $request->size,
                'sample'      => $request->sample,
                'pcs_gumpil'      => $request->pcs_gumpil,
                'persen_gumpil'      => $request->persen_gumpil,
            ]);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('rk.cek.index')->with('success', 'Data Updated Successfully.');
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function deleteCek(rk_cek_gumpil $cek)
    {
        DB::beginTransaction();
        try {
            // Delete User
            rk_cek_gumpil::whereId($cek->id)->delete();

            DB::commit();
            return redirect()->route('rk.cek.index')->with('success', 'Data Deleted Successfully!.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    //koreksi kiln ----------------------------------------------------------

    public function indexKoreksi()
    {
        // Fetch koreksis created today
        $koreksis = rk_koreksi_tile::with('user')
            ->whereDate('created_at', Carbon::today())
            ->get();

        // Set default values for date inputs
        $start_date = Carbon::today()->toDateString();
        $end_date = Carbon::today()->toDateString();

        // Return the view with koreksis and default date values
        return view('masters.master_rk.koreksi.index', compact('koreksis', 'start_date', 'end_date'));
    }

    public function detailKoreksi(rk_koreksi_tile $koreksi)
    {
        // Fetch koreksi created today
        $details = rk_d_koreksi::with('h_koreksi')
            ->where('rk_koreksi_id', $koreksi->id)
            ->get();

        dd($details->h_koreksi);
        // dd($details);

        return view('masters.master_rk.koreksi.detail', ['details' => $details]);
    }

    public function filterKoreksi(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Set default values for date inputs
        $start_date = $start_date ?: Carbon::today()->toDateString();
        $end_date = $end_date ?: Carbon::today()->toDateString();

        $koreksis = rk_koreksi_tile::with('user');

        // Adjusting date format to match the format used by PHPMyAdmin
        $start_date_formatted = date('Y-m-d 00:00:00', strtotime($start_date));
        $end_date_formatted = date('Y-m-d 23:59:59', strtotime($end_date));

        if ($start_date && $end_date) {
            $koreksis->whereBetween('created_at', [$start_date_formatted, $end_date_formatted]);
        }

        $koreksis = $koreksis->get();

        // Pass back the start and end dates to the view
        return view('masters.master_rk.koreksi.index', compact('koreksis', 'start_date', 'end_date'));
    }

    public function editKoreksi(rk_koreksi_tile $koreksi)
    {
        return view('masters.master_rk.koreksi.edit', ['koreksi'  => $koreksi]);
    }

    public function updateKoreksi(Request $request, rk_koreksi_tile $tebal)
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
            $tebal_updated = rk_koreksi_tile::whereId($tebal->id)->update([
                'populasi'      => $request->selisih,
            ]);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('ph.tebal.index')->with('success', 'Data Updated Successfully.');
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function deleteKoreksi(rk_koreksi_tile $tebal)
    {
        DB::beginTransaction();
        try {
            // Delete User
            rk_koreksi_tile::whereId($tebal->id)->delete();

            DB::commit();
            return redirect()->route('ph.tebal.index')->with('success', 'Data Deleted Successfully!.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
