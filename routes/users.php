<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;

Route::prefix('/admin/users')->name('users.')->group(function () {
    Route::get('/create', [ UserController::class, 'createForm'])->middleware('sentinel.auth')->name('form');
    Route::post('/store', [ UserController::class, 'create'])->middleware('sentinel.auth')->name('create');
    Route::get('/index', [ UserController::class, 'index'])->middleware('sentinel.auth')->name('index');
    Route::get('/list', [ UserController::class, 'getList'])->middleware('sentinel.auth')->name('list');
    Route::get('/edit/{id}', [ UserController::class, 'edit'])->middleware('sentinel.auth')->name('edit');
    Route::put('/update/{id}', [ UserController::class, 'update'])->middleware('sentinel.auth')->name('update');
    Route::get('/delete/{id}', [ UserController::class, 'delete'])->middleware('sentinel.auth')->name('delete');
});
