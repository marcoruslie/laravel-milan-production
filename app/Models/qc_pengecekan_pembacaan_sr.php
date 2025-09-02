<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class qc_pengecekan_pembacaan_sr extends Model
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
        'ver1',
        'ver2',
        'ver3',
        'ver4',
        'mesin1',
        'mesin2',
        'mesin3',
        'mesin4',
        'kalibrasi',
        'catatan',
        'is_confirm',
    ];
}
