<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\Website;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    /**
     * Obtener la página actual basada en la URL
     */
    public function getCurrentPage(Request $request)
    {
        try {
            $websiteSlug = $request->input('website_slug');
            $pageSlug = $request->input('page_slug');
            $url = $request->input('url');
            
            // Obtener el sitio web seleccionado en la sesión
            $website = Website::find(session('selected_website_id'));
            
            if (!$website) {
                return response()->json([
                    'success' => false,
                    'message' => 'No hay sitio web seleccionado'
                ]);
            }
            
            // Verificar que el usuario tiene acceso al sitio web
            if ($website->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tienes acceso a este sitio web'
                ]);
            }
            
            $page = null;
            
            // Si es la página de inicio (URL termina con el slug del sitio o es /)
            if ($url === '/' || $url === "/{$website->slug}" || empty($pageSlug)) {
                $page = $website->pages()->where('is_home', true)->first();
            } else {
                // Buscar por slug de página
                $page = $website->pages()->where('slug', $pageSlug)->first();
            }
            
            if ($page) {
                return response()->json([
                    'success' => true,
                    'page_id' => $page->id,
                    'page_title' => $page->title,
                    'page_slug' => $page->slug,
                    'website_name' => $website->name
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Página no encontrada'
                ]);
            }
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener la página: ' . $e->getMessage()
            ]);
        }
    }
}
