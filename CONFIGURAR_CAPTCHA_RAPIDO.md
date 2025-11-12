# ⚡ Configurar CAPTCHA - Guía Rápida

## 🎯 Resumen: ¿Qué debo hacer?

El sistema **YA ESTÁ FUNCIONANDO** con claves de prueba de Google. Para usarlo en **PRODUCCIÓN**, sigue estos pasos:

---

## 📝 Pasos para Configurar CAPTCHA

### **OPCIÓN A: Usar Claves de Prueba (Desarrollo)** ⚠️

**¿Qué hacer?**
- ✅ **NADA** - Ya está configurado

**Ventaja:**
- Funciona inmediatamente en cualquier dominio

**Desventaja:**
- ⚠️ **NO protege realmente** - siempre aprueba el CAPTCHA
- Solo usar para desarrollo/pruebas

**Estado actual:**
```javascript
// Frontend (ya configurado)
const RECAPTCHA_SITE_KEY = '6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI';
```

---

### **OPCIÓN B: Usar Claves Reales (Producción)** ✅ RECOMENDADO

Si quieres **protección real** contra bots, necesitas tus propias claves:

---

## 🚀 Configuración en 3 Pasos

### **PASO 1: Obtener Claves de Google**

1. **Ve a:** https://www.google.com/recaptcha/admin
2. **Inicia sesión** con tu cuenta de Google
3. **Click en "+"** (crear nuevo sitio)
4. **Llena el formulario:**
   ```
   Label: Mi Tienda Online
   reCAPTCHA type: reCAPTCHA v2 → "I'm not a robot Checkbox"
   Domains: 
     - localhost
     - creadorweb.eme10.com
     - tu-dominio-real.com
   ```
5. **Acepta términos** y click en "Submit"
6. **Copia las claves** que te da Google

---

### **PASO 2: Configurar el Frontend**

**Archivo:** `creador-web-eme10/resources/views/components/user-auth-script.blade.php`

**Línea 8 - Cambiar esto:**
```javascript
// ❌ ANTES (clave de prueba)
const RECAPTCHA_SITE_KEY = '6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI';

// ✅ DESPUÉS (tu clave real)
const RECAPTCHA_SITE_KEY = 'TU_SITE_KEY_AQUI';
```

**Ejemplo:**
```javascript
const RECAPTCHA_SITE_KEY = '6Lc9xXYpAAAAABqw7n5K2m3vZ8jH9pL4qR2sT6u';
```

---

### **PASO 3: Configurar AdminNegocios**

**Archivo:** `servidor-adminnegocios/.env`

**Agregar/actualizar estas líneas:**
```env
# reCAPTCHA Configuration
RECAPTCHA_SITE_KEY=TU_SITE_KEY_AQUI
RECAPTCHA_SECRET_KEY=TU_SECRET_KEY_AQUI
RECAPTCHA_VERSION=v2
RECAPTCHA_ENABLED=true
```

**Ejemplo:**
```env
RECAPTCHA_SITE_KEY=6Lc9xXYpAAAAABqw7n5K2m3vZ8jH9pL4qR2sT6u
RECAPTCHA_SECRET_KEY=6Lc9xXYpAAAAAKz3mN9pQ8rV2wX5yH7jL4sK6u
RECAPTCHA_VERSION=v2
RECAPTCHA_ENABLED=true
```

---

## ✅ ¡LISTO! Ya está configurado

Después de hacer estos 3 pasos:
1. ✅ Recarga la página del creador de tiendas
2. ✅ Abre el modal de login
3. ✅ Verás el CAPTCHA funcionando con tus claves

---

## 🧪 Verificar que Funciona

### 1. Abrir tienda
```
http://localhost/creadorweb.eme10.com/mi-tienda
```

### 2. Click en ícono de usuario
```
[👤] ← Click aquí
```

### 3. Verificar CAPTCHA
Deberías ver:
```
☐ No soy un robot
reCAPTCHA
```

### 4. Intentar login SIN completar CAPTCHA
Debería mostrar: **"Por favor, completa el CAPTCHA"**

### 5. Completar CAPTCHA y login
✅ Debería funcionar correctamente

---

## ⚡ Resumen Ultra-Rápido

### Para **DESARROLLO** (ahora):
```
✅ No hacer nada - ya funciona con claves de prueba
```

### Para **PRODUCCIÓN** (después):
```
1. Obtener claves en: google.com/recaptcha/admin
2. Cambiar línea 8 en: user-auth-script.blade.php
3. Actualizar .env en: servidor-adminnegocios
4. ✅ Listo
```

---

## 🎯 Archivos a Modificar

### Frontend (Creador de Tiendas)
```
📁 creador-web-eme10/
   └── resources/views/components/user-auth-script.blade.php
       └── Línea 8: RECAPTCHA_SITE_KEY = 'TU_CLAVE'
```

### Backend (AdminNegocios)
```
📁 servidor-adminnegocios/
   └── .env
       └── RECAPTCHA_SITE_KEY=TU_CLAVE
       └── RECAPTCHA_SECRET_KEY=TU_CLAVE_SECRETA
```

---

## 💡 Consejo

### ¿Cuándo cambiar las claves?

- **Desarrollo/Pruebas:** Deja las claves de prueba
- **Antes de lanzar:** Cambia a claves reales
- **En producción:** Usa claves reales siempre

---

## 🆘 Si Tienes Problemas

### CAPTCHA no aparece
```
1. Ctrl + F5 (recarga forzada)
2. Verifica que tengas internet
3. Revisa consola del navegador (F12)
```

### Error "Token de CAPTCHA requerido"
```
✅ Completa el checkbox "No soy un robot"
✅ El sistema ahora valida antes de enviar
```

### CAPTCHA aparece pero no valida
```
1. Verifica que la SITE_KEY sea correcta
2. Verifica que la SECRET_KEY en AdminNegocios sea correcta
3. Verifica que ambas sean del mismo sitio en Google
```

---

## 🎉 Estado Actual

### ✅ CAPTCHA Ya Configurado:

- ✅ Login → Con CAPTCHA
- ✅ Registro → Con CAPTCHA
- ✅ Recuperar contraseña → Con CAPTCHA

### ✅ Usando:

**Claves de Prueba de Google** (funcionan pero no protegen realmente)

### 🚀 Para Producción:

Cambiar a **claves reales** siguiendo los 3 pasos arriba.

---

**¡El CAPTCHA está funcionando!** 🎊

Solo necesitas decidir si quieres:
- 🧪 **Dejarlo así** para desarrollo (claves de prueba)
- 🚀 **Cambiarlo** para producción (claves reales)

