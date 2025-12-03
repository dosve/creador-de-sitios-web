@extends('layouts.creator')

@section('title', 'Métodos de Pago - ' . $website->name)
@section('page-title', 'Métodos de Pago')
@section('content')
    <!-- Payment Methods Header -->
    <div class="mb-6 bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-medium text-gray-900">Métodos de Pago</h2>
                    <p class="mt-1 text-sm text-gray-600">Configura los métodos de pago disponibles en tu tienda para {{ $website->name }}</p>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ ($website->allow_cash_on_delivery || $website->allow_online_payment) ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                            <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                        </svg>
                        {{ ($website->allow_cash_on_delivery || $website->allow_online_payment) ? 'Configurado' : 'Pendiente' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <form id="payment-methods-form" class="space-y-6">
        @csrf

        <!-- Pago Contra Entrega -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Pago Contra Entrega</h3>
                        <p class="mt-1 text-sm text-gray-600">Permite que los clientes paguen al recibir su pedido</p>
                    </div>
                </div>
            </div>
            <div class="px-6 py-4">
                <div class="space-y-4">
                    <!-- Toggle Pago Contra Entrega -->
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <label for="allow_cash_on_delivery" class="text-sm font-medium text-gray-900">Habilitar pago contra entrega</label>
                            <p class="text-sm text-gray-500">Los clientes podrán elegir pagar en efectivo al recibir su pedido</p>
                        </div>
                        <div class="ml-4">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="allow_cash_on_delivery" name="allow_cash_on_delivery" value="1" 
                                       {{ $website->allow_cash_on_delivery ? 'checked' : '' }}
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                    </div>

                    <!-- Instrucciones para pago contra entrega -->
                    <div id="cash-on-delivery-options" class="{{ $website->allow_cash_on_delivery ? '' : 'hidden' }}">
                        <div>
                            <label for="cash_on_delivery_instructions" class="block text-sm font-medium text-gray-700 mb-2">
                                Instrucciones para el cliente
                            </label>
                            <textarea id="cash_on_delivery_instructions" 
                                      name="cash_on_delivery_instructions" 
                                      rows="4" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                      placeholder="Ej. El pago se realizará al momento de la entrega. Por favor tenga el monto exacto.">{{ $website->cash_on_delivery_instructions }}</textarea>
                            <p class="mt-1 text-xs text-gray-500">Estas instrucciones se mostrarán al cliente durante el checkout</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pago en Línea (Pasarelas) -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Pago en Línea (Pasarelas)</h3>
                        <p class="mt-1 text-sm text-gray-600">Permite pagos con tarjeta de crédito, débito, PSE y más a través de ePayco o Wompi</p>
                    </div>
                    @if($website->epayco_public_key)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Configurado
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            No configurado
                        </span>
                    @endif
                </div>
            </div>
            <div class="px-6 py-4">
                <div class="space-y-4">
                    <!-- Toggle Pago en Línea -->
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <label for="allow_online_payment" class="text-sm font-medium text-gray-900">Habilitar pagos en línea</label>
                            <p class="text-sm text-gray-500">Los clientes podrán pagar con tarjeta, PSE y otros métodos a través de ePayco</p>
                        </div>
                        <div class="ml-4">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="allow_online_payment" name="allow_online_payment" value="1" 
                                       {{ $website->allow_online_payment ? 'checked' : '' }}
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                    </div>

                    <!-- Selección de Pasarela por defecto -->
                    <div id="online-payment-options" class="{{ $website->allow_online_payment ? '' : 'hidden' }}">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Pasarela de pago preferida</label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- ePayco -->
                                <label class="relative flex items-start p-4 border-2 rounded-lg cursor-pointer hover:bg-gray-50 {{ $website->epayco_public_key ? 'border-blue-500 bg-blue-50' : 'border-gray-300' }}">
                                    <input type="radio" name="default_payment_gateway" value="epayco" 
                                           {{ $website->default_payment_gateway == 'epayco' ? 'checked' : '' }}
                                           {{ !$website->epayco_public_key ? 'disabled' : '' }}
                                           class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500">
                                    <div class="ml-3 flex-1">
                                        <div class="flex items-center justify-between">
                                            <span class="block text-sm font-medium text-gray-900">ePayco</span>
                                            @if($website->epayco_public_key)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Configurado
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600">
                                                    No configurado
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">Tarjetas, PSE, efectivo en puntos autorizados</p>
                                        @if(!$website->epayco_public_key)
                                            <a href="{{ route('creator.integrations.epayco') }}" class="text-xs text-blue-600 hover:text-blue-800 mt-1 inline-block">
                                                Configurar ePayco →
                                            </a>
                                        @endif
                                    </div>
                                </label>

                                <!-- Wompi -->
                                <label class="relative flex items-start p-4 border-2 rounded-lg cursor-pointer hover:bg-gray-50 {{ $website->wompi_public_key ? 'border-purple-500 bg-purple-50' : 'border-gray-300' }}">
                                    <input type="radio" name="default_payment_gateway" value="wompi" 
                                           {{ $website->default_payment_gateway == 'wompi' ? 'checked' : '' }}
                                           {{ !$website->wompi_public_key ? 'disabled' : '' }}
                                           class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500">
                                    <div class="ml-3 flex-1">
                                        <div class="flex items-center justify-between">
                                            <span class="block text-sm font-medium text-gray-900">Wompi</span>
                                            @if($website->wompi_public_key)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Configurado
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600">
                                                    No configurado
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">Tarjetas, PSE, Nequi, Bancolombia</p>
                                        @if(!$website->wompi_public_key)
                                            <button type="button" onclick="alert('La integración de Wompi estará disponible próximamente')" class="text-xs text-purple-600 hover:text-purple-800 mt-1 inline-block">
                                                Configurar Wompi →
                                            </button>
                                        @endif
                                    </div>
                                </label>
                            </div>
                            
                            @if(!$website->epayco_public_key && !$website->wompi_public_key)
                                <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg mt-4">
                                    <div class="flex">
                                        <svg class="w-5 h-5 text-yellow-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        <div>
                                            <p class="text-sm font-medium text-yellow-800">Ninguna pasarela configurada</p>
                                            <p class="mt-1 text-sm text-yellow-700">
                                                Para habilitar pagos en línea, configura al menos una pasarela:
                                                <a href="{{ route('creator.integrations.epayco') }}" class="font-semibold underline hover:text-yellow-900">
                                                    ePayco
                                                </a> (disponible ahora)
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                    <!-- Opciones adicionales para pago en línea -->
                    <div id="online-payment-options" class="{{ $website->allow_online_payment ? '' : 'hidden' }}">
                        <div class="flex items-center justify-between p-4 bg-gray-50 border border-gray-200 rounded-lg">
                            <div class="flex-1">
                                <label for="require_payment_before_shipping" class="text-sm font-medium text-gray-900">Requiere pago antes de enviar</label>
                                <p class="text-sm text-gray-500">El pedido solo se procesará después de recibir el pago</p>
                            </div>
                            <div class="ml-4">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" id="require_payment_before_shipping" name="require_payment_before_shipping" value="1" 
                                           {{ $website->require_payment_before_shipping ? 'checked' : '' }}
                                           class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información de ayuda -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <div class="flex">
                <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <div class="text-sm text-blue-700">
                    <p class="font-semibold mb-1">¿Cómo funcionan los métodos de pago?</p>
                    <ul class="list-disc list-inside space-y-1 ml-2">
                        <li><strong>Pago contra entrega:</strong> El cliente paga en efectivo cuando recibe su pedido</li>
                        <li><strong>Pago en línea:</strong> El cliente paga inmediatamente con tarjeta, PSE u otros métodos a través de ePayco</li>
                        <li>Puedes habilitar uno o ambos métodos según las necesidades de tu negocio</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Alert de error/éxito -->
        <div id="payment-alert" class="hidden"></div>

        <!-- Botones de acción -->
        <div class="flex justify-end space-x-3">
            <a href="{{ route('creator.dashboard') }}" class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                Cancelar
            </a>
            <button type="submit" id="save-btn" class="flex items-center justify-center px-6 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                <span id="save-btn-text">Guardar Cambios</span>
                <svg id="save-spinner" class="hidden w-5 h-5 ml-2 animate-spin text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </button>
        </div>
    </form>

    @push('scripts')
    <script>
        // Mostrar/ocultar opciones según el toggle
        document.getElementById('allow_cash_on_delivery').addEventListener('change', function() {
            const options = document.getElementById('cash-on-delivery-options');
            if (this.checked) {
                options.classList.remove('hidden');
            } else {
                options.classList.add('hidden');
            }
        });

        document.getElementById('allow_online_payment').addEventListener('change', function() {
            const options = document.getElementById('online-payment-options');
            if (this.checked) {
                options.classList.remove('hidden');
            } else {
                options.classList.add('hidden');
            }
        });

        // Enviar formulario
        document.getElementById('payment-methods-form').addEventListener('submit', async function(e) {
            e.preventDefault();

            const saveBtn = document.getElementById('save-btn');
            const saveBtnText = document.getElementById('save-btn-text');
            const saveSpinner = document.getElementById('save-spinner');
            const alertBox = document.getElementById('payment-alert');

            // Mostrar estado de carga
            saveBtn.disabled = true;
            saveBtnText.textContent = 'Guardando...';
            saveSpinner.classList.remove('hidden');
            alertBox.classList.add('hidden');

            const selectedGateway = document.querySelector('input[name="default_payment_gateway"]:checked');
            
            const formData = {
                allow_cash_on_delivery: document.getElementById('allow_cash_on_delivery').checked,
                allow_online_payment: document.getElementById('allow_online_payment').checked,
                require_payment_before_shipping: document.getElementById('require_payment_before_shipping').checked,
                cash_on_delivery_instructions: document.getElementById('cash_on_delivery_instructions').value.trim(),
                default_payment_gateway: selectedGateway ? selectedGateway.value : 'epayco',
            };

            try {
                const response = await fetch('{{ route('creator.config.payment-methods.update') }}', {
                    method: 'PUT',
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
                saveBtnText.textContent = 'Guardar Cambios';
                saveSpinner.classList.add('hidden');
            }
        });
    </script>
    @endpush
@endsection

