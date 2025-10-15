{{--
    Componente para el carrito de compras integrado
    
    Este componente incluye:
    - Sidebar deslizante del carrito
    - Funcionalidades de agregar/quitar productos
    - Cálculos automáticos de totales
    - Integración con botones "Agregar al Carrito"
--}}
@props(['epaycoPublicKey' => '', 'epaycoPrivateKey' => '', 'epaycoCustomerId' => ''])

<script>
        document.addEventListener("DOMContentLoaded", function() {
            console.log("🛒 Inicializando carrito de compras...");
            
            // Filtrar logs de errores irrelevantes
            const originalConsoleError = console.error;
            const originalConsoleWarn = console.warn;
            const originalConsoleLog = console.log;
            
            console.error = function(...args) {
                const message = args.join(' ');
                // Filtrar errores irrelevantes
                if (message.includes('Client Token is not configured') || 
                    message.includes('Permissions policy violation')) {
                    return;
                }
                originalConsoleError.apply(console, args);
            };
            
            console.warn = function(...args) {
                const message = args.join(' ');
                // Filtrar warnings irrelevantes
                if (message.includes('Permissions policy violation')) {
                    return;
                }
                originalConsoleWarn.apply(console, args);
            };
    
    // Variables globales del carrito - cargar desde localStorage
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    
    // Limpiar carrito existente para que se agregue con la nueva estructura (con imageUrl)
    if (cart.length > 0 && !cart[0].hasOwnProperty('imageUrl')) {
        console.log("🧹 Limpiando carrito existente para migrar a nueva estructura...");
        cart = [];
        localStorage.setItem("cart", JSON.stringify(cart));
    }
    
    // Elementos del DOM
    const cartButton = document.querySelector("#cart-button");
    const cartCounter = document.querySelector("#cart-counter");
    const cartSidebar = document.querySelector("#cart-sidebar");
    const cartOverlay = document.querySelector("#cart-overlay");
    const closeCartBtn = document.querySelector("#close-cart");
    const cartItems = document.querySelector("#cart-items");
    const cartTotal = document.querySelector("#cart-total");
    const checkoutBtn = document.querySelector("#checkout-btn");
    
    // Si no existen los elementos, crearlos
    if (!cartSidebar) {
        createCartElements();
    }
    
    // Función para crear los elementos del carrito si no existen
    function createCartElements() {
        // Crear overlay del carrito
        if (!document.querySelector("#cart-overlay")) {
            const overlay = document.createElement("div");
            overlay.id = "cart-overlay";
            overlay.className = "fixed inset-0 bg-black bg-opacity-50 z-40 hidden";
            document.body.appendChild(overlay);
        }
        
        // Crear sidebar del carrito
        if (!document.querySelector("#cart-sidebar")) {
            const sidebar = document.createElement("div");
            sidebar.id = "cart-sidebar";
            sidebar.className = "fixed inset-y-0 right-0 z-50 transition-transform duration-300 ease-in-out transform translate-x-full bg-white shadow-xl w-96";
            sidebar.innerHTML = `
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
                    <div class="border-t bg-gray-50 p-4">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-lg font-semibold">Total:</span>
                            <span id="cart-total" class="text-xl font-bold text-green-600">$0.00</span>
                        </div>
                        <button id="checkout-btn" class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transition-colors font-semibold" disabled>
                            Proceder al Pago
                        </button>
                    </div>
                </div>
            `;
            document.body.appendChild(sidebar);
        }
        
        // Crear botón del carrito si no existe
        if (!document.querySelector("#cart-button")) {
            const cartBtn = document.createElement("button");
            cartBtn.id = "cart-button";
            cartBtn.className = "fixed top-4 right-4 z-30 bg-blue-600 text-white p-3 rounded-full shadow-lg hover:bg-blue-700 transition-colors";
            cartBtn.innerHTML = `
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <span id="cart-counter" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-6 w-6 flex items-center justify-center font-bold">0</span>
            `;
            document.body.appendChild(cartBtn);
        }
    }
    
    // Función para calcular totales
    function lineAmounts(item) {
        const unitPrice = parseFloat(item.price || 0);
        const ivaRate = parseFloat(item.iva || 0) / 100;
        const unitBase = unitPrice / (1 + ivaRate);
        const unitIva = unitPrice - unitBase;
        const unitGross = unitPrice;
        return { unitBase, unitIva, unitGross };
    }
    
    function to2(num) {
        return Math.round(num * 100) / 100;
    }
    
    function computeTotals(cart) {
        let gross = 0, base = 0, iva = 0;
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
            tax: to2(iva)
        };
    }
    
    // Abrir carrito
    function openCart() {
        const sidebar = document.querySelector("#cart-sidebar");
        const overlay = document.querySelector("#cart-overlay");
        if (sidebar && overlay) {
            sidebar.classList.remove("translate-x-full");
            overlay.classList.remove("hidden");
            document.body.style.overflow = "hidden";
        }
    }
    
    // Cerrar carrito
    function closeCart() {
        const sidebar = document.querySelector("#cart-sidebar");
        const overlay = document.querySelector("#cart-overlay");
        if (sidebar && overlay) {
            sidebar.classList.add("translate-x-full");
            overlay.classList.add("hidden");
            document.body.style.overflow = "auto";
        }
    }
    
    // Actualizar contador del carrito
    function updateCartCounter() {
        const counter = document.querySelector("#cart-counter");
        if (counter) {
            const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
            counter.textContent = totalItems;
        }
    }
    
    // Actualizar total del carrito
    function updateCartTotal() {
        const totalElement = document.querySelector("#cart-total");
        const checkoutBtn = document.querySelector("#checkout-btn");
        if (totalElement) {
            const totals = computeTotals(cart);
            totalElement.textContent = `$${totals.gross.toFixed(2)}`;
        }
        if (checkoutBtn) {
            checkoutBtn.disabled = cart.length === 0;
        }
    }
    
    // Renderizar items del carrito
    function renderCartItems() {
        const cartItemsContainer = document.querySelector("#cart-items");
        if (!cartItemsContainer) return;
        
        // Guardar en localStorage cada vez que renderizamos
        localStorage.setItem("cart", JSON.stringify(cart));
        
        if (cart.length === 0) {
            cartItemsContainer.innerHTML = `
                <div class="flex flex-col items-center justify-center py-12 text-gray-500 min-h-64">
                    <svg xmlns="http://www.w3.org/2000/svg" width="128" height="128" viewBox="0 0 24 24" class="mx-auto mb-4">
                        <path fill="currentColor" fill-rule="evenodd" d="M1.566 4a.75.75 0 0 1 .75-.75h1.181a2.25 2.25 0 0 1 2.228 1.937l.061.435h13.965a2.25 2.25 0 0 1 2.063 3.148l-2.668 6.128a2.25 2.25 0 0 1-2.063 1.352H7.722a2.25 2.25 0 0 1-2.228-1.937L4.24 5.396a.75.75 0 0 0-.743-.646h-1.18a.75.75 0 0 1-.75-.75m4.431 3.122l.982 6.982a.75.75 0 0 0 .743.646h9.361a.75.75 0 0 0 .688-.45l2.667-6.13a.75.75 0 0 0-.687-1.048z" clip-rule="evenodd"/>
                        <path fill="currentColor" d="M6.034 19.5a1.75 1.75 0 1 1 3.5 0a1.75 1.75 0 0 1-3.5 0m10.286-1.75a1.75 1.75 0 1 0 0 3.5a1.75 1.75 0 0 0 0-3.5"/>
                    </svg>
                    <p class="text-center text-lg">Tu carrito está vacío</p>
                </div>
            `;
            return;
        }
        
        cartItemsContainer.innerHTML = cart.map((item, index) => {
            const totals = lineAmounts(item);
            const itemTotal = totals.unitGross * item.quantity;
            
            // HTML para la imagen del producto
            let imageHtml = "";
            console.log("🖼️ Renderizando imagen para:", item.name, "Imagen URL:", item.imageUrl);
            
            if (item.imageUrl) {
                // Usar la URL completa que ya está guardada
                console.log("🔗 Usando URL guardada:", item.imageUrl);
                
                imageHtml = `
                    <img src="${item.imageUrl}" 
                         alt="${item.name}" 
                         class="object-cover w-16 h-16 rounded-lg"
                         onerror="console.log('❌ Error cargando imagen:', this.src); this.style.display='none'; this.nextElementSibling.style.display='flex';"
                         onload="console.log('✅ Imagen cargada exitosamente:', this.src);">
                    <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center" style="display:none;">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                `;
            } else {
                // Si no hay imagen, mostrar el placeholder
                console.log("⚠️ No hay imagen para:", item.name);
                imageHtml = `
                    <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                `;
            }
            
            return `
                <div class="flex items-center space-x-4 p-4 border border-gray-200 rounded-lg">
                    ${imageHtml}
                    <div class="flex-1">
                        <h3 class="font-semibold text-sm">${item.name}</h3>
                        <p class="text-green-600 font-bold text-sm">$${item.price.toFixed(2)}</p>
                        <p class="text-gray-500 text-xs">Total: $${itemTotal.toFixed(2)}</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button onclick="updateQuantity(${index}, -1)" class="w-6 h-6 bg-gray-200 rounded-full flex items-center justify-center text-sm">-</button>
                        <span class="w-6 text-center text-sm">${item.quantity}</span>
                        <button onclick="updateQuantity(${index}, 1)" class="w-6 h-6 bg-gray-200 rounded-full flex items-center justify-center text-sm">+</button>
                    </div>
                    <button onclick="removeFromCart(${index})" class="text-red-500 hover:text-red-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
            `;
        }).join("");
    }
    
    // Agregar al carrito
    function addToCart(productData) {
        console.log("🛒 Agregando al carrito:", productData);
        console.log("🖼️ Imagen recibida:", productData.image);
        
        const existingItem = cart.find(item => item.id === productData.id);
        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            // Construir la URL completa de la imagen si existe
            let imageUrl = null;
            if (productData.image) {
                imageUrl = `https://servidor.adminnegocios.com/storage/productos/thumbnail/${productData.image}`;
                console.log("🔗 URL de imagen construida al agregar:", imageUrl);
            }
            
            cart.push({
                id: productData.id,
                name: productData.name,
                price: parseFloat(productData.price),
                descripcion: productData.descripcion,
                existencia: parseInt(productData.existencia || 0, 10),
                iva: parseFloat(productData.iva),
                image: productData.image || null,
                imageUrl: imageUrl,
                quantity: 1
            });
        }
        
        updateCartCounter();
        updateCartTotal();
        renderCartItems();
        
        // Mostrar notificación
        showCartNotification(productData.name);
        
        // Disparar evento para actualizar las tarjetas de productos
        window.dispatchEvent(new Event("cartUpdated"));
    }
    
    // Mostrar notificación de producto agregado
    function showCartNotification(productName) {
        const notification = document.createElement("div");
        notification.className = "fixed top-20 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 transition-all duration-300";
        notification.innerHTML = `
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                ${productName} agregado al carrito
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Remover después de 3 segundos
        setTimeout(() => {
            notification.style.opacity = "0";
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
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
        
        // Disparar evento para actualizar las tarjetas de productos
        window.dispatchEvent(new Event("cartUpdated"));
    };
    
    // Remover del carrito
    window.removeFromCart = function(index) {
        cart.splice(index, 1);
        updateCartCounter();
        updateCartTotal();
        renderCartItems();
        
        // Disparar evento para actualizar las tarjetas de productos
        window.dispatchEvent(new Event("cartUpdated"));
    };
    
    
    // Variable para evitar clicks duplicados en checkout
    let checkoutInProgress = false;
    
    // Función de checkout con Epayco
    window.checkout = function() {
        if (cart.length === 0) return;
        
        // Evitar clicks duplicados
        if (checkoutInProgress) {
            console.log("⚠️ Checkout ya en progreso, ignorando click duplicado");
            return;
        }
        
        checkoutInProgress = true;
        
        console.log("💳 Procediendo al pago con carrito:", cart);
        
        // Verificar si hay credenciales de Epayco
        const epaycoPublicKey = "{{ addslashes($epaycoPublicKey) }}";
        const epaycoPrivateKey = "{{ addslashes($epaycoPrivateKey) }}";
        const epaycoCustomerId = "{{ addslashes($epaycoCustomerId) }}";
        
        console.log("🔑 Credenciales de Epayco:", {
            publicKey: epaycoPublicKey ? "✅ Configurada" : "❌ No configurada",
            privateKey: epaycoPrivateKey ? "✅ Configurada" : "❌ No configurada",
            customerId: epaycoCustomerId ? "✅ Configurada" : "❌ No configurada"
        });
        
        if (!epaycoPublicKey || !epaycoPrivateKey) {
            console.error("❌ Credenciales de Epayco faltantes");
            alert("⚠️ Las credenciales de Epayco no están configuradas. Por favor, configura la integración de pagos en el panel de administración.");
            return;
        }
        
        console.log("✅ Todas las credenciales de Epayco están configuradas");
        
        // Verificar que las credenciales no estén vacías
        if (!epaycoPublicKey.trim() || !epaycoPrivateKey.trim()) {
            console.error("❌ Las credenciales están vacías");
            alert("Error: Las credenciales de Epayco están vacías. Verifica la configuración.");
            return;
        }
        
        console.log("🔍 Verificando configuración de Epayco...");
        console.log("Public Key length:", epaycoPublicKey.length);
        console.log("Private Key length:", epaycoPrivateKey.length);
        
        // Calcular totales
        const totals = computeTotals(cart);
        const invoiceNumber = "INV-" + Date.now();
        
        // Configurar datos para Epayco
        const responseUrl = window.location.origin + "/payment/response";
        const confirmationUrl = window.location.origin + "/payment/confirmation";
        
        console.log("🔗 URLs configuradas:");
        console.log("- Response URL:", responseUrl);
        console.log("- Confirmation URL:", confirmationUrl);
        
        const epaycoData = {
            name: "Compra en mi tienda",
            description: `Pedido de ${cart.length} productos`,
            invoice: invoiceNumber,
            currency: "COP",
            amount: totals.gross.toFixed(2),
            tax_base: totals.taxBase.toFixed(2),
            tax: totals.tax.toFixed(2),
            tax_ico: "0.00",
            country: "CO",
            lang: "es",
            external: "false",
            extra1: invoiceNumber,
            extra2: "carrito-web",
            extra3: "canal-online",
            response: responseUrl,
            confirmation: confirmationUrl,
            
            // Datos del cliente (se pueden hacer dinámicos)
            name_billing: "Cliente",
            address_billing: "Dirección del cliente",
            type_doc_billing: "cc",
            mobilephone_billing: "3000000000",
            number_doc_billing: "1234567890",
            email_billing: "cliente@email.com"
        };
        
        console.log("💳 Datos para Epayco:", epaycoData);
        
        // Verificar que los datos estén correctos
        console.log("🔍 Verificando datos de Epayco:");
        console.log("- name:", epaycoData.name);
        console.log("- amount:", epaycoData.amount);
        console.log("- currency:", epaycoData.currency);
        console.log("- invoice:", epaycoData.invoice);
        console.log("- response URL:", epaycoData.response);
        console.log("- confirmation URL:", epaycoData.confirmation);
        
        // Configurar y abrir checkout de Epayco
        if (typeof ePayco !== 'undefined') {
            console.log("✅ SDK de Epayco disponible, configurando...");
            console.log("🔍 ePayco object:", ePayco);
            console.log("🔍 ePayco.checkout:", ePayco.checkout);
            
            try {
                console.log("🔧 Configurando handler con key:", epaycoPublicKey.substring(0, 10) + "...");
                
                const handler = ePayco.checkout.configure({
                    key: epaycoPublicKey,
                    test: true, // Usar modo de prueba
                    autoclick: false
                });
                
                console.log("✅ Handler de Epayco configurado correctamente");
                console.log("🔍 Handler object:", handler);
                
                console.log("🚀 Abriendo modal de Epayco...");
                
                // Usar el SDK de Epayco correctamente
                let result = null;
                try {
                    console.log("🚀 Usando handler.open()...");
                    result = handler.open(epaycoData);
                    console.log("📋 Resultado de handler.open():", result);
                    
                    console.log("✅ Modal de Epayco abierto");
                    
                    // Cerrar el carrito
                    closeCart();
                    
                    // Verificar si el iframe se creó correctamente
                    setTimeout(() => {
                        const epaycoIframe = document.querySelector('iframe#checkout-epayco');
                        if (epaycoIframe) {
                            console.log("🔍 Iframe de Epayco encontrado:", epaycoIframe);
                            
                            // Si tiene width 0, arreglarlo
                            if (epaycoIframe.offsetWidth === 0) {
                                console.log("🔧 Arreglando iframe con width 0...");
                                epaycoIframe.style.width = '100%';
                                epaycoIframe.style.maxWidth = '800px';
                                epaycoIframe.style.height = '600px';
                                epaycoIframe.style.position = 'fixed';
                                epaycoIframe.style.top = '50%';
                                epaycoIframe.style.left = '50%';
                                epaycoIframe.style.transform = 'translate(-50%, -50%)';
                                epaycoIframe.style.zIndex = '9999';
                                epaycoIframe.style.border = 'none';
                                epaycoIframe.style.borderRadius = '10px';
                                epaycoIframe.style.boxShadow = '0 10px 30px rgba(0,0,0,0.3)';
                                epaycoIframe.style.background = 'white';
                                epaycoIframe.style.display = 'block';
                                console.log("✅ Iframe arreglado");
                            }
                        } else {
                            console.log("⚠️ Iframe de Epayco no encontrado");
                        }
                    }, 500);
                    
                } catch (openError) {
                    console.error("❌ Error en handler.open():", openError);
                    
                    // Fallback: intentar con openNew
                    try {
                        console.log("🔄 Intentando con handler.openNew()...");
                        result = handler.openNew(epaycoData);
                        console.log("📋 Resultado de handler.openNew():", result);
                        
                        console.log("✅ Modal de Epayco abierto con openNew");
                        
                        // Cerrar el carrito
                        closeCart();
                        
                        // Verificar si el iframe se creó correctamente
                        setTimeout(() => {
                            const epaycoIframe = document.querySelector('iframe#checkout-epayco');
                            if (epaycoIframe) {
                                console.log("🔍 Iframe de Epayco encontrado (openNew):", epaycoIframe);
                                
                                // Si tiene width 0, arreglarlo
                                if (epaycoIframe.offsetWidth === 0) {
                                    console.log("🔧 Arreglando iframe con width 0 (openNew)...");
                                    epaycoIframe.style.width = '100%';
                                    epaycoIframe.style.maxWidth = '800px';
                                    epaycoIframe.style.height = '600px';
                                    epaycoIframe.style.position = 'fixed';
                                    epaycoIframe.style.top = '50%';
                                    epaycoIframe.style.left = '50%';
                                    epaycoIframe.style.transform = 'translate(-50%, -50%)';
                                    epaycoIframe.style.zIndex = '9999';
                                    epaycoIframe.style.border = 'none';
                                    epaycoIframe.style.borderRadius = '10px';
                                    epaycoIframe.style.boxShadow = '0 10px 30px rgba(0,0,0,0.3)';
                                    epaycoIframe.style.background = 'white';
                                    epaycoIframe.style.display = 'block';
                                    console.log("✅ Iframe arreglado (openNew)");
                                }
                            } else {
                                console.log("⚠️ Iframe de Epayco no encontrado (openNew)");
                            }
                        }, 500);
                        
                    } catch (openNewError) {
                        console.error("❌ Error en handler.openNew():", openNewError);
                        throw openNewError;
                    }
                }
                
            } catch (error) {
                console.error("❌ Error al abrir modal de Epayco:", error);
                alert("Error al abrir el modal de pagos: " + error.message);
                checkoutInProgress = false; // Resetear para permitir reintento
            }
            
        } else {
            console.error("❌ SDK de Epayco no está cargado");
            alert("Error: El SDK de pagos no se ha cargado correctamente. Intenta recargar la página.");
            checkoutInProgress = false; // Resetear para permitir reintento
        }
    };
    
    // Variable para evitar clicks duplicados
    let lastClickTime = 0;
    
    // Event listeners
    document.addEventListener("click", function(e) {
        // Botón del carrito
        if (e.target.closest("#cart-button")) {
            e.preventDefault();
            openCart();
        }
        
        // Cerrar carrito
        if (e.target.closest("#close-cart") || e.target.id === "cart-overlay") {
            e.preventDefault();
            closeCart();
        }
        
        // Botón de checkout
        if (e.target.closest("#checkout-btn")) {
            e.preventDefault();
            window.checkout();
        }
        
        // Botones "Agregar al Carrito"
        const addToCartBtn = e.target.closest(".add-to-cart");
        if (addToCartBtn) {
            e.preventDefault();
            e.stopImmediatePropagation();
            
            // Evitar clicks duplicados (debounce de 300ms)
            const now = Date.now();
            if (now - lastClickTime < 300) {
                console.log("⚠️ Click duplicado detectado y bloqueado");
                return;
            }
            lastClickTime = now;
            
            const productData = {
                id: addToCartBtn.getAttribute("data-id"),
                name: addToCartBtn.getAttribute("data-name"),
                price: parseFloat(addToCartBtn.getAttribute("data-price")),
                descripcion: addToCartBtn.getAttribute("data-descripcion"),
                existencia: addToCartBtn.getAttribute("data-existencia"),
                iva: addToCartBtn.getAttribute("data-iva"),
                image: addToCartBtn.getAttribute("data-image")
            };
            
            addToCart(productData);
        }
    });
    
    // Escuchar cambios en el carrito desde las tarjetas de productos
    window.addEventListener("cartUpdated", function() {
        // Recargar el carrito desde localStorage
        cart = JSON.parse(localStorage.getItem("cart")) || [];
        renderCartItems();
        updateCartCounter();
        updateCartTotal();
    });
    
    // Inicializar el carrito al cargar la página
    renderCartItems();
    updateCartCounter();
    updateCartTotal();
    
    console.log("✅ Carrito de compras inicializado correctamente");
    console.log("📦 Productos en carrito:", cart.length);
});
</script>
