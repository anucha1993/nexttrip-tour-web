<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OptimizeAssets
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (!$this->shouldOptimize($request, $response)) {
            return $response;
        }

        $content = $response->getContent();

        // Minify HTML
        $content = $this->minifyHtml($content);

        // Remove unnecessary whitespace
        $content = preg_replace('/(\s+)/s', ' ', $content);
        
        // Remove HTML comments except IE conditionals
        $content = preg_replace('/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/s', '', $content);

        $response->setContent($content);

        // Set performance headers
        $response->header('Cache-Control', 'public, max-age=31536000');
        $response->header('X-Content-Type-Options', 'nosniff');

        return $response;
    }

    protected function shouldOptimize($request, $response)
    {
        return !$request->is('admin/*') && 
               $response->headers->get('Content-Type') === 'text/html; charset=UTF-8';
    }

    protected function minifyHtml($content)
    {
        $search = [
            '/\>[^\S ]+/s',     // strip whitespaces after tags
            '/[^\S ]+\</s',     // strip whitespaces before tags
            '/(\s)+/s',         // shorten multiple whitespace sequences
            '/<!--(.|\s)*?-->/' // Remove HTML comments
        ];

        $replace = [
            '>',
            '<',
            '\\1',
            ''
        ];

        return preg_replace($search, $replace, $content);
    }
}
