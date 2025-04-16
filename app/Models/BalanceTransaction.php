<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BalanceTransaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'transaction_type',
        'amount',
        'description',
        'invoiced',
        'payment_method',
        'payment_proof',
        'status',
    ];
    /**
     * Get user information.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    } 

}
