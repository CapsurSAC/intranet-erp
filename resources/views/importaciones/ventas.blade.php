@extends('layouts.app')

@section('title', 'Importar ventas')
@section('page_title', 'Importar ventas históricas')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-100 to-slate-200 px-6 py-8">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-800">Importar ventas históricas</h1>
        <p class="text-slate-500 mt-2">
            Carga información antigua desde archivos CSV (Google Forms).
        </p>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

        {{-- CARGA --}}
        <div class="bg-white rounded-2xl shadow-xl p-6">
            <h2 class="text-lg font-semibold mb-4">📁 Archivo CSV</h2>

            <form method="POST" action="/importaciones/ventas" enctype="multipart/form-data">
                @csrf

                <input
                    id="csvInput"
                    type="file"
                    name="archivo"
                    accept=".csv"
                    required
                    class="w-full border border-dashed rounded-xl p-6 cursor-pointer"
                >

                <button class="mt-6 w-full bg-blue-600 hover:bg-blue-700
                               text-white py-3 rounded-xl font-semibold">
                    🚀 Importar ventas
                </button>
            </form>

            @if($errors->any())
                <div class="mt-4 bg-red-100 text-red-800 p-3 rounded">
                    {{ $errors->first() }}
                </div>
            @endif
        </div>

        {{-- PREVIEW --}}
        <div class="xl:col-span-2 bg-white rounded-2xl shadow-xl p-6">

            <h2 class="text-lg font-semibold mb-4">👀 Vista previa</h2>

            <div id="stateEmpty" class="h-64 flex items-center justify-center text-slate-400">
                Selecciona un CSV para ver la vista previa
            </div>

            <div id="stateError"
                 class="hidden bg-red-50 text-red-700 p-4 rounded"></div>

            <div id="previewWrapper"
                 class="hidden max-h-[420px] overflow-y-auto border rounded-xl">
                <div id="previewContainer"></div>
            </div>
        </div>

    </div>
</div>

<script>
const input = document.getElementById('csvInput');
const stateEmpty = document.getElementById('stateEmpty');
const stateError = document.getElementById('stateError');
const previewWrapper = document.getElementById('previewWrapper');
const previewContainer = document.getElementById('previewContainer');

/* 🔥 MAPEO ACTUALIZADO SEGÚN TU EXCEL */
const COLUMN_MAP = {
    dni: ['dni:', 'documento', 'dni'],
    cliente: ['cliente:', 'cliente', 'nombres'],
    email: ['email:', 'dirección de correo electrónico'],
    curso: ['nombre del diplomado', 'producto', 'curso'],
    asesor: ['asesor']
};

// Función robusta para separar CSV respetando comillas
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

function findColumnIndex(headers, aliases) {
    return headers.findIndex(h =>
        aliases.some(a => h.toLowerCase().includes(a.toLowerCase()))
    );
}

input.addEventListener('change', e => {
    const file = e.target.files[0];
    if (!file) return;

    stateEmpty.classList.add('hidden');
    stateError.classList.add('hidden');
    previewWrapper.classList.add('hidden');

    const reader = new FileReader();

    reader.onload = ev => {
        try {
            const text = ev.target.result;
            const rows = text.split(/\r?\n/).filter(r => r.trim() !== '');

            if (rows.length === 0) throw new Error("El archivo está vacío");

            const delimiter = rows[0].includes(';') ? ';' : ',';
            
            // Usamos splitCSV para los encabezados también
            const headers = splitCSV(rows[0], delimiter);

            const indexes = {};
            for (const key in COLUMN_MAP) {
                const idx = findColumnIndex(headers, COLUMN_MAP[key]);
                if (idx === -1 && ['dni','cliente','email','curso'].includes(key)) {
                    throw new Error(`No se detectó la columna necesaria para: ${key.toUpperCase()}. Asegúrate que el CSV tenga los encabezados correctos.`);
                }
                indexes[key] = idx;
            }

            let table = `
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-100 sticky top-0">
                        <tr>
                            ${Object.keys(indexes).map(k =>
                                `<th class="px-4 py-2 border text-left">${k.toUpperCase()}</th>`
                            ).join('')}
                        </tr>
                    </thead>
                    <tbody>
            `;

            rows.slice(1, 21).forEach(r => {
                const cols = splitCSV(r, delimiter);
                table += `<tr class="border-t">`;
                for (const k in indexes) {
                    const val = indexes[k] !== -1 ? cols[indexes[k]] : '';
                    // Limpiar comillas extras si quedaron
                    const cleanVal = (val || '').replace(/^"|"$/g, '');
                    table += `<td class="px-4 py-2 border">${cleanVal}</td>`;
                }
                table += `</tr>`;
            });

            table += `</tbody></table>`;

            previewContainer.innerHTML = table;
            previewWrapper.classList.remove('hidden');

        } catch (err) {
            stateError.textContent = err.message;
            stateError.classList.remove('hidden');
        }
    };

    reader.readAsText(file, 'UTF-8');
});
</script>
@endsection