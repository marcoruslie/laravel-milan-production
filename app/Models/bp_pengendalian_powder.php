<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bp_pengendalian_powder extends Model
{
    use HasFactory;

    protected $table = 'bp_pengendalian_powders';

    protected $fillable = [
        'shift_id',
        'order_id',
        'user_id',
        'kode_material',
        'mesin_id',
        'lane',
        'start_spray',
        'powder_masuk',
        'stop_spray',
        'dari_tanki',
        'ke_tanki',
        'reologi',
        'kapasitas',
        'granulasi',
        'indicator',
        'nozle_1',
        'nozle_2',
        'jumlah',
        'keterangan'
    ];

    public function detail_powder()
    {
        return $this->hasMany(bp_d_powder::class, 'pengendalian_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
