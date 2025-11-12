# Sistema de Login y Checkout para Tiendas

## Descripción General

Este sistema permite que los usuarios que ya tienen cuenta en **AdminNegocios** puedan hacer login desde cualquier tienda creada con el **Creador de Tiendas** y realizar compras asociadas a su cuenta.

También permite realizar compras sin autenticación (como invitado), pero cuando un usuario está autenticado, todas sus compras quedan vinculadas a su perfil.

## Componentes del Sistema

### 1. Base de Datos

#### Tabla `website_customers`
Relaciona los usuarios de AdminNegocios con las tiendas. Permite rastrear qué usuarios han comprado o iniciado sesión en cada tienda.

**Campos principales:**
- `website_id`: ID de la tienda
- `admin_negocios_user_id`: ID del usuario en AdminNegocios
- `email`: Email del usuario
- `first_login_at`: Primera vez que inició sesión
- `last_login_at`: Última vez que inició sesión
- `first_purchase_at`: Primera compra
- `last_purchase_at`: Última compra
- `total_orders`: Total de órdenes realizadas
- `total_spent`: Total gastado en la tienda

#### Tabla `customers` (actualizada)
Almacena la información de los clientes que realizan compras en cada tienda.

**Campos nuevos:**
- `admin_negocios_id`: ID del usuario en AdminNegocios (si está autenticado)
- `is_authenticated`: Indica si el customer está autenticado

#### Tabla `orders` (existente)
Almacena las órdenes de compra.

**Campo importante:**
- `admin_negocios_order_id`: ID de la orden sincronizada con AdminNegocios

### 2. Modelos

#### `WebsiteCustomer`
Modelo para la tabla `website_customers`. Métodos principales:
- `recordLogin()`: Registra un nuevo inicio de sesión
- `recordPurchase($amount)`: Registra una nueva compra y actualiza estadísticas

#### `Customer` (actualizado)
Modelo para la tabla `customers`. Ahora incluye:
- Relación con `WebsiteCustomer`
- Campo `is_authenticated`

### 3. Controladores

#### `CustomerAuthController`
Maneja la autenticación de clientes desde la tienda pública.

**Endpoints principales:**

##### POST `/customer/login`
Inicia sesión usando credenciales de AdminNegocios.

**Request:**
```json
{
  "email": "cliente@ejemplo.com",
  "password": "password123",
  "website_slug": "mi-tienda"
}
```

**Response exitoso:**
```json
{
  "success": true,
  "message": "Login exitoso",
  "customer": {
    "id": 1,
    "admin_negocios_id": 123,
    "email": "cliente@ejemplo.com",
    "name": "Juan Pérez",
    "phone": "3001234567",
    "total_orders": 5,
    "total_spent": 150000
  },
  "token": "eyJ0eXAiOiJKV1QiLCJhbGc..."
}
```

##### POST `/customer/register`
Registra un nuevo usuario en AdminNegocios y lo autentica automáticamente.

**Request:**
```json
{
  "name": "Juan Pérez",
  "email": "cliente@ejemplo.com",
  "password": "password123",
  "phone": "3001234567",
  "website_slug": "mi-tienda"
}
```

##### POST `/customer/logout`
Cierra la sesión del cliente.

##### GET `/customer/check`
Verifica si hay una sesión activa.

**Response:**
```json
{
  "success": true,
  "authenticated": true,
  "customer": {
    "id": 123,
    "email": "cliente@ejemplo.com",
    "name": "Juan Pérez"
  }
}
```

##### GET `/customer/me`
Obtiene la información completa del cliente autenticado.

#### `CheckoutController`
Maneja el proceso de checkout público.

**Endpoints principales:**

##### GET `/{website_slug}/checkout`
Muestra la página de checkout.

##### POST `/{website_slug}/checkout/process`
Procesa el checkout y crea la orden.

