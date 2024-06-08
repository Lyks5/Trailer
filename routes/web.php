<?php

use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'welcome'])->name('welcome');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/post/{post_id}', [App\Http\Controllers\HomeController::class, 'post'])->name('Post');
Route::get('/post/delete/{post_id}', [App\Http\Controllers\AdminController::class, 'delete_post'])->name('DeletePost')->middleware([IsAdmin::class]);
Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin')->middleware([IsAdmin::class]);
Route::post('/admin/new_poster', [App\Http\Controllers\AdminController::class, 'new_poster'])->name('NewPoster')->middleware([IsAdmin::class]);