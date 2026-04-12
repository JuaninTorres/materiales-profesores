# Laravel 13 Upgrade Plan — materiales-profesores

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Actualizar el proyecto de Laravel 12.x (v12.28.1) a Laravel 13.x.

**Architecture:** Actualización incremental por fases — investigación → entorno → dependencias → código → tests → deploy. La Fase 1 es obligatoria antes de tocar cualquier archivo.

**Tech Stack:** Laravel 13, PHP 8.3+, Livewire 3, Filament 3/4, Bootstrap 5, Pest, Laravel Forge.

---

## Estado del progreso

| Fase | Estado |
|---|---|
| 1. Investigación | ⬜ Pendiente |
| 2. Preparación del entorno | ⬜ Pendiente |
| 3. Actualización de dependencias | ⬜ Pendiente |
| 4. Configuración del framework | ⬜ Pendiente |
| 5. Cambios en el código | ⬜ Pendiente |
| 6. Pipeline de assets | ⬜ Pendiente |
| 7. Testing | ⬜ Pendiente |
| 8. Checklist pre-merge | ⬜ Pendiente |
| 9. Deploy a producción | ⬜ Pendiente |

---

## Versiones actuales bloqueadas

| Paquete | Versión |
|---|---|
| `laravel/framework` | v12.28.1 |
| `livewire/livewire` | v3.6.4 |
| `livewire/flux` | v2.3.1 |
| `livewire/volt` | v1.7.2 |
| `filament/filament` | v3.3.37 |
| `laravel/scout` | v10.19.0 |
| `laravel/sanctum` | v4.3.1 |
| `spatie/browsershot` | v5.2.3 |
| `pestphp/pest` | v4.0.4 |
| `resend/resend-php` | v1.1.0 |
| `algolia/algoliasearch-client-php` | v4.39.0 |
| PHP | ^8.2 |

## Cambios de código confirmados (independientes del changelog de L13)

`app/Models/Material.php` usa el patrón de accessor pre-Laravel 9 (`getSizeFormattedAttribute()`,
`getTipoAttribute()`, `getNivelAttribute()`). Deprecado en L9, posiblemente eliminado en L13.
**Esta migración es requerida independientemente del resto del upgrade.**

---

## Fase 1 — Investigación

> Esta fase es obligatoria. No modificar ningún archivo antes de completarla.

- [ ] **1.1** Leer la guía oficial de actualización de Laravel 13:
  `https://laravel.com/docs/13.x/upgrade`

  Anotar cada breaking change que aplique al proyecto. Áreas clave a revisar:
  - Versión mínima de PHP requerida
  - Features deprecadas en L12 que fueron eliminadas en L13
  - Cambios en `bootstrap/app.php` (firmas de `withMiddleware` / `withExceptions`)
  - Cambios en Eloquent (casts, accessors, scopes)
  - Cambios en helpers de testing
  - Cambios en Queue/Jobs

- [ ] **1.2** Verificar compatibilidad de cada paquete con Laravel 13:

  | Paquete | URL |
  |---|---|
  | `filament/filament` | https://github.com/filamentphp/filament/releases |
  | `livewire/livewire` | https://github.com/livewire/livewire/releases |
  | `livewire/flux` | https://github.com/livewire/flux/releases |
  | `livewire/volt` | https://github.com/livewire/volt/releases |
  | `laravel/sanctum` | https://github.com/laravel/sanctum/releases |
  | `laravel/scout` | https://github.com/laravel/scout/releases |
  | `spatie/browsershot` | https://github.com/spatie/browsershot/releases |
  | `pestphp/pest` + plugins | https://github.com/pestphp/pest/releases |
  | `resend/resend-php` | https://github.com/resendlabs/resend-php/releases |

  > **Nota sobre Filament:** Verificar si existe Filament 4. Si es así, puede requerir
  > una guía de migración propia separada de este plan — presupuestar tiempo extra.

- [ ] **1.3** Verificar versión de PHP del servidor Forge:
  ```bash
  php -v
  ```
  Si el servidor corre PHP 8.2 y L13 requiere 8.3, la actualización de PHP en Forge
  debe hacerse en una ventana de mantenimiento antes del deploy.

