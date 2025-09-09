<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Página - {{ $page->title }}</title>
    @vite('resources/js/app.js')
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-4">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('creator.pages.show', [$website, $page]) }}" class="text-gray-600 hover:text-gray-900">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>
                        <h1 class="text-2xl font-bold text-gray-900">Editar Página</h1>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('creator.pages.versions', [$website, $page]) }}" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 text-sm">
                            Historial
                        </a>
                        <a href="{{ route('creator.pages.editor', [$website, $page]) }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-sm">
                            Editor Visual
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-8">
                    <form method="POST" action="{{ route('creator.pages.update', [$website, $page]) }}" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <!-- Main Content -->
                            <div class="lg:col-span-2 space-y-6">
                                <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                        Título de la página
                                    </label>
                                    <input type="text" 
                                           id="title" 
                                           name="title" 
                                           value="{{ old('title', $page->title) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-500 @enderror"
                                           placeholder="Título de la página"
                                           required>
                                    @error('title')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">
                                        URL de la página
                                    </label>
                                    <div class="flex">
                                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                            {{ $website->slug }}.tudominio.com/
                                        </span>
                                        <input type="text" 
                                               id="slug" 
                                               name="slug" 
                                               value="{{ old('slug', $page->slug) }}"
                                               class="flex-1 px-3 py-2 border border-gray-300 rounded-r-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('slug') border-red-500 @enderror"
                                               placeholder="url-de-la-pagina"
                                               required>
                                    </div>
                                    @error('slug')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500">Se generará automáticamente si lo dejas vacío.</p>
                                </div>

                                <div>
                                    <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-2">
                                        Meta descripción (SEO)
                                    </label>
                                    <textarea id="meta_description" 
                                              name="meta_description" 
                                              rows="3"
                                              maxlength="160"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('meta_description') border-red-500 @enderror"
                                              placeholder="Descripción para motores de búsqueda...">{{ old('meta_description', $page->meta_description) }}</textarea>
                                    @error('meta_description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500">Máximo 160 caracteres. Aparecerá en los resultados de búsqueda.</p>
                                </div>

                                <div>
                                    <label for="html_content" class="block text-sm font-medium text-gray-700 mb-2">
                                        Contenido HTML
                                    </label>
                                    <textarea id="html_content" 
                                              name="html_content" 
                                              rows="15"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('html_content') border-red-500 @enderror"
                                              placeholder="Contenido HTML de la página...">{{ old('html_content', $page->html_content) }}</textarea>
                                    @error('html_content')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500">Usa el editor visual para un diseño más fácil.</p>
                                </div>
                            </div>

                            <!-- Sidebar -->
                            <div class="lg:col-span-1 space-y-6">
                                <!-- Publish Settings -->
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Configuración</h3>
                                    
                                    <div class="space-y-4">
                                        <div class="flex items-center">
                                            <input type="checkbox" 
                                                   id="is_published" 
                                                   name="is_published" 
                                                   value="1"
                                                   {{ old('is_published', $page->is_published) ? 'checked' : '' }}
                                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                            <label for="is_published" class="ml-2 block text-sm text-gray-900">
                                                Publicar página
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Change Description -->
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Descripción del cambio</h3>
                                    
                                    <textarea id="change_description" 
                                              name="change_description" 
                                              rows="3"
                                              maxlength="255"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('change_description') border-red-500 @enderror"
                                              placeholder="Describe qué cambios realizaste...">{{ old('change_description') }}</textarea>
                                    @error('change_description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500">Opcional. Aparecerá en el historial de versiones.</p>
                                </div>

                                <!-- Quick Actions -->
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Acciones Rápidas</h3>
                                    
                                    <div class="space-y-2">
                                        <a href="{{ route('creator.pages.editor', [$website, $page]) }}" 
                                           class="block w-full text-center px-3 py-2 border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-50">
                                            Editor Visual
                                        </a>
                                        <a href="{{ route('creator.pages.versions', [$website, $page]) }}" 
                                           class="block w-full text-center px-3 py-2 border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-50">
                                            Ver Historial
                                        </a>
                                        <a href="{{ route('creator.pages.show', [$website, $page]) }}" 
                                           class="block w-full text-center px-3 py-2 border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-50">
                                            Vista Previa
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                            <a href="{{ route('creator.pages.show', [$website, $page]) }}" 
                               class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Actualizar Página
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
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

        // Contador de caracteres para meta description
        const metaTextarea = document.getElementById('meta_description');
        const metaCounter = document.createElement('div');
        metaCounter.className = 'text-xs text-gray-500 mt-1';
        metaTextarea.parentNode.appendChild(metaCounter);

        function updateMetaCounter() {
            const length = metaTextarea.value.length;
            metaCounter.textContent = `${length}/160 caracteres`;
            if (length > 160) {
                metaCounter.className = 'text-xs text-red-500 mt-1';
            } else {
                metaCounter.className = 'text-xs text-gray-500 mt-1';
            }
        }

        metaTextarea.addEventListener('input', updateMetaCounter);
        updateMetaCounter();
    </script>
</body>
</html>
