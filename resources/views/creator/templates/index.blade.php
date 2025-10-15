@extends('layouts.creator')

@section('title', 'Plantillas')
@section('page-title', 'Plantillas')
@section('content')
            <!-- Templates Grid -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach($templates as $categoryTemplates)
                    @foreach($categoryTemplates as $template)
                <div class="overflow-hidden transition-shadow duration-200 bg-white border border-gray-200 rounded-lg hover:shadow-lg">
                    <!-- Template Preview -->
                    @php
                        $previewImage = $template['preview_image_url'] ?? null;
                    @endphp
                    @if($previewImage)
                        <div class="bg-gray-100 aspect-w-16 aspect-h-9">
                            <img src="{{ $previewImage }}" alt="{{ $template['name'] }}" class="object-cover w-full h-48" onerror="this.parentElement.innerHTML='<div class=\'flex items-center justify-center w-full h-48 bg-gray-200\'><svg class=\'w-12 h-12 text-gray-400\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\'></path></svg></div>'">
                        </div>
                    @else
                        <div class="bg-gray-100 aspect-w-16 aspect-h-9">
                            <div class="flex items-center justify-center w-full h-48 bg-gray-200">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Template Info -->
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $template['name'] }}</h3>
                            <div class="flex items-center space-x-2">
                                @if($website && $website->template_id == $template['slug'])
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    En Uso
                                </span>
                                @endif
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ ($template['is_active'] ?? true) ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ ($template['is_active'] ?? true) ? 'Activo' : 'Inactivo' }}
                                </span>
                            </div>
                        </div>
                        
                        @if(!empty($template['description']))
                        <p class="mb-4 text-sm text-gray-600">{{ $template['description'] }}</p>
                        @endif
                        
                        <div class="flex items-center justify-between mb-4 text-sm text-gray-500">
                            <span>{{ $template['category'] ?? 'General' }}</span>
                            <span>{{ date('d/m/Y', $template['created_at']) }}</span>
                        </div>
                        
                        <!-- Template Actions -->
                        <div class="flex space-x-2">
                            <a href="{{ route('creator.templates.preview', $template['slug']) }}" 
                               class="flex-1 px-3 py-2 text-sm text-center text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200" target="_blank" rel="noopener noreferrer">
                                Vista Previa
                            </a>
                            @if($website && $website->template_id == $template['slug'])
                            <span class="flex-1 px-3 py-2 text-sm text-center text-green-700 bg-green-100 rounded-md cursor-default">
                                ✓ Aplicada
                            </span>
                            @else
                            <a href="{{ route('creator.templates.show', $template['slug']) }}" 
                               class="flex-1 px-3 py-2 text-sm text-center text-white bg-blue-600 rounded-md hover:bg-blue-700">
                                Usar Plantilla
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                    @endforeach
                @endforeach
            </div>

            <!-- Empty State -->
            @if($templates->count() == 0)
            <div class="py-16 text-center">
                <div class="flex items-center justify-center w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path>
                    </svg>
                </div>
                <h3 class="mb-2 text-xl font-medium text-gray-900">No hay plantillas disponibles</h3>
                <p class="text-gray-500">Las plantillas aparecerán aquí cuando estén disponibles.</p>
            </div>
            @endif
@endsection