<?php
namespace App\Http\Controllers;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
class NewsletterController extends Controller
{
    public function store(Request $request){$data=$request->validate(['email'=>'required|email|max:180']);NewsletterSubscriber::updateOrCreate(['email'=>$data['email']],['status'=>'active','source'=>'footer']);return back()->with('newsletter_success','Email berhasil didaftarkan.');}
}
