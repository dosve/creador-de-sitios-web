<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista Previa - {{ $template->name }}</title>
    @vite('resources/js/app.js')
    <style>
        {!! $template->css_content !!}
    </style>
</head>
<body>
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-4">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('creator.templates.show', $template) }}" class="text-gray-600 hover:text-gray-900">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>
                        <h1 class="text-lg font-medium text-gray-900">Vista Previa: {{ $template->name }}</h1>
                        @if($template->is_premium)
                            <span class="bg-yellow-500 text-white px-2 py-1 rounded-full text-xs font-medium">
                                Premium
                            </span>
                        @else
                            <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs font-medium">
                                Gratis
                            </span>
                        @endif
                    </div>
                    <div class="flex items-center space-x-3">
                        <button onclick="toggleDevice('desktop')" class="px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">
                            Desktop
                        </button>
                        <button onclick="toggleDevice('tablet')" class="px-3 py-1 text-sm bg-gray-600 text-white rounded hover:bg-gray-700">
                            Tablet
                        </button>
                        <button onclick="toggleDevice('mobile')" class="px-3 py-1 text-sm bg-gray-600 text-white rounded hover:bg-gray-700">
                            Móvil
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <!-- Preview Container -->
        <div class="flex justify-center py-8 bg-gray-100">
            <div id="preview-container" class="bg-white shadow-lg rounded-lg overflow-hidden transition-all duration-300">
                <div id="preview-content">
                    {!! $template->html_content !!}
                </div>
            </div>
        </div>

        <!-- Template Info -->
        <div class="max-w-4xl mx-auto px-4 py-8">
            <div class="bg-white rounded-lg shadow-sm border p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-900">{{ $template->name }}</h2>
                    <div class="flex space-x-3">
                        <a href="{{ route('creator.templates.show', $template) }}" 
                           class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 text-sm">
                            Ver Detalles
                        </a>
                        @if(auth()->user()->websites->count() > 0)
                            <button onclick="showApplyModal()" 
                                    class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-sm">
                                Aplicar Plantilla
                            </button>
                        @endif
                    </div>
                </div>
                
                <p class="text-gray-600 mb-4">{{ $template->description }}</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2">Componentes incluidos</h3>
                        <div class="flex flex-wrap gap-2">
                            @if($template->blocks)
                                @foreach($template->blocks as $block)
                                    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ ucfirst($block) }}
                                    </span>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2">Información</h3>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>Categoría: {{ ucfirst($template->category) }}</li>
                            <li>Tipo: {{ $template->is_premium ? 'Premium' : 'Gratuita' }}</li>
                            <li>Responsive: Sí</li>
                            <li>SEO Optimizada: Sí</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Apply Modal -->
    <div id="apply-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Aplicar Plantilla</h3>
                    
                    <form method="POST" action="#" id="apply-form">
                        @csrf
                        <div class="mb-4">
                            <label for="website_select" class="block text-sm font-medium text-gray-700 mb-2">
                                Seleccionar sitio web
                            </label>
                            <select id="website_select" name="website_id" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                @foreach(auth()->user()->websites as $website)
                                    <option value="{{ $website->id }}">{{ $website->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="flex justify-end space-x-3">
                            <button type="button" onclick="hideApplyModal()" 
                                    class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                                Cancelar
                            </button>
                            <button type="submit" 
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Aplicar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Device preview functions
        function toggleDevice(device) {
            const container = document.getElementById('preview-container');
            const buttons = document.querySelectorAll('button[onclick^="toggleDevice"]');
            
            // Reset all buttons
            buttons.forEach(btn => {
                btn.classList.remove('bg-blue-600');
                btn.classList.add('bg-gray-600');
            });
            
            // Set active button
            event.target.classList.remove('bg-gray-600');
            event.target.classList.add('bg-blue-600');
            
            // Apply device styles
            switch(device) {
                case 'desktop':
                    container.style.width = '100%';
                    container.style.maxWidth = '1200px';
                    break;
                case 'tablet':
                    container.style.width = '768px';
                    container.style.maxWidth = '768px';
                    break;
                case 'mobile':
                    container.style.width = '375px';
                    container.style.maxWidth = '375px';
                    break;
            }
        }

        // Modal functions
        function showApplyModal() {
            document.getElementById('apply-modal').classList.remove('hidden');
        }

        function hideApplyModal() {
            document.getElementById('apply-modal').classList.add('hidden');
        }

        // Apply template form
        document.getElementById('apply-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const websiteId = document.getElementById('website_select').value;
            this.action = `/creator/websites/${websiteId}/templates/{{ $template->id }}/apply`;
            this.submit();
        });

        // Close modal on outside click
        document.getElementById('apply-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                hideApplyModal();
            }
        });
    </script>
</body>
</html>
