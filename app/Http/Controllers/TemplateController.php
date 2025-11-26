<?php

namespace App\Http\Controllers;

use App\Models\Website;
use App\Services\TemplateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TemplateController extends Controller
{
    use AuthorizesRequests;

    protected $templateService;

    public function __construct(TemplateService $templateService)
    {
        $this->templateService = $templateService;
    }

    public function index()
    {
        $templates = $this->templateService->groupByCategory();
        $categories = $this->templateService->getCategories();

        // Obtener el sitio web actual
        $website = Website::find(session('selected_website_id'));

        return view('creator.templates.index', compact('templates', 'categories', 'website'));
    }

    public function show(string $slug)
    {
        $template = $this->templateService->find($slug);

        if (!$template) {
            abort(404, 'Plantilla no encontrada');
        }

        return view('creator.templates.show', compact('template'));
    }

    public function apply(Request $request, Website $website, string $slug)
    {
        $this->authorize('update', $website);

        $template = $this->templateService->find($slug);

        if (!$template) {
            return redirect()->back()->with('error', 'Plantilla no encontrada');
        }

        // Verificar si el usuario puede usar plantillas premium
        if (($template['is_premium'] ?? false) && !$this->canUsePremiumTemplates()) {
            return redirect()->back()
                ->with('error', 'Necesitas un plan premium para usar esta plantilla');
        }

        // Aplicar la plantilla a la página de inicio
        $homePage = $website->pages()->where('is_home', true)->first();

        if (!$homePage) {
            // Si no hay página de inicio, buscar por slug 'inicio' o crear una nueva
            $homePage = $website->pages()->where('slug', 'inicio')->first();

            if (!$homePage) {
                // Crear una nueva página de inicio
                $homePage = $website->pages()->create([
                    'title' => 'Inicio',
                    'slug' => 'inicio',
                    'is_home' => true,
                    'is_published' => true,
                    'html_content' => '',
                    'css_content' => '',
                ]);
            } else {
                // Marcar como página de inicio si no lo está
                $homePage->update(['is_home' => true]);
            }
        }

        // Procesar los hooks de la plantilla antes de guardarla
        $processedContent = $this->processTemplateHooks($template['html_content'], $website, $homePage);

        // Actualizar el contenido de la página de inicio con la plantilla procesada
        $homePage->update([
            'html_content' => $processedContent,
            'css_content' => $template['css_content'] ?? '',
        ]);

        // Actualizar el sitio web con el slug de la plantilla
        $website->update([
            'template_id' => $slug,
        ]);

        // Importar páginas prediseñadas de la plantilla
        $templatePageService = new \App\Services\TemplatePageService();
        $result = $templatePageService->importTemplatePages($website, $slug);

        if ($result['success'] && $result['imported'] > 0) {
            return redirect()->route('creator.templates.index')
                ->with('success', "Plantilla aplicada exitosamente. {$result['imported']} páginas prediseñadas fueron importadas.");
        }

        return redirect()->route('creator.templates.index')
            ->with('success', 'Plantilla aplicada exitosamente.');
    }

    public function preview(string $slug)
    {
        $template = $this->templateService->find($slug);

        if (!$template) {
            abort(404, 'Plantilla no encontrada');
        }

        // Crear un mock del modelo Website dinámico para la vista previa
        $templateName = $template['name'] ?? ucwords(str_replace('-', ' ', $slug));
        $website = new class($slug, $templateName) {
            public $name;
            public $slug;
            public $user_id;
            public $api_key;
            public $api_base_url;
            public $epayco_public_key;
            public $epayco_private_key;
            public $epayco_customer_id;

            public function __construct($slug, $name)
            {
                $this->slug = $slug;
                $this->name = $name;
                $this->user_id = null; // No hay usuario en el preview
                $this->api_key = '';
                $this->api_base_url = '';
                $this->epayco_public_key = '';
                $this->epayco_private_key = '';
                $this->epayco_customer_id = '';
            }

            public function menus()
            {
                return new class {
                    public function where($field, $value)
                    {
                        return $this;
                    }
                    public function first()
                    {
                        return null; // No hay menú configurado, usará el fallback
                    }
                };
            }

            public function pages()
            {
                return new class {
                    public function where($field, $value)
                    {
                        return $this;
                    }
                    public function exists()
                    {
                        return false; // No hay páginas en preview
                    }
                };
            }
        };

        // Para la vista previa, no necesitamos páginas específicas
        $homePage = null;

        // Renderizar la plantilla directamente
        $templateFile = $template['templates']['home'] ?? 'template.blade.php';
        $viewPath = 'templates.' . $template['slug'] . '.' . str_replace('.blade.php', '', $templateFile);

        $customization = $template['customization'] ?? [];

        return view($viewPath, [
            'website' => $website,
            'page' => $homePage,
            'pages' => collect(), // No hay páginas en preview de plantilla
            'customization' => $customization
        ]);
    }

    private function canUsePremiumTemplates()
    {
        $user = Auth::user();

        // Verificar si el usuario tiene un plan que permita plantillas premium
        if ($user->plan) {
            return $user->plan->name !== 'Plan Gratuito';
        }

        return false;
    }

    /**
     * Procesar hooks de plantilla
     */
    private function processTemplateHooks($templateContent, $website, $homePage)
    {
        // Obtener menús del sitio web
        $menus = $website->menus()->with(['items' => function ($query) {
            $query->whereNull('parent_id')->where('is_active', true)->orderBy('order');
        }, 'items.page', 'items.children' => function ($query) {
            $query->where('is_active', true)->orderBy('order');
        }, 'items.children.page'])->get();

        // Detectar si estamos en modo preview
        $isPreview = request()->is('creator/websites/*/preview*');

        // Definir hooks disponibles
        $hooks = $this->getTemplateHooks($website, $homePage, $menus, $isPreview);

        // Procesar hooks en el contenido
        return $this->processHooks($templateContent, $hooks);
    }

    /**
     * Definir todos los hooks disponibles para las plantillas
     */
    private function getTemplateHooks($website, $homePage, $menus, $isPreview = false)
    {
        return [
            // Hooks básicos del sitio web
            'SITIO_WEB_NOMBRE' => $website->name ?? "Mi Sitio Web",
            'SITIO_WEB_DESCRIPCION' => $website->description ?? "Descripción de mi sitio web",
            'ANIO_ACTUAL' => date("Y"),

            // Hooks de la página de inicio
            'PAGINA_TITULO' => $homePage->title ?? $website->name ?? "Mi Sitio Web",
            'PAGINA_DESCRIPCION' => $homePage->meta_description ?? $website->description ?? "Descripción de mi sitio web",

            // Hooks de menús
            'MENU_HEADER_ITEMS' => $this->generateHeaderMenuSimple($website, $menus, $isPreview),
            'MENU_FOOTER_ITEMS' => $this->generateFooterMenuSimple($website, $menus, $isPreview),

            // Hooks de contenido
            'CONTENIDO_PAGINA' => $this->getDefaultPageContent(),

            // Hooks de credenciales API
            'API_KEY' => $website->api_key ?? '',
            'API_BASE_URL' => $website->api_base_url ?? '',
            'EPAYCO_PUBLIC_KEY' => $website->epayco_public_key ?? '',
            'EPAYCO_PRIVATE_KEY' => $website->epayco_private_key ?? '',
            'EPAYCO_CUSTOMER_ID' => $website->epayco_customer_id ?? '',

            // Hooks de contacto
            'CONTACTO_EMAIL' => $website->contact_email ?? 'contacto@misitio.com',
            'CONTACTO_TELEFONO' => $website->contact_phone ?? '+1 (555) 123-4567',
            'CONTACTO_DIRECCION' => $website->contact_address ?? 'Ciudad, País',

            // Hooks de redes sociales
            'FACEBOOK_URL' => $website->facebook_url ?? '#',
            'INSTAGRAM_URL' => $website->instagram_url ?? '#',
            'TWITTER_URL' => $website->twitter_url ?? '#',
            'LINKEDIN_URL' => $website->linkedin_url ?? '#',
        ];
    }

    /**
     * Procesar hooks en el contenido de la plantilla
     */
    private function processHooks($content, $hooks)
    {
        // Reemplazar todos los hooks
        foreach ($hooks as $hook => $value) {
            $content = str_replace($hook, $value, $content);
        }

        // También procesar hooks con formato {{ HOOK }}
        foreach ($hooks as $hook => $value) {
            $content = str_replace('{{ ' . $hook . ' }}', $value, $content);
            $content = str_replace('{{' . $hook . '}}', $value, $content);
        }

        // Limpiar cualquier hook que no haya sido reemplazado
        $content = preg_replace('/\{{\s*[A-Z_]+\s*\}\}/', '', $content);

        return $content;
    }

    /**
     * Generar HTML simple del menú del header
     */
    private function generateHeaderMenuSimple($website, $menus, $isPreview = false)
    {
        $headerMenu = $menus->where('location', 'header')->first();

        if ($headerMenu && $headerMenu->items->count() > 0) {
            $menuItems = '';
            foreach ($headerMenu->items as $item) {
                $icon = $item->icon ? '<i class="' . $item->icon . ' mr-1"></i>' : '';

                // Si estamos en modo preview, crear enlaces que mantengan el contexto de preview
                if ($isPreview) {
                    $previewUrl = $this->generatePreviewUrl($item, $website);
                    $menuItems .= '<a href="' . $previewUrl . '" class="text-gray-600 hover:text-gray-900 transition-colors duration-200">' . $icon . $item->title . '</a>';
                } else {
                    $menuItems .= '<a href="' . $item->final_url . '" target="' . $item->target . '" class="text-gray-600 hover:text-gray-900 transition-colors duration-200">' . $icon . $item->title . '</a>';
                }
            }
            return $menuItems;
        }

        // Menú por defecto
        if ($isPreview) {
            return '<a href="/creator/websites/' . $website->id . '/preview" class="text-gray-600 hover:text-gray-900">Inicio</a>
                    <a href="/creator/websites/' . $website->id . '/preview" class="text-gray-600 hover:text-gray-900">Productos</a>
                    <a href="/creator/websites/' . $website->id . '/preview" class="text-gray-600 hover:text-gray-900">Contacto</a>';
        } else {
            return '<a href="/" class="text-gray-600 hover:text-gray-900">Inicio</a>
                    <a href="/productos" class="text-gray-600 hover:text-gray-900">Productos</a>
                    <a href="/contacto" class="text-gray-600 hover:text-gray-900">Contacto</a>';
        }
    }

    /**
     * Generar HTML simple del menú del footer
     */
    private function generateFooterMenuSimple($website, $menus, $isPreview = false)
    {
        $footerMenu = $menus->where('location', 'footer')->first();

        if ($footerMenu && $footerMenu->items->count() > 0) {
            $menuItems = '';
            foreach ($footerMenu->items as $item) {
                $icon = $item->icon ? '<i class="' . $item->icon . ' mr-1"></i>' : '';

                // Si estamos en modo preview, crear enlaces que mantengan el contexto de preview
                if ($isPreview) {
                    $previewUrl = $this->generatePreviewUrl($item, $website);
                    $menuItems .= '<li><a href="' . $previewUrl . '" class="text-gray-400 hover:text-white transition-colors duration-200">' . $icon . $item->title . '</a></li>';
                } else {
                    $menuItems .= '<li><a href="' . $item->final_url . '" target="' . $item->target . '" class="text-gray-400 hover:text-white transition-colors duration-200">' . $icon . $item->title . '</a></li>';
                }
            }
            return $menuItems;
        }

        // Menú por defecto
        if ($isPreview) {
            return '<li><a href="/creator/websites/' . $website->id . '/preview" class="text-gray-400 hover:text-white">Inicio</a></li>
                    <li><a href="/creator/websites/' . $website->id . '/preview" class="text-gray-400 hover:text-white">Productos</a></li>
                    <li><a href="/creator/websites/' . $website->id . '/preview" class="text-gray-400 hover:text-white">Contacto</a></li>';
        } else {
            return '<li><a href="/" class="text-gray-400 hover:text-white">Inicio</a></li>
                    <li><a href="/productos" class="text-gray-400 hover:text-white">Productos</a></li>
                    <li><a href="/contacto" class="text-gray-400 hover:text-white">Contacto</a></li>';
        }
    }

    /**
     * Generar URL de preview para un item del menú
     */
    private function generatePreviewUrl($item, $website)
    {
        // Si es un enlace externo, mantener el enlace original pero abrir en nueva ventana
        if ($item->target === '_blank' || strpos($item->final_url, 'http') === 0) {
            return $item->final_url;
        }

        // Si el item apunta a una página específica del sitio web, usar preview de esa página
        if ($item->page_id) {
            return "/creator/websites/{$website->id}/preview/pages/{$item->page_id}";
        }

        // Para enlaces internos que no son páginas específicas, mantener en la vista preview principal
        return "/creator/websites/{$website->id}/preview";
    }

    /**
     * Obtener contenido por defecto de la página
     */
    private function getDefaultPageContent()
    {
        return '<section class="py-16 text-white bg-gradient-to-r from-blue-600 to-purple-600">
                    <div class="container px-4 mx-auto text-center">
                        <h2 class="mb-4 text-4xl font-bold">Bienvenido a tu sitio web</h2>
                        <p class="mb-8 text-xl">Crea contenido increíble y compártelo con el mundo</p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="/productos" class="px-8 py-3 font-semibold text-blue-600 transition-colors bg-white rounded-lg hover:bg-gray-100">
                                Ver Productos
                            </a>
                            <a href="/contacto" class="px-8 py-3 font-semibold text-white transition-colors border-2 border-white rounded-lg hover:bg-white hover:text-blue-600">
                                Contactar
                            </a>
                        </div>
                    </div>
                </section>';
    }

    /**
     * Mostrar el blog de una plantilla
     */
    public function blog($slug)
    {
        $template = $this->templateService->find($slug);

        if (!$template) {
            abort(404, 'Plantilla no encontrada');
        }

        // Crear un mock del modelo Website dinámico
        $templateName = $template['name'] ?? ucwords(str_replace('-', ' ', $slug));
        $website = new class($slug, $templateName) {
            public $name;
            public $slug;
            public $user_id;
            public $api_key;
            public $api_base_url;
            public $epayco_public_key;
            public $epayco_private_key;
            public $epayco_customer_id;

            public function __construct($slug, $name)
            {
                $this->slug = $slug;
                $this->name = $name;
                $this->user_id = null; // No hay usuario en el preview
                $this->api_key = '';
                $this->api_base_url = '';
                $this->epayco_public_key = '';
                $this->epayco_private_key = '';
                $this->epayco_customer_id = '';
            }

            public function menus()
            {
                return new class {
                    public function where($field, $value)
                    {
                        return $this;
                    }
                    public function first()
                    {
                        return null; // No hay menú configurado, usará el fallback
                    }
                };
            }
        };

        return view("templates.{$slug}.blog", [
            'website' => $website,
            'customization' => [
                'header' => [],
                'footer' => []
            ]
        ]);
    }

    /**
     * Mostrar el contacto de una plantilla
     */
    public function contacto($slug)
    {
        $template = $this->templateService->find($slug);

        if (!$template) {
            abort(404, 'Plantilla no encontrada');
        }

        // Crear un mock del modelo Website dinámico
        $templateName = $template['name'] ?? ucwords(str_replace('-', ' ', $slug));
        $website = new class($slug, $templateName) {
            public $name;
            public $slug;
            public $user_id;
            public $api_key;
            public $api_base_url;
            public $epayco_public_key;
            public $epayco_private_key;
            public $epayco_customer_id;

            public function __construct($slug, $name)
            {
                $this->slug = $slug;
                $this->name = $name;
                $this->user_id = null; // No hay usuario en el preview
                $this->api_key = '';
                $this->api_base_url = '';
                $this->epayco_public_key = '';
                $this->epayco_private_key = '';
                $this->epayco_customer_id = '';
            }

            public function menus()
            {
                return new class {
                    public function where($field, $value)
                    {
                        return $this;
                    }
                    public function first()
                    {
                        return null; // No hay menú configurado, usará el fallback
                    }
                };
            }
        };

        return view("templates.{$slug}.contacto", [
            'website' => $website,
            'customization' => [
                'header' => [],
                'footer' => []
            ]
        ]);
    }
}
