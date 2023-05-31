<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
//general
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\EstimatorController;
use App\Http\Controllers\EstimatorInternalController;
//general
//workshop
use App\Http\Controllers\Workshop\TypeProductController;
use App\Http\Controllers\Workshop\ProductController;
use App\Http\Controllers\Workshop\ServiceController;
use App\Http\Controllers\Workshop\ServiceParentController;
use App\Http\Controllers\Workshop\TypeServiceController;
use App\Http\Controllers\Workshop\MechanicController;
use App\Http\Controllers\Workshop\CustomerController;
use App\Http\Controllers\Workshop\CarController;
use App\Http\Controllers\Workshop\CarBrandController;
use App\Http\Controllers\Workshop\CarTypeController;
use App\Http\Controllers\Workshop\ColorController;
use App\Http\Controllers\Workshop\PrimerColorController;
use App\Http\Controllers\Workshop\StockController;
use App\Http\Controllers\Workshop\OrderController;
use App\Http\Controllers\Workshop\InvoiceController;
use App\Http\Controllers\Workshop\WorkorderController;
use App\Http\Controllers\Workshop\ExpenseSpendingController;
use App\Http\Controllers\Workshop\ExpenseInvestmentController;
use App\Http\Controllers\Workshop\ReportController;
//workshop
//store
use App\Http\Controllers\Store\StoreTypeProductController;
use App\Http\Controllers\Store\StoreProductController;
use App\Http\Controllers\Store\StoreStockController;
use App\Http\Controllers\Store\StoreChasierController;
use App\Http\Controllers\Store\StoreCustomerController;
use App\Http\Controllers\Store\StoreSpendingController;
use App\Http\Controllers\Store\StoreInvestmentController;
use App\Http\Controllers\Store\ReportStoreController;
//store
//hrm
use App\Http\Controllers\Hrm\AttendanceController;
use App\Http\Controllers\Hrm\AttendancePermitController;
use App\Http\Controllers\Hrm\EmployeeCreditController;
use App\Http\Controllers\Hrm\PayrollController;

//hrm

Route::resource('dashboard', DashboardController::class)->middleware(['auth']);
Route::resource('/', DashboardController::class)->middleware(['auth']);
Route::resource('setting', SettingController::class)->middleware(['auth']);
Route::controller(EstimatorController::class)->group(function () {
    Route::post('estimator/changeColor', 'changeColor')->name('changeColor');
    Route::post('estimator/showEstimator', 'showEstimator')->name('showEstimator');
    Route::get('estimator/download/{id}', 'download')->name('estimator.download');
    Route::post('estimator/detailEstimatorService', 'detailEstimatorService')->name('detailEstimatorService');
    Route::post('estimator/addEstimatorService', 'addEstimatorService')->name('addEstimatorService');
    Route::post('estimator/priceEstimatorService', 'priceEstimatorService')->name('priceEstimatorService');
    Route::post('estimator/deleteEstimatorService', 'deleteEstimatorService')->name('deleteEstimatorService');
    Route::post('estimator/order', 'order')->name('order');
});
Route::resource('estimator', EstimatorController::class);

Route::controller(EstimatorInternalController::class)->group(function () {
    Route::post('estimator-internal/changeColor', 'changeColor')->name('internal.changeColor')->middleware(['auth']);
    Route::post('estimator-internal/showEstimator', 'showEstimator')->name('internal.showEstimator')->middleware(['auth']);
    Route::get('estimator-internal/profile', 'profile')->name('estimator.profile')->middleware(['auth']);
    Route::get('estimator-internal/download/{id}', 'download')->name('internal.download')->middleware(['auth']);
    Route::post('estimator-internal/detailEstimatorService', 'detailEstimatorService')->name('internal.detailEstimatorService')->middleware(['auth']);
    Route::post('estimator-internal/addEstimatorService', 'addEstimatorService')->name('internal.addEstimatorService')->middleware(['auth']);
    Route::post('estimator-internal/priceEstimatorService', 'priceEstimatorService')->name('internal.priceEstimatorService')->middleware(['auth']);
    Route::post('estimator-internal/deleteEstimatorService', 'deleteEstimatorService')->name('internal.deleteEstimatorService')->middleware(['auth']);
    Route::post('estimator-internal/saveMaster', 'saveMaster')->name('internal.saveMaster')->middleware(['auth']);
    Route::post('estimator-internal/headersave', 'headersave')->name('internal.headersave')->middleware(['auth']);
    Route::post('estimator-internal/order', 'order')->name('internal.order')->middleware(['auth']);
});
Route::resource('estimator-internal', EstimatorInternalController::class)->middleware(['auth']);
//workshop
Route::resource('type-product', TypeProductController::class)->middleware(['auth']);
Route::resource('product', ProductController::class)->middleware(['auth']);
Route::resource('type-service', TypeServiceController::class)->middleware(['auth']);
Route::resource('service', ServiceController::class)->middleware(['auth']);

Route::controller(ServiceParentController::class)->group(function () {
    Route::post('service-parent/editCustom', 'editCustom')->name('serviceParent.editCustom')->middleware(['auth']);
	Route::post('service-parent/updateService', 'updateService')->name('serviceParent.updateService')->middleware(['auth']);
});
Route::resource('service-parent', ServiceParentController::class)->middleware(['auth']);

