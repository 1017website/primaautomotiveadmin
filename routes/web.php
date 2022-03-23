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

Route::controller(StockController::class)->group(function () {    
    Route::get('stock/detailItem', 'detailItem')->name('detailItem')->middleware(['auth']);
    Route::post('stock/addItem', 'addItem')->name('addItem')->middleware(['auth']);
    Route::post('stock/deleteItem', 'deleteItem')->name('deleteItem')->middleware(['auth']);
    Route::get('stock/{id}', 'show')->name('stock.show')->middleware(['auth']);
});

Route::resource('stock', StockController::class)->middleware(['auth']);

