@extends('layouts.creator')

@section('title', 'Gestión de Items del Menú')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $menu->name }}</h1>
            <p class="text-gray-600 mt-2">{{ ucfirst($menu->location) }} • {{ $menu->items->count() }} items</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('creator.menus.edit', $menu) }}" 
               class="inline-flex items-center bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Editar Menú
            </a>
            <button onclick="showAddItemModal()" 
                    class="inline-flex items-center bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Agregar Item
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if($menu->description)
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <p class="text-blue-800">{{ $menu->description }}</p>
        </div>
    @endif

    @if($menu->items->count() > 0)
        <div class="bg-white rounded-lg shadow-md border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Items del Menú</h2>
                <p class="text-sm text-gray-600 mt-1">Arrastra para reordenar los items</p>
            </div>
            
            <div id="menu-items-list" class="divide-y divide-gray-200">
                @foreach($menu->items as $item)
                    @include('creator.menus.partials.menu-item', ['item' => $item, 'level' => 0])
                @endforeach
            </div>
        </div>
    @else
        <div class="text-center py-12 bg-white rounded-lg shadow-md border border-gray-200">
            <div class="flex justify-center mb-4">
                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No hay items en este menú</h3>
            <p class="text-gray-600 mb-6">Agrega items para crear la navegación de tu sitio web.</p>
            <button onclick="showAddItemModal()" 
                    class="inline-flex items-center bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Agregar Primer Item
            </button>
        </div>
    @endif

    <!-- Modal para agregar/editar item -->
    <div id="itemModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <div class="p-6">
                    <h3 id="modalTitle" class="text-lg font-semibold text-gray-900 mb-4">Agregar Item al Menú</h3>
                    
                    <form id="itemForm" method="POST">
                        @csrf
                        <div id="methodField"></div>
                        
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                Título del Enlace *
                            </label>
                            <input type="text" 
                                   id="title" 
                                   name="title" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   required>
                        </div>

                        <div class="mb-4">
                            <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                                Tipo de Enlace *
                            </label>
                            <select id="type" 
                                    name="type" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    onchange="toggleUrlFields()">
                                <option value="page">Página del Sitio</option>
                                <option value="custom">URL Personalizada</option>
                                <option value="external">Enlace Externo</option>
                            </select>
                        </div>

                        <div id="pageField" class="mb-4">
                            <label for="page_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Seleccionar Página
                            </label>
                            <select id="page_id" 
                                    name="page_id" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Selecciona una página</option>
                                @foreach($pages as $page)
                                    <option value="{{ $page->id }}">{{ $page->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div id="urlField" class="mb-4 hidden">
                            <label for="url" class="block text-sm font-medium text-gray-700 mb-2">
                                URL
                            </label>
                            <input type="url" 
                                   id="url" 
                                   name="url" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="https://ejemplo.com">
                        </div>

                        <div class="mb-4">
                            <label for="target" class="block text-sm font-medium text-gray-700 mb-2">
                                Abrir en
                            </label>
                            <select id="target" 
                                    name="target" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="_self">Misma ventana</option>
                                <option value="_blank">Nueva ventana</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="icon" class="block text-sm font-medium text-gray-700 mb-2">
                                Icono (Opcional)
                            </label>
                            <input type="text" 
                                   id="icon" 
                                   name="icon" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="Ej: home, mail, phone (clase de icono)">
                        </div>

                        <div class="mb-4">
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="checkbox" 
                                       id="is_active" 
                                       name="is_active" 
                                       value="1"
                                       checked
                                       class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                                <span class="text-sm font-medium text-gray-700">
                                    Item activo (visible en el menú)
                                </span>
                            </label>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <button type="button" 
                                    onclick="hideItemModal()" 
                                    class="px-4 py-2 text-gray-600 bg-gray-100 rounded-md hover:bg-gray-200">
                                Cancelar
                            </button>
                            <button type="submit" 
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SortableJS CDN -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<style>
/* Estilos para el drag & drop */
.sortable-ghost {
    opacity: 0.4;
    background-color: #f3f4f6;
    border: 2px dashed #d1d5db;
}

.sortable-chosen {
    background-color: #dbeafe;
    border: 2px solid #3b82f6;
}

.sortable-drag {
    background-color: #ffffff;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    transform: rotate(5deg);
}

.cursor-move:hover {
    color: #3b82f6;
    transform: scale(1.1);
    transition: all 0.2s ease;
}

.menu-item {
    transition: all 0.2s ease;
}

.menu-item:hover {
    background-color: #f9fafb;
}
</style>

<script>
function showAddItemModal() {
    document.getElementById('modalTitle').textContent = 'Agregar Item al Menú';
    document.getElementById('itemForm').action = '{{ route("creator.menus.items.store", $menu) }}';
    document.getElementById('methodField').innerHTML = '';
    document.getElementById('itemForm').reset();
    document.getElementById('itemModal').classList.remove('hidden');
    toggleUrlFields();
}

function showEditItemModal(itemId, title, type, pageId, url, target, icon, isActive) {
    document.getElementById('modalTitle').textContent = 'Editar Item del Menú';
    document.getElementById('itemForm').action = '{{ route("creator.menus.items.update", [$menu, ":itemId"]) }}'.replace(':itemId', itemId);
    document.getElementById('methodField').innerHTML = '@method("PUT")';
    
    document.getElementById('title').value = title;
    document.getElementById('type').value = type;
    document.getElementById('page_id').value = pageId || '';
    document.getElementById('url').value = url || '';
    document.getElementById('target').value = target || '_self';
    document.getElementById('icon').value = icon || '';
    document.getElementById('is_active').checked = isActive;
    
    document.getElementById('itemModal').classList.remove('hidden');
    toggleUrlFields();
}

function hideItemModal() {
    document.getElementById('itemModal').classList.add('hidden');
}

function toggleUrlFields() {
    const type = document.getElementById('type').value;
    const pageField = document.getElementById('pageField');
    const urlField = document.getElementById('urlField');
    
    if (type === 'page') {
        pageField.classList.remove('hidden');
        urlField.classList.add('hidden');
        document.getElementById('page_id').required = true;
        document.getElementById('url').required = false;
    } else {
        pageField.classList.add('hidden');
        urlField.classList.remove('hidden');
        document.getElementById('page_id').required = false;
        document.getElementById('url').required = true;
    }
}

function deleteItem(itemId) {
    if (confirm('¿Estás seguro de que quieres eliminar este item?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("creator.menus.items.destroy", [$menu, ":itemId"]) }}'.replace(':itemId', itemId);
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        
        const tokenField = document.createElement('input');
        tokenField.type = 'hidden';
        tokenField.name = '_token';
        tokenField.value = '{{ csrf_token() }}';
        
        form.appendChild(methodField);
        form.appendChild(tokenField);
        document.body.appendChild(form);
        form.submit();
    }
}

// Inicializar Sortable para el ordenamiento de items del menú
document.addEventListener('DOMContentLoaded', function() {
    const menuItemsList = document.getElementById('menu-items-list');
    
    if (menuItemsList) {
        const sortable = Sortable.create(menuItemsList, {
            animation: 150,
            handle: '.cursor-move',
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            dragClass: 'sortable-drag',
            onEnd: function(evt) {
                updateMenuOrder();
            }
        });
    }
});

function updateMenuOrder() {
    const menuItems = document.querySelectorAll('#menu-items-list .menu-item');
    const items = [];
    
    menuItems.forEach((item, index) => {
        const itemId = item.getAttribute('data-item-id');
        if (itemId) {
            items.push({
                id: parseInt(itemId),
                order: index,
                parent_id: null // Por ahora solo manejamos items de primer nivel
            });
        }
    });
    
    // Enviar la actualización al servidor
    fetch('{{ route("creator.menus.update-order", $menu) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ items: items })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Mostrar mensaje de éxito
            showNotification('Orden actualizado correctamente', 'success');
        } else {
            showNotification('Error al actualizar el orden', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error al actualizar el orden', 'error');
    });
}

function showNotification(message, type) {
    // Crear elemento de notificación
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 ${
        type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
    }`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    // Remover después de 3 segundos
    setTimeout(() => {
        notification.remove();
    }, 3000);
}
</script>
@endsection
