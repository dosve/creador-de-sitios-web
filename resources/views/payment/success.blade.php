<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago Exitoso</title>
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
                <!-- Ícono de éxito -->
                <div class="flex items-center justify-center w-16 h-16 mx-auto mb-6 bg-green-100 rounded-full">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h2 class="mb-2 text-3xl font-bold text-gray-900">¡Pago Exitoso!</h2>
                <p class="text-gray-600">Tu pago ha sido procesado correctamente</p>
            </div>

            <!-- Información del pago -->
            <div class="p-6 bg-white rounded-lg shadow-lg">
                <h3 class="mb-4 text-lg font-semibold text-gray-900">Detalles del Pago</h3>
                
                <div class="space-y-3">
                    @if($refPayco)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Referencia:</span>
                            <span class="font-medium text-gray-900">{{ $refPayco }}</span>
                        </div>
                    @endif

                    @if(isset($paymentData['transaction_id']))
                        <div class="flex justify-between">
                            <span class="text-gray-600">ID Transacción:</span>
                            <span class="font-medium text-gray-900">{{ $paymentData['transaction_id'] }}</span>
                        </div>
                    @endif

                    @if(isset($paymentData['amount']))
                        <div class="flex justify-between">
                            <span class="text-gray-600">Monto:</span>
                            <span class="font-medium text-gray-900">
                                ${{ number_format($paymentData['amount'], 2) }} {{ $paymentData['currency'] ?? 'COP' }}
                            </span>
                        </div>
                    @endif

                    @if(isset($paymentData['invoice']))
                        <div class="flex justify-between">
                            <span class="text-gray-600">Factura:</span>
                            <span class="font-medium text-gray-900">{{ $paymentData['invoice'] }}</span>
                        </div>
                    @endif

                    @if(isset($paymentData['order']))
                        <div class="flex justify-between">
                            <span class="text-gray-600">Orden:</span>
                            <span class="font-medium text-gray-900">#{{ $paymentData['order']->order_number }}</span>
                        </div>
                    @endif

                    @if(isset($paymentData['epayco_data']['payment_method']))
                        <div class="flex justify-between">
                            <span class="text-gray-600">Método:</span>
                            <span class="font-medium text-gray-900">{{ $paymentData['epayco_data']['payment_method'] }}</span>
                        </div>
                    @endif

                    @if(isset($paymentData['epayco_data']['approval_code']))
                        <div class="flex justify-between">
                            <span class="text-gray-600">Código Aprobación:</span>
                            <span class="font-medium text-gray-900">{{ $paymentData['epayco_data']['approval_code'] }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Información de confirmación -->
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
                            <p>Tu transacción ha sido aprobada exitosamente.</p>
                            <p class="mt-1">Recibirás un correo de confirmación con todos los detalles de tu compra.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información adicional -->
            <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">
                            Próximos Pasos
                        </h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <ul class="list-disc list-inside space-y-1">
                                <li>Revisa tu correo electrónico para el comprobante</li>
                                <li>Guarda tu referencia de pago: <strong>{{ $refPayco }}</strong></li>
                                <li>Tu pedido será procesado en breve</li>
                                <li>Recibirás actualizaciones por email</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

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

                @if(isset($paymentData['order']))
                    <a href="#" 
                       class="flex justify-center w-full px-4 py-2 text-sm font-medium text-white transition-colors bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Ver Detalles del Pedido
                    </a>
                @endif
            </div>

            <!-- Información de contacto -->
            <div class="text-sm text-center text-gray-500">
                <p>¿Necesitas ayuda? Contacta con soporte</p>
                @if(isset($paymentData['website']) && $paymentData['website'])
                    <p>{{ $paymentData['website']->domain ?? 'Tu tienda' }}</p>
                @endif
            </div>

            <!-- Información de referencia -->
            <div class="p-3 bg-gray-100 rounded-lg">
                <p class="text-xs text-center text-gray-600">
                    <strong>Referencia de Pago:</strong> {{ $refPayco }}
                </p>
                @if(isset($paymentData['epayco_data']['transaction_date']))
                    <p class="text-xs text-center text-gray-600 mt-1">
                        <strong>Fecha:</strong> {{ $paymentData['epayco_data']['transaction_date'] }}
                    </p>
                @endif
            </div>
        </div>
    </div>

    <!-- Script para manejar el cierre automático opcional -->
    <script>
        // Opcional: cerrar automáticamente después de 30 segundos
        // setTimeout(() => {
        //     if (confirm('¿Deseas cerrar esta ventana?')) {
        //         window.close();
        //     }
        // }, 30000);

        // Mostrar animación de éxito
        document.addEventListener('DOMContentLoaded', function() {
            // Agregar efecto de pulso al ícono de éxito
            const successIcon = document.querySelector('.bg-green-100');
            if (successIcon) {
                successIcon.classList.add('animate-pulse');
                setTimeout(() => {
                    successIcon.classList.remove('animate-pulse');
                }, 2000);
            }
        });
    </script>
</body>
</html>
