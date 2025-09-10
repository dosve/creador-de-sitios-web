@extends('layouts.creator')

@section('title', 'Plantillas')
@section('page-title', 'Plantillas')
@section('content')
            <!-- Templates Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($templates->flatten() as $template)
                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-200">
                    <!-- Template Preview -->
                    <div class="aspect-w-16 aspect-h-9 bg-gray-100">
                        @php
                            $previewImage = null;
                            if ($template->preview_images && is_array($template->preview_images) && count($template->preview_images) > 0) {
                                $previewImage = $template->preview_images[0];
                            }
                        @endphp
                        <img src="{{ $previewImage ? asset('storage/' . $previewImage) : 'https://via.placeholder.com/400x225?text=Preview' }}" 
                             alt="{{ $template->name }}" 
                             class="w-full h-48 object-cover">
                    </div>
                    
                    <!-- Template Info -->
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $template->name }}</h3>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $template->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $template->is_active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </div>
                        
                        @if($template->description)
                        <p class="text-sm text-gray-600 mb-4">{{ $template->description }}</p>
                        @endif
                        
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                            <span>{{ $template->category ?? 'General' }}</span>
                            <span>{{ $template->created_at->format('d/m/Y') }}</span>
                        </div>
                        
                        <!-- Template Actions -->
                        <div class="flex space-x-2">
                            <a href="{{ route('creator.templates.preview', $template) }}" 
                               class="flex-1 bg-gray-100 text-gray-700 text-center py-2 px-3 rounded-md hover:bg-gray-200 text-sm">
                                Vista Previa
                            </a>
                            <a href="{{ route('creator.templates.show', $template) }}" 
                               class="flex-1 bg-blue-600 text-white text-center py-2 px-3 rounded-md hover:bg-blue-700 text-sm">
                                Usar Plantilla
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Empty State -->
            @if($templates->flatten()->count() == 0)
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-medium text-gray-900 mb-2">No hay plantillas disponibles</h3>
                <p class="text-gray-500">Las plantillas aparecerán aquí cuando estén disponibles.</p>
            </div>
            @endif
@endsection