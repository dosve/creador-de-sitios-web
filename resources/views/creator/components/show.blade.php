<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $component->name }} - {{ $website->name }}</title>
    @vite('resources/js/app.js')
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white border-b shadow-sm">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex items-center justify-between py-4">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('creator.components.index', $website) }}" class="text-gray-600 hover:text-gray-900">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $component->name }}</h1>
                            <p class="text-sm text-gray-500">{{ $component->type_label }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('creator.components.editor', [$website, $component]) }}" class="px-4 py-2 text-sm text-white bg-green-600 rounded-md hover:bg-green-700">
                            Editar
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-6xl px-4 py-8 mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                <!-- Component Info -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Información del Componente</h3>
                    </div>
                    <div class="px-6 py-4 space-y-4">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Nombre:</label>
                            <p class="text-sm text-gray-900">{{ $component->name }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Tipo:</label>
                            <p class="text-sm text-gray-900">{{ $component->type_label }}</p>
                        </div>
                        @if($component->description)
                            <div>
                                <label class="text-sm font-medium text-gray-500">Descripción:</label>
                                <p class="text-sm text-gray-900">{{ $component->description }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="text-sm font-medium text-gray-500">Estado:</label>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $component->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $component->is_active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Creado:</label>
                            <p class="text-sm text-gray-900">{{ $component->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Última actualización:</label>
                            <p class="text-sm text-gray-900">{{ $component->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Component Preview -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Vista Previa</h3>
                    </div>
                    <div class="px-6 py-4">
                        <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                            <div class="prose max-w-none">
                                {!! $component->html_content !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- HTML Code -->
            <div class="mt-8 bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Código HTML</h3>
                </div>
                <div class="px-6 py-4">
                    <pre class="p-4 overflow-x-auto text-sm text-gray-100 bg-gray-900 rounded-lg"><code>{{ htmlspecialchars($component->html_content) }}</code></pre>
                </div>
            </div>

            <!-- CSS Code -->
            @if($component->css_content)
                <div class="mt-8 bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Código CSS</h3>
                    </div>
                    <div class="px-6 py-4">
                        <pre class="p-4 overflow-x-auto text-sm text-gray-100 bg-gray-900 rounded-lg"><code>{{ htmlspecialchars($component->css_content) }}</code></pre>
                    </div>
                </div>
            @endif

            <!-- Actions -->
            <div class="flex justify-center mt-8 space-x-4">
                <a href="{{ route('creator.components.index', $website) }}" 
                   class="px-4 py-2 text-gray-700 border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Volver a la Lista
                </a>
                <a href="{{ route('creator.components.editor', [$website, $component]) }}" 
                   class="px-4 py-2 text-white bg-green-600 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Editor
                </a>
                <a href="{{ route('creator.components.duplicate', [$website, $component]) }}" 
                   class="px-4 py-2 text-white bg-purple-600 rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    Duplicar
                </a>
            </div>
        </main>
    </div>
</body>
</html>