---

## Fase 2 — Preparación del entorno local

- [ ] **2.1** Verificar PHP local:
  ```bash
  php -v
  ```
  Si es 8.2 y L13 requiere 8.3:
  ```bash
  brew install php@8.3
  php -v   # debe mostrar 8.3.x
  ```

- [ ] **2.2** Verificar Composer 2.x:
  ```bash
  composer --version
  ```

- [ ] **2.3** Crear punto de rollback:
  ```bash
  git tag pre-laravel-13-upgrade
  ```

---

## Fase 3 — Actualización de dependencias

> Actualizar constraints una a una. No correr `composer update` sin completar la Fase 1.

- [ ] **3.1** Actualizar constraint de PHP en `composer.json` (si L13 lo requiere):
  ```json
  "php": "^8.3"
  ```

- [ ] **3.2** Actualizar constraint del framework en `composer.json`:
  ```json
  "laravel/framework": "^13.0"
  ```

- [ ] **3.3** Actualizar constraints de paquetes del ecosistema en `composer.json`
  con base en la investigación de la Fase 1.2. Cambios esperados (verificar en Fase 1):
  - `laravel/sanctum` → posiblemente `^5.0`
  - `laravel/scout` → posiblemente `^11.0`
  - `filament/filament` → posiblemente `^4.0`
  - `livewire/livewire` → posiblemente `^3.7`+
  - `pestphp/pest` + plugins → posiblemente `^5.0`
  - `nunomaduro/collision` → sigue el ciclo de Laravel

- [ ] **3.4** Correr la actualización:
  ```bash
  composer update --with-all-dependencies 2>&1 | tee /tmp/composer-update.log
  ```
  Si hay conflictos, diagnosticar uno a uno:
  ```bash
  composer why-not laravel/framework 13.x-dev
  ```

- [ ] **3.5** Publicar assets actualizados:
  ```bash
  php artisan vendor:publish --tag=laravel-assets --force
  php artisan filament:upgrade
  ```

---

## Fase 4 — Configuración del framework

- [ ] **4.1** Comparar `bootstrap/app.php` con el stub de L13:
  `https://github.com/laravel/laravel/blob/13.x/bootstrap/app.php`

  Verificar firmas de `withMiddleware`, `withExceptions` y la clave `health: '/up'`.

- [ ] **4.2** Comparar archivos en `config/` con los defaults de L13:
  `https://github.com/laravel/laravel/tree/13.x/config`

  Prestar atención a: `auth.php`, `session.php`, `database.php`, `logging.php`.

- [ ] **4.3** Verificar versión de PHPUnit post-update:
  ```bash
  ./vendor/bin/phpunit --version
  ```
  Si subió de major version, actualizar `xsi:noNamespaceSchemaLocation` en `phpunit.xml`.

---

## Fase 5 — Cambios en el código de la aplicación

### 5.1 Migrar accessors del estilo antiguo en `app/Models/Material.php` [CONFIRMADO]

- [ ] **5.1.1** Agregar import al inicio del archivo (antes de `class Material`):
  ```php
  use Illuminate\Database\Eloquent\Casts\Attribute;
  ```

- [ ] **5.1.2** Reemplazar `getSizeFormattedAttribute()` (líneas 55–69):

  ```php
  // ANTES
  protected function getSizeFormattedAttribute(): ?string
  {
      if (! $this->size_bytes) {
          return null;
      }
      if ($this->size_bytes < 1024) {
          return $this->size_bytes.' B';
      }
      if ($this->size_bytes < 1048576) {
          return number_format($this->size_bytes / 1024, 1).' KB';
      }
      return number_format($this->size_bytes / 1048576, 2).' MB';
  }

  // DESPUÉS
  protected function sizeFormatted(): Attribute
  {
      return Attribute::make(
          get: function (): ?string {
              if (! $this->size_bytes) {
                  return null;
              }
              if ($this->size_bytes < 1024) {
                  return $this->size_bytes.' B';
              }
              if ($this->size_bytes < 1048576) {
                  return number_format($this->size_bytes / 1024, 1).' KB';
              }
              return number_format($this->size_bytes / 1048576, 2).' MB';
          }
      );
  }
  ```

