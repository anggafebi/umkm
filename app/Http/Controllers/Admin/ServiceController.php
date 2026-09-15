<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class ServiceController extends Controller
{
    public function index(){return view('admin.services.index',['services'=>Service::latest()->paginate(12)]);}
    public function store(Request $r){$d=$this->data($r);$d['slug']=$this->uniqueSlug($d['slug'] ?: Str::slug($d['name']));Service::create($d);return back()->with('success','Layanan ditambahkan.');}
    public function update(Request $r, Service $service){$d=$this->data($r,$service->id);$d['slug']=$this->uniqueSlug($d['slug'] ?: Str::slug($d['name']), $service->id);$service->update($d);return back()->with('success','Layanan diperbarui.');}
    public function destroy(Service $service){$service->delete();return back()->with('success','Layanan dihapus.');}
    private function data(Request $r,?int $id=null){return $r->validate(['name'=>'required|string|max:160','slug'=>'nullable|string|max:180|unique:services,slug,'.($id??'NULL'),'short_description'=>'nullable|string|max:500','description'=>'nullable|string','target_user'=>'nullable|string','problem'=>'nullable|string','solution'=>'nullable|string','features'=>'nullable|string','image'=>'nullable|string|max:255']);}

    private function uniqueSlug(string $base, ?int $ignoreId=null): string
    {
        $base = Str::slug($base) ?: 'item'; $slug=$base; $i=2;
        while (Service::where('slug',$slug)->when($ignoreId,fn($q)=>$q->where('id','!=',$ignoreId))->exists()) $slug=$base.'-'.$i++;
        return $slug;
    }
}
