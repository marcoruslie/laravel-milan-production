<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class qc_pengamatan_tes_bakar_gl extends Model
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
        'hasil_printing',
        'hasil_surface',
        'no_mould',
        'engobe_body',
        'engobe_glaze',
        'is_confirm',
    ];
}
