# 🌐 Vincular Dominio a Sitio Creado

## ✅ Pre-requisito

Tu aplicación ya está funcionando en: `https://paginas.eme10.com`

## 🎯 Pasos para Vincular un Dominio

### Opción A: Usar Cloudflare (Recomendado - Automático)

#### 1. Configurar Cloudflare una sola vez

**a) Crear cuenta en Cloudflare:**
- Ir a: https://dash.cloudflare.com/sign-up
- Crear cuenta gratis

**b) Agregar tu dominio principal:**
1. Click "Add a Site"
2. Ingresar: `paginas.eme10.com`
3. Plan: **Free** → Continue

**c) Configurar DNS en Cloudflare:**
```
Tipo: A
Nombre: @
Contenido: [IP de tu Hostinger]
Proxy: ✅ Activado (nube naranja)

Tipo: A  
Nombre: *
Contenido: [IP de tu Hostinger]
Proxy: ✅ Activado (nube naranja)
```

**¿Cómo obtener IP de Hostinger?**
- hPanel → Información de hosting → IP del servidor
- O conectar por SSH y ejecutar: `curl ifconfig.me`

**d) Cambiar nameservers:**
1. Cloudflare te dará 2 nameservers (ej: `alicia.ns.cloudflare.com`)
2. Ir al registrador donde compraste `paginas.eme10.com`
3. Cambiar nameservers a los que te dio Cloudflare
4. Esperar 5-30 minutos

**e) Configurar SSL en Cloudflare:**
1. SSL/TLS → Modo: **Full (strict)**
2. Edge Certificates → **Always Use HTTPS: ON**

**🎉 ¡Listo! Una sola vez y ya puedes aceptar CUALQUIER dominio.**

---

#### 2. Cuando un usuario quiera vincular su dominio

**Ejemplo:** Usuario compró `www.minegocio.com` en GoDaddy

**PASO 1 - Usuario configura su DNS:**

En GoDaddy (o donde compró el dominio):
1. Ir a: Administrar DNS
2. Agregar registro:
   ```
   Tipo: CNAME
   Nombre: www (o @)
   Apunta a: paginas.eme10.com
   TTL: 3600 (1 hora)
   ```
3. Guardar

**PASO 2 - Usuario agrega dominio en tu plataforma:**

1. Login → Seleccionar su sitio web
2. Ir a: **Configuración → Dominio Personalizado**
3. Ingresar: `www.minegocio.com`
4. Click **"Agregar Dominio"**
5. Seguir instrucciones que aparecen en pantalla

**PASO 3 - Verificar:**

1. Esperar 10-30 minutos (propagación DNS)
2. Click en **"Verificar Ahora"**
3. Si está bien configurado → ✅ Aparece "Verificado"

**PASO 4 - Establecer como principal (opcional):**

1. Si tiene múltiples dominios
2. Click **"Establecer como Principal"**
3. Este será el dominio principal de su sitio

**🎉 ¡Listo! Ahora `www.minegocio.com` muestra su sitio con SSL gratis.**

---

### Opción B: Sin Cloudflare (Manual - Más trabajo)

Si NO quieres usar Cloudflare, cada dominio de usuario debes agregarlo MANUALMENTE en Hostinger:

#### Cuando un usuario agregue dominio:

**PASO 1 - Usuario configura DNS:**
```
Tipo: CNAME
Nombre: www
Apunta a: paginas.eme10.com
```

**PASO 2 - Usuario agrega en tu plataforma:**
- Configuración → Dominio Personalizado → Agregar dominio

**PASO 3 - TÚ agregas en Hostinger (Manual):**

1. hPanel → **Dominios**
2. Click **"Agregar Addon Domain"**
3. Configurar:
   - Dominio: `www.minegocio.com`
   - Document Root: `/public_html/paginas/public` (el mismo de tu app)
4. Guardar
5. Esperar 5-10 minutos
6. Activar SSL para ese dominio

**PASO 4 - Verificar en tu plataforma:**
- El usuario hace click en "Verificar Ahora"
- ✅ Debe aparecer como verificado

**❌ Desventaja:** Debes hacer esto MANUALMENTE para cada dominio de usuario.

---

## 🎯 Recomendación Final

**USA CLOUDFLARE (Opción A):**

✅ Configuras UNA SOLA VEZ
✅ Después AUTOMÁTICO para todos los dominios
✅ SSL gratis para todos
✅ CDN incluido (sitios más rápidos)
✅ Sin límite de dominios

**Sin Cloudflare (Opción B):**
❌ Trabajo manual por cada dominio
❌ Sin SSL automático
❌ Más lento
❌ No escalable si tienes muchos usuarios

---

## 📝 Resumen Ultra-Corto

### Con Cloudflare (Una vez):
```
1. Crear cuenta Cloudflare
2. Agregar paginas.eme10.com
3. Configurar DNS (A records @ y *)
4. Cambiar nameservers
5. Activar SSL
✅ Listo para siempre
```

### Cada usuario (Automático):
```
1. Usuario configura: CNAME → paginas.eme10.com
2. Usuario agrega dominio en tu plataforma
3. Espera 10-30 min
4. Verifica
✅ Funciona con SSL
```

---

## 🆘 Ayuda Rápida

**¿Cómo obtener IP de Hostinger?**
- hPanel → Hosting → Información del servidor

**¿Dónde cambio nameservers?**
- En el registrador donde compraste `paginas.eme10.com`
- GoDaddy: Dominios → Administrar → Nameservers
- Namecheap: Domain List → Manage → Nameservers
- Hostinger: Dominios → Nameservers

**¿Cuánto tarda?**
- Cloudflare: 5-30 minutos para activar
- Dominios de usuarios: 10 minutos - 48 horas (depende del DNS)

**¿Es gratis Cloudflare?**
- ✅ SÍ, plan Free es suficiente

---

## ✅ Checklist

- [ ] Cloudflare configurado con `paginas.eme10.com`
- [ ] Nameservers cambiados
- [ ] DNS configurado (A @ y A *)
- [ ] SSL en modo "Full (strict)"
- [ ] Always Use HTTPS activado
- [ ] Tu aplicación funciona en `https://paginas.eme10.com`
- [ ] Probaste con un dominio de prueba
- [ ] Sistema de dominios funciona en tu panel

---

**¿Dudas?** Pregúntame lo que necesites.

