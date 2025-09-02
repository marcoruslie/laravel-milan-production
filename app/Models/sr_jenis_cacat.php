<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sr_jenis_cacat extends Model
{
    use HasFactory;
    protected $table = 'sr_jenis_cacat';
    protected $fillable = [
        'jenis_cacat',
        'tipe'
    ];
    public function srListKualitas()
    {
        return $this->hasMany(sr_list_kualitas::class, 'cacat_id');
    }
}
