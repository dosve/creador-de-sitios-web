# 🔍 FLUJO VISUAL - Cómo Funciona el Modal de Galería

**Versión con Logging Mejorado**  
**31 de Enero de 2026**

---

## 📺 LO QUE VERÁS EN LA CONSOLA (Paso a Paso)

### Paso 1: Haces clic en "Seleccionar Imagen de Fondo"

```
[GALERÍA #2] Llamada API a: /creator/media/api/list
  ↳ Imágenes cargadas: 5
```

**Qué pasó:**
- Se llamó a la API
- Se encontraron 5 imágenes en tu galería

---

### Paso 2: Se Abre el Modal

```
[GALERÍA] AssetManager state:
  {
    assetCount: 5,
    hasOpen: true,
    hasOn: true,
    hasOff: true
  }
```

**Qué pasó:**
- Se abrió automáticamente el modal de GrapesJS
- El AssetManager tiene 5 imágenes cargadas
- Todo listo para seleccionar

---

### Paso 3: Seleccionas una Imagen

```
[GALERÍA - SELECCIÓN] ✅ Imagen seleccionada
  ├─ URL: https://tusitio.com/storage/uploads/imagen.jpg
  ├─ Tipo: GrapesJS Asset
  └─ Actualizando componente...
  └─ ✅ Componente actualizado
```

**Qué pasó:**
- Se ejecutó el handler `onSelectHandler`
- Se extrajo la URL de la imagen
- Se actualizó la propiedad `background-image-url`
- Se llamó a `updateBackgroundImage()`
- El fondo del componente cambió ✅

---

### Paso 4: Verificación

Ejecuta esto en la consola:

```javascript
window.debugGallery()
```

Verás algo como:

```
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
DEBUG: GALERÍA DE IMÁGENES
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

📊 ESTADÍSTICAS:
  Llamadas API realizadas: 2
  Imágenes seleccionadas: 1
  Última llamada API: /creator/media/api/list
  Imágenes en galería: 5

🖼️ ÚLTIMA SELECCIÓN:
  URL: https://tusitio.com/storage/uploads/imagen.jpg
  Número: 1

🔧 ASSET MANAGER:
  - assetCount: 5
  - hasOpen: true
  - hasOn: true
  - hasOff: true

⚠️ ÚLTIMO ERROR:
  Sin errores registrados ✅

📜 HISTORIAL DE SELECCIONES:
  1. https://tusitio.com/storage/uploads/imagen.jpg

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
```

---

## 🔄 FLUJO COMPLETO (Visual)

```
┌─────────────────────────────────────────┐
│ Usuario hace clic en botón              │
└─────────────────┬───────────────────────┘
                  │
                  ▼
        ┌─────────────────────┐
        │ Registra handler    │
        │ am.on('select', ...) │
        └─────────┬───────────┘
                  │
                  ▼
        ┌──────────────────────┐
        │ Carga imágenes API   │
        │ /creator/media/list  │
        └──────────┬───────────┘
                  │
        [LOG] API Call #2
        ✓ 5 imágenes cargadas
                  │
                  ▼
        ┌──────────────────────┐
        │ Abre modal           │
        │ am.open({...})       │
        └──────────┬───────────┘
                  │
        [VISUAL] Modal aparece
        [VISUAL] Se ven imágenes
                  │
                  ▼
    ┌─────────────────────────┐
    │ Usuario selecciona img  │
    └────────────┬────────────┘
                 │
                 ▼
    ┌─────────────────────────────┐
    │ onSelectHandler ejecuta     │
    │ - Extrae URL                │
    │ - Actualiza componente      │
    │ - Llama updateBackground    │
    └────────────┬────────────────┘
                 │
    [LOG] SELECCIÓN ✅
    [LOG] URL: https://...jpg
    [LOG] Actualizado ✅
                 │
                 ▼
    ┌─────────────────────────────┐
    │ ✅ COMPLETADO               │
    │ Fondo actualizado           │
    └─────────────────────────────┘
```

---

## 📊 ENTRADAS DE LOG ESPERADAS

### Cuando Abres el Editor
```
[GALERÍA] Iniciando sistema de logging
[GALERÍA] Editor disponible...
[GALERÍA] Sistema de logging activo...
```

### Cuando Haces Clic en el Botón
```
[GALERÍA #1] Llamada API a: /creator/media/api/list
  ↳ Imágenes cargadas: 5
```

