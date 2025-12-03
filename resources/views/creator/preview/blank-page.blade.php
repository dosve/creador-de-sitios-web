<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page->title ?? $website->name ?? 'Vista Previa' }}</title>
    <meta name="description" content="{{ $page->meta_description ?? $website->description ?? '' }}">

    <!-- ⚡ PRIMERO: Configurar variables globales ANTES de cualquier cosa -->
    <script>
        window.websiteApiKey = "{{ $website->api_key ?? '' }}";
        window.websiteApiUrl = "{{ $website->api_base_url ?? '' }}";
        window.epaycoPublicKey = "{{ $website->epayco_public_key ?? '' }}";
        window.epaycoPrivateKey = "{{ $website->epayco_private_key ?? '' }}";
        window.epaycoCustomerId = "{{ $website->epayco_customer_id ?? '' }}";
        console.log('⚡ Variables API configuradas en HEAD:', {
            apiKey: window.websiteApiKey ? 'Sí' : 'No',
            apiUrl: window.websiteApiUrl || 'No'
        });
    </script>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>

    @yield('styles')
</head>

<body class="bg-gray-50">
    <!-- Header de Vista Previa -->
    <div class="px-4 py-2 bg-yellow-100 border-b border-yellow-200">
        <div class="flex items-center justify-between mx-auto max-w-7xl">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                <span class="text-sm font-medium text-yellow-800">Vista Previa de Página</span>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-sm text-yellow-700">{{ $page->title ?? 'Página' }} - {{ $website->name ?? 'Mi Sitio Web' }}</span>
                @if($page)
                <a href="{{ route('creator.pages.editor', $page) }}"
                    class="inline-flex items-center px-3 py-1 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-md hover:bg-blue-700">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Editar Página
                </a>
                @endif
                <a href="{{ route('creator.dashboard') }}"
                    class="inline-flex items-center px-3 py-1 text-sm font-medium text-yellow-700 bg-white border border-yellow-300 rounded-md hover:bg-yellow-50">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Volver al Panel
                </a>
            </div>
        </div>
    </div>

    {{-- Navegación entre páginas --}}
    @include('creator.preview.components.page-navigation', ['currentPage' => $page])

    <!-- ⚡ IMPORTANTE: Configurar variables GLOBALES ANTES del contenido -->
    <script>
        window.websiteApiKey = "{{ $website->api_key ?? '' }}";
        window.websiteApiUrl = "{{ $website->api_base_url ?? '' }}";
        window.epaycoPublicKey = "{{ $website->epayco_public_key ?? '' }}";
        window.epaycoPrivateKey = "{{ $website->epayco_private_key ?? '' }}";
        window.epaycoCustomerId = "{{ $website->epayco_customer_id ?? '' }}";

        console.log('⚡ Variables API configuradas ANTES del contenido de la página:', {
            apiKey: window.websiteApiKey ? ('Configurada (' + window.websiteApiKey.length + ' chars)') : '❌ NO configurada',
            apiUrl: window.websiteApiUrl || '❌ NO configurada'
        });
    </script>

    <!-- Contenido Principal -->
    <main class="min-h-screen">
        @if($page && $page->html_content)
        <div class="page-content">
            {!! $page->html_content !!}
        </div>
        @if($page->css_content)
        <style>
            {
                ! ! $page->css_content ! !
            }
        </style>
        @endif
        @else
        <div class="flex items-center justify-center min-h-screen bg-gray-50">
            <div class="text-center">
                <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="mb-2 text-lg font-medium text-gray-900">{{ $page->title ?? 'Página' }}</h3>
                <p class="text-gray-600">Esta página no tiene contenido aún. Usa el editor visual para crear tu contenido.</p>
            </div>
        </div>
        @endif
    </main>

    @yield('scripts')

    <!-- Scripts Globales -->
    <x-global-scripts :website="$website" />

    <!-- Componente para cargar productos dinámicamente -->
    <x-products-script :apiKey="$website->api_key" :apiBaseUrl="$website->api_base_url" />

    <!-- Script del Carrito de Compras -->
    <x-cart.script :websiteSlug="$website->slug" />

    <!-- Script de Autenticación de Usuario -->
    <x-auth.user-auth-script :website="$website" />

    <!-- Handler de Pagos ePayco -->
    @if($website->epayco_public_key && $website->epayco_private_key)
    <x-payments.epayco.handler
        :publicKey="$website->epayco_public_key"
        :privateKey="$website->epayco_private_key"
        :customerId="$website->epayco_customer_id" />
    @endif
</body>

</html>