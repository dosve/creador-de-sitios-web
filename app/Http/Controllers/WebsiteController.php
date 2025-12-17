<?php

namespace App\Http\Controllers;

use App\Models\Website;
use App\Models\Page;
use App\Models\TemplateConfiguration;
use App\Services\TemplateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class WebsiteController extends Controller
{
    use AuthorizesRequests;

    protected $templateService;

    public function __construct(TemplateService $templateService)
    {
        $this->templateService = $templateService;
    }

    /**
     * Mostrar el sitio web desde la ruta raíz
     */
    public function showRoot()
    {
        $host = request()->getHost();

        // LOG: Host actual
        \Log::info("=== SHOWROOT DEBUG ===");
        \Log::info("Host: " . $host);
        \Log::info("Request URL: " . request()->fullUrl());

        // Log directo a archivo para debug
        file_put_contents(storage_path('logs/debug.log'), "=== SHOWROOT DEBUG ===\n", FILE_APPEND);
        file_put_contents(storage_path('logs/debug.log'), "Host: " . $host . "\n", FILE_APPEND);
        file_put_contents(storage_path('logs/debug.log'), "Request URL: " . request()->fullUrl() . "\n", FILE_APPEND);

        // 1. PRIORIDAD: Buscar por dominio personalizado verificado
        // EXCLUIR: creadorweb.eme10.com debe mostrar la aplicación del creador
        if ($host !== 'creadorweb.eme10.com') {
            $domain = \App\Models\Domain::where('domain', $host)
                ->where('is_verified', true)
                ->where('status', 'active')
                ->first();
        } else {
            $domain = null;
        }

        \Log::info("Domain encontrado: " . ($domain ? $domain->toJson() : 'null'));

        // LOG: Verificar todos los dominios en la base de datos
        $allDomains = \App\Models\Domain::all();
        \Log::info("Todos los dominios en BD: " . $allDomains->toJson());

        if ($domain && $domain->website) {
            \Log::info("Mostrando sitio público para dominio: " . $domain->domain);
            \Log::info("Website ID: " . $domain->website->id);
            // Mostrar el sitio público asociado al dominio
            return $this->showPublic($domain->website);
        }

        // 2. Buscar por subdominio (ej: misitioweb.creadorweb.eme10.com)
        if (str_contains($host, '.creadorweb.eme10.com')) {
            \Log::info("Buscando subdominio de creadorweb.eme10.com");
            $subdomain = str_replace('.creadorweb.eme10.com', '', $host);
            $website = Website::where('subdomain', $subdomain)
                ->where('is_published', true)
                ->first();

            if ($website) {
                \Log::info("Sitio encontrado por subdominio: " . $website->id);
                return $this->showPublic($website);
            }
        }

        // 3. Si el usuario está logueado Y tiene un sitio seleccionado
        // EXCLUIR: creadorweb.eme10.com debe mostrar la aplicación del creador
        if (Auth::check() && session('selected_website_id') && $host !== 'creadorweb.eme10.com') {
            \Log::info("Usuario logueado con sitio seleccionado: " . session('selected_website_id'));
            $website = Website::find(session('selected_website_id'));

            // Verificar que el sitio existe y pertenece al usuario
            if ($website && ($website->user_id === Auth::id() || Auth::user()->isAdmin())) {
                \Log::info("Mostrando preview del sitio para usuario logueado");
                // Mostrar el preview del sitio directamente en la ruta raíz
                return app(\App\Http\Controllers\Creator\PreviewController::class)->index(request());
            }
        }

        // 4. Si el usuario está logueado pero NO tiene sitio seleccionado
        if (Auth::check() && !session('selected_website_id')) {
            \Log::info("Usuario logueado sin sitio seleccionado - redirigiendo a welcome");
            // Redirigir a la página de bienvenida
            return redirect()->route('welcome');
        }

        // 5. Si el usuario NO está logueado, redirigir a la página de bienvenida
        \Log::info("Usuario no logueado - redirigiendo a welcome");
        return redirect()->route('welcome');
    }

    /**
     * Mostrar una página del sitio seleccionado por su slug
     */
    public function showPageBySlug($slug)
    {
        // LOG: Debug del flujo de WebsiteController
        \Log::info("=== WEBSITE CONTROLLER DEBUG ===");
        \Log::info("Slug solicitado: " . $slug);
        \Log::info("Usuario autenticado: " . (Auth::check() ? 'Sí' : 'No'));
        \Log::info("Sitio seleccionado: " . (session('selected_website_id') ?? 'NULL'));

        // Log directo a archivo para debug
        file_put_contents(storage_path('logs/debug.log'), "=== WEBSITE CONTROLLER DEBUG ===\n", FILE_APPEND);
        file_put_contents(storage_path('logs/debug.log'), "Slug solicitado: " . $slug . "\n", FILE_APPEND);
        file_put_contents(storage_path('logs/debug.log'), "Usuario autenticado: " . (Auth::check() ? 'Sí' : 'No') . "\n", FILE_APPEND);
        file_put_contents(storage_path('logs/debug.log'), "Sitio seleccionado: " . (session('selected_website_id') ?? 'NULL') . "\n", FILE_APPEND);

        file_put_contents(storage_path('logs/debug.log'), "=== WEBSITE CONTROLLER DEBUG ===\n", FILE_APPEND);
        file_put_contents(storage_path('logs/debug.log'), "Slug solicitado: " . $slug . "\n", FILE_APPEND);
        file_put_contents(storage_path('logs/debug.log'), "Usuario autenticado: " . (Auth::check() ? 'Sí' : 'No') . "\n", FILE_APPEND);
        file_put_contents(storage_path('logs/debug.log'), "Sitio seleccionado: " . (session('selected_website_id') ?? 'NULL') . "\n", FILE_APPEND);

        // Si el usuario está logueado Y tiene un sitio seleccionado
        if (Auth::check() && session('selected_website_id')) {
            $website = Website::find(session('selected_website_id'));

            \Log::info("Sitio encontrado: " . ($website ? $website->name : 'NULL'));
            file_put_contents(storage_path('logs/debug.log'), "Sitio encontrado: " . ($website ? $website->name : 'NULL') . "\n", FILE_APPEND);

            // Verificar que el sitio existe y pertenece al usuario
            if ($website && ($website->user_id === Auth::id() || Auth::user()->isAdmin())) {
                // Buscar la página por slug en el sitio seleccionado
                $page = $website->pages()->where('slug', $slug)->where('is_published', true)->first();

                \Log::info("Página encontrada: " . ($page ? $page->title : 'NULL'));
                file_put_contents(storage_path('logs/debug.log'), "Página encontrada: " . ($page ? $page->title : 'NULL') . "\n", FILE_APPEND);

                if ($page) {
                    \Log::info("Llamando a PreviewController::page");
                    file_put_contents(storage_path('logs/debug.log'), "Llamando a PreviewController::page\n", FILE_APPEND);
                    // Mostrar la página usando el PreviewController
                    return app(\App\Http\Controllers\Creator\PreviewController::class)->page(request(), $page);
                }

                // Si no se encuentra la página, retornar 404
                \Log::info("ERROR: Página no encontrada: " . $slug);
                file_put_contents(storage_path('logs/debug.log'), "ERROR: Página no encontrada: " . $slug . "\n", FILE_APPEND);
                abort(404, 'Página no encontrada: ' . $slug);
            }
        }

        \Log::info("ERROR: Usuario no autenticado o sin sitio seleccionado");
        file_put_contents(storage_path('logs/debug.log'), "ERROR: Usuario no autenticado o sin sitio seleccionado\n", FILE_APPEND);
        // Si no está logueado o no tiene sitio seleccionado, redirigir a bienvenida
        return redirect()->route('welcome');
    }

    /**
     * Mostrar el blog del sitio seleccionado
     */
    public function showBlog()
    {
        // Si el usuario está logueado Y tiene un sitio seleccionado
        if (Auth::check() && session('selected_website_id')) {
            $website = Website::find(session('selected_website_id'));

            // Verificar que el sitio existe y pertenece al usuario
            if ($website && ($website->user_id === Auth::id() || Auth::user()->isAdmin())) {
                // Mostrar el blog usando el PreviewController
                return app(\App\Http\Controllers\Creator\PreviewController::class)->blog(request());
            }
        }

        // Si no está logueado o no tiene sitio seleccionado, redirigir a bienvenida
        return redirect()->route('welcome');
    }

    /**
     * Mostrar un post del blog del sitio seleccionado por su slug
     */
    public function showBlogPost($slug)
    {
        // Si el usuario está logueado Y tiene un sitio seleccionado
        if (Auth::check() && session('selected_website_id')) {
            $website = Website::find(session('selected_website_id'));

            // Verificar que el sitio existe y pertenece al usuario
            if ($website && ($website->user_id === Auth::id() || Auth::user()->isAdmin())) {
                // Buscar el post por slug en el sitio seleccionado
                $blogPost = $website->blogPosts()->where('slug', $slug)->first();

                if ($blogPost) {
                    // Mostrar el post usando el PreviewController
                    return app(\App\Http\Controllers\Creator\PreviewController::class)->blogPost(request(), $blogPost);
                }

                // Si no se encuentra el post, retornar 404
                abort(404, 'Post no encontrado');
            }
        }

        // Si no está logueado o no tiene sitio seleccionado, redirigir a bienvenida
        return redirect()->route('welcome');
    }

    /**
     * Mostrar el sitio web público (sin autenticación)
     */
    public function showPublic(Website $website)
    {
        // LOG: Debug del flujo de showPublic
        \Log::info("=== SHOW PUBLIC DEBUG ===");
        \Log::info("Website: " . $website->name . " (ID: " . $website->id . ")");
        \Log::info("Request URL: " . request()->fullUrl());

        file_put_contents(storage_path('logs/debug.log'), "=== SHOW PUBLIC DEBUG ===\n", FILE_APPEND);
        file_put_contents(storage_path('logs/debug.log'), "Website: " . $website->name . " (ID: " . $website->id . ")\n", FILE_APPEND);
        file_put_contents(storage_path('logs/debug.log'), "Request URL: " . request()->fullUrl() . "\n", FILE_APPEND);

        // Verificar si el sitio web está publicado
        if (!$website->is_published) {
            // Si no está publicado, verificar si el usuario es administrador o propietario
            $canView = false;

            if (Auth::check()) {
                $user = Auth::user();
                // Verificar si es administrador o propietario del sitio
                $canView = ($user->role === 'admin') || ($user->id === $website->user_id);
            }

            if (!$canView) {
                return response()->view('errors.site-not-published', [], 404);
            }
        }

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

        // Si el sitio web tiene plantilla aplicada, renderizar con el sistema de archivos
        if ($website->template_id) {
            $template = $this->templateService->find($website->template_id);
            if ($template) {
                // Renderizar la plantilla con variables
                // Obtener o crear la configuración de la plantilla
                $templateConfig = TemplateConfiguration::firstOrCreate(
                    [
                        'website_id' => $website->id,
                        'template_slug' => $template['slug']
                    ],
                    [
                        'configuration' => TemplateConfiguration::getDefaultConfiguration($template['slug']),
                        'customization' => [],
                        'settings' => [],
                        'is_active' => true
                    ]
                );
                
                // Combinar customización de la plantilla con la configuración guardada
                $defaultCustomization = $template['customization'] ?? [];
                $savedCustomization = $templateConfig->customization ?? [];
                $customization = array_merge($defaultCustomization, $savedCustomization);
                
                $templateFile = $template['templates']['home'] ?? 'template';
                $viewPath = 'templates.' . $template['slug'] . '.' . str_replace('.blade.php', '', $templateFile);

                try {
                    return view($viewPath, [
                        'website' => $website,
                        'page' => $homePage,
                        'pages' => $pages,
                        'customization' => $customization,
                        'templateConfig' => $templateConfig
                    ]);
                } catch (\Exception $e) {
                    \Log::error("Error renderizando plantilla: " . $e->getMessage());
                    \Log::error("Stack trace: " . $e->getTraceAsString());
                    // Fallback a vista en blanco si hay error
                    if ($homePage && $homePage->html_content) {
                        return view('public.blank', compact('website', 'homePage', 'menus'));
                    }
                    throw $e;
                }
            }
        }

        // Si no tiene plantilla pero tiene contenido personalizado, usar vista en blanco
        if (!$website->template_id && $homePage && $homePage->html_content) {
            return view('public.blank', compact('website', 'homePage', 'menus'));
        }

        // Si no tiene plantilla, mostrar página de bienvenida
        return view('welcome');
    }

    /**
     * Procesar plantilla para el sitio público (sin barra de administración)
     */
    private function processTemplatePublic($templateContent, $website, $homePage, $menus)
    {
        // Obtener hooks de la plantilla
        $hooks = $this->getTemplateHooksPublic($website, $homePage, $menus);

        // Reemplazar hooks en el contenido
        $processedContent = $templateContent;
        foreach ($hooks as $hook => $value) {
            $processedContent = str_replace('{{' . $hook . '}}', $value, $processedContent);
        }

        return $processedContent;
    }

    /**
     * Obtener hooks de la plantilla para el sitio público
     */
    private function getTemplateHooksPublic($website, $homePage, $menus)
    {
        $hooks = [
            'CONTENIDO_PAGINA' => $homePage ? $homePage->html_content : '',
            'PAGINA_TITULO' => $homePage ? $homePage->title : 'Inicio',
            'PAGINA_DESCRIPCION' => $homePage ? $homePage->meta_description : '',
            'SITIO_NOMBRE' => $website->name,
            'SITIO_DESCRIPCION' => $website->description ?? '',
        ];

        // Generar menús
        $hooks['MENU_HEADER'] = $this->generateHeaderMenuPublic($website, $menus);
        $hooks['MENU_FOOTER'] = $this->generateFooterMenuPublic($website, $menus);

        return $hooks;
    }

    /**
     * Generar menú del header para el sitio público
     */
    private function generateHeaderMenuPublic($website, $menus)
    {
        $headerMenu = $menus->where('location', 'header')->first();

        if ($headerMenu && $headerMenu->items->count() > 0) {
            $menuItems = '';
            foreach ($headerMenu->items as $item) {
                $icon = $item->icon ? '<i class="' . $item->icon . ' mr-1"></i>' : '';
                $menuItems .= '<a href="' . $item->final_url . '" target="' . $item->target . '" class="text-gray-600 hover:text-gray-900 transition-colors duration-200">' . $icon . $item->title . '</a>';
            }
            return $menuItems;
        }

        // Menú por defecto
        return '<a href="/" class="text-gray-600 hover:text-gray-900">Inicio</a>
                <a href="/blog" class="text-gray-600 hover:text-gray-900">Blog</a>
                <a href="/contacto" class="text-gray-600 hover:text-gray-900">Contacto</a>';
    }

    /**
     * Generar menú del footer para el sitio público
     */
    private function generateFooterMenuPublic($website, $menus)
    {
        $footerMenu = $menus->where('location', 'footer')->first();

        if ($footerMenu && $footerMenu->items->count() > 0) {
            $menuItems = '';
            foreach ($footerMenu->items as $item) {
                $icon = $item->icon ? '<i class="' . $item->icon . ' mr-1"></i>' : '';
                $menuItems .= '<li><a href="' . $item->final_url . '" target="' . $item->target . '" class="text-gray-400 hover:text-white transition-colors duration-200">' . $icon . $item->title . '</a></li>';
            }
            return $menuItems;
        }

        // Menú por defecto
        return '<li><a href="/" class="text-gray-400 hover:text-white">Inicio</a></li>
                <li><a href="/blog" class="text-gray-400 hover:text-white">Blog</a></li>
                <li><a href="/contacto" class="text-gray-400 hover:text-white">Contacto</a></li>';
    }

    public function index()
    {
        return redirect()->route('creator.select-website');
    }

    public function create()
    {
        // Límite de sitios web removido - los usuarios pueden crear múltiples sitios
        $templates = $this->templateService->active();
        return view('creator.websites.create', compact('templates'));
    }

    public function store(Request $request)
    {
        // Límite de sitios web removido - los usuarios pueden crear múltiples sitios

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'template_type' => 'required|in:blank,template',
            'template_slug' => 'nullable|string',
        ]);

        // Determinar qué plantilla usar basado en la selección del usuario
        $templateSlug = null;
        if ($request->template_type === 'template') {
            $templateSlug = $request->template_slug;
            if (!$templateSlug) {
                // Si seleccionó usar plantilla pero no eligió una específica, usar la primera disponible
                $templates = $this->templateService->active();
                $templateSlug = $templates->first()['slug'] ?? null;
            }

            // Verificar que la plantilla existe y está disponible
            if ($templateSlug) {
                $template = $this->templateService->find($templateSlug);
                if (!$template) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'La plantilla seleccionada no existe o no está disponible');
                }

                // Permitido: una misma plantilla puede ser usada por múltiples sitios
            }
        }
        // Si template_type es 'blank', templateSlug permanece null

        // Generar slug único
        $baseSlug = Str::slug($request->name);
        $slug = $baseSlug;
        $counter = 1;

        while (Website::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        $website = Auth::user()->websites()->create([
            'name' => $request->name,
            'description' => $request->description,
            'slug' => $slug,
            'template_id' => $templateSlug,
            'is_published' => false,
        ]);

        // Crear página de inicio automáticamente
        $website->pages()->create([
            'title' => 'Inicio',
            'slug' => 'inicio',
            'html_content' => '<h1>Bienvenido a ' . $website->name . '</h1><p>Esta es tu página de inicio. ¡Comienza a editarla!</p>',
            'is_published' => true,
            'sort_order' => 1,
        ]);

        // Guardar el website en sesión
        session(['selected_website_id' => $website->id]);

        return redirect()->route('creator.websites.show')
            ->with('success', 'Sitio web creado exitosamente');
    }

    public function show(Website $website)
    {
        $this->authorize('view', $website);
        $pages = $website->pages()->orderBy('sort_order')->get();
        return view('creator.websites.show', compact('website', 'pages'));
    }

    public function edit()
    {
        $website = Website::find(session('selected_website_id'));

        if (!$website) {
            return redirect()->route('creator.select-website');
        }

        $this->authorize('update', $website);
        return view('creator.websites.edit', compact('website'));
    }

    public function update(Request $request)
    {
        $website = Website::find(session('selected_website_id'));

        if (!$website) {
            return redirect()->route('creator.select-website');
        }

        $this->authorize('update', $website);

        $newSlug = Str::slug($request->name);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'is_published' => 'nullable|boolean',
        ]);

        // Verificar si el slug ya existe para otro sitio web
        if ($newSlug !== $website->slug) {
            $existingWebsite = Website::where('slug', $newSlug)
                ->where('id', '!=', $website->id)
                ->first();

            if ($existingWebsite) {
                // Si el slug ya existe, agregar un número al final
                $counter = 1;
                $originalSlug = $newSlug;
                do {
                    $newSlug = $originalSlug . '-' . $counter;
                    $counter++;
                } while (Website::where('slug', $newSlug)
                    ->where('id', '!=', $website->id)
                    ->exists()
                );
            }
        }

        $website->update([
            'name' => $request->name,
            'description' => $request->description,
            'slug' => $newSlug,
            'is_published' => $request->boolean('is_published'),
        ]);

        return redirect()->route('creator.config.general')
            ->with('success', 'Sitio web actualizado exitosamente');
    }

    public function destroy(Website $website)
    {
        $this->authorize('delete', $website);
        $website->delete();

        return redirect()->route('creator.select-website')
            ->with('success', 'Sitio web eliminado exitosamente');
    }

    /**
     * Mostrar una página específica del sitio web público
     */
    public function showPagePublic(Website $website, Page $page)
    {
        // LOG: Debug del flujo de showPagePublic
        \Log::info("=== SHOW PAGE PUBLIC DEBUG ===");
        \Log::info("Website: " . $website->name . " (ID: " . $website->id . ")");
        \Log::info("Page: " . $page->title . " (ID: " . $page->id . ")");
        \Log::info("Request URL: " . request()->fullUrl());

        file_put_contents(storage_path('logs/debug.log'), "=== SHOW PAGE PUBLIC DEBUG ===\n", FILE_APPEND);
        file_put_contents(storage_path('logs/debug.log'), "Website: " . $website->name . " (ID: " . $website->id . ")\n", FILE_APPEND);
        file_put_contents(storage_path('logs/debug.log'), "Page: " . $page->title . " (ID: " . $page->id . ")\n", FILE_APPEND);
        file_put_contents(storage_path('logs/debug.log'), "Request URL: " . request()->fullUrl() . "\n", FILE_APPEND);
        file_put_contents(storage_path('logs/debug.log'), "Template ID: " . ($website->template_id ?? 'NULL') . "\n", FILE_APPEND);
        file_put_contents(storage_path('logs/debug.log'), "Tiene plantilla: " . ($website->template_id ? 'Sí' : 'No') . "\n", FILE_APPEND);

        // Verificar que la página pertenece al sitio web
        if ($page->website_id !== $website->id) {
            abort(404);
        }

        // Verificar si el sitio web está publicado
        if (!$website->is_published) {
            // Si no está publicado, verificar si el usuario es administrador o propietario
            $canView = false;

            if (Auth::check()) {
                $user = Auth::user();
                // Verificar si es administrador o propietario del sitio
                $canView = ($user->role === 'admin') || ($user->id === $website->user_id);
            }

            if (!$canView) {
                return response()->view('errors.site-not-published', [], 404);
            }
        }

        // Verificar que la página esté publicada
        if (!$page->is_published) {
            // Si no está publicada, verificar si el usuario es administrador o propietario
            $canView = false;

            if (Auth::check()) {
                $user = Auth::user();
                // Verificar si es administrador o propietario del sitio
                $canView = ($user->role === 'admin') || ($user->id === $website->user_id);
            }

            if (!$canView) {
                abort(404);
            }
        }

        // Obtener páginas del sitio web
        $pages = $website->pages()->where('is_published', true)->orderBy('sort_order')->get();

        // Si el sitio web tiene plantilla aplicada, renderizar con el sistema de archivos
        if ($website->template_id) {
            $template = $this->templateService->find($website->template_id);
            if ($template) {
                // Renderizar la plantilla con variables
                $customization = $template['customization'] ?? [];

                // Determinar qué template usar según el tipo de página
                $templateType = 'page'; // Por defecto usar template de página
                if ($page->is_home) {
                    $templateType = 'home';
                }

                $templateFile = $template['templates'][$templateType] ?? $template['templates']['page'] ?? 'template';
                $viewPath = 'templates.' . $template['slug'] . '.' . str_replace('.blade.php', '', $templateFile);

                // Obtener o crear la configuración de la plantilla
                $templateConfig = TemplateConfiguration::firstOrCreate(
                    [
                        'website_id' => $website->id,
                        'template_slug' => $template['slug']
                    ],
                    [
                        'configuration' => TemplateConfiguration::getDefaultConfiguration($template['slug']),
                        'customization' => [],
                        'settings' => [],
                        'is_active' => true
                    ]
                );

                return view($viewPath, [
                    'website' => $website,
                    'page' => $page,
                    'pages' => $pages,
                    'customization' => $customization,
                    'templateConfig' => $templateConfig
                ]);
            }
        }

        // Si no tiene plantilla, usar vista en blanco
        return view('public.blank', compact('website', 'page', 'pages'));
    }

    /**
     * Método unificado que determina si mostrar página de dominio personalizado o sitio del creador
     */
    public function showPageOrWebsite($slug)
    {
        $host = request()->getHost();

        \Log::info("=== SHOWPAGEORWEBSITE ===");
        \Log::info("Host: " . $host);
        \Log::info("Slug: " . $slug);

        // Si es dominio personalizado (NO creadorweb.eme10.com)
        if ($host !== 'creadorweb.eme10.com' && $host !== 'localhost' && $host !== '127.0.0.1') {
            \Log::info("→ Detectado dominio personalizado, usando showPageByDomain");
            return $this->showPageByDomain($slug);
        }

        // Si es creadorweb.eme10.com, buscar website por slug
        \Log::info("→ Detectado creadorweb.eme10.com, usando showPublic");
        $website = Website::where('slug', $slug)->firstOrFail();
        return $this->showPublic($website);
    }

    /**
     * Mostrar una página del sitio por dominio personalizado (sin slug del sitio)
     */
    public function showPageByDomain($slug)
    {
        $host = request()->getHost();

        \Log::info("=== SHOWPAGEBYDOMAIN DEBUG ===");
        \Log::info("Host: " . $host);
        \Log::info("Slug de página: " . $slug);
        \Log::info("Usuario autenticado: " . (Auth::check() ? 'SÍ' : 'NO'));

        // Si es creadorweb.eme10.com, intentar con el sitio en sesión (si está autenticado)
        if ($host === 'creadorweb.eme10.com' || $host === 'localhost' || $host === '127.0.0.1') {
            \Log::info("⚠️ Host es creadorweb.eme10.com");

            if (!Auth::check()) {
                \Log::info("❌ Usuario NO autenticado - redirigiendo a login");
                return redirect()->route('login');
            }

            // Usuario autenticado - usar el sitio en sesión
            if (!session('selected_website_id')) {
                \Log::info("❌ No hay sitio seleccionado");
                abort(404, 'No hay sitio seleccionado');
            }

            $website = Website::find(session('selected_website_id'));
            if (!$website) {
                abort(404, 'Sitio no encontrado');
            }

            \Log::info("✅ Usando sitio de sesión: " . $website->name);
        } else {
            // Es un dominio personalizado - buscar en la tabla de dominios
            $domain = \App\Models\Domain::where('domain', $host)
                ->where('is_verified', true)
                ->where('status', 'active')
                ->first();

            \Log::info("Dominio encontrado: " . ($domain ? 'SÍ (ID: ' . $domain->id . ')' : 'NO'));

            if (!$domain || !$domain->website) {
                \Log::error("❌ Dominio no encontrado o sin website asociado");
                abort(404, 'Dominio no configurado');
            }

            $website = $domain->website;
            \Log::info("Website del dominio: ID " . $website->id . " - " . $website->name);
        }

        \Log::info("🔍 Buscando página con slug: '" . $slug . "' en website ID: " . $website->id);

        // Buscar la página por slug
        $page = $website->pages()
            ->where('slug', $slug)
            ->where('is_published', true)
            ->first();

        if (!$page) {
            // Buscar TODAS las páginas para debug
            $allPages = $website->pages()->get();
            \Log::error("❌ Página NO encontrada. Slug buscado: '" . $slug . "'");
            \Log::info("📋 Total de páginas en el sitio: " . $allPages->count());
            \Log::info("📋 Todas las páginas:", $allPages->pluck('slug', 'title')->toArray());
            \Log::info("📋 Páginas publicadas:", $website->pages()->where('is_published', true)->pluck('slug', 'title')->toArray());

            abort(404, 'Página "' . $slug . '" no encontrada o no publicada');
        }

        \Log::info("✅ Página encontrada: " . $page->title . " (ID: " . $page->id . ")");

        // Obtener páginas del sitio web
        $pages = $website->pages()->where('is_published', true)->orderBy('sort_order')->get();

        // Si el sitio web tiene plantilla aplicada, renderizar con el sistema de archivos
        if ($website->template_id) {
            $template = $this->templateService->find($website->template_id);
            if ($template) {
                // Renderizar la plantilla con variables
                $customization = $template['customization'] ?? [];

                // Determinar qué template usar según el tipo de página
                $templateType = 'page'; // Por defecto usar template de página
                if ($page->is_home) {
                    $templateType = 'home';
                }

                $templateFile = $template['templates'][$templateType] ?? $template['templates']['page'] ?? 'template';
                $viewPath = 'templates.' . $template['slug'] . '.' . str_replace('.blade.php', '', $templateFile);

                // Obtener o crear la configuración de la plantilla
                $templateConfig = TemplateConfiguration::firstOrCreate(
                    [
                        'website_id' => $website->id,
                        'template_slug' => $template['slug']
                    ],
                    [
                        'configuration' => TemplateConfiguration::getDefaultConfiguration($template['slug']),
                        'customization' => [],
                        'settings' => [],
                        'is_active' => true
                    ]
                );

                return view($viewPath, [
                    'website' => $website,
                    'page' => $page,
                    'pages' => $pages,
                    'customization' => $customization,
                    'templateConfig' => $templateConfig
                ]);
            }
        }

        // Si no tiene plantilla, usar vista en blanco
        return view('public.blank', compact('website', 'page', 'pages'));
    }

    /**
     * Mostrar una página específica de un sitio web por su slug
     * Ejemplo: /sitio/tienda, /sitio/quienes-somos
     */
    public function showWebsitePage(Website $website, $pageSlug)
    {
        \Log::info("=== SHOW WEBSITE PAGE ===");
        \Log::info("Website: " . $website->name);
        \Log::info("Page Slug: " . $pageSlug);

        // Verificar si el sitio está publicado
        if (!$website->is_published) {
            $canView = false;
            if (Auth::check()) {
                $user = Auth::user();
                $canView = ($user->role === 'admin') || ($user->id === $website->user_id);
            }
            if (!$canView) {
                return response()->view('errors.site-not-published', [], 404);
            }
        }

        // Buscar la página por slug
        $page = $website->pages()->where('slug', $pageSlug)->where('is_published', true)->first();

        if (!$page) {
            abort(404, 'Página no encontrada');
        }

        // Obtener todas las páginas para navegación
        $pages = $website->pages()->where('is_published', true)->orderBy('sort_order')->get();

        // Obtener menús
        $menus = $website->menus()->with(['items' => function ($query) {
            $query->whereNull('parent_id')->where('is_active', true)->orderBy('order');
        }, 'items.page', 'items.children' => function ($query) {
            $query->where('is_active', true)->orderBy('order');
        }, 'items.children.page'])->get();

        // Si tiene plantilla, procesarla
        if ($website->template_id) {
            $template = $this->templateService->find($website->template_id);
            if ($template) {
                $customization = $template['customization'] ?? [];
                $templateFile = $template['templates']['page'] ?? $template['templates']['home'] ?? 'template';
                $viewPath = 'templates.' . $template['slug'] . '.' . str_replace('.blade.php', '', $templateFile);

                $templateConfig = TemplateConfiguration::firstOrCreate(
                    ['website_id' => $website->id, 'template_slug' => $template['slug']],
                    [
                        'configuration' => TemplateConfiguration::getDefaultConfiguration($template['slug']),
                        'customization' => [],
                        'settings' => [],
                        'is_active' => true
                    ]
                );

                return view($viewPath, [
                    'website' => $website,
                    'page' => $page,
                    'pages' => $pages,
                    'customization' => $customization,
                    'templateConfig' => $templateConfig
                ]);
            }
        }

        // Sin plantilla - usar vista pública en blanco
        return view('public.blank', compact('website', 'page', 'pages', 'menus'));
    }
}
