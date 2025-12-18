<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProofsRefusedMessage extends Model
{
    use HasFactory;
    /**
     * الجدول المرتبط بالموديل.
     *
     * @var string
     */
    protected $table = 'proofs_refused_messages';

    /**
     * الحقول القابلة للتعبئة.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'payment_proof_id',
        'sender_type',
        'sender_id',
        'message',
        'attachments',
        'is_read_by_admin',
        'is_read_by_seller',
    ];

    /**
     * الحقول التي يتم تحويلها تلقائيًا.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'attachments' => 'array',
        'is_read_by_admin' => 'boolean',
        'is_read_by_seller' => 'boolean',
    ];

    /**
     * العلاقة مع جدول إثباتات الدفع المرفوضة.
     */
    public function paymentProof()
    {
        return $this->belongsTo(UsersPaymentsProofsRefused::class, 'payment_proof_id');
    }

    /**
     * العلاقة مع المرسل (قد يكون أدمن أو بائع).
     */
    public function sender()
    {
        return $this->morphTo(null, 'sender_type', 'sender_id');
    }

    /**
     * سكوب لتصفية الرسائل غير المقروءة للأدمن.
     */
    public function scopeUnreadByAdmin($query)
    {
        return $query->where('is_read_by_admin', false);
    }

    /**
     * سكوب لتصفية الرسائل غير المقروءة للبائع.
     */
    public function scopeUnreadBySeller($query)
    {
        return $query->where('is_read_by_seller', false);
    }
}
