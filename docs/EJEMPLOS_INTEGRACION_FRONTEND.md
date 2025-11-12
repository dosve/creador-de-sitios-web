# Ejemplos de Integración Frontend

Este documento contiene ejemplos prácticos de cómo integrar el sistema de login y checkout en el frontend de tu tienda.

## 1. Formulario de Login

### HTML

```html
<!-- Modal de Login -->
<div id="loginModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Iniciar Sesión</h2>
        
        <form id="loginForm">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div id="loginError" class="error-message" style="display:none;"></div>
            
            <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
        </form>
        
        <p class="text-center mt-3">
            ¿No tienes cuenta? <a href="#" id="showRegister">Regístrate aquí</a>
        </p>
    </div>
</div>
```

### JavaScript

```javascript
// Obtener el slug de la tienda desde el DOM o configuración
const WEBSITE_SLUG = document.querySelector('meta[name="website-slug"]')?.content || 'mi-tienda';

// Manejo del formulario de login
document.getElementById('loginForm')?.addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const errorDiv = document.getElementById('loginError');
    
    // Ocultar errores previos
    errorDiv.style.display = 'none';
    
    try {
        const response = await fetch('/customer/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                email: email,
                password: password,
                website_slug: WEBSITE_SLUG
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Login exitoso
            console.log('Bienvenido:', data.customer.name);
            
            // Cerrar modal
            document.getElementById('loginModal').style.display = 'none';
            
            // Actualizar UI
            updateUserInterface(data.customer);
            
            // Redirigir si es necesario
            const redirectUrl = sessionStorage.getItem('redirect_after_login');
            if (redirectUrl) {
                sessionStorage.removeItem('redirect_after_login');
                window.location.href = redirectUrl;
            } else {
                // Recargar para actualizar la UI
                window.location.reload();
            }
        } else {
            // Mostrar error
            errorDiv.textContent = data.message;
            errorDiv.style.display = 'block';
        }
    } catch (error) {
        console.error('Error:', error);
        errorDiv.textContent = 'Error al procesar el login. Por favor, intenta nuevamente.';
        errorDiv.style.display = 'block';
    }
});
```

## 2. Formulario de Registro

### HTML

```html
<!-- Modal de Registro -->
<div id="registerModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Crear Cuenta</h2>
        
        <form id="registerForm">
            <div class="form-group">
                <label for="reg_name">Nombre Completo:</label>
                <input type="text" id="reg_name" name="name" required>
            </div>
            
            <div class="form-group">
                <label for="reg_email">Email:</label>
                <input type="email" id="reg_email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="reg_phone">Teléfono:</label>
                <input type="tel" id="reg_phone" name="phone" required>
            </div>
            
            <div class="form-group">
                <label for="reg_password">Contraseña:</label>
                <input type="password" id="reg_password" name="password" required minlength="6">
            </div>
            
            <div class="form-group">
                <label for="reg_password_confirm">Confirmar Contraseña:</label>
                <input type="password" id="reg_password_confirm" name="password_confirm" required minlength="6">
            </div>
            
            <div id="registerError" class="error-message" style="display:none;"></div>
            
            <button type="submit" class="btn btn-primary">Registrarse</button>
        </form>
        
        <p class="text-center mt-3">
            ¿Ya tienes cuenta? <a href="#" id="showLogin">Inicia sesión aquí</a>
        </p>
    </div>
</div>
```

### JavaScript

```javascript
document.getElementById('registerForm')?.addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const name = document.getElementById('reg_name').value;
    const email = document.getElementById('reg_email').value;
    const phone = document.getElementById('reg_phone').value;
    const password = document.getElementById('reg_password').value;
    const passwordConfirm = document.getElementById('reg_password_confirm').value;
    const errorDiv = document.getElementById('registerError');
    
    // Validar contraseñas
    if (password !== passwordConfirm) {
        errorDiv.textContent = 'Las contraseñas no coinciden';
        errorDiv.style.display = 'block';
        return;
    }
    
    errorDiv.style.display = 'none';
    
    try {
        const response = await fetch('/customer/register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                name: name,
                email: email,
                phone: phone,
                password: password,
                website_slug: WEBSITE_SLUG
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Registro y login exitoso
            console.log('Registro exitoso:', data.customer.name);
            
            // Cerrar modal
            document.getElementById('registerModal').style.display = 'none';
            
            // Actualizar UI
            updateUserInterface(data.customer);
            
            // Redirigir
            window.location.reload();
        } else {
            errorDiv.textContent = data.message;
            errorDiv.style.display = 'block';
        }
    } catch (error) {
        console.error('Error:', error);
        errorDiv.textContent = 'Error al procesar el registro. Por favor, intenta nuevamente.';
        errorDiv.style.display = 'block';
    }
});
```

