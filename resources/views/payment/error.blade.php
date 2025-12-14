<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error en el Pago</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                        error: '#EF4444',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div class="text-center">
                <!-- Ícono de error -->
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-6">
                    <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 18.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Error en el Pago</h2>
                <p class="text-gray-600">{{ $message ?? $error ?? 'Ocurrió un error al procesar el pago' }}</p>
                
                @if(request()->has('ref') || request()->has('id'))
                <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <p class="text-sm text-blue-800">
                        <strong>Referencia de transacción:</strong> {{ request()->input('ref', 'N/A') }}<br>
                        <strong>ID de transacción:</strong> {{ request()->input('id', 'N/A') }}
                    </p>
                    <p class="text-xs text-blue-600 mt-2">
                        Si el pago fue exitoso, guarda esta información y contacta con soporte para que puedan ayudarte a localizar tu pedido.
                    </p>
                </div>
                @endif
            </div>

            <!-- Información del error -->
            @if(isset($details))
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Detalles del Error</h3>
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <p class="text-sm text-red-700">{{ $details }}</p>
                    </div>
                </div>
            @endif

            <!-- Información de ayuda -->
            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">
                            ¿Qué puedes hacer?
                        </h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul class="list-disc list-inside space-y-1">
                                <li>Verifica que tus datos de pago sean correctos</li>
                                <li>Intenta con otro método de pago</li>
                                <li>Contacta con soporte si el problema persiste</li>
                                <li>Verifica que tengas fondos suficientes</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="flex flex-col space-y-3">
                <button onclick="window.location.href = window.location.origin + '/{{ request()->segment(1) ?? '' }}/profile#pedidos';" 
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    Ver Mis Pedidos
                </button>

                <button onclick="window.history.back()" 
                        class="w-full flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    Volver Atrás
                </button>
            </div>
            
            <!-- Script para limpiar carrito si viene de un error después de pago -->
            @if(request()->has('ref') || request()->has('id'))
            <script>
                // Limpiar carrito si el pago fue exitoso pero hubo un error al procesar
                console.log('⚠️ Error después del pago detectado');
                // No limpiamos el carrito aquí porque podría ser un error legítimo
                // Solo registramos para debug
                console.log('Referencia:', '{{ request()->input("ref") }}');
                console.log('ID Transacción:', '{{ request()->input("id") }}');
            </script>
            @endif

            <!-- Información de contacto -->
            <div class="text-center text-sm text-gray-500">
                <p>¿Necesitas ayuda? Contacta con soporte</p>
            </div>
        </div>
    </div>
</body>
</html>
