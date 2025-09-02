<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rk_d_koreksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'rk_koreksi_id',
        'T1',
        'T2',
        'T3',
        'T4',
        'T5',
        'T6',
        'T7',
        'T8',
        'T9',
    ];

    public function h_koreksi()
    {
        return $this->belongsTo(rk_koreksi_tile::class);
    }
}
