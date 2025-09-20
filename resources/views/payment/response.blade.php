<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Respuesta de Pago - {{ $paymentData['success'] ? 'Exitoso' : 'Error' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                        success: '#10B981',
                        error: '#EF4444',
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-screen bg-gray-50">
    <div class="flex items-center justify-center min-h-screen px-4 py-12 sm:px-6 lg:px-8">
        <div class="w-full max-w-md space-y-8">
            <div class="text-center">
                @if($paymentData['success'])
                    <!-- Ícono de éxito -->
                    <div class="flex items-center justify-center w-16 h-16 mx-auto mb-6 bg-green-100 rounded-full">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h2 class="mb-2 text-3xl font-bold text-gray-900">¡Pago Exitoso!</h2>
                    <p class="text-gray-600">Tu pago ha sido procesado correctamente</p>
                @else
                    <!-- Ícono de error -->
                    <div class="flex items-center justify-center w-16 h-16 mx-auto mb-6 bg-red-100 rounded-full">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <h2 class="mb-2 text-3xl font-bold text-gray-900">Pago Declinado</h2>
                    <p class="text-gray-600">{{ $paymentData['response_reason'] ?? 'El pago no pudo ser procesado' }}</p>
                @endif
            </div>

            <!-- Información del pago -->
            <div class="p-6 bg-white rounded-lg shadow-lg">
                <h3 class="mb-4 text-lg font-semibold text-gray-900">Detalles del Pago</h3>
                
                <div class="space-y-3">
                    @if($paymentData['ref_payco'])
                        <div class="flex justify-between">
                            <span class="text-gray-600">Referencia:</span>
                            <span class="font-medium text-gray-900">{{ $paymentData['ref_payco'] }}</span>
                        </div>
                    @endif

                    @if($paymentData['transaction_id'])
                        <div class="flex justify-between">
                            <span class="text-gray-600">ID Transacción:</span>
                            <span class="font-medium text-gray-900">{{ $paymentData['transaction_id'] }}</span>
                        </div>
                    @endif

                    @if($paymentData['amount'])
                        <div class="flex justify-between">
                            <span class="text-gray-600">Monto:</span>
                            <span class="font-medium text-gray-900">
                                ${{ number_format($paymentData['amount'], 2) }} {{ $paymentData['currency'] ?? 'COP' }}
                            </span>
                        </div>
                    @endif

                    @if($paymentData['invoice'])
                        <div class="flex justify-between">
                            <span class="text-gray-600">Factura:</span>
                            <span class="font-medium text-gray-900">{{ $paymentData['invoice'] }}</span>
                        </div>
                    @endif

                    @if($paymentData['order'])
                        <div class="flex justify-between">
                            <span class="text-gray-600">Orden:</span>
                            <span class="font-medium text-gray-900">#{{ $paymentData['order']->order_number }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Información adicional -->
            @if($paymentData['success'])
                <div class="p-4 border border-green-200 rounded-lg bg-green-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-green-800">
                                Pago Confirmado
                            </h3>
                            <div class="mt-2 text-sm text-green-700">
                                <p>Recibirás un correo de confirmación con los detalles de tu compra.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="p-4 border border-red-200 rounded-lg bg-red-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">
                                Pago No Procesado
                            </h3>
                            <div class="mt-2 text-sm text-red-700">
                                <p>Puedes intentar nuevamente o contactar con soporte si el problema persiste.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Botones de acción -->
            <div class="flex flex-col space-y-3">
                @if(isset($paymentData['website']) && $paymentData['website'])
                    <a href="{{ route('creator.preview.index', $paymentData['website']) }}" 
                       class="flex justify-center w-full px-4 py-2 text-sm font-medium text-white transition-colors bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Volver a la Tienda
                    </a>
                @endif

                <button onclick="window.close()" 
                        class="flex justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Cerrar Ventana
                </button>

                @if(!$paymentData['success'])
                    <button onclick="window.history.back()" 
                            class="flex justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Intentar Nuevamente
                    </button>
                @endif
            </div>

            <!-- Información de contacto -->
            <div class="text-sm text-center text-gray-500">
                <p>¿Necesitas ayuda? Contacta con soporte</p>
                @if(isset($paymentData['website']) && $paymentData['website'])
                    <p>{{ $paymentData['website']->domain ?? 'Tu tienda' }}</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Script para manejar el cierre automático en caso de pago exitoso -->
    @if($paymentData['success'])
        <script>
            // Opcional: cerrar automáticamente después de 10 segundos
            // setTimeout(() => {
            //     window.close();
            // }, 10000);
        </script>
    @endif
</body>
</html>
