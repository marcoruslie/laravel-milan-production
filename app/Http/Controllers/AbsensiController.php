<?php

namespace App\Http\Controllers;

use App\Models\absensi_opr_for_karu;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class AbsensiController extends Controller
{
    public function createAbsensi(Request $request)
    {
        // Cek apakah data absensi sudah ada
        $dataAbsensi = absensi_opr_for_karu::where('opr_id', $request->opr_id)
            ->where('kode_group', $request->karuKodeGrup)
            ->where('kode_area', $request->karuKodeArea)
            ->whereDate('created_at', Carbon::today())
            ->first();

        $response = Http::timeout(50)
            ->get('http://172.31.3.13/ci-milan-restserver-wa/index.php/Absensiraw_GetByArea?areakerja=' . $request->oprKodeArea . '&kodegroup=' . $request->oprKodeGrup);

        $data = $response->body();
        $users = json_decode($data);
        // Mendapatkan user yang sesuai dengan opr_id
        $foundUser = null;
        foreach ($users as $user) {
            if ($user->nip == $request->opr_id) {
                $foundUser = $user;
                break; // langsung berhenti kalau sudah ketemu
            }
        }


        if ($dataAbsensi) {
            return response()->json(['message' => 'Absensi already exists']);
        } else {
            $absensi = new absensi_opr_for_karu();
            $absensi->karu_id = $request->karu_id;
            $absensi->opr_id = $request->opr_id;
            $absensi->kode_group = $request->karuKodeGrup;
            $absensi->kode_area = $request->karuKodeArea;
            $absensi->kehadiran = $request->kehadiran;
            $absensi->cek_log = $foundUser->cek_log ?? null; // kalau null, isi null

            $absensi->save();

            return response()->json(['message' => 'Absensi created successfully']);
        }
    }
    public function getAbsensi(Request $request)
    {
        // Fetch users from API
        $users = Http::timeout(50)->get(
            'http://172.31.3.13/ci-milan-restserver-wa/index.php/Absensiraw_GetByArea',
            [
                'areakerja' => $request->kodeArea,
                'kodegroup' => $request->kodeGrup,
            ]
        )->json();

        if (!$users) {
            return response()->json(['data' => []], 200);
        }

        // Filter out karu_id and remove duplicates by nip
        $filteredUsers = collect($users)
            ->reject(fn($user) => $user['nip'] == $request->karu_id)
            ->unique('nip')
            ->values();

        // Fetch existing absensi for today
        $existingAbsensi = DB::table('absensi_opr_for_karu')
            ->where('kode_group', $request->kodeGrup)
            ->whereDate('created_at', Carbon::today())
            ->pluck('opr_id')
            ->toArray();

        // Insert only new users
        $newRecords = $filteredUsers
            ->reject(fn($user) => in_array($user['nip'], $existingAbsensi))
            ->map(fn($user) => [
                'karu_id'    => $request->karu_id,
                'opr_id'     => $user['nip'],
                'kode_group' => $request->kodeGrup,
                'kode_area'  => $request->kodeArea,
                'kehadiran'  => $user['tgl'] ?: null,
                'cek_log'    => $user['tgl'] ?: null,
                'created_at' => now(),
                'updated_at' => now(),
            ])
            ->all();

        if (!empty($newRecords)) {
            DB::table('absensi_opr_for_karu')->insert($newRecords);
        }

        // Return joined absensi data for today
        $absensi = DB::table('absensi_opr_for_karu')
            ->join('users', 'absensi_opr_for_karu.opr_id', '=', 'users.nip')
            ->where('absensi_opr_for_karu.kode_area', $request->kodeArea)
            ->where('absensi_opr_for_karu.kode_group', $request->kodeGrup)
            ->whereDate('absensi_opr_for_karu.created_at', Carbon::today())
            ->select('absensi_opr_for_karu.*', 'users.nama')
            ->get();

        return response()->json(['data' => $absensi]);
    }

    public function updateAbsensi(Request $request)
    {
        $absensi = absensi_opr_for_karu::find($request->id);
        if ($request->kehadiran == 'Hadir') {
            $absensi->kehadiran = Carbon::now();
        } else {
            $absensi->kehadiran = null;
        }
        $absensi->save();

        return response()->json(['message' => 'Absensi updated successfully']);
    }
    public function getDataUser($kode_grup)
    {
        $dbAbsensi = DB::table('absensi_opr_for_karu')
            ->join('users', 'absensi_opr_for_karu.opr_id', '=', 'users.nip')
            ->where('absensi_opr_for_karu.kode_group', $kode_grup)
            ->whereDate('absensi_opr_for_karu.created_at', Carbon::today())
            ->select('absensi_opr_for_karu.opr_id') // Only select the 'opr_id' field to check duplicates
            ->get()
            ->pluck('opr_id') // Pluck 'opr_id' to get a simple list of existing 'opr_id'
            ->toArray();
        $response = User::where('kode_jabatan', 'OPR')
            ->where('kode_grup', $kode_grup)
            ->whereNotNull('kode_area') // ini yang benar untuk cek not null
            ->get();

        // filter the response to exclude users that already exist in the database ind dbAbsensi named opr_id and in response named nip
        $filteredUsers = array_filter($response->toArray(), function ($user) use ($dbAbsensi) {
            return !in_array($user['nip'], $dbAbsensi);
        });
        $response = array_values($filteredUsers);
        return response()->json(['user' => $response]);
    }
}
