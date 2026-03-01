# CLAUDE.md

Este archivo define las reglas, convenciones y comportamientos esperados para cualquier agente de IA (LLM) que colabore en este proyecto.

---

## 1. Stack Tecnológico

- **Laravel 12** con **Livewire 3** (starter kit de Livewire)
- **Filament 3** — panel de administración en `/adminprofe` para gestionar contenido
- **Bootstrap 5** + Bootstrap Icons — UI del frontend (sin Tailwind; fue eliminado al inicio del proyecto)
- **SCSS** compilado con Vite (`resources/scss/app.scss` → importado desde `resources/js/app.js`)
- **Pest** para tests, **Laravel Scout** para búsqueda, **Resend** para correo
- **SQLite** por defecto (`:memory:` en tests); la migración incluye índices FULLTEXT de MySQL que solo aplican al usar MySQL

El agente **debe conocer y respetar** las convenciones de cada tecnología antes de proponer o modificar código.

> **Nota sobre Tailwind:** el proyecto **no usa Tailwind**. No sugerir clases de Tailwind ni instalar dependencias relacionadas. Filament 3 incluye su propio panel UI basado en Tailwind internamente, pero eso es transparente — no debe filtrarse al frontend público.

---

## 2. Comandos

```bash
# Iniciar el entorno de desarrollo completo (servidor + queue + logs + vite, en paralelo)
composer dev

# Ejecutar tests
composer test
# o un test específico
php artisan test --filter=NombreDelTest

# Lint (Laravel Pint)
./vendor/bin/pint

# Compilar assets
npm run build     # producción
npm run dev       # modo watch

# Comandos artisan frecuentes
php artisan migrate
php artisan migrate:fresh --seed
php artisan storage:link        # necesario para que los archivos subidos sean accesibles públicamente
```

---

## 3. Arquitectura

### Rutas públicas (`routes/web.php`)

| Ruta | Manejador |
|---|---|
| `/` | `PageController@home` |
| `/sobre-mi`, `/servicios` | vistas Blade estáticas |
| `/materiales` | componente `Livewire\Materials\Index` |
| `/materiales/{material:code}` | `MaterialController@show` (usa `code` como clave de ruta) |
| `/contacto` | componente `Livewire\Contact\Form` |

### Panel de administración

Filament en `/adminprofe` — el único recurso es `MaterialResource` (`app/Filament/Resources/`), que gestiona el CRUD de `Material` con subida de archivos a `storage/app/public/materials/YYYY/mm/`.

### Modelo Material (`app/Models/Material.php`)

Entidad central. Campos clave: `code` (único, usado como clave de ruta), `title`, `description`, `subject`, `level` (enum: `colegio`/`cft`/`particulares`/`universidad`/`instituto`), `course`, `year`, `semester`, `unit`, `type` (enum: `pdf`/`image`/`video`/`html`/`latex`/`link`/`other`), `file_path`, `link_url`, `published`. Tiene accesores `$m->nivel` (devuelve badge HTML) y `$m->tipo` (devuelve etiqueta legible del tipo).

### Componentes Livewire (`app/Livewire/`)

- `Materials/Index` — listado filtrable, ordenable y paginado con `?q`, `course`, `type`, `semester`, `perPage`, `sort`, `view` enlazados a la query string
- `Materials/Show` — página de detalle (actualmente reemplazada por `MaterialController`)
- `Contact/Form` — formulario de contacto
- `Auth/*` — flujos de autenticación estándar (login, registro, recuperación de contraseña, verificación de email)
- `Settings/*` — perfil, contraseña, apariencia, eliminar cuenta

### Vistas

- Layout principal: `resources/views/layouts/app.blade.php`
- Vistas Livewire: `resources/views/livewire/`
- Páginas estáticas: `resources/views/pages/`
- Componentes Blade: `resources/views/components/`

### Frontend

`resources/js/app.js` importa `resources/scss/app.scss` e inicializa tooltips y popovers de Bootstrap 5 globalmente. El único punto de entrada de Vite es `resources/js/app.js`.

---

## 4. Principio Fundamental: Pensamiento Crítico sobre las Propuestas

> **Este es el punto más importante de todo el documento.**

El agente **no debe ser complaciente**. Su valor está en pensar con rigor, no en aprobar lo que se le pide.

### El agente debe:

- **Cuestionar activamente** cualquier propuesta —sea del desarrollador o generada por él mismo— si detecta problemas de diseño, rendimiento, seguridad o mantenibilidad.
- **Señalar errores de razonamiento explícitamente**, aunque el desarrollador parezca convencido de su enfoque. Ejemplos:
  - "Esta solución asume X, pero en realidad ocurre Y."
  - "Esto funciona ahora, pero generará el problema Z en cuanto escale."
  - "Hay una contradicción entre lo que se pide aquí y lo definido en la sección anterior."
- **Proponer alternativas** cuando rechace una propuesta, explicando los trade-offs.
- **No validar por cortesía**. Frases como "Claro, eso también funciona" sin argumentación son inaceptables si hay razones técnicas para dudar.

### El agente NO debe:

- Aceptar una decisión solo porque el desarrollador insiste.
- Omitir advertencias para "no complicar" la respuesta.
- Generar código que sabe que es subóptimo sin decirlo.
- Asumir que el desarrollador tiene razón por defecto.

### Ejemplo de comportamiento correcto:

> **Desarrollador:** "Voy a guardar la sesión del usuario en una cookie sin cifrar para simplificar."
>
> **Agente:** "Eso expone datos de sesión al cliente y es un riesgo de seguridad directo. Laravel ya gestiona sesiones cifradas de forma nativa —no hay ganancia real en simplificar esto a costa de seguridad. ¿Cuál es el problema específico que intentas resolver? Probablemente hay una mejor forma."

