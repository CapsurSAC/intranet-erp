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

        // Filtros
        if ($request->filled('desde') && $request->filled('hasta')) {
            $query->whereBetween('created_at', [$request->desde . ' 00:00:00', $request->hasta . ' 23:59:59']);
        }

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where('data->CLIENTE:', 'like', "%{$search}%")
                  ->orWhere('data->DNI:', 'like', "%{$search}%");
        }

        // Data para KPIs
        $totalVentas = $query->count();
        $ventasHoy = Venta::whereDate('created_at', today())->count();

        // Data para Gráficos y Ranking (Soluciona el error de la variable)
        $statsCursos = Venta::all()->pluck('data')->groupBy(function($item) {
            return $item['CURSO:'] ?? $item['NOMBRE DEL DIPLOMADO:'] ?? 'Varios';
        })->map->count()->sortDesc()->take(5);

        $ventasRecientes = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('dashboard', compact('totalVentas', 'ventasHoy', 'ventasRecientes', 'statsCursos'));
    }

    // Función para descargar el Excel
    public function exportar(Request $request)
    {
        $query = Venta::query();
        if ($request->filled('desde')) {
            $query->whereBetween('created_at', [$request->desde, $request->hasta]);
        }

        $ventas = $query->get();
        $csvFileName = 'reporte_capsur_' . date('Ymd_His') . '.csv';
        
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($ventas) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['FECHA', 'DNI', 'CLIENTE', 'CURSO', 'ASESOR']);

            foreach ($ventas as $v) {
                fputcsv($file, [
                    $v->created_at,
                    $v->data['DNI:'] ?? '',
                    $v->data['CLIENTE:'] ?? '',
                    $v->data['CURSO:'] ?? $v->data['NOMBRE DEL DIPLOMADO:'] ?? '',
                    $v->data['ASESOR:'] ?? ''
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}