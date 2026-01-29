<!DOCTYPE html>
<html lang="es">
    <script>
tailwind.config = {
  theme: {
    extend: {
      borderRadius: {
        xl: '1rem',
        '2xl': '1.25rem'
      }
    }
  }
}
</script>


<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Intranet ERP')</title>
   
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
