<?php

use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'welcome'])->name('welcome');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware(['auth'])->name('home');
Route::get('/see/what', [App\Http\Controllers\HomeController::class, 'see'])->name('see');
Route::get('/rating', [App\Http\Controllers\HomeController::class, 'rating'])->name('rating');

Route::get('/post/{post_id}', [App\Http\Controllers\HomeController::class, 'post'])->middleware(['auth'])->name('Post');


Route::get('/post/post/{post_id}/hide', [App\Http\Controllers\AdminController::class, 'hide'])->name('posthide')->middleware([IsAdmin::class]);
Route::get('/post/restore/{id}', [App\Http\Controllers\AdminController::class, 'restore'])->name('postrestore');
Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin')->middleware([IsAdmin::class]);
Route::post('/admin/new_poster', [App\Http\Controllers\AdminController::class, 'new_poster'])->name('NewPoster')->middleware([IsAdmin::class]);
Route::get('/admin/edit_poster/{post_id}', [App\Http\Controllers\AdminController::class, 'edit_poster'])->name('editPosts')->middleware([IsAdmin::class]);
Route::post('/admin/save_edit/{poster_id}', [App\Http\Controllers\AdminController::class, 'save_edit'])->name('save_posts')->middleware([IsAdmin::class]);


Route::post('/search', [App\Http\Controllers\HomeController::class, 'search'])->name('Search');
Route::post('/video/{id}/newComment', [App\Http\Controllers\HomeController::class, 'new_comment'])->name('newComment');


Route::get('/liked/add/{product_id}', [App\Http\Controllers\HomeController::class, 'add_liked'])->name('ToLike')->middleware(['auth', 'verified']);
Route::get('login/yandex', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'yandex'])->name('yandex');
Route::get('login/yandex/redirect', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'yandexRedirect'])->name('yandexRedirect');