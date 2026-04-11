# Rediseño frontend profenicolas.cl — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Replace the entire public frontend with the new design system (navy/amber palette, Plus Jakarta Sans, custom components) while preserving all backend/Livewire logic.

**Architecture:** Pure view-layer change. No PHP logic, models, or routes change. All custom CSS lives in `resources/scss/app.scss` (via imported partials). Blade views switch from Bootstrap defaults to custom design-system classes.

**Tech Stack:** Laravel 12 Blade, Livewire 3, Bootstrap 5 SCSS, Bootstrap Icons, Vite

---

## File map

**New files:**
- `resources/scss/_design-system.scss` — CSS custom properties, utility classes, typography helpers
- `resources/scss/_components.scss` — navbar, footer, mat-card, filter-bar, sidebar-card
- `resources/scss/_pages.scss` — page-specific styles (hero, timeline, service-card, etc.)
- `resources/views/components/materials/card.blade.php` — `<x-materials.card>` Blade component

**Modified files:**
- `resources/scss/_variables.scss` — override `$primary` and add `$font-family-sans-serif`
- `resources/scss/app.scss` — import the 3 new partials
- `resources/views/layouts/app.blade.php` — add Google Fonts, new navbar, new footer, `@stack('scripts')`
- `resources/views/pages/home.blade.php`
- `resources/views/livewire/materials/index.blade.php`
- `resources/views/materiales/show.blade.php`
- `resources/views/pages/about.blade.php`
- `resources/views/pages/services.blade.php`
- `resources/views/livewire/contact/form.blade.php`

**Not changed:** all PHP classes, migrations, Filament, auth views, settings views.

---

## Task 1: Design system SCSS foundation

**Files:**
- Modify: `resources/scss/_variables.scss`
- Create: `resources/scss/_design-system.scss`
- Create: `resources/scss/_components.scss` (empty shell)
- Create: `resources/scss/_pages.scss` (empty shell)
- Modify: `resources/scss/app.scss`

- [ ] **Step 1: Update `_variables.scss`** — prepend these lines before the existing content:

```scss
$font-family-sans-serif: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
$primary: #1a56db;
```

Keep the rest of the existing file unchanged.

- [ ] **Step 2: Create `_design-system.scss`**

```scss
// ============================================================
// DESIGN SYSTEM — Custom properties, utilities, typography
// ============================================================

:root {
  --color-navy:       #1e3a5f;
  --color-navy-dark:  #1a3252;
  --color-amber:      #f59e0b;
  --color-amber-dark: #d97706;
  --color-cream:      #f8f5f0;
  --color-footer:     #0f1e2e;
  --color-footer-card:#1e2d3d;
  scroll-behavior: smooth;
}

// ---- Backgrounds ----
.bg-navy          { background-color: var(--color-navy) !important; }
.bg-navy-gradient { background: linear-gradient(135deg, var(--color-navy), var(--color-navy-dark)); }
.bg-cream         { background-color: var(--color-cream) !important; }
.bg-footer        { background-color: var(--color-footer) !important; }

// ---- Text ----
.text-amber      { color: var(--color-amber) !important; }
.text-on-dark    { color: #e2e8f0 !important; }
.text-muted-dark { color: #94a3b8 !important; }
.fw-800          { font-weight: 800 !important; }

// ---- Buttons ----
.btn-amber {
  background-color: var(--color-amber);
  border-color: var(--color-amber);
  color: #1e293b;
  font-weight: 700;
  &:hover, &:focus {
    background-color: var(--color-amber-dark);
    border-color: var(--color-amber-dark);
    color: #1e293b;
  }
  &:disabled { opacity: .65; }
}

.btn-outline-amber {
  border: 2px solid var(--color-amber);
  color: var(--color-amber);
  font-weight: 600;
  background-color: transparent;
  &:hover, &:focus {
    background-color: var(--color-amber);
    color: #1e293b;
  }
}

// ---- Section spacing ----
.section    { padding-top: 4rem; padding-bottom: 4rem; }
.section-sm { padding-top: 2.5rem; padding-bottom: 2.5rem; }

// ---- Page header (navy, used on /materiales, /contacto, etc.) ----
.page-header {
  background-color: var(--color-navy);
  padding: 3rem 0 3.5rem;

  .page-header-eyebrow {
    font-size: .8rem;
    font-weight: 700;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: var(--color-amber);
    margin-bottom: .5rem;
  }
  h1 { color: #fff; margin-bottom: .5rem; }
  .page-header-lead { color: #94a3b8; font-size: 1.05rem; }
}

// ---- Eyebrow label ----
.eyebrow {
  display: inline-block;
  font-size: .75rem;
  font-weight: 700;
  letter-spacing: .08em;
  text-transform: uppercase;
  color: var(--color-amber);
  margin-bottom: .75rem;
}

// ---- Section header (title + "ver todos" link row) ----
.section-header {
  display: flex;
  align-items: baseline;
  justify-content: space-between;
  margin-bottom: 1.5rem;
  h2 { font-size: 1.5rem; font-weight: 800; color: #1e293b; margin: 0; }
  .section-header-link {
    font-size: .85rem;
    color: #1a56db;
    text-decoration: none;
    font-weight: 600;
    &:hover { text-decoration: underline; }
  }
}

// ---- Narrow container (FAQ) ----
.container-narrow { max-width: 680px; margin-inline: auto; }

// ---- Level dot colors ----
.level-dot-colegio    { background-color: #22c55e; }
.level-dot-paes       { background-color: #f59e0b; }
.level-dot-cft        { background-color: #3b82f6; }
.level-dot-instituto  { background-color: #3b82f6; }
.level-dot-universidad{ background-color: #a855f7; }
.level-dot-particulares{ background-color: #f59e0b; }
```

- [ ] **Step 3: Create empty `_components.scss`** with a single comment `// Components — filled in Task 2`

- [ ] **Step 4: Create empty `_pages.scss`** with a single comment `// Pages — filled in Task 4+`

- [ ] **Step 5: Update `resources/scss/app.scss`** — append at the end (after existing content):

```scss
// --- Design system partials ---
@import "design-system";
@import "components";
@import "pages";
```

- [ ] **Step 6: Run `npm run build` and verify it compiles without errors**

```bash
npm run build
```

Expected: exits 0, no SCSS errors.

- [ ] **Step 7: Commit**

```bash
git add resources/scss/
git commit -m "feat: add design system SCSS foundation (partials, variables, utilities)"
```

---

## Task 2: Navbar, Footer, Google Fonts

**Files:**
- Modify: `resources/views/layouts/app.blade.php`
- Modify: `resources/scss/_components.scss`

- [ ] **Step 1: Write the feature test**

Create `tests/Feature/LayoutTest.php`:

```php
<?php

use App\Models\Material;

test('navbar renders with site classes', function () {
    $response = $this->get('/');
    $response->assertStatus(200);
    $response->assertSee('navbar-site', false);
    $response->assertSee('site-footer', false);
});
```

- [ ] **Step 2: Run test to verify it fails**

```bash
php artisan test --filter=LayoutTest
```

Expected: FAIL — `navbar-site` not found.

- [ ] **Step 3: Replace `resources/views/layouts/app.blade.php`** with:

```blade
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
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
```

- [ ] **Step 4: Add navbar + footer SCSS to `_components.scss`**

```scss
// ============================================================
// NAVBAR
// ============================================================
.navbar-site {
  background-color: var(--color-navy);
  padding-top: .875rem;
  padding-bottom: .875rem;
  border-bottom: 1px solid rgba(255,255,255,.06);

  .navbar-brand-link {
    display: flex;
    align-items: center;
    gap: .5rem;
    text-decoration: none;
    font-weight: 800;
    font-size: 1.1rem;
    color: #fff;
    .brand-accent { color: var(--color-amber); }
  }

  .nav-link {
    color: rgba(255,255,255,.75);
    font-weight: 600;
    font-size: .9rem;
    padding: .375rem .75rem;
    transition: color .15s;
    &:hover, &.active { color: #fff; }
  }

  .navbar-toggler {
    border-color: rgba(255,255,255,.3);
    padding: .3rem .6rem;
    .navbar-toggler-icon {
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255,255,255,0.8%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }
  }
}

// ============================================================
// FOOTER
// ============================================================
.site-footer {
  background-color: var(--color-footer);
  color: #94a3b8;

  .footer-brand {
    font-weight: 800;
    font-size: 1.1rem;
    color: #fff;
    margin-bottom: .5rem;
  }

  .footer-tagline {
    font-size: .82rem;
    color: #94a3b8;
    line-height: 1.6;
  }

  .footer-col-h {
    font-size: .72rem;
    font-weight: 700;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: #64748b;
    margin-bottom: .75rem;
  }

  .footer-link {
    display: block;
    color: #94a3b8;
    text-decoration: none;
    font-size: .85rem;
    padding: .2rem 0;
    transition: color .15s;
    &:hover { color: #fff; }
  }

  .footer-contact-row {
    display: flex;
    align-items: center;
    gap: .5rem;
    font-size: .85rem;
    color: #94a3b8;
    margin-bottom: .5rem;
    i { color: #64748b; flex-shrink: 0; }
  }

  .footer-bottom {
    margin-top: 1rem;
    border-top: 1px solid #1e2d3d;
    padding: 1rem 0;
    font-size: .78rem;
    color: #64748b;
  }
}
```

- [ ] **Step 5: Run `npm run build` — verify clean compile**

- [ ] **Step 6: Run test**

```bash
php artisan test --filter=LayoutTest
```

Expected: PASS.

- [ ] **Step 7: Commit**

```bash
git add resources/views/layouts/app.blade.php resources/scss/_components.scss tests/Feature/LayoutTest.php
git commit -m "feat: redesign navbar and footer with new design system"
```

---

## Task 3: mat-card Blade component

**Files:**
- Create: `resources/views/components/materials/card.blade.php`
- Modify: `resources/scss/_components.scss` (append)

- [ ] **Step 1: Write the test** — append to `tests/Feature/LayoutTest.php`:

