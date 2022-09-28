<?php

use Illuminate\Support\Facades\Route;
//workshop
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TypeProductController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\MechanicController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CarBrandController;
use App\Http\Controllers\CarTypeController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\WorkorderController;
use App\Http\Controllers\ExpenseSpendingController;
use App\Http\Controllers\ExpenseInvestmentController;
use App\Http\Controllers\ReportController;
//workshop
//store
use App\Http\Controllers\StoreTypeProductController;
use App\Http\Controllers\StoreProductController;
use App\Http\Controllers\StoreStockController;
use App\Http\Controllers\StoreChasierController;
use App\Http\Controllers\StoreCustomerController;
use App\Http\Controllers\StoreSpendingController;
use App\Http\Controllers\StoreInvestmentController;
use App\Http\Controllers\ReportStoreController;

Route::resource('dashboard', DashboardController::class)->middleware(['auth']);
Route::resource('/', DashboardController::class)->middleware(['auth']);
Route::resource('setting', SettingController::class)->middleware(['auth']);

//workshop
Route::resource('type-product', TypeProductController::class)->middleware(['auth']);
Route::resource('product', ProductController::class)->middleware(['auth']);
Route::resource('service', ServiceController::class)->middleware(['auth']);
Route::resource('mechanic', MechanicController::class)->middleware(['auth']);
Route::resource('customer', CustomerController::class)->middleware(['auth']);
Route::resource('car', CarController::class)->middleware(['auth']);
Route::resource('car-brand', CarBrandController::class)->middleware(['auth']);
Route::resource('car-type', CarTypeController::class)->middleware(['auth']);
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
    Route::post('order/price', 'price')->name('order.price')->middleware(['auth']);
});
Route::resource('order', OrderController::class)->middleware(['auth']);
Route::controller(InvoiceController::class)->group(function () {
    Route::post('invoice/payInvoice', 'payInvoice')->name('payInvoice')->middleware(['auth']);
    Route::post('invoice/workOrder', 'workOrder')->name('workOrder')->middleware(['auth']);
    Route::post('invoice/voidInvoice', 'voidInvoice')->name('voidInvoice')->middleware(['auth']);
    Route::get('invoice/print/{id}', 'print')->name('invoice.print')->middleware(['auth']);
});
Route::resource('invoice', InvoiceController::class)->middleware(['auth']);
Route::controller(WorkorderController::class)->group(function () {
    Route::get('workorder/detailWork', 'detailWork')->name('detailWork')->middleware(['auth']);
    Route::post('workorder/deleteWork', 'deleteWork')->name('deleteWork')->middleware(['auth']);
    Route::get('workorder/getStock', 'getStock')->name('getStock')->middleware(['auth']);
    Route::post('workorder/addWork', 'addWork')->name('addWork')->middleware(['auth']);
});
Route::resource('workorder', WorkorderController::class)->middleware(['auth']);
Route::resource('expense-spending', ExpenseSpendingController::class)->middleware(['auth']);
Route::resource('expense-investment', ExpenseInvestmentController::class)->middleware(['auth']);

Route::controller(ReportController::class)->group(function () {
    Route::get('report/current-stock', 'currentStock')->name('currentStock')->middleware(['auth']);
    Route::get('report/current-stock-view', 'currentStockView')->name('currentStockView')->middleware(['auth']);
    Route::get('report/history-stock', 'historyStock')->name('historyStock')->middleware(['auth']);
    Route::get('report/history-stock-view', 'historyStockView')->name('historyStockView')->middleware(['auth']);
    Route::get('report/revenue', 'revenue')->name('revenue')->middleware(['auth']);
    Route::get('report/revenue-view', 'revenueView')->name('revenueView')->middleware(['auth']);
    Route::get('report/expense', 'expense')->name('expense')->middleware(['auth']);
    Route::get('report/expense-view', 'expenseView')->name('expenseView')->middleware(['auth']);
});
//workshop
//store
Route::resource('store-type-product', StoreTypeProductController::class)->middleware(['auth']);

Route::controller(StoreProductController::class)->group(function () {
    Route::get('store-product/print/{id}', 'print')->name('store-product.print')->middleware(['auth']);
});
Route::resource('store-product', StoreProductController::class)->middleware(['auth']);

Route::controller(StoreStockController::class)->group(function () {
    Route::get('store-stock/detail', 'detail')->name('store-stock.detail')->middleware(['auth']);
    Route::post('store-stock/price', 'price')->name('store-stock.price')->middleware(['auth']);
    Route::post('store-stock/add', 'add')->name('store-stock.add')->middleware(['auth']);
    Route::post('store-stock/delete', 'delete')->name('store-stock.delete')->middleware(['auth']);
    //Route::get('stock/{id}', 'show')->name('stock.show')->middleware(['auth']);
});
Route::resource('store-stock', StoreStockController::class)->middleware(['auth']);

Route::controller(StoreChasierController::class)->group(function () {
    Route::get('store-chasier/detail', 'detail')->name('store-chasier.detail')->middleware(['auth']);
    Route::post('store-chasier/add', 'add')->name('store-chasier.add')->middleware(['auth']);
    Route::post('store-chasier/barcode', 'barcode')->name('store-chasier.barcode')->middleware(['auth']);
    Route::post('store-chasier/save', 'save')->name('store-chasier.save')->middleware(['auth']);
    Route::post('store-chasier/price', 'price')->name('store-chasier.price')->middleware(['auth']);
    Route::get('store-chasier/customer', 'customer')->name('store-chasier.customer')->middleware(['auth']);
    Route::get('store-chasier/print/{id}', 'print')->name('store-chasier.print')->middleware(['auth']);
    Route::post('store-chasier/payInvoice', 'payStore')->name('payStore')->middleware(['auth']);
    Route::post('store-chasier/deleteProduct', 'deleteProduct')->name('store-chasier.deleteProduct')->middleware(['auth']);
});
Route::resource('store-chasier', StoreChasierController::class)->middleware(['auth']);

Route::controller(StoreCustomerController::class)->group(function () {
    Route::post('store-customer/store', 'store')->name('store-customer.store')->middleware(['auth']);
});
Route::resource('store-customer', StoreCustomerController::class)->middleware(['auth']);

Route::resource('store-spending', StoreSpendingController::class)->middleware(['auth']);
Route::resource('store-investment', StoreInvestmentController::class)->middleware(['auth']);

Route::controller(ReportStoreController::class)->group(function () {
    Route::get('report-store/current-stock', 'currentStock')->name('currentStockStore')->middleware(['auth']);
    Route::get('report-store/current-stock-view', 'currentStockView')->name('currentStockViewStore')->middleware(['auth']);
    Route::get('report-store/history-stock', 'historyStock')->name('historyStockStore')->middleware(['auth']);
    Route::get('report-store/history-stock-view', 'historyStockView')->name('historyStockViewStore')->middleware(['auth']);
    Route::get('report-store/revenue', 'revenue')->name('revenueStore')->middleware(['auth']);
    Route::get('report-store/revenue-view', 'revenueView')->name('revenueViewStore')->middleware(['auth']);
    Route::get('report-store/expense', 'expense')->name('expenseStore')->middleware(['auth']);
    Route::get('report-store/expense-view', 'expenseView')->name('expenseViewStore')->middleware(['auth']);
});
//store

Route::get('generate', function () {
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    echo 'ok';
});
