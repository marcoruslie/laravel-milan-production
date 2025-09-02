<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sr_hasil_sortir extends Model
{
    use HasFactory;

    protected $fillable = [
        'shift_id',
        'order_id',
        'user_id',
        'mesin_id',
        'lane',
        'description',
        'pcs',
        'persen',
        'is_confirm'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
