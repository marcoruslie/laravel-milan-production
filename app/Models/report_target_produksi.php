<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class report_target_produksi extends Model
{
    use HasFactory;
    protected $table = 'report_target_produksi';
    protected $fillable = [
        'po_id',
        'po_date',
        'start_hour',
        'material_desc',
        'hasil',
        'target',
        'keterangan',
    ];
}
