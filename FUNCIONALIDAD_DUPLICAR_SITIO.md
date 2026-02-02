# Funcionalidad: Duplicar Sitio Web

## 📋 Descripción

Se ha implementado una nueva funcionalidad que permite a los usuarios duplicar un sitio web completamente, incluyendo todas sus páginas, menús, categorías, etiquetas, posts del blog y configuración.

## ✨ Características

### ¿Qué se duplica?
- ✅ Todas las páginas y su contenido HTML
- ✅ Menús y estructura de navegación
- ✅ Categorías y etiquetas
- ✅ Posts del blog con sus relaciones
- ✅ Componentes compartidos
- ✅ Configuración general del sitio
- ✅ Ajustes de SEO
- ✅ Configuración de pagos
- ✅ Redes sociales y otra metadata

### ¿Qué NO se duplica?
- ❌ Dominios personalizados
- ❌ Archivos de media (se mantienen referencias pero no se copian físicamente)
- ❌ Estado de publicación (el nuevo sitio inicia como borrador)
- ❌ Historial de cambios

## 🚀 Cómo usar

### Opción 1: Desde la vista del sitio web
1. Ve a tu sitio web en el dashboard
2. Haz clic en el botón **"Duplicar"** (lado derecho del encabezado)
3. Llena el formulario con:
   - **Nombre del nuevo sitio** (requerido) - Se sugiere automáticamente "{nombre original} (Copia)"
   - **Slug** (opcional) - Si no lo especificas, se genera automáticamente

### Opción 2: URL directa
```
/creator/websites/{website_id}/duplicate
```

## 📁 Estructura de cambios

### Archivos creados:
1. **`app/Services/DuplicateWebsiteService.php`**
   - Servicio con toda la lógica de duplicación
   - Maneja transacciones de BD
   - Genera slugs únicos automáticamente
   - Mapea relaciones entre entidades

2. **`resources/views/creator/websites/duplicate.blade.php`**
   - Formulario de duplicación
   - Validación en cliente (JavaScript)
   - Muestra resumen de qué se va a duplicar
   - Interfaz amigable y clara

### Archivos modificados:
1. **`app/Http/Controllers/WebsiteController.php`**
   - Agregado: `use App\Services\DuplicateWebsiteService;`
   - Agregado parámetro al constructor: `DuplicateWebsiteService $duplicateWebsiteService`
   - Nuevo método: `showDuplicate()` - muestra el formulario
   - Nuevo método: `duplicate()` - procesa la duplicación

2. **`routes/web.php`**
   - Nueva ruta GET: `websites/{website}/duplicate` → `showDuplicate()`
   - Nueva ruta POST: `websites/{website}/duplicate` → `duplicate()`

3. **`resources/views/creator/websites/show.blade.php`**
   - Agregado botón "Duplicar" en el header del sitio

## 🔐 Seguridad

- Validación de autorización: Solo el dueño del sitio o admin puede duplicar
- Validación de entrada: Nombre y slug son validados
- Slug único: Sistema automático para evitar conflictos
- Transacciones de BD: Si algo falla, se revierte todo

## 💾 Validaciones

| Campo | Regla |
|-------|-------|
| name | Requerido, máximo 255 caracteres |
| slug | Opcional, único en la BD, máximo 255 caracteres |

## 🎯 Notas importantes

1. **El nuevo sitio inicia como borrador** - Debes publicarlo manualmente cuando esté listo
2. **Slug automático** - Se genera desde el nombre si no lo especificas (p.ej., "Mi Sitio Web" → "mi-sitio-web")
3. **Sin duplicación de archivos** - Los archivos de media se copian en referencia, no en contenido físico
4. **Copia exacta** - El contenido HTML se copia tal cual, sin modificaciones

## 🧪 Testing

### Casos a probar:
1. ✅ Duplicar sitio con todas las secciones
2. ✅ Duplicar sitio sin slug (generar automáticamente)
3. ✅ Intentar usar slug duplicado
4. ✅ Verificar que el nuevo sitio existe en la lista
5. ✅ Verificar que todas las páginas se copiaron
6. ✅ Verificar que los menús se copiaron

### SQL para limpiar (desarrollo):
```sql
-- Ver sitios duplicados
SELECT id, name, slug, user_id, created_at 
FROM websites 
WHERE name LIKE '% (Copia)%' 
ORDER BY created_at DESC;

-- Eliminar sitios de prueba
DELETE FROM websites WHERE id = 123;
```

## 📝 Logs y debugging

El sistema usa transacciones de BD, así que si hay un error:
- Se revierte automáticamente
- El usuario ve un mensaje de error amigable
- Puedes revisar los logs en `storage/logs/laravel.log`

## 🔄 Flujo completo

```
Usuario hace clic "Duplicar"
        ↓
showDuplicate() - Muestra formulario
        ↓
Usuario llena y envía formulario
        ↓
duplicate() - Valida datos
        ↓
DuplicateWebsiteService::duplicate()
        ↓
Inicia transacción BD
        ↓
Crea nuevo Website
        ↓
Copia Categories
        ↓
Copia Tags
        ↓
Copia Pages
        ↓
Copia BlogPosts y relaciones
        ↓
Copia Menus e Items
        ↓
Copia SharedComponents
        ↓
Commit transacción
        ↓
Redirige con mensaje de éxito
```

## ❓ Preguntas frecuentes

**¿Puedo editar el sitio durante la duplicación?**
No, el proceso es rápido (transacción de BD) y atomático.

**¿Se copian los dominios personalizados?**
No, debes configurarlos manualmente en el nuevo sitio.

**¿Puedo duplicar un sitio duplicado?**
Sí, sin límite. Cada copia es independiente.

**¿Se copia el historial de versiones?**
No, el nuevo sitio comienza fresco.

## 📞 Soporte

Si tienes problemas:
1. Revisa que tengas permisos de propietario
2. Intenta con un nombre simple (sin caracteres especiales)
3. Revisa el log en `storage/logs/laravel.log`
4. Contacta al administrador
