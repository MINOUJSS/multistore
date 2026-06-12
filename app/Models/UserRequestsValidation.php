<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRequestsValidation extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'request_number',
        'type',
        'status',
        'reviewed_at',
        'approval_notes',
        'reject_reason',
        'admin_id',
        'ip_address',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    /**
     * صاحب الطلب.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * المشرف الذي راجع الطلب.
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
