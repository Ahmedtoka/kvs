<?php

use Illuminate\Support\Facades\Route;

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
