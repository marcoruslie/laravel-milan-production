<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\temp_car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class adminCarController extends Controller
{
    public function index()
    {
        $cars = temp_car::all();
        return view('cars.index', ['cars' => $cars]);
    }

    public function create()
    {
        return view('cars.add');
    }

    public function store(Request $request)
    {
        // // Validations
        // $request->validate([
        //     'first_name'    => 'required',
        //     'last_name'     => 'required',
        //     'email'         => 'required|unique:users,email',
        //     'mobile_number' => 'required|numeric|digits:10',
        //     'role_id'       =>  'required|exists:roles,id',
        //     'status'       =>  'required|numeric|in:0,1',
        // ]);

        DB::beginTransaction();
        try {

            // Store Data
            $car = temp_car::create([
                'nocar'      => $request->nocar,
                'status'     => $request->status,
                'assign_to'  => $request->assign_to,
            ]);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('cars.index')->with('success', 'car Created Successfully.');
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function edit(temp_car $car)
    {
        return view('cars.edit', ['car'  => $car]);
    }

    public function update(Request $request, temp_car $car)
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
            $car_updated = temp_car::whereId($car->id)->update([
                'nocar'      => $request->nocar,
                'status'     => $request->status,
                'assign_to'  => $request->assign_to,
            ]);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('cars.index')->with('success', 'Car Updated Successfully.');
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function delete(temp_car $car)
    {
        DB::beginTransaction();
        try {
            // Delete User
            temp_car::whereId($car->id)->delete();

            DB::commit();
            return redirect()->route('cars.index')->with('success', 'Car Deleted Successfully!.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
