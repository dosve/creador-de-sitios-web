@extends('layouts.creator')

@section('title', 'Productos - ' . $website->name)

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Productos</h1>
                    <p class="mt-2 text-gray-600">Gestiona los productos de tu tienda</p>
                </div>
                {{-- <a href="{{ route('creator.pages.create', $website) }}" 
                   class="px-4 py-2 font-medium text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700">
                    Nuevo Producto
                </a> --}}
            </div>
        </div>

        <!-- Paginación superior -->
        @if($useExternalApi && $pagination)
            <div class="mb-4">
                <x-pagination :pagination="$pagination" :showPerPageSelector="true" label="productos" />
            </div>
        @endif

        <!-- Products Grid -->
        @if($useExternalApi && count($externalProducts) > 0)
            <div class="p-4 mb-6 border border-blue-200 rounded-lg bg-blue-50">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h3 class="text-sm font-medium text-blue-800">Vista de Productos</h3>
                        <p class="text-sm text-blue-600">Esta es una vista informativa de los productos. Para comprar, visita la <strong>Tienda Virtual</strong> de tu sitio web.</p>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach($externalProducts as $product)
                    <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm">
                        {!! render_image_container(
                            $product['img'], 
                            $product['producto'], 
                            'aspect-w-16 aspect-h-9', 
                            'object-cover w-full h-48'
                        ) !!}
                        
                        <div class="p-6">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="mb-2 text-lg font-semibold text-gray-900">
                                        {{ $product['producto'] }}
                                    </h3>
                                    @if(isset($product['categoria']))
                                        <span class="inline-block px-2 py-1 mb-2 text-xs text-blue-800 bg-blue-100 rounded-full">
                                            {{ $product['categoria']['categoria'] }}
                                        </span>
                                    @endif
                                    <p class="text-sm text-gray-600 line-clamp-2">
                                        {{ $product['descripcion'] ?? '' }}
                                    </p>
                                </div>
                            </div>
                            
                            <div class="flex flex-col mt-4 gap-y-4">
                                <div class="flex flex-col">
                                    <span class="text-sm text-gray-500">
                                        Stock: {{ $product['existencia'] }}
                                    </span>
                                    @if($product['codigo'] === null)
                                        <span class="text-sm text-gray-500">
                                            Código: N/A
                                        </span>
                                    @else
                                        <span class="text-sm text-gray-500">
                                            Código: {{ $product['codigo'] }}
                                        </span>
                                    @endif
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="text-lg font-bold text-green-600">
                                        ${{ number_format($product['precio'], 2) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @elseif(!$useExternalApi && $products->count() > 0)
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach($products as $product)
                    <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm">
                        @if($product->featured_image)
                            <div class="aspect-w-16 aspect-h-9">
                                {!! render_image_container(
                                    Storage::url($product->featured_image), 
                                    $product->title, 
                                    'aspect-w-16 aspect-h-9', 
                                    'object-cover w-full h-48'
                                ) !!}
                            </div>
                        @else
                            <div class="flex items-center justify-center w-full h-48 bg-gray-200">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                        
                        <div class="p-6">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="mb-2 text-lg font-semibold text-gray-900">
                                        {{ $product->title }}
                                    </h3>
                                    @if($product->category)
                                        <span class="inline-block px-2 py-1 mb-2 text-xs text-blue-800 bg-blue-100 rounded-full">
                                            {{ $product->category->name }}
                                        </span>
                                    @endif
                                    <p class="text-sm text-gray-600 line-clamp-2">
                                        {{ Str::limit(strip_tags($product->content), 100) }}
                                    </p>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between mt-4">
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
                                    <span class="text-gray-300">|</span>
                                    <a href="{{ route('creator.pages.preview', [$website, $product]) }}" 
                                       class="text-sm font-medium text-green-600 hover:text-green-800">
                                        Ver
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="py-12 text-center">
                <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                           class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700">
                            Crear Producto
                        </a>
                    @endif
                    <a href="{{ route('creator.config.api', $website) }}" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                        Configurar API Externa
                    </a>
                </div> --}}
            </div>
        @endif

        <!-- Paginación -->
        @if($useExternalApi && $pagination)
            <x-pagination :pagination="$pagination" :showPerPageSelector="true" label="productos" />
        @endif
    </div>
</div>

@endsection
