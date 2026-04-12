# SEO Improvements — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Corregir y mejorar todos los puntos de SEO identificados en la auditoría de profenicolas.cl.

**Architecture:** Los meta tags se centralizan en `layouts/app.blade.php` usando `@yield` con defaults globales, mientras cada vista sobreescribe con `@section`. Los datos estructurados (JSON-LD) se inyectan vía `@stack('jsonld')`. El canonical y OG:URL se resuelven automáticamente con `request()->url()` en el layout, con posibilidad de override por página.

**Tech Stack:** Laravel 12, Blade, Bootstrap 5, Schema.org JSON-LD.

---

## Estado del Proyecto

| Tarea | Estado | Commit |
|-------|--------|--------|
| 1. Meta description en todas las páginas | ✅ COMPLETADA | 987f16b |
| 2. Open Graph y Twitter Card | ✅ COMPLETADA | 57e9adf |
| 3. Canonical tags en todas las páginas | ✅ COMPLETADA | e1756b4 |
| 4. Datos estructurados (Person + WebSite) | ✅ COMPLETADA | 54be2f1 |
| 5. Datos estructurados (LearningResource + BreadcrumbList) | ✅ COMPLETADA | bfb6e5a |
| 6. Sitemap — lastmod en páginas estáticas | ✅ COMPLETADA | 41b0da8 |

---

## Archivos afectados

| Archivo | Acción |
|---|---|
| `resources/views/layouts/app.blade.php` | Modificar: añadir meta description, OG tags, canonical, Twitter Card, stack jsonld |
| `resources/views/pages/home.blade.php` | Modificar: añadir section description, section og_image, push jsonld (Person + FAQPage) |
| `resources/views/pages/about.blade.php` | Modificar: añadir section description, push meta |
| `resources/views/pages/services.blade.php` | Modificar: añadir section description, push meta |
| `resources/views/livewire/materials/index.blade.php` | Modificar: añadir section description, canonical |
| `resources/views/livewire/contact/form.blade.php` | Modificar: añadir section description |
| `resources/views/materiales/show.blade.php` | Modificar: migrar description a @section, añadir OG tags, BreadcrumbList JSON-LD, LearningResource JSON-LD |
| `resources/views/sitemap.blade.php` | Modificar: añadir lastmod a páginas estáticas |

---

## ✅ Tarea 1: `meta description` en todas las páginas

**Estado:** COMPLETADA (Commit: 987f16b)

**Archivos:**
- Modificar: `resources/views/layouts/app.blade.php`
- Modificar: `resources/views/pages/home.blade.php`
- Modificar: `resources/views/pages/about.blade.php`
- Modificar: `resources/views/pages/services.blade.php`
- Modificar: `resources/views/livewire/materials/index.blade.php`
- Modificar: `resources/views/livewire/contact/form.blade.php`
- Modificar: `resources/views/materiales/show.blade.php`

- [ ] **Paso 1: Agregar `@yield('description')` en el layout**

En `resources/views/layouts/app.blade.php`, reemplazar la línea del `<title>`:

```blade
<title>@yield('title', 'profenicolas.cl')</title>
<meta name="description" content="@yield('description', 'Materiales gratuitos de matemática y clases particulares con Nicolás González, profesor en Quintero, Chile. Para colegio, PAES, CFT y universidad.')">
```

- [ ] **Paso 2: Añadir description en Home**

En `resources/views/pages/home.blade.php`, después de `@section('main_class', '')`:

```blade
@section('description', 'Hola, soy el Profe Nicolás González. Materiales gratuitos de matemática para colegio, PAES, CFT y universidad, más clases particulares en Quintero y online.')
```

- [ ] **Paso 3: Añadir description en Sobre mí**

En `resources/views/pages/about.blade.php`, después de `@section('main_class', '')`:

```blade
@section('description', 'Nicolás González M., profesor de Matemática con más de 13 años de experiencia en colegio, PAES y CFT. Egresado de la Universidad de Valparaíso. Clases en Quintero u online.')
```

- [ ] **Paso 4: Añadir description en Servicios**

En `resources/views/pages/services.blade.php`, después de `@section('main_class', '')`:

```blade
@section('description', 'Clases particulares de matemática con Nicolás González: refuerzo escolar 7° básico a 4° medio, preparación PAES y nivelación intensiva. Presencial en Quintero u online.')
```

- [ ] **Paso 5: Añadir description en Materiales (Livewire)**

En `resources/views/livewire/materials/index.blade.php`, después de `@section('main_class', '')`:

```blade
@section('description', 'Biblioteca gratuita de guías, ejercicios y apuntes de matemática para colegio, PAES, CFT y universidad. Sin registro, de libre descarga.')
```

