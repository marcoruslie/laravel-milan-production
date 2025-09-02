<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ph_dimensi extends Model
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
        'populasi',
        'is_confirm'
    ];

    public function shift_dimensi()
    {
        return $this->belongsTo(Shift::class);
    }

    public function ph_d_dimensi()
    {
        return $this->hasMany(ph_d_dimensi::class, 'h_dimensi_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
