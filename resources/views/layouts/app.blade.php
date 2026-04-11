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
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-site sticky-top" aria-label="Navegación principal">
            <div class="container">
                <a href="{{ route('home') }}" class="navbar-brand-link">
                    <svg width="30" height="30" viewBox="0 0 30 30" fill="none" aria-hidden="true">
                        <line x1="5" y1="27" x2="5" y2="3"  stroke="#f59e0b" stroke-width="1" stroke-opacity=".4"/>
                        <line x1="3" y1="25" x2="27" y2="25" stroke="#f59e0b" stroke-width="1" stroke-opacity=".4"/>
                        <path d="M7 23 L7 7 L18 19 L18 7" stroke="#f59e0b" stroke-width="2.5" fill="none"
                              stroke-linejoin="round" stroke-linecap="round"/>
                    </svg>
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
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}"
                               href="{{ route('contact') }}">Contacto</a>
                        </li>
                        <li class="nav-item ms-lg-2">
                            <a class="btn btn-amber btn-sm" href="{{ route('materials.index') }}">
                                Ver materiales
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
            <div class="container py-4">
                {{ $slot ?? '' }}
                @yield('content')
            </div>
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
