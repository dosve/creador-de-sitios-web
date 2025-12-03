<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class PaymentMethodsConfigController extends Controller
{
    /**
     * Mostrar la configuración de métodos de pago
     */
    public function index()
    {
        $websiteId = Session::get('selected_website_id');
        
        if (!$websiteId) {
            return redirect()->route('creator.select-website')
                ->with('error', 'Por favor selecciona un sitio web primero');
        }

        $website = Website::findOrFail($websiteId);

        return view('creator.config.payment-methods', compact('website'));
    }

    /**
     * Actualizar la configuración de métodos de pago
     */
    public function update(Request $request)
    {
        $websiteId = Session::get('selected_website_id');
        
        if (!$websiteId) {
            return response()->json([
                'success' => false,
                'message' => 'No hay sitio web seleccionado'
            ], 400);
        }

        $request->validate([
            'allow_cash_on_delivery' => 'boolean',
            'allow_online_payment' => 'boolean',
            'require_payment_before_shipping' => 'boolean',
            'cash_on_delivery_instructions' => 'nullable|string|max:500',
            'default_payment_gateway' => 'nullable|in:epayco,wompi',
        ]);

        try {
            $website = Website::findOrFail($websiteId);
            
            // Validar que al menos un método esté habilitado
            if (!$request->allow_cash_on_delivery && !$request->allow_online_payment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Debes habilitar al menos un método de pago'
                ], 422);
            }

            $website->update([
                'allow_cash_on_delivery' => $request->boolean('allow_cash_on_delivery'),
                'allow_online_payment' => $request->boolean('allow_online_payment'),
                'require_payment_before_shipping' => $request->boolean('require_payment_before_shipping'),
                'cash_on_delivery_instructions' => $request->cash_on_delivery_instructions,
                'default_payment_gateway' => $request->default_payment_gateway ?? 'epayco',
            ]);

            Log::info('Configuración de métodos de pago actualizada', [
                'website_id' => $websiteId,
                'cash_on_delivery' => $request->boolean('allow_cash_on_delivery'),
                'online_payment' => $request->boolean('allow_online_payment'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Configuración guardada correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('Error actualizando métodos de pago', [
                'website_id' => $websiteId,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al guardar la configuración: ' . $e->getMessage()
            ], 500);
        }
    }
}
