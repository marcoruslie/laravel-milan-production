<?php

namespace App\Models;

use App\Nova\shift;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Headers extends Model
{
    use HasFactory, SoftDeletes;

    // protected $dispatchesEvents = [
    //     'kode' => GenerateUniqueCode::class,
    // ];

    protected $fillable = [
        'kode',
        'mesin_id',
        'sales_id',
    ];

    public function getRouteKey()
    {
        return 'kode';
    }

    public function shift()
    {
        return $this->hasMany(shift::class);
    }
}
