@extends('layouts.app')

@section('title', 'Registrar Venta')
@section('page_title', 'Nueva Venta')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white/80 backdrop-blur-xl p-8 rounded-[2rem] shadow-lg shadow-slate-200/50 border border-white/50">
        <div class="flex items-center justify-between mb-8 border-b border-slate-100 pb-4">
            <div>
                <h3 class="text-xl font-black text-slate-800 uppercase tracking-widest">Ficha de Venta</h3>
                <p class="text-xs text-slate-400 font-bold mt-1">Complete todos los campos requeridos</p>
            </div>
            <div class="bg-blue-50 text-blue-600 p-3 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
        </div>
        
        <form action="{{ route('ventas.store') }}" method="POST" class="space-y-8">
            @csrf

            {{-- 1. Datos del Asesor --}}
            <div>
                <h4 class="text-sm font-black text-blue-600 uppercase tracking-widest mb-4 flex items-center">
                    <span class="w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center mr-2 text-xs">1</span>
                    Datos del Asesor / Origen
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Asesor Responsable</label>
                        <select name="asesor" class="w-full bg-slate-50 border-none rounded-xl text-sm font-semibold text-slate-700 p-4 focus:ring-2 focus:ring-blue-500 shadow-inner cursor-pointer appearance-none">
                            <option value="">Seleccione su nombre...</option>
                            @foreach($asesores as $asesor)
                                <option value="{{ $asesor }}">{{ $asesor }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Fecha de Venta</label>
                        <input type="date" name="fecha" value="{{ date('Y-m-d') }}" class="w-full bg-slate-50 border-none rounded-xl text-sm font-semibold text-slate-700 p-4 focus:ring-2 focus:ring-blue-500 shadow-inner">
                    </div>
                </div>
            </div>

            <hr class="border-slate-100">

            {{-- 2. Datos del Cliente --}}
            <div>
                <h4 class="text-sm font-black text-blue-600 uppercase tracking-widest mb-4 flex items-center">
                    <span class="w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center mr-2 text-xs">2</span>
                    Datos del Cliente
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nombre Completo del Cliente</label>
                        <input type="text" name="cliente" class="w-full bg-slate-50 border-none rounded-xl text-sm font-semibold text-slate-700 p-4 focus:ring-2 focus:ring-blue-500 shadow-inner" placeholder="Ej: Maria Esperanza Gomez">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">DNI / Documento</label>
                        <input type="text" name="dni" class="w-full bg-slate-50 border-none rounded-xl text-sm font-semibold text-slate-700 p-4 focus:ring-2 focus:ring-blue-500 shadow-inner" placeholder="Ej: 72345678">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Celular / WhatsApp</label>
                        <input type="text" name="celular" class="w-full bg-slate-50 border-none rounded-xl text-sm font-semibold text-slate-700 p-4 focus:ring-2 focus:ring-blue-500 shadow-inner" placeholder="Ej: 999 888 777">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Correo Electrónico (Opcional)</label>
                        <input type="email" name="email" class="w-full bg-slate-50 border-none rounded-xl text-sm font-semibold text-slate-700 p-4 focus:ring-2 focus:ring-blue-500 shadow-inner" placeholder="cliente@email.com">
                    </div>
                </div>
            </div>

            <hr class="border-slate-100">

            {{-- 3. Detalle de Venta --}}
            <div>
                <h4 class="text-sm font-black text-blue-600 uppercase tracking-widest mb-4 flex items-center">
                    <span class="w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center mr-2 text-xs">3</span>
                    Detalle de Venta
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Producto / Diplomado</label>
                        <select name="producto" class="w-full bg-slate-50 border-none rounded-xl text-sm font-semibold text-slate-700 p-4 focus:ring-2 focus:ring-blue-500 shadow-inner">
                            <option value="">Seleccione Producto...</option>
                            @foreach($productos as $prod)
                                <option value="{{ $prod }}">{{ $prod }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Monto (S/ o $)</label>
                        <input type="number" step="0.01" name="monto" class="w-full bg-slate-50 border-none rounded-xl text-sm font-semibold text-slate-700 p-4 focus:ring-2 focus:ring-blue-500 shadow-inner" placeholder="0.00">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Método de Pago</label>
                        <select name="metodo_pago" class="w-full bg-slate-50 border-none rounded-xl text-sm font-semibold text-slate-700 p-4 focus:ring-2 focus:ring-blue-500 shadow-inner">
                            <option value="Transferencia BCP">Transferencia BCP</option>
                            <option value="Transferencia Interbank">Transferencia Interbank</option>
                            <option value="Yape / Plin">Yape / Plin</option>
                            <option value="Tarjeta de Crédito">Tarjeta de Crédito</option>
                            <option value="Efectivo">Efectivo</option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Observaciones</label>
                        <textarea name="observaciones" rows="3" class="w-full bg-slate-50 border-none rounded-xl text-sm font-semibold text-slate-700 p-4 focus:ring-2 focus:ring-blue-500 shadow-inner" placeholder="Comentarios adicionales..."></textarea>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-4 pt-6">
                <a href="{{ route('dashboard') }}" class="px-6 py-4 rounded-xl font-bold text-sm text-slate-500 hover:bg-slate-100 transition-colors">Cancelar</a>
                <button type="submit" class="px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-bold text-sm hover:shadow-lg hover:shadow-blue-500/30 transition-all transform hover:-translate-y-1">REGISTRAR VENTA</button>
            </div>
        </form>
    </div>
</div>
@endsection
