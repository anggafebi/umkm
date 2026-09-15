<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Consultation extends Model
{
    protected $fillable = [
        'name','business_name','phone','email','service_interest','budget','message',
        'status','admin_notes','last_contacted_at','source'
    ];
    protected $casts = ['last_contacted_at' => 'datetime'];
}
