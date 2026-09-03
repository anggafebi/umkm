<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'service_category_id',
        'name',
        'slug',
        'short_description',
        'description',
        'target_user',
        'problem',
        'solution',
        'thumbnail'
    ];

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class);
    }
}