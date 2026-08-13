<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    protected $fillable = ["categoryName", "categoryImg", "user_id"];

    
    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
