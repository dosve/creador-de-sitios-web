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
            <button id="save-page" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                Guardar
            </button>
            <button id="preview-page" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">
                Vista Previa
            </button>
        </div>
    </div>

    <!-- Editor GrapesJS -->
    <div style="height: calc(100vh - 80px);">
        <div id="gjs" style="height: 100%;"></div>
    </div>
</div>

<!-- Scripts -->
<script src="https://unpkg.com/grapesjs@0.21.7/dist/grapes.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/grapesjs@0.21.7/dist/css/grapes.min.css">

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Iniciando GrapesJS...');
    
    try {
        const editor = grapesjs.init({
            container: '#gjs',
            height: '100%',
            width: '100%',
            storageManager: false,
            undoManager: true,
            deviceManager: {
                devices: [
                    { name: 'Desktop', width: '' },
                    { name: 'Tablet', width: '768px', widthMedia: '992px' },
                    { name: 'Mobile', width: '320px', widthMedia: '768px' }
                ]
            },
            blockManager: {
                blocks: [
                    {
                        id: 'section',
                        label: 'Sección',
                        content: '<section><h1>Título</h1><p>Contenido</p></section>'
                    },
                    {
                        id: 'text',
                        label: 'Texto',
                        content: '<div>Texto aquí</div>'
                    },
                    {
                        id: 'image',
                        label: 'Imagen',
                        content: { type: 'image' }
                    }
                ]
            }
        });

        console.log('GrapesJS Editor inicializado:', editor);
        
        // Cargar contenido
        var existingContent = @json($page->html_content);
        var existingCSS = @json($page->css_content ?? '');
        var existingData = @json($page->grapesjs_data);

        if (existingData && existingData.components) {
            editor.loadProjectData(existingData);
        } else if (existingContent) {
            editor.setComponents(existingContent);
            if (existingCSS) {
                editor.setStyle(existingCSS);
            }
        } else {
            editor.setComponents('<h1>Nueva Página</h1><p>Comienza editando...</p>');
        }

        // Guardar
        document.getElementById('save-page').addEventListener('click', function() {
            var html = editor.getHtml();
            var css = editor.getCss();
            var data = JSON.stringify(editor.getProjectData());

            var saveBtn = document.getElementById('save-page');
            saveBtn.innerHTML = 'Guardando...';

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
                saveBtn.innerHTML = 'Guardado ✓';
                setTimeout(() => {
                    saveBtn.innerHTML = 'Guardar';
                }, 2000);
            })
            .catch(error => {
                console.error('Error:', error);
                saveBtn.innerHTML = 'Error';
                setTimeout(() => {
                    saveBtn.innerHTML = 'Guardar';
                }, 2000);
            });
        });

        // Vista previa
        document.getElementById('preview-page').addEventListener('click', function() {
            var html = editor.getHtml();
            var css = editor.getCss();
            
            var previewWindow = window.open('', '_blank', 'width=1200,height=800');
            previewWindow.document.write('<!DOCTYPE html><html><head><title>Vista Previa</title><style>' + css + '</style></head><body>' + html + '</body></html>');
            previewWindow.document.close();
        });

    } catch (error) {
        console.error('Error al inicializar GrapesJS:', error);
        document.getElementById('gjs').innerHTML = '<div style="padding: 20px; text-align: center; color: red;">Error: ' + error.message + '</div>';
    }
});
</script>
@endsection
