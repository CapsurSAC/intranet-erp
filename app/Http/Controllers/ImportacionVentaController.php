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
            $content = file_get_contents($path);
            
            // Limpiar basura invisible del archivo
            $content = str_replace("\xEF\xBB\xBF", '', $content);
            $rows = explode("\n", str_replace("\r", "", $content));
            $rows = array_filter(array_map('trim', $rows));

            // La primera fila son los nombres de las columnas del CSV
            $headers = str_getcsv(array_shift($rows)); 
            $inserted = 0;

            foreach ($rows as $line) {
                $values = str_getcsv($line);
                
                // Si la fila está mocha, la saltamos
                if (count($values) < count($headers) * 0.5) continue;

                // Creamos un array: ["Marca temporal" => "3/1/2026...", "DNI:" => "123..."]
                $datosFila = [];
                foreach ($headers as $i => $label) {
                    $datosFila[$label] = $values[$i] ?? null;
                }

                // Insertamos directo a la base de datos
                \App\Models\Venta::create([
                    'data' => $datosFila
                ]);

                $inserted++;
            }

            return back()->with('success', "✅ Se subieron $inserted filas con todas sus columnas originales.");

        } catch (\Exception $e) {
            return back()->withErrors("Error: " . $e->getMessage());
        }
    }

}