# Integración de Wompi - Pasarela de Pagos

## 📋 Resumen

Wompi es una pasarela de pagos colombiana que permite recibir pagos con tarjetas de crédito, débito, PSE, Nequi, Bancolombia y más.

---

## 🔑 Credenciales Necesarias

Para integrar Wompi necesitas **4 llaves**:

### 1. **Public Key (Llave Pública)**
- Formato: `pub_prod_XXXXXXXXXX` o `pub_test_XXXXXXXXXX`
- Uso: Frontend (widget de checkout)
- Se puede compartir públicamente

### 2. **Private Key (Llave Privada)**  
- Formato: `prv_prod_XXXXXXXXXX` o `prv_test_XXXXXXXXXX`
- Uso: Backend (validaciones y consultas)
- **MANTENER SECRETA**

### 3. **Events Secret (Llave de Eventos)**
- Formato: `evt_prod_XXXXXXXXXX` o `evt_test_XXXXXXXXXX`
- Uso: Validar webhooks
- Opcional pero recomendada

### 4. **Integrity Key (Llave de Integridad)**
- Formato: `prod_integrity_XXXXXXXXXX` o `test_integrity_XXXXXXXXXX`
- Uso: Generar firma de integridad para validar transacciones
- **Recomendado** para mayor seguridad
- Se encuentra en: **Desarrolladores** → **Secrets for technical integration**

---

## 📍 Dónde Obtener las Credenciales

1. Ingresa a: https://comercios.wompi.co
2. Inicia sesión con tu cuenta
3. Ve a **Configuración** → **Llaves API**
4. Copia tus llaves de **producción** (pub_prod_, prv_prod_)
5. Para webhooks: **Configuración** → **Eventos**
6. Para Integrity Key: **Desarrolladores** → **Secrets for technical integration**

---

## ⚙️ Configuración en el Panel

### **Paso 1: Configurar Wompi**
1. Ve a: **Integraciones → Wompi - Pagos**
2. Ingresa tus credenciales:
   - Public Key
   - Private Key  
   - Events Secret (opcional)
   - Integrity Key (opcional)
3. Haz clic en "Guardar Configuración"

### **Paso 2: Configurar Métodos de Pago**
1. Ve a: **Configuración → Métodos de Pago**
2. Habilita "Pago en línea"
3. Selecciona **Wompi** como pasarela preferida
4. Haz clic en "Guardar Cambios"

---

## 🔄 Flujo de Pago con Wompi

### **Frontend (Cliente):**

1. Cliente agrega productos al carrito
2. Hace clic en "Proceder al Pago"
3. Selecciona dirección de entrega
4. Selecciona "Pago en línea"
5. Hace clic en "Confirmar"
6. Se abre el **Widget de Wompi** (modal)
7. Cliente ingresa datos de la tarjeta/método de pago
8. Wompi procesa el pago
9. Cliente es redirigido a página de confirmación

### **Backend (Servidor):**

1. Wompi envía webhook con el resultado
2. Sistema actualiza el estado de la orden:
   - `APPROVED` → `payment_status = 'paid'`, `status = 'processing'`
   - `DECLINED` → `payment_status = 'failed'`
   - `VOIDED` → `payment_status = 'refunded'`
   - `ERROR` → `payment_status = 'failed'`

---

## 📡 Webhooks de Wompi

### **URL del Webhook:**
```
https://tu-dominio.com/payment/wompi/webhook
```

### **Configurar en Wompi:**
1. Ingresa a: https://comercios.wompi.co
2. Ve a **Configuración** → **Eventos**
3. Agrega la URL del webhook
4. Selecciona eventos a recibir:
   - `transaction.updated` ✅ (Recomendado)
   - `transaction.created`
   - `transaction.approved`

---

## 💻 Implementación Técnica

### **Archivos Creados:**

#### 1. **Handler JavaScript** 
`resources/views/components/payments/wompi/handler.blade.php`
- Carga el SDK de Wompi
- Configura el checkout widget
- Maneja la respuesta

#### 2. **Controlador de Webhooks**
`app/Http/Controllers/WompiWebhookController.php`
- Recibe webhooks de Wompi
- Valida firmas
- Actualiza estados de órdenes

#### 3. **Controlador de Integración**
`app/Http/Controllers/Creator/WompiIntegrationController.php`
- Panel de configuración
- Guardar credenciales

#### 4. **Vista de Configuración**
`resources/views/creator/integrations/wompi.blade.php`
- Formulario para credenciales
- Guía de configuración

---

## 🔐 Seguridad

