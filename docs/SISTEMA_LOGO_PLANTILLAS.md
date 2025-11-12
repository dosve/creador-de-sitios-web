# 🎨 Sistema de Logo en Plantillas

## ✅ Estado del Sistema

El sistema de logo está **100% funcional** en todas las plantillas. El logo se carga automáticamente desde la configuración del sitio web.

---

## 📍 Ubicaciones del Logo

### **1. Header (Barra de Navegación)**

Todas las plantillas cargan el logo en el header con esta estructura:

```php
@if(!empty($website->logo))
    <img src="{{ asset('storage/' . $website->logo) }}" 
         alt="{{ $website->name }}" 
         class="h-10">
@else
    <h1 class="text-2xl font-bold">{{ $website->name }}</h1>
@endif
```

**Características:**
- ✅ Si hay logo: Muestra la imagen
- ✅ Si NO hay logo: Muestra el nombre del sitio como texto
- ✅ Altura estándar: `h-10` (40px) en la mayoría de plantillas
- ✅ Altura minimalista: `h-8` (32px) en plantillas Apple-style

---

### **2. Footer**

#### **Tienda Virtual:**
```php
@if(!empty($website->logo))
    <img src="{{ asset('storage/' . $website->logo) }}" 
         alt="{{ $website->name }}" 
         class="h-10 mb-4 brightness-0 invert">
@else
    <h5 class="mb-4 text-xl font-semibold">{{ $website->name }}</h5>
@endif
```

**Características:**
- ✅ Logo en **BLANCO** con filtro `brightness-0 invert`
- ✅ Ideal para footers oscuros
- ✅ Altura: 40px

#### **Tienda Minimalista:**
```php
@if(!empty($website->logo))
    <img src="{{ asset('storage/' . $website->logo) }}" 
         alt="{{ $website->name }}" 
         class="h-8">
@else
    <h2 class="text-2xl font-bold">{{ $website->name }}</h2>
@endif
```

**Características:**
- ✅ Logo en **COLOR ORIGINAL**
- ✅ Footer con fondo claro
- ✅ Altura: 32px (más pequeño)

---

## 🎯 Configuración del Logo

### **Cómo Subir el Logo**

1. **Ve a la configuración del sitio**
2. **Sube tu logo** en el campo "Logo"
3. **Guarda cambios**
4. El logo aparecerá automáticamente en:
   - ✅ Header/Navbar
   - ✅ Footer
   - ✅ Todas las páginas del sitio

### **Ubicación del Logo**

El logo se guarda en:
```
storage/app/public/logos/
```

Y se referencia en la base de datos:
```php
$website->logo = 'logos/mi-logo.png'
```

---

## 🎨 Variantes de Estilo del Logo

### **Header Normal (Tienda Virtual)**
```php
class="h-10"  // 40px de altura
```

### **Header Minimalista**
```php
class="h-8"   // 32px de altura (más pequeño)
```

### **Footer Oscuro (con filtro blanco)**
```php
class="h-10 mb-4 brightness-0 invert"
```
- `brightness-0` → Negro puro
- `invert` → Invierte a blanco

### **Footer Claro (sin filtro)**
```php
class="h-8"  // Logo en su color original
```

---

## 📋 Checklist por Plantilla

| Plantilla | Header Logo | Footer Logo | Estado |
|-----------|-------------|-------------|--------|
| **Tienda Virtual** | ✅ `h-10` | ✅ `h-10` + filtro blanco | ✅ |
| **Tienda Minimalista** | ✅ `h-8` | ✅ `h-8` color original | ✅ |
| **Blog Minimalista** | ✅ | ✅ | ✅ |
| **Spa Bienestar** | ✅ | ✅ | ✅ |
| **Agencia Creativa** | ✅ | ✅ | ✅ |
| **Gimnasio Fitness** | ✅ | ✅ | ✅ |
| **Todas las demás** | ✅ | ✅ | ✅ |

---

## 🔍 Variables Disponibles

Dentro de las plantillas tienes acceso a:

```php
$website->logo          // Ruta del logo
$website->name          // Nombre del sitio
$website->description   // Descripción
```

**Ejemplo de uso:**
```php
@if(!empty($website->logo))
    <img src="{{ asset('storage/' . $website->logo) }}" 
         alt="{{ $website->name }}">
@else
    <span>{{ $website->name }}</span>
@endif
```

