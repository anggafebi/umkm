<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Support\PublicContentFallbacks;
use Illuminate\Database\QueryException;

class BlogController extends Controller
{
    public function index()
    {
        try {
            $posts = BlogPost::with('category')
                ->where('status', 'published')
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->latest('published_at')
                ->paginate(9);
        } catch (QueryException $exception) {
            $posts = PublicContentFallbacks::paginate(PublicContentFallbacks::posts(), 9);
            $this->logFallback($exception);
        }

        return view('blog.index', compact('posts'));
    }

    public function show(string $slug)
    {
        try {
            $post = BlogPost::with('category')
                ->where('slug', $slug)
                ->where('status', 'published')
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->firstOrFail();

            $related = BlogPost::where('status', 'published')
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->where('id', '!=', $post->id)
                ->when($post->blog_category_id, fn ($query) => $query->where('blog_category_id', $post->blog_category_id))
                ->latest('published_at')
                ->take(3)
                ->get();
        } catch (QueryException $exception) {
            $fallbackPosts = PublicContentFallbacks::posts();
            $post = PublicContentFallbacks::findBySlug($fallbackPosts, $slug);
            abort_unless($post, 404);
            $related = $fallbackPosts->where('id', '!=', $post->id)->take(3)->values();
            $this->logFallback($exception);
        }

        return view('blog.show', compact('post', 'related'));
    }

    private function logFallback(QueryException $exception): void
    {
        logger()->warning('Blog data could not be loaded; static fallback content was used.', [
            'message' => $exception->getMessage(),
        ]);
    }
}
