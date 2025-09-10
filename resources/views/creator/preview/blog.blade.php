@extends('creator.preview.layout')

@section('title', 'Blog - ' . ($website->name ?? 'Mi Sitio Web'))

@section('content')
<div class="bg-white">
    <!-- Header del Blog -->
    <div class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Blog</h1>
                <p class="text-lg text-gray-600">Descubre nuestras últimas noticias y artículos</p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Contenido Principal -->
            <div class="lg:col-span-3">
                @if($blogPosts->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @foreach($blogPosts as $post)
                            <article class="bg-white rounded-lg shadow-md overflow-hidden">
                                @if($post->featured_image)
                                    <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                                @else
                                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                
                                <div class="p-6">
                                    <div class="flex items-center text-sm text-gray-500 mb-2">
                                        <time datetime="{{ $post->published_at }}">{{ $post->published_at->format('d M Y') }}</time>
                                        @if($post->category)
                                            <span class="mx-2">•</span>
                                            <span class="text-blue-600">{{ $post->category->name }}</span>
                                        @endif
                                    </div>
                                    
                                    <h2 class="text-xl font-semibold text-gray-900 mb-2">
                                        <a href="{{ route('creator.preview.blog-post', [$website, $post]) }}" class="hover:text-blue-600">
                                            {{ $post->title }}
                                        </a>
                                    </h2>
                                    
                                    <p class="text-gray-600 mb-4">{{ Str::limit($post->excerpt, 150) }}</p>
                                    
                                    <div class="flex items-center justify-between">
                                        <a href="{{ route('creator.preview.blog-post', [$website, $post]) }}" 
                                           class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                                            Leer más
                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                        
                                        @if($post->tags->count() > 0)
                                            <div class="flex flex-wrap gap-1">
                                                @foreach($post->tags->take(2) as $tag)
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                        {{ $tag->name }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <!-- Paginación -->
                    <div class="mt-8">
                        {{ $blogPosts->links() }}
                    </div>
                @else
                    <!-- Estado Vacío -->
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No hay publicaciones</h3>
                        <p class="mt-1 text-sm text-gray-500">Aún no se han publicado artículos en el blog.</p>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="space-y-8">
                    <!-- Categorías -->
                    @if($categories->count() > 0)
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Categorías</h3>
                            <ul class="space-y-2">
                                @foreach($categories as $category)
                                    <li>
                                        <a href="#" class="text-gray-600 hover:text-blue-600 flex items-center justify-between">
                                            <span>{{ $category->name }}</span>
                                            <span class="text-sm text-gray-400">({{ $category->blogPosts()->where('is_published', true)->count() }})</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Posts Recientes -->
                    @if($blogPosts->count() > 0)
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Posts Recientes</h3>
                            <ul class="space-y-4">
                                @foreach($blogPosts->take(5) as $post)
                                    <li>
                                        <a href="{{ route('creator.preview.blog-post', [$website, $post]) }}" class="block hover:bg-gray-50 p-2 rounded">
                                            <h4 class="text-sm font-medium text-gray-900 line-clamp-2">{{ $post->title }}</h4>
                                            <time class="text-xs text-gray-500">{{ $post->published_at->format('d M Y') }}</time>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Newsletter -->
                    <div class="bg-blue-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Newsletter</h3>
                        <p class="text-sm text-gray-600 mb-4">Suscríbete para recibir nuestras últimas noticias.</p>
                        <form class="space-y-3">
                            <input type="email" placeholder="Tu email" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md text-sm font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Suscribirse
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
