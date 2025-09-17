@extends('creator.preview.layout')

@section('title', $page->title . ' - ' . $website->name)

@section('content')
<div class="bg-white">
    <!-- Contenido de la Página -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <!-- Título de la Página -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $page->title }}</h1>
            @if($page->excerpt)
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">{{ $page->excerpt }}</p>
            @endif
        </div>

        <!-- Contenido HTML de la Página -->
        @if($page->html_content)
            <div class="page-content">
                {!! $page->html_content !!}
            </div>
        @else
            <div class="text-center py-12">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Contenido no disponible</h3>
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
    console.log('🔧 Configuración de API cargada:', {
        apiKey: window.websiteApiKey ? 'Configurada' : 'No configurada',
        apiUrl: window.websiteApiUrl || 'No configurada'
    });
</script>
@endpush
@endsection
