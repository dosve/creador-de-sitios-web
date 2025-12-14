{{-- Contenido del producto para plantilla básica --}}
@php
    $productName = $product['nombre'] ?? $product['name'] ?? 'Producto';
    $productDescription = $product['descripcion'] ?? $product['description'] ?? '';
    $productPrice = $product['precio'] ?? $product['price'] ?? 0;
    $productId = $product['id'] ?? null;
    
    // Obtener stock y normalizar a número entero
    // Buscar en diferentes campos posibles
    $productStockRaw = null;
    if (isset($product['existencia'])) {
        $productStockRaw = $product['existencia'];
    } elseif (isset($product['stock'])) {
        $productStockRaw = $product['stock'];
    } elseif (isset($product['inventario'])) {
        $productStockRaw = $product['inventario'];
    }
    
    // Normalizar a número entero
    $productStock = 0;
    if ($productStockRaw !== null && $productStockRaw !== '' && $productStockRaw !== false) {
        // Convertir a string primero para manejar casos como "0", luego a int
        $productStock = (int) (string) $productStockRaw;
        // Asegurarse de que no sea negativo
        if ($productStock < 0) {
            $productStock = 0;
        }
    }
    
    $productIva = $product['iva'] ?? 0;
    $categoryName = $product['categoria'] ?? $product['category'] ?? null;
    if (is_array($categoryName)) {
        $categoryName = $categoryName['nombre'] ?? $categoryName['name'] ?? null;
    }
    
    // Obtener todas las imágenes del producto
    $productImages = [];
    if (!empty($product['imagenes']) && is_array($product['imagenes'])) {
        // Nuevo sistema: múltiples imágenes
        foreach ($product['imagenes'] as $imagenItem) {
            if (!empty($imagenItem['imagen_url'])) {
                $productImages[] = $imagenItem['imagen_url'];
            } elseif (!empty($imagenItem['imagen'])) {
                // Si no tiene URL construida, construirla aquí
                $baseImageUrl = rtrim($website->api_base_url ?? '', '/api');
                $productImages[] = $baseImageUrl . '/storage/productos/' . $imagenItem['imagen'];
            }
        }
    }
    
    // Si no hay imágenes en el nuevo sistema, usar img (compatibilidad)
    if (empty($productImages) && !empty($product['img_url'])) {
        $productImages[] = $product['img_url'];
    } elseif (empty($productImages) && !empty($product['img'])) {
        $baseImageUrl = rtrim($website->api_base_url ?? '', '/api');
        $productImages[] = $baseImageUrl . '/storage/productos/' . $product['img'];
    } elseif (empty($productImages) && !empty($product['image'])) {
        $productImages[] = $product['image'];
    }
    
    $mainImage = !empty($productImages) ? $productImages[0] : null;
@endphp

