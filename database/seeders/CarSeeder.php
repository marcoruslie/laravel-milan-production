<?php

namespace Database\Seeders;

use App\Models\temp_car;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 270; $i++) {
            temp_car::create([
                'nocar' => $i,
                'status' => '0',
                'assign_to' => '-',
            ]);
        }
    }
}
