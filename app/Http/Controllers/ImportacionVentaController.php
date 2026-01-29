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

        $path = $request->file('archivo')->getRealPath();
        // Abrimos con codificación UTF-8 para evitar problemas con tildes de Tacna
        $file = fopen($path, 'r');

        // 1. Limpieza de Headers (BOM y caracteres invisibles)
        $headers = fgetcsv($file);
        $headers = array_map(function($h) {
            return trim(mb_strtolower(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $h)));
        }, $headers);

        // 2. Mapeo Flexible (Igual que el JS de la vista)
        $map = [
            'dni'     => ['dni:', 'dni', 'documento'],
            'cliente' => ['cliente:', 'cliente', 'nombres'],
            'email'   => ['email:', 'correo', 'dirección de correo electrónico'],
            'asesor'  => ['asesor'],
            'curso'   => ['producto', 'nombre del diplomado', 'curso', 'especialidad'],
            'celular' => ['celular:', 'telefono'],
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

        $inserted = 0;

        // 3. Procesar filas
        while (($row = fgetcsv($file)) !== false) {
            // Buscamos el nombre del cliente (obligatorio para importar)
            $nombreVal = isset($indexes['cliente']) ? trim($row[$indexes['cliente']]) : '';
            
            if (empty($nombreVal)) continue;

            // Insertamos usando los nombres de tu migración
            Venta::create([
                'dni'         => isset($indexes['dni']) ? trim($row[$indexes['dni']]) : null,
                'cliente'     => $nombreVal, 
                'email'       => isset($indexes['email']) ? trim($row[$indexes['email']]) : null,
                'asesor'      => isset($indexes['asesor']) ? trim($row[$indexes['asesor']]) : 'Sin Asesor',
                'curso'       => isset($indexes['curso']) ? trim($row[$indexes['curso']]) : 'Varios',
                'celular'     => isset($indexes['celular']) ? trim($row[$indexes['celular']]) : null,
                'fecha_venta' => now(),
            ]);

            $inserted++;
        }

        fclose($file);
        return back()->with('success', "✅ Se importaron $inserted ventas de Tacna con éxito.");
    }
}