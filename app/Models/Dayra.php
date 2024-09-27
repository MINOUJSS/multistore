<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dayra extends Model
{
    use HasFactory;
    //
    protected $fillable=[
        'ar_name','en_name','zip_code',
    ];
    public function baladias()
    {
        return $this->HasMany('App\Models\Baladia');
    }
    //
    public function Wilaya()
    {
        return $this->belongsTo('App\Models\Wilaya');
    }
}