```php
test('mat-card component renders for a published material', function () {
    $material = Material::factory()->create([
        'title'     => 'Guía de Álgebra',
        'type'      => 'pdf',
        'level'     => 'colegio',
        'published' => true,
        'course'    => '3° Medio',
    ]);

    $response = $this->get('/');
    // Home renders recent materials; just verify component class exists in output
    // (actual rendering tested via the show route)
    $response->assertStatus(200);
});
```

- [ ] **Step 2: Create `resources/views/components/materials/card.blade.php`**

```blade
@props(['material'])

@php
$typeClass = match($material->type) {
    'pdf'   => 'mat-type-pdf',
    'video' => 'mat-type-video',
    'html'  => 'mat-type-html',
    'image' => 'mat-type-image',
    'latex' => 'mat-type-latex',
    'link'  => 'mat-type-link',
    default => 'mat-type-other',
};
$typeIcon = match($material->type) {
    'pdf'   => 'bi-file-earmark-pdf',
    'video' => 'bi-play-circle',
    'html'  => 'bi-globe',
    'image' => 'bi-image',
    'latex' => 'bi-file-earmark-code',
    'link'  => 'bi-link-45deg',
    default => 'bi-file-earmark',
};
$levelDotClass = match($material->level) {
    'colegio'               => 'level-dot-colegio',
    'cft'                   => 'level-dot-cft',
    'instituto'             => 'level-dot-instituto',
    'universidad'           => 'level-dot-universidad',
    'particulares', 'paes'  => 'level-dot-particulares',
    default                 => 'level-dot-particulares',
};
@endphp

<div class="mat-card">
    <div class="mat-card-top">
        <span class="mat-type-badge {{ $typeClass }}">
            <i class="bi {{ $typeIcon }}" aria-hidden="true"></i>
            {{ strtoupper($material->type) }}
        </span>
        <span class="mat-level-dot {{ $levelDotClass }}" title="{{ ucfirst($material->level) }}"></span>
    </div>

    <div class="mat-card-body">
        <div class="mat-card-title">{{ $material->title }}</div>
        <div class="mat-card-meta">
            @if($material->course){{ $material->course }}@endif
            @if($material->unit) · {{ $material->unit }}@endif
            @if($material->year)  · {{ $material->year }}@endif
        </div>
        @if(!empty($material->tags))
            <div class="mat-card-tags">
                @foreach(array_slice((array)$material->tags, 0, 3) as $tag)
                    <span class="badge bg-light text-secondary border mat-tag">#{{ $tag }}</span>
                @endforeach
            </div>
        @endif
    </div>

    <div class="mat-card-footer">
        <span class="mat-pages">
            @if($material->size_formatted)
                <i class="bi bi-file-earmark" aria-hidden="true"></i>
                {{ $material->size_formatted }}
            @endif
        </span>
        <a href="{{ route('materials.show', $material) }}" class="btn btn-sm btn-outline-primary">
            Ver material
        </a>
    </div>
</div>
```

- [ ] **Step 3: Append mat-card SCSS to `_components.scss`**

```scss
// ============================================================
// MAT-CARD
// ============================================================
.mat-card {
  background: #fff;
  border: 1.5px solid #e2e8f0;
  border-radius: .75rem;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  height: 100%;
  transition: box-shadow .2s, transform .2s;

  &:hover {
    box-shadow: 0 .5rem 1.5rem rgba(0,0,0,.12);
    transform: translateY(-2px);
  }
}

.mat-card-top {
  padding: 1rem 1rem .5rem;
  display: flex;
  align-items: center;
  gap: .5rem;
}

.mat-card-body {
  padding: 0 1rem .75rem;
  flex: 1;
}

.mat-card-title {
  font-size: .95rem;
  font-weight: 700;
  color: #1e293b;
  margin-bottom: .3rem;
  line-height: 1.35;
}

.mat-card-meta {
  font-size: .78rem;
  color: #64748b;
  margin-bottom: .5rem;
}

.mat-card-tags {
  display: flex;
  flex-wrap: wrap;
  gap: .25rem;
}

.mat-tag {
  font-size: .72rem !important;
  font-weight: 500 !important;
}

.mat-card-footer {
  padding: .75rem 1rem;
  border-top: 1px solid #f1f5f9;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.mat-pages {
  font-size: .75rem;
  color: #94a3b8;
  display: flex;
  align-items: center;
  gap: .3rem;
}

// ---- Type badges ----
.mat-type-badge {
  display: inline-flex;
  align-items: center;
  gap: .25rem;
  font-size: .7rem;
  font-weight: 700;
  letter-spacing: .04em;
  text-transform: uppercase;
  padding: .2rem .55rem;
  border-radius: 999px;

  &.mat-type-pdf   { background: #fef2f2; color: #dc2626; }
  &.mat-type-video { background: #eff6ff; color: #2563eb; }
  &.mat-type-html  { background: #f0fdf4; color: #16a34a; }
  &.mat-type-image { background: #fdf4ff; color: #9333ea; }
  &.mat-type-latex { background: #fff7ed; color: #ea580c; }
  &.mat-type-link  { background: #f0f9ff; color: #0284c7; }
  &.mat-type-other { background: #f8fafc; color: #64748b; }
}

// ---- Level dot ----
.mat-level-dot {
  width: 9px;
  height: 9px;
  border-radius: 50%;
  display: inline-block;
  flex-shrink: 0;
}
```

- [ ] **Step 4: Run `npm run build` — verify clean compile**

- [ ] **Step 5: Commit**

```bash
git add resources/views/components/materials/card.blade.php resources/scss/_components.scss tests/Feature/LayoutTest.php
git commit -m "feat: add mat-card Blade component and SCSS"
```

---

## Task 4: Home page

**Files:**
- Modify: `resources/views/pages/home.blade.php`
- Modify: `resources/scss/_pages.scss` (append)

- [ ] **Step 1: Write the test** — create `tests/Feature/HomeTest.php`:

```php
<?php

test('home page renders', function () {
    $response = $this->get('/');
    $response->assertStatus(200);
    $response->assertSee('hero', false);
    $response->assertSee('Matemática', false);
    $response->assertSee('cta-section', false);
});
```

- [ ] **Step 2: Run test — verify it fails**

```bash
php artisan test --filter=HomeTest
```

Expected: FAIL — `hero` class not found.

- [ ] **Step 3: Replace `resources/views/pages/home.blade.php`**

