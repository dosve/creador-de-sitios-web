{{--
    Componente para cargar productos dinámicamente desde la API externa
    
    @param string $apiKey - API Key del usuario
    @param string $apiBaseUrl - URL base de la API externa
--}}
@props(['apiKey' => '', 'apiBaseUrl' => ''])

<script>
document.addEventListener("DOMContentLoaded", function() {
    console.log("🎯 Vista previa de página cargada, buscando productos...");
    
    // Variables globales para el scroll infinito
    let currentPage = 1;
    let isLoading = false;
    let hasMoreProducts = true;
    let allProducts = [];
    
    // Función para cargar productos reales desde la API
    function loadRealProductsInPreview(page = 1, append = false) {
        if (isLoading) return;
        
        isLoading = true;
        console.log("🚀 Iniciando carga de productos en vista previa de página... (Página " + page + ")");
        
        // Buscar contenedores de productos
        let productsContainers = document.querySelectorAll("#products-container");
        console.log("📦 Contenedores por ID encontrados:", productsContainers.length);
        
        // Si no encuentra por ID, buscar por atributo data
        if (productsContainers.length === 0) {
            productsContainers = document.querySelectorAll("[data-dynamic-products=\"true\"] .grid");
            console.log("📦 Contenedores por atributo data encontrados:", productsContainers.length);
        }
        
        // Si aún no encuentra, buscar por clase
        if (productsContainers.length === 0) {
            productsContainers = document.querySelectorAll(".products-list .grid");
            console.log("📦 Contenedores por clase .products-list .grid:", productsContainers.length);
        }
        
        if (productsContainers.length === 0) {
            console.log("❌ No se encontraron contenedores de productos");
            isLoading = false;
            return;
        }
        
        console.log("✅ Encontrados", productsContainers.length, "contenedores de productos");
        
        productsContainers.forEach((container, index) => {
            console.log(`🔄 Procesando contenedor ${index + 1}`);
            
            // Solo mostrar loading en la primera carga
            if (!append) {
                container.innerHTML = `
                    <div class="flex items-center justify-center py-12 col-span-full">
                        <div class="text-center">
                            <div class="w-12 h-12 mx-auto mb-4 border-b-2 border-blue-600 rounded-full animate-spin"></div>
                            <p class="text-gray-600">Cargando productos...</p>
                        </div>
                    </div>
                `;
            }

            // Obtener credenciales de la API
            const apiKey = "{{ addslashes($apiKey) }}";
            const apiBaseUrl = "{{ addslashes($apiBaseUrl) }}";
            
            console.log("🔑 API Key:", apiKey ? "Configurada" : "No configurada");
            console.log("🌐 API URL:", apiBaseUrl ? apiBaseUrl : "No configurada");

            // Si hay credenciales de API, cargar productos reales
            if (apiKey && apiBaseUrl) {
                console.log("✅ Credenciales encontradas, cargando productos de la API externa...");
                
                fetch(apiBaseUrl + "/api-key/products?paginate=6&page=" + page + "&estado=1", {
                    method: "GET",
                    headers: {
                        "X-API-Key": apiKey,
                        "Accept": "application/json",
                        "Content-Type": "application/json"
                    }
                })
                .then(response => {
                    console.log("📡 Respuesta de la API:", response.status);
                    if (!response.ok) {
                        throw new Error("Error en la respuesta de la API: " + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log("📦 Datos recibidos:", data);
                    
                    // La API devuelve data como array, pero verificar por si acaso
                    let products = [];
                    
                    if (data && data.data && Array.isArray(data.data)) {
                        products = data.data;
                    } else if (data && data.data && typeof data.data === "object") {
                        // Fallback: convertir objeto con claves numéricas a array
                        products = Object.values(data.data);
                    }
                    
                    console.log("✅ Productos procesados:", products.length);
                    
                    // Verificar si hay más productos usando la información de paginación de la API
                    if (data.pagination) {
                        hasMoreProducts = data.pagination.current_page < data.pagination.last_page;
                        console.log("📄 Paginación:", {
                            current: data.pagination.current_page,
                            last: data.pagination.last_page,
                            hasMore: hasMoreProducts
                        });
                    } else {
                        // Fallback: si hay menos de 6 productos, no hay más páginas
                        hasMoreProducts = products.length >= 6;
                    }
                    
                    if (products.length > 0) {
                        if (append) {
                            // Agregar productos a los existentes
                            allProducts = allProducts.concat(products);
                            console.log("📦 Total productos acumulados:", allProducts.length);
                            renderRealProducts(container, allProducts, true);
                        } else {
                            // Primera carga
                            allProducts = products;
                            console.log("📦 Primera carga, productos:", allProducts.length);
                            renderRealProducts(container, products, false);
                        }
                        
                        // Agregar buscador de productos
                        addProductSearch(container);
                        
                        // Configurar solo scroll infinito (sin botón)
                        if (hasMoreProducts) {
                            setupInfiniteScroll();
                        } else {
                            console.log("🏁 No hay más productos disponibles, scroll infinito desactivado");
                        }
                    } else {
                        if (!append) {
                            console.log("⚠️ No se encontraron productos, mostrando productos de ejemplo");
                            showEnhancedExampleProducts(container);
                        }
                    }
                    
                    isLoading = false;
                })
                .catch(error => {
                    console.error("❌ Error al cargar productos de la API:", error);
                    isLoading = false;
                    // Si falla la API, mostrar productos de ejemplo
                    if (!append) {
                        showEnhancedExampleProducts(container);
                    }
                });
            } else {
                console.log("⚠️ No hay credenciales de API, mostrando productos de ejemplo");
                isLoading = false;
                // Si no hay credenciales, mostrar productos de ejemplo
                if (!append) {
                    showEnhancedExampleProducts(container);
                }
            }
        });
    }

    // Función para renderizar productos reales de la API
    function renderRealProducts(container, products, append = false) {
        console.log("🎨 Renderizando", products.length, "productos reales... (append:", append, ")");
        
        let productsHtml = "";
        
        // Si es append, solo renderizar los productos nuevos (los últimos agregados)
        let productsToRender = products;
        if (append) {
            // Calcular cuántos productos nuevos hay
            const existingProducts = container.querySelectorAll('.p-6').length;
            const newProductsCount = products.length - existingProducts;
            if (newProductsCount > 0) {
                productsToRender = products.slice(-newProductsCount);
                console.log("📦 Renderizando solo", newProductsCount, "productos nuevos");
            } else {
                console.log("⚠️ No hay productos nuevos para renderizar");
                return;
            }
        }
        
        productsToRender.forEach(product => {
                    const title = product.producto || "Producto sin nombre";
                    const description = product.descripcion || "Sin descripción";
                    const price = product.precio || "0.00";
                    const image = product.img || null;
                    const category = product.categoria ? product.categoria.categoria : null;
                    const iva = product.iva || "0";
                    
                    // Debug: ver qué URL de imagen está llegando desde la API
                    console.log("🖼️ Imagen del producto:", title, "→", image);
            
            // HTML para la imagen
            let imageHtml = `
                <div class="flex items-center justify-center w-full h-48 mb-4 bg-gray-200 rounded-lg">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            `;
            
            // Si hay imagen, construir la URL completa con el servidor
            if (image) {
                // Construir la URL completa usando el servidor de la API
                const imageUrl = `https://servidor.adminnegocios.com/storage/productos/thumbnail/${image}`;
                
                imageHtml = `
                    <div class="mb-4 aspect-w-16 aspect-h-9">
                        <img src="${imageUrl}" 
                             alt="${title}" 
                             class="object-cover w-full h-48 rounded-lg"
                             loading="lazy"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="flex items-center justify-center w-full h-48 bg-gray-200 rounded-lg" style="display:none;">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                `;
                
                // Debug: mostrar la URL construida
                console.log("🔗 URL construida:", image, "→", imageUrl);
            }
            
            // HTML para la categoría
            let categoryHtml = "";
            if (category) {
                categoryHtml = `<span class="inline-block px-2 py-1 mb-2 text-xs text-blue-800 bg-blue-100 rounded-full">${category}</span>`;
            }
            
            // Verificar si el producto está en el carrito
            const cart = JSON.parse(localStorage.getItem("cart")) || [];
            const cartItem = cart.find(item => item.id === product.id);
            
            // HTML para los botones según el estado del producto
            let cartButtonHtml = "";
            if (cartItem) {
                // Producto ya está en el carrito - mostrar controles de cantidad
                cartButtonHtml = `
                    <div class="flex items-center space-x-2" data-product-cart-control="${product.id}">
                        <button class="flex items-center justify-center w-8 h-8 text-white bg-red-500 rounded-md hover:bg-red-600 cart-decrease" 
                                data-id="${product.id}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                            </svg>
                        </button>
                        <span class="px-3 py-1 font-semibold text-gray-900 bg-gray-100 rounded-md cart-quantity" data-id="${product.id}">${cartItem.quantity}</span>
                        <button class="flex items-center justify-center w-8 h-8 text-white bg-green-500 rounded-md hover:bg-green-600 cart-increase" 
                                data-id="${product.id}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </button>
                    </div>
                `;
            } else {
                // Producto no está en el carrito - mostrar botón de agregar
                cartButtonHtml = `
                    <button class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 add-to-cart" 
                            data-id="${product.id || ""}" 
                            data-name="${title}" 
                            data-price="${price}" 
                            data-descripcion="${product.descripcion || ""}" 
                            data-existencia="${product.existencia || ""}" 
                            data-iva="${iva}"
                            data-image="${image || ""}">
                        Agregar al Carrito
                    </button>
                `;
            }
            
            // Construir el HTML del producto
            productsHtml += `
                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                    ${imageHtml}
                    <h3 class="mb-2 text-lg font-semibold text-gray-900">${title}</h3>
                    ${categoryHtml}
                    <p class="mb-4 text-sm text-gray-600 line-clamp-2">${description}</p>
                    <div class="flex items-center justify-between">
                        <span class="text-lg font-bold text-green-600">$${price}</span>
                        ${cartButtonHtml}
                    </div>
                </div>
            `;
        });
        
        if (append) {
            // Si es append, agregar al final del contenedor
            container.insertAdjacentHTML("beforeend", productsHtml);
        } else {
            // Si no es append, reemplazar todo el contenido
            container.innerHTML = productsHtml;
        }
        
        console.log("✅ Productos reales renderizados correctamente");
        
        // Actualizar las tarjetas con los productos que ya están en el carrito
        updateAllProductCardsFromCart();
        
        // Recargar los event listeners del carrito
        if (typeof window.reloadCartListeners === "function") {
            window.reloadCartListeners();
        }
    }
    
    // Función para actualizar todas las tarjetas de productos con los datos del carrito
    function updateAllProductCardsFromCart() {
        const cart = JSON.parse(localStorage.getItem("cart")) || [];
        console.log("🔄 Actualizando tarjetas de productos con carrito:", cart);
        
        // Recorrer todos los botones "Agregar al Carrito"
        const addToCartButtons = document.querySelectorAll(".add-to-cart");
        console.log("🔍 Botones 'Agregar al Carrito' encontrados:", addToCartButtons.length);
        
        addToCartButtons.forEach(btn => {
            const productId = btn.getAttribute("data-id");
            const cartItem = cart.find(item => item.id == productId);
            
            if (cartItem) {
                console.log("✅ Producto en carrito, cambiando a controles:", productId, "Cantidad:", cartItem.quantity);
                // Este producto está en el carrito, cambiar a controles de cantidad
                btn.outerHTML = `
                    <div class="flex items-center space-x-2" data-product-cart-control="${productId}">
                        <button class="flex items-center justify-center w-8 h-8 text-white bg-red-500 rounded-md hover:bg-red-600 cart-decrease" 
                                data-id="${productId}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                            </svg>
                        </button>
                        <span class="px-3 py-1 font-semibold text-gray-900 bg-gray-100 rounded-md cart-quantity" data-id="${productId}">${cartItem.quantity}</span>
                        <button class="flex items-center justify-center w-8 h-8 text-white bg-green-500 rounded-md hover:bg-green-600 cart-increase" 
                                data-id="${productId}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </button>
                    </div>
                `;
            }
        });
        
        // Recorrer todos los controles de cantidad existentes
        const cartControls = document.querySelectorAll("[data-product-cart-control]");
        console.log("🔍 Controles de cantidad encontrados:", cartControls.length);
        
        cartControls.forEach(control => {
            const productId = control.getAttribute("data-product-cart-control");
            const cartItem = cart.find(item => item.id == productId);
            
            console.log("🔍 Verificando control:", productId, "En carrito:", !!cartItem);
            
            if (!cartItem) {
                // Este producto ya no está en el carrito, volver al botón "Agregar al Carrito"
                console.log("🔄 Producto removido del carrito, volviendo a botón agregar:", productId);
                
                // Buscar el contenedor del producto para obtener los datos
                const productCard = control.closest(".p-6");
                if (productCard) {
                    const title = productCard.querySelector("h3")?.textContent || "";
                    const price = productCard.querySelector(".text-green-600")?.textContent.replace("$", "") || "0";
                    
                    console.log("🔍 Datos del producto encontrados:", { title, price });
                    
                    // Buscar el botón de disminuir para obtener más datos
                    const decreaseBtn = control.querySelector(".cart-decrease");
                    if (decreaseBtn) {
                        const productData = {
                            id: decreaseBtn.getAttribute("data-id")
                        };
                        
                        console.log("✅ Reemplazando control con botón agregar para:", productData.id);
                        
                        control.outerHTML = `
                            <button class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 add-to-cart" 
                                    data-id="${productData.id}" 
                                    data-name="${title}" 
                                    data-price="${price}">
                                Agregar al Carrito
                            </button>
                        `;
                    }
                }
            } else {
                // Actualizar la cantidad mostrada
                const quantityEl = control.querySelector(".cart-quantity");
                if (quantityEl) {
                    console.log("🔄 Actualizando cantidad para:", productId, "Nueva cantidad:", cartItem.quantity);
                    quantityEl.textContent = cartItem.quantity;
                }
            }
        });
    }
    
    
    // Función para configurar scroll infinito
    function setupInfiniteScroll() {
        // Remover listener anterior si existe
        window.removeEventListener("scroll", handleScroll);
        
        // Agregar nuevo listener
        window.addEventListener("scroll", handleScroll);
    }
    
    // Función para manejar el scroll
    function handleScroll() {
        if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 1000) {
            // Estamos cerca del final de la página
            if (hasMoreProducts && !isLoading) {
                console.log("🔄 Scroll infinito activado, cargando más productos...");
                currentPage++;
                console.log("📄 Cargando página", currentPage, "de", hasMoreProducts ? "múltiples" : "última");
                
                // Verificar si hay filtros activos
                const searchTerm = document.getElementById("product-search-input")?.value || "";
                const selectedCategory = document.getElementById("category-filter")?.value || "";
                const sortBy = document.getElementById("sort-filter")?.value || "recent";
                
                // Si hay filtros activos, usar la función de búsqueda
                if (searchTerm || selectedCategory || sortBy !== "recent") {
                    loadMoreProductsWithFilters(currentPage);
                } else {
                    // Si no hay filtros, usar la carga normal
                    loadRealProductsInPreview(currentPage, true);
                }
            } else if (!hasMoreProducts) {
                console.log("🏁 No hay más productos para cargar");
            } else if (isLoading) {
                console.log("⏳ Ya se está cargando, esperando...");
            }
        }
    }
    
    // Función para cargar más productos con filtros
    function loadMoreProductsWithFilters(page) {
        if (isLoading) return;
        
        isLoading = true;
        
        const searchTerm = document.getElementById("product-search-input")?.value || "";
        const selectedCategory = document.getElementById("category-filter")?.value || "";
        const sortBy = document.getElementById("sort-filter")?.value || "recent";
        
        // Obtener credenciales de la API
        const apiKey = "{{ addslashes($apiKey) }}";
        const apiBaseUrl = "{{ addslashes($apiBaseUrl) }}";
        
        // Construir parámetros de búsqueda
        let searchParams = new URLSearchParams();
        searchParams.append("paginate", "12");
        searchParams.append("page", page);
        searchParams.append("estado", "1");
        
        // Agregar filtros (usando los parámetros correctos de la API)
        if (searchTerm) {
            searchParams.append("producto", searchTerm); // Buscar por nombre (LIKE)
        }
        if (selectedCategory) {
            searchParams.append("id_categoria", selectedCategory); // Filtrar por ID de categoría
        }
        
        // Agregar ordenamiento
        switch(sortBy) {
            case "name":
                searchParams.append("sort", "producto");
                searchParams.append("order", "asc");
                break;
            case "price_low":
                searchParams.append("sort", "precio");
                searchParams.append("order", "asc");
                break;
            case "price_high":
                searchParams.append("sort", "precio");
                searchParams.append("order", "desc");
                break;
            default:
                searchParams.append("sort", "created_at");
                searchParams.append("order", "desc");
                break;
        }
        
        // Hacer petición a la API
        fetch(apiBaseUrl + "/api-key/products?" + searchParams.toString(), {
            method: "GET",
            headers: {
                "X-API-Key": apiKey,
                "Accept": "application/json",
                "Content-Type": "application/json"
            }
        })
        .then(response => response.json())
        .then(data => {
            let products = [];
            
            if (data && data.data && Array.isArray(data.data)) {
                products = data.data;
            } else if (data && data.data && typeof data.data === "object") {
                products = Object.values(data.data);
            }
            
            // Verificar si hay más productos
            hasMoreProducts = products.length >= 12;
            
            if (products.length > 0) {
                // Agregar productos a los existentes
                allProducts = allProducts.concat(products);
                
                const container = document.querySelector("#products-container") || 
                                document.querySelector("[data-dynamic-products=\"true\"] .grid") ||
                                document.querySelector(".products-list .grid");
                
                if (container) {
                    renderRealProducts(container, allProducts, false);
                }
            }
            
            isLoading = false;
        })
        .catch(error => {
            console.error("❌ Error al cargar más productos:", error);
            isLoading = false;
        });
    }
    
    
    // Función para agregar buscador de productos
    function addProductSearch(container) {
        // Buscar si ya existe un buscador
        const existingSearch = container.parentElement.querySelector(".product-search-container");
        if (existingSearch) {
            return; // Ya existe
        }
        
        // Crear buscador
        const searchContainer = document.createElement("div");
        searchContainer.className = "product-search-container mb-6 col-span-full";
        searchContainer.innerHTML = `
            <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                <div class="flex-1 max-w-md">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" id="product-search-input" placeholder="Buscar productos..." 
                               class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
                <div class="flex gap-2">
                    <select id="category-filter" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Todas las categorías</option>
                    </select>
                    <select id="sort-filter" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                        <option value="recent">Más recientes</option>
                        <option value="name">Nombre A-Z</option>
                        <option value="price_low">Precio: Menor a Mayor</option>
                        <option value="price_high">Precio: Mayor a Menor</option>
                    </select>
                    <button id="search-btn" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Buscar
                    </button>
                </div>
            </div>
        `;
        
        // Insertar el buscador antes del contenedor de productos
        container.parentElement.insertBefore(searchContainer, container);
        
        // Configurar event listeners del buscador
        setupSearchListeners();
        
        // Cargar categorías para el filtro
        loadCategoriesForFilter();
    }
    
    // Función para configurar los listeners del buscador
    function setupSearchListeners() {
        const searchInput = document.getElementById("product-search-input");
        const searchBtn = document.getElementById("search-btn");
        const categoryFilter = document.getElementById("category-filter");
        const sortFilter = document.getElementById("sort-filter");
        
        // Buscar solo cuando se hace clic en el botón
        if (searchBtn) {
            searchBtn.addEventListener("click", filterProducts);
        }
        
        // También permitir buscar con Enter en el input
        if (searchInput) {
            searchInput.addEventListener("keypress", function(e) {
                if (e.key === "Enter") {
                    filterProducts();
                }
            });
        }
        
        // Los filtros de categoría y ordenamiento ya no activan automáticamente la búsqueda
        // Solo se aplican cuando se hace clic en "Buscar"
    }
    
    // Función para cargar categorías para el filtro
    function loadCategoriesForFilter() {
        const apiKey = "{{ addslashes($apiKey) }}";
        const apiBaseUrl = "{{ addslashes($apiBaseUrl) }}";
        const categoryFilter = document.getElementById("category-filter");
        
        if (!apiKey || !apiBaseUrl || !categoryFilter) return;
        
        fetch(apiBaseUrl + "/api-key/categories", {
            method: "GET",
            headers: {
                "X-API-Key": apiKey,
                "Accept": "application/json",
                "Content-Type": "application/json"
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data && data.data) {
                const categories = Array.isArray(data.data) ? data.data : Object.values(data.data);
                categories.forEach(category => {
                    const option = document.createElement("option");
                    option.value = category.id || category.categoria;
                    option.textContent = category.categoria || category.name;
                    categoryFilter.appendChild(option);
                });
            }
        })
        .catch(error => {
            console.log("⚠️ No se pudieron cargar las categorías:", error);
        });
    }
    
    // Función para filtrar productos consultando la API
    function filterProducts() {
        const searchTerm = document.getElementById("product-search-input")?.value || "";
        const selectedCategory = document.getElementById("category-filter")?.value || "";
        const sortBy = document.getElementById("sort-filter")?.value || "recent";
        
        console.log("🔍 Buscando productos en la API:", { searchTerm, selectedCategory, sortBy });
        
        // Obtener credenciales de la API
        const apiKey = "{{ addslashes($apiKey) }}";
        const apiBaseUrl = "{{ addslashes($apiBaseUrl) }}";
        
        if (!apiKey || !apiBaseUrl) {
            console.log("⚠️ No hay credenciales de API para buscar");
            return;
        }
        
        // Construir parámetros de búsqueda
        let searchParams = new URLSearchParams();
        searchParams.append("paginate", "12"); // Cargar más productos en la búsqueda
        searchParams.append("estado", "1");
        
        // Agregar término de búsqueda si existe (usando los parámetros correctos de la API)
        if (searchTerm) {
            searchParams.append("producto", searchTerm); // Buscar por nombre (LIKE)
        }
        
        // Agregar filtro de categoría si existe
        if (selectedCategory) {
            searchParams.append("id_categoria", selectedCategory); // Filtrar por ID de categoría
        }
        
        // Agregar ordenamiento
        switch(sortBy) {
            case "name":
                searchParams.append("sort", "producto");
                searchParams.append("order", "asc");
                break;
            case "price_low":
                searchParams.append("sort", "precio");
                searchParams.append("order", "asc");
                break;
            case "price_high":
                searchParams.append("sort", "precio");
                searchParams.append("order", "desc");
                break;
            default: // recent
                searchParams.append("sort", "created_at");
                searchParams.append("order", "desc");
                break;
        }
        
        // Mostrar loading
        const container = document.querySelector("#products-container") || 
                        document.querySelector("[data-dynamic-products=\"true\"] .grid") ||
                        document.querySelector(".products-list .grid");
        
        if (container) {
            container.innerHTML = `
                <div class="flex items-center justify-center py-12 col-span-full">
                    <div class="text-center">
                        <div class="w-12 h-12 mx-auto mb-4 border-b-2 border-blue-600 rounded-full animate-spin"></div>
                        <p class="text-gray-600">Buscando productos...</p>
                    </div>
                </div>
            `;
        }
        
        // Hacer petición a la API con filtros
        fetch(apiBaseUrl + "/api-key/products?" + searchParams.toString(), {
            method: "GET",
            headers: {
                "X-API-Key": apiKey,
                "Accept": "application/json",
                "Content-Type": "application/json"
            }
        })
        .then(response => {
            console.log("📡 Respuesta de búsqueda:", response.status);
            if (!response.ok) {
                throw new Error("Error en la respuesta de la API: " + response.status);
            }
            return response.json();
        })
        .then(data => {
            console.log("📦 Resultados de búsqueda:", data);
            
            // La API devuelve data como array, pero verificar por si acaso
            let products = [];
            
            if (data && data.data && Array.isArray(data.data)) {
                products = data.data;
            } else if (data && data.data && typeof data.data === "object") {
                // Fallback: convertir objeto con claves numéricas a array
                products = Object.values(data.data);
            }
            
            console.log("✅ Productos encontrados:", products.length);
            
            // Actualizar variables globales
            allProducts = products;
            currentPage = 1;
            hasMoreProducts = products.length >= 12; // Si hay menos de 12, no hay más páginas
            
            if (products.length > 0) {
                // Renderizar productos encontrados
                if (container) {
                    renderRealProducts(container, products, false);
                }
                
                // Configurar scroll infinito para búsquedas
                if (hasMoreProducts) {
                    setupInfiniteScroll();
                }
            } else {
                // No se encontraron productos
                if (container) {
                    container.innerHTML = `
                        <div class="flex items-center justify-center py-12 col-span-full">
                            <div class="text-center">
                                <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <h3 class="mb-2 text-lg font-medium text-gray-900">No se encontraron productos</h3>
                                <p class="text-gray-600">Intenta con otros términos de búsqueda o filtros.</p>
                            </div>
                        </div>
                    `;
                }
            }
        })
        .catch(error => {
            console.error("❌ Error al buscar productos:", error);
            if (container) {
                container.innerHTML = `
                    <div class="flex items-center justify-center py-12 col-span-full">
                        <div class="text-center">
                            <svg class="w-16 h-16 mx-auto mb-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="mb-2 text-lg font-medium text-gray-900">Error en la búsqueda</h3>
                            <p class="text-gray-600">No se pudo conectar con el servidor. Intenta nuevamente.</p>
                        </div>
                    </div>
                `;
            }
        });
    }

    // Función para mostrar productos de ejemplo cuando no hay API configurada
    function showEnhancedExampleProducts(container) {
        console.log("🎨 Mostrando productos de ejemplo...");
        
        const exampleProducts = [
            {
                title: "Producto Premium 1",
                description: "Este es un producto de ejemplo. Configure su API externa para ver productos reales.",
                price: "99.99",
                category: "Categoría A"
            },
            {
                title: "Producto Premium 2", 
                description: "Los productos reales se cargarán automáticamente cuando configure las credenciales de API.",
                price: "149.99",
                category: "Categoría B"
            },
            {
                title: "Producto Premium 3",
                description: "La funcionalidad de carrito de compras está completamente integrada.",
                price: "199.99",
                category: "Categoría C"
            }
        ];

        const productsHtml = exampleProducts.map(product => `
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                <div class="flex items-center justify-center w-full h-48 mb-4 bg-gray-200 rounded-lg">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="mb-2 text-lg font-semibold text-gray-900">${product.title}</h3>
                <span class="inline-block px-2 py-1 mb-2 text-xs text-blue-800 bg-blue-100 rounded-full">${product.category}</span>
                <p class="mb-4 text-sm text-gray-600">${product.description}</p>
                <div class="flex items-center justify-between">
                    <span class="text-lg font-bold text-green-600">$${product.price}</span>
                    <button class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                        Ver Producto
                    </button>
                </div>
            </div>
        `).join("");

        container.innerHTML = productsHtml;
        
        console.log("✅ Productos de ejemplo renderizados");
    }
    
    // Variable para evitar clicks duplicados
    let lastQuantityClickTime = 0;
    
    // Event listeners para los controles de cantidad en las tarjetas de productos
    document.addEventListener("click", function(e) {
        // Aumentar cantidad
        if (e.target.closest(".cart-increase")) {
            e.preventDefault();
            e.stopImmediatePropagation();
            
            // Evitar clicks duplicados (debounce de 200ms)
            const now = Date.now();
            if (now - lastQuantityClickTime < 200) {
                return;
            }
            lastQuantityClickTime = now;
            
            const btn = e.target.closest(".cart-increase");
            const productId = btn.getAttribute("data-id");
            updateProductQuantityInCart(productId, 1);
        }
        
        // Disminuir cantidad
        if (e.target.closest(".cart-decrease")) {
            e.preventDefault();
            e.stopImmediatePropagation();
            
            // Evitar clicks duplicados (debounce de 200ms)
            const now = Date.now();
            if (now - lastQuantityClickTime < 200) {
                return;
            }
            lastQuantityClickTime = now;
            
            const btn = e.target.closest(".cart-decrease");
            const productId = btn.getAttribute("data-id");
            updateProductQuantityInCart(productId, -1);
        }
    });
    
    // Función para actualizar la cantidad de un producto en el carrito
    function updateProductQuantityInCart(productId, change) {
        let cart = JSON.parse(localStorage.getItem("cart")) || [];
        const itemIndex = cart.findIndex(item => item.id == productId);
        
        if (itemIndex !== -1) {
            cart[itemIndex].quantity += change;
            
            // Si la cantidad llega a 0, remover del carrito
            if (cart[itemIndex].quantity <= 0) {
                cart.splice(itemIndex, 1);
            }
            
            // Guardar en localStorage
            localStorage.setItem("cart", JSON.stringify(cart));
            
            // Actualizar la UI del producto
            updateProductCardUI(productId, cart);
            
            // Disparar evento para que el carrito se actualice
            window.dispatchEvent(new Event("cartUpdated"));
        }
    }
    
    // Función para actualizar la UI de la tarjeta del producto
    function updateProductCardUI(productId, cart) {
        const cartItem = cart.find(item => item.id == productId);
        
        // Buscar el elemento de cantidad en la tarjeta
        const quantityElement = document.querySelector(`.cart-quantity[data-id="${productId}"]`);
        const controlElement = document.querySelector(`[data-product-cart-control="${productId}"]`);
        
        if (cartItem && quantityElement) {
            // Actualizar la cantidad mostrada
            quantityElement.textContent = cartItem.quantity;
        } else if (!cartItem && controlElement) {
            // El producto fue removido del carrito, cambiar a botón "Agregar"
            // Necesitamos obtener los datos del producto para crear el botón
            const decreaseBtn = controlElement.querySelector(".cart-decrease");
            const productData = {
                id: decreaseBtn.getAttribute("data-id")
            };
            
            // Buscar el contenedor del producto para obtener más datos
            const productCard = controlElement.closest(".p-6");
            if (productCard) {
                const title = productCard.querySelector("h3")?.textContent || "";
                const price = productCard.querySelector(".text-green-600")?.textContent.replace("$", "") || "0";
                
                controlElement.outerHTML = `
                    <button class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 add-to-cart" 
                            data-id="${productData.id}" 
                            data-name="${title}" 
                            data-price="${price}">
                        Agregar al Carrito
                    </button>
                `;
            }
        }
    }
    
    // Escuchar cambios en el carrito desde otros componentes (carrito sidebar)
    window.addEventListener("cartUpdated", function() {
        console.log("🔄 Evento cartUpdated recibido, actualizando tarjetas de productos...");
        
        // Actualizar todas las tarjetas de productos visibles
        const cart = JSON.parse(localStorage.getItem("cart")) || [];
        console.log("📦 Carrito actual:", cart);
        
        // Llamar a la función de actualización completa
        updateAllProductCardsFromCart();
        
        // Actualizar contador del carrito si existe
        const cartCounter = document.querySelector("#cart-counter");
        if (cartCounter) {
            const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
            cartCounter.textContent = totalItems;
        }
        
        // Actualizar total del carrito si existe
        const cartTotal = document.querySelector("#cart-total");
        if (cartTotal) {
            const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            cartTotal.textContent = `$${total.toFixed(2)}`;
        }
    });
    
    // Cargar productos después de un breve delay
    setTimeout(() => {
        loadRealProductsInPreview();
    }, 500);
});
</script>

