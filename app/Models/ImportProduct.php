<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImportProduct extends Model
{
    protected $fillable = [
        'product_id',
        'import_price',
        'sale_price',
        'quantity',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
