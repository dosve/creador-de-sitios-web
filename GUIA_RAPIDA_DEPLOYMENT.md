# ⚡ Guía Rápida - Poner en Producción

## 🎯 Objetivo

Subir tu aplicación a Hostinger y permitir que usuarios vinculen sus dominios personalizados.

## 📚 Archivos de Documentación

1. **`CONFIGURACION_HOSTINGER.md`** - Subir aplicación a Hostinger
2. **`CLOUDFLARE_SETUP.md`** - Configurar Cloudflare (dominos ilimitados)
3. **`DOMINIOS_PERSONALIZADOS.md`** - Cómo funciona el sistema

## ✅ Checklist de Deployment

### Fase 1: Preparar Aplicación (Local)

```bash
# En tu PC
cd C:\xampp\htdocs\creador-de-sitios-web

# Limpiar caché
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Exportar base de datos
# phpMyAdmin → Exportar → creador_sitios.sql

# Crear ZIP (sin node_modules, .git, storage/logs)
```

### Fase 2: Configurar Hostinger

1. **Subir archivos:**
   - Crear carpeta `public_html/paginas/`
   - Subir ZIP y extraer
   - Configurar Document Root: `/public_html/paginas/public`

2. **Base de datos:**
   - Crear base de datos MySQL
   - Importar dump SQL
   - Anotar credenciales

3. **Configurar .env:**
   ```env
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://paginas.eme10.com
   
   DB_DATABASE=u123_creador
   DB_USERNAME=u123_user
   DB_PASSWORD=***
   
   AUTH_EME10_BASE_URL=https://auth.eme10.com
   AUTH_EME10_CLIENT_ID=4
   ```

4. **Ejecutar comandos:**
   ```bash
   php artisan migrate --force
   php artisan storage:link
   php artisan config:cache
   php artisan route:cache
   chmod -R 775 storage bootstrap/cache
   ```

5. **Activar SSL:**
   - hPanel → SSL → Instalar SSL gratuito

### Fase 3: Configurar Cloudflare (Recomendado)

1. **Crear cuenta:** https://dash.cloudflare.com

2. **Agregar dominio:** `paginas.eme10.com`

3. **Configurar DNS:**
   ```
   Tipo: A | Nombre: @ | IP: [Hostinger IP] | Proxy: ON
   Tipo: A | Nombre: * | IP: [Hostinger IP] | Proxy: ON
   ```

4. **Cambiar nameservers** en tu registrador de dominio

5. **Configurar SSL:**
   - Modo: Full (strict)
   - Always Use HTTPS: ON

6. **Page Rules:**
   - Bypass cache: `*paginas.eme10.com/creator/*`
   - Always HTTPS: `*paginas.eme10.com/*`

### Fase 4: Verificar Funcionamiento

✅ **Probar estos puntos:**

1. Acceder a `https://paginas.eme10.com` → Ver página de bienvenida
2. Login con OAuth → Funciona
3. Crear un sitio web → Se crea correctamente
4. Ver preview del sitio → Se muestra bien
5. Configuración → Dominio Personalizado → Vista carga

### Fase 5: Probar Dominio Personalizado

**Test 1: Subdominio**
```
1. Crear sitio: "Mi Tienda"
2. Slug: mi-tienda
3. Asignar subdomain: mi-tienda
4. Visitar: https://mi-tienda.paginas.eme10.com
5. ✅ Debe mostrar el sitio
```

**Test 2: Dominio personalizado (test local)**
```
1. Editar archivo hosts:
   C:\Windows\System32\drivers\etc\hosts
   
2. Agregar:
   [IP_HOSTINGER] www.prueba.test
   
3. En tu app:
   Configuración → Dominio Personalizado
   Agregar: www.prueba.test
   
4. Visitar: http://www.prueba.test
5. ✅ Debe mostrar el sitio
```

## 🚀 Para Usuarios Finales

### Cómo un usuario usa su dominio

**Paso 1: Comprar dominio**
- GoDaddy, Hostinger, Namecheap, etc.
- Ejemplo: `www.minegocio.com`

**Paso 2: Configurar DNS**

En su proveedor de DNS:
```
Tipo: CNAME
Nombre: www
Valor: paginas.eme10.com
TTL: 3600
```

**Paso 3: Agregar en tu plataforma**
1. Login → Configuración → Dominio Personalizado
2. Agregar: `www.minegocio.com`
3. Seguir instrucciones DNS
4. Click "Verificar Ahora"

**Paso 4: Esperar propagación**
- 5-30 minutos normalmente
- Hasta 48 horas máximo

**Resultado:**
- ✅ `www.minegocio.com` muestra su sitio
- ✅ Con SSL gratis (si usas Cloudflare)

## 🔧 Mantenimiento

### Actualizar código

```bash
# 1. Subir nuevos archivos por FTP

# 2. Limpiar caché
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 3. Volver a cachear
php artisan config:cache
php artisan route:cache
```

### Ver logs de errores

```bash
# SSH en Hostinger
tail -f public_html/paginas/storage/logs/laravel.log
```

### Backup base de datos

```bash
# Desde phpMyAdmin → Exportar
# O configurar backups automáticos en Hostinger
```

## 📊 Monitoreo

### Cloudflare Analytics
- Dashboard → Analytics
- Ver tráfico, amenazas bloqueadas, cache

### Laravel Logs
- `storage/logs/laravel.log`
- Revisar diariamente

### Hostinger Metrics
- hPanel → Métricas
- Ver uso de recursos

## 🆘 Solución Rápida de Problemas

| Problema | Solución |
|----------|----------|
| Error 500 | Ver logs: `storage/logs/laravel.log` |
| Error 404 | Verificar Document Root apunta a `/public` |
| DB no conecta | Verificar credenciales en `.env` |
| SSL no funciona | Esperar 10 min, verificar Cloudflare SSL mode |
| Dominio no verifica | Esperar propagación DNS, usar dnschecker.org |
| Assets no cargan | Ejecutar `php artisan storage:link` |
| Cache problemas | `php artisan config:clear && cache:clear` |

## 💰 Costos Estimados

- **Hostinger Business:** ~$3.99-7.99/mes
- **Dominio paginas.eme10.com:** ~$10-15/año
- **Cloudflare Free:** $0/mes ✅
- **SSL:** $0 (incluido) ✅

**Total mensual:** ~$5-10 USD

## 🎉 Resultado Final

Con todo configurado:

```
👤 Usuario → www.sunegocio.com
    ↓
☁️ Cloudflare (SSL automático, CDN)
    ↓
🖥️ Hostinger (Laravel)
    ↓
🎨 Tu aplicación detecta dominio
    ↓
✨ Muestra sitio del usuario
```

## 📞 ¿Necesitas Ayuda?

1. **Hostinger:** https://support.hostinger.com
2. **Cloudflare:** https://support.cloudflare.com
3. **Laravel:** https://laravel.com/docs

---

**Tiempo estimado total:** 2-4 horas para deployment completo

**Dificultad:** Media (requiere familiaridad básica con hosting y DNS)

## ✅ Próximos Pasos

Después del deployment:
1. Probar con usuarios reales
2. Configurar backups automáticos
3. Monitorear rendimiento
4. Agregar más features según necesidad

¡Éxito con tu plataforma! 🚀

