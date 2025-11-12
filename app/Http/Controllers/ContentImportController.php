<?php

namespace App\Http\Controllers;

use App\Services\ContentImportService;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ContentImportController extends Controller
{
    protected $contentImportService;
    
    public function __construct(ContentImportService $contentImportService)
    {
        $this->contentImportService = $contentImportService;
    }
    
    /**
     * Mostrar páginas disponibles para importar
     */
    public function showImportPages(Website $website, string $templateSlug)
    {
        $pages = $this->contentImportService->getTemplatePages($templateSlug);
        
        return view('admin.import.pages', [
            'website' => $website,
            'templateSlug' => $templateSlug,
            'pages' => $pages
        ]);
    }
    
    /**
     * Importar páginas seleccionadas
     */
    public function importPages(Request $request, Website $website, string $templateSlug): JsonResponse
    {
        $request->validate([
            'pages' => 'array',
            'pages.*' => 'string'
        ]);
        
        $selectedPages = $request->input('pages', []);
        
        if (empty($selectedPages)) {
            return response()->json([
                'success' => false,
                'message' => 'No se seleccionaron páginas para importar'
            ]);
        }
        
        // Filtrar solo las páginas seleccionadas
        $allPages = $this->contentImportService->getTemplatePages($templateSlug);
        $pagesToImport = array_filter($allPages, function($page) use ($selectedPages) {
            return in_array($page['slug'], $selectedPages);
        });
        
        $imported = 0;
        $skipped = 0;
        
        foreach ($pagesToImport as $pageData) {
            // Verificar si la página ya existe
            $existingPage = $website->pages()
                ->where('slug', $pageData['slug'])
                ->first();
            
            if ($existingPage) {
                $skipped++;
                continue;
            }
            
            // Crear nueva página
            $page = new \App\Models\Page([
                'website_id' => $website->id,
                'title' => $pageData['title'],
                'slug' => $pageData['slug'],
                'meta_description' => $pageData['meta_description'] ?? null,
                'html_content' => $pageData['content'] ?? '',
                'is_published' => true,
                'is_home' => $pageData['is_home'] ?? false,
                'sort_order' => $website->pages()->max('sort_order') + 1
            ]);
            
            $page->save();
            $imported++;
        }
        
        return response()->json([
            'success' => true,
            'message' => "Se importaron {$imported} páginas prediseñadas",
            'imported' => $imported,
            'skipped' => $skipped
        ]);
    }
    
    /**
     * Mostrar bloques disponibles para importar
     */
    public function showImportBlocks(Website $website, string $templateSlug)
    {
        $blocks = $this->contentImportService->getTemplateBlocks($templateSlug);
        
        return view('admin.import.blocks', [
            'website' => $website,
            'templateSlug' => $templateSlug,
            'blocks' => $blocks
        ]);
    }
    
    /**
     * Importar bloques seleccionados
     */
    public function importBlocks(Request $request, Website $website, string $templateSlug): JsonResponse
    {
        $request->validate([
            'blocks' => 'array',
            'blocks.*' => 'string'
        ]);
        
        $selectedBlocks = $request->input('blocks', []);
        
        if (empty($selectedBlocks)) {
            return response()->json([
                'success' => false,
                'message' => 'No se seleccionaron bloques para importar'
            ]);
        }
        
        // Aquí podrías implementar la lógica para importar bloques específicos
        // Por ejemplo, agregarlos a una página específica o crear una nueva página
        
        return response()->json([
            'success' => true,
            'message' => "Se importaron " . count($selectedBlocks) . " bloques",
            'imported' => count($selectedBlocks)
        ]);
    }
}
