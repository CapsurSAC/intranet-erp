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

            <button
                type="button"
                class="mt-6 w-full bg-gradient-to-r
                       from-blue-600 to-indigo-600
                       hover:from-blue-700 hover:to-indigo-700
                       text-white font-semibold py-3 rounded-xl
                       shadow-lg hover:shadow-xl
                       transition-all duration-300"
            >
                🚀 Importar ventas
            </button>

            <div class="mt-6 text-xs rounded-xl p-4
                        bg-yellow-50 text-yellow-800
                        border border-yellow-200">
                ⚠️ Este módulo es solo para datos históricos.
            </div>
        </div>

        {{-- CARD PREVIEW --}}
        <div class="xl:col-span-2 bg-white/80 backdrop-blur
                    rounded-2xl shadow-xl p-6
                    transition-all duration-300 hover:shadow-2xl">

            <h2 class="text-lg font-semibold text-slate-700 mb-4 flex items-center gap-2">
                👀 Vista previa
            </h2>

            {{-- ESTADO VACÍO --}}
            <div
                id="emptyState"
                class="h-64 flex flex-col items-center justify-center
                       rounded-xl border border-slate-200
                       bg-slate-50 text-slate-400"
            >
                <p class="font-medium">Ningún archivo cargado</p>
                <p class="text-sm mt-1">Selecciona un CSV para ver la vista previa</p>
            </div>

            {{-- PREVIEW REAL --}}
         <div
                id="previewContainer"
                class="hidden mt-6 rounded-xl
                    border border-slate-200 bg-white shadow
                    max-h-[420px] overflow-y-auto"
            >
            </div>

        </div>

    </div>
</div>

{{-- JS --}}
<script>
document.getElementById('csvInput').addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (!file) return;

    const reader = new FileReader();

    reader.onload = function (event) {
        const text = event.target.result;
        const rows = text.split('\n').filter(r => r.trim() !== '');

        if (rows.length === 0) return;

        const headers = rows[0].split(',');
        const bodyRows = rows.slice(1, 11);

        let table = `
            <table class="min-w-full text-sm rounded-xl overflow-hidden">
                <thead class="bg-slate-100 text-slate-700 sticky top-0 z-10">

                    <tr>
                        ${headers.map(h => `<th class="px-4 py-2 text-left">${h}</th>`).join('')}
                    </tr>
                </thead>
                <tbody class="bg-white">
        `;

        bodyRows.forEach(row => {
            const cols = row.split(',');
            table += `
                <tr class="border-t hover:bg-slate-50 transition">
                    ${cols.map(c => `<td class="px-4 py-2">${c}</td>`).join('')}
                </tr>
            `;
        });

        table += `</tbody></table>`;

        document.getElementById('previewContainer').innerHTML = table;
        document.getElementById('previewContainer').classList.remove('hidden');
        document.getElementById('emptyState').classList.add('hidden');
    };

    reader.readAsText(file);
});
</script>
@endsection
