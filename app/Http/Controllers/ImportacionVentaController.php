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
        $file = fopen($path, 'r');

        if (!$file) {
            return back()->withErrors('No se pudo abrir el archivo');
        }

        /* ===============================
         * 1️⃣ Detectar delimitador
         * =============================== */
        $firstLine = fgets($file);
        $delimiter = str_contains($firstLine, ';') ? ';' : ',';
        rewind($file);

        /* ===============================
         * 2️⃣ Leer cabecera correctamente
         * =============================== */
        $header = fgetcsv($file, 0, $delimiter);

        if (!$header) {
            return back()->withErrors('El archivo CSV está vacío');
        }

        $header = array_map(fn ($h) => strtolower(trim($h)), $header);

        /* ===============================
         * 3️⃣ Validar columnas obligatorias
         * =============================== */
        $required = ['dni', 'cliente', 'email', 'curso'];

        foreach ($required as $col) {
            if (!in_array($col, $header)) {
                return back()->withErrors("❌ Falta la columna obligatoria: $col");
            }
        }

        $map = array_flip($header);
        $inserted = 0;

        /* ===============================
         * 4️⃣ Procesar filas
         * =============================== */
        while (($row = fgetcsv($file, 0, $delimiter)) !== false) {

            // ignorar filas vacías
            if (count(array_filter($row)) === 0) {
                continue;
            }

            Venta::create([
                'dni'         => trim($row[$map['dni']] ?? ''),
                'cliente'     => trim($row[$map['cliente']] ?? ''),
                'email'       => trim($row[$map['email']] ?? ''),
                'curso'       => trim($row[$map['curso']] ?? ''),
                'asesor'      => isset($map['asesor'])
                                    ? trim($row[$map['asesor']] ?? '')
                                    : null,
                'fecha_venta' => now(),
            ]);

            $inserted++;
        }

        fclose($file);

        return back()->with('success', "✅ $inserted ventas importadas correctamente");
    }
}
