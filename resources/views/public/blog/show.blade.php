@extends('layouts.public')

@section('title', $blogPost->title . ' - ' . $website->name)

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header del post -->
    <div class="bg-white shadow-sm">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="text-center">
                @if($blogPost->category)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 mb-4">
                        {{ $blogPost->category->name }}
                    </span>
                @endif
                
                <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $blogPost->title }}</h1>
                
                <div class="flex items-center justify-center text-sm text-gray-500 mb-6">
                    <span>{{ $blogPost->created_at->format('d M, Y') }}</span>
                    <span class="mx-2">•</span>
                    <span>{{ ceil(str_word_count(strip_tags($blogPost->content)) / 200) }} min lectura</span>
                </div>
                
                @if($blogPost->tags->count() > 0)
                    <div class="flex flex-wrap justify-center gap-2">
                        @foreach($blogPost->tags as $tag)
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                {{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Contenido del post -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="p-8">
                <!-- Excerpt si existe -->
                @if($blogPost->excerpt)
                    <div class="text-xl text-gray-600 mb-8 font-medium">
                        {{ $blogPost->excerpt }}
                    </div>
                @endif
                
                <!-- Contenido del post -->
                <div class="prose prose-lg max-w-none">
                    {!! $blogPost->content !!}
                </div>
                
                <!-- Tags al final -->
                @if($blogPost->tags->count() > 0)
                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <h4 class="text-sm font-medium text-gray-900 mb-3">Etiquetas:</h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach($blogPost->tags as $tag)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    {{ $tag->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Posts relacionados -->
        @if($relatedPosts->count() > 0)
            <div class="mt-12">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Artículos relacionados</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedPosts as $relatedPost)
                        <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                            <div class="w-full h-32 bg-gradient-to-br from-blue-100 to-purple-100 flex items-center justify-center">
                                @if($relatedPost->category)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $relatedPost->category->name }}
                                    </span>
                                @endif
                            </div>
                            <div class="p-4">
                                <div class="text-sm text-gray-500 mb-2">
                                    {{ $relatedPost->created_at->format('d M, Y') }}
                                </div>
                                <h4 class="text-lg font-bold text-gray-900 mb-2 hover:text-blue-600">
                                    <a href="{{ route('website.blog.show', ['website' => $website->slug, 'blogPost' => $relatedPost->slug]) }}">
                                        {{ $relatedPost->title }}
                                    </a>
                                </h4>
                                <p class="text-gray-600 text-sm">
                                    {{ Str::limit(strip_tags($relatedPost->content), 100) }}
                                </p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        @endif
        
        <!-- Navegación -->
        <div class="mt-12 flex justify-between">
            <a href="{{ route('website.blog.index', $website->slug) }}" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                ← Volver al blog
            </a>
            
            <a href="{{ route('website.show', $website->slug) }}" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                Ir al inicio
            </a>
        </div>
    </div>
</div>
@endsection
