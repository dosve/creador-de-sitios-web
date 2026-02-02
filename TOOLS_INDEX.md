# 📚 Índice: Herramientas de Diagnóstico

Aquí encontrarás toda la información sobre cómo se renderiza tu página y por qué puede verse diferente entre el editor y la página real.

---

## 📖 Documentos de Referencia

### 1. **Respuesta Rápida**
**Archivo:** [`RESPUESTA_RAPIDA.md`](RESPUESTA_RAPIDA.md)

La respuesta más directa a tu pregunta:
- ✅ Qué se guarda (HTML + CSS)
- ❌ Qué se agrega automáticamente (Tailwind, Font Awesome, etc.)
- Tabla completa de origen de cada elemento

**Tiempo de lectura:** 2 minutos

---

### 2. **Análisis Completo**
**Archivo:** [`COMO_SE_RENDERIZA_PAGINA.md`](COMO_SE_RENDERIZA_PAGINA.md)

Explicación detallada del flujo completo:
- Paso a paso de cómo se renderiza
- Checklist de dónde viene cada cosa
- Causas comunes de diferencias
- Guía de depuración
- Incluye toda la estructura técnica

**Tiempo de lectura:** 10-15 minutos

---

### 3. **Guía de Diagnóstico**
**Archivo:** [`diagnose-render-differences.md`](diagnose-render-differences.md)

Pasos prácticos para diagnosticar problemas:
- Causas comunes específicas
- Cómo inspeccionar en el navegador
- Verificación en base de datos
- Checklist de comparación
- Soluciones rápidas

**Tiempo de lectura:** 8 minutos

---

## 🛠️ Herramientas Web Interactivas

### 4. **Inspector de Contenido (Web)**
**URL:** `http://127.0.0.1:8000/inspect-page-content.php?page_id=33`

Herramienta visual interactiva en el navegador:
- Ver exactamente qué HTML se guardó
- Ver exactamente qué CSS se guardó
- Análisis automático de elementos
- Tabs organizados
- Enlaces rápidos a editor y página real

**Interfaz:** Moderna con TailwindCSS
**Interactivo:** Sí (tabs, detalles expandibles)

---

### 5. **Inspector CLI (Terminal)**
**Comando:** `php public/inspect-cli.php 33`

Herramienta de línea de comandos:
- Verificar rápidamente desde terminal
- Colores ANSI para fácil lectura
- Resumen de problemas
- Recomendaciones automáticas

**Interfaz:** Terminal con colores
**Velocidad:** Muy rápido

---

## 🎯 Por Dónde Empezar

### **Si tienes prisa (2 minutos):**
1. Lee [`RESPUESTA_RAPIDA.md`](RESPUESTA_RAPIDA.md)
2. Abre [`http://127.0.0.1:8000/inspect-page-content.php?page_id=33`](http://127.0.0.1:8000/inspect-page-content.php?page_id=33)

### **Si quieres entender bien (15 minutos):**
1. Lee [`COMO_SE_RENDERIZA_PAGINA.md`](COMO_SE_RENDERIZA_PAGINA.md)
2. Usa [`http://127.0.0.1:8000/inspect-page-content.php?page_id=33`](http://127.0.0.1:8000/inspect-page-content.php?page_id=33) para verificar

### **Si tienes un problema específico:**
1. Sigue los pasos en [`diagnose-render-differences.md`](diagnose-render-differences.md)
2. Usa el Inspector para verificar
3. Abre DevTools (F12) en navegador

---

## ❓ Preguntas Frecuentes Rápidas

**P: ¿Por qué la página real se ve diferente al editor?**
R: Probablemente el CSS no se guardó. Abre el Inspector y verifica.

**P: ¿Se guarda el Tailwind CSS?**
R: No, viene del CDN. Se agrega automáticamente.

**P: ¿Dónde está mi contenido en la BD?**
R: Tabla `pages`, columnas `html_content` y `css_content`.

**P: ¿Qué es grapesjs_data?**
R: Los datos completos del editor. Se usa para recargar después.

**P: ¿Por qué está vacío el CSS?**
R: Normal si solo usas Tailwind. Solo necesitas CSS si usas estilos custom.

---

## 🔧 Acciones Rápidas

| Acción | URL/Comando |
|--------|-----------|
| **Ver página real** | [`http://127.0.0.1:8000/eme10/prueba`](http://127.0.0.1:8000/eme10/prueba) |
| **Ir al editor** | [`http://127.0.0.1:8000/creator/pages/33/editor`](http://127.0.0.1:8000/creator/pages/33/editor) |
| **Inspector web** | [`http://127.0.0.1:8000/inspect-page-content.php?page_id=33`](http://127.0.0.1:8000/inspect-page-content.php?page_id=33) |
| **Inspector CLI** | `php public/inspect-cli.php 33` |

---

## 📊 Arquitectura Técnica (Resumida)

```
EDITOR GrapesJS          BD (Tabla pages)        PÁGINA PÚBLICA
┌──────────────┐         ┌─────────────┐         ┌────────────┐
│ HTML Canvas  │         │ html_content│         │ 1. Tailwind│
│ CSS Styles   │ ────→   │ css_content │ ────→   │ 2. Tu CSS  │
│ Components   │  SAVE   │ grapesjs    │  FETCH  │ 3. Tu HTML │
└──────────────┘         │ title, etc. │         └────────────┘
                         └─────────────┘
```

---

## 💡 Consejos

1. **Siempre guarda después de editar** - Los cambios se pierden si no presionas "Guardar"
2. **Verifica que esté publicada** - Una página no publicada no aparece en público
3. **Limpia caché** - Ctrl+Shift+Del si ves versión antigua
4. **Usa el Inspector** - Es la herramienta más rápida para ver qué se guardó
5. **Redimensiona igual** - Editor y navegador deben tener el mismo ancho para comparar

---

## 📞 Necesitas Más Ayuda

Si después de revisar todo sigue sin funcionar:

1. **Abre el Inspector:** [`http://127.0.0.1:8000/inspect-page-content.php?page_id=33`](http://127.0.0.1:8000/inspect-page-content.php?page_id=33)
2. **Toma un screenshot** de los problemas encontrados
3. **Verifica:**
   - ¿HTML está vacío?
   - ¿CSS está vacío?
   - ¿Está publicada?
4. **Abre DevTools en la página real (F12)** y busca errores en rojo

---

Última actualización: Enero 31, 2026
