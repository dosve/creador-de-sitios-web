<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $template['name'] }} - Plantillas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-4">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('creator.templates.index') }}" class="text-gray-600 hover:text-gray-900">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $template['name'] }}</h1>
                        @if($template['is_premium'] ?? false)
                            <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm font-medium">
                                Premium
                            </span>
                        @else
                            <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-medium">
                                Gratis
                            </span>
                        @endif
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('creator.templates.preview', $template['slug']) }}" 
                           class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 text-sm">
                            Vista Previa
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Template Preview -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
                        <div class="aspect-video bg-gradient-to-br from-gray-100 to-gray-200 relative">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="text-center">
                                    <div class="w-20 h-20 bg-blue-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                                        <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Vista Previa de la Plantilla</h3>
                                    <p class="text-gray-600 mb-4">Haz clic en "Vista Previa" para ver la plantilla completa</p>
                                    <a href="{{ route('creator.templates.preview', $template['slug']) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        Ver Vista Previa
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Template Details -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm border p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Detalles de la Plantilla</h2>
                        
                        <div class="space-y-4">
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-2">Descripción</h3>
                                <p class="text-gray-600">{{ $template['description'] }}</p>
                            </div>

                            <div>
                                <h3 class="font-semibold text-gray-900 mb-2">Categoría</h3>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ ucfirst($template['category']) }}
                                </span>
                            </div>

                            <div>
                                <h3 class="font-semibold text-gray-900 mb-2">Componentes incluidos</h3>
                                <div class="flex flex-wrap gap-2">
                                    @if(!empty($template['blocks']))
                                        @foreach($template['blocks'] as $block)
                                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-800">
                                                {{ ucfirst($block) }}
                                            </span>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            <div>
                                <h3 class="font-semibold text-gray-900 mb-2">Tipo</h3>
                                @if($template['is_premium'] ?? false)
                                    <div class="flex items-center text-yellow-600">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                        <span class="text-sm font-medium">Plantilla Premium</span>
                                    </div>
                                @else
                                    <div class="flex items-center text-green-600">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="text-sm font-medium">Plantilla Gratuita</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Apply Template -->
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <h3 class="font-semibold text-gray-900 mb-4">Aplicar a un sitio</h3>
                            
                            @if(auth()->user()->websites->count() > 0)
                                <form method="POST" action="#" id="apply-template-form">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="website_id" class="block text-sm font-medium text-gray-700 mb-2">
                                            Seleccionar sitio web
                                        </label>
                                        <select id="website_id" name="website_id" 
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                            @foreach(auth()->user()->websites as $website)
                                                <option value="{{ $website->id }}">{{ $website->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <button type="submit" 
                                            class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Aplicar Plantilla
                                    </button>
                                </form>
                            @else
                                <div class="text-center py-4">
                                    <p class="text-gray-600 mb-4">Necesitas crear un sitio web primero</p>
                                    <a href="{{ route('creator.websites.create') }}" 
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                        Crear Sitio Web
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Aplicar plantilla
        document.getElementById('apply-template-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const websiteId = document.getElementById('website_id').value;
            const form = this;
            
            // Cambiar la acción del formulario
            form.action = `/creator/websites/${websiteId}/templates/{{ $template['slug'] }}/apply`;
            form.submit();
        });
    </script>
</body>
</html>
