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