- [ ] **5.1.3** Reemplazar `getTipoAttribute()` (líneas 71–86):

  ```php
  // ANTES
  protected function getTipoAttribute()
  {
      if ($this->type == 'html') {
          return 'Presentación HTML';
      }
      if ($this->type == 'other') {
          return 'Otros';
      }
      if ($this->type == 'pdf') {
          return 'PDF';
      }
      return ucfirst($this->type);
  }

  // DESPUÉS
  protected function tipo(): Attribute
  {
      return Attribute::make(
          get: fn (): string => match ($this->type) {
              'html'  => 'Presentación HTML',
              'other' => 'Otros',
              'pdf'   => 'PDF',
              default => ucfirst($this->type),
          }
      );
  }
  ```

- [ ] **5.1.4** Reemplazar `getNivelAttribute()` (líneas 88–101):

  ```php
  // ANTES
  protected function getNivelAttribute()
  {
      $map = [
          'colegio' => ['text-bg-warning', 'Colegio'],
          'cft' => ['text-bg-primary', 'CFT'],
          'particulares' => ['text-bg-success', 'Particulares'],
          'universidad' => ['text-bg-danger',  'Universidad'],
          'instituto' => ['text-bg-secondary', 'Instituto'],
      ];
      [$class, $label] = $map[$this->level] ?? ['text-bg-info', strtoupper($this->level)];
      return '<span class="badge '.$class.'">'.$label.'</span>';
  }

  // DESPUÉS
  protected function nivel(): Attribute
  {
      return Attribute::make(
          get: function (): string {
              $map = [
                  'colegio'      => ['text-bg-warning',  'Colegio'],
                  'cft'          => ['text-bg-primary',   'CFT'],
                  'particulares' => ['text-bg-success',   'Particulares'],
                  'universidad'  => ['text-bg-danger',    'Universidad'],
                  'instituto'    => ['text-bg-secondary', 'Instituto'],
              ];
              [$class, $label] = $map[$this->level] ?? ['text-bg-info', strtoupper($this->level)];
              return '<span class="badge '.$class.'">'.$label.'</span>';
          }
      );
  }
  ```

  > **Compatibilidad en templates:** `Attribute::make()` convierte el nombre camelCase
  > del método a snake_case automáticamente: `sizeFormatted()` → `$material->size_formatted`,
  > `tipo()` → `$material->tipo`, `nivel()` → `$material->nivel`.
  > **No se requieren cambios en Blade, Livewire ni Filament.**

### 5.2 Breaking changes adicionales de la Fase 1 [CONDICIONAL]

> Completar después de la Fase 1. Agregar un sub-paso por cada breaking change que aplique,
> con archivo afectado, cambio exacto y referencia a la sección de la guía oficial.

- [ ] **5.2.x** _(completar tras Fase 1)_

  Áreas a verificar durante la Fase 1:
  - `Route::view()` y `->where()` — usados en `routes/web.php`
  - `Paginator::useBootstrapFive()` — en `app/Providers/AppServiceProvider.php`
  - `$request->string()` y `$request->integer()` — en `MaterialController::index()`
  - `abort_unless()` — en `MaterialController`
  - `Str::slug()` — en `MaterialResource`

---

## Fase 6 — Pipeline de assets

- [ ] **6.1** Verificar si hay nueva versión de `laravel-vite-plugin` requerida para L13:
  `https://github.com/laravel/vite-plugin/releases`

  Si es necesario, actualizar el constraint en `package.json`:
  ```bash
  npm install
  ```

- [ ] **6.2** Build de producción:
  ```bash
  npm run build
  ```
  Verificar que `public/build/manifest.json` existe con la entrada de `resources/js/app.js`.

---

## Fase 7 — Testing

- [ ] **7.1** Limpiar cachés:
  ```bash
  php artisan config:clear && php artisan route:clear && php artisan view:clear && php artisan cache:clear
  ```

