@props([
'templateSlug' => 'default',
'colors' => [],
'paymentHandler' => 'epayco',
'websiteSlug' => '',
'allowCashOnDelivery' => true,
'allowOnlinePayment' => true,
'cashOnDeliveryInstructions' => ''
])

<script>
    (function() {
        const templateConfig = {
            slug: "{{ $templateSlug }}",
            colors: {
                primary: "{{ $colors['primary'] ?? '#2563eb' }}",
                secondary: "{{ $colors['secondary'] ?? '#7c3aed' }}",
                accent: "{{ $colors['accent'] ?? '#10b981' }}",
                background: "{{ $colors['background'] ?? '#f9fafb' }}",
                text: "{{ $colors['text'] ?? '#111827' }}"
            },
            paymentHandler: "{{ $paymentHandler }}",
            websiteSlug: "{{ $websiteSlug }}",
            allowCashOnDelivery: {{ $allowCashOnDelivery ? 'true' : 'false' }},
            allowOnlinePayment: {{ $allowOnlinePayment ? 'true' : 'false' }},
            cashOnDeliveryInstructions: `{{ $cashOnDeliveryInstructions ?? '' }}`
        };

        const CartState = {
            items: [],
            checkoutData: JSON.parse(localStorage.getItem('cartCheckoutData') || '{}'),
            addresses: [],
            selectedAddressId: null,
            isLoadingAddresses: false,
            selectedPaymentMethod: null // 'cash_on_delivery' o 'online_payment'
        };

        if (CartState.checkoutData?.addressId) {
            CartState.selectedAddressId = CartState.checkoutData.addressId;
        }

        const Selectors = {
            button: '#cart-button',
            counter: '#cart-counter',
            sidebar: '#cart-sidebar',
            overlay: '#cart-overlay',
            close: '#close-cart',
            items: '#cart-items',
            total: '#cart-total',
            checkout: '#checkout-btn'
        };

        document.addEventListener('DOMContentLoaded', initCart);

        function initCart() {
            CartState.items = JSON.parse(localStorage.getItem('cart') || '[]');
            ensureCartStructure();
            bindGlobalEvents();
            renderCart();
        }

        function ensureCartStructure() {
            if (!document.querySelector(Selectors.overlay)) {
                const overlay = document.createElement('div');
                overlay.id = 'cart-overlay';
                overlay.className = 'fixed inset-0 bg-black bg-opacity-50 z-40 hidden';
                document.body.appendChild(overlay);
            }

            if (!document.querySelector(Selectors.sidebar)) {
                const sidebar = document.createElement('div');
                sidebar.id = 'cart-sidebar';
                sidebar.className = 'fixed inset-y-0 right-0 z-50 w-96 bg-white shadow-xl transition-transform duration-300 ease-in-out transform translate-x-full';
                sidebar.innerHTML = buildSidebarTemplate();
                document.body.appendChild(sidebar);
            }

            if (!document.querySelector(Selectors.button)) {
                const button = document.createElement('button');
                button.id = 'cart-button';
                button.className = 'fixed bottom-6 right-6 z-40 bg-blue-600 text-white p-3 rounded-full shadow-lg hover:bg-blue-700';
                button.innerHTML = `
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <span id="cart-counter" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-6 w-6 flex items-center justify-center font-bold">0</span>
            `;
                document.body.appendChild(button);
            }
        }

        function bindGlobalEvents() {
            document.addEventListener('click', handleGlobalClicks);
            window.addToCart = addToCart;
            window.updateQuantity = updateQuantity;
            window.removeFromCart = removeFromCart;
            window.reloadCartListeners = attachAddToCartButtons;
            attachAddToCartButtons();
        }

        function handleGlobalClicks(event) {
            if (event.target.closest(Selectors.button)) {
                event.preventDefault();
                openSidebar();
            }

            if (event.target.closest(Selectors.close) || event.target.id === 'cart-overlay') {
                event.preventDefault();
                closeSidebar();
            }

            if (event.target.closest(Selectors.checkout)) {
                event.preventDefault();
                if (CartState.items.length === 0) return;
                openCheckoutModal();
            }

            const addBtn = event.target.closest('.add-to-cart');
            if (addBtn) {
                event.preventDefault();
                addToCart({
                    id: addBtn.getAttribute('data-id'),
                    name: addBtn.getAttribute('data-name'),
                    price: parseFloat(addBtn.getAttribute('data-price') || '0'),
                    iva: parseFloat(addBtn.getAttribute('data-iva') || '0'),
                    image: addBtn.getAttribute('data-image')
                });
            }
        }

        function attachAddToCartButtons() {
            document.querySelectorAll('.add-to-cart').forEach(button => {
                button.removeEventListener('click', noop);
                button.addEventListener('click', noop);
            });
        }

        function noop() {}

        function openSidebar() {
            document.querySelector(Selectors.sidebar)?.classList.remove('translate-x-full');
            document.querySelector(Selectors.overlay)?.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            document.querySelector(Selectors.sidebar)?.classList.add('translate-x-full');
            document.querySelector(Selectors.overlay)?.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function addToCart(product) {
            const existing = CartState.items.find(item => item.id == product.id);
            if (existing) {
                existing.quantity += 1;
            } else {
                CartState.items.push({
                    ...product,
                    quantity: 1
                });
            }
            persistCart();
            renderCart();
            showToast(`${product.name} agregado al carrito`);
            window.dispatchEvent(new Event('cartUpdated'));
        }

        function updateQuantity(index, change) {
            const item = CartState.items[index];
            if (!item) return;
            item.quantity += change;
            if (item.quantity <= 0) {
                CartState.items.splice(index, 1);
            }
            persistCart();
            renderCart();
            window.dispatchEvent(new Event('cartUpdated'));
        }

        function removeFromCart(index) {
            CartState.items.splice(index, 1);
            persistCart();
            renderCart();
            window.dispatchEvent(new Event('cartUpdated'));
        }

        function buildSidebarTemplate() {
            return `
            <div class="flex flex-col h-full">
                <div class="flex items-center justify-between p-4 border-b bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-900">Carrito de Compras</h3>
                    <button id="close-cart" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="flex-1 p-4 overflow-y-auto">
                    <div id="cart-items" class="space-y-4"></div>
                </div>
                <div class="p-4 border-t bg-gray-50">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-lg font-semibold">Total:</span>
                        <span id="cart-total" class="text-2xl font-bold" style="color:${templateConfig.colors.primary}">$0</span>
                    </div>
                    <button id="checkout-btn"
                            class="w-full py-3 text-white font-semibold rounded-lg disabled:bg-gray-300 flex items-center justify-center"
                            style="background-color:${templateConfig.colors.primary}"
                            disabled>
                        <span id="checkout-btn-text">Proceder al Pago</span>
                        <svg id="checkout-btn-spinner" class="hidden w-5 h-5 ml-2 animate-spin text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </button>
                </div>
            </div>
        `;
        }

        function renderCart() {
            const itemsContainer = document.querySelector(Selectors.items);
            const counter = document.querySelector(Selectors.counter);
            const totalElement = document.querySelector(Selectors.total);
            const checkoutBtn = document.querySelector(Selectors.checkout);

            const totals = computeTotals();

            if (counter) counter.textContent = CartState.items.reduce((sum, item) => sum + item.quantity, 0);
            if (totalElement) totalElement.textContent = formatCurrency(totals.gross);
            if (checkoutBtn) checkoutBtn.disabled = CartState.items.length === 0;

            if (!itemsContainer) return;

            if (CartState.items.length === 0) {
                itemsContainer.innerHTML = `
                <div class="flex flex-col items-center justify-center py-12 text-gray-500 min-h-64">
                    <svg xmlns="http://www.w3.org/2000/svg" width="96" height="96" viewBox="0 0 24 24" class="mb-4">
                        <path fill="currentColor" fill-rule="evenodd" d="M1.566 4a.75.75 0 0 1 .75-.75h1.181a2.25 2.25 0 0 1 2.228 1.937l.061.435h13.965a2.25 2.25 0 0 1 2.063 3.148l-2.668 6.128a2.25 2.25 0 0 1-2.063 1.352H7.722a2.25 2.25 0 0 1-2.228-1.937L4.24 5.396a.75.75 0 0 0-.743-.646h-1.18a.75.75 0 0 1-.75-.75m4.431 3.122l.982 6.982a.75.75 0 0 0 .743.646h9.361a.75.75 0 0 0 .688-.45l2.667-6.13a.75.75 0 0 0-.687-1.048z" clip-rule="evenodd"/>
                        <path fill="currentColor" d="M6.034 19.5a1.75 1.75 0 1 1 3.5 0a1.75 1.75 0 0 1-3.5 0m10.286-1.75a1.75 1.75 0 1 0 0 3.5a1.75 1.75 0 0 0 0-3.5"/>
                    </svg>
                    <p class="text-center">Tu carrito está vacío</p>
                </div>
            `;
                return;
            }

            itemsContainer.innerHTML = CartState.items.map((item, index) => `
            <div class="flex items-center space-x-4 p-4 border border-gray-200 rounded-lg">
                <div class="flex-1">
                    <h3 class="font-semibold text-sm">${item.name}</h3>
                    <p class="text-green-600 font-bold text-sm">${formatCurrency(item.price)}</p>
                    <p class="text-gray-500 text-xs">Subtotal: ${formatCurrency(item.price * item.quantity)}</p>
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
        `).join('');
        }

        function computeTotals() {
            let gross = 0;
            let taxBase = 0;
            let tax = 0;

            CartState.items.forEach(item => {
                const quantity = item.quantity || 1;
                const price = parseFloat(item.price || 0);
                const ivaRate = parseFloat(item.iva || 0) / 100;
                const base = ivaRate > 0 ? price / (1 + ivaRate) : price;
                const iva = price - base;

                gross += price * quantity;
                taxBase += base * quantity;
                tax += iva * quantity;
            });

            return {
                gross: round2(gross),
                taxBase: round2(taxBase),
                tax: round2(tax),
                taxIco: 0
            };
        }

        function round2(value) {
            return Math.round(value * 100) / 100;
        }

        function formatCurrency(value) {
            return new Intl.NumberFormat('es-CO', {
                style: 'currency',
                currency: 'COP'
            }).format(value);
        }

        function persistCart() {
            localStorage.setItem('cart', JSON.stringify(CartState.items));
        }

        function showToast(message) {
            const toast = document.createElement('div');
            toast.className = 'fixed top-6 right-6 z-50 bg-green-600 text-white px-4 py-2 rounded-lg shadow-lg';
            toast.textContent = message;
            document.body.appendChild(toast);
            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            }, 2000);
        }

        function ensureCheckoutModal() {
            if (document.getElementById('checkout-modal')) return;

            const modal = document.createElement('div');
            modal.id = 'checkout-modal';
            modal.className = 'fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 p-4';
            modal.innerHTML = `
            <div class="relative w-full max-w-2xl bg-white rounded-lg shadow-xl flex flex-col max-h-[90vh]">
                <div class="flex-shrink-0 p-6 pb-4 border-b">
                    <button id="close-checkout-modal" class="absolute text-gray-400 top-4 right-4 hover:text-gray-600 z-10">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    <h2 class="mb-2 text-2xl font-bold text-gray-900">Datos para el envío</h2>
                    <p class="text-sm text-gray-600">Selecciona una dirección de entrega o crea una nueva.</p>
                </div>
                
                <div class="flex-1 overflow-y-auto px-6 py-4">

                <div id="address-section" class="space-y-3 mb-6">
                    <div id="address-loading" class="text-sm text-gray-500">Cargando direcciones...</div>
                    <div id="address-select-wrapper" class="hidden"></div>
                    <p id="address-empty-message" class="hidden text-sm text-orange-600 bg-orange-50 border border-orange-200 px-3 py-2 rounded-lg">
                        ⚠️ No tienes direcciones guardadas. Haz clic en "Añadir dirección" para crear una.
                    </p>
                    <button id="add-address-btn" class="hidden w-full px-4 py-2 text-sm font-medium text-white rounded-lg" style="background-color:${templateConfig.colors.primary}">
                        + Añadir dirección
                    </button>
                </div>

                <div id="new-address-form" class="hidden mb-6 border border-gray-200 rounded-lg p-4 bg-gray-50 space-y-3">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900">Nueva dirección</h3>
                        <button id="cancel-new-address" class="text-sm text-gray-500 hover:text-gray-700">Cancelar</button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nombre o alias</label>
                            <input id="new-address-name" type="text" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" placeholder="Casa, Oficina, etc.">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                            <input id="new-address-phone" type="tel" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" placeholder="Opcional">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Dirección completa</label>
                        <textarea id="new-address-address" rows="2" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" placeholder="Ej. Calle 123 #45-67, Torre 2, apto 401"></textarea>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ciudad</label>
                            <input id="new-address-city" type="text" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" placeholder="Ciudad">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Departamento/Barrio</label>
                            <input id="new-address-state" type="text" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" placeholder="Barrio o departamento">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md-grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Código Postal</label>
                            <input id="new-address-postal" type="text" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" placeholder="Opcional">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">País</label>
                            <input id="new-address-country" type="text" value="Colombia" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Referencia adicional</label>
                        <textarea id="new-address-reference" rows="2" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" placeholder="Instrucciones para el repartidor"></textarea>
                    </div>
                    <div id="new-address-error" class="hidden text-sm text-red-600 bg-red-50 border border-red-200 px-3 py-2 rounded-lg"></div>
                    <div class="flex justify-end">
                        <button id="save-new-address" class="px-4 py-2 text-white rounded-lg flex items-center justify-center" style="background-color:${templateConfig.colors.primary}">
                            <span id="save-address-btn-text">Guardar dirección</span>
                            <svg id="save-address-spinner" class="hidden w-5 h-5 ml-2 animate-spin text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Notas o indicaciones</label>
                    <textarea id="checkout-notes" class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-blue-500" rows="3" placeholder="Ej. Torre 2, apto 401"></textarea>
                </div>
                
                <!-- Selección de Método de Pago -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Método de pago</label>
                    <div class="space-y-3">
                        ${templateConfig.allowCashOnDelivery ? `
                        <label class="relative flex items-start p-4 border-2 rounded-lg cursor-pointer hover:bg-gray-50 payment-method-option" data-method="cash_on_delivery">
                            <input type="radio" name="payment_method" value="cash_on_delivery" 
                                   class="mt-1 h-4 w-4 text-green-600 focus:ring-green-500"
                                   ${!templateConfig.allowOnlinePayment ? 'checked' : ''}>
                            <div class="ml-3 flex-1">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    <span class="block text-sm font-medium text-gray-900">Pago contra entrega</span>
                                </div>
                                <p class="text-xs text-gray-500 mt-1 ml-7">Paga en efectivo cuando recibas tu pedido</p>
                                ${templateConfig.cashOnDeliveryInstructions ? `
                                    <div class="ml-7 mt-2 p-2 bg-blue-50 border border-blue-200 rounded text-xs text-blue-700">
                                        ${templateConfig.cashOnDeliveryInstructions}
                                    </div>
                                ` : ''}
                            </div>
                        </label>
                        ` : ''}
                        
                        ${templateConfig.allowOnlinePayment ? `
                        <label class="relative flex items-start p-4 border-2 rounded-lg cursor-pointer hover:bg-gray-50 payment-method-option" data-method="online_payment">
                            <input type="radio" name="payment_method" value="online_payment" 
                                   class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500"
                                   ${!templateConfig.allowCashOnDelivery ? 'checked' : ''}>
                            <div class="ml-3 flex-1">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                    <span class="block text-sm font-medium text-gray-900">Pago en línea</span>
                                </div>
                                <p class="text-xs text-gray-500 mt-1 ml-7">Tarjeta de crédito, débito, PSE y más</p>
                                <div class="flex items-center ml-7 mt-2 space-x-2">
                                    <span class="text-xs text-gray-500">Procesado por:</span>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                        ${templateConfig.paymentHandler === 'wompi' ? 'Wompi' : 'ePayco'}
                                    </span>
                                </div>
                            </div>
                        </label>
                        ` : ''}
                    </div>
                    <div id="payment-method-error" class="hidden mt-2 text-sm text-red-600"></div>
                </div>
                </div>
                
                <div class="flex-shrink-0 p-6 pt-4 border-t bg-gray-50">
                    <div class="mb-4 text-sm text-gray-700">
                        <span class="font-semibold">Total a pagar:</span>
                        <span id="checkout-modal-total" class="text-lg font-bold text-gray-900"></span>
                    </div>
                    <div id="checkout-modal-error" class="hidden mb-4 text-sm text-red-600 bg-red-50 border border-red-200 px-3 py-2 rounded-lg"></div>
                    <div class="flex justify-end space-between">
                        <button id="cancel-checkout-modal" class="mr-3 px-4 py-2 text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200">Cancelar</button>
                        <button id="confirm-checkout-modal" class="px-4 py-2 text-white rounded-lg flex items-center justify-center" style="background-color:${templateConfig.colors.primary}">
                            <span id="confirm-btn-text">Confirmar</span>
                            <svg id="confirm-spinner" class="hidden w-5 h-5 ml-2 animate-spin text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        `;
            document.body.appendChild(modal);

            document.getElementById('close-checkout-modal').addEventListener('click', () => toggleCheckoutModal(false));
            document.getElementById('cancel-checkout-modal').addEventListener('click', () => toggleCheckoutModal(false));
            document.getElementById('confirm-checkout-modal').addEventListener('click', confirmCheckoutData);
            document.getElementById('add-address-btn').addEventListener('click', () => toggleNewAddressForm(true));
            document.getElementById('cancel-new-address').addEventListener('click', () => toggleNewAddressForm(false));
            document.getElementById('save-new-address').addEventListener('click', saveNewAddress);
        }

        async function openCheckoutModal() {
            // Obtener elementos del botón de checkout
            const checkoutBtn = document.getElementById('checkout-btn');
            const checkoutBtnText = document.getElementById('checkout-btn-text');
            const checkoutBtnSpinner = document.getElementById('checkout-btn-spinner');

            // Mostrar estado de carga
            if (checkoutBtn) checkoutBtn.disabled = true;
            if (checkoutBtnText) checkoutBtnText.textContent = 'Verificando...';
            if (checkoutBtnSpinner) checkoutBtnSpinner.classList.remove('hidden');

            // VALIDACIÓN 1: Verificar si el usuario ha iniciado sesión
            const isLoggedIn = await checkIfUserIsLoggedIn();

            if (!isLoggedIn) {
                console.log('⚠️ Usuario no autenticado, mostrando modal de login');

                // Restaurar estado del botón
                if (checkoutBtn) checkoutBtn.disabled = false;
                if (checkoutBtnText) checkoutBtnText.textContent = 'Proceder al Pago';
                if (checkoutBtnSpinner) checkoutBtnSpinner.classList.add('hidden');

                // Cerrar el carrito
                closeSidebar();
                // Mostrar el modal de login (si existe la función global)
                if (typeof window.showLoginModal === 'function') {
                    window.showLoginModal();
                } else {
                    alert('Por favor inicia sesión para continuar con tu compra');
                }
                return;
            }

            console.log('✅ Usuario autenticado, continuando con checkout...');

            // Actualizar texto del botón
            if (checkoutBtnText) checkoutBtnText.textContent = 'Cargando direcciones...';

            // VALIDACIÓN 2: Cargar direcciones y verificar si tiene alguna
            await loadAddresses(true); // Forzar recarga

            if (CartState.addresses.length === 0) {
                console.log('⚠️ Usuario no tiene direcciones, mostrando mensaje');

                // Restaurar estado del botón
                if (checkoutBtn) checkoutBtn.disabled = false;
                if (checkoutBtnText) checkoutBtnText.textContent = 'Proceder al Pago';
                if (checkoutBtnSpinner) checkoutBtnSpinner.classList.add('hidden');

                // Mostrar modal pidiendo que configure una dirección
                showAddressRequiredModal();
                return;
            }

            console.log('✅ Usuario tiene', CartState.addresses.length, 'dirección(es), abriendo modal de checkout');

            // Si todo está bien, abrir el modal de checkout normal
            ensureCheckoutModal();
            const totals = computeTotals();
            const modal = document.getElementById('checkout-modal');
            const totalLabel = document.getElementById('checkout-modal-total');
            const notesField = document.getElementById('checkout-notes');
            const errorLabel = document.getElementById('checkout-modal-error');

            if (totalLabel) totalLabel.textContent = formatCurrency(totals.gross);
            if (errorLabel) errorLabel.classList.add('hidden');

            notesField.value = CartState.checkoutData.notes || '';

            renderAddressSection();

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';

            // Restaurar estado del botón después de abrir el modal
            if (checkoutBtn) checkoutBtn.disabled = false;
            if (checkoutBtnText) checkoutBtnText.textContent = 'Proceder al Pago';
            if (checkoutBtnSpinner) checkoutBtnSpinner.classList.add('hidden');
        }

        // Función para verificar si el usuario está logueado
        async function checkIfUserIsLoggedIn() {
            try {
                // Obtener el slug del website desde la URL actual o de la configuración
                const websiteSlug = templateConfig.websiteSlug || getWebsiteSlugFromUrl();

                console.log('🔍 Verificando autenticación para:', websiteSlug);

                const response = await fetch(`/${websiteSlug}/api/check-auth`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                    }
                });

                if (response.ok) {
                    const data = await response.json();
                    console.log('✅ Respuesta de autenticación:', data);
                    return data.authenticated === true;
                }

                console.warn('⚠️ No se pudo verificar autenticación, status:', response.status);
                return false;
            } catch (error) {
                console.error('❌ Error verificando autenticación:', error);
                return false;
            }
        }

        // Función auxiliar para obtener el slug desde la URL
        function getWebsiteSlugFromUrl() {
            // La URL es algo como: /mashcol o /mashcol/productos
            const pathParts = window.location.pathname.split('/').filter(p => p);
            return pathParts[0] || '';
        }

        // Función para mostrar modal cuando no tiene direcciones
        function showAddressRequiredModal() {
            // Crear modal personalizado para pedir configurar dirección
            const existingModal = document.getElementById('address-required-modal');
            if (existingModal) {
                existingModal.remove();
            }

            const modal = document.createElement('div');
            modal.id = 'address-required-modal';
            modal.className = 'fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50';
            modal.innerHTML = `
            <div class="relative w-full max-w-md p-6 bg-white rounded-lg shadow-xl">
                <div class="text-center mb-6">
                    <div class="mx-auto mb-4 w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="mb-2 text-xl font-bold text-gray-900">Dirección de entrega requerida</h3>
                    <p class="text-gray-600">Para continuar con tu compra, necesitas configurar al menos una dirección de entrega.</p>
                </div>
                <div class="flex flex-col space-y-3">
                    <button id="go-to-addresses" class="w-full px-4 py-3 text-white rounded-lg font-semibold" style="background-color:${templateConfig.colors.primary}">
                        Configurar dirección
                    </button>
                    <button id="close-address-required" class="w-full px-4 py-2 text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200">
                        Cancelar
                    </button>
                </div>
            </div>
        `;

            document.body.appendChild(modal);

            // Event listeners
            document.getElementById('go-to-addresses').addEventListener('click', () => {
                const websiteSlug = templateConfig.websiteSlug || getWebsiteSlugFromUrl();
                window.location.href = `/${websiteSlug}/profile#direcciones`;
            });

            document.getElementById('close-address-required').addEventListener('click', () => {
                modal.remove();
            });

            // Cerrar al hacer clic fuera del modal
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.remove();
                }
            });
        }

        async function loadAddresses(force = false) {
            const websiteSlug = templateConfig.websiteSlug || getWebsiteSlugFromUrl();

            if (!websiteSlug) {
                console.warn('No se pudo determinar el slug del sitio para cargar direcciones.');
                return;
            }

            if (CartState.addresses.length > 0 && !force) {
                console.log('📍 Direcciones ya cargadas:', CartState.addresses.length);
                return;
            }

            CartState.isLoadingAddresses = true;
            renderAddressSection();

            try {
                console.log('📍 Cargando direcciones para website:', websiteSlug);
                const response = await fetch(`/customer/addresses?website=${encodeURIComponent(websiteSlug)}`, {
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) throw new Error('No se pudieron obtener las direcciones');
                const data = await response.json();

                console.log('📦 Datos de direcciones recibidos:', data);

                if (!data.success) throw new Error(data.message || 'Error cargando direcciones');

                CartState.addresses = data.addresses || [];
                console.log('✅ Direcciones cargadas:', CartState.addresses.length);

                if (CartState.addresses.length > 0 && !CartState.selectedAddressId) {
                    CartState.selectedAddressId = CartState.addresses[0].id;
                }
            } catch (error) {
                console.error('❌ Error obteniendo direcciones:', error);
                const emptyMessage = document.getElementById('address-empty-message');
                if (emptyMessage) {
                    emptyMessage.textContent = error.message;
                    emptyMessage.classList.remove('hidden');
                }
            } finally {
                CartState.isLoadingAddresses = false;
                renderAddressSection();
            }
        }

        function renderAddressSection() {
            const loading = document.getElementById('address-loading');
            const wrapper = document.getElementById('address-select-wrapper');
            const addAddressSection = document.getElementById('add-address-section');
            const confirmBtn = document.getElementById('confirm-checkout-modal');

            if (!loading || !wrapper || !confirmBtn) return;

            if (CartState.isLoadingAddresses) {
                loading.classList.remove('hidden');
                wrapper.classList.add('hidden');
                if (addAddressSection) addAddressSection.classList.add('hidden');
                confirmBtn.disabled = true;
                return;
            }

            loading.classList.add('hidden');

            const emptyMessage = document.getElementById('address-empty-message');
            const addBtn = document.getElementById('add-address-btn');

            if (CartState.addresses.length === 0) {
                // No hay direcciones: mostrar aviso y botón "Añadir dirección"
                wrapper.classList.add('hidden');
                if (emptyMessage) emptyMessage.classList.remove('hidden');
                if (addBtn) addBtn.classList.remove('hidden');
                confirmBtn.disabled = true;
                return;
            }

            // Hay direcciones: mostrar selector y ocultar mensaje/botón
            if (emptyMessage) emptyMessage.classList.add('hidden');
            if (addBtn) addBtn.classList.add('hidden');
            wrapper.classList.remove('hidden');
            confirmBtn.disabled = false;

            console.log('📋 Renderizando selector con direcciones:', CartState.addresses);

            wrapper.innerHTML = `
            <label class="block text-sm font-medium text-gray-700 mb-1">Selecciona una dirección</label>
            <select id="checkout-address-select" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                ${CartState.addresses.map(address => {
                    console.log('📍 Renderizando dirección:', address);
                    const displayText = `${address.address || address.direccion || 'Sin dirección'}, ${address.state || address.barrio || ''}, ${address.city || address.ciudad || 'Sin ciudad'}`;
                    console.log('📍 Texto a mostrar:', displayText);
                    return `
                        <option value="${address.id}" ${address.id == CartState.selectedAddressId ? 'selected' : ''}>
                            ${displayText}
                        </option>
                    `;
                }).join('')}
            </select>
        `;

            document.getElementById('checkout-address-select').addEventListener('change', function() {
                CartState.selectedAddressId = this.value;
            });
        }


        async function saveNewAddress() {
            const saveBtn = document.getElementById('save-new-address');
            const saveBtnText = document.getElementById('save-address-btn-text');
            const saveSpinner = document.getElementById('save-address-spinner');
            const confirmBtn = document.getElementById('confirm-checkout-modal');
            const errorBox = document.getElementById('new-address-error');
            if (errorBox) errorBox.classList.add('hidden');

            const data = {
                direccion: document.getElementById('new-address-address').value.trim(),
                ciudad: document.getElementById('new-address-city').value.trim(),
                barrio: document.getElementById('new-address-state').value.trim(),
                codigo_postal: document.getElementById('new-address-postal').value.trim(),
                website: templateConfig.websiteSlug
            };

            if (!data.direccion || !data.ciudad || !data.barrio) {
                showNewAddressError('Por favor completa los campos requeridos (dirección, ciudad y barrio).');
                return;
            }

            try {
                // Mostrar estado de carga en el botón de guardar
                if (saveBtn) saveBtn.disabled = true;
                if (saveBtnText) saveBtnText.textContent = 'Guardando...';
                if (saveSpinner) saveSpinner.classList.remove('hidden');
                if (confirmBtn) confirmBtn.disabled = true;
                const response = await fetch('/customer/addresses', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();
                if (!response.ok || !result.success) {
                    throw new Error(result.message || 'No se pudo crear la dirección');
                }

                CartState.addresses = result.addresses || [];
                if (CartState.addresses.length > 0) {
                    CartState.selectedAddressId = CartState.addresses[CartState.addresses.length - 1].id;
                }
                toggleNewAddressForm(false);
                renderAddressSection();
                showToast('Dirección guardada correctamente');
            } catch (error) {
                console.error('Error guardando dirección:', error);
                showNewAddressError(error.message);
            } finally {
                // Restaurar estado de los botones
                if (saveBtn) saveBtn.disabled = false;
                if (saveBtnText) saveBtnText.textContent = 'Guardar dirección';
                if (saveSpinner) saveSpinner.classList.add('hidden');
                if (confirmBtn) confirmBtn.disabled = CartState.addresses.length === 0;
            }
        }

        function toggleNewAddressForm(show) {
            const form = document.getElementById('new-address-form');
            const addBtn = document.getElementById('add-address-btn');
            
            if (!form) return;
            
            if (show) {
                form.classList.remove('hidden');
                if (addBtn) addBtn.classList.add('hidden');
            } else {
                form.classList.add('hidden');
                if (addBtn) addBtn.classList.remove('hidden');
                // Limpiar campos del formulario
                document.getElementById('new-address-name').value = '';
                document.getElementById('new-address-phone').value = '';
                document.getElementById('new-address-address').value = '';
                document.getElementById('new-address-city').value = '';
                document.getElementById('new-address-state').value = '';
                document.getElementById('new-address-postal').value = '';
                document.getElementById('new-address-reference').value = '';
                // Limpiar error
                const errorBox = document.getElementById('new-address-error');
                if (errorBox) errorBox.classList.add('hidden');
            }
        }

        function showNewAddressError(message) {
            const errorBox = document.getElementById('new-address-error');
            if (!errorBox) return;
            errorBox.textContent = message;
            errorBox.classList.remove('hidden');
        }

        function confirmCheckoutData() {
            const notesField = document.getElementById('checkout-notes');
            const errorLabel = document.getElementById('checkout-modal-error');
            const paymentMethodError = document.getElementById('payment-method-error');
            const confirmBtn = document.getElementById('confirm-checkout-modal');
            const btnText = document.getElementById('confirm-btn-text');
            const spinner = document.getElementById('confirm-spinner');

            if (!notesField) return;

            // Limpiar errores previos
            if (errorLabel) errorLabel.classList.add('hidden');
            if (paymentMethodError) paymentMethodError.classList.add('hidden');

            if (!CartState.selectedAddressId) {
                if (errorLabel) {
                    errorLabel.textContent = 'Selecciona o crea una dirección antes de continuar.';
                    errorLabel.classList.remove('hidden');
                }
                return;
            }

            const selectedAddress = CartState.addresses.find(a => a.id == CartState.selectedAddressId);
            if (!selectedAddress) {
                if (errorLabel) {
                    errorLabel.textContent = 'La dirección seleccionada no es válida.';
                    errorLabel.classList.remove('hidden');
                }
                return;
            }

            // Validar selección de método de pago
            const selectedPaymentMethod = document.querySelector('input[name="payment_method"]:checked');
            if (!selectedPaymentMethod) {
                if (paymentMethodError) {
                    paymentMethodError.textContent = 'Por favor selecciona un método de pago';
                    paymentMethodError.classList.remove('hidden');
                }
                // Scroll hacia el error
                paymentMethodError?.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
                return;
            }

            CartState.selectedPaymentMethod = selectedPaymentMethod.value;
            console.log('💳 Método de pago seleccionado:', CartState.selectedPaymentMethod);

            // Mostrar estado de carga
            if (confirmBtn) confirmBtn.disabled = true;
            if (btnText) btnText.textContent = 'Procesando pago...';
            if (spinner) spinner.classList.remove('hidden');
            if (errorLabel) errorLabel.classList.add('hidden');

            CartState.checkoutData = {
                addressId: selectedAddress.id,
                address: selectedAddress.address,
                city: selectedAddress.city,
                state: selectedAddress.state,
                phone: selectedAddress.phone,
                name: selectedAddress.name,
                notes: notesField.value.trim(),
                paymentMethod: CartState.selectedPaymentMethod
            };

            localStorage.setItem('cartCheckoutData', JSON.stringify(CartState.checkoutData));

            // Pequeño delay para que se vea el loading
            setTimeout(() => {
                toggleCheckoutModal(false);
                proceedToPayment();

                // Restaurar estado del botón (por si hay error y vuelve)
                setTimeout(() => {
                    if (confirmBtn) confirmBtn.disabled = false;
                    if (btnText) btnText.textContent = 'Confirmar';
                    if (spinner) spinner.classList.add('hidden');
                }, 1000);
            }, 300);
        }

        function toggleCheckoutModal(show) {
            const modal = document.getElementById('checkout-modal');
            if (!modal) return;
            if (show) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            } else {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = 'auto';
            }
        }

        function proceedToPayment() {
            console.log('🛒 CartState.items ANTES de crear payload:', CartState.items);
            const totals = computeTotals();
            const payload = {
                cart: CartState.items.map(item => ({
                    ...item
                })),
                totals,
                customer: {
                    ...CartState.checkoutData
                },
                paymentMethod: CartState.selectedPaymentMethod
            };

            console.log('💰 Procesando pago con método:', CartState.selectedPaymentMethod);
            console.log('📦 Payload.cart:', payload.cart);
            console.log('💵 Totals:', totals);

            // Si es pago contra entrega, crear el pedido directamente
            if (CartState.selectedPaymentMethod === 'cash_on_delivery') {
                processCashOnDeliveryOrder(payload);
            }
            // Si es pago en línea, usar la pasarela configurada
            else if (CartState.selectedPaymentMethod === 'online_payment') {
                const handler = window.PaymentHandlers?.[templateConfig.paymentHandler];

                if (handler && typeof handler.checkout === 'function') {
                    handler.checkout(payload);
                } else {
                    alert('No hay pasarela de pago configurada.');
                }
            }
        }

        // Función para procesar pedidos con pago contra entrega
        async function processCashOnDeliveryOrder(payload) {
            console.log('📦 Creando pedido con pago contra entrega...');
            console.log('📋 Datos del payload:', payload);
            console.log('🛒 CartState.items en processCashOnDeliveryOrder:', CartState.items);
            console.log('📦 payload.cart:', payload.cart);
            
            if (!payload.cart || payload.cart.length === 0) {
                console.error('❌ ERROR: payload.cart está vacío!');
                console.log('🔍 Verificando localStorage:', localStorage.getItem('cart'));
                alert('Error: El carrito está vacío. Por favor recarga la página.');
                return;
            }

            try {
                const websiteSlug = templateConfig.websiteSlug || getWebsiteSlugFromUrl();

                // Obtener datos del cliente autenticado
                const authResponse = await fetch(`/${websiteSlug}/api/check-auth`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                const authData = await authResponse.json();
                console.log('👤 Datos del cliente autenticado:', authData);

                const customerData = {
                    name: authData.user?.name || payload.customer.name || 'Cliente',
                    email: authData.user?.email || 'cliente@tienda.com',
                    phone: payload.customer.phone || authData.user?.phone || ''
                };

                console.log('📝 Datos del cliente a enviar:', customerData);

                // Obtener la dirección seleccionada
                const selectedAddress = CartState.addresses.find(a => a.id == CartState.selectedAddressId);
                
                console.log('🏠 Dirección seleccionada:', selectedAddress);
                console.log('🏠 Address ID seleccionado:', CartState.selectedAddressId);

                const requestBody = {
                    website_slug: websiteSlug,
                    items: payload.cart.map(item => ({
                        product_id: item.id,
                        name: item.name,
                        quantity: item.quantity,
                        price: item.price,
                        iva: item.iva || 0,
                        image: item.image || null
                    })),
                    customer: customerData,
                    shipping_address: {
                        address_id: parseInt(CartState.selectedAddressId), // ID de la dirección en AdminNegocios
                        address: selectedAddress?.address || selectedAddress?.direccion || payload.customer.address,
                        city: selectedAddress?.city || selectedAddress?.ciudad || payload.customer.city,
                        state: selectedAddress?.state || selectedAddress?.barrio || payload.customer.state,
                        phone: customerData.phone,
                        name: customerData.name
                    },
                    billing_address: {
                        address: selectedAddress?.address || selectedAddress?.direccion || payload.customer.address,
                        city: selectedAddress?.city || selectedAddress?.ciudad || payload.customer.city,
                        state: selectedAddress?.state || selectedAddress?.barrio || payload.customer.state,
                        phone: customerData.phone,
                        name: customerData.name
                    },
                    payment_method: 'cash_on_delivery',
                    notes: payload.customer.notes,
                    totals: payload.totals
                };

                console.log('📤 Enviando pedido:', requestBody);

                const response = await fetch(`/${websiteSlug}/checkout/process`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(requestBody)
                });

                const data = await response.json();

                if (data.success) {
                    console.log('✅ Pedido creado exitosamente:', data.order);

                    // Limpiar carrito
                    CartState.items = [];
                    persistCart();
                    localStorage.removeItem('cartCheckoutData');

                    // Determinar el número de pedido a mostrar
                    const orderNumber = data.order.admin_negocios_order_id || data.order.order_number;
                    
                    console.log('🔢 Redirigiendo a pedido:', orderNumber);
                    
                    // Redirigir al detalle del pedido
                    window.location.href = `/${websiteSlug}/order/${orderNumber}`;
                } else {
                    alert(data.message || 'Error al procesar el pedido');
                }
            } catch (error) {
                console.error('Error procesando pedido:', error);
                alert('Error al procesar el pedido. Por favor intenta nuevamente.');
            }
        }

        window.getCartState = function() {
            return CartState;
        };

    })();
</script>