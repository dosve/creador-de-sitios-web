<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista Previa SEO - {{ $website->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-4">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('creator.seo.index', $website) }}" class="text-gray-600 hover:text-gray-900">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>
                        <h1 class="text-2xl font-bold text-gray-900">Vista Previa SEO</h1>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Cómo se ve en Google</h3>
                    <p class="text-sm text-gray-500">Vista previa de cómo aparecerá tu sitio en los resultados de búsqueda</p>
                </div>
                <div class="px-6 py-6">
                    <!-- Google Search Result Preview -->
                    <div class="border border-gray-200 rounded-lg p-6 bg-white">
                        <div class="space-y-3">
                            <!-- URL -->
                            <div class="text-sm text-green-700">
                                {{ $website->getUrl() }}{{ $currentPage ? '/' . $currentPage->slug : '' }}
                            </div>
                            
                            <!-- Title -->
                            <div class="text-xl text-blue-600 hover:underline cursor-pointer">
                                {{ $seoSettings && $seoSettings->meta_title ? $seoSettings->meta_title : ($currentPage ? $currentPage->title : $website->name) }}
                            </div>
                            
                            <!-- Description -->
                            <div class="text-sm text-gray-600 leading-relaxed">
                                {{ $seoSettings && $seoSettings->meta_description ? $seoSettings->meta_description : ($currentPage ? $currentPage->meta_description : $website->description) }}
                            </div>
                            
                            <!-- Date (if applicable) -->
                            @if($currentPage)
                                <div class="text-sm text-gray-500">
                                    {{ $currentPage->updated_at->format('d/m/Y') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Facebook Preview -->
                    <div class="mt-8">
                        <h4 class="text-lg font-medium text-gray-900 mb-4">Vista previa en Facebook</h4>
                        <div class="border border-gray-200 rounded-lg overflow-hidden bg-white max-w-md">
                            @if($seoSettings && $seoSettings->og_image)
                                <img src="{{ $seoSettings->og_image }}" alt="Preview" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            <div class="p-4">
                                <div class="text-xs text-gray-500 uppercase tracking-wide mb-1">
                                    {{ $website->getUrl() }}
                                </div>
                                <div class="text-lg font-semibold text-gray-900 mb-2">
                                    {{ $seoSettings && $seoSettings->og_title ? $seoSettings->og_title : ($currentPage ? $currentPage->title : $website->name) }}
                                </div>
                                <div class="text-sm text-gray-600">
                                    {{ $seoSettings && $seoSettings->og_description ? $seoSettings->og_description : ($currentPage ? $currentPage->meta_description : $website->description) }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Twitter Preview -->
                    <div class="mt-8">
                        <h4 class="text-lg font-medium text-gray-900 mb-4">Vista previa en Twitter</h4>
                        <div class="border border-gray-200 rounded-lg overflow-hidden bg-white max-w-md">
                            @if($seoSettings && $seoSettings->og_image && $seoSettings->twitter_card == 'summary_large_image')
                                <img src="{{ $seoSettings->og_image }}" alt="Preview" class="w-full h-48 object-cover">
                            @endif
                            <div class="p-4">
                                <div class="text-xs text-gray-500 uppercase tracking-wide mb-1">
                                    {{ $website->getUrl() }}
                                </div>
                                <div class="text-lg font-semibold text-gray-900 mb-2">
                                    {{ $seoSettings && $seoSettings->og_title ? $seoSettings->og_title : ($currentPage ? $currentPage->title : $website->name) }}
                                </div>
                                <div class="text-sm text-gray-600">
                                    {{ $seoSettings && $seoSettings->og_description ? $seoSettings->og_description : ($currentPage ? $currentPage->meta_description : $website->description) }}
                                </div>
                                @if($seoSettings && $seoSettings->twitter_site)
                                    <div class="mt-2 text-xs text-gray-500">
                                        @{{ $seoSettings->twitter_site }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- SEO Analysis -->
                    <div class="mt-8">
                        <h4 class="text-lg font-medium text-gray-900 mb-4">Análisis SEO</h4>
                        <div class="space-y-4">
                            @php
                                $title = $seoSettings && $seoSettings->meta_title ? $seoSettings->meta_title : ($currentPage ? $currentPage->title : $website->name);
                                $description = $seoSettings && $seoSettings->meta_description ? $seoSettings->meta_description : ($currentPage ? $currentPage->meta_description : $website->description);
                            @endphp

                            <!-- Title Analysis -->
                            <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                                <div>
                                    <h5 class="font-medium text-gray-900">Meta Título</h5>
                                    <p class="text-sm text-gray-600">{{ $title }}</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm font-medium {{ strlen($title) >= 50 && strlen($title) <= 60 ? 'text-green-600' : 'text-yellow-600' }}">
                                        {{ strlen($title) }} caracteres
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ strlen($title) >= 50 && strlen($title) <= 60 ? 'Óptimo' : 'Recomendado: 50-60' }}
                                    </div>
                                </div>
                            </div>

                            <!-- Description Analysis -->
                            <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                                <div>
                                    <h5 class="font-medium text-gray-900">Meta Descripción</h5>
                                    <p class="text-sm text-gray-600">{{ $description }}</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm font-medium {{ strlen($description) >= 150 && strlen($description) <= 160 ? 'text-green-600' : 'text-yellow-600' }}">
                                        {{ strlen($description) }} caracteres
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ strlen($description) >= 150 && strlen($description) <= 160 ? 'Óptimo' : 'Recomendado: 150-160' }}
                                    </div>
                                </div>
                            </div>

                            <!-- Missing Elements -->
                            @if(!$seoSettings || !$seoSettings->meta_title)
                                <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                                    <div class="flex items-start space-x-3">
                                        <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                        </svg>
                                        <div>
                                            <h5 class="font-medium text-yellow-800">Meta título personalizado faltante</h5>
                                            <p class="text-sm text-yellow-700">Se está usando el título de la página. Considera crear un meta título específico para SEO.</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if(!$seoSettings || !$seoSettings->meta_description)
                                <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                                    <div class="flex items-start space-x-3">
                                        <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                        </svg>
                                        <div>
                                            <h5 class="font-medium text-yellow-800">Meta descripción personalizada faltante</h5>
                                            <p class="text-sm text-yellow-700">Se está usando la descripción de la página. Considera crear una meta descripción específica para SEO.</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
