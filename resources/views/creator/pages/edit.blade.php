@extends('layouts.creator')

@section('title', 'Editar Página - ' . $page->title)
@section('page-title', 'Editar Página')
@section('content')
            <!-- Edit Page Form -->
            <div class="max-w-4xl mx-auto">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Editar Página: {{ $page->title }}</h3>
                        <p class="mt-1 text-sm text-gray-600">Modifica los metadatos de tu página. Para editar el contenido visual, usa el Editor Visual.</p>
                    </div>
                    
                    <form method="POST" action="{{ route('creator.pages.update', [$website, $page]) }}" class="px-6 py-4">
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
                                <p class="mt-2 text-sm text-gray-500">La URL será: {{ url('/') }}/{{ $website->slug }}/<span id="slug-preview">{{ $page->slug }}</span></p>
                                @error('slug')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Page Settings -->
                            <div class="space-y-4">
                                <!-- Publish Status -->
                                <div class="flex items-center">
                                    <input type="checkbox" name="is_published" id="is_published" value="1" 
                                           {{ old('is_published', $page->is_published) ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="is_published" class="ml-2 block text-sm text-gray-900">
                                        Página publicada
                                    </label>
                                </div>

                                <!-- Home Page -->
                                <div class="flex items-center">
                                    <input type="checkbox" name="is_home" id="is_home" value="1" 
                                           {{ old('is_home', $page->is_home) ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="is_home" class="ml-2 block text-sm text-gray-900">
                                        Página de inicio
                                    </label>
                                    <p class="ml-2 text-xs text-gray-500">(Esta será la página principal del sitio)</p>
                                </div>
                            </div>

                            <!-- Editor Visual Link -->
                            <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-blue-800">
                                            Editor Visual
                                        </h3>
                                        <div class="mt-2 text-sm text-blue-700">
                                            <p>Para editar el contenido visual de la página, usa el Editor Visual con interfaz drag & drop.</p>
                                        </div>
                                        <div class="mt-3">
                                            <a href="{{ route('creator.pages.editor', [$website, $page]) }}" 
                                               class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                                </svg>
                                                Abrir Editor Visual
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Published Status -->
                            <div class="flex items-center">
                                <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', $page->is_published) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="is_published" class="ml-2 block text-sm text-gray-900">
                                    Página publicada
                                </label>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="mt-6 flex items-center justify-end space-x-3">
                            <a href="{{ route('creator.pages.index', $website) }}" 
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
                // Update slug preview
                document.getElementById('slug').addEventListener('input', function() {
                    document.getElementById('slug-preview').textContent = this.value;
                });
            </script>
@endsection