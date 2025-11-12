# 🎨 Sistema de Estilos Dinámicos para Productos y Carrito

## 📋 Descripción

Este sistema permite que el **listado de productos**, **buscador** y **carrito de compras** se adapten automáticamente a los estilos de cada plantilla.

---

## ✨ Características

✅ **Detección automática** de la plantilla activa  
✅ **Estilos personalizados** por plantilla  
✅ **Colores dinámicos** desde la configuración  
✅ **Consistencia visual** con el resto del sitio  
✅ **Fácil extensión** para nuevas plantillas  

---

## 🏗️ Arquitectura

### 1. **Flujo de Datos**

```
Plantilla (template.blade.php)
    ↓ pasa $customization
global-scripts.blade.php
    ↓ extrae colores y templateSlug
products-script.blade.php + cart-script.blade.php
    ↓ aplican estilos según plantilla
Productos y Carrito renderizados con estilos correctos ✅
```

### 2. **Componentes Actualizados**

#### **global-scripts.blade.php**
- Recibe `$website` y `$customization`
- Extrae `templateSlug` y `colors`
- Pasa datos a productos y carrito

#### **products-script.blade.php**
- Define estilos por plantilla en `getTemplateStyles()`
- Aplica estilos a:
  - Tarjetas de productos
  - Buscador
  - Botones "Agregar al Carrito"
  - Precios

#### **cart-script.blade.php**
- Usa colores de la plantilla para:
  - Botón de checkout
  - Total del carrito
  - Colores de acento

---

## 🎨 Cómo Agregar Estilos para una Nueva Plantilla

### Paso 1: Abrir el archivo de productos

```bash
resources/views/components/products-script.blade.php
```

### Paso 2: Ubicar la función `getTemplateStyles()`

Busca esta sección (línea ~34):

```javascript
function getTemplateStyles() {
    const styles = {
        // Aquí se definen los estilos por plantilla
```

### Paso 3: Agregar tu plantilla

Copia esta estructura y reemplaza los valores:

```javascript
// Nombre de tu plantilla
'tu-plantilla-slug': {
    // Estilos de la tarjeta del producto
    card: 'p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-lg transition-shadow duration-300',
    
    // Título del producto
    title: 'mb-2 text-lg font-semibold text-gray-900',
    
    // Descripción
    description: 'mb-4 text-sm text-gray-600 line-clamp-2',
    
    // Estilo del precio (sin color)
    price: 'text-lg font-bold',
    
    // Color del precio (código hex)
    priceColor: templateColors.primary, // o un color específico como '#10b981'
    
    // Botón "Agregar al Carrito"
    button: 'px-4 py-2 text-sm font-medium text-white rounded-md transition-all duration-200',
    
    // Color de fondo del botón
    buttonBg: templateColors.primary, // o color específico
    
    // Color del botón en hover
    buttonHover: templateColors.secondary, // o color específico
    
    // Botón del buscador
    searchButton: 'inline-flex items-center px-4 py-2 text-sm font-medium text-white border border-transparent rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2',
    
    // Input del buscador
    searchInput: 'block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:border-gray-400'
},
```

### Paso 4: Personalizar los estilos

#### **Ejemplos por tipo de plantilla:**

##### 🏪 **Tienda Moderna (tienda-virtual)**
```javascript
'tienda-virtual': {
    card: 'p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-lg transition-shadow duration-300',
    title: 'mb-2 text-lg font-semibold text-gray-900',
    description: 'mb-4 text-sm text-gray-600 line-clamp-2',
    price: 'text-lg font-bold',
    priceColor: '#10b981', // Verde
    button: 'px-4 py-2 text-sm font-medium text-white rounded-md',
    buttonBg: '#10b981',
    buttonHover: '#059669'
}
```

