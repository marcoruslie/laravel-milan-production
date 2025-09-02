<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ph_counter extends Model
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
        'db',
        'up_m1',
        'up_m2',
        'up_m3',
        'up_m4',
        'lw_m1',
        'lw_m2',
        'lw_m3',
        'lw_m4',
        'is_confirm'
    ];

    public function shift_counter()
    {
        return $this->belongsTo(Shift::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
