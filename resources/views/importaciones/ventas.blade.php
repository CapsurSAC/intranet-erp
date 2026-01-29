@extends('layouts.app')

@section('title', 'Importar ventas')
@section('header', 'Importar ventas históricas')

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-xl">
    <p class="text-gray-600 mb-4">
        Sube archivos CSV con ventas antiguas del sistema.
    </p>

    <form method="POST" action="/importaciones/ventas/preview" enctype="multipart/form-data">
        @csrf

        <input type="file" name="csv" accept=".csv" required
            class="block w-full mb-4 text-sm">

        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Cargar archivo
        </button>
    </form>
</div>
@endsection

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Importar ventas históricas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">
            📥 Importar ventas históricas
        </h1>

        <p class="text-sm text-gray-600 mb-6">
            Esta opción es solo para cargar ventas antiguas desde archivos CSV.
        </p>

        <form method="POST" action="/importaciones/ventas/preview" enctype="multipart/form-data">
            @csrf

            <label class="block mb-2 text-sm font-medium text-gray-700">
                Archivo CSV
            </label>

            <input 
                type="file" 
                name="csv" 
                accept=".csv"
                required
                class="block w-full text-sm text-gray-700 
                       file:mr-4 file:py-2 file:px-4
                       file:rounded-md file:border-0
                       file:bg-blue-50 file:text-blue-700
                       hover:file:bg-blue-100 mb-6"
            >

            <button 
                type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md transition"
            >
                📤 Cargar archivo
            </button>
        </form>

        <div class="mt-6 text-xs text-gray-500">
            ⚠️ Las ventas nuevas se registrarán desde la interfaz del sistema.
        </div>
    </div>

</body>
</html>
