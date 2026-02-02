@extends('layouts.app')

@section('title', 'Importar ventas')

@section('content')
<div class="min-h-screen bg-slate-50 px-6 py-8">

    {{-- Header --}}
    <div class="max-w-7xl mx-auto mb-8 flex justify-between items-end">
        <div>
            <h1 class="text-3xl font-bold text-slate-800 tracking-tight">Importar ventas históricas</h1>
            <p class="text-slate-500 mt-1 text-lg">Centraliza la información de Google Forms al ERP.</p>
        </div>
        <div class="hidden md:block">
            <span class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm font-semibold border border-blue-200">
                Soporte: CSV / UTF-8
            </span>
        </div>
    </div>

    <div class="max-w-7xl mx-auto grid grid-cols-1 xl:grid-cols-3 gap-8">

        {{-- Panel Izquierdo: Carga --}}
        <div class="space-y-6">
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="bg-blue-600 p-2 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                    </div>
                    <h2 class="text-xl font-bold text-slate-800">Cargar Archivo</h2>
                </div>

                <form method="POST" action="/importaciones/ventas" enctype="multipart/form-data" id="importForm">
                    @csrf
                    <label class="group relative flex flex-col items-center justify-center w-full h-40 border-2 border-slate-300 border-dashed rounded-2xl cursor-pointer hover:bg-slate-50 hover:border-blue-400 transition-all">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <p class="mb-2 text-sm text-slate-500"><span class="font-semibold">Haz clic</span> o arrastra el CSV</p>
                            <p class="text-xs text-slate-400">Solo archivos .csv (Max. 10MB)</p>
                        </div>
                        <input id="csvInput" type="file" name="archivo" accept=".csv" required class="hidden" />
                    </label>

                    <div id="fileInfo" class="hidden mt-4 p-3 bg-blue-50 rounded-xl border border-blue-100 flex items-center space-x-3">
                        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"/></svg>
                        <span id="fileName" class="text-sm font-medium text-blue-800 truncate">archivo.csv</span>
                    </div>

                    <button type="submit" id="btnSubmit" class="mt-6 w-full bg-slate-900 hover:bg-black text-white py-4 rounded-2xl font-bold shadow-lg shadow-slate-200 transition-all flex items-center justify-center space-x-2">
                        <span>🚀 Iniciar Importación</span>
                    </button>
                </form>

                @if($errors->any())
                    <div class="mt-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-xl text-sm">
                        <p class="font-bold">Hubo un problema:</p>
                        <p>{{ $errors->first() }}</p>
                    </div>
                @endif
                
                @if(session('success'))
                    <div class="mt-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-xl text-sm">
                        {{ session('success') }}
                    </div>
                @endif
            </div>
            
            <div class="bg-amber-50 border border-amber-100 rounded-2xl p-5">
                <h4 class="text-amber-800 font-bold text-sm flex items-center mb-2">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                    Nota para el Ingeniero
                </h4>
                <p class="text-amber-700 text-xs leading-relaxed">
                    El sistema ahora detecta automáticamente todas las columnas. No es necesario renombrar el encabezado del Excel original.
                </p>
            </div>
        </div>

        {{-- Panel Derecho: Vista Previa --}}
        <div class="xl:col-span-2 space-y-6">
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8 min-h-[500px]">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-slate-800">Vista previa de datos</h2>
                    <span id="rowCount" class="hidden text-xs font-bold bg-slate-100 text-slate-500 px-3 py-1 rounded-lg uppercase"></span>
                </div>

                <div id="stateEmpty" class="flex flex-col items-center justify-center h-80 text-slate-400">
                    <svg class="w-16 h-16 mb-4 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <p class="text-lg">Selecciona un archivo para inspeccionar</p>
                </div>

                <div id="stateError" class="hidden bg-red-50 text-red-600 p-6 rounded-2xl border border-red-100 text-center font-medium"></div>

                <div id="previewWrapper" class="hidden overflow-hidden rounded-2xl border border-slate-100">
                    <div class="overflow-x-auto max-h-[450px]">
                        <div id="previewContainer"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
{{-- TABLA DE VENTAS HISTÓRICAS --}}
<div class="mt-12 bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex justify-between items-center">
        <h3 class="text-xl font-bold text-slate-800">Registros en Sistema</h3>
        <span class="text-xs font-bold bg-blue-50 text-blue-600 px-3 py-1 rounded-full">
            {{ $ventas->total() }} Ventas Totales
        </span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-50 text-slate-400 text-[10px] uppercase font-bold tracking-widest">
                <tr>
                    <th class="px-6 py-4">Cliente / Email</th>
                    <th class="px-6 py-4">DNI</th>
                    <th class="px-6 py-4">Producto / Diplomado</th>
                    <th class="px-6 py-4">Asesor</th>
                    <th class="px-6 py-4">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($ventas as $venta)
                <tr class="hover:bg-slate-50/50 transition-all">
                    <td class="px-6 py-4">
                        <div class="text-sm font-bold text-slate-700">{{ $venta->data['CLIENTE:'] ?? 'Sin Nombre' }}</div>
                        <div class="text-xs text-slate-400">{{ $venta->data['EMAIL:'] ?? $venta->data['Dirección de correo electrónico'] ?? '' }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm font-mono text-slate-500">
                        {{ $venta->data['DNI:'] ?? '---' }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-[11px] font-bold bg-slate-100 text-slate-600 px-2 py-1 rounded border border-slate-200">
                            {{ Str::limit($venta->data['NOMBRE DEL DIPLOMADO:'] ?? $venta->data['CURSO:'] ?? 'Venta General', 35) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600">
                        {{ $venta->data['ASESOR:'] ?? 'No asignado' }}
                    </td>
                    <td class="px-6 py-4">
                        <button class="text-blue-600 hover:text-blue-800 text-xs font-bold uppercase tracking-tighter">
                            Ver Detalle
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
        {{ $ventas->appends(request()->query())->links() }}
    </div>
</div>
<script>
// Elementos UI
const input = document.getElementById('csvInput');
const fileInfo = document.getElementById('fileInfo');
const fileName = document.getElementById('fileName');
const stateEmpty = document.getElementById('stateEmpty');
const stateError = document.getElementById('stateError');
const previewWrapper = document.getElementById('previewWrapper');
const previewContainer = document.getElementById('previewContainer');
const rowCount = document.getElementById('rowCount');

// Lógica de visualización de archivo
input.addEventListener('change', e => {
    const file = e.target.files[0];
    if (!file) return;

    fileName.textContent = file.name;
    fileInfo.classList.remove('hidden');
    stateEmpty.classList.add('hidden');
    stateError.classList.add('hidden');
    previewWrapper.classList.add('hidden');

    const reader = new FileReader();
    reader.onload = ev => {
        try {
            const text = ev.target.result;
            const rows = text.split(/\r?\n/).filter(r => r.trim() !== '');
            if (rows.length === 0) throw new Error("El archivo no tiene filas de datos.");

            const delimiter = rows[0].includes(';') ? ';' : ',';
            const headers = splitCSV(rows[0], delimiter);
            
            let tableHtml = `<table class="min-w-full divide-y divide-slate-200">
                                <thead class="bg-slate-800 text-white">
                                    <tr>`;
            headers.forEach(h => {
                tableHtml += `<th class="px-4 py-3 text-left text-[10px] font-bold uppercase tracking-wider whitespace-nowrap">${h}</th>`;
            });
            tableHtml += `</tr></thead><tbody class="bg-white divide-y divide-slate-100">`;

            // Mostramos solo 15 filas en la preview para no saturar el DOM
            rows.slice(1, 16).forEach(r => {
                const cols = splitCSV(r, delimiter);
                tableHtml += `<tr>`;
                headers.forEach((h, i) => {
                    const val = (cols[i] || '').replace(/^"|"$/g, '');
                    tableHtml += `<td class="px-4 py-3 text-sm text-slate-600 whitespace-nowrap truncate max-w-[200px]">${val}</td>`;
                });
                tableHtml += `</tr>`;
            });

            tableHtml += `</tbody></table>`;
            
            rowCount.textContent = `${rows.length - 1} Registros detectados`;
            rowCount.classList.remove('hidden');
            previewContainer.innerHTML = tableHtml;
            previewWrapper.classList.remove('hidden');

        } catch (err) {
            stateError.textContent = `❌ ${err.message}`;
            stateError.classList.remove('hidden');
        }
    };
    reader.readAsText(file, 'UTF-8');
});

// Tu función robusta original (Mantenida porque es excelente)
function splitCSV(line, delimiter) {
    const result = [];
    let curVal = "";
    let inQuotes = false;
    for (let i = 0; i < line.length; i++) {
        const char = line[i];
        if (char === '"') {
            inQuotes = !inQuotes;
        } else if (char === delimiter && !inQuotes) {
            result.push(curVal.trim());
            curVal = "";
        } else {
            curVal += char;
        }
    }
    result.push(curVal.trim());
    return result;
}

// Feedback al enviar
document.getElementById('importForm').onsubmit = () => {
    const btn = document.getElementById('btnSubmit');
    btn.innerHTML = `<svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> <span>Procesando...</span>`;
    btn.classList.add('opacity-75', 'cursor-not-allowed');
};
</script>
@endsection