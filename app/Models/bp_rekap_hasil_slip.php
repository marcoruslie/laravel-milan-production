<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bp_rekap_hasil_slip extends Model
{
    use HasFactory;

    protected $fillable = [
        'shift_id',
        'order_id',
        'user_id',
        'kode_material',
        'mesin_id',
        'lane',
        'komposisi_body',
        'tab',
        'a2',
        'a3',
        'a4',
        'a6',
        'a7',
        'a8',
        'a9',
        'a10',
        'a11',
        'a12',
        'b1',
        'b2',
        'b3',
        'b4',
        'b5',
        'b6',
        'b7',
        'is_confirm',
        'kode_material',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
