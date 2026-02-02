# Guía de SEO para Creador Web - Configuración Completa

## 📋 Resumen de Cambios Implementados

Se han implementado mejoras SEO completas para asegurar que los sitios web creados con tu plataforma se rankeen correctamente en Google cuando se vinculan con dominios personalizados.

---

## ✅ 1. Meta Tags Dinámicos

### ¿Qué se implementó?
- **Meta tags automáticos** basados en el dominio y sitio actual
- **Canonical URLs** dinámicas para evitar contenido duplicado
- **Open Graph tags** con imágenes por defecto
- **Twitter Cards** configurables
- **Verificación de Google Search Console y Bing**

### 📂 Archivos modificados:
- `app/Helpers/SeoHelper.php` (NUEVO)
- `resources/views/layouts/public.blade.php` (ACTUALIZADO)
- `resources/views/creator/seo/robots.blade.php` (MEJORADO)
- `resources/views/creator/seo/edit.blade.php` (AMPLIADO)

---

## 🔍 2. SEO Helper - Cómo Funciona

El archivo `SeoHelper.php` proporciona métodos para generar meta tags dinámicamente:

```php
use App\Helpers\SeoHelper;

// Generar meta tags para una página
$metaTags = SeoHelper::generateMetaTags($website, $page, [
    'title' => 'Título personalizado',
    'description' => 'Descripción personalizada',
    'image' => 'https://ejemplo.com/imagen.jpg'
]);

// Obtener URL correcta del sitio
$url = SeoHelper::getCurrentUrl();

// Generar JSON-LD para esquema estructurado
$schema = SeoHelper::generateSchemaMarkup($website);
```

### Métodos disponibles:
1. **`generateMetaTags()`** - Genera todos los meta tags dinámicamente
2. **`getCurrentUrl()`** - Obtiene la URL actual correcta
3. **`getDefaultImage()`** - Obtiene imagen por defecto
4. **`generateRobotsMeta()`** - Genera contenido de meta robots
5. **`generateSchemaMarkup()`** - Crea JSON-LD schema
6. **`getDomainUrl()`** - Obtiene URL del dominio personalizado

---

## 🤖 3. Robots.txt Dinámico

### Mejoras implementadas:
- ✅ Configuración específica para Google y Bing
- ✅ Rutas excluidas (admin, dashboard, login, etc.)
- ✅ Crawl-delay para evitar sobrecarga
- ✅ Sitemap dinámico automático
- ✅ Host canónico configurado

### Ubicación:
Ruta: `/websites/{website}/seo/robots`

### Ejemplo de contenido:
```
User-agent: Googlebot
Allow: /

User-agent: Bingbot
Allow: /

User-agent: *
Allow: /
Disallow: /admin
Disallow: /dashboard
Disallow: /creator
Disallow: /api
Disallow: /login

Crawl-delay: 1

Sitemap: https://tu-sitio.com/websites/{website}/seo/sitemap
Host: tu-dominio.com
```

---

## 🔗 4. Canonical URL

### ¿Por qué es importante?
Evita que Google indexe múltiples versiones del mismo contenido (www vs sin www, http vs https, etc.).

### Configuración:
- Se inyecta automáticamente en `<head>`
- Puede configurarse manualmente en SEO settings
- Se usa dinámicamente según el dominio actual

### Ejemplo en HTML:
```html
<link rel="canonical" href="https://tu-dominio.com/pagina">
```

---

## 🖼️ 5. Open Graph e Imágenes

### Campos disponibles:
- `og_image` - Imagen específica para una página
- `default_og_image` - Imagen por defecto del sitio
- Dimensiones recomendadas: 1200x630px

### Flujo de selección:
1. Usa `og_image` si está disponible
2. Sino, usa `default_og_image`
3. Sino, usa imagen por defecto del placeholder
4. Se inyecta en Open Graph y Twitter Cards

---

## ✔️ 6. Verificación en Google Search Console y Bing

### Configuración en Admin Panel:

1. Ve a **Sitios Web → SEO → Editar**
2. Busca la sección **"Verificación en Buscadores"**
3. Agrega los códigos de verificación:

#### Para Google Search Console:
```
google-site-verification: googleXXXXXXXXXXXXXXXXXXXX
```

#### Para Bing Webmaster Tools:
```
msvalidate.01: XXXXXXXXXXXXXXXXXXXXXXXX
```

### ¿Dónde obtener los códigos?

