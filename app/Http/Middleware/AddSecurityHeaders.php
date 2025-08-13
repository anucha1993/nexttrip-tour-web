<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AddSecurityHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Content Security Policy
        $response->header(
            'Content-Security-Policy',
            "default-src 'self' https: data: 'unsafe-inline' 'unsafe-eval';" .
            "img-src 'self' https: data: blob:;" .
            "font-src 'self' https: data:;" .
            "frame-src 'self' https:;" .
            "connect-src 'self' https:;"
        );

        // Performance & Security Headers
        $response->header('X-Content-Type-Options', 'nosniff');
        $response->header('X-XSS-Protection', '1; mode=block');
        $response->header('X-Frame-Options', 'SAMEORIGIN');
        $response->header('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->header('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');

        // Enable compression if supported
        if (str_contains($request->header('Accept-Encoding'), 'gzip')) {
            $response->header('Content-Encoding', 'gzip');
        }

        // Cache Control
        if ($this->isStaticAsset($request)) {
            $response->header('Cache-Control', 'public, max-age=31536000, immutable');
            $response->header('Vary', 'Accept-Encoding');
        } else {
            $response->header('Cache-Control', 'no-cache, private');
        }

        return $response;
    }

    protected function isStaticAsset(Request $request)
    {
        $path = $request->path();
        return preg_match('/\.(css|js|jpg|jpeg|png|gif|ico|woff2?|ttf|eot|svg)$/i', $path);
    }
}
