<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInvoiceDetails extends Model
{
    use HasFactory;
    //
    protected $fillable = [
        'invoice_id',
        'item_name',
        'description',
        'quantity',
        'unit_price',
        'total',
    ];
    
    //
    public function invoice()
    {
        return $this->belongsTo(UserInvoice::class, 'invoice_id');
    }

}
