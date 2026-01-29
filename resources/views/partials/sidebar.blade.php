<aside class="w-64 bg-gradient-to-b from-slate-900 to-slate-800
             text-slate-200 flex flex-col shadow-xl">

    {{-- LOGO --}}
    <div class="px-6 py-5 text-xl font-bold tracking-wide flex items-center gap-2">
        🧠 Intranet ERP
    </div>

    {{-- MENU --}}
    <nav class="flex-1 px-4 space-y-2 mt-4 text-sm">

        <a href="#"
           class="flex items-center gap-3 px-4 py-3 rounded-xl
                  bg-slate-700/50 text-white">
            📊 Dashboard
        </a>

        <a href="#"
           class="flex items-center gap-3 px-4 py-3 rounded-xl
                  hover:bg-slate-700/40 transition">
            💰 Ventas
        </a>

        <a href="{{ url('/importaciones/ventas') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl
                  hover:bg-slate-700/40 transition">
            📥 Importar ventas
        </a>

    </nav>

    {{-- FOOTER --}}
    <div class="px-4 py-4 border-t border-slate-700 text-xs text-slate-400">
        Admin conectado
    </div>
</aside>
