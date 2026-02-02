# 🚀 Referencia Rápida: Espaciado sin Overflow

## El Problema en 10 Segundos
Cuando pones dos elementos al 50% + padding → se desbordan.

## La Solución en 10 Segundos
Usa `gap` (espacio ENTRE elementos) en lugar de `padding` en el contenedor.

---

## Configuración Correcta

### ✅ Contenedor + Dos Elementos al 50%
```
CONTENEDOR
├─ Espaciado Interno (Border): p-[10px]
├─ Espaciado entre Elementos: gap-4 ← IMPORTANTE
├─ Elemento 1: w-1/2
└─ Elemento 2: w-1/2
```

### ❌ Lo que NO hacer
```
CONTENEDOR
├─ Espaciado Interno: p-8  ← Demasiado grande
├─ Elemento 1: w-1/2
└─ Elemento 2: w-1/2
```

---

## Disponible en el Editor

### Trait: "Espaciado entre Elementos"
- `gap-0` → Sin espacio
- `gap-1` → 4px
- `gap-2` → 8px
- **`gap-4` → 16px** ← Recomendado para dos elementos
- `gap-6` → 24px
- `gap-8` → 32px
- `gap-10` → 40px
- `gap-12` → 48px

### Trait: "Espaciado Interno (Border)"
- `p-0` → Sin
- `p-2` → 8px
- `p-4` → 16px
- `p-[10px]` → 10px (default)
- `p-6` → 24px
- `p-8` → 32px
- `p-12` → 48px

---

## ✅ Cambios Técnicos Realizados

| Archivo | Cambio | Efecto |
|---------|--------|--------|
| `editor.blade.php` | Agregado `box-sizing: border-box` global | Padding NO aumenta tamaño |
| `canvas-responsive.css` | Agregado `overflow: hidden` | Contiene desbordamientos |
| `canvas-responsive.css` | Agregado `flex-shrink: 1` | Elementos se ajustan automáticamente |
| `container.js` | Nuevo trait `container-gap` | Control granular del espacio entre elementos |
| `container.js` | Mejorado `updateGap()` | Maneja gaps personalizados |
| `container.js` | Mejorada sincronización de gap | Detecta gaps al cargar |

---

## Fórmula Segura

```
Ancho Total = Elemento1 + Gap + Elemento2 + Padding
           = 50% + 16px + 50% + padding
           ≤ 100% ✅
```

**Con `box-sizing: border-box`**: El padding NO suma, se calcula DENTRO.

---

## Debugging Rápido

Si algo se desborda:
1. Abre Inspector (F12)
2. Selecciona el contenedor
3. Revisa: `width`, `padding`, `flex-basis` de hijos
4. Verifica que hijos sumen ≤ 100%

---

## Ejemplo Práctico

### Crear una Galería de 2 Columnas
1. Insertar **Contenedor**
2. Propiedades:
   - **Espaciado entre Elementos**: `gap-6`
   - **Espaciado Interno**: `p-4`
3. Dentro, insertar 2 **Divisiones**
4. Cada división:
   - **Ancho**: `w-1/2`
   - Agregar contenido

**Resultado**: Dos columnas perfectas sin desbordamiento ✅

---

## Recordatorios Clave

- 🎯 **Gap** es para espacio ENTRE hijos
- 📍 **Padding** es para espacio DENTRO del borde
- 💫 **box-sizing: border-box** es lo que hace que funcione
- ✅ Tailwind ya lo incluye por defecto
- 🔄 Si hay overflow, reduce el ancho de los hijos o aumenta el gap

---

## Más Información

- Detalles completos: `/GUIA_ESPACIADO_CONTENEDORES.md`
- Cambios técnicos: `/RESUMEN_CAMBIOS_ESPACIADO.md`
