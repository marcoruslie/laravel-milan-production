<?php

namespace Database\Seeders;

use App\Models\Shift;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Shift::create([
            'nama_shift' => '1',
            'jam_mulai_shift' => '8',
            'jam_akhir_shift' => '15'
        ]);
        Shift::create([
            'nama_shift' => '2',
            'jam_mulai_shift' => '16',
            'jam_akhir_shift' => '23'
        ]);
        Shift::create([
            'nama_shift' => '3',
            'jam_mulai_shift' => '0',
            'jam_akhir_shift' => '7'
        ]);
    }
}
