<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\Website;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PageController extends BaseController
{
    use AuthorizesRequests;
    public function index(Request $request)
    {
        // Debug temporal
        $selectedWebsiteId = session('selected_website_id');
        
        if (!$selectedWebsiteId) {
            return response()->json([
                'error' => 'No hay sitio web seleccionado en la sesión',
                'session_data' => session()->all(),
                'user_id' => auth()->id()
            ], 403);
        }
        
        $website = Website::find($selectedWebsiteId);
        
        if (!$website) {
            return response()->json([
                'error' => 'Sitio web no encontrado',
                'selected_website_id' => $selectedWebsiteId
            ], 403);
        }
        
        $this->authorize('view', $website);

        $pages = $website->pages()->latest()->get();
        
        // Verificar si se solicita editar una página específica
        if (request()->has('edit_page')) {
            $pageSlug = request()->get('edit_page');
            $page = $website->pages()->where('slug', $pageSlug)->first();
            
            if ($page) {
                return redirect()->route('creator.pages.editor', $page);
            }
        }
        
        // Verificar si se solicita verificar la existencia de una página
        if (request()->has('check_page')) {
            $pageSlug = request()->get('check_page');
            $page = $website->pages()->where('slug', $pageSlug)->first();
            
            return response()->json(['exists' => $page !== null]);
        }

        // Obtener la página actual (si hay una en la URL o en el referer)
        $currentPage = null;
        if (request()->has('current_page')) {
            $currentPageSlug = request()->get('current_page');
            $currentPage = $website->pages()->where('slug', $currentPageSlug)->first();
        } else {
            // Intentar detectar la página actual desde el referer
            $referer = request()->header('referer');
            if ($referer) {
                $refererParts = parse_url($referer);
                $path = $refererParts['path'] ?? '';
                $pathParts = explode('/', trim($path, '/'));
                
                \Log::info('Debug referer', [
                    'referer' => $referer,
                    'path' => $path,
                    'pathParts' => $pathParts,
                    'website_slug' => $website->slug,
                    'count' => count($pathParts)
                ]);
                
                // Si la URL tiene el formato /{website_slug}/{page_slug}
                if (count($pathParts) >= 2 && $pathParts[0] === $website->slug) {
                    $pageSlug = $pathParts[1];
                    $currentPage = $website->pages()->where('slug', $pageSlug)->first();
                    \Log::info('Página encontrada desde referer', [
                        'pageSlug' => $pageSlug,
                        'currentPage' => $currentPage ? $currentPage->title : 'No encontrada'
                    ]);
                }
            }
        }
        
        // Log para debug
        \Log::info('Página actual detectada', [
            'current_page' => $currentPage ? $currentPage->title : 'Ninguna',
            'referer' => request()->header('referer'),
            'has_current_page_param' => request()->has('current_page')
        ]);
        
        return view('creator.pages.index', compact('pages', 'website', 'currentPage'));
    }

    public function create(Request $request)
    {
        $website = Website::find(session('selected_website_id'));
        
        if (!$website) {
            return redirect()->route('creator.select-website');
        }
        
        $this->authorize('update', $website);

        return view('creator.pages.create', compact('website'));
    }

    public function store(Request $request)
    {
        $website = Website::find(session('selected_website_id'));
        
        if (!$website) {
            return redirect()->route('creator.select-website');
        }
        
        $this->authorize('update', $website);

        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:pages,slug,NULL,id,website_id,' . $website->id,
            'html_content' => 'nullable|string',
            'is_published' => 'boolean',
        ]);

        $page = $website->pages()->create([
            'title' => $request->title,
            'slug' => $request->slug,
            'html_content' => $request->html_content ?: '<h1>' . $request->title . '</h1><p>Contenido de la página...</p>',
            'is_published' => $request->boolean('is_published', false),
            'sort_order' => $website->pages()->max('sort_order') + 1,
        ]);

        return redirect()->route('creator.pages.index')
            ->with('success', 'Página creada exitosamente');
    }

    public function show(Request $request, Page $page)
    {
        $website = Website::find(session('selected_website_id'));
        
        if (!$website) {
            return redirect()->route('creator.select-website');
        }
        
        $this->authorize('view', $website);

        return view('creator.pages.show', compact('page', 'website'));
    }

    public function edit(Request $request, Page $page)
    {
        $website = Website::find(session('selected_website_id'));
        
        if (!$website) {
            return redirect()->route('creator.select-website');
        }
        
        $this->authorize('update', $website);

        // Verificar que la página pertenece al sitio web
        if ($page->website_id !== $website->id) {
            abort(403);
        }

        return view('creator.pages.edit', compact('page', 'website'));
    }

    public function update(Request $request, Page $page)
    {
        $website = Website::find(session('selected_website_id'));
        
        if (!$website) {
            return redirect()->route('creator.select-website');
        }
        
        $this->authorize('update', $website);

        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:pages,slug,' . $page->id . ',id,website_id,' . $website->id,
            'html_content' => 'sometimes|nullable|string',
            'is_published' => 'boolean',
            'is_home' => 'boolean',
        ]);

        // Si esta página se marca como inicio, desmarcar las otras
        if ($request->boolean('is_home', false)) {
            $website->pages()->where('id', '!=', $page->id)->update(['is_home' => false]);
        }

        $htmlContent = $request->has('html_content')
            ? ($request->input('html_content') ?? '')
            : ($page->html_content ?? '');

        $page->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'html_content' => $htmlContent,
            'is_published' => $request->boolean('is_published', false),
            'is_home' => $request->boolean('is_home', false),
        ]);

        // Si es una petición AJAX/JSON, devolver respuesta JSON
        if ($request->expectsJson() || $request->isJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Página actualizada exitosamente'
            ]);
        }

        return redirect()->route('creator.pages.index')
            ->with('success', 'Página actualizada exitosamente');
    }

    public function destroy(Request $request, Page $page)
    {
        $website = Website::find(session('selected_website_id'));
        
        if (!$website) {
            return redirect()->route('creator.select-website');
        }
        
        $this->authorize('update', $website);

        $page->delete();

        return redirect()->route('creator.pages.index')
            ->with('success', 'Página eliminada exitosamente');
    }

    /**
     * Establecer una página como página de inicio
     */
    public function setHome(Request $request, Page $page)
    {
        $website = Website::find(session('selected_website_id'));
        
        if (!$website) {
            return redirect()->route('creator.select-website');
        }
        
        $this->authorize('update', $website);

        // Verificar que la página pertenece al sitio web
        if ($page->website_id !== $website->id) {
            abort(403);
        }

        // Desmarcar todas las otras páginas como inicio
        $website->pages()->where('id', '!=', $page->id)->update(['is_home' => false]);

        // Marcar esta página como inicio
        $page->update(['is_home' => true]);

        return redirect()->route('creator.pages.index')
            ->with('success', "La página '{$page->title}' ahora es la página de inicio");
    }
    
    /**
     * Mostrar página de importación de páginas prediseñadas
     */
    public function showImport(Website $website)
    {
        $this->authorize('view', $website);
        
        // Obtener páginas prediseñadas de la plantilla
        $contentImportService = app(\App\Services\ContentImportService::class);
        $pages = $contentImportService->getTemplatePages($website->template_id);
        
        return view('creator.pages.import', [
            'website' => $website,
            'pages' => $pages
        ]);
    }
    
    /**
     * Importar páginas prediseñadas seleccionadas
     */
    public function importPages(Request $request, Website $website)
    {
        $this->authorize('update', $website);
        
        // Debug: Log de la petición
        \Log::info('Importando páginas', [
            'website_id' => $website->id,
            'template_id' => $website->template_id,
            'request_data' => $request->all()
        ]);
        
        $request->validate([
            'pages' => 'array',
            'pages.*' => 'array',
            'pages.*.slug' => 'required|string',
            'pages.*.template' => 'nullable|string'
        ]);
        
        $selectedPages = $request->input('pages', []);
        
        \Log::info('Páginas seleccionadas para importar', ['pages' => $selectedPages]);
        
        if (empty($selectedPages)) {
            return redirect()->back()
                ->with('error', 'No se seleccionaron páginas para importar');
        }
        
        // Verificar que el sitio tenga una plantilla asignada
        if (!$website->template_id) {
            \Log::error('El sitio web no tiene plantilla asignada', ['website_id' => $website->id]);
            return redirect()->back()
                ->with('error', 'El sitio web no tiene una plantilla asignada');
        }
        
        // Agrupar por plantilla (permitir importaciones cruzadas)
        $pagesByTemplate = [];
        foreach ($selectedPages as $entry) {
            $tpl = $entry['template'] ?? $website->template_id;
            $slug = $entry['slug'];
            $pagesByTemplate[$tpl][] = $slug;
        }

        $contentImportService = app(\App\Services\ContentImportService::class);
        $pagesToImport = [];
        foreach ($pagesByTemplate as $tpl => $slugs) {
            $allPages = $contentImportService->getTemplatePages($tpl);
            \Log::info('Páginas disponibles en la plantilla', ['template' => $tpl, 'count' => count($allPages)]);
            foreach ($allPages as $p) {
                if (in_array($p['slug'], $slugs)) {
                    $p['__template'] = $tpl;
                    $pagesToImport[] = $p;
                }
            }
        }

        // Fallback: si no hay metadatos, crear desde los slugs directamente
        if (empty($pagesToImport)) {
            \Log::info('Fallback: creando páginas desde slugs enviados');
            foreach ($pagesByTemplate as $tpl => $slugs) {
                foreach ($slugs as $slug) {
                    $pagesToImport[] = [
                        'title' => ucwords(str_replace('-', ' ', $slug)),
                        'slug' => $slug,
                        'meta_description' => null,
                        'is_home' => false,
                        '__template' => $tpl,
                    ];
                }
            }
        }

        \Log::info('Páginas a importar', ['count' => count($pagesToImport)]);
        
        $imported = 0;
        $skipped = 0;
        
        foreach ($pagesToImport as $pageData) {
            \Log::info('Procesando página', [
                'title' => $pageData['title'],
                'slug' => $pageData['slug']
            ]);
            
            // Asegurar slug único: si existe, agregar sufijo incremental
            $baseSlug = $pageData['slug'];
            $slug = $baseSlug;
            $counter = 2;
            while ($website->pages()->where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }
            
            // Intentar renderizar la vista Blade específica de la plantilla si existe
            $htmlContent = '';
            $templateSlug = $pageData['__template'] ?? $website->template_id;
            if ($templateSlug && isset($pageData['slug'])) {
                $viewName = "creator.pages.templates." . $templateSlug . "." . $pageData['slug'];
                if (view()->exists($viewName)) {
                    try {
                        // Pasar variables mínimas esperadas por vistas de catálogo
                        $htmlContent = view($viewName, [
                            'pageTitle' => $pageData['title'] ?? 'Página',
                            'websiteName' => $website->name ?? 'Sitio',
                            'website' => $website,
                        ])->render();
                    } catch (\Throwable $e) {
                        \Log::warning('Fallo al renderizar la vista durante importación', [
                            'view' => $viewName,
                            'error' => $e->getMessage()
                        ]);
                    }
                }
            }
            // Si no hay vista específica o falló, generar contenido a partir de los datos
            if (trim($htmlContent) === '') {
                $htmlContent = $this->generatePageContent($pageData);
            }

            // Normalizar: si el HTML contiene <main> o <body>, extraer solo el contenido interno para evitar anidar documentos completos en el layout
            $htmlContent = $this->extractMainContent($htmlContent);
            
            \Log::info('Contenido HTML generado', [
                'title' => $pageData['title'],
                'content_length' => strlen($htmlContent),
                'has_blocks' => !empty($pageData['blocks'])
            ]);
            
            // Crear nueva página
            $page = new Page([
                'website_id' => $website->id,
                'title' => $pageData['title'],
                'slug' => $slug,
                'meta_description' => $pageData['meta_description'] ?? null,
                'html_content' => $htmlContent,
                'is_published' => true,
                'is_home' => $pageData['is_home'] ?? false,
                'sort_order' => $website->pages()->max('sort_order') + 1
            ]);
            
            $page->save();
            \Log::info('Página creada exitosamente', [
                'id' => $page->id,
                'title' => $page->title,
                'slug' => $page->slug
            ]);
            $imported++;
        }
        
        $message = "Se importaron {$imported} páginas prediseñadas";
        if ($skipped > 0) {
            $message .= " ({$skipped} ya existían)";
        }
        
        \Log::info('Importación completada', [
            'imported' => $imported,
            'skipped' => $skipped,
            'message' => $message
        ]);
        
        return redirect()->route('creator.pages.index')
            ->with('success', $message);
    }
    
    /**
     * Obtener páginas prediseñadas en formato JSON para el modal
     */
    public function getTemplatePages(Website $website)
    {
        $this->authorize('view', $website);
        
        // Verificar que el sitio tenga una plantilla asignada
        if (!$website->template_id) {
            return response()->json([]);
        }
        
        // Obtener páginas prediseñadas de la plantilla
        $contentImportService = app(\App\Services\ContentImportService::class);
        $pages = $contentImportService->getTemplatePages($website->template_id);
        
        return response()->json($pages);
    }
    
    /**
     * Mostrar el editor de páginas
     */
    public function editor(Page $page)
    {
        $this->authorize('update', $page);
        
        return view('creator.pages.editor', compact('page', 'website'));
    }
    
    /**
     * Generar contenido HTML completo basado en los bloques de la página
     */
    private function generatePageContent(array $pageData): string
    {
        $html = '';
        
        // Agregar el contenido básico si existe
        if (array_key_exists('content', $pageData) && !empty($pageData['content'])) {
            // Si content viene como string HTML
            if (is_string($pageData['content'])) {
                $html .= $pageData['content'];
            }
            // Si content viene como arreglo (p. ej. lista de secciones)
            elseif (is_array($pageData['content'])) {
                foreach ($pageData['content'] as $contentBlock) {
                    if (is_string($contentBlock)) {
                        $html .= $contentBlock;
                    } elseif (is_array($contentBlock)) {
                        // Renderizado muy básico para objetos de contenido
                        $blockTitle = $contentBlock['title'] ?? '';
                        $blockText = $contentBlock['text'] ?? '';
                        $html .= "<section class='py-10'><div class='container mx-auto px-4'><h2 class='text-2xl font-bold mb-2'>{$blockTitle}</h2><p class='text-gray-600'>{$blockText}</p></div></section>";
                    }
                }
            }
        }
        
        // Generar contenido basado en los bloques
        if (isset($pageData['blocks']) && is_array($pageData['blocks'])) {
            foreach ($pageData['blocks'] as $block) {
                $html .= $this->generateBlockContent($block);
            }
        }
        
        // Si no se generó nada, crear un contenido mínimo por defecto
        if (trim($html) === '') {
            $title = $pageData['title'] ?? 'Página';
            $description = $pageData['meta_description'] ?? '';
            $html = "<section class='py-20 bg-white'><div class='container mx-auto px-4 text-center'><h1 class='text-4xl font-bold mb-4'>{$title}</h1>" .
                    ($description ? "<p class='text-lg text-gray-600 max-w-2xl mx-auto'>{$description}</p>" : "<p class='text-gray-500'>Contenido en construcción.</p>") .
                    "</div></section>";
        }
        
        return $html;
    }

    /**
     * Extraer solo el contenido útil del HTML importado.
     * Preferencia: contenido dentro de <main>... </main>; si no existe, el interior de <body>.
     */
    private function extractMainContent(string $html): string
    {
        $headExtras = '';
        // Capturar links/scripts externos del <head> para conservar dependencias (CDN, estilos)
        if (preg_match('/<head[^>]*>([\s\S]*?)<\/head>/i', $html, $h)) {
            $head = $h[1];
            // Links (solo externos/CDN)
            preg_match_all('/<link[^>]+href=[\"\']([^\"\']+)[\"\'][^>]*>/i', $head, $links);
            if (!empty($links[0])) {
                // Conservar solo CDNs (http/https)
                foreach ($links[0] as $i => $tag) {
                    $href = $links[1][$i] ?? '';
                    if (stripos($href, 'http://') === 0 || stripos($href, 'https://') === 0) {
                        $headExtras .= $tag . "\n";
                    }
                }
            }
            // Scripts
            preg_match_all('/<script[^>]+src=[\"\']([^\"\']+)[\"\'][^>]*><\/script>/i', $head, $scripts);
            if (!empty($scripts[0])) {
                foreach ($scripts[0] as $i => $tag) {
                    $src = $scripts[1][$i] ?? '';
                    if (stripos($src, 'http://') === 0 || stripos($src, 'https://') === 0) {
                        $headExtras .= $tag . "\n";
                    }
                }
            }
        }

        // Intentar capturar <main>...</main>
        if (preg_match('/<main[^>]*>([\s\S]*?)<\/main>/i', $html, $m)) {
            return $headExtras . $m[1];
        }
        // Intentar capturar <body>...</body>
        if (preg_match('/<body[^>]*>([\s\S]*?)<\/body>/i', $html, $m)) {
            return $headExtras . $m[1];
        }
        // Como fallback, retornar tal cual (más extras de head por si solo hay secciones)
        return $headExtras . $html;
    }
    
    /**
     * Generar contenido HTML para un bloque específico
     */
    private function generateBlockContent(array $block): string
    {
        $type = $block['type'] ?? '';
        
        switch ($type) {
            case 'hero':
                return $this->generateHeroBlock($block);
            case 'services':
                return $this->generateServicesBlock($block);
            case 'portfolio':
                return $this->generatePortfolioBlock($block);
            case 'page_header':
                return $this->generatePageHeaderBlock($block);
            case 'portfolio_grid':
                return $this->generatePortfolioGridBlock($block);
            case 'services_detailed':
                return $this->generateServicesDetailedBlock($block);
            default:
                return $this->generateGenericBlock($block);
        }
    }
    
    /**
     * Generar bloque Hero
     */
    private function generateHeroBlock(array $block): string
    {
        $title = $block['title'] ?? '';
        $subtitle = $block['subtitle'] ?? '';
        $ctaPrimary = $block['cta_primary_text'] ?? '';
        $ctaPrimaryLink = $block['cta_primary_link'] ?? '#';
        $ctaSecondary = $block['cta_secondary_text'] ?? '';
        $ctaSecondaryLink = $block['cta_secondary_link'] ?? '#';
        
        return "
        <section class='hero-section bg-gradient-to-r from-blue-600 to-purple-600 text-white py-20'>
            <div class='container mx-auto px-4 text-center'>
                <h1 class='text-5xl font-bold mb-6'>{$title}</h1>
                <p class='text-xl mb-8 max-w-2xl mx-auto'>{$subtitle}</p>
                <div class='flex gap-4 justify-center'>
                    <a href='{$ctaPrimaryLink}' class='bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors'>{$ctaPrimary}</a>
                    <a href='{$ctaSecondaryLink}' class='border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition-colors'>{$ctaSecondary}</a>
                </div>
            </div>
        </section>";
    }
    
    /**
     * Generar bloque de Servicios
     */
    private function generateServicesBlock(array $block): string
    {
        $title = $block['title'] ?? '';
        $subtitle = $block['subtitle'] ?? '';
        $description = $block['description'] ?? '';
        $items = $block['items'] ?? [];
        
        $servicesHtml = '';
        foreach ($items as $item) {
            $itemTitle = $item['title'] ?? '';
            $itemDescription = $item['description'] ?? '';
            $icon = $item['icon'] ?? 'star';
            
            $servicesHtml .= "
            <div class='bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow'>
                <div class='text-blue-600 text-4xl mb-4'>📊</div>
                <h3 class='text-xl font-semibold mb-3'>{$itemTitle}</h3>
                <p class='text-gray-600'>{$itemDescription}</p>
            </div>";
        }
        
        return "
        <section class='py-16 bg-gray-50'>
            <div class='container mx-auto px-4'>
                <div class='text-center mb-12'>
                    <h2 class='text-4xl font-bold text-gray-900 mb-4'>{$title}</h2>
                    <p class='text-xl text-gray-600 mb-2'>{$subtitle}</p>
                    <p class='text-gray-500'>{$description}</p>
                </div>
                <div class='grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6'>
                    {$servicesHtml}
                </div>
            </div>
        </section>";
    }
    
    /**
     * Generar bloque de Portfolio
     */
    private function generatePortfolioBlock(array $block): string
    {
        $title = $block['title'] ?? '';
        $subtitle = $block['subtitle'] ?? '';
        
        return "
        <section class='py-16'>
            <div class='container mx-auto px-4'>
                <div class='text-center mb-12'>
                    <h2 class='text-4xl font-bold text-gray-900 mb-4'>{$title}</h2>
                    <p class='text-xl text-gray-600'>{$subtitle}</p>
                </div>
                <div class='grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6'>
                    <div class='bg-gray-200 h-64 rounded-lg flex items-center justify-center'>
                        <span class='text-gray-500'>Proyecto 1</span>
                    </div>
                    <div class='bg-gray-200 h-64 rounded-lg flex items-center justify-center'>
                        <span class='text-gray-500'>Proyecto 2</span>
                    </div>
                    <div class='bg-gray-200 h-64 rounded-lg flex items-center justify-center'>
                        <span class='text-gray-500'>Proyecto 3</span>
                    </div>
                </div>
            </div>
        </section>";
    }
    
    /**
     * Generar bloque de Header de Página
     */
    private function generatePageHeaderBlock(array $block): string
    {
        $title = $block['title'] ?? '';
        $subtitle = $block['subtitle'] ?? '';
        $description = $block['description'] ?? '';
        
        return "
        <section class='py-16 bg-gray-50'>
            <div class='container mx-auto px-4 text-center'>
                <h1 class='text-4xl font-bold text-gray-900 mb-4'>{$title}</h1>
                <h2 class='text-2xl text-gray-600 mb-4'>{$subtitle}</h2>
                <p class='text-lg text-gray-500 max-w-2xl mx-auto'>{$description}</p>
            </div>
        </section>";
    }
    
    /**
     * Generar bloque de Grid de Portfolio
     */
    private function generatePortfolioGridBlock(array $block): string
    {
        $layout = $block['layout'] ?? 'grid';
        $itemsPerPage = $block['items_per_page'] ?? 12;
        $categories = $block['categories'] ?? [];
        
        $categoriesHtml = '';
        foreach ($categories as $category) {
            $categoriesHtml .= "<button class='px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-blue-600 hover:text-white transition-colors'>{$category}</button>";
        }
        
        return "
        <section class='py-16'>
            <div class='container mx-auto px-4'>
                <div class='flex flex-wrap gap-4 mb-8 justify-center'>
                    {$categoriesHtml}
                </div>
                <div class='grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6'>
                    " . str_repeat('<div class="bg-gray-200 h-64 rounded-lg flex items-center justify-center"><span class="text-gray-500">Proyecto</span></div>', 6) . "
                </div>
            </div>
        </section>";
    }
    
    /**
     * Generar bloque de Servicios Detallados
     */
    private function generateServicesDetailedBlock(array $block): string
    {
        $items = $block['items'] ?? [];
        
        $servicesHtml = '';
        foreach ($items as $item) {
            $title = $item['title'] ?? '';
            $description = $item['description'] ?? '';
            $features = $item['features'] ?? [];
            
            $featuresHtml = '';
            foreach ($features as $feature) {
                $featuresHtml .= "<li class='flex items-center'><span class='text-green-500 mr-2'>✓</span>{$feature}</li>";
            }
            
            $servicesHtml .= "
            <div class='bg-white p-8 rounded-lg shadow-lg'>
                <h3 class='text-2xl font-bold text-gray-900 mb-4'>{$title}</h3>
                <p class='text-gray-600 mb-6'>{$description}</p>
                <ul class='space-y-2'>
                    {$featuresHtml}
                </ul>
            </div>";
        }
        
        return "
        <section class='py-16 bg-gray-50'>
            <div class='container mx-auto px-4'>
                <div class='grid grid-cols-1 md:grid-cols-2 gap-8'>
                    {$servicesHtml}
                </div>
            </div>
        </section>";
    }
    
    /**
     * Generar bloque genérico
     */
    private function generateGenericBlock(array $block): string
    {
        $type = $block['type'] ?? 'unknown';
        return "<!-- Bloque {$type} -->";
    }
}
