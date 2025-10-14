<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Editor - {{ $editable->name ?? $editable->title }} - {{ $website->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/grapesjs/dist/css/grapes.min.css">
    <style>

      :root{
        --gjs-primary: #2563eb;          /* botones/acentos */
        --gjs-secondary: #111827;        /* texto principal */
        --gjs-tertiary: #6b7280;         /* texto suave */
        --gjs-quaternary: #e5e7eb;       /* bordes suaves */
        --gjs-bg: #ffffff;               /* fondo paneles */
        --gjs-font-size: 13px;
        }

        /* Fallback para versiones viejas (clases "one/two/three/four") */
        .gjs-one-bg{ background:#ffffff; }
        .gjs-two-color{ color:#111827; }
        .gjs-three-bg{ background:#f3f4f6; }   /* barras/paneles secundarios */
        .gjs-four-color{ color:#374151; }

        .gjs-cv-canvas {
            width: 100% !important;
        }

        /* Paneles y botones */
        .gjs-pn-panel,
        .gjs-pn-views,
        .gjs-pn-options,
        .gjs-pn-commands{ background:#ffffff; border-color:#e5e7eb; }
        .gjs-pn-btn{ color:#374151; }
        .gjs-pn-btn.gjs-pn-active,
        .gjs-pn-btn:hover{ background:#e5effe; color:#1d4ed8; }

        /* Contenedores de bloques/estilos/capas */
        .gjs-blocks-c,
        .gjs-layer-manager,
        .gjs-sm-sectors{ background:#f8fafc; color:#111827; }
        .gjs-block, .gjs-block-label{ color:#111827; }
        .gjs-field{ background:#ffffff; color:#111827; border-color:#e5e7eb; }

        /* Forzar visibilidad de los managers */
        .gjs-sm-sectors {
          display: block !important;
          visibility: visible !important;
        }
        
        .gjs-sm-sector {
          display: block !important;
          visibility: visible !important;
        }
        
        .gjs-sm-property {
          display: block !important;
          visibility: visible !important;
        }
        
        .gjs-sm-label {
          display: block !important;
          visibility: visible !important;
        }
        
        .gjs-sm-field {
          display: block !important;
          visibility: visible !important;
        }

        /* Estilos para sectores expandibles */
        .gjs-sm-sector .gjs-sm-title {
          cursor: pointer !important;
          user-select: none !important;
        }

        .gjs-sm-sector .gjs-sm-title:hover {
          background-color: #f3f4f6 !important;
        }

        /* Asegurar que los sectores colapsados oculten su contenido */
        .gjs-sm-sector.gjs-sm-open .gjs-sm-properties {
          display: block !important;
        }

        .gjs-sm-properties {
          display: block !important;
          visibility: visible !important;
        }

        .gjs-sm-sector:not(.gjs-sm-open) .gjs-sm-properties {
          display: none !important;
        }

        /* Estilos para dropdowns del StyleManager */
        .gjs-sm-field select {
          background: #ffffff !important;
          border: 1px solid #e5e7eb !important;
          border-radius: 4px !important;
          padding: 4px 8px !important;
          color: #111827 !important;
          font-size: 13px !important;
          border-bottom: 1px solid #e5e7eb !important;
        }

        .gjs-sm-field select:focus {
          outline: none !important;
          border-color: #2563eb !important;
          box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1) !important;
        }

        /* Eliminar líneas/bordes no deseados */
        .gjs-sm-field {
          border-bottom: none !important;
        }

        .gjs-sm-property {
          border-bottom: none !important;
        }

        /* Estilos específicos para controles de radio/button groups */
        .gjs-sm-field .gjs-sm-radio {
          border: none !important;
          background: transparent !important;
        }

        .gjs-sm-field .gjs-sm-radio-item {
          border: 1px solid #e5e7eb !important;
          background: #ffffff !important;
          border-radius: 0 !important;
        }

        .gjs-sm-field .gjs-sm-radio-item:first-child {
          border-top-left-radius: 4px !important;
          border-bottom-left-radius: 4px !important;
        }

        .gjs-sm-field .gjs-sm-radio-item:last-child {
          border-top-right-radius: 4px !important;
          border-bottom-right-radius: 4px !important;
        }

        .gjs-sm-field .gjs-sm-radio-item.gjs-sm-active {
          background: #2563eb !important;
          color: #ffffff !important;
          border-color: #2563eb !important;
        }

        /* Estilos para inputs del StyleManager */
        .gjs-sm-field input {
          background: #ffffff !important;
          border: 1px solid #e5e7eb !important;
          border-radius: 4px !important;
          padding: 4px 8px !important;
          color: #111827 !important;
          font-size: 13px !important;
        }

        .gjs-sm-field input:focus {
          outline: none !important;
          border-color: #2563eb !important;
          box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1) !important;
        }

        /* Eliminar líneas adicionales y separadores no deseados */
        .gjs-sm-property::after {
          display: none !important;
        }

        .gjs-sm-property::before {
          display: none !important;
        }

        .gjs-sm-field::after {
          display: none !important;
        }

        .gjs-sm-field::before {
          display: none !important;
        }

        /* Eliminar bordes de separación entre propiedades */
        .gjs-sm-property + .gjs-sm-property {
          border-top: none !important;
        }

        /* Estilos para el contenedor de propiedades */
        .gjs-sm-properties {
          border: none !important;
        }

        /* Eliminar líneas de separación en radio buttons */
        .gjs-sm-radio-item + .gjs-sm-radio-item {
          border-left: none !important;
        }


        /* Canvas alrededor del lienzo (fuera del iframe) */
        .gjs-editor-cont, .gjs-cv-canvas{ background:#f3f4f6; }

        /* Bloques con colores de categoría */
        .gjs-block-section { background: #e3f2fd; border: 2px dashed #2196f3; }
        .gjs-block-text { background: #f3e5f5; border: 2px dashed #9c27b0; }
        .gjs-block-image { background: #e8f5e8; border: 2px dashed #4caf50; }
        .gjs-block-button { background: #fff3e0; border: 2px dashed #ff9800; }
        .gjs-block-video { background: #fce4ec; border: 2px dashed #e91e63; }
        .gjs-block-form { background: #e0f2f1; border: 2px dashed #009688; }
        .gjs-block-pricing { background: #fff8e1; border: 2px dashed #ffc107; }
        .gjs-block-testimonial { background: #e8eaf6; border: 2px dashed #3f51b5; }
        .gjs-block-social { background: #f1f8e9; border: 2px dashed #8bc34a; }
        .gjs-block-map { background: #e3f2fd; border: 2px dashed #2196f3; }
        .gjs-block-gallery { background: #fce4ec; border: 2px dashed #e91e63; }
        .gjs-block-products { background: #e8f5e8; border: 2px dashed #4caf50; }

        .gjs-block {
            width: auto;
            height: auto;
            min-height: auto;
            padding: 8px;
            margin: 4px;
        }

        .gjs-block-label {
            font-size: 11px;
            color: #374151;
            padding-top: 5px;
        }

        /* Mejorar la apariencia de los bloques */
        .gjs-blocks-cs {
            display: flex;
            flex-wrap: wrap;
            gap: 2px;
        }

        .gjs-block {
            flex: 0 0 auto;
            min-width: 80px;
            text-align: center;
        }

        /* Estilos para el header y sidebar */
        .tab-button.active {
            color: #2563eb;
            border-bottom-color: #2563eb;
        }

        .panel-content {
            height: calc(100vh - 200px);
            overflow-y: auto;
        }


        /* Responsive */
        @media (max-width: 768px) {
            .gjs-blocks-cs {
                justify-content: center;
            }
            
            .gjs-block {
                min-width: 70px;
                font-size: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="flex flex-col min-h-screen">
        <!-- Header -->
        <header class="flex-shrink-0 bg-white border-b shadow-sm">
            <div class="px-4 py-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('creator.websites.show', session('selected_website_id')) }}" class="text-gray-600 hover:text-gray-900">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>
                        <div>
                            <h1 class="text-lg font-medium text-gray-900">{{ $editable->name ?? $editable->title }}</h1>
                            <p class="text-sm text-gray-500">{{ $website->name }} - {{ $editable->type ?? 'Página' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <!-- Botones de vista de dispositivos -->
                        <div class="flex items-center p-1 bg-white border border-gray-200 rounded-lg">
                            <button id="desktop-view" class="p-2 text-blue-600 transition-colors rounded-md bg-blue-50 hover:bg-blue-100" title="Vista Desktop">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </button>
                            <button id="tablet-view" class="p-2 text-gray-500 transition-colors rounded-md hover:text-blue-600 hover:bg-blue-50" title="Vista Tablet">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                            </button>
                            <button id="mobile-view" class="p-2 text-gray-500 transition-colors rounded-md hover:text-blue-600 hover:bg-blue-50" title="Vista Móvil">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                            </button>
                        </div>
                        
                        <!-- Botones de acciones -->
                        <button id="fullscreen-btn" class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50" title="Pantalla Completa">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                            </svg>
                        </button>
                        <button id="code-view-btn" class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50" title="Ver Código">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                            </svg>
                        </button>
                        
                        <button id="save-btn" class="px-4 py-2 text-sm text-white bg-blue-600 rounded-md hover:bg-blue-700">
                            Guardar
                        </button>
                        @if($editableType === 'page')
                        <a href="{{ route('creator.preview.page', [$website, $editable]) }}" target="_blank" class="px-4 py-2 text-sm text-white bg-gray-600 rounded-md hover:bg-gray-700">
                            Vista Previa
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </header>

        <!-- Editor -->
        <div class="flex flex-1">
            <!-- Sidebar con paneles -->
            <div class="flex flex-col border-r border-gray-200 w-80 bg-gray-50">
                <!-- Panel Tabs -->
                <div class="border-b border-gray-200">
                    <nav class="flex items-center gap-4 px-3 overflow-x-auto whitespace-nowrap" aria-label="Tabs">
                        <button class="px-1 py-3 text-sm font-medium text-center text-blue-600 border-b-2 border-blue-500 tab-button active" data-panel="blocks">
                            Bloques
                        </button>
                        <button class="px-1 py-3 text-sm font-medium text-center text-gray-500 border-b-2 border-transparent tab-button hover:text-gray-700" data-panel="layers">
                            Capas
                        </button>
                        <button class="px-1 py-3 text-sm font-medium text-center text-gray-500 border-b-2 border-transparent tab-button hover:text-gray-700" data-panel="styles">
                            Estilos
                        </button>
                        <button class="px-1 py-3 text-sm font-medium text-center text-gray-500 border-b-2 border-transparent tab-button hover:text-gray-700" data-panel="traits">
                            Propiedades
                        </button>
                        <button class="px-1 py-3 text-sm font-medium text-center text-gray-500 border-b-2 border-transparent tab-button hover:text-gray-700" data-panel="config">
                            Configuración
                        </button>
                    </nav>
                </div>

                <!-- Panel Content -->
                <div class="flex-1 overflow-auto">
                    <div id="blocks-panel" class="p-4 panel-content">
                        <div id="gjs-blocks" class="gjs-blocks-container"></div>
                    </div>
                    <div id="layers-panel" class="hidden p-4 panel-content">
                        <div class="layers-container"></div>
                    </div>
                    <div id="styles-panel" class="hidden p-4 panel-content">
                        <div class="styles-container"></div>
                    </div>
                    <div id="traits-panel" class="hidden p-4 panel-content">
                        <div class="traits-container"></div>
                    </div>
                    <div id="config-panel" class="hidden p-4 panel-content">
                        <div class="config-container">
                            <h3 class="mb-4 text-lg font-semibold text-gray-900">Configuración de la Página</h3>
                            
                            <!-- Configuración General -->
                            <div class="mb-6">
                                <h4 class="mb-3 text-sm font-medium text-gray-700">General</h4>
                                <div class="space-y-3">
                                    <div>
                                        <label class="block mb-1 text-sm text-gray-600">Título de la página</label>
                                        <input type="text" id="page-title" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Mi página" value="{{ $editable->title ?? '' }}">
                                    </div>
                                    <div>
                                        <label class="block mb-1 text-sm text-gray-600">URL (Slug)</label>
                                        <input type="text" id="page-slug" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="mi-pagina" value="{{ $editable->slug ?? '' }}">
                                        <p class="mt-1 text-xs text-gray-500">La URL será: {{ url('/') }}/{{ $website->slug ?? 'sitio' }}/<span id="slug-preview">{{ $editable->slug ?? 'mi-pagina' }}</span></p>
                                    </div>
                                    <div>
                                        <label class="block mb-1 text-sm text-gray-600">Descripción</label>
                                        <textarea id="page-description" rows="3" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Descripción de la página"></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Configuración de Estado -->
                            <div class="mb-6">
                                <h4 class="mb-3 text-sm font-medium text-gray-700">Estado de la Página</h4>
                                <div class="space-y-3">
                                    <div class="flex items-center">
                                        <input type="checkbox" id="is-published" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2" {{ ($editable->is_published ?? false) ? 'checked' : '' }}>
                                        <label for="is-published" class="ml-2 text-sm text-gray-600">Página publicada</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" id="is-home" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2" {{ ($editable->is_home ?? false) ? 'checked' : '' }}>
                                        <label for="is-home" class="ml-2 text-sm text-gray-600">Página de inicio</label>
                                        <p class="ml-2 text-xs text-gray-500">(Esta será la página principal del sitio)</p>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" id="enable-store" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                        <label for="enable-store" class="ml-2 text-sm text-gray-600">Habilitar tienda virtual</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Configuración SEO -->
                            <div class="mb-6">
                                <h4 class="mb-3 text-sm font-medium text-gray-700">SEO</h4>
                                <div class="space-y-3">
                                    <div>
                                        <label class="block mb-1 text-sm text-gray-600">Meta título</label>
                                        <input type="text" id="meta-title" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Título para SEO">
                                    </div>
                                    <div>
                                        <label class="block mb-1 text-sm text-gray-600">Meta descripción</label>
                                        <textarea id="meta-description" rows="2" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Descripción para SEO"></textarea>
                                    </div>
                                    <div>
                                        <label class="block mb-1 text-sm text-gray-600">Palabras clave</label>
                                        <input type="text" id="meta-keywords" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="palabra1, palabra2, palabra3">
                                    </div>
                                </div>
                            </div>

                            <!-- Configuración de Estilos -->
                            <div class="mb-6">
                                <h4 class="mb-3 text-sm font-medium text-gray-700">Estilos Globales</h4>
                                <div class="space-y-3">
                                    <div>
                                        <label class="block mb-1 text-sm text-gray-600">Color principal</label>
                                        <input type="color" id="primary-color" class="w-full h-10 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" value="#2563eb">
                                    </div>
                                    <div>
                                        <label class="block mb-1 text-sm text-gray-600">Fuente principal</label>
                                        <select id="primary-font" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="Inter">Inter</option>
                                            <option value="Roboto">Roboto</option>
                                            <option value="Open Sans">Open Sans</option>
                                            <option value="Lato">Lato</option>
                                            <option value="Poppins">Poppins</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Botones de Acción -->
                            <div class="space-y-2">
                                <button id="apply-config" class="w-full px-4 py-2 text-sm text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    Aplicar Configuración
                                </button>
                                <button id="reset-config" class="w-full px-4 py-2 text-sm text-gray-600 bg-gray-100 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                    Restablecer
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Editor Canvas -->
            <div class="flex flex-col flex-1">
                <!-- Indicador de carga -->
                <div id="loading-indicator" class="fixed inset-0 z-50 flex items-center justify-center bg-white">
                  <div class="text-center">
                    <div class="w-12 h-12 mx-auto mb-4 border-b-2 border-blue-600 rounded-full animate-spin"></div>
                    <p class="text-gray-600">Cargando editor...</p>
                  </div>
                </div>
                
                <div id="gjs" style="height: 100%; display: none;"></div>
            </div>
        </div>
    </div>

    <!-- Campos ocultos para contenido existente -->
    @if($editable->html_content)
        <input type="hidden" id="page-html-content" value="{{ $editable->html_content }}">
    @endif
    @if($editable->css_content)
        <input type="hidden" id="page-css-content" value="{{ $editable->css_content }}">
    @endif

    <script>
    // Suprimir advertencias de source maps
    if (typeof console !== 'undefined' && console.warn) {
      const originalWarn = console.warn;
      console.warn = function(...args) {
        if (args[0] && typeof args[0] === 'string' && args[0].includes('source map')) {
          return; // Suprimir advertencias de source maps
        }
        originalWarn.apply(console, args);
      };
    }
    </script>
    
    <script src="https://unpkg.com/grapesjs@0.21.7/dist/grapes.min.js"></script>
    <script src="{{ asset('js/editor-config.js') }}"></script>
    <script>
    // Configurar variables globales para el editor
    window.saveUrl = '{{ $saveRoute }}';
    window.csrfToken = '{{ csrf_token() }}';
    window.editableType = '{{ $editableType }}'; // 'page' o 'component'
    
    // Configurar bloques del editor
    window.editorBlocks = [
      @include('creator.blocks.all')
    ];
    </script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
      console.log('DOM cargado, iniciando GrapesJS...');

      // Verificar que GrapesJS esté disponible
      if (typeof grapesjs === 'undefined') {
        console.error('GrapesJS no se ha cargado correctamente');
        alert('Error: El editor no se pudo cargar. Por favor, recarga la página.');
        return;
      }

      console.log('GrapesJS disponible:', grapesjs);
      
      // Inicializar el editor
      initializeEditor();
      

      // Funcionalidad de las pestañas del sidebar
      document.querySelectorAll('.tab-button').forEach(tab => {
        tab.addEventListener('click', function() {
          const panelId = this.getAttribute('data-panel');
          
          // Remover clase active de todas las pestañas y paneles
          document.querySelectorAll('.tab-button').forEach(t => {
            t.classList.remove('active', 'text-blue-600', 'border-blue-500');
            t.classList.add('text-gray-500', 'border-transparent');
          });
          document.querySelectorAll('.panel-content').forEach(p => p.classList.add('hidden'));
          
          // Agregar clase active a la pestaña y panel seleccionados
          this.classList.add('active', 'text-blue-600', 'border-blue-500');
          this.classList.remove('text-gray-500', 'border-transparent');
          document.getElementById(panelId + '-panel').classList.remove('hidden');
          
          // Forzar actualización de los managers cuando se cambia de pestaña
          setTimeout(() => {
            if (window.updateManagers) {
              window.updateManagers();
            }
          }, 100);
        });
      });

      // Funcionalidad del panel de configuración
      const applyConfigBtn = document.getElementById('apply-config');
      const resetConfigBtn = document.getElementById('reset-config');
      
      // Actualizar preview del slug
      const slugInput = document.getElementById('page-slug');
      const slugPreview = document.getElementById('slug-preview');
      if (slugInput && slugPreview) {
        slugInput.addEventListener('input', function() {
          slugPreview.textContent = this.value || 'mi-pagina';
        });
      }
      
      if (applyConfigBtn) {
        applyConfigBtn.addEventListener('click', function() {
          const config = {
            pageTitle: document.getElementById('page-title').value,
            pageSlug: document.getElementById('page-slug').value,
            pageDescription: document.getElementById('page-description').value,
            isPublished: document.getElementById('is-published').checked,
            isHome: document.getElementById('is-home').checked,
            enableStore: document.getElementById('enable-store').checked,
            metaTitle: document.getElementById('meta-title').value,
            metaDescription: document.getElementById('meta-description').value,
            metaKeywords: document.getElementById('meta-keywords').value,
            primaryColor: document.getElementById('primary-color').value,
            primaryFont: document.getElementById('primary-font').value
          };
          
          // Guardar configuración de la página
          savePageConfig(config);
          
          // Aplicar configuración al editor
          if (window.editor) {
            // Aplicar estilos globales
            const css = `
              :root {
                --primary-color: ${config.primaryColor};
                --primary-font: '${config.primaryFont}', sans-serif;
              }
              body {
                font-family: var(--primary-font);
              }
            `;
            
            // Agregar estilos al editor
            window.editor.setStyle(css);
            
            // Guardar configuración en localStorage
            localStorage.setItem('website-config', JSON.stringify(config));
            
            
            // Mostrar mensaje de éxito
            this.textContent = '✓ Aplicado';
            this.classList.remove('bg-blue-600', 'hover:bg-blue-700');
            this.classList.add('bg-green-600');
            
            setTimeout(() => {
              this.textContent = 'Aplicar Configuración';
              this.classList.remove('bg-green-600');
              this.classList.add('bg-blue-600', 'hover:bg-blue-700');
            }, 2000);
          }
        });
      }
      
      if (resetConfigBtn) {
        resetConfigBtn.addEventListener('click', function() {
          // Restablecer valores por defecto
          document.getElementById('page-title').value = '{{ $editable->title ?? "" }}';
          document.getElementById('page-slug').value = '{{ $editable->slug ?? "" }}';
          document.getElementById('page-description').value = '';
          document.getElementById('is-published').checked = {{ ($editable->is_published ?? false) ? 'true' : 'false' }};
          document.getElementById('is-home').checked = {{ ($editable->is_home ?? false) ? 'true' : 'false' }};
          document.getElementById('enable-store').checked = false;
          document.getElementById('meta-title').value = '';
          document.getElementById('meta-description').value = '';
          document.getElementById('meta-keywords').value = '';
          document.getElementById('primary-color').value = '#2563eb';
          document.getElementById('primary-font').value = 'Inter';
          
          // Actualizar preview del slug
          if (slugPreview) {
            slugPreview.textContent = '{{ $editable->slug ?? "mi-pagina" }}';
          }
          
          // Mostrar mensaje
          this.textContent = '✓ Restablecido';
          this.classList.remove('bg-gray-100', 'hover:bg-gray-200');
          this.classList.add('bg-green-100', 'text-green-700');
          
          setTimeout(() => {
            this.textContent = 'Restablecer';
            this.classList.remove('bg-green-100', 'text-green-700');
            this.classList.add('bg-gray-100', 'hover:bg-gray-200');
          }, 2000);
        });
      }

      // Función para guardar configuración de la página
      function savePageConfig(config) {
        const requestData = {
          title: config.pageTitle,
          slug: config.pageSlug,
          is_published: config.isPublished,
          is_home: config.isHome,
          _token: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || window.csrfToken
        };

        fetch('{{ route("creator.pages.update", [$website, $editable]) }}', {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || window.csrfToken
          },
          body: JSON.stringify(requestData)
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            console.log('✅ Configuración de página guardada');
          } else {
            console.error('❌ Error al guardar configuración:', data.message);
          }
        })
        .catch(error => {
          console.error('❌ Error al guardar configuración:', error);
        });
      }

      // Funcionalidad de botones de dispositivos y vista previa
      const desktopBtn = document.getElementById('desktop-view');
      const tabletBtn = document.getElementById('tablet-view');
      const mobileBtn = document.getElementById('mobile-view');
      const fullscreenBtn = document.getElementById('fullscreen-btn');
      const codeViewBtn = document.getElementById('code-view-btn');
      
      // Configuraciones de dispositivos para GrapesJS
      const deviceConfigs = {
        desktop: {
          width: '100%',
          height: '100%',
          name: 'Desktop'
        },
        tablet: {
          width: '768px',
          height: '1024px',
          name: 'Tablet'
        },
        mobile: {
          width: '375px',
          height: '667px',
          name: 'Mobile'
        }
      };
      
      // Función para cambiar vista de dispositivo
      function switchDevice(device) {
        console.log('switchDevice llamado con:', device);
        console.log('Editor disponible:', !!window.editor);
        
        if (window.editor) {
          // Mapear nombres de dispositivos
          const deviceMap = {
            'desktop': 'Desktop',
            'tablet': 'Tablet', 
            'mobile': 'Mobile'
          };
          
          const deviceName = deviceMap[device];
          console.log('Cambiando a dispositivo:', deviceName);
          
          // Cambiar dispositivo en GrapesJS usando el comando correcto
          window.editor.runCommand('set-device-' + device);
          
          // Actualizar botones activos
          [desktopBtn, tabletBtn, mobileBtn].forEach(btn => {
            if (btn) {
              btn.classList.remove('text-blue-600', 'bg-blue-50');
              btn.classList.add('text-gray-500');
            }
          });
          
          // Activar botón seleccionado
          const activeBtn = document.getElementById(device + '-view');
          if (activeBtn) {
            activeBtn.classList.remove('text-gray-500');
            activeBtn.classList.add('text-blue-600', 'bg-blue-50');
          }
        }
      }
      
      // Event listeners para los botones de dispositivos
      console.log('Botones encontrados:', { desktopBtn, tabletBtn, mobileBtn });
      
      if (desktopBtn) {
        desktopBtn.addEventListener('click', () => {
          console.log('Click en desktop');
          switchDevice('desktop');
        });
      }
      if (tabletBtn) {
        tabletBtn.addEventListener('click', () => {
          console.log('Click en tablet');
          switchDevice('tablet');
        });
      }
      if (mobileBtn) {
        mobileBtn.addEventListener('click', () => {
          console.log('Click en mobile');
          switchDevice('mobile');
        });
      }
      
      // Función para pantalla completa
      if (fullscreenBtn) {
        fullscreenBtn.addEventListener('click', function() {
          if (!document.fullscreenElement) {
            // Entrar en pantalla completa
            document.documentElement.requestFullscreen().then(() => {
              this.innerHTML = `
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 9V4.5M9 9H4.5M9 9L3.5 3.5M15 9v-4.5M15 9h4.5M15 9l5.5-5.5M9 15v4.5M9 15H4.5M9 15l-5.5 5.5M15 15v4.5M15 15h4.5m0 0l-5.5 5.5"></path>
                </svg>
              `;
              this.title = 'Salir de Pantalla Completa';
            });
          } else {
            // Salir de pantalla completa
            document.exitFullscreen().then(() => {
              this.innerHTML = `
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                </svg>
              `;
              this.title = 'Pantalla Completa';
            });
          }
        });
      }
      
      // Función para ver código
      if (codeViewBtn) {
        codeViewBtn.addEventListener('click', function() {
          if (window.editor) {
            // Obtener HTML y CSS del editor
            const html = window.editor.getHtml();
            const css = window.editor.getCss();
            
            // Función para escapar HTML y mostrarlo como texto plano
            function escapeHtml(text) {
              const div = document.createElement('div');
              div.textContent = text;
              return div.innerHTML;
            }
            
            // Función para formatear HTML con indentación
            function formatHtml(html) {
              let formatted = html;
              let indent = 0;
              const tab = '  '; // 2 espacios
              
              // Agregar saltos de línea después de etiquetas de cierre
              formatted = formatted.replace(/></g, '>\n<');
              
              // Dividir en líneas y formatear
              const lines = formatted.split('\n');
              const formattedLines = lines.map(line => {
                line = line.trim();
                if (!line) return '';
                
                // Reducir indentación para etiquetas de cierre
                if (line.startsWith('</')) {
                  indent = Math.max(0, indent - 1);
                }
                
                // Aplicar indentación
                const indentedLine = tab.repeat(indent) + line;
                
                // Aumentar indentación para etiquetas de apertura (que no sean self-closing)
                if (line.startsWith('<') && !line.startsWith('</') && !line.endsWith('/>') && !line.includes('</')) {
                  indent++;
                }
                
                return indentedLine;
              });
              
              return formattedLines.join('\n');
            }
            
            // Función para formatear CSS con indentación
            function formatCss(css) {
              let formatted = css;
              
              // Agregar saltos de línea después de llaves de apertura
              formatted = formatted.replace(/\{/g, ' {\n');
              
              // Agregar saltos de línea después de punto y coma
              formatted = formatted.replace(/;/g, ';\n');
              
              // Agregar saltos de línea después de llaves de cierre
              formatted = formatted.replace(/\}/g, '\n}\n');
              
              // Dividir en líneas y formatear
              const lines = formatted.split('\n');
              let indent = 0;
              const tab = '  '; // 2 espacios
              
              const formattedLines = lines.map(line => {
                line = line.trim();
                if (!line) return '';
                
                // Reducir indentación para llaves de cierre
                if (line === '}') {
                  indent = Math.max(0, indent - 1);
                }
                
                // Aplicar indentación
                const indentedLine = tab.repeat(indent) + line;
                
                // Aumentar indentación después de llaves de apertura
                if (line.endsWith('{')) {
                  indent++;
                }
                
                return indentedLine;
              });
              
              return formattedLines.join('\n');
            }
            
            
            // Crear ventana modal para mostrar el código
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
            modal.innerHTML = `
              <div class="bg-white rounded-lg shadow-xl max-w-7xl w-full mx-4 max-h-[90vh] flex flex-col">
                <div class="flex items-center justify-between p-4 border-b bg-gray-50">
                  <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900">Código de la Página</h3>
                  </div>
                  <button class="text-gray-400 transition-colors hover:text-gray-600" onclick="this.closest('.fixed').remove()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                  </button>
                </div>
                
                <!-- Editor de código en dos columnas -->
                <div class="flex flex-1 overflow-hidden">
                  <!-- Columna HTML -->
                  <div class="flex flex-col w-1/2 border-r border-gray-200">
                    <div class="flex items-center justify-between px-4 py-2 border-b border-orange-200 bg-orange-50">
                      <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-orange-500 rounded-full"></div>
                        <span class="text-sm font-medium text-orange-800">HTML</span>
                      </div>
                      <button class="text-xs text-orange-600 hover:text-orange-800" onclick="copyHtml()">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                      </button>
                    </div>
                    <div class="flex-1 overflow-auto bg-gray-900">
                      <pre class="p-4 font-mono text-sm leading-relaxed text-gray-100"><code id="html-code">${escapeHtml(formatHtml(html))}</code></pre>
                    </div>
                  </div>
                  
                  <!-- Columna CSS -->
                  <div class="flex flex-col w-1/2">
                    <div class="flex items-center justify-between px-4 py-2 border-b border-blue-200 bg-blue-50">
                      <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                        <span class="text-sm font-medium text-blue-800">CSS</span>
                      </div>
                      <button class="text-xs text-blue-600 hover:text-blue-800" onclick="copyCss()">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                      </button>
                    </div>
                    <div class="flex-1 overflow-auto bg-gray-900">
                      <pre class="p-4 font-mono text-sm leading-relaxed text-gray-100"><code id="css-code">${escapeHtml(formatCss(css))}</code></pre>
                    </div>
                  </div>
                </div>
                
                <!-- Barra de herramientas inferior -->
                <div class="flex items-center justify-between p-4 border-t bg-gray-50">
                  <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600">HTML: ${html.length} caracteres</span>
                    <span class="text-sm text-gray-600">CSS: ${css.length} caracteres</span>
                  </div>
                  <div class="flex space-x-2">
                    <button class="px-4 py-2 text-sm text-gray-700 transition-colors bg-white border border-gray-300 rounded hover:bg-gray-50" onclick="this.closest('.fixed').remove()">
                      Cerrar
                    </button>
                    <button class="px-4 py-2 text-sm text-white transition-colors bg-blue-600 rounded hover:bg-blue-700" onclick="copyCode()">
                      <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                      </svg>
                      Copiar Todo
                    </button>
                  </div>
                </div>
              </div>
            `;
            
            // Funciones para copiar código
            window.copyCode = function() {
              const fullCode = `<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página</title>
    <style>
${formatCss(css)}
    </style>
</head>
<body>
${formatHtml(html)}
</body>
</html>`;
              
              navigator.clipboard.writeText(fullCode).then(() => {
                showNotification('Código completo copiado al portapapeles', 'success');
              }).catch(() => {
                showNotification('Error al copiar el código', 'error');
              });
            };
            
            window.copyHtml = function() {
              navigator.clipboard.writeText(formatHtml(html)).then(() => {
                showNotification('HTML copiado al portapapeles', 'success');
              }).catch(() => {
                showNotification('Error al copiar el HTML', 'error');
              });
            };
            
            window.copyCss = function() {
              navigator.clipboard.writeText(formatCss(css)).then(() => {
                showNotification('CSS copiado al portapapeles', 'success');
              }).catch(() => {
                showNotification('Error al copiar el CSS', 'error');
              });
            };
            
            // Función para mostrar notificaciones
            function showNotification(message, type = 'success') {
              const notification = document.createElement('div');
              const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
              notification.className = `fixed top-4 right-4 ${bgColor} text-white px-4 py-2 rounded-lg shadow-lg z-50 transition-all duration-300`;
              notification.textContent = message;
              
              document.body.appendChild(notification);
              
              setTimeout(() => {
                notification.style.opacity = '0';
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => {
                  document.body.removeChild(notification);
                }, 300);
              }, 2000);
            }
            
            document.body.appendChild(modal);
          }
        });
      }
      
      // Inicializar con vista desktop
      setTimeout(() => {
        if (window.editor) {
          // Configurar listener para cambios de dispositivo
          window.editor.on('change:device', () => {
            const currentDevice = window.editor.getDevice();
            console.log('Dispositivo actual:', currentDevice);
            
            // Actualizar botones según el dispositivo actual
            [desktopBtn, tabletBtn, mobileBtn].forEach(btn => {
              if (btn) {
                btn.classList.remove('text-blue-600', 'bg-blue-50');
                btn.classList.add('text-gray-500');
              }
            });
            
            // Activar el botón correspondiente
            let activeBtn = null;
            if (currentDevice === 'Desktop') {
              activeBtn = desktopBtn;
            } else if (currentDevice === 'Tablet') {
              activeBtn = tabletBtn;
            } else if (currentDevice === 'Mobile') {
              activeBtn = mobileBtn;
            }
            
            if (activeBtn) {
              activeBtn.classList.remove('text-gray-500');
              activeBtn.classList.add('text-blue-600', 'bg-blue-50');
            }
          });
          
          // Inicializar con vista desktop
          switchDevice('desktop');
        }
      }, 1000);

    });
    </script>

</body>
</html>
