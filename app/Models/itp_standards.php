<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class itp_standards extends Model
{
    use HasFactory;

    protected $fillable = [
        'mesin',
        'form',
        'field',
        'var1',
        'var2',
        'var3',
        'var4',
        'valfr',
        'valto'
    ];
}
