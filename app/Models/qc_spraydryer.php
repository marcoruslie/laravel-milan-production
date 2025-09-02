<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class qc_spraydryer extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'shift_id',
        'user_id',
        'kode_body',
        'jam_cek_1',
        'vs_rheology',
        'ds_rheology',
        'ka_rheology',
        'rs_rheology',
        'jam_cek_2',
        'tek_ppb_1',
        'tek_ppb_2',
        't3',
        'jum_noz',
        'g_30',
        'g_40',
        'g_50',
        'g_60',
        'g_80',
        'g_120',
        'g_230',
        'g_230_more',
        'jumlah',
        'ka',
        'silo',
        'stock_powder',
        'is_confirm',
    ];
}
