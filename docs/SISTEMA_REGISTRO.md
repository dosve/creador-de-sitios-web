# Sistema de Registro de Usuarios

## Descripción

Se ha implementado un sistema completo de registro que permite a los nuevos usuarios crear una cuenta desde cualquier tienda, la cual quedará registrada en **AdminNegocios** y podrá ser usada en todas las tiendas del sistema.

## Características

✅ **Modal de Registro Completo**
- Formulario con validación
- Campos: Nombre, Email, Teléfono, Contraseña
- Validación de contraseñas coincidentes
- Mensajes de error claros

✅ **Registro en AdminNegocios**
- La cuenta se crea en el servidor central
- Puede usarse en todas las tiendas
- Login automático después del registro

✅ **Navegación entre Modales**
- Desde Login → Registro (link "Regístrate aquí")
- Desde Registro → Login (link "Inicia sesión aquí")

✅ **Experiencia de Usuario**
- Validación en tiempo real
- Feedback visual inmediato
- Registro exitoso con confirmación

## Flujo de Registro

```
Usuario hace clic en ícono [👤]
    ↓
Se abre modal de Login
    ↓
Usuario hace clic en "Regístrate aquí"
    ↓
Se cierra modal de Login
Se abre modal de Registro
    ↓
Usuario llena el formulario:
  - Nombre Completo
  - Email
  - Teléfono
  - Contraseña
  - Confirmar Contraseña
    ↓
Usuario hace clic en "Crear Cuenta"
    ↓
Sistema valida:
  ✓ Contraseñas coinciden
  ✓ Contraseña mínimo 6 caracteres
  ✓ Todos los campos requeridos
    ↓
Se envía a AdminNegocios POST /register
    ↓
¿Registro exitoso?
    │
    ├─ SÍ → Login automático
    │        ↓
    │        Cierra modal
    │        ↓
    │        Muestra mensaje "¡Cuenta creada!"
    │        ↓
    │        Actualiza header con nombre del usuario
    │        ↓
    │        Recarga página
    │
    └─ NO → Muestra error
             (Email ya existe, etc.)
```

## Campos del Formulario

### Nombre Completo *
- **Tipo:** Text
- **Requerido:** Sí
- **Placeholder:** "Juan Pérez"
- **Validación:** Campo no vacío

### Email *
- **Tipo:** Email
- **Requerido:** Sí
- **Placeholder:** "tu@email.com"
- **Validación:** Formato de email válido

### Teléfono *
- **Tipo:** Tel
- **Requerido:** Sí
- **Placeholder:** "3001234567"
- **Validación:** Campo no vacío

### Contraseña *
- **Tipo:** Password
- **Requerido:** Sí
- **Minlength:** 6 caracteres
- **Placeholder:** "Mínimo 6 caracteres"
- **Validación:** Mínimo 6 caracteres

### Confirmar Contraseña *
- **Tipo:** Password
- **Requerido:** Sí
- **Minlength:** 6 caracteres
- **Placeholder:** "Repite tu contraseña"
- **Validación:** Debe coincidir con Contraseña

## Validaciones

### Frontend (JavaScript)

```javascript
// 1. Contraseñas coinciden
if (password !== passwordConfirm) {
    return error('Las contraseñas no coinciden');
}

// 2. Longitud mínima
if (password.length < 6) {
    return error('La contraseña debe tener al menos 6 caracteres');
}

// 3. Campos requeridos (HTML5)
<input type="text" required>
```

### Backend (Laravel)

```php
$request->validate([
    'name' => 'required|string|max:255',
    'email' => 'required|email|max:255',
    'password' => 'required|string|min:6',
    'phone' => 'nullable|string|max:20',
    'website_slug' => 'required',
]);
```

## Endpoint de Registro

### POST `/customer/register`

**Request:**
```json
{
  "name": "Juan Pérez",
  "email": "juan@ejemplo.com",
  "phone": "3001234567",
  "password": "mipassword123",
  "website_slug": "mi-tienda"
}
```

**Response Exitoso (201):**
```json
{
  "success": true,
  "message": "Registro exitoso",
  "customer": {
    "id": 1,
    "admin_negocios_id": 456,
    "email": "juan@ejemplo.com",
    "name": "Juan Pérez",
    "phone": "3001234567",
    "total_orders": 0,
    "total_spent": 0
  },
  "token": "eyJ0eXAiOiJKV1QiLCJhbGc..."
}
```

