@extends('layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard General')

@section('content')

{{-- KPIs --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

    <div class="bg-white p-6 rounded-xl shadow">
        <p class="text-sm text-gray-500">Ventas Totales</p>
        <p class="text-3xl font-bold text-blue-600">623</p>
    </div>

    <div class="bg-white p-6 rounded-xl shadow">
        <p class="text-sm text-gray-500">Ventas Hoy</p>
        <p class="text-3xl font-bold text-green-600">90</p>
    </div>

    <div class="bg-white p-6 rounded-xl shadow">
        <p class="text-sm text-gray-500">Clientes Únicos</p>
        <p class="text-3xl font-bold text-purple-600">412</p>
    </div>

</div>

{{-- Tabla --}}
<div class="bg-white rounded-xl shadow p-6">
    <h2 class="text-lg font-semibold mb-4">Últimas ventas registradas</h2>

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left">Fecha</th>
                    <th class="px-4 py-2 text-left">DNI</th>
                    <th class="px-4 py-2 text-left">Cliente</th>
                    <th class="px-4 py-2 text-left">Curso</th>
                    <th class="px-4 py-2 text-left">Monto</th>
                </tr>
            </thead>
            <tbody>
                {{-- FAKE DATA (luego será @foreach) --}}
                <tr class="border-t">
                    <td class="px-4 py-2">28/01/2026</td>
                    <td class="px-4 py-2">70069369</td>
                    <td class="px-4 py-2">Luis Apaza</td>
                    <td class="px-4 py-2">CEGAVA</td>
                    <td class="px-4 py-2 font-semibold">S/ 250</td>
                </tr>
                <tr class="border-t">
                    <td class="px-4 py-2">28/01/2026</td>
                    <td class="px-4 py-2">94331053</td>
                    <td class="px-4 py-2">María Flores</td>
                    <td class="px-4 py-2">SIS</td>
                    <td class="px-4 py-2 font-semibold">S/ 180</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection
