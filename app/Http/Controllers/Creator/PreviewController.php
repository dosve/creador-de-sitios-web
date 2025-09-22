<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\Website;
use App\Models\Page;
use App\Models\BlogPost;
use App\Models\Template;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PreviewController extends Controller
{
    use AuthorizesRequests;

    /**
     * Mostrar vista previa del sitio web
     */
    public function index(Request $request, Website $website)
    {
        $this->authorize('view', $website);

        // Obtener páginas del sitio web
        $pages = $website->pages()->where('is_published', true)->orderBy('sort_order')->get();

        // Obtener la página de inicio
        $homePage = $pages->where('is_home', true)->first() ?? $pages->first();

        // Obtener menús del sitio web
        $menus = $website->menus()->with(['items' => function($query) {
            $query->whereNull('parent_id')->where('is_active', true)->orderBy('order');
        }, 'items.children' => function($query) {
            $query->where('is_active', true)->orderBy('order');
        }])->get();

        // Si el sitio web tiene plantilla aplicada, procesar en tiempo real con modo preview
        if ($website->template_id) {
            $template = $website->template;
            if ($template) {
                // Procesar la plantilla en tiempo real con modo preview
                $processedContent = $this->processTemplateSimple($template->html_content, $website, $homePage, $menus);
                return response($processedContent);
            }
        }

        // Si no tiene plantilla pero tiene contenido personalizado, usar vista en blanco
        if (!$website->template_id && $homePage && $homePage->html_content) {
            return view('creator.preview.blank', compact('website', 'homePage', 'menus'))->with('template', null);
        }

        // Si no tiene plantilla, mostrar mensaje para seleccionar plantilla
        if (!$website->template_id) {
            return view('creator.preview.no-template', compact('website', 'pages', 'homePage', 'menus'));
        }

        // Si no tiene contenido, usar el layout con navbar/footer
        $blogPosts = $website->blogPosts()->where('is_published', true)->latest()->take(5)->get();

        return view('creator.preview.index', compact('website', 'pages', 'blogPosts', 'homePage', 'menus'));
    }

    /**
     * Mostrar vista previa de una página específica
     */
    public function page(Request $request, Website $website, Page $page)
    {
        $this->authorize('view', $website);

        // Verificar que la página pertenece al sitio web
        if ($page->website_id !== $website->id) {
            abort(403);
        }

        // Si el sitio web no tiene plantilla (página en blanco), usar vista sin navbar/footer
        if (!$website->template_id) {
            return view('creator.preview.blank-page', compact('website', 'page'));
        }

        // Si tiene plantilla, procesar con el sistema de hooks
        $template = $website->template;
        if ($template) {
            // Obtener menús del sitio web
            $menus = $website->menus()->with(['items' => function($query) {
                $query->whereNull('parent_id')->where('is_active', true)->orderBy('order');
            }, 'items.children' => function($query) {
                $query->where('is_active', true)->orderBy('order');
            }])->get();
            
            // Procesar la plantilla en tiempo real con modo preview
            $processedContent = $this->processTemplateSimple($template->html_content, $website, $page, $menus);
            return response($processedContent);
        }

        // Fallback: usar el layout con navbar/footer
        $pages = $website->pages()->where('is_published', true)->orderBy('sort_order')->get();
        return view('creator.preview.page', compact('website', 'page', 'pages'));
    }

    /**
     * Mostrar vista previa de un post del blog
     */
    public function blogPost(Request $request, Website $website, BlogPost $blogPost)
    {
        $this->authorize('view', $website);

        // Verificar que el post pertenece al sitio web
        if ($blogPost->website_id !== $website->id) {
            abort(403);
        }

        // Obtener páginas para el menú de navegación
        $pages = $website->pages()->where('is_published', true)->orderBy('sort_order')->get();

        // Obtener posts relacionados
        $relatedPosts = $website->blogPosts()
            ->where('is_published', true)
            ->where('id', '!=', $blogPost->id)
            ->where('category_id', $blogPost->category_id)
            ->latest()
            ->take(3)
            ->get();

        return view('creator.preview.blog-post', compact('website', 'blogPost', 'pages', 'relatedPosts'));
    }

    /**
     * Mostrar vista previa del blog
     */
    public function blog(Request $request, Website $website)
    {
        $this->authorize('view', $website);

        // Obtener páginas para el menú de navegación
        $pages = $website->pages()->where('is_published', true)->orderBy('sort_order')->get();

        // Obtener posts del blog con paginación
        $blogPosts = $website->blogPosts()
            ->where('is_published', true)
            ->with(['category', 'tags'])
            ->latest()
            ->paginate(6);

        // Obtener categorías
        $categories = $website->categories()->where('is_active', true)->get();

        return view('creator.preview.blog', compact('website', 'pages', 'blogPosts', 'categories'));
    }

    /**
     * Mostrar vista previa de contacto
     */
    public function contact(Request $request, Website $website)
    {
        $this->authorize('view', $website);

        // Obtener páginas para el menú de navegación
        $pages = $website->pages()->where('is_published', true)->orderBy('sort_order')->get();

        // Obtener formularios de contacto
        $contactForms = $website->forms()
            ->where('type', 'contact')
            ->where('is_active', true)
            ->get();

        return view('creator.preview.contact', compact('website', 'pages', 'contactForms'));
    }

    /**
     * Mostrar vista previa de una plantilla
     */
    public function template(Request $request, Template $template)
    {
        // Verificar que la plantilla esté activa
        if (!$template->is_active) {
            abort(404, 'Plantilla no disponible');
        }

        // Obtener las credenciales del usuario autenticado
        $userWebsite = Website::where('user_id', auth()->id())->first();

        $apiKey = $userWebsite ? $userWebsite->api_key : '';
        $apiBaseUrl = $userWebsite ? $userWebsite->api_base_url : '';
        $epaycoPublicKey = $userWebsite ? $userWebsite->epayco_public_key : '';
        $epaycoPrivateKey = $userWebsite ? $userWebsite->epayco_private_key : '';
        $epaycoCustomerId = $userWebsite ? $userWebsite->epayco_customer_id : '';

        // Crear un sitio web temporal para la vista previa
        $tempWebsite = new Website([
            'name' => 'Vista Previa - ' . $template->name,
            'description' => $template->description,
            'slug' => 'preview-template-' . $template->id,
            'user_id' => auth()->id(),
            'template_id' => $template->id,
        ]);

        // Crear una página temporal con el contenido de la plantilla
        $tempPage = new Page([
            'title' => $template->name,
            'slug' => 'preview',
            'html_content' => $template->html_content,
            'css_content' => $template->css_content,
            'is_published' => true,
            'is_home' => true,
        ]);

        return view('creator.preview.template', compact('template', 'tempWebsite', 'tempPage', 'apiKey', 'apiBaseUrl', 'epaycoPublicKey', 'epaycoPrivateKey', 'epaycoCustomerId'));
    }

    /**
     * Procesar el código Blade de la plantilla
     */
    private function processTemplateBlade($templateContent, $website, $homePage, $menus)
    {
        try {
            // Crear un archivo temporal en la carpeta de vistas
            $tempFileName = 'temp_template_' . uniqid() . '.blade.php';
            $tempFile = resource_path('views/' . $tempFileName);
            file_put_contents($tempFile, $templateContent);
            
            // Preparar las variables para la vista
            $data = [
                'website' => $website,
                'homePage' => $homePage,
                'menus' => $menus,
            ];
            
            // Usar el view helper de Laravel para renderizar correctamente
            $viewName = basename($tempFileName, '.blade.php');
            $view = view($viewName, $data);
            $processedContent = $view->render();
            
            // Limpiar archivos temporales
            if (file_exists($tempFile)) {
                unlink($tempFile);
            }
            
            return $processedContent;
            
        } catch (\Exception $e) {
            // Si hay error, usar el método de reemplazo simple como fallback
            Log::error('Error procesando plantilla Blade: ' . $e->getMessage());
            
            // Limpiar archivo temporal si existe
            if (isset($tempFile) && file_exists($tempFile)) {
                unlink($tempFile);
            }
            
            return $this->processTemplateSimple($templateContent, $website, $homePage, $menus);
        }
    }
    
    /**
     * Procesamiento simple de plantilla usando sistema de hooks
     */
    private function processTemplateSimple($templateContent, $website, $homePage, $menus)
    {
        // Detectar si estamos en modo preview
        $isPreview = request()->is('creator/websites/*/preview*');
        
        // Definir hooks disponibles
        $hooks = $this->getTemplateHooks($website, $homePage, $menus, $isPreview);
        
        // Procesar hooks en el contenido
        $processedContent = $this->processHooks($templateContent, $hooks);
        
        return $processedContent;
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
            'CONTENIDO_PAGINA' => $this->getPageContent($homePage, $isPreview),
            
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
     * Generar HTML del menú del header
     */
    private function generateHeaderMenu($website, $menus)
    {
        $headerMenu = $menus->where('location', 'header')->first();
        
        if ($headerMenu && $headerMenu->items->count() > 0) {
            $menuItems = '';
            foreach ($headerMenu->items as $item) {
                $icon = $item->icon ? $item->icon . ' ' : '';
                $menuItems .= '<a href="' . $item->final_url . '" target="' . $item->target . '" class="text-gray-600 hover:text-gray-900 transition-colors duration-200">' . $icon . $item->title . '</a>';
            }
            return $menuItems;
        }
        
        // Menú por defecto
        return '<a href="/" class="text-gray-600 hover:text-gray-900">Inicio</a>
                <a href="/productos" class="text-gray-600 hover:text-gray-900">Productos</a>
                <a href="/contacto" class="text-gray-600 hover:text-gray-900">Contacto</a>';
    }
    
    /**
     * Generar HTML del menú del footer
     */
    private function generateFooterMenu($website, $menus)
    {
        $footerMenu = $menus->where('location', 'footer')->first();
        
        if ($footerMenu && $footerMenu->items->count() > 0) {
            $menuItems = '';
            foreach ($footerMenu->items as $item) {
                $icon = $item->icon ? $item->icon . ' ' : '';
                $menuItems .= '<li><a href="' . $item->final_url . '" target="' . $item->target . '" class="text-gray-400 hover:text-white transition-colors duration-200">' . $icon . $item->title . '</a></li>';
            }
            return $menuItems;
        }
        
        // Menú por defecto
        return '<li><a href="/" class="text-gray-400 hover:text-white">Inicio</a></li>
                <li><a href="/productos" class="text-gray-400 hover:text-white">Productos</a></li>
                <li><a href="/contacto" class="text-gray-400 hover:text-white">Contacto</a></li>';
    }
    
    /**
     * Generar contenido de la página
     */
    private function generatePageContent($homePage)
    {
        if ($homePage && $homePage->html_content) {
            return '<div class="container mx-auto px-4 py-8">
                        <div class="prose max-w-none">
                            ' . $homePage->html_content . '
                        </div>
                    </div>';
        }
        
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
     * Reemplazar el menú del header en el contenido
     */
    private function replaceHeaderMenu($content, $menuHtml)
    {
        // Buscar y reemplazar TODAS las instancias del bloque del menú del header
        // Usar un patrón más simple y robusto
        $pattern = '/@if\(\$website->menus\(\)->where\("location", "header"\)->exists\(\)\)(.*?)@endif/s';
        
        // Reemplazar TODAS las ocurrencias
        $content = preg_replace($pattern, $menuHtml, $content);
        
        // También intentar con el patrón @else
        $patternWithElse = '/@if\(\$website->menus\(\)->where\("location", "header"\)->exists\(\)\)(.*?)@else(.*?)@endif/s';
        $content = preg_replace($patternWithElse, $menuHtml, $content);
        
        // También reemplazar directamente las variables Blade que quedan
        $content = preg_replace('/\{\{\s*\$website->name\s*\?\?\s*"[^"]*"\s*\}\}/', $website->name ?? "Mi Sitio Web", $content);
        
        return $content;
    }
    
    /**
     * Reemplazar el menú del footer en el contenido
     */
    private function replaceFooterMenu($content, $menuHtml)
    {
        // Buscar y reemplazar TODAS las instancias del bloque del menú del footer
        // Usar un patrón más simple y robusto
        $pattern = '/@if\(\$website->menus\(\)->where\("location", "footer"\)->exists\(\)\)(.*?)@endif/s';
        
        // Reemplazar TODAS las ocurrencias
        $content = preg_replace($pattern, $menuHtml, $content);
        
        // También intentar con el patrón @else
        $patternWithElse = '/@if\(\$website->menus\(\)->where\("location", "footer"\)->exists\(\)\)(.*?)@else(.*?)@endif/s';
        $content = preg_replace($patternWithElse, $menuHtml, $content);
        
        return $content;
    }
    
    /**
     * Reemplazar el contenido de la página
     */
    private function replacePageContent($content, $pageContent)
    {
        // Buscar y reemplazar el bloque del contenido de la página con diferentes variaciones
        $patterns = [
            '/@if\(\$homePage && \$homePage->html_content\)(.*?)@else(.*?)@endif/s',
            '/@if\(\$homePage \&\& \$homePage->html_content\)(.*?)@else(.*?)@endif/s',
            '/@if\(\$homePage && \$homePage->html_content\)(.*?)@endif/s',
            '/@if\(\$homePage \&\& \$homePage->html_content\)(.*?)@endif/s',
        ];
        
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $content, $matches)) {
                $content = str_replace($matches[0], $pageContent, $content);
                break;
            }
        }
        
        return $content;
    }
    
    /**
     * Reemplazar variables Blade que puedan haber quedado sin procesar
     */
    private function replaceRemainingBladeVariables($content, $website, $homePage)
    {
        // Reemplazar variables del website con patrones más amplios
        $content = preg_replace('/\{\{\s*\$website->name[^}]*\}\}/', $website->name ?? "Mi Sitio Web", $content);
        $content = preg_replace('/\{\{\s*\$website->description[^}]*\}\}/', $website->description ?? "Descripción de mi sitio web", $content);
        
        // Reemplazar variables de la página de inicio
        $content = preg_replace('/\{\{\s*\$homePage->title[^}]*\}\}/', $homePage->title ?? $website->name ?? "Mi Sitio Web", $content);
        $content = preg_replace('/\{\{\s*\$homePage->meta_description[^}]*\}\}/', $homePage->meta_description ?? $website->description ?? "Descripción de mi sitio web", $content);
        
        // Reemplazar fecha
        $content = preg_replace('/\{\{\s*date\([^}]*\)[^}]*\}\}/', date("Y"), $content);
        
        // Reemplazar credenciales API que puedan haber quedado
        $content = preg_replace('/\{\{\s*\$website->api_key[^}]*\}\}/', $website->api_key ?? '', $content);
        $content = preg_replace('/\{\{\s*\$website->api_base_url[^}]*\}\}/', $website->api_base_url ?? '', $content);
        $content = preg_replace('/\{\{\s*\$website->epayco_public_key[^}]*\}\}/', $website->epayco_public_key ?? '', $content);
        $content = preg_replace('/\{\{\s*\$website->epayco_private_key[^}]*\}\}/', $website->epayco_private_key ?? '', $content);
        $content = preg_replace('/\{\{\s*\$website->epayco_customer_id[^}]*\}\}/', $website->epayco_customer_id ?? '', $content);
        
        // Reemplazar cualquier variable Blade restante de forma más agresiva
        $content = preg_replace('/\{\{\s*\$website->name\s*\?\?\s*"[^"]*"\s*\}\}/', $website->name ?? "Mi Sitio Web", $content);
        $content = preg_replace('/\{\{\s*\$homePage->title\s*\?\?\s*\$website->name\s*\?\?\s*"[^"]*"\s*\}\}/', $homePage->title ?? $website->name ?? "Mi Sitio Web", $content);
        $content = preg_replace('/\{\{\s*\$homePage->meta_description\s*\?\?\s*\$website->description\s*\?\?\s*"[^"]*"\s*\}\}/', $homePage->meta_description ?? $website->description ?? "Descripción de mi sitio web", $content);
        
        // Eliminar TODOS los bloques de menú que queden sin procesar
        $content = preg_replace('/@if\(\$website->menus\(\)->where\("location", "header"\)->exists\(\)\)(.*?)@endif/s', '', $content);
        $content = preg_replace('/@if\(\$website->menus\(\)->where\("location", "footer"\)->exists\(\)\)(.*?)@endif/s', '', $content);
        
        // Eliminar cualquier directiva Blade restante
        $content = preg_replace('/@if\([^)]*\)/', '', $content);
        $content = preg_replace('/@foreach\([^)]*\)/', '', $content);
        $content = preg_replace('/@else/', '', $content);
        $content = preg_replace('/@endif/', '', $content);
        $content = preg_replace('/@endforeach/', '', $content);
        
        // Eliminar cualquier variable Blade que quede
        $content = preg_replace('/\{\{[^}]*\}\}/', '', $content);
        
        return $content;
    }
    
    /**
     * Generar HTML simple del menú del header para plantillas simples
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
     * Generar HTML simple del menú del footer para plantillas simples
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
     * Obtener contenido de la página según el contexto
     */
    private function getPageContent($page, $isPreview)
    {
        // Si estamos en modo preview y tenemos una página específica, mostrar su contenido
        if ($isPreview && $page && $page->html_content) {
            return $page->html_content;
        }
        
        // Si no, usar contenido por defecto
        return $this->getDefaultPageContent();
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

}
