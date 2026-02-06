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
Route::get('/exportar-ventas', [DashboardController::class, 'exportar'])->name('ventas.export');

// Rutas de Alumnos
use App\Http\Controllers\AlumnoController;
Route::get('/alumnos', [AlumnoController::class, 'index'])->name('alumnos.index');
Route::get('/alumnos/create', [AlumnoController::class, 'create'])->name('alumnos.create');
Route::post('/alumnos', [AlumnoController::class, 'store'])->name('alumnos.store');

// Rutas de Ventas (Manual)
use App\Http\Controllers\VentaController;
Route::get('/ventas/create', [VentaController::class, 'create'])->name('ventas.create');
Route::post('/ventas', [VentaController::class, 'store'])->name('ventas.store');