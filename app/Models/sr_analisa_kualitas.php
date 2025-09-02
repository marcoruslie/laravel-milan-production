<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sr_analisa_kualitas extends Model
{
    use HasFactory;
    protected $table = 'sr_analisa_kualitas';
    protected $fillable = [
        'order_id',
        'kode_size',
        'size',
        'material_desc',
        'jenis_tile',
        'no_ph',
        'no_hd',
        'no_gl',
        'no_car_gl',
        'tgl_loading',
        'jam_loading',
        'no_kiln',
        'no_car_kiln',
        'speed_kiln',
        'tgl_bakar',
        'jam_bakar',
        'jenis_box',
        'jenis_mesin_cutting',
        'no_mesin_cutting',
        'input_cutting',
        'cara_sortir',
        'kw1',
        'kw2',
        'kw3',
        'kw4',
    ];
    public function srListKualitas()
    {
        return $this->hasMany(sr_list_kualitas::class, 'sr_analisa_id');
    }
}
