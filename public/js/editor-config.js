// Configuración del Editor GrapeJS
// Este archivo contiene toda la configuración y funcionalidades del editor

// Configuración principal de GrapeJS
const editorConfig = {
  container: '#gjs',
  height: '100%',
  width: '100%',
  storageManager: false,
  undoManager: true,
  assetManager: {
    upload: false,
    uploadText: 'Arrastra archivos aquí o haz clic para subir',
    addBtnText: 'Agregar imagen',
    uploadUrl: '/upload',
    upload: function (files) {
      // Aquí se implementaría la subida de archivos
      console.log('Subir archivos:', files);
    }
  },
  layerManager: {
    appendTo: '.layers-container'
  },
  traitManager: {
    appendTo: '.traits-container'
  },
  styleManager: {
    appendTo: '.styles-container',
    sectors: [
      {
        name: 'General',
        open: false,
        buildProps: ['float', 'display', 'position', 'top', 'right', 'left', 'bottom']
      },
      {
        name: 'Dimension',
        open: false,
        buildProps: ['width', 'height', 'max-width', 'min-height', 'margin', 'padding']
      },
      {
        name: 'Typography',
        open: false,
        buildProps: ['font-family', 'font-size', 'font-weight', 'letter-spacing', 'color', 'line-height']
      },
      {
        name: 'Decorations',
        open: false,
        buildProps: ['opacity', 'background-color', 'border-radius', 'border', 'box-shadow', 'background']
      },
      {
        name: 'Extra',
        open: false,
        buildProps: ['transition', 'perspective', 'transform']
      }
    ]
  },
  blockManager: {
    appendTo: '#gjs-blocks',
    blocks: window.editorBlocks || []
  },
  panels: {
    defaults: [
      {
        id: 'basic-actions',
        el: '.panel__basic-actions',
        buttons: [
          {
            id: 'visibility',
            active: true,
            className: 'btn-toggle-borders',
            label: '<i class="fa fa-clone"></i>',
            command: 'sw-visibility',
          },
          {
            id: 'export',
            className: 'btn-open-export',
            label: '<i class="fa fa-code"></i>',
            command: 'export-template',
            context: 'export-template',
          },
          {
            id: 'show-json',
            className: 'btn-show-json',
            label: '<i class="fa fa-file-code-o"></i>',
            context: 'show-json',
            command(editor) {
              editor.Modal.setTitle('Components JSON')
                .setContent(`<textarea style="width:100%; height: 250px;">
                  ${JSON.stringify(editor.getComponents(), null, 2)}
                </textarea>`)
                .open();
            },
          }
        ],
      },
      {
        id: 'panel-devices',
        el: '.panel__devices',
        buttons: [
          {
            id: 'device-desktop',
            label: '<i class="fa fa-television"></i>',
            command: 'set-device-desktop',
            active: true,
            togglable: false,
          },
          {
            id: 'device-tablet',
            label: '<i class="fa fa-tablet"></i>',
            command: 'set-device-tablet',
            togglable: false,
          },
          {
            id: 'device-mobile',
            label: '<i class="fa fa-mobile"></i>',
            command: 'set-device-mobile',
            togglable: false,
          }
        ],
      }
    ],
  },
  deviceManager: {
    devices: [
      {
        name: 'Desktop',
        width: '',
      },
      {
        name: 'Tablet',
        width: '768px',
        widthMedia: '992px',
      },
      {
        name: 'Mobile',
        width: '320px',
        widthMedia: '768px',
      }
    ]
  },
  canvas: {
    styles: [
      'https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css'
    ]
  },
  plugins: [],
  pluginsOpts: {}
};

