@extends('layouts.admin')

@section('title', 'Editor de Página')
@section('page-title', 'Editor: ' . $page->title)

@section('content')
<div class="h-screen flex flex-col">
    <!-- Header del Editor -->
    <div class="bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.websites.show', $website) }}" 
               class="text-gray-600 hover:text-gray-900">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-lg font-semibold text-gray-900">{{ $page->title }}</h1>
                <p class="text-sm text-gray-500">{{ $website->name }} - {{ $page->slug }}</p>
            </div>
        </div>
        
        <div class="flex items-center space-x-3">
            <!-- Botón de Guardar -->
            <button id="save-page" 
                    class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
                <span>Guardar</span>
            </button>
            
            <!-- Botón de Vista Previa -->
            <button id="preview-page" 
                    class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                <span>Vista Previa</span>
            </button>
        </div>
    </div>

    <!-- Editor GrapesJS -->
    <div class="flex-1" style="height: calc(100vh - 80px);">
        <div id="gjs" style="height: 100%;"></div>
    </div>
</div>

<!-- Scripts -->
<script src="https://unpkg.com/grapesjs@0.21.7/dist/grapes.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/grapesjs@0.21.7/dist/css/grapes.min.css">

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Configuración simplificada de GrapesJS
    const editor = grapesjs.init({
        container: '#gjs',
        height: '100%',
        width: '100%',
        storageManager: false,
        undoManager: true,
        deviceManager: {
            devices: [
                {
                    name: 'Desktop',
                    width: '',
                },
                {
                    name: 'Tablet',
                    width: '768px',
                    widthMedia: '992px',
                },
                {
                    name: 'Mobile',
                    width: '320px',
                    widthMedia: '768px',
                }
            ]
        },
        blockManager: {
            blocks: [
                {
                    id: 'section',
                    label: '<b>Sección</b>',
                    attributes: { class: 'gjs-block-section' },
                    content: `<section>
                        <h1>Inserte su título aquí</h1>
                        <p>Inserte su texto aquí</p>
                    </section>`,
                },
                {
                    id: 'text',
                    label: 'Texto',
                    content: '<div data-gjs-type="text">Inserte su texto aquí</div>',
                },
                {
                    id: 'image',
                    label: 'Imagen',
                    select: true,
                    content: { type: 'image' },
                    activate: true,
                },
                {
                    id: 'video',
                    label: 'Video',
                    content: {
                        type: 'video',
                        src: 'img/video2.webm',
                        style: {
                            height: '350px',
                            width: '615px',
                        }
                    },
                },
                {
                    id: 'map',
                    label: 'Mapa',
                    content: {
                        type: 'map',
                        style: { height: '350px' }
                    },
                }
            ]
        }
    });

    // Debug: Verificar que el editor se cargó
    console.log('GrapesJS Editor cargado:', editor);
    
    // Cargar contenido existente
    const existingContent = `{!! addslashes($page->html_content) !!}`;
    const existingCSS = `{!! addslashes($page->css_content ?? '') !!}`;
    const existingData = {!! json_encode($page->grapesjs_data) !!};

    console.log('Contenido existente:', existingContent);
    console.log('CSS existente:', existingCSS);
    console.log('Datos GrapesJS:', existingData);

    if (existingData && existingData.components) {
        editor.loadProjectData(existingData);
    } else if (existingContent) {
        editor.setComponents(existingContent);
        if (existingCSS) {
            editor.setStyle(existingCSS);
        }
    } else {
        // Contenido por defecto si no hay nada
        editor.setComponents('<h1>Nueva Página</h1><p>Comienza editando esta página...</p>');
    }

    // Función de guardado
    document.getElementById('save-page').addEventListener('click', function() {
        const html = editor.getHtml();
        const css = editor.getCss();
        const data = JSON.stringify(editor.getProjectData());

        // Mostrar indicador de guardado
        const saveBtn = document.getElementById('save-page');
        const originalText = saveBtn.innerHTML;
        saveBtn.innerHTML = '<svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg><span>Guardando...</span>';

        // Enviar datos al servidor
        fetch('{{ route("admin.pages.save-editor", [$website, $page]) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                html_content: html,
                css_content: css,
                grapesjs_data: data
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Mostrar mensaje de éxito
                saveBtn.innerHTML = '<svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg><span>Guardado</span>';
                setTimeout(() => {
                    saveBtn.innerHTML = originalText;
                }, 2000);
            } else {
                throw new Error('Error al guardar');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            saveBtn.innerHTML = '<svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg><span>Error</span>';
            setTimeout(() => {
                saveBtn.innerHTML = originalText;
            }, 2000);
        });
    });

    // Función de vista previa
    document.getElementById('preview-page').addEventListener('click', function() {
        const html = editor.getHtml();
        const css = editor.getCss();
        
        // Crear ventana de vista previa
        const previewWindow = window.open('', '_blank', 'width=1200,height=800');
        previewWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>Vista Previa - {{ $page->title }}</title>
                <style>${css}</style>
            </head>
            <body>
                ${html}
            </body>
            </html>
        `);
        previewWindow.document.close();
    });

    // Atajos de teclado
    document.addEventListener('keydown', function(e) {
        // Ctrl+S para guardar
        if (e.ctrlKey && e.key === 's') {
            e.preventDefault();
            document.getElementById('save-page').click();
        }
    });
});
</script>

<!-- Estilos personalizados -->
<style>
.gjs-pn-panel {
    position: relative;
}

.panel__top {
    padding: 0;
    width: 100%;
    display: flex;
    position: initial;
    justify-content: center;
    justify-content: space-between;
}

.panel__basic-actions {
    position: initial;
}

.editor-row {
    display: flex;
    justify-content: flex-start;
    align-items: stretch;
    flex-wrap: nowrap;
    height: 300px;
}

.editor-canvas {
    flex-grow: 1;
}

.panel__right {
    flex-basis: 300px;
    position: relative;
    overflow-y: auto;
}

.panel__switcher {
    position: initial;
}

.panel__devices {
    position: initial;
}

.gjs-cv-canvas {
    top: 0;
    width: 100%;
    height: 100%;
}

.gjs-block {
    width: auto;
    height: auto;
    min-height: auto;
    padding: 10px;
}

.gjs-block-section {
    padding: 20px;
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
}

.gjs-block-text {
    padding: 10px;
    background-color: #ffffff;
    border: 1px solid #dee2e6;
}

.gjs-block-image {
    padding: 10px;
    background-color: #ffffff;
    border: 1px solid #dee2e6;
}

.gjs-block-video {
    padding: 10px;
    background-color: #ffffff;
    border: 1px solid #dee2e6;
}

.gjs-block-map {
    padding: 10px;
    background-color: #ffffff;
    border: 1px solid #dee2e6;
}
</style>
@endsection
