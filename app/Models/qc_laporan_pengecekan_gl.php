<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class qc_laporan_pengecekan_gl extends Model
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
        'berat',
        'c',
        'c_val',
        'ds',
        'vs',
        'brt',
        'is_confirm',
    ];
}
