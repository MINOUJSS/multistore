<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisputesArchive extends Model
{
    use HasFactory;
    protected $fillable = [
        'dispute_id',
        'file_name',
        'file_path',
        'customer_name',
        'customer_phone',
        'customer_email',
        'seller_name',
        'order_number',
        'subject',
        'description',
        'archived_at',
    ];
}
