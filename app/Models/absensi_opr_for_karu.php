<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class absensi_opr_for_karu extends Model
{
    use HasFactory;
    protected $table = 'absensi_opr_for_karu';
    protected $fillable = [
        'karu_id',
        'opr_id',
        'kode_group',
        'kode_area',
        'kehadiran'
    ];

    public function karu()
    {
        return $this->belongsTo(User::class, 'karu_id', 'nip');
    }

    public function opr()
    {
        return $this->belongsTo(User::class, 'opr_id', 'nip');
    }
}
