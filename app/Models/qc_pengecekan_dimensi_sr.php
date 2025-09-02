<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class qc_pengecekan_dimensi_sr extends Model
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
        'size1',
        'size2',
        'size3',
        'size4',
        'visual',
        'dial',
        'sd',
        'is_confirm',
    ];
}
