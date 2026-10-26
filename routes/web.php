<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
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
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\CategoryController;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});


/*
|--------------------------------------------------------------------------
| Admin + Manager
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,manager'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Employees
    Route::resource('employees', EmployeeController::class);

    // Suppliers
    Route::resource('suppliers', SupplierController::class);

    // Product Categories
    Route::resource('categories', CategoryController::class);
});


/*
|--------------------------------------------------------------------------
| Customers
|--------------------------------------------------------------------------
| Admin + Manager + Sales
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,manager,sales'])->group(function () {

    Route::resource('customers', CustomerController::class);

});


/*
|--------------------------------------------------------------------------
| Products
|--------------------------------------------------------------------------
| Admin + Manager + Sales
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,manager,sales'])->group(function () {

    Route::resource('products', ProductController::class);

});


/*
|--------------------------------------------------------------------------
| Inventory Management
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
| Sales Management
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
| Invoice Management
|--------------------------------------------------------------------------
| Admin + Manager + Sales
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,manager,sales'])->group(function () {

    Route::get('/invoices/{sale}', [InvoiceController::class, 'show'])
        ->name('invoices.show');

    Route::get('/invoices/{sale}/pdf', [InvoiceController::class, 'pdf'])
        ->name('invoices.pdf');

});


/*
|--------------------------------------------------------------------------
| Finance Management
|--------------------------------------------------------------------------
| Admin + Manager + Accountant
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,manager,accountant'])->group(function () {

    // Finance Dashboard
    Route::get('/finance', [FinanceController::class, 'index'])
        ->name('finance.index');

    // Expense Categories
    Route::resource('expense-categories', ExpenseCategoryController::class);

    // Expenses
    Route::resource('expenses', ExpenseController::class);

    // Incomes
    Route::resource('incomes', IncomeController::class);

    // Payments
    Route::get('/payments', [PaymentController::class, 'index'])
        ->name('payments.index');

    Route::get('/payments/create', [PaymentController::class, 'create'])
        ->name('payments.create');

    Route::post('/payments', [PaymentController::class, 'store'])
        ->name('payments.store');

});


/*
|--------------------------------------------------------------------------
| Purchase Management
|--------------------------------------------------------------------------
| Admin + Manager + Accountant
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,manager,accountant'])->group(function () {

    Route::get('/purchases', [PurchaseController::class, 'index'])
        ->name('purchases.index');

    Route::get('/purchases/create', [PurchaseController::class, 'create'])
        ->name('purchases.create');

    Route::post('/purchases', [PurchaseController::class, 'store'])
        ->name('purchases.store');

    Route::get('/purchases/{purchase}', [PurchaseController::class, 'show'])
        ->name('purchases.show');

    // Mark purchase as ordered
    Route::post('/purchases/{purchase}/order', [PurchaseController::class, 'order'])
        ->name('purchases.order');

    // Receive purchase
    Route::post('/purchases/{purchase}/receive', [PurchaseController::class, 'receive'])
        ->name('purchases.receive');

    // Cancel purchase
    Route::post('/purchases/{purchase}/cancel', [PurchaseController::class, 'cancel'])
        ->name('purchases.cancel');

});


/*
|--------------------------------------------------------------------------
| Reports
|--------------------------------------------------------------------------
| Admin + Manager + Accountant
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,manager,accountant'])->group(function () {

    Route::get('/reports', [ReportController::class, 'index'])
        ->name('reports.index');

});


/*
|--------------------------------------------------------------------------
| Accounting
|--------------------------------------------------------------------------
| Admin + Manager + Accountant
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,manager,accountant'])->group(function () {

    Route::get('/accounting', [AccountingController::class, 'index'])
        ->name('accounting.index');

});


/*
|--------------------------------------------------------------------------
| Settings
|--------------------------------------------------------------------------
| Admin Only
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/settings', [SettingController::class, 'index'])
        ->name('settings.index');

    Route::put('/settings', [SettingController::class, 'update'])
        ->name('settings.update');

});


/*
|--------------------------------------------------------------------------
| Notifications
|--------------------------------------------------------------------------
| All Authenticated Users
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');

});


/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';

