<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sr_list_kualitas extends Model
{
    use HasFactory;
    protected $table = 'sr_list_kualitas';
    protected $fillable = [
        'sr_analisa_id',
        'cacat_id',
        'kw2',
        'kw3',
        'kw4',
        'keterangan'
    ];
    public function srAnalisaKualitas()
    {
        return $this->belongsTo(sr_analisa_kualitas::class, 'sr_analisa_id');
    }
    public function srCacat()
    {
        return $this->belongsTo(sr_jenis_cacat::class, 'cacat_id');
    }
}
