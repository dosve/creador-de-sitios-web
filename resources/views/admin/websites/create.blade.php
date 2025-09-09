@extends('layouts.admin')

@section('title', 'Crear Sitio Web')
@section('page-title', 'Nuevo Sitio Web')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Crear Nuevo Sitio Web</h3>
        </div>
        
        <form method="POST" action="{{ route('admin.websites.store') }}" class="p-6 space-y-6">
            @csrf
            
            <!-- Información Básica -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre del Sitio</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-300 @enderror" 
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-700">Propietario</label>
                    <select name="user_id" id="user_id" 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('user_id') border-red-300 @enderror" 
                            required>
                        <option value="">Seleccionar propietario</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
                <textarea name="description" id="description" rows="3" 
                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-300 @enderror" 
                          placeholder="Describe brevemente el sitio web...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Configuración -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="domain" class="block text-sm font-medium text-gray-700">Dominio Personalizado (Opcional)</label>
                    <input type="text" name="domain" id="domain" value="{{ old('domain') }}" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('domain') border-red-300 @enderror" 
                           placeholder="ejemplo.com">
                    @error('domain')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="subdomain" class="block text-sm font-medium text-gray-700">Subdominio (Opcional)</label>
                    <input type="text" name="subdomain" id="subdomain" value="{{ old('subdomain') }}" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('subdomain') border-red-300 @enderror" 
                           placeholder="mi-sitio">
                    @error('subdomain')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Se usará como subdominio.tudominio.com</p>
                </div>
            </div>
            
            <!-- Plantilla -->
            <div>
                <label for="template_id" class="block text-sm font-medium text-gray-700">Plantilla (Opcional)</label>
                <select name="template_id" id="template_id" 
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('template_id') border-red-300 @enderror">
                    <option value="">Sin plantilla</option>
                    @foreach($templates as $template)
                        <option value="{{ $template->id }}" {{ old('template_id') == $template->id ? 'selected' : '' }}>
                            {{ $template->name }} ({{ ucfirst($template->category) }})
                        </option>
                    @endforeach
                </select>
                @error('template_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Estado -->
            <div class="flex items-center">
                <input type="checkbox" name="is_published" id="is_published" value="1" 
                       {{ old('is_published') ? 'checked' : '' }}
                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="is_published" class="ml-2 block text-sm text-gray-900">
                    Publicar sitio inmediatamente
                </label>
            </div>
            
            <!-- Botones -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.websites.index') }}" 
                   class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                    Cancelar
                </a>
                <button type="submit" 
                        class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                    Crear Sitio Web
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
