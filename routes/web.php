<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SelectItemsController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::post('/select-item', [SelectItemsController::class, 'addItem'])->name('select-item');
Route::get('/get-selected-items', [SelectItemsController::class, 'getSelectedItems'])->name('get-selected-items');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/save-order', [CheckoutController::class, 'saveOrder'])->name('checkout.save-order');
Route::get('/checkout/success/{orderId}/{hash}', [CheckoutController::class, 'success'])->name('checkout.success');