### **Llaves Privadas:**
- Las llaves privadas se almacenan encriptadas en la base de datos
- **NUNCA** se envían al frontend
- Solo se usan en el backend para validaciones

### **Verificación de Webhooks:**
```php
// Verificar firma del webhook
$signature = $request->header('X-Event-Checksum');
$calculatedSignature = hash_hmac('sha256', $request->getContent(), $eventsSecret);

if ($signature !== $calculatedSignature) {
    // Webhook no válido
    return response()->json(['error' => 'Invalid signature'], 401);
}
```

---

## 🧪 Modo de Pruebas

### **Llaves de Prueba:**
- Public: `pub_test_XXXXXXXXXX`
- Private: `prv_test_XXXXXXXXXX`

### **Tarjetas de Prueba de Wompi:**

**Aprobada:**
- Número: `4242 4242 4242 4242`
- CVV: Cualquier 3 dígitos
- Fecha: Cualquier fecha futura

**Declinada:**
- Número: `4111 1111 1111 1111`
- CVV: Cualquier 3 dígitos
- Fecha: Cualquier fecha futura

---

## 📊 Estados de Transacción

| Estado Wompi | payment_status | order_status | Descripción |
|--------------|----------------|--------------|-------------|
| `APPROVED` | `paid` | `processing` | Pago aprobado |
| `DECLINED` | `failed` | `pending` | Pago rechazado |
| `VOIDED` | `refunded` | `cancelled` | Pago anulado |
| `ERROR` | `failed` | `pending` | Error en el pago |
| `PENDING` | `pending` | `pending` | Pendiente |

---

## 🚀 Ventajas de Wompi

✅ **Comisiones competitivas** - Tarifas transparentes
✅ **Múltiples métodos de pago** - Tarjetas, PSE, Nequi, Bancolombia
✅ **Integración sencilla** - API bien documentada
✅ **Soporte local** - Empresa colombiana
✅ **Pagos recurrentes** - Suscripciones y pagos automáticos
✅ **Link de pago** - Genera links para compartir
✅ **Dashboard completo** - Reportes y estadísticas

---

## 🔗 Enlaces Útiles

- **Panel de Comercios:** https://comercios.wompi.co
- **Documentación API:** https://wompi.com/es/co/desarrolladores/documentacion-tecnica
- **Widget Checkout:** https://checkout.wompi.co/widget.js
- **Soporte:** soporte@wompi.co

---

## ⚠️ Notas Importantes

1. **Usar llaves de producción** para transacciones reales
2. **Configurar webhooks** para recibir notificaciones automáticas
3. **Validar siempre** los webhooks con la firma
4. **Guardar las llaves** de forma segura (nunca en el código)
5. **Probar en modo test** antes de activar producción
6. **Firma de integridad**: Aunque es recomendada para mayor seguridad, el widget puede funcionar sin ella. La firma debe generarse en el backend usando SHA-256.

---

## 🔴 Solución de Problemas

### Error 403 al cargar el widget

Si recibes un error **403 Forbidden** al intentar pagar, significa que tu dominio no está autorizado en Wompi.

#### **Causas comunes:**

1. **Dominio no autorizado**: El dominio desde donde se carga el widget no está en la lista de dominios permitidos en Wompi
2. **Localhost con clave de producción**: Estás usando `localhost` o `127.0.0.1` con claves de producción (debes usar claves de prueba)
3. **Dominio incorrecto**: El dominio configurado en Wompi no coincide con el dominio real

#### **Solución paso a paso:**

##### **Para desarrollo local (localhost):**

⚠️ **IMPORTANTE:** Wompi puede bloquear `localhost` incluso con claves de prueba debido a restricciones de seguridad del CDN.

**Opción 1: Usar ngrok (Recomendado)**
1. Instala ngrok: https://ngrok.com/
2. Ejecuta: `ngrok http 8000` (o el puerto de tu aplicación)
3. Copia la URL HTTPS que ngrok te proporciona (ej: `https://abc123.ngrok.io`)
4. Usa esa URL para acceder a tu aplicación local
5. Las claves de prueba funcionarán con la URL de ngrok

**Opción 2: Verificar configuración en Wompi**
1. Asegúrate de usar **claves de prueba** (`pub_test_...` y `prv_test_...`)
2. Ingresa a: https://comercios.wompi.co
3. Ve a: **Desarrolladores** → **Modo de prueba**
4. Asegúrate de que el **Modo de prueba** esté **ACTIVADO**
5. Verifica que las claves sean de prueba (comienzan con `pub_test_`)

**Opción 3: Usar servidor de staging**
- Despliega tu aplicación en un servidor con dominio público (staging)
- Las claves de prueba funcionarán con el dominio público

