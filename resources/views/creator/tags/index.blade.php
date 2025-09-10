@extends('layouts.creator')

@section('title', 'Etiquetas - ' . $website->name)
@section('page-title', 'Etiquetas')
@section('content')
            <!-- Tags Header -->
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-medium text-gray-900">Etiquetas de {{ $website->name }}</h2>
                            <p class="text-sm text-gray-600 mt-1">Gestiona las etiquetas para tu blog</p>
                    </div>
                        <a href="{{ route('creator.tags.create', $website) }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-sm">
                            Nueva Etiqueta
                        </a>
                    </div>
                </div>
            </div>

            <!-- Tags Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($tags as $tag)
                <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-shadow duration-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $tag->name }}</h3>
                    @if($tag->description)
                        <p class="text-sm text-gray-600 mb-4">{{ $tag->description }}</p>
                    @endif
                    <div class="text-sm text-gray-500">
                        <p>{{ $tag->blogPosts->count() }} artículos</p>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Empty State -->
            @if($tags->count() == 0)
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-medium text-gray-900 mb-2">No hay etiquetas creadas</h3>
                <p class="text-gray-500 mb-8">Crea etiquetas para etiquetar tus artículos del blog.</p>
                <a href="{{ route('creator.tags.create', $website) }}" class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700">
                    Crear Primera Etiqueta
                </a>
            </div>
            @endif
@endsection