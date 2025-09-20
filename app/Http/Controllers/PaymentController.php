<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Website;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    /**
     * Manejar respuesta de pago de ePayco con validaciones robustas
     */
    public function handleResponse(Request $request)
    {
        $refPayco = $request->get('ref_payco');
        $xInvoice = $request->get('x_invoice');

        // Log de la respuesta recibida para debugging
        Log::info('Respuesta de pago recibida', [
            'all_params' => $request->all(),
            'ref_payco' => $refPayco,
            'x_invoice' => $xInvoice,
        ]);

        // Validación 1: Verificar que ref_payco esté presente
        if (!$refPayco || $refPayco === 'undefined') {
            return $this->redirectToError([
                'ref_payco' => $refPayco,
                'x_invoice' => $xInvoice,
                'message' => 'Referencia de pago no válida o faltante'
            ]);
        }

        // Validación 2: Verificar que ref_payco sea alfanumérico y en minúsculas
        if (!ctype_alnum($refPayco) || $refPayco !== strtolower($refPayco)) {
            return $this->redirectToError([
                'ref_payco' => $refPayco,
                'x_invoice' => $xInvoice,
                'message' => 'Referencia de pago debe contener solo letras y números en minúsculas'
            ]);
        }

        // Validación 3: Verificar que x_invoice esté presente (si se usa)
        if ($xInvoice && ($xInvoice === 'undefined' || empty($xInvoice))) {
            return $this->redirectToError([
                'ref_payco' => $refPayco,
                'x_invoice' => $xInvoice,
                'message' => 'Número de factura no válido o faltante'
            ]);
        }

        try {
            // Validación 4: Verificar la transacción con ePayco
            $response = Http::get("https://secure.epayco.co/validation/v1/reference/{$refPayco}");

            if (!$response->successful()) {
                return $this->redirectToError([
                    'ref_payco' => $refPayco,
                    'x_invoice' => $xInvoice,
                    'message' => 'Error al validar la transacción con ePayco'
                ]);
            }

            $data = $response->json();
            
            if (!isset($data['success']) || $data['success'] !== true) {
                return $this->redirectToError([
                    'ref_payco' => $refPayco,
                    'x_invoice' => $xInvoice,
                    'message' => 'La transacción no fue aprobada por ePayco'
                ]);
            }

            // Transacción válida, extraer datos de ePayco
            $epaycoData = $data['data'] ?? [];
            $trueRefPayco = $epaycoData['x_ref_payco'] ?? $refPayco;
            
            // Buscar la orden por la referencia de pago
            $order = null;
            if ($xInvoice) {
                $order = Order::where('payment_reference', $xInvoice)->first();
            }

            // Extraer datos importantes de la respuesta de ePayco
            $transactionId = $epaycoData['x_transaction_id'] ?? null;
            $invoiceNumber = $epaycoData['x_id_invoice'] ?? $xInvoice;
            $amount = $epaycoData['x_amount'] ?? null;
            $approvalCode = $epaycoData['x_approval_code'] ?? null;
            $franchise = $epaycoData['x_franchise'] ?? null;
            $cardNumber = $epaycoData['x_cardnumber'] ?? null;
            $transactionDate = $epaycoData['x_fecha_transaccion'] ?? null;
            $description = $epaycoData['x_description'] ?? null;
            $bank = $epaycoData['x_bank_name'] ?? null;
            $statusDetail = $epaycoData['x_transaction_state'] ?? null;
            $taxAmount = $epaycoData['x_tax'] ?? null;
            $consumptionTax = $epaycoData['x_tax_ico'] ?? null;
            $authorizationCode = $epaycoData['x_approval_code'] ?? null;

            // Determinar el método de pago
            $paymentMethod = $this->determinePaymentMethod($epaycoData);

            // Determinar si el pago fue exitoso
            $isSuccess = $statusDetail === 'Aceptada';
            $isPending = $statusDetail === 'Pendiente';

            // Actualizar la orden si existe
            if ($order) {
                $newPaymentStatus = $isSuccess ? 'paid' : ($isPending ? 'pending' : 'failed');
                
                $order->update([
                    'payment_status' => $newPaymentStatus,
                    'payment_reference' => $trueRefPayco,
                    'payment_method' => $paymentMethod,
                ]);
            }

            // Preparar datos para la vista
            $paymentData = [
                'success' => $isSuccess,
                'pending' => $isPending,
                'ref_payco' => $trueRefPayco,
                'transaction_id' => $transactionId,
                'amount' => $amount,
                'currency' => $epaycoData['x_currency_code'] ?? 'COP',
                'invoice' => $invoiceNumber,
                'response_reason' => $statusDetail,
                'order' => $order,
                'website' => $order ? $order->website : null,
                'epayco_data' => [
                    'approval_code' => $approvalCode,
                    'franchise' => $franchise,
                    'card_number' => $cardNumber,
                    'transaction_date' => $transactionDate,
                    'description' => $description,
                    'bank' => $bank,
                    'tax_amount' => $taxAmount,
                    'consumption_tax' => $consumptionTax,
                    'authorization_code' => $authorizationCode,
                    'payment_method' => $paymentMethod
                ]
            ];

            // Redirigir según el estado
            if ($isPending) {
                return redirect()->route('payment.pending', [
                    'ref_payco' => $trueRefPayco,
                    'status' => 'pending'
                ])->with('paymentData', $paymentData);
            }

            if ($isSuccess) {
                return redirect()->route('payment.success', [
                    'ref_payco' => $trueRefPayco,
                    'status' => 'success'
                ])->with('paymentData', $paymentData);
            }

            // Si no es exitoso ni pendiente, mostrar error
            return $this->redirectToError([
                'ref_payco' => $refPayco,
                'x_invoice' => $xInvoice,
                'message' => 'La transacción fue rechazada'
            ]);

        } catch (\Exception $e) {
            Log::error('Error procesando respuesta de pago', [
                'error' => $e->getMessage(),
                'params' => $request->all()
            ]);

            return $this->redirectToError([
                'ref_payco' => $refPayco,
                'x_invoice' => $xInvoice,
                'message' => 'Error interno del servidor durante la validación'
            ]);
        }
    }

    /**
     * Página de confirmación de pago exitoso
     */
    public function success(Request $request)
    {
        $refPayco = $request->get('ref_payco');
        $paymentData = session('paymentData');
        
        return view('payment.success', compact('refPayco', 'paymentData'));
    }

    /**
     * Página de pago pendiente
     */
    public function pending(Request $request)
    {
        $refPayco = $request->get('ref_payco');
        $paymentData = session('paymentData');
        
        return view('payment.pending', compact('refPayco', 'paymentData'));
    }

    /**
     * Página de error de pago
     */
    public function error(Request $request)
    {
        $error = $request->get('message', 'Error en el procesamiento del pago');
        $refPayco = $request->get('ref_payco');
        $xInvoice = $request->get('x_invoice');
        
        return view('payment.error', compact('error', 'refPayco', 'xInvoice'));
    }

    /**
     * Método auxiliar para redirigir a error
     */
    private function redirectToError(array $data)
    {
        return redirect()->route('payment.error', $data);
    }

    /**
     * Determinar el método de pago basándose en los datos de ePayco
     */
    private function determinePaymentMethod(array $epaycoData)
    {
        $franchise = $epaycoData['x_franchise'] ?? '';
        $bank = $epaycoData['x_bank_name'] ?? '';
        
        // Mapear franquicias a métodos de pago
        $paymentMethods = [
            'VISA' => 'Tarjeta de Crédito Visa',
            'MASTERCARD' => 'Tarjeta de Crédito Mastercard',
            'AMEX' => 'Tarjeta de Crédito American Express',
            'DINERS' => 'Tarjeta de Crédito Diners',
            'PSE' => 'PSE',
            'BANCOLOMBIA_TRANSFERENCIA' => 'Transferencia Bancaria',
            'EFECTY' => 'Efecty',
            'BALOTO' => 'Baloto',
            'GANA' => 'Gana',
            'REDSER' => 'RedServi',
            'CASH_ON_DELIVERY' => 'Contra Entrega',
        ];

        // Buscar método de pago por franquicia
        if (isset($paymentMethods[$franchise])) {
            return $paymentMethods[$franchise];
        }

        // Si no se encuentra por franquicia, usar el banco
        if ($bank) {
            return "Transferencia - {$bank}";
        }

        // Método por defecto
        return $franchise ?: 'Método de Pago Desconocido';
    }
}
