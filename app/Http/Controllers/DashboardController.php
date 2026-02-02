<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Total de ventas importadas
        $totalVentas = Venta::count();

        // 2. Ventas de hoy (basado en la fecha de importación)
        $ventasHoy = Venta::whereDate('created_at', today())->count();

        // 3. Obtener los productos más vendidos (extrayendo del JSON)
        // Nota: Esto es un ejemplo de cómo procesar la data JSON para estadísticas
        $ventasRecientes = Venta::orderBy('created_at', 'desc')->take(5)->get();

        return view('dashboard', compact('totalVentas', 'ventasHoy', 'ventasRecientes'));
    }
}