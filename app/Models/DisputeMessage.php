<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisputeMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'dispute_id',
        'sender_id',
        'sender_type',
        'message',
        'attachments',
        'is_read_by_admin',
        'is_read_by_customer',
    ];

    protected $casts = [
        'attachments' => 'array',
        'is_read_by_admin' => 'boolean',
        'is_read_by_customer' => 'boolean',
    ];

    public function dispute()
    {
        return $this->belongsTo(Dispute::class);
    }

    public function sender()
    {
        // إن sender_id يخص جدول admins أو users حسب sender_type — هنا رابط عام
        return $this->morphTo(null, null, 'sender_id');
    }
}
