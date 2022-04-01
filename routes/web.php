<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TypeProductController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\MechanicController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\WorkorderController;

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
    //Route::get('stock/{id}', 'show')->name('stock.show')->middleware(['auth']);
});
Route::resource('stock', StockController::class)->middleware(['auth']);

Route::controller(OrderController::class)->group(function () {
    Route::get('order/detailOrder', 'detailOrder')->name('detailOrder')->middleware(['auth']);
    Route::post('order/addOrder', 'addOrder')->name('addOrder')->middleware(['auth']);
    Route::post('order/deleteOrder', 'deleteOrder')->name('deleteOrder')->middleware(['auth']);
    Route::post('order/addInvoice', 'addInvoice')->name('addInvoice')->middleware(['auth']);
});
Route::resource('order', OrderController::class)->middleware(['auth']);

Route::controller(InvoiceController::class)->group(function () {
    Route::post('invoice/payInvoice', 'payInvoice')->name('payInvoice')->middleware(['auth']);
    Route::get('invoice/print/{id}', 'print')->name('invoice.print')->middleware(['auth']);
});
Route::resource('invoice', InvoiceController::class)->middleware(['auth']);

Route::resource('workorder', WorkorderController::class)->middleware(['auth']);

Route::get('generate', function () {
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    echo 'ok';
});
