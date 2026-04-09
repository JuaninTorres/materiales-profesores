# Especificación: Campo `tema` en el modelo `Material`

## Contexto

Se agregó una subdivisión lógica dentro de las Unidades llamada **"Temas"**. Los materiales (presentaciones y guías) ahora pueden pertenecer a un tema dentro de una unidad, lo que permite agruparlos en el dashboard local y en el sitio.

El campo `tema` es **opcional** — los materiales sin tema siguen funcionando exactamente igual.

**Ejemplos de valores:**
- `"Tema 1: Fracciones"`
- `"Tema 2: Decimales"`
- `""` (vacío — sin agrupación)

---

## Cambios requeridos en Laravel

### 1. Migración — agregar columna `tema`

```php
php artisan make:migration add_tema_to_materiales_table --table=materiales
```

```php
public function up(): void
{
    Schema::table('materiales', function (Blueprint $table) {
        $table->string('tema')->nullable()->after('unit');
    });
}

public function down(): void
{
    Schema::table('materiales', function (Blueprint $table) {
        $table->dropColumn('tema');
    });
}
```

---

### 2. Modelo `Material` — agregar `tema` a `$fillable`

```php
protected $fillable = [
    'title',
    'description',
    'subject',
    'level',
    'course',
    'year',
    'semester',
    'unit',
    'tema',       // ← agregar
    'type',
    'tags',
    // ... resto de campos existentes
];
```

---

### 3. Validación — aceptar `tema` como campo opcional

En el Form Request correspondiente (ej: `StoreMaterialRequest`, `UpdateMaterialRequest`):

```php
public function rules(): array
{
    return [
        // ... reglas existentes ...
        'tema' => ['nullable', 'string', 'max:255'],
    ];
}
```

---

### 4. Controlador — guardar `tema` al crear y actualizar

Si el controlador usa `$request->validated()` o `$request->only(...)`, agregar `tema` al listado de campos aceptados:

```php
// Si usa validated():
$material = Material::create($request->validated());
// → funciona automáticamente si 'tema' está en las reglas de validación

// Si usa only() o fill() manual:
$material->fill([
    // ... campos existentes ...
    'tema' => $request->input('tema'),
]);
```

---

### 5. Recurso API — incluir `tema` en la respuesta

En el API Resource (ej: `MaterialResource`):

```php
public function toArray(Request $request): array
{
    return [
        'id'          => $this->id,
        'title'       => $this->title,
        'description' => $this->description,
        'subject'     => $this->subject,
        'level'       => $this->level,
        'course'      => $this->course,
        'year'        => $this->year,
        'semester'    => $this->semester,
        'unit'        => $this->unit,
        'tema'        => $this->tema,   // ← agregar
        'type'        => $this->type,
        'tags'        => $this->tags,
        // ... resto de campos existentes ...
    ];
}
```

---

## Cómo llega el campo desde el cliente

El MCP server local envía `tema` como parte del `FormData` en cada publicación/actualización:

```
POST /api/materiales
Content-Type: multipart/form-data

title=...
unit=Unidad 1: Números y Operaciones
tema=Tema 1: Fracciones          ← nuevo campo
type=html
tags[]=fracciones
archivo_html=<file>
```

Cuando el material no tiene tema, el campo llega como cadena vacía (`""`). La validación `nullable` en Laravel lo convierte a `null` si se desea, o se puede guardar como `""` — ambas son válidas.

---

## Resumen de cambios

| Archivo | Cambio |
|---|---|
| `database/migrations/xxxx_add_tema_to_materiales_table.php` | Nueva migración con columna `tema` nullable |
| `app/Models/Material.php` | Agregar `'tema'` a `$fillable` |
| `app/Http/Requests/StoreMaterialRequest.php` | Agregar regla `'tema' => ['nullable', 'string', 'max:255']` |
| `app/Http/Requests/UpdateMaterialRequest.php` | Ídem |
| `app/Http/Resources/MaterialResource.php` | Incluir `'tema' => $this->tema` en el array de respuesta |
