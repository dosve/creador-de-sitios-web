{{-- Script de reCAPTCHA --}}
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

{{-- Script para manejar autenticación de usuario en el header --}}
<script>
    // Configuración global
    const WEBSITE_SLUG = '{{ $website->slug ?? "" }}';
    const RECAPTCHA_SITE_KEY = '6LcuRdkrAAAAACZ3yBQ6I9WtnNb-TYdwKXcWKizj'; // Clave de prueba de Google

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
            <div class="relative w-full max-w-md p-6 bg-white rounded-lg shadow-xl">
                <button id="close-login-modal" class="absolute text-gray-400 top-4 right-4 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                
                <h2 class="mb-6 text-2xl font-bold text-gray-900">Iniciar Sesión</h2>
                
                <form id="login-form">
                    <div class="mb-4">
                        <label for="login-email" class="block mb-2 text-sm font-medium text-gray-700">
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
                        <label for="login-password" class="block mb-2 text-sm font-medium text-gray-700">
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
                    
                    <div class="flex justify-center mb-6">
                        <div id="login-recaptcha" class="g-recaptcha" data-sitekey="${RECAPTCHA_SITE_KEY}"></div>
                    </div>
                    
                    <div id="login-error" class="hidden p-3 mb-4 text-sm text-red-700 border border-red-200 rounded-lg bg-red-50"></div>
                    
                    <button 
                        type="submit"
                        id="login-submit-btn"
                        class="w-full py-3 font-semibold text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700 flex items-center justify-center"
                    >
                        <span id="login-btn-text">Iniciar Sesión</span>
                        <svg id="login-spinner" class="hidden w-5 h-5 ml-2 animate-spin text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </button>
                </form>
                
                <p class="mt-4 text-sm text-center text-gray-600">
                    <a href="#" id="show-forgot-password" class="font-medium text-blue-600 hover:text-blue-700">
                        ¿Olvidaste tu contraseña?
                    </a>
                </p>
                
                <p class="mt-2 text-sm text-center text-gray-600">
                    ¿No tienes cuenta? 
                    <a href="#" id="show-register" class="font-medium text-blue-600 hover:text-blue-700">
                        Regístrate aquí
                    </a>
                </p>
            </div>
        </div>
    `;

        document.body.insertAdjacentHTML('beforeend', modalHTML);

        // Renderizar reCAPTCHA después de crear el modal
        setTimeout(() => {
            if (typeof grecaptcha !== 'undefined' && grecaptcha.render) {
                try {
                    window.loginRecaptchaWidget = grecaptcha.render('login-recaptcha', {
                        'sitekey': RECAPTCHA_SITE_KEY
                    });
                    console.log('✅ reCAPTCHA de login renderizado con ID:', window.loginRecaptchaWidget);
                } catch (e) {
                    console.warn('reCAPTCHA ya renderizado o error:', e);
                }
            }
        }, 100);

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
        const submitBtn = document.getElementById('login-submit-btn');
        const btnText = document.getElementById('login-btn-text');
        const spinner = document.getElementById('login-spinner');

        // Ocultar errores previos
        if (errorDiv) {
            errorDiv.classList.add('hidden');
        }
        
        // Mostrar estado de carga
        if (submitBtn) submitBtn.disabled = true;
        if (btnText) btnText.textContent = 'Iniciando sesión...';
        if (spinner) spinner.classList.remove('hidden');

        // Obtener token de reCAPTCHA
        let captchaToken = null;
        console.log('🔐 Verificando reCAPTCHA:', {
            grecaptchaDisponible: typeof grecaptcha !== 'undefined',
            widgetId: window.loginRecaptchaWidget,
            siteKey: RECAPTCHA_SITE_KEY
        });
        
        if (typeof grecaptcha !== 'undefined' && window.loginRecaptchaWidget !== undefined) {
            try {
                captchaToken = grecaptcha.getResponse(window.loginRecaptchaWidget);
                console.log('✅ Token de reCAPTCHA obtenido:', {
                    tokenLength: captchaToken ? captchaToken.length : 0,
                    tokenPreview: captchaToken ? captchaToken.substring(0, 20) + '...' : 'vacío'
                });

                if (!captchaToken) {
                    console.error('❌ reCAPTCHA no completado');
                    if (errorDiv) {
                        errorDiv.textContent = 'Por favor, completa el CAPTCHA';
                        errorDiv.classList.remove('hidden');
                    }
                    // Restaurar estado del botón
                    if (submitBtn) submitBtn.disabled = false;
                    if (btnText) btnText.textContent = 'Iniciar Sesión';
                    if (spinner) spinner.classList.add('hidden');
                    return;
                }
            } catch (e) {
                console.error('❌ Error obteniendo respuesta de reCAPTCHA:', e);
                // Continuar sin CAPTCHA en caso de error
            }
        } else {
            console.warn('⚠️ reCAPTCHA no disponible, continuando sin validación');
        }

        try {
            console.log('📤 Enviando petición de login:', {
                email: email,
                website_slug: WEBSITE_SLUG,
                hasCaptchaToken: !!captchaToken,
                captchaTokenLength: captchaToken ? captchaToken.length : 0
            });
            
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

            console.log('📥 Respuesta del servidor:', {
                status: response.status,
                ok: response.ok
            });

            const data = await response.json();
            console.log('📋 Datos de respuesta:', data);

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
                
                // Restaurar estado del botón
                if (submitBtn) submitBtn.disabled = false;
                if (btnText) btnText.textContent = 'Iniciar Sesión';
                if (spinner) spinner.classList.add('hidden');

                // Resetear reCAPTCHA
                if (typeof grecaptcha !== 'undefined' && window.loginRecaptchaWidget !== undefined) {
                    try {
                        grecaptcha.reset(window.loginRecaptchaWidget);
                    } catch (e) {
                        console.warn('Error al resetear reCAPTCHA:', e);
                    }
                }
            }
        } catch (error) {
            console.error('Error:', error);
            if (errorDiv) {
                errorDiv.textContent = 'Error al procesar el login. Por favor, intenta nuevamente.';
                errorDiv.classList.remove('hidden');
            }
            
            // Restaurar estado del botón
            if (submitBtn) submitBtn.disabled = false;
            if (btnText) btnText.textContent = 'Iniciar Sesión';
            if (spinner) spinner.classList.add('hidden');

            // Resetear reCAPTCHA
            if (typeof grecaptcha !== 'undefined' && window.loginRecaptchaWidget !== undefined) {
                try {
                    grecaptcha.reset(window.loginRecaptchaWidget);
                } catch (e) {
                    console.warn('Error al resetear reCAPTCHA:', e);
                }
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
                // Limpiar cualquier dato de sesión del frontend
                sessionStorage.clear();

                // Redirigir a la página de inicio y forzar recarga sin caché
                window.location.replace(window.location.origin + '/' + WEBSITE_SLUG);

                // Forzar recarga completa sin caché como respaldo
                setTimeout(() => {
                    window.location.reload(true);
                }, 100);
            }
        } catch (error) {
            console.error('Error al cerrar sesión:', error);

            // Limpiar y recargar de todas formas
            sessionStorage.clear();
            window.location.replace(window.location.origin + '/' + WEBSITE_SLUG);
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
                <button id="close-register-modal" class="absolute text-gray-400 top-4 right-4 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                
                <h2 class="mb-6 text-2xl font-bold text-gray-900">Crear Cuenta</h2>
                
                <form id="register-form">
                    <div class="mb-4">
                        <label for="register-name" class="block mb-2 text-sm font-medium text-gray-700">
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
                        <label for="register-email" class="block mb-2 text-sm font-medium text-gray-700">
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
                        <label for="register-phone" class="block mb-2 text-sm font-medium text-gray-700">
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
                        <label for="register-password" class="block mb-2 text-sm font-medium text-gray-700">
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
                        <label for="register-password-confirm" class="block mb-2 text-sm font-medium text-gray-700">
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
                    
                    <div class="flex justify-center mb-6">
                        <div id="register-recaptcha" class="g-recaptcha" data-sitekey="${RECAPTCHA_SITE_KEY}"></div>
                    </div>
                    
                    <div id="register-error" class="hidden p-3 mb-4 text-sm text-red-700 border border-red-200 rounded-lg bg-red-50"></div>
                    
                    <button 
                        type="submit" 
                        id="register-submit-btn"
                        class="w-full py-3 font-semibold text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700"
                    >
                        Crear Cuenta
                    </button>
                </form>
                
                <p class="mt-4 text-sm text-center text-gray-600">
                    ¿Ya tienes cuenta? 
                    <a href="#" id="show-login-from-register" class="font-medium text-blue-600 hover:text-blue-700">
                        Inicia sesión aquí
                    </a>
                </p>
            </div>
        </div>
    `;

        document.body.insertAdjacentHTML('beforeend', modalHTML);

        // Renderizar reCAPTCHA después de crear el modal
        setTimeout(() => {
            if (typeof grecaptcha !== 'undefined' && grecaptcha.render) {
                try {
                    window.registerRecaptchaWidget = grecaptcha.render('register-recaptcha', {
                        'sitekey': RECAPTCHA_SITE_KEY
                    });
                    console.log('✅ reCAPTCHA de registro renderizado con ID:', window.registerRecaptchaWidget);
                } catch (e) {
                    console.warn('reCAPTCHA registro ya renderizado o error:', e);
                }
            }
        }, 100);

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
        if (typeof grecaptcha !== 'undefined' && window.registerRecaptchaWidget !== undefined) {
            try {
                captchaToken = grecaptcha.getResponse(window.registerRecaptchaWidget);

                if (!captchaToken) {
                    if (errorDiv) {
                        errorDiv.textContent = 'Por favor, completa el CAPTCHA';
                        errorDiv.classList.remove('hidden');
                    }
                    return;
                }
            } catch (e) {
                console.warn('Error obteniendo respuesta de reCAPTCHA:', e);
                // Continuar sin CAPTCHA en caso de error
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
                if (typeof grecaptcha !== 'undefined' && window.registerRecaptchaWidget !== undefined) {
                    try {
                        grecaptcha.reset(window.registerRecaptchaWidget);
                    } catch (e) {
                        console.warn('Error al resetear reCAPTCHA:', e);
                    }
                }
            }
        } catch (error) {
            console.error('Error:', error);
            if (errorDiv) {
                errorDiv.textContent = 'Error al procesar el registro. Por favor, intenta nuevamente.';
                errorDiv.classList.remove('hidden');
            }

            // Resetear reCAPTCHA
            if (typeof grecaptcha !== 'undefined' && window.registerRecaptchaWidget !== undefined) {
                try {
                    grecaptcha.reset(window.registerRecaptchaWidget);
                } catch (e) {
                    console.warn('Error al resetear reCAPTCHA:', e);
                }
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
            <div class="relative w-full max-w-md p-6 bg-white rounded-lg shadow-xl">
                <button id="close-forgot-password-modal" class="absolute text-gray-400 top-4 right-4 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                
                <h2 class="mb-2 text-2xl font-bold text-gray-900">Recuperar Contraseña</h2>
                <p id="forgot-password-subtitle" class="mb-6 text-sm text-gray-600"></p>
                
                <!-- Paso 1: Solicitar email -->
                <div id="forgot-password-step-1" class="hidden">
                    <form id="forgot-password-email-form">
                        <div class="mb-4">
                            <label for="forgot-email" class="block mb-2 text-sm font-medium text-gray-700">
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
                        
                        <div class="flex justify-center mb-6">
                            <div id="forgot-recaptcha" class="g-recaptcha" data-sitekey="${RECAPTCHA_SITE_KEY}"></div>
                        </div>
                        
                        <div id="forgot-email-error" class="hidden p-3 mb-4 text-sm text-red-700 border border-red-200 rounded-lg bg-red-50"></div>
                        <div id="forgot-email-success" class="hidden p-3 mb-4 text-sm text-green-700 border border-green-200 rounded-lg bg-green-50"></div>
                        
                        <button 
                            type="submit" 
                            id="forgot-email-submit-btn"
                            class="w-full py-3 font-semibold text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700"
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
                            <label for="forgot-code" class="block mb-2 text-sm font-medium text-gray-700">
                                Código de Verificación
                            </label>
                            <input 
                                type="text" 
                                id="forgot-code" 
                                name="code" 
                                required
                                maxlength="4"
                                pattern="[0-9]{4}"
                                class="w-full px-4 py-2 text-2xl font-bold tracking-widest text-center border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="0000"
                            >
                            <p class="mt-2 text-xs text-gray-500">Ingresa el código de 4 dígitos que enviamos a tu correo</p>
                        </div>
                        
                        <div id="forgot-code-error" class="hidden p-3 mb-4 text-sm text-red-700 border border-red-200 rounded-lg bg-red-50"></div>
                        
                        <button 
                            type="submit" 
                            id="forgot-code-submit-btn"
                            class="w-full py-3 font-semibold text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700"
                        >
                            Verificar Código
                        </button>
                        
                        <button 
                            type="button" 
                            id="forgot-code-resend-btn"
                            class="w-full mt-3 text-sm font-medium text-blue-600 hover:text-blue-700"
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
                            <label for="forgot-new-password" class="block mb-2 text-sm font-medium text-gray-700">
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
                            <label for="forgot-new-password-confirm" class="block mb-2 text-sm font-medium text-gray-700">
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
                        
                        <div id="forgot-reset-error" class="hidden p-3 mb-4 text-sm text-red-700 border border-red-200 rounded-lg bg-red-50"></div>
                        
                        <button 
                            type="submit" 
                            id="forgot-reset-submit-btn"
                            class="w-full py-3 font-semibold text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700"
                        >
                            Cambiar Contraseña
                        </button>
                    </form>
                </div>
                
                <p class="mt-4 text-sm text-center text-gray-600">
                    <a href="#" id="show-login-from-forgot" class="font-medium text-blue-600 hover:text-blue-700">
                        Volver al login
                    </a>
                </p>
            </div>
        </div>
    `;

        document.body.insertAdjacentHTML('beforeend', modalHTML);

        // Renderizar reCAPTCHA después de crear el modal
        setTimeout(() => {
            if (typeof grecaptcha !== 'undefined' && grecaptcha.render) {
                try {
                    window.forgotRecaptchaWidget = grecaptcha.render('forgot-recaptcha', {
                        'sitekey': RECAPTCHA_SITE_KEY
                    });
                    console.log('✅ reCAPTCHA de recuperar contraseña renderizado con ID:', window.forgotRecaptchaWidget);
                } catch (e) {
                    console.warn('reCAPTCHA recuperar contraseña ya renderizado o error:', e);
                }
            }
        }, 100);

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
            if (typeof grecaptcha !== 'undefined' && window.forgotRecaptchaWidget !== undefined) {
                try {
                    grecaptcha.reset(window.forgotRecaptchaWidget);
                } catch (e) {
                    console.warn('Error al resetear reCAPTCHA:', e);
                }
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
        if (typeof grecaptcha !== 'undefined' && window.forgotRecaptchaWidget !== undefined) {
            try {
                captchaToken = grecaptcha.getResponse(window.forgotRecaptchaWidget);

                if (!captchaToken) {
                    if (errorDiv) {
                        errorDiv.textContent = 'Por favor, completa el CAPTCHA';
                        errorDiv.classList.remove('hidden');
                    }
                    return;
                }
            } catch (e) {
                console.warn('Error obteniendo respuesta de reCAPTCHA:', e);
                // Continuar sin CAPTCHA en caso de error
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
                if (typeof grecaptcha !== 'undefined' && window.forgotRecaptchaWidget !== undefined) {
                    try {
                        grecaptcha.reset(window.forgotRecaptchaWidget);
                    } catch (e) {
                        console.warn('Error al resetear reCAPTCHA:', e);
                    }
                }
            }
        } catch (error) {
            console.error('Error:', error);
            if (errorDiv) {
                errorDiv.textContent = 'Error al procesar la solicitud. Por favor, intenta nuevamente.';
                errorDiv.classList.remove('hidden');
            }

            // Resetear CAPTCHA
            if (typeof grecaptcha !== 'undefined' && window.forgotRecaptchaWidget !== undefined) {
                try {
                    grecaptcha.reset(window.forgotRecaptchaWidget);
                } catch (e) {
                    console.warn('Error al resetear reCAPTCHA:', e);
                }
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
    
    // Exponer funciones globalmente para que puedan ser llamadas desde otros componentes
    window.showLoginModal = showLoginModal;
    window.showRegisterModal = showRegisterModal;
    window.checkUserAuth = checkUserAuth;
</script>