# 🚀 Configuración en Hostinger - Dominios Personalizados

## 📋 Requisitos Previos

- ✅ Cuenta de Hostinger (Business o superior recomendado)
- ✅ Dominio `paginas.eme10.com` (o el que uses)
- ✅ Aplicación Laravel funcionando localmente

## 🎯 Pasos de Configuración

### Paso 1: Configurar Dominio Principal

#### 1.1 Agregar dominio en Hostinger

1. Ir a **hPanel** → **Dominios**
2. Click en **Agregar Dominio** o usar dominio existente
3. Apuntar a: `paginas.eme10.com`

#### 1.2 Configurar Document Root

1. En hPanel → **Administrador de Archivos**
2. Crear estructura:
   ```
   public_html/
   └── paginas/
       └── [archivos de Laravel aquí]
   ```

3. En **Dominios** → Configurar `paginas.eme10.com`:
   - Document Root: `/public_html/paginas/public`

### Paso 2: Subir Aplicación Laravel

#### 2.1 Preparar archivos localmente

En tu PC, ejecuta:

```bash
cd C:\xampp\htdocs\creador-de-sitios-web

# Limpiar caché
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Optimizar para producción
php artisan config:cache
php artisan route:cache
```

#### 2.2 Crear archivo .zip

Crear un ZIP con TODOS los archivos EXCEPTO:
- `node_modules/`
- `.git/`
- `storage/logs/*` (vaciar los logs)
- `.env` (lo crearás en el servidor)

#### 2.3 Subir a Hostinger

**Método 1: Administrador de Archivos**
1. hPanel → **Administrador de Archivos**
2. Ir a `/public_html/paginas/`
3. Subir el archivo .zip
4. Hacer click derecho → **Extraer**
5. Eliminar el .zip

**Método 2: FTP (Más rápido)**
1. Usar FileZilla o WinSCP
2. Conectar con credenciales FTP de Hostinger
3. Subir carpeta completa a `/public_html/paginas/`

#### 2.4 Configurar .env

1. En Administrador de Archivos, ir a `/public_html/paginas/`
2. Crear archivo `.env` (copiar de `.env.example`)
3. Configurar:

```env
APP_NAME="Creador de Sitios Web"
APP_ENV=production
APP_KEY=base64:... # Generar con: php artisan key:generate
APP_DEBUG=false
APP_URL=https://paginas.eme10.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=u123456789_creador
DB_USERNAME=u123456789_user
DB_PASSWORD=TuPassword123

# Auth EME10
AUTH_EME10_BASE_URL=https://auth.eme10.com
AUTH_EME10_CLIENT_ID=4
AUTH_EME10_REDIRECT_URI="${APP_URL}/auth/oauth/callback"

SESSION_DRIVER=file
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
```

#### 2.5 Configurar Base de Datos

1. hPanel → **Bases de Datos MySQL**
2. Click **Crear Base de Datos**
3. Nombre: `u123456789_creador`
4. Crear usuario y contraseña
5. Anotar credenciales para `.env`

#### 2.6 Importar Base de Datos

**Opción A: phpMyAdmin**
1. hPanel → **phpMyAdmin**
2. Seleccionar base de datos creada
3. Importar → Seleccionar archivo SQL local
4. Ejecutar

**Opción B: Exportar/Importar**
```bash
# En tu PC (exportar)
cd C:\xampp\htdocs\creador-de-sitios-web
php artisan migrate:fresh --seed # O exportar DB real

# Crear dump
# Usar phpMyAdmin de XAMPP → Exportar
```

#### 2.7 Ejecutar migraciones

En **Terminal SSH** de Hostinger:
```bash
cd public_html/paginas
php artisan migrate --force
php artisan storage:link
```

### Paso 3: Configurar Permisos

En Terminal SSH o File Manager:

```bash
cd public_html/paginas

# Permisos storage y bootstrap/cache
chmod -R 775 storage bootstrap/cache
chown -R u123456789:u123456789 storage bootstrap/cache
```

### Paso 4: SSL/HTTPS

#### 4.1 Activar SSL Gratuito (Let's Encrypt)

1. hPanel → **SSL**
2. Seleccionar `paginas.eme10.com`
3. Click **Instalar SSL**
4. Esperar 5-10 minutos

#### 4.2 Forzar HTTPS

