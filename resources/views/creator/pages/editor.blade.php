<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Editor - {{ $editable->name ?? $editable->title }} - {{ $website->name }}</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    // Suprimir advertencia de producción de Tailwind CDN en desarrollo
    (function() {
      const originalWarn = console.warn;
      console.warn = function(...args) {
        if (args[0] && typeof args[0] === 'string' && args[0].includes('cdn.tailwindcss.com should not be used in production')) {
          return; // Suprimir esta advertencia específica
        }
        originalWarn.apply(console, args);
      };
    })();
  </script>
  <link rel="stylesheet" href="https://unpkg.com/grapesjs/dist/css/grapes.min.css">
  <style>
    :root {
      --gjs-primary: #2563eb;
      /* botones/acentos */
      --gjs-secondary: #111827;
      /* texto principal */
      --gjs-tertiary: #6b7280;
      /* texto suave */
      --gjs-quaternary: #e5e7eb;
      /* bordes suaves */
      --gjs-bg: #ffffff;
      /* fondo paneles */
      --gjs-font-size: 13px;
    }

    /* Fallback para versiones viejas (clases "one/two/three/four") */
    .gjs-one-bg {
      background: #ffffff;
    }

    .gjs-two-color {
      color: #111827;
    }

    .gjs-three-bg {
      background: #f3f4f6;
    }

    /* barras/paneles secundarios */
    .gjs-four-color {
      color: #374151;
    }

    .gjs-cv-canvas {
      width: 100% !important;
    }

    /* Paneles y botones */
    .gjs-pn-panel,
    .gjs-pn-views,
    .gjs-pn-options,
    .gjs-pn-commands {
      background: #ffffff;
      border-color: #e5e7eb;
    }

    .gjs-pn-btn {
      color: #374151;
    }

    .gjs-pn-btn.gjs-pn-active,
    .gjs-pn-btn:hover {
      background: #e5effe;
      color: #1d4ed8;
    }

    /* Contenedores de bloques/estilos/capas */
    .gjs-blocks-c,
    .gjs-layer-manager,
    .gjs-sm-sectors {
      background: #f8fafc;
      color: #111827;
    }

    .gjs-block,
    .gjs-block-label {
      color: #111827;
    }

    .gjs-field {
      background: #ffffff;
      color: #111827;
      border-color: #e5e7eb;
    }

    /* Forzar visibilidad de los managers */
    .gjs-sm-sectors {
      display: block !important;
      visibility: visible !important;
    }

    .gjs-sm-sector {
      display: block !important;
      visibility: visible !important;
    }

    .gjs-sm-property {
      display: block !important;
      visibility: visible !important;
    }

    .gjs-sm-label {
      display: block !important;
      visibility: visible !important;
    }

    .gjs-sm-field {
      display: block !important;
      visibility: visible !important;
    }

    /* === ESTILOS MEJORADOS PARA SECTORES - ESTILO ELEMENTOR === */

    /* Sectores (acordeones) */
    .gjs-sm-sector {
      border-bottom: 1px solid #e5e7eb !important;
      margin: 0 !important;
      background: #ffffff !important;
    }

    /* Títulos de sectores - estilo Elementor */
    .gjs-sm-sector .gjs-sm-title {
      cursor: pointer !important;
      user-select: none !important;
      padding: 14px 16px !important;
      background: #f9fafb !important;
      font-weight: 600 !important;
      font-size: 12px !important;
      color: #374151 !important;
      text-transform: uppercase !important;
      letter-spacing: 0.5px !important;
      display: flex !important;
      align-items: center !important;
      justify-content: space-between !important;
      transition: all 0.2s ease !important;
      border: none !important;
    }

    .gjs-sm-sector .gjs-sm-title:hover {
      background-color: #f3f4f6 !important;
      color: #2563eb !important;
    }

    /* Asegurar que los sectores colapsados oculten su contenido */
    .gjs-sm-sector.gjs-sm-open .gjs-sm-properties {
      display: block !important;
    }

    .gjs-sm-properties {
      display: block !important;
      visibility: visible !important;
      padding: 16px !important;
      background: #ffffff !important;
    }

    .gjs-sm-sector:not(.gjs-sm-open) .gjs-sm-properties {
      display: none !important;
    }

    /* Propiedades individuales */
    .gjs-sm-property {
      margin-bottom: 16px !important;
    }

    .gjs-sm-property:last-child {
      margin-bottom: 0 !important;
    }

    /* Labels de propiedades */
    .gjs-sm-label {
      font-size: 12px !important;
      font-weight: 500 !important;
      color: #374151 !important;
      margin-bottom: 6px !important;
    }

    /* Estilos para dropdowns del StyleManager */
    .gjs-sm-field select {
      background: #ffffff !important;
      border: 1px solid #d1d5db !important;
      border-radius: 4px !important;
      padding: 7px 10px !important;
      color: #111827 !important;
      font-size: 13px !important;
      width: 100% !important;
      cursor: pointer !important;
      transition: all 0.2s ease !important;
    }

    .gjs-sm-field select:focus {
      outline: none !important;
      border-color: #2563eb !important;
      box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1) !important;
    }

    .gjs-sm-field select:hover {
      border-color: #9ca3af !important;
    }

    /* Eliminar líneas/bordes no deseados */
    .gjs-sm-field {
      border-bottom: none !important;
    }

    .gjs-sm-property {
      border-bottom: none !important;
    }

    /* Estilos específicos para controles de radio/button groups */
    .gjs-sm-field .gjs-sm-radio {
      border: none !important;
      background: transparent !important;
    }

    .gjs-sm-field .gjs-sm-radio-item {
      border: 1px solid #e5e7eb !important;
      background: #ffffff !important;
      border-radius: 0 !important;
    }

    .gjs-sm-field .gjs-sm-radio-item:first-child {
      border-top-left-radius: 4px !important;
      border-bottom-left-radius: 4px !important;
    }

    .gjs-sm-field .gjs-sm-radio-item:last-child {
      border-top-right-radius: 4px !important;
      border-bottom-right-radius: 4px !important;
    }

    .gjs-sm-field .gjs-sm-radio-item.gjs-sm-active {
      background: #2563eb !important;
      color: #ffffff !important;
      border-color: #2563eb !important;
    }

    /* Estilos para inputs del StyleManager */
    .gjs-sm-field input[type="text"],
    .gjs-sm-field input[type="number"] {
      background: #ffffff !important;
      border: 1px solid #d1d5db !important;
      border-radius: 4px !important;
      padding: 7px 10px !important;
      color: #111827 !important;
      font-size: 13px !important;
      width: 100% !important;
      transition: all 0.2s ease !important;
    }

    .gjs-sm-field input:focus {
      outline: none !important;
      border-color: #2563eb !important;
      box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1) !important;
    }

    /* Color picker */
    .gjs-sm-field input[type="color"] {
      height: 36px !important;
      width: 60px !important;
      border: 1px solid #d1d5db !important;
      border-radius: 4px !important;
      cursor: pointer !important;
      padding: 3px !important;
    }

    /* Sliders / Range inputs */
    .gjs-sm-field input[type="range"] {
      width: 100% !important;
      height: 5px !important;
      border-radius: 3px !important;
      background: #e5e7eb !important;
      outline: none !important;
      margin: 8px 0 !important;
    }

    .gjs-sm-field input[type="range"]::-webkit-slider-thumb {
      -webkit-appearance: none !important;
      width: 16px !important;
      height: 16px !important;
      border-radius: 50% !important;
      background: #2563eb !important;
      cursor: pointer !important;
      transition: all 0.2s ease !important;
    }

    .gjs-sm-field input[type="range"]::-webkit-slider-thumb:hover {
      background: #1d4ed8 !important;
      transform: scale(1.1) !important;
    }

    /* Eliminar líneas adicionales y separadores no deseados */
    .gjs-sm-property::after {
      display: none !important;
    }

    .gjs-sm-property::before {
      display: none !important;
    }

    .gjs-sm-field::after {
      display: none !important;
    }

    .gjs-sm-field::before {
      display: none !important;
    }

    /* Eliminar bordes de separación entre propiedades */
    .gjs-sm-property+.gjs-sm-property {
      border-top: none !important;
    }

    /* Estilos para el contenedor de propiedades */
    .gjs-sm-properties {
      border: none !important;
    }

    /* Eliminar líneas de separación en radio buttons */
    .gjs-sm-radio-item+.gjs-sm-radio-item {
      border-left: none !important;
    }

    /* === ESTILOS DEL CONTENEDOR DE WIDGETS === */

    /* Contenedor general con scroll */
    .styles-container-widget {
      max-height: calc(100vh - 300px) !important;
      overflow-y: auto !important;
      overflow-x: hidden !important;
      background: #ffffff !important;
    }

    /* Scrollbar personalizado estilo moderno */
    .styles-container-widget::-webkit-scrollbar {
      width: 8px !important;
    }

    .styles-container-widget::-webkit-scrollbar-track {
      background: #f1f5f9 !important;
      border-radius: 4px !important;
    }

    .styles-container-widget::-webkit-scrollbar-thumb {
      background: #cbd5e1 !important;
      border-radius: 4px !important;
      transition: background 0.2s ease !important;
    }

    .styles-container-widget::-webkit-scrollbar-thumb:hover {
      background: #94a3b8 !important;
    }

    /* Scrollbar para FireFox */
    .styles-container-widget {
      scrollbar-width: thin !important;
      scrollbar-color: #cbd5e1 #f1f5f9 !important;
    }

    /* Contenedor principal del StyleManager */
    .gjs-sm-sectors {
      background: #ffffff !important;
    }


    /* Canvas alrededor del lienzo (fuera del iframe) */
    .gjs-editor-cont,
    .gjs-cv-canvas {
      background: #f3f4f6;
    }

    /* ===== Estilos para Layer Manager (Capas) ===== */
    .gjs-layer {
      background: #ffffff !important;
      border: 1px solid #e5e7eb !important;
      border-radius: 4px !important;
      margin-bottom: 4px !important;
      padding: 6px 8px !important;
      transition: all 0.2s !important;
    }

    .gjs-layer:hover {
      background: #f9fafb !important;
      border-color: #d1d5db !important;
    }

    .gjs-layer.gjs-selected {
      background: #eff6ff !important;
      border-color: #2563eb !important;
      box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1) !important;
    }

    .gjs-layer-title {
      color: #374151 !important;
      font-size: 13px !important;
      font-weight: 500 !important;
    }

    .gjs-layer-count {
      color: #9ca3af !important;
      font-size: 11px !important;
    }

    /* Iconos de visibilidad y edición en capas */
    .gjs-layer-vis,
    .gjs-layer-caret {
      color: #6b7280 !important;
    }

    .gjs-layer-vis:hover,
    .gjs-layer-caret:hover {
      color: #2563eb !important;
    }

    /* Indentación para capas anidadas */
    .gjs-layer-children {
      padding-left: 16px !important;
      border-left: 2px solid #e5e7eb !important;
      margin-left: 8px !important;
      margin-top: 4px !important;
    }

    /* ===== Estilos para Trait Manager (Propiedades) ===== */
    .gjs-trt-trait {
      background: #ffffff !important;
      border: 1px solid #e5e7eb !important;
      border-radius: 4px !important;
      margin-bottom: 8px !important;
      padding: 8px !important;
    }

    .gjs-trt-trait__wrp-label {
      color: #374151 !important;
      font-size: 12px !important;
      font-weight: 500 !important;
      margin-bottom: 4px !important;
    }

    .gjs-field input,
    .gjs-field textarea,
    .gjs-field select {
      background: #ffffff !important;
      border: 1px solid #d1d5db !important;
      border-radius: 4px !important;
      padding: 6px 8px !important;
      color: #111827 !important;
      font-size: 13px !important;
      width: 100% !important;
    }

    .gjs-field input:focus,
    .gjs-field textarea:focus,
    .gjs-field select:focus {
      outline: none !important;
      border-color: #2563eb !important;
      box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1) !important;
    }

    /* Mensaje cuando no hay selección */
    .layers-container:empty::before,
    .traits-container:empty::before {
      content: 'Selecciona un componente para ver sus propiedades';
      display: block;
      padding: 16px;
      text-align: center;
      color: #9ca3af;
      font-size: 13px;
    }

    .layers-container:not(:empty)::before,
    .traits-container:not(:empty)::before {
      content: none;
    }

    /* ===== Estilos para Traits Personalizados ===== */
    .custom-trait {
      background: #ffffff !important;
      border: 1px solid #e5e7eb !important;
      border-radius: 6px !important;
      margin-bottom: 12px !important;
      padding: 12px !important;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;
    }

    .custom-trait .gjs-trt-label {
      color: #374151 !important;
      font-size: 13px !important;
      font-weight: 600 !important;
      margin-bottom: 6px !important;
      display: block !important;
    }

    .custom-trait .gjs-trt-field {
      width: 100% !important;
    }

    .custom-trait .gjs-trt-input,
    .custom-trait .gjs-trt-textarea,
    .custom-trait .gjs-trt-select {
      width: 100% !important;
      padding: 8px 10px !important;
      border: 1px solid #d1d5db !important;
      border-radius: 6px !important;
      font-size: 14px !important;
      background: #ffffff !important;
      transition: all 0.2s ease !important;
    }

    .custom-trait .gjs-trt-input:focus,
    .custom-trait .gjs-trt-textarea:focus,
    .custom-trait .gjs-trt-select:focus {
      outline: none !important;
      border-color: #3b82f6 !important;
      box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1) !important;
    }

    .custom-trait .gjs-trt-checkbox {
      margin-right: 8px !important;
      transform: scale(1.1) !important;
    }

    .custom-trait .gjs-trt-button {
      width: 100% !important;
      padding: 10px 16px !important;
      background: linear-gradient(135deg, #3b82f6, #2563eb) !important;
      color: white !important;
      border: none !important;
      border-radius: 6px !important;
      cursor: pointer !important;
      font-size: 14px !important;
      font-weight: 500 !important;
      transition: all 0.2s ease !important;
    }

    .custom-trait .gjs-trt-button:hover {
      background: linear-gradient(135deg, #2563eb, #1d4ed8) !important;
      transform: translateY(-1px) !important;
      box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3) !important;
    }

    .custom-trait .gjs-trt-button:active {
      transform: translateY(0) !important;
    }

    /* Bloques con colores de categoría */
    .gjs-block-section {
      background: #e3f2fd;
      border: 2px dashed #2196f3;
    }

    .gjs-block-text {
      background: #f3e5f5;
      border: 2px dashed #9c27b0;
    }

    .gjs-block-image {
      background: #e8f5e8;
      border: 2px dashed #4caf50;
    }

    .gjs-block-button {
      background: #fff3e0;
      border: 2px dashed #ff9800;
    }

    .gjs-block-video {
      background: #fce4ec;
      border: 2px dashed #e91e63;
    }

    .gjs-block-form {
      background: #e0f2f1;
      border: 2px dashed #009688;
    }

    .gjs-block-pricing {
      background: #fff8e1;
      border: 2px dashed #ffc107;
    }

    .gjs-block-testimonial {
      background: #e8eaf6;
      border: 2px dashed #3f51b5;
    }

    .gjs-block-social {
      background: #f1f8e9;
      border: 2px dashed #8bc34a;
    }

    .gjs-block-map {
      background: #e3f2fd;
      border: 2px dashed #2196f3;
    }

    .gjs-block-gallery {
      background: #fce4ec;
      border: 2px dashed #e91e63;
    }

    .gjs-block-products {
      background: #e8f5e8;
      border: 2px dashed #4caf50;
    }

    /* Los estilos para bloquear iframes se inyectan via JavaScript en el canvas */

    .gjs-block {
      width: auto;
      height: auto;
      min-height: auto;
      padding: 8px;
      margin: 4px;
    }

    .gjs-block-label {
      font-size: 11px;
      color: #374151;
      padding-top: 5px;
    }

    /* Mejorar la apariencia de los bloques */
    .gjs-blocks-cs {
      display: flex;
      flex-wrap: wrap;
      gap: 2px;
    }

    .gjs-block {
      flex: 0 0 auto;
      min-width: 80px;
      text-align: center;
    }

    /* Ocultar campo de búsqueda y elementos adicionales al final del panel de bloques */
    .gjs-blocks-c input[type="text"],
    .gjs-blocks-c input[type="search"],
    .gjs-blocks-c .gjs-sm-field,
    .gjs-blocks-c .gjs-sm-input-holder,
    .gjs-block-category:last-child input,
    .gjs-block-category:last-child .gjs-field,
    #gjs-blocks input,
    #gjs-blocks .gjs-field,
    #gjs-blocks .gjs-sm-field-holder {
      display: none !important;
    }

    /* Ocultar scrollbar visible al final de las categorías */
    .gjs-blocks-c::-webkit-scrollbar {
      display: none !important;
    }

    .gjs-blocks-c {
      scrollbar-width: none !important;
      -ms-overflow-style: none !important;
    }

    /* Estilos para el header y sidebar */
    .tab-button.active {
      color: #2563eb;
      border-bottom-color: #2563eb;
    }

    .panel-content {
      height: calc(100vh - 200px);
      overflow-y: auto;
    }


    /* Estilos para listas */
    .list-circle {
      list-style-type: circle;
    }

    .list-square {
      list-style-type: square;
    }

    .list-decimal-leading-zero {
      list-style-type: decimal-leading-zero;
    }

    .list-lower-roman {
      list-style-type: lower-roman;
    }

    .list-upper-roman {
      list-style-type: upper-roman;
    }

    .list-lower-alpha {
      list-style-type: lower-alpha;
    }

    .list-upper-alpha {
      list-style-type: upper-alpha;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .gjs-blocks-cs {
        justify-content: center;
      }

      .gjs-block {
        min-width: 70px;
        font-size: 10px;
      }
    }
  </style>
