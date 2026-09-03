<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    protected $fillable = [
        'name',
        'business_name',
        'phone',
        'email',
        'service_interest',
        'budget',
        'message',
        'status'
    ];
}