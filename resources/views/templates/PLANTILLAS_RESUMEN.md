# 📋 Resumen Rápido de Plantillas

## Total: 17 Plantillas | 95+ Páginas Prediseñadas

---

| # | Plantilla | Categoría | Páginas | Color | Ideal Para |
|---|-----------|-----------|---------|-------|------------|
| 1 | Academia Online | Educación | 6 | Violeta | Cursos online |
| 2 | Agencia Creativa | Agencias | 5 | Púrpura | Marketing/Diseño |
| 3 | Blog Minimalista | Blog | 4 | Negro | Blogging |
| 4 | Consultoría Corp. | Negocios | 5 | Azul | Consultoría |
| 5 | CV Personal | Personal | 5 | Azul | CV Online |
| 6 | Evento/Conferencia | Eventos | 8 | Púrpura | Eventos |
| 7 | Gimnasio & Fitness | Fitness | 6 | Rojo | Gimnasios |
| 8 | Inmobiliaria | Bienes Raíces | 7 | Verde azul | Propiedades |
| 9 | Médico & Clínica | Médico | 7 | Cyan | Clínicas |
| 10 | Moda Boutique | Moda | 6 | Negro | Tiendas de ropa |
| 11 | Músico & Banda | Música | 7 | Rojo | Músicos |
| 12 | Portafolio Fotógrafo | Portfolio | 6 | Negro | Fotógrafos |
| 13 | Restaurante & Menú | Restaurantes | 6 | Ámbar | Restaurantes |
| 14 | Spa & Bienestar | Bienestar | 7 | Dorado | Spas |
| 15 | Tienda Minimalista | E-commerce | 6 | Negro | Tech/Premium |
| 16 | Tienda Virtual | E-commerce | 6 | Verde | E-commerce |
| 17 | Plantilla Básica | Básica | 5 | Azul | Genérico |

---

## 📁 Ubicación de Archivos

Cada plantilla tiene:
```
resources/views/templates/[slug]/
├── config.json          # Configuración de la plantilla
├── pages.json          # Páginas prediseñadas ⭐
├── header.blade.php    # Encabezado
├── footer.blade.php    # Pie de página
├── template.blade.php  # Template principal (home)
├── template-page.blade.php   # Template para páginas
└── template-blog.blade.php   # Template para blog
```

---

## 🎯 Por Tipo de Negocio

### **E-commerce (3)**
- Tienda Virtual
- Tienda Minimalista  
- Moda Boutique

### **Servicios Profesionales (4)**
- Agencia Creativa
- Consultoría Corporativa
- CV Personal
- Portafolio Fotógrafo

### **Salud & Bienestar (3)**
- Médico & Clínica
- Gimnasio & Fitness
- Spa & Bienestar

### **Hostelería (1)**
- Restaurante & Menú

### **Entretenimiento (2)**
- Músico & Banda
- Evento & Conferencia

### **Educación (1)**
- Academia Online

### **Blog (1)**
- Blog Minimalista

### **Inmobiliaria (1)**
- Inmobiliaria

### **Genérica (1)**
- Plantilla Básica

---

## ⚡ Uso Rápido

```bash
# Aplicar plantilla (automático desde panel de usuario)
Usuario → Plantillas → Elegir → Aplicar ✅

# Sincronizar páginas manualmente
php artisan template:sync-pages 1

# Ver todas las plantillas con páginas
php artisan template:sync-pages --all
```

---

## 📖 Documentación Completa

- **Catálogo detallado:** `docs/CATALOGO_PLANTILLAS.md`
- **Sistema técnico:** `docs/SISTEMA_PAGINAS_PREDISEÑADAS.md`
- **Archivo de plantillas:** `resources/views/templates/plantillas-catalogo.json`

