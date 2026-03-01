<!doctype html>
<html lang="es" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'profenicolas.cl')</title>
    <meta name="color-scheme" content="light">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="icon" href="/favicon.ico" sizes="32x32">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    @vite(['resources/js/app.js'])
    @livewireStyles
    @stack('meta')
</head>
<body class="text-body">
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container">
                <a href="{{ route('home') }}" class="navbar-brand fw-bold">
                    <i class="bi bi-mortarboard-fill me-2" aria-hidden="true"></i>Profe Nicolás
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
                        aria-controls="mainNav" aria-expanded="false" aria-label="Abrir menú">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div id="mainNav" class="collapse navbar-collapse">
                    <ul class="navbar-nav ms-auto align-items-lg-center gap-1">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('materials.*') ? 'active' : '' }}"
                               href="{{ route('materials.index') }}">Materiales</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}"
                               href="{{ route('about') }}">Sobre mí</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('services') ? 'active' : '' }}"
                               href="{{ route('services') }}">Servicios</a>
                        </li>
                        <li class="nav-item ms-lg-2">
                            <a class="btn btn-outline-light btn-sm {{ request()->routeIs('contact') ? 'active' : '' }}"
                               href="{{ route('contact') }}">Contacto</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main class="@yield('main_class', 'py-4 bg-body-tertiary')">
        @hasSection('full_content')
            @yield('full_content')
        @else
            <div class="container">
                {{ $slot ?? '' }}
                @yield('content')
            </div>
        @endif
    </main>

    <footer class="bg-dark text-white mt-auto">
        <div class="container py-5">
            <div class="row g-5">

                {{-- Marca y descripción --}}
                <div class="col-lg-4">
                    <a href="{{ route('home') }}" class="text-white text-decoration-none fw-bold fs-5">
                        <i class="bi bi-mortarboard-fill me-2" aria-hidden="true"></i>Profe Nicolás
                    </a>
                    <p class="text-white-50 small mt-3 mb-0">
                        Matemática que se entiende.<br>
                        Quintero, Región de Valparaíso.
                    </p>
                </div>

                {{-- Navegación --}}
                <div class="col-6 col-lg-2">
                    <h2 class="text-white-50 text-uppercase small fw-semibold mb-3">Navegación</h2>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <a href="{{ route('materials.index') }}" class="text-white-50 text-decoration-none small">Materiales</a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('about') }}" class="text-white-50 text-decoration-none small">Sobre mí</a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('services') }}" class="text-white-50 text-decoration-none small">Servicios</a>
                        </li>
                        <li>
                            <a href="{{ route('contact') }}" class="text-white-50 text-decoration-none small">Contacto</a>
                        </li>
                    </ul>
                </div>

                {{-- Contacto --}}
                <div class="col-6 col-lg-4">
                    <h2 class="text-white-50 text-uppercase small fw-semibold mb-3">Contacto</h2>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3 d-flex align-items-start gap-2">
                            <i class="bi bi-envelope-fill text-white-50 mt-1 flex-shrink-0 small" aria-hidden="true"></i>
                            <a href="mailto:hola@profenicolas.cl"
                               class="text-white-50 text-decoration-none small">hola@profenicolas.cl</a>
                        </li>
                        <li class="mb-3 d-flex align-items-start gap-2">
                            <i class="bi bi-clock-fill text-white-50 mt-1 flex-shrink-0 small" aria-hidden="true"></i>
                            <span class="text-white-50 small">Clases a partir de las 18:00 hrs</span>
                        </li>
                        <li class="d-flex align-items-start gap-2">
                            <i class="bi bi-laptop text-white-50 mt-1 flex-shrink-0 small" aria-hidden="true"></i>
                            <span class="text-white-50 small">Presencial en Quintero u online</span>
                        </li>
                    </ul>
                </div>

            </div>
        </div>

        {{-- Barra de copyright --}}
        <div class="border-top border-secondary">
            <div class="container py-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
                <span class="text-white-50 small">© {{ date('Y') }} Profesor Nicolás González M.</span>
                <span class="text-white-50 small">Quintero, Chile</span>
            </div>
        </div>
    </footer>
    @livewireScripts
</body>
</html>
