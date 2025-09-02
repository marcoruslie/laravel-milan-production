<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;

class shiftController extends Controller
{
    public function createShift(Request $request)
    {
        $validated = $request->validate([
            'kode_header' => 'required',
            'shift' => 'required',
        ]);

        $baru = Shift::create($request->all());
        return response()->json(['message' => 'sukses', 'body' => $baru]);
    }

    public function get()
    {
        $shift = Shift::all();
        return response()->json(['shift' => $shift]);
    }

    // public function updateCounter(Request $request)
    // {
    //     $ph = $request->ph; // Mengambil nilai "ph" dari $request
    //     $counter = $request->val;
    //     $targetId = Shift::whereHas('header', function ($query) use ($ph) {
    //         $query->where('ph', $ph);
    //     })->where('kode_header', $request->kode)->where('shift', $request->shift)->value('id');

    //     if ($targetId) {
    //         // Langkah 2: Cari id yang lebih kecil
    //         $smallerIds = Shift::where('id', '<', $targetId)
    //             ->whereHas('header', function ($query) use ($ph) {
    //                 $query->where('ph', $ph);
    //             })
    //             ->pluck('id');

    //         // Langkah 3: Lakukan pembaruan pada kolom 'hasil' pada record dengan smaller id

    //         if ($smallerIds->count() > 0) {

    //             $mesin = mesin::where('kode_mesin', '=', $request->ph)->value('counter');
    //             $selisih = $counter - $mesin;
    //             // print($mesin);

    //             Shift::whereIn('id', $smallerIds)->update(['hasil' => DB::raw("`hasil` + $selisih")]);
    //         }

    //         // Langkah 4: Lakukan pembaruan pada kolom 'counter' pada record target
    //         Shift::where('id', $targetId)->update(['counter' => $counter]);
    //         mesin::where('kode_mesin', '=', $request->ph)
    //             ->update(['counter' => $request->val]);
    //     }
    //     return response()->json(['message' => 'sukses']);
    // }
}
