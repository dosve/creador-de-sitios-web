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
                <label class="block text-sm font-medium text-gray-700 mb-2">Nombre de la dirección</label>
                <input type="text" name="name" placeholder="Casa, Oficina, etc." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Dirección completa</label>
                <textarea name="address" rows="2" placeholder="Calle, número, apartamento, etc." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required></textarea>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ciudad</label>
                    <input type="text" name="city" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Departamento</label>
                    <input type="text" name="state" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Código Postal</label>
                    <input type="text" name="postal_code" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">País</label>
                    <select name="country" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required>
                        <option value="Colombia">Colombia</option>
                        <option value="México">México</option>
                        <option value="Argentina">Argentina</option>
                        <option value="Chile">Chile</option>
                        <option value="Perú">Perú</option>
                    </select>
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono de contacto</label>
                <input type="tel" name="phone" placeholder="Opcional" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
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

tabs.forEach(tab => {
    tab.addEventListener('click', function() {
        const targetTab = this.getAttribute('data-tab');
        
        // Remover activo de todos los tabs
        tabs.forEach(t => {
            t.classList.remove('border-blue-500', 'text-blue-600');
            t.classList.add('border-transparent', 'text-gray-500');
        });
        
        // Activar tab seleccionado
        this.classList.remove('border-transparent', 'text-gray-500');
        this.classList.add('border-blue-500', 'text-blue-600');
        
        // Ocultar todos los contenidos
        tabContents.forEach(content => {
            content.classList.add('hidden');
        });
        
        // Mostrar contenido del tab seleccionado
        document.getElementById('tab-' + targetTab).classList.remove('hidden');
    });
});

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
        
        const response = await fetch('/{{ $website->slug }}/addresses', {
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
            // Aquí se recargaría la lista de direcciones cuando esté implementado
            alert('Dirección guardada exitosamente');
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

