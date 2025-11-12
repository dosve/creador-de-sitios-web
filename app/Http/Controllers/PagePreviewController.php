<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagePreviewController extends Controller
{
    /**
     * Mostrar vista previa limpia de una página
     */
    public function show(Request $request, $pageSlug)
    {
        \Log::info('PagePreview - pageSlug recibido: ' . $pageSlug);
        
        $separator = '--';
        if (strpos($pageSlug, $separator) === false) {
            $parts = explode('-', $pageSlug, 2);
            if (count($parts) !== 2) {
                \Log::error('PagePreview - Formato inválido: ' . $pageSlug);
                abort(404, 'Formato de página inválido');
            }
            $websiteKey = $parts[0];
            $actualPageSlug = $parts[1];
        } else {
            $parts = explode($separator, $pageSlug, 2);
            $websiteKey = $parts[0];
            $actualPageSlug = $parts[1];
        }
        
        \Log::info('PagePreview - websiteKey: ' . $websiteKey . ', actualPageSlug: ' . $actualPageSlug);
        
        $websites = $this->getWebsites();
        
        if (!isset($websites[$websiteKey])) {
            abort(404, 'Sitio web no encontrado');
        }
        
        $website = $websites[$websiteKey];
        
        $page = collect($website['pages'])->firstWhere('slug', $actualPageSlug);
        
        if (!$page) {
            abort(404, 'Página no encontrada en este sitio web');
        }
        
        // Pasar websiteKey al generador de bloques para personalizaciones por sitio
        $page['websiteKey'] = $websiteKey;
        // Si existe una vista específica por plantilla/página, usarla
        $specificView = 'creator.pages.templates.' . $websiteKey . '.' . $actualPageSlug;
        if (view()->exists($specificView)) {
            return view($specificView, [
                'pageTitle' => $page['title'],
                'pageDescription' => $page['description'],
                'pageExample' => $page['example'] ?? '',
                'pageType' => $page['type'],
                'websiteName' => $website['name'],
            ]);
        }

        $pageBlocks = $this->generatePageBlocks($page);
        
        $categoryInfo = $this->getCategoryInfo($website['category']);
        
        return view('creator.pages.preview-clean', [
            'pageTitle' => $page['title'],
            'pageDescription' => $page['description'],
            'pageExample' => $page['example'],
            'pageType' => $page['type'],
            'categoryName' => $categoryInfo['name'],
            'categoryIcon' => $categoryInfo['icon'],
            'pageBlocks' => $pageBlocks,
            'websiteName' => $website['name']
        ]);
    }
    
    /**
     * Obtener datos de sitios web
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
                    ['slug' => 'productos', 'title' => 'Productos', 'description' => 'Catálogo completo de productos con filtros', 'type' => 'common', 'example' => 'Categorías, búsqueda, filtros'],
                    ['slug' => 'categorias', 'title' => 'Categorías', 'description' => 'Explora el catálogo por categorías', 'type' => 'common', 'example' => 'Ropa, Hogar, Electrónica'],
                    ['slug' => 'contacto', 'title' => 'Contacto', 'description' => 'Formulario de contacto y ubicación', 'type' => 'common', 'example' => 'Dirección, teléfono, horarios'],
                    ['slug' => 'nosotros', 'title' => 'Nosotros', 'description' => 'Información sobre la empresa y equipo', 'type' => 'common', 'example' => 'Historia, misión, valores']
                ]
            ],
            // Sitio: Tienda Minimalista (clave usada en el modal)
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
            // Moda Boutique
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
            'negocio-local' => [
                'name' => '🏢 Negocio Local',
                'description' => 'Sitio web para negocios físicos y servicios locales',
                'category' => 'business',
                'icon' => 'store',
                'color' => 'blue',
                'pages' => [
                    ['slug' => 'inicio', 'title' => 'Inicio', 'description' => 'Página principal con servicios destacados', 'type' => 'common', 'example' => 'Restaurante, consultorio, taller'],
                    ['slug' => 'servicios', 'title' => 'Servicios', 'description' => 'Lista detallada de servicios ofrecidos', 'type' => 'common', 'example' => 'Servicios con precios y descripciones'],
                    ['slug' => 'contacto', 'title' => 'Contacto', 'description' => 'Información de contacto y ubicación', 'type' => 'common', 'example' => 'Dirección, teléfono, mapa, horarios'],
                    ['slug' => 'nosotros', 'title' => 'Nosotros', 'description' => 'Historia y equipo de la empresa', 'type' => 'specialized', 'example' => 'Misión, visión, equipo'],
                    ['slug' => 'galeria', 'title' => 'Galería', 'description' => 'Fotos del local y trabajos realizados', 'type' => 'specialized', 'example' => 'Fotos del espacio, trabajos, antes/después'],
                    ['slug' => 'testimonios', 'title' => 'Testimonios', 'description' => 'Opiniones de clientes satisfechos', 'type' => 'specialized', 'example' => 'Reseñas con fotos y calificaciones']
                ]
            ],
            // Clínica Médica (clave usada en el modal)
            'clinica-medica' => [
                'name' => '🏥 Salud y Bienestar',
                'description' => 'Sitio web para profesionales de la salud',
                'category' => 'health',
                'icon' => 'heartbeat',
                'color' => 'green',
                'pages' => [
                    ['slug' => 'inicio', 'title' => 'Inicio', 'description' => 'Página principal con servicios de salud', 'type' => 'common', 'example' => 'Clínica, consultorio, spa'],
                    ['slug' => 'servicios', 'title' => 'Servicios', 'description' => 'Tratamientos y servicios médicos', 'type' => 'common', 'example' => 'Consultas, tratamientos, terapias'],
                    ['slug' => 'doctores', 'title' => 'Doctores', 'description' => 'Equipo médico y especialidades', 'type' => 'common', 'example' => 'Doctores, especialidades, horarios'],
                    ['slug' => 'citas', 'title' => 'Citas', 'description' => 'Sistema de reserva de citas online', 'type' => 'specialized', 'example' => 'Calendario, horarios disponibles'],
                    ['slug' => 'contacto', 'title' => 'Contacto', 'description' => 'Información de contacto y ubicación', 'type' => 'common', 'example' => 'Dirección, teléfono, emergencias'],
                    ['slug' => 'blog', 'title' => 'Blog', 'description' => 'Artículos sobre salud y bienestar', 'type' => 'specialized', 'example' => 'Consejos, noticias, investigaciones']
                ]
            ],
            // Academia Online (clave usada en el modal)
            'academia-online' => [
                'name' => '🎓 Educación',
                'description' => 'Plataforma educativa y cursos online',
                'category' => 'education',
                'icon' => 'graduation-cap',
                'color' => 'purple',
                'pages' => [
                    ['slug' => 'inicio', 'title' => 'Inicio', 'description' => 'Página principal con cursos destacados', 'type' => 'common', 'example' => 'Academia, universidad, instituto'],
                    ['slug' => 'cursos', 'title' => 'Cursos', 'description' => 'Catálogo de cursos disponibles', 'type' => 'common', 'example' => 'Cursos por categoría, niveles, duración'],
                    ['slug' => 'instructores', 'title' => 'Instructores', 'description' => 'Profesores y sus especialidades', 'type' => 'common', 'example' => 'Perfiles, experiencia, especialidades'],
                    ['slug' => 'mi-aprendizaje', 'title' => 'Mi Aprendizaje', 'description' => 'Panel del estudiante con progreso', 'type' => 'specialized', 'example' => 'Cursos inscritos, progreso, certificados'],
                    ['slug' => 'planes', 'title' => 'Planes', 'description' => 'Planes de suscripción y precios', 'type' => 'specialized', 'example' => 'Precios, características, comparación'],
                    ['slug' => 'contacto', 'title' => 'Contacto', 'description' => 'Información de contacto y soporte', 'type' => 'common', 'example' => 'Soporte, preguntas, ayuda']
                ]
            ],
            // Portafolio Creativo (clave usada en el modal)
            'portafolio-creativo' => [
                'name' => '🎨 Creativo y Portfolio',
                'description' => 'Portfolio para creativos y freelancers',
                'category' => 'creative',
                'icon' => 'palette',
                'color' => 'pink',
                'pages' => [
                    ['slug' => 'inicio', 'title' => 'Inicio', 'description' => 'Portfolio principal con trabajos destacados', 'type' => 'common', 'example' => 'Diseñador, fotógrafo, artista'],
                    ['slug' => 'portfolio', 'title' => 'Portfolio', 'description' => 'Galería de trabajos y proyectos', 'type' => 'common', 'example' => 'Proyectos, categorías, filtros'],
                    ['slug' => 'servicios', 'title' => 'Servicios', 'description' => 'Servicios creativos ofrecidos', 'type' => 'common', 'example' => 'Diseño, fotografía, ilustración'],
                    ['slug' => 'sobre-mi', 'title' => 'Sobre Mí', 'description' => 'Biografía y experiencia profesional', 'type' => 'specialized', 'example' => 'Historia, experiencia, logros'],
                    ['slug' => 'blog', 'title' => 'Blog', 'description' => 'Artículos sobre creatividad y diseño', 'type' => 'specialized', 'example' => 'Tutoriales, inspiración, tendencias'],
                    ['slug' => 'contacto', 'title' => 'Contacto', 'description' => 'Formulario de contacto para proyectos', 'type' => 'common', 'example' => 'Presupuestos, consultas, colaboraciones']
                ]
            ],
            // Eventos y Conferencias (clave usada en el modal)
            'eventos-conferencias' => [
                'name' => '🎪 Eventos y Entretenimiento',
                'description' => 'Sitio web para eventos y entretenimiento',
                'category' => 'events',
                'icon' => 'calendar-alt',
                'color' => 'yellow',
                'pages' => [
                    ['slug' => 'inicio', 'title' => 'Inicio', 'description' => 'Página principal con eventos destacados', 'type' => 'common', 'example' => 'Salón de eventos, teatro, conciertos'],
                    ['slug' => 'eventos', 'title' => 'Eventos', 'description' => 'Calendario y lista de eventos', 'type' => 'common', 'example' => 'Próximos eventos, categorías, fechas'],
                    ['slug' => 'reservas', 'title' => 'Reservas', 'description' => 'Sistema de reserva de entradas', 'type' => 'specialized', 'example' => 'Comprar entradas online'],
                    ['slug' => 'galeria', 'title' => 'Galería', 'description' => 'Fotos de eventos realizados', 'type' => 'specialized', 'example' => 'Fotos por evento, categorías'],
                    ['slug' => 'patrocinadores', 'title' => 'Patrocinadores', 'description' => 'Información de patrocinadores', 'type' => 'specialized', 'example' => 'Marcas que apoyan el evento'],
                    ['slug' => 'contacto', 'title' => 'Contacto', 'description' => 'Información de contacto y ubicación', 'type' => 'common', 'example' => 'Dirección, teléfono, horarios']
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
        
        // Siempre incluir hero, variante por sitio
        $heroType = (($page['websiteKey'] ?? '') === 'tienda-minimalista')
            ? 'hero-minimalist-navigator'
            : 'hero-navigator';
        $blocks[] = [
            'type' => $heroType,
            'name' => 'Hero Principal',
            'icon' => 'home',
            'title' => $page['title'],
            'subtitle' => $page['description'],
            'primary_button' => (($page['websiteKey'] ?? '') === 'tienda-minimalista') ? 'Comprar' : 'Ver Más',
            'secondary_button' => (($page['websiteKey'] ?? '') === 'tienda-minimalista') ? 'Lookbook' : 'Contactar'
        ];
        
        // Agregar bloques específicos según el tipo de página
        switch ($page['slug']) {
            case 'inicio':
                if (($page['websiteKey'] ?? '') === 'tienda-minimalista') {
                    // Home minimalista: lookbook + colección SS25 + destacados
                    $blocks[] = [
                        'type' => 'collection-banner-navigator',
                        'name' => 'Colección SS25',
                        'icon' => 'sun',
                        'title' => 'Colección SS25',
                        'subtitle' => 'Minimalismo en movimiento. Cortes limpios, tonos neutros y materiales premium.'
                    ];
                    $blocks[] = [
                        'type' => 'lookbook-navigator',
                        'name' => 'Lookbook',
                        'icon' => 'camera-retro'
                    ];
                    $blocks[] = [
                        'type' => 'product-grid-minimalist-navigator',
                        'name' => 'Destacados',
                        'icon' => 'shopping-bag',
                        'title' => 'Destacados SS25',
                        'subtitle' => 'Selección cápsula de la temporada'
                    ];
                } else {
                    // Home clásica
                    $blocks[] = [
                        'type' => 'features-navigator',
                        'name' => '¿Por qué elegirnos?',
                        'icon' => 'star',
                        'title' => 'Beneficios para tu compra',
                        'subtitle' => 'Envío gratis, soporte 24/7 y pagos seguros'
                    ];
                    $blocks[] = [
                        'type' => 'product-grid-navigator',
                        'name' => 'Productos Destacados',
                        'icon' => 'shopping-bag',
                        'title' => 'Productos Destacados',
                        'subtitle' => 'Los más vendidos del mes'
                    ];
                    $blocks[] = [
                        'type' => 'testimonials-navigator',
                        'name' => 'Testimonios',
                        'icon' => 'quote-left',
                        'title' => 'Lo que opinan nuestros clientes',
                        'subtitle' => 'Confianza y calidad garantizadas'
                    ];
                    $blocks[] = [
                        'type' => 'offers-navigator',
                        'name' => 'Ofertas Especiales',
                        'icon' => 'tag',
                        'title' => 'Ofertas y Descuentos',
                        'subtitle' => 'Promociones por tiempo limitado'
                    ];
                }
                break;
                
            case 'productos':
                if (($page['websiteKey'] ?? '') === 'tienda-minimalista') {
                    $blocks[] = [
                        'type' => 'product-grid-minimalist-navigator',
                        'name' => 'Catálogo Minimalista',
                        'icon' => 'th',
                        'title' => 'Catálogo Minimalista',
                        'subtitle' => 'Prendas esenciales en paleta neutra'
                    ];
                } else {
                    $blocks[] = [
                        'type' => 'product-grid-navigator',
                        'name' => 'Catálogo de Productos',
                        'icon' => 'shopping-bag',
                        'title' => 'Nuestros Productos',
                        'subtitle' => 'Catálogo completo con filtros'
                    ];
                    $blocks[] = [
                        'type' => 'features-navigator',
                        'name' => 'Garantías y Servicios',
                        'icon' => 'shield-alt',
                        'title' => 'Compra con confianza',
                        'subtitle' => 'Cambios fáciles y soporte dedicado'
                    ];
                }
                break;

            case 'categorias':
                if (($page['websiteKey'] ?? '') === 'tienda-minimalista') {
                    $blocks[] = [
                        'type' => 'category-grid-navigator',
                        'name' => 'Explora por Categorías',
                        'icon' => 'th-large',
                        'title' => 'Categorías de Moda',
                        'subtitle' => 'Mujer, Hombre, Accesorios y Calzado'
                    ];
                } else {
                    $blocks[] = [
                        'type' => 'category-grid-navigator',
                        'name' => 'Explora por Categorías',
                        'icon' => 'th-large',
                        'title' => 'Compra por Categorías',
                        'subtitle' => 'Electrónica, Hogar, Moda y más'
                    ];
                    $blocks[] = [
                        'type' => 'features-navigator',
                        'name' => 'Beneficios de Comprar',
                        'icon' => 'shield-alt',
                        'title' => 'Ventajas para ti',
                        'subtitle' => 'Garantía, envíos y soporte'
                    ];
                }
                break;

            case 'ofertas':
                $blocks[] = ['type' => 'offers-navigator', 'name' => 'Promociones', 'icon' => 'tags'];
                $blocks[] = ['type' => 'product-grid-navigator', 'name' => 'Productos en Oferta', 'icon' => 'percentage'];
                break;

            case 'mi-cuenta':
                $blocks[] = ['type' => 'features-navigator', 'name' => 'Panel del Cliente', 'icon' => 'user'];
                $blocks[] = ['type' => 'features-navigator', 'name' => 'Pedidos y Direcciones', 'icon' => 'box'];
                break;
                
            case 'servicios':
                $blocks[] = ['type' => 'features-navigator', 'name' => 'Nuestros Servicios', 'icon' => 'cogs'];
                $blocks[] = ['type' => 'testimonials-navigator', 'name' => 'Casos de Éxito', 'icon' => 'trophy'];
                break;
                
            case 'contacto':
                if (($page['websiteKey'] ?? '') === 'tienda-minimalista') {
                    $blocks[] = [
                        'type' => 'contact-form-navigator',
                        'name' => 'Contacto',
                        'icon' => 'envelope',
                        'title' => 'Contáctanos',
                        'subtitle' => 'Atención personalizada para tu compra',
                        'address' => 'Av. Minimal 101, Moda City',
                        'phone' => '+1 (555) 000-2025',
                        'email' => 'hola@minimalista.com'
                    ];
                } else {
                    $blocks[] = [
                        'type' => 'contact-form-navigator',
                        'name' => 'Contacto',
                        'icon' => 'envelope',
                        'title' => '¿Necesitas ayuda?',
                        'subtitle' => 'Estamos aquí para resolver tus dudas',
                        'address' => 'Calle Principal 123, Ciudad',
                        'phone' => '+1 (555) 123-4567',
                        'email' => 'soporte@tiendavirtual.com'
                    ];
                }
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
