<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;

class VentaController extends Controller
{
    public function create()
    {
        // Lista mock de asesores (en el futuro vendría de DB)
        $asesores = ['Carlos Rodríguez', 'Ana María Torres', 'Luis Vega', 'Sofia Martínez', 'Jorge Quispe'];
        
        // Lista mock de cursos/diplomados
        $productos = [
            'Diplomado en Gestión Pública',
            'Diplomado en Recursos Humanos',
            'Diplomado en Seguridad y Salud',
            'Curso de Excel Avanzado',
            'Curso de Power BI'
        ];

        return view('ventas.create', compact('asesores', 'productos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'asesor' => 'required',
            'fecha' => 'required|date',
            'cliente' => 'required|string',
            'dni' => 'required|string',
            'celular' => 'required|string',
            'email' => 'nullable|email',
            'producto' => 'required',
            'monto' => 'required|numeric',
            'metodo_pago' => 'required'
        ]);

        // Estructuramos los datos para guardarlos en la columna JSON 'data'
        // Usamos las mismas claves que la importación (CSV) para mantener consistencia si es posible,
        // o creamos un estándar nuevo. Aquí usaré claves legibles.
        $data = [
            'ASESOR:' => $request->asesor,
            'FECHA:' => $request->fecha,
            'CLIENTE:' => $request->cliente,
            'DNI:' => $request->dni,
            'CELULAR:' => $request->celular,
            'EMAIL:' => $request->email,
            'CURSO:' => $request->producto,
            'MONTO:' => $request->monto,
            'MEDIO DE PAGO:' => $request->metodo_pago,
            'OBSERVACIONES:' => $request->observaciones
        ];

        Venta::create(['data' => $data]);

        return redirect()->route('dashboard')->with('success', 'Venta registrada correctamente.');
    }
}
