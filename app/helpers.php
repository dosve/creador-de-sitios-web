<?php

use App\Helpers\ImageHelper;

if (!function_exists('image_exists')) {
    /**
     * Verifica si una imagen existe y es accesible
     *
     * @param string|null $imageUrl
     * @param int $timeout Segundos de timeout
     * @return bool
     */
    function image_exists($imageUrl, $timeout = 5)
    {
        return ImageHelper::exists($imageUrl, $timeout);
    }
}

if (!function_exists('get_valid_image_url')) {
    /**
     * Retorna la URL de la imagen si es válida, o un placeholder si no
     *
     * @param string|null $imageUrl
     * @param string|null $placeholderUrl URL del placeholder personalizado
     * @param int $timeout Segundos de timeout
     * @return string
     */
    function get_valid_image_url($imageUrl, $placeholderUrl = null, $timeout = 5)
    {
        return ImageHelper::getValidImageUrl($imageUrl, $placeholderUrl, $timeout);
    }
}

if (!function_exists('render_image_with_fallback')) {
    /**
     * Genera el HTML completo para una imagen con fallback automático
     *
     * @param string|null $imageUrl
     * @param string $alt Alt text para la imagen
     * @param string $cssClasses Clases CSS para la imagen
     * @param string|null $placeholderUrl URL del placeholder personalizado
     * @param int $timeout Segundos de timeout
     * @return string
     */
    function render_image_with_fallback($imageUrl, $alt = '', $cssClasses = '', $placeholderUrl = null, $timeout = 5)
    {
        return ImageHelper::renderImageWithFallback($imageUrl, $alt, $cssClasses, $placeholderUrl, $timeout);
    }
}

if (!function_exists('render_image_container')) {
    /**
     * Genera un contenedor completo con imagen y placeholder SVG
     *
     * @param string|null $imageUrl
     * @param string $alt Alt text para la imagen
     * @param string $containerClasses Clases CSS para el contenedor
     * @param string $imageClasses Clases CSS para la imagen
     * @param int $timeout Segundos de timeout
     * @return string
     */
    function render_image_container($imageUrl, $alt = '', $containerClasses = '', $imageClasses = '', $timeout = 5)
    {
        return ImageHelper::renderImageContainer($imageUrl, $alt, $containerClasses, $imageClasses, $timeout);
    }
}
