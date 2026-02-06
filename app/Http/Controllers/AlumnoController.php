<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    public function index()
    {
        // Mock data for display
        $alumnos = collect([
            (object)['id' => 1, 'nombre' => 'Juan Perez', 'dni' => '12345678', 'email' => 'juan@example.com', 'telefono' => '999888777', 'curso' => 'Diplomado en Gestión Pública', 'estado' => 'Activo'],
            (object)['id' => 2, 'nombre' => 'Maria Gomez', 'dni' => '87654321', 'email' => 'maria@example.com', 'telefono' => '999111222', 'curso' => 'Curso de Excel Avanzado', 'estado' => 'Pendiente'],
            (object)['id' => 3, 'nombre' => 'Carlos Diaz', 'dni' => '11223344', 'email' => 'carlos@example.com', 'telefono' => '999333444', 'curso' => 'Diplomado en Recursos Humanos', 'estado' => 'Activo'],
            (object)['id' => 4, 'nombre' => 'Ana Torres', 'dni' => '55667788', 'email' => 'ana@example.com', 'telefono' => '999555666', 'curso' => 'Curso de Power BI', 'estado' => 'Inactivo'],
            (object)['id' => 5, 'nombre' => 'Luis Vega', 'dni' => '99887766', 'email' => 'luis@example.com', 'telefono' => '999777888', 'curso' => 'Diplomado en Gestión Pública', 'estado' => 'Activo'],
        ]);

        return view('alumnos.index', compact('alumnos'));
    }

    public function create()
    {
        return view('alumnos.create');
    }

    public function store(Request $request)
    {
        // Validate and store logic here
        return redirect()->route('alumnos.index')->with('success', 'Alumno registrado correctamente.');
    }
}
