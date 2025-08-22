<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuBanner extends Model
{
    protected $fillable = [
        'title',
        'image',
        'link',
        'status',
        'order',
    ];

    /**
     * Get the URL of the banner image.
     *
     * @return string
     */
    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image);
    }   
}
