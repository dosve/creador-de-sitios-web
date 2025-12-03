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
     * Mostrar vista previa del sitio web seleccionado de la sesión
     */
    public function index(Request $request)
    {
        // Obtener sitio web de la sesión
        $website = Website::find(session('selected_website_id'));

        if (!$website) {
            return redirect()->route('creator.select-website')
                ->with('error', 'Por favor selecciona un sitio web primero');
        }

        $this->authorize('view', $website);

        // Obtener páginas del sitio web
        $pages = $website->pages()->where('is_published', true)->orderBy('sort_order')->get();

        // Obtener la página de inicio
        $homePage = $pages->where('is_home', true)->first() ?? $pages->first();

        // Obtener menús del sitio web
        $menus = $website->menus()->with(['items' => function ($query) {
            $query->whereNull('parent_id')->where('is_active', true)->orderBy('order');
        }, 'items.page', 'items.children' => function ($query) {
            $query->where('is_active', true)->orderBy('order');
        }, 'items.children.page'])->get();

        // Si el sitio web tiene plantilla aplicada, intentar renderizarla
        if ($website->template_id) {
            // Primero intentar cargar desde archivo Blade
            $templateService = app(\App\Services\TemplateService::class);
            $templateArray = $templateService->find($website->template_id);

            if ($templateArray) {
                // Renderizar la vista Blade directamente
                $templateFile = $templateArray['templates']['home'] ?? 'template';
                $viewPath = 'templates.' . $templateArray['slug'] . '.' . str_replace('.blade.php', '', $templateFile);

                if (view()->exists($viewPath)) {
                    $templateConfig = \App\Models\TemplateConfiguration::firstOrCreate(
                        ['website_id' => $website->id, 'template_slug' => $templateArray['slug']],
                        ['customization' => $templateArray['customization'] ?? []]
                    );

                    $customization = $templateConfig->customization ?? $templateArray['customization'] ?? [];

                    return view($viewPath, [
                        'website' => $website,
                        'page' => $homePage,
                        'pages' => $pages,
                        'menus' => $menus,
                        'customization' => $customization
                    ]);
                }
            }

            // Si no está en archivo, intentar desde base de datos
            $template = $website->template;
            if ($template) {
                // Procesar la plantilla en tiempo real con modo preview
                $processedContent = $this->processTemplateSimple($template->html_content, $website, $homePage, $menus, $pages);
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
    public function page(Request $request, Page $page)
    {
        // LOG: Debug del flujo de carga de página
        \Log::info("=== PREVIEW CONTROLLER DEBUG ===");
        \Log::info("Página: " . $page->title . " (ID: " . $page->id . ")");
        \Log::info("Slug: " . $page->slug);

        // Log directo a archivo para debug
        file_put_contents(storage_path('logs/debug.log'), "=== PREVIEW CONTROLLER DEBUG ===\n", FILE_APPEND);
        file_put_contents(storage_path('logs/debug.log'), "Página: " . $page->title . " (ID: " . $page->id . ")\n", FILE_APPEND);
        file_put_contents(storage_path('logs/debug.log'), "Slug: " . $page->slug . "\n", FILE_APPEND);

        // Obtener sitio web de la sesión
        $website = Website::find(session('selected_website_id'));

        if (!$website) {
            \Log::info("ERROR: No se encontró sitio web en sesión");
            file_put_contents(storage_path('logs/debug.log'), "ERROR: No se encontró sitio web en sesión\n", FILE_APPEND);
            return redirect()->route('creator.select-website')
                ->with('error', 'Por favor selecciona un sitio web primero');
        }

        \Log::info("Sitio web: " . $website->name . " (ID: " . $website->id . ")");
        \Log::info("Template ID: " . ($website->template_id ?? 'NULL'));

        file_put_contents(storage_path('logs/debug.log'), "Sitio web: " . $website->name . " (ID: " . $website->id . ")\n", FILE_APPEND);
        file_put_contents(storage_path('logs/debug.log'), "Template ID: " . ($website->template_id ?? 'NULL') . "\n", FILE_APPEND);

        $this->authorize('view', $website);

        // Verificar que la página pertenece al sitio web seleccionado
        if ($page->website_id !== $website->id) {
            \Log::info("ERROR: La página no pertenece al sitio web");
            abort(403, 'Esta página no pertenece al sitio web seleccionado');
        }

        // Obtener todas las páginas del sitio para la navegación
        $pages = $website->pages()->where('is_published', true)->orderBy('sort_order')->get();

        // Si el sitio web no tiene plantilla (página en blanco), usar vista sin navbar/footer
        if (!$website->template_id) {
            \Log::info("FLUJO: Sin plantilla - usando blank-page");
            file_put_contents(storage_path('logs/debug.log'), "FLUJO: Sin plantilla - usando blank-page\n", FILE_APPEND);
            return view('creator.preview.blank-page', compact('website', 'page', 'pages'));
        }

        // Si tiene plantilla, procesar con el sistema de hooks
        \Log::info("FLUJO: Con plantilla - procesando template");
        file_put_contents(storage_path('logs/debug.log'), "FLUJO: Con plantilla - procesando template\n", FILE_APPEND);
        $template = $website->template;
        if ($template) {
            \Log::info("Template encontrado: " . $template->name . " (ID: " . $template->id . ")");
            file_put_contents(storage_path('logs/debug.log'), "Template encontrado: " . $template->name . " (ID: " . $template->id . ")\n", FILE_APPEND);
            // Obtener menús del sitio web
            $menus = $website->menus()->with(['items' => function ($query) {
                $query->whereNull('parent_id')->where('is_active', true)->orderBy('order');
            }, 'items.page', 'items.children' => function ($query) {
                $query->where('is_active', true)->orderBy('order');
            }, 'items.children.page'])->get();

            // Procesar la plantilla en tiempo real con modo preview
            \Log::info("Procesando plantilla con processTemplateSimple");
            $processedContent = $this->processTemplateSimple($template->html_content, $website, $page, $menus);

            \Log::info("Plantilla procesada, retornando respuesta");
            return response($processedContent);
        }

        // Fallback: generar HTML simple sin layout
        $pageContent = '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>' . htmlspecialchars($page->title) . ' - ' . htmlspecialchars($website->name) . '</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="max-w-4xl px-4 py-16 mx-auto">
        <h1 class="mb-4 text-4xl font-bold text-gray-900">' . htmlspecialchars($page->title) . '</h1>
        ' . ($page->html_content ?: '<p class="text-gray-600">Esta página aún no tiene contenido.</p>') . '
    </div>
</body>
</html>';

        return response($pageContent)->header('Content-Type', 'text/html');
    }

    /**
     * Mostrar vista previa de un post del blog
     */
    public function blogPost(Request $request, BlogPost $blogPost)
    {
        // Obtener sitio web de la sesión
        $website = Website::find(session('selected_website_id'));

        if (!$website) {
            return redirect()->route('creator.select-website')
                ->with('error', 'Por favor selecciona un sitio web primero');
        }

        $this->authorize('view', $website);

        // Verificar que el post pertenece al sitio web seleccionado
        if ($blogPost->website_id !== $website->id) {
            abort(403, 'Este post no pertenece al sitio web seleccionado');
        }

        // Obtener la página de inicio para usar como base
        $homePage = $website->pages()->where('is_home', true)->first();
        if (!$homePage) {
            $homePage = $website->pages()->first();
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

        // Obtener menús
        $menus = $website->menus()->with(['items' => function ($query) {
            $query->whereNull('parent_id')->where('is_active', true)->orderBy('order');
        }, 'items.page', 'items.children' => function ($query) {
            $query->where('is_active', true)->orderBy('order');
        }, 'items.children.page'])->get();

        // Generar contenido del post usando la plantilla del sitio
        $postContent = $this->generateBlogPostContent($website, $blogPost, $relatedPosts);

        // Procesar la plantilla del sitio con el contenido del post
        $templateContent = $this->processBlogPostTemplate($website, $homePage, $menus, $postContent, $blogPost, true);

        return response($templateContent)->header('Content-Type', 'text/html');
    }

    /**
     * Mostrar vista previa del blog
     */
    public function blog(Request $request)
    {
        // Obtener sitio web de la sesión
        $website = Website::find(session('selected_website_id'));

        if (!$website) {
            return redirect()->route('creator.select-website')
                ->with('error', 'Por favor selecciona un sitio web primero');
        }

        $this->authorize('view', $website);

        // Obtener la página de inicio para usar como base
        $homePage = $website->pages()->where('is_home', true)->first();
        if (!$homePage) {
            $homePage = $website->pages()->first();
        }

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

        // Obtener menús
        $menus = $website->menus()->with(['items' => function ($query) {
            $query->whereNull('parent_id')->where('is_active', true)->orderBy('order');
        }, 'items.page', 'items.children' => function ($query) {
            $query->where('is_active', true)->orderBy('order');
        }, 'items.children.page'])->get();

        // Generar contenido del blog usando la plantilla del sitio
        $blogContent = $this->generateBlogPageContent($website, $blogPosts, $categories);

        // Procesar la plantilla del sitio con el contenido del blog
        $templateContent = $this->processBlogTemplate($website, $homePage, $menus, $blogContent, true);

        return response($templateContent)->header('Content-Type', 'text/html');
    }

    /**
     * Mostrar vista previa de contacto
     */
    public function contact(Request $request)
    {
        // Obtener sitio web de la sesión
        $website = Website::find(session('selected_website_id'));

        if (!$website) {
            return redirect()->route('creator.select-website')
                ->with('error', 'Por favor selecciona un sitio web primero');
        }

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
    private function processTemplateSimple($templateContent, $website, $currentPage, $menus, $pages = null)
    {
        // Detectar si estamos en modo preview - incluir también las rutas simplificadas
        $isPreview = request()->is('creator/websites/*/preview*') ||
            request()->is('creator/*') ||
            (auth()->check() && session('selected_website_id') == $website->id);

        // Obtener páginas si no se proporcionaron
        if (!$pages) {
            $pages = $website->pages()->where('is_published', true)->orderBy('sort_order')->get();
        }

        // Definir hooks disponibles
        $hooks = $this->getTemplateHooks($website, $currentPage, $menus, $isPreview, $pages);

        // Procesar hooks en el contenido
        $processedContent = $this->processHooks($templateContent, $hooks);

        // Agregar barra de administrador al inicio del body
        $adminBar = view('components.admin-bar', compact('website'))->render();
        $processedContent = $this->injectAdminBar($processedContent, $adminBar);

        // Si estamos en modo preview, agregar los scripts necesarios
        if ($isPreview) {
            $scriptsToAdd = [];

            // Scripts de productos y carrito - SIEMPRE incluir para todas las plantillas
            // Configurar variables JavaScript globales
            $apiConfigScript = '
                <script>
                    console.log("🔧 Configurando variables API en processTemplateSimple");
                    window.websiteApiKey = "' . addslashes($website->api_key ?? '') . '";
                    window.websiteApiUrl = "' . addslashes($website->api_base_url ?? '') . '";
                    console.log("🔧 Variables configuradas:", {
                        apiKey: window.websiteApiKey ? "Configurada" : "No configurada",
                        apiUrl: window.websiteApiUrl || "No configurada"
                    });
                </script>
            ';

            // Script de productos
            $productsScript = view('components.products-script', [
                'apiKey' => $website->api_key ?? '',
                'apiBaseUrl' => $website->api_base_url ?? ''
            ])->render();

            // Script del carrito
            $cartScript = view('components.cart.script', [
                'templateSlug' => $website->template_id ?? 'default',
                'colors' => [],
                'paymentHandler' => $website->default_payment_gateway ?? 'epayco',
                'websiteSlug' => $website->slug,
                'allowCashOnDelivery' => $website->allow_cash_on_delivery ?? true,
                'allowOnlinePayment' => $website->allow_online_payment ?? true,
                'cashOnDeliveryInstructions' => $website->cash_on_delivery_instructions ?? ''
            ])->render();

            // Cargar el handler de pago según la pasarela configurada
            $paymentGateway = $website->default_payment_gateway ?? 'epayco';

            if ($paymentGateway === 'wompi' && $website->wompi_public_key) {
                // Handler de Wompi
                $paymentHandler = view('components.payments.wompi.handler', [
                    'publicKey' => $website->wompi_public_key ?? '',
                    'privateKey' => $website->wompi_private_key ?? '',
                    'integrityKey' => $website->wompi_integrity_key ?? ''
                ])->render();

                $epaycoSDK = ''; // No cargar ePayco si se usa Wompi
            } else {
                // Handler de ePayco (por defecto)
                $paymentHandler = view('components.payments.epayco.handler', [
                    'publicKey' => $website->epayco_public_key ?? '',
                    'privateKey' => $website->epayco_private_key ?? '',
                    'customerId' => $website->epayco_customer_id ?? ''
                ])->render();

                // SDK de Epayco con callback para verificar carga
                $epaycoSDK = '
                    <script type="text/javascript">
                        console.log("🔄 Cargando SDK de Epayco...");
                        var script = document.createElement("script");
                        script.type = "text/javascript";
                        script.src = "https://checkout.epayco.co/checkout.js";
                        script.onload = function() {
                            console.log("✅ SDK de Epayco cargado correctamente");
                            console.log("🔍 ePayco disponible:", typeof ePayco !== "undefined");
                        };
                        script.onerror = function() {
                            console.error("❌ Error cargando SDK de Epayco");
                        };
                        document.head.appendChild(script);
                    </script>
                ';
            }

            $scriptsToAdd[] = $apiConfigScript;
            $scriptsToAdd[] = $epaycoSDK;
            $scriptsToAdd[] = $productsScript;
            $scriptsToAdd[] = $cartScript;
            $scriptsToAdd[] = $paymentHandler;

            // Script de blog si tiene bloque de blog
            if ($this->hasBlogBlock($processedContent)) {
                $blogScript = view('components.blog-script', [
                    'websiteId' => $website->id
                ])->render();
                $scriptsToAdd[] = $blogScript;
            }

            // Combinar todos los scripts
            if (!empty($scriptsToAdd)) {
                $combinedScripts = implode('', $scriptsToAdd);

                // Insertar los scripts antes del cierre de </body>
                if (strpos($processedContent, '</body>') !== false) {
                    $processedContent = str_replace('</body>', $combinedScripts . '</body>', $processedContent);
                } else {
                    // Si no hay tag body, agregar al final
                    $processedContent .= $combinedScripts;
                }
            }

            // Agregar la barra de administración
            $processedContent = $this->addAdminBar($processedContent, $website);
        }

        return $processedContent;
    }

    /**
     * Verificar si el contenido tiene un bloque de productos
     */
    private function hasProductsBlock($content)
    {
        // Verificar si existe alguno de los identificadores del bloque de productos
        return strpos($content, 'id="products-container"') !== false
            || strpos($content, 'data-dynamic-products="true"') !== false
            || strpos($content, 'data-products-source="api"') !== false;
    }

    /**
     * Verificar si el contenido tiene un bloque de blog
     */
    private function hasBlogBlock($content)
    {
        // Verificar si existe alguno de los identificadores del bloque de blog
        return strpos($content, 'id="blog-posts-container"') !== false
            || strpos($content, 'data-dynamic-blog="true"') !== false;
    }

    /**
     * Generar contenido HTML para la página del blog
     */
    private function generateBlogPageContent($website, $blogPosts, $categories)
    {
        $blogHtml = '<section class="py-12 blog-page">';
        $blogHtml .= '<div class="container px-4 mx-auto">';

        // Header del blog
        $blogHtml .= '<div class="mb-12 text-center">';
        $blogHtml .= '<h1 class="mb-4 text-4xl font-bold text-gray-900">Blog</h1>';
        $blogHtml .= '<p class="text-xl text-gray-600">Descubre nuestras últimas publicaciones y tendencias</p>';
        $blogHtml .= '</div>';

        if ($blogPosts->count() > 0) {
            // Grid de posts
            $blogHtml .= '<div class="grid grid-cols-1 gap-8 mb-12 md:grid-cols-2 lg:grid-cols-3">';

            foreach ($blogPosts as $post) {
                $blogHtml .= '<article class="overflow-hidden transition-shadow bg-white rounded-lg shadow-lg hover:shadow-xl">';
                $blogHtml .= '<div class="flex items-center justify-center w-full h-48 bg-gradient-to-br from-blue-100 to-purple-100">';

                if ($post->category) {
                    $blogHtml .= '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">';
                    $blogHtml .= htmlspecialchars($post->category->name);
                    $blogHtml .= '</span>';
                }

                $blogHtml .= '</div>';
                $blogHtml .= '<div class="p-6">';
                $blogHtml .= '<div class="flex items-center mb-2 text-sm text-gray-500">';
                $blogHtml .= '<span>' . $post->created_at->format('d M, Y') . '</span>';
                $blogHtml .= '<span class="mx-2">•</span>';
                $blogHtml .= '<span>' . ceil(str_word_count(strip_tags($post->content)) / 200) . ' min lectura</span>';
                $blogHtml .= '</div>';

                $blogHtml .= '<h3 class="mb-2 text-xl font-bold text-gray-900 hover:text-blue-600">';
                $blogHtml .= '<a href="/creator/websites/' . $website->id . '/preview/blog/' . $post->id . '">';
                $blogHtml .= htmlspecialchars($post->title);
                $blogHtml .= '</a>';
                $blogHtml .= '</h3>';

                $excerpt = $post->excerpt ?: Str::limit(strip_tags($post->content), 150);
                $blogHtml .= '<p class="mb-4 text-gray-600">' . htmlspecialchars($excerpt) . '</p>';

                if ($post->tags->count() > 0) {
                    $blogHtml .= '<div class="flex flex-wrap gap-1 mb-4">';
                    foreach ($post->tags->take(3) as $tag) {
                        $blogHtml .= '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">';
                        $blogHtml .= htmlspecialchars($tag->name);
                        $blogHtml .= '</span>';
                    }
                    $blogHtml .= '</div>';
                }

                $blogHtml .= '<div class="flex items-center justify-between">';
                $blogHtml .= '<div class="flex items-center">';
                $blogHtml .= '<div class="w-6 h-6 mr-2 bg-gray-300 rounded-full"></div>';
                $blogHtml .= '<span class="text-sm text-gray-600">Autor</span>';
                $blogHtml .= '</div>';
                $blogHtml .= '<a href="/creator/websites/' . $website->id . '/preview/blog/' . $post->id . '" class="text-sm text-blue-600 hover:text-blue-800">Leer más →</a>';
                $blogHtml .= '</div>';
                $blogHtml .= '</div>';
                $blogHtml .= '</article>';
            }

            $blogHtml .= '</div>';

            // Paginación
            if ($blogPosts->hasPages()) {
                $blogHtml .= '<div class="flex justify-center">';
                $blogHtml .= $blogPosts->links()->render();
                $blogHtml .= '</div>';
            }
        } else {
            // Estado vacío
            $blogHtml .= '<div class="py-12 text-center">';
            $blogHtml .= '<div class="flex items-center justify-center w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full">';
            $blogHtml .= '<svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
            $blogHtml .= '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>';
            $blogHtml .= '</svg>';
            $blogHtml .= '</div>';
            $blogHtml .= '<h3 class="mb-2 text-xl font-medium text-gray-900">No hay artículos publicados</h3>';
            $blogHtml .= '<p class="text-gray-500">Pronto tendremos contenido interesante para compartir contigo.</p>';
            $blogHtml .= '</div>';
        }

        $blogHtml .= '</div>';
        $blogHtml .= '</section>';

        return $blogHtml;
    }

    /**
     * Procesar la plantilla del sitio para mostrar el blog
     */
    private function processBlogTemplate($website, $homePage, $menus, $blogContent, $isPreview = false)
    {
        // Obtener la plantilla del sitio
        $template = $website->template;
        if (!$template) {
            return '<h1>No hay plantilla configurada para este sitio</h1>';
        }

        // Obtener el contenido de la plantilla
        $templateContent = $template->html_content;

        // Obtener hooks para la plantilla
        $hooks = $this->getTemplateHooks($website, $homePage, $menus, $isPreview);

        // Agregar hook específico para el contenido del blog
        $hooks['CONTENIDO_PAGINA'] = $blogContent;
        $hooks['PAGINA_TITULO'] = 'Blog - ' . $website->name;
        $hooks['PAGINA_DESCRIPCION'] = 'Descubre nuestras últimas publicaciones y tendencias';

        // Procesar hooks en el contenido
        $processedContent = $this->processHooks($templateContent, $hooks);

        // Si estamos en modo preview, agregar los scripts necesarios
        if ($isPreview) {
            $scriptsToAdd = [];

            // Script de blog si tiene contenido de blog
            if ($this->hasBlogBlock($processedContent)) {
                $blogScript = view('components.blog-script', [
                    'websiteId' => $website->id
                ])->render();
                $scriptsToAdd[] = $blogScript;
            }

            // Combinar todos los scripts
            if (!empty($scriptsToAdd)) {
                $combinedScripts = implode('', $scriptsToAdd);

                // Insertar los scripts antes del cierre de </body>
                if (strpos($processedContent, '</body>') !== false) {
                    $processedContent = str_replace('</body>', $combinedScripts . '</body>', $processedContent);
                } else {
                    // Si no hay tag body, agregar al final
                    $processedContent .= $combinedScripts;
                }
            }
        }

        return $processedContent;
    }

    /**
     * Generar contenido HTML para un post individual del blog
     */
    private function generateBlogPostContent($website, $blogPost, $relatedPosts)
    {
        $postHtml = '<section class="py-12 blog-post-page">';
        $postHtml .= '<div class="container px-4 mx-auto">';

        // Header del post
        $postHtml .= '<div class="mb-12 text-center">';
        if ($blogPost->category) {
            $postHtml .= '<span class="inline-flex items-center px-3 py-1 mb-4 text-sm font-medium text-blue-800 bg-blue-100 rounded-full">';
            $postHtml .= htmlspecialchars($blogPost->category->name);
            $postHtml .= '</span>';
        }

        $postHtml .= '<h1 class="mb-4 text-4xl font-bold text-gray-900">' . htmlspecialchars($blogPost->title) . '</h1>';

        $postHtml .= '<div class="flex items-center justify-center mb-6 text-sm text-gray-500">';
        $postHtml .= '<span>' . $blogPost->created_at->format('d M, Y') . '</span>';
        $postHtml .= '<span class="mx-2">•</span>';
        $postHtml .= '<span>' . ceil(str_word_count(strip_tags($blogPost->content)) / 200) . ' min lectura</span>';
        $postHtml .= '</div>';

        if ($blogPost->tags->count() > 0) {
            $postHtml .= '<div class="flex flex-wrap justify-center gap-2">';
            foreach ($blogPost->tags as $tag) {
                $postHtml .= '<span class="inline-flex items-center px-2 py-1 text-xs font-medium text-gray-800 bg-gray-100 rounded">';
                $postHtml .= htmlspecialchars($tag->name);
                $postHtml .= '</span>';
            }
            $postHtml .= '</div>';
        }
        $postHtml .= '</div>';

        // Contenido del post
        $postHtml .= '<div class="max-w-4xl mx-auto">';
        $postHtml .= '<div class="overflow-hidden bg-white rounded-lg shadow-lg">';
        $postHtml .= '<div class="p-8">';

        // Excerpt si existe
        if ($blogPost->excerpt) {
            $postHtml .= '<div class="mb-8 text-xl font-medium text-gray-600">';
            $postHtml .= htmlspecialchars($blogPost->excerpt);
            $postHtml .= '</div>';
        }

        // Contenido del post
        $postHtml .= '<div class="prose prose-lg max-w-none">';
        $postHtml .= $blogPost->content;
        $postHtml .= '</div>';

        // Tags al final
        if ($blogPost->tags->count() > 0) {
            $postHtml .= '<div class="pt-8 mt-8 border-t border-gray-200">';
            $postHtml .= '<h4 class="mb-3 text-sm font-medium text-gray-900">Etiquetas:</h4>';
            $postHtml .= '<div class="flex flex-wrap gap-2">';
            foreach ($blogPost->tags as $tag) {
                $postHtml .= '<span class="inline-flex items-center px-3 py-1 text-sm font-medium text-blue-800 bg-blue-100 rounded-full">';
                $postHtml .= htmlspecialchars($tag->name);
                $postHtml .= '</span>';
            }
            $postHtml .= '</div>';
            $postHtml .= '</div>';
        }

        $postHtml .= '</div>';
        $postHtml .= '</div>';
        $postHtml .= '</div>';

        // Posts relacionados
        if ($relatedPosts->count() > 0) {
            $postHtml .= '<div class="mt-12">';
            $postHtml .= '<h3 class="mb-6 text-2xl font-bold text-gray-900">Artículos relacionados</h3>';
            $postHtml .= '<div class="grid grid-cols-1 gap-6 md:grid-cols-3">';

            foreach ($relatedPosts as $relatedPost) {
                $postHtml .= '<article class="overflow-hidden transition-shadow bg-white rounded-lg shadow-lg hover:shadow-xl">';
                $postHtml .= '<div class="flex items-center justify-center w-full h-32 bg-gradient-to-br from-blue-100 to-purple-100">';
                if ($relatedPost->category) {
                    $postHtml .= '<span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">';
                    $postHtml .= htmlspecialchars($relatedPost->category->name);
                    $postHtml .= '</span>';
                }
                $postHtml .= '</div>';
                $postHtml .= '<div class="p-4">';
                $postHtml .= '<div class="mb-2 text-sm text-gray-500">';
                $postHtml .= $relatedPost->created_at->format('d M, Y');
                $postHtml .= '</div>';
                $postHtml .= '<h4 class="mb-2 text-lg font-bold text-gray-900 hover:text-blue-600">';
                $postHtml .= '<a href="/creator/websites/' . $website->id . '/preview/blog/' . $relatedPost->id . '">';
                $postHtml .= htmlspecialchars($relatedPost->title);
                $postHtml .= '</a>';
                $postHtml .= '</h4>';
                $postHtml .= '<p class="text-sm text-gray-600">';
                $postHtml .= htmlspecialchars(Str::limit(strip_tags($relatedPost->content), 100));
                $postHtml .= '</p>';
                $postHtml .= '</div>';
                $postHtml .= '</article>';
            }

            $postHtml .= '</div>';
            $postHtml .= '</div>';
        }

        $postHtml .= '</div>';
        $postHtml .= '</section>';

        return $postHtml;
    }

    /**
     * Procesar la plantilla del sitio para mostrar un post del blog
     */
    private function processBlogPostTemplate($website, $homePage, $menus, $postContent, $blogPost, $isPreview = false)
    {
        // Obtener la plantilla del sitio
        $template = $website->template;
        if (!$template) {
            return '<h1>No hay plantilla configurada para este sitio</h1>';
        }

        // Obtener el contenido de la plantilla
        $templateContent = $template->html_content;

        // Obtener hooks para la plantilla
        $hooks = $this->getTemplateHooks($website, $homePage, $menus, $isPreview);

        // Agregar hook específico para el contenido del post
        $hooks['CONTENIDO_PAGINA'] = $postContent;
        $hooks['PAGINA_TITULO'] = $blogPost->title . ' - ' . $website->name;
        $hooks['PAGINA_DESCRIPCION'] = $blogPost->excerpt ?: Str::limit(strip_tags($blogPost->content), 160);

        // Procesar hooks en el contenido
        $processedContent = $this->processHooks($templateContent, $hooks);

        // Agregar estilos CSS para el contenido del blog
        $blogStyles = '
        <style>
        .prose {
            color: #374151;
        }
        .prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
            color: #111827;
            font-weight: 600;
        }
        .prose h1 {
            font-size: 2.25rem;
            margin-bottom: 1rem;
        }
        .prose h2 {
            font-size: 1.875rem;
            margin-top: 2rem;
            margin-bottom: 1rem;
        }
        .prose h3 {
            font-size: 1.5rem;
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
        }
        .prose p {
            margin-bottom: 1rem;
            line-height: 1.7;
        }
        .prose ul, .prose ol {
            margin-bottom: 1rem;
            padding-left: 1.5rem;
        }
        .prose li {
            margin-bottom: 0.5rem;
        }
        .prose blockquote {
            border-left: 4px solid #3B82F6;
            padding-left: 1rem;
            margin: 1.5rem 0;
            font-style: italic;
            color: #6B7280;
        }
        .prose a {
            color: #3B82F6;
            text-decoration: underline;
        }
        .prose a:hover {
            color: #1D4ED8;
        }
        .prose img {
            max-width: 100%;
            height: auto;
            border-radius: 0.5rem;
            margin: 1rem 0;
        }
        .prose table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
        }
        .prose th, .prose td {
            border: 1px solid #E5E7EB;
            padding: 0.75rem;
            text-align: left;
        }
        .prose th {
            background-color: #F9FAFB;
            font-weight: 600;
        }
        </style>';

        // Insertar estilos en el head
        if (strpos($processedContent, '</head>') !== false) {
            $processedContent = str_replace('</head>', $blogStyles . '</head>', $processedContent);
        } else {
            $processedContent = $blogStyles . $processedContent;
        }

        return $processedContent;
    }

    /**
     * Agregar la barra de administración a las páginas de preview
     */
    private function addAdminBar($content, $website)
    {
        // Verificar si ya existe la barra en el contenido
        if (strpos($content, 'class="admin-bar"') !== false) {
            return $content; // Ya existe, no agregar otra
        }

        // Generar el HTML de la barra de administración
        $adminBarHtml = view('components.admin-bar', compact('website'))->render();

        // Insertar la barra de administración al inicio del body
        if (strpos($content, '<body') !== false) {
            // Buscar el tag <body> y agregar la barra después - SOLO UNA VEZ
            $content = preg_replace('/(<body[^>]*>)/i', '$1' . $adminBarHtml, $content, 1);
        } else {
            // Si no hay tag body, agregar al inicio del contenido
            $content = $adminBarHtml . $content;
        }

        return $content;
    }


    /**
     * Definir todos los hooks disponibles para las plantillas
     */
    private function getTemplateHooks($website, $currentPage, $menus, $isPreview = false, $pages = null)
    {
        return [
            // Hooks básicos del sitio web
            'SITIO_WEB_ID' => $website->id,
            'SITIO_WEB_NOMBRE' => $website->name ?? "Mi Sitio Web",
            'SITIO_WEB_DESCRIPCION' => $website->description ?? "Descripción de mi sitio web",
            'ANIO_ACTUAL' => date("Y"),

            // Hooks de la página actual
            'PAGINA_TITULO' => $currentPage->title ?? $website->name ?? "Mi Sitio Web",
            'PAGINA_DESCRIPCION' => $currentPage->meta_description ?? $website->description ?? "Descripción de mi sitio web",

            // Hooks de menús
            'MENU_HEADER_ITEMS' => $this->generateHeaderMenuSimple($website, $menus, $isPreview, $currentPage),
            'MENU_FOOTER_ITEMS' => $this->generateFooterMenuSimple($website, $menus, $isPreview, $currentPage),

            // Hook de navegación entre páginas (solo en modo preview)
            'NAVEGACION_PAGINAS' => $isPreview ? $this->generatePageNavigation($website, $currentPage, $pages) : '',

            // Hooks de contenido
            'CONTENIDO_PAGINA' => $this->getPageContent($currentPage, $isPreview),

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
     * Generar navegación entre páginas para vista previa
     */
    private function generatePageNavigation($website, $currentPage, $pages)
    {
        if (!$pages || $pages->count() <= 1) {
            return '';
        }

        $navigationHtml = '<div class="sticky top-0 z-50 bg-white border-b border-gray-200 shadow-sm preview-navigation">';
        $navigationHtml .= '<div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">';
        $navigationHtml .= '<div class="flex items-center justify-between h-16">';

        // Logo/Nombre del sitio
        $navigationHtml .= '<div class="flex items-center">';
        $navigationHtml .= '<div class="flex-shrink-0">';
        $navigationHtml .= '<h1 class="text-xl font-bold text-gray-900">' . htmlspecialchars($website->name) . '</h1>';
        $navigationHtml .= '</div>';
        $navigationHtml .= '</div>';

        // Navegación de páginas
        $navigationHtml .= '<div class="flex items-center space-x-1">';
        $navigationHtml .= '<div class="items-center hidden space-x-1 md:flex">';

        foreach ($pages as $page) {
            $isActive = $currentPage && $currentPage->id === $page->id;
            $activeClass = $isActive ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100';
            $url = route('creator.preview.page', $page->id);

            $navigationHtml .= '<a href="' . $url . '" class="px-3 py-2 text-sm font-medium transition-colors duration-200 rounded-md ' . $activeClass . '">';
            $navigationHtml .= htmlspecialchars($page->title);
            $navigationHtml .= '</a>';
        }

        $navigationHtml .= '</div>';

        // Menú móvil
        $navigationHtml .= '<div class="md:hidden">';
        $navigationHtml .= '<div class="relative">';
        $navigationHtml .= '<button id="mobile-menu-button" class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 focus:outline-none">';
        $navigationHtml .= '<span id="current-page-name">' . htmlspecialchars($currentPage ? $currentPage->title : 'Páginas') . '</span>';
        $navigationHtml .= '<svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
        $navigationHtml .= '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>';
        $navigationHtml .= '</svg>';
        $navigationHtml .= '</button>';

        // Menú desplegable móvil
        $navigationHtml .= '<div id="mobile-menu" class="absolute right-0 z-50 hidden w-48 mt-2 bg-white border border-gray-200 rounded-md shadow-lg">';
        $navigationHtml .= '<div class="py-1">';

        foreach ($pages as $page) {
            $isActive = $currentPage && $currentPage->id === $page->id;
            $activeClass = $isActive ? 'bg-blue-50 text-blue-700' : '';
            $url = route('creator.preview.page', $page->id);

            $navigationHtml .= '<a href="' . $url . '" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 ' . $activeClass . '">';
            $navigationHtml .= htmlspecialchars($page->title);
            $navigationHtml .= '</a>';
        }

        $navigationHtml .= '</div>';
        $navigationHtml .= '</div>';
        $navigationHtml .= '</div>';
        $navigationHtml .= '</div>';
        $navigationHtml .= '</div>';

        // Botón de regreso al editor
        $navigationHtml .= '<div class="flex items-center space-x-2">';
        $navigationHtml .= '<a href="' . route('creator.pages.index') . '" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 transition-colors hover:text-gray-900">';
        $navigationHtml .= '<svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
        $navigationHtml .= '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>';
        $navigationHtml .= '</svg>';
        $navigationHtml .= 'Volver al Editor';
        $navigationHtml .= '</a>';
        $navigationHtml .= '</div>';

        $navigationHtml .= '</div>';
        $navigationHtml .= '</div>';
        $navigationHtml .= '</div>';

        // JavaScript para el menú móvil
        $navigationHtml .= '<script>
        document.addEventListener("DOMContentLoaded", function() {
            const mobileMenuButton = document.getElementById("mobile-menu-button");
            const mobileMenu = document.getElementById("mobile-menu");
            
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener("click", function() {
                    mobileMenu.classList.toggle("hidden");
                });
                
                document.addEventListener("click", function(event) {
                    if (!mobileMenuButton.contains(event.target) && !mobileMenu.contains(event.target)) {
                        mobileMenu.classList.add("hidden");
                    }
                });
            }
        });
        </script>';

        return $navigationHtml;
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
     * Inyectar la barra de administrador en el HTML
     */
    private function injectAdminBar($html, $adminBar)
    {
        // Buscar la etiqueta <body> y agregar la barra de administrador después
        if (preg_match('/(<body[^>]*>)/i', $html, $matches)) {
            $bodyTag = $matches[1];
            $html = str_replace($bodyTag, $bodyTag . $adminBar, $html);
        }

        return $html;
    }

    /**
     * Generar HTML del menú del header
     */
    private function generateHeaderMenu($website, $menus, $currentPage = null)
    {
        $headerMenu = $menus->where('location', 'header')->first();

        // Obtener la URL actual
        $currentUrl = request()->path();

        if ($headerMenu && $headerMenu->items->count() > 0) {
            $menuItems = '';
            foreach ($headerMenu->items as $item) {
                $icon = $item->icon ? $item->icon . ' ' : '';

                // Detectar si este item está activo
                $isActive = false;
                if ($currentPage) {
                    if ($item->page_id && $item->page_id == $currentPage->id) {
                        $isActive = true;
                    }
                    if ($currentPage->is_home && $item->final_url === '/') {
                        $isActive = true;
                    }
                }

                $activeClass = $isActive ? ' font-bold' : '';
                $menuItems .= '<a href="' . $item->final_url . '" target="' . $item->target . '" class="text-gray-600 transition-colors duration-200 hover:text-gray-900' . $activeClass . '">' . $icon . $item->title . '</a>';
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
    private function generateFooterMenu($website, $menus, $currentPage = null)
    {
        $footerMenu = $menus->where('location', 'footer')->first();

        // Obtener la URL actual
        $currentUrl = request()->path();

        if ($footerMenu && $footerMenu->items->count() > 0) {
            $menuItems = '';
            foreach ($footerMenu->items as $item) {
                $icon = $item->icon ? $item->icon . ' ' : '';

                // Detectar si este item está activo
                $isActive = false;
                if ($currentPage) {
                    if ($item->page_id && $item->page_id == $currentPage->id) {
                        $isActive = true;
                    }
                    if ($currentPage->is_home && $item->final_url === '/') {
                        $isActive = true;
                    }
                }

                $activeClass = $isActive ? ' font-bold' : '';
                $menuItems .= '<li><a href="' . $item->final_url . '" target="' . $item->target . '" class="text-gray-400 transition-colors duration-200 hover:text-white' . $activeClass . '">' . $icon . $item->title . '</a></li>';
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
            return '<div class="container px-4 py-8 mx-auto">
                        <div class="prose max-w-none">
                            ' . $homePage->html_content . '
                        </div>
                    </div>';
        }

        return '<section class="py-16 text-white bg-gradient-to-r from-blue-600 to-purple-600">
                    <div class="container px-4 mx-auto text-center">
                        <h2 class="mb-4 text-4xl font-bold">Bienvenido a tu sitio web</h2>
                        <p class="mb-8 text-xl">Crea contenido increíble y compártelo con el mundo</p>
                        <div class="flex flex-col justify-center gap-4 sm:flex-row">
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
    private function generateHeaderMenuSimple($website, $menus, $isPreview = false, $currentPage = null)
    {
        $headerMenu = $menus->where('location', 'header')->first();

        // Obtener la URL actual
        $currentUrl = request()->path();

        if ($headerMenu && $headerMenu->items->count() > 0) {
            $menuItems = '';
            foreach ($headerMenu->items as $item) {
                $icon = $item->icon ? '<i class="' . $item->icon . ' mr-1"></i>' : '';

                // Detectar si este item está activo (corresponde a la página actual)
                $isActive = false;
                if ($currentPage) {
                    // Verificar si el item apunta a la página actual
                    if ($item->page_id && $item->page_id == $currentPage->id) {
                        $isActive = true;
                    }
                    // También verificar si es la página de inicio
                    if ($currentPage->is_home && $item->final_url === '/') {
                        $isActive = true;
                    }
                }

                // También verificar por URL si estamos en preview
                if ($isPreview && !$isActive) {
                    $previewUrl = $this->generatePreviewUrl($item, $website);
                    // Normalizar las URLs para comparar
                    $normalizedPreviewUrl = trim(parse_url($previewUrl, PHP_URL_PATH), '/');
                    $normalizedCurrentUrl = trim($currentUrl, '/');

                    if ($normalizedPreviewUrl === $normalizedCurrentUrl) {
                        $isActive = true;
                    }
                }

                // Agregar clase font-bold si está activo
                $activeClass = $isActive ? ' font-bold' : '';

                // Si estamos en modo preview, crear enlaces que mantengan el contexto de preview
                if ($isPreview) {
                    $previewUrl = $this->generatePreviewUrl($item, $website);
                    $menuItems .= '<a href="' . $previewUrl . '" target="' . $item->target . '" class="text-gray-600 transition-colors duration-200 hover:text-gray-900' . $activeClass . '">' . $icon . $item->title . '</a>';
                } else {
                    $menuItems .= '<a href="' . $item->final_url . '" target="' . $item->target . '" class="text-gray-600 transition-colors duration-200 hover:text-gray-900' . $activeClass . '">' . $icon . $item->title . '</a>';
                }
            }
            return $menuItems;
        }

        // Menú por defecto (usar rutas simplificadas)
        return '<a href="/" class="text-gray-600 hover:text-gray-900">Inicio</a>
                <a href="/productos" class="text-gray-600 hover:text-gray-900">Productos</a>
                <a href="/contacto" class="text-gray-600 hover:text-gray-900">Contacto</a>';
    }

    /**
     * Generar HTML simple del menú del footer para plantillas simples
     */
    private function generateFooterMenuSimple($website, $menus, $isPreview = false, $currentPage = null)
    {
        $footerMenu = $menus->where('location', 'footer')->first();

        // Obtener la URL actual
        $currentUrl = request()->path();

        if ($footerMenu && $footerMenu->items->count() > 0) {
            $menuItems = '';
            foreach ($footerMenu->items as $item) {
                $icon = $item->icon ? '<i class="' . $item->icon . ' mr-1"></i>' : '';

                // Detectar si este item está activo (corresponde a la página actual)
                $isActive = false;
                if ($currentPage) {
                    // Verificar si el item apunta a la página actual
                    if ($item->page_id && $item->page_id == $currentPage->id) {
                        $isActive = true;
                    }
                    // También verificar si es la página de inicio
                    if ($currentPage->is_home && $item->final_url === '/') {
                        $isActive = true;
                    }
                }

                // También verificar por URL si estamos en preview
                if ($isPreview && !$isActive) {
                    $previewUrl = $this->generatePreviewUrl($item, $website);
                    // Normalizar las URLs para comparar
                    $normalizedPreviewUrl = trim(parse_url($previewUrl, PHP_URL_PATH), '/');
                    $normalizedCurrentUrl = trim($currentUrl, '/');

                    if ($normalizedPreviewUrl === $normalizedCurrentUrl) {
                        $isActive = true;
                    }
                }

                // Agregar clase font-bold si está activo
                $activeClass = $isActive ? ' font-bold' : '';

                // Si estamos en modo preview, crear enlaces que mantengan el contexto de preview
                if ($isPreview) {
                    $previewUrl = $this->generatePreviewUrl($item, $website);
                    $menuItems .= '<li><a href="' . $previewUrl . '" target="' . $item->target . '" class="text-gray-400 transition-colors duration-200 hover:text-white' . $activeClass . '">' . $icon . $item->title . '</a></li>';
                } else {
                    $menuItems .= '<li><a href="' . $item->final_url . '" target="' . $item->target . '" class="text-gray-400 transition-colors duration-200 hover:text-white' . $activeClass . '">' . $icon . $item->title . '</a></li>';
                }
            }
            return $menuItems;
        }

        // Menú por defecto (usar rutas simplificadas)
        return '<li><a href="/" class="text-gray-400 hover:text-white">Inicio</a></li>
                <li><a href="/productos" class="text-gray-400 hover:text-white">Productos</a></li>
                <li><a href="/contacto" class="text-gray-400 hover:text-white">Contacto</a></li>';
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

        // Si el item apunta a una página específica del sitio web
        if ($item->page_id) {
            $page = \App\Models\Page::find($item->page_id);
            if ($page) {
                // Si es la página de inicio, usar la ruta raíz
                if ($page->is_home) {
                    return '/';
                }
                // Para otras páginas, usar su slug directamente
                return '/' . $page->slug;
            }
        }

        // Si tiene URL personalizada, usarla
        if ($item->url) {
            // Si la URL no empieza con /, agregarla
            if (strpos($item->url, '/') !== 0) {
                return '/' . $item->url;
            }
            return $item->url;
        }

        // Para enlaces internos que no son páginas específicas, usar la ruta raíz
        return '/';
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
                        <div class="flex flex-col justify-center gap-4 sm:flex-row">
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
