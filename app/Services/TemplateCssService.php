<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class TemplateCssService
{
    /**
     * Obtiene la ruta del archivo CSS para una plantilla específica
     */
    public function getTemplateCssPath(string $templateSlug): string
    {
        return "views/templates/{$templateSlug}/styles.css";
    }

    /**
     * Verifica si existe un archivo CSS para la plantilla
     */
    public function hasTemplateCss(string $templateSlug): bool
    {
        $cssPath = resource_path($this->getTemplateCssPath($templateSlug));
        return File::exists($cssPath);
    }

    /**
     * Obtiene la URL pública del archivo CSS de la plantilla
     */
    public function getTemplateCssUrl(string $templateSlug): ?string
    {
        if (!$this->hasTemplateCss($templateSlug)) {
            return null;
        }

        // Para archivos CSS dentro de plantillas, usamos una ruta especial
        return route('template.css', ['template' => $templateSlug]);
    }

    /**
     * Obtiene el contenido del archivo CSS de la plantilla
     */
    public function getTemplateCssContent(string $templateSlug): ?string
    {
        if (!$this->hasTemplateCss($templateSlug)) {
            return null;
        }

        $cssPath = resource_path($this->getTemplateCssPath($templateSlug));
        return File::get($cssPath);
    }

    /**
     * Crea un archivo CSS para una plantilla
     */
    public function createTemplateCss(string $templateSlug, string $content): bool
    {
        $cssPath = resource_path($this->getTemplateCssPath($templateSlug));
        $directory = dirname($cssPath);

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        return File::put($cssPath, $content) !== false;
    }

    /**
     * Actualiza el contenido del archivo CSS de una plantilla
     */
    public function updateTemplateCss(string $templateSlug, string $content): bool
    {
        return $this->createTemplateCss($templateSlug, $content);
    }

    /**
     * Elimina el archivo CSS de una plantilla
     */
    public function deleteTemplateCss(string $templateSlug): bool
    {
        if (!$this->hasTemplateCss($templateSlug)) {
            return true;
        }

        $cssPath = resource_path($this->getTemplateCssPath($templateSlug));
        return File::delete($cssPath);
    }

    /**
     * Obtiene todas las plantillas que tienen archivos CSS
     */
    public function getTemplatesWithCss(): array
    {
        $templatesDir = resource_path('css/templates');
        
        if (!File::exists($templatesDir)) {
            return [];
        }

        $cssFiles = File::glob($templatesDir . '/*.css');
        $templates = [];

        foreach ($cssFiles as $cssFile) {
            $filename = basename($cssFile, '.css');
            $templates[] = [
                'slug' => $filename,
                'path' => $cssFile,
                'url' => asset("css/templates/{$filename}.css"),
                'size' => File::size($cssFile),
                'modified' => File::lastModified($cssFile)
            ];
        }

        return $templates;
    }

    /**
     * Genera CSS personalizado basado en la configuración de la plantilla
     */
    public function generateCustomCss(string $templateSlug, array $customization): string
    {
        $baseCss = $this->getTemplateCssContent($templateSlug) ?? '';
        
        // Variables CSS personalizadas
        $customVars = $this->generateCustomVariables($customization);
        
        // Combinar CSS base con variables personalizadas
        return $customVars . "\n\n" . $baseCss;
    }

    /**
     * Genera variables CSS personalizadas
     */
    private function generateCustomVariables(array $customization): string
    {
        $colors = $customization['colors'] ?? [];
        $fonts = $customization['fonts'] ?? [];
        $layout = $customization['layout'] ?? [];

        $css = ":root {\n";
        
        // Colores
        if (!empty($colors)) {
            foreach ($colors as $key => $value) {
                $css .= "    --custom-{$key}: {$value};\n";
            }
        }
        
        // Fuentes
        if (!empty($fonts)) {
            foreach ($fonts as $key => $value) {
                $css .= "    --custom-font-{$key}: {$value};\n";
            }
        }
        
        // Layout
        if (!empty($layout)) {
            foreach ($layout as $key => $value) {
                $css .= "    --custom-{$key}: {$value};\n";
            }
        }
        
        $css .= "}\n";
        
        return $css;
    }

    /**
     * Compila y optimiza el CSS de una plantilla
     */
    public function compileTemplateCss(string $templateSlug): string
    {
        $cssContent = $this->getTemplateCssContent($templateSlug);
        
        if (!$cssContent) {
            return '';
        }

        // Aquí se pueden agregar optimizaciones como:
        // - Minificación
        // - Compresión
        // - Optimización de selectores
        // - Eliminación de código no utilizado
        
        return $cssContent;
    }

    /**
     * Obtiene estadísticas de los archivos CSS de plantillas
     */
    public function getCssStats(): array
    {
        $templates = $this->getTemplatesWithCss();
        
        $totalFiles = count($templates);
        $totalSize = array_sum(array_column($templates, 'size'));
        $averageSize = $totalFiles > 0 ? $totalSize / $totalFiles : 0;
        
        return [
            'total_templates' => $totalFiles,
            'total_size' => $totalSize,
            'average_size' => round($averageSize),
            'templates' => $templates
        ];
    }
}
