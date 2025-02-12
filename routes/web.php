<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GoogleCalendarController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/auth/google', [GoogleCalendarController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleCalendarController::class, 'handleGoogleCallback'])->name('google.callback');

Route::get('/dashboard', [DashboardController::class, 'events'])->name('dashboard');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/events', [EventController::class, 'index']);
Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
Route::get('/events/{eventId}/edit', [EventController::class, 'edit'])->name('events.edit');
Route::put('/events/{eventId}/update', [EventController::class, 'update'])->name('events.update');

Route::get('/colors', [EventController::class, 'colors'])->name('colors');
