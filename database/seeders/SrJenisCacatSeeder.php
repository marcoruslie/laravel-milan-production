<?php

namespace Database\Seeders;

use App\Models\sr_jenis_cacat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SrJenisCacatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear the table
        sr_jenis_cacat::truncate();
        // Insert the predefined data
        DB::table('sr_jenis_cacat')->insert(
            [
                ['jenis_cacat' => 'Material diatas glazur', 'tipe' => 'cutting, non cutting'],
                ['jenis_cacat' => 'Timbul body (bawah glazur)', 'tipe' => 'cutting, non cutting'],
                ['jenis_cacat' => 'Mould rusak / kotor', 'tipe' => 'cutting, non cutting'],
                ['jenis_cacat' => 'Tetes air', 'tipe' => 'cutting, non cutting'],
                ['jenis_cacat' => 'Dropping dari cabin', 'tipe' => 'cutting, non cutting'],
                ['jenis_cacat' => 'Bintik hitam / warna lain', 'tipe' => 'cutting, non cutting'],
                ['jenis_cacat' => 'Lubang besar / spot holes', 'tipe' => 'cutting, non cutting'],
                ['jenis_cacat' => 'Lubang jarum / pin holes', 'tipe' => 'cutting, non cutting'],
                ['jenis_cacat' => 'Crawling', 'tipe' => 'cutting, non cutting'],
                ['jenis_cacat' => 'Perm. bergelombang / njeruk', 'tipe' => 'cutting, non cutting'],
                ['jenis_cacat' => 'Nggaris', 'tipe' => 'cutting, non cutting'],
                ['jenis_cacat' => 'Legok glaze', 'tipe' => 'cutting, non cutting'],
                ['jenis_cacat' => 'Legok lengket', 'tipe' => 'cutting, non cutting'],
                ['jenis_cacat' => 'Cacat printing tinta', 'tipe' => 'non cutting'],
                ['jenis_cacat' => 'Cacat printing', 'tipe' => 'cutting, non cutting'],
                ['jenis_cacat' => 'Ngelupas', 'tipe' => 'cutting, non cutting'],
                ['jenis_cacat' => 'Retak body', 'tipe' => 'cutting, non cutting'],
                ['jenis_cacat' => 'Retak glaze', 'tipe' => 'non cutting'],
                ['jenis_cacat' => 'Retak tepi', 'tipe' => 'non cutting'],
                ['jenis_cacat' => 'Percikan engobe body', 'tipe' => 'cutting, non cutting'],
                ['jenis_cacat' => 'Bubble & pori-pori', 'tipe' => 'cutting, non cutting'],
                ['jenis_cacat' => 'Planarity', 'tipe' => 'cutting, non cutting'],
                ['jenis_cacat' => 'Cooling crack', 'tipe' => 'cutting, non cutting'],
                ['jenis_cacat' => 'Permukaan Tergores', 'tipe' => 'cutting, non cutting'],
                ['jenis_cacat' => 'Cecel setelah cutting', 'tipe' => 'cutting'],
                ['jenis_cacat' => 'Mingul', 'tipe' => 'cutting'],
                ['jenis_cacat' => 'Gumpil sebelum glazur', 'tipe' => 'non cutting'],
                ['jenis_cacat' => 'Gumpil setelah glazur', 'tipe' => 'cutting, non cutting'],
                ['jenis_cacat' => 'Gumpil setelah cutting', 'tipe' => 'cutting'],
                ['jenis_cacat' => 'Gumpil setelah bakar', 'tipe' => 'non cutting'],
                ['jenis_cacat' => 'Trapezium', 'tipe' => 'cutting, non cutting, dimensi'],
                ['jenis_cacat' => 'Cushion', 'tipe' => 'cutting, non cutting, dimensi'],
                ['jenis_cacat' => 'Diferensial', 'tipe' => 'non cutting, dimensi'],
                ['jenis_cacat' => 'Size diluar setting', 'tipe' => 'non cutting, dimensi'],
                ['jenis_cacat' => 'Under / Over size', 'tipe' => 'cutting'],
                ['jenis_cacat' => 'Ortogonal', 'tipe' => 'cutting']
            ]
        );
    }
}
