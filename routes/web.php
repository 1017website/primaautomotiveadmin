<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
//general
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\EstimatorController;
use App\Http\Controllers\EstimatorInternalController;
use App\Http\Controllers\UserRolesController;
use App\Http\Controllers\UserController;

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
use App\Http\Controllers\Workshop\ColorCategoryController;
use App\Http\Controllers\Workshop\ColorGroupController;
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
use App\Http\Controllers\Store\MasterRackController;
use App\Http\Controllers\Store\StoreStockController;
use App\Http\Controllers\Store\StoreChasierController;
use App\Http\Controllers\Store\StoreCustomerController;
use App\Http\Controllers\Store\StoreSpendingController;
use App\Http\Controllers\Store\StoreInvestmentController;
use App\Http\Controllers\Store\ReportStoreController;
use App\Http\Controllers\Store\MixController;
use App\Http\Controllers\Store\MaterialUsageHistoryController;
use App\Http\Controllers\Store\MaterialUsageController;
//store
//hrm
use App\Http\Controllers\Hrm\FingerprintController;
use App\Http\Controllers\Hrm\AttendanceController;
use App\Http\Controllers\Hrm\AttendancePermitController;
use App\Http\Controllers\Hrm\AttendanceSystemController;
use App\Http\Controllers\Hrm\EmployeeCreditController;
use App\Http\Controllers\Hrm\PayrollController;
use App\Http\Controllers\Hrm\ReportHrmController;
//wash
use App\Http\Controllers\Wash\WashServiceController;
use App\Http\Controllers\Wash\WashAssetController;
use App\Http\Controllers\Wash\WashExpensesProductController;
use App\Http\Controllers\Wash\WashExpensesServiceController;
use App\Http\Controllers\Wash\WashProductController;
use App\Http\Controllers\Wash\WashSalesController;
use App\Http\Controllers\Workshop\ColorDatabaseController;
use App\Http\Middleware\CheckDashboardAccess;
use App\Models\Menu;
use Illuminate\Support\Facades\View;

// Unauthorized
Route::get('unauthorized', function () {
    return view('unauthorized');
})->name('unauthorized');

// Separates Dashboard
Route::middleware(['auth', CheckDashboardAccess::class])->group(function () {
    Route::resource('dashboard', DashboardController::class)->middleware(['auth']);
    Route::resource('/', DashboardController::class)->middleware(['auth']);
});

Route::get('dashboard-guest', [DashboardController::class, 'dashboardGuest'])->name('dashboard-guest')->middleware(['auth']);

Route::controller(SettingController::class)->middleware(['auth', 'role:65'])->group(function () {
    Route::post('attendance/set-timezone', 'setTimezone')->name('setTimezone');
    Route::post('attendance/restart-finger', 'restartFinger')->name('restartFinger');
    Route::post('attendance/set-timezone-shine', 'setTimezoneShine')->name('setTimezoneShine');
    Route::post('attendance/restart-finger-shine', 'restartFingerShine')->name('restartFingerShine');
});
Route::resource('setting', SettingController::class)->middleware(['auth', 'role:65']);

// Estimator Internal
Route::controller(EstimatorInternalController::class)->middleware(['auth', 'role:69'])->group(function () {
    Route::post('estimator-internal/changeColor', 'changeColor')->name('internal.changeColor');
    Route::post('estimator-internal/showEstimator', 'showEstimator')->name('internal.showEstimator');
    Route::get('estimator-internal/profile', 'profile')->name('estimator.profile');
    Route::get('estimator-internal/download/{id}', 'download')->name('internal.download');
    Route::post('estimator-internal/detailEstimatorService', 'detailEstimatorService')->name('internal.detailEstimatorService');
    Route::post('estimator-internal/addEstimatorService', 'addEstimatorService')->name('internal.addEstimatorService');
    Route::post('estimator-internal/priceEstimatorService', 'priceEstimatorService')->name('internal.priceEstimatorService');
    Route::post('estimator-internal/deleteEstimatorService', 'deleteEstimatorService')->name('internal.deleteEstimatorService');
    Route::post('estimator-internal/saveMaster', 'saveMaster')->name('internal.saveMaster');
    Route::post('estimator-internal/headersave', 'headersave')->name('internal.headersave');
    Route::post('estimator-internal/order', 'order')->name('internal.order');
});
Route::resource('estimator-internal', EstimatorInternalController::class)->middleware(['auth', 'role:69']);

