<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PublicCacheHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Don't cache if:
        // - request is for admin panel
        // - user is logged in
        // - request is POST/PUT/DELETE
        // - response is an error
        if ($this->shouldNotCache($request, $response)) {
            return $response->header('Cache-Control', 'no-store, private');
        }

        // Cache for 1 week, allow CDN/proxy caching
        return $response->header('Cache-Control', 'public, max-age=604800, s-maxage=604800');
    }

    protected function shouldNotCache($request, $response)
    {
        return $request->is('admin/*') ||
               $request->user() ||
               !$request->isMethod('GET') ||
               $response->getStatusCode() !== 200;
    }
}
