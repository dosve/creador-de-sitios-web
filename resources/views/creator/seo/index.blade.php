<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración SEO - {{ $website->name }}</title>
    @vite('resources/js/app.js')
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-4">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('creator.websites.show', $website) }}" class="text-gray-600 hover:text-gray-900">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>
                        <h1 class="text-2xl font-bold text-gray-900">Configuración SEO</h1>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('creator.seo.edit', $website) }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-sm">
                            Configurar SEO
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <!-- SEO Status Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Meta Título</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $seoSettings && $seoSettings->meta_title ? 'Configurado' : 'Sin configurar' }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 {{ $seoSettings && $seoSettings->meta_description ? 'bg-green-500' : 'bg-yellow-500' }} rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Meta Descripción</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $seoSettings && $seoSettings->meta_description ? 'Configurado' : 'Sin configurar' }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 {{ $seoSettings && $seoSettings->google_analytics_id ? 'bg-green-500' : 'bg-gray-400' }} rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Google Analytics</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $seoSettings && $seoSettings->google_analytics_id ? 'Configurado' : 'Sin configurar' }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Sitemap</dt>
                                    <dd class="text-lg font-medium text-gray-900">Disponible</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SEO Tools -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Current SEO Settings -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Configuración Actual</h3>
                    </div>
                    <div class="px-6 py-4">
                        @if($seoSettings)
                            <div class="space-y-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Meta Título:</label>
                                    <p class="text-sm text-gray-900">{{ $seoSettings->meta_title ?: 'No configurado' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Meta Descripción:</label>
                                    <p class="text-sm text-gray-900">{{ $seoSettings->meta_description ?: 'No configurado' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Google Analytics:</label>
                                    <p class="text-sm text-gray-900">{{ $seoSettings->google_analytics_id ?: 'No configurado' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Robots:</label>
                                    <p class="text-sm text-gray-900">{{ $seoSettings->robots_content }}</p>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Sin configuración SEO</h3>
                                <p class="mt-1 text-sm text-gray-500">Configura los metadatos y herramientas de análisis para mejorar el SEO.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- SEO Tools -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Herramientas SEO</h3>
                    </div>
                    <div class="px-6 py-4 space-y-4">
                        <a href="{{ route('creator.seo.sitemap', $website) }}" 
                           class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">Ver Sitemap</h4>
                                <p class="text-xs text-gray-500">sitemap.xml</p>
                            </div>
                        </a>

                        <a href="{{ route('creator.seo.robots', $website) }}" 
                           class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">Ver Robots.txt</h4>
                                <p class="text-xs text-gray-500">robots.txt</p>
                            </div>
                        </a>

                        <a href="{{ route('creator.seo.preview', $website) }}" 
                           class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">Vista Previa SEO</h4>
                                <p class="text-xs text-gray-500">Como se ve en Google</p>
                            </div>
                        </a>

                        <form method="POST" action="{{ route('creator.seo.generate-sitemap', $website) }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                            @csrf
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-sm font-medium text-gray-900">Regenerar Sitemap</h4>
                                <p class="text-xs text-gray-500">Actualizar sitemap.xml</p>
                            </div>
                            <button type="submit" class="text-purple-600 hover:text-purple-900 text-sm font-medium">
                                Regenerar
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- SEO Recommendations -->
            <div class="mt-8 bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Recomendaciones SEO</h3>
                </div>
                <div class="px-6 py-4">
                    <div class="space-y-4">
                        @if(!$seoSettings || !$seoSettings->meta_title)
                            <div class="flex items-start space-x-3 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                                <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <div>
                                    <h4 class="text-sm font-medium text-yellow-800">Meta título faltante</h4>
                                    <p class="text-sm text-yellow-700">Agrega un meta título único y descriptivo para mejorar el SEO.</p>
                                </div>
                            </div>
                        @endif

                        @if(!$seoSettings || !$seoSettings->meta_description)
                            <div class="flex items-start space-x-3 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                                <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <div>
                                    <h4 class="text-sm font-medium text-yellow-800">Meta descripción faltante</h4>
                                    <p class="text-sm text-yellow-700">Agrega una meta descripción atractiva que aparezca en los resultados de búsqueda.</p>
                                </div>
                            </div>
                        @endif

                        @if(!$seoSettings || !$seoSettings->google_analytics_id)
                            <div class="flex items-start space-x-3 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <h4 class="text-sm font-medium text-blue-800">Google Analytics recomendado</h4>
                                    <p class="text-sm text-blue-700">Conecta Google Analytics para monitorear el tráfico y comportamiento de los usuarios.</p>
                                </div>
                            </div>
                        @endif

                        @if($seoSettings && $seoSettings->meta_title && $seoSettings->meta_description && $seoSettings->google_analytics_id)
                            <div class="flex items-start space-x-3 p-4 bg-green-50 border border-green-200 rounded-lg">
                                <svg class="w-5 h-5 text-green-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <h4 class="text-sm font-medium text-green-800">¡Excelente configuración SEO!</h4>
                                    <p class="text-sm text-green-700">Tu sitio web tiene una buena configuración SEO básica.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
