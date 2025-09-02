<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class list_header_po extends Model
{
    use HasFactory;
    protected $table = 'list_header_po';
    protected $fillable = [
        'po_id',
        'po_date',
        'material_desc',
        'status_qc'
    ];
    public function detail_qc_po()
    {
        return $this->hasMany(detail_qc_po::class, 'id_header_po', 'po_id');
    }
}
