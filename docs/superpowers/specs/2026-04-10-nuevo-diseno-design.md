# Spec: Rediseño completo de profenicolas.cl

**Fecha:** 2026-04-10  
**Estado:** Aprobado por el usuario (mockups revisados)

---

## 1. Objetivo

Rediseñar el frontend público de profenicolas.cl con dos metas principales:

1. **Conversión de estudiantes** — facilitar el acceso y descarga de materiales académicos gratuitos.
2. **Conversión de potenciales alumnos** — comunicar la propuesta de valor de las clases particulares y guiar al contacto.

El rediseño también mejora el SEO técnico (Schema.org, meta tags, Open Graph, jerarquía de encabezados).

---

## 2. Sistema de diseño

### Paleta de colores

| Token | Valor | Uso |
|---|---|---|
| Navy primario | `#1e3a5f` | Fondos de sección, navbar, page headers |
| Mid-blue | `#1a56db` | Acentos interactivos, badges tipo |
| Amber | `#f59e0b` | CTA primario, énfasis, badge featured |
| Crema cálido | `#f8f5f0` | Fondo alterno de secciones |
| Footer oscuro | `#0f1e2e` | Footer |
| Texto base | `#e2e8f0` sobre oscuro, `#1e293b` sobre claro |

### Tipografía

- **Fuente:** Plus Jakarta Sans (pesos 400, 600, 700, 800)
- **Import:** Google Fonts en `<head>` de `layouts/app.blade.php`
- **Escala:** `1rem` base, H1 en páginas hero ~ `2.5–3rem`

### Logo

SVG con polígono "N" en amber `#f59e0b` y ejes de coordenadas sutiles. Se ubica en la navbar izquierda.

---

## 3. Estructura de páginas

### 3.1 Home (`/`)

**Secciones (en orden):**

1. **Navbar** — logo izquierda, links derecha (Materiales / Sobre mí / Servicios / Contacto), botón CTA "Ver materiales" en amber
2. **Hero** — título principal con énfasis en amber, subtítulo, dos CTAs (primario amber + secundario outline), imagen de apoyo
3. **Propuestas de valor** — 3 cards horizontales (Materiales gratis, Clases presenciales/online, Años de experiencia)
4. **Niveles** — 4 pills/badges (Colegio, PAES, CFT/Instituto, Universidad) con descripción breve
5. **Materiales recientes** — grid 3 columnas de `mat-card` (últimos 6 materiales publicados)
6. **FAQ** — acordeón con Schema.org `FAQPage` markup
7. **CTA final** — sección navy gradient, "¿Listo para mejorar tus notas?", botón contacto
8. **Footer** — 4 columnas (marca/tagline, navegación, contacto, créditos), fondo `#0f1e2e`

### 3.2 Materiales — Listado (`/materiales`)

**Estructura:**

1. **Page header** — fondo navy, H1, subtítulo, barra de búsqueda
2. **Filter bar sticky** — selects: nivel / curso / unidad / tipo; contador de resultados; toggle grid/lista
3. **Active filter badges** — pills con ×, link "Borrar filtros"
4. **Grid de tarjetas** — `.mat-card` (detalle en §4)
5. **Paginación** — Bootstrap pagination

### 3.3 Material — Detalle (`/materiales/{code}`)

**Layout:** 2 columnas — contenido principal `1fr` + sidebar `300px`

**Columna izquierda:**
- Breadcrumb (`Inicio › Materiales › [título]`)
- Eyebrow badges (nivel + tipo)
- H1 título
- Descripción
- PDF viewer (iframe con toolbar: descarga + pantalla completa)
- Sección de tags
- Link "← Volver a materiales"

**Sidebar derecha:**
- Ficha técnica (nivel, asignatura, unidad, semestre, año, tipo, páginas, tamaño)
- Botón "Descargar" CTA
- Botones de compartir (Twitter/X, WhatsApp, copiar link)
- Lista de materiales relacionados (mismo curso/unidad)
- Card CTA navy hacia `/servicios`

### 3.4 Sobre mí (`/sobre-mi`)

**Secciones:**
1. Hero 2 columnas: texto (eyebrow, H1 con énfasis amber, descripción, credenciales) + foto con badge "4× Medalla"
2. Grid de logros (4 cards): +13 años, 3 niveles, 4× medalla, 100% materiales gratis
3. Timeline en 2 columnas: Historia (2011 / 2013 / 2018 / 2024) + Formación (UV Licenciatura, Pedagogía, Medallas)
4. Metodología (3 cards): Diagnóstico primero / Conexión con lo concreto / Materiales propios
5. CTA doble: "Explorar materiales" + "Contactar"

### 3.5 Servicios (`/servicios`)

