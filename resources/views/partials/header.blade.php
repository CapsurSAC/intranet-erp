<header
    class="h-16 bg-white/70 backdrop-blur
           border-b border-slate-200
           flex items-center justify-between
           px-6 shadow-sm">

    <div class="font-semibold text-slate-700">
        @yield('page_title', 'Dashboard')
    </div>

    <div class="flex items-center gap-4 text-sm text-slate-600">
        <span>👤 Admin</span>
        <button
            class="px-3 py-1 rounded-lg
                   bg-slate-100 hover:bg-slate-200
                   transition">
            Salir
        </button>
    </div>
</header>
