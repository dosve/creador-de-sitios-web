# Ícono de Usuario en el Header

## Descripción

Se ha agregado un **ícono de usuario** en el header de todas las plantillas de tienda, justo al lado del carrito de compras. Este ícono cambia dinámicamente según el estado de autenticación del usuario.

## Ubicación

El ícono de usuario se encuentra en el header de las siguientes plantillas:

- ✅ **Tienda Virtual** (`templates/tienda-virtual/header.blade.php`)
- ✅ **Tienda Minimalista** (`templates/tienda-minimalista/header.blade.php`)
- ✅ **Moda Boutique** (`templates/moda-boutique/header.blade.php`)

**Posición:** Entre el buscador (si está habilitado) y el carrito de compras.

## Estados del Ícono

### 1. Usuario No Autenticado (Invitado)

**Apariencia:**
- Ícono simple de usuario
- Sin nombre visible
- Sin indicador de estado

**Funcionalidad:**
- Al hacer clic, abre un modal de login
- Permite al usuario iniciar sesión

**Visual:**
```
[🔍] [👤] [🛒]
```

### 2. Usuario Autenticado

**Apariencia:**
- Ícono de usuario con nombre (en pantallas grandes)
- Muestra el primer nombre del usuario
- Tiene un menú desplegable

**Funcionalidad:**
- Al hacer clic, muestra un dropdown con opciones:
  - **Mis Órdenes**: Ver historial de compras
  - **Cerrar Sesión**: Finalizar sesión

**Visual (desktop):**
```
[🔍] [👤 Juan ▼] [🛒]
```

**Visual (mobile):**
```
[🔍] [👤] [🛒]
```

## Flujo de Uso

### Para Usuario Invitado

```
1. Usuario ve el ícono de usuario [👤]
   ↓
2. Hace clic en el ícono
   ↓
3. Se abre modal de login
   ↓
4. Ingresa email y contraseña
   ↓
5. Sistema valida contra AdminNegocios
   ↓
6. Si es correcto:
   - Cierra el modal
   - Actualiza el ícono mostrando el nombre
   - Recarga la página
```

### Para Usuario Autenticado

```
1. Usuario ve su nombre en el header [👤 Juan]
   ↓
2. Hace clic en el ícono/nombre
   ↓
3. Se despliega menú con opciones:
   - Mis Órdenes
   - Cerrar Sesión
   ↓
4. Usuario selecciona una opción
```

## Componentes del Sistema

### 1. HTML en Headers

El ícono se encuentra en cada header con esta estructura:

```blade
{{-- Usuario / Login --}}
<div class="relative" id="user-menu-container">
    {{-- Menú de invitado (no autenticado) --}}
    <div id="guest-menu" class="hidden">
        <button id="login-button">
            {{-- Ícono de usuario --}}
        </button>
    </div>
    
    {{-- Menú de usuario autenticado --}}
    <div id="user-menu" class="hidden">
        <button id="user-menu-button">
            {{-- Ícono + nombre --}}
        </button>
        
        {{-- Dropdown --}}
        <div id="user-dropdown" class="hidden">
            <a href="/mi-tienda/my-orders">Mis Órdenes</a>
            <button id="logout-button">Cerrar Sesión</button>
        </div>
    </div>
</div>
```

### 2. JavaScript Automático

El archivo `components/user-auth-script.blade.php` se encarga de:

- ✅ Verificar automáticamente si el usuario está autenticado
- ✅ Mostrar el menú correcto (invitado o autenticado)
- ✅ Manejar el modal de login
- ✅ Procesar el login contra AdminNegocios
- ✅ Manejar el logout
- ✅ Actualizar la UI dinámicamente

**Este script se carga automáticamente en todas las páginas públicas.**

### 3. Modal de Login

El modal se crea dinámicamente cuando el usuario hace clic en el ícono. Incluye:

- Campo de email
- Campo de contraseña
- Botón de "Iniciar Sesión"
- Link para registrarse (futuro)
- Mensajes de error

## Estilos

El ícono usa las clases de Tailwind CSS y se adapta al estilo de cada plantilla:

