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
    window.websiteApiKey = "{{ $website->api_key ?? '' }}";
    window.websiteApiUrl = "{{ $website->api_base_url ?? '' }}";

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
        template: window.templateSlug,
        colors: window.templateColors
    });
</script>

<!-- SDK de Pasarela de Pago -->
@php
$paymentGateway = $website->default_payment_gateway ?? 'epayco';
@endphp

@if($paymentGateway === 'wompi' && $website->wompi_public_key)
<!-- SDK de Wompi -->
<script src="https://checkout.wompi.co/widget.js"></script>
<script>
    console.log("✅ SDK de Wompi cargado");
    console.log("🔍 WidgetCheckout disponible:", typeof WidgetCheckout !== "undefined");
</script>
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
    document.head.appendChild(script);
</script>
@endif

<!-- Scripts de productos y carrito -->
<x-products-script
    :apiKey="$website->api_key"
    :apiBaseUrl="$website->api_base_url"
    :templateSlug="$templateSlug"
    :colors="$colors" />
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
    :cashOnDeliveryInstructions="$website->cash_on_delivery_instructions ?? ''" />

<!-- Handler de Pasarela de Pago -->
@php
$paymentGateway = $website->default_payment_gateway ?? 'epayco';
@endphp

@if($paymentGateway === 'wompi' && $website->wompi_public_key)
<x-payments.wompi.handler
    :publicKey="$website->wompi_public_key"
    :privateKey="$website->wompi_private_key"
    :integrityKey="$website->wompi_integrity_key" />
@elseif($website->epayco_public_key)
<x-payments.epayco.handler
    :publicKey="$website->epayco_public_key"
    :privateKey="$website->epayco_private_key"
    :customerId="$website->epayco_customer_id" />
@endif

<!-- Script de autenticación de usuario -->
<x-auth.user-auth-script :website="$website" />