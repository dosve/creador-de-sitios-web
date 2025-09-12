<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\Website;
use App\Services\ExternalApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ApiConfigController extends Controller
{
    use AuthorizesRequests;
    /**
     * Mostrar la configuración de API
     */
    public function show(Website $website)
    {
        $this->authorize('view', $website);
        
        return view('creator.config.api', compact('website'));
    }

    /**
     * Actualizar la configuración de API
     */
    public function update(Request $request, Website $website)
    {
        $this->authorize('update', $website);

        $request->validate([
            'api_base_url' => 'nullable|url',
            'api_key' => 'nullable|string|min:10',
        ]);

        $website->update([
            'api_base_url' => $request->api_base_url,
            'api_key' => $request->api_key,
        ]);

        return redirect()->route('creator.config.api', $website)
            ->with('success', 'Configuración de API actualizada correctamente');
    }

    /**
     * Probar la conexión con la API
     */
    public function test(Request $request, Website $website)
    {
        $this->authorize('view', $website);

        if (!$website->api_key || !$website->api_base_url) {
            return response()->json([
                'success' => false,
                'message' => 'API Key y URL base son requeridos'
            ], 400);
        }

        try {
            $apiService = new ExternalApiService($website->api_key, $website->api_base_url);
            
            if ($apiService->validateApiKey()) {
                $businessName = $apiService->getBusinessName();
                $message = $businessName ? "Conectado exitosamente con: {$businessName}" : "Conexión exitosa";
                
                return response()->json([
                    'success' => true,
                    'message' => $message
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'API Key inválida o servidor no disponible'
                ], 401);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al conectar con el servidor: ' . $e->getMessage()
            ], 500);
        }
    }
}
