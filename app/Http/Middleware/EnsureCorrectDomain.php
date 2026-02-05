<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Website;

class EnsureCorrectDomain
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $host = $request->getHost();
        
        // Si es el dominio del creador, dejar pasar
        if (in_array($host, ['creadorweb.eme10.com', 'www.creadorweb.eme10.com'])) {
            return $next($request);
        }
        
        // Si tiene un subdominio de creadorweb.eme10.com, validar que el sitio existe
        if (str_contains($host, '.creadorweb.eme10.com')) {
            $subdomain = str_replace(['.creadorweb.eme10.com', 'www.'], '', $host);
            $website = Website::where('subdomain', $subdomain)->first();
            
            if (!$website || !$website->is_published) {
                abort(404, 'Sitio web no encontrado');
            }
        } else {
            // Si es un dominio personalizado, validar que está verificado
            $domain = \App\Models\Domain::where('domain', $host)
                ->orWhere('domain', 'www.' . $host)
                ->first();
            
            if (!$domain || !$domain->is_verified) {
                abort(404, 'Dominio no verificado o no encontrado');
            }
            
            if (!$domain->website || !$domain->website->is_published) {
                abort(404, 'Sitio web no encontrado o no publicado');
            }
        }
        
        return $next($request);
    }
}
