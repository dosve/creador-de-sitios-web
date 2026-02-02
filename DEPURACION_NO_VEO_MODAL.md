# 🆘 DEPURACIÓN: "No veo el Modal"

**Versión:** v1.2 con Logging Ultra Detallado  
**Fecha:** 31 de Enero de 2026

---

## 📋 PASOS EXACTOS PARA PROBAR

### 1️⃣ Preparación
```
1. Abre el navegador
2. Abre la página del editor
3. Presiona F12 (abre consola)
4. IMPORTANTE: No desplaces la consola (queremos ver todos los logs)
```

### 2️⃣ Busca el Componente "Imagen de Fondo"
```
Opción A: 
- Busca en los bloques de la izquierda
- Arrastra "Imagen de Fondo" al canvas

Opción B:
- Si ya existe, selecciónalo
```

### 3️⃣ Abre la Consola
```
En la consola deberías ver:
[GALERÍA] Iniciando sistema de logging
[GALERÍA] Editor disponible...
[GALERÍA] Sistema de logging activo...
```

### 4️⃣ Haz Clic en el Botón
```
Busca en el panel de la derecha (traits):
"📁 Seleccionar Imagen de Fondo"

Haz clic
```

### 5️⃣ Mira la Consola Paso a Paso

Deberías ver estos logs **en este orden exacto**:

```
[GALERÍA] Botón presionado - Iniciando flujo
[GALERÍA] Componente válido: Imagen de Fondo
[GALERÍA] AssetManager obtenido
[GALERÍA] Modal obtenido
[GALERÍA] Listeners previos limpiados
[GALERÍA] Handler registrado para evento "select"
[GALERÍA] Iniciando fetch de imágenes...
[GALERÍA] Respuesta HTTP recibida: 200
[GALERÍA] Datos JSON procesados
[GALERÍA] ✅ 5 imágenes encontradas        ← (o el # que tengas)
[GALERÍA] AssetManager limpiado
[GALERÍA]   1. imagen1.jpg
[GALERÍA]   2. imagen2.png
[GALERÍA]   ... más imágenes ...
[GALERÍA] ✅ Imágenes agregadas al AssetManager
[GALERÍA] Abriendo modal con am.open()...
[GALERÍA] ✅ Modal abierto
```

**Si ves esto pero NO ves el modal en pantalla**, el problema está en GrapesJS.

---

## 🔍 VERIFICACIÓN POR ETAPA

### Etapa 1: ¿Se presiona el botón?
```
Busca en consola:
[GALERÍA] Botón presionado - Iniciando flujo

Si NO VES ESTO:
→ Recarga la página (F5)
→ Intenta de nuevo
```

### Etapa 2: ¿Se obtiene el componente?
```
Busca en consola:
[GALERÍA] Componente válido: Imagen de Fondo

Si OLVEDES ESTO:
→ Asegúrate de seleccionar "Imagen de Fondo"
→ No otro componente
```

### Etapa 3: ¿Se obtienen AssetManager y Modal?
```
Busca en consola:
[GALERÍA] AssetManager obtenido
[GALERÍA] Modal obtenido

Si NO VES ESTO:
→ Problema con GrapesJS
→ Recarga página (F5)
```

### Etapa 4: ¿Se hace el fetch?
```
Busca en consola:
[GALERÍA] Iniciando fetch de imágenes...
[GALERÍA] Respuesta HTTP recibida: 200

Si VES 403 EN VEZ DE 200:
→ No tienes website seleccionado
→ Abre el sitio primero

Si VES ERROR:
→ La galería no tiene permiso
→ Asegúrate de estar logueado
```

### Etapa 5: ¿Se cargan las imágenes?
```
Busca en consola:
[GALERÍA] ✅ 5 imágenes encontradas
[GALERÍA]   1. imagen1.jpg
[GALERÍA]   2. imagen2.png
...

Si VES "0 imágenes":
→ Sube imágenes a tu galería primero
→ O selecciona un sitio con imágenes

Si VES ERROR:
→ La API está fallando
→ Ver sección ERROR MÁS ABAJO
```

### Etapa 6: ¿Se abre el modal?
```
Busca en consola:
[GALERÍA] Abriendo modal con am.open()...
[GALERÍA] ✅ Modal abierto

VISUALMENTE:
→ Deberías ver un modal con imágenes

Si NO VES EL MODAL EN PANTALLA PERO VES ESTOS LOGS:
→ Problema con CSS/visibilidad de GrapesJS
→ Ver sección "MODAL NO VISIBLE" MÁS ABAJO
```

---

## 🚨 PROBLEMAS Y SOLUCIONES

### ❌ No veo ningún log

**Problema:** La consola está vacía

**Checklist:**
- [ ] ¿Presionaste F12?
- [ ] ¿Ves otros mensajes en la consola?
- [ ] ¿Hiciste clic en el botón?
- [ ] ¿Esperaste 2 segundos?

**Soluciones:**
```
1. Recarga la página (F5)
2. Espera a que cargue todo
3. Haz clic en el botón
4. Mira la consola inmediatamente
```

---

### ❌ Veo logs pero se detiene en "Abriendo modal"

**Problema:** Ves esto pero no continúa:
```
[GALERÍA] Abriendo modal con am.open()...
```

Y luego nada.

