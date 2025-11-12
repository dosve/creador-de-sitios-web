# Diagramas de Flujo del Sistema

## Diagrama 1: Flujo de Autenticación

```
┌─────────────────────────────────────────────────────────────────┐
│                     USUARIO EN LA TIENDA                        │
└────────────────────────┬────────────────────────────────────────┘
                         │
                         ▼
              ┌──────────────────────┐
              │  ¿Tiene cuenta en    │
              │   AdminNegocios?     │
              └──────┬───────┬───────┘
                     │       │
          SÍ ────────┘       └──────── NO
          │                            │
          ▼                            ▼
  ┌───────────────┐          ┌─────────────────┐
  │ Clic en       │          │ Clic en         │
  │ "Iniciar      │          │ "Registrarse"   │
  │  Sesión"      │          │                 │
  └───────┬───────┘          └────────┬────────┘
          │                           │
          ▼                           ▼
  ┌───────────────┐          ┌─────────────────┐
  │ POST          │          │ POST            │
  │ /customer/    │          │ /customer/      │
  │ login         │          │ register        │
  └───────┬───────┘          └────────┬────────┘
          │                           │
          ▼                           ▼
  ┌───────────────────────────────────────────┐
  │  Validar contra API de AdminNegocios      │
  └───────────────┬───────────────────────────┘
                  │
        ┌─────────┴─────────┐
        │                   │
    VÁLIDO            INVÁLIDO
        │                   │
        ▼                   ▼
  ┌─────────────┐    ┌──────────────┐
  │ Crear/      │    │ Mostrar      │
  │ Actualizar  │    │ Error        │
  │ en          │    └──────────────┘
  │ website_    │
  │ customers   │
  └──────┬──────┘
         │
         ▼
  ┌──────────────┐
  │ Guardar en   │
  │ Sesión       │
  │ Laravel      │
  └──────┬───────┘
         │
         ▼
  ┌──────────────┐
  │ Usuario      │
  │ Autenticado  │
  └──────────────┘
```

## Diagrama 2: Flujo de Checkout (Usuario Autenticado)

```
┌─────────────────────────────────────────────────────────────────┐
│              USUARIO AUTENTICADO EN LA TIENDA                   │
└────────────────────────┬────────────────────────────────────────┘
                         │
                         ▼
              ┌──────────────────────┐
              │ Agrega productos     │
              │ al carrito           │
              └──────────┬───────────┘
                         │
                         ▼
              ┌──────────────────────┐
              │ Va al Checkout       │
              └──────────┬───────────┘
                         │
                         ▼
              ┌──────────────────────┐
              │ Datos pre-llenados   │
              │ automáticamente      │
              └──────────┬───────────┘
                         │
                         ▼
              ┌──────────────────────┐
              │ Confirma dirección   │
              │ y método de pago     │
              └──────────┬───────────┘
                         │
                         ▼
              ┌──────────────────────────────┐
              │ POST /{website}/checkout/    │
              │ process                      │
              └──────────┬───────────────────┘
                         │
                         ▼
  ┌────────────────────────────────────────────────────┐
  │          SERVIDOR - CheckoutController             │
  └────────────────────┬───────────────────────────────┘
                       │
                       ▼
        ┌──────────────────────────┐
        │ Buscar/Actualizar        │
        │ Customer con             │
        │ admin_negocios_id        │
        └──────────┬───────────────┘
                   │
                   ▼
        ┌──────────────────────────┐
        │ Crear Order en tabla     │
        │ orders (local)           │
        └──────────┬───────────────┘
                   │
                   ▼
        ┌──────────────────────────┐
        │ Crear OrderItems         │
        └──────────┬───────────────┘
                   │
                   ▼
        ┌──────────────────────────┐
        │ ¿Tiene API de            │
        │ AdminNegocios?           │
        └──────┬─────────┬─────────┘
               │         │
           SÍ ─┘         └─ NO
           │                 │
           ▼                 │
  ┌────────────────┐         │
  │ Enviar orden   │         │
  │ a AdminNegocios│         │
  └────────┬───────┘         │
           │                 │
           ▼                 │
  ┌────────────────┐         │
  │ Guardar        │         │
  │ admin_negocios_│         │
  │ order_id       │         │
  └────────┬───────┘         │
           │                 │
           └────────┬────────┘
                    │
                    ▼
         ┌──────────────────┐
         │ Actualizar       │
         │ website_customers│
         │ (total_orders,   │
         │  total_spent)    │
         └──────┬───────────┘
                │
                ▼
         ┌──────────────────┐
         │ Devolver respuesta│
         │ con order_number  │
         └──────┬───────────┘
                │
                ▼
         ┌──────────────────┐
         │ Mostrar          │
         │ confirmación     │
         └──────────────────┘
```

