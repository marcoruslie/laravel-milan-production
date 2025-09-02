<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bp_pengendalian_slip extends Model
{
    use HasFactory;

    protected $fillable = [
        'shift_id',
        'order_id',
        'user_id',
        'mesin_id',
        'lane',
        'bm',
        'komposisi',
        'air_liter',
        'start',
        'finish',
        'sttp',
        'water_glass',
        'air',
        'jam_giling',
        'alumina',
        'setting_jam_giling',
        'total_jam_giling',
        'masuk_tanki_no'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
