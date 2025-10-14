@extends('layouts.public')

@section('title', 'Blog - ' . $website->name)

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header del blog -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Blog</h1>
                <p class="text-xl text-gray-600">Descubre nuestras últimas publicaciones y tendencias</p>
            </div>
        </div>
    </div>

    <!-- Contenido principal -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if($blogPosts->count() > 0)
            <!-- Grid de posts -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                @foreach($blogPosts as $post)
                    <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                        <div class="w-full h-48 bg-gradient-to-br from-blue-100 to-purple-100 flex items-center justify-center">
                            @if($post->category)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $post->category->name }}
                                </span>
                            @endif
                        </div>
                        <div class="p-6">
                            <div class="flex items-center text-sm text-gray-500 mb-2">
                                <span>{{ $post->created_at->format('d M, Y') }}</span>
                                <span class="mx-2">•</span>
                                <span>{{ ceil(str_word_count(strip_tags($post->content)) / 200) }} min lectura</span>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2 hover:text-blue-600">
                                <a href="{{ route('website.blog.show', ['website' => $website->slug, 'blogPost' => $post->slug]) }}">
                                    {{ $post->title }}
                                </a>
                            </h3>
                            <p class="text-gray-600 mb-4">
                                {{ $post->excerpt ?: Str::limit(strip_tags($post->content), 150) }}
                            </p>
                            
                            @if($post->tags->count() > 0)
                                <div class="flex flex-wrap gap-1 mb-4">
                                    @foreach($post->tags->take(3) as $tag)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ $tag->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                            
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-6 h-6 bg-gray-300 rounded-full mr-2"></div>
                                    <span class="text-sm text-gray-600">Autor</span>
                                </div>
                                <a href="{{ route('website.blog.show', ['website' => $website->slug, 'blogPost' => $post->slug]) }}" 
                                   class="text-blue-600 hover:text-blue-800 text-sm">
                                    Leer más →
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Paginación -->
            @if($blogPosts->hasPages())
                <div class="flex justify-center">
                    {{ $blogPosts->links() }}
                </div>
            @endif
        @else
            <!-- Estado vacío -->
            <div class="text-center py-12">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-medium text-gray-900 mb-2">No hay artículos publicados</h3>
                <p class="text-gray-500">Pronto tendremos contenido interesante para compartir contigo.</p>
            </div>
        @endif
    </div>
</div>
@endsection
