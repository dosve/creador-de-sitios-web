{{-- Script de reCAPTCHA --}}
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

{{-- Script para manejar autenticación de usuario en el header --}}
<script>
// Configuración global
const WEBSITE_SLUG = '{{ $website->slug ?? "" }}';
const RECAPTCHA_SITE_KEY = '6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI'; // Clave de prueba de Google

// Verificar autenticación al cargar la página
document.addEventListener('DOMContentLoaded', async function() {
    await checkUserAuth();
    setupUserMenuEvents();
});

/**
 * Verificar si el usuario está autenticado
 */
async function checkUserAuth() {
    try {
        const response = await fetch('/customer/check');
        const data = await response.json();
        
        if (data.authenticated && data.customer) {
            // Usuario autenticado
            showAuthenticatedMenu(data.customer);
        } else {
            // Usuario invitado
            showGuestMenu();
        }
    } catch (error) {
        console.error('Error al verificar autenticación:', error);
        showGuestMenu();
    }
}

/**
 * Mostrar menú para usuario autenticado
 */
function showAuthenticatedMenu(customer) {
    const guestMenu = document.getElementById('guest-menu');
    const userMenu = document.getElementById('user-menu');
    const userName = document.getElementById('user-name');
    
    if (guestMenu) guestMenu.classList.add('hidden');
    if (userMenu) {
        userMenu.classList.remove('hidden');
        
        // Mostrar nombre del usuario
        if (userName && customer.name) {
            userName.textContent = customer.name.split(' ')[0]; // Solo primer nombre
        }
    }
}

/**
 * Mostrar menú para invitado
 */
function showGuestMenu() {
    const guestMenu = document.getElementById('guest-menu');
    const userMenu = document.getElementById('user-menu');
    
    if (guestMenu) guestMenu.classList.remove('hidden');
    if (userMenu) userMenu.classList.add('hidden');
}

/**
 * Configurar eventos del menú de usuario
 */
function setupUserMenuEvents() {
    // Botón de login para invitados
    const loginButton = document.getElementById('login-button');
    if (loginButton) {
        loginButton.addEventListener('click', function() {
            showLoginModal();
        });
    }
    
    // Botón del menú de usuario (toggle dropdown)
    const userMenuButton = document.getElementById('user-menu-button');
    const userDropdown = document.getElementById('user-dropdown');
    
    if (userMenuButton && userDropdown) {
        userMenuButton.addEventListener('click', function(e) {
            e.stopPropagation();
            userDropdown.classList.toggle('hidden');
        });
        
        // Cerrar dropdown al hacer clic fuera
        document.addEventListener('click', function(e) {
            if (!userDropdown.contains(e.target) && !userMenuButton.contains(e.target)) {
                userDropdown.classList.add('hidden');
            }
        });
    }
    
    // Botón de logout
    const logoutButton = document.getElementById('logout-button');
    if (logoutButton) {
        logoutButton.addEventListener('click', async function() {
            await customerLogout();
        });
    }
}

/**
 * Mostrar modal de login
 */
function showLoginModal() {
    // Crear modal si no existe
    if (!document.getElementById('login-modal')) {
        createLoginModal();
    }
    
    const modal = document.getElementById('login-modal');
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
}

/**
 * Crear modal de login
 */
function createLoginModal() {
    const modalHTML = `
        <div id="login-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 relative">
                <button id="close-login-modal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Iniciar Sesión</h2>
                
                <form id="login-form">
                    <div class="mb-4">
                        <label for="login-email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email
                        </label>
                        <input 
                            type="email" 
                            id="login-email" 
                            name="email" 
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                    </div>
                    
                    <div class="mb-4">
                        <label for="login-password" class="block text-sm font-medium text-gray-700 mb-2">
                            Contraseña
                        </label>
                        <input 
                            type="password" 
                            id="login-password" 
                            name="password" 
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                    </div>
                    
                    <div class="mb-6 flex justify-center">
                        <div id="login-recaptcha" class="g-recaptcha" data-sitekey="${RECAPTCHA_SITE_KEY}"></div>
                    </div>
                    
                    <div id="login-error" class="hidden mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm"></div>
                    
                    <button 
                        type="submit" 
                        class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors"
                    >
                        Iniciar Sesión
                    </button>
                </form>
                
                <p class="text-center text-sm text-gray-600 mt-4">
                    <a href="#" id="show-forgot-password" class="text-blue-600 hover:text-blue-700 font-medium">
                        ¿Olvidaste tu contraseña?
                    </a>
                </p>
                
                <p class="text-center text-sm text-gray-600 mt-2">
                    ¿No tienes cuenta? 
                    <a href="#" id="show-register" class="text-blue-600 hover:text-blue-700 font-medium">
                        Regístrate aquí
                    </a>
                </p>
            </div>
        </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', modalHTML);
    
    // Configurar eventos del modal
    const closeButton = document.getElementById('close-login-modal');
    const modal = document.getElementById('login-modal');
    const loginForm = document.getElementById('login-form');
    const showRegisterLink = document.getElementById('show-register');
    
    if (closeButton) {
        closeButton.addEventListener('click', function() {
            closeLoginModal();
        });
    }
    
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeLoginModal();
            }
        });
    }
    
    if (loginForm) {
        loginForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            await handleLogin();
        });
    }
    
    if (showRegisterLink) {
        showRegisterLink.addEventListener('click', function(e) {
            e.preventDefault();
            closeLoginModal();
            showRegisterModal();
        });
    }
    
    const showForgotPasswordLink = document.getElementById('show-forgot-password');
    if (showForgotPasswordLink) {
        showForgotPasswordLink.addEventListener('click', function(e) {
            e.preventDefault();
            closeLoginModal();
            showForgotPasswordModal();
        });
    }
}

/**
 * Cerrar modal de login
 */
function closeLoginModal() {
    const modal = document.getElementById('login-modal');
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }
}

/**
 * Manejar el login
 */
async function handleLogin() {
    const email = document.getElementById('login-email').value;
    const password = document.getElementById('login-password').value;
    const errorDiv = document.getElementById('login-error');
    
    // Ocultar errores previos
    if (errorDiv) {
        errorDiv.classList.add('hidden');
    }
    
    // Obtener token de reCAPTCHA
    let captchaToken = null;
    if (typeof grecaptcha !== 'undefined') {
        captchaToken = grecaptcha.getResponse();
        
        if (!captchaToken) {
            if (errorDiv) {
                errorDiv.textContent = 'Por favor, completa el CAPTCHA';
                errorDiv.classList.remove('hidden');
            }
            return;
        }
    }
    
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
                website_slug: WEBSITE_SLUG,
                captcha_token: captchaToken
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Login exitoso
            console.log('Login exitoso:', data.customer);
            
            // Cerrar modal
            closeLoginModal();
            
            // Actualizar UI
            showAuthenticatedMenu(data.customer);
            
            // Recargar página para actualizar todo
            setTimeout(() => {
                window.location.reload();
            }, 500);
        } else {
            // Mostrar error
            if (errorDiv) {
                errorDiv.textContent = data.message || 'Error al iniciar sesión';
                errorDiv.classList.remove('hidden');
            }
            
            // Resetear reCAPTCHA
            if (typeof grecaptcha !== 'undefined') {
                grecaptcha.reset();
            }
        }
    } catch (error) {
        console.error('Error:', error);
        if (errorDiv) {
            errorDiv.textContent = 'Error al procesar el login. Por favor, intenta nuevamente.';
            errorDiv.classList.remove('hidden');
        }
        
        // Resetear reCAPTCHA
        if (typeof grecaptcha !== 'undefined') {
            grecaptcha.reset();
        }
    }
}

/**
 * Logout de cliente
 */
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
        console.error('Error al cerrar sesión:', error);
        // Recargar de todas formas
        window.location.reload();
    }
}

/**
 * Mostrar modal de registro
 */
function showRegisterModal() {
    // Crear modal si no existe
    if (!document.getElementById('register-modal')) {
        createRegisterModal();
    }
    
    const modal = document.getElementById('register-modal');
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
}

/**
 * Crear modal de registro
 */
function createRegisterModal() {
    const modalHTML = `
        <div id="register-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 relative max-h-[90vh] overflow-y-auto">
                <button id="close-register-modal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Crear Cuenta</h2>
                
                <form id="register-form">
                    <div class="mb-4">
                        <label for="register-name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nombre Completo *
                        </label>
                        <input 
                            type="text" 
                            id="register-name" 
                            name="name" 
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Juan Pérez"
                        >
                    </div>
                    
                    <div class="mb-4">
                        <label for="register-email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email *
                        </label>
                        <input 
                            type="email" 
                            id="register-email" 
                            name="email" 
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="tu@email.com"
                        >
                    </div>
                    
                    <div class="mb-4">
                        <label for="register-phone" class="block text-sm font-medium text-gray-700 mb-2">
                            Teléfono *
                        </label>
                        <input 
                            type="tel" 
                            id="register-phone" 
                            name="phone" 
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="3001234567"
                        >
                    </div>
                    
                    <div class="mb-4">
                        <label for="register-password" class="block text-sm font-medium text-gray-700 mb-2">
                            Contraseña *
                        </label>
                        <input 
                            type="password" 
                            id="register-password" 
                            name="password" 
                            required
                            minlength="6"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Mínimo 6 caracteres"
                        >
                    </div>
                    
                    <div class="mb-4">
                        <label for="register-password-confirm" class="block text-sm font-medium text-gray-700 mb-2">
                            Confirmar Contraseña *
                        </label>
                        <input 
                            type="password" 
                            id="register-password-confirm" 
                            name="password_confirm" 
                            required
                            minlength="6"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Repite tu contraseña"
                        >
                    </div>
                    
                    <div class="mb-6 flex justify-center">
                        <div id="register-recaptcha" class="g-recaptcha" data-sitekey="${RECAPTCHA_SITE_KEY}"></div>
                    </div>
                    
                    <div id="register-error" class="hidden mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm"></div>
                    
                    <button 
                        type="submit" 
                        id="register-submit-btn"
                        class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors"
                    >
                        Crear Cuenta
                    </button>
                </form>
                
                <p class="text-center text-sm text-gray-600 mt-4">
                    ¿Ya tienes cuenta? 
                    <a href="#" id="show-login-from-register" class="text-blue-600 hover:text-blue-700 font-medium">
                        Inicia sesión aquí
                    </a>
                </p>
            </div>
        </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', modalHTML);
    
    // Configurar eventos del modal
    const closeButton = document.getElementById('close-register-modal');
    const modal = document.getElementById('register-modal');
    const registerForm = document.getElementById('register-form');
    const showLoginLink = document.getElementById('show-login-from-register');
    
    if (closeButton) {
        closeButton.addEventListener('click', function() {
            closeRegisterModal();
        });
    }
    
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeRegisterModal();
            }
        });
    }
    
    if (registerForm) {
        registerForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            await handleRegister();
        });
    }
    
    if (showLoginLink) {
        showLoginLink.addEventListener('click', function(e) {
            e.preventDefault();
            closeRegisterModal();
            showLoginModal();
        });
    }
}

