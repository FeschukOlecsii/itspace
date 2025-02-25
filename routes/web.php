<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/event', [EventController::class, 'index'])->name('event.index');
    Route::post('/event/addReminder', [EventController::class, 'addReminder'])->name('event.addReminder');
    Route::post('/event/addEvent', [EventController::class, 'addEvent'])->name('event.addEvent');
    Route::put('/event/updateReminder', [EventController::class, 'updateReminder'])->name('event.updateReminder');
    Route::put('/event/updateEvent', [EventController::class, 'updateEvent'])->name('event.updateEvent');
    Route::delete('/event/destroyReminder/{id}', [EventController::class, 'destroyReminder'])->name('event.destroyReminder');
    Route::delete('/event/destroyEvent/{id}', [EventController::class, 'destroyEvent'])->name('event.destroyEvent');
    Route::get('/setevents', [EventController::class, 'setEvents']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
