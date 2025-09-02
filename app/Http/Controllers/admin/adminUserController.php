<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class adminUserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', ['users' => $users]);
    }

    public function edit(User $user)
    {
        return view('users.edit', ['user'  => $user]);
    }

    public function update(Request $request, User $user)
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
            $user_updated = User::whereId($user->id)->update([
                'nip'    => $request->nip,
                'email'     => $request->nip,
                'nama'         => $request->nama,
                'kode_divisi' => $request->kode_divisi,
                'kode_bagian'       => $request->kode_bagian,
                'kode_jabatan'       => $request->kode_jabatan,
                'kode_grup'       => $request->kode_grup,
            ]);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('users.index')->with('success', 'User Updated Successfully.');
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function delete(User $user)
    {
        DB::beginTransaction();
        try {
            // Delete User
            User::whereId($user->id)->delete();

            DB::commit();
            return redirect()->route('users.index')->with('success', 'User Deleted Successfully!.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
