<?php
namespace App\Http\Controllers;
use App\Models\Consultation;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ConsultationController extends Controller
{
    public function store(Request $request, WhatsAppService $whatsapp)
    {
        $data=$request->validate([
            'name'=>'required|string|max:120','business_name'=>'nullable|string|max:160','phone'=>'required|string|max:40',
            'email'=>'nullable|email|max:160','service_interest'=>'nullable|string|max:160','budget'=>'nullable|string|max:100','message'=>'required|string|max:5000'
        ]);
        $data['status']='new'; $data['source']='website_consultation';
        $lead=Consultation::create($data);
        try {
            $message="Ada konsultasi baru:\n\nNama: {$lead->name}\nBisnis: ".($lead->business_name?:'-')."\nWhatsApp: {$lead->phone}\nEmail: ".($lead->email?:'-')."\nKebutuhan: {$lead->message}";
            $whatsapp->sendMessage($message);
        } catch (\Throwable $e) {
            Log::warning('Lead tersimpan, notifikasi WhatsApp tidak dikirim.', ['lead_id'=>$lead->id,'error'=>$e->getMessage()]);
        }
        return back()->with('success','Konsultasi berhasil dikirim. Tim kami akan menghubungi Anda.');
    }
}
