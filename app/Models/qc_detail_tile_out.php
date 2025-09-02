<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class qc_detail_tile_out extends Model
{
    use HasFactory;

    protected $fillable = [
        'h_tile_out_id',
        'val1',
        'val2',
        'val3',
        'val4',
        'val5',
        'ukuran1',
        'ukuran2',
        'ukuran2',
        'tebal',
        'dial',
        'beberan',
        'visual',
    ];
}
