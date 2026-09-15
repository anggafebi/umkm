<?php
namespace App\Http\Middleware;
use App\Models\PageView;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
class TrackPageView
{
    public function handle(Request $request, Closure $next)
    {
        $response=$next($request);
        try {
            if($request->isMethod('GET') && Schema::hasTable('page_views') && !$request->is('admin/*') && !$request->is('login')) {
                PageView::create(['path'=>'/'.$request->path(),'session_hash'=>hash('sha256',$request->session()->getId()),'referrer'=>substr((string)$request->headers->get('referer'),0,500) ?: null]);
            }
        } catch (\Throwable $e) {}
        return $response;
    }
}
