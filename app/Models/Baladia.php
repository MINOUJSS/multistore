<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Baladia extends Model
{
    use HasFactory;
    //
    protected $fillable=[
        'ar_name','en_name','zip_code',
    ];
    //
    public function dayra()
    {
        return $this->belongsTo('App\Models\Dayra');
    }
}