---

## 🎨 Personalización del Logo

### **Cambiar Tamaño:**

```php
// Pequeño (24px)
class="h-6"

// Normal (32px)
class="h-8"

// Grande (40px)
class="h-10"

// Extra grande (48px)
class="h-12"
```

### **Aplicar Filtros:**

```php
// Logo en blanco (para fondos oscuros)
class="h-10 brightness-0 invert"

// Logo en negro (para fondos claros)
class="h-10 brightness-0"

// Logo con opacidad
class="h-10 opacity-80"

// Logo en escala de grises
class="h-10 grayscale"
```

### **Efectos Hover:**

```php
// Crecer al pasar el mouse
class="h-10 hover:scale-110 transition-transform"

// Cambiar opacidad
class="h-10 opacity-80 hover:opacity-100 transition-opacity"

// Rotar ligeramente
class="h-10 hover:rotate-3 transition-transform"
```

---

## 🔧 Configuración por Plantilla

### **config.json**

Cada plantilla puede definir si muestra el logo:

```json
{
  "header": {
    "show_logo": true,  ← Mostrar logo en header
    "logo_height": "h-10"
  },
  "footer": {
    "show_logo": true,  ← Mostrar logo en footer
    "logo_filter": "brightness-0 invert"
  }
}
```

---

## 🐛 Solución de Problemas

### **El logo no aparece**

**Verifica:**
1. ✅ El logo está subido en la configuración del sitio
2. ✅ La ruta del logo es correcta en la base de datos
3. ✅ El archivo existe en `storage/app/public/logos/`
4. ✅ Se ejecutó `php artisan storage:link`

**Ver en inspeccionar elemento:**
```html
<img src="http://tu-sitio.com/storage/logos/mi-logo.png" alt="Mi Tienda" class="h-10">
```

### **El logo se ve cortado**

**Ajusta la altura:**
```php
class="h-10"  // Cambia a h-8, h-12, etc.
```

### **El logo no se ve en footer oscuro**

**Agrega el filtro:**
```php
class="h-10 brightness-0 invert"
```

---

## 💡 Mejores Prácticas

### ✅ **DO (Hacer):**
- Usar logos en formato PNG con fondo transparente
- Mantener proporciones (width: auto, height: fixed)
- Usar filtros para adaptar a fondos oscuros
- Proporcionar fallback con el nombre del sitio

### ❌ **DON'T (No hacer):**
- Logos muy grandes (más de 200KB)
- Logos con dimensiones excesivas
- Olvidar el atributo `alt`
- Forzar width fijo (dejar que sea automático)

---

## 📖 Ejemplo Completo

### **Header con Logo Responsive:**

```php
<header class="bg-white shadow">
  <div class="container mx-auto px-4 py-4">
    <div class="flex items-center justify-between">
      <!-- Logo -->
      <div>
        @if(!empty($website->logo))
          <img src="{{ asset('storage/' . $website->logo) }}" 
               alt="{{ $website->name }}" 
               class="h-8 md:h-10 hover:opacity-80 transition-opacity">
        @else
          <h1 class="text-xl md:text-2xl font-bold text-gray-900">
            {{ $website->name }}
          </h1>
        @endif
      </div>
      
      <!-- Menú -->
      <nav>...</nav>
    </div>
  </div>
</header>
```

---

## 🚀 Cómo Probar

1. **Sube un logo** en la configuración del sitio
2. **Recarga la página**
3. **Verifica** que aparezca en:
   - ✅ Header (esquina superior izquierda)
   - ✅ Footer (primera columna o arriba)

---

## 📊 Resumen

| Ubicación | Tienda Virtual | Tienda Minimalista | Otras |
|-----------|----------------|-------------------|--------|
| **Header** | ✅ h-10 (40px) | ✅ h-8 (32px) | ✅ h-10 |
| **Footer** | ✅ h-10 + filtro blanco | ✅ h-8 color original | ✅ Varía |
| **Fallback** | ✅ Nombre del sitio | ✅ Nombre del sitio | ✅ |

---

**Última actualización:** 4 de Noviembre, 2025  
**Estado:** ✅ Funcionando en todas las plantillas