<div class="min-h-screen bg-gray-50">
    <!-- Header del producto -->
    <div class="bg-white shadow-sm">
        <div class="container px-4 sm:px-6 lg:px-8 py-8 mx-auto">
            <div class="flex items-center text-sm text-gray-500 mb-4">
                <a href="{{ route('website.show', $website->slug) }}" class="hover:text-gray-700">Inicio</a>
                <span class="mx-2">/</span>
                <span class="text-gray-700">{{ $productName }}</span>
            </div>
        </div>
    </div>

    <!-- Contenido del producto -->
    <div class="container px-4 sm:px-6 lg:px-8 py-12 mx-auto">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8">
                <!-- Galería de imágenes del producto -->
                <div class="relative">
                    @if(!empty($productImages))
                        <!-- Imagen principal -->
                        <div class="mb-4 relative">
                            <img id="main-product-image" src="{{ $mainImage }}" alt="{{ $productName }}" class="w-full h-auto rounded-lg object-cover cursor-pointer" onclick="openImageModal('{{ $mainImage }}')">
                            @if($categoryName)
                                <div class="absolute top-4 left-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 backdrop-blur-sm bg-opacity-90">
                                        {{ $categoryName }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Miniaturas de imágenes (si hay más de una) -->
                        @if(count($productImages) > 1)
                            <div class="flex space-x-2 overflow-x-auto pb-2">
                                @foreach($productImages as $index => $image)
                                    <button 
                                        onclick="changeMainImage('{{ $image }}', {{ $index }})"
                                        class="flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden border-2 {{ $index === 0 ? 'border-blue-500' : 'border-gray-200' }} hover:border-blue-400 transition-colors"
                                        id="thumb-{{ $index }}"
                                    >
                                        <img src="{{ $image }}" alt="{{ $productName }} - Imagen {{ $index + 1 }}" class="w-full h-full object-cover">
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    @else
                        <!-- Sin imágenes -->
                        <div class="w-full h-96 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center">
                            <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        @if($categoryName)
                            <div class="absolute top-4 left-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 backdrop-blur-sm bg-opacity-90">
                                    {{ $categoryName }}
                                </span>
                            </div>
                        @endif
                    @endif
                </div>

                <!-- Información del producto -->
                <div class="flex flex-col">
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $productName }}</h1>
                    
                    @if($productDescription)
                        <div class="prose prose-lg max-w-none mb-6">
                            <p class="text-gray-600">{{ $productDescription }}</p>
                        </div>
                    @endif

                    <!-- Precio -->
                    <div class="mb-6">
                        <div class="flex items-baseline">
                            <span class="text-4xl font-bold text-gray-900">
                                ${{ number_format($productPrice, 0, ',', '.') }}
                            </span>
                            @if($productIva > 0)
                                <span class="ml-2 text-sm text-gray-500">
                                    (IVA incluido)
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Stock -->
                    @if($productStock > 0)
                        <div class="mb-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                En stock ({{ $productStock }} disponibles)
                            </span>
                        </div>
                    @else
                        <div class="mb-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                Sin stock
                            </span>
                        </div>
                    @endif

                    <!-- Botón agregar al carrito o controles de cantidad -->
                    @if($productId)
                        @php
                            // Verificar si hay stock disponible
                            $hasStock = $productStock > 0;
                            $stockValue = $productStock > 0 ? $productStock : 0;
                        @endphp
                        <!-- Contenedor para botón o controles (se actualizará con JavaScript) -->
                        <div id="product-cart-controls-{{ $productId }}" class="mb-4">
                            <!-- Botón inicial (se reemplazará si el producto está en el carrito) -->
                            <button 
                                id="add-to-cart-btn-{{ $productId }}"
                                class="add-to-cart w-full px-6 py-4 {{ $hasStock ? 'bg-blue-600 hover:bg-blue-700' : 'bg-gray-400 cursor-not-allowed' }} text-white font-semibold rounded-lg transition-colors duration-200"
                                data-id="{{ $productId }}"
                                data-name="{{ $productName }}"
                                data-price="{{ $productPrice }}"
                                data-descripcion="{{ $productDescription }}"
                                data-existencia="{{ $stockValue }}"
                                data-iva="{{ $productIva }}"
                                {{ !$hasStock ? 'disabled' : '' }}
                            >
                                <span class="flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    {{ $hasStock ? 'Agregar al carrito' : 'Sin stock' }}
                                </span>
                            </button>
                        </div>
                    @endif

                    <!-- Navegación -->
                    <div class="mt-auto pt-6 border-t border-gray-200">
                        <a href="{{ route('website.show', $website->slug) }}" 
                           class="inline-flex items-center text-gray-600 hover:text-gray-900">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Volver al inicio
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .prose {
        color: #374151;
    }
    .prose p {
        margin-bottom: 1rem;
        line-height: 1.7;
    }
    button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    /* Modal para imagen ampliada */
    #image-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.9);
        cursor: pointer;
    }
    
    #image-modal img {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        max-width: 90%;
        max-height: 90%;
        object-fit: contain;
    }
    
    #image-modal .close {
        position: absolute;
        top: 20px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        cursor: pointer;
    }
</style>

