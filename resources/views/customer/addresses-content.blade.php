{{-- Contenido de Mis Direcciones --}}
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4 max-w-5xl">
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Mis Direcciones</h1>
            <p class="text-gray-600">Gestiona los lugares donde recibes tus pedidos</p>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 space-y-3 md:space-y-0">
                <div>
                    <p class="text-sm text-gray-500">Cliente</p>
                    <p class="text-lg font-semibold text-gray-900">
                        {{ $customerData['name'] ?? 'Cliente' }}
                    </p>
                    <p class="text-sm text-gray-500">{{ $customerData['email'] ?? '' }}</p>
                </div>

                <div class="space-x-3">
                    <a href="/{{ $website->slug }}/profile"
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 text-sm font-medium hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Volver al perfil
                    </a>
                    <button onclick="openAddressModal()" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6"></path>
                        </svg>
                        Nueva Dirección
                    </button>
                </div>
            </div>

            @if($addresses->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                                <p class="text-gray-500">
                                    Registrada el {{ optional($address->created_at)->format('d/m/Y') ?? 'N/A' }}
                                </p>
                            </div>

                            <div class="mt-4 flex items-center justify-between text-sm">
                                <button onclick="editAddress({{ $address->id }})" class="text-blue-600 hover:text-blue-700 font-medium">
                                    Editar
                                </button>
                                <button onclick="deleteAddress({{ $address->id }})" class="text-red-600 hover:text-red-700 font-medium">
                                    Eliminar
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No tienes direcciones guardadas</h3>
                    <p class="text-gray-600 mb-4">
                        Agrega tus direcciones frecuentes para acelerar tu proceso de compra.
                    </p>
                    <button onclick="openAddressModal()" class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        Agregar dirección
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Modal para Crear/Editar Dirección --}}
<div id="addressModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
        <div class="flex items-center justify-between mb-4">
            <h3 id="modalTitle" class="text-xl font-semibold text-gray-900">Nueva Dirección</h3>
            <button onclick="closeAddressModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form id="addressForm" class="space-y-4">
            <input type="hidden" id="addressId" name="address_id">
            
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                    Nombre de la dirección <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="Ej: Casa, Oficina, Apartamento">
            </div>

            <div>
                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">
                    Dirección completa <span class="text-red-500">*</span>
                </label>
                <input type="text" id="address" name="address" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="Calle, número, piso, etc.">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700 mb-1">
                        Ciudad <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="city" name="city" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label for="state" class="block text-sm font-medium text-gray-700 mb-1">
                        Barrio / Zona
                    </label>
                    <input type="text" id="state" name="state"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-1">
                        Código Postal
                    </label>
                    <input type="text" id="postal_code" name="postal_code"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label for="country" class="block text-sm font-medium text-gray-700 mb-1">
                        País <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="country" name="country" value="Colombia" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>

            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                    Teléfono de contacto
                </label>
                <input type="tel" id="phone" name="phone"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div>
                <label for="reference" class="block text-sm font-medium text-gray-700 mb-1">
                    Referencia / Instrucciones de entrega
                </label>
                <textarea id="reference" name="reference" rows="2"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                          placeholder="Ej: Casa blanca con reja verde, 2do piso"></textarea>
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t">
                <button type="button" onclick="closeAddressModal()"
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Cancelar
                </button>
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Guardar Dirección
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Funciones para el modal
function openAddressModal(addressId = null) {
    const modal = document.getElementById('addressModal');
    const modalTitle = document.getElementById('modalTitle');
    const form = document.getElementById('addressForm');
    
    modal.classList.remove('hidden');
    
    if (addressId) {
        modalTitle.textContent = 'Editar Dirección';
        // TODO: Cargar datos de la dirección
    } else {
        modalTitle.textContent = 'Nueva Dirección';
        form.reset();
        document.getElementById('country').value = 'Colombia';
    }
}

function closeAddressModal() {
    document.getElementById('addressModal').classList.add('hidden');
    document.getElementById('addressForm').reset();
}

function editAddress(addressId) {
    openAddressModal(addressId);
}

function deleteAddress(addressId) {
    if (!confirm('¿Estás seguro de que deseas eliminar esta dirección?')) {
        return;
    }
    
    fetch(`/{{ $website->slug }}/addresses/${addressId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message || 'Error al eliminar la dirección');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al eliminar la dirección');
    });
}

// Enviar formulario
document.getElementById('addressForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData.entries());
    const addressId = document.getElementById('addressId').value;
    
    const url = addressId 
        ? `/{{ $website->slug }}/addresses/${addressId}`
        : `/{{ $website->slug }}/addresses`;
    
    const method = addressId ? 'PUT' : 'POST';
    
    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message || 'Error al guardar la dirección');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al guardar la dirección');
    });
});

// Cerrar modal al hacer clic fuera
document.getElementById('addressModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeAddressModal();
    }
});
</script>

