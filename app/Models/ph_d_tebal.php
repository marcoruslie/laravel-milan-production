<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ph_d_tebal extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'h_tebal_id',
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

    public function h_tebal()
    {
        return $this->belongsTo(ph_tebal::class);
    }
}
