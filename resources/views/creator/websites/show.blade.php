<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $website->name }} - Creador de Sitios Web</title>
    @vite('resources/js/app.js')
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-4">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('creator.dashboard') }}" class="text-gray-600 hover:text-gray-900">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $website->name }}</h1>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $website->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $website->is_published ? 'Publicado' : 'Borrador' }}
                        </span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('creator.websites.edit', $website) }}" class="text-gray-600 hover:text-gray-900">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </a>
                        <a href="{{ route('creator.blog.index', $website) }}" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 text-sm">
                            Blog
                        </a>
                        <a href="{{ route('creator.media.index', $website) }}" class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 text-sm">
                            Multimedia
                        </a>
                        <a href="{{ route('creator.pages.create', $website) }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-sm">
                            Nueva Página
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <!-- Website Info -->
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-medium text-gray-900">{{ $website->name }}</h2>
                            @if($website->description)
                                <p class="text-sm text-gray-600 mt-1">{{ $website->description }}</p>
                            @endif
                            <p class="text-xs text-gray-500 mt-2">
                                Creado el {{ $website->created_at->format('d/m/Y') }} • 
                                Última actualización: {{ $website->updated_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-600">{{ $pages->count() }} páginas</p>
                            <p class="text-sm text-gray-600">{{ $pages->where('is_published', true)->count() }} publicadas</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pages List -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">Páginas del sitio</h3>
                        <a href="{{ route('creator.pages.create', $website) }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-sm">
                            Agregar Página
                        </a>
                    </div>
                </div>
                
                @if($pages->count() > 0)
                    <div class="divide-y divide-gray-200">
                        @foreach($pages as $page)
                            <div class="px-6 py-4 hover:bg-gray-50">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 bg-blue-100 rounded-md flex items-center justify-center">
                                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900">{{ $page->title }}</h4>
                                            <p class="text-sm text-gray-500">/{{ $page->slug }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-3">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $page->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $page->is_published ? 'Publicada' : 'Borrador' }}
                                        </span>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('creator.pages.editor', [$website, $page]) }}" 
                                               class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                                Editar
                                            </a>
                                            <a href="{{ route('creator.pages.show', [$website, $page]) }}" 
                                               class="text-gray-600 hover:text-gray-900 text-sm">
                                                Ver
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
                        @endforeach
                    </div>
                @else
                    <div class="px-6 py-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No hay páginas</h3>
                        <p class="mt-1 text-sm text-gray-500">Comienza agregando tu primera página.</p>
                        <div class="mt-6">
                            <a href="{{ route('creator.pages.create', $website) }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Agregar Página
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </main>
    </div>
</body>
</html>
