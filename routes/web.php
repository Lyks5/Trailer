<?php

use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/welcome', [App\Http\Controllers\HomeController::class, 'welcome'])->name('welcome');
Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin')->Middleware([IsAdmin::class]);
Route::post('/admin/new_poster', [App\Http\Controllers\AdminController::class, 'new_poster'])->name('NewPoster')->Middleware([IsAdmin::class]);