@extends('layouts.creator')

@section('title', 'Páginas - ' . $website->name)
@section('page-title', 'Páginas')
@section('content')
<!-- Pages Header -->
<div class="bg-white shadow rounded-lg mb-6">
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-medium text-gray-900">Páginas de {{ $website->name }}</h2>
                <p class="text-sm text-gray-600 mt-1">Gestiona el contenido de tu sitio web</p>
            </div>
            <a href="{{ route('creator.pages.create', $website) }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-sm">
                Nueva Página
            </a>
        </div>
    </div>
</div>

<!-- Pages Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($pages as $page)
    <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-shadow duration-200">
        <!-- Page Header -->
        <div class="flex items-start justify-between mb-4">
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $page->title }}</h3>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $page->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                    {{ $page->is_published ? 'Publicada' : 'Borrador' }}
                </span>
            </div>
        </div>

        <!-- Page Info -->
        <div class="text-sm text-gray-500 mb-4">
            <p><strong>Slug:</strong> /{{ $page->slug }}</p>
            <p><strong>Actualizada:</strong> {{ $page->updated_at->format('d/m/Y H:i') }}</p>
        </div>

        <!-- Page Actions -->
        <div class="space-y-2">
            <div class="flex space-x-2">
                <a href="{{ route('creator.pages.editor', [$website, $page]) }}"
                    class="flex-1 bg-green-600 text-white text-center py-2 px-3 rounded-md hover:bg-green-700 text-sm">
                    Editor Visual
                </a>
                <a href="{{ route('creator.pages.edit', [$website, $page]) }}"
                    class="flex-1 bg-blue-600 text-white text-center py-2 px-3 rounded-md hover:bg-blue-700 text-sm">
                    Editar
                </a>
            </div>
            <form method="POST" action="{{ route('creator.pages.destroy', [$website, $page]) }}" onsubmit="return confirm('¿Estás seguro de eliminar esta página?')">
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
@if($pages->count() == 0)
<div class="text-center py-16">
    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
    </div>
    <h3 class="text-xl font-medium text-gray-900 mb-2">No hay páginas creadas</h3>
    <p class="text-gray-500 mb-8">Comienza creando tu primera página para tu sitio web.</p>
    <a href="{{ route('creator.pages.create', $website) }}" class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700">
        Crear Primera Página
    </a>
</div>
@endif
@endsection