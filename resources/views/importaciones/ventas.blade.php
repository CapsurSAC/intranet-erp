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
        <div
            class="xl:col-span-1 bg-white/80 backdrop-blur
                   rounded-2xl shadow-xl p-6
                   transition-all duration-300
                   hover:shadow-2xl hover:-translate-y-1"
        >
            <h2 class="text-lg font-semibold text-slate-700 mb-6 flex items-center gap-2">
                📁 Archivo CSV
            </h2>

            <form method="POST" enctype="multipart/form-data">
                @csrf

                <label class="block">
                    <span class="text-sm text-slate-600 mb-2 block">
                        Selecciona un archivo
                    </span>

                    <div
                        class="relative border-2 border-dashed border-slate-300
                               rounded-xl p-6 text-center
                               transition hover:border-blue-500 hover:bg-blue-50/40"
                    >
                        <input
                            id="csvInput"
                            type="file"
                            name="archivo"
                            accept=".csv"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                        >

                        <div class="text-slate-500">
                            <p class="font-medium">
                                Arrastra el archivo aquí
                            </p>
                            <p class="text-xs mt-1">
                                o haz clic para seleccionar
                            </p>
                        </div>
                    </div>
                </label>

                <button
                    type="submit"
                    class="mt-6 w-full bg-gradient-to-r
                           from-blue-600 to-indigo-600
                           hover:from-blue-700 hover:to-indigo-700
                           text-white font-semibold py-3 rounded-xl
                           shadow-lg hover:shadow-xl
                           transition-all duration-300"
                >
                    🚀 Importar ventas
                </button>
            </form>

            <div
                class="mt-6 text-xs rounded-xl p-4
                       bg-yellow-50 text-yellow-800
                       border border-yellow-200"
            >
                ⚠️ Este módulo es solo para **datos históricos**.
            </div>
        </div>

        {{-- CARD PREVIEW --}}
        <div
            class="xl:col-span-2 bg-white/80 backdrop-blur
                   rounded-2xl shadow-xl p-6
                   transition-all duration-300
                   hover:shadow-2xl"
        >
            <h2 class="text-lg font-semibold text-slate-700 mb-4 flex items-center gap-2">
                👀 Vista previa
            </h2>

            <div
                class="h-64 flex flex-col items-center justify-center
                       rounded-xl border border-slate-200
                       bg-slate-50 text-slate-400
                       animate-pulse"
            >
                <p class="font-medium">
                    Ningún archivo cargado
                </p>
                <p class="text-sm mt-1">
                    <div id="previewContainer"
                        class="hidden mt-6 overflow-x-auto">
                    </div>
                </p>
            </div>

            {{-- TABLA PREVIEW FUTURA --}}
            {{--
            <div class="mt-6 overflow-x-auto">
                <table class="min-w-full text-sm rounded-xl overflow-hidden">
                    <thead class="bg-slate-100 text-slate-600">
                        <tr>
                            <th class="px-4 py-2 text-left">DNI</th>
                            <th class="px-4 py-2 text-left">Cliente</th>
                            <th class="px-4 py-2 text-left">Curso</th>
                            <th class="px-4 py-2 text-left">Fecha</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        <tr class="border-t hover:bg-slate-50">
                            <td class="px-4 py-2">12345678</td>
                            <td class="px-4 py-2">Juan Pérez</td>
                            <td class="px-4 py-2">Excel Avanzado</td>
                            <td class="px-4 py-2">2023-08-10</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            --}}
        </div>

    </div>
</div>
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
        const bodyRows = rows.slice(1, 11); // max 10 filas

        let table = `
            <table class="min-w-full text-sm rounded-xl overflow-hidden shadow">
                <thead class="bg-slate-100 text-slate-700">
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

        const preview = document.getElementById('previewContainer');
        preview.innerHTML = table;
        preview.classList.remove('hidden');
    };

    reader.readAsText(file);
});
</script>


@endsection
