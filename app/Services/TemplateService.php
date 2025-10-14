<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Collection;

class TemplateService
{
    protected $templatesPath;

    public function __construct()
    {
        $this->templatesPath = resource_path('views/templates');
    }

    /**
     * Obtener todas las plantillas
     */
    public function all(): Collection
    {
        $templates = collect();
        
        if (!File::exists($this->templatesPath)) {
            return $templates;
        }

        $directories = File::directories($this->templatesPath);

        foreach ($directories as $dir) {
            $template = $this->loadTemplate(basename($dir));
            if ($template) {
                $templates->push($template);
            }
        }

        return $templates;
    }

    /**
     * Obtener plantillas activas
     */
    public function active(): Collection
    {
        return $this->all()->filter(function ($template) {
            return $template['is_active'] ?? true;
        });
    }

    /**
     * Obtener plantilla por slug
     */
    public function find(string $slug): ?array
    {
        return $this->loadTemplate($slug);
    }

    /**
     * Cargar una plantilla específica
     */
    protected function loadTemplate(string $slug): ?array
    {
        $templateDir = $this->templatesPath . '/' . $slug;
        $configFile = $templateDir . '/config.json';
        $templateFile = $templateDir . '/template.blade.php';

        if (!File::exists($configFile) || !File::exists($templateFile)) {
            return null;
        }

        $config = json_decode(File::get($configFile), true);
        $content = File::get($templateFile);

        if (!$config) {
            return null;
        }

        return array_merge($config, [
            'html_content' => $content,
            'css_content' => '', // CSS está en Tailwind
            'preview_image_url' => $this->getPreviewImageUrl($slug, $config['preview_image'] ?? null),
            'created_at' => File::lastModified($configFile),
            'template_dir' => $templateDir,
        ]);
    }
    
    /**
     * Obtener template específico por tipo (home, page, blog, etc)
     */
    public function getTemplateFile(string $slug, string $type = 'home'): ?string
    {
        $template = $this->find($slug);
        
        if (!$template) {
            return null;
        }
        
        $templates = $template['templates'] ?? [];
        $templateFile = $templates[$type] ?? $templates['home'] ?? 'template.blade.php';
        
        $fullPath = $this->templatesPath . '/' . $slug . '/' . $templateFile;
        
        if (File::exists($fullPath)) {
            return File::get($fullPath);
        }
        
        return null;
    }

    /**
     * Obtener URL de imagen de preview
     */
    protected function getPreviewImageUrl(string $slug, ?string $previewImage): ?string
    {
        if (!$previewImage) {
            return null;
        }

        $imagePath = $this->templatesPath . '/' . $slug . '/' . $previewImage;
        
        if (File::exists($imagePath)) {
            return asset('templates/' . $slug . '/' . $previewImage);
        }

        return null;
    }

    /**
     * Agrupar plantillas por categoría
     */
    public function groupByCategory(): Collection
    {
        return $this->all()->groupBy('category');
    }

    /**
     * Obtener categorías disponibles
     */
    public function getCategories(): array
    {
        return [
            'basic' => 'Básico',
            'business' => 'Negocios',
            'portfolio' => 'Portafolio',
            'blog' => 'Blog',
            'ecommerce' => 'E-commerce',
            'landing' => 'Landing Page',
            'corporate' => 'Corporativo',
        ];
    }
}

