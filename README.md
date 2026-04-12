# Materiales Profesores

Plataforma digital para compartir y gestionar materiales educativos. Sistema integral con panel administrativo para docentes, búsqueda avanzada y organización por nivel, asignatura y período académico.

**Sitio en vivo:** [profenicolas.cl](https://profenicolas.cl)

---

## Stack Tecnológico

- **Backend:** Laravel 12 con Livewire 3
- **Admin Panel:** Filament 3 (`/adminprofe`)
- **Frontend:** Bootstrap 5 + Bootstrap Icons (SCSS via Vite)
- **Búsqueda:** Laravel Scout + Algolia
- **Email:** Resend
- **Testing:** Pest
- **Base de datos:** SQLite (desarrollo), MySQL (producción)
- **Servidor:** Laravel Forge + DigitalOcean

---

## Requisitos

- PHP 8.4+
- Node.js 22+
- Composer 2
- SQLite (para desarrollo)

---

## Instalación Rápida

```bash
# Clonar repositorio
git clone https://github.com/JuaninTorres/materiales-profesores.git
cd materiales-profesores

# Instalar dependencias
composer install
npm install

# Configurar entorno
cp .env.example .env
php artisan key:generate

# Migraciones y seeders
php artisan migrate:fresh --seed

# Enlace de almacenamiento (para archivos subidos)
php artisan storage:link

# Compilar assets
npm run dev
```

---

## Comandos Principales

```bash
# Iniciar servidor de desarrollo (todo en paralelo: servidor, queue, logs, vite)
composer dev

# Ejecutar tests
composer test
php artisan test --filter=NombreDelTest

# Lint de código (Laravel Pint)
./vendor/bin/pint

# Compilar assets
npm run build     # producción
npm run dev       # modo watch
```

---

## Estructura del Proyecto

### Rutas Públicas

| Ruta | Controlador | Descripción |
|------|-------------|-------------|
| `/` | `PageController@home` | Página de inicio |
| `/materiales` | `Livewire\Materials\Index` | Listado filtrable de materiales |
| `/materiales/{material:code}` | `MaterialController@show` | Detalle de material |
| `/sobre-mi`, `/servicios` | Vistas estáticas | Información del sitio |
| `/contacto` | `Livewire\Contact\Form` | Formulario de contacto |
| `/sitemap.xml` | `PageController@sitemap` | Mapa XML |

### Panel de Administración (`/adminprofe`)

Acceso exclusivo con Filament 3. Gestión del CRUD de `Material`:
- Subida de archivos a `storage/app/public/materials/YYYY/mm/`
- Campos: código, título, descripción, asignatura, nivel, curso, año, semestre, unidad, tipo, archivo, URL externa
- Publicación/despublicación inmediata

### Modelo Material

```php
// Campos principales
$material->code           // Clave de ruta (único)
$material->title          // Título del material
$material->description    // Descripción
$material->subject        // Asignatura
$material->level          // Enum: colegio, cft, particulares, universidad, instituto
$material->course         // Curso
$material->year           // Año
$material->semester       // Semestre (1 o 2)
$material->unit           // Unidad temática
$material->type           // Enum: pdf, image, video, html, latex, link, other
$material->file_path      // Ruta del archivo en storage
$material->link_url       // URL externa si type=link
$material->published      // boolean

// Acesores útiles
$material->nivel          // Badge HTML formateado
$material->tipo           // Etiqueta legible del tipo
```

### Componentes Livewire

- **`Materials/Index`** — Listado con filtros encadenados (`?q`, `course`, `type`, `semester`, `perPage`, `sort`, `view`)
- **`Contact/Form`** — Formulario de contacto
- **`Auth/*`** — Autenticación estándar (login, registro, 2FA, recuperación)
- **`Settings/*`** — Perfil de usuario

### Assets

```
resources/
├── js/app.js                  # Punto de entrada (inicializa Bootstrap, tooltips, popovers)
├── scss/app.scss              # Importa Bootstrap + personalizaciones
└── views/
    ├── layouts/app.blade.php  # Layout principal
    ├── livewire/              # Componentes Livewire
    ├── pages/                 # Páginas estáticas
    └── components/            # Componentes Blade reutilizables
```

---

## Características Principales

### ✅ Búsqueda y Filtrado
- Búsqueda por texto en título y descripción
- Filtros por asignatura, nivel, semestre, tipo
- Ordenamiento flexible
- Paginación configurable
- Vista de lista o galería

### ✅ Panel Administrativo
- CRUD de materiales con interfaz intuitiva
- Subida de archivos con validación
- Vista previa de materiales
- Gestión de permisos basada en roles Filament

### ✅ Autenticación
- Login/registro con email
- Verificación de email
- Recuperación de contraseña
- Cambio de contraseña
- Eliminación de cuenta

### ✅ SEO y Performance
- Mapa de sitio XML dinámico
- Estructura HTML semántica
- Metaetiquetas configurables por página
- Índices FULLTEXT en MySQL para búsqueda rápida
- Caché de scouts y vistas

---

## Convenciones de Desarrollo

### PHP / Laravel
- Seguir PSR-12
- Usar Type Hints y Return Types
- Métodos con única responsabilidad
- Form Requests para validación
- Eloquent Scopes para consultas reutilizables
- Eager loading para evitar N+1 queries

### Frontend
- **Bootstrap 5** para componentes — no Tailwind
- SCSS compilado desde `resources/scss/app.scss`
- Classes utilitarias de Bootstrap antes que CSS personalizado
- Inicializar tooltips/popovers vía `data-bs-*` (ya configurado globalmente)
- Escapar variables con `{{ }}` (usar `{!! !!}` solo si es necesario)

### Testing
- Pest para tests unitarios e integración
- Base de datos en memoria (`:memory:`) para velocidad
- Fixtures y factories para datos de prueba
- Tests aislados sin dependencias entre ellos

---

## Variables de Entorno Clave

```env
# Aplicación
APP_NAME="Profe Nicolas"
APP_ENV=local|production
APP_KEY=base64:... (generar con php artisan key:generate)
APP_DEBUG=true|false
APP_URL=http://localhost|https://profenicolas.cl
APP_LOCALE=es

# Base de datos
DB_CONNECTION=sqlite|mysql
DB_DATABASE=:memory:|nombre_db

# Email
MAIL_MAILER=log|resend
RESEND_API_KEY=...

# Búsqueda
SCOUT_DRIVER=null|algolia
ALGOLIA_APP_ID=...
ALGOLIA_SECRET=...

# Storage
FILESYSTEM_DISK=public
```

---

## Troubleshooting

### Tests fallan con "Unsupported cipher"
Verifica que `.env.testing` tenga un `APP_KEY` válido (base64 de 32 bytes). Genera uno:
```bash
php artisan key:generate --show
```

### Archivos subidos no son accesibles
Ejecuta:
```bash
php artisan storage:link
```

### Panel Filament muestra error 403
Asegúrate de que el usuario implementa `FilamentUser` e implementa `canAccessPanel()`.

---

## Despliegue en Producción

El proyecto está configurado para Laravel Forge:

1. Conectar repositorio GitHub a Forge
2. Configurar `.env` con credenciales de producción
3. Ejecutar migraciones: `php artisan migrate --force`
4. Compilar assets: `npm run build`
5. Configurar almacenamiento: `php artisan storage:link`

SSL se maneja automáticamente con Let's Encrypt via Forge.

---

## Contribuir

1. Crea una rama feature desde `main`:
   ```bash
   git checkout -b feature/tu-caracteristica
   ```

2. Realiza tus cambios respetando las convenciones del proyecto

3. Ejecuta tests y lint:
   ```bash
   composer test
   ./vendor/bin/pint
   ```

4. Crea un Pull Request hacia `main` con descripción clara

---

## Licencia

Privado — Este proyecto es de uso exclusivo de Nicolás Torres.

---

## Contacto

- **Sitio:** [profenicolas.cl](https://profenicolas.cl)
- **Correo:** contacto@profenicolas.cl
- **Repositorio:** [github.com/JuaninTorres/materiales-profesores](https://github.com/JuaninTorres/materiales-profesores)
