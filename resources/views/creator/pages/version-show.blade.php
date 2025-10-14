<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Versión {{ $version->version_number }} - {{ $version->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-4">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('creator.pages.versions', [$website, $page]) }}" class="text-gray-600 hover:text-gray-900">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Versión {{ $version->version_number }}</h1>
                            <p class="text-sm text-gray-500">{{ $version->title }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <form method="POST" action="{{ route('creator.pages.version-restore', [$website, $page, $version]) }}" class="inline" onsubmit="return confirm('¿Estás seguro de restaurar esta versión?')">
                            @csrf
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 text-sm">
                                Restaurar Versión
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <!-- Version Header -->
                <div class="px-6 py-8 border-b border-gray-200">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                Versión {{ $version->version_number }}
                            </span>
                            @if($version->is_published)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Publicada
                                </span>
                            @endif
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ $version->created_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                    
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $version->title }}</h1>
                    
                    @if($version->change_description)
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                            <h3 class="text-sm font-medium text-blue-800 mb-1">Descripción del cambio:</h3>
                            <p class="text-sm text-blue-700">{{ $version->change_description }}</p>
                        </div>
                    @endif
                    
                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                        <span>Creada por: {{ $version->user->name }}</span>
                        <span>URL: /{{ $version->slug }}</span>
                    </div>
                </div>

                <!-- Meta Description -->
                @if($version->meta_description)
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h3 class="text-sm font-medium text-gray-900 mb-2">Meta Descripción:</h3>
                        <p class="text-sm text-gray-600">{{ $version->meta_description }}</p>
                    </div>
                @endif

                <!-- Version Content -->
                <div class="px-6 py-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Contenido de la versión:</h3>
                    <div class="prose max-w-none prose-lg border border-gray-200 rounded-lg p-6">
                        {!! $version->html_content !!}
                    </div>
                </div>

                <!-- Version Footer -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-500">
                            <span>Versión {{ $version->version_number }} - {{ $version->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <form method="POST" action="{{ route('creator.pages.version-restore', [$website, $page, $version]) }}" class="inline" onsubmit="return confirm('¿Estás seguro de restaurar esta versión?')">
                                @csrf
                                <button type="submit" class="text-green-600 hover:text-green-900 text-sm font-medium">
                                    Restaurar esta versión
                                </button>
                            </form>
                            <a href="{{ route('creator.pages.versions', [$website, $page]) }}" 
                               class="text-gray-600 hover:text-gray-900 text-sm">
                                Volver al historial
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
