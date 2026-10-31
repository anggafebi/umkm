<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class ProductController extends Controller
{
    public function index(){return view('admin.products.index',['products'=>Product::latest()->paginate(12)]);}
    public function store(Request $r){$d=$this->data($r);$d['price_is_starting_at']=$r->boolean('price_is_starting_at');$d['slug']=$this->uniqueSlug($d['slug'] ?: Str::slug($d['name']));Product::create($d);return back()->with('success','Produk ditambahkan.');}
    public function update(Request $r, Product $product){$d=$this->data($r,$product->id);$d['price_is_starting_at']=$r->boolean('price_is_starting_at');$d['slug']=$this->uniqueSlug($d['slug'] ?: Str::slug($d['name']), $product->id);$product->update($d);return back()->with('success','Produk diperbarui.');}
    public function destroy(Product $product){$product->delete();return back()->with('success','Produk dihapus.');}
    private function data(Request $r,?int $id=null){return $r->validate(['name'=>'required|string|max:160','slug'=>'nullable|string|max:180|unique:products,slug,'.($id??'NULL'),'description'=>'nullable|string','price'=>'nullable|numeric|min:0','image'=>'nullable|string|max:255','price_is_starting_at'=>'nullable|boolean']);}

    private function uniqueSlug(string $base, ?int $ignoreId=null): string
    {
        $base = Str::slug($base) ?: 'item'; $slug=$base; $i=2;
        while (Product::where('slug',$slug)->when($ignoreId,fn($q)=>$q->where('id','!=',$ignoreId))->exists()) $slug=$base.'-'.$i++;
        return $slug;
    }
}