- [ ] **7.2** Suite completa de tests:
  ```bash
  composer test
  ```
  Todos los tests deben pasar (AboutTest, ContactFormTest, HomeTest, LayoutTest,
  MaterialShowTest, MaterialsIndexTest, MaterialsListingTest, MaterialsSearchTest, etc.)

- [ ] **7.3** Lint de código:
  ```bash
  ./vendor/bin/pint --test
  ```
  Si hay violaciones: `./vendor/bin/pint`

- [ ] **7.4** Verificación manual del panel Filament (`php artisan serve`):
  - [ ] Login en `/adminprofe` funciona
  - [ ] Lista de materiales carga
  - [ ] Crear material nuevo funciona (upload + generación de código)
  - [ ] Editar material existente funciona

- [ ] **7.5** Verificación de Browsershot (PDF):
  ```bash
  php artisan tinker
  >>> \Spatie\Browsershot\Browsershot::url('https://example.com')->html();
  ```
  Si falla con "Chromium not found", verificar path del binario (instalado por Puppeteer via npm).

---

## Fase 8 — Checklist pre-merge

- [ ] `composer test` — todos los tests en verde
- [ ] `./vendor/bin/pint --test` — sin violaciones de estilo
- [ ] `npm run build` — build limpio
- [ ] `php artisan route:list` — 8 rutas esperadas, sin errores
- [ ] `php artisan migrate --pretend` — sin migraciones inesperadas
- [ ] Panel Filament funciona (Fase 7.4 completada)
- [ ] Generación de PDF funciona (Fase 7.5 completada)
- [ ] Los tres accessors de `Material.php` migrados (pasos 5.1.2–5.1.4 completados)

---

## Fase 9 — Deploy a producción (Laravel Forge)

- [ ] **9.1** Actualizar PHP en Forge si L13 lo requiere:
  1. Forge → servidor → PHP → Instalar PHP 8.3
  2. Actualizar versión PHP del sitio
  3. Actualizar versión PHP CLI de los scripts de Forge
  4. Verificar que el sitio carga antes de continuar

- [ ] **9.2** Merge y push:
  ```bash
  git checkout main
  git merge feature/upgrade-laravel-13
  git push origin main
  ```

- [ ] **9.3** Verificar que el script de deploy en Forge incluye:
  ```bash
  composer install --no-dev --optimize-autoloader
  php artisan migrate --force
  php artisan config:cache
  php artisan route:cache
  php artisan view:cache
  php artisan filament:upgrade
  ```

- [ ] **9.4** Smoke test post-deploy:
  - [ ] `https://profenicolas.cl` carga
  - [ ] `https://profenicolas.cl/materiales` carga y búsqueda funciona
  - [ ] `https://profenicolas.cl/adminprofe` carga
  - [ ] Página de detalle de un material carga
  - [ ] PDF alumno funciona: `/materiales/{code}/pdf/alumno`
  - [ ] Health check: `GET /up` devuelve HTTP 200

---

## Plan de rollback

Si el upgrade genera fallas críticas en producción:

1. Revertir en Forge al release anterior (Forge mantiene los últimos N deployments).
2. Si PHP fue actualizado, revertir la versión PHP del sitio a 8.2 en Forge.
3. El tag `pre-laravel-13-upgrade` marca el commit exacto de rollback:
   ```bash
   git checkout pre-laravel-13-upgrade
   ```

---

## Mapa de archivos

| Archivo | Fase | Tipo de cambio |
|---|---|---|
| `composer.json` | 3 | Constraints de PHP + paquetes |
| `app/Models/Material.php` | 5.1 | Migración de accessors (confirmado) |
| `bootstrap/app.php` | 4.1 | Verificar / actualizar si es necesario |
| `phpunit.xml` | 4.3 | URL del schema si PHPUnit subió de major |
| `config/*.php` | 4.2 | Nuevas keys según investigación |
| `package.json` | 6.1 | Bump de `laravel-vite-plugin` si es necesario |
| `app/Providers/AppServiceProvider.php` | 5.2 | Verificar que `Paginator::useBootstrapFive()` existe |
