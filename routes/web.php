<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OfficerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\YearController;

Auth::routes();

// Routes with auth middleware
Route::middleware(['auth'])->group(function () {
    // Admin page
    Route::get('/admin', [HomeController::class, 'index'])->name('home.dashboard');

    // Notifications routes
    Route::post('/readall', [NotificationController::class, 'store'])->name('storeNotification');
    Route::post('/readnotif/{id}', [NotificationController::class, 'update'])->name('updateNotification');
    Route::get('/admin/notifications', [NotificationController::class, 'index'])->name('notif');

    // Profile routes
    Route::get('/admin/profile', [UserController::class, 'profile'])->name('profile');
    Route::get('/admin/profile/edit', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::put('/admin/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::get('/admin/profile/change-password', [UserController::class, 'editPassword'])->name('profile.editPassword');
    Route::put('/admin/profile/update-password', [UserController::class, 'updatePassword'])->name('profile.updatePassword');
    
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
