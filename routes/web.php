<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\OfficerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\YearController;

Auth::routes();

// Routes with auth middleware
Route::middleware(['auth'])->group(function () {
    // Admin page
    Route::get('/admin', [HomeController::class, 'index'])->name('home.dashboard');
    
    // Guest routes
    Route::get('/admin/guest', [GuestController::class, 'index']);
    Route::resource('admin/guest', GuestController::class);
    Route::post('/guest-excel', [GuestController::class, 'guestExcel'])->name('guest.excel');
    
    // Officer routes
    Route::resource('admin/officer', OfficerController::class);
    Route::get('/officer-excel', [OfficerController::class, 'officerExcel'])->name('officer.excel');

    // User routes
    Route::resource('admin/account/user', UserController::class);
    Route::get('/user-excel', [UserController::class, 'userExcel'])->name('user.excel');

    // Year routes
    Route::post('/current-year', [YearController::class, 'currentYear'])->name('current-year');
    Route::get('/admin/setting/year', [YearController::class, 'index'])->name('year.index');
    Route::post('/admin/setting/year', [YearController::class, 'store'])->name('storeYear');
    Route::post('/admin/setting/year/update/{id}', [YearController::class, 'update'])->name('updateYear');
    Route::delete('/admin/setting/year/delete/{id}', [YearController::class, 'destroy'])->name('deleteYear');
    
});
