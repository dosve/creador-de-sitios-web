<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    @php
        // Usar la página de inicio o la página específica si se proporciona
        $currentPage = $page ?? $homePage;
    @endphp
    
    <title>{{ $currentPage->meta_title ?? $currentPage->title ?? $website->name }}</title>
    
    @if($currentPage->meta_description)
        <meta name="description" content="{{ $currentPage->meta_description }}">
    @endif
    
    @if($currentPage->meta_keywords)
        <meta name="keywords" content="{{ $currentPage->meta_keywords }}">
    @endif
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Favicon -->
    @if($website->favicon)
        <link rel="icon" type="image/x-icon" href="{{ Storage::url($website->favicon) }}">
    @endif
    
    <!-- Estilos CSS de la página -->
    @if($currentPage->css_content)
        <!-- CSS de la página ({{ strlen($currentPage->css_content) }} caracteres) -->
        <!-- Tiene !important: {{ str_contains($currentPage->css_content, '!important') ? 'SÍ' : 'NO' }} -->
        <!-- Tiene background-color: {{ str_contains($currentPage->css_content, 'background-color') ? 'SÍ' : 'NO' }} -->
        <style>
            {!! $currentPage->css_content !!}
        </style>
    @else
        <!-- ⚠️ NO HAY CSS GUARDADO PARA ESTA PÁGINA -->
    @endif
    
    <!-- Estilos CSS globales del sitio web -->
    @if($website->global_css)
        <style>
            {!! $website->global_css !!}
        </style>
    @endif
    
    <!-- Google Fonts comunes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-white">
    <!-- Contenido HTML de la página -->
    @if($currentPage->html_content)
        <div id="page-content">
            {!! $currentPage->html_content !!}
        </div>
    @else
        <!-- Mensaje si no hay contenido -->
        <div class="flex items-center justify-center min-h-screen bg-gray-50">
            <div class="text-center p-8">
                <svg class="w-24 h-24 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $currentPage->title }}</h1>
                <p class="text-gray-600">Esta página aún no tiene contenido. Edítala desde el panel de creación.</p>
                @auth
                    @if(auth()->user()->id === $website->user_id || auth()->user()->role === 'admin')
                        <a href="{{ route('creator.pages.editor', [$website->id, $currentPage->id]) }}" class="inline-block mt-4 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            Editar Página
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    @endif
    
    <!-- JavaScript global del sitio web -->
    @if($website->global_js)
        <script>
            {!! $website->global_js !!}
        </script>
    @endif
    
    <!-- JavaScript adicional de la página -->
    @if($currentPage->js_content ?? false)
        <script>
            {!! $currentPage->js_content !!}
        </script>
    @endif
    
    <!-- Alpine.js para interactividad -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>

