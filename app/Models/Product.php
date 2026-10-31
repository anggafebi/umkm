<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'image',
        'price_is_starting_at'
    ];

    protected $casts = ['price_is_starting_at' => 'boolean'];

    public function getDisplayPriceAttribute(): string
    {
        return \App\Support\ProductPricing::label($this);
    }
}
