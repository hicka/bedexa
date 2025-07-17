<?php

use App\Livewire\RoomCategoryManager;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');


    Route::get('/room-categories', RoomCategoryManager::class)->name('room-categories');
    Route::get('/rooms', \App\Livewire\RoomManager::class)->name('rooms');

    Route::get('/guests', \App\Livewire\GuestManager::class)->name('guests');

    Route::get('/bookings', App\Livewire\BookingManager::class)->name('bookings');


});

require __DIR__.'/auth.php';