**Request:**
```json
{
  "website_slug": "mi-tienda",
  "items": [
    {
      "product_id": 1,
      "name": "Producto 1",
      "quantity": 2,
      "price": 25000
    }
  ],
  "customer": {
    "name": "Juan Pérez",
    "email": "cliente@ejemplo.com",
    "phone": "3001234567",
    "address": "Calle 123",
    "city": "Bogotá",
    "state": "Cundinamarca",
    "postal_code": "110111",
    "country": "Colombia"
  },
  "shipping_address": {
    "address": "Calle 123",
    "city": "Bogotá",
    "state": "Cundinamarca",
    "postal_code": "110111",
    "country": "Colombia"
  },
  "billing_address": {
    "address": "Calle 123",
    "city": "Bogotá"
  },
  "payment_method": "epayco",
  "tax_amount": 5000,
  "shipping_amount": 10000,
  "notes": "Notas adicionales"
}
```

**Response exitoso:**
```json
{
  "success": true,
  "message": "Orden creada exitosamente",
  "order": {
    "id": 1,
    "order_number": "ORD20251105001",
    "status": "pending",
    "payment_status": "pending",
    "total": 65000,
    "currency": "COP",
    "admin_negocios_order_id": 456
  }
}
```

##### GET `/{website_slug}/order/{orderNumber}`
Muestra los detalles de una orden específica.

##### GET `/{website_slug}/my-orders`
Lista todas las órdenes del cliente autenticado.

## Flujo de Trabajo

### Flujo 1: Compra como Invitado (Guest Checkout)

1. Usuario agrega productos al carrito
2. Va al checkout sin iniciar sesión
3. Llena sus datos (nombre, email, teléfono, dirección)
4. Procesa el pago
5. Se crea:
   - Un `Customer` con `is_authenticated = false`
   - Una `Order` asociada al customer
   - Se intenta enviar a AdminNegocios (si está configurado)

### Flujo 2: Compra con Usuario Autenticado

1. Usuario hace click en "Iniciar Sesión"
2. Se envía POST a `/customer/login` con credenciales
3. El sistema:
   - Valida contra la API de AdminNegocios
   - Crea/actualiza registro en `website_customers`
   - Registra el login con `recordLogin()`
   - Guarda datos en sesión
4. Usuario agrega productos al carrito
5. Va al checkout (datos pre-llenados)
6. Procesa el pago
7. Se crea:
   - Un `Customer` con `is_authenticated = true` y `admin_negocios_id`
   - Una `Order` asociada al customer
   - Se envía a AdminNegocios con el ID del usuario
   - Se actualiza `website_customers` con `recordPurchase()`

### Flujo 3: Registro desde la Tienda

1. Usuario hace click en "Registrarse"
2. Se envía POST a `/customer/register` con datos
3. El sistema:
   - Crea el usuario en AdminNegocios
   - Automáticamente hace login (flujo 2)
   - Redirige al checkout o tienda

## Integración con AdminNegocios

### Configuración Requerida

Para que una tienda pueda usar este sistema, debe tener configurado:
- `api_base_url`: URL base de la API de AdminNegocios
- `api_key`: API Key del negocio (opcional, para ciertos endpoints)

### Endpoints de AdminNegocios Utilizados

1. **POST /login**: Autenticación de usuarios
2. **POST /register**: Registro de nuevos usuarios
3. **POST /segundos/pedidos**: Crear pedido desde aplicación externa

### Sincronización de Órdenes

Cuando se crea una orden en el creador de tiendas:

1. Se crea localmente en la tabla `orders`
2. Se intenta enviar a AdminNegocios
3. Si es exitoso, se guarda el `admin_negocios_order_id`
4. Si falla, la orden queda solo local (se puede reintentar después)

## Estadísticas y Análisis

La tabla `website_customers` permite generar reportes sobre:

- Usuarios registrados por tienda
- Total de compras por usuario
- Valor total gastado por usuario
- Frecuencia de compras
- Primera y última vez que compraron
- Usuarios activos vs inactivos

### Ejemplo de Consultas

```php
// Usuarios que han comprado en una tienda
$customers = WebsiteCustomer::byWebsite($websiteId)
    ->hasPurchased()
    ->get();

// Usuarios con login reciente (últimos 30 días)
$activeUsers = WebsiteCustomer::byWebsite($websiteId)
    ->recentLogins(30)
    ->get();

// Top compradores
$topBuyers = WebsiteCustomer::byWebsite($websiteId)
    ->orderBy('total_spent', 'desc')
    ->limit(10)
    ->get();
```

