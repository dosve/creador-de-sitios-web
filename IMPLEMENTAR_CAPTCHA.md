# ⚡ Guía de Implementación de CAPTCHA

## 🎯 Para Implementar en TUS Sistemas

Esta guía te dice **exactamente** qué hacer para tener CAPTCHA funcionando en producción.

---

## 📋 OPCIÓN 1: Usar Claves de Prueba (AHORA MISMO) ✅

### ¿Qué hacer?
**NADA** - Ya está todo configurado y funcionando.

### Estado Actual:
- ✅ CAPTCHA aparece en los modales
- ✅ Validación funciona
- ✅ Conectado con AdminNegocios

### ⚠️ Importante:
Las claves de prueba **siempre aprueban** el CAPTCHA, no protegen realmente contra bots.

**Usar solo para:** Desarrollo y pruebas

---

## 🚀 OPCIÓN 2: Claves Reales para PRODUCCIÓN

### PASO 1: Obtener tus Claves de Google (5 minutos)

#### 1.1 Ir a Google reCAPTCHA
```
https://www.google.com/recaptcha/admin
```

#### 1.2 Crear Nuevo Sitio
Click en el botón **"+"** (arriba derecha)

#### 1.3 Llenar Formulario

```
┌─────────────────────────────────────────┐
│ Label (etiqueta):                       │
│ [Mis Tiendas Online____________]        │
│                                         │
│ reCAPTCHA type:                         │
│ ◉ reCAPTCHA v2                          │
│   ☑ "I'm not a robot" Checkbox          │
│                                         │
│ Domains (dominios):                     │
│ [localhost___________________]  + Agregar
│ [creadorweb.eme10.com________]  + Agregar
│ [tudominio.com_______________]  + Agregar
│                                         │
│ ☑ Acepto los términos de servicio      │
│                                         │
│           [Submit]                      │
└─────────────────────────────────────────┘
```

**IMPORTANTE:** Agrega TODOS los dominios donde usarás el CAPTCHA:
- `localhost` (para desarrollo local)
- `127.0.0.1` (para desarrollo local)
- `creadorweb.eme10.com` (tu dominio de creador)
- Cualquier otro dominio personalizado

#### 1.4 Copiar las Claves

Después de crear, Google te mostrará:

```
┌─────────────────────────────────────────┐
│ Site Key:                               │
│ 6Lc9xXYpAAAAABqw7n5K2m3vZ8jH9pL4qR2s  │
│ [Copiar]                                │
│                                         │
│ Secret Key:                             │
│ 6Lc9xXYpAAAAAKz3mN9pQ8rV2wX5yH7jL4sK  │
│ [Copiar]                                │
└─────────────────────────────────────────┘
```

**📝 Copia ambas claves** - las necesitarás en los siguientes pasos.

---

### PASO 2: Configurar el Creador de Tiendas

#### 2.1 Abrir el Archivo
```
C:\xampp\htdocs\creador-web-eme10\resources\views\components\user-auth-script.blade.php
```

#### 2.2 Buscar la Línea 8
```javascript
const RECAPTCHA_SITE_KEY = '6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI';
```

#### 2.3 Reemplazar con TU Site Key
```javascript
const RECAPTCHA_SITE_KEY = '6Lc9xXYpAAAAABqw7n5K2m3vZ8jH9pL4qR2s'; // ← Pega AQUÍ tu Site Key
```

#### 2.4 Guardar el Archivo
```
Ctrl + S
```

---

### PASO 3: Configurar AdminNegocios

#### 3.1 Abrir el Archivo .env
```
C:\xampp\htdocs\servidor-adminnegocios\.env
```

#### 3.2 Buscar o Agregar estas Líneas

Si ya existen, **actualízalas**. Si no existen, **agrégalas** al final del archivo:

```env
# reCAPTCHA Configuration
RECAPTCHA_SITE_KEY=6Lc9xXYpAAAAABqw7n5K2m3vZ8jH9pL4qR2s
RECAPTCHA_SECRET_KEY=6Lc9xXYpAAAAAKz3mN9pQ8rV2wX5yH7jL4sK
RECAPTCHA_VERSION=v2
RECAPTCHA_ENABLED=true
```

**⚠️ IMPORTANTE:** 
- **SITE_KEY** va en ambos archivos (frontend y backend)
- **SECRET_KEY** solo va en AdminNegocios (backend)

#### 3.3 Guardar el Archivo
```
Ctrl + S
```

---

### PASO 4: Verificar

#### 4.1 Reiniciar Servidor (si es necesario)
```bash
# Si usas Apache
# No necesitas hacer nada

# Si usas php artisan serve
# Detener (Ctrl+C) y volver a iniciar
php artisan serve
```

#### 4.2 Probar en el Navegador

