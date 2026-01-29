@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 p-6">

    {{-- Título --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            📥 Importar ventas históricas
        </h1>
        <p class="text-sm text-gray-500 mt-1">
            Esta sección es solo para cargar ventas antiguas mediante archivos CSV.
            Las ventas nuevas se registran desde el sistema.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- FORMULARIO --}}
        <div class="lg:col-span-1 bg-white rounded-xl shadow p-6">
            <h2 class="text-lg font-semibold mb-4 text-gray-700">
                Archivo CSV
            </h2>

            <form method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-600 mb-1">
                        Seleccionar archivo
                    </label>

                    <input
                        type="file"
                        name="archivo"
                        accept=".csv"
                        class="block w-full text-sm text-gray-700
                               file:mr-4 file:py-2 file:px-4
                               file:rounded-lg file:border-0
                               file:text-sm file:font-semibold
                               file:bg-blue-50 file:text-blue-700
                               hover:file:bg-blue-100"
                    >
                </div>

                <div class="mt-6">
                    <button
                        type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700
                               text-white font-semibold py-2 px-4
                               rounded-lg transition"
                    >
                        ⬆️ Importar ventas
                    </button>
                </div>
            </form>

            <div class="mt-6 text-xs text-yellow-700 bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                ⚠️ Este proceso es solo para datos históricos.
            </div>
        </div>

        {{-- VISTA PREVIA --}}
        <div class="lg:col-span-2 bg-white rounded-xl shadow p-6">
            <h2 class="text-lg font-semibold mb-4 text-gray-700">
                👀 Vista previa
            </h2>

            <div class="border border-dashed border-gray-300 rounded-lg p-6 text-center text-gray-400">
                Aún no se ha cargado ningún archivo.
                <br>
                <span class="text-sm">
                    Aquí se mostrará una vista previa del CSV antes de guardar.
                </span>
            </div>

            {{-- Ejemplo futuro --}}
            {{--
            <table class="w-full mt-6 text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 text-left">DNI</th>
                        <th class="p-2 text-left">Cliente</th>
                        <th class="p-2 text-left">Curso</th>
                        <th class="p-2 text-left">Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-t">
                        <td class="p-2">12345678</td>
                        <td class="p-2">Juan Pérez</td>
                        <td class="p-2">Excel Avanzado</td>
                        <td class="p-2">2023-08-10</td>
                    </tr>
                </tbody>
            </table>
            --}}
        </div>

    </div>
</div>
@endsection
