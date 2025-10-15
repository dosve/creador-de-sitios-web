<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Virtual - Prueba</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .container { max-width: 1200px; margin: 0 auto; }
        .transition-colors { transition: color 0.2s, background-color 0.2s; }
        .transition-shadow { transition: box-shadow 0.2s; }
        .hover\:shadow-md:hover { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        .hover\:bg-gray-100:hover { background-color: #f3f4f6; }
        .hover\:bg-blue-700:hover { background-color: #1d4ed8; }
        .hover\:text-gray-900:hover { color: #111827; }
        .hover\:text-white:hover { color: #ffffff; }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="bg-white border-b shadow-sm">
        <div class="container px-4 py-4 mx-auto">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <h1 class="text-2xl font-bold text-gray-900">Mi Tienda</h1>
                    <nav class="hidden space-x-6 md:flex">
                        <a href="#" class="text-gray-600 hover:text-gray-900">Inicio</a>
                        <a href="#" class="text-gray-600 hover:text-gray-900">Productos</a>
                        <a href="#" class="text-gray-600 hover:text-gray-900">Categorías</a>
                        <a href="#" class="text-gray-600 hover:text-gray-900">Contacto</a>
                    </nav>
                </div>
                <div class="flex items-center space-x-4">
                    <button id="cart-button" class="relative p-2 text-gray-800 hover:text-gray-900">
                        <svg class="w-6 h-6" fill="#374151" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M1.566 4a.75.75 0 0 1 .75-.75h1.181a2.25 2.25 0 0 1 2.228 1.937l.061.435h13.965a2.25 2.25 0 0 1 2.063 3.148l-2.668 6.128a2.25 2.25 0 0 1-2.063 1.352H7.722a2.25 2.25 0 0 1-2.228-1.937L4.24 5.396a.75.75 0 0 0-.743-.646h-1.18a.75.75 0 0 1-.75-.75m4.431 3.122l.982 6.982a.75.75 0 0 0 .743.646h9.361a.75.75 0 0 0 .688-.45l2.667-6.13a.75.75 0 0 0-.687-1.048z" clip-rule="evenodd"/>
                            <path d="M6.034 19.5a1.75 1.75 0 1 1 3.5 0a1.75 1.75 0 0 1-3.5 0m10.286-1.75a1.75 1.75 0 1 0 0 3.5a1.75 1.75 0 0 0 0-3.5"/>
                        </svg>
                        <span id="cart-counter" class="absolute flex items-center justify-center w-5 h-5 text-xs text-white bg-red-500 rounded-full -top-1 -right-1">0</span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="py-16 text-white bg-gradient-to-r from-blue-600 to-purple-600">
        <div class="container px-4 mx-auto text-center">
            <h2 class="mb-4 text-4xl font-bold">Bienvenido a Nuestra Tienda</h2>
            <p class="mb-8 text-xl">Descubre productos increíbles a precios increíbles</p>
            <button class="px-8 py-3 font-semibold text-blue-600 transition-colors bg-white rounded-lg hover:bg-gray-100">Ver Productos</button>
        </div>
    </section>

    <!-- Products Section -->
    <section class="py-16 bg-gray-50 products-list" data-products-source="api" data-dynamic-products="true">
        <div class="container px-4 mx-auto">
            <h2 class="mb-12 text-3xl font-bold text-center text-gray-900">Nuestros Productos</h2>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3" id="products-container">
                <!-- Los productos se cargarán dinámicamente aquí -->
                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="flex items-center justify-center w-full h-48 mb-4 bg-gray-200 rounded-lg">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="mb-2 text-lg font-semibold text-gray-900">Producto de Ejemplo 1</h3>
                    <p class="mb-4 text-sm text-gray-600">Los productos reales se mostrarán en la vista previa</p>
                    <div class="flex items-center justify-between">
                        <span class="text-lg font-bold text-green-600">$99.99</span>
                        <button class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 add-to-cart" data-name="Producto de Ejemplo 1" data-price="99.99">
                            Agregar al Carrito
                        </button>
                    </div>
                </div>
                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="flex items-center justify-center w-full h-48 mb-4 bg-gray-200 rounded-lg">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="mb-2 text-lg font-semibold text-gray-900">Producto de Ejemplo 2</h3>
                    <p class="mb-4 text-sm text-gray-600">Los productos reales se mostrarán en la vista previa</p>
                    <div class="flex items-center justify-between">
                        <span class="text-lg font-bold text-green-600">$149.99</span>
                        <button class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 add-to-cart" data-name="Producto de Ejemplo 2" data-price="149.99">
                            Agregar al Carrito
                        </button>
                    </div>
                </div>
                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="flex items-center justify-center w-full h-48 mb-4 bg-gray-200 rounded-lg">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="mb-2 text-lg font-semibold text-gray-900">Producto de Ejemplo 3</h3>
                    <p class="mb-4 text-sm text-gray-600">Los productos reales se mostrarán en la vista previa</p>
                    <div class="flex items-center justify-between">
                        <span class="text-lg font-bold text-green-600">$199.99</span>
                        <button class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 add-to-cart" data-name="Producto de Ejemplo 3" data-price="199.99">
                            Agregar al Carrito
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 text-white bg-gray-900">
        <div class="container px-4 mx-auto">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                <div>
                    <h5 class="mb-4 text-xl font-semibold">Mi Tienda</h5>
                    <p class="text-gray-400">Tu tienda online de confianza</p>
                </div>
                <div>
                    <h5 class="mb-4 text-xl font-semibold">Enlaces</h5>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Inicio</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Productos</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Contacto</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="mb-4 text-xl font-semibold">Contacto</h5>
                    <p class="text-gray-400">Email: info@mitienda.com</p>
                    <p class="text-gray-400">Teléfono: +1 234 567 890</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Sidebar del Carrito -->
    <div id="cart-sidebar" class="fixed inset-y-0 right-0 z-50 transition-transform duration-300 ease-in-out transform translate-x-full bg-white shadow-xl w-96">
        <div class="flex flex-col h-full">
            <!-- Header del carrito -->
            <div class="flex items-center justify-between p-4 border-b bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">Carrito de Compras</h3>
                <button id="close-cart" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Contenido del carrito -->
            <div class="flex-1 p-4 overflow-y-auto">
                <div id="cart-items" class="space-y-4">
                    <!-- Los productos se agregarán aquí dinámicamente -->
                    <div class="py-8 text-center text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" width="128" height="128" viewBox="0 0 24 24"><path fill="#000000" fill-rule="evenodd" d="M1.566 4a.75.75 0 0 1 .75-.75h1.181a2.25 2.25 0 0 1 2.228 1.937l.061.435h13.965a2.25 2.25 0 0 1 2.063 3.148l-2.668 6.128a2.25 2.25 0 0 1-2.063 1.352H7.722a2.25 2.25 0 0 1-2.228-1.937L4.24 5.396a.75.75 0 0 0-.743-.646h-1.18a.75.75 0 0 1-.75-.75m4.431 3.122l.982 6.982a.75.75 0 0 0 .743.646h9.361a.75.75 0 0 0 .688-.45l2.667-6.13a.75.75 0 0 0-.687-1.048z" clip-rule="evenodd"/><path fill="#000000" d="M6.034 19.5a1.75 1.75 0 1 1 3.5 0a1.75 1.75 0 0 1-3.5 0m10.286-1.75a1.75 1.75 0 1 0 0 3.5a1.75 1.75 0 0 0 0-3.5"/></svg>
                        <p>Tu carrito está vacío</p>
                    </div>
                </div>
            </div>
            
            <!-- Footer del carrito -->
            <div class="p-4 border-t bg-gray-50">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-lg font-semibold">Total:</span>
                    <span id="cart-total" class="text-xl font-bold text-green-600">$0.00</span>
                </div>
                <button id="checkout-btn" class="w-full py-3 font-semibold text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700 disabled:bg-gray-300 disabled:cursor-not-allowed" disabled>
                    Proceder al Pago
                </button>
            </div>
        </div>
    </div>
    
    <!-- Overlay del carrito -->
    <div id="cart-overlay" class="fixed inset-0 z-40 hidden bg-black bg-opacity-50"></div>
    
    <!-- Scripts -->
    <script type="text/javascript" src="https://checkout.epayco.co/checkout.js"></script>
    
    <!-- JavaScript del carrito -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const cartButton = document.getElementById("cart-button");
            const cartSidebar = document.getElementById("cart-sidebar");
            const cartOverlay = document.getElementById("cart-overlay");
            const closeCartBtn = document.getElementById("close-cart");
            const cartItems = document.getElementById("cart-items");
            const cartTotal = document.getElementById("cart-total");
            const checkoutBtn = document.getElementById("checkout-btn");
            const addToCartButtons = document.querySelectorAll(".add-to-cart");
            const cartCounter = document.getElementById("cart-counter");

            const to2 = n => (Math.round(n * 100) / 100);
            
            let cart = [];

            function applyDiscountGross(gross, pct = 0) {
                return gross * (1 - (pct / 100));
            }

            function lineAmounts(it) {
                const ivaRate = (parseFloat(it.iva) || 0) / 100; // 0, .05, .19
                const unitGross = applyDiscountGross(parseFloat(it.price || 0), parseFloat(it.discountPct || 0)); // bruto final
                const unitBase  = ivaRate > 0 ? unitGross / (1 + ivaRate) : unitGross;
                const unitIva   = unitGross - unitBase;
                return {
                unitGross: to2(unitGross),
                unitBase:  to2(unitBase),
                unitIva:   to2(unitIva),
                ivaRate
                };
            }

              function computeTotals(cart) {
                let gross = 0, base = 0, iva = 0, ico = 0;
                for (const it of cart) {
                    const { unitGross, unitBase, unitIva } = lineAmounts(it);
                    const qty = parseInt(it.quantity || 1, 10);
                    gross += unitGross * qty;
                    base  += unitBase  * qty;
                    iva   += unitIva   * qty;
                }
                return {
                    gross: to2(gross),
                    taxBase: to2(base),
                    tax: to2(iva),
                    taxIco: to2(ico)
                };
            }
            
            // Abrir carrito
            function openCart() {
                cartSidebar.classList.remove("translate-x-full");
                cartOverlay.classList.remove("hidden");
                document.body.style.overflow = "hidden";
            }
            
            // Cerrar carrito
            function closeCart() {
                cartSidebar.classList.add("translate-x-full");
                cartOverlay.classList.add("hidden");
                document.body.style.overflow = "auto";
            }
            
            // Actualizar contador del carrito
            function updateCartCounter() {
                const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
                cartCounter.textContent = totalItems;
            }
            
            // Actualizar total del carrito
            function updateCartTotal() {
                const totals = computeTotals(cart);
                cartTotal.textContent = `$${totals.gross.toFixed(2)}`;
                checkoutBtn.disabled = cart.length === 0;
            }

            function checkout () {
                const epaycoPublicKey = window.epaycoPublicKey || "";
                const epaycoPrivateKey = window.epaycoPrivateKey || "";
                const epaycoCustomerId = window.epaycoCustomerId || "";

                if (epaycoPublicKey && epaycoPrivateKey && cart.length > 0) {

                    const { gross, taxBase, tax, taxIco } = computeTotals(cart);
                    
                    const invoice = "ORD-" + Date.now();

                    const name = cart.length > 1
                        ? `${cart[0].name} + ${cart.length - 1} más`
                        : cart[0].name;
                        const description = cart.map(i => `${i.quantity}x ${i.name}`).join(" | ").slice(0, 120);

                        
                    const extra1 = JSON.stringify(
                        cart.map(i => {
                            const a = lineAmounts(i);
                            return {
                            id: i.id || null,
                            name: i.name,
                            qty: i.quantity,
                            unitGross: a.unitGross,
                            ivaRate: a.ivaRate
                            };
                        })
                    ).slice(0, 250);

                    const handler = ePayco.checkout.configure({
                        key: window.epaycoPublicKey,
                        test: true
                    });

                    const data = {
                        name,
                        description,
                        invoice,
                        currency: "cop",
                        amount: gross.toFixed(2),
                        tax_base: taxBase.toFixed(2),
                        tax: tax.toFixed(2),
                        tax_ico: taxIco.toFixed(2),
                        country: "co",
                        lang: "es",

                        external: "false",

                        extra1,
                        extra2: "carrito-web",
                        extra3: "canal-online",

                        response: "http://127.0.0.1:8000/response",

                        name_billing: "Jhon Doe",
                        address_billing: "Carrera 19 numero 14 91",
                        type_doc_billing: "cc",
                        mobilephone_billing: "3050000000",
                        number_doc_billing: "100000000",
                        email_billing: "jhondoe@epayco.com"
                    }
                    handler.open(data);
                } else {
                    // No se encontraron credenciales de ePayco
                }
            }
            
            // Renderizar items del carrito
            function renderCartItems() {
                if (cart.length === 0) {
                    cartItems.innerHTML = `
                        <div class="py-8 text-center text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mx-auto mb-4 text-gray-300" viewBox="0 0 24 24"><path fill="#000000" fill-rule="evenodd" d="M1.566 4a.75.75 0 0 1 .75-.75h1.181a2.25 2.25 0 0 1 2.228 1.937l.061.435h13.965a2.25 2.25 0 0 1 2.063 3.148l-2.668 6.128a2.25 2.25 0 0 1-2.063 1.352H7.722a2.25 2.25 0 0 1-2.228-1.937L4.24 5.396a.75.75 0 0 0-.743-.646h-1.18a.75.75 0 0 1-.75-.75m4.431 3.122l.982 6.982a.75.75 0 0 0 .743.646h9.361a.75.75 0 0 0 .688-.45l2.667-6.13a.75.75 0 0 0-.687-1.048z" clip-rule="evenodd"/><path fill="currentColor" d="M6.034 19.5a1.75 1.75 0 1 1 3.5 0a1.75 1.75 0 0 1-3.5 0m10.286-1.75a1.75 1.75 0 1 0 0 3.5a1.75 1.75 0 0 0 0-3.5"/></svg>
                            <p>Tu carrito está vacío</p>
                        </div>
                    `;
                    return;
                }
                
                cartItems.innerHTML = cart.map((item, index) => `
                    <div class="flex items-center p-3 space-x-3 rounded-lg bg-gray-50">
                        <div class="flex items-center justify-center w-16 h-16 bg-gray-200 rounded">
                            <span class="text-xs text-gray-500">IMG</span>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-900">${item.name}</h4>
                            <p class="text-sm text-gray-600">$${item.price.toFixed(2)}</p>
                            <div class="mt-1 text-xs text-gray-500">
                                <div>ID: ${item.id || "N/A"}</div>
                                <div>IVA: ${item.iva || "0"}%</div>
                                <div>Stock: ${item.existencia || "0"}</div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button onclick="updateQuantity(${index}, -1)" class="flex items-center justify-center w-8 h-8 bg-gray-200 rounded-full hover:bg-gray-300">-</button>
                            <span class="w-8 text-center">${item.quantity}</span>
                            <button onclick="updateQuantity(${index}, 1)" class="flex items-center justify-center w-8 h-8 bg-gray-200 rounded-full hover:bg-gray-300">+</button>
                        </div>
                        <button onclick="removeFromCart(${index})" class="text-red-500 hover:text-red-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                `).join("");
            }
            
            // Agregar al carrito
            function addToCart(productData) {
                const existingItem = cart.find(item => item.id === productData.id);
                if (existingItem) {
                    existingItem.quantity += 1;
                } else {
                    cart.push({
                        id: productData.id,
                        name: productData.name,
                        price: parseFloat(productData.price),
                        descripcion: productData.descripcion,
                        existencia: parseInt(productData.existencia || 0,10),
                        iva: parseFloat(productData.iva),
                        discountPct: 0,
                        quantity: 1
                    });
                }
                updateCartCounter();
                updateCartTotal();
                renderCartItems();
            }
            
            // Actualizar cantidad
            window.updateQuantity = function(index, change) {
                cart[index].quantity += change;
                if (cart[index].quantity <= 0) {
                    cart.splice(index, 1);
                }
                updateCartCounter();
                updateCartTotal();
                renderCartItems();
            };
            
            // Remover del carrito
            window.removeFromCart = function(index) {
                cart.splice(index, 1);
                updateCartCounter();
                updateCartTotal();
                renderCartItems();
            };
            
            // Event listeners
            cartButton.addEventListener("click", openCart);
            closeCartBtn.addEventListener("click", closeCart);
            cartOverlay.addEventListener("click", closeCart);
            checkoutBtn.addEventListener("click", checkout);

            // Agregar productos al carrito
            addToCartButtons.forEach((button) => {
                button.addEventListener("click", function() {
                    const productData = {
                        id: this.getAttribute("data-id"),
                        name: this.getAttribute("data-name"),
                        price: parseFloat(this.getAttribute("data-price")),
                        descripcion: this.getAttribute("data-descripcion"),
                        existencia: this.getAttribute("data-existencia"),
                        iva: this.getAttribute("data-iva")
                    };
                    addToCart(productData);
                });
            });
            
            // Función para recargar los event listeners cuando se carguen productos dinámicamente
            window.reloadCartListeners = function() {
                const newAddToCartButtons = document.querySelectorAll(".add-to-cart");
                newAddToCartButtons.forEach((button) => {
                    button.addEventListener("click", function() {
                        const productData = {
                            id: this.getAttribute("data-id"),
                            name: this.getAttribute("data-name"),
                            price: parseFloat(this.getAttribute("data-price")),
                            descripcion: this.getAttribute("data-descripcion"),
                            existencia: this.getAttribute("data-existencia"),
                            iva: this.getAttribute("data-iva")
                        };
                        addToCart(productData);
                    });
                });
            };
            
            // Inicializar
            updateCartCounter();
            updateCartTotal();
            renderCartItems();
        });
        
        // Script para cargar productos reales dinamicamente
        document.addEventListener("DOMContentLoaded", function() {
            function loadRealProducts() {
                let productsContainers = document.querySelectorAll("#products-container");
                if (productsContainers.length === 0) {
                    productsContainers = document.querySelectorAll("[data-dynamic-products=true] .grid");
                }
                if (productsContainers.length === 0) {
                    productsContainers = document.querySelectorAll(".products-list .grid");
                }
                
                if (productsContainers.length === 0) {
                    return;
                }
                
                productsContainers.forEach((container, index) => {
                    // Mostrar loading
                    container.innerHTML = "<div class=\"flex items-center justify-center py-12 col-span-full\"><div class=\"text-center\"><div class=\"w-12 h-12 mx-auto mb-4 border-b-2 border-blue-600 rounded-full animate-spin\"></div><p class=\"text-gray-600\">Cargando productos...</p></div></div>";

                    // Hacer peticion real a la API del servidor externo
                    const apiKey = window.websiteApiKey || "";
                    const apiBaseUrl = window.websiteApiUrl || "";

                    if (apiKey && apiBaseUrl) {
                        
                        fetch(apiBaseUrl + "/api-key/products?paginate=6&estado=1", {
                            method: "GET",
                            headers: {
                                "X-API-Key": apiKey,
                                "Accept": "application/json",
                                "Content-Type": "application/json"
                            }
                        })
                        .then(response => {
                            return response.json();
                        })
                        .then(data => {
                            // La API devuelve data como array, pero verificar por si acaso
                            let products = [];
                            
                            if (data && data.data && Array.isArray(data.data)) {
                                products = data.data;
                            } else if (data && data.data && typeof data.data === "object") {
                                // Fallback: convertir objeto con claves numéricas a array
                                products = Object.values(data.data);
                            }
                            
                            if (products.length > 0) {
                                renderRealProducts(container, products);
                            }
                        })
                        .catch(error => {
                            // Error al conectar con el servidor externo
                        });
                    }
                });
            }
            
            function renderRealProducts(container, products) {
                let productsHtml = "";
                products.forEach(product => {
                    const title = product.producto || "Producto sin nombre";
                    const description = product.descripcion || "Sin descripcion";
                    const price = product.precio || "0.00";
                    const image = product.img || null;
                    const category = product.categoria ? product.categoria.categoria : null;
                    const iva = product.iva || "0";
                    
                    let imageHtml = "<div class=\"flex items-center justify-center w-full h-48 mb-4 bg-gray-200 rounded-lg\"><svg class=\"w-12 h-12 text-gray-400\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\"></path></svg></div>";

                    if (false) {
                        imageHtml = "<div class=\"mb-4 aspect-w-16 aspect-h-9\"><img src=\"" + image + "\" alt=\"" + title + "\" class=\"object-cover w-full h-48 rounded-lg\"></div>";
                    } else {
                        imageHtml = "<div class=\"flex items-center justify-center w-full h-48 mb-4 bg-gray-200 rounded-lg\"><svg class=\"w-12 h-12 text-gray-400\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\"></path></svg></div>";
                    }
                    
                    let categoryHtml = "";
                    if (category) {
                        categoryHtml = "<span class=\"inline-block px-2 py-1 mb-2 text-xs text-blue-800 bg-blue-100 rounded-full\">" + category + "</span>";
                    }
                    
                    productsHtml += "<div class=\"p-6 bg-white border border-gray-200 rounded-lg shadow-sm\">" + imageHtml + "<h3 class=\"mb-2 text-lg font-semibold text-gray-900\">" + title + "</h3>" + categoryHtml + "<p class=\"mb-4 text-sm text-gray-600 line-clamp-2\">" + description + "</p><div class=\"flex items-center justify-between\"><span class=\"text-lg font-bold text-green-600\">$" + price + "</span><button class=\"px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 add-to-cart\" data-id=\"" + (product.id || "") + "\" data-name=\"" + title + "\" data-price=\"" + price + "\" data-descripcion=\"" + (product.descripcion || "") + "\" data-existencia=\"" + (product.existencia || "") + "\" data-iva=\"" + (iva || "") + "\">Agregar al Carrito</button></div></div>";
                });

                container.innerHTML = productsHtml;
                
                // Recargar los event listeners del carrito
                if (typeof window.reloadCartListeners === "function") {
                    window.reloadCartListeners();
                }
            }
            
            // Cargar productos despues de un breve delay
            setTimeout(function() {
                loadRealProducts();
            }, 500);
        });
    </script>
</body>
</html>
