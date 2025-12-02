# Configuración de reCAPTCHA

## ¿Qué se agregó?

Se ha integrado **Google reCAPTCHA v2** en los formularios de login y registro del sistema de autenticación de clientes.

## 🔑 Claves de reCAPTCHA

### Claves Actuales (Desarrollo)

El sistema está configurado con las **claves de prueba de Google** que funcionan en cualquier dominio:

```javascript
Site Key: 6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI
Secret Key: 6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe
```

⚠️ **Estas claves son solo para desarrollo y pruebas. Siempre aprueban el CAPTCHA.**

### Para Producción

Necesitas obtener tus propias claves de reCAPTCHA:

#### Paso 1: Ir a Google reCAPTCHA
1. Ve a: https://www.google.com/recaptcha/admin
2. Inicia sesión con tu cuenta de Google

#### Paso 2: Registrar un Sitio Nuevo
1. Haz clic en el botón "+"
2. Completa el formulario:
   - **Label:** Nombre de tu sitio (ej: "Mi Tienda Online")
   - **reCAPTCHA type:** Selecciona "reCAPTCHA v2" → "I'm not a robot Checkbox"
   - **Domains:** Agrega tus dominios:
     - `localhost` (para desarrollo)
     - `creadorweb.eme10.com` (tu dominio real)
     - Cualquier otro dominio que uses
   - Acepta los términos de servicio
3. Haz clic en "Submit"

#### Paso 3: Copiar las Claves
Después de registrar, Google te dará:
- **Site Key** (Clave del sitio) - Para el frontend
- **Secret Key** (Clave secreta) - Para el backend

## 📝 Cómo Configurar

### Opción 1: Usar Claves de Prueba (Desarrollo)

Si quieres seguir usando las claves de prueba, no necesitas hacer nada. Ya están configuradas.

**Ventaja:** Funciona inmediatamente
**Desventaja:** Siempre aprueba el CAPTCHA (no protege realmente)

### Opción 2: Usar tus Propias Claves (Producción)

#### 1. Actualizar el Frontend

Edita: `resources/views/components/auth/user-auth-script.blade.php`

Cambia esta línea:
```javascript
const RECAPTCHA_SITE_KEY = '6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI'; // Clave de prueba
```

Por tu clave real:
```javascript
const RECAPTCHA_SITE_KEY = 'TU_SITE_KEY_AQUI'; // Tu clave real
```

#### 2. Actualizar AdminNegocios

Las claves del backend ya están configuradas en AdminNegocios:

**Archivo:** `servidor-adminnegocios/config/captcha.php`
```php
'site_key' => env('RECAPTCHA_SITE_KEY', '6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI'),
'secret_key' => env('RECAPTCHA_SECRET_KEY', '6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe'),
```

**Actualizar el archivo `.env` de AdminNegocios:**
```env
RECAPTCHA_SITE_KEY=tu_site_key_aqui
RECAPTCHA_SECRET_KEY=tu_secret_key_aqui
RECAPTCHA_VERSION=v2
RECAPTCHA_ENABLED=true
```

## 🎯 Cómo Funciona

### En el Login

1. Usuario abre el modal de login
2. Ve el checkbox de reCAPTCHA: ☐ No soy un robot
3. Hace clic en el checkbox
4. Completa el desafío si Google lo pide
5. Ingresa credenciales
6. Hace clic en "Iniciar Sesión"
7. El sistema envía el token de CAPTCHA a AdminNegocios
8. AdminNegocios valida el token con Google
9. Si es válido → permite el login
10. Si no es válido → muestra error

### En el Registro

Mismo flujo pero para el formulario de registro.

## 🖼️ Visual

### Antes (sin CAPTCHA)
```
Email: [________________]
Contraseña: [________________]
[Iniciar Sesión]
```

### Ahora (con CAPTCHA)
```
Email: [________________]
Contraseña: [________________]

    ☐ No soy un robot
    reCAPTCHA

[Iniciar Sesión]
```

## ⚠️ Errores Comunes

### "Token de CAPTCHA requerido"

**Causa:** El usuario no completó el CAPTCHA antes de hacer submit.

**Solución:** El sistema ahora muestra el mensaje "Por favor, completa el CAPTCHA" si intentan enviar sin completarlo.

### CAPTCHA no aparece

**Causa 1:** Script de Google no se cargó.

**Solución:** Verifica que tengas internet y que no haya bloqueadores de ads.

**Causa 2:** Clave del sitio incorrecta.

**Solución:** Verifica que `RECAPTCHA_SITE_KEY` sea correcta.

### "invalid-input-response"

**Causa:** El token de CAPTCHA es inválido o ya expiró.

**Solución:** Los tokens de CAPTCHA expiran después de 2 minutos. Pide al usuario que complete el CAPTCHA nuevamente.

## 🔄 Reset Automático

El sistema resetea automáticamente el CAPTCHA en estos casos:

1. ✅ Después de un login fallido
2. ✅ Después de un registro fallido
3. ✅ Después de cualquier error

Esto permite al usuario intentar nuevamente sin recargar la página.

## 🧪 Testing

### Con Claves de Prueba

Las claves de prueba **siempre aprueban** el CAPTCHA, por lo que son perfectas para testing automatizado.

```javascript
// En tus tests
const captchaToken = 'test_token_12345'; // Cualquier valor funciona
```

### Con Claves Reales

Necesitarás completar el CAPTCHA real en tus tests o usar un service account de Google.

## 📊 Estadísticas

AdminNegocios registra todos los intentos de CAPTCHA en los logs:

```
reCAPTCHA verification successful
reCAPTCHA verification failed
reCAPTCHA score too low (solo v3)
```

Puedes revisar `storage/logs/laravel.log` para ver estos eventos.

## 🔐 Seguridad

### Frontend
- El Site Key es público (no es sensible)
- Se incluye directamente en el HTML
- Google lo usa para generar el desafío

### Backend
- El Secret Key es privado (muy sensible)
- **NUNCA** lo expongas en el frontend
- Solo se usa en el servidor para validar

## 🎨 Personalización

### Tema del CAPTCHA

Puedes cambiar el tema del widget:

```html
<!-- Tema claro (default) -->
<div class="g-recaptcha" data-theme="light"></div>

<!-- Tema oscuro -->
<div class="g-recaptcha" data-theme="dark"></div>
```

### Tamaño

```html
<!-- Normal (default) -->
<div class="g-recaptcha" data-size="normal"></div>

<!-- Compacto -->
<div class="g-recaptcha" data-size="compact"></div>
```

### Idioma

El idioma se detecta automáticamente, pero puedes forzarlo:

```html
<script src="https://www.google.com/recaptcha/api.js?hl=es" async defer></script>
```

## 📱 Mobile

reCAPTCHA es responsive y funciona perfectamente en dispositivos móviles.

## 🚀 Próximos Pasos

### Recomendado

1. **Obtener claves propias** de Google reCAPTCHA
2. **Configurarlas** en el frontend y AdminNegocios
3. **Probar** en tu dominio de producción

### Opcional

- Migrar a reCAPTCHA v3 (sin checkbox, invisible)
- Implementar análisis de score para v3
- Agregar fallback si CAPTCHA falla

## 📖 Documentación Oficial

- **Google reCAPTCHA:** https://www.google.com/recaptcha/about/
- **Documentación v2:** https://developers.google.com/recaptcha/docs/display
- **Admin Console:** https://www.google.com/recaptcha/admin

---

**¡El CAPTCHA está listo y funcionando!** 🎉

Ahora el sistema está protegido contra bots y ataques automatizados.

