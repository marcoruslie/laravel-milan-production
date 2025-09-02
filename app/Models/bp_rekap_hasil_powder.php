<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bp_rekap_hasil_powder extends Model
{
    use HasFactory;

    protected $fillable = [
        'shift_id',
        'order_id',
        'user_id',
        'kode_material',
        'mesin_id',
        'lane',
        'stok1',
        'stok2',
        'stok3',
        'stok4',
        'stok5',
        'stok6',
        'stok7',
        'stok8',
        'stok9',
        'stok10',
        'stok11',
        'stok12',
        'stok13',
        'stok14',
        'stok15',
        'stok16',
        'stok17',
        'stok18',
        'stok19',
        'stok20',
        'total_powder',
        'atm40',
        'kapasitas40',
        'atm90',
        'kapasitas90',
        'is_confirm',
        'kode_material',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
