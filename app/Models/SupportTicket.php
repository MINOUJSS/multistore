<?php

namespace App\Models;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_number',
        'user_id',
        'user_type',
        'user_name',
        'user_email',
        'user_phone',
        'category',
        'priority',
        'subject',
        'message',
        'attachments',
        'status',
        'assigned_admin_id',
        'last_reply_at',
        'resolved_at',
    ];

    protected $casts = [
        'attachments' => 'array',
        'last_reply_at' => 'datetime',
        'resolved_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assignedAdmin()
    {
        return $this->belongsTo(Admin::class, 'assigned_admin_id');
    }

    public function replies()
    {
        return $this->hasMany(SupportTicketReply::class, 'ticket_id')->orderBy('created_at', 'asc');
    }

    public function latestReply()
    {
        return $this->hasOne(SupportTicketReply::class, 'ticket_id')->latestOfMany();
    }
}
