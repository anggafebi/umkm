<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
class TestimonialController extends Controller
{
    public function index(){return view('admin.testimonials.index',['items'=>Testimonial::latest()->paginate(12)]);}
    public function store(Request $r){Testimonial::create($this->data($r));return back()->with('success','Testimoni ditambahkan.');}
    public function update(Request $r, Testimonial $testimonial){$testimonial->update($this->data($r));return back()->with('success','Testimoni diperbarui.');}
    public function destroy(Testimonial $testimonial){$testimonial->delete();return back()->with('success','Testimoni dihapus.');}
    private function data(Request $r){$d=$r->validate(['name'=>'required|string|max:120','company'=>'nullable|string|max:150','message'=>'required|string','rating'=>'required|integer|min:1|max:5','photo'=>'nullable|string|max:255']);$d['status']=$r->boolean('status');return $d;}
}
