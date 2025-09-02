<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class down_time extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'work_center',
        'start_date',
        'start_time',
        'respond_date',
        'respond_time',
        'finish_date',
        'finish_time',
        'total',
        'grund',
        'lngtxt',
        'cancel',
        'status',
    ];
}
