# 📄 Sistema de Páginas Prediseñadas

## ✅ Sistema Completo Implementado

Similar a WordPress, cuando un usuario aplica una plantilla, obtiene automáticamente un sitio completo con páginas prediseñadas según el tipo de negocio.

---

## 🎯 Componentes del Sistema

### 1. **Servicio Principal**
**`app/Services/TemplatePageService.php`**

Métodos disponibles:
- `importTemplatePages($website, $templateSlug)` - Importa páginas al aplicar plantilla
- `getTemplatePages($templateSlug)` - Lista páginas disponibles
- `hasTemplatePages($templateSlug)` - Verifica si existe pages.json
- `updateExistingPages($website, $templateSlug, $overwrite)` - Actualiza páginas existentes
- `countTemplatePages($templateSlug)` - Cuenta páginas disponibles

### 2. **Base de Datos**
**Migración:** `2025_10_17_050342_add_blocks_to_pages_table.php`

Agrega campo `blocks` (JSON) a la tabla `pages` para almacenar bloques estructurados.

### 3. **Modelo Actualizado**
**`app/Models/Page.php`**

Nuevos campos fillable:
- `content` - Contenido HTML simple
- `blocks` - Bloques estructurados en JSON
- `meta_title` - Título SEO

Cast automático de `blocks` a array.

### 4. **Controlador Actualizado**
**`app/Http/Controllers/TemplateController.php`**

Al aplicar una plantilla, automáticamente:
1. Aplica el diseño visual
2. Importa páginas prediseñadas
3. Muestra mensaje: "X páginas prediseñadas fueron importadas"

### 5. **Comando Artisan**
**`app/Console/Commands/SyncTemplatePages.php`**

```bash
# Sincronizar todos los sitios con plantillas
php artisan template:sync-pages --all

# Sincronizar un sitio específico
php artisan template:sync-pages 1

# Sincronizar con plantilla específica
php artisan template:sync-pages 1 agencia-creativa

# Sobrescribir páginas existentes
php artisan template:sync-pages 1 --overwrite

# Modo interactivo
php artisan template:sync-pages
```

---

## 📚 Plantillas con Páginas Prediseñadas (17/17)

### 1. **Academia Online** (6 páginas)
- Inicio
- Cursos
- Instructores
- Mi Aprendizaje
- Planes
- Contacto

**Propósito:** Plataforma de cursos online con sistema de inscripción y certificados.

---

### 2. **Agencia Creativa** (5 páginas)
- Inicio
- Servicios
- Portfolio
- Sobre Nosotros
- Contacto

**Propósito:** Agencia de diseño y marketing con portfolio de proyectos.

---

### 3. **Blog Minimalista** (4 páginas)
- Inicio
- Sobre Mí
- Archivo
- Contacto

**Propósito:** Blog personal estilo Medium con lectura fácil.

---

### 4. **Consultoría Corporativa** (5 páginas)
- Inicio
- Servicios
- Casos de Éxito
- Nuestro Equipo
- Contacto

**Propósito:** Consultoría empresarial con enfoque en transformación digital.

---

### 5. **CV Personal** (5 páginas)
- Inicio
- Portfolio
- Experiencia
- Habilidades
- Contacto

**Propósito:** Currículum vitae online profesional con timeline de experiencia.

---

### 6. **Evento & Conferencia** (8 páginas)
- Inicio
- Agenda
- Speakers
- Entradas
- Talleres
- Venue
- Patrocinadores
- Contacto

**Propósito:** Landing page para eventos con sistema de registro y agenda.

---

### 7. **Gimnasio & Fitness** (6 páginas)
- Inicio
- Clases
- Membresías
- Entrenadores
- Instalaciones
- Contacto

**Propósito:** Gimnasio con clases grupales y planes de membresía.

---

### 8. **Inmobiliaria** (6 páginas)
- Inicio
- Propiedades en Venta
- Propiedades en Alquiler
- Vende tu Propiedad
- Nuestros Agentes
- Sobre Nosotros
- Contacto

**Propósito:** Listado de propiedades con búsqueda avanzada y mapas.

---

### 9. **Médico & Clínica** (7 páginas)
- Inicio
- Especialidades
- Nuestros Médicos
- Agendar Cita
- Servicios
- Seguros
- Contacto

**Propósito:** Clínica médica con sistema de citas y especialidades.

---

