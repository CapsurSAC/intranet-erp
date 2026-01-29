<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use Illuminate\Support\Facades\Validator;

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

        $header = fgetcsv($file);
        $header = array_map('strtolower', $header);

        // columnas mínimas obligatorias
        $required = ['dni', 'cliente', 'email', 'curso'];

        foreach ($required as $col) {
            if (!in_array($col, $header)) {
                return back()->withErrors("Falta la columna obligatoria: $col");
            }
        }

        $map = array_flip($header);
        $inserted = 0;

        while (($row = fgetcsv($file)) !== false) {
            Venta::create([
                'dni'          => $row[$map['dni']] ?? null,
                'cliente'      => $row[$map['cliente']] ?? null,
                'email'        => $row[$map['email']] ?? null,
                'curso'        => $row[$map['curso']] ?? null,
                'asesor'       => $row[$map['asesor']] ?? null,
                'fecha_venta'  => now(),
            ]);
            $inserted++;
        }

        fclose($file);

        return back()->with('success', "✅ $inserted ventas importadas correctamente");
    }
}
