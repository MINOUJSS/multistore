<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dispute extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_number',
        'customer_name',
        'customer_email',
        'customer_phone',
        'seller_id',
        'subject',
        'description',
        'attachments',
        'status',
        'admin_notes',
        'resolved_at',
        'access_token',
    ];

    protected $casts = [
        'attachments' => 'array',
        'resolved_at' => 'datetime',
    ];

    public function messages()
    {
        return $this->hasMany(DisputeMessage::class)->orderBy('created_at', 'asc');
    }
}