##### 🍎 **Minimalista (tienda-minimalista)**
```javascript
'tienda-minimalista': {
    card: 'p-8 bg-white border border-gray-100 rounded-2xl hover:shadow-xl transition-all duration-500',
    title: 'mb-3 text-xl font-semibold text-gray-900',
    description: 'mb-6 text-sm text-gray-500 line-clamp-2',
    price: 'text-2xl font-bold',
    priceColor: '#000000', // Negro
    button: 'px-6 py-3 text-sm font-semibold text-white rounded-full',
    buttonBg: '#000000',
    buttonHover: '#1a1a1a',
    searchInput: 'block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-full...'
}
```

##### 💪 **Gimnasio/Fitness**
```javascript
'gimnasio-fitness': {
    card: 'p-5 bg-gradient-to-br from-white to-red-50 border-2 border-red-200 rounded-xl shadow-md hover:shadow-2xl transition-all duration-300',
    title: 'mb-2 text-xl font-bold text-gray-900 uppercase',
    description: 'mb-4 text-sm text-gray-700',
    price: 'text-2xl font-black',
    priceColor: '#ef4444', // Rojo intenso
    button: 'px-6 py-3 text-sm font-bold text-white rounded-lg uppercase tracking-wide',
    buttonBg: '#ef4444',
    buttonHover: '#dc2626'
}
```

##### 🎨 **Creativa/Portfolio**
```javascript
'agencia-creativa': {
    card: 'p-6 bg-white rounded-2xl shadow-lg hover:scale-105 transition-transform duration-300',
    title: 'mb-2 text-lg font-bold text-gray-900',
    description: 'mb-4 text-sm text-gray-600 italic',
    price: 'text-xl font-bold',
    priceColor: '#7c3aed', // Púrpura
    button: 'px-5 py-2 text-sm font-semibold text-white rounded-full',
    buttonBg: '#7c3aed',
    buttonHover: '#6d28d9'
}
```

---

## 🎯 Variables Disponibles

Puedes usar estas variables en tus estilos:

```javascript
templateColors = {
    primary: '#2563eb',      // Color principal de la plantilla
    secondary: '#7c3aed',    // Color secundario
    accent: '#10b981',       // Color de acento
    background: '#f9fafb',   // Color de fondo
    text: '#111827'          // Color de texto
}
```

**Uso:**
```javascript
priceColor: templateColors.primary,  // Usa el color principal
buttonBg: '#custom-color',           // O usa un color específico
```

---

## 📦 Clases de Tailwind Disponibles

Puedes usar cualquier clase de Tailwind CSS. Ejemplos comunes:

### **Espaciado:**
- `p-4, p-6, p-8` - Padding
- `m-4, mb-2, mt-4` - Margins
- `space-x-2, space-y-4` - Espaciado entre elementos

### **Colores:**
- `bg-white, bg-gray-50` - Fondos
- `text-gray-900, text-red-600` - Texto
- `border-gray-200` - Bordes

### **Bordes y Sombras:**
- `rounded-lg, rounded-2xl, rounded-full` - Bordes redondeados
- `shadow-sm, shadow-lg, shadow-xl` - Sombras
- `border, border-2` - Grosor del borde

### **Transiciones:**
- `transition-all, transition-shadow` - Tipo de transición
- `duration-300, duration-500` - Duración
- `hover:shadow-lg` - Estados hover

### **Tipografía:**
- `text-sm, text-lg, text-xl, text-2xl` - Tamaño
- `font-semibold, font-bold, font-black` - Peso
- `uppercase, capitalize` - Transformaciones

---

## 🔍 Elementos que se Personalizan

### **1. Tarjetas de Productos**
- ✅ Borde y sombra
- ✅ Padding interno
- ✅ Efectos hover
- ✅ Bordes redondeados

### **2. Botones**
- ✅ Color de fondo
- ✅ Color en hover
- ✅ Tamaño y padding
- ✅ Forma (cuadrado/redondeado/circular)

### **3. Precios**
- ✅ Color
- ✅ Tamaño de fuente
- ✅ Peso de fuente

### **4. Buscador**
- ✅ Estilos de input
- ✅ Botón de búsqueda
- ✅ Selectores de filtros

### **5. Carrito**
- ✅ Botón de checkout
- ✅ Color del total
- ✅ Colores de acento

