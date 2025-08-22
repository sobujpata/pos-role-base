<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static where(string $string, mixed $id)
 */
class Product extends Model
{
    protected $fillable = [
        'title',
        'short_des',
        'price',
        'discount',
        'discount_price',
        'image',
        'stock',
        'star',
        'remark',
        'category_id',
        'brand_id',
        'sku',
        'tags',
        'water_resistance',
        'capacity',
        'material',
    ];
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function productDetail(){
        return $this->hasOne(ProductDetail::class);
    }

    public function product_reviews()
{
    return $this->hasMany(ProductReview::class)->orderBy('created_at', 'asc');
}

}
