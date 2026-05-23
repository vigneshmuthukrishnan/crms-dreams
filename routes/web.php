<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\BulkSmsPackageController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\SmsLeadController;
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
    return view('auth.login');
});
Route::prefix('phpmyadmin')->group(function () {
    return false; 
});
Route::get('/un-authorized', function () {
    return view('errors.403')->with('error', 'You do not have admin access.');
})->name('un-authorized');
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Company Management Routes not using resource controller
    Route::get('/companies', [CompanyController::class, 'index'])->name('companies.index');
    Route::get('/companies/create', [CompanyController::class, 'create'])->name('companies.create');
    Route::post('/companies/store', [CompanyController::class, 'store'])->name('companies.store');
    Route::get('/companies/edit/{id}', [CompanyController::class, 'edit'])->name('companies.edit');
    Route::post('/companies/update/{id}', [CompanyController::class, 'update'])->name('companies.update');
    Route::delete('/companies/delete/{id}', [CompanyController::class, 'destroy'])->name('companies.destroy');
    Route::get('/companies/{id}', [CompanyController::class, 'show'])->name('companies.show');
    Route::post('/companies/storeSales', [CompanyController::class, 'storeSales'])->name('companies.storeSales');
    Route::get('/getIdLead/{id}', [CompanyController::class, 'getIdLead']);

    Route::post('/close-day', [AuthenticatedSessionController::class, 'closeDay'])->name('attendance.closeDay');

    Route::resource('packages', BulkSmsPackageController::class);

    // Lead Management Routes not resource controller
    Route::get('/leads', [LeadController::class, 'index'])->name('leads.index');
    Route::get('/leads/create', [LeadController::class, 'create'])->name('leads.create');
    Route::post('/leads/store', [LeadController::class, 'store'])->name('leads.store');
    Route::get('/leads/edit/{id}', [LeadController::class, 'edit'])->name('leads.edit');
    Route::post('/leads/update/{id}', [LeadController::class, 'update'])->name('leads.update');
    Route::delete('/leads/delete/{id}', [LeadController::class, 'destroy'])->name('leads.destroy');
    Route::get('/leads/{id}', [LeadController::class, 'show'])->name('leads.show');

    // SMS Lead Management Routes
    Route::get('/sms-leads', [SmsLeadController::class, 'index'])->name('sms-leads.index');
    Route::get('/sms-leads/{id}', [SmsLeadController::class, 'show'])->name('sms-leads.show');
    Route::post('/sms-leads/status/{id}', [SmsLeadController::class, 'updateStatus'])->name('sms-leads.status');

    // lead activities
    Route::post('/leads/{leadId}/activities', [LeadController::class, 'addActivity'])->name('leads.activities.add'); 
    
    Route::get('/product', [ProductController::class, 'index']);
    Route::post('/product', [ProductController::class, 'index'])->name('product.index');
    Route::get('/packages-by-product/{productId}', [ProductController::class, 'getPackagesByProduct']);


    // Report 
    Route::get('/report/leads', [ReportController::class, 'leads'])->name('report.leads');

    // sales routes
    Route::get('/clients', [SalesController::class, 'index'])->name('clients.index');

    Route::get('/calendar', [ReportController::class, 'calendar'])->name('calendar');
});

// Admin can do user management
Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::resource('users', UserController::class);
    Route::get('/users/edit/{id}', [UserController::class, 'editUser'])->name('users.editUser');
    Route::put('/users/update/{id}', [UserController::class, 'updateUser'])->name('users.updateUser');

    // Attendance Route
    Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances.index');
});

require __DIR__.'/auth.php';
