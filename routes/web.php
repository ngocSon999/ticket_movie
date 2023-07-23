<?php

use App\Http\Controllers\Admin\MovieController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
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

Route::get('/admin/login',[LoginController::class, 'login'])->name('admin.user.login');
Route::get('/admin/logout',[LoginController::class, 'logout'])->name('admin.user.logout');
Route::post('/admin/user/postLogin',[LoginController::class, 'postLogin'])->name('admin.user.post-login');

Route::prefix('/admin')->middleware('sentinel.auth')->name('admin.')->group(function () {
    Route::get('/dashboard',[DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('/user')->name('users.')->middleware('sentinel.auth')->group(function () {
        Route::get('/create', [ UserController::class, 'createForm'])->name('form');
        Route::post('/store', [ UserController::class, 'create'])->name('create');
        Route::get('/index', [ UserController::class, 'index'])->name('index');
        Route::get('/list', [ UserController::class, 'getList'])->name('list');
        Route::get('/edit/{id}', [ UserController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [ UserController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [ UserController::class, 'delete'])->name('delete');
    });

    Route::prefix('/categories')->name('categories.')->group(function () {
        Route::get('/create', [ CategoryController::class, 'createForm'])->name('form');
        Route::post('/store', [ CategoryController::class, 'store'])->name('store');
        Route::get('/index', [ CategoryController::class, 'index'])->name('index');
        Route::get('/list', [ CategoryController::class, 'getList'])->name('list');
        Route::get('/edit/{id}', [ CategoryController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [ CategoryController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [ CategoryController::class, 'delete'])->name('delete');
    });

    Route::prefix('/movies')->name('movies.')->group(function () {
        Route::get('/create', [ MovieController::class, 'createForm'])->name('form');
        Route::post('/store', [ MovieController::class, 'store'])->name('store');
        Route::get('/index', [ MovieController::class, 'index'])->name('index');
        Route::get('/list', [ MovieController::class, 'getDataTable'])->name('list');
        Route::get('/edit/{id}', [ MovieController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [ MovieController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [ MovieController::class, 'delete'])->name('delete');
    });
});

