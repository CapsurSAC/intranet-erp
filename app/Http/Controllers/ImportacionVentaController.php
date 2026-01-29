<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;

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

        // 1. Leer el archivo y manejar el encoding para evitar caracteres invisibles
        $path = $request->file('archivo')->getRealPath();
        $content = file_get_contents($path);
        
        // Eliminar el BOM de UTF-8 si existe
        $content = str_replace("\xEF\xBB\xBF", '', $content);
        
        $rows = preg_split('/\r\n|\r|\n/', $content);
        $rows = array_filter($rows);

        // 2. Procesar encabezados con limpieza extrema
        $headers = str_getcsv(array_shift($rows), ",");
        $headers = array_map(function($h) {
            return trim(strtolower(preg_replace('/[^a-z0-9]/i', '', $h)));
        }, $headers);

        // 3. Mapeo ultra-simplificado para los headers limpios
        $targetHeaders = [
            'dni'     => ['dni', 'documento'],
            'cliente' => ['cliente', 'nombres'],
            'email'   => ['email', 'correo', 'direcciondecorreoelectronico'],
            'asesor'  => ['asesor'],
            'curso'   => ['producto', 'nombredeldiplomado', 'curso'],
            'celular' => ['celular', 'telefono'],
        ];

        $indexes = [];
        foreach ($targetHeaders as $campo => $aliases) {
            foreach ($headers as $idx => $header) {
                foreach ($aliases as $alias) {
                    if (str_contains($header, $alias)) {
                        $indexes[$campo] = $idx;
                        break 2;
                    }
                }
            }
        }

        $inserted = 0;

        // 4. Procesar filas
        foreach ($rows as $line) {
            $row = str_getcsv($line, ",");
            if (count($row) < 2) continue;

            // Extraer nombre con validación de seguridad
            $nombre = isset($indexes['cliente']) ? trim($row[$indexes['cliente']] ?? '') : '';
            
            // Si el mapeo falló, buscamos por posición (Plan B: la columna 4 suele ser Cliente)
            if (empty($nombre)) {
                $nombre = trim($row[3] ?? ''); 
            }

            if (empty($nombre)) continue;

            Venta::create([
                'dni'         => isset($indexes['dni']) ? substr(trim($row[$indexes['dni']] ?? ''), 0, 15) : null,
                'cliente'     => $nombre, 
                'email'       => isset($indexes['email']) ? trim($row[$indexes['email']] ?? '') : null,
                'asesor'      => isset($indexes['asesor']) ? trim($row[$indexes['asesor']] ?? '') : 'Sin Asesor',
                'curso'       => isset($indexes['curso']) ? trim($row[$indexes['curso']] ?? '') : 'Varios',
                'celular'     => isset($indexes['celular']) ? trim($row[$indexes['celular']] ?? '') : null,
                'fecha_venta' => now(),
            ]);

            $inserted++;
        }

        return back()->with('success', "✅ Se importaron $inserted ventas con éxito.");
    }

   
}