<script>
    // Función para actualizar la cantidad de un producto en el carrito (compatible con products-script)
    function updateProductQuantityInCart(productId, change) {
        let cart = JSON.parse(localStorage.getItem("cart") || "[]");
        let itemIndex = cart.findIndex(item => item.id == productId || item.id == String(productId));
        
        if (itemIndex === -1) {
            itemIndex = cart.findIndex(item => parseInt(item.id) == parseInt(productId));
        }

        if (itemIndex !== -1) {
            cart[itemIndex].quantity += change;

            if (cart[itemIndex].quantity <= 0) {
                cart.splice(itemIndex, 1);
            }

            localStorage.setItem("cart", JSON.stringify(cart));
            updateProductCartControls(productId);
            window.dispatchEvent(new CustomEvent("cartUpdated", { detail: { cart: cart } }));
        }
    }
    
    // Verificar si el producto está en el carrito al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
        @if($productId)
            const productId = {{ $productId }};
            updateProductCartControls(productId);
            
            // Escuchar cambios en el carrito
            window.addEventListener('cartUpdated', function() {
                updateProductCartControls(productId);
            });
            
            // Agregar event listeners para los botones de cantidad
            document.addEventListener('click', function(e) {
                if (e.target.closest('.cart-increase')) {
                    e.preventDefault();
                    e.stopPropagation();
                    const btn = e.target.closest('.cart-increase');
                    const productId = btn.getAttribute('data-id');
                    updateProductQuantityInCart(productId, 1);
                }
                
                if (e.target.closest('.cart-decrease')) {
                    e.preventDefault();
                    e.stopPropagation();
                    const btn = e.target.closest('.cart-decrease');
                    const productId = btn.getAttribute('data-id');
                    updateProductQuantityInCart(productId, -1);
                }
            });
        @endif
    });
    
    function updateProductCartControls(productId) {
        const cart = JSON.parse(localStorage.getItem('cart') || '[]');
        const cartItem = cart.find(item => item.id == productId || item.id == String(productId) || parseInt(item.id) == parseInt(productId));
        const controlsContainer = document.getElementById('product-cart-controls-' + productId);
        const addButton = document.getElementById('add-to-cart-btn-' + productId);
        
        if (!controlsContainer) return;
        
        if (cartItem && cartItem.quantity > 0) {
            // El producto está en el carrito, mostrar controles de cantidad
            if (addButton) {
                addButton.style.display = 'none';
            }
            
            // Verificar si ya existen los controles
            let controlsDiv = controlsContainer.querySelector('[data-product-cart-controls]');
            if (!controlsDiv) {
                controlsDiv = document.createElement('div');
                controlsDiv.setAttribute('data-product-cart-controls', productId);
                controlsDiv.className = 'flex items-center justify-center gap-4 w-full px-6 py-4 bg-gray-50 rounded-lg border-2 border-blue-200';
                controlsDiv.innerHTML = `
                    <button class="flex items-center justify-center w-12 h-12 text-white bg-red-500 rounded-lg hover:bg-red-600 cart-decrease transition-colors" 
                            data-id="${productId}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                        </svg>
                    </button>
                    <div class="text-center">
                        <div class="text-sm text-gray-600 mb-1">En el carrito</div>
                        <div class="text-2xl font-bold text-blue-600 cart-quantity" data-id="${productId}">${cartItem.quantity}</div>
                        <div class="text-xs text-gray-500">unidades</div>
                    </div>
                    <button class="flex items-center justify-center w-12 h-12 text-white bg-green-500 rounded-lg hover:bg-green-600 cart-increase transition-colors" 
                            data-id="${productId}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </button>
                `;
                controlsContainer.appendChild(controlsDiv);
            } else {
                // Actualizar solo la cantidad
                const quantityElement = controlsDiv.querySelector('.cart-quantity');
                if (quantityElement) {
                    quantityElement.textContent = cartItem.quantity;
                }
            }
        } else {
            // El producto NO está en el carrito, mostrar botón de agregar
            const controlsDiv = controlsContainer.querySelector('[data-product-cart-controls]');
            if (controlsDiv) {
                controlsDiv.remove();
            }
            if (addButton) {
                addButton.style.display = 'block';
            }
        }
    }
    
    function changeMainImage(imageUrl, index) {
        // Cambiar la imagen principal
        document.getElementById('main-product-image').src = imageUrl;
        
        // Actualizar bordes de las miniaturas
        document.querySelectorAll('[id^="thumb-"]').forEach((thumb, i) => {
            if (i === index) {
                thumb.classList.remove('border-gray-200');
                thumb.classList.add('border-blue-500');
            } else {
                thumb.classList.remove('border-blue-500');
                thumb.classList.add('border-gray-200');
            }
        });
    }
    
    function openImageModal(imageUrl) {
        const modal = document.getElementById('image-modal');
        const modalImg = document.getElementById('modal-image');
        modal.style.display = 'block';
        modalImg.src = imageUrl;
    }
    
    function closeImageModal() {
        document.getElementById('image-modal').style.display = 'none';
    }
    
    // Cerrar modal al hacer click fuera de la imagen
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('image-modal');
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === modal || e.target.classList.contains('close')) {
                    closeImageModal();
                }
            });
            
            // Cerrar con tecla Escape
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && modal.style.display === 'block') {
                    closeImageModal();
                }
            });
        }
    });
</script>

<!-- Modal para imagen ampliada -->
<div id="image-modal">
    <span class="close">&times;</span>
    <img id="modal-image" src="" alt="{{ $productName }}">
</div>
