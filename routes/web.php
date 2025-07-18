<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath;
use Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect;

if (!function_exists('localizedView')) {
    function localizedView(string $view): string
    {
        $template = app()->getLocale() === 'ro' ? $view.'-ro' : $view.'-en';

        return view($template);
    }
}

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

        Route::get('/about', fn () => view('about'))->name('about');
        Route::get('/contact', fn () => view('contact'))->name('contact');
        Route::get('/cookie-policy', fn () => localizedView('cookie-policy'))->name('cookie-policy');

//        Route::get('test', function () {
//            $order = \App\Models\Order::where('id', 1)->firstOrFail();
//            $mail = new \App\Mail\NewReservation($order);
//            return $mail->render();
//            Mail::to($order->email)->send(new OrderConfirmation($order));
//        })->name('test');
    }
);
