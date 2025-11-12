@extends('creator.preview.layout')

@section('title', $page->title . ' - ' . $website->name)

@section('content')
<div class="bg-white">
    <!-- Contenido de la Página -->
    <div class="max-w-4xl px-4 py-16 mx-auto sm:px-6 lg:px-8">
        <!-- Título de la Página -->
        <div class="mb-12 text-center">
            <h1 class="mb-4 text-4xl font-bold text-gray-900">{{ $page->title }}</h1>
            @if($page->excerpt)
                <p class="max-w-3xl mx-auto text-xl text-gray-600">{{ $page->excerpt }}</p>
            @endif
        </div>

        <!-- Contenido HTML de la Página -->
        @if($page->html_content)
            <div class="page-content">
                {!! $page->html_content !!}
            </div>
        @else
            <div class="py-12 text-center">
                <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="mb-2 text-lg font-medium text-gray-900">Contenido no disponible</h3>
                <p class="text-gray-600">Esta página aún no tiene contenido. Edita la página para agregar contenido.</p>
            </div>
        @endif

        <!-- CSS personalizado de la página -->
        @if($page->css_content)
            <style>
                {!! $page->css_content !!}
            </style>
        @endif
    </div>
</div>

@push('scripts')
<script>
    // Configurar variables globales para la API del sitio web
    window.websiteApiKey = '{{ $website->api_key }}';
    window.websiteApiUrl = '{{ $website->api_base_url }}';
    
    // Configurar variables globales para ePayco
    window.epaycoPublicKey = '{{ $website->epayco_public_key }}';
    window.epaycoPrivateKey = '{{ $website->epayco_private_key }}';
    window.epaycoCustomerId = '{{ $website->epayco_customer_id }}';
    
    console.log('🔧 Configuración de API cargada:', {
        apiKey: window.websiteApiKey ? 'Configurada' : 'No configurada',
        apiUrl: window.websiteApiUrl || 'No configurada',
        epaycoPublicKey: window.epaycoPublicKey ? 'Configurada' : 'No configurada',
        epaycoCustomerId: window.epaycoCustomerId ? 'Configurado' : 'No configurado'
    });
</script>

<!-- Componente para cargar productos dinámicamente -->
<x-products-script :apiKey="$website->api_key" :apiBaseUrl="$website->api_base_url" />
@endpush
@endsection
