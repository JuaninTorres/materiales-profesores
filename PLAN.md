# Rediseño frontend — profenicolas.cl

Plan de trabajo en progreso. Cada tarea es independiente y puede ejecutarse en una conversación separada.

**Spec completa:** `docs/superpowers/specs/2026-04-10-nuevo-diseno-design.md`  
**Plan detallado:** `docs/superpowers/plans/2026-04-10-nuevo-diseno.md`

---

## Contexto rápido

- Stack: Laravel 12 + Livewire 3 + Bootstrap 5 SCSS (sin Tailwind)
- SCSS vía Vite: `resources/scss/app.scss` (único punto de entrada)
- **Regla crítica:** ningún `style=` inline ni `<style>` en Blade — todo CSS va en SCSS
- **Sin CDN externos:** Bootstrap, Bootstrap Icons, AOS y fuentes se sirven localmente vía npm/Vite
- Paleta: Navy `#1e3a5f`, Amber `#f59e0b`, Cream `#f8f5f0`, Footer `#0f1e2e`
- Fuente: Plus Jakarta Sans (400/600/700/800) — instalada vía `@fontsource/plus-jakarta-sans`, bundleada por Vite

---

## Archivos nuevos a crear

| Archivo | Responsabilidad |
|---|---|
| `resources/scss/_design-system.scss` | Variables CSS, utilidades, bg/text/btn helpers |
| `resources/scss/_components.scss` | Navbar, footer, mat-card, filter-bar, sidebar-card |
| `resources/scss/_pages.scss` | Estilos específicos por página (hero, timeline, etc.) |
| `resources/views/components/materials/card.blade.php` | Componente `<x-materials.card>` reutilizable |

## Archivos a modificar

| Archivo | Qué cambia |
|---|---|
| `resources/scss/_variables.scss` | `$primary`, `$font-family-sans-serif` |
| `resources/scss/app.scss` | Agrega imports de los 3 partials nuevos |
| `resources/views/layouts/app.blade.php` | Google Fonts, navbar nueva, footer nuevo, `@stack('scripts')` |
| `resources/views/pages/home.blade.php` | Hero, value cards, niveles, materiales recientes, FAQ, CTA |
| `resources/views/livewire/materials/index.blade.php` | Page header navy, filter bar, badges, grid con mat-card |
| `resources/views/materiales/show.blade.php` | Layout 2 columnas CSS grid, PDF viewer, ficha técnica, sidebar |
| `resources/views/pages/about.blade.php` | Hero navy, logros, timeline 2 cols, metodología |
| `resources/views/pages/services.blade.php` | Page header, tarjeta destacada amber, info práctica |
| `resources/views/livewire/contact/form.blade.php` | 2 columnas, selector radio para asunto, sidebar cards |

**No cambia:** lógica PHP, modelos, rutas, Filament, vistas de auth/settings.

---

## Progreso

- [x] **Tarea 1 — SCSS foundation + fuente self-hosted**
  - `npm install @fontsource/plus-jakarta-sans` (sin CDN)
  - Actualizar `_variables.scss` (`$primary`, `$font-family-sans-serif`)
  - Crear `_design-system.scss` (variables CSS, utilidades, paleta)
  - Crear `_components.scss` y `_pages.scss` (shells vacíos)
  - Actualizar `app.scss`: imports de fontsource al inicio, imports de partials al final
  - Verificar: `npm run build` sin errores (Vite bundlea los `.woff2` localmente)
  - Commit: `feat: add design system SCSS foundation, self-host Plus Jakarta Sans via Fontsource`

- [ ] **Tarea 2 — Layout: Navbar + Footer**
  - Archivo: `resources/views/layouts/app.blade.php`
  - Sin `<link>` externos — la fuente ya viene de Tarea 1
  - Agregar: `@stack('scripts')`, navbar `.navbar-site` (navy), footer `.site-footer` (dark)
  - SCSS en `_components.scss`
  - Commit: `feat: redesign navbar and footer`

- [ ] **Tarea 3 — Componente mat-card**
  - Crear: `resources/views/components/materials/card.blade.php`
  - SCSS `.mat-card`, `.mat-type-badge`, `.mat-level-dot` en `_components.scss`
  - Commit: `feat: add mat-card Blade component`

- [ ] **Tarea 4 — Home page**
  - Archivo: `resources/views/pages/home.blade.php`
  - Secciones: hero, 3 value-cards, 4 level-pills, grid de mat-cards (últimos 6), FAQ accordion Bootstrap con Schema.org FAQPage, CTA final navy
  - SCSS en `_pages.scss`
  - Commit: `feat: redesign home page`

- [ ] **Tarea 5 — Materiales: listado**
  - Archivo: `resources/views/livewire/materials/index.blade.php`
  - Page header navy, filter bar sticky, active filter badges, grid de mat-cards
  - Preservar toda la lógica Livewire (`wire:model.live`, `setView()`, paginación)
  - Commit: `feat: redesign materials listing page`

- [ ] **Tarea 6 — Material: detalle**
  - Archivo: `resources/views/materiales/show.blade.php`
  - Layout 2 columnas (CSS grid), PDF viewer con toolbar, ficha técnica, share buttons, materiales relacionados, CTA hacia /servicios
  - Quitar inline `style="height: 82vh;"` → clase CSS
  - Commit: `feat: redesign material detail page`

- [ ] **Tarea 7 — Sobre mí**
  - Archivo: `resources/views/pages/about.blade.php`
  - Hero navy 2 cols, grid de 4 logros, timeline 2 cols, 3 metodología cards, CTA doble
  - Commit: `feat: redesign about page`

- [ ] **Tarea 8 — Servicios**
  - Archivo: `resources/views/pages/services.blade.php`
  - Page header navy, 3 service cards (`.featured` con borde amber), info práctica 2×2, lista de niveles con color-dots
  - Commit: `feat: redesign services page`

- [ ] **Tarea 9 — Contacto**
  - Archivo: `resources/views/livewire/contact/form.blade.php`
  - Page header navy, layout 2 columnas CSS grid, selector de asunto en radio grid 6 opciones (mantiene `wire:model.live="subject"`), sidebar con 3 cards
  - Commit: `feat: redesign contact page`

---

## Cómo usar este plan

Al iniciar una nueva conversación, di algo como:

> "Empecemos la Tarea N del rediseño. Lee el PLAN.md y el plan detallado en docs/superpowers/plans/2026-04-10-nuevo-diseno.md"

El agente debe leer ambos archivos antes de empezar. Al terminar cada tarea, marcar el checkbox correspondiente en este archivo.