## 3. Verificar Estado de Autenticación

### JavaScript

```javascript
// Verificar autenticación al cargar la página
async function checkAuthStatus() {
    try {
        const response = await fetch('/customer/check');
        const data = await response.json();
        
        if (data.authenticated) {
            // Usuario autenticado
            updateUserInterface(data.customer);
            return true;
        } else {
            // Usuario no autenticado
            showGuestInterface();
            return false;
        }
    } catch (error) {
        console.error('Error al verificar autenticación:', error);
        return false;
    }
}

// Actualizar interfaz para usuario autenticado
function updateUserInterface(customer) {
    // Mostrar nombre de usuario
    const userNameElement = document.getElementById('userName');
    if (userNameElement) {
        userNameElement.textContent = customer.name;
    }
    
    // Mostrar menú de usuario
    document.getElementById('guestMenu')?.classList.add('d-none');
    document.getElementById('userMenu')?.classList.remove('d-none');
    
    // Pre-llenar formularios de checkout
    document.getElementById('checkout_name')?.setAttribute('value', customer.name);
    document.getElementById('checkout_email')?.setAttribute('value', customer.email);
    document.getElementById('checkout_phone')?.setAttribute('value', customer.phone || '');
}

// Mostrar interfaz de invitado
function showGuestInterface() {
    document.getElementById('userMenu')?.classList.add('d-none');
    document.getElementById('guestMenu')?.classList.remove('d-none');
}

// Llamar al cargar la página
document.addEventListener('DOMContentLoaded', () => {
    checkAuthStatus();
});
```

## 4. Proceso de Checkout

### HTML

```html
<form id="checkoutForm">
    <h3>Información del Cliente</h3>
    
    <!-- Mostrar si no está autenticado -->
    <div id="guestCheckoutInfo" class="alert alert-info">
        ¿Ya tienes cuenta? <a href="#" id="loginBeforeCheckout">Inicia sesión</a> para un checkout más rápido.
    </div>
    
    <div class="form-group">
        <label for="checkout_name">Nombre Completo:</label>
        <input type="text" id="checkout_name" name="name" required>
    </div>
    
    <div class="form-group">
        <label for="checkout_email">Email:</label>
        <input type="email" id="checkout_email" name="email" required>
    </div>
    
    <div class="form-group">
        <label for="checkout_phone">Teléfono:</label>
        <input type="tel" id="checkout_phone" name="phone" required>
    </div>
    
    <h3>Dirección de Envío</h3>
    
    <div class="form-group">
        <label for="address">Dirección:</label>
        <input type="text" id="address" name="address" required>
    </div>
    
    <div class="form-group">
        <label for="city">Ciudad:</label>
        <input type="text" id="city" name="city" required>
    </div>
    
    <div class="form-group">
        <label for="state">Departamento:</label>
        <input type="text" id="state" name="state" required>
    </div>
    
    <div class="form-group">
        <label for="postal_code">Código Postal:</label>
        <input type="text" id="postal_code" name="postal_code">
    </div>
    
    <h3>Método de Pago</h3>
    
    <div class="form-group">
        <label>
            <input type="radio" name="payment_method" value="epayco" checked>
            ePayco (Tarjeta de crédito/débito)
        </label>
    </div>
    
    <div class="form-group">
        <label>
            <input type="radio" name="payment_method" value="contraentrega">
            Pago contra entrega
        </label>
    </div>
    
    <h3>Resumen de la Orden</h3>
    <div id="orderSummary"></div>
    
    <button type="submit" class="btn btn-primary btn-lg">Finalizar Compra</button>
</form>
```

### JavaScript