</head>

<body>
  <div class="flex flex-col min-h-screen">
    <!-- Header -->
    <header class="flex-shrink-0 bg-white border-b shadow-sm">
      <div class="px-4 py-3">
        <div class="flex items-center justify-between">
          <div class="flex items-center space-x-4">
            <a href="{{ route('creator.pages.index') }}" class="text-gray-600 hover:text-gray-900">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
              </svg>
            </a>
            <div>
              <h1 class="text-lg font-medium text-gray-900">{{ $editable->name ?? $editable->title }}</h1>
              <p class="text-sm text-gray-500">{{ $website->name }} - {{ $editable->type ?? 'Página' }}</p>
            </div>
          </div>
          <div class="flex items-center space-x-3">
            <!-- Botones de vista de dispositivos -->
            <div class="flex items-center p-1 bg-white border border-gray-200 rounded-lg">
              <button id="desktop-view" class="p-2 text-blue-600 transition-colors rounded-md bg-blue-50 hover:bg-blue-100" title="Vista Desktop">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
              </button>
              <button id="tablet-view" class="p-2 text-gray-500 transition-colors rounded-md hover:text-blue-600 hover:bg-blue-50" title="Vista Tablet">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
              </button>
              <button id="mobile-view" class="p-2 text-gray-500 transition-colors rounded-md hover:text-blue-600 hover:bg-blue-50" title="Vista Móvil">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
              </button>
            </div>

            <!-- Botones de acciones -->
            <button id="fullscreen-btn" class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50" title="Pantalla Completa">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
              </svg>
            </button>
            <button id="code-view-btn" class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50" title="Ver Código">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
              </svg>
            </button>

            <button id="ai-generate-btn" class="flex items-center gap-2 px-3 py-2 text-sm text-white bg-purple-600 rounded-md hover:bg-purple-700" title="Generar contenido con IA">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
              </svg>
              Generar con IA
            </button>

            <button id="config-btn" class="flex items-center gap-2 px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50" title="Configuración de la Página">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
              </svg>
              Configuración
            </button>

            <button id="save-btn" class="px-4 py-2 text-sm text-white bg-blue-600 rounded-md hover:bg-blue-700">
              Guardar
            </button>
            @if($editableType === 'page')
            {{-- Botón Vista Previa - Lleva a la vista pública del sitio web --}}
            @php
            // Si es la página de inicio, llevar a la raíz del sitio
            if ($editable->is_home ?? false) {
            $previewUrl = route('website.show', [$website->slug]);
            } else {
            $previewUrl = route('website.page.show', [$website->slug, $editable->slug]);
            }
            @endphp
            <a href="{{ $previewUrl }}" target="_blank" class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white transition-colors bg-green-600 rounded-md hover:bg-green-700" title="Ver esta página en el sitio web público">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
              </svg>
              Vista Previa
            </a>

            {{-- Botón Ver Sitio Completo --}}
            <a href="{{ route('website.show', [$website->slug]) }}" target="_blank" class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-md hover:bg-gray-50" title="Ver el sitio web completo">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
              </svg>
              Ver Sitio
            </a>
            @endif
          </div>
        </div>
      </div>
    </header>

    <!-- Editor -->
    <div class="flex flex-1">
      <!-- Sidebar con paneles -->
      <div class="flex flex-col border-r border-gray-200 w-80 bg-gray-50">
        <!-- Panel Tabs -->
        <div class="border-b border-gray-200">
          <nav class="flex items-center gap-4 px-3 overflow-x-auto whitespace-nowrap" aria-label="Tabs">
            <button class="px-1 py-3 text-sm font-medium text-center text-blue-600 border-b-2 border-blue-500 tab-button active" data-panel="blocks">
              Bloques
            </button>
            <button class="px-1 py-3 text-sm font-medium text-center text-gray-500 border-b-2 border-transparent tab-button hover:text-gray-700" data-panel="layers">
              Capas
            </button>
            <button class="px-1 py-3 text-sm font-medium text-center text-gray-500 border-b-2 border-transparent tab-button hover:text-gray-700" data-panel="traits">
              Propiedades
            </button>
          </nav>
        </div>

        <!-- Panel Content -->
        <div class="flex-1 overflow-auto">
          <div id="blocks-panel" class="p-4 panel-content">
            <div id="gjs-blocks" class="gjs-blocks-container"></div>
          </div>
          <div id="layers-panel" class="hidden p-4 panel-content">
            <div class="layers-container"></div>
          </div>
          <div id="traits-panel" class="hidden panel-content">
            <!-- Pestañas estilo Elementor: Contenido | Estilo | Avanzado -->
            <div id="widget-tabs" class="border-b border-gray-200">
              <nav class="flex items-center" aria-label="Widget Tabs">
                <button class="flex-1 px-4 py-3 text-sm font-medium text-center text-blue-600 border-b-2 border-blue-500 widget-tab-button active" data-widget-tab="content">
                  Contenido
                </button>
                <button class="flex-1 px-4 py-3 text-sm font-medium text-center text-gray-500 border-b-2 border-transparent widget-tab-button hover:text-gray-700" data-widget-tab="style">
                  Estilo
                </button>
                <button class="flex-1 px-4 py-3 text-sm font-medium text-center text-gray-500 border-b-2 border-transparent widget-tab-button hover:text-gray-700" data-widget-tab="advanced">
                  Avanzado
                </button>
              </nav>
            </div>

            <!-- Contenido de pestañas -->
            <div class="p-4 overflow-auto">
              <!-- Pestaña Contenido -->
              <div id="widget-content-tab" class="widget-tab-content">
                <div class="traits-container"></div>
                <div id="no-widget-selected" class="flex items-center justify-center py-12 text-center">
                  <div>
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path>
                    </svg>
                    <p class="text-sm font-medium text-gray-900">Selecciona un elemento</p>
                    <p class="mt-1 text-xs text-gray-500">Haz clic en cualquier elemento del canvas para editarlo</p>
                  </div>
                </div>
              </div>

              <!-- Pestaña Estilo -->
              <div id="widget-style-tab" class="hidden widget-tab-content">
                <div class="styles-container-widget"></div>
              </div>

              <!-- Contenedor oculto para el StyleManager original (necesario para la inicialización) -->
              <div class="styles-container" style="display: none;"></div>

              <!-- Pestaña Avanzado -->
              <div id="widget-advanced-tab" class="hidden widget-tab-content">
                <div class="space-y-4">
                  <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Clases CSS</label>
                    <input type="text" id="widget-classes" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="mi-clase personalizada">
                    <p class="mt-1 text-xs text-gray-500">Agrega clases CSS personalizadas separadas por espacios</p>
                  </div>
                  <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">ID del Elemento</label>
                    <input type="text" id="widget-id" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="mi-id">
                  </div>
                  <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">CSS Personalizado</label>
                    <textarea id="widget-custom-css" rows="6" class="w-full px-3 py-2 font-mono text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="/* Tu CSS aquí */"></textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Main Editor Canvas -->
      <div class="flex flex-col flex-1">
        <!-- Indicador de carga -->
        <div id="loading-indicator" class="fixed inset-0 z-50 flex items-center justify-center bg-white">
          <div class="text-center">
            <div class="w-12 h-12 mx-auto mb-4 border-b-2 border-blue-600 rounded-full animate-spin"></div>
            <p class="text-gray-600">Cargando editor...</p>
          </div>
        </div>

        <div id="gjs" style="height: 100%; display: none;"></div>
      </div>
    </div>

    <!-- Modal de Generación con IA -->
    <div id="ai-modal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black bg-opacity-50">
      <div class="flex items-center justify-center min-h-screen px-4 py-8">
        <div class="relative w-full max-w-4xl bg-white rounded-lg shadow-xl">
          <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
            <h2 class="flex items-center gap-2 text-xl font-semibold text-gray-900">
              <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
              </svg>
              Actualizar Contenido con IA
            </h2>
            <button id="close-ai-modal" class="text-gray-400 hover:text-gray-600">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </button>
          </div>
          <div class="px-6 py-4 max-h-[70vh] overflow-y-auto">
            <p class="mb-4 text-sm text-gray-600">
              Describe cómo quieres actualizar el contenido de esta página. La IA mejorará el contenido existente considerando la plantilla y estilos de tu sitio.
            </p>

            <!-- Contenido Actual -->
            <div class="mb-4">
              <label class="block mb-2 text-sm font-medium text-gray-700">Contenido Actual de la Página</label>
              <div class="p-3 overflow-y-auto border border-gray-200 rounded-md bg-gray-50 max-h-40">
                <pre id="ai-current-content" class="font-mono text-xs text-gray-600 whitespace-pre-wrap"></pre>
              </div>
              <p class="mt-1 text-xs text-gray-500">Este es el contenido HTML actual que se actualizará</p>
            </div>

            <!-- Prompt para actualizar -->
            <div>
              <label class="block mb-2 text-sm font-medium text-gray-700">Instrucciones para Actualizar</label>
              <textarea id="ai-prompt-input" rows="6" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500" placeholder="Ejemplo: Mejora el título de la sección hero para que sea más llamativo, agrega más detalles a los servicios y actualiza los testimonios con información más específica."></textarea>
              <p class="mt-2 text-xs text-gray-500">
                Describe cómo quieres mejorar o actualizar el contenido. El contenido completo de la página será reemplazado con la versión actualizada.
              </p>
            </div>
          </div>
          <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-gray-200 bg-gray-50">
            <button id="ai-modal-cancel" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
              Cancelar
            </button>
            <button id="ai-generate-submit" class="px-4 py-2 text-sm font-medium text-white bg-purple-600 rounded-md hover:bg-purple-700">
              <span id="ai-generate-text">Actualizar con IA</span>
              <span id="ai-generate-loading" class="hidden">
                <svg class="inline-block w-4 h-4 mr-2 animate-spin" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Actualizando...
              </span>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal de Configuración -->
    <div id="config-modal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black bg-opacity-50">
      <div class="flex items-center justify-center min-h-screen px-4 py-8">
        <div class="relative w-full max-w-2xl bg-white rounded-lg shadow-xl">
          <!-- Header del Modal -->
          <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Configuración de la Página</h2>
            <button id="close-config-modal" class="text-gray-400 hover:text-gray-600">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </button>
          </div>

          <!-- Contenido del Modal -->
          <div class="px-6 py-4 overflow-y-auto max-h-[70vh]">
            <!-- Configuración General -->
            <div class="mb-6">
              <h4 class="mb-3 text-sm font-medium text-gray-700">General</h4>
              <div class="space-y-3">
                <div>
                  <label class="block mb-1 text-sm text-gray-600">Título de la página</label>
                  <input type="text" id="page-title" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Mi página" value="{{ $editable->title ?? '' }}">
                </div>
                <div>
                  <label class="block mb-1 text-sm text-gray-600">URL (Slug)</label>
                  <input type="text" id="page-slug" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="mi-pagina" value="{{ $editable->slug ?? '' }}">
                  <p class="mt-1 text-xs text-gray-500">La URL será: {{ url('/') }}/{{ $website->slug ?? 'sitio' }}/<span id="slug-preview">{{ $editable->slug ?? 'mi-pagina' }}</span></p>
                </div>
                <div>
                  <label class="block mb-1 text-sm text-gray-600">Descripción</label>
                  <textarea id="page-description" rows="3" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Descripción de la página"></textarea>
                </div>
              </div>
            </div>

            <!-- Configuración de Estado -->
            <div class="mb-6">
              <h4 class="mb-3 text-sm font-medium text-gray-700">Estado de la Página</h4>
              <div class="space-y-3">
                <div class="flex items-center">
                  <input type="checkbox" id="is-published" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2" {{ ($editable->is_published ?? false) ? 'checked' : '' }}>
                  <label for="is-published" class="ml-2 text-sm text-gray-600">Página publicada</label>
                </div>
                <div class="flex items-center">
                  <input type="checkbox" id="is-home" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2" {{ ($editable->is_home ?? false) ? 'checked' : '' }}>
                  <label for="is-home" class="ml-2 text-sm text-gray-600">Página de inicio</label>
                  <p class="ml-2 text-xs text-gray-500">(Esta será la página principal del sitio)</p>
                </div>
                <div class="flex items-center">
                  <input type="checkbox" id="enable-store" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                  <label for="enable-store" class="ml-2 text-sm text-gray-600">Habilitar tienda virtual</label>
                </div>
              </div>
            </div>

            <!-- Configuración SEO -->
            <div class="mb-6">
              <h4 class="mb-3 text-sm font-medium text-gray-700">SEO</h4>
              <div class="space-y-3">
                <div>
                  <label class="block mb-1 text-sm text-gray-600">Meta título</label>
                  <input type="text" id="meta-title" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Título para SEO">
                </div>
                <div>
                  <label class="block mb-1 text-sm text-gray-600">Meta descripción</label>
                  <textarea id="meta-description" rows="2" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Descripción para SEO"></textarea>
                </div>
                <div>
                  <label class="block mb-1 text-sm text-gray-600">Palabras clave</label>
                  <input type="text" id="meta-keywords" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="palabra1, palabra2, palabra3">
                </div>
              </div>
            </div>

            <!-- Configuración de Estilos -->
            <div class="mb-6">
              <h4 class="mb-3 text-sm font-medium text-gray-700">Estilos Globales</h4>
              <div class="space-y-3">
                <div>
                  <label class="block mb-1 text-sm text-gray-600">Ancho del Contenido</label>
                  <div class="flex items-center gap-3">
                    <input type="range" id="content-width" min="600" max="1600" value="1140" step="10" class="flex-1 h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                    <input type="number" id="content-width-value" min="600" max="1600" value="1140" class="w-20 px-2 py-1 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <span class="text-sm text-gray-500">px</span>
                  </div>
                  <p class="mt-1 text-xs text-gray-500">Define el ancho máximo del contenido de la página</p>
                </div>
                <div>
                  <label class="block mb-1 text-sm text-gray-600">Espacio entre Widgets</label>
                  <div class="flex items-center gap-3">
                    <input type="range" id="widget-space" min="0" max="100" value="20" step="5" class="flex-1 h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                    <input type="number" id="widget-space-value" min="0" max="100" value="20" class="w-20 px-2 py-1 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <span class="text-sm text-gray-500">px</span>
                  </div>
                  <p class="mt-1 text-xs text-gray-500">Espacio vertical entre elementos</p>
                </div>
                <div>
                  <label class="block mb-1 text-sm text-gray-600">Color principal</label>
                  <input type="color" id="primary-color" class="w-full h-10 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" value="#2563eb">
                </div>
                <div>
                  <label class="block mb-1 text-sm text-gray-600">Fuente principal</label>
                  <select id="primary-font" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="Inter">Inter</option>
                    <option value="Roboto">Roboto</option>
                    <option value="Open Sans">Open Sans</option>
                    <option value="Lato">Lato</option>
                    <option value="Poppins">Poppins</option>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <!-- Footer del Modal -->
          <div class="flex justify-end gap-3 px-6 py-4 border-t border-gray-200 bg-gray-50">
            <button id="reset-config" class="px-4 py-2 text-sm text-gray-600 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
              Restablecer
            </button>
            <button id="apply-config" class="px-4 py-2 text-sm text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
              Aplicar Configuración
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Campos ocultos para contenido existente -->
  @if($editable->html_content)
  <input type="hidden" id="page-html-content" value="{{ htmlspecialchars($editable->html_content, ENT_QUOTES) }}">
  @endif
  @if($editable->css_content)
  <input type="hidden" id="page-css-content" value="{{ htmlspecialchars($editable->css_content, ENT_QUOTES) }}">
  @endif

  <script>
    // Suprimir advertencias de source maps
    if (typeof console !== 'undefined' && console.warn) {
      const originalWarn = console.warn;
      console.warn = function(...args) {
        if (args[0] && typeof args[0] === 'string' && args[0].includes('source map')) {
          return; // Suprimir advertencias de source maps
        }
        originalWarn.apply(console, args);
      };
    }
  </script>

  <script src="https://unpkg.com/grapesjs@0.21.7/dist/grapes.min.js"></script>
  {{-- Módulos del editor (cargar antes del archivo principal) --}}
  <script src="{{ asset('js/editor-modules/config.js') }}"></script>
  <script src="{{ asset('js/editor-modules/commands.js') }}"></script>
  <script src="{{ asset('js/editor-modules/component-loader.js') }}"></script>
  <script src="{{ asset('js/editor-modules/image-sync.js') }}"></script>
  <script src="{{ asset('js/editor-modules/utils.js') }}"></script>

  {{-- Componentes modulares --}}
  <script src="{{ asset('js/editor-modules/components/image.js') }}"></script>
  <script src="{{ asset('js/editor-modules/components/container.js') }}"></script>
  <script src="{{ asset('js/editor-modules/components/heading.js') }}"></script>
  <script src="{{ asset('js/editor-modules/components/paragraph.js') }}"></script>
  <script src="{{ asset('js/editor-modules/components/list-unordered.js') }}"></script>
  <script src="{{ asset('js/editor-modules/components/list-ordered.js') }}"></script>
  <script src="{{ asset('js/editor-modules/components/button.js') }}"></script>
  <script src="{{ asset('js/editor-modules/components/text.js') }}"></script>
  <script src="{{ asset('js/editor-modules/components/link.js') }}"></script>
  <script src="{{ asset('js/editor-modules/components/divider.js') }}"></script>
  <script src="{{ asset('js/editor-modules/components/separator.js') }}"></script>
  <script src="{{ asset('js/editor-modules/components/table.js') }}"></script>
  <script src="{{ asset('js/editor-modules/components/html-code.js') }}"></script>
  <script src="{{ asset('js/editor-modules/components/spacer.js') }}"></script>
  <script src="{{ asset('js/editor-modules/components/alert.js') }}"></script>
  <script src="{{ asset('js/editor-modules/components/icon.js') }}"></script>
  <script src="{{ asset('js/editor-modules/components/icon-box.js') }}"></script>
  <script src="{{ asset('js/editor-modules/components/icon-list.js') }}"></script>
  <script src="{{ asset('js/editor-modules/components/star-rating.js') }}"></script>
  <script src="{{ asset('js/editor-modules/components/quote.js') }}"></script>
  <script src="{{ asset('js/editor-modules/components/code.js') }}"></script>
  <script src="{{ asset('js/editor-modules/components/preformatted.js') }}"></script>
  <script src="{{ asset('js/editor-modules/components/verse.js') }}"></script>
  <script src="{{ asset('js/editor-modules/components/counter-animated.js') }}"></script>
  <script src="{{ asset('js/editor-modules/components/toggle.js') }}"></script>
  <script src="{{ asset('js/editor-modules/components/tabs.js') }}"></script>
  <script src="{{ asset('js/editor-modules/components/accordion.js') }}"></script>
  <script src="{{ asset('js/editor-modules/components/carousel.js') }}"></script>
  <script src="{{ asset('js/editor-modules/components/gallery.js') }}"></script>
  <script src="{{ asset('js/editor-modules/components/video.js') }}"></script>
  <script src="{{ asset('js/editor-modules/components/google-maps.js') }}"></script>
  <script src="{{ asset('js/editor-modules/components/image-box-advanced.js') }}"></script>
  <script src="{{ asset('js/editor-modules/components/background-image.js') }}"></script>
  <script src="{{ asset('js/editor-modules/components/file.js') }}"></script>
  <script src="{{ asset('js/editor-modules/components/audio.js') }}"></script>
  <script src="{{ asset('js/editor-modules/components/section-inner.js') }}"></script>
  <script src="{{ asset('js/editor-modules/components/column.js') }}"></script>
  <script src="{{ asset('js/editor-modules/carousel-utils.js') }}"></script>

  <script src="{{ asset('js/editor-config.js') }}"></script>
  <script>
    // Configurar variables globales para el editor
    window.saveUrl = '{{ $saveRoute }}';
    window.csrfToken = '{{ csrf_token() }}';
    window.editableType = '{{ $editableType }}'; // 'page' o 'component'
    // Configurar bloques del editor
    window.editorBlocks = [
      @include('creator.blocks.all')
    ];
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Verificar que GrapesJS esté disponible
      if (typeof grapesjs === 'undefined') {
        console.error('GrapesJS no se ha cargado correctamente');
        alert('Error: El editor no se pudo cargar. Por favor, recarga la página.');
        return;
      }

      // Inicializar el editor (con pequeño retraso para asegurar que todo esté cargado)
      if (typeof initializeEditor === 'function') {
        initializeEditor();
      } else {
        console.error('initializeEditor no está definida. Esperando...');
        setTimeout(function() {
          if (typeof initializeEditor === 'function') {
            initializeEditor();
          } else {
            console.error('initializeEditor sigue sin estar definida después del timeout');
          }
        }, 100);
      }


      // Funcionalidad de las pestañas del sidebar
      document.querySelectorAll('.tab-button').forEach(tab => {
        tab.addEventListener('click', function() {
          const panelId = this.getAttribute('data-panel');

          // Remover clase active de todas las pestañas y paneles
          document.querySelectorAll('.tab-button').forEach(t => {
            t.classList.remove('active', 'text-blue-600', 'border-blue-500');
            t.classList.add('text-gray-500', 'border-transparent');
          });
          document.querySelectorAll('.panel-content').forEach(p => p.classList.add('hidden'));

          // Agregar clase active a la pestaña y panel seleccionados
          this.classList.add('active', 'text-blue-600', 'border-blue-500');
          this.classList.remove('text-gray-500', 'border-transparent');
          document.getElementById(panelId + '-panel').classList.remove('hidden');

          // Forzar actualización de los managers cuando se cambia de pestaña
          setTimeout(() => {
            if (window.updateManagers) {
              window.updateManagers();
            }
          }, 100);
        });
      });

      // Funcionalidad de las pestañas de widgets (Contenido | Estilo | Avanzado)
      document.querySelectorAll('.widget-tab-button').forEach(tab => {
        tab.addEventListener('click', function() {
          const tabId = this.getAttribute('data-widget-tab');

          // Remover clase active de todas las pestañas de widgets
          document.querySelectorAll('.widget-tab-button').forEach(t => {
            t.classList.remove('active', 'text-blue-600', 'border-blue-500');
            t.classList.add('text-gray-500', 'border-transparent');
          });
          document.querySelectorAll('.widget-tab-content').forEach(p => p.classList.add('hidden'));

          // Agregar clase active a la pestaña seleccionada
          this.classList.add('active', 'text-blue-600', 'border-blue-500');
          this.classList.remove('text-gray-500', 'border-transparent');
          document.getElementById('widget-' + tabId + '-tab').classList.remove('hidden');
        });
      });

      // Funcionalidad del modal de configuración
      // Modal de Generación con IA
      const aiGenerateBtn = document.getElementById('ai-generate-btn');
      const aiModal = document.getElementById('ai-modal');
      const closeAiModal = document.getElementById('close-ai-modal');
      const aiModalCancel = document.getElementById('ai-modal-cancel');
      const aiPromptInput = document.getElementById('ai-prompt-input');
      const aiGenerateSubmit = document.getElementById('ai-generate-submit');
      const aiGenerateText = document.getElementById('ai-generate-text');
      const aiGenerateLoading = document.getElementById('ai-generate-loading');

      // Abrir modal de IA
      if (aiGenerateBtn) {
        aiGenerateBtn.addEventListener('click', function() {
          // Obtener el contenido actual del editor
          let currentContent = '';
          if (window.editor) {
            currentContent = window.editor.getHtml();
            // Limpiar el contenido para mostrar (quitar espacios excesivos)
            const cleanContent = currentContent.replace(/>\s+</g, '><').trim();
            // Mostrar una versión truncada si es muy largo
            const displayContent = cleanContent.length > 500 ?
              cleanContent.substring(0, 500) + '...\n\n[Contenido truncado - se enviará completo]' :
              cleanContent;

            document.getElementById('ai-current-content').textContent = displayContent || 'Página vacía - se generará contenido nuevo';
          } else {
            document.getElementById('ai-current-content').textContent = 'Editor no inicializado';
          }

          aiModal.classList.remove('hidden');
          aiPromptInput.focus();
        });
      }

      // Cerrar modal de IA
      function closeAiModalFunc() {
        aiModal.classList.add('hidden');
        aiPromptInput.value = '';
      }

      if (closeAiModal) {
        closeAiModal.addEventListener('click', closeAiModalFunc);
      }

      if (aiModalCancel) {
        aiModalCancel.addEventListener('click', closeAiModalFunc);
      }

      // Cerrar al hacer clic fuera del modal
      if (aiModal) {
        aiModal.addEventListener('click', function(e) {
          if (e.target === aiModal) {
            closeAiModalFunc();
          }
        });
      }

      // Generar contenido con IA
      if (aiGenerateSubmit) {
        aiGenerateSubmit.addEventListener('click', function() {
          const prompt = aiPromptInput.value.trim();

          if (!prompt || prompt.length < 10) {
            alert('Por favor describe cómo quieres actualizar el contenido (mínimo 10 caracteres)');
            return;
          }

          // Obtener el contenido actual del editor
          let currentContent = '';
          if (window.editor) {
            currentContent = window.editor.getHtml();
          }

          // Mostrar loading
          aiGenerateText.classList.add('hidden');
          aiGenerateLoading.classList.remove('hidden');
          aiGenerateSubmit.disabled = true;

          // Enviar petición a OpenAI con el contenido actual
          fetch('{{ route("creator.pages.generate-ai-content") }}', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
              },
              body: JSON.stringify({
                prompt: prompt,
                current_content: currentContent,
                page_id: {{ $editable->id ?? 'null' }},
                website_id: {{ $website->id }}
              })
            })
            .then(response => response.json())
            .then(data => {
              if (data.success && data.html_content) {
                // Reemplazar TODO el contenido en GrapesJS
                if (window.editor) {
                  try {
                    // Método 1: Intentar usar setComponents si existe
                    if (typeof window.editor.setComponents === 'function') {
                      window.editor.setComponents(data.html_content);
                    }
                    // Método 2: Limpiar y agregar nuevo contenido
                    else if (typeof window.editor.getWrapper === 'function') {
                      const wrapper = window.editor.getWrapper();
                      if (wrapper && wrapper.components) {
                        wrapper.components().reset();
                        window.editor.addComponents(data.html_content);
                      } else {
                        // Método 3: Usar el método directo de reset
                        window.editor.set('components', data.html_content);
                      }
                    }
                    // Método 4: Usar el método directo
                    else {
                      window.editor.set('components', data.html_content);
                    }

                    closeAiModalFunc();
                    alert('Contenido actualizado exitosamente con IA');
                  } catch (error) {
                    console.error('Error al actualizar contenido:', error);
                    alert('Error al actualizar el contenido en el editor. Por favor intenta guardar manualmente.');
                  }
                } else {
                  alert('Error: El editor no está listo. Por favor recarga la página.');
                }
              } else {
                alert('Error: ' + (data.message || 'No se pudo actualizar el contenido'));
              }
            })
            .catch(error => {
              console.error('Error:', error);
              alert('Error al actualizar el contenido. Por favor intenta nuevamente.');
            })
            .finally(() => {
              // Restaurar botón
              aiGenerateText.classList.remove('hidden');
              aiGenerateLoading.classList.add('hidden');
              aiGenerateSubmit.disabled = false;
            });
        });
      }

      const configBtn = document.getElementById('config-btn');
      const configModal = document.getElementById('config-modal');
      const closeConfigModal = document.getElementById('close-config-modal');

      if (configBtn) {
        configBtn.addEventListener('click', function() {
          configModal.classList.remove('hidden');
        });
      }

      if (closeConfigModal) {
        closeConfigModal.addEventListener('click', function() {
          configModal.classList.add('hidden');
        });
      }

      // Cerrar modal al hacer clic fuera de él
      if (configModal) {
        configModal.addEventListener('click', function(e) {
          if (e.target === configModal) {
            configModal.classList.add('hidden');
          }
        });
      }

      // Funcionalidad del panel de configuración
      const applyConfigBtn = document.getElementById('apply-config');
      const resetConfigBtn = document.getElementById('reset-config');

      // Actualizar preview del slug
      const slugInput = document.getElementById('page-slug');
      const slugPreview = document.getElementById('slug-preview');
      if (slugInput && slugPreview) {
        slugInput.addEventListener('input', function() {
          slugPreview.textContent = this.value || 'mi-pagina';
        });
      }

      // Sincronizar sliders de ancho de contenido y espacio entre widgets
      const contentWidthSlider = document.getElementById('content-width');
      const contentWidthValue = document.getElementById('content-width-value');
      const widgetSpaceSlider = document.getElementById('widget-space');
      const widgetSpaceValue = document.getElementById('widget-space-value');

      if (contentWidthSlider && contentWidthValue) {
        contentWidthSlider.addEventListener('input', function() {
          contentWidthValue.value = this.value;
        });
        contentWidthValue.addEventListener('input', function() {
          contentWidthSlider.value = this.value;
        });
      }

      if (widgetSpaceSlider && widgetSpaceValue) {
        widgetSpaceSlider.addEventListener('input', function() {
          widgetSpaceValue.value = this.value;
        });
        widgetSpaceValue.addEventListener('input', function() {
          widgetSpaceSlider.value = this.value;
        });
      }

      if (applyConfigBtn) {
        applyConfigBtn.addEventListener('click', function() {
          const config = {
            pageTitle: document.getElementById('page-title').value,
            pageSlug: document.getElementById('page-slug').value,
            pageDescription: document.getElementById('page-description').value,
            isPublished: document.getElementById('is-published').checked,
            isHome: document.getElementById('is-home').checked,
            enableStore: document.getElementById('enable-store').checked,
            metaTitle: document.getElementById('meta-title').value,
            metaDescription: document.getElementById('meta-description').value,
            metaKeywords: document.getElementById('meta-keywords').value,
            contentWidth: document.getElementById('content-width-value').value,
            widgetSpace: document.getElementById('widget-space-value').value,
            primaryColor: document.getElementById('primary-color').value,
            primaryFont: document.getElementById('primary-font').value
          };

          // Guardar configuración de la página
          savePageConfig(config);

          // Aplicar configuración al editor
          if (window.editor) {
            // Aplicar estilos globales
            const css = `
              :root {
                --primary-color: ${config.primaryColor};
                --primary-font: '${config.primaryFont}', sans-serif;
                --content-width: ${config.contentWidth}px;
                --widget-space: ${config.widgetSpace}px;
              }
              body {
                font-family: var(--primary-font);
              }
              .container, .container-simple {
                max-width: var(--content-width);
                margin-left: auto;
                margin-right: auto;
              }
              .section-container, .gjs-block {
                margin-bottom: var(--widget-space);
              }
            `;

            // Agregar estilos al editor
            window.editor.setStyle(css);

            // Guardar configuración en localStorage
            localStorage.setItem('website-config', JSON.stringify(config));


            // Mostrar mensaje de éxito
            this.textContent = '✓ Aplicado';
            this.classList.remove('bg-blue-600', 'hover:bg-blue-700');
            this.classList.add('bg-green-600');

            // Cerrar el modal después de aplicar
            setTimeout(() => {
              configModal.classList.add('hidden');
              this.textContent = 'Aplicar Configuración';
              this.classList.remove('bg-green-600');
              this.classList.add('bg-blue-600', 'hover:bg-blue-700');
            }, 1000);
          }
        });
      }

      if (resetConfigBtn) {
        resetConfigBtn.addEventListener('click', function() {
          // Restablecer valores por defecto
          document.getElementById('page-title').value = '{{ $editable->title ?? "" }}';
          document.getElementById('page-slug').value = '{{ $editable->slug ?? "" }}';
          document.getElementById('page-description').value = '';
          document.getElementById('enable-store').checked = false;
          document.getElementById('meta-title').value = '';
          document.getElementById('meta-description').value = '';
          document.getElementById('meta-keywords').value = '';
          document.getElementById('content-width').value = '1140';
          document.getElementById('content-width-value').value = '1140';
          document.getElementById('widget-space').value = '20';
          document.getElementById('widget-space-value').value = '20';
          document.getElementById('primary-color').value = '#2563eb';
          document.getElementById('primary-font').value = 'Inter';

          // Actualizar preview del slug
          if (slugPreview) {
            slugPreview.textContent = '{{ $editable->slug ?? "mi-pagina" }}';
          }

          // Mostrar mensaje
          this.textContent = '✓ Restablecido';
          this.classList.remove('bg-gray-100', 'hover:bg-gray-200');
          this.classList.add('bg-green-100', 'text-green-700');

          setTimeout(() => {
            this.textContent = 'Restablecer';
            this.classList.remove('bg-green-100', 'text-green-700');
            this.classList.add('bg-gray-100', 'hover:bg-gray-200');
          }, 2000);
        });
      }

      // Función para guardar configuración de la página
      function savePageConfig(config) {
        const requestData = {
          title: config.pageTitle,
          slug: config.pageSlug,
          is_published: config.isPublished,
          is_home: config.isHome,
          _token: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || window.csrfToken
        };

        fetch('{{ route("creator.pages.update", [$website, $editable]) }}', {
            method: 'PUT',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || window.csrfToken
            },
            body: JSON.stringify(requestData)
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              console.log('✅ Configuración de página guardada');
            } else {
              console.error('❌ Error al guardar configuración:', data.message);
            }
          })
          .catch(error => {
            console.error('❌ Error al guardar configuración:', error);
          });
      }

      // Funcionalidad de botones de dispositivos y vista previa
      const desktopBtn = document.getElementById('desktop-view');
      const tabletBtn = document.getElementById('tablet-view');
      const mobileBtn = document.getElementById('mobile-view');
      const fullscreenBtn = document.getElementById('fullscreen-btn');
      const codeViewBtn = document.getElementById('code-view-btn');

      // Configuraciones de dispositivos para GrapesJS
      const deviceConfigs = {
        desktop: {
          width: '100%',
          height: '100%',
          name: 'Desktop'
        },
        tablet: {
          width: '768px',
          height: '1024px',
          name: 'Tablet'
        },
        mobile: {
          width: '375px',
          height: '667px',
          name: 'Mobile'
        }
      };

      // Función para cambiar vista de dispositivo
      function switchDevice(device) {
        if (window.editor) {
          // Mapear nombres de dispositivos
          const deviceMap = {
            'desktop': 'Desktop',
            'tablet': 'Tablet',
            'mobile': 'Mobile'
          };

          const deviceName = deviceMap[device];

          // Cambiar dispositivo en GrapesJS usando el comando correcto
          window.editor.runCommand('set-device-' + device);

          // Actualizar botones activos
          [desktopBtn, tabletBtn, mobileBtn].forEach(btn => {
            if (btn) {
              btn.classList.remove('text-blue-600', 'bg-blue-50');
              btn.classList.add('text-gray-500');
            }
          });

          // Activar botón seleccionado
          const activeBtn = document.getElementById(device + '-view');
          if (activeBtn) {
            activeBtn.classList.remove('text-gray-500');
            activeBtn.classList.add('text-blue-600', 'bg-blue-50');
          }

          // Actualizar el TraitManager para mostrar propiedades relevantes al dispositivo
          setTimeout(() => {
            const selectedComponent = window.editor.getSelected();
            if (selectedComponent && window.editor.TraitManager) {
              // Re-renderizar el TraitManager para actualizar las propiedades visibles
              window.editor.TraitManager.render();

              // Si hay una función personalizada de actualización, llamarla
              if (typeof window.forceTraitManagerUpdate === 'function') {
                window.forceTraitManagerUpdate(selectedComponent);
              }
            }
          }, 100);
        }
      }

      // Event listeners para los botones de dispositivos
      if (desktopBtn) {
        desktopBtn.addEventListener('click', () => {
          switchDevice('desktop');
        });
      }
      if (tabletBtn) {
        tabletBtn.addEventListener('click', () => {
          switchDevice('tablet');
        });
      }
      if (mobileBtn) {
        mobileBtn.addEventListener('click', () => {
          switchDevice('mobile');
        });
      }

      // Función para pantalla completa
      if (fullscreenBtn) {
        fullscreenBtn.addEventListener('click', function() {
          if (!document.fullscreenElement) {
            // Entrar en pantalla completa
            document.documentElement.requestFullscreen().then(() => {
              this.innerHTML = `
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 9V4.5M9 9H4.5M9 9L3.5 3.5M15 9v-4.5M15 9h4.5M15 9l5.5-5.5M9 15v4.5M9 15H4.5M9 15l-5.5 5.5M15 15v4.5M15 15h4.5m0 0l-5.5 5.5"></path>
                </svg>
              `;
              this.title = 'Salir de Pantalla Completa';
            });
          } else {
            // Salir de pantalla completa
            document.exitFullscreen().then(() => {
              this.innerHTML = `
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                </svg>
              `;
              this.title = 'Pantalla Completa';
            });
          }
        });
      }

      // Función para ver código
      if (codeViewBtn) {
        codeViewBtn.addEventListener('click', function() {
          if (window.editor) {
            // Obtener HTML y CSS del editor
            const html = window.editor.getHtml();
            const css = window.editor.getCss();

            // Función para escapar HTML y mostrarlo como texto plano
            function escapeHtml(text) {
              const div = document.createElement('div');
              div.textContent = text;
              return div.innerHTML;
            }

            // Función para formatear HTML con indentación
            function formatHtml(html) {
              let formatted = html;
              let indent = 0;
              const tab = '  '; // 2 espacios

              // Agregar saltos de línea después de etiquetas de cierre
              formatted = formatted.replace(/></g, '>\n<');

              // Dividir en líneas y formatear
              const lines = formatted.split('\n');
              const formattedLines = lines.map(line => {
                line = line.trim();
                if (!line) return '';

                // Reducir indentación para etiquetas de cierre
                if (line.startsWith('</')) {
                  indent = Math.max(0, indent - 1);
                }

                // Aplicar indentación
                const indentedLine = tab.repeat(indent) + line;

                // Aumentar indentación para etiquetas de apertura (que no sean self-closing)
                if (line.startsWith('<') && !line.startsWith('</') && !line.endsWith('/>') && !line.includes('</')) {
                  indent++;
                }

                return indentedLine;
              });

              return formattedLines.join('\n');
            }

            // Función para formatear CSS con indentación
            function formatCss(css) {
              let formatted = css;

              // Agregar saltos de línea después de llaves de apertura
              formatted = formatted.replace(/\{/g, ' {\n');

              // Agregar saltos de línea después de punto y coma
              formatted = formatted.replace(/;/g, ';\n');

              // Agregar saltos de línea después de llaves de cierre
              formatted = formatted.replace(/\}/g, '\n}\n');

              // Dividir en líneas y formatear
              const lines = formatted.split('\n');
              let indent = 0;
              const tab = '  '; // 2 espacios

              const formattedLines = lines.map(line => {
                line = line.trim();
                if (!line) return '';

                // Reducir indentación para llaves de cierre
                if (line === '}') {
                  indent = Math.max(0, indent - 1);
                }

                // Aplicar indentación
                const indentedLine = tab.repeat(indent) + line;

                // Aumentar indentación después de llaves de apertura
                if (line.endsWith('{')) {
                  indent++;
                }

                return indentedLine;
              });

              return formattedLines.join('\n');
            }


            // Crear ventana modal para mostrar el código
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
            modal.innerHTML = `
              <div class="bg-white rounded-lg shadow-xl max-w-7xl w-full mx-4 max-h-[90vh] flex flex-col">
                <div class="flex items-center justify-between p-4 border-b bg-gray-50">
                  <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900">Código de la Página</h3>
                  </div>
                  <button class="text-gray-400 transition-colors hover:text-gray-600" onclick="this.closest('.fixed').remove()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                  </button>
                </div>
                
                <!-- Editor de código en dos columnas -->
                <div class="flex flex-1 overflow-hidden">
                  <!-- Columna HTML -->
                  <div class="flex flex-col w-1/2 border-r border-gray-200">
                    <div class="flex items-center justify-between px-4 py-2 border-b border-orange-200 bg-orange-50">
                      <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-orange-500 rounded-full"></div>
                        <span class="text-sm font-medium text-orange-800">HTML</span>
                      </div>
                      <button class="text-xs text-orange-600 hover:text-orange-800" onclick="copyHtml()">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                      </button>
                    </div>
                    <div class="flex-1 overflow-auto bg-gray-900">
                      <pre class="p-4 font-mono text-sm leading-relaxed text-gray-100"><code id="html-code">${escapeHtml(formatHtml(html))}</code></pre>
                    </div>
                  </div>
                  
                  <!-- Columna CSS -->
                  <div class="flex flex-col w-1/2">
                    <div class="flex items-center justify-between px-4 py-2 border-b border-blue-200 bg-blue-50">
                      <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                        <span class="text-sm font-medium text-blue-800">CSS</span>
                      </div>
                      <button class="text-xs text-blue-600 hover:text-blue-800" onclick="copyCss()">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                      </button>
                    </div>
                    <div class="flex-1 overflow-auto bg-gray-900">
                      <pre class="p-4 font-mono text-sm leading-relaxed text-gray-100"><code id="css-code">${escapeHtml(formatCss(css))}</code></pre>
                    </div>
                  </div>
                </div>
                
                <!-- Barra de herramientas inferior -->
                <div class="flex items-center justify-between p-4 border-t bg-gray-50">
                  <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600">HTML: ${html.length} caracteres</span>
                    <span class="text-sm text-gray-600">CSS: ${css.length} caracteres</span>
                  </div>
                  <div class="flex space-x-2">
                    <button class="px-4 py-2 text-sm text-gray-700 transition-colors bg-white border border-gray-300 rounded hover:bg-gray-50" onclick="this.closest('.fixed').remove()">
                      Cerrar
                    </button>
                    <button class="px-4 py-2 text-sm text-white transition-colors bg-blue-600 rounded hover:bg-blue-700" onclick="copyCode()">
                      <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                      </svg>
                      Copiar Todo
                    </button>
                  </div>
                </div>
              </div>
            `;

            // Funciones para copiar código
            window.copyCode = function() {
              const fullCode = `<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página</title>
    <style>
${formatCss(css)}
    </style>
</head>
<body>
${formatHtml(html)}
</body>
</html>`;

              navigator.clipboard.writeText(fullCode).then(() => {
                showNotification('Código completo copiado al portapapeles', 'success');
              }).catch(() => {
                showNotification('Error al copiar el código', 'error');
              });
            };

            window.copyHtml = function() {
              navigator.clipboard.writeText(formatHtml(html)).then(() => {
                showNotification('HTML copiado al portapapeles', 'success');
              }).catch(() => {
                showNotification('Error al copiar el HTML', 'error');
              });
            };

            window.copyCss = function() {
              navigator.clipboard.writeText(formatCss(css)).then(() => {
                showNotification('CSS copiado al portapapeles', 'success');
              }).catch(() => {
                showNotification('Error al copiar el CSS', 'error');
              });
            };

            // Función para mostrar notificaciones
            function showNotification(message, type = 'success') {
              const notification = document.createElement('div');
              const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
              notification.className = `fixed top-4 right-4 ${bgColor} text-white px-4 py-2 rounded-lg shadow-lg z-50 transition-all duration-300`;
              notification.textContent = message;

              document.body.appendChild(notification);

              setTimeout(() => {
                notification.style.opacity = '0';
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => {
                  document.body.removeChild(notification);
                }, 300);
              }, 2000);
            }

            document.body.appendChild(modal);
          }
        });
      }

      // Inicializar con vista desktop
      setTimeout(() => {
        if (window.editor) {
          // Configurar listener para cambios de dispositivo
          window.editor.on('change:device', () => {
            const currentDevice = window.editor.getDevice();

            // Actualizar botones según el dispositivo actual
            [desktopBtn, tabletBtn, mobileBtn].forEach(btn => {
              if (btn) {
                btn.classList.remove('text-blue-600', 'bg-blue-50');
                btn.classList.add('text-gray-500');
              }
            });

            // Activar el botón correspondiente
            let activeBtn = null;
            if (currentDevice === 'Desktop') {
              activeBtn = desktopBtn;
            } else if (currentDevice === 'Tablet') {
              activeBtn = tabletBtn;
            } else if (currentDevice === 'Mobile') {
              activeBtn = mobileBtn;
            }

            if (activeBtn) {
              activeBtn.classList.remove('text-gray-500');
              activeBtn.classList.add('text-blue-600', 'bg-blue-50');
            }

            // Actualizar el TraitManager cuando cambia el dispositivo
            setTimeout(() => {
              const selectedComponent = window.editor.getSelected();
              if (selectedComponent && window.editor.TraitManager) {
                // Re-renderizar el TraitManager para actualizar las propiedades visibles
                window.editor.TraitManager.render();

                // Si hay una función personalizada de actualización, llamarla
                if (typeof window.forceTraitManagerUpdate === 'function') {
                  window.forceTraitManagerUpdate(selectedComponent);
                }
              }
            }, 100);
          });

          // Inicializar con vista desktop
          switchDevice('desktop');
        }
      }, 1000);

    });
  </script>

  <!-- Configuración de credenciales API para productos -->
  <script>
    // Configurar las credenciales API del sitio web
    window.websiteApiKey = "{{ $website->api_key }}";
    window.websiteApiUrl = "{{ $website->api_base_url }}";
    window.websiteId = {{$website->id}};
  </script>

  <!-- Componente para cargar productos dinámicamente -->
  <x-products-script :apiKey="$website->api_key" :apiBaseUrl="$website->api_base_url" />

  <!-- Componente para cargar posts del blog dinámicamente -->
  @include('components.blog-script', ['websiteId' => $website->id])

</body>

</html>