// WORKSHOP
Route::resource('type-product', TypeProductController::class)->middleware(['auth', 'role:23']);
Route::resource('product', ProductController::class)->middleware(['auth', 'role:24']);
Route::resource('type-service', TypeServiceController::class)->middleware(['auth', 'role:25']);
Route::resource('service', ServiceController::class)->middleware(['auth', 'role:27']);

Route::controller(ServiceParentController::class)->middleware(['auth', 'role:26'])->group(function () {
    Route::post('service-parent/editCustom', 'editCustom')->name('serviceParent.editCustom');
    Route::post('service-parent/updateService', 'updateService')->name('serviceParent.updateService');
});
Route::resource('service-parent', ServiceParentController::class)->middleware(['auth', 'role:26']);

Route::controller(MixController::class)->middleware(['auth', 'role:4'])->group(function () {
    Route::post('mix/add', 'add')->name('mix.add');
    Route::get('mix/detail', 'detail')->name('mix.detail');
    Route::post('mix/delete', 'delete')->name('mix.delete');
    Route::post('mix/updateService', 'updateService')->name('mix.updateService');
    Route::post('mix/ingredient', 'ingredient')->name('mix.ingredient');
});
Route::resource('mix', MixController::class)->middleware(['auth', 'role:4']);

// Customer
Route::controller(CustomerController::class)->middleware(['auth', 'role:28'])->group(function () {
    Route::get('customer/customerDetail', 'customerDetail')->name('customerDetail');
    Route::post('customer/deleteCustomerCar', 'deleteCustomerCar')->name('deleteCustomerCar');
    Route::post('customer/addCarCustomer', 'addCarCustomer')->name('addCarCustomer');
});
Route::resource('customer', CustomerController::class)->middleware(['auth', 'role:28']);
// Car
Route::controller(CarController::class)->middleware(['auth', 'role:29'])->group(function () {
    Route::post('car/uploadImages', 'uploadImages')->name('uploadImages');
    Route::post('car/uploadTempImages', 'uploadTempImages')->name('uploadTempImages');
    Route::post('car/deleteImages', 'deleteImages')->name('deleteImages');
    Route::post('car/addCar', 'addCar')->name('car.addCar');
    Route::post('car/deleteCar', 'deleteCar')->name('car.deleteCar');
    Route::get('car/detailCar', 'detailCar')->name('detailCar');
    Route::get('car/detailCarShow', 'detailCarShow')->name('detailCarShow');
});
Route::resource('car', CarController::class)->middleware(['auth', 'role:29']);
Route::resource('car-brand', CarBrandController::class)->middleware(['auth', 'role:30']);
Route::resource('car-type', CarTypeController::class)->middleware(['auth', 'role:31']);
// Color Workshop 
Route::resource('color-group', ColorGroupController::class)->middleware(['auth', 'role:32']);
Route::resource('color', ColorController::class)->middleware(['auth', 'role:33']);
Route::resource('color-category', ColorCategoryController::class)->middleware(['auth', 'role:34']);

// Color Database 
Route::controller(ColorDatabaseController::class)->middleware(['auth', 'role:35'])->group(function () {
    Route::get('color-database/getColorGroups', 'getColorGroups')->name('color-database.getColorGroups');
    Route::post('color-database/saveMaster', 'saveMaster')->name('color-database.saveMaster');
});
Route::resource('color-database', ColorDatabaseController::class)->middleware(['auth', 'role:35']);

