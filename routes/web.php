<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return 'LOGIN (pendiente)';
});
use App\Http\Controllers\ImportacionVentaController;

Route::get('/importaciones/ventas', [ImportacionVentaController::class, 'index']);
Route::post('/importaciones/ventas', [ImportacionVentaController::class, 'store']);
use App\Http\Controllers\DashboardController; // <--- Asegúrate de que esta línea esté al inicio

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
