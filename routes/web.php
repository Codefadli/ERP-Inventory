<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('dashboard');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Example routes for forms - implement controllers as needed
Route::post('/register', function () {
    // TODO: Implement registration logic
    return back()->with('success', 'Registration submitted!');
})->name('register');

Route::post('/demo/schedule', function () {
    // TODO: Implement demo scheduling logic
    return back()->with('success', 'Demo scheduled successfully!');
})->name('demo.schedule');

Route::get('/contact', function () {
    // TODO: Create contact page
    return view('contact.index');
})->name('contact');
