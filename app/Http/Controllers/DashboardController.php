<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Venta::query();

        // Filtro por Rango de Fechas
        if ($request->filled('desde') && $request->filled('hasta')) {
            $query->whereBetween('created_at', [$request->desde . ' 00:00:00', $request->hasta . ' 23:59:59']);
        }

        // Filtro de Búsqueda para la Tabla (DNI o Nombre en JSON)
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('data->DNI:', 'like', "%{$search}%")
                  ->orWhere('data->CLIENTE:', 'like', "%{$search}%")
                  ->orWhere('data->ASESOR:', 'like', "%{$search}%");
            });
        }

        // Estadísticas para las Cards
        $totalVentas = $query->count();
        $ventasHoy = Venta::whereDate('created_at', today())->count();

        // Ranking de Diplomados (Extraído del JSON)
        $statsCursos = Venta::all()->pluck('data')->groupBy(function($item) {
            return $item['CURSO:'] ?? $item['NOMBRE DEL DIPLOMADO:'] ?? 'Varios';
        })->map->count()->sortDesc()->take(5);

        // Data para la Tabla con Paginación
        $ventasRecientes = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('dashboard', compact('totalVentas', 'ventasHoy', 'ventasRecientes', 'statsCursos'));
    }
}