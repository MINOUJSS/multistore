<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialLedger extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_type',
        'owner_id',
        'source_type',
        'source_id',
        'amount',
        'type',
        'category',
        'currency',
        'note',
    ];

    public function owner()
    {
        return $this->morphTo();
    }

    public function source()
    {
        return $this->morphTo();
    }
}
