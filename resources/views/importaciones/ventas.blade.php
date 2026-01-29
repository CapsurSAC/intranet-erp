

@section('title', 'Importar ventas')
@section('page_title', 'Importar ventas históricas')

@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-100 to-slate-200 px-6 py-8">

    {{-- HEADER --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-800 tracking-tight">
            Importar ventas históricas
        </h1>
        <p class="text-slate-500 mt-2 max-w-2xl">
            Carga información antigua desde archivos CSV.  
            Las nuevas ventas se registran directamente desde el sistema.
        </p>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

        {{-- CARD IMPORT --}}
        <div class="xl:col-span-1 bg-white/80 backdrop-blur
                    rounded-2xl shadow-xl p-6
                    transition-all duration-300
                    hover:shadow-2xl hover:-translate-y-1">

            <h2 class="text-lg font-semibold text-slate-700 mb-6 flex items-center gap-2">
                📁 Archivo CSV
            </h2>

            <label class="block">
                <span class="text-sm text-slate-600 mb-2 block">
                    Selecciona un archivo
                </span>

                <div class="relative border-2 border-dashed border-slate-300
                            rounded-xl p-6 text-center
                            transition hover:border-blue-500 hover:bg-blue-50/40">

                    <input
                        id="csvInput"
                        type="file"
                        accept=".csv"
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                    >

                    <div class="text-slate-500">
                        <p class="font-medium">Arrastra el archivo aquí</p>
                        <p class="text-xs mt-1">o haz clic para seleccionar</p>
                    </div>
                </div>
            </label>

          <form method="POST" action="/importaciones/ventas" enctype="multipart/form-data">
                @csrf

                <input type="file" name="archivo" accept=".csv" required>

                <button type="submit"
                    class="mt-4 bg-blue-600 text-white px-6 py-2 rounded-xl">
                    Importar ventas
                </button>
            </form>

            @if(session('success'))
                <div class="mt-4 p-4 bg-green-100 text-green-800 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mt-4 p-4 bg-red-100 text-red-800 rounded-xl">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="mt-6 text-xs rounded-xl p-4
                        bg-yellow-50 text-yellow-800
                        border border-yellow-200">
                ⚠️ Este módulo es solo para datos históricos.
            </div>
        </div>

        {{-- CARD PREVIEW --}}
        <div class="xl:col-span-2 bg-white/80 backdrop-blur
            rounded-2xl shadow-xl p-6">

            <h2 class="text-lg font-semibold text-slate-700 mb-4 flex items-center gap-2">
                👀 Vista previa
            </h2>

            <!-- ESTADO VACÍO -->
            <div id="stateEmpty"
                class="h-64 flex flex-col items-center justify-center
                    rounded-xl border border-dashed border-slate-300
                    bg-slate-50 text-slate-400 transition">
                <p class="font-medium">Ningún archivo cargado</p>
                <p class="text-sm mt-1">Selecciona un CSV para ver la vista previa</p>
            </div>

            <!-- ESTADO CARGANDO -->
            <div id="stateLoading"
                class="hidden h-64 flex flex-col items-center justify-center
                    rounded-xl border border-slate-200 bg-white">
                <div class="animate-spin h-10 w-10 rounded-full
                            border-4 border-blue-500 border-t-transparent"></div>
                <p class="mt-4 text-sm text-slate-500">Leyendo archivo...</p>
            </div>

            <!-- CONTENEDOR PREVIEW -->
            <div id="previewWrapper"
                class="hidden mt-4 max-h-[420px] overflow-y-auto
                    rounded-xl border border-slate-200
                    bg-white shadow-inner
                    transition-all duration-500 ease-out">
                <div id="previewContainer"></div>
            </div>

            <!-- ESTADO ERROR -->
            <div id="stateError"
                class="hidden mt-4 rounded-xl border border-red-200
                    bg-red-50 text-red-700 p-4 text-sm">
                ❌ Error al leer el archivo. Verifica el formato CSV.
            </div>
        </div>


    </div>
</div>

{{-- JS --}}
<script>
const input = document.getElementById('csvInput');

const stateEmpty = document.getElementById('stateEmpty');
const stateLoading = document.getElementById('stateLoading');
const stateError = document.getElementById('stateError');
const previewWrapper = document.getElementById('previewWrapper');
const previewContainer = document.getElementById('previewContainer');

input.addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (!file) return;

    // RESET
    stateEmpty.classList.add('hidden');
    stateError.classList.add('hidden');
    previewWrapper.classList.add('hidden');
    stateLoading.classList.remove('hidden');

    const reader = new FileReader();

    reader.onload = function (event) {
        try {
            const text = event.target.result;
            const rows = text.split('\n').filter(r => r.trim() !== '');

            if (rows.length < 2) throw new Error('CSV vacío');

            const headers = rows[0].split(',');
            const bodyRows = rows.slice(1, 21); // máx 20 filas

            let table = `
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-100 sticky top-0 z-10">
                        <tr>
                            ${headers.map(h => `
                                <th class="px-4 py-3 text-left font-semibold text-slate-700">
                                    ${h}
                                </th>`).join('')}
                        </tr>
                    </thead>
                    <tbody class="bg-white">
            `;

            bodyRows.forEach(row => {
                const cols = row.split(',');
                table += `
                    <tr class="border-t hover:bg-slate-50 transition">
                        ${cols.map(c => `
                            <td class="px-4 py-2 text-slate-600">
                                ${c}
                            </td>`).join('')}
                    </tr>
                `;
            });

            table += `</tbody></table>`;

            previewContainer.innerHTML = table;

            // TRANSICIÓN SUAVE
            stateLoading.classList.add('hidden');
            previewWrapper.classList.remove('hidden');
            previewWrapper.classList.add('animate-fade-in');

        } catch (err) {
            stateLoading.classList.add('hidden');
            stateError.classList.remove('hidden');
        }
    };

    reader.readAsText(file);
});
</script>

@endsection
