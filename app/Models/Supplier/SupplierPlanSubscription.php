<?php

namespace App\Models\Supplier;

use App\Models\FinancialLedger;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierPlanSubscription extends Model
{
    use HasFactory;
    protected $fillable = ['supplier_id', 'plan_id', 'duration', 'price', 'discount', 'payment_method', 'payment_status', 'subscription_start_date', 'subscription_end_date', 'status', 'change_subsription'];

    /**
     * Get supplier information.
     */
    public function Supplier(): BelongsTo
    {
        return $this->BelongsTo(Supplier::class);
    }

    public function financialLedgers()
    {
        return $this->morphMany(FinancialLedger::class, 'source');
    }
}