**Google Search Console:**
1. Accede a [Google Search Console](https://search.google.com/search-console)
2. Agrega propiedad → Elige "Etiqueta HTML"
3. Copia el contenido del atributo content

**Bing Webmaster Tools:**
1. Accede a [Bing Webmaster Tools](https://www.bing.com/webmasters)
2. Agrega sitio → Verifica propiedad → "Meta tag"
3. Copia el contenido del atributo content

---

## 🎯 7. Configuración Avanzada

### Opciones disponibles en Admin:

#### Índice en Buscadores:
- **robots_index** - Permite indexación general
- **allow_google_index** - Específico para Google
- **allow_bing_index** - Específico para Bing

#### Dispositivos:
- **mobile_friendly** - Auto (default), mobile, desktop, o no-set

#### Sitemap:
- **sitemap_url** - URL personalizada del sitemap
- Ruta por defecto: `/websites/{website}/seo/sitemap`

---

## 📊 8. Base de Datos - Nuevos Campos

Se agregaron a la tabla `seo_settings`:

```sql
-- Verificación
google_site_verification VARCHAR(1000)
microsoft_site_verification VARCHAR(1000)

-- Imágenes
default_og_image VARCHAR(255)

-- Sitemap
sitemap_url VARCHAR(255)

-- Índices
allow_google_index BOOLEAN DEFAULT true
allow_bing_index BOOLEAN DEFAULT true

-- Dispositivos
mobile_friendly ENUM('not-set','mobile','desktop','auto') DEFAULT 'auto'
```

---

## 🚀 9. Cómo Usar en Controladores

### En PreviewController o PageController:

```php
use App\Helpers\SeoHelper;

public function showPage($page)
{
    $website = $page->website;
    
    // Generar meta tags
    $metaTags = SeoHelper::generateMetaTags($website, $page, [
        'title' => $page->title,
        'description' => $page->meta_description ?? Str::limit(strip_tags($page->content), 160),
        'image' => $page->featured_image,
    ]);
    
    return view('page', compact('website', 'page', 'metaTags'));
}
```

### En Blade:

```blade
<title>{{ $metaTags['title'] }}</title>
<meta name="description" content="{{ $metaTags['description'] }}">
<link rel="canonical" href="{{ $metaTags['canonical_url'] }}">
<meta property="og:image" content="{{ $metaTags['og']['image'] }}">
```

---

## ⚙️ 10. Checklist de Configuración SEO por Sitio

Para cada sitio web creado, sigue estos pasos:

### Paso 1: Configuración Básica
- [ ] Meta título (50-60 caracteres)
- [ ] Meta descripción (150-160 caracteres)
- [ ] Meta keywords (opcionales)
- [ ] Imagen OG (1200x630px)

### Paso 2: Redes Sociales
- [ ] Open Graph - Título, descripción, imagen
- [ ] Twitter Card - Elegir tipo (summary_large_image recomendado)
- [ ] Twitter Site y Creator (opcionales)

### Paso 3: Herramientas
- [ ] Google Analytics ID
- [ ] Google Tag Manager ID (opcional)
- [ ] Facebook Pixel ID (opcional)

### Paso 4: Verificación
- [ ] Google Site Verification code
- [ ] Bing Webmaster Tools code

### Paso 5: Avanzado
- [ ] Canonical URL (si es diferente)
- [ ] Imagen OG por defecto
- [ ] Permisos de indexación Google/Bing
- [ ] Preferencia de dispositivo

### Paso 6: Dominio Personalizado
- [ ] Configurar dominio en DNS
- [ ] Verificar dominio en sistema
- [ ] Comprobar que robots.txt se sirve correctamente
- [ ] Validar sitemap accesible

---

## 📡 11. URLs Públicas Importantes

| Recurso | URL | Descripción |
|---------|-----|-------------|
| Sitemap | `/websites/{id}/seo/sitemap` | XML sitemap dinámico |
| Robots | `/websites/{id}/seo/robots` | Robots.txt dinámico |
| Ruta pública | `{dominio}/` | Página de inicio |
| SEO Config | `/creator/websites/{id}/seo/edit` | Panel de configuración |

---

## 🔧 12. Troubleshooting

### Meta tags no aparecen en HTML
- [ ] Verificar que `$website` se pasa a la vista
- [ ] Comprobar que `SeoHelper::generateMetaTags()` se llama
- [ ] Revisar que el layout public está siendo usado

### Robots.txt retorna 404
- [ ] Verificar que la ruta está registrada en routes/web.php
- [ ] Comprobar que el SeoController existe
- [ ] Revisar permisos del archivo

### Imagen OG no aparece en redes sociales
- [ ] Verificar que la URL sea HTTPS
- [ ] Comprobar dimensiones 1200x630px
- [ ] Usar [Facebook Debugger](https://developers.facebook.com/tools/debug) para probar

### Sitio no se indexa en Google
- [ ] Verificar que `robots_index` es true en BD
- [ ] Comprobar Google Site Verification code
- [ ] Enviar sitemap a Google Search Console
- [ ] Revisar que no hay noindex en meta tags

---

## 📝 13. Próximas Mejoras Recomendadas

1. **Schema.org Markup** - JSON-LD automático para cada página
2. **Breadcrumbs** - Navegación estructurada
3. **Hreflang Tags** - Para sitios multiidioma
4. **AMP Support** - Versiones aceleradas para móvil
5. **SEO Audit Tool** - Dashboard con puntuación SEO
6. **Sitemap dinámico en archivo** - Generar XML físico
7. **Robots.txt en archivo** - Servir desde public/robots.txt
8. **Meta tags por página** - Además de globales

---

## 💡 14. Consejos Finales

✅ **Buenas prácticas:**
- Mantén títulos únicos y descriptivos (50-60 caracteres)
- Descripciones claras y con palabras clave (150-160 caracteres)
- Imágenes optimizadas y comprimidas
- URLs limpias y descriptivas
- Contenido de calidad y actualizado
- Mobile-friendly responsive
- Velocidad de carga rápida

❌ **Evita:**
- Palabras clave repetidas excesivamente (keyword stuffing)
- Contenido duplicado entre páginas
- Imágenes sin atributo alt
- Links rotos
- Publicidad excesiva
- Redirecciones en cadena
- Cloaking (mostrar contenido diferente a buscadores)

---

**Versión:** 1.0  
**Fecha:** 30 de Enero, 2026  
**Compatibilidad:** Laravel 11+
