# 👁️ Sistema de Vista Previa de Páginas

## 📋 Descripción

Sistema completo de vista previa que permite a los usuarios ver exactamente cómo se verán las páginas antes de importarlas, con renderizado visual de todos los bloques de contenido.

## ✨ Características

### ✅ **Vista Previa Completa**
- **Renderizado visual** de todos los bloques de contenido
- **Información detallada** de la página (título, slug, meta tags, etc.)
- **Lista de bloques** con descripción de cada uno
- **Simulación real** de cómo se verá la página

### ✅ **Tipos de Bloques Soportados**
- **Hero** - Encabezados principales con CTA
- **Page Header** - Encabezados de página interna
- **Features** - Características con iconos
- **Product Grid** - Grid de productos con filtros
- **Contact Form** - Formularios de contacto
- **Contact Info** - Información de contacto
- **Default** - Bloque genérico para tipos no específicos

### ✅ **Interfaz Intuitiva**
- **Botones de vista previa** en cada página disponible
- **Ventana emergente** para vista previa
- **Botón de importación** directa desde la vista previa
- **Información completa** de la página

## 🚀 Cómo Usar

### **1. Acceder a Vista Previa**
```
Creator → Páginas → "🎨 Importar por Categoría" → Seleccionar página → "👁️ Vista Previa"
```

### **2. Ver Información de la Página**
- **Título y slug** de la página
- **Meta título y descripción** para SEO
- **Estado** (página de inicio o no)
- **Lista de bloques** con descripción

### **3. Previsualizar Contenido**
- **Renderizado visual** de todos los bloques
- **Simulación real** del diseño
- **Contenido de ejemplo** para cada tipo de bloque

### **4. Importar Directamente**
- **Botón de importación** en la vista previa
- **Confirmación** antes de importar
- **Redirección** automática después de importar

## 🎨 Tipos de Bloques Renderizados

### **Hero Block**
```html
- Fondo degradado atractivo
- Título principal grande
- Subtítulo opcional
- Botones de llamada a la acción
```

### **Page Header Block**
```html
- Encabezado centrado
- Título de página
- Subtítulo opcional
- Descripción de la página
```

### **Features Block**
```html
- Grid de características
- Iconos circulares
- Títulos y descripciones
- Diseño responsive
```

### **Product Grid Block**
```html
- Grid de productos de ejemplo
- Imágenes placeholder
- Precios y botones
- Información de filtros
```

### **Contact Form Block**
```html
- Formulario completo
- Campos dinámicos
- Validación visual
- Botón de envío
```

### **Contact Info Block**
```html
- Información de contacto
- Iconos representativos
- Datos organizados
- Diseño en grid
```

## 🔧 Implementación Técnica

### **Archivos Creados:**
```
resources/views/creator/pages/
├── preview.blade.php                    # Vista principal de previsualización
└── preview-blocks/
    ├── hero.blade.php                   # Bloque hero
    ├── page_header.blade.php            # Encabezado de página
    ├── features.blade.php               # Características
    ├── product_grid.blade.php           # Grid de productos
    ├── contact_form.blade.php           # Formulario de contacto
    ├── contact_info.blade.php           # Información de contacto
    └── default.blade.php                # Bloque genérico
```

### **Rutas Agregadas:**
```php
// Vista previa de páginas
Route::get('pages/preview/{website}/{pageSlug}', [UniversalPageImportController::class, 'previewPage']);
Route::get('pages/preview/{website}/{pageSlug}/{templateSlug}', [UniversalPageImportController::class, 'previewPage']);
```

### **Métodos del Controlador:**
```php
// Vista previa de página específica
public function previewPage(Website $website, string $pageSlug, string $templateSlug = null)

// Obtener datos de vista previa (AJAX)
public function getPreviewData(string $pageSlug, string $templateSlug = null): JsonResponse
```

## 🎯 Ventajas del Sistema

### ✅ **Para Usuarios**
- **Vista previa real** antes de importar
- **Información completa** de cada página
- **Importación directa** desde la vista previa
- **Interfaz intuitiva** y fácil de usar

### ✅ **Para Desarrolladores**
- **Sistema modular** de bloques
- **Fácil agregar** nuevos tipos de bloques
- **Reutilización** de componentes
- **Mantenimiento** simplificado

## 📱 Responsive Design

- **Vista previa responsive** que se adapta a diferentes tamaños
- **Simulación real** del comportamiento en móviles
- **Contenido optimizado** para todos los dispositivos

## 🔄 Flujo de Trabajo

1. **Usuario** selecciona páginas para importar
2. **Usuario** hace clic en "👁️ Vista Previa"
3. **Sistema** abre ventana con vista previa completa
4. **Usuario** revisa contenido y estructura
5. **Usuario** decide importar o cancelar
6. **Sistema** importa página si se confirma

## 🎉 Resultado Final

Los usuarios ahora pueden:
- **Ver exactamente** cómo se verán las páginas
- **Revisar contenido** antes de importar
- **Tomar decisiones informadas** sobre qué importar
- **Ahorrar tiempo** evitando importaciones innecesarias

¡El sistema de vista previa está completamente funcional y listo para usar! 🚀
