<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Artículo - {{ $website->name }}</title>
    @vite('resources/js/app.js')
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
</head>

<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-4">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('creator.blog.index', $website) }}" class="text-gray-600 hover:text-gray-900">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>
                        <h1 class="text-2xl font-bold text-gray-900">Crear Artículo</h1>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-8">
                    <form method="POST" action="{{ route('creator.blog.store', $website) }}" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <!-- Main Content -->
                            <div class="lg:col-span-2 space-y-6">
                                <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                        Título del artículo
                                    </label>
                                    <input type="text"
                                        id="title"
                                        name="title"
                                        value="{{ old('title') }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-500 @enderror"
                                        placeholder="Título atractivo para tu artículo"
                                        required>
                                    @error('title')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">
                                        URL del artículo
                                    </label>
                                    <div class="flex">
                                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                            {{ $website->slug }}.tudominio.com/blog/
                                        </span>
                                        <input type="text"
                                            id="slug"
                                            name="slug"
                                            value="{{ old('slug') }}"
                                            class="flex-1 px-3 py-2 border border-gray-300 rounded-r-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('slug') border-red-500 @enderror"
                                            placeholder="url-del-articulo"
                                            required>
                                    </div>
                                    @error('slug')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500">Se generará automáticamente si lo dejas vacío.</p>
                                </div>

                                <div>
                                    <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">
                                        Resumen (opcional)
                                    </label>
                                    <textarea id="excerpt"
                                        name="excerpt"
                                        rows="3"
                                        maxlength="500"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('excerpt') border-red-500 @enderror"
                                        placeholder="Breve descripción del artículo...">{{ old('excerpt') }}</textarea>
                                    @error('excerpt')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500">Máximo 500 caracteres. Aparecerá en la lista de artículos.</p>
                                </div>

                                <div>
                                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                                        Contenido del artículo
                                    </label>
                                    <textarea id="content"
                                        name="content"
                                        rows="15"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('content') border-red-500 @enderror"
                                        placeholder="Escribe tu artículo aquí..."
                                        required>{{ old('content') }}</textarea>
                                    @error('content')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
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
                                                {{ old('is_published') ? 'checked' : '' }}
                                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                            <label for="is_published" class="ml-2 block text-sm text-gray-900">
                                                Publicar inmediatamente
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Category -->
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Categoría</h3>

                                    <select id="category_id"
                                        name="category_id"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('category_id') border-red-500 @enderror">
                                        <option value="">Sin categoría</option>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror

                                    @if($categories->count() == 0)
                                    <p class="mt-2 text-xs text-gray-500">
                                        <a href="#" class="text-blue-600 hover:text-blue-800">Crear categoría</a>
                                    </p>
                                    @endif
                                </div>

                                <!-- Tags -->
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Etiquetas</h3>

                                    @if($tags->count() > 0)
                                    <div class="space-y-2">
                                        @foreach($tags as $tag)
                                        <label class="flex items-center">
                                            <input type="checkbox"
                                                name="tags[]"
                                                value="{{ $tag->id }}"
                                                {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}
                                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                            <span class="ml-2 text-sm text-gray-900">{{ $tag->name }}</span>
                                        </label>
                                        @endforeach
                                    </div>
                                    @else
                                    <p class="text-sm text-gray-500 mb-2">No hay etiquetas disponibles</p>
                                    <p class="text-xs text-gray-500">
                                        <a href="#" class="text-blue-600 hover:text-blue-800">Crear etiquetas</a>
                                    </p>
                                    @endif
                                </div>

                                <!-- Featured Image -->
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Imagen destacada</h3>

                                    <input type="url"
                                        id="featured_image"
                                        name="featured_image"
                                        value="{{ old('featured_image') }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('featured_image') border-red-500 @enderror"
                                        placeholder="https://ejemplo.com/imagen.jpg">
                                    @error('featured_image')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500">URL de la imagen destacada</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                            <a href="{{ route('creator.blog.index', $website) }}"
                                class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Cancelar
                            </a>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Crear Artículo
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

        // Contador de caracteres para excerpt
        const excerptTextarea = document.getElementById('excerpt');
        const excerptCounter = document.createElement('div');
        excerptCounter.className = 'text-xs text-gray-500 mt-1';
        excerptTextarea.parentNode.appendChild(excerptCounter);

        function updateExcerptCounter() {
            const length = excerptTextarea.value.length;
            excerptCounter.textContent = `${length}/500 caracteres`;
            if (length > 500) {
                excerptCounter.className = 'text-xs text-red-500 mt-1';
            } else {
                excerptCounter.className = 'text-xs text-gray-500 mt-1';
            }
        }

        excerptTextarea.addEventListener('input', updateExcerptCounter);
        updateExcerptCounter();

        // Inicializar TinyMCE
        tinymce.init({
            selector: '#content',
            height: 400,
            menubar: false,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | blocks | ' +
                'bold italic forecolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
            content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; }',
            language: 'es',
            branding: false,
            promotion: false
        });
    </script>
</body>

</html>