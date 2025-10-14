<script>
document.addEventListener("DOMContentLoaded", function() {
    const cartButton = document.getElementById("cart-button");
    const cartSidebar = document.getElementById("cart-sidebar");
    const cartOverlay = document.getElementById("cart-overlay");
    const closeCartBtn = document.getElementById("close-cart");
    const cartItems = document.getElementById("cart-items");
    const cartTotal = document.getElementById("cart-total");
    const checkoutBtn = document.getElementById("checkout-btn");
    const cartCounter = document.getElementById("cart-counter");

    const to2 = n => (Math.round(n * 100) / 100);
    let cart = [];

    function applyDiscountGross(gross, pct = 0) {
        return gross * (1 - (pct / 100));
    }

    function lineAmounts(it) {
        const ivaRate = (parseFloat(it.iva) || 0) / 100;
        const unitGross = applyDiscountGross(parseFloat(it.price || 0), parseFloat(it.discountPct || 0));
        const unitBase = ivaRate > 0 ? unitGross / (1 + ivaRate) : unitGross;
        const unitIva = unitGross - unitBase;
        return { unitGross: to2(unitGross), unitBase: to2(unitBase), unitIva: to2(unitIva), ivaRate };
    }

    function computeTotals(cart) {
        let gross = 0, base = 0, iva = 0;
        for (const it of cart) {
            const { unitGross, unitBase, unitIva } = lineAmounts(it);
            const qty = parseInt(it.quantity || 1, 10);
            gross += unitGross * qty;
            base += unitBase * qty;
            iva += unitIva * qty;
        }
        return { gross: to2(gross), taxBase: to2(base), tax: to2(iva), taxIco: to2(0) };
    }

    function openCart() {
        if (cartSidebar && cartOverlay) {
            cartSidebar.classList.remove("translate-x-full");
            cartOverlay.classList.remove("hidden");
            document.body.style.overflow = "hidden";
        }
    }

    function closeCart() {
        if (cartSidebar && cartOverlay) {
            cartSidebar.classList.add("translate-x-full");
            cartOverlay.classList.add("hidden");
            document.body.style.overflow = "auto";
        }
    }

    function updateCartCounter() {
        if (cartCounter) {
            const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
            cartCounter.textContent = totalItems;
        }
    }

    function updateCartTotal() {
        if (cartTotal && checkoutBtn) {
            const totals = computeTotals(cart);
            cartTotal.textContent = `$${totals.gross.toFixed(2)}`;
            checkoutBtn.disabled = cart.length === 0;
        }
    }

    function renderCartItems() {
        if (!cartItems) return;
        
        if (cart.length === 0) {
            cartItems.innerHTML = '<div class="py-8 text-center text-gray-500"><p>Tu carrito está vacío</p></div>';
            return;
        }

        cartItems.innerHTML = cart.map((item, index) => `
            <div class="flex items-center p-3 space-x-3 rounded-lg bg-gray-50">
                <div class="flex-1">
                    <h4 class="font-medium text-gray-900">${item.name}</h4>
                    <p class="text-sm text-gray-600">$${item.price.toFixed(2)}</p>
                </div>
                <div class="flex items-center space-x-2">
                    <button onclick="updateQuantity(${index}, -1)" class="w-8 h-8 bg-gray-200 rounded-full">-</button>
                    <span class="w-8 text-center">${item.quantity}</span>
                    <button onclick="updateQuantity(${index}, 1)" class="w-8 h-8 bg-gray-200 rounded-full">+</button>
                </div>
                <button onclick="removeFromCart(${index})" class="text-red-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </div>
        `).join("");
    }

    function addToCart(productData) {
        const existingItem = cart.find(item => item.id === productData.id);
        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            cart.push({
                id: productData.id,
                name: productData.name,
                price: parseFloat(productData.price),
                iva: parseFloat(productData.iva || 0),
                quantity: 1
            });
        }
        updateCartCounter();
        updateCartTotal();
        renderCartItems();
    }

    window.updateQuantity = function(index, change) {
        cart[index].quantity += change;
        if (cart[index].quantity <= 0) {
            cart.splice(index, 1);
        }
        updateCartCounter();
        updateCartTotal();
        renderCartItems();
    };

    window.removeFromCart = function(index) {
        cart.splice(index, 1);
        updateCartCounter();
        updateCartTotal();
        renderCartItems();
    };

    if (cartButton) cartButton.addEventListener("click", openCart);
    if (closeCartBtn) closeCartBtn.addEventListener("click", closeCart);
    if (cartOverlay) cartOverlay.addEventListener("click", closeCart);

    window.addToCart = addToCart;
    window.reloadCartListeners = function() {
        document.querySelectorAll(".add-to-cart").forEach(button => {
            button.addEventListener("click", function() {
                addToCart({
                    id: this.getAttribute("data-id"),
                    name: this.getAttribute("data-name"),
                    price: this.getAttribute("data-price"),
                    iva: this.getAttribute("data-iva")
                });
            });
        });
    };

    updateCartCounter();
    updateCartTotal();
    renderCartItems();
    window.reloadCartListeners();
});
</script>