##### **Para producción:**
1. Ingresa a tu panel de Wompi: https://comercios.wompi.co
2. Inicia sesión con tus credenciales
3. Ve a la sección **"Desarrolladores"** o **"Developers"** en el menú
4. Busca la opción **"Dominios Autorizados"** o **"Authorized Domains"**
5. Haz clic en **"Agregar Dominio"** o **"Add Domain"**
6. Ingresa tu dominio completo (ejemplo: `mitienda.com`)
7. **Importante**: Si tu sitio funciona tanto con `www` como sin `www`, agrega ambas versiones:
   - `mitienda.com`
   - `www.mitienda.com`
8. Guarda los cambios
9. Espera 2-3 minutos a que se propaguen los cambios
10. Prueba nuevamente el pago

**Nota:** Si no encuentras la sección "Desarrolladores", puede estar en:
- **Configuración** → **Integraciones** → **Dominios**
- **Settings** → **Integrations** → **Authorized Domains**

##### **Ejemplo de dominios a agregar:**
```
mitienda.com
www.mitienda.com
app.mitienda.com  (si usas subdominios)
```

##### **Verificación:**
- Abre la consola del navegador (F12)
- Intenta hacer un pago
- Si ves el error 403, verifica que tu dominio esté exactamente como lo agregaste en Wompi
- Revisa que no haya espacios adicionales o caracteres especiales

#### **Mensajes de error relacionados:**

- `Failed to load resource: the server responded with a status of 403 ()`
- `Error 403: El dominio no está autorizado`
- `FORBIDDEN` en los logs del widget
- `403 ERROR - Request blocked - Generated by cloudfront (CloudFront)` ⚠️ **Este es diferente**

#### **Error 403 de CloudFront (CDN de AWS)**

Si ves un mensaje como:
```
403 ERROR
The request could not be satisfied.
Request blocked. Generated by cloudfront (CloudFront)
```

**Esto NO es un problema de dominio no autorizado.** Es un problema temporal del CDN de Wompi.

**Causas posibles:**
- Problema temporal en los servidores de Wompi
- Bloqueo geográfico o de IP
- Demasiadas solicitudes (rate limiting)
- Mantenimiento en el servicio

**Soluciones:**
1. **Espera 2-3 minutos** e intenta nuevamente (suele resolverse automáticamente)
2. **Recarga la página** completamente (Ctrl+F5 o Cmd+Shift+R)
3. **Prueba desde otra conexión** de internet
4. **Verifica el estado del servicio**: https://status.wompi.co
5. Si persiste después de varios intentos, contacta soporte: soporte@wompi.co

**Nota:** Este tipo de error suele ser temporal y se resuelve automáticamente. Si persiste por más de 10-15 minutos, puede haber un problema más serio del servicio.

#### **Si el problema persiste:**

1. Verifica que estés usando las claves correctas (test vs producción)
2. Contacta al soporte de Wompi: soporte@wompi.co
3. Proporciona:
   - El dominio desde donde intentas usar el widget
   - El tipo de clave que estás usando (test o producción)
   - Captura de pantalla del error en la consola

---

## 🆚 Comparación: Wompi vs ePayco

| Característica | Wompi | ePayco |
|----------------|-------|--------|
| Comisión | 2.99% + $900 | 3.49% + $900 |
| PSE | ✅ | ✅ |
| Tarjetas | ✅ | ✅ |
| Nequi | ✅ | ❌ |
| Bancolombia | ✅ | ❌ |
| Efecty | ❌ | ✅ |
| Dashboard | Moderno | Completo |
| Soporte | Chat/Email | Teléfono/Email |

---

## 📝 Checklist de Implementación

- [x] Migración creada (campos de Wompi en `websites`)
- [x] Modelo actualizado (`Website.php`)
- [x] Controlador de integración creado
- [x] Vista de configuración creada
- [x] Handler JavaScript creado
- [x] Webhooks configurados
- [x] Rutas agregadas
- [x] Selector de pasarela en configuración
- [x] Widget integrado en checkout
- [ ] Probar con tarjetas de prueba
- [ ] Configurar webhooks en panel de Wompi
- [ ] Activar en producción con llaves reales

---

## 🎯 Próximos Pasos

1. **Obtener credenciales** de Wompi
2. **Configurar en el panel** (Integraciones → Wompi)
3. **Seleccionar como pasarela** (Configuración → Métodos de Pago)
4. **Probar con tarjetas de prueba**
5. **Configurar webhooks** en panel de Wompi
6. **Activar en producción**

¡La integración está lista para usarse! 🎉