**Response Error (400):**
```json
{
  "success": false,
  "message": "El email ya está registrado"
}
```

**Response Error (500):**
```json
{
  "success": false,
  "message": "Error al procesar el registro. Por favor, intenta nuevamente."
}
```

## Proceso en el Backend

### 1. Validación de Datos
El controlador `CustomerAuthController@register` valida los datos recibidos.

### 2. Registro en AdminNegocios
Se hace una petición POST al endpoint de AdminNegocios:
```php
POST {api_base_url}/register
```

### 3. Manejo de Respuesta
- **Si es exitoso:** Login automático y retorna datos del usuario
- **Si falla:** Retorna el mensaje de error de AdminNegocios

### 4. Login Automático
Después del registro exitoso, se llama automáticamente a la función `login()` para autenticar al usuario.

## Estados del Botón

### Estado Normal
```html
<button class="bg-blue-600 hover:bg-blue-700">
    Crear Cuenta
</button>
```

### Estado Loading (procesando)
```html
<button disabled class="bg-blue-400 cursor-not-allowed">
    Creando cuenta...
</button>
```

### Estado Exitoso
```
✓ Cuenta creada
  Modal se cierra
  Usuario autenticado
```

## Mensajes de Error

### Contraseñas no coinciden
```
❌ Las contraseñas no coinciden
```

### Contraseña muy corta
```
❌ La contraseña debe tener al menos 6 caracteres
```

### Email ya registrado
```
❌ El email ya está registrado
```

### Error de conexión
```
❌ Error al procesar el registro. Por favor, intenta nuevamente.
```

### Error de validación
```
❌ Por favor completa todos los campos correctamente
```

## Mensaje de Éxito

Después del registro exitoso, se muestra:

```javascript
alert('¡Cuenta creada exitosamente! Ya puedes hacer compras.');
```

Y luego:
1. El modal se cierra
2. El header se actualiza con el nombre del usuario
3. La página se recarga para reflejar el nuevo estado

## Navegación entre Modales

### Desde Login a Registro

En el modal de Login:
```html
<p class="text-center text-sm text-gray-600 mt-4">
    ¿No tienes cuenta? 
    <a href="#" id="show-register">Regístrate aquí</a>
</p>
```

Al hacer clic:
1. Cierra modal de Login
2. Abre modal de Registro

### Desde Registro a Login

En el modal de Registro:
```html
<p class="text-center text-sm text-gray-600 mt-4">
    ¿Ya tienes cuenta? 
    <a href="#" id="show-login-from-register">Inicia sesión aquí</a>
</p>
```

Al hacer clic:
1. Cierra modal de Registro
2. Abre modal de Login

## Estilos del Modal

El modal de registro usa las mismas clases que el modal de login:

```css
/* Modal overlay */
.fixed .inset-0 .z-50 .bg-black .bg-opacity-50

/* Modal content */
.bg-white .rounded-lg .shadow-xl .max-w-md

/* Scrollable (para móviles) */
.max-h-[90vh] .overflow-y-auto

/* Inputs */
.border .border-gray-300 .rounded-lg
.focus:ring-2 .focus:ring-blue-500

/* Button */
.bg-blue-600 .hover:bg-blue-700
.text-white .py-3 .rounded-lg
```

## Integración con el Sistema

### Después del Registro

1. **Se crea registro en AdminNegocios** (tabla `users`)
2. **Login automático** usando las credenciales
3. **Se crea/actualiza en `website_customers`** con:
   - `first_login_at`: Timestamp del registro
   - `last_login_at`: Timestamp del registro
   - `total_orders`: 0
   - `total_spent`: 0

4. **Sesión Laravel** se establece con:
   - `customer_logged_in`: true
   - `customer_id`: ID en website_customers
   - `customer_admin_negocios_id`: ID en AdminNegocios
   - `customer_token`: Token JWT
   - `customer_data`: Datos del usuario

## Testing Manual

Para probar el sistema de registro:

### 1. Abrir una tienda
```
http://localhost/creadorweb.eme10.com/mi-tienda
```

### 2. Hacer clic en el ícono de usuario
```
[👤] ← Clic aquí
```

### 3. En el modal de login, hacer clic en "Regístrate aquí"

### 4. Llenar el formulario con datos válidos
```
Nombre: Juan Pérez
Email: juan.perez@ejemplo.com
Teléfono: 3001234567
Contraseña: password123
Confirmar: password123
```

### 5. Hacer clic en "Crear Cuenta"

