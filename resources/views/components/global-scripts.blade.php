{{--
    Componente global para incluir scripts de productos y carrito en todas las plantillas
    
    @param object $website - Objeto del sitio web con credenciales API y ePayco
    @param array $customization - Configuración de colores y estilos de la plantilla (opcional)
--}}
@props(['website', 'customization' => []])

@php
    // Obtener el slug de la plantilla activa
    $templateSlug = $website->template_id ?? 'default';
    
    // Configuración de colores por defecto si no se proporciona customization
    $defaultColors = [
        'primary' => '#2563eb',
        'secondary' => '#7c3aed',
        'accent' => '#10b981',
        'background' => '#f9fafb',
        'text' => '#111827'
    ];
    
    // Combinar colores proporcionados con los por defecto
    $colors = array_merge($defaultColors, $customization['colors'] ?? []);
@endphp

<!-- Configuración de variables JavaScript globales -->
<script>
    console.log('🔧 Configurando variables API globales');
    // Solo asignar si no existen para evitar redeclaraciones
    if (typeof window.websiteApiKey === 'undefined') {
        window.websiteApiKey = "{{ $website->api_key ?? '' }}";
    }
    if (typeof window.websiteApiUrl === 'undefined') {
        window.websiteApiUrl = "{{ $website->api_base_url ?? '' }}";
    }
    if (typeof window.websiteSlug === 'undefined') {
        window.websiteSlug = "{{ $website->slug ?? '' }}";
    }
    if (typeof window.websiteId === 'undefined') {
        window.websiteId = {{ $website->id ?? 0 }};
    }
    
    // Configuración de plantilla y estilos
    window.templateSlug = "{{ $templateSlug }}";
    window.templateColors = {
        primary: "{{ $colors['primary'] }}",
        secondary: "{{ $colors['secondary'] }}",
        accent: "{{ $colors['accent'] }}",
        background: "{{ $colors['background'] }}",
        text: "{{ $colors['text'] }}"
    };
    
    console.log('🔧 Variables configuradas:', {
        apiKey: window.websiteApiKey ? 'Configurada' : 'No configurada',
        apiUrl: window.websiteApiUrl || 'No configurada',
        websiteSlug: window.websiteSlug || 'No configurada',
        websiteId: window.websiteId || 'No configurada',
        template: window.templateSlug,
        colors: window.templateColors
    });
</script>

<!-- SDK de Pasarela de Pago -->
@php
    $paymentGateway = $website->default_payment_gateway ?? 'epayco';
@endphp

@if($paymentGateway === 'wompi' && $website->wompi_public_key)
    <!-- SDK de Wompi se carga en el handler para mejor manejo de errores -->
@else
    <!-- SDK de Epayco (por defecto) -->
    <script type="text/javascript">
        console.log("🔄 Cargando SDK de Epayco...");
        var script = document.createElement("script");
        script.type = "text/javascript";
        script.src = "https://checkout.epayco.co/checkout.js";
        script.onload = function() {
            console.log("✅ SDK de Epayco cargado correctamente");
            console.log("🔍 ePayco disponible:", typeof ePayco !== "undefined");
        };
        script.onerror = function() {
            console.error("❌ Error cargando SDK de Epayco");
        };
        if (document.head) {
            document.head.appendChild(script);
        } else {
            console.error('❌ document.head no está disponible');
        }
    </script>
@endif

<!-- Handler de Pasarela de Pago (DEBE CARGARSE ANTES del script del carrito) -->
<script>
    console.log('🔵🔵🔵 ===== INICIO: Cargando handlers de pago ===== 🔵🔵🔵');
    console.log('🔵 Este log DEBE aparecer al cargar la página');
    console.log('🔵 Si no ves este log, el componente global-scripts NO se está cargando');
</script>

