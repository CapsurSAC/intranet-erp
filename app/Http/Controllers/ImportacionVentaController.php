<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImportacionVentaController extends Controller
{
    public function index()
    {
        return view('importaciones.ventas');
    }

    public function preview(Request $request)
    {
        $request->validate([
            'csv' => 'required|file|mimes:csv,txt'
        ]);

        $path = $request->file('csv')->store('imports');

        $file = storage_path('app/' . $path);
        $handle = fopen($file, 'r');

        $headers = fgetcsv($handle);
        $rows = [];

        for ($i = 0; $i < 10 && ($row = fgetcsv($handle)) !== false; $i++) {
            $rows[] = $row;
        }

        fclose($handle);

        return view('importaciones.preview', compact('headers', 'rows', 'path'));
    }
}
