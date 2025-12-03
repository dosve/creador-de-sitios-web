@extends('layouts.creator')

@section('title', 'Editar Artículo')
@section('page-title', 'Editar Artículo')

@push('styles')
<script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>
@endpush

@section('content')
            <!-- Edit Article Form -->
            <div class="max-w-4xl mx-auto">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Editar Artículo</h3>
                                <p class="mt-1 text-sm text-gray-600">Actualiza el artículo del blog.</p>
                            </div>
                            <a href="{{ route('creator.blog.show', $blogPost) }}" class="text-gray-600 hover:text-gray-900">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                    
                    <form method="POST" action="{{ route('creator.blog.update', $blogPost) }}" class="px-6 py-4">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <!-- Main Content -->
                            <div class="lg:col-span-2 space-y-6">
                                <!-- Title -->
                                <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                        Título del artículo
                                    </label>
                                    <input type="text" 
                                           id="title" 
                                           name="title" 
                                           value="{{ old('title', $blogPost->title) }}"
                                           class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('title') border-red-300 @enderror"
                                           placeholder="Título atractivo para tu artículo"
                                           required>
                                    @error('title')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Slug -->
                                <div>
                                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">
                                        URL del artículo
                                    </label>
                                    <div class="flex">
                                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                            /blog/
                                        </span>
                                        <input type="text" 
                                               id="slug" 
                                               name="slug" 
                                               value="{{ old('slug', $blogPost->slug) }}"
                                               class="flex-1 px-3 py-2 border border-gray-300 rounded-r-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('slug') border-red-300 @enderror"
                                               placeholder="url-del-articulo"
                                               required>
                                    </div>
                                    @error('slug')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500">Se generará automáticamente si lo dejas vacío.</p>
                                </div>

                                <!-- Excerpt -->
                                <div>
                                    <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">
                                        Resumen (opcional)
                                    </label>
                                    <textarea id="excerpt" 
                                              name="excerpt" 
                                              rows="3"
                                              maxlength="500"
                                              class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('excerpt') border-red-300 @enderror"
                                              placeholder="Breve descripción del artículo...">{{ old('excerpt', $blogPost->excerpt) }}</textarea>
                                    @error('excerpt')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500" id="excerpt-counter">0/500 caracteres. Aparecerá en la lista de artículos.</p>
                                </div>

                                <!-- Content -->
                                <div>
                                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                                        Contenido del artículo
                                    </label>
                                    <div id="editor-container" style="min-height: 400px;">
                                        <textarea id="content" 
                                              name="content" 
                                              rows="15"
                                              class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('content') border-red-300 @enderror"
                                              placeholder="Escribe tu artículo aquí..."
                                              autocomplete="off"
                                              data-form-type="other">{{ old('content', $blogPost->content) }}</textarea>
                                    </div>
                                    @error('content')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Sidebar -->
                            <div class="lg:col-span-1 space-y-6">
                                <!-- Publish Settings -->
                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                    <h3 class="text-sm font-medium text-gray-900 mb-4">Configuración</h3>
                                    
                                    <div class="space-y-4">
                                        <div class="flex items-center">
                                            <input type="checkbox" 
                                                   id="is_published" 
                                                   name="is_published" 
                                                   value="1"
                                                   {{ old('is_published', $blogPost->is_published) ? 'checked' : '' }}
                                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                            <label for="is_published" class="ml-2 block text-sm text-gray-900">
                                                Publicar inmediatamente
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Category -->
                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                    <h3 class="text-sm font-medium text-gray-900 mb-4">Categoría</h3>
                                    
                                    <select id="category_id" 
                                            name="category_id" 
                                            class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('category_id') border-red-300 @enderror">
                                        <option value="">Sin categoría</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $blogPost->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    
                                    @if($categories->count() == 0)
                                        <p class="mt-2 text-xs text-gray-500">
                                            <a href="{{ route('creator.categories.index') }}" class="text-blue-600 hover:text-blue-800">Crear categoría</a>
                                        </p>
                                    @endif
                                </div>

                                <!-- Tags -->
                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                    <h3 class="text-sm font-medium text-gray-900 mb-4">Etiquetas</h3>
                                    
                                    @if($tags->count() > 0)
                                        <div class="space-y-2">
                                            @foreach($tags as $tag)
                                                <label class="flex items-center">
                                                    <input type="checkbox" 
                                                           name="tags[]" 
                                                           value="{{ $tag->id }}"
                                                           {{ in_array($tag->id, old('tags', $blogPost->tags->pluck('id')->toArray())) ? 'checked' : '' }}
                                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                                    <span class="ml-2 text-sm text-gray-900">{{ $tag->name }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-sm text-gray-500 mb-2">No hay etiquetas disponibles</p>
                                        <p class="text-xs text-gray-500">
                                            <a href="{{ route('creator.tags.index', session('selected_website_id')) }}" class="text-blue-600 hover:text-blue-800">Crear etiquetas</a>
                                        </p>
                                    @endif
                                </div>

                                <!-- Featured Image -->
                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                    <h3 class="text-sm font-medium text-gray-900 mb-4">Imagen destacada</h3>
                                    
                                    <!-- Image Preview -->
                                    <div id="featured_image_preview" class="mb-3 hidden">
                                        <div class="aspect-video bg-gray-100 rounded-lg overflow-hidden">
                                            <img id="featured_image_preview_img" src="" alt="Vista previa" class="w-full h-full object-cover">
                                        </div>
                                        <button type="button" onclick="removeFeaturedImage()" class="mt-2 text-xs text-red-600 hover:text-red-800">
                                            Eliminar imagen
                                        </button>
                                    </div>

                                    <input type="url" 
                                           id="featured_image" 
                                           name="featured_image" 
                                           value="{{ old('featured_image', $blogPost->featured_image) }}"
                                           class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md mb-2 @error('featured_image') border-red-300 @enderror"
                                           placeholder="https://ejemplo.com/imagen.jpg">
                                    @error('featured_image')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    
                                    <button type="button" onclick="openMediaSelector(setFeaturedImage)" 
                                            class="w-full mt-2 bg-blue-600 text-white text-sm py-2 px-4 rounded-md hover:bg-blue-700">
                                        Seleccionar de la Biblioteca
                                    </button>
                                    
                                    <p class="mt-2 text-xs text-gray-500">URL de la imagen destacada</p>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="mt-6 flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                            <a href="{{ route('creator.blog.show', $blogPost) }}" 
                               class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Actualizar Artículo
                            </button>
                        </div>
                    </form>
                </div>
            </div>

<!-- Media Selector Component -->
@include('components.media-selector')

@push('scripts')
<script>
    // Auto-generar slug desde el título
    document.getElementById('title').addEventListener('input', function() {
        const title = this.value;
        const slug = title
            .toLowerCase()
            .normalize('NFD').replace(/[\u0300-\u036f]/g, '') // Remover acentos
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim('-');
        
        document.getElementById('slug').value = slug;
    });

    // Contador de caracteres para excerpt
    const excerptTextarea = document.getElementById('excerpt');
    const excerptCounter = document.getElementById('excerpt-counter');

    function updateExcerptCounter() {
        const length = excerptTextarea.value.length;
        excerptCounter.textContent = `${length}/500 caracteres. Aparecerá en la lista de artículos.`;
        if (length > 500) {
            excerptCounter.classList.add('text-red-500');
            excerptCounter.classList.remove('text-gray-500');
        } else {
            excerptCounter.classList.add('text-gray-500');
            excerptCounter.classList.remove('text-red-500');
        }
    }

    excerptTextarea.addEventListener('input', updateExcerptCounter);
    updateExcerptCounter();

    // Funciones para manejar la imagen destacada
    function setFeaturedImage(url) {
        document.getElementById('featured_image').value = url;
        updateFeaturedImagePreview(url);
    }

    function updateFeaturedImagePreview(url) {
        if (url) {
            document.getElementById('featured_image_preview_img').src = url;
            document.getElementById('featured_image_preview').classList.remove('hidden');
        } else {
            document.getElementById('featured_image_preview').classList.add('hidden');
        }
    }

    function removeFeaturedImage() {
        document.getElementById('featured_image').value = '';
        document.getElementById('featured_image_preview').classList.add('hidden');
    }

    // Actualizar vista previa cuando se cambie el input manualmente
    document.getElementById('featured_image').addEventListener('input', function() {
        updateFeaturedImagePreview(this.value);
    });

    // Cargar vista previa si ya hay una URL
    if (document.getElementById('featured_image').value) {
        updateFeaturedImagePreview(document.getElementById('featured_image').value);
    }

    // Inicializar CKEditor con manejo de errores mejorado y botón para insertar imágenes
    let editorInstance = null;
    
    ClassicEditor
        .create(document.querySelector('#content'), {
            toolbar: [
                'heading', '|',
                'bold', 'italic', 'link', '|',
                'bulletedList', 'numberedList', '|',
                'outdent', 'indent', '|',
                'blockQuote', 'insertTable', '|',
                'insertImage', '|',
                'undo', 'redo'
            ],
            language: 'es',
            table: {
                contentToolbar: [
                    'tableColumn',
                    'tableRow',
                    'mergeTableCells'
                ]
            }
        })
        .then(editor => {
            editorInstance = editor;
            console.log('CKEditor inicializado correctamente');
            
            // Personalizar el botón de insertar imagen
            editor.ui.view.toolbar.items.forEach(item => {
                if (item.label === 'Insertar imagen' || item.label === 'Insert image') {
                    item.on('execute', () => {
                        openMediaSelector(function(url) {
                            editor.model.change(writer => {
                                const imageElement = writer.createElement('imageBlock', {
                                    src: url
                                });
                                editor.model.insertContent(imageElement, editor.model.document.selection);
                            });
                        });
                    });
                }
            });
            
            // Asegurar que el contenido se sincronice antes del envío
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    try {
                        // Forzar actualización del contenido del textarea
                        if (editorInstance) {
                            editorInstance.updateSourceElement();
                        }
                        
                        // Verificar que el textarea tenga contenido
                        const textarea = document.querySelector('#content');
                        if (textarea && !textarea.value.trim()) {
                            e.preventDefault();
                            alert('Por favor, escribe el contenido del artículo.');
                            return false;
                        }
                    } catch (error) {
                        console.error('Error al sincronizar editor:', error);
                    }
                });
            }
        })
        .catch(error => {
            console.error('Error al inicializar CKEditor:', error);
            // Si falla CKEditor, mostrar el textarea normal y hacerlo requerido
            const textarea = document.querySelector('#content');
            if (textarea) {
                textarea.style.display = 'block';
                textarea.required = true;
                textarea.setAttribute('data-fallback', 'true');
            }
        });
</script>
@endpush
@endsection
