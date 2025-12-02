# Sistema de Recuperación de Contraseña

## ✅ Funcionalidad Verificada e Implementada

El sistema de recuperación de contraseña está **completamente implementado y funcional**, conectándose con los endpoints de AdminNegocios.

---

## 🔄 Flujo Completo (3 Pasos)

### Paso 1: Solicitar Código de Recuperación

```
Usuario hace clic en "¿Olvidaste tu contraseña?"
    ↓
Se abre modal de recuperación
    ↓
Ingresa su email
    ↓
Completa CAPTCHA
    ↓
Hace clic en "Enviar Código"
    ↓
Sistema envía código de 4 dígitos por email
    ↓
Avanza al Paso 2
```

### Paso 2: Validar Código

```
Usuario recibe email con código (ej: 8347)
    ↓
Ingresa el código de 4 dígitos
    ↓
Hace clic en "Verificar Código"
    ↓
Sistema valida contra AdminNegocios
    ↓
Si es correcto → Avanza al Paso 3
Si es incorrecto → Muestra error
```

### Paso 3: Cambiar Contraseña

```
Usuario ingresa nueva contraseña
    ↓
Confirma la nueva contraseña
    ↓
Hace clic en "Cambiar Contraseña"
    ↓
Sistema actualiza contraseña en AdminNegocios
    ↓
Mensaje: "¡Contraseña cambiada exitosamente!"
    ↓
Se abre modal de login
    ↓
Usuario puede iniciar sesión con nueva contraseña
```

---

## 📱 Aspecto Visual

### Paso 1: Solicitar Email
```
┌─────────────────────────────────────┐
│ Recuperar Contraseña           [X]  │
│ Ingresa tu email para recibir un    │
│ código de verificación              │
├─────────────────────────────────────┤
│                                     │
│ Email                               │
│ [tu@email.com________________]      │
│                                     │
│    ┌─────────────────────┐         │
│    │ ☐ No soy un robot   │         │
│    │ reCAPTCHA           │         │
│    └─────────────────────┘         │
│                                     │
│  [   Enviar Código   ]              │
│                                     │
│  Volver al login                    │
└─────────────────────────────────────┘
```

### Paso 2: Validar Código
```
┌─────────────────────────────────────┐
│ Recuperar Contraseña           [X]  │
│ Verifica el código que enviamos     │
│ a tu correo                         │
├─────────────────────────────────────┤
│                                     │
│ Código de Verificación              │
│ [  8  3  4  7  ]  ← Grande          │
│ Ingresa el código de 4 dígitos      │
│ que enviamos a tu correo            │
│                                     │
│  [  Verificar Código  ]             │
│                                     │
│  Reenviar código                    │
│                                     │
│  Volver al login                    │
└─────────────────────────────────────┘
```

### Paso 3: Nueva Contraseña
```
┌─────────────────────────────────────┐
│ Recuperar Contraseña           [X]  │
│ Ingresa tu nueva contraseña         │
├─────────────────────────────────────┐
│                                     │
│ Nueva Contraseña                    │
│ [●●●●●●●●●●_______________]         │
│                                     │
│ Confirmar Contraseña                │
│ [●●●●●●●●●●_______________]         │
│                                     │
│  [  Cambiar Contraseña  ]           │
│                                     │
│  Volver al login                    │
└─────────────────────────────────────┘
```

---

## 🔌 Endpoints Utilizados

### 1. POST `/password/sendEmail`

Envía código de 4 dígitos al email del usuario.

**Request:**
```json
{
  "email": "usuario@ejemplo.com",
  "captcha_token": "03AGdBq..."
}
```

**Response Exitoso:**
```json
{
  "success": true,
  "message": "Hemos enviado un correo electrónico con el código de recuperación"
}
```

**Response Error:**
```json
{
  "success": false,
  "message": "El correo electrónico no existe"
}
```

### 2. POST `/password/validateCode`

Valida el código de 4 dígitos ingresado.

**Request:**
```json
{
  "email": "usuario@ejemplo.com",
  "code": "8347"
}
```

**Response Exitoso:**
```json
{
  "success": true,
  "message": "El código de recuperación es correcto"
}
```

**Response Error:**
```json
{
  "success": false,
  "message": "El código de recuperación no es correcto"
}
```

### 3. POST `/password/resetPassword`

Cambia la contraseña del usuario.

