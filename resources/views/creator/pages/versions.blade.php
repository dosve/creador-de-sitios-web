<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Versiones - {{ $page->title }}</title>
    @vite('resources/js/app.js')
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white border-b shadow-sm">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex items-center justify-between py-4">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('creator.pages.show', [$website, $page]) }}" class="text-gray-600 hover:text-gray-900">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Historial de Versiones</h1>
                            <p class="text-sm text-gray-500">{{ $page->title }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Stats -->
            <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-3">
                <div class="overflow-hidden bg-white rounded-lg shadow">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center w-8 h-8 bg-blue-500 rounded-md">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1 w-0 ml-5">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Versiones</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $versions->total() }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden bg-white rounded-lg shadow">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center w-8 h-8 bg-green-500 rounded-md">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1 w-0 ml-5">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Última Actualización</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $page->updated_at->format('d/m/Y') }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden bg-white rounded-lg shadow">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center w-8 h-8 bg-purple-500 rounded-md">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1 w-0 ml-5">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Creada</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $page->created_at->format('d/m/Y') }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Versions List -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Historial de Cambios</h3>
                </div>
                
                @if($versions->count() > 0)
                    <div class="divide-y divide-gray-200">
                        @foreach($versions as $version)
                            <div class="px-6 py-4 hover:bg-gray-50">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center mb-2 space-x-3">
                                            <h4 class="text-lg font-medium text-gray-900">Versión {{ $version->version_number }}</h4>
                                            @if($version->is_published)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Publicada
                                                </span>
                                            @endif
                                        </div>
                                        
                                        @if($version->change_description)
                                            <p class="mb-2 text-sm text-gray-600">{{ $version->change_description }}</p>
                                        @endif
                                        
                                        <div class="flex items-center space-x-4 text-sm text-gray-500">
                                            <span>{{ $version->created_at->format('d/m/Y H:i') }}</span>
                                            <span>por {{ $version->user->name }}</span>
                                            <span>{{ $version->title }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center ml-4 space-x-2">
                                        <a href="{{ route('creator.pages.version-show', [$website, $page, $version]) }}" 
                                           class="text-sm font-medium text-blue-600 hover:text-blue-900">
                                            Ver
                                        </a>
                                        @if($version->version_number > 1)
                                            <button onclick="compareVersions({{ $version->id }}, {{ $versions->first()->id }})" 
                                                    class="text-sm text-gray-600 hover:text-gray-900">
                                                Comparar
                                            </button>
                                        @endif
                                        <form method="POST" action="{{ route('creator.pages.version-restore', [$website, $page, $version]) }}" class="inline" onsubmit="return confirm('¿Estás seguro de restaurar esta versión?')">
                                            @csrf
                                            <button type="submit" class="text-sm text-green-600 hover:text-green-900">
                                                Restaurar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $versions->links() }}
                    </div>
                @else
                    <div class="px-6 py-12 text-center">
                        <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No hay versiones</h3>
                        <p class="mt-1 text-sm text-gray-500">Las versiones se crearán automáticamente cuando edites la página.</p>
                    </div>
                @endif
            </div>
        </main>
    </div>

    <script>
        function compareVersions(version1Id, version2Id) {
            window.location.href = `{{ route('creator.pages.compare-versions', [$website, $page, '']) }}/${version1Id}/${version2Id}`;
        }
    </script>
</body>
</html>
