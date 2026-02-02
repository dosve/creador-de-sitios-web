# 🎬 GUÍA: Cómo Rastrear la Selección de Imagen

**Actualizado:** 31 de Enero de 2026  
**Versión:** v1.1 con Logging Mejorado

---

## 🎯 OBJETIVO

Entender exactamente qué sucede cuando:
1. Haces clic en "Seleccionar Imagen de Fondo"
2. Se abre el modal
3. Seleccionas una imagen
4. Se actualiza el componente

---

## 📺 PASO A PASO CON LOGS

### Paso 1: Prepárate

```javascript
// Abre F12 (Consola del navegador)
// Deja la consola abierta
// No desplaces (queremos ver todos los logs)
```

### Paso 2: Haz Clic en el Botón

**Qué ves en la consola:**
```
[GALERÍA #1] Llamada API a: /creator/media/api/list
  ↳ Imágenes cargadas: 5
```

**Qué pasó internamente:**
```
editor.getSelected()        // Obtiene el componente
│
├─ am = editor.AssetManager
├─ am.off('select')        // Limpia listeners viejos
└─ am.on('select', handler) // Registra nuevo handler
│
fetch('/creator/media/api/list')  // Carga imágenes
│
├─ respuesta.json()
├─ am.getAll().reset()     // Borra imágenes viejas
├─ data.files.forEach()    // Agrega nuevas imágenes
└─ am.open()               // Abre el modal ✅
```

### Paso 3: Se Abre el Modal

**Visualmente:** Ves un modal con imágenes

**En consola:** (Silencio, todo bien)

**Internamente:**
```
GrapesJS renderiza el modal
│
├─ Muestra 5 imágenes
├─ Cada una es clickeable
└─ Espera a que hagas clic
```

### Paso 4: Seleccionas una Imagen

**Qué ves en la consola:**
```
[GALERÍA - SELECCIÓN] ✅ Imagen seleccionada
  ├─ URL: https://example.com/img-456.jpg
  ├─ Tipo: GrapesJS Asset
  └─ Actualizando componente...
  └─ ✅ Componente actualizado

[GALERÍA - SELECCIÓN #1] Imagen seleccionada
  ├─ URL: https://example.com/img-456.jpg
  └─ Actualizado: Sí ✅
```

**Qué pasó internamente:**
```
Usuario hizo clic
│
└─ Se dispara: am.on('select', onSelectHandler)
   │
   ├─ asset = la imagen seleccionada
   ├─ newSrc = se extrae URL
   │
   ├─ component.set('background-image-url', newSrc)
   │  └─ Guarda la URL en el modelo
   │
   ├─ component.updateBackgroundImage()
   │  └─ Actualiza el CSS del componente
   │
   ├─ am.off('select', onSelectHandler)
   │  └─ Desregistra el handler
   │
   └─ Logs en consola ✅
```

### Paso 5: Se Actualiza el Fondo

**Visualmente:** El fondo del componente cambia a la imagen seleccionada

**En consola:** Ya lo viste en el Paso 4

**Internamente:**
```
updateBackgroundImage() se ejecuta
│
├─ Obtiene la URL: newSrc
│
├─ this.view.el.style.setProperty('background-image', ...)
│
└─ Actualiza el DOM en tiempo real ✅
```

---

## 🔍 CÓMO LEER LOS LOGS

### Primer Log (Paso 2)

```
[GALERÍA #1] Llamada API a: /creator/media/api/list
  ↳ Imágenes cargadas: 5
```

**Decodificación:**
- `[GALERÍA #1]` = Es la 1ª llamada a la API (en esta sesión)
- `Llamada API a:` = Se está llamando a la ruta
- `/creator/media/api/list` = Específicamente a este endpoint
- `Imágenes cargadas: 5` = La API respondió con 5 imágenes

### Segundo Log (Paso 4)

```
[GALERÍA - SELECCIÓN] ✅ Imagen seleccionada
  ├─ URL: https://example.com/img-456.jpg
  ├─ Tipo: GrapesJS Asset
  └─ Actualizando componente...
  └─ ✅ Componente actualizado
```

**Decodificación:**
- `[GALERÍA - SELECCIÓN]` = Evento de selección
- `✅ Imagen seleccionada` = Se seleccionó exitosamente
- `URL:` = Aquí va la dirección de la imagen
- `Tipo: GrapesJS Asset` = Es un asset del editor (no un objeto cualquiera)
- `Actualizando componente...` = Se está actualizando
- `✅ Componente actualizado` = Se actualizó correctamente

### Tercer Log (Paso 4, segunda parte)

```
[GALERÍA - SELECCIÓN #1] Imagen seleccionada
  ├─ URL: https://example.com/img-456.jpg
  └─ Actualizado: Sí ✅
```

**Decodificación:**
- `[GALERÍA - SELECCIÓN #1]` = Es la 1ª selección (en esta sesión)
- `Imagen seleccionada` = Se registró la selección
- `URL:` = La URL seleccionada
- `Actualizado: Sí ✅` = Se guardó correctamente

---

## 🧪 VERIFICACIONES INTERACTIVAS

### Verificación 1: ¿Se cargó la galería?