---

## 5. Convenciones de Laravel 12

### Estructura y arquitectura

- Respetar la estructura de directorios estándar de Laravel. No crear carpetas arbitrarias sin justificación.
- Preferir **Form Requests** para validación en lugar de validar directamente en controladores.
- Usar **Resources / API Resources** para transformar datos en respuestas JSON.
- Aplicar el patrón **Service Layer** para lógica de negocio compleja (evitar controladores gordos).
- Usar **Policies** para autorización, no lógica `if` dispersa en controladores.

### Eloquent

- Definir explícitamente `$fillable` o `$guarded` en todos los modelos.
- Usar **eager loading** (`with()`) para evitar el problema N+1. El agente debe señalarlo si detecta consultas que lo generan.
- Preferir **scopes** locales para consultas reutilizables.
- No usar `DB::raw()` sin necesidad. Si se usa, el agente debe advertir sobre riesgos de inyección SQL.

### Rutas

- Agrupar rutas por contexto (`web`, `api`, `admin`) usando `Route::group` o `Route::prefix`.
- Nombrar todas las rutas con `->name()`.
- No definir lógica de negocio dentro de closures en rutas.

### Blade

- No escribir lógica PHP compleja en vistas Blade. Si aparece, debe extraerse a un componente, View Composer o el controlador.
- Usar **componentes Blade** (`<x-component>`) para elementos de UI reutilizables.
- Escapar siempre las variables con `{{ }}`. Usar `{!! !!}` solo cuando sea explícitamente necesario y documentado.

---

## 6. Convenciones de Bootstrap 5

- Usar las clases utilitarias de Bootstrap antes de escribir CSS personalizado.
- Si se necesita CSS propio, escribirlo en `resources/scss/app.scss` (o un parcial importado desde ahí), **nunca en `<style>` inline ni en archivos CSS separados no gestionados por Vite**.
- Aprovechar las variables SCSS de Bootstrap (`$primary`, `$spacer`, etc.) y las custom properties CSS (`--bs-primary`, etc.) para personalizaciones. Sobreescribir variables SCSS **antes** del `@import` de Bootstrap, no después.
- Respetar el sistema de **grid de 12 columnas** (`col-`, `col-md-`, etc.).
- No introducir Tailwind ni ningún otro framework CSS. Esta decisión es definitiva para el proyecto.
- Para componentes interactivos (modales, dropdowns, tooltips, popovers), usar los atributos `data-bs-*` nativos. La inicialización global de tooltips y popovers ya está en `app.js`; no duplicarla.

---

## 7. Convenciones de Bootstrap Icons

- Usar Bootstrap Icons mediante la clase CSS (`<i class="bi bi-nombre-icono">`), no como SVG inline salvo que haya una razón específica (como animación o manipulación dinámica).
- El nombre del ícono debe ser semánticamente coherente con la acción que representa.
- Incluir siempre un atributo `aria-label` o texto oculto (`visually-hidden`) cuando el ícono sea el único indicador de una acción, por accesibilidad.

```blade
{{-- Correcto --}}
<button class="btn btn-danger" aria-label="Eliminar registro">
    <i class="bi bi-trash" aria-hidden="true"></i>
</button>

{{-- Incorrecto: ícono sin contexto accesible --}}
<button class="btn btn-danger">
    <i class="bi bi-trash"></i>
</button>
```

---

## 8. Seguridad

El agente debe alertar activamente ante cualquiera de estos patrones:

- Variables sin escapar en Blade (`{!! $var !!}` sin justificación).
- Uso de `$request->all()` directo en `create()` o `update()` sin validación previa.
- Consultas con interpolación de strings en lugar de bindings.
- Lógica de autorización ausente o implementada ad-hoc fuera de Policies/Gates.
- Archivos subidos sin validación de tipo MIME y tamaño.
- Rutas o endpoints sin middleware de autenticación donde corresponde.

---

## 9. Calidad de Código

- Seguir **PSR-12** para estilo de código PHP.
- Los métodos deben tener una sola responsabilidad clara. Si un método hace más de una cosa, el agente debe señalarlo.
- Nombrar variables, métodos y clases de forma descriptiva en inglés. Evitar abreviaciones crípticas.
- Todo código nuevo debe ser, en principio, testeable. El agente debe señalar si una implementación dificulta las pruebas unitarias.

---

## 10. Gestión de Cambios

Antes de generar código que modifique archivos existentes, el agente debe:

1. Describir qué va a cambiar y por qué.
2. Indicar si el cambio tiene efectos secundarios en otras partes del sistema.
3. Esperar confirmación si el cambio es destructivo o afecta la base de datos.

---

## 11. Comunicación del Agente

- Las respuestas deben ser directas. Evitar relleno introductorio ("¡Claro! Con gusto te ayudo...").
- Si hay ambigüedad en un requerimiento, preguntar antes de asumir.
- Cuando se detecte un error en el razonamiento del desarrollador, mencionarlo primero, antes de proporcionar la solución solicitada.
- Usar bloques de código con el lenguaje especificado (` ```php `, ` ```blade `, ` ```js `).

---

## 12. Lo que el Agente NO debe hacer

- Generar migraciones destructivas (`dropColumn`, `dropTable`) sin advertencia explícita.
- Modificar archivos de configuración de entorno (`.env`, `config/`) sin solicitarlo expresamente.
- Instalar paquetes nuevos sin mencionar el comando y el impacto en el proyecto.
- Asumir el contexto de producción o desarrollo sin que se haya especificado.
- Inventar nombres de métodos, clases o rutas que no existen en el proyecto.
