<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\ImageHelper;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Registrar helper global para verificar imágenes
        if (!function_exists('image_exists')) {
            function image_exists($imageUrl, $timeout = 5) {
                return ImageHelper::exists($imageUrl, $timeout);
            }
        }

        if (!function_exists('get_valid_image_url')) {
            function get_valid_image_url($imageUrl, $placeholderUrl = null, $timeout = 5) {
                return ImageHelper::getValidImageUrl($imageUrl, $placeholderUrl, $timeout);
            }
        }

        if (!function_exists('render_image_with_fallback')) {
            function render_image_with_fallback($imageUrl, $alt = '', $cssClasses = '', $placeholderUrl = null, $timeout = 5) {
                return ImageHelper::renderImageWithFallback($imageUrl, $alt, $cssClasses, $placeholderUrl, $timeout);
            }
        }

        if (!function_exists('render_image_container')) {
            function render_image_container($imageUrl, $alt = '', $containerClasses = '', $imageClasses = '', $timeout = 5) {
                return ImageHelper::renderImageContainer($imageUrl, $alt, $containerClasses, $imageClasses, $timeout);
            }
        }
    }
}
