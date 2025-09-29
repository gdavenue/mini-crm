<?php

use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\TicketStatisticsController;
use Illuminate\Support\Facades\Route;

Route::get('/tickets', [TicketController::class, 'index']);
Route::post('/tickets', [TicketController::class, 'store']);

Route::middleware(['auth:sanctum', 'role:admin|manager'])->group(function () {
	Route::get('/tickets/statistics', [TicketStatisticsController::class, 'index']);
});
