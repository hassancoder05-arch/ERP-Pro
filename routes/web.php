<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\AccountingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;


/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});


/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
| Admin + Manager
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'role:admin,manager'])
    ->name('dashboard');


/*
|--------------------------------------------------------------------------
| Employees
|--------------------------------------------------------------------------
| Admin + Manager
|--------------------------------------------------------------------------
*/

Route::resource('employees', EmployeeController::class)
    ->middleware(['auth', 'role:admin,manager']);


/*
|--------------------------------------------------------------------------
| Customers
|--------------------------------------------------------------------------
| Admin + Manager + Sales
|--------------------------------------------------------------------------
*/

Route::resource('customers', CustomerController::class)
    ->middleware(['auth', 'role:admin,manager,sales']);


/*
|--------------------------------------------------------------------------
| Suppliers
|--------------------------------------------------------------------------
| Admin + Manager
|--------------------------------------------------------------------------
*/

Route::resource('suppliers', SupplierController::class)
    ->middleware(['auth', 'role:admin,manager']);


/*
|--------------------------------------------------------------------------
| Products
|--------------------------------------------------------------------------
| Admin + Manager + Sales
|--------------------------------------------------------------------------
*/

Route::resource('products', ProductController::class)
    ->middleware(['auth', 'role:admin,manager,sales']);


/*
|--------------------------------------------------------------------------
| Inventory
|--------------------------------------------------------------------------
| Admin + Manager + Sales
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,manager,sales'])->group(function () {

    Route::get('/inventory', [InventoryController::class, 'index'])
        ->name('inventory.index');

    Route::get('/inventory/create', [InventoryController::class, 'create'])
        ->name('inventory.create');

    Route::post('/inventory', [InventoryController::class, 'store'])
        ->name('inventory.store');

    Route::get('/inventory/history', [InventoryController::class, 'history'])
        ->name('inventory.history');

    Route::get('/inventory/{product}', [InventoryController::class, 'show'])
        ->name('inventory.show');
});


/*
|--------------------------------------------------------------------------
| Sales
|--------------------------------------------------------------------------
| Admin + Manager + Sales
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,manager,sales'])->group(function () {

    Route::get('/sales', [SaleController::class, 'index'])
        ->name('sales.index');

    Route::get('/sales/create', [SaleController::class, 'create'])
        ->name('sales.create');

    Route::post('/sales', [SaleController::class, 'store'])
        ->name('sales.store');

    Route::get('/sales/{sale}', [SaleController::class, 'show'])
        ->name('sales.show');

    Route::delete('/sales/{sale}', [SaleController::class, 'destroy'])
        ->name('sales.destroy');
});


/*
|--------------------------------------------------------------------------
| Finance
|--------------------------------------------------------------------------
| Admin + Manager + Accountant
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,manager,accountant'])->group(function () {

    Route::get('/finance', [FinanceController::class, 'index'])
        ->name('finance.index');

    Route::resource('expense-categories', ExpenseCategoryController::class);

    Route::resource('expenses', ExpenseController::class);

    Route::resource('incomes', IncomeController::class);

    Route::get('/payments', [PaymentController::class, 'index'])
        ->name('payments.index');

    Route::get('/payments/create', [PaymentController::class, 'create'])
        ->name('payments.create');

    Route::post('/payments', [PaymentController::class, 'store'])
        ->name('payments.store');
});


/*
|--------------------------------------------------------------------------
| Reports
|--------------------------------------------------------------------------
| Admin + Manager + Accountant
|--------------------------------------------------------------------------
*/

Route::get('/reports', [ReportController::class, 'index'])
    ->middleware(['auth', 'role:admin,manager,accountant'])
    ->name('reports.index');


/*
|--------------------------------------------------------------------------
| Accounting
|--------------------------------------------------------------------------
| Admin + Manager + Accountant
|--------------------------------------------------------------------------
*/

Route::get('/accounting', [AccountingController::class, 'index'])
    ->middleware(['auth', 'role:admin,manager,accountant'])
    ->name('accounting.index');


/*
|--------------------------------------------------------------------------
| Settings
|--------------------------------------------------------------------------
| Admin Only
|--------------------------------------------------------------------------
*/

Route::get('/settings', [SettingController::class, 'index'])
    ->middleware(['auth', 'role:admin'])
    ->name('settings.index');

Route::put('/settings', [SettingController::class, 'update'])
    ->middleware(['auth', 'role:admin'])
    ->name('settings.update');


/*
|--------------------------------------------------------------------------
| Invoices
|--------------------------------------------------------------------------
| Admin + Manager + Sales
|--------------------------------------------------------------------------
*/

Route::get('/invoices/{sale}', [InvoiceController::class, 'show'])
    ->middleware(['auth', 'role:admin,manager,sales'])
    ->name('invoices.show');

Route::get('/invoices/{sale}/pdf', [InvoiceController::class, 'pdf'])
    ->middleware(['auth', 'role:admin,manager,sales'])
    ->name('invoices.pdf');

/*
|--------------------------------------------------------------------------
| Notifications
|--------------------------------------------------------------------------
| Admin + Manager + Sales
|--------------------------------------------------------------------------*/

Route::get('/notifications', [NotificationController::class, 'index'])
    ->middleware(['auth'])
    ->name('notifications.index');

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';