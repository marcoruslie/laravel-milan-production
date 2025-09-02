<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gl_pengendalian_proses extends Model
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
        'jenis_aplikasi',
        'engobe',
        'engobe_visco',
        'engobe_densi',
        'engobe_berat',
        'glaze',
        'glaze_visco',
        'glaze_densi',
        'glaze_berat',
        'pasta',
        'pasta_visco',
        'pasta_densi',
        'temp_body',
        'set_pemukul',
        'sikat',
        'saringan',
        'is_confirm'
    ];

    public function shift_pengendalian_proses()
    {
        return $this->belongsTo(shift::class);
    }

    public function detail_pengendalian_proses()
    {
        return $this->hasMany(gl_detail_pengendalian_proses::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
