@props([
    'templateSlug' => 'default',
    'colors' => [],
    'paymentHandler' => 'epayco',
    'websiteSlug' => ''
])

<script>
(function () {
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
        return new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP' }).format(value);
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
                    <p id="address-empty-message" class="hidden text-sm text-red-600 bg-red-50 border border-red-200 px-3 py-2 rounded-lg">
                        No tienes direcciones guardadas. Agrega una para continuar.
                    </p>
                    <button id="add-address-btn" class="text-sm font-medium text-blue-600 hover:text-blue-700">
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
                        <button id="save-new-address" class="px-4 py-2 text-white rounded-lg" style="background-color:${templateConfig.colors.primary}">
                            Guardar dirección
                        </button>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Notas o indicaciones</label>
                    <textarea id="checkout-notes" class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-blue-500" rows="3" placeholder="Ej. Torre 2, apto 401"></textarea>
                </div>
                <div class="mb-4 text-sm text-gray-700">
                    <span class="font-semibold">Total a pagar:</span>
                    <span id="checkout-modal-total" class="text-lg font-bold text-gray-900"></span>
                </div>
                <div id="checkout-modal-error" class="hidden mb-4 text-sm text-red-600 bg-red-50 border border-red-200 px-3 py-2 rounded-lg"></div>
                <div class="flex justify-end space-between">
                    <button id="cancel-checkout-modal" class="mr-3 px-4 py-2 text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200">Cancelar</button>
                    <button id="confirm-checkout-modal" class="px-4 py-2 text-white rounded-lg" style="background-color:${templateConfig.colors.primary}">Confirmar</button>
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
        ensureCheckoutModal();
        const totals = computeTotals();
        const modal = document.getElementById('checkout-modal');
        const totalLabel = document.getElementById('checkout-modal-total');
        const notesField = document.getElementById('checkout-notes');
        const errorLabel = document.getElementById('checkout-modal-error');

        if (totalLabel) totalLabel.textContent = formatCurrency(totals.gross);
        if (errorLabel) errorLabel.classList.add('hidden');

        notesField.value = CartState.checkoutData.notes || '';

        await loadAddresses();
        renderAddressSection();

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    async function loadAddresses(force = false) {
        if (!templateConfig.websiteSlug) {
            console.warn('No se definió el slug del sitio para cargar direcciones.');
            return;
        }

        if (CartState.addresses.length > 0 && !force) return;

        CartState.isLoadingAddresses = true;
        renderAddressSection();

        try {
            const response = await fetch(`/customer/addresses?website=${encodeURIComponent(templateConfig.websiteSlug)}`, {
                headers: { 'Accept': 'application/json' }
            });

            if (!response.ok) throw new Error('No se pudieron obtener las direcciones');
            const data = await response.json();

            if (!data.success) throw new Error(data.message || 'Error cargando direcciones');

            CartState.addresses = data.addresses || [];
            if (CartState.addresses.length > 0 && !CartState.selectedAddressId) {
                CartState.selectedAddressId = CartState.addresses[0].id;
            }
        } catch (error) {
            console.error('Error obteniendo direcciones:', error);
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
        const emptyMessage = document.getElementById('address-empty-message');
        const confirmBtn = document.getElementById('confirm-checkout-modal');

        if (!loading || !wrapper || !emptyMessage || !confirmBtn) return;

        if (CartState.isLoadingAddresses) {
            loading.classList.remove('hidden');
            wrapper.classList.add('hidden');
            emptyMessage.classList.add('hidden');
            confirmBtn.disabled = true;
            return;
        }

        loading.classList.add('hidden');

        if (CartState.addresses.length === 0) {
            wrapper.classList.add('hidden');
            emptyMessage.classList.remove('hidden');
            confirmBtn.disabled = true;
            toggleNewAddressForm(true);
            return;
        }

        emptyMessage.classList.add('hidden');
        wrapper.classList.remove('hidden');
        confirmBtn.disabled = false;

        wrapper.innerHTML = `
            <label class="block text-sm font-medium text-gray-700 mb-1">Selecciona una dirección</label>
            <select id="checkout-address-select" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                ${CartState.addresses.map(address => `
                    <option value="${address.id}" ${address.id == CartState.selectedAddressId ? 'selected' : ''}>
                        ${address.name ? address.name + ' - ' : ''}${address.address}, ${address.city}
                    </option>
                `).join('')}
            </select>
        `;

        document.getElementById('checkout-address-select').addEventListener('change', function () {
            CartState.selectedAddressId = this.value;
        });
    }

    function toggleNewAddressForm(show) {
        const form = document.getElementById('new-address-form');
        const button = document.getElementById('add-address-btn');
        if (!form || !button) return;

        if (show) {
            form.classList.remove('hidden');
            button.classList.add('hidden');
        } else {
            form.classList.add('hidden');
            button.classList.remove('hidden');
        }
    }

    async function saveNewAddress() {
        const confirmBtn = document.getElementById('confirm-checkout-modal');
        const errorBox = document.getElementById('new-address-error');
        if (errorBox) errorBox.classList.add('hidden');

        const data = {
            name: document.getElementById('new-address-name').value.trim(),
            address: document.getElementById('new-address-address').value.trim(),
            city: document.getElementById('new-address-city').value.trim(),
            state: document.getElementById('new-address-state').value.trim(),
            postal_code: document.getElementById('new-address-postal').value.trim(),
            country: document.getElementById('new-address-country').value.trim(),
            phone: document.getElementById('new-address-phone').value.trim(),
            reference: document.getElementById('new-address-reference').value.trim(),
            website: templateConfig.websiteSlug
        };

        if (!data.name || !data.address || !data.city) {
            showNewAddressError('Por favor completa los campos requeridos.');
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
            toggleNewAddressForm(false);
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

    function confirmCheckoutData() {
        const notesField = document.getElementById('checkout-notes');
        const errorLabel = document.getElementById('checkout-modal-error');

        if (!notesField) return;

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

        CartState.checkoutData = {
            addressId: selectedAddress.id,
            address: selectedAddress.address,
            city: selectedAddress.city,
            state: selectedAddress.state,
            phone: selectedAddress.phone,
            name: selectedAddress.name,
            notes: notesField.value.trim()
        };

        localStorage.setItem('cartCheckoutData', JSON.stringify(CartState.checkoutData));
        toggleCheckoutModal(false);
        proceedToPayment();
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
        const totals = computeTotals();
        const payload = {
            cart: CartState.items.map(item => ({ ...item })),
            totals,
            customer: {
                ...CartState.checkoutData
            }
        };

        const handler = window.PaymentHandlers?.[templateConfig.paymentHandler];

        if (handler && typeof handler.checkout === 'function') {
            handler.checkout(payload);
        } else {
            alert('No hay pasarela de pago configurada.');
        }
    }

    window.getCartState = function () {
        return CartState;
    };

})();
</script>

