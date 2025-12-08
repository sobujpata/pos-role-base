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
    const remark = [
        'popular','new','top','special','trending','regular','featured'
    ];
    protected $fillable = [
        'sku', 'title', 'short_des', 'description', 'price', 'buy_price',
        'discount', 'discount_price', 'image', 'stock', 'min_stock', 'unit',
        'star', 'remark', 'is_active', 'category_id', 'brand_id'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'buy_price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'stock' => 'integer',
        'min_stock' => 'integer',
        'is_active' => 'boolean',
        'star' => 'float'
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }
    public function productDetail(){
        return $this->hasOne(ProductDetail::class);
    }

    public function product_reviews()
{
    return $this->hasMany(ProductReview::class)->orderBy('created_at', 'asc');
}

}
