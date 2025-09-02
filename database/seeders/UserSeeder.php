<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'nip' => '1234',
            'email' => 'sac@gmail.com',
            'nama' => 'chris',
            'kode_divisi' => '2',
            'kode_bagian' => '2',
            'kode_jabatan' => '2',
            'kode_grup' => '2',
            'password' => '123',
        ]);
    }
}
