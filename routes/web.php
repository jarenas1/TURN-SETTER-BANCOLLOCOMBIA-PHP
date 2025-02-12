<?php

use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CounterController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\SelectService;
use App\Http\Livewire\QueueScreen;
use App\Http\Livewire\CashierInterface;

// Rutas públicas
Route::get('/', function () {
    return redirect()->route('ticket.create');
});

// Vista tablet para generar tickets
Route::get('/ticket', SelectService::class)->name('ticket.create');

// Pantalla TV (pública)
Route::get('/queue-display', QueueScreen::class)->name('queue.display');

// Autenticación
Auth::routes();

// Rutas protegidas
Route::middleware(['auth'])->group(function () {
    // Cajeros
    Route::middleware([CheckRole::class . ':cashier'])->group(function () {
        Route::get('/cashier', CashierInterface::class)->name('cashier');
    });

    // Administradores
    // Route::middleware([CheckRole::class . ':admin'])->group(function () {
    //     Route::resource('services', ServiceController::class);
    //     Route::resource('counters', CounterController::class);
    //     Route::resource('users', UserController::class);
    // });
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
