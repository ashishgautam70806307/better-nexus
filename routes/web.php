<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\ContactEnquiryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HomeHeroController;
use App\Http\Controllers\Admin\PasswordController;
use App\Http\Controllers\Admin\WebsiteSettingController;
use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\BlogController as FrontendBlogController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ServiceController;
use App\Http\Middleware\EnsureUserIsAdmin;
use Illuminate\Support\Facades\Route;

// PUBLIC WEBSITE
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');

Route::get('/contact-us', [ContactController::class, 'index'])->name('contact-us');
Route::post('/contact-us', [ContactController::class, 'store'])->name('contact.store');

// Lowercase letters/numbers separated by hyphens. The final * is NOT escaped.
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{slug}', [ServiceController::class, 'show'])
    ->where('slug', '[a-z0-9]+(?:-[a-z0-9]+)*')
    ->name('services.show');

Route::get('/blogs', [FrontendBlogController::class, 'index'])->name('blogs.index');
Route::get('/blogs/{slug}', [FrontendBlogController::class, 'show'])
    ->name('blogs.show');

// OLD URL COMPATIBILITY: these methods redirect to the current blog URLs.
Route::get('/case-studies', [FrontendBlogController::class, 'legacyIndex'])
    ->name('legacy.case-studies.index');
Route::get('/case-studies/{slug}', [FrontendBlogController::class, 'legacyShow'])
    ->where('slug', '[a-z0-9]+(?:-[a-z0-9]+)*')
    ->name('legacy.case-studies.show');

// ADMIN SIGN-IN: no public registration endpoint.
Route::get('/admin/login', [AuthController::class, 'create'])->name('login');
Route::post('/admin/login', [AuthController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('admin.login.store');

// PROTECTED ADMIN WORKSPACE
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth:web', 'auth.session', EnsureUserIsAdmin::class])
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');

        // Keep the explicit data endpoint before the resource routes.
        Route::get('/blogs/data', [AdminBlogController::class, 'data'])
            ->name('blogs.data');
        Route::resource('blogs', AdminBlogController::class)->except(['show']);

        Route::resource('enquiries', ContactEnquiryController::class)
            ->only(['index', 'show', 'update', 'destroy']);

        Route::get('/hero-banners', [HomeHeroController::class, 'edit'])
            ->name('hero-banners.index');
        Route::put('/hero-banners', [HomeHeroController::class, 'update'])
            ->name('hero-banners.update');
        Route::put('/hero-images/{image}', [HomeHeroController::class, 'updateImage'])
            ->name('hero-images.update');
        Route::delete('/hero-images/{image}', [HomeHeroController::class, 'destroyImage'])
            ->name('hero-images.destroy');

        Route::get('/settings', [WebsiteSettingController::class, 'edit'])
            ->name('settings.edit');
        Route::put('/settings', [WebsiteSettingController::class, 'update'])
            ->name('settings.update');

        Route::get('/password', [PasswordController::class, 'edit'])
            ->name('password.edit');
        Route::put('/password', [PasswordController::class, 'update'])
            ->middleware('throttle:5,1')
            ->name('password.update');
    });
