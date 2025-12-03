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

<!-- SDK de Epayco -->
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

<!-- Scripts de productos y carrito -->
<x-products-script 
    :apiKey="$website->api_key" 
    :apiBaseUrl="$website->api_base_url"
    :templateSlug="$templateSlug"
    :colors="$colors"
/>
<x-cart.script 
    :epaycoPublicKey="$website->epayco_public_key" 
    :epaycoPrivateKey="$website->epayco_private_key" 
    :epaycoCustomerId="$website->epayco_customer_id"
    :templateSlug="$templateSlug"
    :colors="$colors"
    :websiteSlug="$website->slug"
/>

<!-- Script de autenticación de usuario -->
<x-auth.user-auth-script :website="$website" />