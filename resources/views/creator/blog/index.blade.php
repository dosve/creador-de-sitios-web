@extends('layouts.creator')

@section('title', 'Blog - ' . $website->name)
@section('page-title', 'Blog')
@section('content')
            <!-- Blog Header -->
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-medium text-gray-900">Blog de {{ $website->name }}</h2>
                            <p class="text-sm text-gray-600 mt-1">Gestiona los artículos de tu blog</p>
                        </div>
                        <a href="{{ route('creator.blog.create', $website) }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-sm">
                            Nuevo Artículo
                        </a>
                    </div>
                </div>
            </div>

            <!-- Blog Posts Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($blogPosts as $post)
                <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-shadow duration-200">
                    <!-- Post Header -->
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 mb-1 line-clamp-2">{{ $post->title }}</h3>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $post->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $post->is_published ? 'Publicado' : 'Borrador' }}
                            </span>
                        </div>
                    </div>

                    <!-- Post Excerpt -->
                    @if($post->excerpt)
                    <p class="text-sm text-gray-600 mb-4 line-clamp-3">{{ $post->excerpt }}</p>
                    @endif

                    <!-- Post Info -->
                    <div class="text-sm text-gray-500 mb-4">
                        @if($post->category)
                            <p><strong>Categoría:</strong> {{ $post->category->name }}</p>
                        @endif
                        <p><strong>Actualizado:</strong> {{ $post->updated_at->format('d/m/Y H:i') }}</p>
                        @if($post->tags->count() > 0)
                            <div class="mt-2">
                                <strong>Etiquetas:</strong>
                                <div class="flex flex-wrap gap-1 mt-1">
                                    @foreach($post->tags->take(3) as $tag)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $tag->name }}
                                        </span>
                                    @endforeach
                                    @if($post->tags->count() > 3)
                                        <span class="text-xs text-gray-500">+{{ $post->tags->count() - 3 }} más</span>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Post Actions -->
                    <div class="flex space-x-2">
                        <a href="{{ route('creator.blog.edit', [$website, $post]) }}" 
                           class="flex-1 bg-blue-600 text-white text-center py-2 px-3 rounded-md hover:bg-blue-700 text-sm">
                            Editar
                        </a>
                        <form method="POST" action="{{ route('creator.blog.destroy', [$website, $post]) }}" class="flex-1" onsubmit="return confirm('¿Estás seguro de eliminar este artículo?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-600 text-white py-2 px-3 rounded-md hover:bg-red-700 text-sm">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Empty State -->
            @if($blogPosts->count() == 0)
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-medium text-gray-900 mb-2">No hay artículos en el blog</h3>
                <p class="text-gray-500 mb-8">Comienza escribiendo tu primer artículo para tu blog.</p>
                <a href="{{ route('creator.blog.create', $website) }}" class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700">
                    Escribir Primer Artículo
                </a>
            </div>
            @endif
@endsection