### Tienda Virtual
- Color: Gris oscuro (#374151)
- Hover: Gris más oscuro
- Padding: 8px

### Tienda Minimalista
- Color: Gris 700
- Hover: Negro
- Transiciones suaves

### Moda Boutique
- Color: Gris 700
- Hover: Negro
- Stroke width: 1.5px (más delgado)

## API Utilizada

El sistema de autenticación usa estos endpoints:

### GET `/customer/check`
Verifica si hay una sesión activa.

**Response:**
```json
{
  "success": true,
  "authenticated": true,
  "customer": {
    "id": 123,
    "email": "cliente@ejemplo.com",
    "name": "Juan Pérez"
  }
}
```

### POST `/customer/login`
Inicia sesión con credenciales de AdminNegocios.

**Request:**
```json
{
  "email": "cliente@ejemplo.com",
  "password": "password123",
  "website_slug": "mi-tienda"
}
```

**Response exitoso:**
```json
{
  "success": true,
  "message": "Login exitoso",
  "customer": {
    "id": 1,
    "admin_negocios_id": 123,
    "email": "cliente@ejemplo.com",
    "name": "Juan Pérez",
    "total_orders": 5,
    "total_spent": 150000
  },
  "token": "eyJ0eXAiOiJKV1QiLCJhbGc..."
}
```

### POST `/customer/logout`
Cierra la sesión del usuario.

**Response:**
```json
{
  "success": true,
  "message": "Sesión cerrada exitosamente"
}
```

## Ejemplo de Personalización

Si quieres personalizar el ícono de usuario en tu plantilla:

### 1. Cambiar el Ícono

Reemplaza el SVG en el header:

```html
<!-- Ícono actual -->
<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
</svg>

<!-- Alternativa: ícono de círculo -->
<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"/>
</svg>
```

### 2. Cambiar Colores del Dropdown

En el archivo del header, modifica las clases del dropdown:

```html
<!-- Dropdown actual (fondo blanco) -->
<div id="user-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 py-1">

<!-- Dropdown oscuro -->
<div id="user-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-gray-900 rounded-lg shadow-lg border border-gray-800 py-1">
    <a href="/my-orders" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-800">
        Mis Órdenes
    </a>
</div>
```

### 3. Agregar Más Opciones al Menú

En el archivo del header, añade más links en el dropdown:

```html
<div id="user-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 py-1">
    <!-- Nuevo: Perfil -->
    <a href="/{{ $website->slug }}/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
        Mi Perfil
    </a>
    
    <!-- Nuevo: Favoritos -->
    <a href="/{{ $website->slug }}/favorites" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
        Favoritos
    </a>
    
    <!-- Existente: Órdenes -->
    <a href="/{{ $website->slug }}/my-orders" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
        Mis Órdenes
    </a>
    
    <!-- Divider -->
    <div class="border-t border-gray-100 my-1"></div>
    
    <!-- Existente: Logout -->
    <button id="logout-button" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-red-50">
        Cerrar Sesión
    </button>
</div>
```

## Beneficios

### Para los Usuarios:
- ✅ Fácil acceso al login
- ✅ Visual claro de su estado de autenticación
- ✅ Acceso rápido a sus órdenes
- ✅ Logout con un solo clic

### Para el Negocio:
- ✅ Fomenta el registro de usuarios
- ✅ Mejora la experiencia de usuario
- ✅ Facilita compras recurrentes
- ✅ Permite seguimiento de clientes

### Técnicamente:
- ✅ Totalmente automático
- ✅ Sin configuración adicional requerida
- ✅ Compatible con todas las plantillas
- ✅ Responsive (funciona en mobile)

## Troubleshooting

### El ícono no aparece

**Posible causa:** El script de autenticación no se está cargando.

**Solución:**
1. Verificar que existe `components/user-auth-script.blade.php`
2. Verificar que está incluido en `components/global-scripts.blade.php`
3. Verificar que el header incluye `<x-global-scripts :website="$website" />`

### El modal no se abre

**Posible causa:** Conflicto con otro JavaScript.

**Solución:**
1. Abrir la consola del navegador (F12)
2. Buscar errores de JavaScript
3. Verificar que no hay otro elemento con ID `login-modal`

### El login no funciona

**Posible causa:** La tienda no tiene configurada la API de AdminNegocios.

**Solución:**
1. Ir al panel de administración
2. Configurar `api_base_url` de la tienda
3. Verificar que AdminNegocios está accesible

### El nombre del usuario no se muestra

**Posible causa:** El elemento `#user-name` tiene la clase `hidden` en mobile.

**Solución:**
Esto es normal. En mobile, solo se muestra el ícono por espacio. El nombre aparece en pantallas medianas o grandes (md:inline).

## Agregar a Nuevas Plantillas

Si creas una nueva plantilla y quieres agregar el ícono de usuario:

1. **Copiar el bloque HTML** de cualquiera de los headers existentes
2. **Ajustar los estilos** según el diseño de tu plantilla
3. **Verificar** que el header incluye `<x-global-scripts>`
4. **Probar** el login y logout

## Código Completo de Referencia

Ver archivos de implementación:
- Headers: `resources/views/templates/{plantilla}/header.blade.php`
- Script: `resources/views/components/user-auth-script.blade.php`
- Scripts globales: `resources/views/components/global-scripts.blade.php`
- Controlador: `app/Http/Controllers/CustomerAuthController.php`
- Rutas: `routes/web.php` (sección de `/customer/*`)

---

**¡El sistema está listo para usar!** 🎉

Los usuarios ahora pueden hacer login fácilmente desde cualquier tienda y ver sus órdenes con un solo clic.

