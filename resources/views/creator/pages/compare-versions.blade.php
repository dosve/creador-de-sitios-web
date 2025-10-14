<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comparar Versiones - {{ $page->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .diff-added {
            background-color: #d1fae5;
            border-left: 4px solid #10b981;
        }
        .diff-removed {
            background-color: #fee2e2;
            border-left: 4px solid #ef4444;
        }
        .diff-unchanged {
            background-color: #f9fafb;
        }
    </style>
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
                            <h1 class="text-2xl font-bold text-gray-900">Comparar Versiones</h1>
                            <p class="text-sm text-gray-500">{{ $page->title }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <!-- Version Headers -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Version 1 -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-medium text-gray-900">Versión {{ $version1->version_number }}</h3>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $version1->created_at->format('d/m/Y H:i') }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-500 mt-1">{{ $version1->title }}</p>
                        @if($version1->change_description)
                            <p class="text-xs text-gray-600 mt-2">{{ $version1->change_description }}</p>
                        @endif
                    </div>
                </div>

                <!-- Version 2 -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-medium text-gray-900">Versión {{ $version2->version_number }}</h3>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                {{ $version2->created_at->format('d/m/Y H:i') }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-500 mt-1">{{ $version2->title }}</p>
                        @if($version2->change_description)
                            <p class="text-xs text-gray-600 mt-2">{{ $version2->change_description }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Comparison Content -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Comparación de Contenido</h3>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
                    <!-- Version 1 Content -->
                    <div class="p-6 border-r border-gray-200">
                        <h4 class="text-sm font-medium text-gray-900 mb-4">Versión {{ $version1->version_number }}</h4>
                        <div class="prose max-w-none prose-sm">
                            {!! $version1->html_content !!}
                        </div>
                    </div>

                    <!-- Version 2 Content -->
                    <div class="p-6">
                        <h4 class="text-sm font-medium text-gray-900 mb-4">Versión {{ $version2->version_number }}</h4>
                        <div class="prose max-w-none prose-sm">
                            {!! $version2->html_content !!}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Meta Data Comparison -->
            <div class="mt-8 bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Comparación de Metadatos</h3>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Version 1 Meta -->
                        <div>
                            <h4 class="text-sm font-medium text-gray-900 mb-4">Versión {{ $version1->version_number }}</h4>
                            <div class="space-y-3">
                                <div>
                                    <label class="text-xs font-medium text-gray-500">Título:</label>
                                    <p class="text-sm text-gray-900">{{ $version1->title }}</p>
                                </div>
                                <div>
                                    <label class="text-xs font-medium text-gray-500">Slug:</label>
                                    <p class="text-sm text-gray-900">/{{ $version1->slug }}</p>
                                </div>
                                <div>
                                    <label class="text-xs font-medium text-gray-500">Meta Descripción:</label>
                                    <p class="text-sm text-gray-900">{{ $version1->meta_description ?: 'Sin descripción' }}</p>
                                </div>
                                <div>
                                    <label class="text-xs font-medium text-gray-500">Estado:</label>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $version1->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $version1->is_published ? 'Publicada' : 'Borrador' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Version 2 Meta -->
                        <div>
                            <h4 class="text-sm font-medium text-gray-900 mb-4">Versión {{ $version2->version_number }}</h4>
                            <div class="space-y-3">
                                <div>
                                    <label class="text-xs font-medium text-gray-500">Título:</label>
                                    <p class="text-sm text-gray-900">{{ $version2->title }}</p>
                                </div>
                                <div>
                                    <label class="text-xs font-medium text-gray-500">Slug:</label>
                                    <p class="text-sm text-gray-900">/{{ $version2->slug }}</p>
                                </div>
                                <div>
                                    <label class="text-xs font-medium text-gray-500">Meta Descripción:</label>
                                    <p class="text-sm text-gray-900">{{ $version2->meta_description ?: 'Sin descripción' }}</p>
                                </div>
                                <div>
                                    <label class="text-xs font-medium text-gray-500">Estado:</label>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $version2->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $version2->is_published ? 'Publicada' : 'Borrador' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-8 flex justify-center space-x-4">
                <a href="{{ route('creator.pages.versions', [$website, $page]) }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Volver al Historial
                </a>
                <form method="POST" action="{{ route('creator.pages.version-restore', [$website, $page, $version2]) }}" class="inline" onsubmit="return confirm('¿Estás seguro de restaurar la versión {{ $version2->version_number }}?')">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Restaurar Versión {{ $version2->version_number }}
                    </button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
