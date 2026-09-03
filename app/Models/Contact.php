<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['name','business_name','phone','email','service_interest','message'];
}
