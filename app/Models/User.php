<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'tenant_id',
        'email',
        'password',
        'phone',
        'type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get tenant information.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get user balance.
     */
    public function balance()
    {
        return $this->hasOne(UserBalance::class, 'user_id');
    }

    /**
     * Get user transactions.
     */
    public function transactions()
    {
        return $this->hasMany(BalanceTransaction::class);
    }

    public function store_settings()
    {
        $this->hasMany(UserStoreSetting::class, 'user_id');
    }

    public function dashboard_settings()
    {
        $this->hasMany(UserDashboardSetting::class);
    }

    public function sliders()
    {
        $this->hasMany(UserSlider::class);
    }

    public function storeCategories()
    {
        return $this->hasMany(UserStoreCategory::class);
    }

    public function invoices()
    {
        return $this->hasMany(UserInvoice::class);
    }

    // free orders
    public function freeOrder()
    {
        return $this->hasOne(UserFreeOrder::class, 'user_id');
    }

    // facebook_pixle
    public function facebook_pixle()
    {
        return $this->hasMany(UserApps::class, 'user_id')
                    ->where('app_name', '=', 'facebook_pixel');
    }

    // telegratm_chat_id
    public function telegrame_chat_id()
    {
        return $this->hasMany(UserApps::class, 'user_id')
                    ->where('app_name', '=', 'telegram_notifications');
    }

    // google_analytics
    public function google_analytics()
    {
        return $this->hasMany(UserApps::class, 'user_id')
                    ->where('app_name', '=', 'google_analytics');
    }

    // tiktok_pixle
    public function tiktok_pixle()
    {
        return $this->hasMany(UserApps::class, 'user_id')
                    ->where('app_name', '=', 'tiktok_pixel');
    }

    // google_sheet
    public function google_sheet()
    {
        return $this->hasMany(UserApps::class, 'user_id')
                    ->where('app_name', '=', 'google_sheets');
    }

    // clarity
    public function clarity()
    {
        return $this->hasMany(UserApps::class, 'user_id')
                    ->where('app_name', '=', 'clarity');
    }

    // store copyright name
    public function storeCopyright()
    {
        return $this->hasMany(UserStoreSetting::class, 'user_id')
                    ->where('key', '=', 'copyright');
    }

    public function chargilySettings()
    {
        return $this->hasOne(ChargilySettingForTenants::class, 'user_id');
    }

    public function bank_settings()
    {
        return $this->hasOne(UserBanckAccounts::class, 'user_id');
    }

    public function benefit_section()
    {
        return $this->hasOne(UserBenefitSection::class, 'user_id');
    }

    public function employees()
    {
        return $this->hasMany(UserEmployee::class, 'user_id');
    }

    public function shipping_companies()
    {
        return $this->hasMany(ShippingCompaines::class, 'user_id');
    }
}
