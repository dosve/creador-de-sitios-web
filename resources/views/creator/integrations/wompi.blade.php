@extends('layouts.creator')

@section('title', 'Integración Wompi')
@section('page-title', 'Integración Wompi')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="p-6 bg-white rounded-lg shadow">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Configuración de Wompi</h2>
                <p class="mt-1 text-sm text-gray-600">Configura la integración con la pasarela de pagos Wompi para procesar pagos en tu sitio web.</p>
            </div>
            <div class="flex items-center space-x-2">
                @if($website->wompi_public_key)
                    <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                    <span class="text-sm text-gray-600">Conectado</span>
                @else
                    <div class="w-3 h-3 bg-yellow-400 rounded-full"></div>
                    <span class="text-sm text-gray-600">No configurado</span>
                @endif
            </div>
        </div>
    </div>

    <!-- Formulario de configuración -->
    <div class="p-6 bg-white rounded-lg shadow">
        <form id="wompi-form" method="POST">
            @csrf
            
            <div class="space-y-6">
                <!-- Public Key -->
                <div>
                    <label for="wompi_public_key" class="block mb-2 text-sm font-medium text-gray-700">
                        Public Key (Llave pública) *
                    </label>
                    <input type="text" 
                           id="wompi_public_key" 
                           name="wompi_public_key" 
                           value="{{ old('wompi_public_key', $website->wompi_public_key) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                           placeholder="pub_test_... o pub_prod_..."
                           required>
                    <p class="mt-1 text-xs text-gray-500">
                        Encuentra esta clave en tu panel de Wompi → Configuración → Llaves API
                        <br>
                        <span class="text-orange-600 font-semibold">⚠️ IMPORTANTE:</span> Para desarrollo local usa <code class="bg-gray-100 px-1 rounded">pub_test_...</code> (claves de prueba)
                    </p>
                </div>

                <!-- Private Key -->
                <div>
                    <label for="wompi_private_key" class="block mb-2 text-sm font-medium text-gray-700">
                        Private Key (Llave privada) *
                    </label>
                    <input type="password" 
                           id="wompi_private_key" 
                           name="wompi_private_key" 
                           value="{{ old('wompi_private_key', $website->wompi_private_key) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                           placeholder="prv_test_... o prv_prod_..."
                           required>
                    <p class="mt-1 text-xs text-gray-500">
                        <span class="text-orange-600 font-semibold">⚠️ Para desarrollo local usa <code class="bg-gray-100 px-1 rounded">prv_test_...</code></span>
                    </p>
                    <p class="mt-1 text-xs text-gray-500">Esta clave es secreta y se usa para validaciones en el servidor</p>
                </div>

                <!-- Event Key -->
                <div>
                    <label for="wompi_event_key" class="block mb-2 text-sm font-medium text-gray-700">
                        Events Secret (Llave de eventos)
                    </label>
                    <input type="password" 
                           id="wompi_event_key" 
                           name="wompi_event_key" 
                           value="{{ old('wompi_event_key', $website->wompi_event_key) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                           placeholder="evt_prod_...">
                    <p class="mt-1 text-xs text-gray-500">Necesaria para recibir notificaciones de eventos (webhooks)</p>
                </div>

                <!-- Integrity Key -->
                <div>
                    <label for="wompi_integrity_key" class="block mb-2 text-sm font-medium text-gray-700">
                        Integrity Key (Llave de integridad)
                    </label>
                    <input type="password" 
                           id="wompi_integrity_key" 
                           name="wompi_integrity_key" 
                           value="{{ old('wompi_integrity_key', $website->wompi_integrity_key) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                           placeholder="int_prod_...">
                    <p class="mt-1 text-xs text-gray-500">Usada para verificar la integridad de las transacciones</p>
                </div>
            </div>

            <!-- Alert -->
            <div id="wompi-alert" class="hidden mt-6"></div>

            <!-- Botones -->
            <div class="flex justify-end mt-8 space-x-3">
                <a href="{{ route('creator.dashboard') }}" 
                   class="px-4 py-2 text-sm font-medium text-gray-700 border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    Cancelar
                </a>
                <button type="submit" 
                        id="save-wompi-btn"
                        class="flex items-center px-6 py-2 text-sm font-medium text-white bg-purple-600 border border-transparent rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    <span id="save-wompi-text">Guardar Configuración</span>
                    <svg id="save-wompi-spinner" class="hidden w-4 h-4 ml-2 animate-spin text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            </div>
        </form>
    </div>

    <!-- Información adicional -->
    <div class="p-6 border border-purple-200 rounded-lg bg-purple-50">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-purple-900">¿Cómo obtener mis credenciales de Wompi?</h3>
                <div class="mt-2 text-sm text-purple-700">
                    <ol class="list-decimal list-inside space-y-1">
                        <li>Ingresa a <a href="https://comercios.wompi.co" target="_blank" rel="noopener noreferrer" class="font-semibold underline">comercios.wompi.co</a></li>
                        <li>Inicia sesión en tu cuenta</li>
                        <li>Ve a <strong>Configuración</strong> → <strong>Llaves API</strong></li>
                        <li>Copia tus llaves de producción (pub_prod_, prv_prod_, etc.)</li>
                        <li>Para webhooks, ve a <strong>Configuración</strong> → <strong>Eventos</strong></li>
                    </ol>
                    <p class="mt-3">
                        <strong>Nota:</strong> Asegúrate de usar las llaves de <strong>producción</strong> (no las de prueba) para transacciones reales.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('wompi-form').addEventListener('submit', async function(e) {
        e.preventDefault();

        const saveBtn = document.getElementById('save-wompi-btn');
        const saveBtnText = document.getElementById('save-wompi-text');
        const saveSpinner = document.getElementById('save-wompi-spinner');
        const alertBox = document.getElementById('wompi-alert');

        // Mostrar estado de carga
        saveBtn.disabled = true;
        saveBtnText.textContent = 'Guardando...';
        saveSpinner.classList.remove('hidden');
        alertBox.classList.add('hidden');

        const formData = {
            wompi_public_key: document.getElementById('wompi_public_key').value.trim(),
            wompi_private_key: document.getElementById('wompi_private_key').value.trim(),
            wompi_event_key: document.getElementById('wompi_event_key').value.trim(),
            wompi_integrity_key: document.getElementById('wompi_integrity_key').value.trim(),
        };

        try {
            const response = await fetch('{{ route('creator.integrations.wompi.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(formData)
            });

            const data = await response.json();

            if (data.success) {
                // Mostrar mensaje de éxito
                alertBox.className = 'p-4 bg-green-50 border border-green-200 rounded-lg flex items-center';
                alertBox.innerHTML = `
                    <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-sm font-medium text-green-800">${data.message}</span>
                `;
                alertBox.classList.remove('hidden');

                // Recargar la página después de 1.5 segundos
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                throw new Error(data.message || 'Error al guardar');
            }
        } catch (error) {
            // Mostrar mensaje de error
            alertBox.className = 'p-4 bg-red-50 border border-red-200 rounded-lg flex items-center';
            alertBox.innerHTML = `
                <svg class="w-5 h-5 text-red-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-sm font-medium text-red-800">${error.message}</span>
            `;
            alertBox.classList.remove('hidden');
        } finally {
            // Restaurar estado del botón
            saveBtn.disabled = false;
            saveBtnText.textContent = 'Guardar Configuración';
            saveSpinner.classList.add('hidden');
        }
    });
</script>
@endpush
@endsection

