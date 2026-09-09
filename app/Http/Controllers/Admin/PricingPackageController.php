<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\PricingPackage;
use Illuminate\Http\Request;
class PricingPackageController extends Controller {
public function index(){ return view('admin.pricingPackages.index',['items'=>PricingPackage::latest()->get()]); }
public function store(Request $r){ PricingPackage::create($r->all()); return back(); }
public function destroy(PricingPackage $item){ $item->delete(); return back(); }
}
