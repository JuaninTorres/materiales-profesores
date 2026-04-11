<!doctype html>
<html lang="es" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'profenicolas.cl')</title>
    <meta name="description" content="@yield('description', 'Materiales gratuitos de matemática y clases particulares con Nicolás González, profesor en Quintero, Chile. Para colegio, PAES, CFT y universidad.')">
    <meta name="color-scheme" content="light">

    {{-- Open Graph --}}
    <meta property="og:site_name" content="Profe Nicolás">
    <meta property="og:locale" content="es_CL">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="{{ $__env->yieldContent('og_title') ?: $__env->yieldContent('title', 'Profe Nicolás · Matemática') }}">
    <meta property="og:description" content="{{ $__env->yieldContent('og_description') ?: $__env->yieldContent('description', 'Materiales gratuitos de matemática y clases particulares con Nicolás González, profesor en Quintero, Chile.') }}">
    <meta property="og:url" content="@yield('og_url', request()->url())">
    <meta property="og:image" content="@yield('og_image', asset('images/og-default.jpg'))">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $__env->yieldContent('og_title') ?: $__env->yieldContent('title', 'Profe Nicolás') }}">
    <meta name="twitter:description" content="{{ $__env->yieldContent('og_description') ?: $__env->yieldContent('description', 'Materiales gratuitos de matemática y clases particulares.') }}">
    <meta name="twitter:image" content="@yield('og_image', asset('images/og-default.jpg'))">

    {{-- Canonical --}}
    <link rel="canonical" href="@yield('canonical', request()->url())">

    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="icon" href="/favicon.ico" sizes="32x32">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    @vite(['resources/js/app.js'])
    @livewireStyles
    @stack('meta')
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-site fixed-top" aria-label="Navegación principal">
            <div class="container">
                <a href="{{ route('home') }}" class="navbar-brand-link">
                    <img src="/images/logo.svg" class="navbar-logo" height="36" alt="" aria-hidden="true">
                    Profe <span class="brand-accent">Nicolás</span>
                </a>

                <button class="navbar-toggler" type="button"
                        data-bs-toggle="collapse" data-bs-target="#mainNav"
                        aria-controls="mainNav" aria-expanded="false" aria-label="Abrir menú">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div id="mainNav" class="collapse navbar-collapse">
                    <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
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
                            <a class="btn btn-amber btn-sm" href="{{ route('contact') }}">
                                Consultar
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="@yield('main_class', '')">
        @hasSection('full_content')
            @yield('full_content')
        @else
            {{ $slot ?? '' }}
            @yield('content')
        @endif
    </main>

    <footer class="site-footer">
        <div class="container">
            <div class="row g-4 pb-4 pt-4">
                <div class="col-lg-4">
                    <div class="footer-brand">Profe Nicolás</div>
                    <p class="footer-tagline">
                        Matemática que se entiende.<br>
                        Materiales gratuitos y clases particulares<br>
                        para todos los niveles. Quintero, Chile.
                    </p>
                </div>
                <div class="col-sm-4 col-lg-2 offset-lg-2">
                    <p class="footer-col-h">Explorar</p>
                    <a href="{{ route('materials.index') }}" class="footer-link">Materiales</a>
                    <a href="{{ route('about') }}" class="footer-link">Sobre mí</a>
                    <a href="{{ route('services') }}" class="footer-link">Servicios</a>
                    <a href="{{ route('contact') }}" class="footer-link">Contacto</a>
                </div>
                <div class="col-sm-8 col-lg-4">
                    <p class="footer-col-h">Contacto</p>
                    <div class="footer-contact-row">
                        <i class="bi bi-envelope" aria-hidden="true"></i>
                        <a href="mailto:hola@profenicolas.cl" class="footer-link d-inline">hola@profenicolas.cl</a>
                    </div>
                    <div class="footer-contact-row">
                        <i class="bi bi-geo-alt" aria-hidden="true"></i>
                        <span>Quintero, Valparaíso, Chile</span>
                    </div>
                    <div class="footer-contact-row">
                        <i class="bi bi-clock" aria-hidden="true"></i>
                        <span>Clases desde las 18:00 hrs.</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container d-flex flex-wrap justify-content-between align-items-center gap-2">
                <span>© {{ date('Y') }} Profe Nicolás González — Todos los derechos reservados</span>
                <span>Hecho en Chile</span>
            </div>
        </div>
    </footer>

    @livewireScripts
    @stack('scripts')
</body>
</html>
