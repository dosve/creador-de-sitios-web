<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\TemplateCssService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Registrar el servicio de CSS de plantillas
        $this->app->singleton(TemplateCssService::class, function ($app) {
            return new TemplateCssService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Registrar helpers globales
        if (!function_exists('template_css')) {
            function template_css($templateSlug, $customization = [], $inline = false) {
                return \App\Helpers\TemplateCssHelper::renderCss($templateSlug, $customization, $inline);
            }
        }

        if (!function_exists('template_css_url')) {
            function template_css_url($templateSlug) {
                return \App\Helpers\TemplateCssHelper::cssUrl($templateSlug);
            }
        }

        if (!function_exists('template_has_css')) {
            function template_has_css($templateSlug) {
                return \App\Helpers\TemplateCssHelper::hasCss($templateSlug);
            }
        }
    }
}
