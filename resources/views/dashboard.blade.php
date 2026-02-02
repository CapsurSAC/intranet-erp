@extends('layouts.app')

@section('title', 'Panel de Control')
@section('page_title', 'Dashboard Principal')

@section('content')
<div class="space-y-8">
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center space-x-4">
            <div class="bg-blue-100 p-4 rounded-2xl text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Ventas Totales</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ number_format($totalVentas) }}</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center space-x-4">
            <div class="bg-green-100 p-4 rounded-2xl text-green-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Importadas Hoy</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ $ventasHoy }}</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center space-x-4">
            <div class="bg-purple-100 p-4 rounded-2xl text-purple-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Sede Principal</p>
                <h3 class="text-2xl font-bold text-slate-800">Tacna</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center space-x-4">
            <div class="bg-amber-100 p-4 rounded-2xl text-amber-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Easypanel Status</p>
                <h3 class="text-lg font-bold text-slate-800">Online</h3>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-6 border-b border-slate-50 flex justify-between items-center">
                <h3 class="font-bold text-slate-800">Últimos Registros</h3>
                <a href="/ventas" class="text-xs font-bold text-blue-600 hover:underline">Ver todo</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <tbody class="divide-y divide-slate-50">
                        @foreach($ventasRecientes as $v)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <p class="text-sm font-bold text-slate-700">{{ $v->data['CLIENTE:'] ?? 'N/A' }}</p>
                                <p class="text-[10px] text-slate-400 font-mono">{{ $v->data['DNI:'] ?? '' }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-[10px] bg-slate-100 px-2 py-1 rounded text-slate-500 uppercase font-bold">
                                    {{ Str::limit($v->data['CURSO:'] ?? 'Diplomado', 25) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <p class="text-xs text-slate-400">{{ $v->created_at->diffForHumans() }}</p>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-slate-900 rounded-3xl p-6 text-white shadow-xl shadow-slate-200">
                <h4 class="font-bold mb-4">Acciones de Ingeniero</h4>
                <div class="grid grid-cols-1 gap-3">
                    <a href="/importaciones/ventas" class="flex items-center space-x-3 bg-slate-800 p-3 rounded-xl hover:bg-slate-700 transition-all text-sm">
                        <span>📂 Importar nuevo CSV</span>
                    </a>
                    <button class="flex items-center space-x-3 bg-blue-600 p-3 rounded-xl hover:bg-blue-500 transition-all text-sm font-bold">
                        <span>📊 Generar Reporte Mensual</span>
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
                <h4 class="font-bold text-slate-800 mb-2">Soporte CAPSUR</h4>
                <p class="text-xs text-slate-500 leading-relaxed">Si detectas errores en las columnas de Tacna, recuerda que el sistema JSON las procesa automáticamente.</p>
            </div>
        </div>
    </div>
</div>
@endsection