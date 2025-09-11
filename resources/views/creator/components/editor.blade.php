<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editor - {{ $component->name }} - {{ $website->name }}</title>
    @vite('resources/js/app.js')
    <link rel="stylesheet" href="https://unpkg.com/grapesjs/dist/css/grapes.min.css">
    <style>
        .gjs-pn-panel {
            background: #f8f9fa;
        }
        .gjs-block {
            width: auto;
            height: auto;
            min-height: auto;
            padding: 10px;
            margin: 5px;
        }
        .gjs-block-section {
            background: #e3f2fd;
            border: 2px dashed #2196f3;
        }
        .gjs-block-text {
            background: #f3e5f5;
            border: 2px dashed #9c27b0;
        }
        .gjs-block-image {
            background: #e8f5e8;
            border: 2px dashed #4caf50;
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
                        <a href="{{ route('creator.components.show', [$website, $component]) }}" class="text-gray-600 hover:text-gray-900">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>
                        <div>
                            <h1 class="text-lg font-medium text-gray-900">{{ $component->name }}</h1>
                            <p class="text-sm text-gray-500">{{ $component->type_label }} - {{ $website->name }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <button id="save-btn" class="px-4 py-2 text-sm text-white bg-blue-600 rounded-md hover:bg-blue-700">
                            Guardar
                        </button>
                        <a href="{{ route('creator.components.show', [$website, $component]) }}" class="px-4 py-2 text-sm text-white bg-gray-600 rounded-md hover:bg-gray-700">
                            Vista Previa
                        </a>
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
                    <nav class="flex px-4 space-x-8" aria-label="Tabs">
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
                <!-- Component Type Info -->
                <div class="px-4 py-2 border-b border-blue-200 bg-blue-50">
                    <div class="flex items-center justify-center">
                        <div class="text-center">
                            <p class="text-sm text-blue-800">
                                Editando {{ $component->type_label }}
                                @if($component->type === 'header')
                                    - Se mostrará en la parte superior de todas las páginas
                                @elseif($component->type === 'footer')
                                    - Se mostrará en la parte inferior de todas las páginas
                                @elseif($component->type === 'menu')
                                    - Navegación reutilizable para múltiples páginas
                                @elseif($component->type === 'block')
                                    - Bloque de contenido que se puede insertar donde necesites
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Canvas -->
                <div class="flex-1">
                    <div id="gjs" style="height: 100%;"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/grapesjs"></script>
    <script>
        const editor = grapesjs.init({
            container: '#gjs',
            height: '100%',
            width: '100%',
            storageManager: false,
            plugins: [],
            pluginsOpts: {},
            showOffsets: true,
            noticeOnUnload: true,
            canvas: {
                styles: [
                    'https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css'
                ]
            },
            blockManager: {
                appendTo: '#gjs-blocks',
                blocks: [
                    // Bloques específicos para componentes
                    {
                        id: 'text',
                        label: 'Texto',
                        content: '<div data-gjs-type="text" class="p-4">Haz clic para editar este texto</div>',
                    },
                    {
                        id: 'heading',
                        label: 'Título',
                        content: '<h2 class="text-2xl font-bold text-gray-900">Título Principal</h2>',
                    },
                    {
                        id: 'paragraph',
                        label: 'Párrafo',
                        content: '<p class="leading-relaxed text-gray-700">Este es un párrafo de ejemplo.</p>',
                    },
                    {
                        id: 'image',
                        label: 'Imagen',
                        select: true,
                        content: { type: 'image' },
                        activate: true,
                    },
                    {
                        id: 'button',
                        label: 'Botón',
                        content: '<button class="px-6 py-2 text-white transition-colors bg-blue-600 rounded-md hover:bg-blue-700">Botón</button>',
                    },
                    {
                        id: 'link',
                        label: 'Enlace',
                        content: '<a href="#" class="text-blue-600 underline hover:text-blue-800">Enlace de ejemplo</a>',
                    },
                    {
                        id: 'divider',
                        label: 'Divisor',
                        content: '<hr class="my-8 border-gray-300">',
                    },
                    {
                        id: 'container',
                        label: 'Contenedor',
                        content: '<div class="container px-4 mx-auto"></div>',
                    },
                    {
                        id: 'flex-row',
                        label: 'Fila Flex',
                        content: '<div class="flex space-x-4"></div>',
                    },
                    {
                        id: 'grid',
                        label: 'Grid',
                        content: '<div class="grid grid-cols-2 gap-4"></div>',
                    }
                ]
            },
            layerManager: {
                appendTo: '.layers-container'
            },
            traitManager: {
                appendTo: '.traits-container',
            },
            selectorManager: {
                appendTo: '.styles-container'
            },
        });

        // Cargar contenido existente del componente
        @if($component->html_content)
            editor.setComponents('{!! addslashes($component->html_content) !!}');
        @endif

        @if($component->css_content)
            editor.setStyle('{!! addslashes($component->css_content) !!}');
        @endif

        // Funcionalidad de paneles laterales
        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', function() {
                const panel = this.dataset.panel;
                
                // Actualizar tabs activos
                document.querySelectorAll('.tab-button').forEach(btn => {
                    btn.classList.remove('active', 'border-blue-500', 'text-blue-600');
                    btn.classList.add('border-transparent', 'text-gray-500');
                });
                
                this.classList.add('active', 'border-blue-500', 'text-blue-600');
                this.classList.remove('border-transparent', 'text-gray-500');
                
                // Mostrar panel correspondiente
                document.querySelectorAll('.panel-content').forEach(panel => {
                    panel.classList.add('hidden');
                });
                
                document.getElementById(panel + '-panel').classList.remove('hidden');
            });
        });

        // Funciones de utilidad
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg text-white z-50 ${
                type === 'success' ? 'bg-green-500' : 'bg-red-500'
            }`;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        // Guardar componente
        document.getElementById('save-btn').addEventListener('click', function() {
            const htmlContent = editor.getHtml();
            const cssContent = editor.getCss();
            const grapesjsData = JSON.stringify(editor.getProjectData());

            fetch('{{ route("creator.components.save", [$website, $component]) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    html_content: htmlContent,
                    css_content: cssContent,
                    grapesjs_data: grapesjsData
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Componente guardado exitosamente');
                } else {
                    showNotification('Error al guardar el componente', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error al guardar el componente', 'error');
            });
        });

        // Atajos de teclado
        document.addEventListener('keydown', function(e) {
            // Ctrl+S para guardar
            if (e.ctrlKey && e.key === 's') {
                e.preventDefault();
                document.getElementById('save-btn').click();
            }
            
            // Ctrl+Z para deshacer
            if (e.ctrlKey && e.key === 'z' && !e.shiftKey) {
                e.preventDefault();
                editor.UndoManager.undo();
            }
            
            // Ctrl+Shift+Z para rehacer
            if (e.ctrlKey && e.shiftKey && e.key === 'Z') {
                e.preventDefault();
                editor.UndoManager.redo();
            }
        });

        console.log('Editor de componentes inicializado correctamente');
    </script>
</body>
</html>
