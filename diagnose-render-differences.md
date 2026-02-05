# 🔍 Guía de Diagnóstico: Diferencias entre Editor y Página Real

## Causas Comunes

### 1. **Ancho de Viewport Diferentes**
- **En el Editor**: El canvas de GrapesJS tiene un ancho específico (probablemente 1200px o menos)
- **En la Página Real**: Se visualiza en la resolución real del navegador
- **Solución**: Redimensiona el navegador al mismo ancho que el editor para comparar

### 2. **CSS Tailwind no Cargado**
- **Síntoma**: Los estilos de Tailwind (colores, espacios, flexbox) no aparecen
- **Causa**: El template carga Tailwind desde CDN, pero el editor puede no
- **Verificación**: Abre el Inspector de Elementos (F12) → Pestaña "Elementos" → Busca `<script src="https://cdn.tailwindcss.com">`

### 3. **Clases Personalizadas No Se Guardan**
- **Síntoma**: Clases custom (tipo `bg-yellow-300`, `flex`, etc.) aparecen en editor pero no en página real
- **Causa**: La función `cleanHTMLBeforeSave()` puede estar eliminando clases
- **Verificación**: Abre la base de datos → Tabla `pages` → Columna `html_content` → Busca las clases que faltan

### 4. **CSS Personalizado No Se Inyecta**
- **Síntoma**: Los estilos especiales desaparecen en la página real
- **Causa**: El CSS en `css_content` no se está inyectando en el `<style>` tag
- **Verificación**: Abre Inspector → Tab "Elementos" → Busca `<style>` tags → Debería contener el contenido de `css_content`

### 5. **Resolución Responsive Incorrecta**
- **Síntoma**: Diferentes diseños en móvil/tablet/desktop
- **Causa**: Las clases Tailwind responsive (md:, lg:, etc.) pueden interpretarse diferente
- **Verificación**: Redimensiona el navegador y compara con editor

---

## Pasos de Diagnóstico

### Paso 1: Inspeccionar la Base de Datos
```bash
# Abre phpMyAdmin o tu cliente SQL favorito
# Busca la tabla "pages" y encuentra tu página
# Verifica:
# - html_content: ¿Tiene el HTML correcto?
# - css_content: ¿Tiene los estilos?
# - grapesjs_data: ¿Tiene datos validos?
```

### Paso 2: Inspeccionar HTML en la Página Real
1. Abre la página en el navegador
2. Click derecho → **Inspeccionar Elemento** (o F12)
3. En la pestaña "Elementos", expande el `<head>`
4. Busca todos los `<style>` tags
5. Verifica que contengan:
   - Los estilos de Tailwind (desde CDN)
   - El CSS personalizado de `css_content`

### Paso 3: Comparar Editor vs Página Real
| Elemento | Editor | Página Real | ¿Coincide? |
|----------|--------|-----------|-----------|
| Tamaño de fuente | | | ☐ |
| Colores de fondo | | | ☐ |
| Espaciado (padding/margin) | | | ☐ |
| Ancho del contenedor | | | ☐ |
| Responsive en móvil | | | ☐ |

### Paso 4: Ver Código Fuente
1. Abre la página real
2. Click derecho → **Ver código fuente** (o Ctrl+U)
3. Busca la línea `<main>` - ahí debe estar tu contenido HTML

---

## Soluciones Rápidas

### Si falta CSS Tailwind:
Verifica que el template tenga:
```html
<script src="https://cdn.tailwindcss.com"></script>
```

### Si falta CSS personalizado:
1. Ve a la base de datos y revisa el campo `css_content`
2. Si está vacío, vuelve al editor y guarda nuevamente
3. Asegúrate que en el editor haya CSS en el panel de estilos

### Si hay diferencias de layout:
1. Redimensiona el navegador al mismo ancho que el editor
2. Si el problema persiste, el HTML puede tener etiquetas con clases rotas
3. Edita el HTML en el editor para limpiar las clases

---

## URLs de Referencia

- **Página Real**: [tu-dominio.com/eme10/prueba](http://127.0.0.1:8000/eme10/prueba)
- **Editor**: [127.0.0.1:8000/creator/pages/33/editor](http://127.0.0.1:8000/creator/pages/33/editor)

---

## ¿Todavía hay problemas?

Si después de estos pasos aún hay diferencias, necesitamos:
1. Hacer un screenshot del editor
2. Hacer un screenshot de la página real (con el mismo ancho de ventana)
3. Inspeccionar el HTML guardado en la base de datos
4. Verificar los logs del servidor (en `storage/logs/`)

