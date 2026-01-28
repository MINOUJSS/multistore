<?php

namespace App\Models\Seller;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerPlanSubscription extends Model
{
    use HasFactory;
    protected $fillable = ['seller_id', 'plan_id', 'duration', 'price', 'discount', 'payment_method', 'payment_status', 'subscription_start_date', 'subscription_end_date', 'status', 'change_subsription'];

    /**
     * Get seller information.
     */
    public function Seller(): BelongsTo
    {
        return $this->BelongsTo(Seller::class);
    }
}
