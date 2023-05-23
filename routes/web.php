<?php

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

//Route::get('/', function () {
//    return view('welcome');
//});
Route::get('/admin/login',[LoginController::class, 'login'])->name('admin.user.login');
Route::get('/admin/logout',[LoginController::class, 'logout'])->name('admin.user.logout');
Route::post('/admin/user/postLogin',[LoginController::class, 'postLogin'])->name('admin.user.post-login');

Route::prefix('/admin')->middleware('sentinel.auth')->name('admin.')->group(function () {
    Route::get('/dashboard',[DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('/user')->name('users.')->middleware('sentinel.auth')->group(function () {
        Route::get('/create', [ UserController::class, 'createForm'])->middleware('sentinel.auth')->name('form');
        Route::post('/store', [ UserController::class, 'create'])->middleware('sentinel.auth')->name('create');
        Route::get('/index', [ UserController::class, 'index'])->middleware('sentinel.auth')->name('index');
        Route::get('/list', [ UserController::class, 'getList'])->middleware('sentinel.auth')->name('list');
        Route::get('/edit/{id}', [ UserController::class, 'edit'])->middleware('sentinel.auth')->name('edit');
        Route::put('/update/{id}', [ UserController::class, 'update'])->middleware('sentinel.auth')->name('update');
        Route::get('/delete/{id}', [ UserController::class, 'delete'])->middleware('sentinel.auth')->name('delete');
    });

    Route::prefix('/admin/categories')->name('categories.')->group(function () {
        Route::get('/create', [ CategoryController::class, 'createForm'])->middleware('sentinel.auth')->name('form');
        Route::post('/store', [ CategoryController::class, 'store'])->middleware('sentinel.auth')->name('store');
        Route::get('/index', [ CategoryController::class, 'index'])->middleware('sentinel.auth')->name('index');
        Route::get('/list', [ CategoryController::class, 'getList'])->middleware('sentinel.auth')->name('list');
        Route::get('/edit/{id}', [ CategoryController::class, 'edit'])->middleware('sentinel.auth')->name('edit');
        Route::put('/update/{id}', [ CategoryController::class, 'update'])->middleware('sentinel.auth')->name('update');
        Route::get('/delete/{id}', [ CategoryController::class, 'delete'])->middleware('sentinel.auth')->name('delete');
    });

});