### 10. **Moda Boutique** (6 páginas)
- Inicio
- Colecciones
- Tienda
- Lookbook
- Sobre Nosotros
- Contacto

**Propósito:** Tienda de moda estilo editorial con lookbook.

---

### 11. **Músico & Banda** (7 páginas)
- Inicio
- Música
- Tour
- La Banda
- Merch
- Galería
- Contacto

**Propósito:** Sitio para músicos con reproductor, calendario de tours y tienda.

---

### 12. **Portafolio Fotógrafo** (6 páginas)
- Inicio
- Galerías
- Bodas
- Sobre Mí
- Servicios
- Contacto

**Propósito:** Portfolio fotográfico con galerías masonry y servicios.

---

### 13. **Restaurante & Menú** (6 páginas)
- Inicio
- Menú
- Reservas
- Galería
- Eventos
- Contacto

**Propósito:** Restaurante con menú digital y sistema de reservas.

---

### 14. **Spa & Bienestar** (7 páginas)
- Inicio
- Tratamientos
- Yoga & Meditación
- Reservas
- Membresías
- Galería
- Contacto

**Propósito:** Centro de bienestar con sistema de reservas y tratamientos.

---

### 15. **Tienda Minimalista** (6 páginas)
- Inicio
- Productos
- Colecciones
- Sobre Nosotros
- Soporte
- Contacto

**Propósito:** E-commerce minimalista estilo Apple con diseño ultra limpio.

---

### 16. **Tienda Virtual** (6 páginas)
- Inicio
- Productos
- Carrito
- Checkout
- Sobre Nosotros
- Contacto

**Propósito:** Tienda online completa con carrito y checkout.

---

### 17. **Plantilla Básica** (5 páginas)
- Inicio
- Sobre Nosotros
- Servicios
- Blog
- Contacto

**Propósito:** Plantilla genérica para cualquier tipo de sitio.

---

## 🎨 Tipos de Bloques Implementados (50+)

### **Layout & Navegación**
- `hero` - Sección hero principal
- `hero_minimal` - Hero minimalista
- `hero_fullscreen` - Hero pantalla completa
- `hero_video` - Hero con video de fondo
- `page_header` - Encabezado de página
- `page_header_minimal` - Encabezado minimalista

### **Contenido**
- `about_content` - Contenido sobre nosotros
- `features` - Características/beneficios
- `stats` - Estadísticas
- `cta` - Call to action
- `testimonials` - Testimonios

### **Comercio**
- `products_grid` - Grilla de productos
- `featured_products` - Productos destacados
- `cart` - Carrito de compras
- `checkout_form` - Formulario de pago
- `pricing_plans` - Planes de precios

### **Portfolio & Galería**
- `gallery_grid` - Galería en grilla
- `gallery_masonry` - Galería masonry
- `portfolio_grid` - Portfolio de proyectos
- `lookbook` - Lookbook de moda

### **Blog & Contenido**
- `blog_posts_feed` - Feed de posts
- `blog_posts_grid` - Posts en grilla
- `blog_archive` - Archivo de posts

### **Servicios Específicos**
- `courses_grid` - Cursos (academia)
- `class_schedule` - Horarios de clases
- `menu_categories` - Menú de restaurante
- `reservation_form` - Formulario de reservas
- `appointment_form` - Citas médicas
- `properties_grid` - Propiedades (inmobiliaria)
- `event_schedule` - Agenda de eventos
- `music_player` - Reproductor de música
- `tour_dates` - Fechas de tour

### **Contacto & Formularios**
- `contact_form` - Formulario de contacto
- `contact_info` - Información de contacto
- `faq_section` - Preguntas frecuentes
- `newsletter_signup` - Suscripción newsletter

---

## 📖 Cómo Funciona

### **Flujo Automático:**

1. **Usuario aplica plantilla** desde el panel
2. **Sistema detecta** si existe `pages.json` para esa plantilla
3. **Importa automáticamente** todas las páginas prediseñadas
4. **No sobrescribe** páginas existentes
5. **Muestra mensaje** de éxito con número de páginas importadas

### **Ejemplo de Uso:**

```php
// Usuario selecciona plantilla "Restaurante & Menú"
// Al hacer click en "Aplicar Plantilla"

TemplateController@apply():
  1. Aplica diseño visual
  2. Llama a TemplatePageService->importTemplatePages()
  3. Importa 6 páginas:
     - Inicio (is_home: true)
     - Menú
     - Reservas
     - Galería
     - Eventos
     - Contacto
  4. Usuario obtiene sitio completo listo para personalizar
```

