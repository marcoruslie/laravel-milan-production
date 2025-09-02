<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\down_time;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class adminDownTimeController extends Controller
{

    public function indexDownTime()
    {
        // Fetch DownTimes created today
        $times = down_time::whereDate('created_at', Carbon::today())->get();

        // Set default values for date inputs
        $start_date = Carbon::today()->toDateString();
        $end_date = Carbon::today()->toDateString();

        // Return the view with times and default date values
        return view('downtime.index', compact('times', 'start_date', 'end_date'));
    }

    public function filterDownTimes(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Set default values for date inputs
        $start_date = $start_date ?: Carbon::today()->toDateString();
        $end_date = $end_date ?: Carbon::today()->toDateString();

        $times = down_time::with('user');

        // Adjusting date format to match the format used by PHPMyAdmin
        $start_date_formatted = date('Y-m-d 00:00:00', strtotime($start_date));
        $end_date_formatted = date('Y-m-d 23:59:59', strtotime($end_date));

        if ($start_date && $end_date) {
            $times->whereBetween('created_at', [$start_date_formatted, $end_date_formatted]);
        }

        $times = $times->get();

        // Pass back the start and end dates to the view
        return view('downtime.index', compact('times', 'start_date', 'end_date'));
    }
}
