<?php

use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('assessment_dashboard');
})->name('assessment.dashboard');


Route::get('/reports/recent-orders', [ReportController::class, 'recentOrders'])->name('recent.orders');
Route::get('/reports/customer-sales', [ReportController::class, 'customerSales'])->name('customer.sales');
Route::get('/reports/filtered-orders', [ReportController::class, 'filteredOrders'])->name('orders.filtered');
Route::get('/reports/order-status-summary', [ReportController::class, 'orderStatusSummary'])->name('status.summary');
Route::get('/reports/daily-sales', [ReportController::class, 'dailySalesReport'])->name('reports.daily');
Route::get('/reports/sales-report', [ReportController::class, 'salesReport'])->name('sales.report');
Route::get('/reports/query-performance', [ReportController::class, 'queryPerformance'])->name('query.performance');

