<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ph_temp_out extends Model
{
    use HasFactory;

    protected $fillable = [
        'shift_id',
        'order_id',
        'user_id',
        'mesin_id',
        'lane',
        'size',
        'jenis',
        'sap_11',
        'sap_12',
        'sap_13',
        'sap_14',
        'sap_21',
        'sap_22',
        'sap_23',
        'sap_24',
        'sap_31',
        'sap_32',
        'sap_33',
        'sap_34',
        'sap_41',
        'sap_42',
        'sap_43',
        'sap_44',
        'sap_51',
        'sap_52',
        'sap_53',
        'sap_54',
        'is_confirm'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
