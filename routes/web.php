<?php

use App\Livewire\RoomCategoryManager;
use App\Livewire\RoomType\Create;
use App\Livewire\RoomType\Index;
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

    Route::get('/room-types', Index::class)->name('room-types.index');
    Route::get('/room-types/create', Create::class)->name('room-types.create');
    Route::get('/room-types/{id}/edit', Create::class)->name('room-types.edit');

});

require __DIR__.'/auth.php';
