<?php

use App\Http\Controllers\Dashboard\TicketController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home');
Route::view('/feedback-widget', 'feedback-widget');

Route::middleware(['auth', 'role:admin|manager'])->prefix('dashboard')->name('dashboard.')->group(function () {
	Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
	Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
	Route::post('/tickets/{ticket}/status', [TicketController::class, 'updateStatus'])->name('tickets.updateStatus');
});

require __DIR__ . '/auth.php';
