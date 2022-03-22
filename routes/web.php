<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TypeProductController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\MechanicController;
use App\Http\Controllers\StockController;

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth']);

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::resource('type-product', TypeProductController::class)->middleware(['auth']);

Route::resource('product', ProductController::class)->middleware(['auth']);

Route::resource('service', ServiceController::class)->middleware(['auth']);

Route::resource('mechanic', MechanicController::class)->middleware(['auth']);

Route::get('stock/detailItem', 'App\Http\Controllers\StockController@detailItem')->name('detailItem');
Route::post('stock/addItem', 'App\Http\Controllers\StockController@addItem')->name('addItem');
Route::post('stock/deleteItem', 'App\Http\Controllers\StockController@deleteItem')->name('deleteItem');
Route::resource('stock', StockController::class)->middleware(['auth']);





