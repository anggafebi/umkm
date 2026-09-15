<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class PortfolioController extends Controller
{
    public function index(){return view('admin.portfolio.index',['portfolio'=>Portfolio::latest()->paginate(12)]);}
    public function store(Request $r){$d=$this->data($r);$d['slug']=$this->uniqueSlug($d['slug'] ?: Str::slug($d['title']));Portfolio::create($d);return back()->with('success','Portfolio ditambahkan.');}
    public function update(Request $r, Portfolio $portfolio){$d=$this->data($r,$portfolio->id);$d['slug']=$this->uniqueSlug($d['slug'] ?: Str::slug($d['title']), $portfolio->id);$portfolio->update($d);return back()->with('success','Portfolio diperbarui.');}
    public function destroy(Portfolio $portfolio){$portfolio->delete();return back()->with('success','Portfolio dihapus.');}
    private function data(Request $r,?int $id=null){return $r->validate(['title'=>'required|string|max:160','slug'=>'nullable|string|max:180|unique:portfolios,slug,'.($id??'NULL'),'category'=>'nullable|string|max:100','description'=>'nullable|string','features'=>'nullable|string','technology'=>'nullable|string','demo_url'=>'nullable|url','image'=>'nullable|string|max:255']);}

    private function uniqueSlug(string $base, ?int $ignoreId=null): string
    {
        $base = Str::slug($base) ?: 'item'; $slug=$base; $i=2;
        while (Portfolio::where('slug',$slug)->when($ignoreId,fn($q)=>$q->where('id','!=',$ignoreId))->exists()) $slug=$base.'-'.$i++;
        return $slug;
    }
}
