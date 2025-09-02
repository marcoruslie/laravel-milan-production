<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\gl_analisa_tes_bakar;
use App\Models\gl_hasil_produksi;
use App\Models\gl_pengendalian_proses;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class adminGlController extends Controller
{
    // Proccess Control
    public function index()
    {
        // Ambil data analisa tes bakar untuk hari ini
        $analisas = gl_analisa_tes_bakar::with('user')
            ->whereDate('created_at', Carbon::today())
            ->where('shift_id', 1)
            ->get();

        // Ambil data hasil produksi untuk hari ini
        $loadings = gl_hasil_produksi::with('user')
            ->whereDate('created_at', Carbon::today())
            ->where('shift_id', 1)
            ->get();

        $pengendalians = gl_pengendalian_proses::with('user')
            ->whereDate('created_at', Carbon::today())
            ->where('shift_id', 1)
            ->get();

        // Ambil semua data shift
        $shifts = Shift::all();

        // Set default value untuk shift
        $shift = 1;

        // Set default values untuk tanggal
        $date = Carbon::today()->toDateString();

        return view('masters.master_gl.proccess_control.index', compact('analisas', 'loadings', 'pengendalians', 'shifts', 'shift', 'date'));
    }

    public function filter(Request $request)
    {
        $date = $request->input('date');
        $shift = $request->input('shift');

        // Set default value for date input
        $date = $date ?: Carbon::today()->toDateString();

        // Ambil data analisa tes bakar dengan shift tertentu untuk tanggal tertentu
        $analisas = gl_analisa_tes_bakar::with('user')
            ->whereDate('created_at', $date);

        // Filter berdasarkan shift jika dipilih
        if ($shift) {
            $analisas->where('shift_id', $shift);
        }

        $analisas = $analisas->get();

        $pengendalians = gl_pengendalian_proses::with('user')
            ->whereDate('created_at', $date);

        // Filter berdasarkan shift jika dipilih
        if ($shift) {
            $pengendalians->where('shift_id', $shift);
        }

        $pengendalians = $pengendalians->get();

        // Ambil data hasil produksi dengan shift tertentu untuk tanggal tertentu
        $loadings = gl_hasil_produksi::with('user')
            ->whereDate('created_at', $date);

        // Filter berdasarkan shift jika dipilih
        if ($shift) {
            $loadings->where('shift_id', $shift);
        }

        $loadings = $loadings->get();

        // Ambil semua data shift untuk dropdown
        $shifts = Shift::all();

        // Pass kembali tanggal, shift, dan data shift ke tampilan
        return view('masters.master_gl.proccess_control.index', compact('analisas', 'loadings', 'pengendalians', 'date', 'shift', 'shifts'));
    }

    // Analisa
    public function indexAnalisa()
    {
        $analisas = gl_analisa_tes_bakar::with('user')
            ->whereDate('created_at', Carbon::today())
            ->get();

        // Set default values for date inputs
        $start_date = Carbon::today()->toDateString();
        $end_date = Carbon::today()->toDateString();

        return view('masters.master_gl.analisa.index', compact('analisas', 'start_date', 'end_date'));
    }

    public function filterAnalisa(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Set default values for date inputs
        $start_date = $start_date ?: Carbon::today()->toDateString();
        $end_date = $end_date ?: Carbon::today()->toDateString();

        $analisas = gl_analisa_tes_bakar::with('user');

        // Adjusting date format to match the format used by PHPMyAdmin
        $start_date_formatted = date('Y-m-d 00:00:00', strtotime($start_date));
        $end_date_formatted = date('Y-m-d 23:59:59', strtotime($end_date));

        if ($start_date && $end_date) {
            $analisas->whereBetween('created_at', [$start_date_formatted, $end_date_formatted]);
        }

        $analisas = $analisas->get();

        // Pass back the start and end dates to the view
        return view('masters.master_gl.analisa.index', compact('analisas', 'start_date', 'end_date'));
    }

    public function editAnalisa(gl_analisa_tes_bakar $analisa)
    {
        return view('masters.master_gl.analisa.edit', ['analisa'  => $analisa]);
    }

    public function updateAnalisa(Request $request, gl_analisa_tes_bakar $analisa)
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
            $analisa_updated = gl_analisa_tes_bakar::whereId($analisa->id)->update([
                'grup_motive'      => $request->grup_motive,
                'jenis_cacat'      => $request->jenis_cacat,
                'no_mould'      => $request->no_mould,
                'jenis_perbaikan'      => $request->jenis_perbaikan,
                'status'      => $request->status,
            ]);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('gl.analisa.index')->with('success', 'Data Updated Successfully.');
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function deleteAnalisa(gl_analisa_tes_bakar $analisa)
    {
        DB::beginTransaction();
        try {
            // Delete User
            gl_analisa_tes_bakar::whereId($analisa->id)->delete();

            DB::commit();
            return redirect()->route('gl.analisa.index')->with('success', 'Data Deleted Successfully!.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    // loading -----------------------

    public function indexLoading()
    {
        $loadings = gl_hasil_produksi::with('user')
            ->whereDate('created_at', Carbon::today())
            ->get();

        // Set default values for date inputs
        $start_date = Carbon::today()->toDateString();
        $end_date = Carbon::today()->toDateString();

        return view('masters.master_gl.loading.index', compact('loadings', 'start_date', 'end_date'));
    }
 
    public function filterLoading(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Set default values for date inputs
        $start_date = $start_date ?: Carbon::today()->toDateString();
        $end_date = $end_date ?: Carbon::today()->toDateString();

        $loadings = gl_hasil_produksi::with('user');

        // Adjusting date format to match the format used by PHPMyAdmin
        $start_date_formatted = date('Y-m-d 00:00:00', strtotime($start_date));
        $end_date_formatted = date('Y-m-d 23:59:59', strtotime($end_date));

        if ($start_date && $end_date) {
            $loadings->whereBetween('created_at', [$start_date_formatted, $end_date_formatted]);
        }

        $loadings = $loadings->get();

        // Pass back the start and end dates to the view
        return view('masters.master_gl.loading.index', compact('loadings', 'start_date', 'end_date'));
    }

    public function recapLoading()
    {
        $loadings = gl_hasil_produksi::selectRaw('order_id, shift_id, DATE(created_at) as day, SUM(jumlah) as total_jumlah')
            ->whereDate('created_at', Carbon::today())
            ->groupBy('order_id', 'shift_id', 'day')
            ->with('user')
            ->get();

        // Set default values for date inputs
        $start_date = Carbon::today()->toDateString();
        $end_date = Carbon::today()->toDateString();

        return view('masters.master_gl.loading.recap', compact('loadings', 'start_date', 'end_date'));
    }

    public function recapFilter(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Set default values for date inputs
        $start_date = $start_date ?: Carbon::today()->toDateString();
        $end_date = $end_date ?: Carbon::today()->toDateString();

        $loadings = gl_hasil_produksi::selectRaw('order_id, shift_id, DATE(created_at) as day, SUM(jumlah) as total_jumlah')
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
        return view('masters.master_gl.loading.recap', compact('loadings', 'start_date', 'end_date'));
    }

    public function editLoading(gl_hasil_produksi $loading)
    {
        return view('masters.master_gl.loading.edit', ['loading'  => $loading]);
    }

    public function updateLoading(Request $request, gl_hasil_produksi $loading)
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
            $loading_updated = gl_hasil_produksi::whereId($loading->id)->update([
                'from'      => $request->from,
                'no'      => $request->no,
                'start'      => $request->start,
                'stop'      => $request->stop,
                'menit'      => $request->menit,
                'jumlah'      => $request->jumlah,
            ]);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('gl.loading.index')->with('success', 'Data Updated Successfully.');
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function deleteLoading(gl_hasil_produksi $loading)
    {
        DB::beginTransaction();
        try {
            // Delete User
            gl_hasil_produksi::whereId($loading->id)->delete();

            DB::commit();
            return redirect()->route('gl.loading.index')->with('success', 'Data Deleted Successfully!.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    // Pengendalian proses

    public function indexPengendalian()
    {
        $pengendalians = gl_pengendalian_proses::with('user')
            ->whereDate('created_at', Carbon::today())
            ->get();

        // Set default values for date inputs
        $start_date = Carbon::today()->toDateString();
        $end_date = Carbon::today()->toDateString();

        return view('masters.master_gl.pengendalian.index', compact('pengendalians', 'start_date', 'end_date'));
    }

    public function filterPengendalian(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Set default values for date inputs
        $start_date = $start_date ?: Carbon::today()->toDateString();
        $end_date = $end_date ?: Carbon::today()->toDateString();

        $pengendalians = gl_pengendalian_proses::with('user');

        // Adjusting date format to match the format used by PHPMyAdmin
        $start_date_formatted = date('Y-m-d 00:00:00', strtotime($start_date));
        $end_date_formatted = date('Y-m-d 23:59:59', strtotime($end_date));

        if ($start_date && $end_date) {
            $pengendalians->whereBetween('created_at', [$start_date_formatted, $end_date_formatted]);
        }

        $pengendalians = $pengendalians->get();

        // Pass back the start and end dates to the view
        return view('masters.master_gl.pengendalian.index', compact('pengendalians', 'start_date', 'end_date'));
    }

    public function editPengendalian(gl_pengendalian_proses $pengendalian)
    {
        return view('masters.master_gl.pengendalian.edit', ['pengendalian'  => $pengendalian]);
    }

    public function updatePengendalian(Request $request, gl_pengendalian_proses $pengendalian)
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
            $pengendalian_updated = gl_pengendalian_proses::whereId($pengendalian->id)->update([
                'jenis_aplikasi'      => $request->jenis_aplikasi,
                'engobe'      => $request->engobe,
                'engobe_visco'      => $request->engobe_visco,
                'engobe_densi'      => $request->engobe_densi,
                'engobe_berat'      => $request->engobe_berat,
                'glaze'      => $request->glaze,
                'glaze_visco'      => $request->glaze_visco,
                'glaze_densi'      => $request->glaze_densi,
                'glaze_berat'      => $request->glaze_berat,
                'pasta'      => $request->pasta,
                'pasta_visco'      => $request->pasta_visco,
                'pasta_densi'      => $request->pasta_densi,
                'temp_body'      => $request->temp_body,
                'set_pemukul'      => $request->set_pemukul,
                'sikat'      => $request->sikat,
                'saringan'      => $request->saringan,
            ]);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('gl.pengendalian.index')->with('success', 'Data Updated Successfully.');
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function deletePengendalian(gl_pengendalian_proses $pengendalian)
    {
        DB::beginTransaction();
        try {
            // Delete User
            gl_pengendalian_proses::whereId($pengendalian->id)->delete();

            DB::commit();
            return redirect()->route('gl.pengendalian.index')->with('success', 'Data Deleted Successfully!.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
