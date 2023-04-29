<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;

Route::prefix('/admin/users')->name('users.')->group(function () {
    Route::get('/create', [ UserController::class, 'createForm'])->name('form');
    Route::post('/store', [ UserController::class, 'create'])->name('create');
    Route::get('/index', [ UserController::class, 'index'])->name('index');
    Route::get('/list', [ UserController::class, 'getList'])->name('list');
    Route::get('/edit/{id}', [ UserController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [ UserController::class, 'update'])->name('update');
    Route::get('/delete/{id}', [ UserController::class, 'delete'])->name('delete');
});
