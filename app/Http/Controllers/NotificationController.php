<?php

namespace App\Http\Controllers;

use App\Models\detail_qc_po;
use App\Models\Headers;
use App\Models\itp_standards;
use App\Models\list_header_po;
use App\Models\mesin;
use App\Models\Shift;
use App\Models\standard_Ph;
use App\Models\temp_car;
use App\Nova\header;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Header as Psr7Header;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function addPlayerId(Request $request)
    {
        $request->validate([
            'player_id' => 'required',
            'user_id' => 'required',
        ]);



        return response()->json(['message' => 'sukses']);
    }
}
