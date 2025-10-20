<?php

namespace App\Services;

use App\Models\Website;
use App\Models\Page;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class TemplatePageService
{
    /**
     * Importar páginas prediseñadas de una plantilla
     */
    public function importTemplatePages(Website $website, string $templateSlug): array
    {
        $pagesFile = resource_path("views/templates/{$templateSlug}/pages.json");
        
        if (!File::exists($pagesFile)) {
            Log::info("No se encontró archivo pages.json para la plantilla: {$templateSlug}");
            return [
                'success' => false,
                'message' => 'No hay páginas prediseñadas para esta plantilla',
                'imported' => 0
            ];
        }
        
        try {
            $pagesData = json_decode(File::get($pagesFile), true);
            
            if (!isset($pagesData['pages']) || !is_array($pagesData['pages'])) {
                return [
                    'success' => false,
                    'message' => 'Formato de archivo pages.json inválido',
                    'imported' => 0
                ];
            }
            
            $imported = 0;
            $skipped = 0;
            
            foreach ($pagesData['pages'] as $index => $pageData) {
                // Verificar si la página ya existe
                $existingPage = $website->pages()
                    ->where('slug', $pageData['slug'])
                    ->first();
                
                if ($existingPage) {
                    $skipped++;
                    continue; // No sobrescribir páginas existentes
                }
                
                // Crear la página
                $website->pages()->create([
                    'title' => $pageData['title'],
                    'slug' => $pageData['slug'],
                    'content' => $pageData['content'] ?? '',
                    'blocks' => json_encode($pageData['blocks'] ?? []),
                    'is_home' => $pageData['is_home'] ?? false,
                    'is_published' => true,
                    'sort_order' => $index,
                    'meta_title' => $pageData['meta_title'] ?? $pageData['title'],
                    'meta_description' => $pageData['meta_description'] ?? '',
                ]);
                
                $imported++;
            }
            
            Log::info("Páginas importadas para {$website->name}: {$imported} importadas, {$skipped} omitidas");
            
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
     * Obtener páginas disponibles de una plantilla
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
     * Verificar si una plantilla tiene páginas prediseñadas
     */
    public function hasTemplatePages(string $templateSlug): bool
    {
        $pagesFile = resource_path("views/templates/{$templateSlug}/pages.json");
        return File::exists($pagesFile);
    }
    
    /**
     * Contar páginas disponibles en una plantilla
     */
    public function countTemplatePages(string $templateSlug): int
    {
        $pages = $this->getTemplatePages($templateSlug);
        return count($pages);
    }
    
    /**
     * Actualizar páginas existentes con contenido de plantilla (opcional)
     */
    public function updateExistingPages(Website $website, string $templateSlug, bool $overwrite = false): array
    {
        $pagesFile = resource_path("views/templates/{$templateSlug}/pages.json");
        
        if (!File::exists($pagesFile)) {
            return [
                'success' => false,
                'message' => 'No hay páginas prediseñadas para esta plantilla',
                'updated' => 0
            ];
        }
        
        try {
            $pagesData = json_decode(File::get($pagesFile), true);
            
            if (!isset($pagesData['pages'])) {
                return [
                    'success' => false,
                    'message' => 'Formato de archivo pages.json inválido',
                    'updated' => 0
                ];
            }
            
            $updated = 0;
            
            foreach ($pagesData['pages'] as $pageData) {
                $existingPage = $website->pages()
                    ->where('slug', $pageData['slug'])
                    ->first();
                
                if ($existingPage && $overwrite) {
                    $existingPage->update([
                        'content' => $pageData['content'] ?? $existingPage->content,
                        'blocks' => json_encode($pageData['blocks'] ?? []),
                    ]);
                    $updated++;
                }
            }
            
            return [
                'success' => true,
                'message' => "Se actualizaron {$updated} páginas",
                'updated' => $updated
            ];
            
        } catch (\Exception $e) {
            Log::error("Error actualizando páginas: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error al actualizar páginas: ' . $e->getMessage(),
                'updated' => 0
            ];
        }
    }
}


