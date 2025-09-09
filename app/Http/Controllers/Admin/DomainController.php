<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Domain;
use Illuminate\Http\Request;

class DomainController extends Controller
{
    public function index()
    {
        $domains = Domain::with('website.user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('admin.domains.index', compact('domains'));
    }

    public function show(Domain $domain)
    {
        $domain->load('website.user');
        return view('admin.domains.show', compact('domain'));
    }

    public function edit(Domain $domain)
    {
        return view('admin.domains.edit', compact('domain'));
    }

    public function update(Request $request, Domain $domain)
    {
        $request->validate([
            'domain' => 'required|string|max:255',
            'type' => 'required|in:subdomain,custom',
            'is_primary' => 'boolean',
            'is_verified' => 'boolean',
            'ssl_enabled' => 'boolean',
            'status' => 'required|in:pending,active,suspended',
            'notes' => 'nullable|string|max:1000',
        ]);

        $domain->update([
            'domain' => $request->domain,
            'type' => $request->type,
            'is_primary' => $request->boolean('is_primary'),
            'is_verified' => $request->boolean('is_verified'),
            'ssl_enabled' => $request->boolean('ssl_enabled'),
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.domains.index')
            ->with('success', 'Dominio actualizado exitosamente');
    }

    public function destroy(Domain $domain)
    {
        $domain->delete();
        
        return redirect()->route('admin.domains.index')
            ->with('success', 'Dominio eliminado exitosamente');
    }

    public function toggleStatus(Domain $domain)
    {
        $newStatus = $domain->status === 'active' ? 'suspended' : 'active';
        $domain->update(['status' => $newStatus]);
        
        $status = $newStatus === 'active' ? 'activado' : 'suspendido';
        return redirect()->route('admin.domains.index')
            ->with('success', "Dominio {$status} exitosamente");
    }

    public function verify(Domain $domain)
    {
        // Aquí se implementaría la lógica de verificación de dominio
        $domain->update([
            'is_verified' => true,
            'status' => 'active'
        ]);
        
        return redirect()->route('admin.domains.index')
            ->with('success', 'Dominio verificado exitosamente');
    }

    public function enableSSL(Domain $domain)
    {
        // Aquí se implementaría la lógica de habilitación de SSL
        $domain->update([
            'ssl_enabled' => true,
            'ssl_expires_at' => now()->addYear()
        ]);
        
        return redirect()->route('admin.domains.index')
            ->with('success', 'SSL habilitado exitosamente');
    }
}
