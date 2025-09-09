<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rk_hasil_produksi extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = [
        'shift_id',
        'order_id',
        'user_id',
        'mesin_id',
        'kode_material',
        'lane',
        'size',
        'jenis',
        'from',
        'no',
        'outKiln',
        'start',
        'stop',
        'menit',
        'jumlah',
        'is_confirm',
        'kode_material',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
