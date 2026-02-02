@extends('layouts.app')

@section('title', 'Panel de Control')
@section('page_title', 'Dashboard Principal')

@section('content')
<div class="space-y-8">

    {{-- 1. FILTROS Y ACCIONES --}}
    <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex flex-col xl:flex-row items-center justify-between gap-6">
        <form action="{{ route('dashboard') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end w-full xl:w-3/4">
            <div>
                <label class="text-[10px] font-bold text-slate-400 uppercase ml-2 mb-1 block">Desde</label>
                <input type="date" name="desde" value="{{ request('desde') }}" class="w-full border-slate-200 rounded-xl text-sm focus:ring-blue-500">
            </div>
            <div>
                <label class="text-[10px] font-bold text-slate-400 uppercase ml-2 mb-1 block">Hasta</label>
                <input type="date" name="hasta" value="{{ request('hasta') }}" class="w-full border-slate-200 rounded-xl text-sm focus:ring-blue-500">
            </div>
            <div>
                <label class="text-[10px] font-bold text-slate-400 uppercase ml-2 mb-1 block">Búsqueda rápida</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="DNI o Cliente..." class="w-full border-slate-200 rounded-xl text-sm focus:ring-blue-500">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-blue-600 text-white py-2 rounded-xl font-bold text-sm hover:bg-blue-700 transition-all shadow-lg shadow-blue-200">FILTRAR</button>
                <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-slate-100 text-slate-500 rounded-xl text-sm font-bold hover:bg-slate-200">Limpiar</a>
            </div>
        </form>

        <div class="w-full xl:w-1/4 flex justify-end">
            <a href="{{ route('ventas.export', request()->all()) }}" class="w-full xl:w-auto bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-bold text-sm transition-all flex items-center justify-center shadow-lg shadow-green-100">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Exportar Excel
            </a>
        </div>
    </div>

    {{-- 2. KPI CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-slate-900 p-6 rounded-[2rem] text-white shadow-xl">
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Ventas Totales</p>
            <h3 class="text-3xl font-black mt-2">{{ number_format($totalVentas) }}</h3>
        </div>
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
            <p class="text-slate-500 text-xs font-bold uppercase">Importadas Hoy</p>
            <h3 class="text-3xl font-bold text-blue-600 mt-2">{{ $ventasHoy }}</h3>
        </div>
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
            <p class="text-slate-500 text-xs font-bold uppercase">Sede Activa</p>
            <h3 class="text-2xl font-bold text-slate-800 mt-2">Tacna, PE</h3>
        </div>
        <div class="bg-blue-50 p-6 rounded-[2rem] border border-blue-100 shadow-sm">
            <p class="text-blue-600 text-xs font-bold uppercase">Estado ERP</p>
            <h3 class="text-2xl font-bold text-blue-800 mt-2 italic">Online</h3>
        </div>
    </div>

    {{-- 3. ZONA DE GRÁFICOS --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 h-[400px] flex flex-col">
            <h3 class="font-bold text-slate-800 mb-6 text-sm uppercase tracking-widest">Participación por Diplomado</h3>
            <div class="flex-1 relative">
                <canvas id="chartPastel"></canvas>
            </div>
        </div>

        <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 h-[400px] flex flex-col">
            <h3 class="font-bold text-slate-800 mb-6 text-sm uppercase tracking-widest">Rendimiento Temporal</h3>
            <div class="flex-1 relative">
                <canvas id="chartBarras"></canvas>
            </div>
        </div>
    </div>

    {{-- 4. RANKING Y TABLA --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Ranking Lateral --}}
        <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 h-fit">
            <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center italic">
                Top 5 Cursos
            </h3>
            <div class="space-y-6">
                @foreach($statsCursos as $nombre => $cantidad)
                <div class="group">
                    <div class="flex justify-between items-end mb-2">
                        <span class="text-xs font-bold text-slate-500 truncate max-w-[150px] group-hover:text-blue-600 transition-colors">{{ $nombre }}</span>
                        <span class="text-sm font-black text-slate-900">{{ $cantidad }}</span>
                    </div>
                    <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                        <div class="bg-blue-600 h-full rounded-full transition-all duration-1000" style="width: {{ ($cantidad / max($totalVentas, 1)) * 100 }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Tabla de Ventas --}}
        <div class="lg:col-span-2 bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
                <h3 class="text-lg font-bold text-slate-800 uppercase tracking-tighter text-sm">Listado de Ventas Recientes</h3>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-white text-[10px] font-black text-slate-400 uppercase tracking-widest border-b">
                        <tr>
                            <th class="px-8 py-5">Cliente</th>
                            <th class="px-8 py-5">Diplomado</th>
                            <th class="px-8 py-5 text-right">Fecha</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($ventasRecientes as $v)
                        <tr class="hover:bg-blue-50/20 transition-all group">
                            <td class="px-8 py-4">
                                <div class="text-sm font-bold text-slate-700 group-hover:text-blue-600 transition-colors">{{ $v->data['CLIENTE:'] ?? 'N/A' }}</div>
                                <div class="text-[10px] text-slate-400 font-mono">DNI: {{ $v->data['DNI:'] ?? '---' }}</div>
                            </td>
                            <td class="px-8 py-4">
                                <span class="text-[10px] font-bold text-slate-500 bg-slate-100 px-3 py-1.5 rounded-lg border border-slate-200 uppercase">
                                    {{ Str::limit($v->data['CURSO:'] ?? $v->data['NOMBRE DEL DIPLOMADO:'] ?? 'Venta General', 30) }}
                                </span>
                            </td>
                            <td class="px-8 py-4 text-right">
                                <span class="text-[10px] text-slate-400 font-bold">{{ $v->created_at->format('d/m/Y') }}</span>
                                <div class="text-[9px] text-slate-300">{{ $v->created_at->diffForHumans() }}</div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-8 py-12 text-center text-slate-400 italic">No hay registros disponibles.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-8 py-4 bg-slate-50 border-t border-slate-100">
                {{ $ventasRecientes->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

{{-- Scripts para los Gráficos --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Gráfico de Pastel (Doughnut)
    const ctxPastel = document.getElementById('chartPastel').getContext('2d');
    new Chart(ctxPastel, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($statsCursos->keys()) !!},
            datasets: [{
                data: {!! json_encode($statsCursos->values()) !!},
                backgroundColor: ['#0f172a', '#2563eb', '#8b5cf6', '#f59e0b', '#10b981'],
                hoverOffset: 20,
                borderWidth: 0
            }]
        },
        options: { 
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, font: { size: 10 } } } } 
        }
    });

    // Gráfico de Barras
    const ctxBarras = document.getElementById('chartBarras').getContext('2d');
    new Chart(ctxBarras, {
        type: 'bar',
        data: {
            labels: ['Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab', 'Dom'],
            datasets: [{
                label: 'Ventas por Día',
                data: [12, 19, 15, 25, 22, 30, 10], 
                backgroundColor: '#2563eb',
                borderRadius: 10,
                barThickness: 20
            }]
        },
        options: { 
            responsive: true,
            maintainAspectRatio: false,
            scales: { y: { beginAtZero: true, grid: { display: false } }, x: { grid: { display: false } } },
            plugins: { legend: { display: false } }
        }
    });
</script>
@endsection