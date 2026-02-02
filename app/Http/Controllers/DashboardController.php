<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
  public function index(Request $request)
    {
        $query = Venta::query();

        // Filtro por rango de fechas (usando la fecha de importación)
        if ($request->filled('desde') && $request->filled('hasta')) {
            $query->whereBetween('created_at', [$request->desde, $request->hasta]);
        }

        $totalVentas = $query->count();
        $ventasHoy = Venta::whereDate('created_at', today())->count();
        
        // Obtener los 5 diplomados más vendidos (Lógica para JSON)
        // Extraemos la columna 'data', la decodificamos y agrupamos en PHP
        $ventasParaGrafico = Venta::all()->pluck('data');
        $productosTop = $ventasParaGrafico->groupBy(function($item) {
            return $item['CURSO:'] ?? $item['NOMBRE DEL DIPLOMADO:'] ?? 'Varios';
        })->map->count()->sortDesc()->take(5);

        $ventasRecientes = $query->orderBy('created_at', 'desc')->take(8)->get();

        return view('dashboard', compact('totalVentas', 'ventasHoy', 'ventasRecientes', 'productosTop'));
    }
}