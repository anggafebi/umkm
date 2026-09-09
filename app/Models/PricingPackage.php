<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class PricingPackage extends Model { protected $fillable=['name', 'price', 'features', 'highlight', 'status']; }
