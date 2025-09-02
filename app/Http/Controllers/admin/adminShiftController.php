<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class adminShiftController extends Controller
{
    public function index()
    {
        $shifts = Shift::all();
        return view('shifts.index', ['shifts' => $shifts]);
    }

    public function create()
    {
        return view('shifts.add');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {

            // Store Data
            $shift = Shift::create([
                'nama_shift' => $request->nama_shift,
                'jam_mulai_shift'   => $request->jam_mulai_shift,
                'jam_akhir_shift'   => $request->jam_akhir_shift,
            ]);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('shifts.index')->with('success', 'Shift Created Successfully.');
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function edit(Shift $shift)
    {
        return view('shifts.edit', ['shift'  => $shift]);
    }

    public function update(Request $request, Shift $shift)
    {
        DB::beginTransaction();
        try {

            // Store Data
            $shift_updated = Shift::whereId($shift->id)->update([
                'nama_shift'   => $request->nama_shift,
                'jam_mulai_shift'   => $request->jam_mulai_shift,
                'jam_akhir_shift'   => $request->jam_akhir_shift,
            ]);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('shifts.index')->with('success', 'Shift Updated Successfully.');
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function delete(Shift $shift)
    {
        DB::beginTransaction();
        try {
            // Delete User
            Shift::whereId($shift->id)->delete();

            DB::commit();
            return redirect()->route('shifts.index')->with('success', 'Shift Deleted Successfully!.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
