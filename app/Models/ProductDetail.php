<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductDetail extends Model
{
    Protected $fillable = [
        'img1',
        'img2',
        'img3',
        'img4',
        'color',
        'size',
        'des',
        'product_id',
    ];
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
