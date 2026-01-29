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
        $request->validate(['archivo' => 'required|file']);

        try {
            $path = $request->file('archivo')->getRealPath();
            
            // 1. CARGA SEGURA: Usamos file() con flags para omitir líneas vacías
            // y detectar finales de línea de forma automática.
            $rows = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            
            if (count($rows) < 2) return back()->withErrors("El archivo está vacío.");

            // 2. LIMPIEZA DE HEADERS: Quitamos el BOM y caracteres no deseados
            $headerLine = array_shift($rows);
            $headerLine = str_replace("\xEF\xBB\xBF", '', $headerLine);
            $headers = str_getcsv($headerLine);
            
            $headers = array_map(function($h) {
                return trim(strtolower(preg_replace('/[^a-z0-9]/i', '', $h)));
            }, $headers);

            // 3. MAPEO DINÁMICO (El que ya sabemos que funciona para Capsur)
            $map = [
                'dni'     => ['dni', 'documento'],
                'cliente' => ['cliente', 'nombres'],
                'email'   => ['email', 'correo', 'direcciondecorreoelectronico'],
                'asesor'  => ['asesor'],
                'curso'   => ['producto', 'nombredeldiplomado', 'curso'],
                'celular' => ['celular', 'telefono'],
            ];

            $indexes = [];
            foreach ($map as $campo => $aliases) {
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

            // 4. PROCESAMIENTO SIN WARNINGS
            foreach ($rows as $line) {
                // str_getcsv maneja automáticamente las comillas de Google Forms
                $row = str_getcsv($line);
                
                // Verificamos que al menos tengamos el índice del cliente
                if (!isset($indexes['cliente'])) continue;

                $nombre = trim($row[$indexes['cliente']] ?? '');
                
                // Si no hay nombre, saltamos sin lanzar error
                if (empty($nombre)) continue;

                // Creamos el registro protegiendo cada campo con ?? null
                Venta::create([
                    'dni'         => isset($indexes['dni']) ? trim($row[$indexes['dni']] ?? '') : null,
                    'cliente'     => $nombre,
                    'email'       => isset($indexes['email']) ? trim($row[$indexes['email']] ?? '') : null,
                    'asesor'      => isset($indexes['asesor']) ? trim($row[$indexes['asesor']] ?? '') : 'Sin Asesor',
                    'curso'       => isset($indexes['curso']) ? trim($row[$indexes['curso']] ?? '') : 'Varios',
                    'celular'     => isset($indexes['celular']) ? trim($row[$indexes['celular']] ?? '') : null,
                    'fecha_venta' => now(),
                ]);

                $inserted++;
            }

            return back()->with('success', "✅ Éxito: $inserted ventas importadas sin errores.");

        } catch (\Exception $e) {
            \Log::error("Error en importación Tacna: " . $e->getMessage());
            return back()->withErrors("Error técnico: " . $e->getMessage());
        }
    }
   
}