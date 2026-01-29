# Estructura de componentes del editor para páginas

## Reglas

### 1. Contenedor (container)
- **Clase obligatoria:** `container-flex`
- **Uso:** Agrupar y organizar contenido. Es **droppable**: dentro van heading, párrafo, botón, imagen, otros contenedores.
- **No** usar `div` genéricos para estructura. Cualquier wrapper que agrupe componentes debe ser `container-flex`.
- Si usas un `div` sin `container-flex` que envuelve texto/otros elementos, el editor puede interpretarlo como **text** y romper la estructura.

### 2. Título (heading)
- **Clase:** `heading-component`
- **Etiqueta:** `h1`, `h2`, `h3`, `h4`
- **Uso:** Un título por componente. El texto va **dentro** del heading (contenido del nodo).
- **No** anidar otros componentes dentro.

### 3. Párrafo (paragraph)
- **Clase:** `paragraph-component`
- **Etiqueta:** `p`
- **Uso:** Un bloque de texto por componente. El texto va **dentro** del párrafo.
- **No** anidar otros componentes dentro.

### 4. Componente texto (text)
- **Clase:** `text-component`
- **Uso:** Bloque de texto genérico (div). **No** usar para secciones que agrupan título + párrafo + botón.
- Esos grupos deben ir en un **contenedor**, y dentro del contenedor: **heading**, **paragraph**, **button**.

### 5. Botón (button)
- **Clase:** `button-component`
- **Etiqueta:** `a` o `button`
- **Uso:** Enlaces y CTAs. Texto dentro del nodo.

### 6. Imagen (image)
- **Clase:** `image-component` (opcional; todo `img` se reconoce)
- **Etiqueta:** `img`

### 7. Imagen de fondo (background-image)
- **Clase:** `background-image-section` y `data-gjs-type="background-image"`
- **Uso:** Hero con imagen de fondo. Acepta **un** título, **un** texto y **un** botón (traits).
- El overlay debe usar **contenedores** (`container-flex`) para el contenido, no `div` sueltos.

## Estructura correcta por sección

```
container (container-flex)     ← sección
├── container (container-flex) ← fila/columna si hace falta
│   ├── heading (heading-component)
│   ├── paragraph (paragraph-component)
│   ├── button (button-component)
│   └── …
```

- **Contenedor** agrupa.
- **Heading**, **paragraph**, **button** son hijos del contenedor, no al revés.
- **No** poner párrafos ni títulos dentro de un **text**; usar **paragraph** y **heading**.

## Seeders (Lyman, etc.)

El HTML que generan los seeders debe seguir esta estructura:
- Todos los wrappers = `container-flex`.
- Títulos = `heading-component`, párrafos = `paragraph-component`, botones = `button-component`, imágenes = `image-component` o `img`.
- Evitar `div` sin `container-flex` que agrupe contenido.