**Request:**
```json
{
  "email": "usuario@ejemplo.com",
  "code": "8347",
  "password": "nuevaContraseña123",
  "password_confirmation": "nuevaContraseña123"
}
```

**Response Exitoso:**
```json
{
  "success": true,
  "message": "Contraseña actualizada exitosamente"
}
```

**Response Error:**
```json
{
  "success": false,
  "message": "El código de recuperación ha expirado"
}
```

---

## ✨ Características Implementadas

### ✅ Validaciones

1. **Email válido:** Formato de email correcto
2. **CAPTCHA requerido:** Solo en el paso 1
3. **Código numérico:** 4 dígitos (0000-9999)
4. **Contraseñas coinciden:** Validación frontend
5. **Longitud mínima:** 6 caracteres

### ✅ Seguridad

1. **CAPTCHA:** Protección contra bots
2. **Código temporal:** Expira después de un tiempo
3. **Validación en servidor:** Todas las validaciones se hacen en AdminNegocios
4. **Email verificado:** Solo usuarios registrados pueden recuperar contraseña

### ✅ Experiencia de Usuario

1. **Flujo guiado:** 3 pasos claramente definidos
2. **Mensajes claros:** Instrucciones en cada paso
3. **Feedback visual:** Éxito y errores visibles
4. **Reenviar código:** Botón para solicitar nuevo código
5. **Navegación:** Volver al login en cualquier momento

### ✅ Funcionalidades Extra

1. **Reenviar código:** Si no llegó el email
2. **Reset automático:** Formularios se limpian al cerrar
3. **Auto-navegación:** Cambia de paso automáticamente
4. **Estados de botones:** Loading, deshabilitado, etc.

---

## 📧 Email de Recuperación

AdminNegocios envía un email que contiene:

**Asunto:** "Recuperación de contraseña"

**Contenido:**
```
Hola [Nombre],

Has solicitado recuperar tu contraseña.

Tu código de verificación es: 8347

Este código expira en [tiempo].

Si no solicitaste este cambio, ignora este correo.

Saludos,
El equipo de [Nombre del Negocio]
```

---

## 🔧 Configuración en AdminNegocios

### Endpoints Disponibles

Estos endpoints están en `routes/api.php` de AdminNegocios:

```php
// Recuperar contraseña
Route::post('password/sendEmail', 'UserController@sendEmail');
Route::post('password/validateCode', 'UserController@validateCode');
Route::post('password/resetPassword', 'UserController@resetPassword');
```

### Configuración de Email

Para que funcione el envío de emails, AdminNegocios debe tener configurado:

**Archivo `.env`:**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu-email@gmail.com
MAIL_PASSWORD=tu-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@tudominio.com
MAIL_FROM_NAME="${APP_NAME}"
```

---

## 🎯 Acceso al Sistema

### Desde el Modal de Login

```
Modal de Login
    ↓
Link: "¿Olvidaste tu contraseña?"
    ↓
Se abre Modal de Recuperación
```

### Visual en Modal de Login

```
┌─────────────────────────────────┐
│ Iniciar Sesión             [X]  │
├─────────────────────────────────┤
│ Email: [________________]       │
│ Contraseña: [___________]       │
│                                 │
│    ☐ No soy un robot            │
│                                 │
│  [Iniciar Sesión]               │
│                                 │
│  ¿Olvidaste tu contraseña? ← NUEVO
│                                 │
│  ¿No tienes cuenta?             │
│  Regístrate aquí                │
└─────────────────────────────────┘
```

---

## 🧪 Casos de Prueba

### ✅ Caso 1: Flujo Completo Exitoso
```
1. Ingresa email válido
2. Completa CAPTCHA
3. Recibe código por email
4. Ingresa código correcto
5. Ingresa nueva contraseña
6. Confirma contraseña
7. ✅ Contraseña cambiada
8. Login con nueva contraseña
```

### ❌ Caso 2: Email No Existe
```
1. Ingresa email que no está registrado
2. ❌ Error: "El correo electrónico no existe"
```

### ❌ Caso 3: CAPTCHA No Completado
```
1. Ingresa email
2. No completa CAPTCHA
3. Intenta enviar
4. ❌ Error: "Por favor, completa el CAPTCHA"
```

### ❌ Caso 4: Código Incorrecto
```
1. Recibe código: 8347
2. Ingresa: 1234
3. ❌ Error: "El código de recuperación no es correcto"
```

### ❌ Caso 5: Contraseñas No Coinciden
```
1. Nueva contraseña: password123
2. Confirmar: password456
3. ❌ Error: "Las contraseñas no coinciden"
```

### ✅ Caso 6: Reenviar Código
```
1. No llegó el email
2. Hace clic en "Reenviar código"
3. ✅ Nuevo código enviado
```

---

## 🎨 Estados de Botones

### Paso 1: Enviar Código
```javascript
Normal:      [Enviar Código]
Loading:     [Enviando...] (deshabilitado)
Éxito:       Mensaje verde + auto-avance a paso 2
```

### Paso 2: Verificar Código
```javascript
Normal:      [Verificar Código]
Loading:     [Verificando...] (deshabilitado)
Éxito:       Auto-avance a paso 3
```

### Paso 3: Cambiar Contraseña
```javascript
Normal:      [Cambiar Contraseña]
Loading:     [Cambiando...] (deshabilitado)
Éxito:       Cierra modal + abre login
```

---

## 💡 Características Especiales

### 1. Input de Código Estilizado
```html
<!-- Campo de código con estilo especial -->
<input 
    type="text"
    class="text-center text-2xl font-bold tracking-widest"
    placeholder="0000"
    maxlength="4"
    pattern="[0-9]{4}"
