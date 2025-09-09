<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Página - {{ $website->name }}</title>
    @vite('resources/js/app.js')
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-4">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('creator.websites.show', $website) }}" class="text-gray-600 hover:text-gray-900">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>
                        <h1 class="text-2xl font-bold text-gray-900">Crear Nueva Página</h1>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-2xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-8">
                    <div class="mb-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-2">Sitio: {{ $website->name }}</h2>
                        <p class="text-sm text-gray-600">Crea una nueva página para tu sitio web</p>
                    </div>

                    <form method="POST" action="{{ route('creator.pages.store', $website) }}" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                Título de la página
                            </label>
                            <input type="text" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-500 @enderror"
                                   placeholder="Mi Nueva Página"
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
                                       value="{{ old('slug') }}"
                                       class="flex-1 px-3 py-2 border border-gray-300 rounded-r-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('slug') border-red-500 @enderror"
                                       placeholder="mi-nueva-pagina"
                                       required>
                            </div>
                            @error('slug')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Solo letras, números y guiones. Se generará automáticamente si lo dejas vacío.</p>
                        </div>

                        <div>
                            <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-2">
                                Descripción para SEO (opcional)
                            </label>
                            <textarea id="meta_description" 
                                      name="meta_description" 
                                      rows="2"
                                      maxlength="160"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('meta_description') border-red-500 @enderror"
                                      placeholder="Descripción breve de la página para motores de búsqueda...">{{ old('meta_description') }}</textarea>
                            @error('meta_description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Máximo 160 caracteres. Ayuda a mejorar el posicionamiento en Google.</p>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" 
                                   id="is_published" 
                                   name="is_published" 
                                   value="1"
                                   {{ old('is_published') ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="is_published" class="ml-2 block text-sm text-gray-900">
                                Publicar página inmediatamente
                            </label>
                        </div>

                        <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                            <h3 class="text-sm font-medium text-blue-800 mb-2">¿Qué puedes hacer después?</h3>
                            <ul class="text-sm text-blue-700 space-y-1">
                                <li>• Usar el editor visual drag & drop</li>
                                <li>• Agregar imágenes, texto y botones</li>
                                <li>• Personalizar colores y tipografías</li>
                                <li>• Optimizar para móviles</li>
                                <li>• Configurar SEO y metadatos</li>
                            </ul>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('creator.websites.show', $website) }}" 
                               class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Crear Página
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
    </script>
</body>
</html>