/**
 * Cerrar modal de registro
 */
function closeRegisterModal() {
    const modal = document.getElementById('register-modal');
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }
}

/**
 * Manejar el registro
 */
async function handleRegister() {
    const name = document.getElementById('register-name').value;
    const email = document.getElementById('register-email').value;
    const phone = document.getElementById('register-phone').value;
    const password = document.getElementById('register-password').value;
    const passwordConfirm = document.getElementById('register-password-confirm').value;
    const errorDiv = document.getElementById('register-error');
    const submitBtn = document.getElementById('register-submit-btn');
    
    // Ocultar errores previos
    if (errorDiv) {
        errorDiv.classList.add('hidden');
    }
    
    // Validar contraseñas
    if (password !== passwordConfirm) {
        if (errorDiv) {
            errorDiv.textContent = 'Las contraseñas no coinciden';
            errorDiv.classList.remove('hidden');
        }
        return;
    }
    
    // Validar longitud de contraseña
    if (password.length < 6) {
        if (errorDiv) {
            errorDiv.textContent = 'La contraseña debe tener al menos 6 caracteres';
            errorDiv.classList.remove('hidden');
        }
        return;
    }
    
    // Obtener token de reCAPTCHA
    let captchaToken = null;
    if (typeof grecaptcha !== 'undefined') {
        // Obtener respuesta del widget de registro
        const response = grecaptcha.getResponse(1); // El segundo widget (índice 1)
        captchaToken = response;
        
        if (!captchaToken) {
            if (errorDiv) {
                errorDiv.textContent = 'Por favor, completa el CAPTCHA';
                errorDiv.classList.remove('hidden');
            }
            return;
        }
    }
    
    try {
        // Deshabilitar botón
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.textContent = 'Creando cuenta...';
        }
        
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
                website_slug: WEBSITE_SLUG,
                captcha_token: captchaToken
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Registro exitoso
            console.log('Registro exitoso:', data.customer);
            
            // Cerrar modal
            closeRegisterModal();
            
            // Mostrar mensaje de éxito
            alert('¡Cuenta creada exitosamente! Ya puedes hacer compras.');
            
            // Actualizar UI
            showAuthenticatedMenu(data.customer);
            
            // Recargar página para actualizar todo
            setTimeout(() => {
                window.location.reload();
            }, 500);
        } else {
            // Mostrar error
            if (errorDiv) {
                errorDiv.textContent = data.message || 'Error al crear la cuenta';
                errorDiv.classList.remove('hidden');
            }
            
            // Resetear reCAPTCHA
            if (typeof grecaptcha !== 'undefined') {
                grecaptcha.reset(1); // Resetear el segundo widget
            }
        }
    } catch (error) {
        console.error('Error:', error);
        if (errorDiv) {
            errorDiv.textContent = 'Error al procesar el registro. Por favor, intenta nuevamente.';
            errorDiv.classList.remove('hidden');
        }
        
        // Resetear reCAPTCHA
        if (typeof grecaptcha !== 'undefined') {
            grecaptcha.reset(1); // Resetear el segundo widget
        }
    } finally {
        // Rehabilitar botón
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Crear Cuenta';
        }
    }
}

