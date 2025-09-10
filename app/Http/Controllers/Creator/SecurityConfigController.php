<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class SecurityConfigController extends Controller
{
    use AuthorizesRequests;

    /**
     * Mostrar la configuración de SSL y seguridad
     */
    public function index(Request $request)
    {
        $selectedWebsiteId = session('selected_website_id');
        $website = Website::findOrFail($selectedWebsiteId);
        
        $this->authorize('view', $website);
        
        return view('creator.config.security', compact('website'));
    }

    /**
     * Actualizar configuración de SSL
     */
    public function updateSsl(Request $request)
    {
        $selectedWebsiteId = session('selected_website_id');
        $website = Website::findOrFail($selectedWebsiteId);
        
        $this->authorize('update', $website);
        
        $request->validate([
            'ssl_enabled' => 'boolean',
            'force_https' => 'boolean',
            'hsts_enabled' => 'boolean',
        ]);

        // Aquí actualizarías la configuración de SSL en la base de datos
        // Por ahora, simularemos la actualización
        $website->update([
            'ssl_enabled' => $request->ssl_enabled ?? false,
            'force_https' => $request->force_https ?? false,
            'hsts_enabled' => $request->hsts_enabled ?? false,
        ]);

        return redirect()->route('creator.config.security', $website)
            ->with('success', 'Configuración de SSL actualizada exitosamente.');
    }

    /**
     * Generar certificado SSL
     */
    public function generateSsl(Request $request)
    {
        $selectedWebsiteId = session('selected_website_id');
        $website = Website::findOrFail($selectedWebsiteId);
        
        $this->authorize('update', $website);
        
        // Aquí implementarías la lógica para generar un certificado SSL
        // Por ahora, simularemos la generación
        
        return redirect()->route('creator.config.security', $website)
            ->with('success', 'Certificado SSL generado exitosamente. Se activará en unos minutos.');
    }

    /**
     * Actualizar configuración de seguridad general
     */
    public function updateSecurity(Request $request)
    {
        $selectedWebsiteId = session('selected_website_id');
        $website = Website::findOrFail($selectedWebsiteId);
        
        $this->authorize('update', $website);
        
        $request->validate([
            'two_factor_enabled' => 'boolean',
            'login_attempts_limit' => 'integer|min:1|max:10',
            'session_timeout' => 'integer|min:15|max:480',
            'ip_whitelist' => 'nullable|string',
        ]);

        // Aquí actualizarías la configuración de seguridad en la base de datos
        // Por ahora, simularemos la actualización
        $website->update([
            'two_factor_enabled' => $request->two_factor_enabled ?? false,
            'login_attempts_limit' => $request->login_attempts_limit ?? 5,
            'session_timeout' => $request->session_timeout ?? 60,
            'ip_whitelist' => $request->ip_whitelist,
        ]);

        return redirect()->route('creator.config.security', $website)
            ->with('success', 'Configuración de seguridad actualizada exitosamente.');
    }
}