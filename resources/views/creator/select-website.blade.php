@extends('layouts.creator-simple')

@section('title', 'Seleccionar Sitio Web')
@section('page-title', 'Seleccionar Sitio Web')
@section('content')
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">¡Bienvenido, {{ auth()->user()->name }}!</h1>
                    <p class="text-lg text-gray-600">Selecciona el sitio web con el que quieres trabajar en esta sesión</p>
                </div>

                <!-- Websites Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    @foreach($websites as $website)
                    <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-shadow duration-200 cursor-pointer" 
                         onclick="selectWebsite({{ $website->id }})">
                        <!-- Website Header -->
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $website->name }}</h3>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $website->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $website->is_published ? 'Publicado' : 'Borrador' }}
                                </span>
                            </div>
                        </div>

                        <!-- Website Description -->
                        @if($website->description)
                        <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $website->description }}</p>
                        @endif

                        <!-- Website Stats -->
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                            <div class="flex items-center space-x-4">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    {{ $website->pages->count() }} páginas
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                    </svg>
                                    {{ $website->blogPosts->count() }} posts
                                </span>
                            </div>
                            <span>{{ $website->created_at->format('d/m/Y') }}</span>
                        </div>

                        <!-- Select Button -->
                        <div class="mt-4">
                            <button type="button" class="w-full bg-blue-600 text-white text-center py-2 px-4 rounded-md hover:bg-blue-700 text-sm font-medium">
                                Seleccionar este sitio
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Create New Website Option -->
                <div class="text-center">
                    <div class="bg-white border-2 border-dashed border-gray-300 rounded-lg p-8 hover:border-blue-400 hover:bg-blue-50 transition-all duration-200 cursor-pointer" 
                         onclick="createNewWebsite()">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Crear Nuevo Sitio Web</h3>
                        <p class="text-sm text-gray-500">Comienza un nuevo proyecto web</p>
                    </div>
                </div>
            </div>

            <!-- Hidden Form for Website Selection -->
            <form id="selectWebsiteForm" method="POST" action="{{ route('creator.select-website') }}" style="display: none;">
                @csrf
                <input type="hidden" name="website_id" id="selectedWebsiteId">
            </form>

            <script>
                function selectWebsite(websiteId) {
                    document.getElementById('selectedWebsiteId').value = websiteId;
                    document.getElementById('selectWebsiteForm').submit();
                }

                function createNewWebsite() {
                    window.location.href = "{{ route('creator.websites.create') }}";
                }
            </script>
@endsection
