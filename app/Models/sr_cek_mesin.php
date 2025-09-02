<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sr_cek_mesin extends Model
{
    use HasFactory;

    protected $fillable = [
        'shift_id',
        'order_id',
        'user_id',
        'mesin_id',
        'lane',
        'mesin',
        'kondisi',
        'keterangan',
        'is_confirm'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
