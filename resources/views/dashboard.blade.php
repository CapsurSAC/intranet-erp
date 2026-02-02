@extends('layouts.app')

@section('content')
<div class="space-y-6">
    
    {{-- FILTROS DE INTELIGENCIA --}}
    <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100">
        <form action="{{ route('dashboard') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
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
                <button type="submit" class="flex-1 bg-blue-600 text-white py-2 rounded-xl font-bold text-sm hover:bg-blue-700 transition-all">FILTRAR</button>
                <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-slate-100 text-slate-500 rounded-xl text-sm font-bold hover:bg-slate-200">Limpiar</a>
            </div>
        </form>
    </div>

    {{-- KPI CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-slate-900 p-6 rounded-[2rem] text-white shadow-xl">
            <p class="text-slate-400 text-xs font-bold uppercase">Ventas Totales</p>
            <h3 class="text-3xl font-black mt-2">{{ number_format($totalVentas) }}</h3>
        </div>
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
            <p class="text-slate-500 text-xs font-bold uppercase">Importadas Hoy</p>
            <h3 class="text-3xl font-bold text-blue-600 mt-2">{{ $ventasHoy }}</h3>
        </div>
        {{-- Card dinámica para Tacna --}}
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
            <p class="text-slate-500 text-xs font-bold uppercase">Sede Activa</p>
            <h3 class="text-2xl font-bold text-slate-800 mt-2">Tacna, PE</h3>
        </div>
        <div class="bg-blue-50 p-6 rounded-[2rem] border border-blue-100 shadow-sm">
            <p class="text-blue-600 text-xs font-bold uppercase">Estado ERP</p>
            <h3 class="text-2xl font-bold text-blue-800 mt-2 italic">Online</h3>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- RANKING LATERAL --}}
        <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 h-fit">
            <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/></svg>
                Top Diplomados
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

        {{-- TABLA DE VENTAS COMPLETA --}}
        <div class="lg:col-span-2 bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                <h3 class="text-lg font-bold text-slate-800 uppercase tracking-tighter">Listado de Ventas Filtradas</h3>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-white text-[10px] font-black text-slate-400 uppercase tracking-widest border-b">
                        <tr>
                            <th class="px-8 py-5">Información Cliente</th>
                            <th class="px-8 py-5">Diplomado / Curso</th>
                            <th class="px-8 py-5 text-right">Importación</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($ventasRecientes as $v)
                        <tr class="hover:bg-blue-50/20 transition-all group">
                            <td class="px-8 py-4">
                                <div class="text-sm font-bold text-slate-700 group-hover:text-blue-600 transition-colors">
                                    {{ $v->data['CLIENTE:'] ?? 'N/A' }}
                                </div>
                                <div class="text-[10px] text-slate-400 font-mono italic">
                                    DNI: {{ $v->data['DNI:'] ?? '---' }} | {{ $v->data['ASESOR:'] ?? 'S/A' }}
                                </div>
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
                            <td colspan="3" class="px-8 py-12 text-center text-slate-400 italic">No hay registros con esos filtros.</td>
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
@endsection