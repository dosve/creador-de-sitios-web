<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\Website;

class BaseController extends Controller
{
    /**
     * Obtener el website de la sesión
     */
    protected function getWebsiteFromSession()
    {
        $website = Website::find(session('selected_website_id'));
        
        if (!$website) {
            abort(403, 'No hay sitio web seleccionado');
        }
        
        return $website;
    }
}