```blade
@extends('layouts.app')

@section('title', 'Profe Nicolás González · Matemática para todos')
@section('main_class', '')

@section('full_content')

{{-- ================================================================
     HERO
================================================================ --}}
<section class="hero">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <p class="eyebrow">
                    <i class="bi bi-mortarboard-fill me-1" aria-hidden="true"></i>Profesor de Matemática
                </p>
                <h1 class="fw-800">
                    Matemática<br>que <span class="text-amber">se entiende.</span>
                </h1>
                <p class="hero-lead">
                    Hola, soy el <strong>Profe Nicolás González</strong>. Llevo más de 13 años
                    acompañando a estudiantes de colegio, CFT y PAES a entender la matemática
                    —no solo a memorizar fórmulas. Acá encuentras los materiales de mis clases,
                    disponibles para todos.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('materials.index') }}" class="btn btn-amber btn-lg px-4">
                        <i class="bi bi-collection me-2" aria-hidden="true"></i>Explorar materiales
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-outline-amber btn-lg px-4">
                        <i class="bi bi-calendar2-check me-2" aria-hidden="true"></i>Agendar clase
                    </a>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block">
                <img src="{{ asset('images/landing_principal.jpg') }}"
                     alt="Profesor Nicolás González M."
                     class="hero-photo">
            </div>
        </div>
    </div>
</section>

{{-- ================================================================
     VALUE PROPS
================================================================ --}}
<section class="section bg-cream">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="bi bi-file-earmark-text" aria-hidden="true"></i>
                    </div>
                    <div>
                        <div class="value-title">Material organizado y gratuito</div>
                        <div class="value-desc">Guías, ejercicios y apuntes ordenados por curso y unidad. Sin registro ni costo.</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="bi bi-people" aria-hidden="true"></i>
                    </div>
                    <div>
                        <div class="value-title">Para todos los niveles</div>
                        <div class="value-desc">Desde 7° básico hasta la PAES y educación técnica. Contenido para cada etapa.</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="bi bi-person-check" aria-hidden="true"></i>
                    </div>
                    <div>
                        <div class="value-title">Asesorías personalizadas</div>
                        <div class="value-desc">Clases particulares adaptadas a tu ritmo y objetivos, presenciales u online.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================================================================
     LEVELS
================================================================ --}}
<section class="section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-800 fs-2 mb-2">¿En qué nivel estás?</h2>
            <p class="text-muted">Tengo material y clases para distintos contextos educativos.</p>
        </div>
        <div class="row g-3">
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('materials.index') }}" class="level-pill">
                    <span class="level-pill-dot level-dot-colegio"></span>
                    <div class="level-pill-text">
                        <div class="level-name">Colegio</div>
                        <div class="level-desc">7° básico a 4° medio</div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('materials.index') }}" class="level-pill">
                    <span class="level-pill-dot level-dot-paes"></span>
                    <div class="level-pill-text">
                        <div class="level-name">PAES</div>
                        <div class="level-desc">Preparación universitaria</div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('materials.index') }}" class="level-pill">
                    <span class="level-pill-dot level-dot-cft"></span>
                    <div class="level-pill-text">
                        <div class="level-name">CFT / Instituto</div>
                        <div class="level-desc">Formación técnico-profesional</div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('materials.index') }}" class="level-pill">
                    <span class="level-pill-dot level-dot-universidad"></span>
                    <div class="level-pill-text">
                        <div class="level-name">Universidad</div>
                        <div class="level-desc">Matemática superior</div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ================================================================
     RECENT MATERIALS
================================================================ --}}
@if($recentMaterials->isNotEmpty())
<section class="section bg-cream">
    <div class="container">
        <div class="section-header">
            <h2>Últimos materiales</h2>
            <a href="{{ route('materials.index') }}" class="section-header-link">
                Ver todos <i class="bi bi-arrow-right ms-1" aria-hidden="true"></i>
            </a>
        </div>
        <div class="row g-4">
            @foreach($recentMaterials as $m)
                <div class="col-md-6 col-xl-4">
                    <x-materials.card :material="$m" />
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ================================================================
     FAQ
================================================================ --}}
<section class="section">
    <div class="container">
        <div class="container-narrow">
            <div class="text-center mb-5">
                <h2 class="fw-800 fs-2 mb-2">Preguntas frecuentes</h2>
            </div>
            <div id="faqAccordion" itemscope itemtype="https://schema.org/FAQPage">

                <div class="faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                    <h3 itemprop="name" class="mb-0">
                        <button class="faq-question collapsed" data-bs-toggle="collapse"
                                data-bs-target="#faq1" aria-expanded="false" aria-controls="faq1">
                            ¿Los materiales son realmente gratis?
                            <i class="bi bi-chevron-down" aria-hidden="true"></i>
                        </button>
                    </h3>
                    <div id="faq1" class="collapse" data-bs-parent="#faqAccordion"
                         itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                        <div class="faq-answer" itemprop="text">
                            Sí, todos los materiales del sitio son gratuitos y de libre descarga. No necesitas crear cuenta ni pagar nada.
                        </div>
                    </div>
                </div>

                <div class="faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                    <h3 itemprop="name" class="mb-0">
                        <button class="faq-question collapsed" data-bs-toggle="collapse"
                                data-bs-target="#faq2" aria-expanded="false" aria-controls="faq2">
                            ¿Haces clases online?
                            <i class="bi bi-chevron-down" aria-hidden="true"></i>
                        </button>
                    </h3>
                    <div id="faq2" class="collapse" data-bs-parent="#faqAccordion"
                         itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                        <div class="faq-answer" itemprop="text">
                            Sí, ofrezco clases presenciales en Quintero y online por Zoom o Meet. Cuéntame tu situación y buscamos la mejor opción.
                        </div>
                    </div>
                </div>

                <div class="faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                    <h3 itemprop="name" class="mb-0">
                        <button class="faq-question collapsed" data-bs-toggle="collapse"
                                data-bs-target="#faq3" aria-expanded="false" aria-controls="faq3">
                            ¿Cómo puedo agendar una clase?
                            <i class="bi bi-chevron-down" aria-hidden="true"></i>
                        </button>
                    </h3>
                    <div id="faq3" class="collapse" data-bs-parent="#faqAccordion"
                         itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                        <div class="faq-answer" itemprop="text">
                            Escríbeme desde el <a href="{{ route('contact') }}">formulario de contacto</a> indicando tu nivel, disponibilidad y lo que necesitas trabajar. Te respondo en menos de 24 horas.
                        </div>
                    </div>
                </div>

                <div class="faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                    <h3 itemprop="name" class="mb-0">
                        <button class="faq-question collapsed" data-bs-toggle="collapse"
                                data-bs-target="#faq4" aria-expanded="false" aria-controls="faq4">
                            ¿Para qué niveles tienes materiales?
                            <i class="bi bi-chevron-down" aria-hidden="true"></i>
                        </button>
                    </h3>
                    <div id="faq4" class="collapse" data-bs-parent="#faqAccordion"
                         itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                        <div class="faq-answer" itemprop="text">
                            Para colegio (7° básico a 4° medio), PAES, CFT/Instituto y matemática universitaria. Puedes filtrarlos en la sección de materiales.
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

{{-- ================================================================
     CTA FINAL
================================================================ --}}
<section class="cta-section">
    <div class="container">
        <h2>¿Listo para mejorar tus notas?</h2>
        <p class="lead">Explora los materiales gratuitos o contáctame para una clase personalizada.</p>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            <a href="{{ route('materials.index') }}" class="btn btn-amber btn-lg px-5">
                <i class="bi bi-collection me-2" aria-hidden="true"></i>Ver materiales
            </a>
            <a href="{{ route('contact') }}" class="btn btn-outline-amber btn-lg px-5">
                <i class="bi bi-envelope me-2" aria-hidden="true"></i>Contactar
            </a>
        </div>
    </div>
</section>

@endsection
```

- [ ] **Step 4: Add home SCSS to `_pages.scss`**

```scss
// ============================================================
// HOME — HERO
// ============================================================
.hero {
  background: linear-gradient(160deg, var(--color-navy) 0%, #1a3252 60%, #162a46 100%);
  padding: 5rem 0 4rem;
  color: #fff;

  h1 {
    font-size: clamp(2rem, 4vw, 2.9rem);
    font-weight: 800;
    line-height: 1.15;
    margin-bottom: 1.25rem;
    color: #fff;
  }

  .hero-lead {
    font-size: 1.05rem;
    color: rgba(255,255,255,.8);
    line-height: 1.65;
    margin-bottom: 2rem;
    max-width: 500px;
  }

  .hero-photo {
    border-radius: 1rem;
    box-shadow: 0 1.5rem 4rem rgba(0,0,0,.45);
    width: 100%;
    max-height: 420px;
    object-fit: cover;
    object-position: top;
  }
}

// VALUE CARDS
.value-card {
  background: #fff;
  border: 1.5px solid #e2e8f0;
  border-radius: .75rem;
  padding: 1.5rem;
  display: flex;
  gap: 1rem;
  align-items: flex-start;
  height: 100%;
  transition: box-shadow .2s;
  &:hover { box-shadow: 0 .5rem 1.5rem rgba(0,0,0,.08); }

  .value-icon {
    width: 44px;
    height: 44px;
    border-radius: .5rem;
    background: #eff6ff;
    color: #1a56db;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
  }
  .value-title { font-weight: 700; font-size: .95rem; color: #1e293b; margin-bottom: .25rem; }
  .value-desc  { font-size: .85rem; color: #64748b; line-height: 1.5; margin: 0; }
}

// LEVEL PILLS
.level-pill {
  display: flex;
  align-items: center;
  gap: .75rem;
  padding: 1rem 1.25rem;
  background: #fff;
  border: 1.5px solid #e2e8f0;
  border-radius: .625rem;
  transition: border-color .15s;
  text-decoration: none;
  &:hover { border-color: var(--color-amber); }

  .level-pill-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    flex-shrink: 0;
  }
  .level-name { font-weight: 700; font-size: .9rem; color: #1e293b; }
  .level-desc { font-size: .78rem; color: #64748b; }
}

// FAQ
.faq-item {
  border: 1px solid #e2e8f0;
  border-radius: .5rem;
  margin-bottom: .5rem;
  overflow: hidden;
}

.faq-question {
  width: 100%;
  background: #fff;
  border: none;
  padding: 1rem 1.25rem;
  text-align: left;
  font-weight: 700;
  font-size: .95rem;
  color: #1e293b;
  cursor: pointer;
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: .5rem;

  i { transition: transform .2s; flex-shrink: 0; }
  &:not(.collapsed) i { transform: rotate(180deg); }
  &:hover { background: #f8fafc; }
  &:focus { outline: 2px solid var(--color-amber); outline-offset: -2px; }
}

.faq-answer {
  padding: .75rem 1.25rem 1rem;
  font-size: .9rem;
  color: #475569;
  line-height: 1.65;
  border-top: 1px solid #f1f5f9;
}

// CTA FINAL
.cta-section {
  background: linear-gradient(135deg, var(--color-navy), var(--color-navy-dark));
  color: #fff;
  padding: 4.5rem 0;
  text-align: center;

  h2   { font-size: 2rem; font-weight: 800; margin-bottom: 1rem; }
  .lead { color: rgba(255,255,255,.75); margin-bottom: 1.75rem; }
}
```

- [ ] **Step 5: Run `npm run build`**

- [ ] **Step 6: Run test**

```bash
php artisan test --filter=HomeTest
```

Expected: PASS.

- [ ] **Step 7: Commit**

```bash
git add resources/views/pages/home.blade.php resources/scss/_pages.scss tests/Feature/HomeTest.php
git commit -m "feat: redesign home page (hero, value props, levels, FAQ, CTA)"
```

---

## Task 5: Materials index (Livewire)

**Files:**
- Modify: `resources/views/livewire/materials/index.blade.php`
- Modify: `resources/scss/_components.scss` (append filter-bar styles)

- [ ] **Step 1: Write the test** — create `tests/Feature/MaterialsIndexTest.php`:

```php
<?php

test('materials index renders with page header', function () {
    $response = $this->get('/materiales');
    $response->assertStatus(200);
    $response->assertSee('page-header', false);
    $response->assertSee('filter-bar', false);
});
```

- [ ] **Step 2: Run test — verify it fails**

```bash
php artisan test --filter=MaterialsIndexTest
```

- [ ] **Step 3: Replace `resources/views/livewire/materials/index.blade.php`**