**Causa:** `am.open()` no es una función válida

**Solución - Test:**
```javascript
// En la consola, ejecuta:
const am = window.editor.AssetManager;
console.log(typeof am.open);
```

**Deberías ver:**
```
"function"
```

**Si ves "undefined":**
→ Hay problema con GrapesJS
→ Recarga (F5)
→ Prueba de nuevo

---

### ❌ Error HTTP 403

**Problema:** Ves esto:
```
[GALERÍA] Respuesta HTTP recibida: 403
[GALERÍA] ❌ Error en fetch: Error: HTTP error! status: 403
```

**Causa:** No hay website seleccionado

**Solución:**
1. Cierra el editor
2. Abre un website específico
3. Vuelve a entrar al editor
4. Intenta de nuevo

---

### ❌ Error en logs pero modal no visible

**Problema:** Ves todos los logs verdes pero NO ves el modal en pantalla

**Posibles causas:**
1. El modal está detrás de otros elementos (z-index)
2. El modal es invisible (opacity: 0)
3. GrapesJS no lo renderizó correctamente

**Soluciones:**
```javascript
// En consola, intenta esto:
window.editor.Modal.show();
```

Si aparece, excelente. Si no:

```javascript
// Intenta abrir la galería directamente:
window.editor.AssetManager.open({ types: ['image'] });
```

---

### ❌ Veo error "Cannot read property 'get'"

**Problema:** Error en consola

**Causa:** El asset no tiene la función `get()`

**Solución:** El código intenta 5 formas diferentes de extraer la URL. Si ninguna funciona, probablemente el objeto asset está malformado.

```javascript
// En consola, cuando selecciones una imagen:
window.__galleryDebug.lastSelection.asset
```

Inspecciona qué propiedades tiene.

---

## 🎯 PRUEBA MANUAL DEL MODAL

### Test 1: ¿Existe la función `am.open()`?

```javascript
// En consola:
window.editor.AssetManager.open
```

Deberías ver:
```
ƒ open()
```

Si ves `undefined`, hay problema serio con GrapesJS.

---

### Test 2: ¿Abre el modal manualmente?

```javascript
// En consola:
window.editor.AssetManager.open({ types: ['image'] })
```

¿Ves el modal?

Si SÍ: El problema es con nuestra lógica
Si NO: El problema es con GrapesJS

---

### Test 3: ¿Están las imágenes en el AssetManager?

```javascript
// En consola:
window.editor.AssetManager.getAll().length
```

Deberías ver:
```
5
```
(o el número de imágenes en tu galería)

Si ves 0 o undefined: Las imágenes no se cargaron

---

## 📊 TABLA DE DIAGNÓSTICO

| Síntoma | Logs Que Ves | Qué Revisar |
|---------|--------------|------------|
| Sin logs | Nada | ¿Hiciste F12? ¿Clickeaste? |
| Logs hasta "Botón presionado" | Sólo primer log | ¿Seleccionaste componente correcto? |
| Logs hasta "AssetManager obtenido" | Hasta línea 2 | ¿Hay problema con GrapesJS? |
| Logs hasta "HTTP 403" | Hasta fetch | ¿Seleccionaste website? |
| Logs hasta "0 imágenes" | Hasta API | ¿Hay imágenes en la galería? |
| Todos los logs pero sin modal visual | Todos verdes | ¿Es problema de CSS/visibilidad? |
| Error JavaScript | Con ❌ | Ver sección de errores |

---

## 💡 COMANDOS RÁPIDOS DE TEST

Copia estos y ejecuta en F12:

### Ver resumen
```javascript
window.debugGallery()
```

### Ver número de imágenes
```javascript
window.editor.AssetManager.getAll().length
```

### Abrir modal manualmente
```javascript
window.editor.AssetManager.open({ types: ['image'] })
```

### Ver último error
```javascript
window.__galleryDebug.lastError
```

### Ver última selección
```javascript
window.__galleryDebug.lastSelection
```

---

## ✅ CHECKLIST DE ÉXITO

Si VES TODO ESTO, el sistema funciona:

- [ ] Veo logs iniciales en consola
- [ ] Veo "[GALERÍA] Botón presionado"
- [ ] Veo "[GALERÍA] HTTP 200"
- [ ] Veo "[GALERÍA] X imágenes encontradas"
- [ ] Veo "[GALERÍA] ✅ Modal abierto"
- [ ] Veo el modal en pantalla
- [ ] Puedo seleccionar una imagen
- [ ] Veo "[GALERÍA - SELECCIÓN] ✅"
- [ ] El fondo del componente cambió

Si todos sí → **¡FUNCIONA PERFECTAMENTE!**

---

## 🆘 Si Nada Funciona

**Pasos nucleares:**

1. **Abre devtools (F12)**
2. **Recarga página (F5)**
3. **Espera 5 segundos**
4. **Abre un website**
5. **Abre el editor**
6. **Arrastra "Imagen de Fondo"**
7. **Haz clic en el botón**
8. **Mira la consola**
9. **Copia el PRIMER LOG DE ERROR que veas**

Y si aún no funciona, comparte ese primer error en rojo.

---

**Documento: DEPURACION_NO_VEO_MODAL.md**  
**Versión: v1.2 Ultra Detallado**  
**Fecha: 31-01-2026**
