@props([
'templateSlug' => 'default',
'colors' => [],
'paymentHandler' => 'epayco',
'websiteSlug' => ''
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
            websiteSlug: "{{ $websiteSlug }}"
        };

        const CartState = {
            items: [],
            checkoutData: JSON.parse(localStorage.getItem('cartCheckoutData') || '{}'),
            addresses: [],
            selectedAddressId: null,
            isLoadingAddresses: false
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
                            class="w-full py-3 text-white font-semibold rounded-lg disabled:bg-gray-300"
                            style="background-color:${templateConfig.colors.primary}"
                            disabled>
                        Proceder al Pago
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
            modal.className = 'fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50';
            modal.innerHTML = `
            <div class="relative w-full max-w-2xl p-6 bg-white rounded-lg shadow-xl">
                <button id="close-checkout-modal" class="absolute text-gray-400 top-4 right-4 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                <h2 class="mb-2 text-2xl font-bold text-gray-900">Datos para el envío</h2>
                <p class="mb-4 text-sm text-gray-600">Selecciona una dirección de entrega o crea una nueva.</p>

                <div id="address-section" class="space-y-3 mb-6">
                    <div id="address-loading" class="text-sm text-gray-500">Cargando direcciones...</div>
                    <div id="address-select-wrapper" class="hidden"></div>
                    <p id="address-empty-message" class="hidden text-sm text-orange-600 bg-orange-50 border border-orange-200 px-3 py-2 rounded-lg">
                        ⚠️ No tienes direcciones guardadas. Haz clic en "Añadir dirección" para crear una.
                    </p>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Método de pago *</label>
                    <select id="checkout-payment-method" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                        <option value="">Seleccionar método de pago</option>
                        <option value="Efectivo">Efectivo</option>
                        <option value="Nequi/Daviplata">Nequi/Daviplata</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Notas o indicaciones</label>
                    <textarea id="checkout-notes" class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-blue-500" rows="3" placeholder="Ej. Torre 2, apto 401"></textarea>
                </div>
                <div class="mb-4 text-sm text-gray-700">
                    <span class="font-semibold">Total a pagar:</span>
                    <span id="checkout-modal-total" class="text-lg font-bold text-gray-900"></span>
                </div>
                <div id="checkout-modal-error" class="hidden mb-4 text-sm text-red-600 bg-red-50 border border-red-200 px-3 py-2 rounded-lg"></div>
                <div class="flex justify-between items-center">
                    <button id="add-address-btn" class="hidden px-4 py-2 text-blue-600 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 transition-colors font-medium">
                        + Añadir dirección
                    </button>
                    <div class="flex ml-auto space-x-3">
                        <button id="cancel-checkout-modal" class="px-4 py-2 text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200">Cancelar</button>
                        <button id="confirm-checkout-modal" class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700">Confirmar Pedido</button>
                    </div>
                </div>
            </div>
        `;
            document.body.appendChild(modal);

            document.getElementById('close-checkout-modal').addEventListener('click', () => toggleCheckoutModal(false));
            document.getElementById('cancel-checkout-modal').addEventListener('click', () => toggleCheckoutModal(false));
            document.getElementById('confirm-checkout-modal').addEventListener('click', confirmCheckoutData);
            document.getElementById('add-address-btn').addEventListener('click', () => openAddressModal());

            // Crear modal de dirección separado
            createAddressModal();
        }

        function createAddressModal() {
            if (document.getElementById('address-modal')) return;

            const modal = document.createElement('div');
            modal.id = 'address-modal';
            modal.className = 'fixed inset-0 z-[60] hidden items-center justify-center bg-black bg-opacity-50';
            modal.innerHTML = `
            <div class="relative w-full max-w-2xl p-6 bg-white rounded-lg shadow-xl max-h-[90vh] overflow-y-auto">
                <button id="close-address-modal" class="absolute text-gray-400 top-4 right-4 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                <h2 class="mb-4 text-2xl font-bold text-gray-900">Nueva Dirección de Envío</h2>
                <p class="mb-6 text-sm text-gray-600">Completa los datos de tu dirección de entrega.</p>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Dirección completa *</label>
                        <textarea id="new-address-address" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" placeholder="Ej. Calle 123 #45-67, Torre 2, apto 401" required></textarea>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ciudad *</label>
                            <input id="new-address-city" type="text" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" placeholder="Ej. Bogotá" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Barrio *</label>
                            <input id="new-address-barrio" type="text" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" placeholder="Ej. Chapinero" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Código Postal</label>
                        <input id="new-address-postal" type="text" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" placeholder="Opcional">
                    </div>
                    <div id="new-address-error" class="hidden text-sm text-red-600 bg-red-50 border border-red-200 px-3 py-2 rounded-lg"></div>
                </div>
                
                <div class="flex justify-end mt-6 space-x-3">
                    <button id="cancel-new-address" class="px-6 py-2 text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200">Cancelar</button>
                    <button id="save-new-address" class="px-6 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700">Guardar dirección</button>
                </div>
            </div>
        `;
            document.body.appendChild(modal);

            document.getElementById('close-address-modal').addEventListener('click', () => toggleAddressModal(false));
            document.getElementById('cancel-new-address').addEventListener('click', () => toggleAddressModal(false));
            document.getElementById('save-new-address').addEventListener('click', saveNewAddress);
        }

        function openAddressModal() {
            toggleAddressModal(true);
        }

        function toggleAddressModal(show) {
            const modal = document.getElementById('address-modal');
            if (!modal) return;

            if (show) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            } else {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }

        async function openCheckoutModal() {
            console.log('🚀 === ABRIENDO MODAL DE CHECKOUT ===');
            console.log('🔧 templateConfig:', templateConfig);

            // Verificar si el usuario está autenticado
            try {
                const response = await fetch('/customer/check');
                const data = await response.json();

                console.log('👤 Usuario autenticado:', data.authenticated);

                if (!data.authenticated || !data.customer) {
                    // Usuario no autenticado, mostrar modal de login
                    console.warn('⚠️ Usuario no autenticado, mostrando login');
                    if (typeof showLoginModal === 'function') {
                        showLoginModal();
                        showToast('Debes iniciar sesión para realizar una compra', 'warning');
                    } else {
                        alert('Debes iniciar sesión para realizar una compra');
                    }
                    return;
                }
            } catch (error) {
                console.error('❌ Error al verificar autenticación:', error);
                if (typeof showLoginModal === 'function') {
                    showLoginModal();
                    showToast('Debes iniciar sesión para realizar una compra', 'warning');
                } else {
                    alert('Debes iniciar sesión para realizar una compra');
                }
                return;
            }

            console.log('✅ Usuario autenticado, continuando con checkout');

            // Usuario autenticado, continuar con el checkout
            ensureCheckoutModal();
            const totals = computeTotals();
            const modal = document.getElementById('checkout-modal');
            const totalLabel = document.getElementById('checkout-modal-total');
            const notesField = document.getElementById('checkout-notes');
            const errorLabel = document.getElementById('checkout-modal-error');

            if (totalLabel) totalLabel.textContent = formatCurrency(totals.gross);
            if (errorLabel) errorLabel.classList.add('hidden');

            notesField.value = CartState.checkoutData.notes || '';

            console.log('📍 === INICIANDO CARGA DE DIRECCIONES ===');
            await loadAddresses();
            console.log('📍 === DIRECCIONES CARGADAS, RENDERIZANDO ===');
            renderAddressSection();

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        async function loadAddresses(force = false) {
            console.log('🔍 === loadAddresses EJECUTÁNDOSE ===');
            console.log('🔧 templateConfig.websiteSlug:', templateConfig.websiteSlug);
            console.log('🔧 CartState.addresses:', CartState.addresses);
            console.log('🔧 force:', force);

            if (!templateConfig.websiteSlug) {
                console.error('❌ ERROR: No se definió el slug del sitio para cargar direcciones.');
                console.error('❌ templateConfig completo:', templateConfig);
                alert('ERROR: No se definió el slug del sitio. templateConfig.websiteSlug = ' + templateConfig.websiteSlug);
                return;
            }

            if (CartState.addresses.length > 0 && !force) {
                console.log('📍 Direcciones ya cargadas:', CartState.addresses.length);
                return;
            }

            CartState.isLoadingAddresses = true;
            renderAddressSection();

            try {
                const url = `/customer/addresses?website=${encodeURIComponent(templateConfig.websiteSlug)}`;
                console.log('📍 === HACIENDO PETICIÓN DE DIRECCIONES ===');
                console.log('📍 URL:', url);

                const response = await fetch(url, {
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                console.log('📡 Respuesta direcciones:', {
                    status: response.status,
                    ok: response.ok,
                    contentType: response.headers.get('content-type')
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
            const confirmBtn = document.getElementById('confirm-checkout-modal');
            const errorBox = document.getElementById('new-address-error');
            if (errorBox) errorBox.classList.add('hidden');

            const data = {
                direccion: document.getElementById('new-address-address').value.trim(),
                ciudad: document.getElementById('new-address-city').value.trim(),
                barrio: document.getElementById('new-address-barrio').value.trim(),
                codigo_postal: document.getElementById('new-address-postal').value.trim(),
                website: templateConfig.websiteSlug
            };

            if (!data.direccion || !data.ciudad || !data.barrio) {
                showNewAddressError('Por favor completa los campos requeridos (dirección, ciudad y barrio).');
                return;
            }

            try {
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
                toggleAddressModal(false);
                renderAddressSection();
                showToast('Dirección guardada correctamente');
            } catch (error) {
                console.error('Error guardando dirección:', error);
                showNewAddressError(error.message);
            } finally {
                if (confirmBtn) confirmBtn.disabled = CartState.addresses.length === 0;
            }
        }

        function showNewAddressError(message) {
            const errorBox = document.getElementById('new-address-error');
            if (!errorBox) return;
            errorBox.textContent = message;
            errorBox.classList.remove('hidden');
        }

        async function confirmCheckoutData() {
            const notesField = document.getElementById('checkout-notes');
            const paymentMethodField = document.getElementById('checkout-payment-method');
            const errorLabel = document.getElementById('checkout-modal-error');
            const confirmBtn = document.getElementById('confirm-checkout-modal');

            if (!notesField || !paymentMethodField) return;

            // Validar dirección
            if (!CartState.selectedAddressId) {
                if (errorLabel) {
                    errorLabel.textContent = 'Selecciona o crea una dirección antes de continuar.';
                    errorLabel.classList.remove('hidden');
                }
                return;
            }

            // Validar método de pago
            if (!paymentMethodField.value) {
                if (errorLabel) {
                    errorLabel.textContent = 'Selecciona un método de pago.';
                    errorLabel.classList.remove('hidden');
                }
                paymentMethodField.focus();
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

            if (CartState.items.length === 0) {
                if (errorLabel) {
                    errorLabel.textContent = 'Tu carrito está vacío.';
                    errorLabel.classList.remove('hidden');
                }
                return;
            }

            // Deshabilitar botón durante el proceso
            if (confirmBtn) {
                confirmBtn.disabled = true;
                confirmBtn.textContent = 'Procesando...';
            }

            // Ocultar errores previos
            if (errorLabel) errorLabel.classList.add('hidden');

            console.log('🚀 === ENVIANDO PEDIDO AL BACKEND ===');

            try {
                // Obtener datos del usuario autenticado
                const userCheckResponse = await fetch('/customer/check');
                const userData = await userCheckResponse.json();

                if (!userData.authenticated || !userData.customer) {
                    throw new Error('Sesión expirada. Por favor, inicia sesión nuevamente.');
                }

                console.log('👤 Usuario autenticado:', userData.customer);

                // Preparar productos en el formato que espera el backend
                const productosTransformados = CartState.items.map(item => ({
                    id_producto: item.id,
                    producto: item.name,
                    precio: parseFloat(item.price),
                    cantidad: item.quantity,
                    img: item.img || null
                }));

                // Obtener el id_negocio desde window (configurado globalmente)
                // O desde el primer producto del carrito
                let idNegocio = window.businessId || null;

                // Si no está configurado, intentar obtenerlo del primer producto
                if (!idNegocio && CartState.items.length > 0) {
                    // Hacer petición para obtener el negocio del primer producto
                    const firstProductId = CartState.items[0].id;
                    try {
                        const productResponse = await fetch(`${window.websiteApiUrl}/api-key/products/${firstProductId}`, {
                            headers: {
                                'X-API-Key': window.websiteApiKey,
                                'Accept': 'application/json'
                            }
                        });
                        const productData = await productResponse.json();
                        if (productData.success && productData.data) {
                            idNegocio = productData.data.id_negocio;
                            console.log('🏪 Negocio detectado del producto:', idNegocio);
                        }
                    } catch (e) {
                        console.warn('⚠️ No se pudo obtener el negocio del producto:', e);
                    }
                }

                // Si aún no tenemos id_negocio, usar el default (80)
                if (!idNegocio) {
                    idNegocio = 80;
                    console.warn('⚠️ Usando id_negocio por defecto: 80');
                }

                // Preparar payload completo (igual que en la app móvil)
                const payload = {
                    id_direccion: parseInt(selectedAddress.id),
                    medio_pago: paymentMethodField.value, // Método de pago seleccionado
                    observaciones: notesField.value.trim() || '',
                    productos: productosTransformados,
                    user_id: userData.customer.id, // ID del usuario en AdminNegocios
                    id_negocio: idNegocio, // ID del negocio detectado o default
                    origen: 'web-mash'
                };

                console.log('📦 Payload del pedido:', payload);

                // Construir URL del endpoint correcto
                // websiteApiUrl puede ser: http://127.0.0.1:8001/api o http://127.0.0.1:8001/api/segundos
                let baseUrl = window.websiteApiUrl;

                // Remover /segundos si existe
                if (baseUrl.endsWith('/segundos')) {
                    baseUrl = baseUrl.replace('/segundos', '');
                }

                // Agregar /api-key/orders
                const orderUrl = `${baseUrl}/api-key/orders`;

                console.log('📡 websiteApiUrl original:', window.websiteApiUrl);
                console.log('📡 URL construida para pedido:', orderUrl);

                // Enviar al backend
                const response = await fetch(orderUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-API-Key': window.websiteApiKey || '',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });

                console.log('📡 Respuesta del servidor:', {
                    status: response.status,
                    ok: response.ok
                });

                const result = await response.json();
                console.log('✅ Resultado:', result);

                if (response.ok && result.success) {
                    // ÉXITO: Pedido creado
                    console.log('🎉 Pedido creado exitosamente:', result);

                    // Cerrar modal de checkout
                    toggleCheckoutModal(false);

                    // Limpiar carrito
                    CartState.items = [];
                    localStorage.removeItem('cart');
                    localStorage.removeItem('cartCheckoutData');
                    renderCart();

                    // Mostrar alerta de éxito
                    showOrderSuccessAlert(result.data);
                } else {
                    // ERROR: Mostrar mensaje
                    throw new Error(result.message || 'No se pudo crear el pedido');
                }
            } catch (error) {
                console.error('❌ Error al crear el pedido:', error);

                // Mostrar error en el modal
                if (errorLabel) {
                    errorLabel.textContent = error.message || 'Error al procesar el pedido. Por favor, intenta nuevamente.';
                    errorLabel.classList.remove('hidden');
                }
            } finally {
                // Rehabilitar botón
                if (confirmBtn) {
                    confirmBtn.disabled = false;
                    confirmBtn.textContent = 'Confirmar Pedido';
                }
            }
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

        function showOrderSuccessAlert(orderData) {
            // Crear modal de éxito
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 z-[70] flex items-center justify-center bg-black bg-opacity-50';
            modal.innerHTML = `
            <div class="relative w-full max-w-md p-8 bg-white rounded-lg shadow-xl text-center">
                <div class="mb-4">
                    <svg class="w-16 h-16 mx-auto text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h2 class="mb-2 text-2xl font-bold text-gray-900">¡Pedido Realizado!</h2>
                <p class="mb-6 text-gray-600">Tu pedido ha sido creado exitosamente.</p>
                <p class="mb-6 text-sm text-gray-500">Número de pedido: <strong>${orderData?.id || 'N/A'}</strong></p>
                <div class="flex flex-col space-y-3">
                    <button id="view-order-detail" class="px-6 py-3 text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                        Ver Detalle del Pedido
                    </button>
                    <button id="continue-shopping" class="px-6 py-3 text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200">
                        Seguir Comprando
                    </button>
                </div>
            </div>
        `;
            document.body.appendChild(modal);

            // Eventos de los botones
            document.getElementById('view-order-detail').addEventListener('click', () => {
                const websiteSlug = templateConfig.websiteSlug || 'sitio';
                window.location.href = `/${websiteSlug}/profile#pedidos`;
            });

            document.getElementById('continue-shopping').addEventListener('click', () => {
                document.body.removeChild(modal);
                const websiteSlug = templateConfig.websiteSlug || 'sitio';
                window.location.href = `/${websiteSlug}`;
            });
        }

        function showOrderErrorAlert(errorMessage) {
            // Crear modal de error
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 z-[70] flex items-center justify-center bg-black bg-opacity-50';
            modal.innerHTML = `
            <div class="relative w-full max-w-md p-8 bg-white rounded-lg shadow-xl text-center">
                <div class="mb-4">
                    <svg class="w-16 h-16 mx-auto text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h2 class="mb-2 text-2xl font-bold text-gray-900">Error al Procesar</h2>
                <p class="mb-6 text-gray-600">${errorMessage || 'No se pudo crear el pedido'}</p>
                <button id="close-error-alert" class="px-6 py-3 text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                    Intentar Nuevamente
                </button>
            </div>
        `;
            document.body.appendChild(modal);

            // Evento del botón
            document.getElementById('close-error-alert').addEventListener('click', () => {
                document.body.removeChild(modal);
            });
        }

        window.getCartState = function() {
            return CartState;
        };

    })();
</script>