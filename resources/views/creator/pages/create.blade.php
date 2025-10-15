@extends('layouts.creator')

@section('title', 'Nueva Página')
@section('page-title', 'Nueva Página')
@section('content')
            <!-- Create Page Form -->
            <div class="max-w-4xl mx-auto">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Crear Nueva Página</h3>
                        <p class="mt-1 text-sm text-gray-600">Agrega una nueva página a tu sitio web.</p>
                    </div>
                    
                    <form method="POST" action="{{ route('creator.pages.store') }}" class="px-6 py-4">
                        @csrf
                        
                        <div class="space-y-6">
                            <!-- Page Title -->
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">Título de la Página</label>
                                <div class="mt-1">
                                    <input type="text" name="title" id="title" value="{{ old('title') }}" 
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
                                    <input type="text" name="slug" id="slug" value="{{ old('slug') }}" 
                                           class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('slug') border-red-300 @enderror" 
                                           placeholder="mi-nueva-pagina" required>
                                </div>
                                <p class="mt-2 text-sm text-gray-500">La URL será: {{ url('/') }}/<span id="slug-preview">mi-nueva-pagina</span></p>
                                @error('slug')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tipo de Página -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">Tipo de Página</label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Página en Blanco -->
                                    <div class="relative">
                                        <input type="radio" name="page_type" id="page_type_blank" value="blank" 
                                               {{ old('page_type', 'blank') === 'blank' ? 'checked' : '' }}
                                               class="sr-only peer">
                                        <label for="page_type_blank" 
                                               class="relative flex flex-col items-center p-6 transition-all duration-300 border-2 border-gray-200 rounded-xl cursor-pointer peer-checked:border-blue-500 peer-checked:bg-gradient-to-br peer-checked:from-blue-50 peer-checked:to-blue-100 peer-checked:shadow-lg peer-checked:shadow-blue-200 peer-checked:scale-105 hover:border-gray-300 hover:shadow-md">
                                            <!-- Borde destacado cuando está seleccionado -->
                                            <div class="absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-blue-400 peer-checked:shadow-inner"></div>
                                            
                                            <div class="flex items-center justify-center w-16 h-16 mb-4 transition-all duration-300 bg-gray-100 rounded-xl peer-checked:bg-blue-500 peer-checked:shadow-lg">
                                                <svg class="w-8 h-8 text-gray-600 transition-all duration-300 peer-checked:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            </div>
                                            <h3 class="text-xl font-bold text-gray-900 transition-all duration-300 peer-checked:text-blue-800">Página en Blanco</h3>
                                            <p class="mt-2 text-sm text-center text-gray-500 transition-all duration-300 peer-checked:text-blue-600">Crear una página desde cero con contenido básico</p>
                                            
                                            <!-- Badge de seleccionado -->
                                            <div class="absolute -top-2 -right-2 w-6 h-6 transition-all duration-300 bg-gray-300 rounded-full peer-checked:bg-blue-500 peer-checked:scale-110">
                                                <svg class="w-4 h-4 text-white transition-all duration-300 opacity-0 peer-checked:opacity-100" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                        </label>
                                    </div>

                                    <!-- Usar Plantilla -->
                                    <div class="relative">
                                        <input type="radio" name="page_type" id="page_type_template" value="template" 
                                               {{ old('page_type') === 'template' ? 'checked' : '' }}
                                               class="sr-only peer">
                                        <label for="page_type_template" 
                                               class="relative flex flex-col items-center p-6 transition-all duration-300 border-2 border-gray-200 rounded-xl cursor-pointer peer-checked:border-blue-500 peer-checked:bg-gradient-to-br peer-checked:from-blue-50 peer-checked:to-blue-100 peer-checked:shadow-lg peer-checked:shadow-blue-200 peer-checked:scale-105 hover:border-gray-300 hover:shadow-md">
                                            <!-- Borde destacado cuando está seleccionado -->
                                            <div class="absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-blue-400 peer-checked:shadow-inner"></div>
                                            
                                            <div class="flex items-center justify-center w-16 h-16 mb-4 transition-all duration-300 bg-gray-100 rounded-xl peer-checked:bg-blue-500 peer-checked:shadow-lg">
                                                <svg class="w-8 h-8 text-gray-600 transition-all duration-300 peer-checked:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                                </svg>
                                            </div>
                                            <h3 class="text-xl font-bold text-gray-900 transition-all duration-300 peer-checked:text-blue-800">Usar Plantilla</h3>
                                            <p class="mt-2 text-sm text-center text-gray-500 transition-all duration-300 peer-checked:text-blue-600">Seleccionar una plantilla predefinida</p>
                                            
                                            <!-- Badge de seleccionado -->
                                            <div class="absolute -top-2 -right-2 w-6 h-6 transition-all duration-300 bg-gray-300 rounded-full peer-checked:bg-blue-500 peer-checked:scale-110">
                                                <svg class="w-4 h-4 text-white transition-all duration-300 opacity-0 peer-checked:opacity-100" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                @error('page_type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Selector de Plantilla (se muestra solo si se selecciona "Usar Plantilla") -->
                            <div id="template_selector" class="hidden">
                                <label for="template_id" class="block text-sm font-medium text-gray-700">Seleccionar Plantilla</label>
                                <select name="template_id" id="template_id" 
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('template_id') border-red-300 @enderror">
                                    <option value="">Selecciona una plantilla...</option>
                                    @foreach($templates ?? [] as $template)
                                        <option value="{{ $template->id }}" {{ old('template_id') == $template->id ? 'selected' : '' }}>
                                            {{ $template->name }} - {{ $template->description }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('template_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-sm text-gray-500">Las plantillas incluyen contenido HTML y CSS predefinido</p>
                            </div>

                            <!-- Published Status -->
                            <div class="flex items-center">
                                <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="is_published" class="ml-2 block text-sm text-gray-900">
                                    Publicar inmediatamente
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
                                Crear Página
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

                // Manejar el cambio de tipo de página
                document.addEventListener('DOMContentLoaded', function() {
                    const pageTypeInputs = document.querySelectorAll('input[name="page_type"]');
                    const templateSelector = document.getElementById('template_selector');
                    const templateSelect = document.getElementById('template_id');
                    
                    function toggleTemplateSelector() {
                        const selectedType = document.querySelector('input[name="page_type"]:checked');
                        
                        if (selectedType && selectedType.value === 'template') {
                            templateSelector.classList.remove('hidden');
                            templateSelect.required = true;
                        } else {
                            templateSelector.classList.add('hidden');
                            templateSelect.required = false;
                            templateSelect.value = '';
                        }
                    }
                    
                    // Agregar event listeners a los radio buttons
                    pageTypeInputs.forEach(input => {
                        input.addEventListener('change', toggleTemplateSelector);
                    });
                    
                    // Ejecutar al cargar la página
                    toggleTemplateSelector();
                });
            </script>
@endsection