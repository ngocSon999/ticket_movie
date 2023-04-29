<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LoginController;

Route::get('/admin/login',[LoginController::class, 'login'])->name('admin.user.login');
Route::get('/admin/logout',[LoginController::class, 'logout'])->name('admin.user.logout');
Route::post('/admin/user/postLogin',[LoginController::class, 'postLogin'])->name('admin.user.post-login');

Route::prefix('/admin')->middleware('sentinel.auth')->name('admin.')->group(function () {
    Route::get('/dashboard',[DashboardController::class, 'index'])->name('dashboard');
    Route::prefix('/user')->name('user.')->middleware('sentinel.auth')->group(function () {

    });
});