- [ ] **Paso 6: Añadir description en Contacto (Livewire)**

En `resources/views/livewire/contact/form.blade.php`, después de `@section('main_class', '')`:

```blade
@section('description', 'Escríbele al Profe Nicolás González para agendar una clase particular de matemática o resolver tus dudas. Respuesta en menos de 24 horas.')
```

- [ ] **Paso 7: Migrar description en Show a `@section`**

En `resources/views/materiales/show.blade.php`, el `@push('meta')` actual mezcla description y canonical. Separar: sacar la description del push y convertirla en section. Reemplazar el bloque `@push('meta')` existente por:

```blade
@php
    $metaDescription = Str::limit(strip_tags($material->description ?? ''), 155)
        ?: $material->title . ' · Material de matemática de Profe Nicolás González.';
@endphp
@section('description', $metaDescription)

@push('meta')
    <link rel="canonical" href="{{ route('materials.show', $material) }}">
@endpush
```

- [ ] **Paso 8: Verificar en el navegador**

Ejecutar el servidor:
```bash
composer dev
```

Abrir cada URL y verificar en DevTools → Elements que el `<head>` contiene:
```html
<meta name="description" content="...">
```

- `/` → description sobre materiales gratuitos y Nicolás González
- `/sobre-mi` → description sobre el profesor
- `/servicios` → description sobre clases particulares
- `/materiales` → description sobre biblioteca gratuita
- `/contacto` → description sobre contacto
- `/materiales/{cualquier-code}` → description dinámica del material

- [ ] **Paso 9: Commit**

```bash
git add resources/views/layouts/app.blade.php \
        resources/views/pages/home.blade.php \
        resources/views/pages/about.blade.php \
        resources/views/pages/services.blade.php \
        resources/views/livewire/materials/index.blade.php \
        resources/views/livewire/contact/form.blade.php \
        resources/views/materiales/show.blade.php
git commit -m "feat(seo): add meta description to all pages"
```

---

## ✅ Tarea 2: Open Graph y Twitter Card en todas las páginas

**Estado:** COMPLETADA (Commit: 57e9adf)

**Archivos:**
- Modificar: `resources/views/layouts/app.blade.php`
- Modificar: `resources/views/pages/home.blade.php`
- Modificar: `resources/views/pages/about.blade.php`
- Modificar: `resources/views/pages/services.blade.php`
- Modificar: `resources/views/livewire/materials/index.blade.php`
- Modificar: `resources/views/livewire/contact/form.blade.php`
- Modificar: `resources/views/materiales/show.blade.php`

- [ ] **Paso 1: Añadir bloque OG en el layout (defaults globales)**

En `resources/views/layouts/app.blade.php`, después de la meta description:

```blade
{{-- Open Graph --}}
<meta property="og:site_name" content="Profe Nicolás">
<meta property="og:locale" content="es_CL">
<meta property="og:type" content="@yield('og_type', 'website')">
<meta property="og:title" content="@yield('og_title', @yield('title', 'Profe Nicolás · Matemática'))">
<meta property="og:description" content="@yield('og_description', @yield('description', 'Materiales gratuitos de matemática y clases particulares con Nicolás González, profesor en Quintero, Chile.'))">
<meta property="og:url" content="@yield('og_url', request()->url())">
<meta property="og:image" content="@yield('og_image', asset('images/og-default.jpg'))">
{{-- Twitter Card --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="@yield('og_title', @yield('title', 'Profe Nicolás'))">
<meta name="twitter:description" content="@yield('og_description', @yield('description', 'Materiales gratuitos de matemática y clases particulares.'))">
<meta name="twitter:image" content="@yield('og_image', asset('images/og-default.jpg'))">
```

Nota: La imagen `og-default.jpg` debe existir en `public/images/`. Si no existe, crear una imagen de 1200×630px con el logo/branding del sitio y subirla a `public/images/og-default.jpg`.

- [ ] **Paso 2: Añadir og_type y og_title en Show (material)**

En `resources/views/materiales/show.blade.php`, añadir tras los `@section` ya existentes:

```blade
@section('og_type', 'article')
@section('og_title', $material->title . ' · Profe Nicolás')
@section('og_description', Str::limit(strip_tags($material->description ?? ''), 155) ?: $material->title . ' · Material gratuito de matemática.')
```

Si el material tiene imagen adjunta, añadir también:
```blade
@if($material->type === 'image' && $material->file_path)
    @section('og_image', asset('storage/' . $material->file_path))
@endif
```

- [ ] **Paso 3: Verificar en el navegador**

Con el servidor corriendo, usar la extensión "Meta SEO inspector" o DevTools para verificar que en `/materiales/{code}` aparecen los tags OG con valores correctos, y en `/` aparecen los defaults.

