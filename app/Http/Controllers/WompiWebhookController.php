<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WompiWebhookController extends Controller
{
    /**
     * Manejar webhook de Wompi
     */
    public function handleWebhook(Request $request)
    {
        Log::info('🟣 Wompi Webhook recibido', [
            'data' => $request->all(),
            'headers' => $request->headers->all()
        ]);

        try {
            $event = $request->input('event');
            $data = $request->input('data');
            
            // Verificar firma del webhook si está configurada
            $signature = $request->header('X-Event-Checksum');
            
            if ($event === 'transaction.updated') {
                $this->handleTransactionUpdate($data);
            }

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            Log::error('Error procesando webhook de Wompi', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json(['status' => 'error'], 500);
        }
    }

    /**
     * Manejar actualización de transacción
     */
    private function handleTransactionUpdate($data)
    {
        $transactionId = $data['id'] ?? null;
        $reference = $data['reference'] ?? null;
        $status = $data['status'] ?? null;

        Log::info('💳 Transacción actualizada', [
            'transaction_id' => $transactionId,
            'reference' => $reference,
            'status' => $status
        ]);

        if (!$reference) {
            return;
        }

        // Buscar la orden por referencia (guardarla en el campo payment_reference)
        $order = Order::where('payment_reference', $reference)->first();

        if ($order) {
            // Actualizar estado según el status de Wompi
            switch ($status) {
                case 'APPROVED':
                    $order->payment_status = 'paid';
                    $order->status = 'processing';
                    break;
                case 'DECLINED':
                    $order->payment_status = 'failed';
                    break;
                case 'VOIDED':
                    $order->payment_status = 'refunded';
                    break;
                case 'ERROR':
                    $order->payment_status = 'failed';
                    break;
            }

            $order->save();

            Log::info('✅ Orden actualizada por webhook de Wompi', [
                'order_id' => $order->id,
                'payment_status' => $order->payment_status,
                'status' => $order->status
            ]);
        }
    }

    /**
     * Página de respuesta después del pago
     */
    public function paymentResponse(Request $request)
    {
        $transactionId = $request->input('id');
        $reference = $request->input('ref');

        Log::info('🟣 Respuesta de pago Wompi', [
            'transaction_id' => $transactionId,
            'reference' => $reference,
            'all_params' => $request->all()
        ]);

        // Buscar la orden por referencia
        $order = Order::where('payment_reference', $reference)->first();

        // Si no se encuentra por referencia, buscar por orden reciente pendiente del mismo usuario
        if (!$order) {
            Log::warning('⚠️ Orden no encontrada por payment_reference', [
                'reference' => $reference,
                'transaction_id' => $transactionId
            ]);
            
            // Intentar buscar por orden reciente (últimos 10 minutos) con pago pendiente
            $order = Order::where('payment_status', 'pending')
                ->where('payment_method', 'online_payment')
                ->where('created_at', '>=', now()->subMinutes(10))
                ->orderBy('created_at', 'desc')
                ->first();
            
            // Si encontramos una orden reciente, actualizar el payment_reference
            if ($order && $reference) {
                $order->payment_reference = $reference;
                $order->save();
                Log::info('✅ Payment reference actualizado en orden encontrada', [
                    'order_id' => $order->id,
                    'reference' => $reference
                ]);
            }
        }

        // Si encontramos la orden, consultar el estado real en Wompi
        if ($order && $transactionId) {
            $website = Website::find($order->website_id);
            
            if ($website && $website->wompi_private_key) {
                try {
                    // Consultar el estado de la transacción en Wompi
                    $apiUrl = 'https://production.wompi.co/v1/transactions/' . $transactionId;
                    
                    // Determinar si es test o producción
                    $isTest = strpos($website->wompi_private_key, 'prv_test_') === 0;
                    if ($isTest) {
                        $apiUrl = 'https://sandbox.wompi.co/v1/transactions/' . $transactionId;
                    }
                    
                    $response = Http::withHeaders([
                        'Authorization' => 'Bearer ' . $website->wompi_private_key,
                        'Accept' => 'application/json'
                    ])->get($apiUrl);

                    if ($response->successful()) {
                        $transactionData = $response->json();
                        $status = $transactionData['data']['status'] ?? null;
                        
                        Log::info('💳 Estado de transacción consultado en Wompi', [
                            'transaction_id' => $transactionId,
                            'status' => $status,
                            'reference' => $reference
                        ]);

                        // Actualizar el estado de la orden según el resultado
                        switch ($status) {
                            case 'APPROVED':
                                $order->payment_status = 'paid';
                                $order->status = 'processing';
                                break;
                            case 'DECLINED':
                                $order->payment_status = 'failed';
                                break;
                            case 'VOIDED':
                                $order->payment_status = 'refunded';
                                $order->status = 'cancelled';
                                break;
                            case 'ERROR':
                                $order->payment_status = 'failed';
                                break;
                            case 'PENDING':
                                $order->payment_status = 'pending';
                                break;
                        }
                        
                        $order->save();
                        
                        Log::info('✅ Orden actualizada según estado de Wompi', [
                            'order_id' => $order->id,
                            'payment_status' => $order->payment_status,
                            'status' => $order->status,
                            'wompi_status' => $status
                        ]);
                    }
                } catch (\Exception $e) {
                    Log::error('Error consultando transacción en Wompi', [
                        'transaction_id' => $transactionId,
                        'error' => $e->getMessage()
                    ]);
                }
            }
            
            // Redirigir a la página de la orden
            if ($website) {
                // Limpiar carrito del usuario (usando sesión o cookie)
                // Esto se manejará también en el frontend, pero lo hacemos aquí como respaldo
                
                if ($order->payment_status === 'paid') {
                    // Pago exitoso - redirigir a página de la orden con mensaje de éxito
                    Log::info('✅ Redirigiendo a orden exitosa', [
                        'order_id' => $order->id,
                        'order_number' => $order->order_number,
                        'website_slug' => $website->slug
                    ]);
                    
                    // Construir URL directamente con el website slug
                    $orderUrl = '/' . $website->slug . '/order/' . $order->order_number;
                    return redirect($orderUrl)->with('payment_success', true);
                } else {
                    // Pago fallido o pendiente - mostrar la orden pero con estado correspondiente
                    $orderUrl = '/' . $website->slug . '/order/' . $order->order_number;
                    return redirect($orderUrl);
                }
            }
        }

        // Si no se encontró la orden, mostrar error con información útil
        Log::error('❌ Orden no encontrada para respuesta de pago Wompi', [
            'reference' => $reference,
            'transaction_id' => $transactionId,
            'all_params' => $request->all()
        ]);
        
        return view('payment.error', [
            'message' => 'No se pudo encontrar la orden asociada a esta transacción. Si el pago fue exitoso, por favor contacta con soporte proporcionando la siguiente información: Referencia: ' . ($reference ?? 'N/A') . ', ID de transacción: ' . ($transactionId ?? 'N/A')
        ]);
    }

    /**
     * Generar firma de integridad para el widget de Wompi
     * 
     * Según la documentación de Wompi, la firma se genera concatenando:
     * reference + amountInCents + currency + integrityKey
     * Y luego aplicando SHA-256
     */
    public function generateSignature(Request $request)
    {
        $request->validate([
            'reference' => 'required|string',
            'amount_in_cents' => 'required|integer|min:100',
            'currency' => 'required|string|in:COP',
            'website_slug' => 'required|string',
        ]);

        try {
            $website = Website::where('slug', $request->website_slug)->first();

            if (!$website) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sitio web no encontrado'
                ], 404);
            }

            // Verificar que tenga la integrity key configurada
            if (!$website->wompi_integrity_key) {
                return response()->json([
                    'success' => false,
                    'message' => 'Integrity key no configurada',
                    'signature' => null
                ]);
            }

            // Generar la firma según la documentación de Wompi
            // Formato: reference + amountInCents + currency + integrityKey
            $concatenated = $request->reference 
                          . $request->amount_in_cents 
                          . $request->currency 
                          . $website->wompi_integrity_key;

            // Aplicar SHA-256
            $signature = hash('sha256', $concatenated);

            Log::info('✅ Firma de integridad generada para Wompi', [
                'website_slug' => $request->website_slug,
                'reference' => $request->reference,
                'amount_in_cents' => $request->amount_in_cents
            ]);

            return response()->json([
                'success' => true,
                'signature' => $signature
            ]);

        } catch (\Exception $e) {
            Log::error('Error generando firma de integridad de Wompi', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al generar la firma: ' . $e->getMessage()
            ], 500);
        }
    }
}
