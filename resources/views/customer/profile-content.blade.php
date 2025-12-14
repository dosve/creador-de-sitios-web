{{-- Contenido de Mi Perfil --}}
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4 max-w-5xl">
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Mi Perfil</h1>
            <p class="text-gray-600">Gestiona tu información personal, seguridad y direcciones</p>
        </div>

        {{-- Tabs de navegación --}}
        <div class="mb-6">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8">
                    <button class="profile-tab border-b-2 border-blue-500 py-4 px-1 text-sm font-medium text-blue-600" data-tab="datos">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Datos Personales
                    </button>
                    <button class="profile-tab border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="seguridad">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Seguridad
                    </button>
                    <button class="profile-tab border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="direcciones">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Direcciones
                    </button>
                    <button class="profile-tab border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="pedidos">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Mis Pedidos
                    </button>
                </nav>
            </div>
        </div>

        {{-- Contenido de los tabs --}}
        
        {{-- Tab: Datos Personales --}}
        <div id="tab-datos" class="tab-content">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Datos Personales</h2>
                    
                    <form id="profile-form" class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nombre Completo
                            </label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                value="{{ $customerData['name'] ?? '' }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required
                            >
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email
                            </label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                value="{{ $customerData['email'] ?? '' }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed"
                                disabled
                            >
                            <p class="mt-1 text-xs text-gray-500">El email no se puede cambiar</p>
                        </div>
                        
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                Teléfono
                            </label>
                            <input 
                                type="tel" 
                                id="phone" 
                                name="phone" 
                                value="{{ $customerData['phone'] ?? '' }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required
                            >
                        </div>
                        
                        <div id="profile-message" class="hidden"></div>
                        
                        <button 
                            type="submit" 
                            class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors"
                        >
                            Guardar Cambios
                        </button>
                    </form>
            </div>
        </div>

        {{-- Tab: Seguridad --}}
        <div id="tab-seguridad" class="tab-content hidden">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Cambiar Contraseña</h2>
                    
                    <form id="password-form" class="space-y-4">
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                                Contraseña Actual
                            </label>
                            <input 
                                type="password" 
                                id="current_password" 
                                name="current_password" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required
                            >
                        </div>
                        
                        <div>
                            <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">
                                Nueva Contraseña
                            </label>
                            <input 
                                type="password" 
                                id="new_password" 
                                name="new_password" 
                                minlength="6"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required
                            >
                            <p class="mt-1 text-xs text-gray-500">Mínimo 6 caracteres</p>
                        </div>
                        
                        <div>
                            <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                Confirmar Nueva Contraseña
                            </label>
                            <input 
                                type="password" 
                                id="new_password_confirmation" 
                                name="new_password_confirmation" 
                                minlength="6"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required
                            >
                        </div>
                        
                        <div id="password-message" class="hidden"></div>
                        
                        <button 
                            type="submit" 
                            class="w-full bg-red-600 text-white py-3 rounded-lg font-semibold hover:bg-red-700 transition-colors"
                        >
                            Cambiar Contraseña
                        </button>
                    </form>
            </div>
        </div>

        {{-- Tab: Direcciones --}}
        <div id="tab-direcciones" class="tab-content hidden">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-900">Mis Direcciones</h2>
                    <button id="add-address-btn" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Agregar Dirección
                    </button>
                </div>

                <div id="addresses-list">
                @if(isset($addresses) && $addresses->count() > 0)
                    <div class="grid grid-cols-1 gap-4">
                        @foreach($addresses as $address)
                        <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-200 transition-colors bg-gray-50">
                            <div class="flex items-start justify-between mb-3">
                                <div>
                                    <p class="text-sm uppercase text-gray-500 font-semibold">
                                        {{ $address->name ?? 'Dirección' }}
                                    </p>
                                    <p class="text-base font-semibold text-gray-900">
                                        {{ $address->address }}
                                    </p>
                                </div>
                                @if($address->is_primary)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-700">
                                        Principal
                                    </span>
                                @endif
                            </div>

                            <div class="text-sm text-gray-600 space-y-1">
                                <p>{{ $address->city }} @if($address->state) - {{ $address->state }} @endif</p>
                                @if(!empty($address->reference))
                                    <p class="text-gray-500">Referencia: {{ $address->reference }}</p>
                                @endif
                                @if(!empty($address->phone))
                                    <p class="text-gray-500">Teléfono: {{ $address->phone }}</p>
                                @endif
                                <p class="text-gray-500">
                                    Registrada el {{ optional($address->created_at)->format('d/m/Y') ?? 'N/A' }}
                                </p>
                            </div>

                            <div class="mt-4 flex items-center justify-between text-sm">
                                <button class="text-blue-600 hover:text-blue-700 font-medium">
                                    Editar
                                </button>
                                <button class="text-red-600 hover:text-red-700 font-medium">
                                    Eliminar
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">No tienes direcciones guardadas</h3>
                        <p class="text-gray-600 mb-4">Agrega una dirección para agilizar tus compras futuras</p>
                        <button id="add-first-address-btn" class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                            Agregar Primera Dirección
                        </button>
                    </div>
                @endif
                </div>
            </div>
        </div>

        {{-- Tab: Mis Pedidos --}}
        <div id="tab-pedidos" class="tab-content hidden">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Mis Pedidos</h2>
                
                @if(isset($orders) && $orders->count() > 0)
                    <div class="space-y-4">
                        @foreach($orders as $order)
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h3 class="font-semibold text-gray-900">Pedido #{{ $order->order_number }}</h3>
                                    <p class="text-sm text-gray-500">{{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : 'N/A' }}</p>
                                </div>
                                <span class="px-3 py-1 text-sm rounded-full 
                                    @if($order->estado === 'entregado') bg-green-100 text-green-800
                                    @elseif($order->estado === 'en_camino' || $order->estado === 'en camino') bg-blue-100 text-blue-800
                                    @elseif($order->estado === 'cancelado') bg-red-100 text-red-800
                                    @else bg-yellow-100 text-yellow-800
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $order->estado)) }}
                                </span>
                            </div>
                            
                            <div class="text-sm text-gray-600 space-y-1 mb-3">
                                <p><strong>{{ $order->items_count }}</strong> {{ $order->items_count === 1 ? 'producto' : 'productos' }}</p>
                                @if($order->direccion)
                                    <p class="flex items-start">
                                        <svg class="w-4 h-4 mr-1 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span>{{ $order->direccion }}{{ $order->barrio ? ', ' . $order->barrio : '' }}</span>
                                    </p>
                                @endif
                                @if($order->payment_method)
                                    <p><strong>Pago:</strong> {{ $order->payment_method }}</p>
                                @endif
                            </div>
                            
                            <div class="flex justify-between items-center pt-3 border-t border-gray-200">
                                <span class="text-lg font-bold text-gray-900">${{ number_format($order->total, 0, ',', '.') }}</span>
                                <a href="/{{ $website->slug }}/order/{{ $order->order_number }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                                    Ver detalles →
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">No tienes pedidos</h3>
                        <p class="text-gray-600 mb-4">Empieza a comprar en nuestra tienda</p>
                        <a href="/{{ $website->slug }}/tienda" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            Ir a la Tienda
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Modal para agregar/editar dirección (compartido) --}}
<div id="address-modal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-lg p-6 m-4 max-h-[90vh] overflow-y-auto overflow-x-hidden">
        <div class="flex justify-between items-center mb-6">
            <h2 id="address-modal-title" class="text-2xl font-bold text-gray-900">Agregar Dirección</h2>
            <button id="close-address-modal" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <form id="address-form" class="space-y-4">
            <input type="hidden" id="address-id" name="address_id" value="">
            {{-- Departamento y Ciudad (PRIMERO) --}}
            <div class="grid grid-cols-2 gap-3">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Departamento *</label>
                    <select name="departamento" id="departamento-select" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Cargando...</option>
                    </select>
                </div>
                
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ciudad/Municipio *</label>
                    <select name="ciudad" id="ciudad-select" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required disabled>
                        <option value="">Seleccione primero un departamento</option>
                    </select>
                </div>
            </div>

            {{-- Tipo de dirección --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de vía *</label>
                <select name="tipo_via" id="tipo-via" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required>
                    <option value="">Seleccione un tipo</option>
                    <option value="Calle">Calle</option>
                    <option value="Carrera">Carrera</option>
                    <option value="Avenida">Avenida</option>
                    <option value="Avenida Calle">Avenida Calle</option>
                    <option value="Avenida Carrera">Avenida Carrera</option>
                    <option value="Diagonal">Diagonal</option>
                    <option value="Transversal">Transversal</option>
                    <option value="Circular">Circular</option>
                    <option value="Vía">Vía</option>
                    <option value="Autopista">Autopista</option>
                    <option value="Boulevard">Boulevard</option>
                    <option value="Pasaje">Pasaje</option>
                    <option value="Camino">Camino</option>
                    <option value="Carrera">Carrera</option>
                </select>
            </div>

            {{-- Dirección en tres campos --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Dirección *</label>
                <div class="flex items-center gap-2 w-full">
                    <input type="text" name="direccion_campo1" id="direccion-campo1" placeholder="-" maxlength="10" class="flex-1 min-w-0 px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required>
                    <span class="text-blue-600 font-semibold text-base flex-shrink-0 px-1">#</span>
                    <input type="text" name="direccion_campo2" id="direccion-campo2" placeholder="-" maxlength="10" class="flex-1 min-w-0 px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required>
                    <span class="text-blue-600 font-semibold text-base flex-shrink-0 px-1">-</span>
                    <input type="text" name="direccion_campo3" id="direccion-campo3" placeholder="-" maxlength="10" class="flex-1 min-w-0 px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <p class="mt-1 text-xs text-gray-500">Ej: 27 # 45 - 67</p>
            </div>
            
            {{-- Barrio --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Barrio *</label>
                <input type="text" name="barrio" placeholder="Nombre del barrio" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required>
            </div>

            {{-- Otros detalles (Torre, Piso, Apartamento, etc.) --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Otros detalles (opcional)</label>
                <input type="text" name="otros_detalles" placeholder="Ej: Torre 2, Piso 5, Apto 201, Edificio Los Rosales" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <p class="mt-1 text-xs text-gray-500">Torre, piso, apartamento, edificio, etc.</p>
            </div>
            
            <div id="address-message" class="hidden"></div>
            
            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                Guardar Dirección
            </button>
        </form>
    </div>
</div>

{{-- Scripts para manejar tabs y actualizaciones --}}
<script>
// Sistema de Tabs
const tabs = document.querySelectorAll('.profile-tab');
const tabContents = document.querySelectorAll('.tab-content');

function switchToTab(tabName) {
    // Remover activo de todos los tabs
    tabs.forEach(t => {
        t.classList.remove('border-blue-500', 'text-blue-600');
        t.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Encontrar y activar el tab especificado
    const targetTab = document.querySelector(`[data-tab="${tabName}"]`);
    if (targetTab) {
        targetTab.classList.remove('border-transparent', 'text-gray-500');
        targetTab.classList.add('border-blue-500', 'text-blue-600');
    }
    
    // Ocultar todos los contenidos
    tabContents.forEach(content => {
        content.classList.add('hidden');
    });
    
    // Mostrar contenido del tab seleccionado
    const tabContent = document.getElementById('tab-' + tabName);
    if (tabContent) {
        tabContent.classList.remove('hidden');
    }
    
        // Si es el tab de pedidos, los pedidos ya están cargados desde el servidor
        // if (tabName === 'pedidos') {
        //     loadOrders();
        // }
        
        // Si es el tab de direcciones, cargar las direcciones
        if (tabName === 'direcciones') {
            loadAddresses();
        }
}

tabs.forEach(tab => {
    tab.addEventListener('click', function() {
        const targetTab = this.getAttribute('data-tab');
        switchToTab(targetTab);
        // Actualizar el hash en la URL
        window.location.hash = targetTab;
    });
});

// Detectar hash en la URL al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    const hash = window.location.hash.substring(1); // Remover el #
    if (hash && ['datos', 'seguridad', 'direcciones', 'pedidos'].includes(hash)) {
        switchToTab(hash);
    }
});

// Cargar direcciones del usuario
async function loadAddresses() {
    const addressesList = document.getElementById('addresses-list');
    
    try {
        addressesList.innerHTML = `
            <div class="text-center py-8">
                <svg class="w-12 h-12 mx-auto text-gray-400 mb-3 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                <p class="text-gray-500">Cargando direcciones...</p>
            </div>
        `;
        
        // Obtener direcciones
        const response = await fetch('/customer/addresses?website={{ $website->slug }}', {
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        if (!response.ok) {
            throw new Error('Error al cargar direcciones');
        }
        
        const result = await response.json();
        const addresses = result.addresses || [];
        
        if (addresses.length === 0) {
            addressesList.innerHTML = `
                <div class="text-center py-12">
                    <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No tienes direcciones guardadas</h3>
                    <p class="text-gray-600 mb-4">Agrega una dirección para agilizar tus compras futuras</p>
                </div>
            `;
            return;
        }
        
        let addressesHtml = '<div class="grid grid-cols-1 gap-4">';
        addresses.forEach(address => {
            const createdDate = address.created_at ? new Date(address.created_at).toLocaleDateString('es-ES') : 'N/A';
            addressesHtml += `
                <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-200 transition-colors bg-gray-50">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <p class="text-sm uppercase text-gray-500 font-semibold">DIRECCIÓN</p>
                            <p class="text-base font-semibold text-gray-900">${address.direccion || ''}</p>
                        </div>
                    </div>
                    <div class="text-sm text-gray-600 space-y-1">
                        ${address.barrio ? `<p>Barrio: ${address.barrio}</p>` : ''}
                        <p>${address.ciudad || ''}</p>
                        ${address.codigo_postal ? `<p>Código Postal: ${address.codigo_postal}</p>` : ''}
                        <p class="text-gray-500">Registrada el ${createdDate}</p>
                    </div>
                    <div class="mt-4 flex items-center justify-between text-sm">
                        <button class="text-blue-600 hover:text-blue-700 font-medium" onclick="editAddress(${address.id}, ${JSON.stringify(address).replace(/"/g, '&quot;')})">Editar</button>
                        <button class="text-red-600 hover:text-red-700 font-medium" onclick="deleteAddress(${address.id})">Eliminar</button>
                    </div>
                </div>
            `;
        });
        addressesHtml += '</div>';
        addressesList.innerHTML = addressesHtml;
        
    } catch (error) {
        console.error('Error al cargar direcciones:', error);
        addressesList.innerHTML = `
            <div class="text-center py-8 text-red-600">
                <p>Error al cargar las direcciones</p>
            </div>
        `;
    }
}

// Cargar pedidos del usuario
async function loadOrders() {
    const ordersList = document.getElementById('orders-list');
    
    try {
        ordersList.innerHTML = `
            <div class="text-center py-8">
                <svg class="w-12 h-12 mx-auto text-gray-400 mb-3 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                <p class="text-gray-500">Cargando pedidos...</p>
            </div>
        `;
        
        // Obtener ID del usuario
        const userCheck = await fetch('/customer/check');
        const userData = await userCheck.json();
        
        if (!userData.authenticated || !userData.customer) {
            throw new Error('No autenticado');
        }
        
        const userId = userData.customer.id;
        
        // Construir URL
        let baseUrl = window.websiteApiUrl;
        if (baseUrl.endsWith('/segundos')) {
            baseUrl = baseUrl.replace('/segundos', '');
        }
        const ordersUrl = `${baseUrl}/api-key/orders?user_id=${userId}&paginate=100`;
        
        console.log('📦 Cargando pedidos de usuario:', userId);
        console.log('📡 URL:', ordersUrl);
        
        const response = await fetch(ordersUrl, {
            headers: {
                'X-API-Key': window.websiteApiKey,
                'Accept': 'application/json'
            }
        });
        
        const result = await response.json();
        
        console.log('📦 Pedidos recibidos:', result);
        console.log('📊 Total de pedidos:', result.data?.length || 0);
        console.log('📄 Paginación:', result.pagination);
        
        if (result.success && result.data && result.data.length > 0) {
            console.log('📋 Primer pedido completo:', result.data[0]);
            
            ordersList.innerHTML = result.data.map(order => {
                console.log('📦 Renderizando pedido:', order);
                return `
                <div class="border border-gray-200 rounded-lg p-6 hover:border-blue-200 transition-colors">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-sm text-gray-500">Pedido #${order.id}</p>
                            <p class="text-lg font-semibold text-gray-900">${order.estado || 'N/A'}</p>
                        </div>
                        <span class="px-3 py-1 text-sm font-medium rounded-full ${getStatusColor(order.estado)}">
                            ${order.estado || 'solicitado'}
                        </span>
                    </div>
                    <div class="text-sm text-gray-600 space-y-1 mb-4">
                        <p><strong>Dirección:</strong> ${order.direccion || 'N/A'}, ${order.barrio || ''}, ${order.ciudad || 'N/A'}</p>
                        <p><strong>Método de pago:</strong> ${order.medio_pago || 'N/A'}</p>
                        ${order.observaciones ? `<p><strong>Observaciones:</strong> ${order.observaciones}</p>` : ''}
                        <p><strong>Fecha:</strong> ${new Date(order.created_at).toLocaleDateString('es-CO', {day: '2-digit', month: 'short', year: 'numeric'})}</p>
                    </div>
                    <div class="border-t pt-4">
                        <p class="text-sm text-gray-700 mb-2"><strong>Productos:</strong></p>
                        <div class="space-y-2">
                            ${order.productos && order.productos.length > 0 ? order.productos.map(p => `
                                <div class="flex justify-between text-sm">
                                    <span>${p.cantidad}x ${p.producto?.producto || 'Producto'}</span>
                                    <span class="font-medium">$${parseFloat(p.precio).toLocaleString('es-CO')}</span>
                                </div>
                            `).join('') : '<p class="text-gray-500 text-sm">Sin productos</p>'}
                        </div>
                    </div>
                </div>
            `}).join('');
            
            // Mostrar info de paginación si hay más pedidos
            if (result.pagination && result.pagination.total > result.data.length) {
                ordersList.innerHTML += `
                    <div class="text-center py-4 text-sm text-gray-500">
                        Mostrando ${result.data.length} de ${result.pagination.total} pedidos
                    </div>
                `;
            }
        } else {
            ordersList.innerHTML = `
                <div class="text-center py-12">
                    <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No tienes pedidos</h3>
                    <p class="text-gray-600 mb-4">Empieza a comprar en nuestra tienda</p>
                    <a href="/sitio/tienda" class="inline-block px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        Ir a la Tienda
                    </a>
                </div>
            `;
        }
    } catch (error) {
        console.error('Error cargando pedidos:', error);
        ordersList.innerHTML = `
            <div class="text-center py-12">
                <svg class="mx-auto h-16 w-16 text-red-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Error al cargar pedidos</h3>
                <p class="text-gray-600">Por favor, intenta nuevamente</p>
            </div>
        `;
    }
}

function getStatusColor(estado) {
    const colors = {
        'solicitado': 'bg-gray-100 text-gray-700',
        'aceptado': 'bg-blue-100 text-blue-700',
        'listo': 'bg-yellow-100 text-yellow-700',
        'asignado': 'bg-purple-100 text-purple-700',
        'en_camino': 'bg-orange-100 text-orange-700',
        'entregado': 'bg-green-100 text-green-700',
        'cancelado': 'bg-red-100 text-red-700'
    };
    return colors[estado] || 'bg-gray-100 text-gray-700';
}

// Actualizar datos personales
document.getElementById('profile-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const messageDiv = document.getElementById('profile-message');
    const submitBtn = e.target.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    
    try {
        submitBtn.disabled = true;
        submitBtn.textContent = 'Guardando...';
        messageDiv.classList.add('hidden');
        
        const formData = new FormData(e.target);
        const data = Object.fromEntries(formData);
        
        const response = await fetch('/{{ $website->slug }}/profile', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        
        if (result.success) {
            messageDiv.className = 'p-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm';
            messageDiv.textContent = result.message;
            messageDiv.classList.remove('hidden');
            
            // Actualizar el nombre en el header
            const userName = document.getElementById('user-name');
            if (userName) {
                userName.textContent = data.name.split(' ')[0];
            }
        } else {
            messageDiv.className = 'p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm';
            messageDiv.textContent = result.message;
            messageDiv.classList.remove('hidden');
        }
    } catch (error) {
        messageDiv.className = 'p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm';
        messageDiv.textContent = 'Error al actualizar. Intenta nuevamente.';
        messageDiv.classList.remove('hidden');
    } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
    }
});

// Cambiar contraseña
document.getElementById('password-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const messageDiv = document.getElementById('password-message');
    const submitBtn = e.target.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    
    const newPassword = document.getElementById('new_password').value;
    const confirmation = document.getElementById('new_password_confirmation').value;
    
    // Validar que las contraseñas coincidan
    if (newPassword !== confirmation) {
        messageDiv.className = 'p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm';
        messageDiv.textContent = 'Las contraseñas no coinciden';
        messageDiv.classList.remove('hidden');
        return;
    }
    
    try {
        submitBtn.disabled = true;
        submitBtn.textContent = 'Cambiando...';
        messageDiv.classList.add('hidden');
        
        const formData = new FormData(e.target);
        const data = Object.fromEntries(formData);
        
        const response = await fetch('/{{ $website->slug }}/profile/password', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        
        if (result.success) {
            messageDiv.className = 'p-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm';
            messageDiv.textContent = result.message;
            messageDiv.classList.remove('hidden');
            
            // Limpiar formulario
            e.target.reset();
        } else {
            messageDiv.className = 'p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm';
            messageDiv.textContent = result.message;
            messageDiv.classList.remove('hidden');
        }
    } catch (error) {
        messageDiv.className = 'p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm';
        messageDiv.textContent = 'Error al cambiar contraseña. Intenta nuevamente.';
        messageDiv.classList.remove('hidden');
    } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
    }
});

// Variable global para modo de edición
let editingAddressId = null;

// Gestión de modal de direcciones
async function openAddressModal() {
    editingAddressId = null;
    document.getElementById('address-id').value = '';
    document.getElementById('address-modal-title').textContent = 'Agregar Dirección';
    document.getElementById('address-modal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    
    // Limpiar formulario
    document.getElementById('address-form').reset();
    document.getElementById('ciudad-select').innerHTML = '<option value="">Seleccione primero un departamento</option>';
    document.getElementById('ciudad-select').disabled = true;
    
    // Cargar departamentos al abrir el modal
    await loadDepartments();
}

// Abrir modal en modo edición
async function editAddress(addressId, addressData) {
    editingAddressId = addressId;
    document.getElementById('address-id').value = addressId;
    document.getElementById('address-modal-title').textContent = 'Editar Dirección';
    document.getElementById('address-modal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    
    // Cargar departamentos primero
    await loadDepartments();
    
    // Esperar un momento para que los departamentos se carguen
    await new Promise(resolve => setTimeout(resolve, 500));
    
    // Parsear y llenar los campos
    parseAndFillAddress(addressData);
}

// Parsear dirección completa y llenar campos del formulario
function parseAndFillAddress(address) {
    // Llenar barrio
    document.getElementById('address-form').querySelector('input[name="barrio"]').value = address.barrio || '';
    
    // Llenar otros detalles (si existen en la dirección)
    const otrosDetallesInput = document.getElementById('address-form').querySelector('input[name="otros_detalles"]');
    otrosDetallesInput.value = '';
    
    // Parsear dirección completa
    const direccionCompleta = address.direccion || '';
    
    // Separar otros detalles si hay una coma
    let direccionSinDetalles = direccionCompleta;
    let otrosDetalles = '';
    
    const comaIndex = direccionCompleta.lastIndexOf(',');
    if (comaIndex > 0) {
        direccionSinDetalles = direccionCompleta.substring(0, comaIndex).trim();
        otrosDetalles = direccionCompleta.substring(comaIndex + 1).trim();
        otrosDetallesInput.value = otrosDetalles;
    }
    
    // Intentar extraer tipo de vía y números
    // Formato esperado: "TipoVia Campo1 # Campo2 - Campo3"
    // Ejemplos: "Calle 27 # 45 - 67", "Carrera 15 # 20", "Avenida 100 # 50 - 30"
    const direccionMatch = direccionSinDetalles.match(/^([A-Za-zÁÉÍÓÚáéíóúñÑ\s]+?)\s+(\d+)\s*#\s*(\d+)(?:\s*-\s*(\d+))?$/);
    
    if (direccionMatch) {
        // Tipo de vía
        const tipoVia = direccionMatch[1].trim();
        const tipoViaSelect = document.getElementById('tipo-via');
        // Buscar la opción que coincida
        for (let i = 0; i < tipoViaSelect.options.length; i++) {
            if (tipoViaSelect.options[i].textContent.trim() === tipoVia) {
                tipoViaSelect.value = tipoViaSelect.options[i].value;
                break;
            }
        }
        // Si no se encuentra, poner el valor directamente
        if (!tipoViaSelect.value) {
            tipoViaSelect.value = tipoVia;
        }
        
        // Campo 1
        document.getElementById('direccion-campo1').value = direccionMatch[2] || '';
        
        // Campo 2
        document.getElementById('direccion-campo2').value = direccionMatch[3] || '';
        
        // Campo 3 (opcional)
        if (direccionMatch[4]) {
            document.getElementById('direccion-campo3').value = direccionMatch[4];
        }
    } else {
        // Si no coincide el patrón exacto, intentar extraer lo que se pueda
        // Buscar el primer número después del tipo de vía
        const tipoViaMatch = direccionSinDetalles.match(/^([A-Za-zÁÉÍÓÚáéíóúñÑ\s]+?)\s+/);
        if (tipoViaMatch) {
            const tipoVia = tipoViaMatch[1].trim();
            const tipoViaSelect = document.getElementById('tipo-via');
            for (let i = 0; i < tipoViaSelect.options.length; i++) {
                if (tipoViaSelect.options[i].textContent.trim() === tipoVia) {
                    tipoViaSelect.value = tipoViaSelect.options[i].value;
                    break;
                }
            }
        }
        
        // Intentar extraer números con # y -
        const numerosMatch = direccionSinDetalles.match(/(\d+)\s*#\s*(\d+)(?:\s*-\s*(\d+))?/);
        if (numerosMatch) {
            document.getElementById('direccion-campo1').value = numerosMatch[1] || '';
            document.getElementById('direccion-campo2').value = numerosMatch[2] || '';
            if (numerosMatch[3]) {
                document.getElementById('direccion-campo3').value = numerosMatch[3];
            }
        }
    }
    
    // Seleccionar departamento y ciudad
    selectDepartmentAndCity(address.ciudad);
}

// Seleccionar departamento y ciudad
async function selectDepartmentAndCity(ciudadNombre) {
    const departamentoSelect = document.getElementById('departamento-select');
    const ciudadSelect = document.getElementById('ciudad-select');
    
    if (!ciudadNombre || !departamentoSelect || departamentoSelect.options.length <= 1) {
        return;
    }
    
    // Obtener la URL base de la API
    let apiBaseUrl = window.websiteApiUrl || '{{ $website->api_base_url ?? "" }}';
    if (!apiBaseUrl) return;
    
    apiBaseUrl = apiBaseUrl.replace(/\/$/, '');
    const url = apiBaseUrl + (apiBaseUrl.endsWith('/api') ? '/public/departments' : '/api/public/departments');
    
    try {
        // Cargar todos los departamentos con sus ciudades
        const response = await fetch(url, {
            headers: {
                'Accept': 'application/json',
            }
        });
        
        if (!response.ok) return;
        
        const departments = await response.json();
        
        // Buscar la ciudad en todos los departamentos
        for (const dept of departments) {
            if (dept.cities && Array.isArray(dept.cities)) {
                const ciudad = dept.cities.find(c => 
                    c.name.trim().toLowerCase() === ciudadNombre.trim().toLowerCase()
                );
                
                if (ciudad) {
                    // Seleccionar el departamento
                    departamentoSelect.value = dept.id;
                    
                    // Cargar las ciudades del departamento
                    await loadCities(dept.id);
                    
                    // Esperar un momento para que se carguen las ciudades
                    await new Promise(resolve => setTimeout(resolve, 300));
                    
                    // Seleccionar la ciudad
                    ciudadSelect.value = ciudad.id;
                    ciudadSelect.disabled = false;
                    return;
                }
            }
        }
    } catch (error) {
        console.error('Error buscando ciudad:', error);
    }
}

function closeAddressModal() {
    document.getElementById('address-modal').classList.add('hidden');
    document.body.style.overflow = '';
    
    // Limpiar formulario y resetear selects
    document.getElementById('address-form').reset();
    document.getElementById('address-id').value = '';
    editingAddressId = null;
    document.getElementById('ciudad-select').innerHTML = '<option value="">Seleccione primero un departamento</option>';
    document.getElementById('ciudad-select').disabled = true;
}

// Cargar departamentos desde la API
async function loadDepartments() {
    const departamentoSelect = document.getElementById('departamento-select');
    const ciudadSelect = document.getElementById('ciudad-select');
    
    try {
        departamentoSelect.innerHTML = '<option value="">Cargando...</option>';
        departamentoSelect.disabled = true;
        
        // Obtener la URL base de la API del servidor de admin negocios
        let apiBaseUrl = window.websiteApiUrl || '{{ $website->api_base_url ?? "" }}';
        
        if (!apiBaseUrl) {
            throw new Error('No se encontró la URL de la API');
        }
        
        // Limpiar la URL base (remover barra final si existe)
        apiBaseUrl = apiBaseUrl.replace(/\/$/, '');
        
        // Si la URL base ya incluye /api, no agregarlo de nuevo
        // Construir la URL del endpoint público de departamentos
        const url = apiBaseUrl + (apiBaseUrl.endsWith('/api') ? '/public/departments' : '/api/public/departments');
        
        const response = await fetch(url, {
            headers: {
                'Accept': 'application/json',
            }
        });
        
        if (!response.ok) {
            throw new Error('Error al cargar departamentos: ' + response.status);
        }
        
        const departments = await response.json();
        populateDepartmentsSelect(departamentoSelect, departments);
        
    } catch (error) {
        console.error('Error cargando departamentos:', error);
        departamentoSelect.innerHTML = '<option value="">Error al cargar departamentos</option>';
    }
}

// Función auxiliar para poblar el select de departamentos
function populateDepartmentsSelect(select, departments) {
    select.innerHTML = '<option value="">Seleccione un departamento</option>';
    
    if (Array.isArray(departments)) {
        departments.forEach(dept => {
            const option = document.createElement('option');
            option.value = dept.id;
            option.textContent = dept.name;
            select.appendChild(option);
        });
    }
    
    select.disabled = false;
}

// Cargar ciudades según el departamento seleccionado
async function loadCities(departmentId) {
    const ciudadSelect = document.getElementById('ciudad-select');
    
    if (!departmentId) {
        ciudadSelect.innerHTML = '<option value="">Seleccione primero un departamento</option>';
        ciudadSelect.disabled = true;
        return;
    }
    
    try {
        ciudadSelect.innerHTML = '<option value="">Cargando...</option>';
        ciudadSelect.disabled = true;
        
        // Obtener la URL base de la API
        let apiBaseUrl = window.websiteApiUrl || '{{ $website->api_base_url ?? "" }}';
        
        if (!apiBaseUrl) {
            throw new Error('No se encontró la URL de la API');
        }
        
        // Limpiar la URL base (remover barra final si existe)
        apiBaseUrl = apiBaseUrl.replace(/\/$/, '');
        
        // Si la URL base ya incluye /api, no agregarlo de nuevo
        // Construir la URL del endpoint público de departamento específico (que incluye ciudades)
        const url = apiBaseUrl + (apiBaseUrl.endsWith('/api') ? '/public/departments/' + departmentId : '/api/public/departments/' + departmentId);
        
        const response = await fetch(url, {
            headers: {
                'Accept': 'application/json',
            }
        });
        
        if (!response.ok) {
            throw new Error('Error al cargar ciudades: ' + response.status);
        }
        
        const department = await response.json();
        populateCitiesSelect(ciudadSelect, department.cities || []);
        
    } catch (error) {
        console.error('Error cargando ciudades:', error);
        ciudadSelect.innerHTML = '<option value="">Error al cargar ciudades</option>';
    }
}

// Función auxiliar para poblar el select de ciudades
function populateCitiesSelect(select, cities) {
    select.innerHTML = '<option value="">Seleccione una ciudad</option>';
    
    if (Array.isArray(cities)) {
        cities.forEach(city => {
            const option = document.createElement('option');
            option.value = city.id;
            option.textContent = city.name;
            select.appendChild(option);
        });
    }
    
    select.disabled = false;
}

// Event listener para cuando se selecciona un departamento
document.addEventListener('DOMContentLoaded', function() {
    const departamentoSelect = document.getElementById('departamento-select');
    if (departamentoSelect) {
        departamentoSelect.addEventListener('change', function() {
            loadCities(this.value);
        });
    }
});

document.getElementById('add-address-btn')?.addEventListener('click', openAddressModal);
document.getElementById('add-first-address-btn')?.addEventListener('click', openAddressModal);
document.getElementById('close-address-modal')?.addEventListener('click', closeAddressModal);

// Función para eliminar dirección
async function deleteAddress(addressId) {
    if (!confirm('¿Estás seguro de que deseas eliminar esta dirección?')) {
        return;
    }
    
    try {
        const response = await fetch(`/customer/addresses/${addressId}?website={{ $website->slug }}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        const result = await response.json();
        
        if (result.success) {
            // Recargar la lista de direcciones
            loadAddresses();
            
            // Mostrar mensaje de éxito
            const addressesList = document.getElementById('addresses-list');
            const successMsg = document.createElement('div');
            successMsg.className = 'p-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm mb-4';
            successMsg.textContent = '✓ Dirección eliminada exitosamente';
            addressesList.insertBefore(successMsg, addressesList.firstChild);
            
            setTimeout(() => {
                successMsg.remove();
            }, 3000);
        } else {
            alert('Error al eliminar la dirección: ' + (result.message || 'Error desconocido'));
        }
    } catch (error) {
        console.error('Error eliminando dirección:', error);
        alert('Error al eliminar la dirección. Por favor, intenta nuevamente.');
    }
}

// Guardar dirección
document.getElementById('address-form')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const messageDiv = document.getElementById('address-message');
    const submitBtn = e.target.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    
    try {
        submitBtn.disabled = true;
        submitBtn.textContent = 'Guardando...';
        messageDiv.classList.add('hidden');
        
        const formData = new FormData(e.target);
        
        // Obtener valores del formulario
        const tipoVia = formData.get('tipo_via');
        const direccionCampo1 = formData.get('direccion_campo1');
        const direccionCampo2 = formData.get('direccion_campo2');
        const direccionCampo3 = formData.get('direccion_campo3');
        const otrosDetalles = formData.get('otros_detalles');
        const barrio = formData.get('barrio');
        const ciudadSelect = document.getElementById('ciudad-select');
        
        // Validar que la ciudad esté seleccionada
        if (!ciudadSelect.value || ciudadSelect.selectedIndex === 0) {
            messageDiv.className = 'p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm';
            messageDiv.textContent = 'Por favor seleccione una ciudad';
            messageDiv.classList.remove('hidden');
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
            return;
        }
        
        const ciudadText = ciudadSelect.options[ciudadSelect.selectedIndex].textContent;
        
        // Construir la dirección completa desde los tres campos
        let direccionNumeros = `${direccionCampo1} # ${direccionCampo2}`;
        if (direccionCampo3 && direccionCampo3.trim() !== '') {
            direccionNumeros += ` - ${direccionCampo3.trim()}`;
        }
        
        let direccionCompleta = `${tipoVia} ${direccionNumeros}`.trim();
        
        // Agregar otros detalles si existen
        if (otrosDetalles && otrosDetalles.trim() !== '') {
            direccionCompleta += `, ${otrosDetalles.trim()}`;
        }
        
        // Preparar datos para enviar al servidor
        // El servidor de admin negocios espera: user_id, direccion, barrio, ciudad, codigo_postal (opcional)
        const data = {
            direccion: direccionCompleta,
            barrio: barrio,
            ciudad: ciudadText,
            website: '{{ $website->slug }}'
        };
        
        console.log('📤 Datos a enviar:', data);
        
        // Determinar si es edición o creación
        const addressId = document.getElementById('address-id').value;
        const isEdit = addressId && addressId !== '';
        
        const url = isEdit ? `/customer/addresses/${addressId}` : '/customer/addresses';
        const method = isEdit ? 'PUT' : 'POST';
        
        console.log(`${isEdit ? '✏️ Editando' : '➕ Creando'} dirección:`, url, method);
        
        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        
        if (result.success) {
            closeAddressModal();
            // Recargar la lista de direcciones
            loadAddresses();
            // Limpiar el formulario
            e.target.reset();
            // Mostrar mensaje de éxito
            messageDiv.className = 'p-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm';
            messageDiv.textContent = isEdit ? '✓ Dirección actualizada exitosamente' : '✓ Dirección guardada exitosamente';
            messageDiv.classList.remove('hidden');
            setTimeout(() => messageDiv.classList.add('hidden'), 3000);
        } else {
            messageDiv.className = 'p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm';
            messageDiv.textContent = result.message;
            messageDiv.classList.remove('hidden');
        }
    } catch (error) {
        messageDiv.className = 'p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm';
        messageDiv.textContent = 'Error al guardar. Intenta nuevamente.';
        messageDiv.classList.remove('hidden');
    } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
    }
});
</script>

