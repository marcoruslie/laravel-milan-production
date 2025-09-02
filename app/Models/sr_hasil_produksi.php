<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sr_hasil_produksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'shift_id',
        'order_id',
        'user_id',
        'mesin_id',
        'lane',
        'from',
        'no',
        'jumlah',
        'unloading',
        'a',
        's',
        'm',
        'l',
        'll',
        'xm',
        'xl',
        'b',
        'e',
        'g',
        'h',
        'f',
        'c',
        'q',
        'kw4',
        'jumlah_total',
        'karton',
        'kw4Ket',
        'bs',
        'afal',
        'total',
        'is_confirm',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
