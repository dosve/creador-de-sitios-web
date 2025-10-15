<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Autenticando... - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center">
    <div class="text-center">
        <!-- Spinner de carga -->
        <div class="mb-8">
            <svg class="animate-spin h-16 w-16 text-indigo-600 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>

        <!-- Mensaje -->
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">
                Autenticando con Auth EME10
            </h2>
            <p class="text-gray-600 mb-4" id="status-message">
                Procesando tu autenticación...
            </p>
            <div class="text-sm text-gray-500">
                Por favor espera un momento
            </div>
        </div>

        <!-- Mensaje de error (oculto por defecto) -->
        <div id="error-container" class="hidden max-w-md mx-auto mt-4 bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex items-start">
                <svg class="h-6 w-6 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h3 class="text-sm font-medium text-red-800">Error de autenticación</h3>
                    <p class="text-sm text-red-700 mt-1" id="error-message"></p>
                    <a href="{{ route('login') }}" class="inline-block mt-3 text-sm font-medium text-red-600 hover:text-red-500">
                        Volver a intentar →
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        /**
         * Procesar callback OAuth2
         * El token puede venir en el hash (#) o en query parameters (?)
         */
        async function handleOAuthCallback() {
            try {
                console.log('🔍 Debug OAuth Callback:');
                console.log('Hash:', window.location.hash);
                console.log('Search:', window.location.search);
                console.log('URL completa:', window.location.href);
                
                let params;
                
                // Verificar si el token viene en el hash (estándar OAuth2)
                if (window.location.hash.includes('access_token')) {
                    console.log('✅ Token encontrado en hash');
                    const hash = window.location.hash.substring(1);
                    params = new URLSearchParams(hash);
                } 
                // Si no, verificar si viene en query parameters (Auth EME10)
                else if (window.location.search.includes('access_token')) {
                    console.log('✅ Token encontrado en search parameters');
                    params = new URLSearchParams(window.location.search);
                }
                // Si no hay token en ningún lado, error
                else {
                    console.log('❌ No se encontró token en hash ni search');
                    showError('No se recibieron parámetros de autenticación. Por favor inicia sesión nuevamente.');
                    return;
                }
                
                const accessToken = params.get('access_token');
                const state = params.get('state');
                const tokenType = params.get('token_type');
                const expiresIn = params.get('expires_in');
                
                console.log('📋 Parámetros extraídos:');
                console.log('Access Token:', accessToken ? '✅ Presente' : '❌ Ausente');
                console.log('State:', state ? '✅ Presente' : '❌ Ausente');
                console.log('Token Type:', tokenType);
                console.log('Expires In:', expiresIn);
                
                // TEMPORAL: Ignorar expiración negativa (problema de Auth EME10)
                if (expiresIn && parseInt(expiresIn) < 0) {
                    console.log('⚠️ Token con expiración negativa detectado - ignorando validación temporalmente');
                }
                
                // Verificar si hay error
                const error = params.get('error');
                const errorDescription = params.get('error_description');
                
                if (error) {
                    showError(`Error de autorización: ${errorDescription || error}`);
                    return;
                }
                
                if (!accessToken || !state) {
                    showError('No se recibió el token de acceso. Por favor intenta nuevamente.');
                    return;
                }
                
                updateStatus('Validando token...');
                
                // Enviar token al backend para procesar
                const response = await fetch('{{ route('oauth.handle-token') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        access_token: accessToken,
                        state: state,
                        token_type: tokenType,
                        expires_in: expiresIn
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    updateStatus('¡Autenticación exitosa! Redirigiendo...');
                    
                    // Limpiar el hash de la URL
                    window.history.replaceState({}, document.title, window.location.pathname);
                    
                    // Redirigir al dashboard
                    setTimeout(() => {
                        window.location.href = data.redirect_url;
                    }, 500);
                } else {
                    showError(data.message || 'Error al procesar la autenticación');
                }
                
            } catch (error) {
                console.error('Error en callback OAuth:', error);
                showError('Error de conexión. Por favor intenta nuevamente.');
            }
        }
        
        /**
         * Actualizar mensaje de estado
         */
        function updateStatus(message) {
            const statusEl = document.getElementById('status-message');
            if (statusEl) {
                statusEl.textContent = message;
            }
        }
        
        /**
         * Mostrar error
         */
        function showError(message) {
            const errorContainer = document.getElementById('error-container');
            const errorMessage = document.getElementById('error-message');
            
            if (errorContainer && errorMessage) {
                errorMessage.textContent = message;
                errorContainer.classList.remove('hidden');
            }
            
            // Ocultar spinner
            const spinner = document.querySelector('.animate-spin');
            if (spinner) {
                spinner.parentElement.style.display = 'none';
            }
        }
        
        // Ejecutar al cargar la página
        if (window.location.hash.includes('access_token') || window.location.search.includes('access_token')) {
            handleOAuthCallback();
        } else if (window.location.hash.includes('error') || window.location.search.includes('error')) {
            handleOAuthCallback();
        } else {
            showError('No se recibieron parámetros de autenticación. Por favor inicia sesión nuevamente.');
        }
    </script>
</body>
</html>

