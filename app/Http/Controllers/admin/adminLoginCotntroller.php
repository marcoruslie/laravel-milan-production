<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class adminLoginCotntroller extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);

        $pass = strtoupper(
            sha1(
                sha1($request->password, true)
            )
        );
        $pass = '*' . $pass;

        $hash = Hash::make($request->password, [
            'rounds' => 12,
        ]);

        // $response = Http::timeout(50)
        //     ->get('http://172.31.3.13/ci-milan-restserver/index.php/user?user=' . $request->email . '&password=' . $pass);
        // // ->get('http://117.102.76.211/ci-milan-restserver/index.php/user?user=' . $request->email . '&password=' . $pass);
        // $data = $response->body();
        // $users = json_decode($data);

        // Check if the authentication was successful
        //if (!empty($users)) {
        if (!empty($request->email)) {
            // Find or create the local user based on the external API response
            // $user = User::firstOrCreate(['email' => $users[0]->user], [
            //     'nip' => $users[0]->Nip,
            //     'nama' => $users[0]->name,
            //     'kode_divisi' => $users[0]->{'Kode Divisi'},
            //     'kode_bagian' => $users[0]->{'Kode Bagian'},
            //     'kode_jabatan' => $users[0]->{'Kode Jabatan'},
            //     'kode_grup' => $users[0]->{'Kode Group'},
            //     'password' => $hash,
            //     // Add other relevant fields from the external API response
            // ]);


            // if ($users[0]->{'Kode Admin'} == 'EM' || $users[0]->{'Kode Admin'} == 'PBR') {
            //     $user->is_admin = 1;
            //     $user->save();
            // }

            $result = Auth::attempt(['email' => $request->email, 'password' => $request->password]);
            // dd($request->email);

            if ($result) {
                // Authentication was successful...
                $user = Auth::user();
                if ($user->kode_jabatan == "KARU/KASHIFT") {
                    return redirect()->route('dashboard');
                } else if ($user->is_admin == 0) {
                    return back()->withErrors([
                        'email' => 'You are not admin!.',
                    ])->onlyInput('email');
                }
                return redirect()->intended('home');
            }

            return back()->withErrors([
                'email' => 'Session already has user!',
            ])->onlyInput('email');
        } else {
            // Handle authentication failure
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
