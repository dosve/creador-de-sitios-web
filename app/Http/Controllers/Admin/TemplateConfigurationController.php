<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TemplateConfiguration;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TemplateConfigurationController extends Controller
{
    /**
     * Verificar autorización para acceder a la configuración de plantillas
     */
    private function checkAuthorization(Website $website)
    {
        if (!Auth::check() || (Auth::user()->role !== 'admin' && Auth::user()->id !== $website->user_id)) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }
    }

    /**
     * Muestra la configuración de plantillas para un sitio web
     */
    public function index(Website $website)
    {
        $this->checkAuthorization($website);
        
        // Si el sitio tiene una plantilla específica, redirigir directamente a su configuración
        if ($website->template_id) {
            // Determinar el prefijo de ruta según el rol del usuario
            $routePrefix = Auth::user()->role === 'admin' ? 'admin.' : 'creator.';
            
            return redirect()->route($routePrefix . 'template-configuration.show', [
                'website' => $website,
                'templateSlug' => $website->template_id
            ]);
        }
        
        $templateConfigs = TemplateConfiguration::where('website_id', $website->id)
            ->with('website')
            ->get();
            
        return view('admin.template-configuration.index', compact('website', 'templateConfigs'));
    }

    /**
     * Muestra el formulario de configuración de una plantilla específica
     */
    public function show(Website $website, string $templateSlug)
    {
        $this->checkAuthorization($website);
        
        $templateConfig = TemplateConfiguration::getOrCreateForWebsite($website->id, $templateSlug);
        $availableTemplates = $this->getAvailableTemplates();
        
        return view('admin.template-configuration.show', compact('website', 'templateConfig', 'availableTemplates'));
    }

    /**
     * Actualiza la configuración de una plantilla
     */
    public function update(Request $request, Website $website, string $templateSlug)
    {
        $this->checkAuthorization($website);
        
        $request->validate([
            'configuration' => 'sometimes|array',
            'customization' => 'sometimes|array',
            'settings' => 'sometimes|array',
        ]);

        $templateConfig = TemplateConfiguration::getOrCreateForWebsite($website->id, $templateSlug);
        
        if ($request->has('configuration')) {
            $templateConfig->updateConfiguration($request->configuration);
        }
        
        if ($request->has('customization')) {
            $templateConfig->updateCustomization($request->customization);
        }
        
        if ($request->has('settings')) {
            $templateConfig->updateSettings($request->settings);
        }

        return redirect()
            ->route('admin.template-configuration.show', [$website, $templateSlug])
            ->with('success', 'Configuración actualizada exitosamente');
    }

    /**
     * Actualiza solo la personalización (colores, fuentes, etc.)
     */
    public function updateCustomization(Request $request, Website $website, string $templateSlug)
    {
        $this->checkAuthorization($website);
        
        $request->validate([
            'colors' => 'sometimes|array',
            'fonts' => 'sometimes|array',
            'layout' => 'sometimes|array',
        ]);

        $templateConfig = TemplateConfiguration::getOrCreateForWebsite($website->id, $templateSlug);
        
        $customization = $templateConfig->customization ?? [];
        
        if ($request->has('colors')) {
            $customization['colors'] = array_merge($customization['colors'] ?? [], $request->colors);
        }
        
        if ($request->has('fonts')) {
            $customization['fonts'] = array_merge($customization['fonts'] ?? [], $request->fonts);
        }
        
        if ($request->has('layout')) {
            $customization['layout'] = array_merge($customization['layout'] ?? [], $request->layout);
        }

        $templateConfig->updateCustomization($customization);

        return response()->json([
            'success' => true,
            'message' => 'Personalización actualizada exitosamente'
        ]);
    }

    /**
     * Actualiza la configuración general (logo, nombre, etc.)
     */
    public function updateSettings(Request $request, Website $website, string $templateSlug)
    {
        $this->checkAuthorization($website);
        
        $request->validate([
            'site_name' => 'sometimes|string|max:255',
            'site_description' => 'sometimes|string|max:500',
            'logo' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:512',
            'contact_email' => 'sometimes|email',
            'contact_phone' => 'sometimes|string|max:20',
            'social_media' => 'sometimes|array',
        ]);

        $templateConfig = TemplateConfiguration::getOrCreateForWebsite($website->id, $templateSlug);
        
        $settings = $templateConfig->settings ?? [];
        
        // Actualizar configuración del sitio web
        if ($request->has('site_name')) {
            $website->update(['name' => $request->site_name]);
        }
        
        if ($request->has('site_description')) {
            $website->update(['description' => $request->site_description]);
        }
        
        // Manejar subida de logo
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $website->update(['logo' => $logoPath]);
        }
        
        if ($request->hasFile('favicon')) {
            $faviconPath = $request->file('favicon')->store('favicons', 'public');
            $settings['favicon'] = $faviconPath;
        }
        
        if ($request->has('contact_email')) {
            $settings['contact_email'] = $request->contact_email;
        }
        
        if ($request->has('contact_phone')) {
            $settings['contact_phone'] = $request->contact_phone;
        }
        
        if ($request->has('social_media')) {
            $settings['social_media'] = $request->social_media;
        }

        $templateConfig->updateSettings($settings);

        return response()->json([
            'success' => true,
            'message' => 'Configuración general actualizada exitosamente'
        ]);
    }

    /**
     * Resetea la configuración de una plantilla a los valores por defecto
     */
    public function reset(Website $website, string $templateSlug)
    {
        $this->checkAuthorization($website);
        
        $templateConfig = TemplateConfiguration::where('website_id', $website->id)
            ->where('template_slug', $templateSlug)
            ->first();
            
        if ($templateConfig) {
            $defaultConfig = TemplateConfiguration::getDefaultConfiguration($templateSlug);
            $templateConfig->update([
                'configuration' => $defaultConfig,
                'customization' => [],
                'settings' => []
            ]);
        }

        return redirect()
            ->route('admin.template-configuration.show', [$website, $templateSlug])
            ->with('success', 'Configuración reseteada a los valores por defecto');
    }

    /**
     * Obtiene la lista de plantillas disponibles
     */
    private function getAvailableTemplates(): array
    {
        $templatesDir = resource_path('views/templates');
        $templates = [];
        
        if (is_dir($templatesDir)) {
            $directories = array_filter(scandir($templatesDir), function($item) use ($templatesDir) {
                return is_dir($templatesDir . '/' . $item) && !in_array($item, ['.', '..', 'partials']);
            });
            
            foreach ($directories as $dir) {
                $configPath = $templatesDir . '/' . $dir . '/config.json';
                if (file_exists($configPath)) {
                    $config = json_decode(file_get_contents($configPath), true);
                    $templates[] = $config;
                }
            }
        }
        
        return $templates;
    }
}
