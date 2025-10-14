<?php

namespace App\Traits;

use App\Models\Website;

trait HasSelectedWebsite
{
    /**
     * Obtener el sitio web seleccionado de la sesión
     */
    protected function getSelectedWebsite(): ?Website
    {
        $websiteId = session('selected_website_id');
        
        if (!$websiteId) {
            return null;
        }
        
        return Website::find($websiteId);
    }
    
    /**
     * Obtener el sitio web seleccionado o abortar con 404
     */
    protected function getSelectedWebsiteOrFail(): Website
    {
        $website = $this->getSelectedWebsite();
        
        if (!$website) {
            abort(404, 'No hay un sitio web seleccionado');
        }
        
        return $website;
    }
}

