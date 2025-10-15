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
    addBtnText: 'Agregar imagen'
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
        buildProps: ['float', 'display', 'position', 'top', 'right', 'left', 'bottom', 'z-index']
      },
      {
        name: 'Dimension',
        open: false,
        buildProps: ['width', 'height', 'max-width', 'min-width', 'max-height', 'min-height', 'margin', 'padding']
      },
      {
        name: 'Typography',
        open: false,
        buildProps: ['font-family', 'font-size', 'font-weight', 'letter-spacing', 'color', 'line-height', 'text-align', 'text-decoration']
      },
      {
        name: 'Decorations',
        open: false,
        buildProps: ['opacity', 'background-color', 'border-radius', 'border', 'box-shadow', 'background', 'border-width', 'border-style', 'border-color']
      },
      {
        name: 'Flexbox',
        open: false,
        buildProps: ['flex-direction', 'flex-wrap', 'justify-content', 'align-items', 'align-content', 'flex-grow', 'flex-shrink']
      },
      {
        name: 'Grid',
        open: false,
        buildProps: ['grid-template-columns', 'grid-template-rows', 'grid-gap', 'grid-column', 'grid-row', 'justify-self', 'align-self']
      },
      {
        name: 'Extra',
        open: false,
        buildProps: ['transition', 'perspective', 'transform', 'filter', 'backdrop-filter']
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
  pluginsOpts: {},
  // Configuraciones adicionales
  allowScripts: 1,
  showOffsets: 1,
  showOffsetsSelected: 1,
  noticeOnUnload: 0,
  height: '100%',
  width: '100%',
  // Configuración de comandos
  commands: [
    {
      id: 'copy',
      run: 'core:copy',
      keys: 'ctrl+c'
    },
    {
      id: 'paste',
      run: 'core:paste',
      keys: 'ctrl+v'
    },
    {
      id: 'undo',
      run: 'core:undo',
      keys: 'ctrl+z'
    },
    {
      id: 'redo',
      run: 'core:redo',
      keys: 'ctrl+y'
    },
    {
      id: 'select-all',
      run: 'core:select-all',
      keys: 'ctrl+a'
    }
  ]
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


// Función para mostrar placeholder de productos en el editor
function showProductsPlaceholder() {

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

  if (productsContainers.length === 0) {
    return;
  }

  productsContainers.forEach((container, index) => {

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
        <h3 class="mb-2 text-lg font-semibold text-gray-900">Producto de Ejemplo 2</h3>
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
        <h3 class="mb-2 text-lg font-semibold text-gray-900">Producto de Ejemplo 3</h3>
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
    }
  }
}


// Función para inicializar managers manualmente
function initializeManagers() {
  if (!window.editor) {
    return;
  }

  const editor = window.editor;

  // Verificar que el editor esté completamente inicializado
  if (!editor.getComponents || !editor.getWrapper) {
    console.warn('⚠️ Editor no completamente inicializado, reintentando en 500ms...');
    setTimeout(initializeManagers, 500);
    return;
  }



  // Verificar que los managers estén disponibles y intentar renderizar
  if (editor.StyleManager) {
    try {
      editor.StyleManager.render();

      // Agregar event listeners después del renderizado
      setTimeout(() => {
        const styleContainer = document.querySelector('.styles-container');
        if (styleContainer) {
          // Remover listeners anteriores si existen
          styleContainer.removeEventListener('click', handleSectorClick);
          // Agregar nuevo listener
          styleContainer.addEventListener('click', handleSectorClick);
        }
      }, 100);
    } catch (error) {
      console.error('❌ Error renderizando StyleManager:', error);
    }
  } else {
    console.warn('⚠️ StyleManager no disponible');
  }


  if (editor.TraitManager) {
    try {
      editor.TraitManager.render();
    } catch (error) {
      console.error('❌ Error renderizando TraitManager:', error);
    }
  } else {
    console.warn('⚠️ TraitManager no disponible');
  }

  if (editor.LayerManager) {
    try {
      // Verificar que el LayerManager tenga componentes válidos antes de renderizar
      const components = editor.getComponents();
      if (components && components.length > 0) {
        // Limpiar componentes inválidos
        components.forEach((component, index) => {
          if (!component || !component.get) {
            console.warn(`⚠️ Componente inválido en índice ${index}, removiendo...`);
            components.remove(component);
          }
        });
      }

      editor.LayerManager.render();
    } catch (error) {
      console.error('❌ Error renderizando LayerManager:', error);
      // Intentar limpiar y reinicializar
      try {
        const components = editor.getComponents();
        if (components) {
          components.reset();
        }
        editor.LayerManager.render();
      } catch (retryError) {
        console.error('❌ Error persistente en LayerManager:', retryError);
      }
    }
  } else {
    console.warn('⚠️ LayerManager no disponible');
  }

  // Intentar seleccionar un componente para activar los managers
  // (Comentado para evitar deselección automática de componentes seleccionados)
  // const components = editor.getComponents();
  // if (components && components.length > 0) {
  //   const firstComponent = components.at(0);
  //   if (firstComponent) {
  //     editor.select(firstComponent);
  //   }
  // }
}

// Inicialización del editor
function initializeEditor() {
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
    // Si es un bloque de productos, mostrar placeholder
    if (component.get('type') === 'products-list' ||
      component.get('attributes').class === 'gjs-block-products') {
      setTimeout(showProductsPlaceholder, 100);
    }

    // Si es un bloque de navbar, verificar si la tienda virtual está habilitada
    if (component?.attributes?.tagName === 'nav') {
      console.log('navbar');
    }
  });

  // Evento cuando se selecciona un componente
  editor.on('component:selected', function (component) {

    // Forzar actualización del StyleManager cuando se selecciona un componente
    setTimeout(() => {
      if (editor.StyleManager) {
        editor.StyleManager.render();
      }
    }, 100);
  });

  // Evento cuando se deselecciona un componente
  editor.on('component:deselected', function (component) {
  });

  // Cargar contenido existente si existe
  const existingHtml = document.getElementById('page-html-content')?.value;
  const existingCss = document.getElementById('page-css-content')?.value;

  if (existingHtml && existingCss) {
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
          }
        }
      });
    }
  }, 2000);

  // También intentar inicializar cuando se selecciona un componente
  // (Comentado para evitar deselección automática)
  // editor.on('component:selected', function (component) {
  //   setTimeout(initializeManagers, 100);
  // });

  // Función para forzar actualización de managers
  window.updateManagers = function () {
    if (window.editor) {
      const editor = window.editor;

      // Verificar si los contenedores tienen contenido
      const stylesContainer = document.querySelector('.styles-container');
      const traitsContainer = document.querySelector('.traits-container');
      const layersContainer = document.querySelector('.layers-container');


      // Forzar renderizado de todos los managers
      if (editor.StyleManager) {
        editor.StyleManager.render();
      }
      if (editor.TraitManager) {
        editor.TraitManager.render();
      }
      if (editor.LayerManager) {
        editor.LayerManager.render();
      }

      // Verificar nuevamente después del renderizado
      setTimeout(() => {
      }, 500);
    }
  };

  // Configurar botón de guardar
  document.getElementById('save-btn')?.addEventListener('click', function () {
    const htmlContent = editor.getHtml();
    const cssContent = editor.getCss();


    const requestData = {
      html_content: htmlContent,
      css_content: cssContent,
      enable_store: document.getElementById('enable-store')?.checked || false
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

}

// Exportar funciones para uso global
window.initializeEditor = initializeEditor;
window.showProductsPlaceholder = showProductsPlaceholder;
window.initializeManagers = initializeManagers;