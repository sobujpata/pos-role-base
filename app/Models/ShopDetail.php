<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopDetail extends Model
{
    protected $fillable = [
        'shop_name',
        'shop_email',
        'shop_phone',
        'shop_address',
        'logo_text',
        'logo',
    ];
}
