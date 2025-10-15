<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DomainController extends Controller
{
    /**
     * Mostrar página de configuración de dominios
     */
    public function index()
    {
        $website = Website::find(session('selected_website_id'));
        
        if (!$website) {
            return redirect()->route('creator.select-website')
                ->with('error', 'Selecciona un sitio web primero');
        }
        
        // Obtener todos los dominios del sitio
        $domains = $website->domains()->orderBy('is_primary', 'desc')->get();
        
        return view('creator.domains.index', compact('website', 'domains'));
    }
    
    /**
     * Agregar un nuevo dominio
     */
    public function store(Request $request)
    {
        $website = Website::find(session('selected_website_id'));
        
        if (!$website) {
            return redirect()->route('creator.select-website')
                ->with('error', 'Selecciona un sitio web primero');
        }
        
        $request->validate([
            'domain' => 'required|string|unique:domains,domain',
        ]);
        
        // Limpiar el dominio
        $domain = strtolower($request->domain);
        $domain = str_replace(['http://', 'https://', 'www.'], '', $domain);
        $domain = trim($domain, '/');
        
        // Verificar que no sea un subdominio de paginas.eme10.com
        if (str_contains($domain, 'paginas.eme10.com')) {
            return back()->with('error', 'No puedes usar subdominios de paginas.eme10.com como dominio personalizado');
        }
        
        // Crear el dominio
        $newDomain = $website->domains()->create([
            'domain' => $domain,
            'type' => 'custom',
            'is_primary' => false,
            'is_verified' => false,
            'status' => 'pending',
        ]);
        
        // Intentar verificar el dominio inmediatamente
        $this->verifyDomain($newDomain->id);
        
        return back()->with('success', 'Dominio agregado. Verificando configuración DNS...');
    }
    
    /**
     * Verificar configuración DNS del dominio
     */
    public function verify($domainId)
    {
        $domain = Domain::findOrFail($domainId);
        $website = $domain->website;
        
        // Verificar que el dominio pertenece al sitio del usuario
        if ($website->id !== session('selected_website_id')) {
            return back()->with('error', 'No tienes permiso para verificar este dominio');
        }
        
        $verified = $this->verifyDomain($domainId);
        
        if ($verified) {
            return back()->with('success', '¡Dominio verificado exitosamente! Tu sitio ya está disponible en ' . $domain->domain);
        } else {
            return back()->with('error', 'No se pudo verificar el dominio. Asegúrate de configurar correctamente los registros DNS.');
        }
    }
    
    /**
     * Verificar DNS del dominio
     */
    private function verifyDomain($domainId)
    {
        $domain = Domain::findOrFail($domainId);
        
        // Verificar registros DNS
        $records = @dns_get_record($domain->domain, DNS_A + DNS_CNAME);
        
        if (!$records) {
            $domain->update([
                'is_verified' => false,
                'status' => 'pending',
                'notes' => 'No se encontraron registros DNS. Configura tu dominio para apuntar a paginas.eme10.com'
            ]);
            return false;
        }
        
        $verified = false;
        $serverIp = gethostbyname('paginas.eme10.com'); // IP de tu servidor
        
        foreach ($records as $record) {
            // Verificar CNAME
            if (isset($record['target']) && str_contains($record['target'], 'paginas.eme10.com')) {
                $verified = true;
                break;
            }
            
            // Verificar A record apuntando a la IP del servidor
            if (isset($record['ip']) && $record['ip'] === $serverIp) {
                $verified = true;
                break;
            }
        }
        
        if ($verified) {
            $domain->update([
                'is_verified' => true,
                'status' => 'active',
                'dns_records' => $records,
                'notes' => 'Verificado exitosamente el ' . now()->format('d/m/Y H:i')
            ]);
        } else {
            $domain->update([
                'is_verified' => false,
                'status' => 'pending',
                'dns_records' => $records,
                'notes' => 'DNS configurado pero no apunta a paginas.eme10.com'
            ]);
        }
        
        return $verified;
    }
    
    /**
     * Establecer un dominio como principal
     */
    public function setPrimary($domainId)
    {
        $domain = Domain::findOrFail($domainId);
        $website = $domain->website;
        
        // Verificar que el dominio pertenece al sitio del usuario
        if ($website->id !== session('selected_website_id')) {
            return back()->with('error', 'No tienes permiso para modificar este dominio');
        }
        
        // Verificar que el dominio esté verificado
        if (!$domain->is_verified) {
            return back()->with('error', 'El dominio debe estar verificado antes de establecerlo como principal');
        }
        
        // Quitar primary de todos los dominios
        $website->domains()->update(['is_primary' => false]);
        
        // Establecer este como primary
        $domain->update(['is_primary' => true]);
        
        return back()->with('success', 'Dominio principal actualizado');
    }
    
    /**
     * Eliminar un dominio
     */
    public function destroy($domainId)
    {
        $domain = Domain::findOrFail($domainId);
        $website = $domain->website;
        
        // Verificar que el dominio pertenece al sitio del usuario
        if ($website->id !== session('selected_website_id')) {
            return back()->with('error', 'No tienes permiso para eliminar este dominio');
        }
        
        // No permitir eliminar el dominio principal
        if ($domain->is_primary) {
            return back()->with('error', 'No puedes eliminar el dominio principal. Establece otro dominio como principal primero.');
        }
        
        $domain->delete();
        
        return back()->with('success', 'Dominio eliminado exitosamente');
    }
}

