<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class PosInvoiceProduct extends Model
{
     protected $fillable = [
        'invoice_id',
        'product_id',
        'user_id',
        'qty',
        'rate',
        'sale_price',
        'total_buy_price',
    ];

    function product(){
        return $this->belongsTo(Product::class);
    }
}