/**
 * Mostrar modal de recuperar contraseña
 */
function showForgotPasswordModal() {
    // Crear modal si no existe
    if (!document.getElementById('forgot-password-modal')) {
        createForgotPasswordModal();
    }
    
    const modal = document.getElementById('forgot-password-modal');
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        
        // Mostrar paso 1 (solicitar email)
        showForgotPasswordStep(1);
    }
}

/**
 * Crear modal de recuperar contraseña
 */
function createForgotPasswordModal() {
    const modalHTML = `
        <div id="forgot-password-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 relative">
                <button id="close-forgot-password-modal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Recuperar Contraseña</h2>
                <p id="forgot-password-subtitle" class="text-sm text-gray-600 mb-6"></p>
                
                <!-- Paso 1: Solicitar email -->
                <div id="forgot-password-step-1" class="hidden">
                    <form id="forgot-password-email-form">
                        <div class="mb-4">
                            <label for="forgot-email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email
                            </label>
                            <input 
                                type="email" 
                                id="forgot-email" 
                                name="email" 
                                required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="tu@email.com"
                            >
                        </div>
                        
                        <div class="mb-6 flex justify-center">
                            <div id="forgot-recaptcha" class="g-recaptcha" data-sitekey="${RECAPTCHA_SITE_KEY}"></div>
                        </div>
                        
                        <div id="forgot-email-error" class="hidden mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm"></div>
                        <div id="forgot-email-success" class="hidden mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm"></div>
                        
                        <button 
                            type="submit" 
                            id="forgot-email-submit-btn"
                            class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors"
                        >
                            Enviar Código
                        </button>
                    </form>
                </div>
                
                <!-- Paso 2: Validar código -->
                <div id="forgot-password-step-2" class="hidden">
                    <form id="forgot-password-code-form">
                        <input type="hidden" id="forgot-email-hidden" value="">
                        
                        <div class="mb-6">
                            <label for="forgot-code" class="block text-sm font-medium text-gray-700 mb-2">
                                Código de Verificación
                            </label>
                            <input 
                                type="text" 
                                id="forgot-code" 
                                name="code" 
                                required
                                maxlength="4"
                                pattern="[0-9]{4}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-center text-2xl font-bold tracking-widest"
                                placeholder="0000"
                            >
                            <p class="text-xs text-gray-500 mt-2">Ingresa el código de 4 dígitos que enviamos a tu correo</p>
                        </div>
                        
                        <div id="forgot-code-error" class="hidden mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm"></div>
                        
                        <button 
                            type="submit" 
                            id="forgot-code-submit-btn"
                            class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors"
                        >
                            Verificar Código
                        </button>
                        
                        <button 
                            type="button" 
                            id="forgot-code-resend-btn"
                            class="w-full mt-3 text-blue-600 hover:text-blue-700 text-sm font-medium"
                        >
                            Reenviar código
                        </button>
                    </form>
                </div>
                
                <!-- Paso 3: Nueva contraseña -->
                <div id="forgot-password-step-3" class="hidden">
                    <form id="forgot-password-reset-form">
                        <input type="hidden" id="forgot-email-hidden-2" value="">
                        <input type="hidden" id="forgot-code-hidden" value="">
                        
                        <div class="mb-4">
                            <label for="forgot-new-password" class="block text-sm font-medium text-gray-700 mb-2">
                                Nueva Contraseña
                            </label>
                            <input 
                                type="password" 
                                id="forgot-new-password" 
                                name="password" 
                                required
                                minlength="6"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Mínimo 6 caracteres"
                            >
                        </div>
                        
                        <div class="mb-6">
                            <label for="forgot-new-password-confirm" class="block text-sm font-medium text-gray-700 mb-2">
                                Confirmar Contraseña
                            </label>
                            <input 
                                type="password" 
                                id="forgot-new-password-confirm" 
                                name="password_confirmation" 
                                required
                                minlength="6"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Repite tu nueva contraseña"
                            >
                        </div>
                        
                        <div id="forgot-reset-error" class="hidden mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm"></div>
                        
                        <button 
                            type="submit" 
                            id="forgot-reset-submit-btn"
                            class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors"
                        >
                            Cambiar Contraseña
                        </button>
                    </form>
                </div>
                
                <p class="text-center text-sm text-gray-600 mt-4">
                    <a href="#" id="show-login-from-forgot" class="text-blue-600 hover:text-blue-700 font-medium">
                        Volver al login
                    </a>
                </p>
            </div>
        </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', modalHTML);
    
    // Configurar eventos del modal
    const closeButton = document.getElementById('close-forgot-password-modal');
    const modal = document.getElementById('forgot-password-modal');
    const emailForm = document.getElementById('forgot-password-email-form');
    const codeForm = document.getElementById('forgot-password-code-form');
    const resetForm = document.getElementById('forgot-password-reset-form');
    const showLoginLink = document.getElementById('show-login-from-forgot');
    const resendBtn = document.getElementById('forgot-code-resend-btn');
    
    if (closeButton) {
        closeButton.addEventListener('click', function() {
            closeForgotPasswordModal();
        });
    }
    
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeForgotPasswordModal();
            }
        });
    }
    
    if (emailForm) {
        emailForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            await handleForgotPasswordEmail();
        });
    }
    
    if (codeForm) {
        codeForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            await handleForgotPasswordCode();
        });
    }
    
    if (resetForm) {
        resetForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            await handleForgotPasswordReset();
        });
    }
    
    if (showLoginLink) {
        showLoginLink.addEventListener('click', function(e) {
            e.preventDefault();
            closeForgotPasswordModal();
            showLoginModal();
        });
    }
    
    if (resendBtn) {
        resendBtn.addEventListener('click', async function() {
            await handleForgotPasswordEmail();
        });
    }
}

/**
 * Cerrar modal de recuperar contraseña
 */
function closeForgotPasswordModal() {
    const modal = document.getElementById('forgot-password-modal');
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
        
        // Resetear formularios
        document.getElementById('forgot-password-email-form')?.reset();
        document.getElementById('forgot-password-code-form')?.reset();
        document.getElementById('forgot-password-reset-form')?.reset();
        
        // Resetear CAPTCHA
        if (typeof grecaptcha !== 'undefined') {
            grecaptcha.reset(2); // El tercer widget
        }
    }
}

/**
 * Mostrar paso específico del modal
 */
function showForgotPasswordStep(step) {
    const subtitle = document.getElementById('forgot-password-subtitle');
    
    // Ocultar todos los pasos
    document.getElementById('forgot-password-step-1')?.classList.add('hidden');
    document.getElementById('forgot-password-step-2')?.classList.add('hidden');
    document.getElementById('forgot-password-step-3')?.classList.add('hidden');
    
    // Mostrar el paso solicitado
    if (step === 1) {
        if (subtitle) subtitle.textContent = 'Ingresa tu email para recibir un código de verificación';
        document.getElementById('forgot-password-step-1')?.classList.remove('hidden');
    } else if (step === 2) {
        if (subtitle) subtitle.textContent = 'Verifica el código que enviamos a tu correo';
        document.getElementById('forgot-password-step-2')?.classList.remove('hidden');
    } else if (step === 3) {
        if (subtitle) subtitle.textContent = 'Ingresa tu nueva contraseña';
        document.getElementById('forgot-password-step-3')?.classList.remove('hidden');
    }
}

/**
 * Paso 1: Enviar código al email
 */
async function handleForgotPasswordEmail() {
    const email = document.getElementById('forgot-email').value;
    const errorDiv = document.getElementById('forgot-email-error');
    const successDiv = document.getElementById('forgot-email-success');
    const submitBtn = document.getElementById('forgot-email-submit-btn');
    
    // Ocultar mensajes previos
    if (errorDiv) errorDiv.classList.add('hidden');
    if (successDiv) successDiv.classList.add('hidden');
    
    // Obtener token de reCAPTCHA
    let captchaToken = null;
    if (typeof grecaptcha !== 'undefined') {
        captchaToken = grecaptcha.getResponse(2); // El tercer widget
        
        if (!captchaToken) {
            if (errorDiv) {
                errorDiv.textContent = 'Por favor, completa el CAPTCHA';
                errorDiv.classList.remove('hidden');
            }
            return;
        }
    }
    
    try {
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.textContent = 'Enviando...';
        }
        
        const apiUrl = '{{ $website->api_base_url ?? "" }}';
        const response = await fetch(apiUrl + '/password/sendEmail', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                email: email,
                captcha_token: captchaToken
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Guardar email para siguientes pasos
            document.getElementById('forgot-email-hidden').value = email;
            document.getElementById('forgot-email-hidden-2').value = email;
            
            // Mostrar mensaje de éxito
            if (successDiv) {
                successDiv.textContent = 'Código enviado exitosamente. Revisa tu correo.';
                successDiv.classList.remove('hidden');
            }
            
            // Cambiar al paso 2 después de 2 segundos
            setTimeout(() => {
                showForgotPasswordStep(2);
            }, 2000);
        } else {
            if (errorDiv) {
                errorDiv.textContent = data.message || 'Error al enviar el código';
                errorDiv.classList.remove('hidden');
            }
            
            // Resetear CAPTCHA
            if (typeof grecaptcha !== 'undefined') {
                grecaptcha.reset(2);
            }
        }
    } catch (error) {
        console.error('Error:', error);
        if (errorDiv) {
            errorDiv.textContent = 'Error al procesar la solicitud. Por favor, intenta nuevamente.';
            errorDiv.classList.remove('hidden');
        }
        
        // Resetear CAPTCHA
        if (typeof grecaptcha !== 'undefined') {
            grecaptcha.reset(2);
        }
    } finally {
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Enviar Código';
        }
    }
}

/**
 * Paso 2: Validar código
 */
async function handleForgotPasswordCode() {
    const email = document.getElementById('forgot-email-hidden').value;
    const code = document.getElementById('forgot-code').value;
    const errorDiv = document.getElementById('forgot-code-error');
    const submitBtn = document.getElementById('forgot-code-submit-btn');
    
    // Ocultar errores previos
    if (errorDiv) errorDiv.classList.add('hidden');
    
    try {
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.textContent = 'Verificando...';
        }
        
        const apiUrl = '{{ $website->api_base_url ?? "" }}';
        const response = await fetch(apiUrl + '/password/validateCode', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                email: email,
                code: code
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Guardar código para el siguiente paso
            document.getElementById('forgot-code-hidden').value = code;
            
            // Cambiar al paso 3
            showForgotPasswordStep(3);
        } else {
            if (errorDiv) {
                errorDiv.textContent = data.message || 'Código incorrecto';
                errorDiv.classList.remove('hidden');
            }
        }
    } catch (error) {
        console.error('Error:', error);
        if (errorDiv) {
            errorDiv.textContent = 'Error al validar el código. Por favor, intenta nuevamente.';
            errorDiv.classList.remove('hidden');
        }
    } finally {
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Verificar Código';
        }
    }
}

/**
 * Paso 3: Cambiar contraseña
 */
async function handleForgotPasswordReset() {
    const email = document.getElementById('forgot-email-hidden-2').value;
    const code = document.getElementById('forgot-code-hidden').value;
    const password = document.getElementById('forgot-new-password').value;
    const passwordConfirm = document.getElementById('forgot-new-password-confirm').value;
    const errorDiv = document.getElementById('forgot-reset-error');
    const submitBtn = document.getElementById('forgot-reset-submit-btn');
    
    // Ocultar errores previos
    if (errorDiv) errorDiv.classList.add('hidden');
    
    // Validar contraseñas
    if (password !== passwordConfirm) {
        if (errorDiv) {
            errorDiv.textContent = 'Las contraseñas no coinciden';
            errorDiv.classList.remove('hidden');
        }
        return;
    }
    
    if (password.length < 6) {
        if (errorDiv) {
            errorDiv.textContent = 'La contraseña debe tener al menos 6 caracteres';
            errorDiv.classList.remove('hidden');
        }
        return;
    }
    
    try {
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.textContent = 'Cambiando...';
        }
        
        const apiUrl = '{{ $website->api_base_url ?? "" }}';
        const response = await fetch(apiUrl + '/password/resetPassword', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                email: email,
                code: code,
                password: password,
                password_confirmation: passwordConfirm
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Cerrar modal
            closeForgotPasswordModal();
            
            // Mostrar mensaje de éxito
            alert('¡Contraseña cambiada exitosamente! Ahora puedes iniciar sesión con tu nueva contraseña.');
            
            // Abrir modal de login
            showLoginModal();
        } else {
            if (errorDiv) {
                errorDiv.textContent = data.message || 'Error al cambiar la contraseña';
                errorDiv.classList.remove('hidden');
            }
        }
    } catch (error) {
        console.error('Error:', error);
        if (errorDiv) {
            errorDiv.textContent = 'Error al cambiar la contraseña. Por favor, intenta nuevamente.';
            errorDiv.classList.remove('hidden');
        }
    } finally {
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Cambiar Contraseña';
        }
    }
}
</script>