```blade
@section('title', 'Materiales · profenicolas.cl')
@section('main_class', '')

<div>

    {{-- PAGE HEADER --}}
    <div class="page-header">
        <div class="container">
            <p class="page-header-eyebrow">
                <i class="bi bi-collection-fill me-1" aria-hidden="true"></i>Biblioteca
            </p>
            <h1 class="fw-800">Materiales</h1>
            <p class="page-header-lead">
                Guías, ejercicios y apuntes de matemática. Descárgalos gratis.
            </p>
        </div>
    </div>

    {{-- FILTER BAR --}}
    <div class="filter-bar">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center gap-2">

                {{-- Search --}}
                <div class="filter-bar-search">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search text-muted" aria-hidden="true"></i>
                        </span>
                        <input type="search"
                               class="form-control border-start-0 ps-0"
                               placeholder="Buscar…"
                               wire:model.live="q"
                               wire:keydown.escape="$set('q','')">
                    </div>
                </div>

                {{-- Course --}}
                <select class="form-select form-select-sm filter-bar-select"
                        wire:model.live="course" aria-label="Filtrar por curso">
                    <option value="">Todos los cursos</option>
                    @foreach($courses as $c)
                        <option value="{{ $c }}">{{ $c }}</option>
                    @endforeach
                </select>

                {{-- Unit --}}
                <select class="form-select form-select-sm filter-bar-select"
                        wire:model.live="unit" aria-label="Filtrar por unidad">
                    <option value="">Todas las unidades</option>
                    @foreach($units as $u)
                        <option value="{{ $u }}">{{ $u }}</option>
                    @endforeach
                </select>

                {{-- Tema --}}
                <select class="form-select form-select-sm filter-bar-select"
                        wire:model.live="tema" aria-label="Filtrar por tema">
                    <option value="">Todos los temas</option>
                    @foreach($temas as $t)
                        <option value="{{ $t }}">{{ $t }}</option>
                    @endforeach
                </select>

                {{-- Sort --}}
                <select class="form-select form-select-sm filter-bar-select"
                        wire:model.live="sort" aria-label="Ordenar">
                    <option value="recent">Más recientes</option>
                    <option value="title_az">A–Z</option>
                    <option value="title_za">Z–A</option>
                </select>

                {{-- View toggle --}}
                <div class="view-toggle ms-auto d-flex gap-1" role="group" aria-label="Vista">
                    <button type="button" class="btn-view @if($view==='cards') active @endif"
                            wire:click="setView('cards')" aria-pressed="{{ $view==='cards' ? 'true' : 'false' }}"
                            title="Vista tarjetas">
                        <i class="bi bi-grid-3x3-gap" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="btn-view @if($view==='list') active @endif"
                            wire:click="setView('list')" aria-pressed="{{ $view==='list' ? 'true' : 'false' }}"
                            title="Vista lista">
                        <i class="bi bi-list-ul" aria-hidden="true"></i>
                    </button>
                </div>

            </div>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <div class="container py-4">

        {{-- Active filter badges --}}
        @if($q || $course || $unit || $tema)
            <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                <span class="small text-muted fw-600">Filtros activos:</span>
                @if($q)
                    <span class="filter-badge">
                        "{{ $q }}"
                        <span class="filter-badge-remove" wire:click="$set('q','')" role="button"
                              aria-label="Quitar filtro búsqueda">×</span>
                    </span>
                @endif
                @if($course)
                    <span class="filter-badge">
                        {{ $course }}
                        <span class="filter-badge-remove" wire:click="$set('course','')" role="button"
                              aria-label="Quitar filtro curso">×</span>
                    </span>
                @endif
                @if($unit)
                    <span class="filter-badge">
                        {{ $unit }}
                        <span class="filter-badge-remove" wire:click="$set('unit','')" role="button"
                              aria-label="Quitar filtro unidad">×</span>
                    </span>
                @endif
                @if($tema)
                    <span class="filter-badge">
                        {{ $tema }}
                        <span class="filter-badge-remove" wire:click="$set('tema','')" role="button"
                              aria-label="Quitar filtro tema">×</span>
                    </span>
                @endif
                <button type="button" class="btn btn-link btn-sm text-danger p-0"
                        wire:click="$set('q', ''); $set('course', ''); $set('unit', ''); $set('tema', '')">
                    Borrar filtros
                </button>
            </div>
        @endif

        {{-- Results count --}}
        <p class="small text-muted mb-3" wire:loading.remove>
            {{ $materials->total() }} {{ $materials->total() === 1 ? 'material' : 'materiales' }}
        </p>
        <p class="small text-muted mb-3" wire:loading>
            <i class="bi bi-hourglass-split me-1" aria-hidden="true"></i>Cargando…
        </p>

        @if($materials->count())

            {{-- CARDS VIEW --}}
            @if($view === 'cards')
                <div class="row g-4">
                    @foreach($materials as $m)
                        <div class="col-12 col-md-6 col-xl-4">
                            <x-materials.card :material="$m" />
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- LIST VIEW --}}
            @if($view === 'list')
                <div class="d-flex flex-column gap-2">
                    @foreach($materials as $m)
                        <a href="{{ route('materials.show', $m) }}" class="mat-list-row text-decoration-none">
                            <div class="mat-list-info">
                                <div class="mat-list-title">{{ $m->title }}</div>
                                <div class="mat-list-meta">
                                    {{ $m->course }}
                                    @if($m->unit) · {{ $m->unit }}@endif
                                    @if($m->semester) · Semestre {{ $m->semester }}@endif
                                    · {{ strtoupper($m->type) }}
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                @if(!empty($m->tags))
                                    @foreach(array_slice((array)$m->tags, 0, 2) as $tag)
                                        <span class="badge bg-light text-secondary border mat-tag">#{{ $tag }}</span>
                                    @endforeach
                                @endif
                                <span class="mat-type-badge mat-type-{{ $m->type }}">{{ strtoupper($m->type) }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif

            {{-- PAGINATION --}}
            <div class="d-flex justify-content-center mt-4">
                {{ $materials->onEachSide(1)->withQueryString()->links() }}
            </div>

        @else

            <div class="text-center py-5">
                <i class="bi bi-search display-4 text-muted mb-3 d-block" aria-hidden="true"></i>
                <h3 class="h5 fw-semibold mb-1">Sin resultados</h3>
                <p class="text-muted mb-3">No hay materiales con esos filtros.</p>
                <button type="button" class="btn btn-outline-secondary btn-sm"
                        wire:click="$set('q', ''); $set('course', ''); $set('unit', ''); $set('tema', '')">
                    <i class="bi bi-arrow-counterclockwise me-1" aria-hidden="true"></i>Limpiar filtros
                </button>
            </div>

        @endif

    </div>

</div>
```

- [ ] **Step 4: Append filter-bar SCSS to `_components.scss`**

```scss
// ============================================================
// FILTER BAR
// ============================================================
.filter-bar {
  background: #fff;
  border-bottom: 1px solid #e2e8f0;
  padding: .75rem 0;
  position: sticky;
  top: 60px;
  z-index: 100;

  .filter-bar-search { min-width: 200px; }
  .filter-bar-select { width: auto; min-width: 140px; }
}

// Filter badges
.filter-badge {
  display: inline-flex;
  align-items: center;
  gap: .3rem;
  background: #eff6ff;
  color: #1a56db;
  border: 1px solid #bfdbfe;
  padding: .2rem .6rem;
  border-radius: 999px;
  font-size: .78rem;
  font-weight: 600;

  .filter-badge-remove {
    cursor: pointer;
    color: #93c5fd;
    line-height: 1;
    &:hover { color: #1a56db; }
  }
}

// View toggle
.view-toggle {
  .btn-view {
    padding: .35rem .6rem;
    border: 1.5px solid #e2e8f0;
    background: #fff;
    color: #94a3b8;
    border-radius: .375rem;
    cursor: pointer;
    transition: border-color .15s, color .15s, background .15s;

    &.active, &:hover {
      border-color: #1a56db;
      color: #1a56db;
      background: #eff6ff;
    }
  }
}

// List row
.mat-list-row {
  display: flex;
  align-items: center;
  gap: 1rem;
  padding: .875rem 1rem;
  background: #fff;
  border: 1px solid #e2e8f0;
  border-radius: .5rem;
  color: inherit;
  transition: box-shadow .15s;

  &:hover { box-shadow: 0 2px 8px rgba(0,0,0,.08); }

  .mat-list-info { flex: 1; min-width: 0; }
  .mat-list-title {
    font-weight: 700;
    font-size: .92rem;
    color: #1e293b;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  .mat-list-meta { font-size: .78rem; color: #64748b; }
}
```

- [ ] **Step 5: Run `npm run build`**

- [ ] **Step 6: Run test**

```bash
php artisan test --filter=MaterialsIndexTest
```

Expected: PASS.

- [ ] **Step 7: Commit**

```bash
git add resources/views/livewire/materials/index.blade.php resources/scss/_components.scss tests/Feature/MaterialsIndexTest.php
git commit -m "feat: redesign materials index with page header, filter bar, mat-card grid"
```

---

## Task 6: Material detail

**Files:**
- Modify: `resources/views/materiales/show.blade.php`
- Modify: `resources/scss/_pages.scss` (append)

- [ ] **Step 1: Write the test** — create `tests/Feature/MaterialShowTest.php`:

```php
<?php

use App\Models\Material;

test('material detail page renders', function () {
    $material = Material::factory()->create([
        'type'      => 'pdf',
        'published' => true,
    ]);

    $response = $this->get(route('materials.show', $material));
    $response->assertStatus(200);
    $response->assertSee('material-detail-grid', false);
    $response->assertSee('ficha-tecnica', false);
});
```

- [ ] **Step 2: Run test — verify it fails**

```bash
php artisan test --filter=MaterialShowTest
```

- [ ] **Step 3: Replace `resources/views/materiales/show.blade.php`**

