# 📊 Diagrama de Flujo: Duplicar Sitio Web

## Flujo de Usuario

```
┌─────────────────────────────────────────────────────────────────┐
│                    Dashboard del Creador                         │
│                  (Sitio web seleccionado)                        │
└────────────────────────────┬──────────────────────────────────────┘
                             │
                             ▼
                  ┌──────────────────────┐
                  │ Header del Sitio Web │
                  │                      │
                  │ [Duplicar] [Editar]  │
                  └──────────┬───────────┘
                             │
                    (Usuario hace clic)
                             │
                             ▼
            ┌────────────────────────────────┐
            │ GET /websites/{id}/duplicate   │
            │  → showDuplicate()             │
            └────────────┬───────────────────┘
                         │
                         ▼
            ┌────────────────────────────────┐
            │  Mostrar Formulario            │
            │  - Nombre (con sugerencia)     │
            │  - Slug (opcional)             │
            │  - Resumen de qué se copia     │
            └────────────┬───────────────────┘
                         │
              (Usuario llena y envía)
                         │
                         ▼
            ┌────────────────────────────────┐
            │ POST /websites/{id}/duplicate  │
            │  → duplicate()                 │
            └────────────┬───────────────────┘
                         │
                         ▼
            ┌────────────────────────────────┐
            │  Validar entrada               │
            │  - name (requerido)            │
            │  - slug (único si existe)      │
            └────────────┬───────────────────┘
                         │
                ┌────────┴─────────┐
                │                  │
            ✅ OK             ❌ Error
                │                  │
                ▼                  ▼
         (Continuar)        (Volver atrás
                            con errores)
```

## Flujo de Lógica de Negocio

```
┌──────────────────────────────────────────────────────────────┐
│           DuplicateWebsiteService::duplicate()                │
└────────────────────┬─────────────────────────────────────────┘
                     │
          INICIO TRANSACCIÓN DB
                     │
        ┌────────────┴────────────┐
        │                         │
        ▼                         ▼
   1. Crear Website        2. Validar slug
   (is_published=false)       (único)
        │                     │
        └────────────┬────────┘
                     │
                     ▼
          3. Duplicar Categorías
          ├─ Crear nuevas
          ├─ Mapear IDs
          └─ Slug único
                     │
                     ▼
          4. Duplicar Etiquetas
          ├─ Crear nuevas
          ├─ Mapear IDs
          └─ Slug único
                     │
                     ▼
          5. Duplicar Páginas
          ├─ Crear nuevas
          ├─ Copiar contenido HTML
          ├─ Mapear IDs
          └─ Slug único
                     │
                     ▼
          6. Duplicar Blog Posts
          ├─ Crear nuevos posts
          ├─ Sincronizar etiquetas
          ├─ Mapear IDs
          └─ Slug único
                     │
                     ▼
          7. Duplicar Menús
          ├─ Crear nuevos menús
          ├─ Crear items del menú
          └─ Referenciar páginas
                     │
                     ▼
          8. Duplicar Componentes
          ├─ Crear nuevos
          ├─ Copiar contenido
          └─ Slug único
                     │
        ┌────────────┴────────────┐
        │                         │
        ▼                         ▼
   ✅ COMMIT            ❌ ROLLBACK
    (Todo OK)           (Error detectado)
        │                    │
        ▼                    ▼
   Retornar           Lanzar excepción
   $newWebsite             │
        │                  ▼
        │         Mostrar error al usuario
        │
        ▼
  Redirigir a sitios
  con mensaje de éxito
```

## Estructura de Datos: Mapeo de IDs

```
SITIO ORIGINAL                    →  SITIO DUPLICADO
─────────────────────────────────────────────────────

Categoría: 1                      →  Categoría: 25
Categoría: 2                      →  Categoría: 26
Categoría: 3                      →  Categoría: 27
│
├─ Etiqueta: 10                  →  Etiqueta: 40
├─ Etiqueta: 11                  →  Etiqueta: 41
│
├─ Página: 100 (Inicio)          →  Página: 150
│  ├─ slug: home                 →  slug: home
│  ├─ contenido: <html>...</html>→  contenido: <html>...</html>
│  ├─ is_published: true         →  is_published: false
│  │
│  └─ Menú: 5 (Principal)        →  Menú: 8
│     ├─ Items:                  →  ├─ Items:
│     │  ├─ Label: "Inicio"      │  │  ├─ Label: "Inicio"
│     │  │  page_id: 100         │  │  │  page_id: 150
│     │  ├─ Label: "Nosotros"    │  │  ├─ Label: "Nosotros"
│     │  │  page_id: 101         │  │  │  page_id: 151
│     │  └─ Label: "Contacto"    │  │  └─ Label: "Contacto"
│     │     page_id: 102         │  │     page_id: 152
│
├─ Página: 101 (Nosotros)        →  Página: 151
│  └─ slug: nosotros             →  slug: nosotros
│
├─ Página: 102 (Contacto)        →  Página: 152
│  └─ slug: contacto             →  slug: contacto
│
└─ Blog Post: 1000               →  Blog Post: 2000
   ├─ slug: primer-articulo      →  slug: primer-articulo
   ├─ category_id: 1             →  category_id: 25 (mapeado)
   ├─ Etiquetas:                 →  Etiquetas:
   │  ├─ 10                      │  ├─ 40 (mapeado)
   │  └─ 11                      │  └─ 41 (mapeado)
   └─ contenido: <html>...</html>→  contenido: <html>...</html>
```

