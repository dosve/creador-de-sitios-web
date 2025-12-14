@props([
    'publicKey' => '',
    'privateKey' => '',
    'integrityKey' => '',
    'websiteSlug' => ''
])

<!-- SDK de Wompi -->
<script>
    // Interceptor de errores de red para detectar errores 403
    (function() {
        const originalFetch = window.fetch;
        window.fetch = function(...args) {
            const url = args[0];
            return originalFetch.apply(this, args)
                .then(response => {
                    if (!response.ok && response.status === 403) {
                        console.error('❌ Error 403 detectado en petición:', url);
                        console.error('El dominio no está autorizado. Verifica la configuración en Wompi.');
                    }
                    return response;
                })
                .catch(error => {
                    console.error('❌ Error en fetch:', error, url);
                    return Promise.reject(error);
                });
        };

        // Interceptor de errores de recursos (imágenes, scripts, iframes, etc.)
        window.addEventListener('error', function(event) {
            const src = event.target ? (event.target.src || event.target.href) : null;
            if (src && src.includes('wompi')) {
                console.error('❌ Error cargando recurso de Wompi:', src);
                console.error('Tipo de recurso:', event.target.tagName);
                console.error('Error:', event.message);
                
                // Detectar error de CloudFront
                const isCloudFrontError = event.message && (
                    event.message.includes('CloudFront') || 
                    event.message.includes('cloudfront') ||
                    event.message.includes('Request blocked') ||
                    event.message.includes('could not be satisfied')
                );
                
                // Detectar si es un error 403
                if (event.message && (event.message.includes('403') || event.message.includes('Forbidden'))) {
                    const currentDomain = window.location.hostname;
                    console.error('');
                    console.error('🔴 ========================================');
                    
                    if (isCloudFrontError) {
                        console.error('🔴 ERROR 403 DE CLOUDFRONT (CDN de AWS)');
                        console.error('🔴 ========================================');
                        console.error('Este NO es un error de dominio no autorizado.');
                        console.error('Es un problema del CDN de Wompi (CloudFront).');
                        console.error('');
                        console.error('URL que falló:', src);
                        console.error('Dominio actual:', currentDomain);
                        console.error('');
                        console.error('📋 POSIBLES CAUSAS:');
                        console.error('1. Problema temporal en los servidores de Wompi');
                        console.error('2. Bloqueo geográfico o de IP');
                        console.error('3. Demasiadas solicitudes (rate limiting)');
                        console.error('4. Mantenimiento en el servicio de Wompi');
                        console.error('');
                        console.error('📋 SOLUCIONES:');
                        console.error('1. Espera unos minutos e intenta nuevamente');
                        console.error('2. Recarga la página completamente (Ctrl+F5)');
                        console.error('3. Prueba desde otra conexión de internet');
                        console.error('4. Verifica el estado del servicio en: https://status.wompi.co');
                        console.error('5. Si persiste, contacta soporte: soporte@wompi.co');
                        console.error('');
                        console.error('NOTA: Este error suele ser temporal y se resuelve automáticamente.');
                    } else {
                        const isLocalhost = currentDomain === 'localhost' || currentDomain === '127.0.0.1' || currentDomain.startsWith('192.168.');
                        
                        if (isLocalhost) {
                            console.error('🔴 ERROR 403 EN LOCALHOST');
                            console.error('🔴 ========================================');
                            console.error('URL que falló:', src);
                            console.error('Dominio actual:', currentDomain);
                            console.error('');
                            console.error('📋 SOLUCIONES PARA LOCALHOST:');
                            console.error('');
                            console.error('Opción 1: Usar ngrok (Recomendado)');
                            console.error('1. Instala: https://ngrok.com/');
                            console.error('2. Ejecuta: ngrok http 8000');
                            console.error('3. Usa la URL HTTPS que ngrok te da');
                            console.error('4. Actualiza tu app para usar esa URL');
                            console.error('');
                            console.error('Opción 2: Verificar configuración en Wompi');
                            console.error('1. Ve a: https://comercios.wompi.co');
                            console.error('2. Desarrolladores → Modo de prueba');
                            console.error('3. Asegúrate de que esté ACTIVADO');
                            console.error('4. Verifica claves de prueba (pub_test_)');
                            console.error('');
                            console.error('Opción 3: Probar en servidor de staging');
                            console.error('Despliega en un servidor con dominio público');
                        } else {
                            console.error('🔴 ERROR 403 - DOMINIO NO AUTORIZADO');
                            console.error('🔴 ========================================');
                            console.error('URL que falló:', src);
                            console.error('Dominio actual:', currentDomain);
                            console.error('URL completa:', window.location.href);
                            console.error('');
                            console.error('📋 PASOS PARA RESOLVER:');
                            console.error('1. Ingresa a: https://comercios.wompi.co');
                            console.error('2. Inicia sesión');
                            console.error('3. Ve a: Desarrolladores → Dominios Autorizados');
                            console.error('4. Agrega tu dominio:', currentDomain);
                            console.error('5. Si usas www, agrega también: www.' + currentDomain);
                            console.error('6. Guarda los cambios');
                            console.error('7. Espera 2-3 minutos');
                            console.error('8. Recarga la página e intenta nuevamente');
                        }
                    }
                    console.error('🔴 ========================================');
                }
                
                if (event.target.tagName === 'SCRIPT') {
                    console.error('❌ Error al cargar el SDK de Wompi');
                } else if (event.target.tagName === 'IFRAME') {
                    console.error('❌ Error al cargar el widget de Wompi (iframe)');
                    if (isCloudFrontError) {
                        console.error('Este es un error de CloudFront, no de autorización de dominio');
                    }
                }
            }
        }, true);

        // Interceptor para errores no capturados
        window.addEventListener('unhandledrejection', function(event) {
            if (event.reason && event.reason.toString && event.reason.toString().includes('403')) {
                console.error('❌ Error 403 no manejado:', event.reason);
            }
        });
    })();

    // Cargar el SDK de Wompi con manejo de errores
    (function() {
        const script = document.createElement('script');
        script.src = 'https://checkout.wompi.co/widget.js';
        script.async = true;
        
        script.onload = function() {
            console.log('✅ SDK de Wompi cargado correctamente');
            // Esperar un poco más para que WidgetCheckout esté disponible
            setTimeout(function() {
                if (typeof WidgetCheckout !== 'undefined') {
                    console.log('✅ WidgetCheckout disponible');
                    // Disparar evento personalizado para notificar que está listo
                    window.dispatchEvent(new CustomEvent('wompi-sdk-ready'));
                } else {
                    console.warn('⚠️ WidgetCheckout aún no está disponible, puede tardar unos segundos más');
                    // Intentar nuevamente después de 1 segundo
                    setTimeout(function() {
                        if (typeof WidgetCheckout !== 'undefined') {
                            console.log('✅ WidgetCheckout disponible (carga tardía)');
                            window.dispatchEvent(new CustomEvent('wompi-sdk-ready'));
                        } else {
                            console.error('❌ WidgetCheckout no está disponible después de cargar el SDK');
                        }
                    }, 1000);
                }
            }, 500);
        };
        
        script.onerror = function(error) {
            console.error('❌ Error al cargar el SDK de Wompi (widget.js)');
            console.error('URL que falló: https://checkout.wompi.co/widget.js');
            console.error('Error completo:', error);
            
            // Intentar obtener más información del error
            fetch('https://checkout.wompi.co/widget.js', { method: 'HEAD', mode: 'no-cors' })
                .catch(() => {
                    console.error('📋 DIAGNÓSTICO:');
                    console.error('El recurso no está accesible. Esto puede ser:');
                    console.error('1. Error de CloudFront (CDN de AWS) - Problema temporal');
                    console.error('2. Dominio no autorizado');
                    console.error('3. Problema de red/firewall');
                    
                    const errorMsg = 'Error al cargar el SDK de Wompi.\n\n' +
                                   'Si ves un error de CloudFront, es un problema temporal del servicio.\n\n' +
                                   'SOLUCIONES:\n' +
                                   '1. Espera unos minutos e intenta nuevamente\n' +
                                   '2. Recarga la página (Ctrl+F5)\n' +
                                   '3. Si persiste, verifica:\n' +
                                   '   - Tu conexión a internet\n' +
                                   '   - Que el dominio esté autorizado en Wompi\n' +
                                   '   - El estado del servicio: https://status.wompi.co';
                    
                    alert(errorMsg);
                });
        };
        
        if (document.head) {
            document.head.appendChild(script);
        } else {
            console.error('❌ document.head no está disponible');
        }
    })();