En `/public_html/paginas/public/.htaccess`, agregar al inicio:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    
    # Forzar HTTPS
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
</IfModule>
```

### Paso 5: Configurar para Múltiples Dominios

#### 5.1 Configurar Addon Domains (Hostinger)

Hostinger NO soporta wildcard ServerAlias nativamente en hosting compartido, pero podemos usar **Addon Domains** para cada dominio de usuario.

**Cuando un usuario agregue un dominio:**

1. El usuario configura su DNS: `CNAME → paginas.eme10.com`
2. TÚ agregas manualmente el dominio en Hostinger:
   - hPanel → **Dominios** → **Agregar Addon Domain**
   - Dominio: `www.minegocio.com`
   - Document Root: `/public_html/paginas/public` (el mismo)

**Esto es MANUAL** por cada dominio de usuario. 

#### 5.2 Alternativa: Usar Cloudflare (Recomendado)

Cloudflare permite manejar múltiples dominios sin agregar cada uno manualmente:

1. **Configurar Cloudflare para paginas.eme10.com:**
   - Crear cuenta en Cloudflare
   - Agregar `paginas.eme10.com`
   - Cambiar nameservers en tu registrador de dominio

2. **Agregar DNS en Cloudflare:**
   ```
   Tipo: A
   Nombre: @
   Contenido: [IP de Hostinger]
   Proxy: Activado (nube naranja)
   
   Tipo: A
   Nombre: *
   Contenido: [IP de Hostinger]
   Proxy: Activado (nube naranja)
   ```

3. **Configurar SSL en Cloudflare:**
   - SSL/TLS → Full (strict)
   - Edge Certificates → Always Use HTTPS: ON
   - Universal SSL: Activado

4. **Instrucciones para usuarios:**
   - Los usuarios apuntan su dominio a Cloudflare Workers o directamente:
   - `CNAME → paginas.eme10.com`
   - Cloudflare manejará el SSL automáticamente

### Paso 6: Optimizaciones de Producción

#### 6.1 Composer en producción

```bash
cd public_html/paginas
composer install --optimize-autoloader --no-dev
```

#### 6.2 Optimizar Laravel

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

#### 6.3 Configurar Cron Jobs (Para tareas programadas)

1. hPanel → **Cron Jobs**
2. Agregar:
   ```
   * * * * * cd /home/u123456789/public_html/paginas && php artisan schedule:run >> /dev/null 2>&1
   ```

### Paso 7: Probar el Sistema

#### 7.1 Verificar instalación

1. Visitar: `https://paginas.eme10.com`
2. Debería cargar la página de bienvenida

#### 7.2 Verificar OAuth

1. Login con Auth EME10
2. Crear un sitio web
3. Verificar preview

#### 7.3 Probar dominio personalizado

**Test local (sin dominio real):**
1. Editar archivo `hosts` en tu PC:
   - Windows: `C:\Windows\System32\drivers\etc\hosts`
   - Agregar: `[IP_HOSTINGER] www.minegocio.test`
2. Agregar dominio en tu panel: `www.minegocio.test`
3. Visitar en navegador

## 🚀 Solución Escalable: CloudFlare Workers (Opcional)

Para manejar MILES de dominios sin agregarlos manualmente:

### Crear Worker en Cloudflare

```javascript
addEventListener('fetch', event => {
  event.respondWith(handleRequest(event.request))
})

async function handleRequest(request) {
  const url = new URL(request.url)
  
  // Reescribir el host al servidor real
  const targetURL = `https://paginas.eme10.com${url.pathname}${url.search}`
  
  // Copiar request pero cambiar Host header
  const modifiedRequest = new Request(targetURL, {
    method: request.method,
    headers: request.headers,
    body: request.body,
  })
  
  // Agregar header con el dominio original
  modifiedRequest.headers.set('X-Forwarded-Host', url.hostname)
  
  // Hacer request al servidor
  const response = await fetch(modifiedRequest)
  
  return response
}
```

Luego en Laravel, detectar el dominio con:
```php
$host = request()->header('X-Forwarded-Host') ?? request()->getHost();
```

## 📝 Lista de Verificación Final

- [ ] Aplicación subida y funcionando en `paginas.eme10.com`
- [ ] Base de datos configurada y migrada
- [ ] SSL instalado y funcionando (HTTPS)
- [ ] Permisos de storage configurados
- [ ] .env configurado correctamente
- [ ] OAuth funcionando con auth.eme10.com
- [ ] Usuarios pueden crear sitios
- [ ] Subdominios funcionan (ej: `misitioweb.paginas.eme10.com`)
- [ ] Sistema de dominios personalizados probado

## 🆘 Troubleshooting

### Error 500
```bash
# Ver logs
tail -f public_html/paginas/storage/logs/laravel.log
```

### Error de permisos
```bash
chmod -R 775 storage bootstrap/cache
```

### Base de datos no conecta
- Verificar credenciales en `.env`
- Verificar que DB_HOST sea `localhost`

### SSL no funciona
- Esperar 10-15 minutos después de instalar
- Verificar que Cloudflare esté en modo "Full (strict)"

## 🎉 Próximos Pasos

1. **Para dominios de usuarios:**
   - Usar Cloudflare (automático)
   - O agregar manualmente cada dominio en Hostinger

2. **Monitoreo:**
   - Configurar Laravel Telescope (desarrollo)
   - Usar logs de Hostinger

3. **Backups:**
   - Hostinger hace backups automáticos
   - Considera backups adicionales de BD

## 📞 Recursos

- **Panel Hostinger:** https://hpanel.hostinger.com
- **Documentación Hostinger:** https://support.hostinger.com
- **Cloudflare:** https://dash.cloudflare.com
- **Laravel Deployment:** https://laravel.com/docs/deployment

---

**¿Necesitas ayuda?** Contacta a soporte de Hostinger o consulta los logs en `storage/logs/laravel.log`

