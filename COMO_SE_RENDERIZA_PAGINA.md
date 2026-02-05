# 📊 Análisis Completo: Cómo se Renderiza la Página Real

## 🔄 Flujo de Renderización

### **Paso 1: Usuario Visita la Página Pública**
```
URL: http://127.0.0.1:8000/eme10/prueba
    ↓
Ruta Web: GET /{website:slug}/{page:slug}
    ↓
Controlador: WebsiteController::showPagePublic()
    ↓
Busca:
  - Website por slug "eme10"
  - Page por slug "prueba"
```

---

## 🎯 ¿Qué Viene del Creador y Qué Se Agrega?

### **DEL CREADOR (lo que tú guardas en el editor):**

Cuando presionas "Guardar" en el editor, se envía al servidor:

```javascript
// En public/js/editor-config.js, línea ~5544
const requestData = {
  title: pageTitle,                 // ✅ Desde campo #page-title
  slug: pageSlug,                   // ✅ Desde campo #page-slug
  html_content: htmlContent,        // ✅ HTML generado por GrapesJS
  css_content: cssContent,          // ✅ CSS generado por GrapesJS
  grapesjs_data: JSON.stringify(editor.getProjectData())  // ✅ Datos del editor
};
```

Se **guarda en la BD** en la tabla `pages`:
- `html_content` → HTML de tu contenido
- `css_content` → CSS personalizado
- `grapesjs_data` → Datos completos del editor (para recargar después)

---

### **LO QUE SE AGREGA EN LA PÁGINA REAL:**

La vista [`resources/views/public/blank.blade.php`](resources/views/public/blank.blade.php) **agrega automáticamente**:

#### **1️⃣ Estilos Globales (siempre presentes)**
```html
<!-- Línea ~65: Tailwind CSS del CDN -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Línea ~82: Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Línea ~93-98: Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter...Poppins...">
```

#### **2️⃣ Tu CSS Personalizado (SOLO si está guardado)**
```blade
@if($currentPage->css_content)
  <style>
    {!! $currentPage->css_content !!}  <!-- 👈 TU CSS del editor -->
  </style>
@endif
```

#### **3️⃣ CSS Global del Sitio Web (si existe)**
```blade
@if($website->global_css)
  <style>
    {!! $website->global_css !!}  <!-- 👈 CSS GLOBAL de todo el sitio -->
  </style>
@endif
```

#### **4️⃣ Barra de Administración (si estás logueado)**
```blade
@auth
  @if(auth()->user()->role === 'admin' || ...)
    <x-admin-bar :website="$website" :page="$currentPage" />
  @endif
@endauth
```

#### **5️⃣ Tu Contenido HTML (EXACTAMENTE lo que guardaste)**
```blade
<div id="page-content">
  {!! $contentToShow !!}  <!-- 👈 TU HTML del editor -->
</div>
```

---

## 📋 Checklist: ¿De Dónde Viene Cada Cosa?

| Elemento | Viene De | Guardado En | Editable En |
|----------|----------|-------------|-------------|
| **HTML del contenido** | ✅ Editor | `pages.html_content` | Editor |
| **CSS personalizado** | ✅ Editor | `pages.css_content` | Editor |
| **Tailwind CDN** | ❌ Template | CDN remoto | NO |
| **Font Awesome** | ❌ Template | CDN remoto | NO |
| **Google Fonts** | ❌ Template | CDN remoto | NO |
| **Barra admin** | ❌ Template | Componente Blade | NO |
| **Meta tags (title, description)** | ✅ Editor | `pages.title`, `pages.meta_*` | Editor |
| **Favicon** | ❌ Sitio web | `websites.favicon` | Configuración del sitio |
| **CSS global del sitio** | ❌ Sitio web | `websites.global_css` | NO (propósito futuro) |

---

## 🔍 Diferencias: Editor vs Página Real

### **Posibles Causas de Diferencias:**

#### **1. Ancho de Viewport**
- **Editor**: Canvas fijo de GrapesJS (~1200px o menos)
- **Página Real**: Ancho real del navegador
- **Solución**: Redimensiona el navegador al mismo tamaño que el editor

