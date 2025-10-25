<?php

namespace App\Http\Controllers;

use App\Models\Website;
use App\Models\Page;
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
        // Si el usuario está logueado Y tiene un sitio seleccionado
        if (Auth::check() && session('selected_website_id')) {
            $website = Website::find(session('selected_website_id'));
            
            // Verificar que el sitio existe y pertenece al usuario
            if ($website && ($website->user_id === Auth::id() || Auth::user()->isAdmin())) {
                // Buscar la página por slug en el sitio seleccionado
                $page = $website->pages()->where('slug', $slug)->where('is_published', true)->first();
                
                if ($page) {
                    // Mostrar la página usando el PreviewController
                    return app(\App\Http\Controllers\Creator\PreviewController::class)->page(request(), $page);
                }
                
                // Si no se encuentra la página, retornar 404
                abort(404, 'Página no encontrada: ' . $slug);
            }
        }
        
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
        $menus = $website->menus()->with(['items' => function($query) {
            $query->whereNull('parent_id')->where('is_active', true)->orderBy('order');
        }, 'items.page', 'items.children' => function($query) {
            $query->where('is_active', true)->orderBy('order');
        }, 'items.children.page'])->get();

        // Si el sitio web tiene plantilla aplicada, renderizar con el sistema de archivos
        if ($website->template_id) {
            $template = $this->templateService->find($website->template_id);
            if ($template) {
                // Renderizar la plantilla con variables
                $customization = $template['customization'] ?? [];
                $templateFile = $template['templates']['home'] ?? 'template';
                $viewPath = 'templates.' . $template['slug'] . '.' . str_replace('.blade.php', '', $templateFile);
                return view($viewPath, [
                    'website' => $website,
                    'page' => $homePage,
                    'pages' => $pages,
                    'customization' => $customization
                ]);
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
                
                // Verificar si la plantilla está siendo usada por otros sitios web
                $sitesUsingTemplate = Website::where('template_id', $templateSlug)->count();
                if ($sitesUsingTemplate > 0) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Esta plantilla ya está siendo utilizada por otro sitio web. Por favor selecciona una diferente.');
                }
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
                
                return view($viewPath, [
                    'website' => $website,
                    'page' => $page,
                    'pages' => $pages,
                    'customization' => $customization
                ]);
            }
        }

        // Si no tiene plantilla, usar vista en blanco
        return view('public.blank', compact('website', 'page', 'pages'));
    }

    /**
     * Mostrar una página del sitio por dominio personalizado (sin slug del sitio)
     */
    public function showPageByDomain($slug)
    {
        $host = request()->getHost();
        
        // Buscar el sitio por dominio personalizado
        $domain = \App\Models\Domain::where('domain', $host)
            ->where('is_verified', true)
            ->where('status', 'active')
            ->first();
        
        if (!$domain || !$domain->website) {
            abort(404);
        }
        
        $website = $domain->website;
        
        // Buscar la página por slug
        $page = $website->pages()
            ->where('slug', $slug)
            ->where('is_published', true)
            ->first();
        
        if (!$page) {
            abort(404);
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
                
                return view($viewPath, [
                    'website' => $website,
                    'page' => $page,
                    'pages' => $pages,
                    'customization' => $customization
                ]);
            }
        }

        // Si no tiene plantilla, usar vista en blanco
        return view('public.blank', compact('website', 'page', 'pages'));
    }
}