// Comandos personalizados del editor
const editorCommands = {
  'set-device-desktop': {
    run: editor => editor.setDevice('Desktop')
  },
  'set-device-tablet': {
    run: editor => editor.setDevice('Tablet')
  },
  'set-device-mobile': {
    run: editor => editor.setDevice('Mobile')
  },
  'sw-visibility': {
    run: editor => {
      // Toggle visibility de bordes y offsets
      const canvas = editor.Canvas;
      const canvasEl = canvas.getElement();
      const toggleClass = 'gjs-hide-offsets';

      if (canvasEl.classList.contains(toggleClass)) {
        canvasEl.classList.remove(toggleClass);
      } else {
        canvasEl.classList.add(toggleClass);
      }
    }
  },
  'export-template': {
    run: editor => {
      const htmlContent = editor.getHtml();
      const cssContent = editor.getCss();

      // Crear y descargar archivo
      const blob = new Blob([`<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Template Exportado</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>${cssContent}</style>
</head>
<body>
${htmlContent}
</body>
</html>`], { type: 'text/html' });

      const url = URL.createObjectURL(blob);
      const a = document.createElement('a');
      a.href = url;
      a.download = 'template.html';
      document.body.appendChild(a);
      a.click();
      document.body.removeChild(a);
      URL.revokeObjectURL(url);
    }
  }
};

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
  window.updateQuantity = function (index, change) {
    cart[index].quantity += change;
    if (cart[index].quantity <= 0) {
      cart.splice(index, 1);
    }
    updateCart();
  };

  // Función para remover del carrito
  window.removeFromCart = function (index) {
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
  window.addToCart = function (product) {
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

// Función para mostrar placeholder de productos en el editor
function showProductsPlaceholder() {
  console.log('🎯 Mostrando placeholder de productos en el editor...');

  // Buscar contenedores de productos de múltiples formas
  let productsContainers = document.querySelectorAll('#products-container');

  // Si no se encuentra por ID, buscar por clase
  if (productsContainers.length === 0) {
    productsContainers = document.querySelectorAll('.products-list .grid');
  }

  // Si aún no se encuentra, buscar cualquier elemento con clase grid que contenga productos
  if (productsContainers.length === 0) {
    const allGrids = document.querySelectorAll('.grid');
    productsContainers = Array.from(allGrids).filter(grid =>
      grid.textContent.includes('Producto de Ejemplo') ||
      grid.querySelector('.bg-white.border.border-gray-200')
    );
  }

  console.log(`🔍 Encontrados ${productsContainers.length} contenedores de productos`);

  if (productsContainers.length === 0) {
    console.log('❌ No se encontraron contenedores de productos en el editor');
    return;
  }

  productsContainers.forEach((container, index) => {
    console.log(`🔄 Procesando contenedor ${index + 1}`);

    // Mostrar productos de ejemplo estáticos
    container.innerHTML = `
      <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
        <div class="flex items-center justify-center w-full h-48 mb-4 bg-gray-200 rounded-lg">
          <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
          </svg>
        </div>
        <h3 class="mb-2 text-lg font-semibold text-gray-900">Producto de Ejemplo 1</h3>
        <p class="mb-4 text-sm text-gray-600">Los productos reales se mostrarán en la vista previa</p>
        <div class="flex items-center justify-between">
          <span class="text-lg font-bold text-green-600">$99.99</span>
          <button class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700" onclick="addToCart({id: 1, name: 'Producto de Ejemplo 1', price: 99.99, image: 'https://via.placeholder.com/60x60'})">
            Agregar al Carrito
          </button>
        </div>
      </div>
      <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
        <div class="flex items-center justify-center w-full h-48 mb-4 bg-gray-200 rounded-lg">
          <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
          </svg>
        </div>
        <h3 class="mb-2 text-lg font-semibold text-gray-900">Producto de Ejemplo 2</h3>
        <p class="mb-4 text-sm text-gray-600">Los productos reales se mostrarán en la vista previa</p>
        <div class="flex items-center justify-between">
          <span class="text-lg font-bold text-green-600">$149.99</span>
          <button class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700" onclick="addToCart({id: 2, name: 'Producto de Ejemplo 2', price: 149.99, image: 'https://via.placeholder.com/60x60'})">
            Agregar al Carrito
          </button>
        </div>
      </div>
      <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
        <div class="flex items-center justify-center w-full h-48 mb-4 bg-gray-200 rounded-lg">
          <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
          </svg>
        </div>
        <h3 class="mb-2 text-lg font-semibold text-gray-900">Producto de Ejemplo 3</h3>
        <p class="mb-4 text-sm text-gray-600">Los productos reales se mostrarán en la vista previa</p>
        <div class="flex items-center justify-between">
          <span class="text-lg font-bold text-green-600">$199.99</span>
          <button class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700" onclick="addToCart({id: 3, name: 'Producto de Ejemplo 3', price: 199.99, image: 'https://via.placeholder.com/60x60'})">
            Agregar al Carrito
          </button>
        </div>
      </div>
    `;
  });

  console.log('✅ Placeholder de productos mostrado en el editor');
}

// Función para manejar clics en sectores del StyleManager
function handleSectorClick(e) {
  const sectorTitle = e.target.closest('.gjs-sm-title');
  if (sectorTitle) {
    const sector = sectorTitle.closest('.gjs-sm-sector');
    if (sector) {
      // Toggle del estado del sector
      if (sector.classList.contains('gjs-sm-open')) {
        sector.classList.remove('gjs-sm-open');
      } else {
        sector.classList.add('gjs-sm-open');
      }
      console.log('🔄 Sector toggled:', sectorTitle.textContent);
    }
  }
}

// Función para inicializar managers manualmente
function initializeManagers() {
  if (!window.editor) {
    console.warn('⚠️ Editor no disponible');
    return;
  }

  const editor = window.editor;
  console.log('🔧 Inicializando managers del editor...');
  console.log('Editor object:', editor);
  console.log('Editor managers:', {
    StyleManager: editor.StyleManager,
    TraitManager: editor.TraitManager,
    LayerManager: editor.LayerManager
  });

  // Verificar que los managers estén disponibles y intentar renderizar
  if (editor.StyleManager) {
    console.log('✅ StyleManager disponible');
    try {
      editor.StyleManager.render();
      console.log('✅ StyleManager renderizado');

      // Agregar event listeners después del renderizado
      setTimeout(() => {
        const styleContainer = document.querySelector('.styles-container');
        if (styleContainer) {
          // Remover listeners anteriores si existen
          styleContainer.removeEventListener('click', handleSectorClick);
          // Agregar nuevo listener
          styleContainer.addEventListener('click', handleSectorClick);
          console.log('✅ Event listeners del StyleManager actualizados');
        }
      }, 100);
    } catch (error) {
      console.error('❌ Error renderizando StyleManager:', error);
    }
  } else {
    console.warn('⚠️ StyleManager no disponible');
  }


  if (editor.TraitManager) {
    console.log('✅ TraitManager disponible');
    try {
      editor.TraitManager.render();
      console.log('✅ TraitManager renderizado');
    } catch (error) {
      console.error('❌ Error renderizando TraitManager:', error);
    }
  } else {
    console.warn('⚠️ TraitManager no disponible');
  }

  if (editor.LayerManager) {
    console.log('✅ LayerManager disponible');
    try {
      editor.LayerManager.render();
      console.log('✅ LayerManager renderizado');
    } catch (error) {
      console.error('❌ Error renderizando LayerManager:', error);
    }
  } else {
    console.warn('⚠️ LayerManager no disponible');
  }

  // Intentar seleccionar un componente para activar los managers
  // (Comentado para evitar deselección automática de componentes seleccionados)
  // const components = editor.getComponents();
  // if (components && components.length > 0) {
  //   console.log('🎯 Seleccionando primer componente para activar managers...');
  //   const firstComponent = components.at(0);
  //   if (firstComponent) {
  //     editor.select(firstComponent);
  //     console.log('✅ Componente seleccionado:', firstComponent.get('type'));
  //   }
  // }
}

// Inicialización del editor
function initializeEditor() {
  console.log('🚀 Inicializando editor GrapeJS...');
  // Configurar bloques directamente desde los archivos Blade
  editorConfig.blockManager.blocks = window.editorBlocks || [];

  // Inicializar el editor
  const editor = grapesjs.init(editorConfig);

  // Hacer el editor disponible globalmente
  window.editor = editor;

  // Ocultar indicador de carga y mostrar editor
  const loadingIndicator = document.getElementById('loading-indicator');
  const editorContainer = document.getElementById('gjs');

  if (loadingIndicator) {
    loadingIndicator.style.display = 'none';
  }
  if (editorContainer) {
    editorContainer.style.display = 'block';
  }

  // Agregar comandos personalizados
  Object.keys(editorCommands).forEach(command => {
    editor.Commands.add(command, editorCommands[command]);
  });

  // Configurar eventos del editor
  editor.on('component:add', function (component) {
    console.log('➕ Componente agregado:', component.get('type'));

    // Si es un bloque de productos, mostrar placeholder
    if (component.get('type') === 'products-list' ||
      component.get('attributes').class === 'gjs-block-products') {
      console.log('🛍️ Bloque de productos detectado, mostrando placeholder...');
      setTimeout(showProductsPlaceholder, 100);
    }

  // Si es un bloque de carrito, inicializar carrito
  if (component.get('type') === 'cart-button' ||
    component.get('attributes').class === 'gjs-block-cart') {
    console.log('🛒 Bloque de carrito detectado, inicializando carrito...');
    setTimeout(initCart, 500);
  }
  
  // Inicializar carrito para vista previa
  if (component.getEl && component.getEl().querySelector('#cart-toggle')) {
    console.log('🛒 Elemento de carrito encontrado, inicializando...');
    setTimeout(initCart, 500);
  }
  });

  // Evento cuando se selecciona un componente
  editor.on('component:selected', function (component) {
    console.log('🎯 Componente seleccionado:', component.get('type'));

    // Forzar actualización del StyleManager cuando se selecciona un componente
    setTimeout(() => {
      if (editor.StyleManager) {
        editor.StyleManager.render();
        console.log('✅ StyleManager actualizado tras selección');
      }
    }, 100);
  });

  // Evento cuando se deselecciona un componente
  editor.on('component:deselected', function (component) {
    console.log('❌ Componente deseleccionado:', component.get('type'));
  });

  // Cargar contenido existente si existe
  const existingHtml = document.getElementById('page-html-content')?.value;
  const existingCss = document.getElementById('page-css-content')?.value;

  if (existingHtml && existingCss) {
    console.log('📄 Cargando contenido existente...');
    editor.setComponents(existingHtml);
    editor.setStyle(existingCss);
  }

  // Mostrar placeholder de productos si ya hay bloques de productos
  setTimeout(() => {
    showProductsPlaceholder();
  }, 1000);

  // Verificar que los contenedores existan
  const layersContainer = document.querySelector('.layers-container');
  const stylesContainer = document.querySelector('.styles-container');
  const traitsContainer = document.querySelector('.traits-container');

  console.log('🔍 Verificando contenedores:', {
    layersContainer: layersContainer,
    stylesContainer: stylesContainer,
    traitsContainer: traitsContainer
  });

  // Inicializar managers después de que el editor esté completamente cargado
  setTimeout(initializeManagers, 1500);

  // Agregar event listeners para los sectores del StyleManager
  setTimeout(() => {
    const styleContainer = document.querySelector('.styles-container');
    if (styleContainer) {
      // Delegar eventos de clic para los títulos de sectores
      styleContainer.addEventListener('click', function (e) {
        const sectorTitle = e.target.closest('.gjs-sm-title');
        if (sectorTitle) {
          const sector = sectorTitle.closest('.gjs-sm-sector');
          if (sector) {
            // Toggle del estado del sector
            if (sector.classList.contains('gjs-sm-open')) {
              sector.classList.remove('gjs-sm-open');
            } else {
              sector.classList.add('gjs-sm-open');
            }
            console.log('🔄 Sector toggled:', sectorTitle.textContent);
          }
        }
      });
      console.log('✅ Event listeners agregados para sectores del StyleManager');
    }
  }, 2000);

  // También intentar inicializar cuando se selecciona un componente
  // (Comentado para evitar deselección automática)
  // editor.on('component:selected', function (component) {
  //   console.log('🎯 Componente seleccionado, reinicializando managers...');
  //   setTimeout(initializeManagers, 100);
  // });

  // Función para forzar actualización de managers
  window.updateManagers = function () {
    if (window.editor) {
      const editor = window.editor;
      console.log('🔄 Forzando actualización de managers...');

      // Verificar si los contenedores tienen contenido
      const stylesContainer = document.querySelector('.styles-container');
      const traitsContainer = document.querySelector('.traits-container');
      const layersContainer = document.querySelector('.layers-container');

      console.log('🔍 Estado de contenedores:', {
        stylesContainer: stylesContainer ? stylesContainer.innerHTML.length : 'No encontrado',
        traitsContainer: traitsContainer ? traitsContainer.innerHTML.length : 'No encontrado',
        layersContainer: layersContainer ? layersContainer.innerHTML.length : 'No encontrado'
      });

      // Forzar renderizado de todos los managers
      if (editor.StyleManager) {
        editor.StyleManager.render();
        console.log('✅ StyleManager actualizado');
      }
      if (editor.TraitManager) {
        editor.TraitManager.render();
        console.log('✅ TraitManager actualizado');
      }
      if (editor.LayerManager) {
        editor.LayerManager.render();
        console.log('✅ LayerManager actualizado');
      }

      // Verificar nuevamente después del renderizado
      setTimeout(() => {
        console.log('🔍 Estado después del renderizado:', {
          stylesContainer: stylesContainer ? stylesContainer.innerHTML.length : 'No encontrado',
          traitsContainer: traitsContainer ? traitsContainer.innerHTML.length : 'No encontrado',
          layersContainer: layersContainer ? layersContainer.innerHTML.length : 'No encontrado'
        });
      }, 500);
    }
  };

  // Configurar botón de guardar
  document.getElementById('save-btn')?.addEventListener('click', function () {
    const htmlContent = editor.getHtml();
    const cssContent = editor.getCss();

    console.log('💾 Guardando contenido...');

    const requestData = {
      html_content: htmlContent,
      css_content: cssContent
    };

    // Agregar grapesjs_data si es un componente
    if (window.editableType === 'component') {
      requestData.grapesjs_data = JSON.stringify(editor.getProjectData());
    }

    fetch(window.saveUrl, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || window.csrfToken
      },
      body: JSON.stringify(requestData)
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
}

// Inicializar carrito cuando se carga la página
document.addEventListener('DOMContentLoaded', function () {
  setTimeout(initCart, 1000); // Esperar a que se cargue el editor
});

// Exportar funciones para uso global
window.initializeEditor = initializeEditor;
window.initCart = initCart;
window.showProductsPlaceholder = showProductsPlaceholder;
window.initializeManagers = initializeManagers;