<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class qc_dalam_box_hasil_sortir extends Model
{
    use HasFactory;

    protected $fillable = [
        'shift_id',
        'order_id',
        'user_id',
        'mesin_id',
        'lane',
        'size_box',
        'jenis',
        'kw',
        'motif',
        'uk',
        'size',
        'tonality',
        'cek_surface',
        'kw1',
        'kw2',
        'kw3',
        'kw4',
        'pass_qc',
        'barcode',
        'is_confirm',
    ];
}
