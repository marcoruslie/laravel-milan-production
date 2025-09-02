<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rk_pengendalian_proses extends Model
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
        'fan_vacum',
        'fan_temp',
        'gas_preasure',
        'h28',
        'h27',
        'h1',
        'h2',
        'h3',
        'f4',
        'h5',
        'f6',
        'f6_setting',
        'h7',
        'f8',
        'a9',
        'a9_setting',
        'a10',
        'a10_setting',
        'a11',
        'a11_setting',
        'a12',
        'a12_setting',
        'a13',
        'a13_setting',
        'a14',
        'a14_setting',
        'a15',
        'a15_setting',
        'a16',
        'a16_setting',
        'a17',
        'a17_setting',
        'a18',
        'a18_setting',
        'a19',
        'a19_setting',
        'a20',
        'a20_setting',
        'a21',
        'a21_setting',
        'a22',
        'a22_setting',
        'a23',
        'a24',
        'f25',
        'f26',
        'f26_setting',
        'comb_preasure',
        'comb_temp',
        'zero_point',
        'hot_air_fan',
        'speedy_preasure',
        'keterangan',
        'is_confirm'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
