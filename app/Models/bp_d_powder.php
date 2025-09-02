<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bp_d_powder extends Model
{
    use HasFactory;
    protected $table = 'bp_d_powders';

    protected $fillable = [
        'pengendalian_id',
        't1',
        't3',
        'silo',
        'kadar_air',
        'ppb',
        'vc',
        'mf',
        'af',
    ];

    public function h_pengendalian_powder()
    {
        return $this->belongsTo(bp_pengendalian_powder::class, 'pengendalian_id');
    }
}
