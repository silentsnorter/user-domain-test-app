<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [App\Http\Controllers\DomainController::class, 'dashboard'])->name('dashboard');
    Route::post('/domains', [App\Http\Controllers\DomainController::class, 'store'])->name('domains.store');
    Route::delete('/domain/{domain}', [App\Http\Controllers\DomainController::class, 'delete'])->name('domains.delete');

    Route::get('/plans', [App\Http\Controllers\PlanController::class, 'index'])->name('plans');
    Route::post('/plans/{plan}', [App\Http\Controllers\PlanController::class, 'buy'])->name('plans.buy');

    Route::group(['middleware' => 'admin'], function () {
        Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users');
    });
});

