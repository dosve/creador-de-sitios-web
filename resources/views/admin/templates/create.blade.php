@extends('layouts.admin')

@section('title', 'Crear Plantilla')
@section('page-title', 'Nueva Plantilla')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Crear Nueva Plantilla</h3>
        </div>
        
        <form method="POST" action="{{ route('admin.templates.store') }}" class="p-6 space-y-6">
            @csrf
            
            <!-- Información Básica -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre de la Plantilla</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-300 @enderror" 
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700">Categoría</label>
                    <select name="category" id="category" 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('category') border-red-300 @enderror" 
                            required>
                        <option value="">Seleccionar categoría</option>
                        @foreach($categories as $key => $label)
                            <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
                <textarea name="description" id="description" rows="3" 
                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-300 @enderror" 
                          placeholder="Describe brevemente la plantilla...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Configuración -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex items-center">
                    <input type="checkbox" name="is_premium" id="is_premium" value="1" 
                           {{ old('is_premium') ? 'checked' : '' }}
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="is_premium" class="ml-2 block text-sm text-gray-900">
                        Plantilla Premium
                    </label>
                </div>
                
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" 
                           {{ old('is_active', true) ? 'checked' : '' }}
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-900">
                        Activa
                    </label>
                </div>
            </div>
            
            <!-- Contenido HTML -->
            <div>
                <label for="html_content" class="block text-sm font-medium text-gray-700">Contenido HTML</label>
                <textarea name="html_content" id="html_content" rows="15" 
                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('html_content') border-red-300 @enderror" 
                          placeholder="Ingresa el contenido HTML de la plantilla..." required>{{ old('html_content') }}</textarea>
                @error('html_content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Contenido CSS -->
            <div>
                <label for="css_content" class="block text-sm font-medium text-gray-700">Contenido CSS (Opcional)</label>
                <textarea name="css_content" id="css_content" rows="10" 
                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('css_content') border-red-300 @enderror" 
                          placeholder="Ingresa estilos CSS personalizados...">{{ old('css_content') }}</textarea>
                @error('css_content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Bloques JSON -->
            <div>
                <label for="blocks" class="block text-sm font-medium text-gray-700">Bloques JSON (Opcional)</label>
                <textarea name="blocks" id="blocks" rows="5" 
                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('blocks') border-red-300 @enderror" 
                          placeholder='[{"type": "text", "content": "Texto de ejemplo"}]'>{{ old('blocks') }}</textarea>
                @error('blocks')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Define los bloques disponibles en formato JSON</p>
            </div>
            
            <!-- Botones -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.templates.index') }}" 
                   class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                    Cancelar
                </a>
                <button type="submit" 
                        class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                    Crear Plantilla
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