>
```

Resultado: `8  3  4  7` (números grandes y espaciados)

### 2. Botón de Reenviar Código

Si el usuario no recibió el email, puede solicitar un nuevo código:

```
[Verificar Código]

Reenviar código  ← Click para solicitar nuevo
```

### 3. Navegación entre Modales

El usuario puede volver al login en cualquier momento:

```
Recuperar Contraseña
    ↓
"Volver al login" (link)
    ↓
Cierra modal de recuperación
    ↓
Abre modal de login
```

---

## 🔐 Seguridad Implementada

### En AdminNegocios

1. **CAPTCHA obligatorio** en paso 1
2. **Código aleatorio** de 4 dígitos (1000-9999)
3. **Código temporal** (expira después de un tiempo)
4. **Validación de email** existente
5. **Contraseñas hasheadas**

### En el Frontend

1. **Validación de formato** de email
2. **Validación de longitud** de contraseña
3. **Confirmación de contraseña**
4. **Reset de CAPTCHA** después de errores
5. **Inputs sanitizados**

---

## 📊 Endpoints de AdminNegocios

### 1. Enviar Email
```
POST {api_base_url}/password/sendEmail
```

**Campos:**
- `email` (requerido)
- `captcha_token` (requerido)

**Lo que hace:**
1. Valida CAPTCHA
2. Verifica que el email exista
3. Genera código aleatorio (1000-9999)
4. Guarda código en `users.reset_password_code`
5. Envía email con el código

### 2. Validar Código
```
POST {api_base_url}/password/validateCode
```

**Campos:**
- `email` (requerido)
- `code` (requerido, numérico)

**Lo que hace:**
1. Busca el usuario por email
2. Compara el código ingresado con el guardado
3. Retorna éxito o error

### 3. Cambiar Contraseña
```
POST {api_base_url}/password/resetPassword
```

**Campos:**
- `email` (requerido)
- `code` (requerido, numérico)
- `password` (requerido)
- `password_confirmation` (requerido)

**Lo que hace:**
1. Valida el código nuevamente
2. Verifica que las contraseñas coincidan
3. Hashea la nueva contraseña
4. Actualiza la contraseña del usuario
5. Limpia el código de recuperación

---

## 📧 Configuración de Email en AdminNegocios

Para que los emails se envíen correctamente, AdminNegocios debe tener configurado el servicio de correo.

### Opción 1: Gmail (Recomendado para desarrollo)

**Archivo `.env`:**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu-correo@gmail.com
MAIL_PASSWORD=tu-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@tudominio.com
MAIL_FROM_NAME="Mi Tienda"
```

**Nota:** Para Gmail necesitas una "App Password" (no tu contraseña normal):
1. Ve a https://myaccount.google.com/security
2. Activa "Verificación en dos pasos"
3. Ve a "Contraseñas de aplicaciones"
4. Genera una contraseña para "Otra aplicación"
5. Usa esa contraseña en `MAIL_PASSWORD`

### Opción 2: Mailgun

