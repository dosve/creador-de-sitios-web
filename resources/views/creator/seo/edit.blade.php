<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar SEO - {{ $website->name }}</title>
    @vite('resources/js/app.js')
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
                        <h1 class="text-2xl font-bold text-gray-900">Configurar SEO</h1>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('creator.seo.update', $website) }}" class="space-y-8">
                @csrf
                @method('PUT')

                <!-- Meta Tags Básicos -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Meta Tags Básicos</h3>
                        <p class="text-sm text-gray-500">Configuración fundamental para motores de búsqueda</p>
                    </div>
                    <div class="px-6 py-6 space-y-6">
                        <div>
                            <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-2">
                                Meta Título
                            </label>
                            <input type="text" 
                                   id="meta_title" 
                                   name="meta_title" 
                                   value="{{ old('meta_title', $seoSettings->meta_title ?? '') }}"
                                   maxlength="60"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('meta_title') border-red-500 @enderror"
                                   placeholder="Título que aparecerá en Google">
                            <p class="mt-1 text-xs text-gray-500">Máximo 60 caracteres. Recomendado: 50-60 caracteres</p>
                            @error('meta_title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-2">
                                Meta Descripción
                            </label>
                            <textarea id="meta_description" 
                                      name="meta_description" 
                                      rows="3"
                                      maxlength="160"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('meta_description') border-red-500 @enderror"
                                      placeholder="Descripción que aparecerá en los resultados de búsqueda">{{ old('meta_description', $seoSettings->meta_description ?? '') }}</textarea>
                            <p class="mt-1 text-xs text-gray-500">Máximo 160 caracteres. Recomendado: 150-160 caracteres</p>
                            @error('meta_description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="meta_keywords" class="block text-sm font-medium text-gray-700 mb-2">
                                Meta Keywords
                            </label>
                            <input type="text" 
                                   id="meta_keywords" 
                                   name="meta_keywords" 
                                   value="{{ old('meta_keywords', $seoSettings->meta_keywords ?? '') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('meta_keywords') border-red-500 @enderror"
                                   placeholder="palabra1, palabra2, palabra3">
                            <p class="mt-1 text-xs text-gray-500">Palabras clave separadas por comas (opcional)</p>
                            @error('meta_keywords')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Open Graph (Facebook) -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Open Graph (Facebook)</h3>
                        <p class="text-sm text-gray-500">Cómo se ve tu sitio cuando se comparte en redes sociales</p>
                    </div>
                    <div class="px-6 py-6 space-y-6">
                        <div>
                            <label for="og_title" class="block text-sm font-medium text-gray-700 mb-2">
                                Título OG
                            </label>
                            <input type="text" 
                                   id="og_title" 
                                   name="og_title" 
                                   value="{{ old('og_title', $seoSettings->og_title ?? '') }}"
                                   maxlength="60"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('og_title') border-red-500 @enderror"
                                   placeholder="Título para compartir en Facebook">
                            @error('og_title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="og_description" class="block text-sm font-medium text-gray-700 mb-2">
                                Descripción OG
                            </label>
                            <textarea id="og_description" 
                                      name="og_description" 
                                      rows="3"
                                      maxlength="160"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('og_description') border-red-500 @enderror"
                                      placeholder="Descripción para compartir en Facebook">{{ old('og_description', $seoSettings->og_description ?? '') }}</textarea>
                            @error('og_description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="og_image" class="block text-sm font-medium text-gray-700 mb-2">
                                Imagen OG
                            </label>
                            <input type="url" 
                                   id="og_image" 
                                   name="og_image" 
                                   value="{{ old('og_image', $seoSettings->og_image ?? '') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('og_image') border-red-500 @enderror"
                                   placeholder="https://ejemplo.com/imagen.jpg">
                            <p class="mt-1 text-xs text-gray-500">URL de la imagen que aparecerá al compartir (recomendado: 1200x630px)</p>
                            @error('og_image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Twitter Cards -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Twitter Cards</h3>
                        <p class="text-sm text-gray-500">Configuración para Twitter</p>
                    </div>
                    <div class="px-6 py-6 space-y-6">
                        <div>
                            <label for="twitter_card" class="block text-sm font-medium text-gray-700 mb-2">
                                Tipo de Card
                            </label>
                            <select id="twitter_card" 
                                    name="twitter_card" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('twitter_card') border-red-500 @enderror">
                                <option value="summary" {{ old('twitter_card', $seoSettings->twitter_card ?? 'summary') == 'summary' ? 'selected' : '' }}>Summary</option>
                                <option value="summary_large_image" {{ old('twitter_card', $seoSettings->twitter_card ?? '') == 'summary_large_image' ? 'selected' : '' }}>Summary Large Image</option>
                                <option value="app" {{ old('twitter_card', $seoSettings->twitter_card ?? '') == 'app' ? 'selected' : '' }}>App</option>
                                <option value="player" {{ old('twitter_card', $seoSettings->twitter_card ?? '') == 'player' ? 'selected' : '' }}>Player</option>
                            </select>
                            @error('twitter_card')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="twitter_site" class="block text-sm font-medium text-gray-700 mb-2">
                                Twitter Site (@usuario)
                            </label>
                            <input type="text" 
                                   id="twitter_site" 
                                   name="twitter_site" 
                                   value="{{ old('twitter_site', $seoSettings->twitter_site ?? '') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('twitter_site') border-red-500 @enderror"
                                   placeholder="@tuusuario">
                            @error('twitter_site')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="twitter_creator" class="block text-sm font-medium text-gray-700 mb-2">
                                Twitter Creator (@usuario)
                            </label>
                            <input type="text" 
                                   id="twitter_creator" 
                                   name="twitter_creator" 
                                   value="{{ old('twitter_creator', $seoSettings->twitter_creator ?? '') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('twitter_creator') border-red-500 @enderror"
                                   placeholder="@tuusuario">
                            @error('twitter_creator')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Herramientas de Análisis -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Herramientas de Análisis</h3>
                        <p class="text-sm text-gray-500">Códigos de seguimiento y análisis</p>
                    </div>
                    <div class="px-6 py-6 space-y-6">
                        <div>
                            <label for="google_analytics_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Google Analytics ID
                            </label>
                            <input type="text" 
                                   id="google_analytics_id" 
                                   name="google_analytics_id" 
                                   value="{{ old('google_analytics_id', $seoSettings->google_analytics_id ?? '') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('google_analytics_id') border-red-500 @enderror"
                                   placeholder="G-XXXXXXXXXX">
                            <p class="mt-1 text-xs text-gray-500">ID de seguimiento de Google Analytics (formato: G-XXXXXXXXXX)</p>
                            @error('google_analytics_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="google_tag_manager_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Google Tag Manager ID
                            </label>
                            <input type="text" 
                                   id="google_tag_manager_id" 
                                   name="google_tag_manager_id" 
                                   value="{{ old('google_tag_manager_id', $seoSettings->google_tag_manager_id ?? '') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('google_tag_manager_id') border-red-500 @enderror"
                                   placeholder="GTM-XXXXXXX">
                            <p class="mt-1 text-xs text-gray-500">ID de Google Tag Manager (formato: GTM-XXXXXXX)</p>
                            @error('google_tag_manager_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="facebook_pixel_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Facebook Pixel ID
                            </label>
                            <input type="text" 
                                   id="facebook_pixel_id" 
                                   name="facebook_pixel_id" 
                                   value="{{ old('facebook_pixel_id', $seoSettings->facebook_pixel_id ?? '') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('facebook_pixel_id') border-red-500 @enderror"
                                   placeholder="123456789012345">
                            <p class="mt-1 text-xs text-gray-500">ID del píxel de Facebook</p>
                            @error('facebook_pixel_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Configuración Avanzada -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Configuración Avanzada</h3>
                        <p class="text-sm text-gray-500">Opciones adicionales de SEO</p>
                    </div>
                    <div class="px-6 py-6 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       id="robots_index" 
                                       name="robots_index" 
                                       value="1"
                                       {{ old('robots_index', $seoSettings->robots_index ?? true) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="robots_index" class="ml-2 block text-sm text-gray-900">
                                    Permitir indexación
                                </label>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" 
                                       id="robots_follow" 
                                       name="robots_follow" 
                                       value="1"
                                       {{ old('robots_follow', $seoSettings->robots_follow ?? true) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="robots_follow" class="ml-2 block text-sm text-gray-900">
                                    Permitir seguimiento de enlaces
                                </label>
                            </div>
                        </div>

                        <div>
                            <label for="canonical_url" class="block text-sm font-medium text-gray-700 mb-2">
                                URL Canónica
                            </label>
                            <input type="url" 
                                   id="canonical_url" 
                                   name="canonical_url" 
                                   value="{{ old('canonical_url', $seoSettings->canonical_url ?? '') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('canonical_url') border-red-500 @enderror"
                                   placeholder="https://tu-sitio.com">
                            <p class="mt-1 text-xs text-gray-500">URL canónica del sitio (opcional)</p>
                            @error('canonical_url')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="custom_head_code" class="block text-sm font-medium text-gray-700 mb-2">
                                Código Personalizado (Head)
                            </label>
                            <textarea id="custom_head_code" 
                                      name="custom_head_code" 
                                      rows="4"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('custom_head_code') border-red-500 @enderror"
                                      placeholder="<!-- Código personalizado para el <head> -->">{{ old('custom_head_code', $seoSettings->custom_head_code ?? '') }}</textarea>
                            <p class="mt-1 text-xs text-gray-500">Código HTML personalizado que se insertará en el &lt;head&gt;</p>
                            @error('custom_head_code')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="custom_body_code" class="block text-sm font-medium text-gray-700 mb-2">
                                Código Personalizado (Body)
                            </label>
                            <textarea id="custom_body_code" 
                                      name="custom_body_code" 
                                      rows="4"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('custom_body_code') border-red-500 @enderror"
                                      placeholder="<!-- Código personalizado para el <body> -->">{{ old('custom_body_code', $seoSettings->custom_body_code ?? '') }}</textarea>
                            <p class="mt-1 text-xs text-gray-500">Código HTML personalizado que se insertará antes del cierre del &lt;/body&gt;</p>
                            @error('custom_body_code')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="flex justify-end space-x-3 pt-6">
                    <a href="{{ route('creator.seo.index', $website) }}" 
                       class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Guardar Configuración
                    </button>
                </div>
            </form>
        </main>
    </div>

    <script>
        // Contador de caracteres para meta título y descripción
        function updateCharCount(input, maxLength) {
            const count = input.value.length;
            const remaining = maxLength - count;
            
            let counter = input.parentNode.querySelector('.char-counter');
            if (!counter) {
                counter = document.createElement('div');
                counter.className = 'char-counter text-xs mt-1';
                input.parentNode.appendChild(counter);
            }
            
            counter.textContent = `${count}/${maxLength} caracteres`;
            counter.className = `char-counter text-xs mt-1 ${remaining < 10 ? 'text-red-500' : 'text-gray-500'}`;
        }

        document.getElementById('meta_title').addEventListener('input', function() {
            updateCharCount(this, 60);
        });

        document.getElementById('meta_description').addEventListener('input', function() {
            updateCharCount(this, 160);
        });

        document.getElementById('og_title').addEventListener('input', function() {
            updateCharCount(this, 60);
        });

        document.getElementById('og_description').addEventListener('input', function() {
            updateCharCount(this, 160);
        });

        // Inicializar contadores
        updateCharCount(document.getElementById('meta_title'), 60);
        updateCharCount(document.getElementById('meta_description'), 160);
        updateCharCount(document.getElementById('og_title'), 60);
        updateCharCount(document.getElementById('og_description'), 160);
    </script>
</body>
</html>
