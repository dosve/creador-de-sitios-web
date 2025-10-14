<script>
document.addEventListener("DOMContentLoaded", function() {
    function loadRealProducts() {
        const container = document.getElementById("products-container");
        if (!container) return;

        const apiKey = window.websiteApiKey || "";
        const apiBaseUrl = window.websiteApiUrl || "";

        if (!apiKey || !apiBaseUrl) return;

        container.innerHTML = '<div class="flex items-center justify-center py-12 col-span-full"><div class="text-center"><div class="w-12 h-12 mx-auto mb-4 border-b-2 border-blue-600 rounded-full animate-spin"></div><p class="text-gray-600">Cargando productos...</p></div></div>';

        fetch(apiBaseUrl + "/api-key/products?paginate=6&estado=1", {
            method: "GET",
            headers: {
                "X-API-Key": apiKey,
                "Accept": "application/json"
            }
        })
        .then(response => response.json())
        .then(data => {
            let products = [];
            if (data && data.data && Array.isArray(data.data)) {
                products = data.data;
            } else if (data && data.data) {
                products = Object.values(data.data);
            }
            
            if (products.length > 0) {
                renderRealProducts(container, products);
            }
        })
        .catch(error => {
            console.error("Error cargando productos:", error);
        });
    }

    function renderRealProducts(container, products) {
        const html = products.map(product => `
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                <div class="flex items-center justify-center w-full h-48 mb-4 bg-gray-200 rounded-lg">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="mb-2 text-lg font-semibold text-gray-900">${product.producto || 'Producto'}</h3>
                <p class="mb-4 text-sm text-gray-600 line-clamp-2">${product.descripcion || ''}</p>
                <div class="flex items-center justify-between">
                    <span class="text-lg font-bold text-green-600">$${product.precio || '0.00'}</span>
                    <button class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 add-to-cart" 
                            data-id="${product.id || ''}" 
                            data-name="${product.producto || ''}" 
                            data-price="${product.precio || '0'}" 
                            data-iva="${product.iva || '0'}">
                        Agregar al Carrito
                    </button>
                </div>
            </div>
        `).join("");
        
        container.innerHTML = html;
        
        if (typeof window.reloadCartListeners === "function") {
            window.reloadCartListeners();
        }
    }

    setTimeout(loadRealProducts, 500);
});
</script>

