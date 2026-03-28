<?php

use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InstagramItemController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');

Route::prefix('admin')->name('admin.')->group(function (): void {
    Route::middleware('guest')->group(function (): void {
        Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
    });

    Route::middleware('auth')->group(function (): void {
        Route::get('/', DashboardController::class)->name('dashboard');
        Route::post('/instagram-items/import', [InstagramItemController::class, 'import'])->name('instagram-items.import');
        Route::resource('posts', AdminPostController::class)->except(['show']);
        Route::resource('instagram-items', InstagramItemController::class)->except(['show']);
        Route::get('/settings', [SiteSettingController::class, 'edit'])->name('settings.edit');
        Route::put('/settings', [SiteSettingController::class, 'update'])->name('settings.update');
        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    });
});