---

## 🧪 Probar tus Estilos

### 1. **Guarda los cambios** en `products-script.blade.php`

### 2. **Ve a tu sitio** con la plantilla aplicada

### 3. **Agrega un bloque de productos** desde el editor

### 4. **Vista previa** - Los productos deberían verse con tus estilos

### 5. **Prueba el carrito** - Los botones y colores deben coincidir

---

## 🐛 Solución de Problemas

### ❌ Los estilos no se aplican

**Verifica:**
1. El slug de la plantilla es correcto
2. La plantilla está pasando `$customization` a `global-scripts`
3. Los colores están definidos en `config.json` de la plantilla

**Ver en consola del navegador:**
```javascript
// Deberías ver estos logs:
🎨 Plantilla activa: tu-plantilla-slug
✅ Estilos cargados para plantilla: tu-plantilla-slug
```

### ❌ Los colores están en blanco/negro

**Causa:** No se está pasando `$customization` correctamente

**Solución:** Verifica que el template incluya:
```php
<x-global-scripts :website="$website" :customization="$customization ?? []" />
```

### ❌ Los botones no tienen hover

**Causa:** Los eventos `onmouseover` necesitan variables en scope

**Solución:** Los estilos inline usan template literals con variables de JavaScript

---

## 📝 Ejemplo Completo

Aquí un ejemplo completo para una plantilla "Tech Store":

```javascript
'tech-store': {
    // Tarjeta con borde azul neón y sombra moderna
    card: 'p-6 bg-gradient-to-br from-white to-blue-50 border-2 border-blue-300 rounded-xl shadow-lg hover:shadow-2xl hover:border-blue-500 transition-all duration-300',
    
    // Título bold y grande
    title: 'mb-3 text-xl font-bold text-gray-900 tracking-tight',
    
    // Descripción con color más claro
    description: 'mb-4 text-sm text-gray-500 line-clamp-3',
    
    // Precio destacado
    price: 'text-2xl font-black tracking-tight',
    priceColor: '#2563eb', // Azul tech
    
    // Botón moderno con gradiente
    button: 'px-6 py-3 text-sm font-bold text-white rounded-lg shadow-md hover:shadow-lg transition-all duration-200',
    buttonBg: '#2563eb',
    buttonHover: '#1d4ed8',
    
    // Buscador tech
    searchButton: 'inline-flex items-center px-5 py-2.5 text-sm font-bold text-white rounded-lg shadow-md',
    searchInput: 'block w-full pl-10 pr-3 py-3 border-2 border-blue-200 rounded-lg bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all'
}
```

---

## 🚀 Mejores Prácticas

### ✅ DO (Hacer)
- Mantener consistencia con el diseño general de la plantilla
- Usar colores del `templateColors` cuando sea posible
- Probar en móvil y desktop
- Incluir transiciones suaves
- Documentar colores personalizados

### ❌ DON'T (No hacer)
- Hardcodear demasiados colores (usa `templateColors`)
- Olvidar los estados hover
- Usar transiciones muy largas (>500ms)
- Ignorar la accesibilidad (contraste de colores)
- Copiar estilos sin adaptarlos

---

## 📚 Recursos

- **Tailwind CSS:** https://tailwindcss.com/docs
- **Paletas de colores:** https://coolors.co
- **Generador de gradientes:** https://cssgradient.io
- **Sombras:** https://shadows.brumm.af

---

## 🔄 Changelog

### v1.0.0 (2025-01-XX)
- ✅ Sistema de estilos dinámicos implementado
- ✅ Soporte para tienda-virtual y tienda-minimalista
- ✅ Estilos por defecto para otras plantillas
- ✅ Carrito con colores dinámicos
- ✅ Buscador con estilos personalizables

---

## 📞 Soporte

¿Preguntas o problemas?
- Revisa la consola del navegador para logs de debug
- Verifica que todos los archivos estén actualizados
- Consulta el código de plantillas existentes como ejemplo

---

**Última actualización:** {{ date('d/m/Y') }}  
**Versión:** 1.0.0

