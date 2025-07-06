<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::post('/add-to-cart', [CartController::class, 'addItem'])->name('add-to-cart');
Route::post('/remove-from-cart', [CartController::class, 'removeItem'])->name('remove-from-cart');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/save-order', [CheckoutController::class, 'saveOrder'])->name('checkout.save-order');
Route::get('/checkout/success/{orderId}/{hash}', [CheckoutController::class, 'success'])->name('checkout.success');
