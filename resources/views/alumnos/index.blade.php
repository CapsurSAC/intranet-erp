@extends('layouts.app')

@section('title', 'Gestión de Alumnos')
@section('page_title', 'Directorio de Alumnos')

@section('content')
<div class="space-y-6">

    {{-- Actions & Search --}}
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 bg-white/80 backdrop-blur-xl p-6 rounded-[2rem] shadow-lg shadow-slate-200/50 border border-white/50">
        
        <div class="w-full md:w-1/3 relative">
            <input type="text" placeholder="Buscar alumno por nombre o DNI..." class="w-full pl-10 pr-4 py-3 rounded-xl bg-slate-50 border-none text-slate-600 font-medium focus:ring-2 focus:ring-blue-500 shadow-inner">
            <svg class="w-5 h-5 text-slate-400 absolute left-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>

        <div class="flex gap-2 w-full md:w-auto">
            <button class="flex-1 md:flex-none flex items-center justify-center space-x-2 bg-slate-100 text-slate-600 px-6 py-3 rounded-xl font-bold hover:bg-slate-200 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                <span>Filtros</span>
            </button>
            <a href="{{ route('alumnos.create') }}" class="flex-1 md:flex-none flex items-center justify-center space-x-2 bg-blue-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-700 transition-colors shadow-lg shadow-blue-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Nuevo Alumno</span>
            </a>
        </div>
    </div>

    {{-- Students Table --}}
    <div class="bg-white/80 backdrop-blur-xl rounded-[2rem] shadow-lg shadow-slate-200/50 border border-white/50 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50/50 text-xs font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100">
                    <tr>
                        <th class="px-8 py-5">Nombre / Email</th>
                        <th class="px-8 py-5">DNI / Teléfono</th>
                        <th class="px-8 py-5">Curso Actual</th>
                        <th class="px-8 py-5">Estado</th>
                        <th class="px-8 py-5 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($alumnos as $alumno)
                    <tr class="hover:bg-blue-50/30 transition-all group">
                        <td class="px-8 py-4">
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 text-white flex items-center justify-center font-bold text-sm shadow-md shadow-indigo-200">
                                    {{ substr($alumno->nombre, 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-slate-800 group-hover:text-blue-600 transition-colors">{{ $alumno->nombre }}</div>
                                    <div class="text-xs text-slate-400 font-medium">{{ $alumno->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-4">
                            <div class="flex flex-col">
                                <span class="text-xs font-bold text-slate-600 bg-slate-100 px-2 py-0.5 rounded-md w-fit mb-1">DNI: {{ $alumno->dni }}</span>
                                <span class="text-xs text-slate-400 flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    {{ $alumno->telefono }}
                                </span>
                            </div>
                        </td>
                        <td class="px-8 py-4">
                            <span class="text-xs font-bold text-slate-600">{{ Str::limit($alumno->curso, 30) }}</span>
                        </td>
                        <td class="px-8 py-4">
                            @if($alumno->estado === 'Activo')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                    <span class="w-1.5 h-1.5 bg-green-600 rounded-full mr-1.5"></span> Activo
                                </span>
                            @elseif($alumno->estado === 'Pendiente')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 border border-amber-200">
                                    <span class="w-1.5 h-1.5 bg-amber-600 rounded-full mr-1.5"></span> Pendiente
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-500 border border-slate-200">
                                    <span class="w-1.5 h-1.5 bg-slate-400 rounded-full mr-1.5"></span> Inactivo
                                </span>
                            @endif
                        </td>
                        <td class="px-8 py-4 text-right">
                             <div class="flex items-center justify-end space-x-2">
                                <button class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <button class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                             </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-12 text-center text-slate-400 italic">No hay alumnos registrados.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Pagination Mockup --}}
        <div class="px-8 py-4 border-t border-slate-100 bg-slate-50/50 flex justify-between items-center">
            <span class="text-xs text-slate-400 font-bold">Mostrando 5 de 120 resultados</span>
            <div class="flex space-x-1">
                <button class="px-3 py-1 text-xs font-bold text-slate-400 hover:bg-white hover:shadow-sm rounded-md transition-all">Anterior</button>
                <button class="px-3 py-1 text-xs font-bold bg-blue-600 text-white shadow-md shadow-blue-200 rounded-md">1</button>
                <button class="px-3 py-1 text-xs font-bold text-slate-600 hover:bg-white hover:shadow-sm rounded-md transition-all">2</button>
                <button class="px-3 py-1 text-xs font-bold text-slate-600 hover:bg-white hover:shadow-sm rounded-md transition-all">3</button>
                <button class="px-3 py-1 text-xs font-bold text-slate-400 hover:bg-white hover:shadow-sm rounded-md transition-all">Siguiente</button>
            </div>
        </div>
    </div>
</div>
@endsection
