<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return 'LOGIN (pendiente)';
});
use App\Http\Controllers\ImportacionVentaController;

Route::middleware(['auth'])->group(function () {
    Route::get('/importaciones/ventas', [ImportacionVentaController::class, 'index']);
});
