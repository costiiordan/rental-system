<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath;
use Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [
            LocaleCookieRedirect::class,
            LaravelLocalizationRedirectFilter::class,
            LaravelLocalizationViewPath::class,
        ]
    ],
    function() {
        Route::get('/', HomeController::class)->name('home');

        Route::post('/add-to-cart', [CartController::class, 'addItem'])->name('add-to-cart');
        Route::post('/remove-from-cart', [CartController::class, 'removeItem'])->name('remove-from-cart');

        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/checkout/save-order', [CheckoutController::class, 'saveOrder'])->name('checkout.save-order');
        Route::get('/checkout/success/{orderId}/{hash}', [CheckoutController::class, 'success'])->name('checkout.success');

        Route::get('/test/', function () {
            dd(public_path());
        });
    }
);
