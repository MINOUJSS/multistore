<?php

namespace App\Models\Seller;

use App\Notifications\Users\Sellers\SellerResetPasswordNotification;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Seller extends Authenticatable implements CanResetPasswordContract
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
        return $this->hasOne(SellerPlanSubscription::class);
    }

    public function products()
    {
        return $this->hasMany(SellerProducts::class);
    }

    public function orders()
    {
        return $this->hasMany(SellerOrders::class, 'seller_id');
    }

    // order today
    public function orderToDay()
    {
        return $this->hasMany(SellerOrders::class, 'seller_id')
                    ->whereDate('created_at', '=', now());
    }

    // orders this week
    public function ordersThisWeek()
    {
        return $this->hasMany(SellerOrders::class, 'seller_id')
                    ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    // orders this month
    public function ordersThisMonth()
    {
        return $this->hasMany(SellerOrders::class, 'seller_id')
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year);
    }

    // order confirmed today
    public function orderConfirmedToDay()
    {
        return $this->hasMany(SellerOrders::class, 'seller_id')
                    ->whereDate('updated_at', '=', now())
                    ->where('status', '=', 'processing');
    }

    // orders confirmed this week
    public function ordersConfirmedThisWeek()
    {
        return $this->hasMany(SellerOrders::class, 'seller_id')
                    ->whereBetween('updated_at', [now()->startOfWeek(), now()->endOfWeek()])
                    ->where('status', '=', 'processing');
    }

    // orders confirmed this month
    public function ordersConfirmedThisMonth()
    {
        return $this->hasMany(SellerOrders::class, 'seller_id')
                    ->whereMonth('updated_at', now()->month)
                    ->whereYear('updated_at', now()->year)
                    ->where('status', '=', 'processing');
    }

    // order canceled today
    public function orderCanceledToDay()
    {
        return $this->hasMany(SellerOrders::class, 'seller_id')
                    ->whereDate('updated_at', '=', now())
                    ->where('status', '=', 'canceled');
    }

    // order Canceled this week
    public function ordersCanceledThisWeek()
    {
        return $this->hasMany(SellerOrders::class, 'seller_id')
                    ->whereBetween('updated_at', [now()->startOfWeek(), now()->endOfWeek()])
                    ->where('status', '=', 'canceled');
    }

    // order Canceled this month
    public function ordersCanceledThisMonth()
    {
        return $this->hasMany(SellerOrders::class, 'seller_id')
                    ->whereMonth('updated_at', now()->month)
                    ->whereYear('updated_at', now()->year)
                    ->where('status', '=', 'canceled');
    }

    // order delivered to day
    public function orderDeliveredToDay()
    {
        return $this->hasMany(SellerOrders::class, 'seller_id')
                    ->whereDate('updated_at', '=', now())
                    ->where('status', '=', 'delivered');
    }

    // order delivered this week
    public function ordersDeliveredThisWeek()
    {
        return $this->hasMany(SellerOrders::class, 'seller_id')
                    ->whereBetween('updated_at', [now()->startOfWeek(), now()->endOfWeek()])
                    ->where('status', '=', 'delivered');
    }

    // order delivered this month
    public function ordersDeliveredThisMonth()
    {
        return $this->hasMany(SellerOrders::class, 'seller_id')
                    ->whereMonth('updated_at', now()->month)
                    ->whereYear('updated_at', now()->year)
                    ->where('status', '=', 'delivered');
    }

    // order abandonte order to day
    public function orderAbandonedToDay()
    {
        return $this->hasMany(SellerOrderAbandoned::class, 'seller_id')
                    ->whereDate('created_at', '=', now());
    }

    // order abandoned this week
    public function ordersAbandonedThisWeek()
    {
        return $this->hasMany(SellerOrderAbandoned::class, 'seller_id')
                    ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    // order abandoned this month
    public function ordersAbandonedThisMonth()
    {
        return $this->hasMany(SellerOrderAbandoned::class, 'seller_id')
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year);
    }

    // orderPlan
    public function orderPlan()
    {
        return $this->hasMany(SellerPlanOrder::class, 'seller_id')
                    ->where('status', '=', 'pending');
    }

    // pages
    public function pages()
    {
        return $this->hasMany(SellerPage::class);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new SellerResetPasswordNotification($token));
    }
}
