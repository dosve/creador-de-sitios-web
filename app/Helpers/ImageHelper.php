<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Exception;

class ImageHelper
{
    /**
     * Verifica si una imagen existe y es accesible
     *
     * @param string|null $imageUrl
     * @param int $timeout Segundos de timeout
     * @return bool
     */
    public static function exists($imageUrl, $timeout = 5)
    {
        if (empty($imageUrl)) {
            return false;
        }

        try {
            $response = Http::timeout($timeout)->head($imageUrl);
            return $response->successful();
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Verifica si una imagen existe y retorna la URL o un placeholder
     *
     * @param string|null $imageUrl
     * @param string|null $placeholderUrl URL del placeholder personalizado
     * @param int $timeout Segundos de timeout
     * @return string
     */
    public static function getValidImageUrl($imageUrl, $placeholderUrl = null, $timeout = 5)
    {
        if (self::exists($imageUrl, $timeout)) {
            return $imageUrl;
        }

        return $placeholderUrl ?: self::getDefaultPlaceholder();
    }

    /**
     * Retorna un placeholder SVG por defecto
     *
     * @return string
     */
    public static function getDefaultPlaceholder()
    {
        return 'data:image/svg+xml;base64,' . base64_encode('
            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
        ');
    }

    /**
     * Genera el HTML completo para una imagen con fallback
     *
     * @param string|null $imageUrl
     * @param string $alt Alt text para la imagen
     * @param string $cssClasses Clases CSS para la imagen
     * @param string|null $placeholderUrl URL del placeholder personalizado
     * @param int $timeout Segundos de timeout
     * @return string
     */
    public static function renderImageWithFallback($imageUrl, $alt = '', $cssClasses = '', $placeholderUrl = null, $timeout = 5)
    {
        $validUrl = self::getValidImageUrl($imageUrl, $placeholderUrl, $timeout);
        
        if ($validUrl === $imageUrl) {
            // La imagen original es válida
            return sprintf(
                '<img src="%s" alt="%s" class="%s" onerror="this.onerror=null; this.src=\'%s\'">',
                htmlspecialchars($imageUrl),
                htmlspecialchars($alt),
                htmlspecialchars($cssClasses),
                htmlspecialchars($placeholderUrl ?: self::getDefaultPlaceholder())
            );
        } else {
            // Usar placeholder directamente
            return sprintf(
                '<img src="%s" alt="%s" class="%s">',
                htmlspecialchars($validUrl),
                htmlspecialchars($alt),
                htmlspecialchars($cssClasses)
            );
        }
    }

    /**
     * Genera el HTML para un contenedor de imagen con placeholder SVG
     *
     * @param string|null $imageUrl
     * @param string $alt Alt text para la imagen
     * @param string $containerClasses Clases CSS para el contenedor
     * @param string $imageClasses Clases CSS para la imagen
     * @param int $timeout Segundos de timeout
     * @return string
     */
    public static function renderImageContainer($imageUrl, $alt = '', $containerClasses = '', $imageClasses = '', $timeout = 5)
    {
        if (self::exists($imageUrl, $timeout)) {
            return sprintf(
                '<div class="%s">
                    <img src="%s" alt="%s" class="%s" onerror="this.parentElement.innerHTML=\'%s\'">
                </div>',
                htmlspecialchars($containerClasses),
                htmlspecialchars($imageUrl),
                htmlspecialchars($alt),
                htmlspecialchars($imageClasses),
                htmlspecialchars(self::getSvgPlaceholder())
            );
        } else {
            return sprintf(
                '<div class="%s">%s</div>',
                htmlspecialchars($containerClasses),
                self::getSvgPlaceholder()
            );
        }
    }

    /**
     * Retorna el HTML del placeholder SVG
     *
     * @return string
     */
    private static function getSvgPlaceholder()
    {
        return '<div class="flex items-center justify-center w-full h-48 bg-gray-200">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>';
    }
}
