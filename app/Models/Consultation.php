<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Consultation extends Model
{
    protected $fillable = [
        'name','business_name','phone','email','service_interest','budget','message',
        'status','admin_notes','last_contacted_at','source',
        'user_id','product_id','product_name_snapshot','reference_code','submission_token'
    ];
    public function owner() { return $this->belongsTo(User::class, 'user_id'); }
    public function product() { return $this->belongsTo(Product::class); }
    public function replies() { return $this->hasMany(ConsultationMessage::class); }
    public function statusLogs() { return $this->hasMany(ConsultationStatusLog::class); }
    public function getReferenceAttribute(): string { return $this->reference_code ?: 'KSL-'.str_pad((string) $this->id, 5, '0', STR_PAD_LEFT); }
    public function getProductLabelAttribute(): string { return $this->product_name_snapshot ?: 'Umum / belum pilih produk'; }
    protected $casts = ['last_contacted_at' => 'datetime'];
}
