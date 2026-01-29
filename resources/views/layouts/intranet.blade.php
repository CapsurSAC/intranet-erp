<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Intranet ERP')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 antialiased">

<div class="flex h-screen overflow-hidden">

    {{-- SIDEBAR --}}
    @include('partials.sidebar')

    {{-- MAIN --}}
    <div class="flex-1 flex flex-col">

        {{-- HEADER --}}
        @include('partials.header')

        {{-- CONTENT --}}
        <main
            class="flex-1 overflow-y-auto p-6
                   animate-fade-in"
        >
            @yield('content')
        </main>
    </div>

</div>

</body>
</html>