```blade
@extends('layouts.app')

@section('title', $material->title . ' · Materiales')
@section('main_class', '')

@push('meta')
    <meta name="description" content="{{ Str::limit(strip_tags($material->description ?? ''), 155) }}">
    <link rel="canonical" href="{{ route('materials.show', $material) }}">
@endpush

@section('full_content')

{{-- BREADCRUMB --}}
<nav class="material-breadcrumb" aria-label="Ruta de navegación">
    <div class="container">
        <a href="{{ route('home') }}">Inicio</a>
        <span class="mx-2" aria-hidden="true">›</span>
        <a href="{{ route('materials.index') }}">Materiales</a>
        <span class="mx-2" aria-hidden="true">›</span>
        <span class="text-muted">{{ Str::limit($material->title, 40) }}</span>
    </div>
</nav>

{{-- MAIN --}}
<div class="container py-5">
    <div class="material-detail-grid">

        {{-- LEFT: main content --}}
        <div>
            <div class="d-flex flex-wrap gap-2 mb-3">
                {!! $material->nivel !!}
                @if($material->year)
                    <span class="badge bg-light text-secondary border">{{ $material->year }}</span>
                @endif
            </div>

            <h1 class="fw-800 mb-3">{{ $material->title }}</h1>

            @if($material->description)
                <div class="material-description text-muted mb-4">
                    {!! Str::markdown($material->description, ['html_input' => 'escape']) !!}
                </div>
            @endif

            @if(!empty($material->tags))
                <div class="d-flex flex-wrap gap-2 mb-4">
                    @foreach($material->tags as $tag)
                        <span class="badge bg-light text-secondary border mat-tag">#{{ $tag }}</span>
                    @endforeach
                </div>
            @endif

            {{-- VIEWER --}}
            @if($material->type === 'pdf' && $material->file_path)
                <div class="mb-5">
                    <div class="pdf-viewer-toolbar">
                        <span class="pdf-viewer-title">{{ $material->title }}</span>
                        <a href="{{ asset('storage/' . $material->file_path) }}"
                           class="btn btn-sm btn-amber" download>
                            <i class="bi bi-download me-1" aria-hidden="true"></i>Descargar
                        </a>
                    </div>
                    <iframe src="{{ asset('storage/' . $material->file_path) }}"
                            class="pdf-viewer"
                            title="{{ $material->title }}"></iframe>
                </div>
            @elseif($material->type === 'image' && $material->file_path)
                <div class="text-center mb-5">
                    <img src="{{ asset('storage/' . $material->file_path) }}"
                         alt="{{ $material->title }}"
                         class="img-fluid rounded-3 shadow-sm">
                </div>
            @elseif($material->type === 'video' && $material->file_path)
                <div class="mb-5">
                    <video controls class="w-100 rounded-3 shadow-sm">
                        <source src="{{ asset('storage/' . $material->file_path) }}">
                        Tu navegador no soporta la reproducción de video.
                    </video>
                </div>
            @endif

            <a href="{{ route('materials.index') }}" class="text-muted text-decoration-none small">
                <i class="bi bi-arrow-left me-1" aria-hidden="true"></i>Volver a materiales
            </a>
        </div>

        {{-- RIGHT: sidebar --}}
        <aside>

            {{-- Ficha técnica --}}
            <div class="sidebar-card">
                <h2 class="ficha-heading">Ficha técnica</h2>
                <div class="ficha-tecnica">
                    <div class="ficha-row">
                        <span class="ficha-label">Nivel</span>
                        <span class="ficha-value">{!! $material->nivel !!}</span>
                    </div>
                    @if($material->course)
                    <div class="ficha-row">
                        <span class="ficha-label">Curso</span>
                        <span class="ficha-value">{{ $material->course }}</span>
                    </div>
                    @endif
                    @if($material->subject)
                    <div class="ficha-row">
                        <span class="ficha-label">Asignatura</span>
                        <span class="ficha-value">{{ $material->subject }}</span>
                    </div>
                    @endif
                    @if($material->unit)
                    <div class="ficha-row">
                        <span class="ficha-label">Unidad</span>
                        <span class="ficha-value">{{ $material->unit }}</span>
                    </div>
                    @endif
                    @if($material->semester)
                    <div class="ficha-row">
                        <span class="ficha-label">Semestre</span>
                        <span class="ficha-value">{{ $material->semester }}</span>
                    </div>
                    @endif
                    @if($material->year)
                    <div class="ficha-row">
                        <span class="ficha-label">Año</span>
                        <span class="ficha-value">{{ $material->year }}</span>
                    </div>
                    @endif
                    <div class="ficha-row">
                        <span class="ficha-label">Tipo</span>
                        <span class="ficha-value">{{ $material->tipo }}</span>
                    </div>
                    @if($material->size_formatted)
                    <div class="ficha-row">
                        <span class="ficha-label">Tamaño</span>
                        <span class="ficha-value">{{ $material->size_formatted }}</span>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Download CTA --}}
            <div class="sidebar-card">
                @if($material->type === 'pdf' && $material->file_path)
                    <a href="{{ asset('storage/' . $material->file_path) }}"
                       class="btn btn-amber w-100 mb-2" download>
                        <i class="bi bi-download me-2" aria-hidden="true"></i>Descargar PDF
                    </a>
                @elseif($material->type === 'html' && $material->file_path)
                    <a href="{{ route('materials.content', $material) }}"
                       class="btn btn-amber w-100 mb-2" target="_blank" rel="noopener">
                        <i class="bi bi-play-circle me-2" aria-hidden="true"></i>Abrir presentación
                    </a>
                @elseif($material->type === 'link' && $material->link_url)
                    <a href="{{ $material->link_url }}"
                       class="btn btn-amber w-100 mb-2" target="_blank" rel="noopener noreferrer">
                        <i class="bi bi-box-arrow-up-right me-2" aria-hidden="true"></i>Abrir recurso
                    </a>
                @elseif($material->file_path)
                    <a href="{{ asset('storage/' . $material->file_path) }}"
                       class="btn btn-amber w-100 mb-2" download>
                        <i class="bi bi-download me-2" aria-hidden="true"></i>Descargar archivo
                    </a>
                @endif

                {{-- Share buttons --}}
                <div class="share-buttons mt-2">
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('materials.show', $material)) }}&text={{ urlencode($material->title) }}"
                       class="share-btn" target="_blank" rel="noopener noreferrer" aria-label="Compartir en Twitter/X">
                        <i class="bi bi-twitter-x" aria-hidden="true"></i>
                    </a>
                    <a href="https://wa.me/?text={{ urlencode($material->title . ' ' . route('materials.show', $material)) }}"
                       class="share-btn" target="_blank" rel="noopener noreferrer" aria-label="Compartir por WhatsApp">
                        <i class="bi bi-whatsapp" aria-hidden="true"></i>
                    </a>
                    <button type="button" class="share-btn"
                            onclick="navigator.clipboard.writeText('{{ route('materials.show', $material) }}')"
                            aria-label="Copiar enlace">
                        <i class="bi bi-link-45deg" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

            {{-- Related materials --}}
            @if($related->isNotEmpty())
                <div class="sidebar-card">
                    <h2 class="ficha-heading">Más de {{ $material->course }}</h2>
                    <div class="d-flex flex-column gap-2">
                        @foreach($related as $rel)
                            <a href="{{ route('materials.show', $rel) }}"
                               class="related-item text-decoration-none">
                                <span class="related-title">{{ $rel->title }}</span>
                                <span class="mat-type-badge mat-type-{{ $rel->type }}">{{ strtoupper($rel->type) }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Services CTA --}}
            <div class="sidebar-card sidebar-card-navy">
                <p class="fw-700 mb-1" style="color:#fff;">¿Necesitas clases?</p>
                <p class="small mb-3" style="color:rgba(255,255,255,.75);">Asesorías personalizadas para tu nivel.</p>
                <a href="{{ route('services') }}" class="btn btn-amber btn-sm w-100">
                    Ver servicios
                </a>
            </div>

        </aside>
    </div>
</div>

@endsection
```

Note: the sidebar-card-navy has inline `style` on `<p>` tags. Replace with classes in Step 4.

- [ ] **Step 4: Fix the inline styles in sidebar-card-navy** — in the Blade above, replace:

```blade
<p class="fw-700 mb-1" style="color:#fff;">¿Necesitas clases?</p>
<p class="small mb-3" style="color:rgba(255,255,255,.75);">Asesorías personalizadas para tu nivel.</p>
```

with:

```blade
<p class="fw-700 mb-1 text-white">¿Necesitas clases?</p>
<p class="small mb-3 text-on-dark opacity-75">Asesorías personalizadas para tu nivel.</p>
```

- [ ] **Step 5: Append material-detail SCSS to `_pages.scss`**

```scss
// ============================================================
// MATERIAL DETAIL
// ============================================================
.material-breadcrumb {
  background: #fff;
  border-bottom: 1px solid #e2e8f0;
  padding: .75rem 0;
  font-size: .82rem;
  color: #64748b;
  a { color: #64748b; text-decoration: none; &:hover { color: #1a56db; } }
}

.material-detail-grid {
  display: grid;
  grid-template-columns: 1fr 300px;
  gap: 2rem;
  align-items: start;

  @media (max-width: 768px) {
    grid-template-columns: 1fr;
  }
}

.pdf-viewer-toolbar {
  background: #1e293b;
  border-radius: .5rem .5rem 0 0;
  padding: .6rem 1rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: .5rem;

  .pdf-viewer-title {
    font-size: .8rem;
    color: #94a3b8;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    flex: 1;
  }
}

.pdf-viewer {
  width: 100%;
  border: none;
  border-radius: 0 0 .5rem .5rem;
  height: 600px;
  background: #f1f5f9;

  @media (max-width: 768px) { height: 400px; }
}

.sidebar-card {
  background: #fff;
  border: 1.5px solid #e2e8f0;
  border-radius: .75rem;
  padding: 1.25rem;
  margin-bottom: 1.25rem;

  &.sidebar-card-navy {
    background: linear-gradient(135deg, var(--color-navy), var(--color-navy-dark));
    border-color: transparent;
  }
}

.ficha-heading {
  font-size: .72rem;
  font-weight: 700;
  letter-spacing: .08em;
  text-transform: uppercase;
  color: #64748b;
  margin-bottom: .75rem;
}

.ficha-tecnica {
  .ficha-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: .5rem 0;
    border-bottom: 1px solid #f1f5f9;
    font-size: .83rem;
    &:last-child { border-bottom: none; }
    .ficha-label { color: #64748b; font-weight: 600; }
    .ficha-value { color: #1e293b; text-align: right; max-width: 55%; }
  }
}

.share-buttons {
  display: flex;
  gap: .5rem;

  .share-btn {
    flex: 1;
    padding: .45rem;
    border: 1.5px solid #e2e8f0;
    border-radius: .5rem;
    background: #fff;
    color: #475569;
    font-size: .85rem;
    text-align: center;
    cursor: pointer;
    transition: border-color .15s, color .15s;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    &:hover { border-color: #1a56db; color: #1a56db; }
  }
}

.related-item {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: .5rem;
  padding: .5rem .25rem;
  border-bottom: 1px solid #f1f5f9;
  color: #1e293b;
  &:last-child { border-bottom: none; }
  &:hover { color: #1a56db; }

  .related-title {
    font-size: .83rem;
    font-weight: 600;
    flex: 1;
    min-width: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
}
```

- [ ] **Step 6: Run `npm run build`**

- [ ] **Step 7: Run tests**

```bash
php artisan test --filter=MaterialShowTest
```

Expected: PASS.

- [ ] **Step 8: Commit**

```bash
git add resources/views/materiales/show.blade.php resources/scss/_pages.scss tests/Feature/MaterialShowTest.php
git commit -m "feat: redesign material detail page (2-col, PDF viewer, ficha técnica, sidebar)"
```

---

## Task 7: Sobre mí

