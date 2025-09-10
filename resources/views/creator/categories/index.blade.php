@extends('layouts.creator')

@section('title', 'Categorías - ' . $website->name)
@section('page-title', 'Categorías')
@section('content')
            <!-- Categories Header -->
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-medium text-gray-900">Categorías de {{ $website->name }}</h2>
                            <p class="text-sm text-gray-600 mt-1">Gestiona las categorías para tu blog</p>
                    </div>
                        <a href="{{ route('creator.categories.create', $website) }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-sm">
                            Nueva Categoría
                        </a>
                    </div>
                </div>
            </div>

            <!-- Categories Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($categories as $category)
                <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-shadow duration-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $category->name }}</h3>
                    @if($category->description)
                        <p class="text-sm text-gray-600 mb-4">{{ $category->description }}</p>
                    @endif
                    <div class="text-sm text-gray-500">
                        <p>{{ $category->blogPosts->count() }} artículos</p>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Empty State -->
            @if($categories->count() == 0)
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-medium text-gray-900 mb-2">No hay categorías creadas</h3>
                <p class="text-gray-500 mb-8">Crea categorías para organizar tus artículos del blog.</p>
                <a href="{{ route('creator.categories.create', $website) }}" class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700">
                    Crear Primera Categoría
                </a>
            </div>
            @endif
@endsection