<!doctype html>
<html lang="es" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'profenicolas.cl')</title>
    <meta name="color-scheme" content="light">
    @vite(['resources/js/app.js'])
    @livewireStyles
    @stack('meta')
</head>
<body class="text-body">
    @php
        $is = fn(string $name) => request()->routeIs($name) ? 'text-azulchile underline' : 'hover:underline';
    @endphp
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container">
                <a href="{{ route('home') }}" class="navbar-brand fw-bold">Profe Nicolás</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div id="mainNav" class="collapse navbar-collapse">
                    <ul class="navbar-nav ms-auto align-items-lg-center gap-2">
                        <li class="nav-item"><a class="nav-link" href="{{ route('materials.index') }}">Materiales</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">Sobre mí</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('services') }}">Servicios</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contacto</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main class="py-4 bg-body-tertiary">
        <div class="container">
            {{ $slot ?? '' }}
            @yield('content')
        </div>
    </main>

    <footer class="border-top py-4">
        <div class="container small text-muted d-flex flex-wrap gap-2 justify-content-between">
            <span>© {{ date('Y') }} Profesor Nicolás González M.</span>
        </div>
    </footer>
    @livewireScripts
</body>
</html>