## Validaciones en Flujo

```
INPUT → VALIDACIÓN → DECISIÓN

┌──────────────┐
│ Nombre vacío │
└──────┬───────┘
       │
       ▼
   Validar (SERVER)
       │
    ❌ Error
       │
       ▼
   Mostrar mensaje
   "El nombre es requerido"
       │
       ▼
   Volver al formulario
       └─ preservar datos

┌──────────────────┐
│ Slug duplicado   │
└──────┬───────────┘
       │
       ▼
   Validar en DB
       │
    ❌ Error
       │
       ▼
   Mostrar mensaje
   "El slug ya existe"
       │
       ▼
   Volver al formulario
       └─ mostrar error específico

┌──────────────────┐
│ Todo válido      │
└──────┬───────────┘
       │
       ▼
   Iniciar transacción
       │
       ▼
   Duplicar datos
       │
       ├─ ✅ OK → Commit
       │         └─ Redirigir con éxito
       │
       └─ ❌ Error → Rollback
                     └─ Mostrar error
```

## Estados de Sitio Web

```
Sitio Original          →  Sitio Duplicado
═════════════════════════════════════════════

is_published: true      →  is_published: false
slug: "tienda-online"   →  slug: "tienda-online-1"
user_id: 1              →  user_id: 1 (mismo usuario)
created_at: 2024-01-15  →  created_at: 2024-02-02
updated_at: 2024-02-01  →  updated_at: 2024-02-02

┌─ Páginas (10)          ├─ Páginas (10)
│  ├─ id: 100-109        │  ├─ id: 150-159
│  ├─ website_id: 1      │  ├─ website_id: nuevo
│  └─ is_published: true │  └─ is_published: false
│
├─ Menús (5)             ├─ Menús (5)
│  └─ Items (15)         │  └─ Items (15)
│
├─ Posts (20)            ├─ Posts (20)
│  ├─ category_id: mapeado
│  └─ tags: sincronizadas
│
└─ Categorías (3)        └─ Categorías (3)
   └─ Etiquetas (10)        └─ Etiquetas (10)
      └─ Mapeo IDs          └─ Mapeo IDs
```

## Timeline de Ejecución

```
T0:   Usuario hace clic en "Duplicar"
      └─ Navegador → GET /websites/{id}/duplicate

T1:   Servidor procesa GET
      ├─ Verifica autorización (Auth::check)
      ├─ Verifica permiso (puede_ver_sitio)
      └─ Renderiza vista con datos del sitio

T2:   Navegador muestra formulario
      └─ Usuario llena datos

T3:   Usuario hace clic en "Duplicar Sitio Web"
      └─ Formulario envía → POST /websites/{id}/duplicate

T4:   Servidor recibe POST
      ├─ CSRF token check ✓
      ├─ Validar entrada
      ├─ Iniciar transacción DB
      ├─ Crear nuevo Website
      ├─ Duplicar Categorías (0.1s)
      ├─ Duplicar Etiquetas (0.1s)
      ├─ Duplicar Páginas (0.2s)
      ├─ Duplicar BlogPosts (0.2s)
      ├─ Duplicar Menús (0.1s)
      ├─ Duplicar Componentes (0.1s)
      ├─ Commit transacción (0.5s)
      └─ Total: ~1.3 segundos

T5:   Servidor responde
      └─ Redirect con mensaje de éxito

T6:   Navegador recibe redirect
      └─ Usuario ve nuevo sitio en lista ✨
```

## Puntos de Fallo y Recuperación

```
PUNTO DE FALLO          ACCIONES
════════════════════════════════════════════════════

❌ Validación fallida
   ├─ Nombre vacío
   ├─ Slug duplicado
   ├─ Nombre muy largo
   └─ Recuperación: Mostrar error, volver atrás

❌ Error en transacción
   ├─ Error al crear Website
   ├─ Error al duplicar categorías
   ├─ Error de conexión DB
   └─ Recuperación: ROLLBACK automático

❌ Error de permiso
   ├─ Usuario no es propietario
   ├─ Usuario no está autenticado
   └─ Recuperación: Denegar acceso (403/401)

❌ Error de servidor (500)
   ├─ Exception no capturada
   ├─ OutOfMemory
   └─ Recuperación: Mensaje genérico, log en Laravel
```

## Checklist de QA

```
[ ] Duplicación sin errores
[ ] Verificar cantidad de registros
[ ] Verificar relaciones (tags en posts)
[ ] Verificar slugs únicos
[ ] Verificar nuevo sitio en lista
[ ] Verificar estado = BORRADOR
[ ] Verificar contenido idéntico
[ ] Validar con nombre duplicado (error esperado)
[ ] Validar con slug duplicado (error esperado)
[ ] Validar sin nombre (error esperado)
[ ] Probar con sitio vacío
[ ] Probar con sitio con muchos datos
```
