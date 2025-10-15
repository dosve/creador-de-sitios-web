<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Componentes Compartidos - {{ $website->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white border-b shadow-sm">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex items-center justify-between py-4">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('creator.websites.show', session('selected_website_id')) }}" class="text-gray-600 hover:text-gray-900">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>
                        <h1 class="text-2xl font-bold text-gray-900">Componentes Compartidos</h1>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('creator.components.create', $website) }}" class="px-4 py-2 text-sm text-white bg-blue-600 rounded-md hover:bg-blue-700">
                            Nuevo Componente
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Stats -->
            <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-4">
                @foreach($componentTypes as $type => $label)
                    <div class="overflow-hidden bg-white rounded-lg shadow">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center w-8 h-8 bg-blue-500 rounded-md">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1 w-0 ml-5">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">{{ $label }}</dt>
                                        <dd class="text-lg font-medium text-gray-900">{{ $components->where('type', $type)->count() }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Components List -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">Componentes del Sitio</h3>
                        <a href="{{ route('creator.components.create', $website) }}" class="px-4 py-2 text-sm text-white bg-blue-600 rounded-md hover:bg-blue-700">
                            Nuevo Componente
                        </a>
                    </div>
                </div>
                
                @if($components->count() > 0)
                    <div class="divide-y divide-gray-200">
                        @foreach($components as $component)
                            <div class="px-6 py-4 hover:bg-gray-50">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center mb-2 space-x-3">
                                            <div class="flex items-center justify-center w-8 h-8 bg-gray-100 rounded-md">
                                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $component->type_icon }}"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="text-lg font-medium text-gray-900">{{ $component->name }}</h4>
                                                <p class="text-sm text-gray-500">{{ $component->type_label }}</p>
                                            </div>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $component->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                {{ $component->is_active ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </div>
                                        
                                        @if($component->description)
                                            <p class="mb-2 text-sm text-gray-600">{{ $component->description }}</p>
                                        @endif
                                        
                                        <div class="flex items-center space-x-4 text-sm text-gray-500">
                                            <span>{{ $component->created_at->format('d/m/Y') }}</span>
                                            <span>Última actualización: {{ $component->updated_at->format('d/m/Y H:i') }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center ml-4 space-x-2">
                                        <a href="{{ route('creator.components.show', [$website, $component]) }}" 
                                           class="text-sm font-medium text-blue-600 hover:text-blue-900">
                                            Ver
                                        </a>
                                        <a href="{{ route('creator.components.editor', [$website, $component]) }}" 
                                           class="text-sm text-green-600 hover:text-green-900">
                                            Editor
                                        </a>
                                        <a href="{{ route('creator.components.duplicate', [$website, $component]) }}" 
                                           class="text-sm text-purple-600 hover:text-purple-900">
                                            Duplicar
                                        </a>
                                        <form method="POST" action="{{ route('creator.components.toggle-status', [$website, $component]) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-sm text-yellow-600 hover:text-yellow-900">
                                                {{ $component->is_active ? 'Desactivar' : 'Activar' }}
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('creator.components.destroy', [$website, $component]) }}" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este componente?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm text-red-600 hover:text-red-900">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $components->links() }}
                    </div>
                @else
                    <div class="px-6 py-12 text-center">
                        <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No hay componentes</h3>
                        <p class="mt-1 text-sm text-gray-500">Comienza creando tu primer componente compartido.</p>
                        <div class="mt-6">
                            <a href="{{ route('creator.components.create', $website) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700">
                                <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Crear Componente
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </main>
    </div>
</body>
</html>
