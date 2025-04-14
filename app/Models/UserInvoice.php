<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInvoice extends Model
{
    use HasFactory;
    //
    protected $fillable = [
        'user_id',
        'invoice_number',
        'amount',
        'status',
        'payment_method',
        'payment_proof',
        'due_date',
        'paid_at',
    ];
    
    //
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //
    public function details()
    {
        return $this->hasMany(UserInvoiceDetails::class, 'invoice_id');
    }

}
