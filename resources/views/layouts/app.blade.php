<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Intranet ERP')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex min-h-screen">

    {{-- Sidebar --}}
    <aside class="w-64 bg-slate-900 text-white flex flex-col">
        <div class="p-4 text-xl font-bold border-b border-slate-700">
            📊 Intranet ERP
        </div>

        <nav class="flex-1 p-4 space-y-2">
            <a href="/dashboard" class="block px-3 py-2 rounded hover:bg-slate-700">
                📈 Dashboard
            </a>
            <a href="/ventas" class="block px-3 py-2 rounded hover:bg-slate-700">
                💰 Ventas
            </a>
            <a href="/importaciones/ventas" class="block px-3 py-2 rounded hover:bg-slate-700">
                ⬆ Importar Ventas
            </a>
        </nav>

        <div class="p-4 text-sm border-t border-slate-700">
            Admin conectado
        </div>
    </aside>

    {{-- Main --}}
    <main class="flex-1 p-6">
        <header class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">
                @yield('header')
            </h1>
        </header>

        @yield('content')
    </main>

</body>
</html>
