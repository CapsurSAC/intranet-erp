<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;

class ImportacionVentaController extends Controller
{
    public function index(Request $request)
    {
    $query = Venta::query();

    // Filtro de búsqueda profesional dentro del JSON
    if ($request->filled('search')) {
        $search = $request->get('search');
        // Buscamos en las llaves que Google Forms suele poner en el CSV
        $query->where('data->DNI:', 'like', "%{$search}%")
              ->orWhere('data->CLIENTE:', 'like', "%{$search}%")
              ->orWhere('data->email', 'like', "%{$search}%");
    }

    $ventas = $query->orderBy('created_at', 'desc')->paginate(12);

    return view('importaciones.ventas', compact('ventas'));
    }
    public function store(Request $request) {
    $path = $request->file('archivo')->getRealPath();
    $rows = array_map('str_getcsv', file($path));
    $header = array_shift($rows);

    foreach ($rows as $row) {
        if (count($header) == count($row)) {
            $json = array_combine($header, $row);
            \App\Models\Venta::create(['data' => $json]); // Sube todo el CSV directo
        }
    }
    return back()->with('success', '¡Importación finalizada!');
    }   

}