### Cuando Se Abre el Modal
```
[GALERÍA] AssetManager state: {
  assetCount: 5,
  hasOpen: true,
  hasOn: true,
  hasOff: true
}
```

### Cuando Seleccionas Imagen
```
[GALERÍA - SELECCIÓN] ✅ Imagen seleccionada
  ├─ URL: https://...
  ├─ Tipo: GrapesJS Asset
  └─ Actualizando componente...
  └─ ✅ Componente actualizado

[GALERÍA - SELECCIÓN #1] Imagen seleccionada
  ├─ URL: https://...
  └─ Actualizado: Sí ✅
```

---

## 🆘 SI VES ESTO EN VEZ DE LO ANTERIOR

### Error: "Imagen not found"
```
[GALERÍA] ⚠️ No se pudo extraer URL de la imagen
```
**Solución:** Verifica que haya imágenes en la galería

### Error: API 403
```
[GALERÍA #1] Llamada API a: /creator/media/api/list
  ↳ Error: HTTP error! status: 403
```
**Solución:** Asegúrate de tener un website seleccionado

### Error: AssetManager vacío
```
[GALERÍA] AssetManager state: {
  assetCount: 0,
  ...
}
```
**Solución:** Recarga el editor (F5)

---

## 🧪 PRUEBAS INTERACTIVAS

### Test 1: Ver el flujo completo
```javascript
// 1. Abre el editor
// 2. Haz clic en "Seleccionar Imagen"
// 3. En consola verás los logs en tiempo real
```

### Test 2: Verificar selecciones
```javascript
window.debugGallery()
// Verás el resumen completo
```

### Test 3: Ver historial
```javascript
window.__galleryDebug.selectionHistory
// Array con todas las selecciones
```

### Test 4: Ver última selección
```javascript
console.log(window.__galleryDebug.lastSelection)
// Detalles de la imagen seleccionada
```

---

## 📈 MÉTRICA DE FUNCIONAMIENTO

**Sistema funcionando correctamente si ves:**

✅ API Call log cuando haces clic  
✅ AssetManager con N imágenes  
✅ Modal visible en pantalla  
✅ Log "Imagen seleccionada" al seleccionar  
✅ "Componente actualizado" después  
✅ La previsualización cambia  

---

## 🎬 EJEMPLO REAL DE SESIÓN

```
> Usuario abre editor
[GALERÍA] Iniciando sistema de logging
[GALERÍA] Editor disponible...

> Usuario hace clic en botón
[GALERÍA #1] Llamada API a: /creator/media/api/list
  ↳ Imágenes cargadas: 8
[GALERÍA] AssetManager state: { assetCount: 8, ... }

> Usuario ve el modal y selecciona una imagen
[GALERÍA - SELECCIÓN] ✅ Imagen seleccionada
  ├─ URL: https://example.com/img-123.jpg
  ├─ Tipo: GrapesJS Asset
  └─ Actualizando componente...
  └─ ✅ Componente actualizado

[GALERÍA - SELECCIÓN #1] Imagen seleccionada
  ├─ URL: https://example.com/img-123.jpg
  └─ Actualizado: Sí ✅

> Usuario ejecuta debugGallery()
window.debugGallery()
╔ Mostrar resumen con 1 API call, 1 selección ╗
```

---

## 💡 CÓMO LEER LOS LOGS

| Log | Significa |
|-----|-----------|
| `[GALERÍA #N]` | N-ésima llamada a la API |
| `[GALERÍA - SELECCIÓN]` | Una imagen fue seleccionada |
| `✅` | Éxito |
| `⚠️` | Advertencia |
| `❌` | Error |
| `↳` | Detalle del log anterior |

---

## 🎯 RESUMEN

Cuando funciona correctamente, verás este flujo:

```
1. Clic en botón
   ↓
2. [GALERÍA #N] Llamada API ✅
   ↓
3. Modal abierto (visual)
   ↓
4. Selecciona imagen
   ↓
5. [GALERÍA - SELECCIÓN] ✅ Actualizado
   ↓
6. Fondo cambia (visual)
```

**Todos estos pasos con sus logs correspondientes.**

---

**Documento: FLUJO_VISUAL_GALERIA.md**  
**Fecha: 31-01-2026**