```javascript
// Obtener carrito del localStorage o sesión
function getCart() {
    const cartStr = localStorage.getItem('cart');
    return cartStr ? JSON.parse(cartStr) : [];
}

// Procesar checkout
document.getElementById('checkoutForm')?.addEventListener('submit', async (e) => {
    e.preventDefault();
    
    // Obtener datos del formulario
    const formData = {
        website_slug: WEBSITE_SLUG,
        items: getCart().map(item => ({
            product_id: item.id,
            name: item.name,
            quantity: item.quantity,
            price: item.price
        })),
        customer: {
            name: document.getElementById('checkout_name').value,
            email: document.getElementById('checkout_email').value,
            phone: document.getElementById('checkout_phone').value,
        },
        shipping_address: {
            address: document.getElementById('address').value,
            city: document.getElementById('city').value,
            state: document.getElementById('state').value,
            postal_code: document.getElementById('postal_code').value,
            country: 'Colombia'
        },
        payment_method: document.querySelector('input[name="payment_method"]:checked').value,
        tax_amount: calculateTax(),
        shipping_amount: calculateShipping(),
    };
    
    // Agregar dirección de facturación si es diferente
    formData.billing_address = formData.shipping_address;
    
    try {
        // Mostrar loader
        showLoader('Procesando tu orden...');
        
        const response = await fetch(`/${WEBSITE_SLUG}/checkout/process`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(formData)
        });
        
        const data = await response.json();
        
        hideLoader();
        
        if (data.success) {
            // Orden creada exitosamente
            console.log('Orden creada:', data.order);
            
            // Limpiar carrito
            localStorage.removeItem('cart');
            
            // Redirigir a página de confirmación
            window.location.href = `/${WEBSITE_SLUG}/order/${data.order.order_number}?success=1`;
            
            // O si el pago es con ePayco, redirigir a su plataforma
            if (data.order.payment_url) {
                window.location.href = data.order.payment_url;
            }
        } else {
            alert('Error: ' + data.message);
        }
    } catch (error) {
        hideLoader();
        console.error('Error:', error);
        alert('Error al procesar la orden. Por favor, intenta nuevamente.');
    }
});

// Funciones auxiliares
function calculateTax() {
    const cart = getCart();
    const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    return subtotal * 0.19; // IVA 19%
}

function calculateShipping() {
    return 10000; // Envío fijo
}

function showLoader(message) {
    // Implementar según tu diseño
    document.getElementById('loader').style.display = 'block';
}

function hideLoader() {
    document.getElementById('loader').style.display = 'none';
}
```

## 5. Página de Mis Órdenes

### HTML

```html
<div class="container my-orders-page">
    <h1>Mis Órdenes</h1>
    
    <div id="ordersContainer">
        <!-- Las órdenes se cargarán dinámicamente -->
        <div class="loading">Cargando órdenes...</div>
    </div>
</div>
```

### JavaScript

```javascript
async function loadMyOrders() {
    const container = document.getElementById('ordersContainer');
    
    try {
        // Verificar autenticación
        const authCheck = await fetch('/customer/check');
        const authData = await authCheck.json();
        
        if (!authData.authenticated) {
            container.innerHTML = `
                <div class="alert alert-warning">
                    Debes <a href="#" onclick="showLoginModal()">iniciar sesión</a> para ver tus órdenes.
                </div>
            `;
            return;
        }
        
        // Cargar órdenes
        const response = await fetch(`/${WEBSITE_SLUG}/my-orders`);
        const html = await response.text();
        
        // Si es una respuesta HTML completa, extraer solo el contenido necesario
        container.innerHTML = html;
        
    } catch (error) {
        console.error('Error:', error);
        container.innerHTML = `
            <div class="alert alert-danger">
                Error al cargar las órdenes. Por favor, intenta nuevamente.
            </div>
        `;
    }
}

// Cargar al iniciar la página
document.addEventListener('DOMContentLoaded', () => {
    if (window.location.pathname.includes('/my-orders')) {
        loadMyOrders();
    }
});
```

## 6. Widget de Usuario en el Header

### HTML