## Diagrama 3: Flujo de Checkout (Usuario Invitado)

```
┌─────────────────────────────────────────────────────────────────┐
│              USUARIO NO AUTENTICADO (INVITADO)                  │
└────────────────────────┬────────────────────────────────────────┘
                         │
                         ▼
              ┌──────────────────────┐
              │ Agrega productos     │
              │ al carrito           │
              └──────────┬───────────┘
                         │
                         ▼
              ┌──────────────────────┐
              │ Va al Checkout       │
              └──────────┬───────────┘
                         │
                         ▼
              ┌──────────────────────┐
              │ Debe llenar todos    │
              │ los datos manualmente│
              └──────────┬───────────┘
                         │
                         ▼
              ┌──────────────────────┐
              │ Ingresa: nombre,     │
              │ email, teléfono,     │
              │ dirección, pago      │
              └──────────┬───────────┘
                         │
                         ▼
              ┌──────────────────────────────┐
              │ POST /{website}/checkout/    │
              │ process                      │
              └──────────┬───────────────────┘
                         │
                         ▼
  ┌────────────────────────────────────────────────────┐
  │          SERVIDOR - CheckoutController             │
  └────────────────────┬───────────────────────────────┘
                       │
                       ▼
        ┌──────────────────────────┐
        │ Crear Customer con       │
        │ is_authenticated=false   │
        │ admin_negocios_id=null   │
        └──────────┬───────────────┘
                   │
                   ▼
        ┌──────────────────────────┐
        │ Crear Order en tabla     │
        │ orders (local)           │
        └──────────┬───────────────┘
                   │
                   ▼
        ┌──────────────────────────┐
        │ Crear OrderItems         │
        └──────────┬───────────────┘
                   │
                   ▼
        ┌──────────────────────────┐
        │ Intentar enviar a        │
        │ AdminNegocios (opcional) │
        └──────────┬───────────────┘
                   │
                   ▼
         ┌──────────────────┐
         │ Devolver respuesta│
         │ con order_number  │
         └──────┬───────────┘
                │
                ▼
         ┌──────────────────┐
         │ Mostrar          │
         │ confirmación     │
         └──────────────────┘
```

## Diagrama 4: Relación de Tablas

```
┌───────────────────────────────────────────────────────────────────┐
│                    BASE DE DATOS LOCAL                            │
└───────────────────────────────────────────────────────────────────┘

┌─────────────────┐         ┌─────────────────┐         ┌──────────────┐
│    websites     │         │   customers     │         │    orders    │
├─────────────────┤         ├─────────────────┤         ├──────────────┤
│ • id (PK)       │◄───────┤ • id (PK)       │◄───────┤ • id (PK)    │
│ • name          │         │ • website_id    │         │ • website_id │
│ • slug          │         │ • name          │         │ • customer_id│
│ • api_base_url  │         │ • email         │         │ • order_     │
│ • api_key       │         │ • phone         │         │   number     │
└─────────┬───────┘         │ • admin_        │         │ • total      │
          │                 │   negocios_id   │         │ • admin_     │
          │                 │ • is_           │         │   negocios_  │
          │                 │   authenticated │         │   order_id   │
          │                 └─────────────────┘         └──────┬───────┘
          │                                                     │
          │                                                     │
          │                 ┌─────────────────┐                │
          │                 │ order_items     │                │
          │                 ├─────────────────┤                │
          │                 │ • id (PK)       │◄───────────────┘
          │                 │ • order_id      │
          │                 │ • product_id    │
          │                 │ • product_name  │
          │                 │ • quantity      │
          │                 │ • price         │
          │                 │ • total         │
          │                 └─────────────────┘
          │
          │
          │                 ┌──────────────────────┐
          └────────────────►│ website_customers    │
                            ├──────────────────────┤
                            │ • id (PK)            │
                            │ • website_id         │
                            │ • admin_negocios_    │
                            │   user_id            │
                            │ • email              │
                            │ • name               │
                            │ • first_login_at     │
                            │ • last_login_at      │
                            │ • first_purchase_at  │
                            │ • last_purchase_at   │
                            │ • total_orders       │
                            │ • total_spent        │
                            └──────────────────────┘

┌───────────────────────────────────────────────────────────────────┐
│           BASE DE DATOS ADMINNEGOCIOS (EXTERNA)                   │
└───────────────────────────────────────────────────────────────────┘

                            ┌──────────────────────┐
                            │ users                │
                            ├──────────────────────┤
                            │ • id (PK)            │
                            │ • name               │
                            │ • email              │
                            │ • password           │
                            │ • phone              │
                            └──────────────────────┘
                                      ▲
                                      │
                                      │ Se vincula a través de
                                      │ admin_negocios_user_id
                                      │
```

