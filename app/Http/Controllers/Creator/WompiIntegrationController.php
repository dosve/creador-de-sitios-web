<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class WompiIntegrationController extends Controller
{
    /**
     * Mostrar formulario de configuración de Wompi
     */
    public function index()
    {
        $websiteId = Session::get('selected_website_id');
        
        if (!$websiteId) {
            return redirect()->route('creator.select-website')
                ->with('error', 'Por favor selecciona un sitio web primero');
        }

        $website = Website::findOrFail($websiteId);

        return view('creator.integrations.wompi', compact('website'));
    }

    /**
     * Guardar credenciales de Wompi
     */
    public function store(Request $request)
    {
        $websiteId = Session::get('selected_website_id');
        
        if (!$websiteId) {
            return response()->json([
                'success' => false,
                'message' => 'No hay sitio web seleccionado'
            ], 400);
        }

        $request->validate([
            'wompi_public_key' => 'required|string',
            'wompi_private_key' => 'required|string',
            'wompi_event_key' => 'nullable|string',
            'wompi_integrity_key' => 'nullable|string',
        ]);

        try {
            $website = Website::findOrFail($websiteId);
            
            $website->update([
                'wompi_public_key' => $request->wompi_public_key,
                'wompi_private_key' => $request->wompi_private_key,
                'wompi_event_key' => $request->wompi_event_key,
                'wompi_integrity_key' => $request->wompi_integrity_key,
                // Actualizar la pasarela de pago por defecto a Wompi si se guardan credenciales
                'default_payment_gateway' => 'wompi',
            ]);

            Log::info('Credenciales de Wompi actualizadas', [
                'website_id' => $websiteId,
                'public_key_length' => strlen($request->wompi_public_key)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Credenciales de Wompi guardadas correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('Error guardando credenciales de Wompi', [
                'website_id' => $websiteId,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al guardar las credenciales: ' . $e->getMessage()
            ], 500);
        }
    }
}
