<?php

namespace App\Helpers;

use App\Services\TemplateCssService;

class TemplateCssHelper
{
    protected static $templateCssService;

    /**
     * Obtiene la instancia del servicio
     */
    protected static function getService(): TemplateCssService
    {
        if (!self::$templateCssService) {
            self::$templateCssService = new TemplateCssService();
        }
        return self::$templateCssService;
    }

    /**
     * Genera el tag link para incluir el CSS de una plantilla
     */
    public static function cssLink(string $templateSlug): string
    {
        $cssUrl = self::getService()->getTemplateCssUrl($templateSlug);
        
        if (!$cssUrl) {
            return '';
        }

        return '<link rel="stylesheet" href="' . $cssUrl . '">';
    }

    /**
     * Genera el CSS inline para una plantilla
     */
    public static function cssInline(string $templateSlug): string
    {
        $cssContent = self::getService()->getTemplateCssContent($templateSlug);
        
        if (!$cssContent) {
            return '';
        }

        return '<style>' . $cssContent . '</style>';
    }

    /**
     * Genera CSS personalizado para una plantilla
     */
    public static function customCss(string $templateSlug, array $customization = []): string
    {
        $cssContent = self::getService()->generateCustomCss($templateSlug, $customization);
        
        if (!$cssContent) {
            return '';
        }

        return '<style>' . $cssContent . '</style>';
    }

    /**
     * Verifica si una plantilla tiene CSS
     */
    public static function hasCss(string $templateSlug): bool
    {
        return self::getService()->hasTemplateCss($templateSlug);
    }

    /**
     * Obtiene la URL del CSS de una plantilla
     */
    public static function cssUrl(string $templateSlug): ?string
    {
        return self::getService()->getTemplateCssUrl($templateSlug);
    }

    /**
     * Genera el CSS completo para una plantilla (base + personalizado)
     */
    public static function fullCss(string $templateSlug, array $customization = []): string
    {
        $baseCss = self::cssInline($templateSlug);
        $customCss = self::customCss($templateSlug, $customization);
        
        return $baseCss . $customCss;
    }

    /**
     * Genera clases CSS específicas para una plantilla
     */
    public static function templateClasses(string $templateSlug): string
    {
        $templateClass = str_replace('-', '_', $templateSlug) . '_template';
        return $templateClass;
    }

    /**
     * Genera el HTML completo para incluir CSS de plantilla
     */
    public static function renderCss(string $templateSlug, array $customization = [], bool $inline = false): string
    {
        if ($inline) {
            return self::fullCss($templateSlug, $customization);
        } else {
            $linkTag = self::cssLink($templateSlug);
            $customCss = self::customCss($templateSlug, $customization);
            return $linkTag . $customCss;
        }
    }

    /**
     * Obtiene estadísticas de CSS de plantillas
     */
    public static function getStats(): array
    {
        return self::getService()->getCssStats();
    }

    /**
     * Lista todas las plantillas con CSS
     */
    public static function getTemplatesWithCss(): array
    {
        return self::getService()->getTemplatesWithCss();
    }
}
