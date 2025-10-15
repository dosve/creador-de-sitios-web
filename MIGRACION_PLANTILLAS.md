# Migración a Sistema de Plantillas Basado en Archivos

## ✅ Qué se Logró

Migramos de un sistema de plantillas en **base de datos** a uno basado en **archivos físicos** (estilo WordPress).

### Ventajas del Nuevo Sistema:

- ✅ **Más rápido** - No queries a la DB
- ✅ **Versionamiento con Git** - Control total
- ✅ **Portable** - Fácil compartir entre proyectos
- ✅ **Menús dinámicos** - Se cargan de la DB automáticamente
- ✅ **Configuración flexible** - Colores, fuentes, layout por plantilla
- ✅ **Templates por tipo** - Home, páginas, blog separados
- ✅ **Header/Footer modulares** - Como WordPress

## 📁 Estructura Nueva

```
resources/templates/
  ├── partials/               ← Componentes reutilizables
  │   ├── menu-header.blade.php
  │   ├── menu-footer.blade.php
  │   ├── cart-script.blade.php
  │   └── products-script.blade.php
  │
  ├── tienda-virtual/         ← Plantilla de e-commerce
  │   ├── config.json
  │   ├── header.blade.php
  │   ├── footer.blade.php
  │   ├── template.blade.php
  │   ├── template-page.blade.php
  │   └── template-blog.blade.php
  │
  └── plantilla-basica/       ← Plantilla básica
      ├── config.json
      ├── header.blade.php
      ├── footer.blade.php
      └── template.blade.php
```

## 🔧 Cambios en el Código

### Archivos Nuevos:

1. **Servicio:**
   - `app/Services/TemplateService.php` - Lee plantillas desde archivos

2. **Plantillas:**
   - `resources/templates/tienda-virtual/` (completa)
   - `resources/templates/plantilla-basica/` (completa)
   - `resources/templates/partials/` (menús y scripts)

3. **Migración:**
   - `database/migrations/2025_10_13_000000_change_template_id_to_string.php`

### Archivos Modificados:

1. **Controladores:**
   - `app/Http/Controllers/TemplateController.php` - Usa TemplateService
   - `app/Http/Controllers/WebsiteController.php` - Usa TemplateService

2. **Modelos:**
   - `app/Models/Website.php` - Eliminó relación template()

3. **Vistas:**
   - `resources/views/creator/templates/index.blade.php` - Arrays
   - `resources/views/creator/templates/show.blade.php` - Arrays
   - `resources/views/creator/websites/create.blade.php` - template_slug

4. **Rutas:**
   - `routes/web.php` - Usa slugs en lugar de IDs

## 🚀 Pasos para Producción

### 1. Subir Archivos

Subir todos los archivos listados arriba al servidor.

### 2. Ejecutar Migración

```bash
php artisan migrate
```

Esto cambiará `template_id` de foreign key a string.

### 3. Actualizar Datos Existentes (Si hay websites con template_id)

```bash
php artisan tinker
```

```php
// Convertir IDs existentes a slugs
$websites = \App\Models\Website::whereNotNull('template_id')->get();
foreach ($websites as $website) {
    // Si template_id es 1, cambiar a "tienda-virtual"
    // Si es 2, cambiar a "plantilla-basica", etc.
    if ($website->template_id == 1) {
        $website->update(['template_id' => 'tienda-virtual']);
    }
}
```

### 4. Limpiar (Opcional)

Los seeders `TemplateSeeder` y `DefaultTemplateSeeder` ya **NO son necesarios**.
Puedes eliminarlos o dejarlos por compatibilidad.

## 📖 Cómo Funciona Ahora

### Antes (Base de Datos):
1. Admin ejecutaba seeder
2. Plantillas se guardaban en tabla `templates`
3. Websites tenían `template_id` como foreign key
4. Al aplicar plantilla, se copiaba HTML a la página

### Ahora (Archivos):
1. **Admin crea carpeta** en `resources/templates/`
2. **Sistema lee automáticamente** las plantillas
3. **Websites guardan el slug** en `template_id` (string)
4. **Al renderizar**, se carga plantilla con variables dinámicas

## 🎨 Opciones de Configuración

Cada plantilla puede tener:

### Colors:
- primary, secondary, accent, background, text

### Fonts:
- heading, body

### Header:
- sticky, show_logo, show_search, show_cart

### Footer:
- background, columns, show_social, show_copyright

## 📝 Crear Nueva Plantilla

Ver `resources/templates/README.md` para guía completa.

## ⚠️ Notas Importantes

- ✅ Los menús se cargan dinámicamente de la DB
- ✅ `template_id` ahora es string (slug), no foreign key
- ✅ No se necesitan seeders de plantillas
- ✅ Compatible con el sistema antiguo (backward compatibility)
- ✅ Las páginas que ya tienen `html_content` funcionan igual

## 🔄 Rollback (Si es necesario)

Si necesitas volver al sistema anterior:

```bash
php artisan migrate:rollback
```

Y restaurar los archivos desde Git.

