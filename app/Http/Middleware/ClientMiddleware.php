<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
class ClientMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user()) return redirect()->route('login');
        abort_unless($request->user()->role === 'client' && $request->user()->is_active, 403);
        return $next($request);
    }
}