## Diagrama 5: Ciclo de Vida de una Sesión de Cliente

```
┌──────────────────────────────────────────────────────────────┐
│                    CICLO DE VIDA DE SESIÓN                   │
└──────────────────────────────────────────────────────────────┘

1. LOGIN
   ├─ POST /customer/login
   ├─ Valida contra AdminNegocios
   ├─ Crea/actualiza website_customers
   ├─ Registra first_login_at o last_login_at
   └─ Guarda en Sesión Laravel:
      ├─ customer_logged_in = true
      ├─ customer_id = [id en website_customers]
      ├─ customer_admin_negocios_id = [id en AdminNegocios]
      ├─ customer_token = [JWT token]
      └─ customer_data = [datos del usuario]

2. NAVEGACIÓN
   ├─ Cada petición verifica la sesión
   ├─ GET /customer/check
   └─ Si sesión válida → continuar
      Si no → mostrar login

3. CHECKOUT
   ├─ Datos pre-llenados desde customer_data
   ├─ POST /{website}/checkout/process
   ├─ Usa customer_admin_negocios_id para vincular
   └─ Actualiza estadísticas en website_customers

4. LOGOUT
   ├─ POST /customer/logout
   └─ Limpia sesión Laravel:
      ├─ Remueve customer_logged_in
      ├─ Remueve customer_id
      ├─ Remueve customer_admin_negocios_id
      ├─ Remueve customer_token
      └─ Remueve customer_data

┌────────────────────────────────────────────────────────┐
│              DATOS EN SESIÓN LARAVEL                   │
├────────────────────────────────────────────────────────┤
│                                                        │
│  Session::put('customer_logged_in', true)             │
│  Session::put('customer_id', 1)                       │
│  Session::put('customer_admin_negocios_id', 123)      │
│  Session::put('customer_token', 'eyJ0eXAi...')        │
│  Session::put('customer_data', [                      │
│      'id' => 123,                                     │
│      'email' => 'cliente@ejemplo.com',                │
│      'name' => 'Juan Pérez',                          │
│      'phone' => '3001234567'                          │
│  ])                                                   │
│                                                        │
└────────────────────────────────────────────────────────┘
```

## Diagrama 6: Sincronización con AdminNegocios

