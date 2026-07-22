<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CareerAdminController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventAdminController;
use App\Http\Controllers\Admin\LeadAdminController;
use App\Http\Controllers\Admin\MaintenanceController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\TrackController;
use App\Http\Controllers\ThankYouController;
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

// Post-submission Thank-You / conversion page
Route::get('/thank-you/{type?}', [ThankYouController::class, 'show'])->name('thank-you');

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
    Route::get('/analytics/live', [AnalyticsController::class, 'live'])->middleware('role:media_buyer')->name('analytics.live');
    Route::get('/flow', [AnalyticsController::class, 'flow'])->middleware('role:media_buyer')->name('flow');
    Route::get('/visitors', [AnalyticsController::class, 'visitors'])->middleware('role:media_buyer')->name('visitors');
    Route::get('/visitors/{visitor}', [AnalyticsController::class, 'visitorShow'])->middleware('role:media_buyer')->name('visitors.show');

    Route::get('/reports', [ReportController::class, 'index'])->middleware('role:media_buyer')->name('reports');

    Route::get('/settings', [SettingController::class, 'index'])->middleware('role:content_editor')->name('settings');
    Route::patch('/settings', [SettingController::class, 'update'])->middleware('role:content_editor')->name('settings.update');

    Route::middleware('role:content_editor')->group(function () {
        Route::get('/events', [EventAdminController::class, 'index'])->name('events.index');
        Route::post('/events', [EventAdminController::class, 'store'])->name('events.store');
        Route::patch('/events/{event}', [EventAdminController::class, 'update'])->name('events.update');
        Route::delete('/events/{event}', [EventAdminController::class, 'destroy'])->name('events.destroy');
    });

    Route::middleware('role:content_editor')->group(function () {
        Route::get('/content', [ContentController::class, 'hub'])->name('content.hub');
        Route::get('/content/{group}', [ContentController::class, 'group'])->whereIn('group', ['faq', 'service'])->name('content.group');
        Route::post('/content/{group}', [ContentController::class, 'store'])->whereIn('group', ['faq', 'service'])->name('content.store');
        Route::patch('/content/item/{item}', [ContentController::class, 'update'])->name('content.update');
        Route::delete('/content/item/{item}', [ContentController::class, 'destroy'])->name('content.destroy');
    });

    Route::middleware('role:super_admin')->group(function () {
        Route::get('/users', [UserAdminController::class, 'index'])->name('users.index');
        Route::post('/users', [UserAdminController::class, 'store'])->name('users.store');
        Route::patch('/users/{user}', [UserAdminController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserAdminController::class, 'destroy'])->name('users.destroy');

        Route::get('/reset', [MaintenanceController::class, 'index'])->name('reset');
        Route::post('/reset', [MaintenanceController::class, 'reset'])->name('reset.perform');
    });

    Route::middleware('role:sales_agent,media_buyer')->group(function () {
        Route::get('/leads', [LeadAdminController::class, 'index'])->name('leads.index');
        Route::get('/leads/export', [LeadAdminController::class, 'export'])->name('leads.export');
        Route::get('/leads/agenda', [LeadAdminController::class, 'agenda'])->name('leads.agenda');
        Route::patch('/leads/{lead}', [LeadAdminController::class, 'update'])->name('leads.update');
        Route::delete('/leads/{lead}', [LeadAdminController::class, 'destroy'])->name('leads.destroy');
    });

    Route::middleware('role:super_admin')->group(function () {
        Route::get('/careers', [CareerAdminController::class, 'index'])->name('careers.index');
        Route::get('/careers/{application}/cv', [CareerAdminController::class, 'download'])->name('careers.download');
        Route::patch('/careers/{application}', [CareerAdminController::class, 'update'])->name('careers.update');
        Route::delete('/careers/{application}', [CareerAdminController::class, 'destroy'])->name('careers.destroy');
    });

    Route::get('/password', [AuthController::class, 'showPassword'])->name('password.edit');
    Route::patch('/password', [AuthController::class, 'updatePassword'])->name('password.update');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
