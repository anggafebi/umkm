<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        return view('admin.blog.index', [
            'posts'=>BlogPost::with('category')->latest()->paginate(12),
            'categories'=>BlogCategory::orderBy('name')->get()
        ]);
    }
    public function store(Request $request)
    {
        $data=$this->validated($request);
        $data['slug']=$this->uniqueSlug($data['slug'] ?: Str::slug($data['title']));
        $data['published_at']=$data['status']==='published' ? ($data['published_at'] ?? now()) : null;
        $post=BlogPost::create($data);
        $this->log($request,'blog.created',"Artikel {$post->title} dibuat");
        return back()->with('success','Artikel berhasil dibuat.');
    }
    public function update(Request $request, BlogPost $post)
    {
        $data=$this->validated($request,$post->id);
        $data['slug']=$this->uniqueSlug($data['slug'] ?: Str::slug($data['title']), $post->id);
        $data['published_at']=$data['status']==='published' ? ($data['published_at'] ?? $post->published_at ?? now()) : null;
        $post->update($data); $this->log($request,'blog.updated',"Artikel {$post->title} diperbarui");
        return back()->with('success','Artikel berhasil diperbarui.');
    }
    public function destroy(Request $request, BlogPost $post)
    {
        $title=$post->title; $post->delete(); $this->log($request,'blog.deleted',"Artikel {$title} dihapus");
        return back()->with('success','Artikel dihapus.');
    }
    public function storeCategory(Request $request)
    {
        $data=$request->validate(['name'=>'required|string|max:100']);
        BlogCategory::firstOrCreate(['slug'=>Str::slug($data['name'])],['name'=>$data['name']]);
        return back()->with('success','Kategori tersimpan.');
    }
    private function validated(Request $r, ?int $id=null): array
    {
        return $r->validate([
            'blog_category_id'=>'nullable|exists:blog_categories,id','title'=>'required|string|max:180',
            'slug'=>'nullable|string|max:190|unique:blog_posts,slug,'.($id ?? 'NULL'),
            'excerpt'=>'nullable|string|max:500','content'=>'nullable|string','image'=>'nullable|string|max:255',
            'status'=>'required|in:draft,published','meta_title'=>'nullable|string|max:180','meta_description'=>'nullable|string|max:300',
            'published_at'=>'nullable|date'
        ]);
    }
    private function log(Request $r,string $action,string $description): void
    { ActivityLog::create(['user_id'=>auth()->id(),'action'=>$action,'description'=>$description,'ip_address'=>$r->ip()]); }

    private function uniqueSlug(string $base, ?int $ignoreId=null): string
    {
        $base=Str::slug($base) ?: 'artikel'; $slug=$base; $i=2;
        while(BlogPost::where('slug',$slug)->when($ignoreId,fn($q)=>$q->where('id','!=',$ignoreId))->exists()) $slug=$base.'-'.$i++;
        return $slug;
    }
}