#### **2. CSS No Se Guardó**
- **Síntoma**: Vuelto a abrir en el editor = tiene estilos, pero en página real = sin estilos
- **Causa**: `pages.css_content` está vacío en la BD
- **Verificación**: En XAMPP, abre phpMyAdmin → Tabla `pages` → Busca tu página → Ve el campo `css_content`
- **Solución**: Ve al editor y guarda nuevamente

#### **3. HTML Limpiado al Guardar**
La función `cleanHTMLBeforeSave()` en el editor elimina:
- Clases de GrapesJS como `gjs-*`
- Espacios en blanco mal formados
- Esto NORMALMENTE no afecta, pero puede causar problemas si tenías algo especial

#### **4. Clases Tailwind No Aplicadas**
- **Síntoma**: Los estilos de Tailwind funcionan en editor pero no en página
- **Causa**: Tailwind necesita tiempo para compilar o el CDN no carga
- **Verificación**: Abre F12 → Consola → Busca errores
- **Solución**: Recarga la página (Ctrl+F5 para limpiar caché)

#### **5. Media Queries Responsive No Funcionan**
- **Síntoma**: El diseño en móvil se ve diferente
- **Causa**: Ancho real del viewport diferente
- **Verificación**: Abre DevTools (F12) → Modo responsive (Ctrl+Shift+M)
- **Solución**: Compara con el editor al mismo tamaño

---

## 🔧 Cómo Depurar

### **Opción 1: Ver Qué Se Guardó**

```php
// En la base de datos (phpMyAdmin):
SELECT 
  id, title, 
  LENGTH(html_content) as html_chars, 
  LENGTH(css_content) as css_chars,
  is_published
FROM pages 
WHERE id = 33;
```

**Resultado esperado:**
- `html_chars` > 0 (debe haber contenido HTML)
- `css_chars` > 0 (si usaste CSS personalizado) o = 0 (si solo Tailwind)
- `is_published` = 1 (para que sea visible)

### **Opción 2: Inspeccionar Página Real**

1. Abre la página en navegador
2. Presiona **F12** (DevTools)
3. Pestaña **"Elementos"** (o "Inspector")
4. Busca: `<style>` tags en el `<head>`
5. Verifica que contenga:
   - Tu CSS personalizado (si existe)
   - NO debe estar vacío

### **Opción 3: Comparar HTML Generado**

**En el Editor:**
- Click derecho → "Ver código fuente" del canvas

**En Página Real:**
- Click derecho → "Ver código fuente" (Ctrl+U)

**Compara:**
- ¿El HTML es idéntico?
- ¿Las clases CSS están igual?

---

## 📌 Resumen Rápido

**La página real está compuesta de:**

```
┌─────────────────────────────────────────────┐
│       PÁGINA REAL RENDERIZADA               │
├─────────────────────────────────────────────┤
│ <head>                                      │
│  ├─ Meta tags (title, description)          │
│  ├─ Tailwind CDN  ❌ NO es del editor      │
│  ├─ Font Awesome  ❌ NO es del editor      │
│  ├─ Google Fonts  ❌ NO es del editor      │
│  │                                          │
│  ├─ TU CSS DEL EDITOR  ✅ desde BD         │
│  └─ CSS Global del Sitio (si existe)       │
├─────────────────────────────────────────────┤
│ <body>                                      │
│  ├─ Barra Admin (si estás logueado)        │
│  ├─ Navbar de preview                      │
│  │                                          │
│  ├─ TU HTML DEL EDITOR  ✅ desde BD        │
│  └─ Footer/Scripts                         │
├─────────────────────────────────────────────┤
```

**Clave:**
- ✅ Lo que GUARDES en el editor → aparece en la página real
- ❌ Lo que NO GUARDES → aparece SOLO como estructura (Tailwind, etc)

Si hay diferencias, probablemente es porque:
1. No guardaste los cambios
2. El CSS o HTML está vacío en la BD
3. El navegador tiene caché antiguo (Ctrl+Shift+Del)
4. Hay diferencia en el ancho de viewport

---

## 🧪 Test Rápido

1. **En el Editor**: Agrega un `<h1>PRUEBA DE RENDERIZADO</h1>` con estilo rojo
2. **Guarda** (botón Guardar)
3. **En página real**: ¿Aparece el "PRUEBA DE RENDERIZADO" en rojo?
   - **Sí** → Todo funciona correctamente
   - **No** → El CSS/HTML no se guardó

