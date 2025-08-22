<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopBanner extends Model
{
    protected $fillable = ['title', 'short_des', 'discount','image','remarks'];
}
