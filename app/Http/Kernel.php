<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        // ใน Laravel 10+ แนะนำใช้ของ core:
        // \Illuminate\Http\Middleware\HandleCors::class,
        \Fruitcake\Cors\HandleCors::class, // ถ้าโปรเจ็กต์ยังใช้ fruitcake อยู่ก็ได้
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    protected $middlewareGroups = [
        // กลุ่มเดิม: ใช้กับหน้าที่ต้องมี session/login/form
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        // ✅ กลุ่มใหม่: สำหรับหน้า PUBLIC “ไม่ใช้ session/CSRF” → แคชได้
        'public-web' => [
            \App\Http\Middleware\TrustProxies::class,
            // \Illuminate\Http\Middleware\HandleCors::class, // หรือ Fruitcake ตามที่ใช้
            \Fruitcake\Cors\HandleCors::class,
            \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
            \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
            \App\Http\Middleware\TrimStrings::class,
            \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            // ตั้ง header ให้แคชได้
            \App\Http\Middleware\PublicCacheHeaders::class,
            // Optimize assets
            \App\Http\Middleware\OptimizeAssets::class,
            // Optimize images
            \App\Http\Middleware\OptimizeImages::class,
            // ใช้ response cache ของ Spatie
            \Spatie\ResponseCache\Middlewares\CacheResponse::class,
        ],

        'api' => [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'Webpanel' => \App\Http\Middleware\Webpanel::class,
        'Functions' => \App\Http\Middleware\Functions::class,
        'Member' => \App\Http\Middleware\Member::class,
        'Language' => \App\Http\Middleware\Language::class,

        // เผื่ออยากเรียกใช้แบบเป็นตัวๆ
        'responsecache' => \Spatie\ResponseCache\Middlewares\CacheResponse::class,
    ];
}