### **Personalización:**

El usuario puede:
- ✅ Editar cualquier página importada
- ✅ Eliminar páginas que no necesite
- ✅ Agregar nuevas páginas
- ✅ Cambiar contenido de bloques
- ✅ Reordenar páginas

---

## 🔧 Comandos Útiles

### **Sincronizar Páginas Manualmente:**

```bash
# Ver todos los comandos disponibles
php artisan list template

# Sincronizar sitio específico
php artisan template:sync-pages 1

# Sincronizar todos los sitios
php artisan template:sync-pages --all

# Actualizar páginas existentes (sobrescribe)
php artisan template:sync-pages 1 --overwrite
```

### **Ejecutar Migración:**

```bash
php artisan migrate
```

---

## 📊 Estadísticas del Sistema

| Métrica | Valor |
|---------|-------|
| **Plantillas totales** | 17 |
| **Páginas prediseñadas** | 95+ |
| **Tipos de bloques** | 50+ |
| **Promedio páginas/plantilla** | 5-7 |
| **Categorías** | 10 (agency, education, blog, etc.) |

---

## 🎯 Ventajas sobre Competencia

### **vs. WordPress:**
✅ Páginas específicas por industria
✅ Bloques estructurados en JSON
✅ Importación automática
✅ No sobrescribe páginas existentes
✅ Comando artisan para sincronización

### **vs. Wix:**
✅ Código limpio
✅ Personalización completa
✅ Sin límites de páginas
✅ Exportable

### **vs. Squarespace:**
✅ Más flexible
✅ Gratis
✅ Auto-hospedado
✅ Sin restricciones

---

## 📝 Estructura de pages.json

```json
{
  "pages": [
    {
      "title": "Nombre de la Página",
      "slug": "url-slug",
      "is_home": true/false,
      "meta_title": "Título SEO",
      "meta_description": "Descripción SEO",
      "content": "<h1>Contenido HTML</h1>",
      "blocks": [
        {
          "type": "hero",
          "title": "Título del Bloque",
          "subtitle": "Subtítulo",
          "cta_text": "Botón",
          "cta_link": "/ruta"
        }
      ]
    }
  ]
}
```

---

## 🚀 Próximos Pasos Sugeridos

### **Funcionalidades Adicionales:**

1. **Editor Visual de Bloques**
   - Permitir editar bloques desde el panel
   - Drag & drop para reordenar
   - Preview en tiempo real

2. **Exportar/Importar Páginas**
   - Exportar páginas de un sitio
   - Importar en otro sitio
   - Compartir entre usuarios

3. **Plantillas de Páginas**
   - Crear páginas desde templates
   - Biblioteca de páginas prediseñadas
   - Marketplace de páginas

4. **Versionado de Páginas**
   - Historial de cambios
   - Restaurar versiones anteriores
   - Comparar versiones

---

## 📞 Uso del Sistema

### **Para el Administrador:**

```bash
# Ver estadísticas de uso
php artisan template:sync-pages --all

# Actualizar páginas de todos los sitios
php artisan template:sync-pages --all --overwrite
```

### **Para el Usuario:**

1. Login en el creador
2. Seleccionar sitio web
3. Ir a "Plantillas"
4. Elegir plantilla
5. Click "Aplicar Plantilla"
6. ✅ Sitio completo con páginas listas!

---

## ✅ Checklist de Implementación

- [x] Crear TemplatePageService
- [x] Crear migración add_blocks_to_pages_table
- [x] Actualizar modelo Page
- [x] Actualizar TemplateController
- [x] Crear comando SyncTemplatePages
- [x] Crear pages.json para 17 plantillas
- [x] Probar importación automática
- [ ] Ejecutar migración en producción
- [ ] Probar con usuarios reales

---

## 🎉 Resultado Final

Cuando un usuario aplica una plantilla:

**Antes:**
- Solo diseño visual
- Usuario debe crear todas las páginas manualmente
- Proceso largo y tedioso

**Ahora:**
- ✅ Diseño visual aplicado
- ✅ 5-7 páginas prediseñadas creadas automáticamente
- ✅ Contenido de ejemplo relevante
- ✅ Estructura completa lista
- ✅ Usuario solo personaliza contenido
- ✅ Sitio funcional en minutos

**¡Exactamente como WordPress, pero mejor!** 🚀