```
┌─────────────────────────────────────────────────────────────────┐
│               SINCRONIZACIÓN CON ADMINNEGOCIOS                  │
└─────────────────────────────────────────────────────────────────┘

ORDEN CREADA EN CREADOR DE TIENDAS
         │
         ▼
┌─────────────────────┐
│ ¿Tiene api_base_url │
│ y api_key?          │
└──────┬──────┬───────┘
       │      │
    SÍ │      │ NO → TERMINAR (orden solo local)
       │      │
       ▼      │
┌──────────────────────┐
│ Preparar datos:      │
│ • customer_id        │
│ • items[]            │
│ • shipping_address   │
│ • total              │
└──────┬───────────────┘
       │
       ▼
┌──────────────────────┐
│ POST                 │
│ {api_url}/segundos/  │
│ pedidos              │
└──────┬──────┬────────┘
       │      │
  ÉXITO│      │ERROR
       │      │
       ▼      ▼
┌──────────┐  ┌────────────────┐
│ Guardar  │  │ Log del error  │
│ admin_   │  │ Orden queda    │
│ negocios_│  │ solo local     │
│ order_id │  └────────────────┘
└──────┬───┘
       │
       ▼
┌──────────────────────┐
│ Orden sincronizada   │
│ en ambos sistemas    │
└──────────────────────┘


VENTAJAS DE LA SINCRONIZACIÓN:
┌─────────────────────────────────────────────────────────┐
│ ✓ Centralización de datos en AdminNegocios             │
│ ✓ Gestión unificada de inventario                      │
│ ✓ Reportes consolidados                                │
│ ✓ Sincronización de estados de orden                   │
│ ✓ Facturación desde un solo lugar                      │
└─────────────────────────────────────────────────────────┘
```

## Diagrama 7: Estadísticas en website_customers

```
┌──────────────────────────────────────────────────────────────┐
│           ESTADÍSTICAS POR USUARIO EN CADA TIENDA            │
└──────────────────────────────────────────────────────────────┘

USUARIO: cliente@ejemplo.com (ID AdminNegocios: 123)

TIENDA A (mi-tienda-ropa)
┌──────────────────────────────────────┐
│ first_login_at:    2025-01-15        │
│ last_login_at:     2025-11-05        │
│ first_purchase_at: 2025-01-20        │
│ last_purchase_at:  2025-10-28        │
│ total_orders:      12                │
│ total_spent:       $850,000 COP      │
└──────────────────────────────────────┘

TIENDA B (mi-tienda-tecnologia)
┌──────────────────────────────────────┐
│ first_login_at:    2025-03-10        │
│ last_login_at:     2025-11-03        │
│ first_purchase_at: 2025-03-15        │
│ last_purchase_at:  2025-11-01        │
│ total_orders:      5                 │
│ total_spent:       $1,200,000 COP    │
└──────────────────────────────────────┘

ANÁLISIS DISPONIBLE:
┌────────────────────────────────────────────────────────┐
│ • Usuarios más activos por tienda                     │
│ • Top compradores (por monto)                         │
│ • Usuarios con múltiples compras                      │
│ • Usuarios inactivos (no han comprado en X días)      │
│ • Valor promedio de compra por usuario                │
│ • Frecuencia de compra                                │
│ • Usuarios nuevos vs recurrentes                      │
└────────────────────────────────────────────────────────┘
```

## Diagrama 8: Seguridad y Validación

```
┌──────────────────────────────────────────────────────────────┐
│                  CAPAS DE SEGURIDAD                          │
└──────────────────────────────────────────────────────────────┘

FRONTEND
├─ CSRF Token en todos los formularios
├─ Validación de campos antes de enviar
└─ HTTPS (recomendado en producción)
         │
         ▼
SERVIDOR LARAVEL
├─ Validación de Request (rules)
├─ Verificación de sesión
├─ Sanitización de datos
└─ Autorización (verificar que el usuario
   │ solo puede ver sus propias órdenes)
   │
   ▼
API ADMINNEGOCIOS
├─ Validación de credenciales
├─ Rate limiting (límite de intentos)
├─ JWT Token para sesiones
└─ Verificación de permisos
         │
         ▼
BASE DE DATOS
├─ Índices únicos (email, website_id)
├─ Foreign keys con onDelete cascade
└─ Datos sensibles encriptados


NO SE ALMACENA EN CREADOR DE TIENDAS:
┌──────────────────────────────────┐
│ ✗ Contraseñas                    │
│ ✗ Tokens de pago                 │
│ ✗ Información bancaria           │
│ ✗ Datos sensibles personales     │
└──────────────────────────────────┘

SÍ SE ALMACENA:
┌──────────────────────────────────┐
│ ✓ Email                          │
│ ✓ Nombre                         │
│ ✓ Teléfono                       │
│ ✓ Dirección de envío             │
│ ✓ Historial de compras           │
│ ✓ Estadísticas                   │
└──────────────────────────────────┘
```

---

Estos diagramas te ayudarán a entender visualmente cómo funciona el sistema completo de autenticación y checkout.

