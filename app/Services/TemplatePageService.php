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
                
                // Generar HTML de los bloques
                $htmlContent = $this->renderBlocksToHtml($pageData['blocks'] ?? [], $templateSlug);
                
                // Si no hay bloques, usar el content simple
                if (empty($htmlContent)) {
                    $htmlContent = $pageData['content'] ?? '';
                }
                
                // Crear la página
                $website->pages()->create([
                    'title' => $pageData['title'],
                    'slug' => $pageData['slug'],
                    'content' => $pageData['content'] ?? '',
                    'html_content' => $htmlContent,
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
                    // Generar HTML de los bloques
                    $htmlContent = $this->renderBlocksToHtml($pageData['blocks'] ?? [], $templateSlug);
                    
                    // Si no hay bloques, usar el content simple
                    if (empty($htmlContent)) {
                        $htmlContent = $pageData['content'] ?? $existingPage->html_content;
                    }
                    
                    $existingPage->update([
                        'content' => $pageData['content'] ?? $existingPage->content,
                        'html_content' => $htmlContent,
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
    
    /**
     * Convertir bloques a HTML según el tipo de plantilla
     */
    public function renderBlocksToHtml(array $blocks, string $templateSlug): string
    {
        if (empty($blocks)) {
            return '';
        }
        
        $html = '';
        
        foreach ($blocks as $block) {
            $type = $block['type'] ?? '';
            $html .= $this->renderBlock($type, $block, $templateSlug);
        }
        
        return $html;
    }
    
    /**
     * Renderizar un bloque individual según su tipo
     */
    protected function renderBlock(string $type, array $block, string $templateSlug): string
    {
        switch ($type) {
            case 'hero':
                return $this->renderHeroBlock($block);
            case 'about':
                return $this->renderAboutBlock($block);
            case 'services':
                return $this->renderServicesBlock($block);
            case 'technologies':
                return $this->renderTechnologiesBlock($block);
            case 'projects':
                return $this->renderProjectsBlock($block);
            case 'values':
                return $this->renderValuesBlock($block);
            case 'why_choose_us':
                return $this->renderWhyChooseUsBlock($block);
            case 'cta':
                return $this->renderCtaBlock($block);
            case 'page_header':
                return $this->renderPageHeaderBlock($block);
            case 'services_detailed':
                return $this->renderServicesDetailedBlock($block);
            case 'projects_grid':
                return $this->renderProjectsGridBlock($block);
            case 'contact_form':
                return $this->renderContactFormBlock($block);
            case 'contact_info':
                return $this->renderContactInfoBlock($block);
            default:
                return '';
        }
    }
    
    protected function renderHeroBlock(array $block): string
    {
        $title = $block['title'] ?? '';
        $subtitle = $block['subtitle'] ?? '';
        $ctaPrimary = $block['cta_primary_text'] ?? '';
        $ctaPrimaryLink = $block['cta_primary_link'] ?? '#';
        $ctaSecondary = $block['cta_secondary_text'] ?? '';
        $ctaSecondaryLink = $block['cta_secondary_link'] ?? '#';
        
        return <<<HTML
<section class="bg-gradient-to-br from-blue-50 to-blue-100 py-20">
    <div class="container px-4 sm:px-6 lg:px-8 mx-auto">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 mb-6 font-heading">{$title}</h1>
                <p class="text-xl text-gray-600 mb-8">{$subtitle}</p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{$ctaPrimaryLink}" class="px-8 py-4 rounded-lg font-medium transition-colors text-center text-white hover:opacity-90" style="background-color: {$this->getTemplateColor('primary')};">
                        {$ctaPrimary}
                    </a>
                    <a href="{$ctaSecondaryLink}" class="px-8 py-4 border-2 rounded-lg font-medium transition-colors text-center" style="border-color: {$this->getTemplateColor('primary')}; color: {$this->getTemplateColor('primary')};" onmouseover="this.style.backgroundColor='{$this->getTemplateColor('primary')}'; this.style.color='white';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='{$this->getTemplateColor('primary')}';">
                        {$ctaSecondary}
                    </a>
                </div>
            </div>
            <div class="relative">
                <div class="bg-white rounded-2xl shadow-2xl p-8">
                    <div class="text-center">
                        <div class="w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6" style="background-color: {$this->getTemplateColor('primary')}; opacity: 0.1;">
                            <svg class="w-12 h-12" style="color: {$this->getTemplateColor('primary')};" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4 font-heading">Más de 10 años</h3>
                        <p class="text-gray-600 mb-6">Desarrollando soluciones digitales para empresas e instituciones de la región y del país</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
HTML;
    }
    
    protected function renderAboutBlock(array $block): string
    {
        $title = $block['title'] ?? '';
        $subtitle = $block['subtitle'] ?? '';
        $description = $block['description'] ?? '';
        $milestones = $block['milestones'] ?? [];
        $mission = $block['mission'] ?? '';
        $vision = $block['vision'] ?? '';
        
        $milestonesHtml = '';
        if (!empty($milestones)) {
            $milestonesHtml = '<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-8">';
            foreach ($milestones as $milestone) {
                $year = $milestone['year'] ?? '';
                $desc = $milestone['description'] ?? '';
                $milestonesHtml .= <<<HTML
<div class="text-center">
    <div class="text-2xl font-bold mb-2" style="color: {$this->getTemplateColor('primary')}">{$year}</div>
    <div class="text-sm text-gray-500">{$desc}</div>
</div>
HTML;
            }
            $milestonesHtml .= '</div>';
        }
        
        $missionVisionHtml = '';
        if ($mission || $vision) {
            $missionVisionHtml = '<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">';
            if ($mission) {
                $missionVisionHtml .= <<<HTML
<div class="bg-blue-50 p-6 rounded-lg">
    <h4 class="font-bold text-gray-900 mb-3">Misión</h4>
    <p class="text-gray-600 text-sm">{$mission}</p>
</div>
HTML;
            }
            if ($vision) {
                $missionVisionHtml .= <<<HTML
<div class="bg-blue-50 p-6 rounded-lg">
    <h4 class="font-bold text-gray-900 mb-3">Visión</h4>
    <p class="text-gray-600 text-sm">{$vision}</p>
</div>
HTML;
            }
            $missionVisionHtml .= '</div>';
        }
        
        return <<<HTML
<section class="py-20 bg-white">
    <div class="container px-4 sm:px-6 lg:px-8 mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6 font-heading">{$title}</h2>
            <div class="w-24 h-1 mx-auto mb-8" style="background-color: {$this->getTemplateColor('primary')}"></div>
        </div>
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <h3 class="text-2xl font-bold text-gray-900 mb-6 font-heading">{$subtitle}</h3>
                <p class="text-gray-600 mb-6 leading-relaxed">{$description}</p>
                {$milestonesHtml}
            </div>
            <div>
                {$missionVisionHtml}
            </div>
        </div>
    </div>
</section>
HTML;
    }
    
    protected function getTemplateColor(string $colorName): string
    {
        return match($colorName) {
            'primary' => '#2563EB',
            'secondary' => '#1E40AF',
            'accent' => '#F59E0B',
            default => '#2563EB'
        };
    }
    
    protected function renderServicesBlock(array $block): string
    {
        $title = $block['title'] ?? '';
        $subtitle = $block['subtitle'] ?? '';
        $items = $block['items'] ?? [];
        
        $itemsHtml = '';
        foreach ($items as $item) {
            $itemTitle = $item['title'] ?? '';
            $itemDesc = $item['description'] ?? '';
            $itemsHtml .= <<<HTML
<div class="bg-white p-8 rounded-lg shadow-lg text-center hover:shadow-xl transition-shadow">
    <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6" style="background-color: {$this->getTemplateColor('primary')}; opacity: 0.1;">
        <svg class="w-8 h-8" style="color: {$this->getTemplateColor('primary')};" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
        </svg>
    </div>
    <h3 class="text-xl font-bold text-gray-900 mb-4 font-heading">{$itemTitle}</h3>
    <p class="text-gray-600">{$itemDesc}</p>
</div>
HTML;
        }
        
        return <<<HTML
<section class="py-20 bg-gray-50">
    <div class="container px-4 sm:px-6 lg:px-8 mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6 font-heading">{$title}</h2>
            <div class="w-24 h-1 mx-auto mb-8" style="background-color: {$this->getTemplateColor('primary')}"></div>
            <p class="text-xl text-gray-600">{$subtitle}</p>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            {$itemsHtml}
        </div>
    </div>
</section>
HTML;
    }
    
    protected function renderTechnologiesBlock(array $block): string
    {
        $title = $block['title'] ?? '';
        $items = $block['items'] ?? [];
        
        $itemsHtml = '';
        foreach ($items as $item) {
            $name = $item['name'] ?? '';
            $itemsHtml .= <<<HTML
<div class="bg-white px-6 py-4 rounded-lg shadow-sm text-center font-medium text-gray-700">
    {$name}
</div>
HTML;
        }
        
        return <<<HTML
<section class="py-16 bg-white">
    <div class="container px-6 mx-auto">
        <h2 class="text-4xl font-bold text-center mb-12 text-gray-900">{$title}</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-4">
            {$itemsHtml}
        </div>
    </div>
</section>
HTML;
    }
    
    protected function renderProjectsBlock(array $block): string
    {
        $title = $block['title'] ?? '';
        $subtitle = $block['subtitle'] ?? '';
        $items = $block['items'] ?? [];
        
        $itemsHtml = '';
        $index = 1;
        foreach ($items as $item) {
            $itemTitle = $item['title'] ?? '';
            $itemDesc = $item['description'] ?? '';
            $itemsHtml .= <<<HTML
<div class="bg-white rounded-lg shadow-lg overflow-hidden">
    <div class="p-8">
        <div class="flex items-center mb-6">
            <div class="w-16 h-16 rounded-full flex items-center justify-center mr-4" style="background-color: {$this->getTemplateColor('primary')};">
                <span class="text-white font-bold text-xl">{$index}</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 font-heading">{$itemTitle}</h3>
        </div>
        <p class="text-gray-600 mb-6 leading-relaxed">{$itemDesc}</p>
    </div>
</div>
HTML;
            $index++;
        }
        
        return <<<HTML
<section class="py-20 bg-gray-50">
    <div class="container px-4 sm:px-6 lg:px-8 mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6 font-heading">{$title}</h2>
            <div class="w-24 h-1 mx-auto mb-8" style="background-color: {$this->getTemplateColor('primary')}"></div>
            <p class="text-xl text-gray-600">{$subtitle}</p>
        </div>
        <div class="grid md:grid-cols-2 gap-8">
            {$itemsHtml}
        </div>
    </div>
</section>
HTML;
    }
    
    protected function renderValuesBlock(array $block): string
    {
        $title = $block['title'] ?? '';
        $subtitle = $block['subtitle'] ?? '';
        $items = $block['items'] ?? [];
        
        $itemsHtml = '';
        foreach ($items as $item) {
            $itemTitle = $item['title'] ?? '';
            $itemDesc = $item['description'] ?? '';
            $itemsHtml .= <<<HTML
<div class="text-center">
    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
        <svg class="w-8 h-8" style="color: {$this->getTemplateColor('primary')};" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
    </div>
    <h3 class="text-xl font-bold text-gray-900 mb-4 font-heading">{$itemTitle}</h3>
    <p class="text-gray-600">{$itemDesc}</p>
</div>
HTML;
        }
        
        $subtitleHtml = $subtitle ? '<p class="text-lg text-gray-600 max-w-3xl mx-auto mb-12 text-center">' . $subtitle . '</p>' : '';
        
        return <<<HTML
<section class="py-20 bg-white">
    <div class="container px-4 sm:px-6 lg:px-8 mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6 font-heading">{$title}</h2>
            <div class="w-24 h-1 mx-auto mb-8" style="background-color: {$this->getTemplateColor('primary')}"></div>
            {$subtitleHtml}
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            {$itemsHtml}
        </div>
    </div>
</section>
HTML;
    }
    
    protected function renderWhyChooseUsBlock(array $block): string
    {
        $title = $block['title'] ?? '';
        $subtitle = $block['subtitle'] ?? '';
        $description = $block['description'] ?? '';
        $items = $block['items'] ?? [];
        
        $itemsHtml = '';
        foreach ($items as $item) {
            $itemTitle = $item['title'] ?? '';
            $itemDesc = $item['description'] ?? '';
            $itemsHtml .= <<<HTML
<div class="bg-white p-8 rounded-lg shadow-lg">
    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-6">
        <svg class="w-8 h-8" style="color: {$this->getTemplateColor('primary')};" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
    </div>
    <h3 class="text-xl font-bold text-gray-900 mb-4 font-heading">{$itemTitle}</h3>
    <p class="text-gray-600">{$itemDesc}</p>
</div>
HTML;
        }
        
        $headerHtml = '';
        if ($subtitle || $description) {
            $headerHtml = '<div class="text-center mb-12">';
            if ($subtitle) {
                $headerHtml .= '<h3 class="text-2xl font-bold text-gray-900 mb-4 font-heading">' . $subtitle . '</h3>';
            }
            if ($description) {
                $headerHtml .= '<p class="text-lg text-gray-600 max-w-3xl mx-auto">' . $description . '</p>';
            }
            $headerHtml .= '</div>';
        }
        
        return <<<HTML
<section class="py-20 bg-gray-50">
    <div class="container px-4 sm:px-6 lg:px-8 mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6 font-heading">{$title}</h2>
            <div class="w-24 h-1 mx-auto mb-8" style="background-color: {$this->getTemplateColor('primary')}"></div>
        </div>
        {$headerHtml}
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            {$itemsHtml}
        </div>
    </div>
</section>
HTML;
    }
    
    protected function renderCtaBlock(array $block): string
    {
        $title = $block['title'] ?? '';
        $description = $block['description'] ?? '';
        $ctaText = $block['cta_text'] ?? '';
        $ctaLink = $block['cta_link'] ?? '#';
        
        return <<<HTML
<section class="py-20 text-white" style="background-color: {$this->getTemplateColor('primary')};">
    <div class="container px-4 sm:px-6 lg:px-8 mx-auto text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6 font-heading">{$title}</h2>
        <p class="text-xl mb-8 max-w-3xl mx-auto opacity-90 leading-relaxed">{$description}</p>
        <a href="{$ctaLink}" class="inline-block px-8 py-4 bg-white rounded-lg font-medium hover:bg-gray-100 transition-colors" style="color: {$this->getTemplateColor('primary')};">
            {$ctaText}
        </a>
    </div>
</section>
HTML;
    }
    
    protected function renderPageHeaderBlock(array $block): string
    {
        $title = $block['title'] ?? '';
        $subtitle = $block['subtitle'] ?? '';
        $description = $block['description'] ?? '';
        
        return <<<HTML
<section class="py-20 bg-gradient-to-r from-blue-600 to-blue-800 text-white">
    <div class="container px-6 mx-auto text-center">
        <h1 class="text-5xl md:text-6xl font-bold mb-4">{$title}</h1>
        <p class="text-xl md:text-2xl mb-6">{$subtitle}</p>
        <p class="text-lg max-w-3xl mx-auto opacity-90">{$description}</p>
    </div>
</section>
HTML;
    }
    
    protected function renderServicesDetailedBlock(array $block): string
    {
        $items = $block['items'] ?? [];
        
        $itemsHtml = '';
        foreach ($items as $item) {
            $itemTitle = $item['title'] ?? '';
            $itemDesc = $item['description'] ?? '';
            $features = $item['features'] ?? [];
            
            $featuresHtml = '';
            foreach ($features as $feature) {
                $featuresHtml .= "<li class=\"flex items-center text-gray-600\"><span class=\"mr-2 text-blue-600\">✓</span>{$feature}</li>";
            }
            
            $itemsHtml .= <<<HTML
<div class="bg-white p-8 rounded-lg shadow-md">
    <h3 class="text-2xl font-semibold mb-4 text-gray-900">{$itemTitle}</h3>
    <p class="text-gray-600 mb-4">{$itemDesc}</p>
    <ul class="space-y-2">
        {$featuresHtml}
    </ul>
</div>
HTML;
        }
        
        return <<<HTML
<section class="py-16 bg-gray-50">
    <div class="container px-6 mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            {$itemsHtml}
        </div>
    </div>
</section>
HTML;
    }
    
    protected function renderProjectsGridBlock(array $block): string
    {
        $items = $block['items'] ?? [];
        
        $itemsHtml = '';
        foreach ($items as $item) {
            $itemTitle = $item['title'] ?? '';
            $itemDesc = $item['description'] ?? '';
            $technologies = $item['technologies'] ?? [];
            
            $techHtml = '';
            foreach ($technologies as $tech) {
                $techHtml .= "<span class=\"px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm mr-2\">{$tech}</span>";
            }
            
            $itemsHtml .= <<<HTML
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="h-48 bg-gray-200"></div>
    <div class="p-6">
        <h3 class="text-xl font-semibold mb-2 text-gray-900">{$itemTitle}</h3>
        <p class="text-gray-600 mb-4">{$itemDesc}</p>
        <div class="flex flex-wrap">
            {$techHtml}
        </div>
    </div>
</div>
HTML;
        }
        
        return <<<HTML
<section class="py-16 bg-white">
    <div class="container px-6 mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            {$itemsHtml}
        </div>
    </div>
</section>
HTML;
    }
    
    protected function renderContactFormBlock(array $block): string
    {
        $submitText = $block['submit_text'] ?? 'Enviar Mensaje';
        
        return <<<HTML
<section class="py-16 bg-white">
    <div class="container px-6 mx-auto">
        <div class="max-w-2xl mx-auto">
            <form class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nombre</label>
                    <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Mensaje</label>
                    <textarea rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required></textarea>
                </div>
                <button type="submit" class="w-full px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                    {$submitText}
                </button>
            </form>
        </div>
    </div>
</section>
HTML;
    }
    
    protected function renderContactInfoBlock(array $block): string
    {
        $email = $block['email'] ?? '';
        $phone = $block['phone'] ?? '';
        $address = $block['address'] ?? '';
        $website = $block['website'] ?? '';
        
        return <<<HTML
<section class="py-16 bg-gray-50">
    <div class="container px-6 mx-auto">
        <div class="max-w-2xl mx-auto space-y-4">
            <div class="flex items-center">
                <span class="text-blue-600 font-semibold mr-3">Email:</span>
                <a href="mailto:{$email}" class="text-gray-700 hover:text-blue-600">{$email}</a>
            </div>
            <div class="flex items-center">
                <span class="text-blue-600 font-semibold mr-3">Teléfono:</span>
                <a href="tel:{$phone}" class="text-gray-700 hover:text-blue-600">{$phone}</a>
            </div>
            <div class="flex items-center">
                <span class="text-blue-600 font-semibold mr-3">Dirección:</span>
                <span class="text-gray-700">{$address}</span>
            </div>
            <div class="flex items-center">
                <span class="text-blue-600 font-semibold mr-3">Sitio web:</span>
                <a href="https://{$website}" target="_blank" class="text-gray-700 hover:text-blue-600">{$website}</a>
            </div>
        </div>
    </div>
</section>
HTML;
    }
}


