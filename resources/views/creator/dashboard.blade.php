@extends('layouts.creator')

@section('title', 'Inicio')
@section('page-title', 'Inicio - ' . $selectedWebsite->name)
@section('content')
            <!-- Selected Website Info -->
            <div class="mb-6 bg-white rounded-lg shadow">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-medium text-gray-900">Trabajando con: {{ $selectedWebsite->name }}</h2>
                            @if($selectedWebsite->description)
                                <p class="mt-1 text-sm text-gray-600">{{ $selectedWebsite->description }}</p>
                            @endif
                            <p class="mt-2 text-xs text-gray-500">
                                Creado el {{ $selectedWebsite->created_at->format('d/m/Y') }} • 
                                Última actualización: {{ $selectedWebsite->updated_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-600">{{ $selectedWebsite->pages->count() }} páginas</p>
                            <p class="text-sm text-gray-600">{{ $selectedWebsite->blogPosts->count() }} posts</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions for Selected Website -->
            <div class="mb-6 bg-white rounded-lg shadow">
                <div class="px-6 py-4">
                    <h3 class="mb-4 text-lg font-medium text-gray-900">Gestionar {{ $selectedWebsite->name }}</h3>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
                        <a href="{{ route('creator.pages.create', $selectedWebsite) }}" class="flex items-center p-4 transition-colors border border-gray-200 rounded-lg hover:bg-gray-50">
                            <div class="flex items-center justify-center w-10 h-10 mr-3 bg-blue-100 rounded-lg">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">Nueva Página</h4>
                                <p class="text-xs text-gray-500">Agregar contenido</p>
                            </div>
                        </a>
                        
                        <a href="{{ route('creator.blog.index', $selectedWebsite) }}" class="flex items-center p-4 transition-colors border border-gray-200 rounded-lg hover:bg-gray-50">
                            <div class="flex items-center justify-center w-10 h-10 mr-3 bg-green-100 rounded-lg">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">Blog</h4>
                                <p class="text-xs text-gray-500">Artículos y posts</p>
                            </div>
                        </a>
                        
                        <a href="{{ route('creator.seo.index', $selectedWebsite) }}" class="flex items-center p-4 transition-colors border border-gray-200 rounded-lg hover:bg-gray-50">
                            <div class="flex items-center justify-center w-10 h-10 mr-3 bg-yellow-100 rounded-lg">
                                {{-- <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"></path>
                                </svg> --}}
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-yellow-600" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8H4a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H3m11 0h-4V8h4m-3 4h2m4-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v6a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1z"/></svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">SEO & Analytics</h4>
                                <p class="text-xs text-gray-500">Metadatos y análisis</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Actividad Reciente</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <!-- Recent Pages -->
                        @if($selectedWebsite->pages->count() > 0)
                        <div>
                            <h4 class="mb-2 text-sm font-medium text-gray-900">Páginas Recientes</h4>
                            <div class="space-y-2">
                                @foreach($selectedWebsite->pages()->latest()->take(3)->get() as $page)
                                <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50">
                                    <div class="flex items-center">
                                        <div class="flex items-center justify-center w-8 h-8 mr-3 bg-blue-100 rounded-lg">
                                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $page->title }}</p>
                                            <p class="text-xs text-gray-500">{{ $page->updated_at->format('d/m/Y H:i') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('creator.pages.editor', [$selectedWebsite, $page]) }}" class="text-sm font-medium text-green-600 hover:text-green-800">
                                            Editar
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Recent Blog Posts -->
                        @if($selectedWebsite->blogPosts->count() > 0)
                        <div>
                            <h4 class="mb-2 text-sm font-medium text-gray-900">Posts Recientes</h4>
                            <div class="space-y-2">
                                @foreach($selectedWebsite->blogPosts()->latest()->take(3)->get() as $post)
                                <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50">
                                    <div class="flex items-center">
                                        <div class="flex items-center justify-center w-8 h-8 mr-3 bg-green-100 rounded-lg">
                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $post->title }}</p>
                                            <p class="text-xs text-gray-500">{{ $post->updated_at->format('d/m/Y H:i') }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('creator.blog.edit', [$selectedWebsite, $post]) }}" class="text-sm text-blue-600 hover:text-blue-800">
                                        Editar
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Empty State -->
                        @if($selectedWebsite->pages->count() == 0 && $selectedWebsite->blogPosts->count() == 0)
                        <div class="py-8 text-center">
                            <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <h3 class="mb-2 text-lg font-medium text-gray-900">¡Comienza a crear contenido!</h3>
                            <p class="mb-4 text-gray-500">Crea tu primera página o escribe un artículo para tu blog.</p>
                            <div class="flex justify-center space-x-4">
                                <a href="{{ route('creator.pages.create', $selectedWebsite) }}" class="px-4 py-2 text-sm text-white bg-blue-600 rounded-md hover:bg-blue-700">
                                    Nueva Página
                                </a>
                                <a href="{{ route('creator.blog.create', $selectedWebsite) }}" class="px-4 py-2 text-sm text-white bg-green-600 rounded-md hover:bg-green-700">
                                    Nuevo Post
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
@endsection
