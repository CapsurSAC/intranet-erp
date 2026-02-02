@extends('layouts.app')

@section('title', 'Panel de Control')
@section('page_title', 'Dashboard Principal')

@section('content')
<div class="space-y-6">

    {{-- BARRA DE HERRAMIENTAS Y FILTROS --}}
    <div class="bg-white p-4 rounded-3xl shadow-sm border border-slate-100 flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex items-center space-x-2">
            <div class="bg-blue-600 w-2 h-8 rounded-full"></div>
            <h2 class="text-lg font-bold text-slate-800 uppercase tracking-tighter">Análisis de Ventas</h2>
        </div>
        
        <form action="{{ route('dashboard') }}" method="GET" class="flex items-center gap-2">
            <input type="date" name="desde" value="{{ request('desde') }}" class="text-xs border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500">
            <span class="text-slate-400 text-xs font-bold">AL</span>
            <input type="date" name="hasta" value="{{ request('hasta') }}" class="text-xs border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500">
            <button type="submit" class="bg-slate-900 text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-black transition-all">
                FILTRAR
            </button>
            @if(request()->has('desde'))
                <a href="{{ route('dashboard') }}" class="text-xs text-red-500 font-bold px-2">X Limpiar</a>
            @endif
        </form>
    </div>

    {{-- KPI CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- Card Total --}}
        <div class="bg-gradient-to-br from-blue-600 to-blue-800 p-6 rounded-[2rem] text-white shadow-xl shadow-blue-100 relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-blue-100 text-xs font-bold uppercase tracking-widest">Ventas Totales</p>
                <h3 class="text-4xl font-black mt-2">{{ number_format($totalVentas) }}</h3>
                <p class="text-[10px] text-blue-200 mt-4 flex items-center">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path></svg>
                    Sede Tacna Actualizada
                </p>
            </div>
            <svg class="absolute -right-4 -bottom-4 w-32 h-32 text-blue-500 opacity-20" fill="currentColor" viewBox="0 0 20 20"><path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path></svg>
        </div>

        {{-- Card Hoy --}}
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex flex-col justify-between">
            <div class="flex justify-between items-start">
                <div class="bg-green-100 p-3 rounded-2xl text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="text-[10px] font-black text-green-600 bg-green-50 px-2 py-1 rounded-lg">ACTIVO</span>
            </div>
            <div>
                <p class="text-slate-500 text-xs font-bold uppercase mt-4">Importadas Hoy</p>
                <h3 class="text-3xl font-bold text-slate-800">{{ $ventasHoy }}</h3>
            </div>
        </div>

        {{-- Card Ratio (Ejemplo dinámico) --}}
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex flex-col justify-between">
            <div class="bg-purple-100 w-fit p-3 rounded-2xl text-purple-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
            </div>
            <div>
                <p class="text-slate-500 text-xs font-bold uppercase mt-4">Crecimiento</p>
                <h3 class="text-3xl font-bold text-slate-800">+12.5%</h3>
            </div>
        </div>

        {{-- Card Status --}}
        <div class="bg-slate-900 p-6 rounded-[2rem] shadow-xl text-white flex flex-col justify-between">
            <div class="flex items-center space-x-2">
                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                <span class="text-[10px] font-bold text-slate-400">SERVER STATUS</span>
            </div>
            <div class="mt-4">
                <p class="text-blue-400 text-[10px] font-black uppercase">Easypanel Online</p>
                <p class="text-lg font-bold">Biblioteca ERP v1.0</p>
            </div>
        </div>
    </div>

    {{-- SECCIÓN INTERMEDIA: GRÁFICOS Y TABLA --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- TOP DIPLOMADOS (PROCESAMIENTO JSON) --}}
        <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100">
            <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                Ranking Diplomados
            </h3>
            
            <div class="space-y-6">
                @foreach($statsCursos as $nombre => $cantidad)
                <div>
                    <div class="flex justify-between items-end mb-2">
                        <span class="text-xs font-bold text-slate-600 truncate max-w-[180px]">{{ $nombre }}</span>
                        <span class="text-sm font-black text-slate-900">{{ $cantidad }}</span>
                    </div>
                    <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                        <div class="bg-blue-600 h-full rounded-full" style="width: {{ ($cantidad / max($totalVentas, 1)) * 100 }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- ÚLTIMOS REGISTROS --}}
        <div class="lg:col-span-2 bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-8 border-b border-slate-50 flex justify-between items-center">
                <h3 class="text-lg font-bold text-slate-800">Flujo Reciente de Ventas</h3>
                <a href="/ventas" class="text-xs font-bold text-blue-600 bg-blue-50 px-4 py-2 rounded-xl hover:bg-blue-100 transition-all">Explorar Todo</a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                        <tr>
                            <th class="px-8 py-4">Cliente</th>
                            <th class="px-8 py-4">Producto / Curso</th>
                            <th class="px-8 py-4">Asesor</th>
                            <th class="px-8 py-4 text-right">Tiempo</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($ventasRecientes as $v)
                        <tr class="hover:bg-blue-50/30 transition-all group">
                            <td class="px-8 py-4">
                                <div class="text-sm font-bold text-slate-700 group-hover:text-blue-700 transition-colors">{{ $v->data['CLIENTE:'] ?? 'N/A' }}</div>
                                <div class="text-[10px] text-slate-400 font-mono tracking-tighter">{{ $v->data['DNI:'] ?? '---' }}</div>
                            </td>
                            <td class="px-8 py-4">
                                <span class="text-[10px] font-bold text-slate-500 bg-slate-100 px-2 py-1 rounded-lg border border-slate-200">
                                    {{ Str::limit($v->data['CURSO:'] ?? $v->data['NOMBRE DEL DIPLOMADO:'] ?? 'Venta General', 30) }}
                                </span>
                            </td>
                            <td class="px-8 py-4 text-xs font-bold text-slate-600">
                                {{ $v->data['ASESOR:'] ?? 'Central' }}
                            </td>
                            <td class="px-8 py-4 text-right">
                                <span class="text-[10px] text-slate-400 font-medium italic">{{ $v->created_at->diffForHumans() }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection