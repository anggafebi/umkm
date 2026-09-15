<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
class FaqController extends Controller
{
    public function index(){return view('admin.faqs.index',['items'=>Faq::orderBy('order')->paginate(15)]);}
    public function store(Request $r){Faq::create($this->data($r));return back()->with('success','FAQ ditambahkan.');}
    public function update(Request $r, Faq $faq){$faq->update($this->data($r));return back()->with('success','FAQ diperbarui.');}
    public function destroy(Faq $faq){$faq->delete();return back()->with('success','FAQ dihapus.');}
    private function data(Request $r){$d=$r->validate(['question'=>'required|string|max:255','answer'=>'required|string','order'=>'nullable|integer|min:0']);$d['order']=$d['order']??0;$d['status']=$r->boolean('status');return $d;}
}
