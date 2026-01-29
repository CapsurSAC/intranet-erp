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
    public function store(Request $request) {
    $path = $request->file('archivo')->getRealPath();
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    // Limpiar el encabezado de cualquier basura (BOM, comas raras)
    $headers = str_getcsv(array_shift($lines));
    $headers = array_map(fn($h) => preg_replace('/[^a-z0-9]/i', '_', trim($h)), $headers);

    foreach ($lines as $line) {
        $values = str_getcsv($line);
        if (count($values) < 1) continue;

        // Creamos el registro sin mapeos complicados
        \App\Models\Venta::create([
            'data' => array_combine($headers, array_pad($values, count($headers), ''))
        ]);
    }
    return back()->with('success', '¡POR FIN SUBIÓ!');
}

}