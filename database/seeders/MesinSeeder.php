<?php

namespace Database\Seeders;

use App\Models\mesin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MesinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        mesin::create([
            'kode_mesin' => 'PH 1',
            'counter' => '0',
        ]);
        mesin::create([
            'kode_mesin' => 'PH 2',
            'counter' => '0',
        ]);
        mesin::create([
            'kode_mesin' => 'PH 3',
            'counter' => '0',
        ]);
        mesin::create([
            'kode_mesin' => 'PH 4',
            'counter' => '0',
        ]);
        mesin::create([
            'kode_mesin' => 'PH 5',
            'counter' => '0',
        ]);
        mesin::create([
            'kode_mesin' => 'PH 6',
            'counter' => '0',
        ]);
        mesin::create([
            'kode_mesin' => 'PH 7',
            'counter' => '0',
        ]);
        mesin::create([
            'kode_mesin' => 'PH 8',
            'counter' => '0',
        ]);
    }
}
