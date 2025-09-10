@extends('layouts.creator')

@section('title', 'Editar Sitio Web - ' . $website->name)
@section('page-title', 'Editar Sitio Web')
@section('content')
            <!-- Edit Website Form -->
            <div class="max-w-2xl mx-auto">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Editar {{ $website->name }}</h3>
                        <p class="mt-1 text-sm text-gray-600">Modifica la información de tu sitio web.</p>
                    </div>
                    
                    <form method="POST" action="{{ route('creator.websites.update', $website) }}" class="px-6 py-4">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-6">
                            <!-- Website Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nombre del Sitio Web</label>
                                <div class="mt-1">
                                    <input type="text" name="name" id="name" value="{{ old('name', $website->name) }}" 
                                           class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('name') border-red-300 @enderror" 
                                           placeholder="Mi Sitio Web" required>
                                </div>
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Website Description -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
                                <div class="mt-1">
                                    <textarea name="description" id="description" rows="3" 
                                              class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('description') border-red-300 @enderror" 
                                              placeholder="Describe brevemente tu sitio web...">{{ old('description', $website->description) }}</textarea>
                                </div>
                                @error('description')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Website Slug -->
                            <div>
                                <label for="slug" class="block text-sm font-medium text-gray-700">URL (Slug)</label>
                                <div class="mt-1">
                                    <input type="text" name="slug" id="slug" value="{{ old('slug', $website->slug) }}" 
                                           class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('slug') border-red-300 @enderror" 
                                           placeholder="mi-sitio-web" required>
                                </div>
                                <p class="mt-2 text-sm text-gray-500">La URL será: {{ url('/') }}/<span id="slug-preview">{{ $website->slug }}</span></p>
                                @error('slug')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Template Selection -->
                            <div>
                                <label for="template_id" class="block text-sm font-medium text-gray-700">Plantilla</label>
                                <div class="mt-1">
                                    <select name="template_id" id="template_id" 
                                            class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('template_id') border-red-300 @enderror">
                                        <option value="">Sin plantilla</option>
                                        @foreach(\App\Models\Template::active()->get() as $template)
                                            <option value="{{ $template->id }}" {{ old('template_id', $website->template_id) == $template->id ? 'selected' : '' }}>
                                                {{ $template->name }} - {{ $template->category }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('template_id')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Published Status -->
                            <div class="flex items-center">
                                <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', $website->is_published) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="is_published" class="ml-2 block text-sm text-gray-900">
                                    Sitio web publicado
                                </label>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="mt-6 flex items-center justify-end space-x-3">
                            <a href="{{ route('creator.dashboard') }}" 
                               class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Actualizar Sitio Web
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <script>
                // Update slug preview
                document.getElementById('slug').addEventListener('input', function() {
                    document.getElementById('slug-preview').textContent = this.value;
                });
            </script>
@endsection
