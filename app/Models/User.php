<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'is_active'
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function consultations() { return $this->hasMany(Consultation::class); }
    public function notifications() { return $this->hasMany(SystemNotification::class); }

    protected $hidden = [
        'password',
        'remember_token'
    ];
}