Route::resource('mechanic', MechanicController::class)->middleware(['auth']);

Route::controller(CustomerController::class)->group(function () {
    Route::get('customer/customerDetail', 'customerDetail')->name('customerDetail')->middleware(['auth']);
    Route::post('customer/deleteCustomerCar', 'deleteCustomerCar')->name('deleteCustomerCar')->middleware(['auth']);
    Route::post('customer/addCarCustomer', 'addCarCustomer')->name('addCarCustomer')->middleware(['auth']);
});
Route::resource('customer', CustomerController::class)->middleware(['auth']);

Route::controller(CarController::class)->group(function () {
    Route::post('car/uploadImages', 'uploadImages')->name('uploadImages')->middleware(['auth']);
    Route::post('car/deleteImages', 'deleteImages')->name('deleteImages')->middleware(['auth']);
    Route::post('car/addCar', 'addCar')->name('car.addCar')->middleware(['auth']);
    Route::post('car/deleteCar', 'deleteCar')->name('car.deleteCar')->middleware(['auth']);
    Route::get('car/detailCar', 'detailCar')->name('detailCar')->middleware(['auth']);
});
Route::resource('car', CarController::class)->middleware(['auth']);
Route::resource('car-brand', CarBrandController::class)->middleware(['auth']);
Route::resource('car-type', CarTypeController::class)->middleware(['auth']);
Route::resource('color', ColorController::class)->middleware(['auth']);
Route::resource('primer-color', PrimerColorController::class)->middleware(['auth']);

Route::controller(StockController::class)->group(function () {
    Route::get('stock/detailItem', 'detailItem')->name('detailItem')->middleware(['auth']);
    Route::post('stock/addItem', 'addItem')->name('addItem')->middleware(['auth']);
    Route::post('stock/deleteItem', 'deleteItem')->name('deleteItem')->middleware(['auth']);
    //Route::get('stock/{id}', 'show')->name('stock.show')->middleware(['auth']);
});
Route::resource('stock', StockController::class)->middleware(['auth']);
Route::controller(OrderController::class)->group(function () {
    Route::get('order/detailOrder', 'detailOrder')->name('detailOrder')->middleware(['auth']);
    Route::get('order/profile', 'profile')->name('profile.car')->middleware(['auth']);
    Route::get('order/detailProduct', 'detailProduct')->name('detailProduct')->middleware(['auth']);
    Route::post('order/addOrder', 'addOrder')->name('addOrder')->middleware(['auth']);
    Route::post('order/updateOrder', 'updateOrder')->name('updateOrder')->middleware(['auth']);
    Route::get('order/allDetail', 'allDetail')->name('allDetail')->middleware(['auth']);
    Route::post('order/addOrderProduct', 'addOrderProduct')->name('addOrderProduct')->middleware(['auth']);
    Route::post('order/addCar', 'addCar')->name('addCar')->middleware(['auth']);
    Route::post('order/deleteOrder', 'deleteOrder')->name('deleteOrder')->middleware(['auth']);
    Route::post('order/deleteOrderProduct', 'deleteOrderProduct')->name('deleteOrderProduct')->middleware(['auth']);
    Route::post('order/addInvoice', 'addInvoice')->name('addInvoice')->middleware(['auth']);
    Route::post('order/price', 'price')->name('order.price')->middleware(['auth']);
});
Route::resource('order', OrderController::class)->middleware(['auth']);
Route::controller(InvoiceController::class)->group(function () {
    Route::post('invoice/payInvoice', 'payInvoice')->name('payInvoice')->middleware(['auth']);
    Route::post('invoice/workOrder', 'workOrder')->name('workOrder')->middleware(['auth']);
    Route::post('invoice/voidInvoice', 'voidInvoice')->name('voidInvoice')->middleware(['auth']);
    Route::get('invoice/print/{id}', 'print')->name('invoice.print')->middleware(['auth']);
    Route::get('invoice/printProduct/{id}', 'printProduct')->name('invoice.printProduct')->middleware(['auth']);
    Route::get('invoice/download/{id}', 'download')->name('invoice.download')->middleware(['auth']);
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
    Route::get('store-chasier/download/{id}', 'download')->name('store-chasier.download')->middleware(['auth']);
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
//hrm 
Route::controller(AttendanceController::class)->group(function () {
    
});
Route::resource('attendance', AttendanceController::class)->middleware(['auth']);

Route::resource('attendance-permit', AttendancePermitController::class)->middleware(['auth']);

Route::controller(EmployeeCreditController::class)->group(function () {
    Route::post('employee-credit/paid', 'paid')->name('employee-credit.paid')->middleware(['auth']);
});
Route::resource('employee-credit', EmployeeCreditController::class)->middleware(['auth']);

Route::controller(PayrollController::class)->group(function () {
    Route::post('payroll/getAttendance', 'getAttendance')->name('payroll.getAttendance')->middleware(['auth']);
    Route::get('payroll/print/{id}', 'print')->name('payroll.print')->middleware(['auth']);
});
Route::resource('payroll', PayrollController::class)->middleware(['auth']);
//hrm 

Route::get('generate', function () {
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    echo 'ok';
});

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});