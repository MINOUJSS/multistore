<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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
        return $this->hasOne(UserBalance::class);
    }
    /**
     * Get user transactions.
     */
    public function transactions()
    {
        return $this->hasMany(BalanceTransaction::class);
    }
    //
    public function store_settings()
    {
        $this->hasMany(UserStoreSetting::class);
    }
    //
    public function dashboard_settings()
    {
        $this->hasMany(UserDashboardSetting::class);
    }
    //
    public function sliders()
    {
        $this->hasMany(UserSlider::class);
    }
    //
    public function storeCategories()
    {
        return $this->hasMany(UserStoreCategory::class);
    }
    //
    public function invoices()
    {
        return $this->hasMany(UserInvoice::class);
    }

}
