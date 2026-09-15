<?php
namespace App\Http\Controllers;
use App\Models\Consultation;
use Illuminate\Http\Request;
class ContactController extends Controller
{
    public function store(Request $request)
    {
        $data=$request->validate(['name'=>'required|string|max:120','business_name'=>'nullable|string|max:160','phone'=>'required|string|max:40','email'=>'nullable|email|max:160','service_interest'=>'nullable|string|max:160','message'=>'nullable|string|max:5000']);
        $data['status']='new'; $data['source']='contact_form'; Consultation::create($data);
        return back()->with('success','Pesan berhasil dikirim. Kami akan menghubungi Anda secepatnya.');
    }
}
