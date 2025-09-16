<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Editor - {{ $page->title }} - {{ $website->name }}</title>
    @vite('resources/js/app.js')
    <link rel="stylesheet" href="https://unpkg.com/grapesjs/dist/css/grapes.min.css">
    <style>

      :root{
        --gjs-primary: #2563eb;          /* botones/acentos */
        --gjs-secondary: #111827;        /* texto principal */
        --gjs-tertiary: #6b7280;         /* texto suave */
        --gjs-quaternary: #e5e7eb;       /* bordes suaves */
        --gjs-bg: #ffffff;               /* fondo paneles */
        --gjs-font-size: 13px;
        }

        /* Fallback para versiones viejas (clases "one/two/three/four") */
        .gjs-one-bg{ background:#ffffff; }
        .gjs-two-color{ color:#111827; }
        .gjs-three-bg{ background:#f3f4f6; }   /* barras/paneles secundarios */
        .gjs-four-color{ color:#374151; }

        .gjs-cv-canvas {
            width: 100% !important;
        }

        /* Paneles y botones */
        .gjs-pn-panel,
        .gjs-pn-views,
        .gjs-pn-options,
        .gjs-pn-commands{ background:#ffffff; border-color:#e5e7eb; }
        .gjs-pn-btn{ color:#374151; }
        .gjs-pn-btn.gjs-pn-active,
        .gjs-pn-btn:hover{ background:#e5effe; color:#1d4ed8; }

        /* Contenedores de bloques/estilos/capas */
        .gjs-blocks-c,
        .gjs-layer-manager,
        .gjs-sm-sectors{ background:#f8fafc; color:#111827; }
        .gjs-block, .gjs-block-label{ color:#111827; }
        .gjs-field{ background:#ffffff; color:#111827; border-color:#e5e7eb; }

        /* Canvas alrededor del lienzo (fuera del iframe) */
        .gjs-editor-cont, .gjs-cv-canvas{ background:#f3f4f6; }

        /* Resaltados y selección (más visibles) */
        .gjs-selected{ outline:2px solid #2563eb !important; }
        .gjs-resizer-h{ border-color:#2563eb !important; }

        .gjs-pn-panel {
            background: #f8f9fa;
        }

        .gjs-block {
            width: auto;
            height: auto;
            min-height: auto;
            padding: 10px;
            margin: 5px;
        }

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

        .gjs-block-video {
            background: #fff3e0;
            border: 2px dashed #ff9800;
        }

        .gjs-block-form {
            background: #fce4ec;
            border: 2px dashed #e91e63;
        }

        .gjs-block-gallery {
            background: #f1f8e9;
            border: 2px dashed #8bc34a;
        }

        .gjs-block-testimonial {
            background: #e0f2f1;
            border: 2px dashed #009688;
        }

        .gjs-block-pricing {
            background: #fff8e1;
            border: 2px dashed #ffc107;
        }

        .gjs-block-contact {
            background: #e8eaf6;
            border: 2px dashed #3f51b5;
        }

        .gjs-block-newsletter {
            background: #f3e5f5;
            border: 2px dashed #9c27b0;
        }

        .gjs-block-map {
            background: #e0f7fa;
            border: 2px dashed #00bcd4;
        }

        .gjs-block-social {
            background: #f9fbe7;
            border: 2px dashed #827717;
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
                        <a href="{{ route('creator.websites.show', $website) }}" class="text-gray-600 hover:text-gray-900">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>
                        <div>
                            <h1 class="text-lg font-medium text-gray-900">{{ $page->title }}</h1>
                            <p class="text-sm text-gray-500">{{ $website->name }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                         <button id="save-btn" class="px-4 py-2 text-sm text-white bg-blue-600 rounded-md hover:bg-blue-700">
                            Guardar
                        </button>
                        <a href="{{ route('creator.preview.page', [$website, $page]) }}" target="_blank" class="px-4 py-2 text-sm text-white bg-gray-600 rounded-md hover:bg-gray-700">
                            Vista Previa
                        </a>
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
            <button class="px-1 py-3 text-sm font-medium text-center text-gray-500 border-b-2 border-transparent tab-button hover:text-gray-700" data-panel="styles">
                            Estilos
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
          <div id="styles-panel" class="hidden p-4 panel-content">
                        <div class="styles-container"></div>
                    </div>
          <div id="traits-panel" class="hidden p-4 panel-content">
                        <div class="traits-container"></div>
                    </div>
                </div>
            </div>

            <!-- Main Editor Canvas -->
      <div class="flex flex-col flex-1">
                <div id="gjs" style="height: 100%;"></div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/grapesjs"></script>
    <script src="{{ asset('js/editor-config.js') }}"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
      console.log('DOM cargado, iniciando GrapesJS...');

      // Verificar que GrapesJS esté disponible
      if (typeof grapesjs === 'undefined') {
        console.error('GrapesJS no se ha cargado correctamente');
        alert('Error: El editor no se pudo cargar. Por favor, recarga la página.');
        return;
      }

      console.log('GrapesJS disponible:', grapesjs);

      // Configurar variables globales para el editor
      window.saveUrl = '{{ route("creator.pages.save", [$website, $page]) }}';
      window.csrfToken = '{{ csrf_token() }}';
      
      // Inicializar el editor usando la configuración externa
      initializeEditor();
        container: '#gjs'
        , height: '100%'
        , width: '100%'
        , storageManager: false
        , plugins: []
        , pluginsOpts: {}
        , showOffsets: true
        , noticeOnUnload: true
        , colorPrimary: '#3B82F6'
        , colorSecondary: '#6B7280'
        , colorTertiary: '#10B981'
        , panels: { defaults: [] }
        , colorQuaternary: '#F59E0B'
        , canvas: {
                styles: [
                    'https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css'
                ]
        }
        , blockManager: {
          appendTo: '#gjs-blocks'
          , blocks: [
                    @include('creator.blocks.all')
                ]
        }
        , layerManager: {
                appendTo: '.layers-container'
        }
        , styleManager: {
          appendTo: '.styles-container'
          , sectors: [{
              name: 'General'
              , open: false
              , buildProps: ['float', 'display', 'position', 'top', 'right', 'left', 'bottom']
            , }
            , {
              name: 'Dimension'
              , open: false
              , buildProps: ['width', 'height', 'max-width', 'min-height', 'margin', 'padding']
            , }
            , {
              name: 'Typography'
              , open: false
              , buildProps: ['font-family', 'font-size', 'font-weight', 'letter-spacing', 'color', 'line-height']
            , }
            , {
              name: 'Decorations'
              , open: false
              , buildProps: ['opacity', 'background-color', 'border-radius', 'border', 'box-shadow', 'background']
            , }
            , {
              name: 'Extra'
              , open: false
              , buildProps: ['transition', 'perspective', 'transform']
            }
          ]
        }
        , traitManager: {
          appendTo: '.traits-container'
        }
      , }); 

      console.log('Editor GrapesJS inicializado:', editor);

      // Cargar contenido existente si existe
      @if($page->html_content)
        editor.setComponents('{!! addslashes($page->html_content) !!}');
      @endif

      @if($page->css_content)
        editor.setStyle('{!! addslashes($page->css_content) !!}');
      @endif

      // Configurar paneles personalizados
      const pn = editor.Panels;
      pn.addPanel({
            id: 'top-panel',
            buttons: [
                { id: 'preview',    command: 'preview',         label: '👁️',  attributes: { title: 'Vista previa' } },
                { id: 'fullscreen', command: 'fullscreen',      label: '⛶',   attributes: { title: 'Pantalla completa' } },
                { id: 'export',     command: 'export-template', label: '</', attributes: { title: 'Ver código fuente' } },
            ],
        });
        pn.addPanel({
            id: 'devices',
            buttons: [
                { id: 'device-desktop', label: 'Desktop', command: e => e.setDevice('Desktop'), active: true },
                { id: 'device-tablet',  label: 'Tablet',  command: e => e.setDevice('Tablet') },
                { id: 'device-mobile',  label: 'Mobile',  command: e => e.setDevice('Mobile portrait') },
            ],
        });

        editor.DeviceManager.add('Desktop', { width: '1024px' });
        editor.DeviceManager.add('Tablet', { width: '768px' });
        editor.DeviceManager.add('Mobile portrait', { width: '375px' });

      // Comandos personalizados
      editor.Commands.add('preview', {
        run: function(editor) {
          window.open('{{ route("creator.preview.page", [$website, $page]) }}', '_blank');
        }
      });

      editor.Commands.add('fullscreen', {
        run: function(editor) {
          editor.runCommand('core:canvas-clear');
        }
      });

      editor.Commands.add('export-template', {
        run: function(editor) {
          const html = editor.getHtml();
          const css = editor.getCss();
          const fullHtml = `<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Template Export</title>
  <style>${css}</style>
</head>
<body>${html}</body>
</html>`;
          
          const blob = new Blob([fullHtml], { type: 'text/html' });
          const url = URL.createObjectURL(blob);
          const a = document.createElement('a');
          a.href = url;
          a.download = 'template.html';
          a.click();
          URL.revokeObjectURL(url);
        }
      });

      // Función para mostrar placeholder de productos
      function showProductsPlaceholder() {
        console.log('🔄 Mostrando placeholder de productos...');
        
        // Buscar contenedores de productos
        const productsContainers = document.querySelectorAll('#products-container');
        console.log('📦 Contenedores encontrados:', productsContainers.length);
        
        if (productsContainers.length === 0) {
          console.log('❌ No se encontraron contenedores de productos');
          return;
        }
        
        productsContainers.forEach((container, index) => {
          console.log(`🔄 Procesando contenedor ${index + 1}`);
          
          // Mostrar productos de ejemplo
          container.innerHTML = `
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
              <div class="flex items-center justify-center w-full h-48 mb-4 bg-gray-200 rounded-lg">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
              </div>
              <h3 class="mb-2 text-lg font-semibold text-gray-900">Producto de Ejemplo</h3>
              <p class="mb-4 text-sm text-gray-600">Los productos reales se mostrarán en la vista previa</p>
              <div class="flex items-center justify-between">
                <span class="text-lg font-bold text-green-600">$99.99</span>
                <button class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                  Ver Producto
                </button>
              </div>
            </div>
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
              <div class="flex items-center justify-center w-full h-48 mb-4 bg-gray-200 rounded-lg">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
              </div>
              <h3 class="mb-2 text-lg font-semibold text-gray-900">Producto de Ejemplo</h3>
              <p class="mb-4 text-sm text-gray-600">Los productos reales se mostrarán en la vista previa</p>
              <div class="flex items-center justify-between">
                <span class="text-lg font-bold text-green-600">$149.99</span>
                <button class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                  Ver Producto
                </button>
              </div>
            </div>
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
              <div class="flex items-center justify-center w-full h-48 mb-4 bg-gray-200 rounded-lg">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
              </div>
              <h3 class="mb-2 text-lg font-semibold text-gray-900">Producto de Ejemplo</h3>
              <p class="mb-4 text-sm text-gray-600">Los productos reales se mostrarán en la vista previa</p>
              <div class="flex items-center justify-between">
                <span class="text-lg font-bold text-green-600">$199.99</span>
                <button class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                  Ver Producto
                </button>
              </div>
            </div>
          `;
        });
      }

      // Detectar cuando se agrega un componente
      editor.on('component:add', function(component) {
        console.log('➕ Componente agregado:', component.get('type'));
        console.log('📝 Contenido:', component.getInnerHTML().substring(0, 200));
        
        // Detectar bloque de productos por contenido o clases
        const content = component.getInnerHTML();
        const hasProductsContainer = content.includes('products-container');
        const hasProductsListClass = component.getClasses().includes('products-list');
        
        console.log('🔍 Tiene products-container:', hasProductsContainer);
        console.log('🔍 Tiene clase products-list:', hasProductsListClass);
        
        if (hasProductsContainer || hasProductsListClass) {
          console.log('✅ Bloque de productos detectado, mostrando placeholder...');
          setTimeout(() => {
            showProductsPlaceholder();
          }, 500);
        }
      });

      // Mostrar placeholder de productos al inicializar
      setTimeout(() => {
        console.log('🔄 Mostrando placeholder de productos al inicializar...');
        showProductsPlaceholder();
      }, 500);

      // Abrir panel de estilos automáticamente cuando se selecciona un elemento
      editor.on('component:selected', function(component) {
        // Abrir panel de estilos cuando se selecciona un elemento
        document.querySelector('[data-panel="styles"]').click();
      });

      // Método alternativo: usar eventos de teclado para cambiar paneles
      document.addEventListener('keydown', function(e) {
        // Ctrl + 1 = Bloques
        if (e.ctrlKey && e.key === '1') {
          e.preventDefault();
          document.querySelector('[data-panel="blocks"]').click();
        }
        // Ctrl + 2 = Capas
        if (e.ctrlKey && e.key === '2') {
          e.preventDefault();
          document.querySelector('[data-panel="layers"]').click();
        }
        // Ctrl + 3 = Estilos
        if (e.ctrlKey && e.key === '3') {
          e.preventDefault();
          document.querySelector('[data-panel="styles"]').click();
        }
        // Ctrl + 4 = Propiedades
        if (e.ctrlKey && e.key === '4') {
          e.preventDefault();
          document.querySelector('[data-panel="traits"]').click();
        }
      });

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
        });
      });

      // Funcionalidad del botón guardar
      document.getElementById('save-btn').addEventListener('click', function() {
        const htmlContent = editor.getHtml();
        const cssContent = editor.getCss();

        fetch('{{ route("creator.pages.save", [$website, $page]) }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}'
          },
          body: JSON.stringify({
            html_content: htmlContent,
            css_content: cssContent
          })
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Mostrar mensaje de éxito
            const btn = document.getElementById('save-btn');
            const originalText = btn.textContent;
            btn.textContent = '✓ Guardado';
            btn.classList.remove('bg-blue-600', 'hover:bg-blue-700');
            btn.classList.add('bg-green-600');
            
            setTimeout(() => {
              btn.textContent = originalText;
              btn.classList.remove('bg-green-600');
              btn.classList.add('bg-blue-600', 'hover:bg-blue-700');
            }, 2000);
          } else {
            alert('Error al guardar: ' + (data.message || 'Error desconocido'));
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Error al guardar la página');
        });
      });

      console.log('✅ Editor completamente inicializado');
    });

    // Funcionalidad del carrito de compras
    function initCart() {
      // Variables del carrito
      let cart = JSON.parse(localStorage.getItem('cart')) || [];
      
      // Función para obtener elementos del DOM (tanto en el editor como en el iframe)
      function getCartElements() {
        // Buscar en el documento principal
        let elements = {
          cartToggle: document.getElementById('cart-toggle'),
          cartClose: document.getElementById('cart-close'),
          cartOverlay: document.getElementById('cart-overlay'),
          cartSidebar: document.getElementById('cart-sidebar'),
          cartItems: document.getElementById('cart-items'),
          cartCount: document.getElementById('cart-count'),
          cartTotal: document.getElementById('cart-total'),
          checkoutBtn: document.getElementById('checkout-btn'),
          emptyCart: document.getElementById('empty-cart')
        };
        
        // Si no se encuentran en el documento principal, buscar en el iframe
        if (!elements.cartToggle) {
          const iframe = document.querySelector('.gjs-cv-canvas iframe');
          if (iframe && iframe.contentDocument) {
            const iframeDoc = iframe.contentDocument;
            elements = {
              cartToggle: iframeDoc.getElementById('cart-toggle'),
              cartClose: iframeDoc.getElementById('cart-close'),
              cartOverlay: iframeDoc.getElementById('cart-overlay'),
              cartSidebar: iframeDoc.getElementById('cart-sidebar'),
              cartItems: iframeDoc.getElementById('cart-items'),
              cartCount: iframeDoc.getElementById('cart-count'),
              cartTotal: iframeDoc.getElementById('cart-total'),
              checkoutBtn: iframeDoc.getElementById('checkout-btn'),
              emptyCart: iframeDoc.getElementById('empty-cart')
            };
          }
        }
        
        return elements;
      }
      
      // Obtener elementos del DOM
      const elements = getCartElements();

      // Función para actualizar el carrito
      function updateCart() {
        const currentElements = getCartElements();
        
        // Actualizar contador
        const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
        if (currentElements.cartCount) {
          currentElements.cartCount.textContent = totalItems;
        }
        
        // Actualizar total
        const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        if (currentElements.cartTotal) {
          currentElements.cartTotal.textContent = `$${total.toFixed(2)}`;
        }
        
        // Habilitar/deshabilitar botón de checkout
        if (currentElements.checkoutBtn) {
          currentElements.checkoutBtn.disabled = cart.length === 0;
        }
        
        // Mostrar/ocultar carrito vacío
        if (cart.length === 0) {
          if (currentElements.emptyCart) {
            currentElements.emptyCart.style.display = 'flex';
          }
          if (currentElements.cartItems) {
            currentElements.cartItems.innerHTML = '<div id="empty-cart" class="flex flex-col items-center justify-center h-full text-gray-500"><svg class="w-16 h-16 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m0 0h8M9 18a1 1 0 100 2 1 1 0 000-2zm8 0a1 1 0 100 2 1 1 0 000-2z"></path></svg><p class="text-lg font-medium">Tu carrito está vacío</p><p class="text-sm">Agrega algunos productos para comenzar</p></div>';
          }
        } else {
          if (currentElements.emptyCart) {
            currentElements.emptyCart.style.display = 'none';
          }
          renderCartItems();
        }
        
        // Guardar en localStorage
        localStorage.setItem('cart', JSON.stringify(cart));
      }

      // Función para renderizar los items del carrito
      function renderCartItems() {
        const currentElements = getCartElements();
        if (!currentElements.cartItems) return;
        
        const itemsHtml = cart.map((item, index) => `
          <div class="flex items-center p-4 mb-4 space-x-4 border border-gray-200 rounded-lg">
            <img src="${item.image || 'https://via.placeholder.com/60x60'}" alt="${item.name}" class="object-cover w-16 h-16 rounded-lg">
            <div class="flex-1">
              <h3 class="font-medium text-gray-900">${item.name}</h3>
              <p class="text-sm text-gray-600">$${item.price.toFixed(2)}</p>
              <div class="flex items-center mt-2 space-x-2">
                <button onclick="updateQuantity(${index}, -1)" class="flex items-center justify-center w-8 h-8 border border-gray-300 rounded-md hover:bg-gray-100">-</button>
                <span class="w-8 text-center">${item.quantity}</span>
                <button onclick="updateQuantity(${index}, 1)" class="flex items-center justify-center w-8 h-8 border border-gray-300 rounded-md hover:bg-gray-100">+</button>
              </div>
            </div>
            <button onclick="removeFromCart(${index})" class="p-2 text-red-500 hover:text-red-700">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
              </svg>
            </button>
          </div>
        `).join('');
        
        currentElements.cartItems.innerHTML = itemsHtml;
      }

      // Función para actualizar cantidad
      window.updateQuantity = function(index, change) {
        cart[index].quantity += change;
        if (cart[index].quantity <= 0) {
          cart.splice(index, 1);
        }
        updateCart();
      };

      // Función para remover del carrito
      window.removeFromCart = function(index) {
        cart.splice(index, 1);
        updateCart();
      };

      // Función para abrir carrito
      function openCart() {
        const currentElements = getCartElements();
        if (currentElements.cartSidebar) {
          currentElements.cartSidebar.classList.remove('translate-x-full');
        }
        if (currentElements.cartOverlay) {
          currentElements.cartOverlay.classList.remove('hidden');
        }
        document.body.style.overflow = 'hidden';
      }

      // Función para cerrar carrito
      function closeCart() {
        const currentElements = getCartElements();
        if (currentElements.cartSidebar) {
          currentElements.cartSidebar.classList.add('translate-x-full');
        }
        if (currentElements.cartOverlay) {
          currentElements.cartOverlay.classList.add('hidden');
        }
        document.body.style.overflow = 'auto';
      }

      // Event listeners
      function attachEventListeners() {
        const currentElements = getCartElements();
        if (currentElements.cartToggle) {
          currentElements.cartToggle.addEventListener('click', openCart);
        }
        if (currentElements.cartClose) {
          currentElements.cartClose.addEventListener('click', closeCart);
        }
        if (currentElements.cartOverlay) {
          currentElements.cartOverlay.addEventListener('click', closeCart);
        }
        if (currentElements.checkoutBtn) {
          currentElements.checkoutBtn.addEventListener('click', () => {
            alert('Funcionalidad de checkout en desarrollo');
          });
        }
      }
      
      // Adjuntar event listeners
      attachEventListeners();

      // Función para agregar al carrito (para usar desde otros bloques)
      window.addToCart = function(product) {
        const existingItem = cart.find(item => item.id === product.id);
        if (existingItem) {
          existingItem.quantity += 1;
        } else {
          cart.push({
            id: product.id || Date.now(),
            name: product.name || 'Producto',
            price: product.price || 0,
            image: product.image || 'https://via.placeholder.com/60x60',
            quantity: 1
          });
        }
        updateCart();
        openCart();
        // Re-adjuntar event listeners por si se agregó un nuevo elemento
        setTimeout(attachEventListeners, 100);
      };

      // Inicializar carrito
      updateCart();
    }

    // Inicializar carrito cuando se carga la página
    document.addEventListener('DOMContentLoaded', function() {
      setTimeout(initCart, 1000); // Esperar a que se cargue el editor
    });

    // También inicializar cuando se agrega un componente de carrito
    if (typeof editor !== 'undefined') {
      editor.on('component:add', function(component) {
        if (component.get('type') === 'cart-button' || component.get('attributes').class === 'gjs-block-cart') {
          setTimeout(initCart, 500);
        }
      });
    }
    </script>
</body>
</html>
