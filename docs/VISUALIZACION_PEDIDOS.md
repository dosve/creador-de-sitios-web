# Visualización de Pedidos del Usuario

## Descripción General

El sistema permite a los usuarios autenticados ver todos sus pedidos históricos, con información detallada de cada orden, estados, productos comprados, direcciones de envío y resumen de pagos.

## Acceso al Sistema

### 1. Desde el Header
Los usuarios pueden acceder a sus pedidos desde el ícono de usuario en el header:

```
Header → [👤 Usuario ▼] → Mis Órdenes
```

### 2. URL Directa
```
/{website-slug}/my-orders
```

**Ejemplo:**
```
https://creadorweb.eme10.com/mi-tienda/my-orders
```

### 3. Requisitos
- ✅ Usuario debe estar autenticado
- ✅ Si no está autenticado, se redirige al login

## Pantalla: Mis Órdenes

### Vista General

La página "Mis Órdenes" muestra:

#### Header de la Página
- **Título:** "Mis Órdenes"
- **Descripción:** "Revisa el estado y detalles de tus compras"

#### Tarjetas de Órdenes
Cada orden se muestra en una tarjeta que incluye:

1. **Información Principal**
   - Número de orden (ej: #ORD20251108001)
   - Fecha y hora de creación

2. **Estados**
   - **Estado de la orden:** Pendiente, Procesando, Enviado, Entregado, Cancelado
   - **Estado del pago:** Pendiente, Pagado, Fallido, Reembolsado

3. **Productos**
   - Lista de todos los productos con cantidad y precio

4. **Total**
   - Total a pagar (grande y destacado)
   - Moneda

5. **Acciones**
   - Botón "Ver Detalles"

### Diseño de Estados

#### Estados de Orden

| Estado | Color | Ícono | Descripción |
|--------|-------|-------|-------------|
| Pendiente | Amarillo | ⏳ | Esperando procesamiento |
| Procesando | Azul | 🔄 | En proceso |
| Enviado | Morado | 📦 | En camino |
| Entregado | Verde | ✅ | Recibido |
| Cancelado | Rojo | ❌ | Cancelado |

#### Estados de Pago

| Estado | Color | Ícono | Descripción |
|--------|-------|-------|-------------|
| Pendiente | Amarillo | 💳 | Esperando pago |
| Pagado | Verde | ✓ | Pagado exitosamente |
| Fallido | Rojo | ✗ | Pago no procesado |
| Reembolsado | Gris | ↩ | Dinero devuelto |

### Estado Vacío

Si el usuario no tiene órdenes, se muestra:

```
┌─────────────────────────────────┐
│         [Ícono de Bolsa]        │
│                                 │
│  No tienes órdenes aún          │
│                                 │
│  Comienza a explorar nuestros   │
│  productos y realiza tu         │
│  primera compra                 │
│                                 │
│    [Ir a la Tienda]             │
└─────────────────────────────────┘
```

### Paginación

- Las órdenes se muestran de **10 en 10**
- Ordenadas por fecha (más reciente primero)
- Paginación en la parte inferior

## Pantalla: Detalle de Orden

### Acceso
Al hacer clic en "Ver Detalles" de cualquier orden:

```
/{website-slug}/order/{order-number}
```

**Ejemplo:**
```
https://creadorweb.eme10.com/mi-tienda/order/ORD20251108001
```

### Estructura de la Página

#### 1. Breadcrumb
```
← Volver a Mis Órdenes
```

#### 2. Header
- Número de orden (destacado)
- Fecha y hora completa
- Estados (orden y pago)

#### 3. Sección de Productos
**Detalles de cada producto:**
- Imagen (placeholder si no hay)
- Nombre del producto
- Cantidad
- Precio unitario
- Total por producto

**Visual:**
```
┌────────────────────────────────────────┐
│ Productos                              │
├────────────────────────────────────────┤
│ [IMG] Producto 1           x2  $50,000 │
│       Precio unitario: $25,000         │
│                                        │
│ [IMG] Producto 2           x1  $30,000 │
│       Precio unitario: $30,000         │
└────────────────────────────────────────┘
```

#### 4. Información de Envío

**Dos columnas:**

##### Dirección de Envío
- Calle
- Ciudad, Departamento
- Código Postal
- País

##### Dirección de Facturación
- Calle
- Ciudad, Departamento
- Código Postal
- País

#### 5. Información del Cliente

**Grid con 4 campos:**
- Nombre
- Email
- Teléfono
- Método de Pago

**Notas adicionales** (si existen)

#### 6. Sidebar - Resumen (derecha)

```
┌─────────────────────────┐
│ Resumen de Orden        │
├─────────────────────────┤
│ Subtotal     $80,000    │
│ Impuestos    $15,200    │
│ Envío        $10,000    │
├─────────────────────────┤
│ Total        $105,200   │
│              COP        │
├─────────────────────────┤
│ [Pagar Ahora]          │  ← Solo si pago pendiente
│ [Continuar Comprando]   │
└─────────────────────────┘
```

### Seguridad

El usuario solo puede ver órdenes que le pertenecen:

1. **Usuario Autenticado:** Se valida por `admin_negocios_id`
2. **Usuario Invitado:** Se valida por email (si se proporciona)
3. **Sin acceso:** Error 403 "No tienes acceso a esta orden"

## Código de Ejemplo

### Listar Órdenes

```php
// CheckoutController@myOrders
$orders = Order::where('website_id', $website->id)
    ->whereHas('customer', function($query) use ($customerAdminNegociosId) {
        $query->where('admin_negocios_id', $customerAdminNegociosId);
    })
    ->with(['customer', 'items'])
    ->orderBy('created_at', 'desc')
    ->paginate(10);
```

### Ver Detalle de Orden

```php
// CheckoutController@showOrder
$order = Order::where('website_id', $website->id)
    ->where('order_number', $orderNumber)
    ->with(['customer', 'items'])
    ->first();

// Validar acceso
if ($order->customer->admin_negocios_id != $customerAdminNegociosId) {
    abort(403, 'No tienes acceso a esta orden');
}
```

## Rutas

### Mis Órdenes (Lista)
```
GET /{website_slug}/my-orders
```

**Middleware:** Verifica autenticación

**Respuesta:** Vista con lista de órdenes paginadas

### Detalle de Orden
```
GET /{website_slug}/order/{order_number}
```

**Middleware:** Verifica autenticación y acceso

**Respuesta:** Vista con detalles completos de la orden

## Formato de Datos

### Dirección (JSON en BD)
```json
{
  "address": "Calle 123 #45-67",
  "city": "Bogotá",
  "state": "Cundinamarca",
  "postal_code": "110111",
  "country": "Colombia"
}
```

### Items de Orden
```php
[
  {
    "id": 1,
    "product_id": 123,
    "product_name": "Producto 1",
    "quantity": 2,
    "price": 25000,
    "total": 50000
  }
]
```

## Responsive Design

### Desktop (> 768px)
- Diseño de 2-3 columnas
- Sidebar fijo en scroll
- Información completa visible

### Tablet (768px - 1024px)
- Diseño de 2 columnas
- Cards ajustadas
- Sidebar debajo del contenido

### Mobile (< 768px)
- Diseño de 1 columna
- Cards ocupan ancho completo
- Texto ajustado para legibilidad
- Botones en bloque

## Características Especiales

### 1. **Auto-actualización de Estados**
Los estados se actualizan automáticamente cuando AdminNegocios actualiza la orden.

### 2. **Formato de Números**
```php
${{ number_format($order->total, 0, ',', '.') }}
// Resultado: $150.000
```

### 3. **Fechas Legibles**
```php
{{ $order->created_at->format('d/m/Y H:i') }}
// Resultado: 08/11/2025 14:30
```

### 4. **Links Contextuales**
- "Volver a Mis Órdenes"
- "Continuar Comprando"
- "Ir a la Tienda" (si no hay órdenes)

## Mejoras Futuras

### Funcionalidades Sugeridas

1. **Filtros**
   - Por estado de orden
   - Por estado de pago
   - Por fecha

2. **Búsqueda**
   - Por número de orden
   - Por producto

3. **Seguimiento**
   - Tracking de envío
   - Timeline de estados
   - Notificaciones por email

4. **Acciones**
   - Descargar factura PDF
   - Solicitar reembolso
   - Contactar soporte
   - Repetir orden (comprar los mismos productos)

5. **Filtros Rápidos**
   - Ver solo pendientes
   - Ver solo completadas
   - Ver últimos 30 días

### Ejemplo de Timeline (futura)

```
┌─────────────────────────────────┐
│ Estado de tu Pedido             │
├─────────────────────────────────┤
│ ● Pedido Realizado             │
│   08/11/2025 14:30              │
│   |                             │
│ ● Pago Confirmado              │
│   08/11/2025 14:35              │
│   |                             │
│ ● En Preparación               │
│   08/11/2025 16:00              │
│   |                             │
│ ○ Enviado                      │
│   Estimado: 09/11/2025          │
│   |                             │
│ ○ Entregado                    │
│   Estimado: 10/11/2025          │
└─────────────────────────────────┘
```

## Testing

### Caso 1: Usuario con órdenes
```
1. Login como usuario con compras
2. Ir a /mi-tienda/my-orders
3. Verificar que se muestran todas las órdenes
4. Click en "Ver Detalles"
5. Verificar información completa
```

### Caso 2: Usuario sin órdenes
```
1. Login como usuario nuevo
2. Ir a /mi-tienda/my-orders
3. Verificar estado vacío
4. Click en "Ir a la Tienda"
5. Redirige a home
```

### Caso 3: Usuario no autenticado
```
1. Sin login
2. Intentar acceder a /mi-tienda/my-orders
3. Redirige a login
4. Después del login, vuelve a mis órdenes
```

### Caso 4: Acceso no autorizado
```
1. Login como Usuario A
2. Intentar ver orden de Usuario B
3. Error 403: "No tienes acceso a esta orden"
```

## Archivos del Sistema

### Vistas
- `resources/views/checkout/my-orders.blade.php` - Lista de órdenes
- `resources/views/checkout/order.blade.php` - Detalle de orden
- `resources/views/layouts/public.blade.php` - Layout base

### Controlador
- `app/Http/Controllers/CheckoutController.php`
  - `myOrders()` - Lista de órdenes
  - `showOrder()` - Detalle de orden

### Modelos
- `app/Models/Order.php` - Modelo de órdenes
- `app/Models/OrderItem.php` - Items de orden
- `app/Models/Customer.php` - Clientes

### Rutas
```php
Route::get('/{website:slug}/my-orders', 'CheckoutController@myOrders')
    ->name('checkout.my-orders');

Route::get('/{website:slug}/order/{orderNumber}', 'CheckoutController@showOrder')
    ->name('checkout.order.show');
```

## Integración con AdminNegocios

### Sincronización de Estados

Cuando AdminNegocios actualiza una orden:

1. Se actualiza el campo `status` en la tabla `orders`
2. Se actualiza el campo `payment_status`
3. La próxima vez que el usuario ve sus órdenes, ve los nuevos estados

### ID de Sincronización

```php
// Orden local
'admin_negocios_order_id' => 456

// Permite rastrear la orden en AdminNegocios
```

## Personalización

### Cambiar Cantidad de Órdenes por Página

En `CheckoutController@myOrders`:
```php
->paginate(20); // Cambiar de 10 a 20
```

### Agregar Campo Personalizado

1. **Migración:**
```php
$table->string('custom_field')->nullable();
```

2. **Vista:**
```blade
<p>{{ $order->custom_field }}</p>
```

### Cambiar Colores de Estados

En las vistas, modificar las clases:
```blade
@if($order->status === 'pending') 
    bg-orange-100 text-orange-800  {{-- Cambiar de amarillo a naranja --}}
@endif
```

## Troubleshooting

### No se muestran las órdenes

**Causa:** Usuario no tiene órdenes o no está bien autenticado.

**Solución:**
1. Verificar que el usuario esté logueado
2. Verificar que `admin_negocios_id` esté guardado en customer
3. Verificar que existan órdenes con ese customer_id

### Error 403 al ver detalle

**Causa:** Usuario intenta ver orden de otro usuario.

**Solución:**
Esto es el comportamiento esperado por seguridad.

### Direcciones no se muestran correctamente

**Causa:** Formato JSON incorrecto.

**Solución:**
Verificar que shipping_address y billing_address sean arrays:
```php
'shipping_address' => [
    'address' => 'Calle 123',
    'city' => 'Bogotá',
    // ...
]
```

---

**¡El sistema de visualización de pedidos está completo!** 🎉

Los usuarios pueden ver todo su historial de compras, con información detallada y estados actualizados en tiempo real.

