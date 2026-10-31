<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class SystemNotification extends Model
{
    protected $fillable = ['user_id', 'consultation_id', 'type', 'title', 'body', 'read_at'];
    protected $casts = ['read_at' => 'datetime'];
    public function consultation() { return $this->belongsTo(Consultation::class); }
}