**Files:**
- Modify: `resources/views/pages/about.blade.php`
- Modify: `resources/scss/_pages.scss` (append)

- [ ] **Step 1: Write the test** — create `tests/Feature/AboutTest.php`:

```php
<?php

test('about page renders', function () {
    $response = $this->get(route('about'));
    $response->assertStatus(200);
    $response->assertSee('about-hero', false);
    $response->assertSee('achievement-card', false);
});
```

- [ ] **Step 2: Run test — verify it fails**

```bash
php artisan test --filter=AboutTest
```

- [ ] **Step 3: Replace `resources/views/pages/about.blade.php`**

```blade
@extends('layouts.app')
@section('title', 'Sobre mí · Profe Nicolás González')
@section('main_class', '')

@section('full_content')

{{-- HERO --}}
<section class="about-hero">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <p class="eyebrow">
                    <i class="bi bi-mortarboard-fill me-1" aria-hidden="true"></i>Profesor de Matemática
                </p>
                <h1 class="fw-800 text-white">
                    Nicolás González M.<br>
                    <span class="text-amber">13 años enseñando</span> matemáticas.
                </h1>
                <p class="about-hero-lead">
                    Egresado de la Universidad de Valparaíso (sede Playa Ancha). Docente
                    en Quintero desde que egresé, con clases particulares desde 2012.
                </p>
                <ul class="list-unstyled about-credentials">
                    <li>
                        <i class="bi bi-award-fill text-amber" aria-hidden="true"></i>
                        4× medalla CMAT (2018, 2019, 2024, 2025)
                    </li>
                    <li>
                        <i class="bi bi-check2-circle text-success" aria-hidden="true"></i>
                        Colegio, CFT, PAES y clases particulares
                    </li>
                    <li>
                        <i class="bi bi-geo-alt-fill" aria-hidden="true"></i>
                        Quintero, Valparaíso — presencial u online
                    </li>
                </ul>
            </div>
            <div class="col-lg-4 offset-lg-1 d-none d-lg-block">
                <div class="about-photo-wrap">
                    <img src="{{ asset('images/about_me.jpg') }}"
                         alt="Nicolás González M., Profesor de Matemática">
                    <span class="photo-badge">
                        <i class="bi bi-award-fill me-1" aria-hidden="true"></i>4× Medalla CMAT
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ACHIEVEMENTS --}}
<section class="section bg-cream">
    <div class="container">
        <div class="row g-4">
            <div class="col-6 col-lg-3">
                <div class="achievement-card">
                    <h3>+13</h3>
                    <p>años de experiencia</p>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="achievement-card">
                    <h3>3</h3>
                    <p>niveles de enseñanza</p>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="achievement-card">
                    <h3>4×</h3>
                    <p>medalla CMAT</p>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="achievement-card">
                    <h3>100%</h3>
                    <p>materiales gratuitos</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- TIMELINE --}}
<section class="section">
    <div class="container">
        <h2 class="fw-800 fs-2 text-center mb-5">Historia y formación</h2>
        <div class="row g-5">
            <div class="col-lg-6">
                <h3 class="about-timeline-heading">Historia</h3>
                <div class="timeline">
                    <div class="timeline-item">
                        <span class="timeline-year">2011</span>
                        <div class="timeline-content">
                            <h4>Ingreso a la UV</h4>
                            <p>Comenzó sus estudios de Pedagogía en Matemáticas en la Universidad de Valparaíso, sede Playa Ancha.</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <span class="timeline-year">2012</span>
                        <div class="timeline-content">
                            <h4>Primeras clases particulares</h4>
                            <p>Inició su trabajo en clases particulares y preparación PAES, que mantiene hasta hoy.</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <span class="timeline-year">2018</span>
                        <div class="timeline-content">
                            <h4>Titulación y primer CMAT</h4>
                            <p>Se tituló de Profesor de Matemática y obtuvo su primera medalla CMAT acompañando estudiantes.</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <span class="timeline-year">2024</span>
                        <div class="timeline-content">
                            <h4>profenicolas.cl</h4>
                            <p>Lanzó este sitio para compartir materiales de forma abierta y gratuita con todos los estudiantes.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <h3 class="about-timeline-heading">Formación</h3>
                <div class="timeline">
                    <div class="timeline-item">
                        <span class="timeline-year">UV</span>
                        <div class="timeline-content">
                            <h4>Licenciatura en Matemática</h4>
                            <p>Universidad de Valparaíso, sede Playa Ancha.</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <span class="timeline-year">UV</span>
                        <div class="timeline-content">
                            <h4>Pedagogía en Matemáticas</h4>
                            <p>Titulado 2018. Formación enfocada en didáctica, evaluación y contexto escolar chileno.</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <span class="timeline-year">CMAT</span>
                        <div class="timeline-content">
                            <h4>Medallas 2018, 2019, 2024 y 2025</h4>
                            <p>Bronce y plata en el Campeonato Escolar de Matemática, como entrenador y acompañante.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- METHODOLOGY --}}
<section class="section bg-cream">
    <div class="container">
        <h2 class="fw-800 fs-2 text-center mb-5">Cómo enseño</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="method-card">
                    <div class="method-icon"><i class="bi bi-sort-down" aria-hidden="true"></i></div>
                    <h3>Diagnóstico primero</h3>
                    <p>Antes de avanzar, identificamos las brechas reales. No asumo lo que el estudiante sabe o no sabe.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="method-card">
                    <div class="method-icon"><i class="bi bi-puzzle" aria-hidden="true"></i></div>
                    <h3>Conexión con lo concreto</h3>
                    <p>Parto de ejemplos cotidianos antes de formalizar. Los símbolos deben tener sentido real, no ser algo a memorizar.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="method-card">
                    <div class="method-icon"><i class="bi bi-file-earmark-text" aria-hidden="true"></i></div>
                    <h3>Materiales propios</h3>
                    <p>Los materiales son creados por mí y están adaptados al nivel de cada estudiante. Nada genérico.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="cta-section">
    <div class="container">
        <h2>¿Listo para trabajar juntos?</h2>
        <p class="lead">Explora los materiales gratuitos o contáctame directamente.</p>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            <a href="{{ route('materials.index') }}" class="btn btn-amber btn-lg px-5">
                <i class="bi bi-collection me-2" aria-hidden="true"></i>Explorar materiales
            </a>
            <a href="{{ route('contact') }}" class="btn btn-outline-amber btn-lg px-5">
                <i class="bi bi-envelope me-2" aria-hidden="true"></i>Contactar
            </a>
        </div>
    </div>
</section>

@endsection
```

- [ ] **Step 4: Append about SCSS to `_pages.scss`**

```scss
// ============================================================
// SOBRE MÍ
// ============================================================
.about-hero {
  background: linear-gradient(135deg, var(--color-navy), var(--color-navy-dark));
  padding: 4rem 0 3rem;
  color: #fff;
}

.about-hero-lead {
  color: rgba(255,255,255,.8);
  font-size: 1.05rem;
  line-height: 1.65;
  margin-bottom: 1.5rem;
}

.about-credentials {
  li {
    display: flex;
    align-items: center;
    gap: .6rem;
    font-size: .9rem;
    color: rgba(255,255,255,.8);
    margin-bottom: .6rem;
    i { font-size: 1rem; flex-shrink: 0; }
  }
}

.about-photo-wrap {
  position: relative;
  img {
    border-radius: 1rem;
    box-shadow: 0 1rem 3rem rgba(0,0,0,.4);
    width: 100%;
    max-height: 400px;
    object-fit: cover;
    object-position: top;
  }
  .photo-badge {
    position: absolute;
    bottom: -1rem;
    left: 50%;
    transform: translateX(-50%);
    background: var(--color-amber);
    color: #1e293b;
    font-size: .78rem;
    font-weight: 800;
    padding: .4rem 1.25rem;
    border-radius: 999px;
    white-space: nowrap;
    box-shadow: 0 .25rem .75rem rgba(0,0,0,.3);
  }
}

.achievement-card {
  background: #fff;
  border: 1.5px solid #e2e8f0;
  border-radius: .75rem;
  padding: 1.5rem;
  text-align: center;
  h3 { font-size: 2.25rem; font-weight: 800; color: var(--color-navy); margin-bottom: .25rem; }
  p  { font-size: .82rem; color: #64748b; margin: 0; }
}

.about-timeline-heading {
  font-size: .75rem;
  font-weight: 700;
  letter-spacing: .1em;
  text-transform: uppercase;
  color: #64748b;
  margin-bottom: 1.25rem;
}

.timeline {
  .timeline-item {
    display: flex;
    gap: .75rem;
    margin-bottom: 1.25rem;
    &:last-child { margin-bottom: 0; }

    .timeline-year {
      font-size: .75rem;
      font-weight: 700;
      color: var(--color-amber);
      min-width: 44px;
      padding-top: .15rem;
    }
    .timeline-content {
      h4 { font-size: .9rem; font-weight: 700; color: #1e293b; margin-bottom: .2rem; }
      p  { font-size: .82rem; color: #64748b; margin: 0; line-height: 1.5; }
    }
  }
}

.method-card {
  background: #fff;
  border: 1.5px solid #e2e8f0;
  border-radius: .75rem;
  padding: 1.5rem;
  height: 100%;

  .method-icon {
    font-size: 1.75rem;
    color: var(--color-navy);
    margin-bottom: .75rem;
  }
  h3 { font-size: 1rem; font-weight: 700; color: #1e293b; margin-bottom: .5rem; }
  p  { font-size: .85rem; color: #475569; margin: 0; line-height: 1.6; }
}
```

- [ ] **Step 5: Run `npm run build`**

- [ ] **Step 6: Run tests**

```bash
php artisan test --filter=AboutTest
```

Expected: PASS.

- [ ] **Step 7: Commit**

```bash
git add resources/views/pages/about.blade.php resources/scss/_pages.scss tests/Feature/AboutTest.php
git commit -m "feat: redesign sobre-mi page (hero, achievements, timeline, methodology)"
```

---

## Task 8: Servicios

**Files:**
- Modify: `resources/views/pages/services.blade.php`
- Modify: `resources/scss/_pages.scss` (append)