// Stock 
Route::controller(StockController::class)->middleware(['auth', 'role:37'])->group(function () {
    Route::get('stock/detailItem', 'detailItem')->name('detailItem');
    Route::post('stock/addItem', 'addItem')->name('addItem');
    Route::post('stock/deleteItem', 'deleteItem')->name('deleteItem');
    //Route::get('stock/{id}', 'show')->name('stock.show')->middleware(['auth']);
});
Route::resource('stock', StockController::class)->middleware(['auth', 'role:37']);
// Order 
Route::controller(OrderController::class)->middleware(['auth', 'role:38'])->group(function () {
    Route::get('order/detailOrder', 'detailOrder')->name('detailOrder');
    Route::get('order/profile', 'profile')->name('profile.car');
    Route::get('order/detailProduct', 'detailProduct')->name('detailProduct');
    Route::post('order/addOrder', 'addOrder')->name('addOrder');
    Route::post('order/updateOrder', 'updateOrder')->name('updateOrder');
    Route::get('order/allDetail', 'allDetail')->name('allDetail');
    Route::post('order/addOrderProduct', 'addOrderProduct')->name('addOrderProduct');
    Route::post('order/addCar', 'addCar')->name('addCar');
    Route::post('order/deleteOrder', 'deleteOrder')->name('deleteOrder');
    Route::post('order/deleteOrderProduct', 'deleteOrderProduct')->name('deleteOrderProduct');
    Route::post('order/addInvoice', 'addInvoice')->name('addInvoice');
    Route::post('order/price', 'price')->name('order.price');
});
Route::resource('order', OrderController::class)->middleware(['auth', 'role:38']);
// Invoice 
Route::controller(InvoiceController::class)->middleware(['auth', 'role:39'])->group(function () {
    Route::post('invoice/payInvoice', 'payInvoice')->name('payInvoice');
    Route::post('invoice/workOrder', 'workOrder')->name('workOrder');
    Route::post('invoice/voidInvoice', 'voidInvoice')->name('voidInvoice');
    Route::post('invoice/voidWashInvoice', 'voidWashInvoice')->name('voidWashInvoice');
    Route::get('invoice/print/{id}', 'print')->name('invoice.print');
    Route::get('invoice/printProduct/{id}', 'printProduct')->name('invoice.printProduct');
    Route::get('invoice/download/{id}', 'download')->name('invoice.download');
});
Route::resource('invoice', InvoiceController::class)->middleware(['auth', 'role:39']);
// Work Order 
Route::controller(WorkorderController::class)->middleware(['auth', 'role:40'])->group(function () {
    Route::get('workorder/detailWork', 'detailWork')->name('detailWork');
    Route::post('workorder/deleteWork', 'deleteWork')->name('deleteWork');
    Route::get('workorder/getStock', 'getStock')->name('getStock');
    Route::post('workorder/addWork', 'addWork')->name('addWork');
});
Route::resource('workorder', WorkorderController::class)->middleware(['auth', 'role:40']);
// Expense Spending 
Route::resource('expense-spending', ExpenseSpendingController::class)->middleware(['auth', 'role:42']);
// Expense Investment 
Route::resource('expense-investment', ExpenseInvestmentController::class)->middleware(['auth', 'role:43']);

// Report Workshop 
Route::controller(ReportController::class)->group(function () {
    Route::get('report/current-stock', 'currentStock')->name('currentStock')->middleware(['auth', 'role:45']);
    Route::get('report/current-stock-view', 'currentStockView')->name('currentStockView')->middleware(['auth', 'role:45']);
    Route::get('report/history-stock', 'historyStock')->name('historyStock')->middleware(['auth', 'role:46']);
    Route::get('report/history-stock-view', 'historyStockView')->name('historyStockView')->middleware(['auth', 'role:46']);
    Route::get('report/revenue', 'revenue')->name('revenue')->middleware(['auth', 'role:47']);
    Route::get('report/revenue-view', 'revenueView')->name('revenueView')->middleware(['auth', 'role:47']);
    Route::get('report/expense', 'expense')->name('expense')->middleware(['auth', 'role:48']);
    Route::get('report/expense-view', 'expenseView')->name('expenseView')->middleware(['auth', 'role:48']);
});
//workshop


