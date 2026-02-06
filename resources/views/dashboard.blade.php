@extends('layouts.app')

@section('title', 'Panel de Control')
@section('page_title', 'Dashboard')

@section('content')
<div x-data="{ 
    showWelcome: true,
    init() {
        setTimeout(() => this.showWelcome = false, 5000);
    }
}" class="space-y-8 pb-12">

    {{-- Welcome Widget (Dismissable) --}}
    <div x-show="showWelcome" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform -translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-2"
         class="relative overflow-hidden rounded-[2rem] bg-gradient-to-r from-blue-600 to-indigo-600 p-8 text-white shadow-xl shadow-blue-500/20">
        
        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-white/10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-64 h-64 rounded-full bg-blue-400/20 blur-3xl"></div>

        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <h2 class="text-3xl font-bold mb-2">¡Hola, {{ Auth::user()->name ?? 'Usuario' }}! 👋</h2>
                <p class="text-blue-100 text-lg">Bienvenido a tu panel de control. Aquí tienes un resumen de la actividad de hoy.</p>
            </div>
            <button @click="showWelcome = false" class="p-2 bg-white/10 hover:bg-white/20 rounded-full transition-colors backdrop-blur-sm">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        {{-- COLUMNA PRINCIPAL (KPIs + Gráficos) --}}
        <div class="lg:col-span-8 space-y-8">
            
            {{-- KPI CARDS --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- KPI 1 -->
                <div class="group bg-white/80 backdrop-blur-xl p-6 rounded-[2rem] border border-white/50 shadow-lg shadow-slate-200/50 hover:shadow-indigo-500/20 hover:-translate-y-1 transition-all duration-300">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Ventas Totales</p>
                            <h3 class="text-3xl font-black text-slate-800 tracking-tight">{{ number_format($totalVentas) }}</h3>
                        </div>
                        <div class="p-3 bg-indigo-50 rounded-2xl group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                            <svg class="w-6 h-6 text-indigo-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-xs font-bold text-green-500 bg-green-50 w-fit px-2 py-1 rounded-lg">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                        +12% vs mes anterior
                    </div>
                </div>

                <!-- KPI 2 -->
                <div class="group bg-white/80 backdrop-blur-xl p-6 rounded-[2rem] border border-white/50 shadow-lg shadow-slate-200/50 hover:shadow-blue-500/20 hover:-translate-y-1 transition-all duration-300">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Importadas Hoy</p>
                            <h3 class="text-3xl font-black text-slate-800 tracking-tight">{{ $ventasHoy }}</h3>
                        </div>
                        <div class="p-3 bg-blue-50 rounded-2xl group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                            <svg class="w-6 h-6 text-blue-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                        </div>
                    </div>
                     <div class="mt-4 flex items-center text-xs font-bold text-slate-400 bg-slate-50 w-fit px-2 py-1 rounded-lg">
                        Actualizado hace 5m
                    </div>
                </div>

                <!-- KPI 3 -->
                <div class="group bg-white/80 backdrop-blur-xl p-6 rounded-[2rem] border border-white/50 shadow-lg shadow-slate-200/50 hover:shadow-amber-500/20 hover:-translate-y-1 transition-all duration-300">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Sede Activa</p>
                            <h3 class="text-2xl font-black text-slate-800 tracking-tight">Tacna, PE</h3>
                        </div>
                        <div class="p-3 bg-amber-50 rounded-2xl group-hover:bg-amber-500 group-hover:text-white transition-colors duration-300">
                           <svg class="w-6 h-6 text-amber-500 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                    </div>
                     <div class="mt-4 flex items-center text-xs font-bold text-blue-500 w-fit px-2 py-1 rounded-lg">
                        Estado: Operativo
                    </div>
                </div>
            </div>

            {{-- ZONA DE GRÁFICOS (Glassmorphism + Modern) --}}
            <div class="grid grid-cols-1 gap-8">
                 <div class="bg-white/70 backdrop-blur-xl p-8 rounded-[2rem] shadow-lg shadow-slate-200/50 border border-white/50">
                    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                        <h3 class="font-bold text-slate-800 text-lg flex items-center">
                            <span class="w-2 h-8 bg-blue-600 rounded-full mr-3"></span>
                            Rendimiento Semanal
                        </h3>
                        <select class="bg-slate-100 border-none text-xs font-bold text-slate-600 rounded-lg px-4 py-2 hover:bg-slate-200 transition-colors cursor-pointer focus:ring-2 focus:ring-blue-500">
                            <option>Últimos 7 días</option>
                            <option>Este Mes</option>
                        </select>
                    </div>
                    <div class="h-[350px] w-full">
                        <canvas id="chartBarras"></canvas>
                    </div>
                </div>
            </div>

            {{-- TABLA DE VENTAS --}}
             <div class="bg-white/80 backdrop-blur-xl rounded-[2rem] shadow-lg shadow-slate-200/50 border border-white/50 overflow-hidden">
                <div class="p-8 border-b border-slate-100/50 flex flex-col md:flex-row justify-between items-center gap-4 bg-white/40">
                    <h3 class="font-bold text-slate-800 text-lg flex items-center">
                        <span class="w-2 h-8 bg-indigo-600 rounded-full mr-3"></span>
                        Últimas Transacciones
                    </h3>
                    <div class="flex gap-2">
                        <a href="{{ route('ventas.export', request()->all()) }}" class="flex items-center space-x-2 bg-green-50 text-green-700 px-4 py-2 rounded-xl text-xs font-bold hover:bg-green-100 transition-colors">
                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                             <span>Excel</span>
                        </a>
                        <a href="#" class="flex items-center space-x-2 bg-slate-50 text-slate-600 px-4 py-2 rounded-xl text-xs font-bold hover:bg-slate-100 transition-colors">
                            <span>Ver todas</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-50/50 text-xs font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">
                            <tr>
                                <th class="px-8 py-5">Cliente</th>
                                <th class="px-8 py-5">Diplomado/Curso</th>
                                <th class="px-8 py-5">Monto</th>
                                <th class="px-8 py-5 text-right">Fecha</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($ventasRecientes as $v)
                            <tr class="hover:bg-blue-50/30 transition-all group">
                                <td class="px-8 py-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-blue-400 to-blue-600 text-white flex items-center justify-center text-xs font-bold shadow-md shadow-blue-200">
                                            {{ substr($v->data['CLIENTE:'] ?? 'U', 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-slate-700 group-hover:text-blue-600 transition-colors">{{ $v->data['CLIENTE:'] ?? 'N/A' }}</div>
                                            <div class="text-[10px] text-slate-400 font-mono tracking-wide">DNI: {{ $v->data['DNI:'] ?? '---' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-4">
                                    <span class="text-[10px] font-bold text-indigo-500 bg-indigo-50 px-3 py-1.5 rounded-full border border-indigo-100/50 uppercase tracking-wide">
                                        {{ Str::limit($v->data['CURSO:'] ?? $v->data['NOMBRE DEL DIPLOMADO:'] ?? 'Venta General', 25) }}
                                    </span>
                                </td>
                                <td class="px-8 py-4">
                                    <span class="text-sm font-bold text-slate-700">$ {{ number_format(rand(100, 500), 2) }}</span> {{-- Placeholder para monto --}}
                                </td>
                                <td class="px-8 py-4 text-right">
                                    <span class="text-[10px] text-slate-400 font-bold block">{{ $v->created_at->format('d/m/Y') }}</span>
                                    <span class="text-[9px] text-slate-300">{{ $v->created_at->diffForHumans() }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-8 py-12 text-center text-slate-400 italic">No hay registros recientes.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        {{-- COLUMNA LATERAL (Widgets & Utilidades) --}}
        <div class="lg:col-span-4 space-y-8">

            {{-- FILTROS RÁPIDOS (Compacto) --}}
            <div class="bg-white/80 backdrop-blur-xl p-6 rounded-[2rem] shadow-lg shadow-slate-200/50 border border-white/50">
                <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Filtrar Data</h4>
                <form action="{{ route('dashboard') }}" method="GET" class="space-y-4">
                     <div>
                        <input type="date" name="desde" value="{{ request('desde') }}" class="w-full bg-slate-50 border-none rounded-xl text-xs font-bold text-slate-600 p-3 focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <input type="date" name="hasta" value="{{ request('hasta') }}" class="w-full bg-slate-50 border-none rounded-xl text-xs font-bold text-slate-600 p-3 focus:ring-2 focus:ring-blue-500">
                    </div>
                    <button type="submit" class="w-full bg-slate-800 text-white py-3 rounded-xl font-bold text-xs hover:bg-slate-700 transition-all shadow-lg shadow-slate-200 uppercase tracking-wider">Actualizar Dashboard</button>
                    @if(request()->has('desde') || request()->has('hasta'))
                        <a href="{{ route('dashboard') }}" class="block text-center text-[10px] uppercase font-bold text-slate-400 hover:text-red-500 transition-colors">Limpiar Filtros</a>
                    @endif
                </form>
            </div>

            {{-- 1. ACCESOS RÁPIDOS --}}
            <div class="bg-gradient-to-br from-indigo-600 to-blue-700 p-6 rounded-[2rem] text-white shadow-xl shadow-indigo-200 relative overflow-hidden group">
                 <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 rounded-full bg-white/10 blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                 <h3 class="font-bold text-lg mb-4 relative z-10">Accesos Rápidos</h3>
                 <div class="grid grid-cols-2 gap-3 relative z-10">
                    <a href="#" class="bg-white/10 hover:bg-white/20 p-4 rounded-2xl flex flex-col items-center justify-center text-center backdrop-blur-sm transition-all border border-white/5">
                        <svg class="w-6 h-6 mb-2 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span class="text-[10px] font-bold uppercase">Nueva Venta</span>
                    </a>
                    <a href="#" class="bg-white/10 hover:bg-white/20 p-4 rounded-2xl flex flex-col items-center justify-center text-center backdrop-blur-sm transition-all border border-white/5">
                         <svg class="w-6 h-6 mb-2 text-amber-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                        <span class="text-[10px] font-bold uppercase">Nuevo Alumno</span>
                    </a>
                     <a href="#" class="bg-white/10 hover:bg-white/20 p-4 rounded-2xl flex flex-col items-center justify-center text-center backdrop-blur-sm transition-all border border-white/5">
                        <svg class="w-6 h-6 mb-2 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span class="text-[10px] font-bold uppercase">Reporte Diario</span>
                    </a>
                    <a href="#" class="bg-white/10 hover:bg-white/20 p-4 rounded-2xl flex flex-col items-center justify-center text-center backdrop-blur-sm transition-all border border-white/5">
                         <svg class="w-6 h-6 mb-2 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span class="text-[10px] font-bold uppercase">Agenda</span>
                    </a>
                 </div>
            </div>

            {{-- 2. GRAFICO DE DONA (Reubicado) --}}
            <div class="bg-white/80 backdrop-blur-xl p-8 rounded-[2rem] shadow-lg shadow-slate-200/50 border border-white/50 relative overflow-hidden">
                <h3 class="font-bold text-slate-800 mb-6 text-sm uppercase tracking-widest text-center">Top Diplomados</h3>
                <div class="h-[250px] relative z-10">
                    <canvas id="chartPastel"></canvas>
                </div>
            </div>

            {{-- 3. ANUNCIOS / COMUNICADOS --}}
            <div x-data="{ 
                activeSlide: 0, 
                slides: [
                    { title: 'Reunión Mensual', desc: 'Viernes 14 a las 10:00 AM en Sala 1.', color: 'bg-amber-100 text-amber-800' },
                    { title: 'Mantenimiento ERP', desc: 'Sábado de 22:00 a 23:30 PM.', color: 'bg-blue-100 text-blue-800' },
                    { title: 'Nuevo Convenio', desc: 'Se firmó alianza con U. Nacional.', color: 'bg-green-100 text-green-800' }
                ],
                next() { this.activeSlide = (this.activeSlide + 1) % this.slides.length },
                prev() { this.activeSlide = (this.activeSlide - 1 + this.slides.length) % this.slides.length }
            }" class="bg-white/80 backdrop-blur-xl p-6 rounded-[2rem] shadow-lg shadow-slate-200/50 border border-white/50">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest">Comunicados</h4>
                    <div class="flex gap-1">
                        <button @click="prev()" class="p-1 hover:bg-slate-100 rounded-lg text-slate-400 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg></button>
                        <button @click="next()" class="p-1 hover:bg-slate-100 rounded-lg text-slate-400 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></button>
                    </div>
                </div>
                
                <template x-for="(slide, index) in slides" :key="index">
                    <div x-show="activeSlide === index" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-x-4"
                         x-transition:enter-end="opacity-100 translate-x-0"
                         :class="slide.color"
                         class="p-4 rounded-2xl">
                        <h4 class="font-bold text-sm mb-1" x-text="slide.title"></h4>
                        <p class="text-xs opacity-90" x-text="slide.desc"></p>
                    </div>
                </template>
            </div>

        </div>
    </div>

</div>

{{-- Scripts para los Gráficos --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.color = '#64748b';
    Chart.defaults.scale.grid.color = 'rgba(241, 245, 249, 0.5)';

    // Gráfico de Pastel (Doughnut) Modernizado
    const ctxPastel = document.getElementById('chartPastel').getContext('2d');
    new Chart(ctxPastel, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($statsCursos->keys()) !!},
            datasets: [{
                data: {!! json_encode($statsCursos->values()) !!},
                backgroundColor: [
                    'rgba(37, 99, 235, 0.9)',   // Blue
                    'rgba(79, 70, 229, 0.9)',   // Indigo
                    'rgba(139, 92, 246, 0.9)',  // Violet
                    'rgba(245, 158, 11, 0.9)',  // Amber
                    'rgba(16, 185, 129, 0.9)'   // Emerald
                ],
                borderWidth: 0,
                hoverOffset: 15
            }]
        },
        options: { 
            responsive: true,
            maintainAspectRatio: false,
            cutout: '75%',
            plugins: { 
                legend: { 
                    position: 'bottom', 
                    labels: { 
                        usePointStyle: true,
                        pointStyle: 'circle',
                        padding: 20,
                        font: { size: 10, weight: 'bold' } 
                    } 
                },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                    padding: 12,
                    cornerRadius: 12,
                    bodyFont: { size: 12 }
                }
            } 
        }
    });

    // Gráfico de Barras Modernizado
    const ctxBarras = document.getElementById('chartBarras').getContext('2d');
    
    // Crear degradado para las barras
    let gradient = ctxBarras.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, '#2563eb');
    gradient.addColorStop(1, '#60a5fa');

    new Chart(ctxBarras, {
        type: 'bar',
        data: {
            labels: ['Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab', 'Dom'],
            datasets: [{
                label: 'Ventas por Día',
                data: [12, 19, 15, 25, 22, 30, 20], 
                backgroundColor: gradient,
                borderRadius: 8,
                barThickness: 24,
                hoverBackgroundColor: '#1d4ed8'
            }]
        },
        options: { 
            responsive: true,
            maintainAspectRatio: false,
            scales: { 
                y: { 
                    beginAtZero: true, 
                    grid: { display: true, drawBorder: false },
                    ticks: { padding: 10, font: { weight: 'bold' }} 
                }, 
                x: { 
                    grid: { display: false },
                    ticks: { padding: 10, font: { weight: 'bold' }} 
                } 
            },
            plugins: { 
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                    padding: 12,
                    cornerRadius: 12,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return context.parsed.y + ' Ventas';
                        }
                    }
                }
            }
        }
    });
</script>
@endsection