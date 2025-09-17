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
        <header class="bg-white border-b shadow-sm">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex items-center justify-between py-4">
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
                        <a href="{{ route('creator.pages.versions', [$website, $page]) }}" class="px-4 py-2 text-sm text-white bg-gray-600 rounded-md hover:bg-gray-700">
                            Historial
                        </a>
                        <a href="{{ route('creator.pages.editor', [$website, $page]) }}" class="px-4 py-2 text-sm text-white bg-green-600 rounded-md hover:bg-green-700">
                            Editar
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-4xl px-4 py-8 mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white rounded-lg shadow">
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
                    
                    <h1 class="mb-4 text-3xl font-bold text-gray-900">{{ $page->title }}</h1>
                    
                    @if($page->meta_description)
                        <p class="mb-4 text-lg text-gray-600">{{ $page->meta_description }}</p>
                    @endif
                </div>

                <!-- Page Content -->
                <div class="px-6 py-8">
                    <div class="prose prose-lg max-w-none">
                        {!! $page->html_content !!}
                    </div>
                </div>

                <!-- Page Footer -->
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-500">
                            <span>Creada: {{ $page->created_at->format('d/m/Y H:i') }}</span>
                            @if($page->updated_at != $page->created_at)
                                <span class="ml-4">Actualizada: {{ $page->updated_at->format('d/m/Y H:i') }}</span>
                            @endif
                        </div>
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('creator.pages.versions', [$website, $page]) }}" 
                               class="text-sm font-medium text-gray-600 hover:text-gray-900">
                                Historial ({{ $page->versions()->count() }} versiones)
                            </a>
                            <a href="{{ route('creator.pages.editor', [$website, $page]) }}" 
                               class="text-sm font-medium text-green-600 hover:text-green-900">
                                Editar
                            </a>
                            <form method="POST" action="{{ route('creator.pages.destroy', [$website, $page]) }}" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar esta página?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-600 hover:text-red-900">
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
