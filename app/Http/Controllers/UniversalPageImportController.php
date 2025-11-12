<?php

namespace App\Http\Controllers;

use App\Services\UniversalPageImportService;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UniversalPageImportController extends Controller
{
    protected $importService;
    
    public function __construct(UniversalPageImportService $importService)
    {
        $this->importService = $importService;
    }
    
    /**
     * Mostrar categorías de sitios web disponibles
     */
    public function showCategories(Website $website)
    {
        $categories = $this->importService->getCategories();
        
        return view('creator.pages.import-categories', [
            'website' => $website,
            'categories' => $categories
        ]);
    }
    
    /**
     * Mostrar páginas disponibles para una categoría
     */
    public function showPagesForCategory(Website $website, string $category)
    {
        $categoryData = $this->importService->getPagesForCategory($category);
        $templates = $this->importService->getTemplatesForCategory($category);
        
        if (empty($categoryData)) {
            return redirect()->back()
                ->with('error', 'Categoría no encontrada');
        }
        
        return view('creator.pages.import-pages', [
            'website' => $website,
            'category' => $category,
            'categoryData' => $categoryData,
            'templates' => $templates
        ]);
    }
    
    /**
     * Mostrar páginas de una plantilla específica
     */
    public function showTemplatePages(Website $website, string $templateSlug)
    {
        $pages = $this->importService->getTemplatePages($templateSlug);
        
        if (empty($pages)) {
            return redirect()->back()
                ->with('error', 'No hay páginas disponibles para esta plantilla');
        }
        
        return view('creator.pages.import-template-pages', [
            'website' => $website,
            'templateSlug' => $templateSlug,
            'pages' => $pages
        ]);
    }
    
    /**
     * Importar páginas seleccionadas
     */
    public function importPages(Request $request, Website $website): JsonResponse
    {
        $request->validate([
            'pages' => 'required|array',
            'pages.*' => 'string',
            'template_slug' => 'nullable|string'
        ]);
        
        $selectedPages = $request->input('pages', []);
        $templateSlug = $request->input('template_slug');
        
        if (empty($selectedPages)) {
            return response()->json([
                'success' => false,
                'message' => 'No se seleccionaron páginas para importar'
            ]);
        }
        
        $result = $this->importService->importSelectedPages(
            $website, 
            $selectedPages, 
            $templateSlug
        );
        
        return response()->json($result);
    }
    
    /**
     * Obtener páginas recomendadas para una categoría (AJAX)
     */
    public function getRecommendedPages(string $category): JsonResponse
    {
        $pages = $this->importService->getRecommendedPages($category);
        
        return response()->json([
            'success' => true,
            'pages' => $pages
        ]);
    }
    
    /**
     * Obtener plantillas para una categoría (AJAX)
     */
    public function getTemplatesForCategory(string $category): JsonResponse
    {
        $templates = $this->importService->getTemplatesForCategory($category);
        
        return response()->json([
            'success' => true,
            'templates' => $templates
        ]);
    }
    
    /**
     * Obtener páginas de una plantilla específica (AJAX)
     */
    public function getTemplatePages(string $templateSlug): JsonResponse
    {
        $pages = $this->importService->getTemplatePages($templateSlug);
        
        return response()->json([
            'success' => true,
            'pages' => $pages
        ]);
    }
    
    /**
     * Mostrar vista previa de una página específica
     */
    public function previewPage(Website $website, string $pageSlug, string $templateSlug = null)
    {
        $pageData = null;
        
        if ($templateSlug) {
            // Obtener página de plantilla específica
            $templatePages = $this->importService->getTemplatePages($templateSlug);
            $pageData = collect($templatePages)->firstWhere('slug', $pageSlug);
        } else {
            // Crear página básica
            $pageData = $this->importService->createBasicPageData($pageSlug);
        }
        
        if (!$pageData) {
            abort(404, 'Página no encontrada');
        }
        
        return view('creator.pages.preview', [
            'website' => $website,
            'pageData' => $pageData,
            'templateSlug' => $templateSlug
        ]);
    }
    
    /**
     * Obtener datos de vista previa (AJAX)
     */
    public function getPreviewData(string $pageSlug, string $templateSlug = null): JsonResponse
    {
        $pageData = null;

        if ($templateSlug) {
            $templatePages = $this->importService->getTemplatePages($templateSlug);
            $pageData = collect($templatePages)->firstWhere('slug', $pageSlug);
        } else {
            $pageData = $this->importService->createBasicPageData($pageSlug);
        }

        if (!$pageData) {
            return response()->json([
                'success' => false,
                'message' => 'Página no encontrada'
            ]);
        }

        return response()->json([
            'success' => true,
            'pageData' => $pageData
        ]);
    }

    /**
     * Obtener todas las páginas disponibles para el modal de navegación
     */
    public function getAllAvailablePages(): JsonResponse
    {
        try {
            $allPages = [];
            $categories = $this->importService->getCategories();

            foreach ($categories as $categoryKey => $categoryData) {
                // Páginas comunes
                foreach ($categoryData['common_pages'] as $slug => $description) {
                    $allPages[] = [
                        'slug' => $slug,
                        'title' => ucfirst(str_replace('-', ' ', $slug)),
                        'description' => $description,
                        'category' => $categoryKey,
                        'type' => 'common',
                        'category_name' => $categoryData['name']
                    ];
                }

                // Páginas especializadas
                foreach ($categoryData['specialized_pages'] as $slug => $description) {
                    $allPages[] = [
                        'slug' => $slug,
                        'title' => ucfirst(str_replace('-', ' ', $slug)),
                        'description' => $description,
                        'category' => $categoryKey,
                        'type' => 'specialized',
                        'category_name' => $categoryData['name']
                    ];
                }
            }

            return response()->json([
                'success' => true,
                'pages' => $allPages,
                'total' => count($allPages)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar las páginas: ' . $e->getMessage()
            ], 500);
        }
    }
}
