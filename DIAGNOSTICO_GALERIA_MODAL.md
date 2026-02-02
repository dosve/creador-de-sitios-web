# 🔧 DIAGNÓSTICO: Modal de Galería No Se Abre

**Fecha:** 31 de Enero de 2026  
**Problema:** Al hacer clic en el botón de seleccionar imagen, no se abre el modal de la galería

---

## 📋 CAMBIOS REALIZADOS

### 1. ✅ Corregido: background-image.js
**Línea:** 65-135

**Problema Original:**
```javascript
// ❌ INCORRECTO
am.onClick(onClickHandler);  // Este método NO existe en GrapesJS
modal.setTitle('Seleccionar Imagen desde Galería')
  .setContent(am.render())
  .open();
```

**Solución Aplicada:**
```javascript
// ✅ CORRECTO
am.off('select', onClickHandler);  // Limpiar listeners previos
am.on('select', onClickHandler);   // Registrar nuevo listener
am.open({ types: ['image'] });     // Abrir modal directamente
```

**Por qué funciona:**
- `am.on('select')` es la forma correcta de escuchar eventos en GrapesJS
- `am.open()` abre el modal internamente sin necesidad de manipularlo manualmente
- Se limpian listeners previos para evitar duplicados

---

## 🔍 VERIFICACIÓN DEL PROBLEMA

### Paso 1: Abre el editor de una página

### Paso 2: Abre la consola del navegador (F12)

### Paso 3: Ejecuta este comando de diagnóstico:
```javascript
window.debugGallery()
```

Deberías ver:
```
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
DEBUG: GALERÍA DE IMÁGENES
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

📊 ESTADÍSTICAS:
  Llamadas API realizadas: 0
  
🔧 ASSET MANAGER:
  - assetCount: [número de imágenes]
  - hasOpen: true
  - hasOn: true
  - hasOff: true
```

---

## 🧪 PRUEBA MANUAL DE LA GALERÍA

### Test 1: Verificar que la API funciona
```javascript
fetch('/creator/media/api/list')
  .then(r => r.json())
  .then(d => {
    console.log('API Response:', d);
    console.log('Imágenes encontradas:', d.files.length);
  })
  .catch(e => console.error('Error:', e));
```

**Esperado:**
```
{
  success: true,
  files: [
    { id: 1, filename: "imagen1.jpg", url: "/storage/...", alt_text: "..." },
    { id: 2, filename: "imagen2.png", url: "/storage/...", alt_text: "..." },
    ...
  ]
}
```

### Test 2: Abrir la galería manualmente
```javascript
// Seleccionar un componente background-image primero
const component = window.editor.getSelected();
console.log('Componente seleccionado:', component);
console.log('Tipo:', component.get('type'));

// Luego ejecutar esto
const am = window.editor.AssetManager;
fetch('/creator/media/api/list')
  .then(r => r.json())
  .then(d => {
    am.getAll().reset();
    d.files.forEach(f => {
      am.add({
        type: 'image',
        src: f.url,
        name: f.filename,
        alt: f.alt_text || f.filename
      });
    });
    am.open({ types: ['image'] });
  });
```

**Esperado:** Se abre un modal mostrando las imágenes disponibles

---

## ⚠️ POSIBLES PROBLEMAS Y SOLUCIONES

### Problema A: "Error 403 - No website selected"
**Síntoma:** API retorna error 403

**Causa:** No hay website seleccionado en la sesión

**Solución:**
1. Asegúrate de estar editando una página dentro de un website
2. Verifica que `session('selected_website_id')` esté disponible
3. Intenta recargar la página

---

### Problema B: "AssetManager no tiene método open()"
**Síntoma:** Error "am.open is not a function"

**Causa:** Versión de GrapesJS incompatible o no está cargado

**Solución:**
```javascript
// Verificar versión y disponibilidad
console.log('GrapesJS Version:', grapesjs.version);
console.log('AssetManager methods:', Object.getOwnPropertyNames(Object.getPrototypeOf(window.editor.AssetManager)));
```

---

### Problema C: "Modal no se ve aunque se abre"
**Síntoma:** El modal se abre pero es invisible o está fuera de pantalla

**Causa:** Problema de CSS o z-index

**Solución:**
```javascript
// Forzar visibilidad del modal
const modal = window.editor.Modal;
modal.show();  // Asegurar que está visible
```

---

### Problema D: "Las imágenes no se cargan en el modal"
**Síntoma:** Modal abierto pero vacío

**Causa:** Imágenes no se agregan correctamente al AssetManager

**Solución:**
```javascript
const am = window.editor.AssetManager;
console.log('Assets antes:', am.getAll().length);

am.add({
  type: 'image',
  src: 'https://placehold.co/300x300',
  name: 'test',
  alt: 'test image'
});

console.log('Assets después:', am.getAll().length);
```

---

## 📊 ESTADO DEL CÓDIGO

| Archivo | Línea | Estado | Cambio |
|---------|-------|--------|--------|
| `background-image.js` | 65-135 | ✅ Corregido | Reescrito comando de botón |
| `container.js` | 169-230 | ✅ Correcto | Ya usaba `am.on('select')` |
| `debug-gallery.js` | Nuevo | ✅ Creado | Script de diagnóstico |
| `editor.blade.php` | 1690 | ✅ Actualizado | Incluye debug-gallery.js |

---

## 🚀 PRÓXIMOS PASOS

1. **Verificar en el navegador:**
   - Abre una página en el editor
   - Abre la consola (F12)
   - Ejecuta `window.debugGallery()`
   - Haz clic en "📁 Seleccionar Imagen de Fondo"
   - Verifica que el modal se abra

2. **Si aún no funciona:**
   - Ejecuta los tests manuales arriba
   - Comparte los errores en la consola
   - Revisa `/creator/media/api/list` directamente en el navegador

3. **Para validar la solución:**
   - El modal debe abrirse
   - Las imágenes deben mostrarse
   - Al seleccionar una, debe actualizarse el componente

---

## 💾 ARCHIVO DE LOGGING

Se agregó un script de debugging que registra automáticamente:
- Todas las llamadas a `/creator/media/api/list`
- El estado del AssetManager
- Errores de fetch
- Eventos de selección

**Acceder al log:**
```javascript
window.__galleryDebug
```

---

## 📝 NOTA TÉCNICA

El problema principal era el uso de `am.onClick()` que no existe en GrapesJS v0.21.x.

GrapesJS usa un sistema de eventos:
- ✅ Correcto: `am.on('select', handler)`
- ❌ Incorrecto: `am.onClick(handler)`

La API correcta es:
```javascript
am.on('select', (asset) => {
  console.log('Seleccionado:', asset);
});
am.open({ types: ['image'] });  // Abre automáticamente el modal
```

---

**Documento actualizado:** 2026-01-31
