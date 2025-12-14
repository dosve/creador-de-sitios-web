<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
    // Usar la página de inicio o la página específica si se proporciona
    $currentPage = $page ?? $homePage;
    // Variable para evitar cargar el script de blog múltiples veces
    $blogScriptIncluded = false;
    @endphp

    <title>{{ $currentPage->meta_title ?? $currentPage->title ?? $website->name }}</title>

    @if($currentPage->meta_description)
    <meta name="description" content="{{ $currentPage->meta_description }}">
    @endif

    @if($currentPage->meta_keywords)
    <meta name="keywords" content="{{ $currentPage->meta_keywords }}">
    @endif

    <!-- ⚡ IMPORTANTE: Variables globales PRIMERO -->
    <script>
        window.websiteApiKey = "{{ $website->api_key ?? '' }}";
        window.websiteApiUrl = "{{ $website->api_base_url ?? '' }}";
        window.websiteSlug = "{{ $website->slug ?? '' }}";
        window.websiteId = {{ $website->id ?? 0 }};
        window.epaycoPublicKey = "{{ $website->epayco_public_key ?? '' }}";
        window.epaycoPrivateKey = "{{ $website->epayco_private_key ?? '' }}";
        window.epaycoCustomerId = "{{ $website->epayco_customer_id ?? '' }}";
        console.log('⚡ Variables API configuradas:', {
            apiKey: window.websiteApiKey ? ('Configurada - ' + window.websiteApiKey.length + ' chars') : 'NO',
            apiUrl: window.websiteApiUrl || 'NO',
            websiteSlug: window.websiteSlug || 'NO',
            websiteId: window.websiteId || 'NO'
        });
    </script>

    <!-- Tailwind CSS -->
    @php
        $isProduction = app()->environment('production');
        $hasCompiledCss = file_exists(public_path('build/assets/app.css'));
    @endphp
    @if($isProduction && $hasCompiledCss)
        <link href="{{ asset('build/assets/app.css') }}" rel="stylesheet">
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            // Suprimir advertencia de producción en desarrollo
            (function() {
                if (typeof tailwind !== 'undefined' && tailwind.config) {
                    try {
                        // Intentar suprimir la advertencia
                        const originalWarn = console.warn;
                        console.warn = function(...args) {
                            if (args[0] && typeof args[0] === 'string' && args[0].includes('cdn.tailwindcss.com should not be used in production')) {
                                return; // Suprimir esta advertencia específica
                            }
                            originalWarn.apply(console, args);
                        };
                    } catch(e) {
                        // Ignorar errores al suprimir advertencias
                    }
                }
            })();
        </script>
    @endif

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
        {
            ! ! $currentPage->css_content ! !
        }
    </style>
    @else
    <!-- ⚠️ NO HAY CSS GUARDADO PARA ESTA PÁGINA -->
    @endif

    <!-- Estilos CSS globales del sitio web -->
    @if($website->global_css)
    <style>
        {
            ! ! $website->global_css ! !
        }
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
        {
            !!$website - > global_js!!
        }
    </script>
    @endif

    <!-- JavaScript adicional de la página -->
    @if($currentPage->js_content ?? false)
    <script>
        {
            !!$currentPage - > js_content!!
        }
    </script>
    @endif

    <!-- Scripts Globales -->
    @php
        $currentPage = $page ?? $homePage;
        $isHomePage = $currentPage && $currentPage->is_home;
        $isStorePage = $currentPage && $currentPage->enable_store && !$currentPage->is_home;
        
        // Verificar si el contenido tiene un bloque de blog
        $hasBlogBlock = false;
        if ($currentPage && $currentPage->html_content) {
            $hasBlogBlock = strpos($currentPage->html_content, 'id="blog-posts-container"') !== false
                || strpos($currentPage->html_content, 'data-dynamic-blog="true"') !== false;
        }
        
        // Verificar si el contenido tiene un bloque de productos
        $hasProductsBlock = false;
        if ($currentPage && $currentPage->html_content) {
            $hasProductsBlock = strpos($currentPage->html_content, 'id="products-container"') !== false
                || strpos($currentPage->html_content, 'data-dynamic-products="true"') !== false
                || strpos($currentPage->html_content, 'data-products-source="api"') !== false;
        }
    @endphp
    
    @if($isStorePage)
        {{-- Página de Tienda: Usar componentes completos de Laravel --}}
        <x-global-scripts :website="$website" />
    @elseif(!$isHomePage)
        {{-- Otras páginas: Solo carrito y auth --}}
        <script type="text/javascript" src="https://checkout.epayco.co/checkout.js"></script>
        <x-cart.script :websiteSlug="$website->slug" />
        <x-auth.user-auth-script :website="$website" />
        
        {{-- Script de productos si tiene bloque de productos --}}
        @if($hasProductsBlock)
            <x-products-script :apiKey="$website->api_key" :apiBaseUrl="$website->api_base_url" />
        @endif
        
        {{-- Script de blog si tiene bloque de blog (solo si no se cargó antes) --}}
        @if($hasBlogBlock && !isset($blogScriptIncluded))
            @php $blogScriptIncluded = true; @endphp
            @include('components.blog-script', ['websiteId' => $website->id])
        @endif
    @else
        {{-- Página de inicio: Solo carrito y auth (productos se cargan con script inline) --}}
        <script type="text/javascript" src="https://checkout.epayco.co/checkout.js"></script>
        <x-cart.script :websiteSlug="$website->slug" />
        <x-auth.user-auth-script :website="$website" />
        
        {{-- Script de productos si tiene bloque de productos --}}
        @if($hasProductsBlock)
            <x-products-script :apiKey="$website->api_key" :apiBaseUrl="$website->api_base_url" />
        @endif
        
        {{-- Script de blog si tiene bloque de blog (solo si no se cargó antes) --}}
        @if($hasBlogBlock && !isset($blogScriptIncluded))
            @php $blogScriptIncluded = true; @endphp
            @include('components.blog-script', ['websiteId' => $website->id])
        @endif
        
        @if($website->epayco_public_key && $website->epayco_private_key)
            <x-payments.epayco.handler 
                :publicKey="$website->epayco_public_key"
                :privateKey="$website->epayco_private_key"
                :customerId="$website->epayco_customer_id"
            />
        @endif
    @endif

    <!-- Alpine.js para interactividad -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    {{-- Script para eliminar placeholders eliminado: Ya no es necesario porque los placeholders solo aparecen en páginas nuevas sin contenido --}}
</body>

</html>