<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class PosInvoice extends Model
{
    protected $fillable = [
        'total', 
        'discount', 
        'vat', 
        'payable', 
        'user_id', 
        'is_read',
        'payMethod',
        'custName',
        'notes',
    ];
    function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
