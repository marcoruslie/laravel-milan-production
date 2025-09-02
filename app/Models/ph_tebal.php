<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ph_tebal extends Model
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

    public function shift_tebal()
    {
        return $this->belongsTo(Shift::class);
    }

    public function d_tebal()
    {
        return $this->hasMany(ph_d_tebal::class, 'h_tebal_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
