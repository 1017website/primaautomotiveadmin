<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TypeProductController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\MechanicController;

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
