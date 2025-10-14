# 🌐 Sistema de Dominios Personalizados

## ✅ Lo que ya está implementado:

### 1. Base de Datos
- ✅ Tabla `domains` con todos los campos necesarios
- ✅ Modelo `Domain` con relaciones

### 2. Backend
- ✅ `DomainController` para gestión completa de dominios
- ✅ Método `showRoot()` actualizado para detectar dominios personalizados
- ✅ Verificación automática de DNS

### 3. Frontend
- ✅ Vista completa para configurar dominios (`creator/domains/index.blade.php`)
- ✅ Menú con enlace "Dominio Personalizado" en Configuración
- ✅ Instrucciones DNS integradas

### 4. Rutas
- ✅ `GET /creator/config/domain` - Ver dominios
- ✅ `POST /creator/config/domain` - Agregar dominio
- ✅ `POST /creator/config/domain/{domain}/verify` - Verificar DNS
- ✅ `PATCH /creator/config/domain/{domain}/set-primary` - Establecer como principal
- ✅ `DELETE /creator/config/domain/{domain}` - Eliminar dominio

## 🎯 Cómo usar (Para tus usuarios):

### Paso 1: Acceder a la configuración
1. Login en tu aplicación
2. Selecciona tu sitio web
3. Ve a: **Configuración → Dominio Personalizado**

### Paso 2: Agregar dominio
1. Escribe tu dominio (ej: `www.minegocio.com`)
2. Haz clic en "Agregar Dominio"
3. Aparecerán las instrucciones DNS

### Paso 3: Configurar DNS (Usuario final)

**En GoDaddy:**
1. Ir a "Mis Productos" → "DNS"
2. Agregar un nuevo registro:
   - **Tipo:** CNAME
   - **Nombre:** @  (o www)
   - **Valor:** creadorweb.eme10.com
   - **TTL:** 3600 (1 hora)
3. Guardar

**En Hostinger:**
1. Panel de Control → DNS/Nameservers
2. Agregar registro CNAME:
   - **Tipo:** CNAME
   - **Nombre:** @  (o www)
   - **Apunta a:** creadorweb.eme10.com
   - **TTL:** 3600
3. Guardar

### Paso 4: Verificar dominio
1. Esperar 5-10 minutos (la propagación DNS puede tardar hasta 48 horas)
2. En tu panel, hacer clic en "Verificar Ahora"
3. Si está configurado correctamente, aparecerá como "✓ Verificado"

## 🖥️ Lo que FALTA configurar (Servidor):

### 1. Configuración Apache/Nginx

**Para Apache (VirtualHost):**

Edita tu archivo de configuración de Apache (httpd.conf o sites-available):

```apache
<VirtualHost *:80>
    ServerName paginas.eme10.com
    ServerAlias *.paginas.eme10.com
    
    # IMPORTANTE: Aceptar TODOS los dominios
    ServerAlias *
    
    DocumentRoot "C:/xampp/htdocs/creador-de-sitios-web/public"
    
    <Directory "C:/xampp/htdocs/creador-de-sitios-web/public">
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog "logs/paginas-error.log"
    CustomLog "logs/paginas-access.log" combined
</VirtualHost>

<VirtualHost *:443>
    ServerName paginas.eme10.com
    ServerAlias *.paginas.eme10.com
    
    # IMPORTANTE: Aceptar TODOS los dominios
    ServerAlias *
    
    DocumentRoot "C:/xampp/htdocs/creador-de-sitios-web/public"
    
    SSLEngine on
    SSLCertificateFile "path/to/cert.pem"
    SSLCertificateKeyFile "path/to/key.pem"
    
    <Directory "C:/xampp/htdocs/creador-de-sitios-web/public">
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

**Para Nginx:**

```nginx
server {
    listen 80;
    listen 443 ssl http2;
    
    # Aceptar cualquier dominio
    server_name _;
    
    root /path/to/creador-de-sitios-web/public;
    index index.php index.html;
    
    # SSL
    ssl_certificate /path/to/cert.pem;
    ssl_certificate_key /path/to/key.pem;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

### 2. Configuración DNS de tu servidor

En tu proveedor de hosting (donde está `paginas.eme10.com`):

**Registro A (Principal):**
```
Tipo: A
Nombre: paginas.eme10.com
Valor: [IP_DE_TU_SERVIDOR]
TTL: 3600
```

**Registro A (Wildcard para subdominios):**
```
Tipo: A
Nombre: *.paginas.eme10.com
Valor: [IP_DE_TU_SERVIDOR]
TTL: 3600
```

### 3. SSL/HTTPS (Opcional pero recomendado)

**Opción A: Let's Encrypt (Gratis)**
```bash
# Instalar certbot
sudo apt-get install certbot python3-certbot-apache

# Obtener certificado wildcard
sudo certbot certonly --manual --preferred-challenges dns -d paginas.eme10.com -d *.paginas.eme10.com
```

**Opción B: Cloudflare (Gratis + CDN)**
1. Agregar `paginas.eme10.com` a Cloudflare
2. Activar SSL/TLS "Flexible" o "Full"
3. Los dominios de usuarios también tendrán SSL automáticamente

## 🧪 Probar el Sistema

### Test 1: Dominio personalizado
```
1. Usuario agrega: www.minegocio.com
2. Configura DNS: CNAME → paginas.eme10.com
3. Espera propagación
4. Verifica en el panel
5. Visita www.minegocio.com → Ve su sitio
```

### Test 2: Subdominio
```
1. Usuario crea sitio "Mi Restaurante"
2. Slug generado: mi-restaurante
3. Subdominio: mi-restaurante.creadorweb.eme10.com
4. Visita mi-restaurante.creadorweb.eme10.com → Ve su sitio
```

## 🔍 Orden de Detección de Dominios

Cuando alguien visita tu aplicación, el sistema busca en este orden:

1. **Dominio personalizado verificado** (ej: www.minegocio.com)
2. **Subdominio de creadorweb.eme10.com** (ej: mi-restaurante.creadorweb.eme10.com)
3. **Sesión del usuario** (si está logueado y tiene sitio seleccionado)
4. **Página de bienvenida** (si no coincide nada)

## 📝 Notas Importantes

1. **Propagación DNS:** Puede tardar hasta 48 horas
2. **SSL:** Necesitarás certificados SSL para dominios personalizados
3. **Wildcard SSL:** Recomendado para aceptar cualquier dominio
4. **Caché:** Algunos proveedores DNS cachean más tiempo
5. **TTL:** Valores bajos (3600) permiten cambios más rápidos

## 🚨 Troubleshooting

### "Dominio no verifica"
- Esperar más tiempo (hasta 48 hrs)
- Verificar que el CNAME esté correcto
- Usar herramientas online: https://dnschecker.org

### "ERR_SSL_PROTOCOL_ERROR"
- Necesitas configurar SSL en tu servidor
- Usar Cloudflare para SSL automático

### "Este sitio no se puede encontrar"
- DNS no configurado correctamente
- Servidor no acepta el dominio (revisar VirtualHost)

## 🎉 Resultado Final

Cuando todo esté configurado:

```
Usuario compra: www.restaurantelosandes.com
↓
Configura DNS → paginas.eme10.com
↓
Tu aplicación detecta el dominio
↓
Muestra el sitio del usuario
↓
¡Funciona! 🎊
```

## 📞 Soporte

Si tienes dudas sobre la configuración del servidor, contacta a tu proveedor de hosting o revisa su documentación sobre VirtualHosts y dominios múltiples.

