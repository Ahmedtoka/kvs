<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CareerAdminController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LeadAdminController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\TrackController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public website
|--------------------------------------------------------------------------
*/

Route::view('/', 'home')->name('home');

// About
Route::view('/about', 'about')->name('about');
Route::view('/leadership', 'leadership')->name('leadership');
Route::view('/accreditations', 'accreditations')->name('accreditations');

// Academics
Route::view('/academics', 'academics')->name('academics');
Route::view('/academics/early-years', 'academics.early-years')->name('academics.early-years');
Route::view('/academics/primary', 'academics.primary')->name('academics.primary');
Route::view('/academics/secondary', 'academics.secondary')->name('academics.secondary');

// Admissions
Route::view('/admissions', 'admissions')->name('admissions');
Route::view('/book-a-tour', 'book-a-tour')->name('book-a-tour');
Route::view('/fees', 'fees')->name('fees');
Route::view('/faqs', 'faqs')->name('faqs');

// School Life
Route::view('/school-life', 'school-life')->name('school-life');
Route::view('/services', 'services')->name('services');

// Contact
Route::view('/contact', 'contact')->name('contact');
Route::view('/careers', 'careers')->name('careers');

// First-party analytics beacon (JS sendBeacon)
Route::post('/track', [TrackController::class, 'store'])->middleware('throttle:120,1')->name('track');

// Public form submissions (rate-limited)
Route::middleware('throttle:15,1')->group(function () {
    Route::post('/leads', [LeadController::class, 'store'])->name('leads.store');
    Route::post('/careers/apply', [LeadController::class, 'storeCareer'])->name('careers.store');
});

/*
|--------------------------------------------------------------------------
| Admin panel
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/admin/login', [AuthController::class, 'login'])->middleware('throttle:10,1')->name('admin.login.attempt');

Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/analytics', [AnalyticsController::class, 'index'])->middleware('role:media_buyer')->name('analytics');

    Route::get('/leads', [LeadAdminController::class, 'index'])->name('leads.index');
    Route::get('/leads/export', [LeadAdminController::class, 'export'])->name('leads.export');
    Route::patch('/leads/{lead}', [LeadAdminController::class, 'update'])->name('leads.update');
    Route::delete('/leads/{lead}', [LeadAdminController::class, 'destroy'])->name('leads.destroy');

    Route::get('/careers', [CareerAdminController::class, 'index'])->name('careers.index');
    Route::get('/careers/{application}/cv', [CareerAdminController::class, 'download'])->name('careers.download');
    Route::patch('/careers/{application}', [CareerAdminController::class, 'update'])->name('careers.update');
    Route::delete('/careers/{application}', [CareerAdminController::class, 'destroy'])->name('careers.destroy');

    Route::get('/password', [AuthController::class, 'showPassword'])->name('password.edit');
    Route::patch('/password', [AuthController::class, 'updatePassword'])->name('password.update');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
