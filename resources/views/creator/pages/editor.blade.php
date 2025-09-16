<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Editor - {{ $editable->name ?? $editable->title }} - {{ $website->name }}</title>
    @vite('resources/js/app.js')
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
        .gjs-block-cart { background: #fff3e0; border: 2px dashed #ff9800; }

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

        /* Estilos para el carrito */
        .cart-container {
            position: relative;
        }

        #cart-sidebar {
            z-index: 9999;
        }

        #cart-overlay {
            z-index: 9998;
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
                        <a href="{{ route('creator.websites.show', $website) }}" class="text-gray-600 hover:text-gray-900">
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

    });
    </script>
</body>
</html>
