<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PageNavigatorPreviewController extends Controller
{
    /**
     * Mostrar vista previa de una página del navegador
     */
    public function show(Request $request, $pageSlug)
    {
        // Debug: Log del pageSlug recibido
        \Log::info('PageNavigatorPreview - pageSlug recibido: ' . $pageSlug);
        
        // El pageSlug viene en formato "websiteKey-pageSlug"
        // Usar un separador más específico para evitar conflictos con guiones en los nombres
        $separator = '--';
        if (strpos($pageSlug, $separator) === false) {
            // Fallback para el formato anterior con un solo guión
            $parts = explode('-', $pageSlug, 2);
            if (count($parts) !== 2) {
                \Log::error('PageNavigatorPreview - Formato inválido: ' . $pageSlug);
                abort(404, 'Formato de página inválido');
            }
            $websiteKey = $parts[0];
            $actualPageSlug = $parts[1];
        } else {
            $parts = explode($separator, $pageSlug, 2);
            $websiteKey = $parts[0];
            $actualPageSlug = $parts[1];
        }
        
        \Log::info('PageNavigatorPreview - websiteKey: ' . $websiteKey . ', actualPageSlug: ' . $actualPageSlug);
        
        // Obtener datos de sitios web
        $websites = $this->getWebsites();
        
        if (!isset($websites[$websiteKey])) {
            abort(404, 'Sitio web no encontrado');
        }
        
        $website = $websites[$websiteKey];
        
        // Buscar la página en el sitio web
        $page = collect($website['pages'])->firstWhere('slug', $actualPageSlug);
        
        if (!$page) {
            abort(404, 'Página no encontrada en este sitio web');
        }
        
        // Generar bloques de la página basados en el tipo
        $pageBlocks = $this->generatePageBlocks($page);
        
        // Obtener información de la categoría
        $categoryInfo = $this->getCategoryInfo($website['category']);
        
        return view('creator.pages.preview-navigator', [
            'pageTitle' => $page['title'],
            'pageDescription' => $page['description'],
            'pageExample' => $page['example'],
            'pageType' => $page['type'],
            'categoryName' => $categoryInfo['name'],
            'categoryIcon' => $categoryInfo['icon'],
            'pageBlocks' => $pageBlocks
        ]);
    }
    
    /**
     * Obtener datos de sitios web del navegador
     */
    private function getWebsites()
    {
        return [
            'tienda-virtual' => [
                'name' => '🛒 Tienda Virtual',
                'description' => 'Tienda online completa con carrito y checkout',
                'category' => 'ecommerce',
                'icon' => 'shopping-cart',
                'color' => 'orange',
                'pages' => [
                    ['slug' => 'inicio', 'title' => 'Inicio', 'description' => 'Página principal con productos destacados y ofertas', 'type' => 'common', 'example' => 'Tienda de ropa, electrónicos, etc.'],
                    ['slug' => 'productos', 'title' => 'Productos', 'description' => 'Catálogo completo con filtros y búsqueda', 'type' => 'common', 'example' => 'Lista de todos los productos disponibles'],
                    ['slug' => 'categorias', 'title' => 'Categorías', 'description' => 'Navegación por categorías de productos', 'type' => 'specialized', 'example' => 'Ropa, Calzado, Accesorios'],
                    ['slug' => 'carrito', 'title' => 'Carrito', 'description' => 'Carrito de compras con resumen de productos', 'type' => 'specialized', 'example' => 'Productos seleccionados para comprar'],
                    ['slug' => 'checkout', 'title' => 'Checkout', 'description' => 'Proceso de compra y pago', 'type' => 'specialized', 'example' => 'Formulario de envío y pago'],
                    ['slug' => 'ofertas', 'title' => 'Ofertas', 'description' => 'Productos en descuento y promociones', 'type' => 'specialized', 'example' => 'Black Friday, Descuentos especiales'],
                    ['slug' => 'mi-cuenta', 'title' => 'Mi Cuenta', 'description' => 'Panel del cliente con pedidos y datos', 'type' => 'specialized', 'example' => 'Historial de compras, perfil']
                ]
            ],
            'tienda-minimalista' => [
                'name' => '⚫ Tienda Minimalista',
                'description' => 'Diseño ultra minimalista inspirado en Apple',
                'category' => 'ecommerce',
                'icon' => 'apple',
                'color' => 'gray',
                'pages' => [
                    ['slug' => 'inicio', 'title' => 'Inicio', 'description' => 'Página principal minimalista con productos destacados', 'type' => 'common', 'example' => 'Diseño limpio y elegante'],
                    ['slug' => 'productos', 'title' => 'Productos', 'description' => 'Catálogo con diseño minimalista', 'type' => 'common', 'example' => 'Productos cuidadosamente seleccionados'],
                    ['slug' => 'categorias', 'title' => 'Categorías', 'description' => 'Navegación simple por categorías', 'type' => 'specialized', 'example' => 'Hogar, Oficina, Moda'],
                    ['slug' => 'sobre-nosotros', 'title' => 'Sobre Nosotros', 'description' => 'Historia de la marca minimalista', 'type' => 'common', 'example' => 'Filosofía de diseño'],
                    ['slug' => 'contacto', 'title' => 'Contacto', 'description' => 'Formulario de contacto minimalista', 'type' => 'common', 'example' => 'Contacto directo y simple']
                ]
            ],
            'moda-boutique' => [
                'name' => '👗 Moda Boutique',
                'description' => 'Tienda elegante para ropa y accesorios de moda',
                'category' => 'fashion',
                'icon' => 'tshirt',
                'color' => 'pink',
                'pages' => [
                    ['slug' => 'inicio', 'title' => 'Inicio', 'description' => 'Página principal con lookbook y colecciones', 'type' => 'common', 'example' => 'Tendencias de moda actuales'],
                    ['slug' => 'mujer', 'title' => 'Mujer', 'description' => 'Sección de moda femenina', 'type' => 'common', 'example' => 'Ropa, accesorios y calzado para mujer'],
                    ['slug' => 'hombre', 'title' => 'Hombre', 'description' => 'Sección de moda masculina', 'type' => 'common', 'example' => 'Ropa y accesorios para hombre'],
                    ['slug' => 'accesorios', 'title' => 'Accesorios', 'description' => 'Bolsas, zapatos, joyería', 'type' => 'specialized', 'example' => 'Completa tu look'],
                    ['slug' => 'colecciones', 'title' => 'Colecciones', 'description' => 'Ediciones especiales y limitadas', 'type' => 'specialized', 'example' => 'Colecciones por temporada'],
                    ['slug' => 'sobre-nosotros', 'title' => 'Sobre Nosotros', 'description' => 'Historia de la boutique', 'type' => 'common', 'example' => 'Nuestra pasión por la moda'],
                    ['slug' => 'contacto', 'title' => 'Contacto', 'description' => 'Información de contacto y ubicación', 'type' => 'common', 'example' => 'Visítanos en nuestra tienda']
                ]
            ],
            'consultoria-corporativa' => [
                'name' => '💼 Consultoría Corporativa',
                'description' => 'Sitio web profesional para consultoras y empresas',
                'category' => 'business',
                'icon' => 'briefcase',
                'color' => 'blue',
                'pages' => [
                    ['slug' => 'inicio', 'title' => 'Inicio', 'description' => 'Presentación de la consultora y servicios', 'type' => 'common', 'example' => 'Consultoría estratégica y empresarial'],
                    ['slug' => 'servicios', 'title' => 'Servicios', 'description' => 'Lista detallada de servicios de consultoría', 'type' => 'common', 'example' => 'Estrategia, Operaciones, Finanzas'],
                    ['slug' => 'casos-exito', 'title' => 'Casos de Éxito', 'description' => 'Proyectos completados y resultados', 'type' => 'specialized', 'example' => 'Transformaciones empresariales'],
                    ['slug' => 'equipo', 'title' => 'Nuestro Equipo', 'description' => 'Consultores y especialistas', 'type' => 'specialized', 'example' => 'Expertos en diferentes áreas'],
                    ['slug' => 'contacto', 'title' => 'Contacto', 'description' => 'Formulario de contacto profesional', 'type' => 'common', 'example' => 'Solicita una consulta']
                ]
            ],
            'clinica-medica' => [
                'name' => '🏥 Clínica Médica',
                'description' => 'Sitio web para clínicas y centros médicos',
                'category' => 'health',
                'icon' => 'heartbeat',
                'color' => 'red',
                'pages' => [
                    ['slug' => 'inicio', 'title' => 'Inicio', 'description' => 'Presentación de la clínica y servicios médicos', 'type' => 'common', 'example' => 'Atención médica de calidad'],
                    ['slug' => 'servicios', 'title' => 'Servicios', 'description' => 'Servicios médicos y tratamientos', 'type' => 'common', 'example' => 'Consultas, tratamientos, cirugías'],
                    ['slug' => 'especialidades', 'title' => 'Especialidades', 'description' => 'Áreas médicas especializadas', 'type' => 'specialized', 'example' => 'Cardiología, Dermatología, Odontología'],
                    ['slug' => 'doctores', 'title' => 'Doctores', 'description' => 'Equipo médico y especialistas', 'type' => 'specialized', 'example' => 'Dr. García, Dra. López, especialistas'],
                    ['slug' => 'citas', 'title' => 'Citas', 'description' => 'Sistema de agendamiento de citas', 'type' => 'specialized', 'example' => 'Reservar consulta médica online'],
                    ['slug' => 'contacto', 'title' => 'Contacto', 'description' => 'Información de contacto y ubicación', 'type' => 'common', 'example' => 'Dirección, teléfonos, horarios']
                ]
            ],
            'academia-online' => [
                'name' => '🎓 Academia Online',
                'description' => 'Plataforma educativa para cursos y capacitaciones',
                'category' => 'education',
                'icon' => 'graduation-cap',
                'color' => 'green',
                'pages' => [
                    ['slug' => 'inicio', 'title' => 'Inicio', 'description' => 'Presentación de la academia y cursos', 'type' => 'common', 'example' => 'Aprende desde cualquier lugar'],
                    ['slug' => 'cursos', 'title' => 'Cursos', 'description' => 'Catálogo de cursos y programas', 'type' => 'common', 'example' => 'Inglés, Programación, Diseño'],
                    ['slug' => 'instructores', 'title' => 'Instructores', 'description' => 'Profesores y tutores especializados', 'type' => 'specialized', 'example' => 'Profesores certificados, expertos'],
                    ['slug' => 'mi-aprendizaje', 'title' => 'Mi Aprendizaje', 'description' => 'Panel del estudiante', 'type' => 'specialized', 'example' => 'Mis cursos, certificados, progreso'],
                    ['slug' => 'planes', 'title' => 'Planes', 'description' => 'Planes de estudio y precios', 'type' => 'specialized', 'example' => 'Básico, Intermedio, Avanzado'],
                    ['slug' => 'blog', 'title' => 'Blog', 'description' => 'Artículos educativos y recursos', 'type' => 'specialized', 'example' => 'Tips, tutoriales, noticias']
                ]
            ],
            'portafolio-creativo' => [
                'name' => '🎨 Portafolio Creativo',
                'description' => 'Sitio web para diseñadores, fotógrafos y creativos',
                'category' => 'creative',
                'icon' => 'palette',
                'color' => 'purple',
                'pages' => [
                    ['slug' => 'inicio', 'title' => 'Inicio', 'description' => 'Portfolio principal con trabajos destacados', 'type' => 'common', 'example' => 'Diseñador, Fotógrafo, Artista'],
                    ['slug' => 'portfolio', 'title' => 'Portfolio', 'description' => 'Galería completa de trabajos', 'type' => 'common', 'example' => 'Proyectos de diseño, fotografía'],
                    ['slug' => 'servicios', 'title' => 'Servicios', 'description' => 'Servicios creativos ofrecidos', 'type' => 'common', 'example' => 'Diseño web, branding, fotografía'],
                    ['slug' => 'galeria', 'title' => 'Galería', 'description' => 'Colección de imágenes y trabajos', 'type' => 'specialized', 'example' => 'Fotos, diseños, ilustraciones'],
                    ['slug' => 'sobre-mi', 'title' => 'Sobre Mí', 'description' => 'Biografía y experiencia', 'type' => 'specialized', 'example' => 'Mi historia, experiencia, premios'],
                    ['slug' => 'contacto', 'title' => 'Contacto', 'description' => 'Formulario para solicitar servicios', 'type' => 'common', 'example' => 'Presupuestos, consultas, proyectos']
                ]
            ],
            'eventos-conferencias' => [
                'name' => '🎪 Eventos y Conferencias',
                'description' => 'Sitio web para eventos, conferencias y entretenimiento',
                'category' => 'events',
                'icon' => 'calendar-alt',
                'color' => 'yellow',
                'pages' => [
                    ['slug' => 'inicio', 'title' => 'Inicio', 'description' => 'Próximos eventos y información general', 'type' => 'common', 'example' => 'Conciertos, conferencias, festivales'],
                    ['slug' => 'eventos', 'title' => 'Eventos', 'description' => 'Lista de eventos programados', 'type' => 'common', 'example' => 'Calendario de eventos, fechas'],
                    ['slug' => 'reservas', 'title' => 'Reservas', 'description' => 'Sistema de reserva de entradas', 'type' => 'specialized', 'example' => 'Comprar entradas online'],
                    ['slug' => 'galeria', 'title' => 'Galería', 'description' => 'Fotos y videos de eventos pasados', 'type' => 'specialized', 'example' => 'Memorias de eventos anteriores'],
                    ['slug' => 'patrocinadores', 'title' => 'Patrocinadores', 'description' => 'Información de patrocinadores', 'type' => 'specialized', 'example' => 'Marcas que apoyan el evento'],
                    ['slug' => 'contacto', 'title' => 'Contacto', 'description' => 'Información de contacto para eventos', 'type' => 'common', 'example' => 'Organizadores, ubicación']
                ]
            ]
        ];
    }
    
    /**
     * Generar bloques de la página basados en el tipo
     */
    private function generatePageBlocks($page)
    {
        $blocks = [];
        
        // Siempre incluir hero
        $blocks[] = [
            'type' => 'hero-navigator',
            'name' => 'Hero Principal',
            'icon' => 'home',
            'title' => $page['title'],
            'subtitle' => $page['description'],
            'primary_button' => 'Ver Más',
            'secondary_button' => 'Contactar'
        ];
        
        // Agregar bloques específicos según el tipo de página
        switch ($page['slug']) {
            case 'inicio':
                $blocks[] = ['type' => 'features-navigator', 'name' => '¿Por qué elegirnos?', 'icon' => 'star'];
                $blocks[] = ['type' => 'product-grid-navigator', 'name' => 'Productos Destacados', 'icon' => 'shopping-bag'];
                $blocks[] = ['type' => 'testimonials-navigator', 'name' => 'Testimonios', 'icon' => 'quote-left'];
                $blocks[] = ['type' => 'offers-navigator', 'name' => 'Ofertas Especiales', 'icon' => 'tag'];
                break;
                
            case 'productos':
            case 'categorias':
                $blocks[] = ['type' => 'product-grid-navigator', 'name' => 'Catálogo de Productos', 'icon' => 'shopping-bag'];
                $blocks[] = ['type' => 'features-navigator', 'name' => 'Garantías y Servicios', 'icon' => 'shield-alt'];
                break;
                
            case 'servicios':
                $blocks[] = ['type' => 'features-navigator', 'name' => 'Nuestros Servicios', 'icon' => 'cogs'];
                $blocks[] = ['type' => 'testimonials-navigator', 'name' => 'Casos de Éxito', 'icon' => 'trophy'];
                break;
                
            case 'contacto':
                $blocks[] = ['type' => 'contact-form-navigator', 'name' => 'Formulario de Contacto', 'icon' => 'envelope'];
                break;
                
            case 'sobre-nosotros':
            case 'equipo':
                $blocks[] = ['type' => 'features-navigator', 'name' => 'Nuestro Equipo', 'icon' => 'users'];
                $blocks[] = ['type' => 'testimonials-navigator', 'name' => 'Testimonios', 'icon' => 'quote-left'];
                break;
                
            case 'cursos':
                $blocks[] = ['type' => 'features-navigator', 'name' => 'Cursos Disponibles', 'icon' => 'graduation-cap'];
                $blocks[] = ['type' => 'testimonials-navigator', 'name' => 'Opiniones de Estudiantes', 'icon' => 'star'];
                break;
                
            case 'portfolio':
            case 'galeria':
                $blocks[] = ['type' => 'product-grid-navigator', 'name' => 'Nuestro Trabajo', 'icon' => 'images'];
                $blocks[] = ['type' => 'testimonials-navigator', 'name' => 'Opiniones de Clientes', 'icon' => 'quote-left'];
                break;
                
            case 'eventos':
                $blocks[] = ['type' => 'features-navigator', 'name' => 'Próximos Eventos', 'icon' => 'calendar'];
                $blocks[] = ['type' => 'offers-navigator', 'name' => 'Ofertas Especiales', 'icon' => 'tag'];
                break;
                
            case 'carrito':
                $blocks[] = ['type' => 'product-grid-navigator', 'name' => 'Tu Carrito', 'icon' => 'shopping-cart'];
                break;
                
            case 'checkout':
                $blocks[] = ['type' => 'contact-form-navigator', 'name' => 'Finalizar Compra', 'icon' => 'credit-card'];
                break;
                
            default:
                $blocks[] = ['type' => 'features-navigator', 'name' => 'Características', 'icon' => 'star'];
                break;
        }
        
        return $blocks;
    }
    
    /**
     * Obtener información de la categoría
     */
    private function getCategoryInfo($category)
    {
        $categories = [
            'ecommerce' => ['name' => '🛒 Tiendas Online', 'icon' => 'shopping-cart'],
            'business' => ['name' => '💼 Negocios y Servicios', 'icon' => 'briefcase'],
            'health' => ['name' => '🏥 Salud y Bienestar', 'icon' => 'heartbeat'],
            'education' => ['name' => '🎓 Educación', 'icon' => 'graduation-cap'],
            'creative' => ['name' => '🎨 Creativos y Portfolio', 'icon' => 'palette'],
            'events' => ['name' => '🎪 Eventos y Entretenimiento', 'icon' => 'calendar-alt']
        ];
        
        return $categories[$category] ?? ['name' => '🌐 General', 'icon' => 'globe'];
    }
}
