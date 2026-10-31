<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ConsultationStatusLog extends Model
{
    public $timestamps = false;
    protected $fillable = ['consultation_id', 'old_status', 'new_status', 'changed_by', 'created_at'];
    protected $casts = ['created_at' => 'datetime'];
    public function changer() { return $this->belongsTo(User::class, 'changed_by'); }
}