Alternativa rápida: ver source con `Ctrl+U` y buscar `og:title`.

- [ ] **Paso 4: Commit**

```bash
git add resources/views/layouts/app.blade.php \
        resources/views/materiales/show.blade.php
git commit -m "feat(seo): add Open Graph and Twitter Card meta tags"
```

---

## Tarea 3: Canonical tags en todas las páginas

**Archivos:**
- Modificar: `resources/views/layouts/app.blade.php`

- [ ] **Paso 1: Añadir canonical global en el layout**

En `resources/views/layouts/app.blade.php`, después de las meta OG y Twitter Card:

```blade
<link rel="canonical" href="@yield('canonical', request()->url())">
```

Nota: `request()->url()` devuelve la URL sin query string, lo que es el comportamiento correcto para páginas con filtros como `/materiales`.

- [ ] **Paso 2: Eliminar el canonical del @push('meta') en Show**

En `resources/views/materiales/show.blade.php`, el `@push('meta')` ahora solo tendría el canonical, que ya viene del layout. Eliminar el canonical del push:

```blade
{{-- Eliminar esta línea del @push('meta') --}}
<link rel="canonical" href="{{ route('materials.show', $material) }}">
```

El canonical del layout usará `request()->url()` que para la ruta de show devuelve la URL correcta (sin query params). Si se quiere ser explícito con la ruta nombrada, mantener un `@section('canonical', route('materials.show', $material))` y modificar el layout para usar `@yield('canonical', request()->url())`.

Opción recomendada para Show (más explícito):
```blade
@section('canonical', route('materials.show', $material))
```

Y en el layout:
```blade
<link rel="canonical" href="@yield('canonical', request()->url())">
```

- [ ] **Paso 3: Verificar**

Revisar en source que:
- `/materiales?q=fracciones` tiene canonical `https://profenicolas.cl/materiales` (sin query string)
- `/materiales/tema01-fracciones` tiene canonical con su propia URL

- [ ] **Paso 4: Commit**

```bash
git add resources/views/layouts/app.blade.php \
        resources/views/materiales/show.blade.php
git commit -m "feat(seo): add canonical link tag to all pages"
```

---

## Tarea 4: Datos estructurados — Person y WebSite en Home

**Archivos:**
- Modificar: `resources/views/layouts/app.blade.php` (añadir `@stack('jsonld')`)
- Modificar: `resources/views/pages/home.blade.php`

- [ ] **Paso 1: Añadir stack jsonld en el layout**

En `resources/views/layouts/app.blade.php`, al final del `<head>`, antes del cierre:

```blade
@stack('jsonld')
```

- [ ] **Paso 2: Añadir JSON-LD de Person y WebSite en Home**

En `resources/views/pages/home.blade.php`, al final (antes de `@endsection`):

```blade
@push('jsonld')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "Person",
      "@id": "{{ url('/') }}#nicolas",
      "name": "Nicolás González M.",
      "jobTitle": "Profesor de Matemática",
      "url": "{{ url('/') }}",
      "sameAs": [],
      "address": {
        "@type": "PostalAddress",
        "addressLocality": "Quintero",
        "addressRegion": "Valparaíso",
        "addressCountry": "CL"
      },
      "knowsAbout": ["Matemática", "PAES", "Álgebra", "Cálculo", "Geometría"]
    },
    {
      "@type": "WebSite",
      "@id": "{{ url('/') }}#website",
      "url": "{{ url('/') }}",
      "name": "Profe Nicolás",
      "description": "Materiales gratuitos de matemática y clases particulares.",
      "publisher": {
        "@id": "{{ url('/') }}#nicolas"
      },
      "potentialAction": {
        "@type": "SearchAction",
        "target": {
          "@type": "EntryPoint",
          "urlTemplate": "{{ route('materials.index') }}?q={search_term_string}"
        },
        "query-input": "required name=search_term_string"
      }
    }
  ]
}
</script>
@endpush
```

Nota: El bloque FAQPage ya existe en el HTML de Home. Moverlo a un `@push('jsonld')` como JSON-LD es más limpio que el microdata actual, pero el microdata existente es válido. No modificar el FAQ por ahora para evitar regresiones.

- [ ] **Paso 3: Verificar con Rich Results Test**

Abrir `https://search.google.com/test/rich-results` e introducir `https://profenicolas.cl/`. Verificar que detecta Person y WebSite sin errores.

Alternativa local: ver source de `/` y buscar `application/ld+json`.

- [ ] **Paso 4: Commit**

```bash
git add resources/views/layouts/app.blade.php \
        resources/views/pages/home.blade.php
git commit -m "feat(seo): add Person and WebSite JSON-LD structured data"
```

