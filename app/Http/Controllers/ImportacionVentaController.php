<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use Illuminate\Support\Carbon;

class ImportacionVentaController extends Controller
{
    public function index()
    {
        return view('importaciones.ventas');
    }

    public function store(Request $request)
    {
        $request->validate([
            'archivo' => 'required|file|mimes:csv,txt'
        ]);

        $path = $request->file('archivo')->getRealPath();
        $file = fopen($path, 'r');

        // 1. Leer y limpiar encabezados (quitando BOM y espacios raros)
        $headers = fgetcsv($file);
        if (!$headers) {
            return back()->withErrors("El archivo está vacío o tiene un formato inválido.");
        }
        
        // Limpieza profunda de headers
        $headers = array_map(function($h) {
            return trim(mb_strtolower(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $h)));
        }, $headers);

        // 2. Mapeo flexible (buscamos coincidencias parciales)
        $map = [
            'dni'     => ['dni:', 'dni', 'documento'],
            'cliente' => ['cliente:', 'cliente', 'nombres'],
            'email'   => ['email:', 'correo', 'dirección de correo electrónico'],
            'asesor'  => ['asesor'],
            'curso'   => ['producto', 'nombre del diplomado', 'curso'],
            'celular' => ['celular:'],
        ];

        $indexes = [];
        foreach ($map as $campo => $aliases) {
            foreach ($headers as $idx => $header) {
                foreach ($aliases as $alias) {
                    if (str_contains($header, strtolower($alias))) {
                        $indexes[$campo] = $idx;
                        break 2;
                    }
                }
            }
        }

        // Validación de columnas críticas
        $columnasCriticas = ['cliente', 'curso']; // Bajamos la guardia con el DNI por si viene vacío
        foreach ($columnasCriticas as $critica) {
            if (!isset($indexes[$critica])) {
                return back()->withErrors("No se encontró la columna para: " . strtoupper($critica));
            }
        }

        $inserted = 0;

        // 3. Procesar filas
        while (($row = fgetcsv($file)) !== false) {
            // Si la fila está vacía o el nombre del cliente no existe, saltar
            $nombreCliente = isset($indexes['cliente']) ? trim($row[$indexes['cliente']]) : '';
            if (empty($nombreCliente)) continue;

            // Extraer DNI (si no existe, ponemos null o vacío en lugar de saltar la fila)
            $dniValue = isset($indexes['dni']) ? trim($row[$indexes['dni']]) : '';

            Venta::create([
                'dni'         => $dniValue,
                'cliente'     => $nombreCliente,
                'email'       => isset($indexes['email']) ? trim($row[$indexes['email']]) : null,
                'asesor'      => isset($indexes['asesor']) ? trim($row[$indexes['asesor']]) : 'Sin Asesor',
                'curso'       => isset($indexes['curso']) ? trim($row[$indexes['curso']]) : 'No especificado',
                'celular'     => isset($indexes['celular']) ? trim($row[$indexes['celular']]) : null,
                'fecha_venta' => now(), // O puedes intentar parsear 'Marca temporal' si lo necesitas
            ]);

            $inserted++;
        }

        fclose($file);

        return back()->with('success', "✅ $inserted ventas importadas correctamente");
    }
}