<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nama_shift',
        'jam_mulai_shift',
        'jam_akhir_shift',
    ];

    public function tesBakar()
    {
        return $this->hasMany(ph_control::class);
    }

    public function temp()
    {
        return $this->hasMany(ph_temp::class);
    }

    public function dimensi()
    {
        return $this->hasMany(ph_dimensi::class);
    }

    public function tebal()
    {
        return $this->hasMany(ph_tebal::class);
    }

    public function dryer()
    {
        return $this->hasMany(ph_dryer::class);
    }

    public function hasil_produksi()
    {
        return $this->hasMany(gl_hasil_produksi::class);
    }
}