1. **Recarga la página** (Ctrl + F5)
2. **Abre el modal de login** (click en [👤])
3. **Verás el CAPTCHA real** de Google
4. **Completa el CAPTCHA**
5. **Intenta login**
6. ✅ **Debería funcionar**

---

## 📊 Comparación: Claves de Prueba vs Reales

| Aspecto | Claves de Prueba | Claves Reales |
|---------|------------------|---------------|
| **Protección** | ❌ No protege | ✅ Protege contra bots |
| **Dominios** | ✅ Cualquiera | Solo los configurados |
| **Configuración** | ✅ Ya está | Requiere 3 pasos |
| **Usar en** | Desarrollo | Producción |
| **Costo** | Gratis | Gratis |

---

## 🎯 Resumen Ultra-Rápido

### Para Desarrollo (AHORA):
```
✅ No hacer nada
✅ Ya funciona con claves de prueba
✅ Solo para testing
```

### Para Producción (ANTES DE LANZAR):

```
1️⃣ Google reCAPTCHA Admin → Obtener claves
2️⃣ user-auth-script.blade.php línea 8 → Pegar Site Key
3️⃣ AdminNegocios .env → Pegar ambas claves
4️⃣ Ctrl + F5 → Probar
✅ Listo!
```

---

## 📁 Archivos a Modificar

### 1. Frontend (Creador de Tiendas)
```
📂 C:\xampp\htdocs\creador-web-eme10\
   └── resources\views\components\user-auth-script.blade.php
       └── Línea 8: RECAPTCHA_SITE_KEY
```

### 2. Backend (AdminNegocios)
```
📂 C:\xampp\htdocs\servidor-adminnegocios\
   └── .env
       ├── RECAPTCHA_SITE_KEY
       └── RECAPTCHA_SECRET_KEY
```

---

## ⚡ Comando Rápido (Producción)

### Editar Frontend:
```bash
code C:\xampp\htdocs\creador-web-eme10\resources\views\components\user-auth-script.blade.php
```
Buscar línea 8 y cambiar la clave.

### Editar Backend:
```bash
code C:\xampp\htdocs\servidor-adminnegocios\.env
```
Agregar/actualizar las 4 líneas de RECAPTCHA.

---

## 🧪 Prueba Rápida

### ¿Está funcionando?

1. **Abre:** http://localhost/creadorweb.eme10.com/tu-tienda
2. **Click:** [👤]
3. **¿Ves esto?** ☐ No soy un robot
4. **¿Puedes hacer clic?** ☑ No soy un robot
5. **¿Login funciona?** ✅ Sí
6. **Resultado:** ✅ CAPTCHA funcionando

---

## ❓ ¿Cuándo Cambiar las Claves?

### Claves de Prueba - Usar cuando:
- ✅ Estás desarrollando
- ✅ Estás haciendo pruebas
- ✅ Estás en localhost
- ✅ No te importa la protección real

### Claves Reales - Usar cuando:
- ✅ Vas a lanzar a producción
- ✅ Quieres protección real contra bots
- ✅ Tu sitio está en un dominio público
- ✅ Tienes usuarios reales

---

## 🎊 Estado Actual

### ✅ CAPTCHA Implementado en:

1. **Modal de Login**
   - Email + Contraseña + **CAPTCHA** ✅

2. **Modal de Registro**
   - Nombre + Email + Teléfono + Contraseña + **CAPTCHA** ✅

3. **Modal de Recuperar Contraseña (Paso 1)**
   - Email + **CAPTCHA** ✅

### ✅ Validaciones:

- Si no completa CAPTCHA → Error claro
- CAPTCHA se resetea después de errores
- Token se envía a AdminNegocios
- AdminNegocios valida con Google

---

## 🎯 Decisión Rápida

### ¿Qué hacer AHORA?

```
┌─────────────────────────────────────┐
│ ¿Estás en desarrollo/pruebas?       │
└──────┬──────────────────────┬───────┘
       │                      │
      SÍ                     NO (Producción)
       │                      │
       ▼                      ▼
┌─────────────┐      ┌──────────────────┐
│ ✅ NO HACER │      │ Obtener claves   │
│    NADA     │      │ reales de Google │
│             │      │ (3 pasos arriba) │
│ Ya funciona │      └──────────────────┘
└─────────────┘
```

---

## 📞 Resumen para Ti

### Para usar AHORA (Desarrollo):
```
✅ Todo listo - ya funciona
```

### Para producción (Después):
```
1. google.com/recaptcha/admin → Obtener claves
2. Editar 2 archivos:
   - user-auth-script.blade.php (línea 8)
   - servidor-adminnegocios/.env (4 líneas)
3. Guardar y recargar
✅ Listo para producción
```

---

**¡El CAPTCHA ya está funcionando en tus sistemas!** 🎉

Solo decide si quieres seguir con claves de prueba (desarrollo) o cambiar a claves reales (producción).

