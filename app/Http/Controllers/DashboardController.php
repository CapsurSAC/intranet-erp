<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Venta::query();

        // 1. Filtro por fecha (opcional por ahora)
        if ($request->filled('desde') && $request->filled('hasta')) {
            $query->whereBetween('created_at', [$request->desde, $request->hasta]);
        }

        // 2. Cálculos básicos
        $totalVentas = $query->count();
        $ventasHoy = Venta::whereDate('created_at', today())->count();

        // 3. ESTA ES LA VARIABLE QUE TE FALTA ($statsCursos)
        // Extraemos la data, agrupamos por curso y contamos
        $statsCursos = Venta::all()->pluck('data')->groupBy(function($item) {
            return $item['CURSO:'] ?? $item['NOMBRE DEL DIPLOMADO:'] ?? 'Varios';
        })->map->count()->sortDesc()->take(5);

        // 4. Ventas recientes para la tabla
        $ventasRecientes = $query->orderBy('created_at', 'desc')->take(10)->get();

        // 5. Enviamos TODO a la vista
        return view('dashboard', compact('totalVentas', 'ventasHoy', 'ventasRecientes', 'statsCursos'));
    }
}