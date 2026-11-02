<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientOrder extends Model
{
    protected $fillable = [
        'order_number', 'user_id', 'product_id', 'product_name', 'order_type',
        'project_name', 'service_type', 'description', 'requested_features',
        'budget', 'client_notes', 'price', 'offer_price', 'offer_details',
        'status', 'offer_responded_at',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'offer_price' => 'decimal:2',
        'offer_responded_at' => 'datetime',
    ];

    public function owner() { return $this->belongsTo(User::class, 'user_id'); }
    public function product() { return $this->belongsTo(Product::class); }
}
