@extends('layouts.creator')

@section('title', 'Nueva Página')
@section('page-title', 'Nueva Página')
@section('content')
            <!-- Create Page Form -->
            <div class="max-w-4xl mx-auto">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Crear Nueva Página</h3>
                    </div>
                    
                    <form method="POST" action="{{ route('creator.pages.store') }}" class="px-6 py-4" id="page-create-form">
                        @csrf
                        
                        <div class="space-y-6">
                            <!-- Page Title -->
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">Título de la Página</label>
                                <div class="mt-1">
                                    <input type="text" name="title" id="title" value="{{ old('title') }}" 
                                           class="px-4 py-4 bg-gray-50 border focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white block w-full sm:text-sm border-gray-700 rounded-md transition-all @error('title') border-red-500 @enderror" 
                                           placeholder="Mi Nueva Página" required>
                                </div>
                                @error('title')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Page Slug -->
                            <div>
                                <label for="slug" class="block text-sm font-medium text-gray-700">URL (Slug)</label>
                                <div class="mt-1">
                                    <input type="text" name="slug" id="slug" value="{{ old('slug') }}" 
                                           class="px-4 py-4 bg-gray-50 border focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white block w-full sm:text-sm border-gray-700 rounded-md transition-all @error('slug') border-red-500 @enderror" 
                                           placeholder="mi-nueva-pagina" required>
                                </div>
                                <p class="mt-2 text-sm text-gray-500">La URL será: {{ url('/') }}/<span id="slug-preview">mi-nueva-pagina</span></p>
                                @error('slug')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tipo de Página -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">Tipo de Página</label>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <!-- Página en Blanco -->
                                    <div class="relative">
                                        <input type="radio" name="page_type" id="page_type_blank" value="blank" 
                                               {{ old('page_type', 'blank') === 'blank' ? 'checked' : '' }}
                                               class="sr-only peer">
                                        <label for="page_type_blank" 
                                               class="relative flex flex-col items-center p-6 transition-all duration-300 border-2 border-gray-200 rounded-xl cursor-pointer peer-checked:border-blue-500 peer-checked:bg-gradient-to-br peer-checked:from-blue-50 peer-checked:to-blue-100 peer-checked:shadow-lg peer-checked:shadow-blue-200 peer-checked:scale-105 hover:border-gray-300 hover:shadow-md">
                                            <!-- Borde destacado cuando está seleccionado -->
                                            <div class="absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-blue-400 peer-checked:shadow-inner"></div>
                                            
                                            <div class="flex items-center justify-center w-16 h-16 mb-4 transition-all duration-300 bg-gray-100 rounded-xl peer-checked:bg-blue-500 peer-checked:shadow-lg">
                                                <svg class="w-8 h-8 text-gray-600 transition-all duration-300 peer-checked:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            </div>
                                            <h3 class="text-xl font-bold text-gray-900 transition-all duration-300 peer-checked:text-blue-800">Página en Blanco</h3>
                                            <p class="mt-2 text-sm text-center text-gray-500 transition-all duration-300 peer-checked:text-blue-600">Crear una página desde cero con contenido básico</p>
                                            
                                            <!-- Badge de seleccionado -->
                                            <div class="absolute -top-2 -right-2 w-6 h-6 transition-all duration-300 bg-gray-300 rounded-full peer-checked:bg-blue-500 peer-checked:scale-110">
                                                <svg class="w-4 h-4 text-white transition-all duration-300 opacity-0 peer-checked:opacity-100" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                        </label>
                                    </div>

                                    <!-- Usar Plantilla -->
                                    <div class="relative">
                                        <input type="radio" name="page_type" id="page_type_template" value="template" 
                                               {{ old('page_type') === 'template' ? 'checked' : '' }}
                                               class="sr-only peer">
                                        <label for="page_type_template" 
                                               class="relative flex flex-col items-center p-6 transition-all duration-300 border-2 border-gray-200 rounded-xl cursor-pointer peer-checked:border-blue-500 peer-checked:bg-gradient-to-br peer-checked:from-blue-50 peer-checked:to-blue-100 peer-checked:shadow-lg peer-checked:shadow-blue-200 peer-checked:scale-105 hover:border-gray-300 hover:shadow-md">
                                            <!-- Borde destacado cuando está seleccionado -->
                                            <div class="absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-blue-400 peer-checked:shadow-inner"></div>
                                            
                                            <div class="flex items-center justify-center w-16 h-16 mb-4 transition-all duration-300 bg-gray-100 rounded-xl peer-checked:bg-blue-500 peer-checked:shadow-lg">
                                                <svg class="w-8 h-8 text-gray-600 transition-all duration-300 peer-checked:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                                </svg>
                                            </div>
                                            <h3 class="text-xl font-bold text-gray-900 transition-all duration-300 peer-checked:text-blue-800">Usar Plantilla</h3>
                                            <p class="mt-2 text-sm text-center text-gray-500 transition-all duration-300 peer-checked:text-blue-600">Seleccionar una plantilla predefinida</p>
                                            
                                            <!-- Badge de seleccionado -->
                                            <div class="absolute -top-2 -right-2 w-6 h-6 transition-all duration-300 bg-gray-300 rounded-full peer-checked:bg-blue-500 peer-checked:scale-110">
                                                <svg class="w-4 h-4 text-white transition-all duration-300 opacity-0 peer-checked:opacity-100" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                        </label>
                                    </div>

                                    <!-- Generar con IA -->
                                    <div class="relative">
                                        <input type="radio" name="page_type" id="page_type_ai" value="ai" 
                                               {{ old('page_type') === 'ai' ? 'checked' : '' }}
                                               class="sr-only peer">
                                        <label for="page_type_ai" 
                                               class="relative flex flex-col items-center p-6 transition-all duration-300 border-2 border-gray-200 rounded-xl cursor-pointer peer-checked:border-purple-500 peer-checked:bg-gradient-to-br peer-checked:from-purple-50 peer-checked:to-purple-100 peer-checked:shadow-lg peer-checked:shadow-purple-200 peer-checked:scale-105 hover:border-gray-300 hover:shadow-md">
                                            <!-- Borde destacado cuando está seleccionado -->
                                            <div class="absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-purple-400 peer-checked:shadow-inner"></div>
                                            
                                            <div class="flex items-center justify-center w-16 h-16 mb-4 transition-all duration-300 bg-gray-100 rounded-xl peer-checked:bg-purple-500 peer-checked:shadow-lg">
                                                <svg class="w-8 h-8 text-gray-600 transition-all duration-300 peer-checked:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                                </svg>
                                            </div>
                                            <h3 class="text-xl font-bold text-gray-900 transition-all duration-300 peer-checked:text-purple-800">Generar con IA</h3>
                                            <p class="mt-2 text-sm text-center text-gray-500 transition-all duration-300 peer-checked:text-purple-600">Crear página usando inteligencia artificial</p>
                                            
                                            <!-- Badge de seleccionado -->
                                            <div class="absolute -top-2 -right-2 w-6 h-6 transition-all duration-300 bg-gray-300 rounded-full peer-checked:bg-purple-500 peer-checked:scale-110">
                                                <svg class="w-4 h-4 text-white transition-all duration-300 opacity-0 peer-checked:opacity-100" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                @error('page_type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Campo de Prompt para IA (se muestra solo si se selecciona "Generar con IA") -->
                            <div id="ai_prompt_section" class="hidden">
                                <label for="ai_prompt" class="block text-sm font-medium text-gray-700">Describe la idea de la página</label>
                                <div class="mt-1">
                                    <textarea name="ai_prompt" id="ai_prompt" rows="4" 
                                              class="px-4 py-4 bg-gray-50 border focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:bg-white block w-full sm:text-sm border-gray-700 rounded-md transition-all @error('ai_prompt') border-red-500 @enderror" 
                                              placeholder="Ejemplo: Página de servicios para una agencia de marketing. Hero atractivo, servicios (SEO, redes sociales, diseño web), testimonios y formulario de contacto."></textarea>
                                </div>
                                <p class="mt-2 text-sm text-gray-500">
                                    Escribe tu idea en una frase o párrafo. Luego usa <strong>Planear con IA</strong> para que te sugiera contenedores y widgets según el catálogo del sistema.
                                </p>
                                <div class="mt-3 flex flex-wrap gap-2">
                                    <button type="button" id="btn_plan_ai" 
                                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                        <span id="btn_plan_text">Planear con IA</span>
                                        <span id="btn_plan_loading" class="hidden ml-2">
                                            <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                        </span>
                                    </button>
                                </div>
                                @error('ai_prompt')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Plan generado por IA: contenedores y prompt refinado (editable antes de crear) -->
                            <div id="ai_plan_section" class="hidden mt-4 p-4 bg-purple-50 border border-purple-200 rounded-lg">
                                <h4 class="text-sm font-semibold text-purple-900 mb-2">Plan de la página (contenedores y widgets)</h4>
                                <div id="ai_plan_containers_list" class="mb-4 space-y-2 text-sm text-gray-700"></div>
                                <label for="ai_refined_prompt" class="block text-sm font-medium text-gray-700 mb-1">Consulta para generar el HTML (puedes editarla)</label>
                                <textarea id="ai_refined_prompt" rows="4" 
                                          class="px-3 py-2 bg-white border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-purple-500 block w-full sm:text-sm"
                                          placeholder="La IA rellenará aquí un texto detallado para la generación. Puedes ajustarlo antes de crear."></textarea>
                                <p class="mt-1 text-xs text-gray-500">Este texto se usará al hacer clic en Crear página. Ajusta secciones o detalles si quieres.</p>
                            </div>

                            <!-- Selector de Plantilla (se muestra solo si se selecciona "Usar Plantilla") -->
                            <div id="template_selector" class="hidden">
                                <label for="template_id" class="block text-sm font-medium text-gray-700">Seleccionar Plantilla</label>
                                <select name="template_id" id="template_id" 
                                        class="mt-1 px-4 py-4 bg-gray-50 block w-full border border-gray-700 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all @error('template_id') border-red-500 @enderror">
                                    <option value="">Selecciona una plantilla...</option>
                                    @foreach($templates ?? [] as $template)
                                        <option value="{{ $template->id }}" {{ old('template_id') == $template->id ? 'selected' : '' }}>
                                            {{ $template->name }} - {{ $template->description }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('template_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-sm text-gray-500">Las plantillas incluyen contenido HTML y CSS predefinido</p>
                            </div>

                            <!-- Published Status -->
                            <div class="flex items-center">
                                <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="is_published" class="ml-2 block text-sm text-gray-900">
                                    Publicar inmediatamente
                                </label>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="mt-6 flex items-center justify-end space-x-3">
                            <a href="{{ route('creator.pages.index') }}" 
                               class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Cancelar
                            </a>
                            <button type="submit" id="submit_btn"
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <span id="submit_text">Crear Página</span>
                                <span id="submit_loading" class="hidden">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Generando...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <script>
                // Auto-generate slug from title
                document.getElementById('title').addEventListener('input', function() {
                    const title = this.value;
                    const slug = title.toLowerCase()
                        .replace(/[^a-z0-9\s-]/g, '')
                        .replace(/\s+/g, '-')
                        .replace(/-+/g, '-')
                        .trim('-');
                    
                    document.getElementById('slug').value = slug;
                    document.getElementById('slug-preview').textContent = slug;
                });

                // Update slug preview
                document.getElementById('slug').addEventListener('input', function() {
                    document.getElementById('slug-preview').textContent = this.value;
                });

                // Manejar el cambio de tipo de página
                document.addEventListener('DOMContentLoaded', function() {
                    console.log('Script de creación de página cargado');
                    
                    const pageTypeInputs = document.querySelectorAll('input[name="page_type"]');
                    const templateSelector = document.getElementById('template_selector');
                    const templateSelect = document.getElementById('template_id');
                    const aiPromptSection = document.getElementById('ai_prompt_section');
                    const aiPrompt = document.getElementById('ai_prompt');
                    const form = document.getElementById('page-create-form') || document.querySelector('form');
                    const submitBtn = document.getElementById('submit_btn');
                    const submitText = document.getElementById('submit_text');
                    const submitLoading = document.getElementById('submit_loading');
                    
                    // Verificar que todos los elementos existan
                    if (!form) {
                        console.error('Formulario no encontrado');
                        return;
                    }
                    if (!aiPromptSection) {
                        console.error('Sección de prompt de IA no encontrada');
                    }
                    if (!submitBtn) {
                        console.error('Botón de envío no encontrado');
                    }
                    
                    console.log('Elementos encontrados:', {
                        form: !!form,
                        aiPromptSection: !!aiPromptSection,
                        submitBtn: !!submitBtn,
                        pageTypeInputs: pageTypeInputs.length
                    });
                    
                    function toggleSections() {
                        const selectedType = document.querySelector('input[name="page_type"]:checked');
                        const planSection = document.getElementById('ai_plan_section');
                        
                        // Ocultar todas las secciones primero
                        templateSelector.classList.add('hidden');
                        templateSelect.required = false;
                        templateSelect.value = '';
                        aiPromptSection.classList.add('hidden');
                        aiPrompt.required = false;
                        aiPrompt.value = '';
                        const planContainersList = document.getElementById('ai_plan_containers_list');
                        if (planSection) planSection.classList.add('hidden');
                        if (planContainersList) planContainersList.innerHTML = '';
                        
                        // Mostrar sección según el tipo seleccionado
                        if (selectedType) {
                            if (selectedType.value === 'template') {
                                templateSelector.classList.remove('hidden');
                                templateSelect.required = true;
                            } else if (selectedType.value === 'ai') {
                                aiPromptSection.classList.remove('hidden');
                                aiPrompt.required = true;
                            }
                        }
                    }
                    
                    // Agregar event listeners a los radio buttons
                    pageTypeInputs.forEach(input => {
                        input.addEventListener('change', toggleSections);
                    });
                    
                    // Manejar envío del formulario - DEBE SER EL PRIMERO Y CON capture: true
                    form.addEventListener('submit', function(e) {
                        console.log('Evento submit capturado');
                        const selectedType = document.querySelector('input[name="page_type"]:checked');
                        
                        console.log('Formulario enviado, tipo seleccionado:', selectedType ? selectedType.value : 'ninguno');
                        
                        // SIEMPRE prevenir el envío por defecto si es IA
                        if (selectedType && selectedType.value === 'ai') {
                            e.preventDefault();
                            e.stopPropagation();
                            e.stopImmediatePropagation();
                            console.log('Procesando generación con IA - envío prevenido');
                            
                            // Validar campos requeridos
                            const title = document.getElementById('title').value;
                            const slug = document.getElementById('slug').value;
                            const prompt = aiPrompt.value.trim();
                            // Usar prompt refinado si existe (después de planear), sino la idea original
                            const refinedPromptEl = document.getElementById('ai_refined_prompt');
                            const promptToSend = (refinedPromptEl && refinedPromptEl.value.trim().length >= 10)
                                ? refinedPromptEl.value.trim()
                                : prompt;
                            
                            console.log('Datos del formulario:', { title, slug, prompt_length: promptToSend.length });
                            
                            if (!title || !slug || !prompt) {
                                alert('Por favor completa todos los campos requeridos');
                                return false;
                            }
                            
                            if (promptToSend.length < 10) {
                                alert('La consulta debe tener al menos 10 caracteres. Escribe tu idea o usa Planear con IA.');
                                return false;
                            }
                            
                            // Mostrar loading
                            submitBtn.disabled = true;
                            submitText.classList.add('hidden');
                            submitLoading.classList.remove('hidden');
                            
                            const url = '{{ route("creator.pages.generate-ai") }}';
                            const csrfToken = '{{ csrf_token() }}';
                            
                            // Solo enviar website si no hay sesión (como fallback)
                            const urlParams = new URLSearchParams(window.location.search);
                            const websiteParam = urlParams.get('website');
                            const requestData = {
                                title: title,
                                slug: slug,
                                prompt: promptToSend,
                                is_published: document.getElementById('is_published').checked
                            };
                            
                            // Solo agregar website si viene en la URL (fallback)
                            if (websiteParam) {
                                requestData.website = websiteParam;
                            }
                            
                            console.log('Enviando petición a:', url);
                            console.log('Datos enviados:', requestData);
                            
                            // Enviar petición AJAX
                            fetch(url, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Accept': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest'
                                },
                                body: JSON.stringify(requestData)
                            })
                            .then(response => {
                                console.log('Respuesta recibida, status:', response.status);
                                if (!response.ok) {
                                    return response.json().then(err => {
                                        throw new Error(err.message || 'Error en la respuesta del servidor');
                                    });
                                }
                                return response.json();
                            })
                            .then(data => {
                                console.log('Datos recibidos:', data);
                                if (data.success) {
                                    window.location.href = data.page.url;
                                } else {
                                    alert('Error: ' + (data.message || 'No se pudo generar la página'));
                                    submitBtn.disabled = false;
                                    submitText.classList.remove('hidden');
                                    submitLoading.classList.add('hidden');
                                }
                            })
                            .catch(error => {
                                console.error('Error completo:', error);
                                alert('Error al generar la página: ' + error.message);
                                submitBtn.disabled = false;
                                submitText.classList.remove('hidden');
                                submitLoading.classList.add('hidden');
                            });
                            
                            return false; // Prevenir cualquier otro comportamiento
                        }
                    }, true); // Usar capture phase para capturar antes que otros listeners
                    
                    // Botón Planear con IA
                    const btnPlanAi = document.getElementById('btn_plan_ai');
                    const btnPlanText = document.getElementById('btn_plan_text');
                    const btnPlanLoading = document.getElementById('btn_plan_loading');
                    const aiPlanSection = document.getElementById('ai_plan_section');
                    const aiPlanContainersList = document.getElementById('ai_plan_containers_list');
                    const aiRefinedPrompt = document.getElementById('ai_refined_prompt');
                    if (btnPlanAi && aiPrompt) {
                        btnPlanAi.addEventListener('click', function() {
                            const idea = aiPrompt.value.trim();
                            if (idea.length < 10) {
                                alert('Escribe al menos 10 caracteres describiendo tu idea antes de planear.');
                                return;
                            }
                            btnPlanText.classList.add('hidden');
                            btnPlanLoading.classList.remove('hidden');
                            btnPlanAi.disabled = true;
                            fetch('{{ route("creator.pages.plan-with-ai") }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest'
                                },
                                body: JSON.stringify({ prompt: idea })
                            })
                            .then(r => r.json())
                            .then(data => {
                                if (data.success) {
                                    const list = document.getElementById('ai_plan_containers_list');
                                    const items = (data.containers || data.sections || []).map((c, i) => {
                                        let html = '<div class="border-l-2 border-purple-200 pl-2 mb-2">';
                                        html += '<div class="flex gap-2"><span class="font-medium text-purple-700">' + (i + 1) + '. ' + (c.title || 'Contenedor') + '</span>';
                                        html += '<span class="text-gray-600">— ' + (c.description || '') + '</span>';
                                        if (c.suggested_components && c.suggested_components.length) html += '<span class="text-xs text-gray-500">[' + c.suggested_components.join(', ') + ']</span>';
                                        html += '</div>';
                                        if (c.widgets && c.widgets.length) {
                                            html += '<div class="mt-1 ml-2 text-xs text-gray-600 space-y-0.5">';
                                            c.widgets.forEach(function(w) {
                                                const content = (w.content || '').substring(0, 60) + ((w.content || '').length > 60 ? '…' : '');
                                                html += '<div><span class="text-purple-600">' + (w.id || '') + '</span>: ' + content + '</div>';
                                            });
                                            html += '</div>';
                                        }
                                        html += '</div>';
                                        return html;
                                    }).join('');
                                    if (list) list.innerHTML = items;
                                    if (aiRefinedPrompt) aiRefinedPrompt.value = data.refined_prompt || '';
                                    aiPlanSection.classList.remove('hidden');
                                } else {
                                    alert(data.message || 'No se pudo generar el plan.');
                                }
                            })
                            .catch(err => {
                                console.error(err);
                                alert('Error al planear: ' + (err.message || 'Intenta de nuevo.'));
                            })
                            .finally(function() {
                                btnPlanText.classList.remove('hidden');
                                btnPlanLoading.classList.add('hidden');
                                btnPlanAi.disabled = false;
                            });
                        });
                    }
                    
                    // Ejecutar al cargar la página
                    toggleSections();
                });
            </script>
@endsection