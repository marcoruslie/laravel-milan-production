<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class update_log extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'shift',
        'user',
        'param1',
        'param2',
        'param3',
        'param4',
        'value_before',
        'value_after',
    ];
}
