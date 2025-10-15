<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Componente - {{ $website->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-4">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('creator.components.index', $website) }}" class="text-gray-600 hover:text-gray-900">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>
                        <h1 class="text-2xl font-bold text-gray-900">Crear Componente</h1>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-8">
                    <form method="POST" action="{{ route('creator.components.store', $website) }}" class="space-y-6">
                        @csrf
                        
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <!-- Main Content -->
                            <div class="lg:col-span-2 space-y-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nombre del componente
                                    </label>
                                    <input type="text" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name') }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                                           placeholder="Mi Header Principal"
                                           required>
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                                        Tipo de componente
                                    </label>
                                    <select id="type" 
                                            name="type" 
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('type') border-red-500 @enderror"
                                            required>
                                        <option value="">Selecciona un tipo</option>
                                        @foreach($componentTypes as $type => $label)
                                            <option value="{{ $type }}" {{ old('type') == $type ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('type')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                        Descripción (opcional)
                                    </label>
                                    <textarea id="description" 
                                              name="description" 
                                              rows="3"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror"
                                              placeholder="Describe qué hace este componente...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="html_content" class="block text-sm font-medium text-gray-700 mb-2">
                                        Contenido HTML
                                    </label>
                                    <textarea id="html_content" 
                                              name="html_content" 
                                              rows="15"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('html_content') border-red-500 @enderror"
                                              placeholder="<header class='bg-blue-600 text-white p-4'>
    <h1>Mi Sitio Web</h1>
    <nav>
        <a href='/'>Inicio</a>
        <a href='/sobre'>Sobre</a>
    </nav>
</header>"
                                              required>{{ old('html_content') }}</textarea>
                                    @error('html_content')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500">Puedes usar el editor visual después de crear el componente.</p>
                                </div>
                            </div>

                            <!-- Sidebar -->
                            <div class="lg:col-span-1 space-y-6">
                                <!-- Component Type Info -->
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Tipos de Componentes</h3>
                                    
                                    <div class="space-y-3 text-sm">
                                        <div>
                                            <strong>Encabezado:</strong> Aparece en la parte superior de todas las páginas
                                        </div>
                                        <div>
                                            <strong>Pie de página:</strong> Aparece en la parte inferior de todas las páginas
                                        </div>
                                        <div>
                                            <strong>Menú:</strong> Navegación que se puede usar en múltiples páginas
                                        </div>
                                        <div>
                                            <strong>Bloque:</strong> Contenido reutilizable que puedes insertar donde necesites
                                        </div>
                                    </div>
                                </div>

                                <!-- Settings -->
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Configuración</h3>
                                    
                                    <div class="space-y-4">
                                        <div class="flex items-center">
                                            <input type="checkbox" 
                                                   id="is_active" 
                                                   name="is_active" 
                                                   value="1"
                                                   {{ old('is_active', true) ? 'checked' : '' }}
                                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                            <label for="is_active" class="ml-2 block text-sm text-gray-900">
                                                Componente activo
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Quick Actions -->
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Después de crear</h3>
                                    
                                    <div class="space-y-2 text-sm text-gray-600">
                                        <p>• Usar el editor visual drag & drop</p>
                                        <p>• Personalizar estilos CSS</p>
                                        <p>• Duplicar para crear variaciones</p>
                                        <p>• Insertar en páginas existentes</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                            <a href="{{ route('creator.components.index', $website) }}" 
                               class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Crear Componente
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Actualizar placeholder según el tipo seleccionado
        document.getElementById('type').addEventListener('change', function() {
            const type = this.value;
            const textarea = document.getElementById('html_content');
            
            const templates = {
                'header': `<header class="bg-blue-600 text-white p-4">
    <div class="container mx-auto flex justify-between items-center">
        <h1 class="text-2xl font-bold">Mi Sitio Web</h1>
        <nav class="space-x-4">
            <a href="/" class="hover:text-blue-200">Inicio</a>
            <a href="/sobre" class="hover:text-blue-200">Sobre</a>
            <a href="/contacto" class="hover:text-blue-200">Contacto</a>
        </nav>
    </div>
</header>`,
                'footer': `<footer class="bg-gray-800 text-white p-6">
    <div class="container mx-auto text-center">
        <p>&copy; 2025 Mi Sitio Web. Todos los derechos reservados.</p>
        <div class="mt-4 space-x-4">
            <a href="/privacidad" class="hover:text-gray-300">Privacidad</a>
            <a href="/terminos" class="hover:text-gray-300">Términos</a>
        </div>
    </div>
</footer>`,
                'menu': `<nav class="bg-white shadow-sm">
    <div class="container mx-auto px-4">
        <ul class="flex space-x-6 py-4">
            <li><a href="/" class="text-gray-700 hover:text-blue-600">Inicio</a></li>
            <li><a href="/servicios" class="text-gray-700 hover:text-blue-600">Servicios</a></li>
            <li><a href="/productos" class="text-gray-700 hover:text-blue-600">Productos</a></li>
            <li><a href="/contacto" class="text-gray-700 hover:text-blue-600">Contacto</a></li>
        </ul>
    </div>
</nav>`,
                'block': `<div class="bg-gray-50 p-6 rounded-lg">
    <h2 class="text-xl font-bold text-gray-900 mb-4">Título del Bloque</h2>
    <p class="text-gray-600">Contenido del bloque que se puede reutilizar en diferentes páginas.</p>
    <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Botón de Acción
    </button>
</div>`
            };
            
            if (templates[type] && !textarea.value) {
                textarea.value = templates[type];
            }
        });
    </script>
</body>
</html>
