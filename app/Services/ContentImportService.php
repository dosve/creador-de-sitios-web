<?php

namespace App\Services;

use App\Models\Website;
use App\Models\Page;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ContentImportService
{
    /**
     * Importar páginas prediseñadas desde una plantilla
     */
    public function importTemplatePages(Website $website, string $templateSlug): array
    {
        try {
            $pagesArray = $this->loadTemplatePagesArray($templateSlug);
            if (empty($pagesArray)) {
                return [
                    'success' => false,
                    'message' => 'No hay páginas prediseñadas para esta plantilla',
                    'imported' => 0
                ];
            }
            
            $imported = 0;
            $skipped = 0;
            
            foreach ($pagesArray as $pageData) {
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
                    'meta_description' => $pageData['meta_description'] ?? null,
                    'html_content' => is_string($pageData['content'] ?? null) ? ($pageData['content'] ?? '') : $this->renderBladeIfExists($templateSlug, $pageData['slug']),
                    'is_published' => true,
                    'is_home' => $pageData['is_home'] ?? false,
                    'sort_order' => $website->pages()->max('sort_order') + 1
                ]);
                
                $page->save();
                $imported++;
            }
            
            return [
                'success' => true,
                'message' => "Se importaron {$imported} páginas prediseñadas",
                'imported' => $imported,
                'skipped' => $skipped
            ];
            
        } catch (\Exception $e) {
            Log::error("Error importando páginas: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error al importar páginas: ' . $e->getMessage(),
                'imported' => 0
            ];
        }
    }
    
    /**
     * Importar bloques/sections por defecto desde una plantilla
     */
    public function importTemplateBlocks(Website $website, string $templateSlug): array
    {
        $pagesFile = resource_path("views/templates/{$templateSlug}/pages.json");
        
        if (!File::exists($pagesFile)) {
            return [
                'success' => false,
                'message' => 'No hay bloques prediseñados para esta plantilla',
                'imported' => 0
            ];
        }
        
        try {
            $pagesData = json_decode(File::get($pagesFile), true);
            
            if (!isset($pagesData['pages'])) {
                return [
                    'success' => false,
                    'message' => 'Formato de archivo pages.json inválido',
                    'imported' => 0
                ];
            }
            
            $imported = 0;
            $blocks = [];
            
            // Extraer bloques de todas las páginas
            foreach ($pagesData['pages'] as $pageData) {
                if (isset($pageData['blocks']) && is_array($pageData['blocks'])) {
                    foreach ($pageData['blocks'] as $block) {
                        $blocks[] = [
                            'type' => $block['type'],
                            'data' => $block,
                            'source_page' => $pageData['title']
                        ];
                    }
                }
            }
            
            // Guardar bloques en la base de datos o en un archivo
            $blocksFile = storage_path("app/template-blocks-{$templateSlug}.json");
            File::put($blocksFile, json_encode($blocks, JSON_PRETTY_PRINT));
            
            return [
                'success' => true,
                'message' => "Se importaron " . count($blocks) . " bloques prediseñados",
                'imported' => count($blocks),
                'blocks' => $blocks
            ];
            
        } catch (\Exception $e) {
            Log::error("Error importando bloques: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error al importar bloques: ' . $e->getMessage(),
                'imported' => 0
            ];
        }
    }
    
    /**
     * Obtener páginas disponibles de una plantilla
     */
    public function getTemplatePages(string $templateSlug): array
    {
        // Intenta cargar desde pages.json o derivar de .blade.php
        return $this->loadTemplatePagesArray($templateSlug);
    }
    
    /**
     * Obtener bloques disponibles de una plantilla
     */
    public function getTemplateBlocks(string $templateSlug): array
    {
        $blocksFile = storage_path("app/template-blocks-{$templateSlug}.json");
        
        if (!File::exists($blocksFile)) {
            return [];
        }
        
        try {
            $blocksData = json_decode(File::get($blocksFile), true);
            return $blocksData ?? [];
        } catch (\Exception $e) {
            Log::error("Error leyendo bloques de plantilla: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Resolver pages.json desde múltiples ubicaciones y soportar arreglo plano o { pages: [...] }.
     * Si no existe, derivar páginas desde los .blade.php de creator/pages/templates/{template}.
     */
    private function loadTemplatePagesArray(string $templateSlug): array
    {
        $candidateFiles = [
            resource_path("views/creator/pages/templates/{$templateSlug}/pages.json"),
            resource_path("views/templates/{$templateSlug}/pages.json"),
        ];

        foreach ($candidateFiles as $pagesFile) {
            if (File::exists($pagesFile)) {
                try {
                    $pagesData = json_decode(File::get($pagesFile), true);
                    if (isset($pagesData['pages']) && is_array($pagesData['pages'])) {
                        return $pagesData['pages'];
                    }
                    if (is_array($pagesData)) {
                        return $pagesData;
                    }
                } catch (\Exception $e) {
                    Log::error("Error leyendo pages.json: " . $e->getMessage());
                }
            }
        }

        // Derivar desde archivos blade del catálogo Creator
        $dir = resource_path("views/creator/pages/templates/{$templateSlug}");
        if (!File::isDirectory($dir)) {
            return [];
        }

        $pages = [];
        foreach (File::files($dir) as $file) {
            $filename = $file->getFilename();
            if (!Str::endsWith($filename, '.blade.php')) {
                continue;
            }
            $slug = Str::replaceLast('.blade.php', '', $filename);
            $pages[] = [
                'title' => Str::title(str_replace('-', ' ', $slug)),
                'slug' => $slug,
                'is_home' => $slug === 'inicio',
                'meta_description' => null,
                // No incluimos 'content' aquí; se renderiza al importar
            ];
        }
        return $pages;
    }

    /**
     * Intentar renderizar un blade de creator/pages/templates/{template}/{slug}.blade.php
     */
    private function renderBladeIfExists(string $templateSlug, string $slug): string
    {
        $view = "creator.pages.templates.{$templateSlug}.{$slug}";
        try {
            if (view()->exists($view)) {
                return view($view)->render();
            }
        } catch (\Throwable $e) {
            Log::warning('Render blade falló: ' . $e->getMessage());
        }
        return '';
    }
}
