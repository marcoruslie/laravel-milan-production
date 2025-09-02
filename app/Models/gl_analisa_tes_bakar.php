<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gl_analisa_tes_bakar extends Model
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
        'grup_motive',
        'jenis_cacat',
        'no_mould',
        'jenis_perbaikan',
        'status',
        'is_confirm'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
