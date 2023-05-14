<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;

Route::prefix('/admin/categories')->name('categories.')->group(function () {
    Route::get('/create', [ CategoryController::class, 'createForm'])->middleware('sentinel.auth')->name('form');
    Route::post('/store', [ CategoryController::class, 'store'])->middleware('sentinel.auth')->name('store');
    Route::get('/index', [ CategoryController::class, 'index'])->middleware('sentinel.auth')->name('index');
    Route::get('/list', [ CategoryController::class, 'getList'])->middleware('sentinel.auth')->name('list');
    Route::get('/edit/{id}', [ CategoryController::class, 'edit'])->middleware('sentinel.auth')->name('edit');
    Route::put('/update/{id}', [ CategoryController::class, 'update'])->middleware('sentinel.auth')->name('update');
    Route::get('/delete/{id}', [ CategoryController::class, 'delete'])->middleware('sentinel.auth')->name('delete');
});
