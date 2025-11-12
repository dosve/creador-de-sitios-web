# 🔧 Solución para id-moda.com en Producción

## ✅ LOCAL FUNCIONA - PRODUCCIÓN NO

### **Estado:**
- ✅ `127.0.0.1:8000/eme10/productos` → **FUNCIONA**
- ❌ `id-moda.com/sobre-nosotros` → **404 NOT FOUND**

---

## 🎯 SOLUCIÓN PARA PRODUCCIÓN

### **PASO 1: Subir los archivos actualizados**

Los archivos que cambiamos:
```
✅ routes/web.php (rutas arregladas)
✅ app/Http/Controllers/WebsiteController.php (logs agregados)
```

**Comando para subir:**
```bash
# Subir por Git
git add .
git commit -m "Fix: Rutas de dominios personalizados"
git push origin main

# O subir por FTP los archivos:
- routes/web.php
- app/Http/Controllers/WebsiteController.php
```

---

### **PASO 2: Limpiar caché en PRODUCCIÓN**

Conéctate por SSH a Hostinger y ejecuta:

```bash
cd /home/tu-usuario/public_html

# Limpiar todas las cachés
php artisan route:clear
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

**Si no tienes SSH:**

Crea un archivo temporal `clear-cache.php` en la raíz:

```php
<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

Artisan::call('route:clear');
Artisan::call('config:clear');
Artisan::call('cache:clear');
Artisan::call('view:clear');

echo "Caché limpiada exitosamente";
```

Luego accede a: `https://id-moda.com/clear-cache.php`

---

### **PASO 3: Verificar los logs en PRODUCCIÓN**

**Opción A - Por SSH:**
```bash
tail -f storage/logs/laravel.log
```

**Opción B - Por FTP:**
Descarga el archivo:
```
storage/logs/laravel.log
```

Luego accede a: `https://id-moda.com/sobre-nosotros`

---

### **PASO 4: Verificar que la página existe**

Ejecuta en producción (por SSH o phpMyAdmin):

```sql
-- Ver las páginas del sitio ID Moda (website_id = 4)
SELECT id, title, slug, is_published 
FROM pages 
WHERE website_id = 4;
```

**Verifica:**
- ✅ Existe una página con slug = `sobre-nosotros`
- ✅ La página tiene `is_published = 1`

---

### **PASO 5: Si la página NO existe**

Créala desde el panel:

1. Ve al creador
2. Selecciona el sitio "ID Moda"
3. Páginas → Nueva Página
4. Título: "Sobre Nosotros"
5. Slug: `sobre-nosotros`
6. ✅ Marcar como publicada
7. Guardar

---

## 🔍 DIAGNÓSTICO RÁPIDO

### **Comprueba en phpMyAdmin:**

```sql
-- Verificar dominio
SELECT * FROM domains WHERE domain = 'id-moda.com';
-- Debe tener: is_verified=1, status='active', website_id=4

-- Verificar páginas
SELECT * FROM pages WHERE website_id = 4;
-- Busca la página "sobre-nosotros" y verifica is_published=1
```

---

## ⚠️ POSIBLES PROBLEMAS

### **1. Archivos no actualizados en servidor:**
→ Sube los archivos por Git o FTP

### **2. Caché vieja:**
→ Limpia la caché con los comandos de arriba

### **3. Página no existe o no está publicada:**
→ Créala o publícala

### **4. .htaccess no está en /public:**
→ Súbelo manualmente

---

## 🚀 CHECKLIST

- [ ] Archivos actualizados subidos a producción
- [ ] Caché limpiada en servidor
- [ ] Página "sobre-nosotros" existe en BD
- [ ] Página "sobre-nosotros" está publicada
- [ ] Dominio id-moda.com verificado
- [ ] .htaccess en carpeta /public

---

## 📞 SIGUIENTE PASO

**Compárteme:**
1. ¿Ya subiste los archivos a producción?
2. ¿Ya limpiaste la caché?
3. Los logs que aparezcan cuando accedas a `id-moda.com/sobre-nosotros`

Con esa info te doy la solución exacta.

---

**Creado:** 5 Nov 2025
**Estado:** Esperando logs de producción

