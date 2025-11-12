<?php

namespace App\Services;

use App\Models\Website;
use App\Models\Page;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class UniversalPageImportService
{
    /**
     * Categorías de sitios web y sus páginas típicas
     */
    private $siteCategories = [
        'ecommerce' => [
            'name' => 'Tiendas Online',
            'templates' => ['tienda-virtual', 'tienda-minimalista', 'moda-boutique'],
            'common_pages' => [
                'inicio' => 'Página de inicio con productos destacados',
                'productos' => 'Catálogo de productos',
                'categorias' => 'Categorías de productos',
                'carrito' => 'Carrito de compras',
                'checkout' => 'Proceso de compra',
                'sobre-nosotros' => 'Información de la empresa',
                'contacto' => 'Información de contacto'
            ],
            'specialized_pages' => [
                'mujer' => 'Sección de moda femenina',
                'hombre' => 'Sección de moda masculina',
                'accesorios' => 'Accesorios y complementos',
                'colecciones' => 'Colecciones especiales',
                'ofertas' => 'Página de ofertas y descuentos',
                'nuevos' => 'Productos nuevos',
                'marcas' => 'Marcas disponibles'
            ]
        ],
        'business' => [
            'name' => 'Negocios y Servicios',
            'templates' => ['agencia-creativa', 'consultoria-corporativa', 'inmobiliaria'],
            'common_pages' => [
                'inicio' => 'Página principal con servicios',
                'servicios' => 'Listado de servicios',
                'sobre-nosotros' => 'Historia y equipo',
                'contacto' => 'Información de contacto',
                'blog' => 'Artículos y noticias'
            ],
            'specialized_pages' => [
                'portfolio' => 'Trabajos realizados',
                'casos-exito' => 'Casos de éxito',
                'equipo' => 'Nuestro equipo',
                'testimonios' => 'Testimonios de clientes',
                'propiedades' => 'Propiedades disponibles',
                'servicios-detallados' => 'Servicios detallados'
            ]
        ],
        'health' => [
            'name' => 'Salud y Bienestar',
            'templates' => ['medico-clinica', 'gimnasio-fitness', 'spa-bienestar'],
            'common_pages' => [
                'inicio' => 'Página principal',
                'servicios' => 'Servicios médicos/deportivos',
                'sobre-nosotros' => 'Información del centro',
                'contacto' => 'Contacto y ubicación'
            ],
            'specialized_pages' => [
                'especialidades' => 'Especialidades médicas',
                'doctores' => 'Equipo médico',
                'citas' => 'Agendar cita',
                'membresias' => 'Planes de membresía',
                'clases' => 'Clases disponibles',
                'entrenadores' => 'Instructores',
                'instalaciones' => 'Instalaciones'
            ]
        ],
        'education' => [
            'name' => 'Educación',
            'templates' => ['academia-online'],
            'common_pages' => [
                'inicio' => 'Página principal',
                'cursos' => 'Catálogo de cursos',
                'sobre-nosotros' => 'Sobre la academia',
                'contacto' => 'Información de contacto'
            ],
            'specialized_pages' => [
                'instructores' => 'Profesores',
                'mi-aprendizaje' => 'Dashboard del estudiante',
                'planes' => 'Planes de suscripción',
                'blog' => 'Artículos educativos'
            ]
        ],
        'creative' => [
            'name' => 'Creativos y Portfolio',
            'templates' => ['portafolio-fotografo', 'cv-personal', 'blog-minimalista'],
            'common_pages' => [
                'inicio' => 'Página principal',
                'sobre-mi' => 'Sobre el creador',
                'contacto' => 'Información de contacto'
            ],
            'specialized_pages' => [
                'portfolio' => 'Trabajos realizados',
                'galeria' => 'Galería de fotos',
                'servicios' => 'Servicios ofrecidos',
                'blog' => 'Artículos y posts',
                'archivo' => 'Archivo de publicaciones'
            ]
        ],
        'events' => [
            'name' => 'Eventos y Entretenimiento',
            'templates' => ['evento-conferencia', 'musico-banda', 'restaurante-menu'],
            'common_pages' => [
                'inicio' => 'Página principal',
                'sobre-nosotros' => 'Información del evento/restaurante',
                'contacto' => 'Información de contacto'
            ],
            'specialized_pages' => [
                'agenda' => 'Programa del evento',
                'ponentes' => 'Ponentes/artistas',
                'menu' => 'Menú del restaurante',
                'reservas' => 'Reservar mesa',
                'galeria' => 'Galería de fotos',
                'eventos' => 'Eventos privados'
            ]
        ]
    ];

    /**
     * Obtener todas las categorías disponibles
     */
    public function getCategories(): array
    {
        return $this->siteCategories;
    }

    /**
     * Obtener páginas disponibles para una categoría específica
     */
    public function getPagesForCategory(string $category): array
    {
        if (!isset($this->siteCategories[$category])) {
            return [];
        }

        $categoryData = $this->siteCategories[$category];
        
        return [
            'name' => $categoryData['name'],
            'common_pages' => $categoryData['common_pages'],
            'specialized_pages' => $categoryData['specialized_pages'],
            'templates' => $categoryData['templates']
        ];
    }

    /**
     * Obtener páginas disponibles de una plantilla específica
     */
    public function getTemplatePages(string $templateSlug): array
    {
        $pagesFile = resource_path("views/templates/{$templateSlug}/pages.json");
        
        if (!File::exists($pagesFile)) {
            return [];
        }
        
        try {
            $pagesData = json_decode(File::get($pagesFile), true);
            return $pagesData['pages'] ?? [];
        } catch (\Exception $e) {
            Log::error("Error leyendo páginas de plantilla: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Importar páginas seleccionadas a un sitio web
     */
    public function importSelectedPages(Website $website, array $selectedPages, string $templateSlug = null): array
    {
        $imported = 0;
        $skipped = 0;
        $errors = [];

        foreach ($selectedPages as $pageSlug) {
            try {
                // Si se especifica una plantilla, usar sus páginas
                if ($templateSlug) {
                    $templatePages = $this->getTemplatePages($templateSlug);
                    $pageData = collect($templatePages)->firstWhere('slug', $pageSlug);
                    
                    if (!$pageData) {
                        $errors[] = "Página '{$pageSlug}' no encontrada en la plantilla '{$templateSlug}'";
                        continue;
                    }
                } else {
                    // Crear página básica si no hay plantilla específica
                    $pageData = $this->createBasicPageData($pageSlug);
                }

                // Verificar si la página ya existe
                $existingPage = $website->pages()
                    ->where('slug', $pageData['slug'])
                    ->first();
                
                if ($existingPage) {
                    $skipped++;
                    continue;
                }

                // Crear nueva página
                $page = new Page([
                    'website_id' => $website->id,
                    'title' => $pageData['title'],
                    'slug' => $pageData['slug'],
                    'content' => $pageData['content'] ?? '',
                    'blocks' => json_encode($pageData['blocks'] ?? []),
                    'is_home' => $pageData['is_home'] ?? false,
                    'is_published' => true,
                    'sort_order' => $website->pages()->max('sort_order') + 1,
                    'meta_title' => $pageData['meta_title'] ?? $pageData['title'],
                    'meta_description' => $pageData['meta_description'] ?? '',
                ]);

                $page->save();
                $imported++;

            } catch (\Exception $e) {
                $errors[] = "Error importando página '{$pageSlug}': " . $e->getMessage();
                Log::error("Error importando página: " . $e->getMessage());
            }
        }

        return [
            'success' => $imported > 0,
            'imported' => $imported,
            'skipped' => $skipped,
            'errors' => $errors,
            'message' => "Se importaron {$imported} páginas, {$skipped} omitidas"
        ];
    }

    /**
     * Crear datos básicos de página cuando no hay plantilla específica
     */
    public function createBasicPageData(string $pageSlug): array
    {
        $pageTemplates = [
            'inicio' => [
                'title' => 'Inicio',
                'slug' => 'inicio',
                'is_home' => true,
                'meta_title' => 'Bienvenido',
                'meta_description' => 'Página de inicio',
                'content' => '<h1>Bienvenido</h1><p>Esta es la página de inicio de tu sitio web.</p>',
                'blocks' => [
                    [
                        'type' => 'hero',
                        'title' => 'Bienvenido',
                        'subtitle' => 'Esta es tu página de inicio',
                        'cta_text' => 'Conocer más',
                        'cta_link' => '/sobre-nosotros'
                    ]
                ]
            ],
            'sobre-nosotros' => [
                'title' => 'Sobre Nosotros',
                'slug' => 'sobre-nosotros',
                'is_home' => false,
                'meta_title' => 'Sobre Nosotros',
                'meta_description' => 'Conoce más sobre nosotros',
                'content' => '<h1>Sobre Nosotros</h1><p>Información sobre nuestra empresa.</p>',
                'blocks' => [
                    [
                        'type' => 'page_header',
                        'title' => 'Sobre Nosotros',
                        'subtitle' => 'Nuestra Historia'
                    ]
                ]
            ],
            'contacto' => [
                'title' => 'Contacto',
                'slug' => 'contacto',
                'is_home' => false,
                'meta_title' => 'Contacto',
                'meta_description' => 'Ponte en contacto con nosotros',
                'content' => '<h1>Contacto</h1><p>Estamos aquí para ayudarte.</p>',
                'blocks' => [
                    [
                        'type' => 'page_header',
                        'title' => 'Contacto',
                        'subtitle' => 'Estamos Aquí'
                    ],
                    [
                        'type' => 'contact_form',
                        'fields' => ['name', 'email', 'message'],
                        'submit_text' => 'Enviar Mensaje'
                    ]
                ]
            ]
        ];

        return $pageTemplates[$pageSlug] ?? [
            'title' => ucfirst(str_replace('-', ' ', $pageSlug)),
            'slug' => $pageSlug,
            'is_home' => false,
            'meta_title' => ucfirst(str_replace('-', ' ', $pageSlug)),
            'meta_description' => 'Página de ' . str_replace('-', ' ', $pageSlug),
            'content' => '<h1>' . ucfirst(str_replace('-', ' ', $pageSlug)) . '</h1><p>Contenido de la página.</p>',
            'blocks' => []
        ];
    }

    /**
     * Obtener páginas recomendadas para una categoría
     */
    public function getRecommendedPages(string $category): array
    {
        $categoryData = $this->getPagesForCategory($category);
        
        if (empty($categoryData)) {
            return [];
        }

        // Combinar páginas comunes y especializadas
        $allPages = array_merge(
            $categoryData['common_pages'],
            $categoryData['specialized_pages']
        );

        return $allPages;
    }

    /**
     * Obtener plantillas disponibles para una categoría
     */
    public function getTemplatesForCategory(string $category): array
    {
        $categoryData = $this->getPagesForCategory($category);
        return $categoryData['templates'] ?? [];
    }
}