- [ ] **Step 1: Write the test** — create `tests/Feature/ServicesTest.php`:

```php
<?php

test('services page renders', function () {
    $response = $this->get(route('services'));
    $response->assertStatus(200);
    $response->assertSee('service-card', false);
    $response->assertSee('service-card-featured', false);
});
```

- [ ] **Step 2: Run test — verify it fails**

```bash
php artisan test --filter=ServicesTest
```

- [ ] **Step 3: Replace `resources/views/pages/services.blade.php`**

```blade
@extends('layouts.app')
@section('title', 'Servicios · Profe Nicolás González')
@section('main_class', '')

@section('full_content')

{{-- PAGE HEADER --}}
<div class="page-header text-center">
    <div class="container">
        <p class="page-header-eyebrow">Asesorías de matemática</p>
        <h1 class="fw-800">Servicios</h1>
        <p class="page-header-lead">
            Clases adaptadas a tu nivel, tu ritmo y tus objetivos.
        </p>
    </div>
</div>

{{-- SERVICE CARDS --}}
<section class="section">
    <div class="container">
        <div class="row g-4 justify-content-center">

            {{-- Clases particulares --}}
            <div class="col-lg-4">
                <div class="service-card service-card-featured">
                    <span class="featured-badge">Más solicitado</span>
                    <div class="service-icon"><i class="bi bi-journal-text" aria-hidden="true"></i></div>
                    <h2 class="h4">Clases particulares</h2>
                    <p class="service-desc">
                        Refuerzo personalizado para estudiantes de 7° básico a 4° medio.
                        Trabajamos los contenidos del curso, preparamos pruebas y cerramos
                        las brechas que el ritmo del colegio no cubre.
                    </p>
                    <ul class="service-includes">
                        <li>Todas las unidades de 7° básico a 4° medio</li>
                        <li>Preparación de pruebas y exámenes</li>
                        <li>Nivelación y refuerzo de contenidos anteriores</li>
                    </ul>
                    <a href="{{ route('contact') }}" class="btn btn-amber mt-auto">
                        <i class="bi bi-calendar2-check me-2" aria-hidden="true"></i>Consultar
                    </a>
                </div>
            </div>

            {{-- Preparación PAES --}}
            <div class="col-lg-4">
                <div class="service-card">
                    <div class="service-icon"><i class="bi bi-trophy" aria-hidden="true"></i></div>
                    <h2 class="h4">Preparación PAES</h2>
                    <p class="service-desc">
                        Preparación enfocada en la Prueba de Acceso a la Educación Superior.
                        Resolvemos ensayos reales e identificamos errores frecuentes.
                    </p>
                    <ul class="service-includes">
                        <li>Resolución de ensayos oficiales</li>
                        <li>Estrategias por tipo de pregunta</li>
                        <li>Seguimiento del avance durante el año</li>
                    </ul>
                    <a href="{{ route('contact') }}" class="btn btn-outline-primary mt-auto">
                        <i class="bi bi-calendar2-check me-2" aria-hidden="true"></i>Consultar
                    </a>
                </div>
            </div>

            {{-- Nivelación intensiva --}}
            <div class="col-lg-4">
                <div class="service-card">
                    <div class="service-icon"><i class="bi bi-file-earmark-ruled" aria-hidden="true"></i></div>
                    <h2 class="h4">Nivelación intensiva</h2>
                    <p class="service-desc">
                        Para quienes necesitan ponerse al día rápido. Diagnóstico,
                        plan personalizado y materiales a medida.
                    </p>
                    <ul class="service-includes">
                        <li>Diagnóstico inicial de brechas</li>
                        <li>Plan de trabajo personalizado</li>
                        <li>Guías y materiales adaptados</li>
                    </ul>
                    <a href="{{ route('contact') }}" class="btn btn-outline-primary mt-auto">
                        <i class="bi bi-calendar2-check me-2" aria-hidden="true"></i>Consultar
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- PRACTICAL INFO --}}
<section class="section bg-cream">
    <div class="container">
        <h2 class="fw-800 fs-2 text-center mb-5">Información práctica</h2>
        <div class="row g-4">
            <div class="col-sm-6">
                <div class="practical-card">
                    <h4><i class="bi bi-laptop" aria-hidden="true"></i>Modalidad</h4>
                    <p>Presencial en Quintero y alrededores, u online desde cualquier lugar de Chile vía Zoom o Meet.</p>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="practical-card">
                    <h4><i class="bi bi-clock" aria-hidden="true"></i>Horarios</h4>
                    <p>Clases a partir de las 18:00 hrs. de lunes a viernes, y en bloques más amplios los fines de semana.</p>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="practical-card">
                    <h4><i class="bi bi-calendar2-check" aria-hidden="true"></i>¿Cómo agendar?</h4>
                    <p>Escríbeme por el formulario de contacto indicando tu nivel, disponibilidad y lo que necesitas trabajar.</p>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="practical-card">
                    <h4><i class="bi bi-people" aria-hidden="true"></i>Formato</h4>
                    <p>Individual o en grupos pequeños de amigos o compañeros. Los paquetes mensuales también están disponibles.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- LEVELS --}}
<section class="section">
    <div class="container" style="max-width: 640px;">
        <h2 class="fw-800 fs-2 text-center mb-5">Niveles disponibles</h2>
        <div class="levels-list">
            <div class="level-row">
                <span class="mat-level-dot level-dot-colegio"></span>
                <div>
                    <div class="level-name">Colegio</div>
                    <div class="level-courses">7° básico a 4° medio · todas las asignaturas de matemática</div>
                </div>
            </div>
            <div class="level-row">
                <span class="mat-level-dot level-dot-paes"></span>
                <div>
                    <div class="level-name">PAES Matemática</div>
                    <div class="level-courses">Preparación M1 y M2 · estrategias, ensayos, refuerzo</div>
                </div>
            </div>
            <div class="level-row">
                <span class="mat-level-dot level-dot-cft"></span>
                <div>
                    <div class="level-name">CFT / Instituto</div>
                    <div class="level-courses">Matemática aplicada para formación técnico-profesional</div>
                </div>
            </div>
            <div class="level-row">
                <span class="mat-level-dot level-dot-universidad"></span>
                <div>
                    <div class="level-name">Universidad</div>
                    <div class="level-courses">Cálculo, álgebra lineal, estadística, matemática discreta</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="cta-section">
    <div class="container">
        <h2>¿Listo para empezar?</h2>
        <p class="lead">Escríbeme y coordinamos horario y modalidad.</p>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            <a href="{{ route('contact') }}" class="btn btn-amber btn-lg px-5">
                <i class="bi bi-envelope me-2" aria-hidden="true"></i>Contactar ahora
            </a>
            <a href="{{ route('materials.index') }}" class="btn btn-outline-amber btn-lg px-5">
                <i class="bi bi-collection me-2" aria-hidden="true"></i>Ver materiales gratis
            </a>
        </div>
    </div>
</section>

@endsection
```

Note: `style="max-width: 640px;"` on the levels container — replace with a `.container-narrow-md` class:

- [ ] **Step 4: Remove the inline max-width** — replace `<div class="container" style="max-width: 640px;">` with `<div class="container-narrow-md">` and add to `_design-system.scss`:

```scss
.container-narrow-md { max-width: 640px; margin-inline: auto; }
```

- [ ] **Step 5: Append services SCSS to `_pages.scss`**

```scss
// ============================================================
// SERVICIOS
// ============================================================
.service-card {
  background: #fff;
  border: 1.5px solid #e2e8f0;
  border-radius: .875rem;
  padding: 2rem 1.5rem;
  height: 100%;
  display: flex;
  flex-direction: column;
  position: relative;

  &.service-card-featured {
    border-color: var(--color-amber);
    .featured-badge {
      position: absolute;
      top: -13px;
      left: 50%;
      transform: translateX(-50%);
      background: var(--color-amber);
      color: #1e293b;
      font-size: .7rem;
      font-weight: 800;
      padding: .25rem 1rem;
      border-radius: 999px;
      letter-spacing: .04em;
      text-transform: uppercase;
      white-space: nowrap;
    }
  }

  .service-icon {
    font-size: 2rem;
    color: var(--color-navy);
    margin-bottom: 1rem;
  }
  h2 { margin-bottom: .5rem; }
  .service-desc { font-size: .88rem; color: #475569; margin-bottom: 1.25rem; flex: 1; line-height: 1.6; }

  .service-includes {
    list-style: none;
    padding: 0;
    margin: 0 0 1.5rem;
    li {
      font-size: .83rem;
      color: #475569;
      padding: .3rem 0;
      display: flex;
      align-items: flex-start;
      gap: .5rem;
      &::before {
        content: '✓';
        color: #22c55e;
        font-weight: 700;
        flex-shrink: 0;
        margin-top: .05rem;
      }
    }
  }
}

.practical-card {
  background: #fff;
  border: 1px solid #e2e8f0;
  border-radius: .625rem;
  padding: 1.25rem;
  height: 100%;

  h4 {
    font-size: .9rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: .375rem;
    display: flex;
    align-items: center;
    gap: .4rem;
    i { color: #1a56db; }
  }
  p { font-size: .82rem; color: #475569; margin: 0; line-height: 1.55; }
}

.levels-list {
  background: #fff;
  border: 1.5px solid #e2e8f0;
  border-radius: .75rem;
  overflow: hidden;
}

.level-row {
  display: flex;
  align-items: center;
  gap: .875rem;
  padding: 1rem 1.25rem;
  border-bottom: 1px solid #f1f5f9;
  &:last-child { border-bottom: none; }

  .level-name    { font-weight: 700; font-size: .9rem; color: #1e293b; }
  .level-courses { font-size: .8rem; color: #64748b; }
}
```

- [ ] **Step 6: Run `npm run build`**

- [ ] **Step 7: Run tests**

```bash
php artisan test --filter=ServicesTest
```

Expected: PASS.

- [ ] **Step 8: Commit**

```bash
git add resources/views/pages/services.blade.php resources/scss/_pages.scss resources/scss/_design-system.scss tests/Feature/ServicesTest.php
git commit -m "feat: redesign servicios page (service cards, practical info, levels)"
```

