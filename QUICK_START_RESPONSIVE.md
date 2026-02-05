# ⚡ QUICK START - COMIENZA AQUÍ

## 30 Segundos

1. **Recarga:** `Ctrl+F5`
2. **Consola:** `F12`
3. **Ejecuta:** 
   ```javascript
   window.investigateResponsive()
   ```
4. **Lee los logs** (de arriba a abajo)
5. **Comparte conmigo lo que ves**

---

## 2 Minutos (Si Hay Problemas)

```javascript
// 1. Si ves "❌ Clases mal formadas"
window.fixResponsiveClasses()

// 2. Espera 2 segundos

// 3. Ejecuta de nuevo
window.investigateResponsive()

// 4. Si todo sigue igual, recarga
location.reload()
```

---

## 3 Minutos (Dashboard Visual)

```javascript
// Ver un panel flotante en la esquina derecha
window.showResponsiveDashboard()
```

El panel:
- ✅ Se actualiza cada 2 segundos
- ✅ Muestra problemas encontrados
- ✅ Ofrece botones de acción

---

## Comandos Principales

```javascript
// Investigación completa (AQUÍ EMPEZAR)
window.investigateResponsive()

// Diagnóstico detallado (MÁS LENTO, MÁS COMPLETO)
window.debugResponsiveClasses()

// Reparar clases mal formadas (AUTOMÁTICO)
window.fixResponsiveClasses()

// Ver panel visual (INTERFAZ GRÁFICA)
window.showResponsiveDashboard()

// Limpiar consola
console.clear()
```

---

## Qué Significan los Símbolos

| Símbolo | Significa |
|---------|-----------|
| ✅ | Está bien |
| ❌ | Hay un problema |
| ⚠️ | Advertencia |
| 📱 | Móvil |
| 🖥️ | Desktop |
| 🚀 | Inicializando |

---

## Los 3 Casos Más Comunes

### Caso A: "Columnas lado a lado en móvil"
```
↓ Ejecuta:
window.fixResponsiveClasses()
window.investigateResponsive()
```

### Caso B: "No veo media queries"
```
↓ Verifica:
1. Ctrl+F5 (hard refresh)
2. window.debugResponsiveClasses()
3. Si no salen media queries, el CSS no cargó
```

### Caso C: "No sé qué está mal"
```
↓ Haz esto:
1. window.investigateResponsive()
2. Lee todos los logs
3. Comparte una captura
```

---

## 🚨 Si Nada Funciona

Comparte:
1. **Captura de los logs** (screenshot de la consola)
2. **Tamaño de tu ventana** (ancho en px)
3. **Lo que ves en la página** (columnas lado a lado o apiladas)

---

## 📚 Documentación Completa

Archivo: [`GUIA_INVESTIGACION_RESPONSIVE.md`](./GUIA_INVESTIGACION_RESPONSIVE.md)

Archivo: [`HERRAMIENTAS_DIAGNOSTICO_RESUMEN.md`](./HERRAMIENTAS_DIAGNOSTICO_RESUMEN.md)

---

**¡Vamos! Recarga + Consola + Investiga = Solucionado 🚀**
