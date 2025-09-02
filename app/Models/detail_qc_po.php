<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detail_qc_po extends Model
{
    use HasFactory;
    protected $table = 'detail_qc_po';
    protected $fillable = [
        'po_id',
        'nip_user',
        'keterangan',
        'status',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'nip_user', 'nip');
    }
    public function header_po()
    {
        return $this->belongsTo(list_header_po::class, 'po_id', 'po_id');
    }
}
