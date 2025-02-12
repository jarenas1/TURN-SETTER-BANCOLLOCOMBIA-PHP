<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CounterController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\CashierController;
use App\Http\Livewire\SelectService;
use App\Http\Livewire\QueueScreen;
use Illuminate\Support\Facades\Auth;

// Rutas públicas
Route::redirect('/', '/ticket');
Route::get('/ticket', SelectService::class)->name('ticket.create');
Route::get('/queue-display', QueueScreen::class)->name('queue.display');

Auth::routes();

// Rutas protegidas
Route::middleware(['auth'])->group(function () {
    
    // Ruta común después del login
    Route::get('/home', function () {
        return Auth::user()->role->value === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('cashier.dashboard');
    })->name('home');

    // Administración
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        Route::resource('users', UserController::class)->except(['show']);
        Route::resource('counters', CounterController::class);
        Route::resource('services', ServiceController::class);
        
        // Opcional: Gestión de tickets históricos
        Route::get('tickets', [TicketController::class, 'index'])
            ->name('admin.tickets.index');
    });

    // Cajeros
    Route::middleware('role:cashier')->group(function () {
        Route::get('/cashier/dashboard', [CashierController::class, 'dashboard'])
            ->name('cashier.dashboard');
            
        Route::post('/cashier/next-ticket', [CashierController::class, 'nextTicket'])
            ->name('cashier.next-ticket');
            
        Route::post('/cashier/complete-ticket', [CashierController::class, 'completeTicket'])
            ->name('cashier.complete-ticket');
    });
});