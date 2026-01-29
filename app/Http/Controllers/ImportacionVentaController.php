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
        
        // 1. Limpieza de caracteres invisibles al leer el archivo
        $content = file_get_contents($path);
        $content = str_replace("\xEF\xBB\xBF", '', $content); // Quita el BOM de Excel
        
        $lines = explode("\n", str_replace("\r", "", $content));
        $lines = array_filter(array_map('trim', $lines)); // Quita líneas vacías

        if (count($lines) < 2) return back()->withErrors("El archivo no tiene datos.");

        // 2. Procesar encabezados de forma segura
        $headersRaw = str_getcsv(array_shift($lines), ",");
        $headers = array_map(function($h) {
            return preg_replace('/[^a-z0-9]/', '', strtolower($h));
        }, $headersRaw);

        // 3. Mapeo de columnas (Ajustado a tus nombres reales)
        $map = [
            'dni'     => ['dni'],
            'cliente' => ['cliente'],
            'email'   => ['email', 'correo'],
            'asesor'  => ['asesor'],
            'curso'   => ['producto', 'diplomado', 'curso'],
            'celular' => ['celular', 'telefono'],
        ];

        $idx = [];
        foreach ($map as $campo => $aliases) {
            foreach ($headers as $i => $h) {
                foreach ($aliases as $alias) {
                    if (str_contains($h, $alias)) {
                        $idx[$campo] = $i;
                        break 2;
                    }
                }
            }
        }

        // Si no detectó la columna cliente por nombre, usamos la posición 3 (Ventas Tacna)
        if (!isset($idx['cliente'])) $idx['cliente'] = 3;

        $inserted = 0;

        // 4. Bucle Blindado: Aquí es donde matamos los Warnings
        foreach ($lines as $line) {
            $row = str_getcsv($line, ",");
            
            // VERIFICACIÓN CLAVE: Si la fila no tiene la columna esperada, saltar sin avisar
            if (!isset($row[$idx['cliente']])) continue;

            $nombre = trim($row[$idx['cliente']]);
            if (empty($nombre)) continue;

            // Usamos el operador ?? para asegurar que si falta un dato, mande NULL y no un Warning
            Venta::create([
                'dni'         => isset($idx['dni']) ? substr(trim($row[$idx['dni']] ?? ''), 0, 15) : null,
                'cliente'     => mb_convert_encoding($nombre, 'UTF-8', 'UTF-8'),
                'email'       => isset($idx['email']) ? trim($row[$idx['email']] ?? '') : null,
                'asesor'      => isset($idx['asesor']) ? trim($row[$idx['asesor']] ?? '') : 'Sin Asesor',
                'curso'       => isset($idx['curso']) ? trim($row[$idx['curso']] ?? '') : 'Varios',
                'celular'     => isset($idx['celular']) ? trim($row[$idx['celular']] ?? '') : null,
                'fecha_venta' => now(),
            ]);

            $inserted++;
        }

        return back()->with('success', "✅ Se importaron $inserted ventas correctamente.");

    } catch (\Exception $e) {
        \Log::error("Error Fatal: " . $e->getMessage());
        return back()->withErrors("Error en el archivo: No se pudo procesar la línea.");
    }
}
}