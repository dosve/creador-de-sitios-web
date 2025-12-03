{{-- Contenido de Mi Perfil --}}
<header class="bg-red-600 text-white">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between py-4">
            <div class="text-center flex-1">
                <h1 class="text-3xl font-bold">MASH</h1>
                <p class="text-xs">🚚 ENVÍOS A TODO COLOMBIA</p>
            </div>
            <div class="flex items-center space-x-4">
                <!-- Menú para usuarios invitados (no autenticados) -->
                <div id="guest-menu" class="hidden">
                    <button id="login-button" class="hover:text-red-200 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </button>
                </div>

                <!-- Menú para usuarios autenticados -->
                <div id="user-menu" class="hidden relative">
                    <button id="user-menu-button" class="hover:text-red-200 transition-colors flex items-center space-x-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <!-- Dropdown del usuario -->
                    <div id="user-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50">
                        <a href="/sitio/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                            👤 Mi Perfil
                        </a>
                        <div class="border-t border-gray-200 my-1"></div>
                        <button id="logout-button" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                            🚪 Cerrar Sesión
                        </button>
                    </div>
                </div>

                <!-- Carrito de compras -->
                <button id="cart-button" class="hover:text-red-200 transition-colors relative">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span id="cart-counter" class="absolute -top-1 -right-1 bg-white text-red-600 rounded-full w-5 h-5 flex items-center justify-center text-xs font-bold">0</span>
                </button>
            </div>
        </div>
    </div>
</header>

<nav class="bg-gray-800 text-white">
    <div class="container mx-auto px-4 py-3">
        <div class="flex items-center space-x-6">
            <a href="/sitio" class="hover:text-yellow-400 transition-colors">INICIO</a>
            <a href="/sitio/tienda" class="hover:text-yellow-400 transition-colors">TIENDA</a>
            <a href="/sitio/quienes-somos" class="hover:text-yellow-400 transition-colors">QUIÉNES SOMOS</a>
        </div>
    </div>
</nav>

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
                
                <div id="orders-list" class="space-y-4">
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 mx-auto text-gray-400 mb-3 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        <p class="text-gray-500">Cargando pedidos...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal para agregar/editar dirección (compartido) --}}
<div id="address-modal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 m-4 max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Agregar Dirección</h2>
            <button id="close-address-modal" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <form id="address-form" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Dirección completa *</label>
                <textarea name="direccion" rows="2" placeholder="Calle, número, apartamento, etc." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required></textarea>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Barrio *</label>
                    <input type="text" name="barrio" placeholder="Nombre del barrio" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ciudad *</label>
                    <input type="text" name="ciudad" placeholder="Ej: Bogotá" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required>
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Código Postal (opcional)</label>
                <input type="text" name="codigo_postal" placeholder="Ej: 110111" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
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
    
        // Si es el tab de pedidos, cargar los pedidos
        if (tabName === 'pedidos') {
            loadOrders();
        }
        
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
                        <button class="text-blue-600 hover:text-blue-700 font-medium">Editar</button>
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

// Gestión de modal de direcciones
function openAddressModal() {
    document.getElementById('address-modal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeAddressModal() {
    document.getElementById('address-modal').classList.add('hidden');
    document.body.style.overflow = '';
}

document.getElementById('add-address-btn')?.addEventListener('click', openAddressModal);
document.getElementById('add-first-address-btn')?.addEventListener('click', openAddressModal);
document.getElementById('close-address-modal')?.addEventListener('click', closeAddressModal);

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
        const data = Object.fromEntries(formData);
        data.website = '{{ $website->slug }}'; // Agregar slug del sitio web
        
        const response = await fetch('/customer/addresses', {
            method: 'POST',
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
            messageDiv.textContent = '✓ Dirección guardada exitosamente';
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

