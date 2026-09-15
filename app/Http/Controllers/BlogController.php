<?php
namespace App\Http\Controllers;
use App\Models\BlogPost;

class BlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::with('category')->where('status','published')->whereNotNull('published_at')->where('published_at','<=',now())->latest('published_at')->paginate(9);
        return view('blog.index', compact('posts'));
    }

    public function show(string $slug)
    {
        $post = BlogPost::with('category')->where('slug',$slug)->where('status','published')->whereNotNull('published_at')->where('published_at','<=',now())->firstOrFail();
        $related = BlogPost::where('status','published')->whereNotNull('published_at')->where('published_at','<=',now())->where('id','!=',$post->id)
            ->when($post->blog_category_id, fn($q)=>$q->where('blog_category_id',$post->blog_category_id))
            ->latest('published_at')->take(3)->get();
        return view('blog.show', compact('post','related'));
    }
}
