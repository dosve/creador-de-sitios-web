@extends('layouts.admin')

@section('title', 'Editar Etiqueta')
@section('page-title', 'Editar Etiqueta')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Editar Etiqueta</h3>
            <p class="text-sm text-gray-500">Modifica la información de la etiqueta</p>
        </div>
        
        <form method="POST" action="{{ route('admin.tags.update', $tag) }}" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Información Básica -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Sitio Web</label>
                    <div class="mt-1 p-3 bg-gray-50 border border-gray-200 rounded-md">
                        <div class="text-sm text-gray-900">{{ $tag->website->name }}</div>
                        <div class="text-sm text-gray-500">{{ $tag->website->user->name }}</div>
                    </div>
                </div>
                
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre de la Etiqueta</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $tag->name) }}" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                        placeholder="Ej: Tecnología, Marketing, etc.">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
                <textarea name="description" id="description" rows="3"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror"
                    placeholder="Descripción opcional de la etiqueta...">{{ old('description', $tag->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="color" class="block text-sm font-medium text-gray-700">Color de la Etiqueta</label>
                <div class="mt-1 flex items-center space-x-4">
                    <input type="color" name="color" id="color" value="{{ old('color', $tag->color) }}"
                        class="h-10 w-20 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('color') border-red-500 @enderror">
                    <div class="flex space-x-2">
                        <button type="button" onclick="setColor('#10B981')" class="w-6 h-6 rounded-full bg-green-500 border-2 border-gray-300 hover:border-gray-400"></button>
                        <button type="button" onclick="setColor('#3B82F6')" class="w-6 h-6 rounded-full bg-blue-500 border-2 border-gray-300 hover:border-gray-400"></button>
                        <button type="button" onclick="setColor('#F59E0B')" class="w-6 h-6 rounded-full bg-yellow-500 border-2 border-gray-300 hover:border-gray-400"></button>
                        <button type="button" onclick="setColor('#EF4444')" class="w-6 h-6 rounded-full bg-red-500 border-2 border-gray-300 hover:border-gray-400"></button>
                        <button type="button" onclick="setColor('#8B5CF6')" class="w-6 h-6 rounded-full bg-purple-500 border-2 border-gray-300 hover:border-gray-400"></button>
                        <button type="button" onclick="setColor('#06B6D4')" class="w-6 h-6 rounded-full bg-cyan-500 border-2 border-gray-300 hover:border-gray-400"></button>
                    </div>
                </div>
                @error('color')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Botones -->
            <div class="flex justify-end space-x-3 pt-6 border-t">
                <a href="{{ route('admin.tags.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Cancelar
                </a>
                <button type="submit" class="bg-blue-600 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Actualizar Etiqueta
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function setColor(color) {
    document.getElementById('color').value = color;
}
</script>
@endsection
