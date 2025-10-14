<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBanckAccounts extends Model
{
    use HasFactory;
    //
    protected $filable = [
        'id',
        'user_id',
        'name',
        'bank_name',
        'account_number',
    ];
}
