<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class qc_pengecekan_tile_out extends Model
{
    use HasFactory;

    protected $fillable = [
        'shift_id',
        'order_id',
        'user_id',
        'mesin_id',
        'lane',
        'size',
        'jenis',
        'temp_rk',
        'speed_rk',
        'phgl',
        'surface',
        'blackcore',
        'is_confirm',
    ];

    public function d_tile()
    {
        return $this->hasMany(qc_detail_tile_out::class, 'h_tile_out_id');
    }
}
