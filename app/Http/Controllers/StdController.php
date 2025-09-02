<?php

namespace App\Http\Controllers;

use App\Models\itp_standards;
use Illuminate\Http\Request;

class StdController extends Controller
{
    public function getStd($mesin, $form)
    {
        $result = itp_standards::where('mesin', $mesin)
            ->where('form', $form)
            ->get();
        return response()->json(['std' => $result]);
    }
}
