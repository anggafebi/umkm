<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
class TestimonialController extends Controller {
public function index(){ return view('admin.testimonials.index',['items'=>Testimonial::latest()->get()]); }
public function store(Request $r){ Testimonial::create($r->all()); return back(); }
public function destroy(Testimonial $item){ $item->delete(); return back(); }
}
