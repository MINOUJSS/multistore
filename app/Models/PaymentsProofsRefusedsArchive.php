<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentsProofsRefusedsArchive extends Model
{
    use HasFactory;
    //
    protected $fillable = [
        'original_proof_id',
        'order_number',
        'user_id',
        'user_name',
        'user_email',
        'user_phone',
        'proof_path',
        'refuse_reason',
        'admin_notes',
        'admin_id',
        'admin_name',
        'admin_email',
        'admin_phone',
        'status',
        'archive_pdf_path',
        'refused_at',
        'archived_at',
    ];
}