// STORE
// Store Type Product
Route::resource('store-type-product', StoreTypeProductController::class)->middleware(['auth', 'role:6']);

// Store Product
Route::controller(StoreProductController::class)->middleware(['auth', 'role:7'])->group(function () {
    Route::get('store-product/print/{id}', 'print')->name('store-product.print');
});
Route::resource('store-product', StoreProductController::class)->middleware(['auth', 'role:7']);

// Master Rack 
Route::controller(MasterRackController::class)->middleware(['auth', 'role:3'])->group(function () {
    Route::get('master-rack/edit/{code}', 'edit')->name('master-rack.edit');
});
Route::resource('master-rack', MasterRackController::class)->middleware(['auth', 'role:3']);

// Store Stock 
Route::controller(StoreStockController::class)->middleware(['auth', 'role:8'])->group(function () {
    Route::get('store-stock/detail', 'detail')->name('store-stock.detail');
    Route::post('store-stock/price', 'price')->name('store-stock.price');
    Route::post('store-stock/add', 'add')->name('store-stock.add');
    Route::post('store-stock/delete', 'delete')->name('store-stock.delete');
    //Route::get('stock/{id}', 'show')->name('stock.show')->middleware(['auth']);
});
Route::resource('store-stock', StoreStockController::class)->middleware(['auth', 'role:8']);

// Store Cashier 
Route::controller(StoreChasierController::class)->middleware(['auth', 'role:9'])->group(function () {
    Route::get('store-chasier/detail', 'detail')->name('store-chasier.detail');
    Route::post('store-chasier/add', 'add')->name('store-chasier.add');
    Route::post('store-chasier/barcode', 'barcode')->name('store-chasier.barcode');
    Route::post('store-chasier/save', 'save')->name('store-chasier.save');
    Route::post('store-chasier/price', 'price')->name('store-chasier.price');
    Route::get('store-chasier/customer', 'customer')->name('store-chasier.customer');
    Route::get('store-chasier/print/{id}', 'print')->name('store-chasier.print');
    Route::get('store-chasier/download/{id}', 'download')->name('store-chasier.download');
    Route::post('store-chasier/payInvoice', 'payStore')->name('payStore');
    Route::post('store-chasier/deleteProduct', 'deleteProduct')->name('store-chasier.deleteProduct');
});
Route::resource('store-chasier', StoreChasierController::class)->middleware(['auth', 'role:9']);

// Store Customer 
Route::controller(StoreCustomerController::class)->middleware(['auth', 'role:10'])->group(function () {
    Route::post('store-customer/store', 'store')->name('store-customer.store');
});
Route::resource('store-customer', StoreCustomerController::class)->middleware(['auth', 'role:10']);
// Store Spending 
Route::resource('store-spending', StoreSpendingController::class)->middleware(['auth', 'role:11']);
// Store Investment
Route::resource('store-investment', StoreInvestmentController::class)->middleware(['auth', 'role:12']);

