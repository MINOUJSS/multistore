<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersPaymentsProofsRefused extends Model
{
    use HasFactory;
        protected $fillable = [
        'order_number',
        'user_id',
        'proof_path',
        'refuse_reason',
        'admin_notes',
        'status',
        'admin_id',
        'refused_at',
    ];

    protected $dates = ['refused_at'];

    // 🔹 العلاقة مع المستخدم (المورد)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // 🔹 العلاقة مع الأدمن
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
    //messages
    public function messages()
    {
        return $this->hasMany(ProofsRefusedMessage::class, 'payment_proof_id');
    }
}
