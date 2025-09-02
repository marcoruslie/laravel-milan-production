<?php

namespace Database\Seeders;

use App\Models\Headers;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Headers::create([
            'kode' => 'K000001',
            'mesin_id' => '1',
            'sales_id' => '1'
        ]);
        Headers::create([
            'kode' => 'K000002',
            'mesin_id' => '2',
            'sales_id' => '2'
        ]);
        Headers::create([
            'kode' => 'K000003',
            'mesin_id' => '3',
            'sales_id' => '3'
        ]);
        Headers::create([
            'kode' => 'K000004',
            'mesin_id' => '4',
            'sales_id' => '4'
        ]);
    }
}
