<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago Pendiente</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                        warning: '#F59E0B',
                        success: '#10B981',
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
                <!-- Ícono de pendiente -->
                <div class="flex items-center justify-center w-16 h-16 mx-auto mb-6 bg-yellow-100 rounded-full">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h2 class="mb-2 text-3xl font-bold text-gray-900">Pago Pendiente</h2>
                <p class="text-gray-600">Tu pago está siendo procesado</p>
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
                </div>
            </div>

            <!-- Información de estado pendiente -->
            <div class="p-4 border border-yellow-200 rounded-lg bg-yellow-50">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800">
                            Procesamiento en Curso
                        </h3>
                        <div class="mt-2 text-sm text-yellow-700">
                            <p>Tu pago está siendo verificado por el banco. Este proceso puede tomar unos minutos.</p>
                            <p class="mt-2 font-medium">Recibirás una notificación cuando el pago sea confirmado.</p>
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
                            ¿Qué significa esto?
                        </h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <ul class="list-disc list-inside space-y-1">
                                <li>Tu transacción fue recibida correctamente</li>
                                <li>Está siendo procesada por el banco emisor</li>
                                <li>Puede tomar entre 5-30 minutos</li>
                                <li>Recibirás un correo de confirmación</li>
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

                <button onclick="location.reload()" 
                        class="flex justify-center w-full px-4 py-2 text-sm font-medium text-white transition-colors bg-yellow-600 border border-transparent rounded-md shadow-sm hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                    Verificar Estado
                </button>
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

    <!-- Script para verificación automática -->
    <script>
        // Verificar el estado cada 30 segundos
        let checkCount = 0;
        const maxChecks = 20; // Máximo 10 minutos

        function checkPaymentStatus() {
            if (checkCount >= maxChecks) {
                return;
            }
            
            checkCount++;
            
            // Aquí podrías hacer una petición AJAX para verificar el estado
            // Por ahora solo mostramos un mensaje
            console.log(`Verificando estado del pago... (${checkCount}/${maxChecks})`);
        }

        // Iniciar verificación automática después de 30 segundos
        setTimeout(() => {
            setInterval(checkPaymentStatus, 30000);
        }, 30000);
    </script>
</body>
</html>