</script>

<script>
// Log inicial FUERA de cualquier bloque para asegurar que siempre se ejecute
console.log('🟣🟣🟣 ===== WOMPI HANDLER: INICIO DE EJECUCIÓN ===== 🟣🟣🟣');
console.log('🟣 Este log DEBE aparecer si el handler se está cargando');
console.log('🟣 Timestamp:', new Date().toISOString());

// Inmediatamente registrar el handler para evitar problemas de timing
(function() {
    'use strict';
    
    console.log('🟣 Wompi Handler: Iniciando registro INMEDIATAMENTE...');
    
    // Asegurar que PaymentHandlers existe antes de registrarse
    if (typeof window.PaymentHandlers === 'undefined') {
        window.PaymentHandlers = {};
        console.log('🟣 PaymentHandlers creado');
    } else {
        console.log('🟣 PaymentHandlers ya existe:', Object.keys(window.PaymentHandlers));
    }
    
    try {
    const wompiConfig = {
        publicKey: "{{ addslashes($publicKey) }}",
        privateKey: "{{ addslashes($privateKey) }}",
        integrityKey: "{{ addslashes($integrityKey) }}"
    };

    console.log('🟣 Wompi Handler: Configuración recibida', {
        hasPublicKey: !!wompiConfig.publicKey && wompiConfig.publicKey.length > 0,
        publicKeyLength: wompiConfig.publicKey ? wompiConfig.publicKey.length : 0,
        publicKeyPrefix: wompiConfig.publicKey ? wompiConfig.publicKey.substring(0, 15) + '...' : 'N/A',
        publicKeyStarts: wompiConfig.publicKey ? wompiConfig.publicKey.substring(0, 12) : 'N/A',
        hasPrivateKey: !!wompiConfig.privateKey && wompiConfig.privateKey.length > 0,
        privateKeyLength: wompiConfig.privateKey ? wompiConfig.privateKey.length : 0,
        hasIntegrityKey: !!wompiConfig.integrityKey && wompiConfig.integrityKey.length > 0,
        integrityKeyLength: wompiConfig.integrityKey ? wompiConfig.integrityKey.length : 0,
        websiteSlug: "{{ addslashes($websiteSlug) }}"
    });
    
    // Validar que tenemos la clave pública
    if (!wompiConfig.publicKey || wompiConfig.publicKey.length === 0) {
        console.error('❌ ERROR CRÍTICO: No se proporcionó la clave pública de Wompi');
        console.error('Valor recibido:', wompiConfig.publicKey);
        console.error('Longitud:', wompiConfig.publicKey ? wompiConfig.publicKey.length : 0);
        console.error('El handler NO se registrará porque falta la configuración esencial');
        console.error('⚠️ Verifica que la clave pública esté guardada en la base de datos del website');
        return; // Salir sin registrar el handler
    }
    
    // Validar formato de clave pública
    if (!wompiConfig.publicKey.match(/^pub_(test|prod)_/)) {
        console.warn('⚠️ ADVERTENCIA: La clave pública no tiene el formato esperado');
        console.warn('Formato esperado: pub_test_... o pub_prod_...');
        console.warn('Valor recibido (primeros 20 chars):', wompiConfig.publicKey.substring(0, 20));
        // Continuamos de todas formas porque puede ser válida
    }
    
    console.log('✅ Validación pasada: La clave pública existe y será usada');

    // Registrar el handler
    window.PaymentHandlers.wompi = {
        async checkout(payload) {
            const { cart, totals, customer } = payload || {};

            console.log('💜 Iniciando checkout de Wompi', {
                cartItems: cart?.length,
                total: totals?.gross,
                customer: customer?.email
            });

            if (!cart || cart.length === 0) {
                alert('El carrito está vacío.');
                return;
            }

            if (!wompiConfig.publicKey) {
                alert('La pasarela de pago Wompi no está configurada. Por favor contacta al administrador.');
                return;
            }

            // Función auxiliar para esperar a que el SDK se cargue
            const waitForWidgetCheckout = (maxAttempts = 30, delay = 200) => {
                return new Promise((resolve, reject) => {
                    // Si ya está disponible, resolver inmediatamente
                    if (typeof WidgetCheckout !== 'undefined') {
                        resolve();
                        return;
                    }

                    // Escuchar evento personalizado de SDK listo
                    const onSdkReady = () => {
                        if (typeof WidgetCheckout !== 'undefined') {
                            window.removeEventListener('wompi-sdk-ready', onSdkReady);
                            clearInterval(checkInterval);
                            resolve();
                        }
                    };
                    window.addEventListener('wompi-sdk-ready', onSdkReady);

                    let attempts = 0;
                    const checkInterval = setInterval(() => {
                        attempts++;
                        if (typeof WidgetCheckout !== 'undefined') {
                            window.removeEventListener('wompi-sdk-ready', onSdkReady);
                            clearInterval(checkInterval);
                            resolve();
                        } else if (attempts >= maxAttempts) {
                            window.removeEventListener('wompi-sdk-ready', onSdkReady);
                            clearInterval(checkInterval);
                            reject(new Error('WidgetCheckout no está disponible después de ' + (maxAttempts * delay) + 'ms'));
                        }
                    }, delay);
                });
            };

            // Esperar a que el SDK esté disponible
            try {
                await waitForWidgetCheckout();
                console.log('✅ SDK de Wompi disponible, procediendo con checkout');
            } catch (error) {
                console.error('❌ SDK de Wompi no cargado:', error);
                alert('Error al cargar el sistema de pagos de Wompi. Por favor recarga la página. Si el problema persiste, verifica:\n\n1. Tu conexión a internet\n2. Que el dominio esté autorizado en Wompi\n3. Que no haya bloqueos de firewall');
                return;
            }

            try {
                // Validar que la clave pública tenga el formato correcto
                if (!wompiConfig.publicKey.match(/^pub_(test|prod)_/)) {
                    console.error('❌ Clave pública de Wompi con formato inválido');
                    alert('Error: La clave pública de Wompi tiene un formato inválido. Debe comenzar con pub_test_ o pub_prod_.');
                    return;
                }

                // Validar dominio (Wompi no permite localhost en producción)
                const currentDomain = window.location.hostname;
                const isLocalhost = currentDomain === 'localhost' || currentDomain === '127.0.0.1' || currentDomain.startsWith('192.168.');
                const isTestKey = wompiConfig.publicKey.startsWith('pub_test_');
                const isProdKey = wompiConfig.publicKey.startsWith('pub_prod_');
                
                // BLOQUEAR: No permitir claves de producción en localhost
                if (isLocalhost && isProdKey) {
                    const errorMsg = '🔴 ERROR: Claves de PRODUCCIÓN detectadas en localhost\n\n' +
                                   'Wompi NO permite usar claves de producción (pub_prod_) en dominios locales.\n\n' +
                                   'SOLUCIÓN:\n\n' +
                                   '1. Ve a tu panel: Integraciones → Wompi - Pagos\n' +
                                   '2. Cambia la Public Key a una clave de PRUEBA (pub_test_...)\n' +
                                   '3. También cambia la Private Key a una clave de PRUEBA (prv_test_...)\n' +
                                   '4. Guarda los cambios\n' +
                                   '5. Recarga esta página e intenta nuevamente\n\n' +
                                   '📋 Obtén claves de prueba en: https://comercios.wompi.co';
                    
                    console.error('🔴 ========================================');
                    console.error('🔴 ERROR: CLAVES DE PRODUCCIÓN EN LOCALHOST');
                    console.error('🔴 ========================================');
                    console.error('Dominio:', currentDomain);
                    console.error('Clave detectada:', wompiConfig.publicKey.substring(0, 20) + '...');
                    console.error('');
                    console.error('Wompi bloquea claves de producción en localhost.');
                    console.error('Debes usar claves de prueba (pub_test_) para desarrollo local.');
                    console.error('🔴 ========================================');
                    
                    alert(errorMsg);
                    return; // Detener la ejecución
                }

                // PASO 1: Generar referencia única para la transacción
                const reference = `WOM-${Date.now()}-${Math.random().toString(36).substring(7)}`;
                
                // PASO 2: Crear la orden ANTES de abrir el widget
                console.log('📦 Creando orden antes de procesar el pago...');
                
                // Función auxiliar para obtener website slug de la URL (declarada una sola vez)
                function getWebsiteSlugFromUrl() {
                    const path = window.location.pathname;
                    const parts = path.split('/').filter(p => p);
                    return parts[0] || '';
                }
                
                // Usar window.websiteSlug si existe, sino obtenerlo de otras fuentes
                const websiteSlug = window.websiteSlug || "{{ addslashes($websiteSlug) }}" || (typeof templateConfig !== 'undefined' && templateConfig?.websiteSlug) || getWebsiteSlugFromUrl() || '';

                // Obtener CartState desde el contexto global (del script del carrito)
                const CartState = window.getCartState ? window.getCartState() : null;
                
                // Obtener datos del cliente autenticado (similar a processCashOnDeliveryOrder)
                let authData = { user: null };
                try {
                    const authResponse = await fetch(`/${websiteSlug}/api/check-auth`, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json'
                        }
                    });
                    authData = await authResponse.json();
                    console.log('👤 Datos del cliente autenticado:', authData);
                } catch (authError) {
                    console.warn('⚠️ No se pudieron obtener datos del cliente autenticado:', authError);
                }
                
                // Obtener datos necesarios para crear la orden
                const selectedAddress = CartState?.addresses?.find(a => a.id == CartState?.selectedAddressId);
                
                // Preparar datos del cliente
                const customerDataForOrder = {
                    name: authData.user?.name || customer?.name || CartState?.checkoutData?.name || 'Cliente',
                    email: authData.user?.email || customer?.email || CartState?.checkoutData?.email || 'cliente@email.com',
                    phone: customer?.phone || authData.user?.phone || CartState?.checkoutData?.phone || '3000000000'
                };
                
                console.log('📝 Datos del cliente para la orden:', customerDataForOrder);
                
                try {
                    const orderResponse = await fetch(`/${websiteSlug}/checkout/process`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            website_slug: websiteSlug,
                            items: cart.map(item => ({
                                product_id: item.id,
                                name: item.name,
                                quantity: item.quantity,
                                price: item.price,
                                iva: item.iva || 0,
                                image: item.image || null
                            })),
                            customer: customerDataForOrder,
                            shipping_address: {
                                address_id: selectedAddress?.id || CartState?.selectedAddressId || null,
                                address: customer?.address || selectedAddress?.address || selectedAddress?.direccion || CartState?.checkoutData?.address || 'Sin dirección',
                                city: customer?.city || selectedAddress?.city || selectedAddress?.ciudad || CartState?.checkoutData?.city || 'Bogotá',
                                state: customer?.state || selectedAddress?.state || selectedAddress?.barrio || CartState?.checkoutData?.state || 'Cundinamarca',
                                phone: customerDataForOrder.phone,
                                name: customerDataForOrder.name
                            },
                            payment_method: 'online_payment',
                            currency: 'COP',
                            tax_amount: totals?.tax || 0,
                            shipping_amount: 0,
                            payment_reference: reference // Guardar la referencia en la orden
                        })
                    });

                    const orderData = await orderResponse.json();
                    
                    if (!orderData.success) {
                        console.error('❌ Error al crear la orden:', orderData.message);
                        alert('Error al procesar el pedido: ' + (orderData.message || 'Error desconocido'));
                        return;
                    }

                    console.log('✅ Orden creada exitosamente:', orderData.order);
                    console.log('📝 Payment reference guardado:', reference);
                    
                    // El payment_reference ya se guardó al crear la orden
                    // Continuamos con el proceso de pago
                    
                } catch (orderError) {
                    console.error('❌ Error al crear la orden:', orderError);
                    alert('Error al procesar el pedido. Por favor intenta nuevamente.');
                    return;
                }
                
                // Calcular el monto en centavos (Wompi trabaja con centavos)
                const amountInCents = Math.round((totals?.gross ?? 0) * 100);
                
                // Validar monto mínimo (Wompi requiere mínimo 100 centavos = $1 COP)
                if (amountInCents < 100) {
                    alert('El monto mínimo de pago es $1.00 COP.');
                    return;
                }
                
                // URL de redirección
                const redirectUrl = window.location.origin + '/payment/wompi/response';

                // websiteSlug ya está declarado arriba (línea 379), no necesitamos redeclararlo

                // Generar firma de integridad (si está configurada)
                let integritySignature = null;
                if (wompiConfig.integrityKey && websiteSlug) {
                    try {
                        console.log('🔐 Generando firma de integridad...');
                        const signatureResponse = await fetch('/payment/wompi/generate-signature', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                            },
                            body: JSON.stringify({
                                reference: reference,
                                amount_in_cents: amountInCents,
                                currency: 'COP',
                                website_slug: websiteSlug
                            })
                        });

                        const signatureData = await signatureResponse.json();
                        if (signatureData.success && signatureData.signature) {
                            integritySignature = signatureData.signature;
                            console.log('✅ Firma de integridad generada correctamente');
                        } else {
                            console.warn('⚠️ No se pudo generar la firma de integridad:', signatureData.message || 'Error desconocido');
                            console.warn('El widget funcionará sin firma (puede ser menos seguro)');
                        }
                    } catch (error) {
                        console.warn('⚠️ Error al generar firma de integridad:', error);
                        console.warn('El widget funcionará sin firma (puede ser menos seguro)');
                    }
                } else {
                    console.info('ℹ️ Firma de integridad no configurada. El widget funcionará sin ella.');
                }

                // Información detallada para diagnóstico
                console.log('💳 Datos de pago Wompi:', {
                    reference,
                    amountInCents,
                    currency: 'COP',
                    publicKey: wompiConfig.publicKey.substring(0, 20) + '...',
                    publicKeyPrefix: wompiConfig.publicKey.substring(0, 12),
                    domain: currentDomain,
                    fullUrl: window.location.href,
                    isLocalhost: isLocalhost,
                    isTestKey: isTestKey,
                    hasIntegritySignature: !!integritySignature
                });

                // Este código ya no se ejecutará si hay claves de producción en localhost
                // porque se bloquea arriba. Aquí solo validamos otros casos.

                // Mostrar información sobre dominio para producción
                if (!isLocalhost && !currentDomain.includes('localhost') && !currentDomain.includes('127.0.0.1')) {
                    console.info('');
                    console.info('ℹ️ ===========================================');
                    console.info('ℹ️ DIAGNÓSTICO DE CONFIGURACIÓN WOMPI');
                    console.info('ℹ️ ===========================================');
                    console.info('Dominio actual:', currentDomain);
                    console.info('URL completa:', window.location.href);
                    console.info('Tipo de clave:', isTestKey ? 'PRUEBA (pub_test_)' : 'PRODUCCIÓN (pub_prod_)');
                    console.info('');
                    console.info('Si recibes un error 403, necesitas autorizar este dominio:');
                    console.info('1. Ve a: https://comercios.wompi.co');
                    console.info('2. Inicia sesión');
                    console.info('3. Ve a: Desarrolladores → Dominios Autorizados');
                    console.info('4. Agrega:', currentDomain);
                    if (currentDomain.indexOf('www.') === -1) {
                        console.info('5. Si también usas www, agrega: www.' + currentDomain);
                    }
                    console.info('6. Guarda y espera 2-3 minutos');
                    console.info('ℹ️ ===========================================');
                    console.info('');
                } else {
                    // Verificar si está usando ngrok o un dominio público
                    const isNgrok = currentDomain.includes('ngrok');
                    const isPublicDomain = !isLocalhost && !currentDomain.includes('localhost') && !currentDomain.includes('127.0.0.1');
                    
                    if (isNgrok) {
                        console.info('');
                        console.info('✅ ngrok detectado - Dominio público HTTPS');
                        console.info('✅ Configuración perfecta para probar Wompi');
                        console.info('✅ El widget debería funcionar correctamente');
                        console.info('');
                    } else if (isPublicDomain) {
                        console.info('');
                        console.info('✅ Dominio público detectado');
                        console.info('✅ Configuración correcta para Wompi');
                        console.info('');
                    } else {
                        // Desarrollo local con claves de prueba
                        console.info('');
                        console.info('✅ Desarrollo local detectado con claves de prueba');
                        console.info('✅ Configuración correcta para desarrollo');
                        console.info('');
                        console.info('⚠️ NOTA: Si recibes un error 403, puede ser porque:');
                        console.info('1. Wompi bloquea localhost incluso con claves de prueba');
                        console.info('2. Usa ngrok para exponer tu localhost: https://ngrok.com/');
                        console.info('3. O prueba en un servidor de staging con un dominio público');
                        console.info('');
                    }
                }

                // Listener para errores del widget (antes de crear el checkout)
                const widgetErrorHandler = function(event) {
                    // Verificar si el mensaje viene de Wompi
                    if (event.origin === 'https://checkout.wompi.co' || 
                        event.origin === 'https://comercios.wompi.co' ||
                        event.origin.includes('wompi')) {
                        console.log('📨 Mensaje recibido de Wompi:', event.data);
                        
                        if (event.data) {
                            const data = typeof event.data === 'string' ? JSON.parse(event.data) : event.data;
                            
                            // Detectar errores
                            if (data.type === 'error' || data.error || data.code === 'FORBIDDEN' || 
                                (data.message && data.message.includes('403'))) {
                                console.error('❌ Error del widget de Wompi:', data);
                                
                                // Manejar error 403 específicamente
                                if (data.message && data.message.includes('403') || 
                                    data.code === 'FORBIDDEN' ||
                                    data.error === 'FORBIDDEN' ||
                                    (data.message && data.message.includes('forbidden'))) {
                                    alert('🔴 Error 403: El dominio "' + currentDomain + '" no está autorizado en Wompi.\n\n' +
                                          'SOLUCIÓN:\n' +
                                          '1. Ingresa a https://comercios.wompi.co\n' +
                                          '2. Ve a Configuración → Dominios (o Integraciones)\n' +
                                          '3. Agrega tu dominio: ' + currentDomain + '\n' +
                                          '4. Guarda los cambios y espera 2-3 minutos\n' +
                                          '5. Si estás en localhost, asegúrate de usar claves de prueba (pub_test_)');
                                }
                            }
                        }
                    }
                };
                window.addEventListener('message', widgetErrorHandler);

                // Configurar el checkout de Wompi
                let checkout;
                try {
                    // Configuración base del widget
                    const widgetConfig = {
                        currency: 'COP',
                        amountInCents: amountInCents,
                        reference: reference,
                        publicKey: wompiConfig.publicKey,
                        redirectUrl: redirectUrl,
                        taxInCents: {
                            vat: Math.round((totals?.tax ?? 0) * 100),  // IVA
                            consumption: 0  // Impuesto al consumo
                        },
                        customerData: {
                            email: customerDataForOrder.email,
                            fullName: customerDataForOrder.name,
                            phoneNumber: customerDataForOrder.phone,
                            phoneNumberPrefix: '+57',
                            legalId: customer?.document || '1234567890',
                            legalIdType: 'CC'  // CC, CE, NIT, etc.
                        },
                        shippingAddress: {
                            addressLine1: selectedAddress?.address || selectedAddress?.direccion || CartState?.checkoutData?.address || customer?.address || 'Sin dirección',
                            city: selectedAddress?.city || selectedAddress?.ciudad || CartState?.checkoutData?.city || customer?.city || 'Bogotá',
                            phoneNumber: customerDataForOrder.phone,
                            region: selectedAddress?.state || selectedAddress?.barrio || CartState?.checkoutData?.state || customer?.state || 'Cundinamarca',
                            country: 'CO'
                        }
                    };

                    // Agregar firma de integridad si está disponible
                    if (integritySignature) {
                        widgetConfig.signature = {
                            integrity: integritySignature
                        };
                        console.log('🔐 Firma de integridad incluida en el widget');
                    }

                    checkout = new WidgetCheckout(widgetConfig);
                    console.log('✅ WidgetCheckout creado correctamente' + (integritySignature ? ' con firma de integridad' : ''));
                } catch (initError) {
                    console.error('❌ Error al crear WidgetCheckout:', initError);
                    if (initError.message && initError.message.includes('403')) {
                        alert('🔴 Error 403: El dominio no está autorizado. Verifica la configuración en Wompi.');
                    }
                    throw initError;
                }

                // Abrir el widget de Wompi con timeout
                const openTimeout = setTimeout(() => {
                    console.warn('⚠️ El widget de Wompi está tardando en abrirse');
                    console.warn('Esto puede indicar un problema de conexión o autorización');
                }, 5000);

                // Interceptor para detectar errores 403 en iframes o recursos del widget
                const errorInterceptor = window.addEventListener('error', function(event) {
                    if (event.target && event.target.src && event.target.src.includes('wompi')) {
                        console.error('❌ Error cargando recurso del widget:', event.target.src);
                        if (event.message && event.message.includes('403')) {
                            console.error('🔴 DETECTADO ERROR 403');
                            console.error('URL que falló:', event.target.src);
                            console.error('Dominio actual:', currentDomain);
                            console.error('');
                            console.error('SOLUCIÓN:');
                            console.error('1. Ve a https://comercios.wompi.co');
                            console.error('2. Inicia sesión');
                            console.error('3. Ve a Desarrolladores → Dominios Autorizados');
                            console.error('4. Agrega el dominio:', currentDomain);
                            console.error('5. Guarda y espera 2-3 minutos');
                        }
                    }
                }, true);

                try {
                    checkout.open(function (result) {
                        clearTimeout(openTimeout);
                        window.removeEventListener('error', errorInterceptor);
                        // Remover el listener después de que se procese el resultado
                        window.removeEventListener('message', widgetErrorHandler);
                        console.log('💜 Resultado de Wompi:', result);
                        
                        // El resultado contiene información sobre la transacción
                        if (result.transaction) {
                            const transaction = result.transaction;
                            
                            console.log('✅ Transacción procesada', {
                                id: transaction.id,
                                status: transaction.status,
                                reference: transaction.reference
                            });

                            // Si el pago fue exitoso, limpiar el carrito antes de redirigir
                            if (transaction.status === 'APPROVED') {
                                console.log('✅ Pago aprobado, limpiando carrito...');
                                
                                // Limpiar carrito
                                if (window.getCartState) {
                                    const cartState = window.getCartState();
                                    if (cartState) {
                                        cartState.items = [];
                                        // Guardar carrito vacío
                                        localStorage.setItem('cart', JSON.stringify([]));
                                        localStorage.removeItem('cartCheckoutData');
                                        console.log('✅ Carrito limpiado');
                                    }
                                } else {
                                    // Fallback: limpiar directamente del localStorage
                                    localStorage.setItem('cart', JSON.stringify([]));
                                    localStorage.removeItem('cartCheckoutData');
                                    console.log('✅ Carrito limpiado (fallback)');
                                }
                                
                                // Disparar evento para actualizar la UI del carrito
                                window.dispatchEvent(new CustomEvent('cartUpdated'));
                            }

                            // Redirigir a página de confirmación
                            window.location.href = redirectUrl + '?ref=' + reference + '&id=' + transaction.id;
                        } else if (result.error) {
                            console.error('❌ Error en la transacción:', result.error);
                            alert('Error al procesar el pago: ' + (result.error.message || 'Error desconocido'));
                        }
                    });

                    console.log('✅ Llamada a checkout.open() ejecutada');
                } catch (openError) {
                    clearTimeout(openTimeout);
                    window.removeEventListener('error', errorInterceptor);
                    console.error('❌ Error al llamar checkout.open():', openError);
                    throw openError;
                }

            } catch (error) {
                console.error('❌ Error al abrir el checkout de Wompi:', error);
                console.error('Stack trace:', error.stack);
                
                // Mensaje más específico según el tipo de error
                let errorMessage = 'No fue posible iniciar el pago. Por favor intenta nuevamente.';
                
                if (error.message && (error.message.includes('403') || error.message.includes('Forbidden'))) {
                    // Verificar si es un error de CloudFront
                    const isCloudFront = error.message.includes('CloudFront') || 
                                       error.message.includes('cloudfront') ||
                                       error.message.includes('Request blocked') ||
                                       error.message.includes('could not be satisfied');
                    
                    if (isCloudFront) {
                        errorMessage = '🔴 ERROR 403 DE CLOUDFRONT (CDN de Wompi)\n\n' +
                                      'Este NO es un problema de dominio no autorizado.\n' +
                                      'Es un problema temporal del servicio de Wompi.\n\n' +
                                      'SOLUCIONES:\n\n' +
                                      '1. Espera 2-3 minutos e intenta nuevamente\n' +
                                      '2. Recarga la página completamente (Ctrl+F5)\n' +
                                      '3. Prueba desde otra conexión de internet\n' +
                                      '4. Verifica el estado del servicio:\n' +
                                      '   https://status.wompi.co\n\n' +
                                      'Si el problema persiste después de varios intentos:\n' +
                                      'Contacta soporte: soporte@wompi.co';
                    } else {
                        errorMessage = '🔴 ERROR 403: El dominio "' + currentDomain + '" no está autorizado en Wompi.\n\n' +
                                       'SOLUCIÓN PASO A PASO:\n\n' +
                                       '1. Ingresa a: https://comercios.wompi.co\n' +
                                       '2. Inicia sesión con tu cuenta\n' +
                                       '3. Ve a la sección "Desarrolladores" o "Developers"\n' +
                                       '4. Busca "Dominios Autorizados" o "Authorized Domains"\n' +
                                       '5. Agrega tu dominio: ' + currentDomain + '\n' +
                                       '6. Si usas "www", agrega también: www.' + currentDomain + '\n' +
                                       '7. Guarda los cambios y espera 2-3 minutos\n\n' +
                                       'NOTA: Si estás en localhost (127.0.0.1), asegúrate de usar claves de PRUEBA (pub_test_).';
                    }
                } else if (error.message && error.message.includes('domain')) {
                    errorMessage = 'Error: El dominio debe estar autorizado en el panel de Wompi.';
                }
                
                alert(errorMessage);
                
                // Mostrar información adicional en consola
                console.error('🔍 INFORMACIÓN PARA RESOLVER EL ERROR 403:');
                console.error('Dominio actual:', currentDomain);
                console.error('URL completa:', window.location.href);
                console.error('Tipo de clave:', isTestKey ? 'PRUEBA (pub_test_)' : 'PRODUCCIÓN (pub_prod_)');
                console.error('¿Es localhost?', isLocalhost);
                console.error('');
                console.error('📋 PASOS PARA AUTORIZAR EL DOMINIO:');
                console.error('1. https://comercios.wompi.co → Desarrolladores → Dominios Autorizados');
                console.error('2. Agregar:', currentDomain);
                console.error('3. Guardar y esperar 2-3 minutos');
            }
        },

        /**
         * Verificar el estado de una transacción
         */
        async checkTransactionStatus(transactionId) {
            try {
                // En producción, esto debería llamar a tu backend
                // que a su vez consulta la API de Wompi con la private key
                const response = await fetch(`/api/wompi/transaction/${transactionId}`, {
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();
                return data;
            } catch (error) {
                console.error('Error verificando transacción de Wompi:', error);
                return null;
            }
        }
    };

    console.log('🟣 Wompi Handler: Registro completado exitosamente');
    
    console.log('✅✅✅ Wompi Payment Handler registrado correctamente ✅✅✅');
    console.log('🔍 Verificación final:', {
        PaymentHandlers: typeof window.PaymentHandlers,
        wompiHandler: typeof window.PaymentHandlers.wompi,
        hasCheckout: typeof window.PaymentHandlers.wompi?.checkout === 'function',
        allHandlers: Object.keys(window.PaymentHandlers)
    });
    
        // Disparar evento para notificar que el handler está listo
        try {
            window.dispatchEvent(new CustomEvent('wompi-handler-ready'));
            console.log('📢 Evento wompi-handler-ready disparado');
        } catch (error) {
            console.error('❌ Error al disparar evento wompi-handler-ready:', error);
        }
    } catch (error) {
        console.error('❌ ERROR CRÍTICO en el handler de Wompi:', error);
        console.error('Stack trace:', error.stack);
        console.error('El handler NO se pudo registrar debido a un error');
    }
})();

console.log('🔵 SCRIPT DE WOMPI HANDLER: Fin de ejecución');
</script>

