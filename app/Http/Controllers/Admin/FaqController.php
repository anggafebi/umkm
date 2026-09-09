<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
class FaqController extends Controller {
public function index(){ return view('admin.faqs.index',['items'=>Faq::latest()->get()]); }
public function store(Request $r){ Faq::create($r->all()); return back(); }
public function destroy(Faq $item){ $item->delete(); return back(); }
}