```html
<nav class="navbar">
    <div class="navbar-brand">
        <a href="/">Mi Tienda</a>
    </div>
    
    <div class="navbar-menu">
        <!-- Para usuarios no autenticados -->
        <div id="guestMenu">
            <button onclick="showLoginModal()" class="btn btn-outline">Iniciar Sesión</button>
            <button onclick="showRegisterModal()" class="btn btn-primary">Registrarse</button>
        </div>
        
        <!-- Para usuarios autenticados -->
        <div id="userMenu" class="d-none">
            <div class="dropdown">
                <button class="btn btn-link dropdown-toggle">
                    <i class="icon-user"></i>
                    <span id="userName">Usuario</span>
                </button>
                <div class="dropdown-menu">
                    <a href="/${WEBSITE_SLUG}/my-orders">Mis Órdenes</a>
                    <a href="#" onclick="customerLogout()">Cerrar Sesión</a>
                </div>
            </div>
        </div>
        
        <!-- Carrito (siempre visible) -->
        <a href="/cart" class="btn btn-outline">
            <i class="icon-cart"></i>
            <span id="cartCount">0</span>
        </a>
    </div>
</nav>
```

### JavaScript

```javascript
// Logout
async function customerLogout() {
    try {
        const response = await fetch('/customer/logout', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Recargar página
            window.location.reload();
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

// Mostrar modales
function showLoginModal() {
    document.getElementById('loginModal').style.display = 'block';
}

function showRegisterModal() {
    document.getElementById('registerModal').style.display = 'block';
}
```

## 7. CSS Básico para Modales

```css
/* Estilos para modales */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
    background-color: #fff;
    margin: 10% auto;
    padding: 30px;
    border: 1px solid #888;
    border-radius: 8px;
    width: 90%;
    max-width: 500px;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.close:hover,
.close:focus {
    color: #000;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: 500;
}

.form-group input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 16px;
}

.error-message {
    background-color: #f8d7da;
    color: #721c24;
    padding: 10px;
    border-radius: 4px;
    margin-bottom: 15px;
}

.btn {
    padding: 12px 24px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s;
}

.btn-primary {
    background-color: #007bff;
    color: white;
}

.btn-primary:hover {
    background-color: #0056b3;
}

.d-none {
    display: none !important;
}
```

## 8. Integración con Carrito de Compras

```javascript
// Clase para manejar el carrito
class ShoppingCart {
    constructor() {
        this.items = this.loadCart();
    }
    
    loadCart() {
        const cartStr = localStorage.getItem('cart');
        return cartStr ? JSON.parse(cartStr) : [];
    }
    
    saveCart() {
        localStorage.setItem('cart', JSON.stringify(this.items));
        this.updateCartUI();
    }
    
    addItem(product, quantity = 1) {
        const existingItem = this.items.find(item => item.id === product.id);
        
        if (existingItem) {
            existingItem.quantity += quantity;
        } else {
            this.items.push({
                id: product.id,
                name: product.name,
                price: product.price,
                quantity: quantity,
                image: product.image
            });
        }
        
        this.saveCart();
    }
    
    removeItem(productId) {
        this.items = this.items.filter(item => item.id !== productId);
        this.saveCart();
    }
    
    updateQuantity(productId, quantity) {
        const item = this.items.find(item => item.id === productId);
        if (item) {
            item.quantity = quantity;
            this.saveCart();
        }
    }
    
    clear() {
        this.items = [];
        this.saveCart();
    }
    
    getTotal() {
        return this.items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    }
    
    getItemCount() {
        return this.items.reduce((sum, item) => sum + item.quantity, 0);
    }
    
    updateCartUI() {
        // Actualizar contador en el header
        const cartCountElement = document.getElementById('cartCount');
        if (cartCountElement) {
            cartCountElement.textContent = this.getItemCount();
        }
    }
}

// Instancia global del carrito
const cart = new ShoppingCart();

// Agregar producto al carrito
function addToCart(productId, productName, productPrice, productImage) {
    cart.addItem({
        id: productId,
        name: productName,
        price: productPrice,
        image: productImage
    }, 1);
    
    // Mostrar notificación
    showNotification('Producto agregado al carrito');
}

function showNotification(message) {
    // Implementar según tu diseño
    alert(message);
}
```

## Notas Finales

Estos son ejemplos básicos que puedes adaptar según el diseño y estructura de tu tienda. Recuerda:

1. Siempre incluir el CSRF token en las peticiones POST
2. Manejar errores apropiadamente
3. Validar datos en el frontend antes de enviar
4. Usar loaders/spinners para indicar procesos en curso
5. Dar feedback claro al usuario sobre acciones exitosas o fallidas
6. Implementar manejo de sesiones expiradas
7. Considerar la accesibilidad (ARIA labels, navegación por teclado, etc.)

