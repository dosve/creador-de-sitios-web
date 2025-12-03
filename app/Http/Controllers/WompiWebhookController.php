<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Website;
use Illuminate\Http\Request;
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

        // Buscar la orden
        $order = Order::where('payment_reference', $reference)->first();

        if ($order) {
            $website = Website::find($order->website_id);
            
            if ($website) {
                return redirect()->route('customer.order.show', [
                    'website' => $website->slug,
                    'orderNumber' => $order->order_number
                ]);
            }
        }

        return view('payment.error', [
            'message' => 'No se pudo encontrar la orden asociada a esta transacción.'
        ]);
    }
}
