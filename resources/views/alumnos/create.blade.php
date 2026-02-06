@extends('layouts.app')

@section('title', 'Nuevo Alumno')
@section('page_title', 'Registrar Nuevo Alumno')

@section('content')
<div class="max-w-2xl mx-auto bg-white/80 backdrop-blur-xl p-8 rounded-[2rem] shadow-lg shadow-slate-200/50 border border-white/50">
    <h3 class="text-lg font-black text-slate-800 uppercase tracking-widest mb-6 border-b border-slate-100 pb-4">Ficha de Inscripción</h3>
    
    <form action="{{ route('alumnos.store') }}" method="POST" class="space-y-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Nombre Completo</label>
                <input type="text" name="nombre" class="w-full bg-slate-50 border-none rounded-xl text-sm font-semibold text-slate-700 p-4 focus:ring-2 focus:ring-blue-500 shadow-inner" placeholder="Ej: Juan Pérez">
            </div>
            
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">DNI / Documento</label>
                <input type="text" name="dni" class="w-full bg-slate-50 border-none rounded-xl text-sm font-semibold text-slate-700 p-4 focus:ring-2 focus:ring-blue-500 shadow-inner" placeholder="Ej: 12345678">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Teléfono / Celular</label>
                <input type="text" name="telefono" class="w-full bg-slate-50 border-none rounded-xl text-sm font-semibold text-slate-700 p-4 focus:ring-2 focus:ring-blue-500 shadow-inner" placeholder="Ej: 999 000 111">
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Correo Electrónico</label>
                <input type="email" name="email" class="w-full bg-slate-50 border-none rounded-xl text-sm font-semibold text-slate-700 p-4 focus:ring-2 focus:ring-blue-500 shadow-inner" placeholder="juan@ejemplo.com">
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-4">
            <a href="{{ route('alumnos.index') }}" class="px-6 py-3 rounded-xl font-bold text-sm text-slate-500 hover:bg-slate-100 transition-colors">Cancelar</a>
            <button type="submit" class="px-8 py-3 bg-blue-600 text-white rounded-xl font-bold text-sm hover:bg-blue-700 transition-all shadow-lg shadow-blue-200">Guardar Alumno</button>
        </div>
    </form>
</div>
@endsection
