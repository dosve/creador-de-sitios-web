@extends('layouts.creator')

@section('title', 'Duplicar Sitio Web')
@section('page-title', 'Duplicar Sitio Web')
@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white shadow rounded-lg p-8">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Duplicar Sitio Web</h2>
            <p class="mt-2 text-lg text-gray-600">
                Se creará una copia completa de <strong>{{ $website->name }}</strong> con todas sus páginas, 
                menús, categorías y configuración.
            </p>
        </div>

        <div class="mb-8 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <div class="flex gap-3">
                <svg class="flex-shrink-0 h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd" />
                </svg>
                <div class="text-sm text-blue-700">
                    <p class="font-medium">Nota importante:</p>
                    <p class="mt-1">El nuevo sitio se creará en estado no publicado. Podrás editarlo, modificar su contenido y publicarlo cuando esté listo.</p>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('creator.websites.duplicate.store', $website) }}" class="space-y-6">
            @csrf

            <!-- Sitio Original -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Sitio Original</label>
                <div class="mt-1 p-3 bg-gray-50 border border-gray-300 rounded-md">
                    <p class="text-gray-900 font-medium">{{ $website->name }}</p>
                    <p class="text-sm text-gray-500 mt-1">Slug: <code class="bg-gray-200 px-2 py-1 rounded">{{ $website->slug }}</code></p>
                </div>
            </div>

            <!-- Nuevo Nombre -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nombre del Nuevo Sitio *</label>
                <div class="mt-1">
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        value="{{ old('name', $website->name . ' (Copia)') }}" 
                        class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('name') border-red-300 @enderror" 
                        placeholder="Nuevo nombre para el sitio"
                        required
                    >
                </div>
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Se generará automáticamente un slug si no especificas uno.</p>
            </div>

            <!-- Nuevo Slug (Opcional) -->
            <div>
                <label for="slug" class="block text-sm font-medium text-gray-700">Slug (Opcional)</label>
                <div class="mt-1">
                    <input 
                        type="text" 
                        name="slug" 
                        id="slug" 
                        value="{{ old('slug') }}" 
                        class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('slug') border-red-300 @enderror" 
                        placeholder="nuevo-sitio-web"
                    >
                </div>
                @error('slug')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Si lo dejas en blanco, se generará automáticamente del nombre.</p>
            </div>

            <!-- Resumen -->
            <div class="p-4 bg-amber-50 border border-amber-200 rounded-lg">
                <p class="text-sm text-amber-800">
                    <span class="font-medium">Se copiarán:</span>
                </p>
                <ul class="mt-2 text-sm text-amber-700 space-y-1 ml-4">
                    <li>✓ Todas las páginas y su contenido</li>
                    <li>✓ Menús y navegación</li>
                    <li>✓ Categorías y etiquetas</li>
                    <li>✓ Posts del blog</li>
                    <li>✓ Componentes compartidos</li>
                    <li>✓ Configuración y ajustes</li>
                </ul>
            </div>

            <!-- Botones de acción -->
            <div class="flex gap-4 pt-6">
                <button 
                    type="submit" 
                    class="flex-1 bg-blue-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                >
                    Duplicar Sitio Web
                </button>
                <a 
                    href="{{ route('creator.websites.show') }}" 
                    class="flex-1 bg-white border border-gray-300 rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                >
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    // Auto-generar slug desde el nombre cuando cambia
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');

    nameInput.addEventListener('change', function() {
        if (!slugInput.value) {
            slugInput.value = this.value
                .toLowerCase()
                .trim()
                .replace(/[^\w\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
        }
    });

    // Permitir editar slug manualmente
    slugInput.addEventListener('input', function() {
        this.value = this.value
            .toLowerCase()
            .trim()
            .replace(/[^\w-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');
    });
</script>
@endsection
