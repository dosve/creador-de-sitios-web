@extends('layouts.creator')

@section('title', 'SEO - ' . $website->name)
@section('page-title', 'SEO & Analytics')
@section('content')
            <!-- SEO Header -->
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-medium text-gray-900">SEO & Analytics de {{ $website->name }}</h2>
                            <p class="text-sm text-gray-600 mt-1">Optimiza tu sitio web para los motores de búsqueda</p>
                        </div>
                        <a href="{{ route('creator.seo.edit', $website) }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-sm">
                            Configurar SEO
                        </a>
                    </div>
                </div>
            </div>

            <!-- SEO Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                <!-- Meta Title -->
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">Meta Título</h3>
                            <p class="text-xs text-gray-500">
                                @if($website->seo_settings && isset($website->seo_settings['meta_title']))
                                    {{ Str::limit($website->seo_settings['meta_title'], 30) }}
                                @else
                                    No configurado
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Meta Description -->
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">Meta Descripción</h3>
                            <p class="text-xs text-gray-500">
                                @if($website->seo_settings && isset($website->seo_settings['meta_description']))
                                    {{ Str::limit($website->seo_settings['meta_description'], 30) }}
                                @else
                                    No configurado
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Keywords -->
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">Palabras Clave</h3>
                            <p class="text-xs text-gray-500">
                                @if($website->seo_settings && isset($website->seo_settings['meta_keywords']))
                                    {{ Str::limit($website->seo_settings['meta_keywords'], 30) }}
                                @else
                                    No configurado
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SEO Tips -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Consejos de SEO</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center mr-3 mt-0.5">
                                <span class="text-xs font-medium text-blue-600">1</span>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">Meta Título</h4>
                                <p class="text-sm text-gray-600">Mantén el título entre 50-60 caracteres para una mejor visualización en los resultados de búsqueda.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3 mt-0.5">
                                <span class="text-xs font-medium text-green-600">2</span>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">Meta Descripción</h4>
                                <p class="text-sm text-gray-600">Escribe una descripción atractiva de 150-160 caracteres que invite a hacer clic.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-6 h-6 bg-purple-100 rounded-full flex items-center justify-center mr-3 mt-0.5">
                                <span class="text-xs font-medium text-purple-600">3</span>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">Palabras Clave</h4>
                                <p class="text-sm text-gray-600">Usa palabras clave relevantes separadas por comas, pero evita el exceso de palabras clave.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection