# Sistema de Menú Dinámico

## Descripción

El menú del panel lateral izquierdo ahora se genera dinámicamente desde el archivo de configuración `config/creator-menu.php`, en lugar de estar hardcoded en el layout.

## Archivos Involucrados

1. **`config/creator-menu.php`** - Configuración del menú
2. **`resources/views/layouts/creator.blade.php`** - Layout principal
3. **`resources/views/components/sidebar-menu-item.blade.php`** - Componente para renderizar items del menú

## Estructura de la Configuración

### Items del Menú Principal

Cada item del menú puede ser:

#### 1. Item Simple (enlace directo)
```php
[
    'title' => 'Inicio',
    'route' => 'creator.dashboard',
    'icon_svg' => 'M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z',
    'active_routes' => ['creator.dashboard'],
    'requires_website' => false,
]
```

#### 2. Dropdown (con sub-items)
```php
[
    'title' => 'Diseño y Contenido',
    'id' => 'design',  // ID único para el toggle
    'icon_svg' => 'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4...',
    'active_routes' => ['creator.templates.*', 'creator.pages.*', ...],
    'requires_website' => true,
    'items' => [  // Sub-items
        [
            'title' => 'Plantillas',
            'route' => 'creator.templates.index',
            'icon_svg' => 'M4 5a1 1 0 011-1h14a1...',
            'active_routes' => ['creator.templates.*'],
        ],
        // ... más sub-items
    ],
]
```

### Propiedades de los Items

- **`title`**: Texto que se muestra en el menú
- **`route`**: Nombre de la ruta (Laravel route name)
- **`icon_svg`**: Path SVG para el icono (usado con stroke)
- **`icon_custom`**: HTML completo del SVG (opcional, sobrescribe icon_svg)
- **`active_routes`**: Array de patrones de rutas para determinar si está activo
- **`requires_website`**: Boolean, si requiere un sitio web seleccionado
- **`target`**: Atributo target del enlace (ej: '_blank')
- **`id`**: ID único para dropdowns
- **`items`**: Array de sub-items (solo para dropdowns)
- **`params_session`**: Boolean, si usa session('selected_website_id') para parámetros

### Menú Dropdown del Usuario

```php
'user_dropdown' => [
    [
        'title' => 'Ver Mis Sitios Web',
        'route' => 'creator.select-website',
        'icon_svg' => 'M9 12h6m-6 4h6m2 5H7...',
    ],
    [
        'type' => 'divider',  // Separador
    ],
    [
        'title' => 'Cerrar Sesión',
        'route' => 'logout',
        'icon_svg' => 'M17 16l4-4m0 0l-4-4m4 4H7...',
        'method' => 'POST',  // Para formularios
    ],
]
```

## Componente `sidebar-menu-item`

Este componente renderiza automáticamente:

1. **Items simples**: Enlaces directos con icono y título
2. **Dropdowns**: Botón con toggle y sub-menú colapsable
3. **Validación**: Oculta items que requieren sitio web cuando no hay uno seleccionado
4. **Estados activos**: Marca el item activo basándose en `active_routes`

### Uso

```blade
@foreach(config('creator-menu.items') as $menuItem)
    <x-sidebar-menu-item :item="$menuItem" />
@endforeach
```

## Ventajas del Sistema Dinámico

1. ✅ **Centralizado**: Toda la configuración del menú en un solo archivo
2. ✅ **Fácil de mantener**: Agregar/modificar items sin tocar el layout
3. ✅ **Reutilizable**: El componente puede usarse en diferentes lugares
4. ✅ **Consistente**: Todos los items usan la misma lógica
5. ✅ **Flexible**: Soporta múltiples tipos de items y configuraciones

## Cómo Agregar un Nuevo Item

### Item Simple

```php
[
    'title' => 'Mi Nueva Sección',
    'route' => 'creator.nueva-seccion.index',
    'icon_svg' => 'M...',  // Path SVG
    'active_routes' => ['creator.nueva-seccion.*'],
    'requires_website' => true,
],
```

### Dropdown con Sub-items

```php
[
    'title' => 'Mi Dropdown',
    'id' => 'mi-dropdown',
    'icon_svg' => 'M...',
    'active_routes' => ['creator.item1.*', 'creator.item2.*'],
    'requires_website' => true,
    'items' => [
        [
            'title' => 'Sub-item 1',
            'route' => 'creator.item1.index',
            'icon_svg' => 'M...',
            'active_routes' => ['creator.item1.*'],
        ],
        [
            'title' => 'Sub-item 2',
            'route' => 'creator.item2.index',
            'icon_svg' => 'M...',
            'active_routes' => ['creator.item2.*'],
        ],
    ],
],
```

## Troubleshooting

### El menú no se muestra

- Verifica que `config/creator-menu.php` existe y es válido
- Ejecuta `php artisan config:clear` para limpiar el cache de configuración

### Un item no aparece

- Verifica la propiedad `requires_website`
- Asegúrate de que hay un sitio web seleccionado en sesión si es necesario

### El item activo no se marca correctamente

- Revisa los patrones en `active_routes`
- Usa `*` para wildcards: `'creator.blog.*'` coincide con todas las rutas que empiecen con `creator.blog.`

### Los iconos no se muestran

- Verifica que `icon_svg` contenga un path SVG válido
- Si usas `icon_custom`, asegúrate de que el HTML esté completo con la etiqueta `<svg>`


