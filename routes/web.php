<?php
use App\Http\Controllers\ExportController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\TrackPageViews;
use Illuminate\Support\Facades\Route;
use App\Models\Analytic;
use App\Http\Controllers\AdminController;
Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'welcome'])->middleware([TrackPageViews::class])->name('welcome');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware(['auth'])->name('home');
Route::get('/see/what', [App\Http\Controllers\HomeController::class, 'see'])->middleware([TrackPageViews::class])->name('see');
Route::get('/rating', [App\Http\Controllers\HomeController::class, 'rating'])->name('rating');

Route::get('/post/{post_id}', [App\Http\Controllers\HomeController::class, 'post'])->middleware(['auth'])->name('Post');
Route::post('/rate/{post_id}', [App\Http\Controllers\RatingController::class, 'store'])->middleware(['auth'])->name('rate');
Route::get('/post/{post_id}/ratings', [App\Http\Controllers\RatingController::class, 'show'])->name('post.ratings');

Route::get('/post/post/{post_id}/hide', [App\Http\Controllers\AdminController::class, 'hide'])->name('posthide')->middleware([IsAdmin::class]);
Route::get('/post/restore/{id}', [App\Http\Controllers\AdminController::class, 'restore'])->name('postrestore');
Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin')->middleware([IsAdmin::class]);
Route::post('/admin/new_poster', [App\Http\Controllers\AdminController::class, 'new_poster'])->name(name: 'NewPoster')->middleware([IsAdmin::class]);
Route::get('/new_poster', [App\Http\Controllers\AdminController::class, 'showForm'])->name('NewPosterForm');
Route::get('/stats', [App\Http\Controllers\AdminController::class, 'stat'])->name('stat')->middleware([IsAdmin::class]);
Route::get('/admin/edit_poster/{post_id}', [App\Http\Controllers\AdminController::class, 'edit_poster'])->name('editPosts')->middleware([IsAdmin::class]);
Route::post('/admin/save_edit/{poster_id}', [App\Http\Controllers\AdminController::class, 'save_edit'])->name('save_posts')->middleware([IsAdmin::class]);
Route::get('/users', [App\Http\Controllers\AdminController::class, 'users'])->name('users')->middleware([IsAdmin::class]);

Route::post('/search', [App\Http\Controllers\HomeController::class, 'search'])->name('Search');
Route::post('/video/{id}/newComment', [App\Http\Controllers\HomeController::class, 'new_comment'])->name('newComment');



Route::get('/users', [App\Http\Controllers\AdminController::class, 'users'])->middleware([IsAdmin::class])->name('users');
Route::get('/users/{id}/edit', [App\Http\Controllers\AdminController::class, 'editUser'])->middleware([IsAdmin::class])->name('users.edit');
Route::put('/users/{id}/toggle-block', [App\Http\Controllers\AdminController::class, 'toggleBlockUser'])->name('users.toggleBlock');
Route::get('/users/{id}/details', [App\Http\Controllers\AdminController::class, 'showUserDetails'])->middleware([IsAdmin::class])->name('users.details');

Route::get('/liked/add/{product_id}', [App\Http\Controllers\HomeController::class, 'add_liked'])->name('ToLike')->middleware(['auth', 'verified']);
Route::get('login/yandex', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'yandex'])->name('yandex');
Route::get('login/yandex/redirect', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'yandexRedirect'])->name('yandexRedirect');



Route::get('/export/word', [ExportController::class, 'exportWord'])->name('export.word');
Route::get('/export/excel', [ExportController::class, 'exportExcel'])->name('export.excel');