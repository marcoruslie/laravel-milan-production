<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ph_dryer extends Model
{
    protected $fillable = [
        'shift_id',
        'order_id',
        'user_id',
        'mesin_id',
        'lane',
        'size',
        'jenis',
        'dryers',
        'param1',
        'param2',
        'param3',
        'param4',
        'param5',
        'counterVd',
        'tempAplikasi',
        'kondisi_et',
        'floating_grid',
        'sikat_rol',
        'below',
        'keterangan',
        'is_confirm'
    ];

    public function shift_dryer()
    {
        return $this->belongsTo(Shift::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    use HasFactory;
}
