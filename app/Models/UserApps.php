<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserApps extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'app_name', 'data','status',];
}
