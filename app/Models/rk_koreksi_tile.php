<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rk_koreksi_tile extends Model
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
        'mode',
        'koreksi_kiln_kiri',
        'koreksi_kiln_kanan',
        'as',
        'at',
        'is_confirm'
    ];

    public function rk_d_koreksi()
    {
        return $this->hasMany(rk_d_koreksi::class, 'rk_koreksi_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