// Report Store
Route::controller(ReportStoreController::class)->group(function () {
    Route::get('report-store/current-stock', 'currentStock')->name('currentStockStore')->middleware(['auth', 'role:14']);
    Route::get('report-store/current-stock-view', 'currentStockView')->name('currentStockViewStore')->middleware(['auth', 'role:14']);
    Route::get('report-store/history-stock', 'historyStock')->name('historyStockStore')->middleware(['auth', 'role:15']);
    Route::get('report-store/history-stock-view', 'historyStockView')->name('historyStockViewStore')->middleware(['auth', 'role:15']);
    Route::get('report-store/revenue', 'revenue')->name('revenueStore')->middleware(['auth', 'role:16']);
    Route::get('report-store/revenue-view', 'revenueView')->name('revenueViewStore')->middleware(['auth', 'role:16']);
    Route::get('report-store/expense', 'expense')->name('expenseStore')->middleware(['auth', 'role:17']);
    Route::get('report-store/expense-view', 'expenseView')->name('expenseViewStore')->middleware(['auth', 'role:17']);
    Route::get('report-store/stock-rack', 'stockRack')->name('stockRack')->middleware(['auth', 'role:18']);
    Route::get('report-store/stock-rack-view', 'stockRackView')->name('stockRackView')->middleware(['auth', 'role:18']);
    Route::get('report-store/history-rack', 'historyRack')->name('historyRack')->middleware(['auth', 'role:19']);
    Route::get('report-store/history-stock-rack-view', 'historyStockRackView')->name('historyStockRackView')->middleware(['auth', 'role:19']);
});
// END OF STORE

// HRM
// System (No need User Roles)
Route::get('attendance/import-attendance-system', [AttendanceSystemController::class, 'importAttendanceSystem'])->withoutMiddleware(['auth'])->name('importAttendanceSystem');
Route::get('attendance/import-attendance-system-shine', [AttendanceSystemController::class, 'importAttendanceSystemShine'])->withoutMiddleware(['auth'])->name('importAttendanceSystemShine');

Route::resource('mechanic', MechanicController::class)->middleware(['auth', 'role:58']);
// Attendance 
Route::controller(AttendanceController::class)->middleware(['auth', 'role:59'])->group(function () {
    Route::get('attendance/import', 'import')->name('attendance.import');
    Route::get('attendance/download-template', 'downloadTemplate')->name('attendance.downloadTemplate');
    Route::post('attendance/import-upload', 'importUpload')->name('attendance.importUpload');
    Route::post('attendance/import-attendance', 'importAttendance')->name('importAttendance');
    Route::post('attendance/import-attendance-shine', 'importAttendanceShine')->name('importAttendanceShine');
});
Route::resource('attendance', AttendanceController::class)->middleware(['auth', 'role:59']);

// Attendance Permit
Route::resource('attendance-permit', AttendancePermitController::class)->middleware(['auth', 'role:60']);

// Report HRM 
Route::controller(ReportHrmController::class)->middleware(['auth', 'role:64'])->group(function () {
    Route::get('report/attendance-view', 'attendanceView')->name('attendanceView');
    Route::get('report/attendance-view-month', 'attendanceViewMonth')->name('attendanceViewMonth');
    Route::get('report/attendance-view-week', 'attendanceViewWeek')->name('attendanceViewWeek');
    Route::get('report/attendance', 'index')->name('attendanceHome');
    Route::get('report/monthly-attendance', 'indexMonth')->name('indexMonth');
    Route::get('report/weekly-attendance', 'indexWeek')->name('indexWeek');
});

// Employee Credit
Route::controller(EmployeeCreditController::class)->middleware(['auth', 'role:62'])->group(function () {
    Route::post('employee-credit/paid', 'paid')->name('employee-credit.paid');
});
Route::resource('employee-credit', EmployeeCreditController::class)->middleware(['auth', 'role:62']);

// Payroll 
Route::controller(PayrollController::class)->middleware(['auth', 'role:61'])->group(function () {
    Route::post('payroll/getAttendance', 'getAttendance')->name('payroll.getAttendance');
    Route::get('payroll/print/{id}', 'print')->name('payroll.print');
});
Route::resource('payroll', PayrollController::class)->middleware(['auth', 'role:61']);