```javascript
// Ejecuta en consola:
window.__galleryDebug.lastApiCall
```

**Deberías ver:**
```javascript
{
  timestamp: ...,
  url: "/creator/media/api/list",
  callNumber: 1,
  response: {
    success: true,
    files: [
      { id: 1, filename: "img1.jpg", url: "...", alt_text: "..." },
      ...
    ]
  }
}
```

### Verificación 2: ¿Cuántas imágenes hay?

```javascript
// Ejecuta en consola:
window.__galleryDebug.lastApiCall.response.files.length
```

**Deberías ver:**
```
5
```
(O el número de imágenes en tu galería)

### Verificación 3: ¿Se seleccionó imagen?

```javascript
// Ejecuta en consola:
window.__galleryDebug.lastSelection
```

**Deberías ver:**
```javascript
{
  timestamp: ...,
  asset: { ... },
  imageUrl: "https://example.com/img-456.jpg",
  selectionNumber: 1
}
```

### Verificación 4: ¿Cuál fue la URL seleccionada?

```javascript
// Ejecuta en consola:
window.__galleryDebug.lastSelection.imageUrl
```

**Deberías ver:**
```
"https://example.com/img-456.jpg"
```

### Verificación 5: ¿Cuántas selecciones hiciste?

```javascript
// Ejecuta en consola:
window.__galleryDebug.selectionCount
```

**Deberías ver:**
```
1
```
(Cada vez que selecciones otra imagen, sube este número)

### Verificación 6: Ver todo el resumen

```javascript
// Ejecuta en consola:
window.debugGallery()
```

**Deberías ver:**
```
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
DEBUG: GALERÍA DE IMÁGENES
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

📊 ESTADÍSTICAS:
  Llamadas API realizadas: 1
  Imágenes seleccionadas: 1
  Última llamada API: /creator/media/api/list
  Imágenes en galería: 5

🖼️ ÚLTIMA SELECCIÓN:
  URL: https://example.com/img-456.jpg
  Número: 1

... y más ...
```

---

## 📊 TABLA RÁPIDA DE LOGS

| Evento | Log | Cómo Verificar |
|--------|-----|----------------|
| API llamada | `[GALERÍA #N]` | `__galleryDebug.apiCallCount` |
| Imágenes cargadas | `Imágenes cargadas: N` | `__galleryDebug.lastApiCall.response.files.length` |
| Imagen seleccionada | `[GALERÍA - SELECCIÓN]` | `__galleryDebug.lastSelection` |
| URL de imagen | `URL: https://...` | `__galleryDebug.lastSelection.imageUrl` |
| Actualización exitosa | `✅ Componente actualizado` | Visual: fondo cambió |

---

## ✅ CHECKLIST DE FUNCIONAMIENTO

Marca todo para confirmar que funciona:

```
□ 1. Hago clic en botón
□ 2. Veo log [GALERÍA #N] en consola
□ 3. Se muestra "Imágenes cargadas: X"
□ 4. Se abre el modal (visual)
□ 5. Veo imágenes en el modal
□ 6. Selecciono una imagen
□ 7. Veo log [GALERÍA - SELECCIÓN]
□ 8. Veo la URL en el log
□ 9. Veo "Componente actualizado"
□ 10. El fondo del componente cambió
```

Si todos marcados ✅ → **¡Todo funciona perfectamente!**

---

## 🚨 TROUBLESHOOTING RÁPIDO

### No veo logs

**Problema:** Los logs no aparecen

**Soluciones:**
1. ¿Abriste la consola (F12)?
2. ¿Hiciste clic en el botón?
3. ¿Espéraste a que cargue?
4. Recarga (F5) e intenta de nuevo

### Veo error en log

**Problema:** Ves un error rojo

**Busca en:** [DIAGNOSTICO_GALERIA_MODAL.md](DIAGNOSTICO_GALERIA_MODAL.md)
- Sección "POSIBLES PROBLEMAS"

### El modal no se abre

**Problema:** No ves el modal aunque sí veo los logs

**Intenta:**
```javascript
window.editor.AssetManager.open({ types: ['image'] })
```

Ejecuta esto en consola. ¿Se abre el modal?

---

## 📚 DOCUMENTACIÓN RELACIONADA

- **Flujo visual:** [FLUJO_VISUAL_GALERIA.md](FLUJO_VISUAL_GALERIA.md)
- **Mejoras de logging:** [MEJORAS_LOGGING_GALERIA.md](MEJORAS_LOGGING_GALERIA.md)
- **Troubleshooting:** [DIAGNOSTICO_GALERIA_MODAL.md](DIAGNOSTICO_GALERIA_MODAL.md)

---

## 🎯 RESUMEN

Para rastrear la selección:

1. **Abre F12** (consola)
2. **Haz clic** en "Seleccionar Imagen de Fondo"
3. **Mira los logs** que aparecen
4. **Selecciona** una imagen
5. **Mira más logs** confirmando la selección
6. **Ejecuta `window.debugGallery()`** para ver resumen

**Todo lo que necesitas saber está en los logs.**

---

**Documento: COMO_RASTREAR_SELECCION.md**  
**Fecha: 31-01-2026**