**Secciones:**
1. Hero centrado (navy gradient)
2. Grid 3 tarjetas de servicio: **Clases particulares** (`.featured`, borde amber), Preparación PAES, Nivelación intensiva — cada una con checklist de incluidos
3. Info práctica 2×2: Modalidad / Horarios / Cómo agendar / Preguntas frecuentes
4. Lista de niveles con color-dots (colegio=verde, PAES=amber, CFT=azul, universidad=púrpura)
5. CTA final: "Contactar ahora" + "Ver materiales gratis"

### 3.6 Contacto (`/contacto`)

**Layout:** 2 columnas — formulario `1fr` + sidebar `360px`

**Formulario:**
- Nombre + Email (row 2 columnas)
- Selector de asunto (grid de 6 radio buttons visuales)
- Textarea mensaje
- Botón submit amber
- Nota de privacidad

**Sidebar:**
- Card info (email, ubicación, horarios, modalidad)
- Card tiempo de respuesta (navy gradient, dot verde, "menos de 24 horas")
- Card promo materiales

---

## 4. Componente: `.mat-card`

Tarjeta de material reutilizable en home (recientes) y `/materiales`.

**Estructura:**
```
.mat-card
  .mat-card-header
    .mat-type-badge   ← PDF / VIDEO / HTML / IMAGE
    .mat-level-dot    ← color según nivel
  .mat-card-body
    h3.mat-title
    .mat-meta         ← curso · semestre · año
    .mat-tags         ← tags como pills
  .mat-card-footer
    .mat-pages        ← "X páginas" (si aplica)
    a.btn.btn-sm      ← "Descargar" / "Ver"
```

**Colores de nivel (dot + badge):**
- `colegio` → verde `#22c55e`
- `cft` / `instituto` → azul `#3b82f6`
- `universidad` → púrpura `#a855f7`
- `particulares` / PAES → amber `#f59e0b`

---

## 5. Navbar y Footer

### Navbar
- `<nav class="navbar navbar-expand-lg navbar-dark bg-navy sticky-top">`
- Logo SVG izquierda
- Links con `nav-link` estándar
- Botón CTA "Ver materiales" clase `.btn-amber` (amber bg, texto oscuro)
- Colapsa en hamburger en mobile

### Footer
- 4 columnas Bootstrap grid
- Fondo `#0f1e2e`, texto `#94a3b8` (suficiente contraste)
- `.footer-col-h` títulos en `#64748b`
- `.footer-bottom` borde superior `1px solid #1e2d3d`, texto `#64748b`

---

## 6. SCSS — Centralización de estilos

**Regla fundamental:** toda clase CSS personalizada vive en `resources/scss/app.scss` (o parciales importados desde ahí). Las vistas Blade **no tienen `<style>` ni atributos `style=`**.

**Estructura sugerida de `app.scss`:**
```scss
// 1. Variables Bootstrap (override antes del import)
// 2. @import Bootstrap
// 3. @import Bootstrap Icons
// 4. Componentes globales: navbar, footer
// 5. Componentes de materiales: .mat-card, .mat-type-badge, .mat-level-dot
// 6. Páginas específicas: .page-hero, .filter-bar, .ficha-tecnica, etc.
// 7. Utilidades propias: .bg-navy, .btn-amber, .section-cream, etc.
```

---

## 7. SEO

- `<title>` único por página con patrón: `[Página] — Profe Nicolás`
- `<meta name="description">` ≤ 155 caracteres por página
- Open Graph tags (`og:title`, `og:description`, `og:image`, `og:url`)
- Schema.org `FAQPage` en home (JSON-LD en `<script type="application/ld+json">`)
- Jerarquía de encabezados: un solo `<h1>` por página, `<h2>` para secciones, `<h3>` para subsecciones
- Sitemap ya existente en `/sitemap.xml`

---

## 8. Responsividad

- Mobile-first con breakpoints Bootstrap (`sm`, `md`, `lg`)
- Layouts de 2 columnas (detalle material, sidebar contacto, sobre-mi hero) colapsan a 1 columna en `< md`
- Grid de materiales: 3 cols en `lg`, 2 en `md`, 1 en `sm`
- Navbar colapsa a hamburger en `< lg`
- PDF viewer: altura fija `600px` en desktop, `400px` en mobile

---

## 9. Lo que NO cambia

- Panel Filament en `/adminprofe` — sin modificaciones
- Lógica de filtros Livewire en `Materials/Index` — se conserva, solo cambia la vista Blade
- Modelo `Material` y sus campos — sin cambios
- Rutas — mismas URLs
- Auth flows (`/login`, `/register`, etc.) — sin cambios en este rediseño