// Fingerprint
Route::controller(FingerprintController::class)->group(function () {
    Route::post('fingerprint/callback', 'callback');
    Route::post('fingerprint/get-log', 'getLog');
    Route::post('fingerprint/get-user', 'getUser');
    Route::post('fingerprint/get-user-all', 'getUserAll');
    Route::post('fingerprint/delete-user', 'deleteUser');
    Route::post('fingerprint/set-timezone', 'setTimezone');
    Route::post('fingerprint/restart', 'restart');
});
Route::resource('fingerprint', FingerprintController::class);
// END OF HRM

// USER
// User Roles
Route::controller(UserRolesController::class)->middleware(['auth', 'role:68'])->group(function () {
    Route::get('user-roles/get-menu', 'getMenu')->name('user-role.getMenu');
    Route::put('user-roles/update', [UserRolesController::class, 'update'])->name('user-role.update');
});
Route::resource('user-roles', UserRolesController::class)->middleware(['auth', 'role:68']);
// END OF USER

// PrimaxShine 
Route::resource('wash-service', WashServiceController::class)->middleware(['auth', 'role:50']);
Route::resource('wash-product', WashProductController::class)->middleware(['auth', 'role:51']);
Route::resource('wash-asset', WashAssetController::class)->middleware(['auth', 'role:52']);
Route::controller(WashSalesController::class)->middleware(['auth', 'role:56'])->group(function () {
    Route::post('wash-sale/price', 'price')->name('wash-sale.price');
    Route::post('wash-sale/priceProduct', 'priceProduct')->name('wash-sale.priceProduct');
    Route::post('wash-sale/addOrder', 'addOrder')->name('wash-sale.addOrder');
    Route::get('wash-sale/detailOrder', 'detailOrder')->name('wash-sale.detailOrder');
    Route::get('wash-sale/profile', 'profile')->name('profile.car');
    Route::get('wash-sale/detailProduct', 'detailProduct')->name('wash-sale.detailProduct');
    Route::post('wash-sale/updateOrder', 'updateOrder')->name('wash-sale.updateOrder');
    Route::get('wash-sale/allDetail', 'allDetail')->name('wash-sale.allDetail');
    Route::post('wash-sale/addOrderProduct', 'addOrderProduct')->name('wash-sale.addOrderProduct');
    Route::post('wash-sale/addCar', 'addCar')->name('addCar');
    Route::post('wash-sale/deleteOrder', 'deleteOrder')->name('wash-sale.deleteOrder');
    Route::post('wash-sale/deleteOrderProduct', 'deleteOrderProduct')->name('wash-sale.deleteOrderProduct');
    Route::post('wash-sale/addInvoice', 'addInvoice')->name('wash-sale.addInvoice');
});
Route::resource('wash-sale', WashSalesController::class)->middleware(['auth', 'role:56']);
Route::resource('wash-expense-product', WashExpensesProductController::class)->middleware(['auth', 'role:55']);
Route::resource('wash-expense-service', WashExpensesServiceController::class)->middleware(['auth', 'role:54']);

// User Configuration (No need User Roles)
Route::put('user/changePassword', [UserController::class, 'changePassword'])->name('user.changePassword')->middleware(['auth']);
Route::resource('user', UserController::class)->middleware(['auth']);

// Material Usage
Route::controller(MaterialUsageController::class)->middleware(['auth', 'role:5'])->group(function () {
    Route::post('material-usage/price', 'price')->name('material-usage.price');
    Route::post('material-usage/total', 'total')->name('material-usage.totalPrice');
});
Route::resource('material-usage', MaterialUsageController::class)->middleware(['auth', 'role:5']);

// Material Usage History 
Route::controller(MaterialUsageHistoryController::class)->middleware(['auth', 'role:20'])->group(function () {
    Route::get('/report-store/material-usage-history/history-view', 'historyMaterialUsage')->name('historyMaterialUsage');
});
Route::resource('/report-store/material-usage-history', MaterialUsageHistoryController::class)->middleware(['auth', 'role:20']);

// Fix bug
Route::get('generate', function () {
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    echo 'ok';
});

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});

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