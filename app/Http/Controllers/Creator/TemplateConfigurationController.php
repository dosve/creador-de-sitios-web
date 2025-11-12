<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\TemplateConfiguration;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TemplateConfigurationController extends Controller
{
    /**
     * Obtiene el sitio web seleccionado desde la sesión
     */
    private function getSelectedWebsite(): Website
    {
        $websiteId = session('selected_website_id');
        if (!$websiteId) {
            abort(404, 'No hay sitio web seleccionado');
        }
        
        $website = Website::find($websiteId);
        if (!$website) {
            abort(404, 'Sitio web no encontrado');
        }
        
        // Verificar que el usuario tenga acceso al sitio
        if (Auth::user()->id !== $website->user_id) {
            abort(403, 'No tienes permisos para acceder a este sitio');
        }
        
        return $website;
    }

    /**
     * Muestra la configuración de plantillas para el sitio web seleccionado
     */
    public function index()
    {
        $website = $this->getSelectedWebsite();
        
        // Si el sitio tiene una plantilla específica, redirigir directamente a su configuración
        if ($website->template_id) {
            return redirect()->route('creator.template-configuration.show', [
                'templateSlug' => $website->template_id
            ]);
        }
        
        $templateConfigs = TemplateConfiguration::where('website_id', $website->id)
            ->with('website')
            ->get();
            
        return view('creator.template-configuration.index', compact('website', 'templateConfigs'));
    }

    /**
     * Muestra el formulario de configuración de una plantilla específica
     */
    public function show(string $templateSlug)
    {
        $website = $this->getSelectedWebsite();
        
        // Obtener o crear la configuración de la plantilla
        $templateConfig = TemplateConfiguration::firstOrCreate(
            [
                'website_id' => $website->id,
                'template_slug' => $templateSlug
            ],
            [
                'configuration' => TemplateConfiguration::getDefaultConfiguration($templateSlug),
                'customization' => [],
                'settings' => [],
                'is_active' => true
            ]
        );

        // Obtener la configuración completa
        $fullConfig = $templateConfig->getFullConfiguration();
        
        return view('creator.template-configuration.show', compact('website', 'templateConfig', 'templateSlug', 'fullConfig'));
    }

    /**
     * Actualiza la configuración general de una plantilla
     */
    public function update(Request $request, string $templateSlug)
    {
        $website = $this->getSelectedWebsite();
        
        $templateConfig = TemplateConfiguration::where('website_id', $website->id)
            ->where('template_slug', $templateSlug)
            ->firstOrFail();

        $configuration = $templateConfig->configuration ?? [];
        
        // Actualizar configuración general
        if ($request->has('site_name')) {
            $configuration['site_name'] = $request->site_name;
        }
        
        if ($request->has('site_description')) {
            $configuration['site_description'] = $request->site_description;
        }
        
        if ($request->has('logo_url')) {
            $configuration['logo_url'] = $request->logo_url;
        }
        
        if ($request->has('favicon_url')) {
            $configuration['favicon_url'] = $request->favicon_url;
        }

        $templateConfig->update(['configuration' => $configuration]);

        return response()->json([
            'success' => true,
            'message' => 'Configuración actualizada exitosamente'
        ]);
    }

    /**
     * Actualiza la personalización de una plantilla
     */
    public function updateCustomization(Request $request, string $templateSlug)
    {
        \Log::info('🔧 updateCustomization llamado', [
            'templateSlug' => $templateSlug,
            'hasFile' => $request->hasFile('logo'),
            'files' => $request->allFiles(),
            'all_data' => $request->all()
        ]);
        
        $website = $this->getSelectedWebsite();
        
        $templateConfig = TemplateConfiguration::where('website_id', $website->id)
            ->where('template_slug', $templateSlug)
            ->firstOrFail();

        // Manejar la subida del logo
        if ($request->hasFile('logo')) {
            $logoFile = $request->file('logo');
            
            \Log::info('📸 Logo detectado', [
                'filename' => $logoFile->getClientOriginalName(),
                'size' => $logoFile->getSize(),
                'mime' => $logoFile->getMimeType()
            ]);
            
            try {
                // Validar el archivo
                $request->validate([
                    'logo' => 'image|mimes:jpeg,png,jpg,svg|max:2048'
                ]);
                
                // Eliminar el logo anterior si existe
                if ($website->logo && \Storage::disk('public')->exists($website->logo)) {
                    \Storage::disk('public')->delete($website->logo);
                    \Log::info('🗑️ Logo anterior eliminado', ['path' => $website->logo]);
                }
                
                // Guardar el nuevo logo
                $logoPath = $logoFile->store('logos', 'public');
                
                \Log::info('💾 Logo guardado en storage', ['path' => $logoPath]);
                
                // Actualizar el website
                $website->logo = $logoPath;
                $website->save();
                
                \Log::info('✅ Website actualizado con logo', [
                    'website_id' => $website->id,
                    'logo_path' => $logoPath,
                    'logo_saved' => $website->logo
                ]);
                
            } catch (\Exception $e) {
                \Log::error('❌ Error al subir logo', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Error al subir el logo: ' . $e->getMessage()
                ], 500);
            }
        } else {
            \Log::info('⚠️ No se recibió archivo de logo');
        }

        $customization = $request->except(['logo', '_token']);
        $templateConfig->updateCustomization($customization);

        return response()->json([
            'success' => true,
            'message' => $request->hasFile('logo') 
                ? 'Logo y apariencia actualizados exitosamente' 
                : 'Personalización actualizada exitosamente'
        ]);
    }

    /**
     * Actualiza la configuración de ajustes de una plantilla
     */
    public function updateSettings(Request $request, string $templateSlug)
    {
        $website = $this->getSelectedWebsite();
        
        $templateConfig = TemplateConfiguration::where('website_id', $website->id)
            ->where('template_slug', $templateSlug)
            ->firstOrFail();

        $settings = [];
        
        if ($request->has('contact_email')) {
            $settings['contact_email'] = $request->contact_email;
        }
        
        if ($request->has('contact_phone')) {
            $settings['contact_phone'] = $request->contact_phone;
        }
        
        if ($request->has('contact_address')) {
            $settings['contact_address'] = $request->contact_address;
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
    public function reset(string $templateSlug)
    {
        $website = $this->getSelectedWebsite();
        
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
            ->route('creator.template-configuration.show', ['templateSlug' => $templateSlug])
            ->with('success', 'Configuración reseteada a los valores por defecto');
    }
    
    /**
     * Elimina el logo del sitio web
     */
    public function removeLogo(string $templateSlug)
    {
        $website = $this->getSelectedWebsite();
        
        // Eliminar el archivo del logo si existe
        if ($website->logo && \Storage::disk('public')->exists($website->logo)) {
            \Storage::disk('public')->delete($website->logo);
        }
        
        // Actualizar el website
        $website->update(['logo' => null]);
        
        \Log::info('Logo eliminado correctamente');
        
        return response()->json([
            'success' => true,
            'message' => 'Logo eliminado correctamente'
        ]);
    }
}