@php
    $hasWompiPublicKey = !empty($website->wompi_public_key);
    $hasEpaycoPublicKey = !empty($website->epayco_public_key);
    
    // Si tiene credenciales de Wompi pero default_payment_gateway no está configurado como 'wompi',
    // asumimos que debe usar Wompi (compatibilidad hacia atrás)
    $paymentGateway = $website->default_payment_gateway ?? null;
    
    // Auto-detectar: Si tiene claves de Wompi y no tiene gateway configurado, usar Wompi
    if (!$paymentGateway && $hasWompiPublicKey) {
        $paymentGateway = 'wompi';
    } elseif (!$paymentGateway && $hasEpaycoPublicKey) {
        $paymentGateway = 'epayco';
    } else {
        $paymentGateway = $paymentGateway ?? 'epayco';
    }
    
    // Logs detallados de credenciales (sin mostrar valores completos por seguridad)
    $wompiKeyLength = $hasWompiPublicKey ? strlen($website->wompi_public_key) : 0;
    $wompiKeyPreview = $hasWompiPublicKey ? substr($website->wompi_public_key, 0, 15) . '...' : 'N/A';
    $wompiKeyStarts = $hasWompiPublicKey ? substr($website->wompi_public_key, 0, 12) : 'N/A';
    
    // Debug en PHP (solo para desarrollo)
    \Log::info('Payment Gateway Config', [
        'payment_gateway' => $paymentGateway,
        'original_gateway' => $website->default_payment_gateway ?? 'null',
        'has_wompi_key' => $hasWompiPublicKey,
        'wompi_key_length' => $wompiKeyLength,
        'wompi_key_starts' => $wompiKeyStarts,
        'auto_detected' => !$website->default_payment_gateway && $hasWompiPublicKey
    ]);
@endphp

<!-- Inicializar PaymentHandlers ANTES de cualquier handler -->
<script>
    // Asegurar que PaymentHandlers siempre existe
    if (typeof window.PaymentHandlers === 'undefined') {
        window.PaymentHandlers = {};
        console.log('🔧 PaymentHandlers inicializado globalmente');
    }
    
    console.log('🔍 DEBUG COMPLETO: Verificando pasarela de pago', {
        paymentGateway: '{{ $paymentGateway }}',
        originalGateway: '{{ $website->default_payment_gateway ?? "null" }}',
        hasWompiKey: {{ $hasWompiPublicKey ? 'true' : 'false' }},
        wompiKeyLength: {{ $wompiKeyLength }},
        wompiKeyPreview: '{{ $wompiKeyPreview }}',
        wompiKeyStarts: '{{ $wompiKeyStarts }}',
        hasEpaycoKey: {{ $hasEpaycoPublicKey ? 'true' : 'false' }},
        PaymentHandlersExists: typeof window.PaymentHandlers !== 'undefined',
        conditionMet: {{ ($paymentGateway === 'wompi' && $hasWompiPublicKey) ? 'true' : 'false' }},
        willLoadWompi: {{ ($paymentGateway === 'wompi' && $hasWompiPublicKey) ? 'true' : 'false' }}
    });
    
    // Log crítico para debug
    if ('{{ $paymentGateway }}' === 'wompi' && {{ $hasWompiPublicKey ? 'true' : 'false' }}) {
        console.log('✅✅✅ CONDICIÓN VERIFICADA: Se debe cargar Wompi ✅✅✅');
    } else {
        console.error('❌❌❌ CONDICIÓN NO CUMPLIDA: NO se cargará Wompi ❌❌❌');
        console.error('Razones:', {
            paymentGatewayEsWompi: '{{ $paymentGateway }}' === 'wompi',
            tieneClavePublica: {{ $hasWompiPublicKey ? 'true' : 'false' }},
            paymentGateway: '{{ $paymentGateway }}',
            wompiKeyLength: {{ $wompiKeyLength }}
        });
    }
    
    @if($paymentGateway === 'wompi')
        @if($hasWompiPublicKey)
            console.log('✅ CONDICIÓN CUMPLIDA: paymentGateway es "wompi" Y tiene clave pública');
        @else
            console.warn('⚠️ CONDICIÓN NO CUMPLIDA: paymentGateway es "wompi" pero NO tiene clave pública');
            console.warn('El handler de Wompi NO se cargará');
        @endif
    @else
        console.log('ℹ️ paymentGateway es "{{ $paymentGateway }}" (no es wompi)');
    @endif
</script>

