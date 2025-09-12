@extends('layouts.creator')

@section('title', 'Productos - ' . $website->name)

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Productos</h1>
                    <p class="mt-2 text-gray-600">Gestiona los productos de tu tienda</p>
                </div>
                {{-- <a href="{{ route('creator.pages.create', $website) }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                    Nuevo Producto
                </a> --}}
            </div>
        </div>

        <!-- Controles de paginación -->
        @if($useExternalApi && $pagination)
            <div class="mb-6 flex justify-end">
                <x-per-page-selector label="Productos por página:" />
            </div>
        @endif

        <!-- Products Grid -->
        @if($useExternalApi && count($externalProducts) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($externalProducts as $product)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                        @if($product['img'])
                            <div class="aspect-w-16 aspect-h-9">
                                <img src="{{ $product['img'] }}" 
                                     alt="{{ $product['producto'] }}"
                                     class="w-full h-48 object-cover">
                            </div>
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                        
                        <div class="p-6">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                        {{ $product['producto'] }}
                                    </h3>
                                    @if(isset($product['categoria']))
                                        <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mb-2">
                                            {{ $product['categoria']['categoria'] }}
                                        </span>
                                    @endif
                                    <p class="text-gray-600 text-sm line-clamp-2">
                                        {{ $product['descripcion'] ?? '' }}
                                    </p>
                                </div>
                            </div>
                            
                            <div class="mt-4 flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <span class="text-lg font-bold text-green-600">
                                        ${{ number_format($product['precio'], 2) }}
                                    </span>
                                    <span class="text-sm text-gray-500">
                                        Stock: {{ $product['existencia'] }}
                                    </span>
                                </div>
                                
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm text-gray-500">
                                        Código: {{ $product['codigo'] }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @elseif(!$useExternalApi && $products->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($products as $product)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                        @if($product->featured_image)
                            <div class="aspect-w-16 aspect-h-9">
                                <img src="{{ Storage::url($product->featured_image) }}" 
                                     alt="{{ $product->title }}"
                                     class="w-full h-48 object-cover">
                            </div>
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                        
                        <div class="p-6">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                        {{ $product->title }}
                                    </h3>
                                    @if($product->category)
                                        <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mb-2">
                                            {{ $product->category->name }}
                                        </span>
                                    @endif
                                    <p class="text-gray-600 text-sm line-clamp-2">
                                        {{ Str::limit(strip_tags($product->content), 100) }}
                                    </p>
                                </div>
                            </div>
                            
                            <div class="mt-4 flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    @if($product->price)
                                        <span class="text-lg font-bold text-green-600">
                                            ${{ number_format($product->price, 2) }}
                                        </span>
                                    @endif
                                    @if($product->stock !== null)
                                        <span class="text-sm text-gray-500">
                                            Stock: {{ $product->stock }}
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('creator.pages.edit', [$website, $product]) }}" 
                                       class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        Editar
                                    </a>
                                    <span class="text-gray-300">|</span>
                                    <a href="{{ route('creator.pages.preview', [$website, $product]) }}" 
                                       class="text-green-600 hover:text-green-800 text-sm font-medium">
                                        Ver
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No hay productos</h3>
                <p class="mt-1 text-sm text-gray-500">
                    @if($useExternalApi)
                        No se encontraron productos en la API externa. Verifica tu configuración de API.
                    @else
                        No tienes productos configurados. Puedes crear productos desde las páginas o configurar una API externa.
                    @endif
                </p>
                {{-- <div class="mt-6 space-x-4">
                    @if(!$useExternalApi)
                        <a href="{{ route('creator.pages.create', $website) }}" 
                           class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            Crear Producto
                        </a>
                    @endif
                    <a href="{{ route('creator.config.api', $website) }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Configurar API Externa
                    </a>
                </div> --}}
            </div>
        @endif

        <!-- Paginación -->
        @if($useExternalApi && $pagination)
            <x-pagination :pagination="$pagination" :showPerPageSelector="false" />
        @endif
    </div>
</div>

@endsection