---

## Tarea 5: Datos estructurados — LearningResource y BreadcrumbList en materiales

**Archivos:**
- Modificar: `resources/views/materiales/show.blade.php`

- [ ] **Paso 1: Añadir JSON-LD en Show**

En `resources/views/materiales/show.blade.php`, al final antes de `@endsection`:

```blade
@push('jsonld')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "LearningResource",
      "name": "{{ $material->title }}",
      "description": "{{ Str::limit(strip_tags($material->description ?? ''), 250) }}",
      "url": "{{ route('materials.show', $material) }}",
      "educationalLevel": "{{ $material->level }}",
      "learningResourceType": "{{ $material->tipo }}",
      "inLanguage": "es",
      "isAccessibleForFree": true,
      "author": {
        "@type": "Person",
        "name": "Nicolás González M.",
        "@id": "{{ url('/') }}#nicolas"
      },
      "provider": {
        "@type": "Person",
        "@id": "{{ url('/') }}#nicolas"
      }
      @if($material->subject)
      ,"teaches": "{{ $material->subject }}"
      @endif
    },
    {
      "@type": "BreadcrumbList",
      "itemListElement": [
        {
          "@type": "ListItem",
          "position": 1,
          "name": "Inicio",
          "item": "{{ url('/') }}"
        },
        {
          "@type": "ListItem",
          "position": 2,
          "name": "Materiales",
          "item": "{{ route('materials.index') }}"
        },
        {
          "@type": "ListItem",
          "position": 3,
          "name": "{{ $material->title }}"
        }
      ]
    }
  ]
}
</script>
@endpush
```

- [ ] **Paso 2: Verificar**

Abrir cualquier URL de material en producción (o localmente) y pasar la URL por `https://search.google.com/test/rich-results`. Esperar que detecte "LearningResource" y "Breadcrumb".

Alternativa local: ver source y buscar `application/ld+json`.

- [ ] **Paso 3: Commit**

```bash
git add resources/views/materiales/show.blade.php
git commit -m "feat(seo): add LearningResource and BreadcrumbList JSON-LD to material pages"
```

---

## Tarea 6: Sitemap — `<lastmod>` en páginas estáticas

**Archivos:**
- Modificar: `resources/views/sitemap.blade.php`
- Modificar: `app/Http/Controllers/PageController.php`

- [ ] **Paso 1: Pasar fecha del último material al sitemap**

En `app/Http/Controllers/PageController.php`, modificar `sitemap()`:

```php
public function sitemap()
{
    $materials = Material::where('published', true)
        ->select('code', 'updated_at')
        ->latest()
        ->get();

    $lastMaterialUpdate = $materials->first()?->updated_at ?? now();

    return response()
        ->view('sitemap', compact('materials', 'lastMaterialUpdate'))
        ->header('Content-Type', 'application/xml');
}
```

- [ ] **Paso 2: Añadir `<lastmod>` en páginas estáticas del sitemap**

En `resources/views/sitemap.blade.php`:

```xml
<url>
    <loc>{{ url('/') }}</loc>
    <lastmod>{{ $lastMaterialUpdate->toAtomString() }}</lastmod>
    <changefreq>weekly</changefreq>
    <priority>1.0</priority>
</url>
<url>
    <loc>{{ route('materials.index') }}</loc>
    <lastmod>{{ $lastMaterialUpdate->toAtomString() }}</lastmod>
    <changefreq>daily</changefreq>
    <priority>0.9</priority>
</url>
<url>
    <loc>{{ route('about') }}</loc>
    <changefreq>monthly</changefreq>
    <priority>0.7</priority>
</url>
<url>
    <loc>{{ route('services') }}</loc>
    <changefreq>monthly</changefreq>
    <priority>0.7</priority>
</url>
<url>
    <loc>{{ route('contact') }}</loc>
    <changefreq>monthly</changefreq>
    <priority>0.6</priority>
</url>
```

- [ ] **Paso 3: Verificar**

```bash
curl http://localhost:8000/sitemap.xml
```

Verificar que las URLs de `/` y `/materiales` tienen `<lastmod>` con fecha válida.

- [ ] **Paso 4: Commit**

```bash
git add resources/views/sitemap.blade.php \
        app/Http/Controllers/PageController.php
git commit -m "feat(seo): add lastmod to static pages in sitemap"
```

---

## Checklist final

- [ ] Revisar con `<Ctrl+U>` (source) en cada página que description, canonical y OG están presentes
- [ ] Validar home y un material en https://search.google.com/test/rich-results
- [ ] Verificar sitemap.xml en producción: https://profenicolas.cl/sitemap.xml
- [ ] Verificar robots.txt sigue apuntando al sitemap correcto
