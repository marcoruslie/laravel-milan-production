<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gl_detail_pengendalian_proses extends Model
{
    use HasFactory;

    protected $fillable = [
        'gl_pengendalian_proses_id',
        'viscositas',
        'densitas',
        'berat',
    ];

    public function gl_pengendalian_proses()
    {
        return $this->belongsTo(gl_pengendalian_proses::class);
    }
}