@if($paymentGateway === 'wompi' && $hasWompiPublicKey)
    <!-- Cargar SDK de Wompi -->
    <script src="https://checkout.wompi.co/widget.js"></script>
    
    <!-- Handler simplificado: Incluir componente completo -->
    <x-payments.wompi.handler 
        :publicKey="$website->wompi_public_key"
        :privateKey="$website->wompi_private_key"
        :integrityKey="$website->wompi_integrity_key"
        :websiteSlug="$website->slug"
    />
@elseif($hasEpaycoPublicKey)
    <script>
        console.log('✅ Cargando handler de Epayco...');
    </script>
    <x-payments.epayco.handler 
        :publicKey="$website->epayco_public_key"
        :privateKey="$website->epayco_private_key"
        :customerId="$website->epayco_customer_id"
    />
@else
    <script>
        console.error('❌ PROBLEMA: No se encontró ninguna pasarela de pago configurada');
        console.error('Detalles:', {
            paymentGateway: '{{ $paymentGateway }}',
            hasWompiKey: {{ $hasWompiPublicKey ? 'true' : 'false' }},
            wompiKeyLength: {{ $wompiKeyLength }},
            hasEpaycoKey: {{ $hasEpaycoPublicKey ? 'true' : 'false' }}
        });
        console.error('⚠️ El handler NO se cargará y los pagos fallarán');
    </script>
@endif

<!-- Scripts de productos y carrito (después de los handlers) -->
<x-products-script 
    :apiKey="$website->api_key" 
    :apiBaseUrl="$website->api_base_url"
    :templateSlug="$templateSlug"
    :colors="$colors"
/>

<!-- Verificación del handler antes de cargar el script del carrito -->
<script>
    // Esperar un momento para que los handlers se registren
    setTimeout(function() {
        console.log('🔍 Verificación final de handlers de pago:', {
            PaymentHandlers: typeof window.PaymentHandlers !== 'undefined' ? 'existe' : 'NO EXISTE',
            handlers: typeof window.PaymentHandlers !== 'undefined' ? Object.keys(window.PaymentHandlers) : [],
            wompiHandler: typeof window.PaymentHandlers?.wompi !== 'undefined' ? 'existe' : 'NO EXISTE',
            wompiHasCheckout: typeof window.PaymentHandlers?.wompi?.checkout === 'function',
            expectedHandler: '{{ $website->default_payment_gateway ?? "epayco" }}'
        });
        
        if (typeof window.PaymentHandlers === 'undefined') {
            console.error('❌ CRÍTICO: PaymentHandlers no está definido. Los handlers no se cargaron correctamente.');
        } else if (typeof window.PaymentHandlers['{{ $website->default_payment_gateway ?? "epayco" }}'] === 'undefined') {
            console.error('❌ CRÍTICO: El handler esperado "{{ $website->default_payment_gateway ?? "epayco" }}" no está disponible.');
            console.error('Handlers disponibles:', Object.keys(window.PaymentHandlers));
        } else {
            console.log('✅ El handler esperado está disponible');
        }
    }, 100);
</script>

<x-cart.script 
    :epaycoPublicKey="$website->epayco_public_key" 
    :epaycoPrivateKey="$website->epayco_private_key" 
    :epaycoCustomerId="$website->epayco_customer_id"
    :templateSlug="$templateSlug"
    :colors="$colors"
    :paymentHandler="$website->default_payment_gateway ?? 'epayco'"
    :websiteSlug="$website->slug"
    :allowCashOnDelivery="$website->allow_cash_on_delivery ?? true"
    :allowOnlinePayment="$website->allow_online_payment ?? true"
    :cashOnDeliveryInstructions="$website->cash_on_delivery_instructions ?? ''"
/>

<!-- Script de autenticación de usuario -->
<x-auth.user-auth-script :website="$website" />

<!-- Script de blog (se ejecuta solo si hay un contenedor de blog en la página) -->
@if(!isset($blogScriptIncluded))
    @php $blogScriptIncluded = true; @endphp
    @include('components.blog-script', ['websiteId' => $website->id])
@endif

{{-- Script para eliminar placeholders eliminado: Ya no es necesario porque los placeholders solo aparecen en páginas nuevas sin contenido --}}