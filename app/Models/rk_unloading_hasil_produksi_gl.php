<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rk_unloading_hasil_produksi_gl extends Model
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
        'from',
        'no',
        'jumlah',
        'kompensator',
        'start',
        'stop',
        'menit',
        'unloading',
        'is_confirm'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
