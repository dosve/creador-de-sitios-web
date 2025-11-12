@extends('layouts.creator')

@section('title', 'Importar Páginas Prediseñadas')
@section('page-title', 'Importar Páginas')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-6 bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-medium text-gray-900">Importar Páginas Prediseñadas</h2>
                    <p class="mt-1 text-sm text-gray-600">Selecciona las páginas que quieres importar desde la plantilla <strong>{{ $website->template_id }}</strong></p>
                </div>
                <a href="{{ route('creator.pages.index') }}" class="px-4 py-2 text-sm text-gray-700 bg-gray-300 rounded-md hover:bg-gray-400">
                    Volver a Páginas
                </a>
            </div>
        </div>
    </div>

    <form id="importForm" class="space-y-6">
        @csrf
        <div class="grid gap-4">
            @foreach($pages as $page)
            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                <label class="flex items-start space-x-3 cursor-pointer">
                    <input type="checkbox" name="pages[]" value="{{ $page['slug'] }}" class="mt-1 rounded border-gray-300 text-green-600 focus:ring-green-500">
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $page['title'] }}</h3>
                            @if($page['is_home'])
                                <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">Página de Inicio</span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-600 mt-1">{{ $page['meta_description'] ?? 'Sin descripción' }}</p>
                        <div class="mt-2 text-xs text-gray-500">
                            <span class="font-medium">Slug:</span> {{ $page['slug'] }}
                            @if(isset($page['blocks']) && count($page['blocks']) > 0)
                                <span class="ml-4"><span class="font-medium">Bloques:</span> {{ count($page['blocks']) }}</span>
                            @endif
                        </div>
                    </div>
                </label>
            </div>
            @endforeach
        </div>

        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
            <button type="button" id="selectAll" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                Seleccionar Todo
            </button>
            <div class="flex space-x-3">
                <a href="{{ route('creator.pages.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                    Cancelar
                </a>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700">
                    Importar Seleccionadas
                </button>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('importForm');
    const selectAllBtn = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    
    // Seleccionar todo
    selectAllBtn.addEventListener('click', function() {
        const allChecked = Array.from(checkboxes).every(cb => cb.checked);
        checkboxes.forEach(cb => cb.checked = !allChecked);
        selectAllBtn.textContent = allChecked ? 'Seleccionar Todo' : 'Deseleccionar Todo';
    });
    
    // Enviar formulario
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const selectedPages = Array.from(checkboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value);
        
        if (selectedPages.length === 0) {
            alert('Por favor selecciona al menos una página para importar');
            return;
        }
        
        // Mostrar loading
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        submitBtn.textContent = 'Importando...';
        submitBtn.disabled = true;
        
        // Enviar petición
        fetch(`{{ route('creator.pages.import', $website) }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ pages: selectedPages })
        })
        .then(response => {
            if (response.ok) {
                return response.text();
            }
            throw new Error('Error en la respuesta del servidor');
        })
        .then(html => {
            // Redirigir a la página de páginas
            window.location.href = '{{ route("creator.pages.index") }}';
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al importar páginas');
        })
        .finally(() => {
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;
        });
    });
});
</script>
@endsection
