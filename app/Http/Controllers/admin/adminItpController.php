<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\itp_standards;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class adminItpController extends Controller
{
    public function index()
    {
        $itps = itp_standards::all();
        return view('itps.index', ['itps' => $itps]);
    }

    public function create()
    {
        return view('itps.add');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {

            // Store Data
            $car = itp_standards::create([
                'mesin' => $request->mesin,
                'form'   => $request->form,
                'field'   => $request->field,
                'var1'   => $request->var1,
                'var2'   => $request->var2,
                'var3'   => $request->var3,
                'var4'   => $request->var4,
                'var5'   => $request->var5,
                'valfr'  => $request->valfr,
                'valto'  => $request->valto,
            ]);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('itps.index')->with('success', 'Itp Created Successfully.');
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function edit(itp_standards $itp)
    {
        return view('itps.edit', ['itp'  => $itp]);
    }

    public function update(Request $request, itp_standards $itp)
    {
        DB::beginTransaction();
        try {

            // Store Data
            $itp_updated = itp_standards::whereId($itp->id)->update([
                'mesin'   => $request->mesin,
                'form'   => $request->form,
                'field'   => $request->field,
                'var1'   => $request->var1,
                'var2'   => $request->var2,
                'var3'   => $request->var3,
                'var4'   => $request->var4,
                'var5'   => $request->var5,
                'valfr'  => $request->valfr,
                'valto'  => $request->valto,
            ]);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('itps.index')->with('success', 'Itp Updated Successfully.');
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function delete(itp_standards $itp)
    {
        DB::beginTransaction();
        try {
            // Delete User
            itp_standards::whereId($itp->id)->delete();

            DB::commit();
            return redirect()->route('itps.index')->with('success', 'itp Deleted Successfully!.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
