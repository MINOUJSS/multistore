<?php

namespace App\Models\Supplier;

use App\Models\Tenant;
use App\Notifications\Users\Suppliers\SupplierResetPasswordNotification;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Supplier extends Authenticatable implements CanResetPasswordContract
{
    use Notifiable;
    use CanResetPassword;
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'full_name',
        'last_name',
        'first_name',
        'store_name',
        'email',
        'wilaya',
        'dayra',
        'baladia',
        'address',
        'sex',
        'birth_date',
        'avatar',
        'id_card_image',
        'approval_status',
        'part_of_approved_list',
        'status',
    ];

    /**
     * Get tenant information.
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get plan information.
     */
    public function plan_subscription()
    {
        return $this->hasOne(SupplierPlanSubscription::class);
    }

    public function products()
    {
        return $this->hasMany(SupplierProducts::class);
    }

    public function orders()
    {
        return $this->hasMany(SupplierOrders::class, 'supplier_id');
    }

    // order today
    public function orderToDay()
    {
        return $this->hasMany(SupplierOrders::class, 'supplier_id')
                    ->whereDate('created_at', '=', now());
    }

    // orders this week
    public function ordersThisWeek()
    {
        return $this->hasMany(SupplierOrders::class, 'supplier_id')
                    ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    // orders this month
    public function ordersThisMonth()
    {
        return $this->hasMany(SupplierOrders::class, 'supplier_id')
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year);
    }

    // order confirmed today
    public function orderConfirmedToDay()
    {
        return $this->hasMany(SupplierOrders::class, 'supplier_id')
                    ->whereDate('updated_at', '=', now())
                    ->where('status', '=', 'processing');
    }

    // orders confirmed this week
    public function ordersConfirmedThisWeek()
    {
        return $this->hasMany(SupplierOrders::class, 'supplier_id')
                    ->whereBetween('updated_at', [now()->startOfWeek(), now()->endOfWeek()])
                    ->where('status', '=', 'processing');
    }

    // orders confirmed this month
    public function ordersConfirmedThisMonth()
    {
        return $this->hasMany(SupplierOrders::class, 'supplier_id')
                    ->whereMonth('updated_at', now()->month)
                    ->whereYear('updated_at', now()->year)
                    ->where('status', '=', 'processing');
    }

    // order canceled today
    public function orderCanceledToDay()
    {
        return $this->hasMany(SupplierOrders::class, 'supplier_id')
                    ->whereDate('updated_at', '=', now())
                    ->where('status', '=', 'canceled');
    }

    // order Canceled this week
    public function ordersCanceledThisWeek()
    {
        return $this->hasMany(SupplierOrders::class, 'supplier_id')
                    ->whereBetween('updated_at', [now()->startOfWeek(), now()->endOfWeek()])
                    ->where('status', '=', 'canceled');
    }

    // order Canceled this month
    public function ordersCanceledThisMonth()
    {
        return $this->hasMany(SupplierOrders::class, 'supplier_id')
                    ->whereMonth('updated_at', now()->month)
                    ->whereYear('updated_at', now()->year)
                    ->where('status', '=', 'canceled');
    }

    // order delivered to day
    public function orderDeliveredToDay()
    {
        return $this->hasMany(SupplierOrders::class, 'supplier_id')
                    ->whereDate('updated_at', '=', now())
                    ->where('status', '=', 'delivered');
    }

    // order delivered this week
    public function ordersDeliveredThisWeek()
    {
        return $this->hasMany(SupplierOrders::class, 'supplier_id')
                    ->whereBetween('updated_at', [now()->startOfWeek(), now()->endOfWeek()])
                    ->where('status', '=', 'delivered');
    }

    // order delivered this month
    public function ordersDeliveredThisMonth()
    {
        return $this->hasMany(SupplierOrders::class, 'supplier_id')
                    ->whereMonth('updated_at', now()->month)
                    ->whereYear('updated_at', now()->year)
                    ->where('status', '=', 'delivered');
    }

    // order abandonte order to day
    public function orderAbandonedToDay()
    {
        return $this->hasMany(SupplierOrderAbandoned::class, 'supplier_id')
                    ->whereDate('created_at', '=', now());
    }

    // order abandoned this week
    public function ordersAbandonedThisWeek()
    {
        return $this->hasMany(SupplierOrderAbandoned::class, 'supplier_id')
                    ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    // order abandoned this month
    public function ordersAbandonedThisMonth()
    {
        return $this->hasMany(SupplierOrderAbandoned::class, 'supplier_id')
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year);
    }

    // orderPlan
    public function orderPlan()
    {
        return $this->hasMany(SupplierPlanOrder::class, 'supplier_id')
                    ->where('status', '=', 'pending');
    }

    // pages
    public function pages()
    {
        return $this->hasMany(SupplierPage::class);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new SupplierResetPasswordNotification($token));
    }
}
