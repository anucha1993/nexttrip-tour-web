<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend as Frontend;

Route::get('/error-page', [Frontend\HomeController::class, 'error_page']);

Route::middleware(['Member'])->group(function () {
    Route::get('/member-booking', [Frontend\HomeController::class, 'member']);
});

Route::post('/login',  [Frontend\HomeController::class, 'LogIn'])->middleware('throttle:10,1');
Route::get('/logout',  [Frontend\HomeController::class, 'LogOut'])->middleware('auth');

Route::controller(Frontend\HomeController::class)->group(function () {

    // ✅ กลุ่มหน้า PUBLIC + แคชได้
    // Route::middleware('responsecache')->group(function () {
        Route::get('/', 'index')->name('home');
        Route::get('/about', 'about');
        Route::get('/aroundworld/{id}/{tyid}/{tid}', 'aroundworld')
            ->whereNumber(['id','tyid','tid']);
        Route::get('/around-detail/{id}', 'around_detail')->whereNumber('id');
        Route::get('/clients-company/{id}', 'clients_company')->whereNumber('id');
        Route::get('/clients-detail/{id}', 'clients_detail')->whereNumber('id');
        Route::get('/clients-review/{id}/{cid}', 'clients_review')->whereNumber(['id','cid']);
        Route::get('/clients-govern/{id}', 'clients_govern')->whereNumber('id');
        Route::get('/news/{tyid}/{tid}', 'news')->whereNumber(['tyid','tid']);
        Route::get('/news-detail/{id}', 'news_detail')->whereNumber('id');
        Route::get('/video/{id}/{cid}', 'video')->whereNumber(['id','cid']);
        Route::get('/faq', 'faq');
        Route::get('/contact', 'contact');
        Route::get('/promotiontour/{id}/{tid}', 'promotiontour')->whereNumber(['id','tid']);
        Route::get('/weekend', 'weekend');
        Route::get('/weekend-landing/{id}', 'weekend_landing')->whereNumber('id');
        Route::get('/package/{id}', 'package')->whereNumber('id');
        Route::get('/package-detail/{id}', 'package_detail')->whereNumber('id');
        Route::get('/organizetour', 'organizetour');
        Route::get('/wishlist', 'wishlist');
        Route::get('/tour-summary', 'tour_summary');
        Route::get('/search-price', 'search_price');
        Route::get('/get-data', 'get_data');
        Route::get('/pdf-data', 'file_pdf');
    // });

    // 🔄 คำขอแบบเปลี่ยนข้อมูล/ค้นหาหนัก ๆ ไม่ควรแคช
    Route::post('/search-video', 'search_video')->middleware('throttle:60,1');
    Route::post('/search-weekend', 'search_weekend')->middleware('throttle:60,1');
    Route::post('/search-airline', 'search_airline')->middleware('throttle:60,1');
    Route::post('/promotiontour-filter', 'promotion_filter')->middleware('throttle:60,1');
    Route::post('/data-filter', 'filter_data')->middleware('throttle:60,1');
    Route::post('/record-view/{id}', 'recordPageView')->whereNumber('id')->middleware('throttle:120,1');

    // ✅ รวม route ซ้ำ GET/POST showmore ให้ชัดเจน
    Route::match(['get','post'], '/showmore', 'showmore_promotion');
    Route::match(['get','post'], '/showmore-hot', 'showmore_promotion_hot');

    // Auth/โปรไฟล์
    Route::post('/register', 'register')->middleware('throttle:20,1');
    Route::post('/update-message', 'update_message')->middleware('auth');
    Route::post('/update-member', 'update_member')->middleware('auth');
    Route::post('/forgot-password', 'forgot')->middleware('throttle:5,1');

    // Social callbacks (ห้ามแคช)
    Route::get('auth/facebook', 'redirectToFacebook')->name('auth.facebook');
    Route::get('auth/facebook/callback', 'handleFacebookCallback');
    Route::get('/google', 'redirectToGoogle')->name('google');
    Route::get('/google/callback', 'handleGoogleCallback');
    Route::post('/line-login', 'loginLine')->middleware('throttle:10,1');
    Route::get('/line/callback', 'line_callback');
});

// Fallback กัน 404
Route::fallback(fn() => redirect('/error-page'));
