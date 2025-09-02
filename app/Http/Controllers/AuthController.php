<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required'
    //     ]);

    //     $user = User::where('email', $request->email)->first();
    //     if (!$user || !Hash::check($request->password, $user->password)) {
    //         throw ValidationException::withMessages([
    //             'email' => ['The provided credentials are incorrect.'],
    //         ]);
    //     }
    //     return response()->json([
    //         'user' => $user,
    //         'token' => $user->createToken($request->email)->plainTextToken,
    //     ]);
    //     // return $user->createToken($request->email)->plainTextToken;
    //     // return response()->json($user);
    // }

    // public function login(Request $request)
    // {
    //     // dd(gettype($request->password));
    //     $pass = strtoupper(
    //         sha1(
    //             sha1($request->password, true)
    //         )
    //     );
    //     $pass = '*' . $pass;

    //     // $response = Http::timeout(50)
    //     // ->get('http://developer.milantiles.co.id/androapi/SelectKueri.php?kueri=select u., m. from user u, masteremployee m where u.user = m.nip and m.Nip =' . $request->username . ' and u.password="' . $pass . '"');
    // $response = Http::timeout(50)
    //     ->get('http://117.102.76.211/ci-milan-restserver/index.php/user?user=' . $request->username . ' &password=' . $pass);
    // $data = $response->body();
    // $users = json_decode($data);
    //     return response()->json([
    //         'user' => $users,
    //         'token' => $users->createToken($request->username)->plainTextToken,
    //     ]);
    // }

    public function getDataUser($nip)
    {
        $response = User::where('nip', $nip)->first();
        return response()->json(['user' => $response]);
    }
    public function login(Request $request)
    {
        $pass = strtoupper(
            sha1(
                sha1($request->password, true)
            )
        );
        $pass = '*' . $pass;

        $hash = Hash::make($request->password, [
            'rounds' => 12,
        ]);

        $response = Http::timeout(50)
            ->get('http://172.31.3.13/ci-milan-restserver-wa/index.php/user?user=' . $request->username . '&password=' . $pass);
        $data = $response->body();
        $users = json_decode($data);
        if (!empty($users)) {
            // Cari user berdasarkan email
            $user = User::where('email', $users[0]->user)->first();
            $updateData = [
                'nip' => $users[0]->Nip,
                'nama' => $users[0]->name,
                'kode_divisi' => $users[0]->{'Kode Divisi'},
                'kode_bagian' => $users[0]->{'Kode Bagian'},
                'kode_jabatan' => $users[0]->{'Kode Jabatan'},
                'kode_grup' => $users[0]->{'Kode Group'},
                'kode_area' => $users[0]->{'AreaKerja'},
            ];
            if ($user) {
                // Jika user ditemukan, cek apakah ada data yang berbeda

                // Cek apakah ada perubahan data
                if ($user->only(array_keys($updateData)) !== $updateData) {
                    $user->update($updateData);
                }
            } else {
                // Jika user tidak ditemukan, buat user baru

                $user = User::create(array_merge($updateData, ['email' => $users[0]->user, 'password' => $hash]));
            }
            // return  array_merge($updateData, ['email' => $users[0]->user, 'password' => $hash]);
            // // Generate token untuk user
            $token = $user->createToken($request->username)->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token,
            ]);
        } else {
            // Jika API tidak mengembalikan data user
            throw ValidationException::withMessages([
                'username' => ['Password atau username salah.'],
            ]);
        }
    }



    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
    }

    public function getDataUserLogin()
    {
        $user = Auth::user();
        return response()->json($user);
    }
}
