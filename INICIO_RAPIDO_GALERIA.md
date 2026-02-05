# ⚡ INICIO RÁPIDO - Verificar Modal de Galería

> **Hecho en:** 31 de Enero de 2026  
> **Tiempo de lectura:** 2 minutos  
> **Tiempo de prueba:** 1 minuto

---

## 🚀 EN 3 PASOS

### 1️⃣ Recargar el editor
```
Abre: http://localhost/creator/pages/[page-id]/edit
Presiona: F5 (recargar)
```

### 2️⃣ Crear componente
```
Opción A: Arrastra "Imagen de Fondo" desde bloques de la izquierda
Opción B: Si ya existe, selecciona uno
```

### 3️⃣ Hacer clic en botón
```
Busca: "📁 Seleccionar Imagen de Fondo"
Haz clic
Resultado esperado: ✅ Se abre un modal con imágenes
```

---

## ✅ CHECKLIST DE VERIFICACIÓN

```
□ Modal se abre
□ Se muestran imágenes
□ Puedo hacer clic en una imagen
□ Se actualiza la previsualización
□ No hay errores en la consola
```

Si todos marcan ✅ → **¡Funciona correctamente!**

---

## 🧪 SI FALLA, DEBUGGING EN 30 SEGUNDOS

### Paso 1: Abre consola
```
F12 en el navegador
```

### Paso 2: Ejecuta esto
```javascript
window.debugGallery()
```

### Paso 3: Busca errores
```
Mira la salida:
- ¿Dice "API Funcionando"?
- ¿Dice números de assets?
- ¿Hay errores en rojo?
```

---

## 📋 PRUEBAS MANUALES

Si quieres verificar más a fondo, en la consola ejecuta:

### Test 1: API Funciona
```javascript
fetch('/creator/media/api/list')
  .then(r => r.json())
  .then(d => console.log('✅ API OK:', d.files.length, 'imágenes'))
  .catch(e => console.error('❌ API Error:', e));
```

### Test 2: AssetManager Funciona
```javascript
const am = window.editor.AssetManager;
console.log('✅ AssetManager OK');
console.log('  - Assets:', am.getAll().length);
console.log('  - open():', typeof am.open);
```

### Test 3: Abrir Modal Manualmente
```javascript
window.editor.AssetManager.open({ types: ['image'] });
```

---

## 🎯 RESULTADO ESPERADO

### Visual
```
┌─────────────────────────────┐
│   Seleccionar Imagen        │
│                             │
│  [IMG1] [IMG2] [IMG3]       │
│  [IMG4] [IMG5] [IMG6]       │
│                             │
│     Haz clic para elegir    │
└─────────────────────────────┘
```

### Console
```
[GALERÍA] Iniciando sistema de logging
[GALERÍA #1] Llamada API a: /creator/media/api/list
[GALERÍA] AssetManager state: { assetCount: 5, ... }
```

---

## 🚨 TROUBLESHOOTING RÁPIDO

| Problema | Solución |
|----------|----------|
| Modal no se abre | Recarga (F5) → Intenta de nuevo |
| "Image not found" | Verifica que haya imágenes en galería |
| Error 403 | Asegúrate de tener website seleccionado |
| Consola roja | Ver `DIAGNOSTICO_GALERIA_MODAL.md` |

---

## 📚 DOCUMENTACIÓN COMPLETA

Si necesitas más detalles:

- **¿Qué cambió?** → `COMPARATIVA_ANTES_DESPUES.md`
- **¿Cómo funciona?** → `CORRECCION_GALERIA_COMPLETA.md`
- **¿Qué hago si falla?** → `DIAGNOSTICO_GALERIA_MODAL.md`
- **¿Cuál es el árbol de cambios?** → `ARBOL_CAMBIOS_GALERIA.md`

---

## 💾 COPIA RÁPIDA

Si quieres probarlo todo en uno:

```javascript
// Copiar todo esto a la consola (F12)

console.log('🔍 Iniciando verificación...\n');

// 1. Verificar editor
console.log('1. Editor:', !!window.editor);

// 2. Verificar AssetManager
const am = window.editor?.AssetManager;
console.log('2. AssetManager:', !!am);

// 3. Test API
fetch('/creator/media/api/list')
  .then(r => r.json())
  .then(d => {
    console.log('3. API:', d.success ? '✅' : '❌');
    console.log('   Imágenes:', d.files?.length);
  })
  .catch(e => console.log('3. API: ❌', e.message));

// 4. Abrir modal
setTimeout(() => {
  console.log('4. Abriendo modal...');
  am?.open({ types: ['image'] });
}, 1000);
```

---

## ✨ LISTO

Ahora mismo:
1. Recarga el editor
2. Haz clic en el botón
3. Verifica que funciona ✅

Si funciona → **Misión cumplida** 🎉

Si no funciona → Ejecuta `window.debugGallery()` y compartela salida

---

**Documento rápido - 31/01/26**
