@extends('layouts.creator')

@section('title', 'Editar Página - ' . $page->title)
@section('page-title', 'Editar Página')
@section('content')
            <!-- Edit Page Form -->
            <div class="max-w-4xl mx-auto">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Editar Página</h3>
                        <p class="mt-1 text-sm text-gray-600">Modifica los datos de la página "{{ $page->title }}".</p>
                    </div>
                    
                    <form method="POST" action="{{ route('creator.pages.update', $page) }}" class="px-6 py-4">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-6">
                            <!-- Page Title -->
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">Título de la Página</label>
                                <div class="mt-1">
                                    <input type="text" name="title" id="title" value="{{ old('title', $page->title) }}" 
                                           class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('title') border-red-300 @enderror" 
                                           placeholder="Mi Nueva Página" required>
                                </div>
                                @error('title')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Page Slug -->
                            <div>
                                <label for="slug" class="block text-sm font-medium text-gray-700">URL (Slug)</label>
                                <div class="mt-1">
                                    <input type="text" name="slug" id="slug" value="{{ old('slug', $page->slug) }}" 
                                           class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('slug') border-red-300 @enderror" 
                                           placeholder="mi-nueva-pagina" required>
                                </div>
                                <p class="mt-2 text-sm text-gray-500">La URL será: {{ url('/') }}/<span id="slug-preview">{{ $page->slug }}</span></p>
                                @error('slug')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Page Content -->
                            <div>
                                <label for="html_content" class="block text-sm font-medium text-gray-700">Contenido HTML</label>
                                <div class="mt-1">
                                    <textarea name="html_content" id="html_content" rows="10" 
                                              class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('html_content') border-red-300 @enderror" 
                                              placeholder="<h1>Título de la página</h1>
<p>Contenido de tu página aquí...</p>">{{ old('html_content', $page->html_content) }}</textarea>
                                </div>
                                @error('html_content')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Published Status -->
                            <div class="flex items-center">
                                <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', $page->is_published) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="is_published" class="ml-2 block text-sm text-gray-900">
                                    Página publicada
                                </label>
                            </div>

                            <!-- Home Page Status -->
                            <div class="flex items-center">
                                <input type="checkbox" name="is_home" id="is_home" value="1" {{ old('is_home', $page->is_home) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="is_home" class="ml-2 block text-sm text-gray-900">
                                    Establecer como página de inicio
                                </label>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="mt-6 flex items-center justify-end space-x-3">
                            <a href="{{ route('creator.pages.index') }}" 
                               class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Actualizar Página
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <script>
                // Auto-generate slug from title
                document.getElementById('title').addEventListener('input', function() {
                    const title = this.value;
                    const slug = title.toLowerCase()
                        .replace(/[^a-z0-9\s-]/g, '')
                        .replace(/\s+/g, '-')
                        .replace(/-+/g, '-')
                        .trim('-');
                    
                    document.getElementById('slug').value = slug;
                    document.getElementById('slug-preview').textContent = slug;
                });

                // Update slug preview
                document.getElementById('slug').addEventListener('input', function() {
                    document.getElementById('slug-preview').textContent = this.value;
                });
            </script>
@endsection
