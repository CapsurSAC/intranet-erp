<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Intranet ERP') | CAPSUR</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>

<body class="bg-slate-50 flex min-h-screen text-slate-900" x-data="{ sidebarOpen: true }">

    {{-- Sidebar --}}
    <aside :class="sidebarOpen ? 'w-72' : 'w-20'" class="bg-[#0f172a] text-slate-300 flex flex-col transition-all duration-300 shadow-2xl z-50">
        
        <div class="p-6 flex items-center justify-between border-b border-slate-800/50">
            <div class="flex items-center space-x-3" x-show="sidebarOpen">
                <div class="bg-blue-600 p-1.5 rounded-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <span class="text-lg font-bold tracking-tight text-white">INTRANET <span class="text-blue-500">ERP</span></span>
            </div>
            <button @click="sidebarOpen = !sidebarOpen" class="hover:bg-slate-800 p-1 rounded">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>

        <nav class="flex-1 p-4 overflow-y-auto space-y-8">
            
            {{-- Grupo: General --}}
            <div>
                <p x-show="sidebarOpen" class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-4">Principal</p>
                <a href="/dashboard" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all hover:bg-slate-800 hover:text-white {{ request()->is('dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span x-show="sidebarOpen" class="font-medium">Dashboard</span>
                </a>
            </div>

            {{-- Grupo: Ventas & Comercial --}}
            <div x-data="{ open: {{ request()->is('ventas*') || request()->is('importaciones*') ? 'true' : 'false' }} }">
                <p x-show="sidebarOpen" class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-4">Comercial</p>
                
                <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 rounded-xl hover:bg-slate-800 transition-all">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span x-show="sidebarOpen" class="font-medium text-slate-300">Ventas</span>
                    </div>
                    <svg x-show="sidebarOpen" :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
                </button>

                <div x-show="open && sidebarOpen" x-collapse class="pl-12 mt-2 space-y-2">
                    <a href="/ventas" class="block text-sm py-2 hover:text-white transition-colors {{ request()->is('ventas') ? 'text-blue-400 font-bold' : 'text-slate-500' }}">Listado de Ventas</a>
                    <a href="/importaciones/ventas" class="block text-sm py-2 hover:text-white transition-colors {{ request()->is('importaciones/ventas') ? 'text-blue-400 font-bold' : 'text-slate-500' }}">Importar Histórico</a>
                </div>
            </div>

            {{-- Grupo: Académico (Sistemas del Sur) --}}
            <div>
                <p x-show="sidebarOpen" class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-4">Académico</p>
                <a href="/alumnos" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition-all">
                    <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                    <span x-show="sidebarOpen" class="font-medium">Gestión de Alumnos</span>
                </a>
            </div>

        </nav>

        <div class="p-6 border-t border-slate-800/50 bg-slate-900/50">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center font-bold text-white shadow-lg">
                    C
                </div>
                <div x-show="sidebarOpen">
                    <p class="text-sm font-bold text-white leading-none">Carlos</p>
                    <p class="text-[10px] text-slate-500 mt-1 uppercase font-bold tracking-tighter">Sistemas Ing.</p>
                </div>
            </div>
        </div>
    </aside>

    {{-- Main Content Area --}}
    <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
        
        <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-8 shadow-sm">
            <div class="flex items-center">
                <h2 class="text-xl font-bold text-slate-800">
                    @yield('page_title', 'Bienvenido')
                </h2>
            </div>
            
            <div class="flex items-center space-x-6">
                <span class="text-xs font-bold text-slate-400 px-3 py-1 bg-slate-100 rounded-full">Tacna, PE</span>
                <button class="text-slate-400 hover:text-slate-600 relative">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                </button>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-8">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </div>
    </main>

</body>
</html>