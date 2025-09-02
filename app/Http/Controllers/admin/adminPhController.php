<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ph_control;
use App\Models\ph_counter;
use App\Models\ph_d_dimensi;
use App\Models\ph_d_tebal;
use App\Models\ph_dimensi;
use App\Models\ph_dryer;
use App\Models\ph_tebal;
use App\Models\ph_temp;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class adminPhController extends Controller
{
    // Proccess Control
    public function index()
    {
        $controls = ph_control::with('user')
            ->whereDate('created_at', Carbon::today())
            ->where('shift_id', 1)
            ->get();
        $dimensis = ph_dimensi::with('user')
            ->whereDate('created_at', Carbon::today())
            ->where('shift_id', 1)
            ->get();
        $temps = ph_temp::with('user')
            ->whereDate('created_at', Carbon::today())
            ->where('shift_id', 1)
            ->get();
        $counters = ph_counter::with('user')
            ->whereDate('created_at', Carbon::today())
            ->where('shift_id', 1)
            ->get();
        $tebals = ph_tebal::with('user')
            ->whereDate('created_at', Carbon::today())
            ->where('shift_id', 1)
            ->get();
        $dryers = ph_dryer::with('user')
            ->whereDate('created_at', Carbon::today())
            ->where('shift_id', 1)
            ->get();

        // Ambil semua data shift
        $shifts = Shift::all();

        // Set default value untuk shift
        $shift = 1;

        // Set default values untuk tanggal
        $date = Carbon::today()->toDateString();

        return view('masters.master_ph.proccess_control.index', compact('controls', 'dimensis','temps','counters', 'tebals', 'dryers', 'shifts', 'shift', 'date'));
    }

    public function filter(Request $request)
    {
        $date = $request->input('date');
        $shift = $request->input('shift');

        // Set default value for date input
        $date = $date ?: Carbon::today()->toDateString();

        $controls = ph_control::with('user')
            ->whereDate('created_at', $date);
        if ($shift) {
            $controls->where('shift_id', $shift);
        }
        $controls = $controls->get();

        $dimensis = ph_dimensi::with('user')
            ->whereDate('created_at', $date);
        if ($shift) {
            $dimensis->where('shift_id', $shift);
        }
        $dimensis = $dimensis->get();

        $counters = ph_counter::with('user')
            ->whereDate('created_at', $date);
        if ($shift) {
            $counters->where('shift_id', $shift);
        }
        $counters = $counters->get();

        $temps = ph_temp::with('user')
            ->whereDate('created_at', $date);
        if ($shift) {
            $temps->where('shift_id', $shift);
        }
        $temps = $temps->get();

        $tebals = ph_tebal::with('user')
            ->whereDate('created_at', $date);
        if ($shift) {
            $tebals->where('shift_id', $shift);
        }
        $tebals = $tebals->get();

        $dryers = ph_dryer::with('user')
            ->whereDate('created_at', $date);
        if ($shift) {
            $dryers->where('shift_id', $shift);
        }
        $dryers = $dryers->get();

        $shifts = Shift::all();

        return view('masters.master_ph.proccess_control.index', compact('controls', 'dimensis', 'temps', 'counters', 'tebals', 'dryers', 'date', 'shift', 'shifts'));
    }

    public function indexControl()
    {
        // Fetch controls created today
        $controls = ph_control::with('user')
            ->whereDate('created_at', Carbon::today())
            ->get();

        // Set default values for date inputs
        $start_date = Carbon::today()->toDateString();
        $end_date = Carbon::today()->toDateString();

        // Return the view with controls and default date values
        return view('masters.master_ph.control.index', compact('controls', 'start_date', 'end_date'));
    }

    public function filterControls(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Set default values for date inputs
        $start_date = $start_date ?: Carbon::today()->toDateString();
        $end_date = $end_date ?: Carbon::today()->toDateString();

        $controls = ph_control::with('user');

        // Adjusting date format to match the format used by PHPMyAdmin
        $start_date_formatted = date('Y-m-d 00:00:00', strtotime($start_date));
        $end_date_formatted = date('Y-m-d 23:59:59', strtotime($end_date));

        if ($start_date && $end_date) {
            $controls->whereBetween('created_at', [$start_date_formatted, $end_date_formatted]);
        }

        $controls = $controls->get();

        // Pass back the start and end dates to the view
        return view('masters.master_ph.control.index', compact('controls', 'start_date', 'end_date'));
    }


    public function editControl(ph_control $control)
    {
        return view('masters.master_ph.control.edit', ['control'  => $control]);
    }

    public function updateControl(Request $request, ph_control $control)
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
            $control_updated = ph_control::whereId($control->id)->update([
                'tekanan_max'      => $request->tekanan_max,
                'tekanan_init'     => $request->tekanan_init,
                'cycle_ph'     => $request->cycle_ph,
                'keutuhan_body'     => $request->keutuhan_body,
            ]);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('ph.control.index')->with('success', 'Control Updated Successfully.');
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function deleteControl(ph_control $control)
    {
        DB::beginTransaction();
        try {
            // Delete User
            ph_control::whereId($control->id)->delete();

            DB::commit();
            return redirect()->route('ph.control.index')->with('success', 'Control Deleted Successfully!.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function indexCounter()
    {
        // Fetch counters created today
        $counters = ph_counter::with('user')
            ->whereDate('created_at', Carbon::today())
            ->get();

        // Set default values for date inputs
        $start_date = Carbon::today()->toDateString();
        $end_date = Carbon::today()->toDateString();

        // Return the view with counters and default date values
        return view('masters.master_ph.counter.index', compact('counters', 'start_date', 'end_date'));
    }

    public function filterCounter(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Set default values for date inputs
        $start_date = $start_date ?: Carbon::today()->toDateString();
        $end_date = $end_date ?: Carbon::today()->toDateString();

        $counters = ph_counter::with('user');

        // Adjusting date format to match the format used by PHPMyAdmin
        $start_date_formatted = date('Y-m-d 00:00:00', strtotime($start_date));
        $end_date_formatted = date('Y-m-d 23:59:59', strtotime($end_date));

        if ($start_date && $end_date) {
            $counters->whereBetween('created_at', [$start_date_formatted, $end_date_formatted]);
        }

        $counters = $counters->get();

        // Pass back the start and end dates to the view
        return view('masters.master_ph.counter.index', compact('counters', 'start_date', 'end_date'));
    }

    public function editCounter(ph_counter $counter)
    {
        return view('masters.master_ph.counter.edit', ['counter'  => $counter]);
    }

    public function updateCounter(Request $request, ph_counter $counter)
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
            $counter_updated = ph_counter::whereId($counter->id)->update([
                'db'      => $request->db,
                'up_m1'     => $request->up_m1,
                'up_m2'     => $request->up_m2,
                'up_m3'     => $request->up_m3,
                'up_m4'     => $request->up_m4,
                'lw_m1'  => $request->lw_m1,
                'lw_m2'  => $request->lw_m2,
                'lw_m3'  => $request->lw_m3,
                'lw_m4'  => $request->lw_m4,
            ]);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('ph.counter.index')->with('success', 'Counter Updated Successfully.');
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function deleteCounter(ph_counter $counter)
    {
        DB::beginTransaction();
        try {
            // Delete User
            ph_counter::whereId($counter->id)->delete();

            DB::commit();
            return redirect()->route('ph.counter.index')->with('success', 'Counter Deleted Successfully!.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function indexTemp()
    {
        // Fetch temps created today
        $temps = ph_temp::with('user')
            ->whereDate('created_at', Carbon::today())
            ->get();

        // Set default values for date inputs
        $start_date = Carbon::today()->toDateString();
        $end_date = Carbon::today()->toDateString();

        // Return the view with temps and default date values
        return view('masters.master_ph.suhu.index', compact('temps', 'start_date', 'end_date'));
    }

    public function filterTemp(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Set default values for date inputs
        $start_date = $start_date ?: Carbon::today()->toDateString();
        $end_date = $end_date ?: Carbon::today()->toDateString();

        $temps = ph_temp::with('user');

        // Adjusting date format to match the format used by PHPMyAdmin
        $start_date_formatted = date('Y-m-d 00:00:00', strtotime($start_date));
        $end_date_formatted = date('Y-m-d 23:59:59', strtotime($end_date));

        if ($start_date && $end_date) {
            $temps->whereBetween('created_at', [$start_date_formatted, $end_date_formatted]);
        }

        $temps = $temps->get();

        // Pass back the start and end dates to the view
        return view('masters.master_ph.suhu.index', compact('temps', 'start_date', 'end_date'));
    }

    public function editTemp(ph_temp $temp)
    {
        return view('masters.master_ph.suhu.edit', ['temp'  => $temp]);
    }

    public function updateTemp(Request $request, ph_temp $temp)
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
            $temp = ph_temp::whereId($temp->id)->update([
                'DB_setting'      => $request->DB_setting,
                'DB_actual'     => $request->DB_actual,
                'UP_setting'     => $request->UP_setting,
                'UP_actual'     => $request->UP_actual,
                'LW_setting'     => $request->LW_setting,
                'LW_actual'  => $request->LW_actual,
            ]);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('ph.temps.index')->with('success', 'Temp Updated Successfully.');
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function deleteTemp(ph_temp $temp)
    {
        DB::beginTransaction();
        try {
            // Delete User
            ph_temp::whereId($temp->id)->delete();

            DB::commit();
            return redirect()->route('ph.temp.index')->with('success', 'Temp Deleted Successfully!.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function indexDryer()
    {
        // Fetch dryers created today
        $dryers = ph_dryer::with('user')
            ->whereDate('created_at', Carbon::today())
            ->get();

        // Set default values for date inputs
        $start_date = Carbon::today()->toDateString();
        $end_date = Carbon::today()->toDateString();

        // Return the view with dryers and default date values
        return view('masters.master_ph.dryer.index', compact('dryers', 'start_date', 'end_date'));
    }

    public function filterDryer(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Set default values for date inputs
        $start_date = $start_date ?: Carbon::today()->toDateString();
        $end_date = $end_date ?: Carbon::today()->toDateString();

        $dryers = ph_dryer::with('user');

        // Adjusting date format to match the format used by PHPMyAdmin
        $start_date_formatted = date('Y-m-d 00:00:00', strtotime($start_date));
        $end_date_formatted = date('Y-m-d 23:59:59', strtotime($end_date));

        if ($start_date && $end_date) {
            $dryers->whereBetween('created_at', [$start_date_formatted, $end_date_formatted]);
        }

        $dryers = $dryers->get();

        // Pass back the start and end dates to the view
        return view('masters.master_ph.dryer.index', compact('dryers', 'start_date', 'end_date'));
    }

    public function editDryer(ph_dryer $dryer)
    {
        return view('masters.master_ph.dryer.edit', ['dryer'  => $dryer]);
    }

    public function updateDryer(Request $request, ph_dryer $dryer)
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
            $dryer_updated = ph_dryer::whereId($dryer->id)->update([
                'dryers'      => $request->dryers,
                'param1'     => $request->param1,
                'param2'     => $request->param2,
                'param3'     => $request->param3,
                'param4'     => $request->param4,
                'param5'     => $request->param5,
                'counterVd'  => $request->counterVd,
                'tempAplikasi'  => $request->tempAplikasi,
                'kondisi_et'  => $request->kondisi_et,
                'floating_grid'  => $request->floating_grid,
                'sikat_rol'  => $request->sikat_rol,
                'below'  => $request->below,
            ]);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('ph.dryer.index')->with('success', 'Dryer Updated Successfully.');
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function deleteDryer(ph_dryer $dryer)
    {
        DB::beginTransaction();
        try {
            // Delete User
            ph_dryer::whereId($dryer->id)->delete();

            DB::commit();
            return redirect()->route('ph.dryer.index')->with('success', 'Dryer Deleted Successfully!.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function indexDimensi()
    {
        // Fetch dimensis created today
        $dimensis = ph_dimensi::with('user')
            ->whereDate('created_at', Carbon::today())
            ->get();

        // Set default values for date inputs
        $start_date = Carbon::today()->toDateString();
        $end_date = Carbon::today()->toDateString();

        // Return the view with dimensis and default date values
        return view('masters.master_ph.dimensi.index', compact('dimensis', 'start_date', 'end_date'));
    }

    public function detailDimensi(ph_dimensi $dimensi)
    {
        // Fetch dimensis created today
        $details = ph_d_dimensi::with('h_dimensi')
            ->where('h_dimensi_id', $dimensi->id)
            ->get();

        // dd($details);

        return view('masters.master_ph.dimensi.detail', ['details' => $details]);
    }

    public function filterDimensi(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Set default values for date inputs
        $start_date = $start_date ?: Carbon::today()->toDateString();
        $end_date = $end_date ?: Carbon::today()->toDateString();

        $dimensis = ph_dimensi::with('user');

        // Adjusting date format to match the format used by PHPMyAdmin
        $start_date_formatted = date('Y-m-d 00:00:00', strtotime($start_date));
        $end_date_formatted = date('Y-m-d 23:59:59', strtotime($end_date));

        if ($start_date && $end_date) {
            $dimensis->whereBetween('created_at', [$start_date_formatted, $end_date_formatted]);
        }

        $dimensis = $dimensis->get();

        // Pass back the start and end dates to the view
        return view('masters.master_ph.dimensi.index', compact('dimensis', 'start_date', 'end_date'));
    }

    public function editDimensi(ph_dimensi $dimensi)
    {
        return view('masters.master_ph.dimensi.edit', ['dimensi'  => $dimensi]);
    }

    public function updateDimensi(Request $request, ph_dimensi $dimensi)
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
            $dimensi_updated = ph_dimensi::whereId($dimensi->id)->update([
                'populasi'      => $request->populasi,
            ]);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('ph.dimensi.index')->with('success', 'Data Updated Successfully.');
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function deleteDimensi(ph_dimensi $dimensi)
    {
        DB::beginTransaction();
        try {
            // Delete User
            ph_dimensi::whereId($dimensi->id)->delete();

            DB::commit();
            return redirect()->route('ph.dimensi.index')->with('success', 'Data Deleted Successfully!.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    //tebal ------------------------------------------

    public function indexTebal()
    {
        // Fetch tebals created today
        $tebals = ph_tebal::with('user')
            ->whereDate('created_at', Carbon::today())
            ->get();

        // Set default values for date inputs
        $start_date = Carbon::today()->toDateString();
        $end_date = Carbon::today()->toDateString();

        // Return the view with tebals and default date values
        return view('masters.master_ph.tebal.index', compact('tebals', 'start_date', 'end_date'));
    }

    public function detailTebal(ph_tebal $tebal)
    {
        // Fetch tebal created today
        $details = ph_d_tebal::with('h_tebal')
            ->where('h_tebal_id', $tebal->id)
            ->get();

        // dd($details);

        return view('masters.master_ph.tebal.detail', ['details' => $details]);
    }

    public function filterTebal(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Set default values for date inputs
        $start_date = $start_date ?: Carbon::today()->toDateString();
        $end_date = $end_date ?: Carbon::today()->toDateString();

        $tebals = ph_tebal::with('user');

        // Adjusting date format to match the format used by PHPMyAdmin
        $start_date_formatted = date('Y-m-d 00:00:00', strtotime($start_date));
        $end_date_formatted = date('Y-m-d 23:59:59', strtotime($end_date));

        if ($start_date && $end_date) {
            $tebals->whereBetween('created_at', [$start_date_formatted, $end_date_formatted]);
        }

        $tebals = $tebals->get();

        // Pass back the start and end dates to the view
        return view('masters.master_ph.tebal.index', compact('tebals', 'start_date', 'end_date'));
    }

    public function editTebal(ph_tebal $tebal)
    {
        return view('masters.master_ph.tebal.edit', ['tebal'  => $tebal]);
    }

    public function updateTebal(Request $request, ph_tebal $tebal)
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
            $tebal_updated = ph_tebal::whereId($tebal->id)->update([
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

    public function deleteTebal(ph_tebal $tebal)
    {
        DB::beginTransaction();
        try {
            // Delete User
            ph_tebal::whereId($tebal->id)->delete();

            DB::commit();
            return redirect()->route('ph.tebal.index')->with('success', 'Data Deleted Successfully!.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