## Sesiones

El sistema usa sesiones de Laravel para mantener el estado de autenticación:

**Datos en sesión:**
- `customer_logged_in`: boolean
- `customer_id`: ID en `website_customers`
- `customer_admin_negocios_id`: ID del usuario en AdminNegocios
- `customer_token`: Token JWT de AdminNegocios
- `customer_data`: Datos del usuario (nombre, email, phone)

## Seguridad

### Protección de Datos
- Las contraseñas nunca se almacenan en el creador de tiendas
- La autenticación se delega completamente a AdminNegocios
- El token JWT se almacena en sesión (no en cookies del cliente)

### Verificación de Acceso a Órdenes
- Solo el usuario autenticado puede ver sus propias órdenes
- Las órdenes de invitados requieren validación por email
- No se exponen IDs internos en URLs públicas (se usa `order_number`)

## Implementación en el Frontend

### Ejemplo de Login con JavaScript

```javascript
// Login de cliente
async function customerLogin(email, password, websiteSlug) {
    try {
        const response = await fetch('/customer/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                email: email,
                password: password,
                website_slug: websiteSlug
            })
        });

        const data = await response.json();

        if (data.success) {
            // Login exitoso
            console.log('Bienvenido:', data.customer.name);
            // Redirigir o actualizar UI
            window.location.href = '/checkout';
        } else {
            // Error
            alert(data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error al procesar el login');
    }
}
```

### Ejemplo de Checkout

```javascript
// Procesar checkout
async function processCheckout(orderData) {
    try {
        const response = await fetch(`/${websiteSlug}/checkout/process`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(orderData)
        });

        const data = await response.json();

        if (data.success) {
            // Orden creada
            console.log('Orden creada:', data.order.order_number);
            // Redirigir a página de confirmación
            window.location.href = `/order/${data.order.order_number}`;
        } else {
            alert(data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error al procesar la orden');
    }
}
```

### Verificar Estado de Autenticación

```javascript
// Verificar si el usuario está autenticado
async function checkAuth() {
    try {
        const response = await fetch('/customer/check');
        const data = await response.json();

        if (data.authenticated) {
            // Usuario autenticado
            console.log('Usuario:', data.customer);
            // Mostrar menú de usuario, pre-llenar formularios, etc.
        } else {
            // Usuario no autenticado
            console.log('No hay sesión activa');
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

// Llamar al cargar la página
checkAuth();
```

## Migraciones

Para aplicar los cambios a la base de datos:

```bash
php artisan migrate
```

Esto creará:
1. La tabla `website_customers`
2. Actualizará la tabla `customers` con los nuevos campos

## Próximos Pasos

### Funcionalidades Sugeridas

1. **Recuperación de contraseña**: Permitir a los usuarios recuperar su contraseña desde la tienda
2. **Perfil de usuario**: Página donde el usuario pueda ver y editar su información
3. **Direcciones guardadas**: Permitir guardar múltiples direcciones de envío
4. **Lista de deseos**: Guardar productos favoritos por usuario
5. **Historial de compras**: Vista detallada de todas las órdenes
6. **Notificaciones**: Enviar emails cuando cambia el estado de una orden
7. **Reseñas de productos**: Permitir a usuarios autenticados dejar reseñas
8. **Puntos de fidelidad**: Sistema de recompensas por compras

### Mejoras de Seguridad

1. Implementar rate limiting en endpoints de login
2. Agregar verificación de email
3. Implementar 2FA (autenticación de dos factores)
4. Log de actividad del usuario (auditoría)

### Optimizaciones

1. Caché de sesiones de usuario
2. Índices adicionales en base de datos
3. Queue para sincronización con AdminNegocios
4. Webhook para recibir actualizaciones de AdminNegocios

## Soporte

Para preguntas o problemas relacionados con este sistema, contactar al equipo de desarrollo.

