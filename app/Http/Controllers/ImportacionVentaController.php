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

        $file = fopen($request->file('archivo')->getRealPath(), 'r');

        // Leer encabezados
        $headers = fgetcsv($file);

        // Normalizamos headers
        $headers = array_map(fn($h) => trim($h), $headers);

        // MAPEO REAL DEL CSV
        $map = [
            'dni'     => 'DNI:',
            'cliente' => 'CLIENTE:',
            'email'   => 'EMAIL:',
            'asesor'  => 'ASESOR(A)',
            'curso'   => 'PRODUCTO',
            'celular' => 'CELULAR:',
            'fecha'   => 'Marca temporal',
        ];

        // Validación de columnas obligatorias
        foreach ($map as $campo => $csvName) {
            if (!in_array($csvName, $headers)) {
                return back()->withErrors("Falta la columna obligatoria: {$csvName}");
            }
        }

        // Índices reales
        $indexes = [];
        foreach ($map as $campo => $csvName) {
            $indexes[$campo] = array_search($csvName, $headers);
        }

        $inserted = 0;

        while (($row = fgetcsv($file)) !== false) {

            // Evitar filas vacías
            if (empty($row[$indexes['dni']])) continue;

            Venta::create([
                'dni'         => trim($row[$indexes['dni']]),
                'cliente'     => trim($row[$indexes['cliente']]),
                'email'       => trim($row[$indexes['email']]),
                'asesor'      => trim($row[$indexes['asesor']]),
                'curso'       => trim($row[$indexes['curso']]),
                'celular'     => trim($row[$indexes['celular']] ?? ''),
                'fecha_venta' => now(),
            ]);

            $inserted++;
        }

        fclose($file);

        return back()->with('success', "✅ $inserted ventas importadas correctamente");
    }
}
