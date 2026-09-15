<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\PricingPackage;
use Illuminate\Http\Request;
class PricingPackageController extends Controller
{
    public function index(){return view('admin.pricing.index',['items'=>PricingPackage::latest()->paginate(12)]);}
    public function store(Request $r){PricingPackage::create($this->data($r));return back()->with('success','Paket ditambahkan.');}
    public function update(Request $r, PricingPackage $pricing){$pricing->update($this->data($r));return back()->with('success','Paket diperbarui.');}
    public function destroy(PricingPackage $pricing){$pricing->delete();return back()->with('success','Paket dihapus.');}
    private function data(Request $r){$d=$r->validate(['name'=>'required|string|max:120','price'=>'required|string|max:100','features'=>'nullable|string']);$d['highlight']=$r->boolean('highlight');$d['status']=$r->boolean('status');return $d;}
}
