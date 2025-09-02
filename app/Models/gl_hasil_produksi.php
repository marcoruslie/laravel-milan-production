<?php

namespace App\Models;

use App\Nova\shift;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gl_hasil_produksi extends Model
{
    use HasFactory;

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
        'tipe',
        'start',
        'stop',
        'menit',
        'jumlah',
        'is_confirm',
        'kode_material',
    ];

    public function shift_hasil_produksi()
    {
        return $this->belongsTo(shift::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
