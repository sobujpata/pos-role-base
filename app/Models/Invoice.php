<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{


    protected $fillable = [
        'subtotal',
        'shipping',
        'total',
        'name',
        'phone',
        'address',
        'status',
        'payment_method',
    ];


}