### 6. Verificar
- ✅ Modal se cierra
- ✅ Aparece mensaje "¡Cuenta creada exitosamente!"
- ✅ Header muestra el nombre "Juan"
- ✅ Página se recarga
- ✅ Usuario está autenticado

### 7. Verificar en AdminNegocios
- Ir a la tabla `users`
- Buscar el email registrado
- Verificar que existe el usuario

### 8. Intentar registrar con el mismo email
- Debe mostrar error: "El email ya está registrado"

## Casos de Prueba

### ✅ Caso 1: Registro exitoso
```
Datos válidos → Registro exitoso → Login automático
```

### ❌ Caso 2: Email duplicado
```
Email existente → Error "El email ya está registrado"
```

### ❌ Caso 3: Contraseñas no coinciden
```
password123 ≠ password456 → Error "Las contraseñas no coinciden"
```

### ❌ Caso 4: Contraseña corta
```
"12345" (5 chars) → Error "Mínimo 6 caracteres"
```

### ❌ Caso 5: Campos vacíos
```
Campos requeridos vacíos → HTML5 validation
```

### ❌ Caso 6: Email inválido
```
"correo-invalido" → HTML5 validation
```

## Seguridad

### ✅ Validaciones Implementadas
1. Validación de formato de email (HTML5 + Backend)
2. Longitud mínima de contraseña (6 caracteres)
3. Confirmación de contraseña
4. CSRF Token en todas las peticiones
5. Contraseñas hasheadas en AdminNegocios

### ✅ Buenas Prácticas
1. No se almacenan contraseñas en el creador de tiendas
2. Todo se delega a AdminNegocios
3. Token JWT para sesiones
4. Validación tanto frontend como backend

## Personalización

### Cambiar Longitud Mínima de Contraseña

**Frontend:**
```html
<input 
    type="password" 
    minlength="8"  <!-- Cambiar aquí -->
>
```

**Backend (CustomerAuthController):**
```php
$request->validate([
    'password' => 'required|string|min:8',  // Cambiar aquí
]);
```

### Agregar Campo Adicional (ej: Dirección)

**1. Frontend (modal):**
```html
<div class="mb-4">
    <label>Dirección (opcional)</label>
    <input type="text" id="register-address">
</div>
```

**2. JavaScript:**
```javascript
const address = document.getElementById('register-address').value;

body: JSON.stringify({
    // ... otros campos
    address: address
})
```

**3. Backend:**
```php
$request->validate([
    // ... otras validaciones
    'address' => 'nullable|string|max:255',
]);
```

### Cambiar Mensaje de Éxito

En `user-auth-script.blade.php`:
```javascript
alert('¡Bienvenido! Tu cuenta ha sido creada correctamente.');
```

## Troubleshooting

### El modal de registro no se abre

**Causa:** Posible conflicto de IDs o JavaScript no cargado.

**Solución:**
1. Verificar en la consola del navegador (F12)
2. Buscar errores de JavaScript
3. Verificar que `user-auth-script.blade.php` está incluido

### El registro no funciona

**Causa:** AdminNegocios no está accesible o no tiene configurado el endpoint.

**Solución:**
1. Verificar `api_base_url` de la tienda
2. Probar el endpoint manualmente:
```bash
curl -X POST http://adminnegocios.test/api/register \
  -H "Content-Type: application/json" \
  -d '{"name":"Test","email":"test@test.com","password":"123456"}'
```

### Error "Email ya está registrado" pero no existe

**Causa:** El email puede estar en otra tabla o sistema.

**Solución:**
1. Verificar en la base de datos de AdminNegocios
2. Buscar en tabla `users` por el email
3. Si no existe, puede ser un problema de validación

### El login automático no funciona

**Causa:** El endpoint de login de AdminNegocios retorna un formato diferente.

**Solución:**
1. Verificar el response del endpoint `/login`
2. Asegurarse que retorna `success`, `user` y `token`

## Archivos Relacionados

- **Script principal:** `resources/views/components/auth/user-auth-script.blade.php`
- **Controlador:** `app/Http/Controllers/CustomerAuthController.php`
- **Rutas:** `routes/web.php` (POST `/customer/register`)
- **Modelo:** `app/Models/WebsiteCustomer.php`

---

**¡El sistema de registro está completamente funcional!** 🎉

Los usuarios ahora pueden crear cuentas nuevas directamente desde cualquier tienda y comenzar a comprar inmediatamente.

