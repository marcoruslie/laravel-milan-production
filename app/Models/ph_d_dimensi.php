<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ph_d_dimensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'h_dimensi_id',
        'D1',
        'D2',
        'D3',
        'D4',
        'D5',
        'D6',
        'D7',
        'D8',
        'center',
    ];

    public function h_dimensi()
    {
        return $this->belongsTo(ph_dimensi::class);
    }
}
