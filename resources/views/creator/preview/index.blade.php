@extends('creator.preview.layout')

@section('title', $website->name ?? 'Inicio')

@section('content')
<div class="bg-white">
    @if($homePage && $homePage->html_content)
        <!-- Contenido de la Página de Inicio -->
        <div class="home-page-content">
            {!! $homePage->html_content !!}
        </div>
        @if($homePage->css_content)
            <style>
                {!! $homePage->css_content !!}
            </style>
        @endif
    @else
        <!-- Hero Section (Solo si no hay contenido personalizado) -->
        <div class="relative bg-gradient-to-r from-blue-600 to-purple-600">
            <div class="px-4 py-24 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="mb-6 text-4xl font-bold text-white md:text-6xl">
                        {{ $website->name ?? 'Bienvenido a Mi Sitio Web' }}
                    </h1>
                    <p class="max-w-3xl mx-auto mb-8 text-xl text-blue-100">
                        {{ $website->description ?? 'Esta es la descripción de tu sitio web. Aquí puedes explicar qué hace tu empresa o proyecto.' }}
                    </p>
                    <div class="flex flex-col justify-center gap-4 sm:flex-row">
                        <a href="{{ route('creator.preview.contact', $website) }}" 
                           class="inline-flex items-center px-8 py-3 text-base font-medium text-blue-600 bg-white border border-transparent rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white">
                            Contáctanos
                        </a>
                        <a href="{{ route('creator.preview.blog', $website) }}" 
                           class="inline-flex items-center px-8 py-3 text-base font-medium text-white border border-white rounded-md hover:bg-white hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white">
                            Ver Blog
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(!$homePage || !$homePage->html_content)
        <!-- Sección de Servicios/Características (Solo si no hay contenido personalizado) -->
    <div class="py-16 bg-gray-50">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mb-12 text-center">
                <h2 class="mb-4 text-3xl font-bold text-gray-900">Nuestros Servicios</h2>
                <p class="text-lg text-gray-600">Descubre lo que podemos hacer por ti</p>
            </div>
            
            <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                <div class="p-6 text-center bg-white rounded-lg shadow-md">
                    <div class="flex items-center justify-center w-12 h-12 mx-auto mb-4 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="mb-2 text-xl font-semibold text-gray-900">Rápido</h3>
                    <p class="text-gray-600">Ofrecemos servicios rápidos y eficientes para satisfacer tus necesidades.</p>
                </div>
                
                <div class="p-6 text-center bg-white rounded-lg shadow-md">
                    <div class="flex items-center justify-center w-12 h-12 mx-auto mb-4 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="mb-2 text-xl font-semibold text-gray-900">Confiable</h3>
                    <p class="text-gray-600">Nuestro equipo está comprometido con la calidad y la confiabilidad.</p>
                </div>
                
                <div class="p-6 text-center bg-white rounded-lg shadow-md">
                    <div class="flex items-center justify-center w-12 h-12 mx-auto mb-4 bg-purple-100 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="mb-2 text-xl font-semibold text-gray-900">Personalizado</h3>
                    <p class="text-gray-600">Adaptamos nuestros servicios a las necesidades específicas de cada cliente.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Últimos Posts del Blog -->
    @if($blogPosts->count() > 0)
        <div class="py-16">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="mb-12 text-center">
                    <h2 class="mb-4 text-3xl font-bold text-gray-900">Últimas Noticias</h2>
                    <p class="text-lg text-gray-600">Mantente al día con nuestras últimas publicaciones</p>
                </div>
                
                <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($blogPosts as $post)
                        <article class="overflow-hidden bg-white rounded-lg shadow-md">
                            @if($post->featured_image)
                                <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="object-cover w-full h-48">
                            @else
                                <div class="flex items-center justify-center w-full h-48 bg-gray-200">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            
                            <div class="p-6">
                                <div class="flex items-center mb-2 text-sm text-gray-500">
                                    <time datetime="{{ $post->published_at }}">{{ $post->published_at->format('d M Y') }}</time>
                                    @if($post->category)
                                        <span class="mx-2">•</span>
                                        <span class="text-blue-600">{{ $post->category->name }}</span>
                                    @endif
                                </div>
                                
                                <h3 class="mb-2 text-xl font-semibold text-gray-900">
                                    <a href="{{ route('creator.preview.blog-post', [$website, $post]) }}" class="hover:text-blue-600">
                                        {{ $post->title }}
                                    </a>
                                </h3>
                                
                                <p class="mb-4 text-gray-600">{{ Str::limit($post->excerpt, 120) }}</p>
                                
                                <a href="{{ route('creator.preview.blog-post', [$website, $post]) }}" 
                                   class="inline-flex items-center font-medium text-blue-600 hover:text-blue-800">
                                    Leer más
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
                
                <div class="mt-8 text-center">
                    <a href="{{ route('creator.preview.blog', $website) }}" 
                       class="inline-flex items-center px-6 py-3 text-base font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Ver Todas las Publicaciones
                    </a>
                </div>
            </div>
        </div>
    @endif
    @endif
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
