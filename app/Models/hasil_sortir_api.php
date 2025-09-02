<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hasil_sortir_api extends Model
{
    use HasFactory;

    protected $fillable = [
        'AUFNR',
        'MATNR',
        'WERKS',
        'LGORT',
        'BWART',
        'MENGE',
        'ERFMG',
        'ERFME',
        'MAKTX',
        'MBLNR',
        'MJAHR',
        'BUDAT',
        'WRHZET',
        'ARBPL',
        'MVGR4',
        'IDNRK',
    ];
}