```env
MAIL_MAILER=mailgun
MAILGUN_DOMAIN=tu-dominio.mailgun.org
MAILGUN_SECRET=tu-secret-key
```

### Opción 3: SendGrid

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=tu-sendgrid-api-key
```

---

## 🧪 Testing

### Probar el Flujo Completo

1. **Abrir modal de login**
   ```
   Click en [👤] → Modal se abre
   ```

2. **Click en "¿Olvidaste tu contraseña?"**
   ```
   Se abre modal de recuperación (Paso 1)
   ```

3. **Ingresar email registrado**
   ```
   Email: montilla.colombia@gmail.com
   ```

4. **Completar CAPTCHA**
   ```
   ☑ No soy un robot
   ```

5. **Click en "Enviar Código"**
   ```
   ✅ "Código enviado exitosamente"
   Auto-avanza a Paso 2
   ```

6. **Revisar correo**
   ```
   Busca email de AdminNegocios
   Código: 8347
   ```

7. **Ingresar código**
   ```
   [8][3][4][7]
   Click en "Verificar Código"
   ✅ Auto-avanza a Paso 3
   ```

8. **Ingresar nueva contraseña**
   ```
   Nueva: miNuevaPassword123
   Confirmar: miNuevaPassword123
   Click en "Cambiar Contraseña"
   ```

9. **Verificar éxito**
   ```
   ✅ "¡Contraseña cambiada exitosamente!"
   Se abre modal de login
   ```

10. **Login con nueva contraseña**
    ```
    Email: montilla.colombia@gmail.com
    Password: miNuevaPassword123
    ✅ Login exitoso
    ```

---

## ⚠️ Troubleshooting

### El email no llega

**Posibles causas:**
1. AdminNegocios no tiene configurado el servicio de correo
2. El email del usuario no existe en la BD
3. El email está en spam

**Soluciones:**
1. Verificar configuración de email en `.env`
2. Probar con: `php artisan tinker` → `Mail::raw('Test', fn($m) => $m->to('test@test.com'))`
3. Revisar logs: `storage/logs/laravel.log`

### "El correo electrónico no existe"

**Causa:** El email no está registrado en AdminNegocios.

**Solución:** Verificar en la tabla `users` de AdminNegocios.

### "El código de recuperación no es correcto"

**Causa:** Usuario ingresó código incorrecto o código expiró.

**Solución:** Usar el botón "Reenviar código" para obtener uno nuevo.

### "Token de CAPTCHA requerido"

**Causa:** Usuario no completó el CAPTCHA.

**Solución:** El sistema ahora valida y muestra mensaje antes de enviar.

### Modal no se abre

**Causa:** Error de JavaScript.

**Solución:**
1. Abrir consola del navegador (F12)
2. Revisar errores de JavaScript
3. Verificar que el script se cargó correctamente

---

## 📁 Archivos Modificados

### Actualizado:
✅ `resources/views/components/auth/user-auth-script.blade.php`
   - Agregado modal de recuperar contraseña (3 pasos)
   - Función `showForgotPasswordModal()`
   - Función `createForgotPasswordModal()`
   - Función `showForgotPasswordStep()`
   - Función `handleForgotPasswordEmail()`
   - Función `handleForgotPasswordCode()`
   - Función `handleForgotPasswordReset()`
   - Función `closeForgotPasswordModal()`

### Creado:
✅ `docs/RECUPERAR_CONTRASEÑA.md` (este archivo)
   - Documentación completa del sistema

---

## 🎉 ¡Sistema Verificado y Funcionando!

La funcionalidad de recuperar contraseña está:

✅ **Completamente implementada**
✅ **Conectada con AdminNegocios**
✅ **Protegida con CAPTCHA**
✅ **Con flujo de 3 pasos claro**
✅ **Validaciones completas**
✅ **Mensajes de error claros**
✅ **Opción de reenviar código**
✅ **Integrada en el modal de login**

---

## 🚀 Cómo Usar

1. **Usuario olvida su contraseña**
2. **Click en "¿Olvidaste tu contraseña?"** en el modal de login
3. **Paso 1:** Ingresa email + CAPTCHA
4. **Paso 2:** Ingresa código recibido por email
5. **Paso 3:** Ingresa nueva contraseña
6. **Login** con la nueva contraseña

**¡Funcionando al 100%!** 🎊

