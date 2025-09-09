@extends('layouts.admin')

@section('title', 'Crear Página')
@section('page-title', 'Nueva Página')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Crear Nueva Página</h3>
            <p class="text-sm text-gray-500">Sitio: {{ $website->name }}</p>
        </div>
        
        <form method="POST" action="{{ route('admin.pages.store', $website) }}" class="p-6 space-y-6">
            @csrf
            
            <!-- Información Básica -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Título de la Página</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-300 @enderror" 
                           required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-700">Slug (URL)</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug') }}" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('slug') border-red-300 @enderror" 
                           required>
                    @error('slug')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Se generará automáticamente desde el título</p>
                </div>
            </div>
            
            <div>
                <label for="meta_description" class="block text-sm font-medium text-gray-700">Descripción Meta (SEO)</label>
                <textarea name="meta_description" id="meta_description" rows="3" 
                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('meta_description') border-red-300 @enderror" 
                          placeholder="Describe brevemente el contenido de la página para SEO...">{{ old('meta_description') }}</textarea>
                @error('meta_description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Contenido HTML -->
            <div>
                <label for="html_content" class="block text-sm font-medium text-gray-700">Contenido HTML</label>
                <textarea name="html_content" id="html_content" rows="10" 
                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('html_content') border-red-300 @enderror" 
                          placeholder="Ingresa el contenido HTML de la página..." required>{{ old('html_content', '<h1>Nueva Página</h1><p>Contenido de la página...</p>') }}</textarea>
                @error('html_content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Contenido CSS -->
            <div>
                <label for="css_content" class="block text-sm font-medium text-gray-700">Estilos CSS (Opcional)</label>
                <textarea name="css_content" id="css_content" rows="8" 
                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('css_content') border-red-300 @enderror" 
                          placeholder="Ingresa estilos CSS personalizados...">{{ old('css_content') }}</textarea>
                @error('css_content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Estado -->
            <div class="flex items-center">
                <input type="checkbox" name="is_published" id="is_published" value="1" 
                       {{ old('is_published') ? 'checked' : '' }}
                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="is_published" class="ml-2 block text-sm text-gray-900">
                    Publicar página inmediatamente
                </label>
            </div>
            
            <!-- Botones -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.websites.show', $website) }}" 
                   class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                    Cancelar
                </a>
                <button type="submit" 
                        class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                    Crear Página
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Auto-generar slug desde el título
document.getElementById('title').addEventListener('input', function() {
    const title = this.value;
    const slug = title
        .toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .trim('-');
    
    document.getElementById('slug').value = slug;
});
</script>
@endsection
