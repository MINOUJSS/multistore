<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wilaya extends Model
{
    use HasFactory;
    //
    protected $fillable = [
        'ar_name','en_name','zip_code',
    ];
    // -------------wilaya relations sheep------
    // dayra relationships
    public function dayras()
    {
        return $this->HasMany('App\Models\Dayra');
    }
}
