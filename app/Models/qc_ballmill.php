<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class qc_ballmill extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'shift_id',
        'user_id',
        'mesin_id',
        'lane',
        'size',
        'jenis',
        'kode_body',
        'no_bm',
        'setting_jam',
        'start_milling',
        'stop_milling',
        'sttp_def',
        'wg_def',
        'air', 'tgl_cek',
        'jam_cek',
        'vs_rhology',
        'ds_rhology',
        'ka_rhology',
        'rs_rhology',
        'sttp_koreksi',
        'wg_koreksi',
        'air_koreksi',
        'jamling_koreksi',
        'jam_tap',
        'total_miling',
        'tangki_tap',
        'ruang_bm',
        'ruang_slip',
        'is_confirm',
    ];
}
