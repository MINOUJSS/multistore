<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTicketReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'sender_type',
        'sender_id',
        'sender_name',
        'message',
        'attachments',
        'is_read_by_user',
        'is_read_by_admin',
    ];

    protected $casts = [
        'attachments' => 'array',
        'is_read_by_user' => 'boolean',
        'is_read_by_admin' => 'boolean',
    ];

    public function ticket()
    {
        return $this->belongsTo(SupportTicket::class, 'ticket_id');
    }
}
