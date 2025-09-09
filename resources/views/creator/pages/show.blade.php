<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page->title }} - {{ $website->name }}</title>
    @vite('resources/js/app.js')
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-4">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('creator.pages.index', $website) }}" class="text-gray-600 hover:text-gray-900">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $page->title }}</h1>
                            <p class="text-sm text-gray-500">{{ $website->name }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('creator.pages.versions', [$website, $page]) }}" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 text-sm">
                            Historial
                        </a>
                        <a href="{{ route('creator.pages.edit', [$website, $page]) }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-sm">
                            Editar
                        </a>
                        <a href="{{ route('creator.pages.editor', [$website, $page]) }}" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 text-sm">
                            Editor Visual
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <!-- Page Header -->
                <div class="px-6 py-8 border-b border-gray-200">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $page->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $page->is_published ? 'Publicada' : 'Borrador' }}
                            </span>
                            <span class="text-sm text-gray-500">/{{ $page->slug }}</span>
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ $page->updated_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                    
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $page->title }}</h1>
                    
                    @if($page->meta_description)
                        <p class="text-lg text-gray-600 mb-4">{{ $page->meta_description }}</p>
                    @endif
                </div>

                <!-- Page Content -->
                <div class="px-6 py-8">
                    <div class="prose max-w-none prose-lg">
                        {!! $page->html_content !!}
                    </div>
                </div>

                <!-- Page Footer -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-500">
                            <span>Creada: {{ $page->created_at->format('d/m/Y H:i') }}</span>
                            @if($page->updated_at != $page->created_at)
                                <span class="ml-4">Actualizada: {{ $page->updated_at->format('d/m/Y H:i') }}</span>
                            @endif
                        </div>
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('creator.pages.versions', [$website, $page]) }}" 
                               class="text-gray-600 hover:text-gray-900 text-sm font-medium">
                                Historial ({{ $page->versions()->count() }} versiones)
                            </a>
                            <a href="{{ route('creator.pages.edit', [$website, $page]) }}" 
                               class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                Editar
                            </a>
                            <a href="{{ route('creator.pages.editor', [$website, $page]) }}" 
                               class="text-green-600 hover:text-green-900 text-sm font-medium">
                                Editor Visual
                            </a>
                            <form method="POST" action="{{ route('creator.pages.destroy', [$website, $page]) }}" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar esta página?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 text-sm">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
