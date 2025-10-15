<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\Website;
use App\Models\Domain;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class DomainConfigController extends Controller
{
    use AuthorizesRequests;

    /**
     * Mostrar la configuración de dominio personalizado
     */
    public function index(Request $request)
    {
        $selectedWebsiteId = session('selected_website_id');
        $website = Website::findOrFail($selectedWebsiteId);
        
        $this->authorize('view', $website);
        
        $domains = $website->domains;
        
        return view('creator.config.domain', compact('website', 'domains'));
    }

    /**
     * Almacenar un nuevo dominio personalizado
     */
    public function store(Request $request)
    {
        $selectedWebsiteId = session('selected_website_id');
        $website = Website::findOrFail($selectedWebsiteId);
        
        $this->authorize('update', $website);
        
        $request->validate([
            'domain_name' => 'required|string|max:255|unique:domains,domain',
        ]);

        // Si ya existe un dominio, eliminarlo primero
        $website->domains()->delete();

        $domain = $website->domains()->create([
            'domain' => $request->domain_name,
            'is_primary' => true, // Siempre será el principal ya que es el único
            'is_verified' => false,
            'status' => 'pending',
        ]);

        return redirect()->route('creator.config.domain')
            ->with('success', 'Dominio vinculado exitosamente. Configura los registros DNS para verificar el dominio.');
    }

    /**
     * Actualizar un dominio existente
     */
    public function update(Request $request, Domain $domain)
    {
        $selectedWebsiteId = session('selected_website_id');
        $website = Website::findOrFail($selectedWebsiteId);
        
        $this->authorize('update', $website);
        
        // Verificar que el dominio pertenece al sitio web
        if ($domain->website_id !== $website->id) {
            abort(403);
        }

        $request->validate([
            'domain_name' => 'required|string|max:255|unique:domains,domain,' . $domain->id,
            'is_primary' => 'boolean',
        ]);

        // Si se marca como primario, desmarcar otros dominios primarios
        if ($request->is_primary) {
            $website->domains()->where('id', '!=', $domain->id)->update(['is_primary' => false]);
        }

        $domain->update([
            'domain' => $request->domain_name,
            'is_primary' => $request->is_primary ?? false,
        ]);

        return redirect()->route('creator.config.domain')
            ->with('success', 'Dominio actualizado exitosamente.');
    }

    /**
     * Eliminar un dominio
     */
    public function destroy(Domain $domain)
    {
        $selectedWebsiteId = session('selected_website_id');
        $website = Website::findOrFail($selectedWebsiteId);
        
        $this->authorize('update', $website);
        
        // Verificar que el dominio pertenece al sitio web
        if ($domain->website_id !== $website->id) {
            abort(403);
        }

        $domain->delete();

        return redirect()->route('creator.config.domain')
            ->with('success', 'Dominio eliminado exitosamente.');
    }

    /**
     * Verificar un dominio
     */
    public function verify(Domain $domain)
    {
        $selectedWebsiteId = session('selected_website_id');
        $website = Website::findOrFail($selectedWebsiteId);
        
        $this->authorize('update', $website);
        
        // Verificar que el dominio pertenece al sitio web
        if ($domain->website_id !== $website->id) {
            abort(403);
        }

        // Aquí implementarías la lógica de verificación real
        // Por ahora, simularemos la verificación
        $domain->update([
            'is_verified' => true,
            'status' => 'active',
        ]);

        return redirect()->route('creator.config.domain')
            ->with('success', 'Dominio verificado exitosamente.');
    }
}