<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Response;

class PerformanceServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Enable HTTP/2 Server Push
        $this->app->middleware([
            \Illuminate\Http\Middleware\AddLinkHeadersMiddleware::class,
        ]);

        // Add Cache-Control headers
        Response::macro('cache', function ($value) {
            $response = Response::make($value);
            $response->header('Cache-Control', 'public, max-age=31536000');
            return $response;
        });

        // Force HTTPS in production
        if($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
