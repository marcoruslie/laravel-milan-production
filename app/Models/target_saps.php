<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class target_saps extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'kiln',
        'size',
        'ipb',
        'box_per_24hour',
        'pcs_per_24hour',
        'pcs_per_hour',
        'std_min_1_per_24hour',
        'std_plus_1_per_24hour',
    ];
}
