# Guía: Espaciado en Contenedores sin Overflow

## Problema
Cuando configuras dos elementos al 50% de ancho dentro de un contenedor y luego añades padding, el contenedor se desborda porque:
- **2 elementos × 50% ancho = 100%**
- **100% + padding = más del 100%** ❌

## Solución: Usar GAP en lugar de Padding

### ✅ CORRECTO: Espaciado entre elementos
```
Contenedor (100%)
├─ Elemento 1: 50% ancho
├─ GAP: 16px (espacio entre elementos)
└─ Elemento 2: 50% ancho
```

### ❌ INCORRECTO: Padding en el contenedor
```
Contenedor (100%) + padding = > 100%
├─ Elemento 1: 50% ancho
└─ Elemento 2: 50% ancho
```

## Cómo Configurar Correctamente

### Paso 1: Crear Contenedor Flexible
1. Inserta un **Contenedor**
2. En Propiedades → **Espaciado entre Elementos**: Selecciona `Gap Normal (16px)` o tu preferencia
3. En Propiedades → **Espaciado Interno (Border)**: Déjalo en `10px` (para separación del borde)

### Paso 2: Agregar Elementos Hijos
1. Dentro del contenedor, inserta dos elementos (ej: dos divisiones)
2. A cada elemento, configura: **Ancho Responsivo: w-1/2** (50%)

### Paso 3: Aplicar Estilos
```
┌─────────────────────────────────────┐
│  Contenedor (gap-4 = 16px)         │
│ ┌──────────┐  gap  ┌──────────┐    │
│ │Elemento 1│  16px │Elemento 2│    │
│ │   50%    │       │   50%    │    │
│ └──────────┘       └──────────┘    │
└─────────────────────────────────────┘
```

## Traits Disponibles

### 📌 Espaciado entre Elementos (Gap)
**Propósito**: Controla el espacio ENTRE elementos hijos
- `gap-0`: Sin espacio
- `gap-1`: 4px
- `gap-2`: 8px
- **`gap-4`: 16px ← Recomendado**
- `gap-6`: 24px
- `gap-8`: 32px
- `gap-10`: 40px
- `gap-12`: 48px

**Ventaja**: ✅ NO afecta el ancho total del contenedor

### 📌 Espaciado Interno (Border) - Padding
**Propósito**: Controla el espacio DENTRO del borde del contenedor
- `p-0`: Sin espaciado
- `p-2`: 8px
- `p-4`: 16px
- `p-6`: 24px
- `p-8`: 32px
- `p-12`: 48px

**Nota**: ✅ Ya usa `box-sizing: border-box` (no causa overflow)

### 📌 Margen Externo
**Propósito**: Espacio FUERA del contenedor
- `mx-auto`: Centrado horizontal

## Ejemplo Real

### ❌ Problema Original
```
Contenedor (w-full: 100%) 
├─ Padding: p-8 (32px)
├─ Elemento 1: w-1/2 (50%)
└─ Elemento 2: w-1/2 (50%)
= Desbordamiento porque 50% + 50% + padding > 100%
```

### ✅ Solución Correcta
```
Contenedor (w-full: 100%, gap-4: 16px)
├─ Padding: p-[10px] (borde interno)
├─ Elemento 1: w-1/2 (50%)
├─ GAP: 16px
└─ Elemento 2: w-1/2 (50%)
= Perfecto: 50% + 16px + 50% = 100% con espacio
```

## Mejoras CSS Aplicadas

### 1. `box-sizing: border-box` Global
El padding se calcula DENTRO del ancho, no FUERA:
```css
* {
  box-sizing: border-box;
}
```

### 2. `overflow: hidden` en Contenedores
Evita que elementos desbordados se visualicen:
```css
.container-flex {
  overflow: hidden;
}
```

### 3. `flex-shrink: 1` en Hijos
Permite que los elementos se ajusten si el espacio es insuficiente:
```css
.container-flex > * {
  flex-shrink: 1;
  min-width: 0;
}
```

## Checklist de Configuración

- [ ] Contenedor tiene `gap-X` configurado
- [ ] Elementos hijos tienen ancho especificado (ej: w-1/2)
- [ ] Padding está en `10px` (por defecto, correcto)
- [ ] En el navegador, los elementos se alinean sin desbordamiento
- [ ] En mobile, los elementos se apilan (verificar configuración responsiva)

## Debugging

Si aún hay overflow, verifica:
1. **Usa las Herramientas del Navegador** (F12 → Inspector)
2. **Busca el contenedor** y revisa su tamaño real
3. **Verifica el ancho de los elementos hijos**
4. **Comprueba que no hay padding/margin adicional** en JavaScript

## Fórmula Segura

```
Ancho Contenedor = 100%
Ancho Total Hijos = (número de hijos × ancho) + (número de gaps × gap-size)
Debe cumplir: Ancho Total Hijos ≤ 100%
```

### Ejemplo:
- 2 elementos × 50% = 100%
- 1 gap × 16px = 16px
- **Total = 100% + 16px** ❌

**Solución**: Usar ancho menor:
- 2 elementos × 47% = 94%
- 1 gap × 16px = 16px
- **Total = 94% + 16px = 110%** (aún hay desbordamiento)

**Alternativa mejor**: Usar flex-basis:
- Configurar elementos con `flex: 1` para que se distribuyan automáticamente