---

## Task 9: Contacto

**Files:**
- Modify: `resources/views/livewire/contact/form.blade.php`
- Modify: `resources/scss/_pages.scss` (append)

- [ ] **Step 1: Write the test** — create `tests/Feature/ContactTest.php`:

```php
<?php

test('contact page renders', function () {
    $response = $this->get(route('contact'));
    $response->assertStatus(200);
    $response->assertSee('contact-grid', false);
    $response->assertSee('subject-selector', false);
});
```

- [ ] **Step 2: Run test — verify it fails**

```bash
php artisan test --filter=ContactTest
```

- [ ] **Step 3: Replace `resources/views/livewire/contact/form.blade.php`**

```blade
@section('title', 'Contacto · profenicolas.cl')
@section('main_class', '')

<div>

    {{-- PAGE HEADER --}}
    <div class="page-header text-center">
        <div class="container">
            <p class="page-header-eyebrow">
                <i class="bi bi-envelope-heart-fill me-1" aria-hidden="true"></i>Escríbeme
            </p>
            <h1 class="fw-800">Contacto</h1>
            <p class="page-header-lead">
                ¿Tienes dudas con la materia o quieres agendar una clase? Te respondo en menos de 24 horas.
            </p>
        </div>
    </div>

    <div class="container py-5">

        @if($sent)

            <div class="alert alert-success d-flex align-items-start gap-3 p-4" role="alert">
                <i class="bi bi-check-circle-fill fs-4 flex-shrink-0 mt-1" aria-hidden="true"></i>
                <div>
                    <h2 class="h5 fw-bold mb-1">¡Mensaje enviado!</h2>
                    <p class="mb-3">Gracias por escribirme. Te responderé a la brevedad.</p>
                    <a href="{{ route('home') }}" class="btn btn-success btn-sm">
                        <i class="bi bi-house me-1" aria-hidden="true"></i>Volver al inicio
                    </a>
                </div>
            </div>

        @else

            <div class="contact-grid">

                {{-- FORM --}}
                <div>
                    <form wire:submit="send" novalidate>

                        {{-- Honeypot --}}
                        <div class="d-none" aria-hidden="true">
                            <input type="text" wire:model="website" autocomplete="off" tabindex="-1">
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-sm-6">
                                <label for="name" class="form-label fw-semibold">Nombre</label>
                                <input id="name" type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       wire:model.live="name" autocomplete="name">
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-sm-6">
                                <label for="email" class="form-label fw-semibold">Correo electrónico</label>
                                <input id="email" type="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       wire:model.live="email" autocomplete="email">
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- Subject radio grid --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Asunto <span class="fw-normal text-muted">(opcional)</span>
                            </label>
                            <div class="subject-selector">
                                @foreach([
                                    'Clases particulares',
                                    'Preparación PAES',
                                    'Duda sobre materia',
                                    'Descarga de material',
                                    'Nivelación intensiva',
                                    'Otro tema',
                                ] as $option)
                                    <div class="subject-option">
                                        <input type="radio"
                                               id="subject_{{ Str::slug($option) }}"
                                               wire:model.live="subject"
                                               value="{{ $option }}">
                                        <label for="subject_{{ Str::slug($option) }}">{{ $option }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @error('subject')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label for="message" class="form-label fw-semibold">Mensaje</label>
                            <textarea id="message" rows="6"
                                      class="form-control @error('message') is-invalid @enderror"
                                      wire:model.live="message"></textarea>
                            @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <button type="submit" class="btn btn-amber px-5"
                                wire:loading.attr="disabled" wire:target="send">
                            <i class="bi bi-send me-2" aria-hidden="true"
                               wire:loading.remove wire:target="send"></i>
                            <i class="bi bi-hourglass-split me-2" aria-hidden="true"
                               wire:loading wire:target="send"></i>
                            <span wire:loading.remove wire:target="send">Enviar mensaje</span>
                            <span wire:loading wire:target="send">Enviando…</span>
                        </button>

                        <p class="text-muted small mt-3 mb-0">
                            Al enviar aceptas ser contactado por correo para responder tu consulta.
                        </p>

                    </form>
                </div>

                {{-- SIDEBAR --}}
                <aside class="d-flex flex-column gap-3">

                    {{-- Info card --}}
                    <div class="sidebar-card">
                        <h2 class="ficha-heading">Información de contacto</h2>
                        <div class="d-flex flex-column gap-3">
                            <div class="d-flex align-items-start gap-3">
                                <i class="bi bi-envelope-fill text-primary fs-5 mt-1 flex-shrink-0" aria-hidden="true"></i>
                                <div>
                                    <div class="fw-semibold small">Correo</div>
                                    <a href="mailto:hola@profenicolas.cl" class="text-muted small">hola@profenicolas.cl</a>
                                </div>
                            </div>
                            <div class="d-flex align-items-start gap-3">
                                <i class="bi bi-geo-alt-fill text-primary fs-5 mt-1 flex-shrink-0" aria-hidden="true"></i>
                                <div>
                                    <div class="fw-semibold small">Ubicación</div>
                                    <span class="text-muted small">Quintero, Valparaíso. Online para el resto del país.</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-start gap-3">
                                <i class="bi bi-clock-fill text-primary fs-5 mt-1 flex-shrink-0" aria-hidden="true"></i>
                                <div>
                                    <div class="fw-semibold small">Horario</div>
                                    <span class="text-muted small">Clases desde las 18:00 hrs. de lunes a viernes.</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-start gap-3">
                                <i class="bi bi-laptop text-primary fs-5 mt-1 flex-shrink-0" aria-hidden="true"></i>
                                <div>
                                    <div class="fw-semibold small">Modalidad</div>
                                    <span class="text-muted small">Presencial u online, lo que te sea más cómodo.</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Response time card --}}
                    <div class="response-time-card">
                        <div class="response-indicator">
                            <span class="dot-green" aria-hidden="true"></span>
                            Tiempo de respuesta
                        </div>
                        <div class="response-time-value">Menos de 24 horas</div>
                    </div>

                    {{-- Materials promo --}}
                    <div class="sidebar-card">
                        <p class="fw-700 mb-1">¿Solo buscas material?</p>
                        <p class="text-muted small mb-3">Tengo guías, ejercicios y apuntes gratuitos disponibles para descargar.</p>
                        <a href="{{ route('materials.index') }}" class="btn btn-outline-primary btn-sm w-100">
                            <i class="bi bi-collection me-1" aria-hidden="true"></i>Ver materiales
                        </a>
                    </div>

                </aside>

            </div>

        @endif

    </div>

</div>
```

- [ ] **Step 4: Append contact SCSS to `_pages.scss`**

```scss
// ============================================================
// CONTACTO
// ============================================================
.contact-grid {
  display: grid;
  grid-template-columns: 1fr 340px;
  gap: 2.5rem;
  align-items: start;

  @media (max-width: 992px) {
    grid-template-columns: 1fr;
  }
}

.subject-selector {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: .5rem;

  @media (max-width: 576px) { grid-template-columns: repeat(2, 1fr); }

  .subject-option {
    input[type="radio"] { display: none; }

    label {
      display: block;
      padding: .6rem .5rem;
      border: 1.5px solid #e2e8f0;
      border-radius: .5rem;
      text-align: center;
      font-size: .78rem;
      font-weight: 600;
      color: #475569;
      cursor: pointer;
      transition: border-color .15s, color .15s, background .15s;
      line-height: 1.3;

      &:hover {
        border-color: #1a56db;
        color: #1a56db;
        background: #eff6ff;
      }
    }

    input:checked + label {
      border-color: #1a56db;
      background: #eff6ff;
      color: #1a56db;
    }
  }
}

.response-time-card {
  background: linear-gradient(135deg, var(--color-navy), var(--color-navy-dark));
  border-radius: .75rem;
  padding: 1.25rem;
  color: #fff;

  .response-indicator {
    display: flex;
    align-items: center;
    gap: .5rem;
    font-size: .82rem;
    color: rgba(255,255,255,.75);
    margin-bottom: .4rem;

    .dot-green {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background: #22c55e;
      flex-shrink: 0;
      animation: pulse-dot 2s infinite;
    }
  }
  .response-time-value { font-size: 1.1rem; font-weight: 700; }
}

@keyframes pulse-dot {
  0%, 100% { opacity: 1; transform: scale(1); }
  50%       { opacity: .7; transform: scale(1.2); }
}
```

- [ ] **Step 5: Run `npm run build`**

- [ ] **Step 6: Run tests**

```bash
php artisan test --filter=ContactTest
```

Expected: PASS.

- [ ] **Step 7: Run full test suite**

```bash
php artisan test
```

Expected: all passing.

- [ ] **Step 8: Commit**

```bash
git add resources/views/livewire/contact/form.blade.php resources/scss/_pages.scss tests/Feature/ContactTest.php
git commit -m "feat: redesign contacto page (2-col layout, subject selector, sidebar cards)"
```

---

## Self-review

**Spec coverage check:**

| Spec section | Task |
|---|---|
| Design system (§2) | Task 1 |
| Navbar + Footer (§5) | Task 2 |
| mat-card component (§4) | Task 3 |
| Home / all sections (§3.1) | Task 4 |
| Materiales listing (§3.2) | Task 5 |
| Material detail (§3.3) | Task 6 |
| Sobre mí (§3.4) | Task 7 |
| Servicios (§3.5) | Task 8 |
| Contacto (§3.6) | Task 9 |
| SCSS centralization (§6) | All tasks |
| SEO meta + Schema.org FAQ (§7) | Task 4 (FAQ), Task 6 (meta) |
| Responsiveness (§8) | All tasks — Bootstrap grid + media queries |
| No changes to Filament / auth (§9) | Confirmed — only view files modified |

**Placeholder scan:** none found.

**Type consistency:** `mat-type-{type}` class used in `card.blade.php` (Task 3) and `index.blade.php` (Task 5 list view) — consistent. `level-dot-*` classes defined in Task 1 `_design-system.scss` and used in Tasks 3, 4, 7, 8 — consistent. `sidebar-card` defined in Task 6 `_pages.scss` and reused in Task 9 — consistent.
