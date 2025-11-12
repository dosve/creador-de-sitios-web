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
    // Imágenes de ejemplo por defecto
    assets: [
      'https://images.unsplash.com/photo-1506748686214-e9df14d4d9d0?w=800',
      'https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=800',
      'https://images.unsplash.com/photo-1501594907352-04cda38ebc29?w=800',
      'https://images.unsplash.com/photo-1518173946687-a4c8892bbd9f?w=800',
      'https://images.unsplash.com/photo-1511593358241-7eea1f3c84e5?w=800',
      'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800'
    ],
    // Permitir agregar imágenes por URL
    modalTitle: 'Seleccionar Imagen',
    multiUpload: false
  },
  layerManager: {
    appendTo: '.layers-container',
    // Mostrar nombres personalizados en lugar de tipos HTML
    showWrapper: false,
    sortable: true,
    hidable: true
  },
  traitManager: {
    appendTo: '.traits-container',
    // Configuración adicional para traits estilo Elementor
    textareaAutoResize: true,
  },
  selectorManager: {
    // Configuración para selectores únicos por componente
    componentFirst: true,
    custom: true
  },
  styleManager: {
    appendTo: '.styles-container',
    // Aplicar estilos al componente seleccionado, no a toda la clase
    clearProperties: false,
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

  // Función global para forzar la actualización del TraitManager
  window.forceTraitManagerUpdate = function(component) {
    if (editor.TraitManager) {
      console.log('🔄 Forzando actualización global del TraitManager...');
      
      // Obtener el componente seleccionado si no se proporciona uno
      const targetComponent = component || editor.getSelected();
      
      if (targetComponent) {
        console.log('🎯 Componente objetivo para TraitManager:', targetComponent.get('type'));
        
        // Si es un carrusel, usar solo el sistema personalizado
        if (targetComponent.get('type') === 'carousel') {
          console.log('🎠 Carrusel detectado: usando solo sistema personalizado');
          window.renderCustomTraits(targetComponent);
          return;
        }
        
        // Limpiar el contenedor de traits primero
        const traitsContainer = document.querySelector('.traits-container');
        if (traitsContainer) {
          traitsContainer.innerHTML = '';
        }
        
        // Limpiar completamente el TraitManager
        if (editor.TraitManager.collection) {
          editor.TraitManager.collection.reset();
        }
        
        // Re-renderizar desde cero
        editor.TraitManager.render();
        
        // Verificar si se renderizaron todos los traits
        setTimeout(() => {
          const traitsInContainer = document.querySelectorAll('.traits-container .gjs-trt-trait');
          console.log('📋 Traits renderizados después de actualización global:', traitsInContainer.length);
          
          if (traitsInContainer.length === 0) {
            console.log('⚠️ No se renderizaron traits, usando sistema personalizado...');
            
            // Usar el sistema de traits personalizado
            window.renderCustomTraits(targetComponent);
          }
        }, 200);
      } else {
        console.warn('⚠️ No hay componente seleccionado para actualizar TraitManager');
      }
    }
  };

  // Sistema de traits personalizado
  window.renderCustomTraits = function(component) {
    console.log('🎨 Renderizando traits personalizados para:', component.get('type'));
    
    const traitsContainer = document.querySelector('.traits-container');
    if (!traitsContainer) {
      console.error('❌ No se encontró el contenedor de traits');
      return;
    }
    
    // Limpiar el contenedor
    traitsContainer.innerHTML = '';
    
    // Obtener los traits del componente
    let traits = [];
    if (component.getTraits && typeof component.getTraits === 'function') {
      traits = component.getTraits();
    } else if (component.get('traits')) {
      traits = component.get('traits').toJSON();
    }
    
    console.log('📋 Traits a renderizar:', traits.length);
    
    if (traits.length === 0) {
      traitsContainer.innerHTML = '<div class="text-gray-500 text-sm p-4">No hay propiedades disponibles</div>';
      return;
    }
    
    // Renderizar cada trait
    traits.forEach(trait => {
      const traitElement = createTraitElement(trait, component);
      if (traitElement) {
        traitsContainer.appendChild(traitElement);
      }
    });
    
    console.log('✅ Traits personalizados renderizados:', traitsContainer.children.length);
    
    // Proteger los traits personalizados del carrusel
    if (component.get('type') === 'carousel') {
      console.log('🛡️ Protegiendo traits del carrusel de interferencias');
      
      // Marcar el contenedor como protegido
      traitsContainer.setAttribute('data-protected', 'true');
      traitsContainer.setAttribute('data-component-type', 'carousel');
      
      // Interceptar intentos de limpiar el contenedor
      const originalInnerHTML = traitsContainer.innerHTML;
      
      // Crear un observer para detectar cambios no deseados
      const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
          if (mutation.type === 'childList' && traitsContainer.children.length === 0) {
            console.log('⚠️ Detectado intento de limpiar traits del carrusel, restaurando...');
            setTimeout(() => {
              if (traitsContainer.children.length === 0) {
                traitsContainer.innerHTML = originalInnerHTML;
                console.log('🔄 Traits del carrusel restaurados');
              }
            }, 100);
          }
        });
      });
      
      observer.observe(traitsContainer, { childList: true });
      
      // Limpiar el observer después de 30 segundos
      setTimeout(() => {
        observer.disconnect();
        console.log('🛡️ Protección de traits del carrusel desactivada');
      }, 30000);
    }
  };

  // Funciones globales para editar y eliminar imágenes
  window.editImage = function(slideNum) {
    console.log(`🔄 Editando imagen ${slideNum}`);
    const component = editor.getSelected();
    if (component) {
      // Abrir el Asset Manager
      const am = editor.AssetManager;
      const modal = editor.Modal;
      
      // Configurar el callback cuando se seleccione una imagen
      am.onClick((asset) => {
        const newSrc = asset.get('src');
        console.log(`🎠 Imagen seleccionada para slide ${slideNum}:`, newSrc);
        
        // Encontrar la imagen específica
        const carouselContainer = component.view.el.querySelector('.carousel-container') || 
                                 component.view.el.querySelector('.carousel') || 
                                 component.view.el;
        const images = carouselContainer.querySelectorAll('.carousel-slide img') || 
                     carouselContainer.querySelectorAll('img') ||
                     [];
        
        if (images[slideNum - 1]) {
          images[slideNum - 1].src = newSrc;
          images[slideNum - 1].setAttribute('src', newSrc);
          
          // Actualizar el trait correspondiente
          component.set(`slide-${slideNum}`, newSrc);
          
          console.log(`✅ Slide ${slideNum} actualizado con nueva imagen`);
        }
        
        // Cerrar el modal
        modal.close();
        
        // Actualizar traits personalizados
        if (window.renderCustomTraits) {
          window.renderCustomTraits(component);
        }
      });
      
      // Mostrar el Asset Manager en un modal
      modal.setTitle(`Cambiar Imagen ${slideNum}`)
        .setContent(am.render())
        .open();
    }
  };

  window.deleteImage = function(slideNum) {
    console.log(`🗑️ Eliminando imagen ${slideNum}`);
    const component = editor.getSelected();
    if (component) {
      // Confirmar eliminación
      if (confirm(`¿Estás seguro de que quieres eliminar la imagen ${slideNum}?`)) {
        // Encontrar la imagen específica
        const carouselContainer = component.view.el.querySelector('.carousel-container') || 
                                 component.view.el.querySelector('.carousel') || 
                                 component.view.el;
        const images = carouselContainer.querySelectorAll('.carousel-slide img') || 
                     carouselContainer.querySelectorAll('img') ||
                     [];
        
        if (images[slideNum - 1]) {
          // Restaurar placeholder
          images[slideNum - 1].src = `https://via.placeholder.com/800x400?text=Slide+${slideNum}`;
          images[slideNum - 1].setAttribute('src', images[slideNum - 1].src);
          
          // Limpiar el trait
          component.set(`slide-${slideNum}`, '');
          
          console.log(`✅ Imagen ${slideNum} eliminada`);
          
          // Actualizar traits personalizados
          if (window.renderCustomTraits) {
            window.renderCustomTraits(component);
          }
        }
      }
    }
  };

  // Función para crear elementos de trait
  function createTraitElement(trait, component) {
    const container = document.createElement('div');
    container.className = 'gjs-trt-trait custom-trait';
    container.setAttribute('data-trait-name', trait.name);
    
    const label = document.createElement('label');
    label.className = 'gjs-trt-label';
    label.textContent = trait.label || trait.name;
    container.appendChild(label);
    
    const fieldContainer = document.createElement('div');
    fieldContainer.className = 'gjs-trt-field';
    
    let input;
    
    switch (trait.type) {
      case 'text':
        input = document.createElement('input');
        input.type = 'text';
        input.className = 'gjs-trt-input';
        input.placeholder = trait.placeholder || '';
        input.value = component.get(trait.name) || '';
        break;
        
      case 'textarea':
        input = document.createElement('textarea');
        input.className = 'gjs-trt-textarea';
        input.placeholder = trait.placeholder || '';
        input.value = component.get(trait.name) || '';
        break;
        
      case 'select':
        input = document.createElement('select');
        input.className = 'gjs-trt-select';
        if (trait.options) {
          trait.options.forEach(option => {
            const optionElement = document.createElement('option');
            optionElement.value = option.value;
            optionElement.textContent = option.name;
            input.appendChild(optionElement);
          });
        }
        input.value = component.get(trait.name) || '';
        break;
        
      case 'checkbox':
        input = document.createElement('input');
        input.type = 'checkbox';
        input.className = 'gjs-trt-checkbox';
        input.checked = component.get(trait.name) || false;
        break;
        
      case 'button':
        input = document.createElement('button');
        input.type = 'button';
        input.className = 'gjs-trt-button';
        input.textContent = trait.text || trait.label;
        if (trait.command) {
          input.addEventListener('click', () => trait.command(editor));
        }
        break;
        
      case 'custom':
        // Para traits personalizados, usar el contenido HTML directamente
        fieldContainer.innerHTML = trait.content || '';
        container.appendChild(fieldContainer);
        return container;
        
      default:
        console.warn('⚠️ Tipo de trait no soportado:', trait.type);
        return null;
    }
    
    if (input && trait.type !== 'button') {
      // Agregar event listener para cambios
      input.addEventListener('change', (e) => {
        const value = e.target.type === 'checkbox' ? e.target.checked : e.target.value;
        component.set(trait.name, value);
        console.log(`🔄 Trait actualizado: ${trait.name} = ${value}`);
        
        // Ejecutar onUpdate si existe
        if (trait.onUpdate && typeof trait.onUpdate === 'function') {
          trait.onUpdate(value, component);
        }
      });
      
      input.addEventListener('input', (e) => {
        const value = e.target.type === 'checkbox' ? e.target.checked : e.target.value;
        component.set(trait.name, value);
        console.log(`🔄 Trait actualizado (input): ${trait.name} = ${value}`);
        
        // Ejecutar onUpdate si existe
        if (trait.onUpdate && typeof trait.onUpdate === 'function') {
          trait.onUpdate(value, component);
        }
      });
    }
    
    fieldContainer.appendChild(input);
    container.appendChild(fieldContainer);
    
    return container;
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
  
  // Registrar tipos de componentes personalizados para Layer Manager
  editor.DomComponents.addType('section', {
    model: {
      defaults: {
        name: 'Sección',
        icon: '<i class="fa fa-columns"></i>',
        droppable: true
      }
    }
  });
  
  editor.DomComponents.addType('container', {
    model: {
      defaults: {
        name: 'Contenedor',
        icon: '<i class="fa fa-square-o"></i>',
        droppable: true,
        traits: [
          {
            type: 'select',
            name: 'container-width',
            label: 'Ancho del Contenedor',
            changeProp: 1,
            options: [
              { value: 'w-full', name: 'Ancho Completo (100%)' },
              { value: 'container', name: 'Contenedor Responsive' },
              { value: 'max-w-7xl', name: 'Muy Ancho (1280px)' },
              { value: 'max-w-6xl', name: 'Ancho (1152px)' },
              { value: 'max-w-4xl', name: 'Mediano (896px)' },
              { value: 'max-w-2xl', name: 'Pequeño (672px)' }
            ]
          },
          {
            type: 'select',
            name: 'padding',
            label: 'Espaciado Interno',
            changeProp: 1,
            options: [
              { value: 'p-0', name: 'Sin Espaciado' },
              { value: 'p-2', name: 'Muy Pequeño' },
              { value: 'p-4', name: 'Pequeño' },
              { value: 'p-6', name: 'Normal' },
              { value: 'p-8', name: 'Grande' },
              { value: 'p-12', name: 'Extra Grande' }
            ]
          },
          {
            type: 'select',
            name: 'margin',
            label: 'Margen',
            changeProp: 1,
            options: [
              { value: 'mx-auto', name: 'Centrado Horizontal' },
              { value: 'm-0', name: 'Sin Margen' },
              { value: 'm-4', name: 'Pequeño' },
              { value: 'm-8', name: 'Mediano' },
              { value: 'm-12', name: 'Grande' }
            ]
          }
        ]
      },
      init() {
        // Escuchar cambios en los traits del contenedor
        this.on('change:container-width', this.handleContainerWidthChange);
        this.on('change:padding', this.handlePaddingChange);
        this.on('change:margin', this.handleMarginChange);
        this.on('change:container-layout', this.handleContainerLayoutChange);
        this.on('change:column-gap', this.handleColumnGapChange);
        this.on('change:vertical-align', this.handleVerticalAlignChange);
        this.on('change:horizontal-align', this.handleHorizontalAlignChange);
      },
      handleContainerWidthChange() {
        const width = this.get('container-width');
        const currentClasses = this.getClasses();
        
        // Remover clases de ancho anteriores
        const widthClasses = ['w-full', 'container', 'max-w-7xl', 'max-w-6xl', 'max-w-4xl', 'max-w-2xl'];
        widthClasses.forEach(cls => this.removeClass(cls));
        
        // Agregar nueva clase de ancho
        if (width) {
          this.addClass(width);
        }
      },
      handlePaddingChange() {
        const padding = this.get('padding');
        
        // Remover clases de padding anteriores
        const paddingClasses = ['p-0', 'p-2', 'p-4', 'p-6', 'p-8', 'p-12'];
        paddingClasses.forEach(cls => this.removeClass(cls));
        
        // Agregar nueva clase de padding
        if (padding) {
          this.addClass(padding);
        }
      },
      handleMarginChange() {
        const margin = this.get('margin');
        
        // Remover clases de margen anteriores
        const marginClasses = ['mx-auto', 'm-0', 'm-4', 'm-8', 'm-12'];
        marginClasses.forEach(cls => this.removeClass(cls));
        
        // Agregar nueva clase de margen
        if (margin) {
          this.addClass(margin);
        }
      },
      handleContainerLayoutChange() {
        // Actualizar layout de columnas del contenedor
        if (window.updateContainerLayout) {
          window.updateContainerLayout(this);
        }
      },
      handleColumnGapChange() {
        if (window.updateContainerLayout) {
          window.updateContainerLayout(this);
        }
      },
      handleVerticalAlignChange() {
        if (window.updateContainerLayout) {
          window.updateContainerLayout(this);
        }
      },
      handleHorizontalAlignChange() {
        if (window.updateContainerLayout) {
          window.updateContainerLayout(this);
        }
      }
    }
  });
  
  editor.DomComponents.addType('section-inner', {
    model: {
      defaults: {
        name: 'Grid de Columnas',
        icon: '<i class="fa fa-th"></i>',
        droppable: true
      }
    }
  });
  
  editor.DomComponents.addType('column', {
    model: {
      defaults: {
        name: 'Columna',
        icon: '<i class="fa fa-square"></i>',
        droppable: true
      }
    }
  });
  
  editor.DomComponents.addType('heading', {
    model: {
      defaults: {
        name: 'Título',
        icon: '<i class="fa fa-header"></i>',
        editable: true,
        traits: [
          {
            type: 'text',
            name: 'text',
            label: 'Texto del Título',
            changeProp: 1,
          },
          {
            type: 'select',
            name: 'tagName',
            label: 'Etiqueta HTML',
            changeProp: 1,
            options: [
              { value: 'h1', name: 'H1 (Más grande)' },
              { value: 'h2', name: 'H2' },
              { value: 'h3', name: 'H3' },
              { value: 'h4', name: 'H4' },
              { value: 'h5', name: 'H5' },
              { value: 'h6', name: 'H6 (Más pequeño)' }
            ]
          },
          {
            type: 'select',
            name: 'text-align',
            label: 'Alineación',
            changeProp: 1,
            options: [
              { value: 'text-left', name: 'Izquierda' },
              { value: 'text-center', name: 'Centro' },
              { value: 'text-right', name: 'Derecha' },
              { value: 'text-justify', name: 'Justificado' }
            ]
          }
        ]
      },
      init() {
        // Escuchar cambios en los traits
        this.on('change:text', this.handleTextChange);
      },
      handleTextChange() {
        const text = this.get('text');
        if (text) {
          this.components(text);
        }
      }
    }
  });
  
  editor.DomComponents.addType('paragraph', {
    model: {
      defaults: {
        name: 'Párrafo',
        icon: '<i class="fa fa-paragraph"></i>',
        editable: true,
        traits: [
          {
            type: 'textarea',
            name: 'text',
            label: 'Texto del Párrafo',
            changeProp: 1,
          }
        ]
      },
      init() {
        // Escuchar cambios en los traits
        this.on('change:text', this.handleTextChange);
      },
      handleTextChange() {
        const text = this.get('text');
        if (text) {
          this.components(text);
        }
      }
    }
  });
  
  editor.DomComponents.addType('text', {
    model: {
      defaults: {
        name: 'Texto',
        icon: '<i class="fa fa-font"></i>',
        editable: true,
        traits: [
          {
            type: 'textarea',
            name: 'text',
            label: 'Contenido de Texto',
            changeProp: 1,
          }
        ]
      },
      init() {
        // Escuchar cambios en los traits
        this.on('change:text', this.handleTextChange);
      },
      handleTextChange() {
        const text = this.get('text');
        if (text) {
          this.components(text);
        }
      }
    }
  });
  
  // Componente de Imagen con traits personalizados
  editor.DomComponents.addType('image', {
    extend: 'image',
    isComponent: (el) => {
      if (el.tagName === 'IMG') {
        return { type: 'image' };
      }
    },
    model: {
      defaults: {
        name: 'Imagen',
        tagName: 'img'
      },
      // Sobrescribir el método para obtener los traits
      getTraits() {
        return [
          {
            type: 'button',
            name: 'select-image',
            label: '📁 Seleccionar Imagen',
            text: 'Elegir nueva imagen',
            full: true,
            command: (editor) => {
              const component = editor.getSelected();
              if (component) {
                // Abrir el Asset Manager
                const am = editor.AssetManager;
                const modal = editor.Modal;
                
                // Configurar el callback cuando se seleccione una imagen
                am.onClick((asset) => {
                  const newSrc = asset.get('src');
                  console.log('🖼️ Imagen seleccionada desde Asset Manager:', newSrc);
                  
                  // Actualizar la imagen
                  component.set('src', newSrc);
                  component.addAttributes({ src: newSrc });
                  
                  // Actualizar el DOM
                  if (component.view && component.view.el) {
                    component.view.el.src = newSrc;
                  }
                  
                  // Cerrar el modal
                  modal.close();
                  
                  // Forzar actualización del trait manager
                  editor.TraitManager.render();
                });
                
                // Mostrar el Asset Manager en un modal
                modal.setTitle('Seleccionar Imagen')
                  .setContent(am.render())
                  .open();
              }
            }
          },
          {
            type: 'text',
            name: 'src',
            label: 'URL de la Imagen',
            placeholder: 'https://ejemplo.com/imagen.jpg'
          },
          {
            type: 'text',
            name: 'alt',
            label: 'Texto Alternativo',
            placeholder: 'Descripción de la imagen'
          },
          {
            type: 'text',
            name: 'title',
            label: 'Título (Tooltip)',
            placeholder: 'Título al pasar el mouse'
          },
          {
            type: 'select',
            name: 'loading',
            label: 'Carga de Imagen',
            options: [
              { value: '', name: 'Por defecto' },
              { value: 'lazy', name: 'Lazy (Diferida)' },
              { value: 'eager', name: 'Eager (Inmediata)' }
            ]
          }
        ];
      },
      init() {
        console.log('🖼️ Inicializando componente de Imagen...');
        
        // Extraer valores de atributos existentes
        const attrs = this.getAttributes();
        console.log('📋 Atributos actuales de la imagen:', attrs);
        
        // Sincronizar atributos con traits
        if (attrs.src && !this.get('src')) {
          this.set('src', attrs.src, { silent: true });
        }
        if (attrs.alt && !this.get('alt')) {
          this.set('alt', attrs.alt, { silent: true });
        }
        if (attrs.title && !this.get('title')) {
          this.set('title', attrs.title, { silent: true });
        }
        if (attrs.loading && !this.get('loading')) {
          this.set('loading', attrs.loading, { silent: true });
        }
        
        // Listener para cambios en los traits
        this.on('change:src', this.handleSrcChange);
        this.on('change:alt', this.handleAltChange);
        this.on('change:title', this.handleTitleChange);
        this.on('change:loading', this.handleLoadingChange);
        
        console.log('✅ Componente Imagen inicializado:', {
          src: this.get('src') || attrs.src,
          alt: this.get('alt') || attrs.alt,
          title: this.get('title') || attrs.title,
          loading: this.get('loading') || attrs.loading
        });
      },
      handleSrcChange() {
        const newSrc = this.get('src');
        console.log('🖼️ Cambiando src de imagen a:', newSrc);
        
        if (newSrc && newSrc.trim()) {
          // Actualizar el atributo src
          this.addAttributes({ src: newSrc.trim() });
          
          // También actualizar el DOM directamente
          if (this.view && this.view.el) {
            this.view.el.src = newSrc.trim();
            console.log('✅ Imagen actualizada en el DOM');
          }
        }
      },
      handleAltChange() {
        const newAlt = this.get('alt');
        console.log('🖼️ Cambiando alt de imagen a:', newAlt);
        
        if (newAlt !== undefined) {
          this.addAttributes({ alt: newAlt });
          
          if (this.view && this.view.el) {
            this.view.el.alt = newAlt;
          }
        }
      },
      handleTitleChange() {
        const newTitle = this.get('title');
        console.log('🖼️ Cambiando title de imagen a:', newTitle);
        
        if (newTitle !== undefined) {
          this.addAttributes({ title: newTitle });
          
          if (this.view && this.view.el) {
            this.view.el.title = newTitle;
          }
        }
      },
      handleLoadingChange() {
        const newLoading = this.get('loading');
        console.log('🖼️ Cambiando loading de imagen a:', newLoading);
        
        if (newLoading) {
          this.addAttributes({ loading: newLoading });
          
          if (this.view && this.view.el) {
            this.view.el.loading = newLoading;
          }
        }
      }
    }
  });
  
  // Componente de Carrusel - REFORMULADO COMPLETAMENTE
  editor.DomComponents.addType('carousel', {
    isComponent: (el) => {
      console.log('🔍 Verificando elemento para carrusel:', el.tagName, el.className);
      
      // Identificar por clase carousel-container
      if (el.classList && el.classList.contains('carousel-container')) {
        console.log('✅ Carrusel identificado por clase "carousel-container"');
        return { type: 'carousel' };
      }
      
      // Identificar por estructura de carrusel
      if (el.querySelector && el.querySelector('.carousel-slide')) {
        console.log('✅ Carrusel identificado por estructura');
        return { type: 'carousel' };
      }
      
      return false;
    },
    model: {
      defaults: {
        name: 'Carrusel',
        tagName: 'div',
        draggable: true,
        droppable: true,
        selectable: true,
        hoverable: true,
        editable: true,
        removable: true,
        layerable: true,
        highlightable: true,
        badgable: true,
        toolbar: true
      },
      getTraits() {
        console.log('📋 getTraits() llamado para carrusel');
        
        return [
          {
            type: 'button',
            name: 'open-gallery',
            label: '🖼️ Galería de Imágenes',
            text: 'Abrir galería para seleccionar o cargar imágenes',
            full: true,
            command: (editor) => {
              const component = editor.getSelected();
              if (component) {
                // Abrir el Asset Manager
                const am = editor.AssetManager;
                const modal = editor.Modal;
                
                // Configurar el callback cuando se seleccione una imagen
                am.onClick((asset) => {
                  const newSrc = asset.get('src');
                  console.log('🎠 Imagen seleccionada para carrusel:', newSrc);
                  
                  // Encontrar el contenedor del carrusel
                  const carouselContainer = component.view.el.querySelector('.carousel-container') || 
                                          component.view.el.querySelector('.carousel') || 
                                          component.view.el;
                  
                  const existingImages = carouselContainer.querySelectorAll('.carousel-slide img') || 
                                       carouselContainer.querySelectorAll('img') ||
                                       [];
                  
                  let targetSlide = null;
                  let slideIndex = 1;
                  
                  // Buscar el primer slide vacío (placeholder) o el primer slide disponible
                  for (let i = 0; i < existingImages.length; i++) {
                    if (existingImages[i].src.includes('placeholder') || existingImages[i].src.includes('via.placeholder')) {
                      targetSlide = existingImages[i];
                      slideIndex = i + 1;
                      break;
                    }
                  }
                  
                  // Si no hay slide vacío, usar el primer slide disponible
                  if (!targetSlide && existingImages.length > 0) {
                    targetSlide = existingImages[0];
                    slideIndex = 1;
                  }
                  
                  if (targetSlide) {
                    // Actualizar slide existente
                    targetSlide.src = newSrc;
                    targetSlide.setAttribute('src', newSrc);
                    
                    // Guardar en el componente
                    component.set(`slide-${slideIndex}`, newSrc);
                    
                    console.log(`✅ Slide ${slideIndex} actualizado con nueva imagen`);
                  } else {
                    // Si no hay slides, crear el primer slide
                    const newSlide = document.createElement('div');
                    newSlide.className = 'carousel-slide';
                    newSlide.innerHTML = `
                      <img src="${newSrc}" 
                           alt="Slide 1" 
                           style="width: 100%; height: 300px; object-fit: cover;">
                    `;
                    carouselContainer.appendChild(newSlide);
                    
                    // Guardar la URL del slide
                    component.set('slide-1', newSrc);
                    component.set('slides', 1);
                    
                    console.log(`✅ Primer slide creado con imagen`);
                  }
                  
                  // Cerrar el modal
                  modal.close();
                  
                  // Actualizar el TraitManager
                  setTimeout(() => {
                    editor.TraitManager.render();
                  }, 100);
                });
                
                // Mostrar el Asset Manager en un modal
                modal.setTitle('Galería de Imágenes - Seleccionar o Cargar')
                  .setContent(am.render())
                  .open();
              }
            }
          },
          {
            type: 'checkbox',
            name: 'autoplay',
            label: 'Reproducción Automática',
            value: false
          },
          {
            type: 'select',
            name: 'transition-speed',
            label: 'Velocidad de Transición',
            options: [
              { value: '300', name: 'Rápido (0.3s)' },
              { value: '500', name: 'Normal (0.5s)' },
              { value: '1000', name: 'Lento (1s)' }
            ]
          },
          {
            type: 'checkbox',
            name: 'show-controls',
            label: 'Mostrar Controles',
            value: true
          },
          {
            type: 'checkbox',
            name: 'show-indicators',
            label: 'Mostrar Indicadores',
            value: true
          }
        ];
      },
      init() {
        console.log('🎠 Inicializando componente de Carrusel...');
        console.log('📋 Tipo de componente:', this.get('type'));
        console.log('📋 Traits definidos:', this.get('traits'));
        
        // Inicializar con 3 slides vacíos por defecto
        if (!this.get('slides')) {
          this.set('slides', 3);
        }
        
        // Crear slides vacíos si no existen
        setTimeout(() => {
          const carouselContainer = this.view?.el?.querySelector('.carousel-container') || 
                                   this.view?.el?.querySelector('.carousel') || 
                                   this.view?.el;
          
          if (carouselContainer) {
            const existingSlides = carouselContainer.querySelectorAll('.carousel-slide');
            const expectedSlides = this.get('slides') || 3;
            
            console.log(`🔍 Slides existentes: ${existingSlides.length}, esperados: ${expectedSlides}`);
            
            // Si no hay slides o hay menos de los esperados, crear los faltantes
            for (let i = existingSlides.length; i < expectedSlides; i++) {
              const slideNum = i + 1;
              const newSlide = document.createElement('div');
              newSlide.className = 'carousel-slide';
              newSlide.innerHTML = `
                <img src="https://via.placeholder.com/800x400?text=Slide+${slideNum}" 
                     alt="Slide ${slideNum}" 
                     style="width: 100%; height: 300px; object-fit: cover;">
              `;
              carouselContainer.appendChild(newSlide);
              console.log(`✅ Slide ${slideNum} creado (placeholder)`);
            }
          }
        }, 200);
        
        // Hacer que todas las imágenes hijas NO sean seleccionables
        const makeImagesNonSelectable = (component = this) => {
          component.components().each(child => {
            if (child.get('tagName') === 'img') {
              child.set({
                selectable: false,
                hoverable: false,
                draggable: false,
                editable: false,
                removable: false,
                layerable: false
              });
              console.log('🎠 Imagen de carrusel bloqueada');
            }
            // Recursión para todos los hijos
            if (child.components().length > 0) {
              makeImagesNonSelectable(child);
            }
          });
        };
        
        // Ejecutar ahora y después de renderizar
        setTimeout(makeImagesNonSelectable, 100);
        this.on('component:mount', makeImagesNonSelectable);
        
        // Extraer URLs iniciales de las imágenes y sincronizar con traits
        const syncSlideUrls = () => {
          const slides = this.view?.el?.querySelectorAll('.carousel-slide img') || [];
          console.log(`📸 Encontrados ${slides.length} slides en el carrusel`);
          
          slides.forEach((img, index) => {
            const slideNum = index + 1;
            const src = img.src;
            if (src) {
              this.set(`slide-${slideNum}`, src, { silent: true });
              console.log(`✅ Sincronizado slide-${slideNum}: ${src.substring(0, 50)}...`);
            }
          });
          
          // Forzar actualización del TraitManager
          if (window.editor && window.editor.TraitManager) {
            window.editor.TraitManager.render();
            console.log('🔄 TraitManager actualizado');
          }
        };
        
        // Función para forzar la actualización del TraitManager cuando se selecciona el carrusel
        const forceTraitManagerUpdate = () => {
          if (window.editor && window.editor.TraitManager) {
            console.log('🔄 Forzando actualización del TraitManager para carrusel...');
            
            // Limpiar el contenedor de traits primero
            const traitsContainer = document.querySelector('.traits-container');
            if (traitsContainer) {
              traitsContainer.innerHTML = '';
            }
            
            // Forzar la actualización del componente seleccionado en el editor
            const selectedComponent = window.editor.getSelected();
            if (selectedComponent) {
              console.log('🎯 Componente seleccionado para TraitManager:', selectedComponent.get('type'));
              
            // Forzar la actualización del TraitManager con el componente correcto
            // Nota: setTarget no está disponible en esta versión de GrapesJS
            // window.editor.TraitManager.setTarget(selectedComponent);
              
              // Limpiar completamente el TraitManager
              if (window.editor.TraitManager.collection) {
                window.editor.TraitManager.collection.reset();
              }
              
              // Re-renderizar desde cero
              window.editor.TraitManager.render();
              
              // Verificar si se renderizaron todos los traits
              setTimeout(() => {
                const traitsInContainer = document.querySelectorAll('.traits-container .gjs-trt-trait');
                console.log('📋 Traits renderizados después de forzar actualización:', traitsInContainer.length);
                
                if (traitsInContainer.length < 8) {
                  console.log('⚠️ Aún no se muestran todos los traits, intentando método alternativo...');
                  
                  // Método alternativo: forzar la actualización del componente
                  selectedComponent.trigger('change:traits');
                  selectedComponent.trigger('change:attributes');
                  
                  // Forzar nuevamente el target
                  // Nota: setTarget no está disponible en esta versión de GrapesJS
                  // window.editor.TraitManager.setTarget(selectedComponent);
                  
                  // Re-renderizar una vez más
                  window.editor.TraitManager.render();
                  
                  setTimeout(() => {
                    const finalTraits = document.querySelectorAll('.traits-container .gjs-trt-trait');
                    console.log('📋 Traits finales después de método alternativo:', finalTraits.length);
                  }, 100);
                }
              }, 200);
            } else {
              console.warn('⚠️ No hay componente seleccionado para actualizar TraitManager');
            }
          }
        };
        
        // Exponer la función para uso externo
        this.forceTraitManagerUpdate = forceTraitManagerUpdate;
        
        setTimeout(syncSlideUrls, 200);
        this.on('component:mount', () => setTimeout(syncSlideUrls, 100));
        
        // Listeners para cambios en las imágenes
        this.on('change:slide-1', this.handleSlideChange);
        this.on('change:slide-2', this.handleSlideChange);
        this.on('change:slide-3', this.handleSlideChange);
        
        // Listeners para opciones del carrusel
        this.on('change:autoplay', this.handleAutoplayChange);
        this.on('change:transition-speed', this.handleTransitionChange);
        this.on('change:show-controls', this.handleShowControlsChange);
        this.on('change:show-indicators', this.handleShowIndicatorsChange);
        
        console.log('✅ Componente Carrusel inicializado');
      },
      
      // Método para forzar actualización de traits
      updateTraits() {
        console.log('🔄 Forzando actualización de traits del carrusel...');
        
        // Usar el editor global
        if (window.editor && window.editor.TraitManager) {
          try {
            // Forzar re-renderizado del TraitManager
            window.editor.TraitManager.render();
            
            // Forzar actualización del componente
            this.trigger('change:traits');
            
            console.log('✅ Traits del carrusel actualizados');
          } catch (error) {
            console.log('⚠️ Error actualizando traits:', error);
            // Fallback: solo re-renderizar
            window.editor.TraitManager.render();
          }
        }
      },
      view: {
        onRender() {
          console.log('🎠 Vista de carrusel renderizada');
          
          // Agregar evento de clic para forzar selección
          this.el.addEventListener('click', (e) => {
            e.stopPropagation();
            console.log('🖱️ Clic detectado en carrusel - forzando selección');
            editor.select(this.model);
          });
          
          // Agregar cursor pointer
          this.el.style.cursor = 'pointer';
        }
      },
      handleSlideChange(component, value, options) {
        console.log('🎠 Cambio en slide detectado');
        
        // Obtener qué slide cambió
        const changedAttrs = component.changed;
        let slideNumber = null;
        
        for (let key in changedAttrs) {
          if (key.startsWith('slide-')) {
            slideNumber = parseInt(key.replace('slide-', ''));
            break;
          }
        }
        
        if (!slideNumber) return;
        
        const newUrl = this.get(`slide-${slideNumber}`);
        console.log(`🖼️ Actualizando slide ${slideNumber} a:`, newUrl);
        
        if (newUrl && newUrl.trim() && this.view && this.view.el) {
          const slides = this.view.el.querySelectorAll('.carousel-slide img');
          const targetImg = slides[slideNumber - 1];
          
          if (targetImg) {
            targetImg.src = newUrl.trim();
            targetImg.setAttribute('src', newUrl.trim());
            console.log(`✅ Slide ${slideNumber} actualizado`);
          }
        }
      },
      handleAutoplayChange() {
        const autoplay = this.get('autoplay');
        console.log('🎠 Autoplay cambiado a:', autoplay);
        // Aquí puedes agregar lógica para iniciar/detener autoplay
      },
      handleTransitionChange() {
        const speed = this.get('transition-speed');
        console.log('🎠 Velocidad de transición cambiada a:', speed);
        const track = this.view.el.querySelector('.carousel-track');
        if (track) {
          track.style.transitionDuration = `${speed}ms`;
        }
      },
      handleShowControlsChange() {
        const show = this.get('show-controls');
        console.log('🎠 Mostrar controles:', show);
        const controls = this.view.el.querySelector('.carousel-controls');
        if (controls) {
          controls.style.display = show ? 'flex' : 'none';
        }
      },
      handleShowIndicatorsChange() {
        const show = this.get('show-indicators');
        console.log('🎠 Mostrar indicadores:', show);
        const indicators = this.view.el.querySelector('.carousel-indicators');
        if (indicators) {
          indicators.style.display = show ? 'flex' : 'none';
        }
      }
    }
  });
  
  // Componente de Galería - VERSIÓN SIMPLIFICADA
  editor.DomComponents.addType('gallery', {
    isComponent: (el) => {
      // Solo verificar el elemento principal de la galería
      if (el.classList && el.classList.contains('gallery')) {
        console.log('✅ Galería identificada por clase "gallery"');
        return { type: 'gallery' };
      }
      return false;
    },
    model: {
      defaults: {
        name: 'Galería',
        draggable: true,
        droppable: true,
        selectable: true,
        hoverable: true,
        editable: true,
        removable: true,
        layerable: true,
        highlightable: true,
        badgable: true,
        toolbar: true,
        // Valores por defecto
        'image-1': '',
        'image-2': '',
        'image-3': '',
        'image-4': '',
        'columns': '4',
        'gap': '4',
        'hover-effect': true,
        'lightbox': false,
        // Hacer que el componente sea más fácil de seleccionar
        style: {
          'position': 'relative',
          'cursor': 'pointer',
          'outline': '2px dashed transparent',
          'transition': 'outline 0.2s ease'
        }
      },
      getTraits() {
        console.log('📋 getTraits() llamado para galería');
        return [
          {
            type: 'button',
            name: 'load-images',
            label: '📁 Cargar Imágenes',
            text: 'Seleccionar imágenes de la galería',
            full: true,
            command: (editor) => {
              const component = editor.getSelected();
              if (component) {
                // Abrir el Asset Manager
                const am = editor.AssetManager;
                const modal = editor.Modal;
                
                // Configurar el callback cuando se seleccione una imagen
                am.onClick((asset) => {
                  const newSrc = asset.get('src');
                  console.log('🖼️ Imagen seleccionada para galería:', newSrc);
                  
                  // Encontrar la primera imagen vacía o reemplazar la primera
                  const images = component.view.el.querySelectorAll('.grid img');
                  let targetIndex = 0;
                  
                  // Buscar la primera imagen que esté vacía o sea placeholder
                  for (let i = 0; i < images.length; i++) {
                    if (images[i].src.includes('placeholder') || !images[i].src) {
                      targetIndex = i;
                      break;
                    }
                  }
                  
                  // Actualizar la imagen
                  if (images[targetIndex]) {
                    images[targetIndex].src = newSrc;
                    images[targetIndex].setAttribute('src', newSrc);
                    
                    // Actualizar el trait correspondiente
                    const imageNum = targetIndex + 1;
                    component.set(`image-${imageNum}`, newSrc);
                    
                    console.log(`✅ Imagen ${imageNum} actualizada`);
                  }
                  
                  // Cerrar el modal
                  modal.close();
                  
                  // Forzar actualización del trait manager
                  editor.TraitManager.render();
                });
                
                // Mostrar el Asset Manager en un modal
                modal.setTitle('Seleccionar Imagen para Galería')
                  .setContent(am.render())
                  .open();
              }
            }
          },
          {
            type: 'text',
            name: 'image-1',
            label: 'Imagen 1 (URL)',
            placeholder: 'https://ejemplo.com/imagen1.jpg'
          },
          {
            type: 'text',
            name: 'image-2',
            label: 'Imagen 2 (URL)',
            placeholder: 'https://ejemplo.com/imagen2.jpg'
          },
          {
            type: 'text',
            name: 'image-3',
            label: 'Imagen 3 (URL)',
            placeholder: 'https://ejemplo.com/imagen3.jpg'
          },
          {
            type: 'text',
            name: 'image-4',
            label: 'Imagen 4 (URL)',
            placeholder: 'https://ejemplo.com/imagen4.jpg'
          },
          {
            type: 'select',
            name: 'columns',
            label: 'Columnas',
            options: [
              { value: '2', name: '2 Columnas' },
              { value: '3', name: '3 Columnas' },
              { value: '4', name: '4 Columnas' },
              { value: '5', name: '5 Columnas' },
              { value: '6', name: '6 Columnas' }
            ]
          },
          {
            type: 'select',
            name: 'gap',
            label: 'Espaciado',
            options: [
              { value: '1', name: 'Pequeño (0.25rem)' },
              { value: '2', name: 'Reducido (0.5rem)' },
              { value: '4', name: 'Normal (1rem)' },
              { value: '6', name: 'Grande (1.5rem)' },
              { value: '8', name: 'Extra Grande (2rem)' }
            ]
          },
          {
            type: 'checkbox',
            name: 'hover-effect',
            label: 'Efecto Hover',
            value: true
          },
          {
            type: 'checkbox',
            name: 'lightbox',
            label: 'Abrir en Lightbox',
            value: false
          }
        ];
      },
      init() {
        console.log('🖼️ Inicializando componente de Galería...');
        console.log('📋 Tipo de componente:', this.get('type'));
        
        // Listeners para cambios en las imágenes
        this.on('change:image-1', this.handleImageChange);
        this.on('change:image-2', this.handleImageChange);
        this.on('change:image-3', this.handleImageChange);
        this.on('change:image-4', this.handleImageChange);
        
        // Listeners para opciones de layout
        this.on('change:columns', this.handleColumnsChange);
        this.on('change:gap', this.handleGapChange);
        this.on('change:hover-effect', this.handleHoverEffectChange);
        
        // Sincronizar URLs después de renderizar
        setTimeout(() => {
          this.syncImageUrls();
        }, 300);
        
        console.log('✅ Componente Galería inicializado');
      },
      view: {
        onRender() {
          console.log('🖼️ Vista de galería renderizada');
          
          // Hacer que el elemento sea más fácil de seleccionar
          this.el.style.position = 'relative';
          this.el.style.cursor = 'pointer';
          this.el.style.outline = '2px dashed transparent';
          this.el.style.transition = 'outline 0.2s ease';
          
          // Agregar evento de clic para forzar selección
          this.el.addEventListener('click', (e) => {
            e.stopPropagation();
            e.preventDefault();
            console.log('🖱️ Clic detectado en galería - forzando selección');
            editor.select(this.model);
            return false;
          });
          
          // Agregar evento de mouseover para feedback visual
          this.el.addEventListener('mouseover', (e) => {
            this.el.style.outline = '2px dashed #3b82f6';
          });
          
          this.el.addEventListener('mouseout', (e) => {
            this.el.style.outline = '2px dashed transparent';
          });
          
          // Forzar que el elemento sea seleccionable
          this.el.setAttribute('data-gjs-selectable', 'true');
          this.el.setAttribute('data-gjs-hoverable', 'true');
        }
      },
      syncImageUrls() {
        if (!this.view || !this.view.el) return;
        
        const images = this.view.el.querySelectorAll('.grid img') || [];
        console.log(`📸 Encontradas ${images.length} imágenes en la galería`);
        
        images.forEach((img, index) => {
          const imageNum = index + 1;
          const src = img.src;
          if (src && src !== this.get(`image-${imageNum}`)) {
            this.set(`image-${imageNum}`, src, { silent: true });
            console.log(`✅ Sincronizada imagen-${imageNum}: ${src.substring(0, 50)}...`);
          }
        });
        
        // Bloquear imágenes para que no sean seleccionables
        images.forEach(img => {
          const component = editor.DomComponents.getComponent(img);
          if (component) {
            component.set({
              selectable: false,
              hoverable: false,
              draggable: false,
              editable: false,
              removable: false,
              layerable: false
            });
          }
        });
      },
      handleImageChange(component, value, options) {
        console.log('🖼️ Cambio en imagen de galería detectado');
        
        // Obtener qué imagen cambió
        const changedAttrs = component.changed;
        let imageNumber = null;
        
        for (let key in changedAttrs) {
          if (key.startsWith('image-')) {
            imageNumber = parseInt(key.replace('image-', ''));
            break;
          }
        }
        
        if (!imageNumber) return;
        
        const newUrl = this.get(`image-${imageNumber}`);
        console.log(`🖼️ Actualizando imagen ${imageNumber} a:`, newUrl);
        
        if (newUrl && newUrl.trim() && this.view && this.view.el) {
          const images = this.view.el.querySelectorAll('.grid img');
          const targetImg = images[imageNumber - 1];
          
          if (targetImg) {
            targetImg.src = newUrl.trim();
            targetImg.setAttribute('src', newUrl.trim());
            console.log(`✅ Imagen ${imageNumber} actualizada`);
          }
        }
      },
      handleColumnsChange() {
        const columns = this.get('columns') || '4';
        console.log('🖼️ Columnas cambiadas a:', columns);
        
        const grid = this.view.el.querySelector('.grid');
        if (grid) {
          // Remover clases anteriores
          grid.classList.remove('grid-cols-2', 'grid-cols-3', 'grid-cols-4', 'grid-cols-5', 'grid-cols-6');
          // Agregar nueva clase
          grid.classList.add(`grid-cols-${columns}`);
          
          // También aplicar responsive
          grid.classList.remove('md:grid-cols-2', 'md:grid-cols-3', 'md:grid-cols-4', 'md:grid-cols-5', 'md:grid-cols-6');
          grid.classList.add(`md:grid-cols-${columns}`);
        }
      },
      handleGapChange() {
        const gap = this.get('gap') || '4';
        console.log('🖼️ Espaciado cambiado a:', gap);
        
        const grid = this.view.el.querySelector('.grid');
        if (grid) {
          grid.classList.remove('gap-1', 'gap-2', 'gap-4', 'gap-6', 'gap-8');
          grid.classList.add(`gap-${gap}`);
        }
      },
      handleHoverEffectChange() {
        const hasEffect = this.get('hover-effect');
        console.log('🖼️ Efecto hover:', hasEffect);
        
        const images = this.view.el.querySelectorAll('img');
        images.forEach(img => {
          if (hasEffect) {
            img.classList.add('hover:scale-105', 'transition-transform');
          } else {
            img.classList.remove('hover:scale-105', 'transition-transform');
          }
        });
      }
    }
  });
  
  // Componente de YouTube
  editor.DomComponents.addType('youtube-video', {
    isComponent: (el) => {
      if (el.tagName === 'DIV' && (el.classList.contains('youtube-container') || el.getAttribute('data-gjs-type') === 'youtube-video')) {
        return { type: 'youtube-video' };
      }
    },
    model: {
      defaults: {
        name: 'YouTube',
        icon: '<i class="fa fa-youtube-play"></i>',
        draggable: true,
        droppable: false,
        selectable: true,
        editable: true,
        removable: true,
        copyable: true,
        badgable: true,
        stylable: true,
        highlightable: true,
        resizable: false,
        layerable: true,
        attributes: {
          'data-gjs-type': 'youtube-video',
          'data-gjs-name': 'YouTube'
        },
        // Definir traits aquí directamente en defaults
        'video-id': 'dQw4w9WgXcQ',
        'aspect-ratio': '56.25',
        'autoplay': false,
        'controls': '1',
        traits: [
          {
            type: 'text',
            name: 'video-id',
            label: 'ID del Video de YouTube',
            placeholder: 'Ej: dQw4w9WgXcQ',
            changeProp: 1
          },
          {
            type: 'select',
            name: 'aspect-ratio',
            label: 'Proporción',
            changeProp: 1,
            options: [
              { value: '56.25', name: '16:9 (Estándar)' },
              { value: '75', name: '4:3 (Clásico)' },
              { value: '100', name: '1:1 (Cuadrado)' }
            ]
          },
          {
            type: 'checkbox',
            name: 'autoplay',
            label: 'Reproducir automáticamente',
            changeProp: 1
          },
          {
            type: 'checkbox',
            name: 'controls',
            label: 'Mostrar controles',
            changeProp: 1,
            valueTrue: '1',
            valueFalse: '0'
          }
        ]
      },
      init() {
        console.log('🎬 Inicializando componente de YouTube...');
        
        // Buscar iframe recursivamente
        const findIframe = (component) => {
          if (component.get('tagName') === 'iframe') {
            return component;
          }
          let found = null;
          component.components().each(child => {
            if (!found) {
              found = findIframe(child);
            }
          });
          return found;
        };
        
        // Extraer el video-id inicial del src del iframe si existe
        const iframe = findIframe(this);
        if (iframe) {
          const src = iframe.getAttributes().src || '';
          const match = src.match(/embed\/([^?&]+)/);
          if (match && match[1]) {
            this.set('video-id', match[1], { silent: true });
            console.log('📺 Video ID extraído del iframe:', match[1]);
          }
        }
        
        // Listeners para cambios (después de extraer el ID inicial)
        this.on('change:video-id', this.handleVideoIdChange);
        this.on('change:aspect-ratio', this.handleAspectRatioChange);
        this.on('change:autoplay', this.handleAutoplayChange);
        this.on('change:controls', this.handleControlsChange);
        
        // Log de traits disponibles
        const traits = this.get('traits');
        console.log('✅ Componente YouTube inicializado:', {
          traits: traits,
          cantidadTraits: traits?.length || 0,
          videoId: this.get('video-id'),
          aspectRatio: this.get('aspect-ratio'),
          selectable: this.get('selectable'),
          hoverable: this.get('hoverable')
        });
        
        // Forzar que los hijos no sean seleccionables
        this.components().each(child => {
          child.set({
            selectable: false,
            hoverable: false,
            draggable: false
          });
        });
        
        // Asegurar que el aspect ratio esté aplicado desde el inicio
        this.handleAspectRatioChange();
      },
      handleVideoIdChange() {
        const videoId = this.get('video-id');
        const autoplay = this.get('autoplay') ? '1' : '0';
        const controls = this.get('controls') || '1';
        
        console.log('📺 Cambiando video ID a:', videoId);
        console.log('   Autoplay:', autoplay);
        console.log('   Controls:', controls);
        
        if (videoId && videoId.trim()) {
          // Buscar el iframe de manera recursiva
          const findIframe = (component) => {
            if (component.get('tagName') === 'iframe') {
              return component;
            }
            let found = null;
            component.components().each(child => {
              if (!found) {
                found = findIframe(child);
              }
            });
            return found;
          };
          
          const iframe = findIframe(this);
          console.log('🔍 Iframe encontrado:', !!iframe);
          
          if (iframe) {
            const newSrc = `https://www.youtube.com/embed/${videoId.trim()}?autoplay=${autoplay}&controls=${controls}`;
            
            // Actualizar atributos del iframe en el modelo
            iframe.addAttributes({
              src: newSrc,
              allow: 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture',
              allowfullscreen: ''
            });
            
            // MÉTODO 1: Actualizar el DOM directamente
            if (iframe.view && iframe.view.el) {
              const el = iframe.view.el;
              
              // Guardar el padre y clases del iframe
              const parent = el.parentNode;
              const classes = el.className;
              
              // Crear un nuevo iframe para forzar recarga
              const newIframe = document.createElement('iframe');
              newIframe.src = newSrc;
              newIframe.className = classes;
              newIframe.setAttribute('frameborder', '0');
              newIframe.setAttribute('allowfullscreen', '');
              newIframe.setAttribute('allow', 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture');
              
              // Reemplazar el iframe viejo con el nuevo
              if (parent) {
                parent.replaceChild(newIframe, el);
                // Actualizar la referencia en la vista
                iframe.view.el = newIframe;
                console.log('🎬 Iframe reemplazado completamente en el DOM');
              } else {
                // Si no hay padre, intentar solo cambiar el src
                el.setAttribute('src', ''); // Limpiar primero
                setTimeout(() => {
                  el.setAttribute('src', newSrc);
                  el.src = newSrc;
                }, 10);
                console.log('🎬 Src del iframe actualizado con delay');
              }
            }
            
            console.log('✅ URL del iframe actualizada:', newSrc);
          } else {
            console.warn('⚠️ No se encontró el iframe dentro del componente');
            console.log('   Componentes hijos:', this.components().length);
          }
        }
      },
      handleAspectRatioChange() {
        const aspectRatio = this.get('aspect-ratio') || '56.25';
        console.log('🎨 handleAspectRatioChange llamado, aspectRatio:', aspectRatio);
        
          const wrapper = this.components().at(0);
        console.log('   Wrapper encontrado:', !!wrapper);
        
          if (wrapper) {
          // Agregar el padding-bottom como estilo inline para que se guarde en el HTML
          const currentStyle = wrapper.getAttributes().style || '';
          console.log('   Estilo actual del wrapper:', currentStyle);
          
          const styleObj = {};
          
          // Parsear estilos existentes
          if (currentStyle) {
            currentStyle.split(';').forEach(rule => {
              const [prop, val] = rule.split(':').map(s => s.trim());
              if (prop && val) {
                styleObj[prop] = val;
              }
            });
          }
          
          // Agregar o actualizar padding-bottom
          styleObj['padding-bottom'] = `${aspectRatio}%`;
          
          // Convertir de vuelta a string
          const newStyle = Object.entries(styleObj)
            .map(([prop, val]) => `${prop}: ${val}`)
            .join('; ');
          
          console.log('   Nuevo estilo calculado:', newStyle);
          
          // Aplicar como atributo inline
          wrapper.addAttributes({ style: newStyle });
          
          // Verificar que se aplicó
          const verifyStyle = wrapper.getAttributes().style;
          console.log('✅ Estilo verificado después de aplicar:', verifyStyle);
          
          // También actualizar el DOM directamente
          if (wrapper.view && wrapper.view.el) {
            wrapper.view.el.style.paddingBottom = `${aspectRatio}%`;
            console.log('   ✅ Estilo aplicado también al DOM directamente');
          }
        } else {
          console.error('❌ No se encontró el wrapper del componente YouTube');
        }
      },
      handleAutoplayChange() {
        this.handleVideoIdChange(); // Re-generar la URL con el nuevo parámetro
      },
      handleControlsChange() {
        this.handleVideoIdChange(); // Re-generar la URL con el nuevo parámetro
      }
    },
    view: {
onRender() {
        const el = this.el;
        console.log('🎨 Vista de YouTube renderizada:', {
          elemento: el,
          classes: el.className,
          selectable: this.model.get('selectable')
        });
        
        // Agregar listener de clic para asegurar la selección
        el.addEventListener('click', (e) => {
          console.log('🖱️ Clic detectado en componente YouTube');
          e.stopPropagation();
          
          // Forzar la selección de este componente
          if (window.editor) {
            window.editor.select(this.model);
            console.log('✅ Componente YouTube seleccionado manualmente');
          }
        });
        
        // Asegurar que el aspect ratio esté aplicado cuando se renderiza
        // (importante para componentes cargados desde HTML guardado)
        setTimeout(() => {
          this.model.handleAspectRatioChange();
          console.log('✅ Aspect ratio aplicado al renderizar');
        }, 100);
        
        // NO agregar pointer-events via JavaScript, se maneja con CSS solo en el editor
        console.log('✅ Vista de YouTube lista (sin modificar pointer-events)');
      }
    }
  });

  editor.DomComponents.addType('button', {
    model: {
      defaults: {
        tagName: 'a',
        name: 'Botón',
        icon: '<i class="fa fa-hand-pointer-o"></i>',
        editable: true,
        stylable: true,  // Permitir aplicar estilos
        attributes: {
          href: '#',
          target: '_self'
        },
        traits: [
          {
            type: 'text',
            name: 'text',
            label: 'Texto del Botón',
            changeProp: 1,
          },
          {
            type: 'text',
            name: 'href',
            label: 'Enlace URL',
            placeholder: 'https://ejemplo.com'
          },
          {
            type: 'select',
            name: 'target',
            label: 'Abrir Enlace',
            options: [
              { value: '_self', name: 'Misma Ventana' },
              { value: '_blank', name: 'Nueva Ventana/Pestaña' }
            ]
          },
          {
            type: 'select',
            name: 'button-type',
            label: 'Tipo de Botón',
            options: [
              { value: 'primary', name: 'Principal (Azul)' },
              { value: 'secondary', name: 'Secundario (Gris)' },
              { value: 'success', name: 'Éxito (Verde)' },
              { value: 'danger', name: 'Peligro (Rojo)' },
              { value: 'warning', name: 'Advertencia (Amarillo)' }
            ],
            changeProp: 1,
          },
          {
            type: 'select',
            name: 'button-size',
            label: 'Tamaño',
            options: [
              { value: 'small', name: 'Pequeño' },
              { value: 'medium', name: 'Mediano' },
              { value: 'large', name: 'Grande' }
            ],
            changeProp: 1,
          },
          {
            type: 'checkbox',
            name: 'full-width',
            label: 'Ancho Completo',
            changeProp: 1,
          }
        ]
      },
      init() {
        // Escuchar cambios en los traits
        this.on('change:text', this.handleTextChange);
        this.on('change:attributes:href', this.handleHrefChange);
        this.on('change:attributes:target', this.handleTargetChange);
        this.on('change:button-type', this.handleButtonTypeChange);
        this.on('change:button-size', this.handleButtonSizeChange);
        this.on('change:full-width', this.handleFullWidthChange);
      },
      handleTextChange() {
        const text = this.get('text');
        if (text) {
          this.components(text);
        }
      },
      handleHrefChange() {
        // El href ya se actualiza automáticamente como atributo
        const href = this.getAttributes().href;
        console.log('Button href changed to:', href);
      },
      handleTargetChange() {
        // El target ya se actualiza automáticamente como atributo
        const target = this.getAttributes().target;
        console.log('Button target changed to:', target);
      },
      handleButtonTypeChange() {
        const type = this.get('button-type');
        const currentClasses = this.getClasses();
        
        // Remover clases de tipo anteriores
        const typeClasses = ['bg-blue-600', 'hover:bg-blue-700', 'bg-gray-600', 'hover:bg-gray-700', 
                            'bg-green-600', 'hover:bg-green-700', 'bg-red-600', 'hover:bg-red-700',
                            'bg-yellow-500', 'hover:bg-yellow-600', 'text-black'];
        typeClasses.forEach(cls => this.removeClass(cls));
        
        // Agregar nuevas clases según el tipo
        const typeMap = {
          'primary': ['bg-blue-600', 'hover:bg-blue-700'],
          'secondary': ['bg-gray-600', 'hover:bg-gray-700'],
          'success': ['bg-green-600', 'hover:bg-green-700'],
          'danger': ['bg-red-600', 'hover:bg-red-700'],
          'warning': ['bg-yellow-500', 'hover:bg-yellow-600', 'text-black']
        };
        
        if (type && typeMap[type]) {
          typeMap[type].forEach(cls => this.addClass(cls));
        }
      },
      handleButtonSizeChange() {
        const size = this.get('button-size');
        const currentClasses = this.getClasses();
        
        // Remover clases de tamaño anteriores
        const sizeClasses = ['px-3', 'py-1', 'text-sm', 'px-6', 'py-2', 'px-8', 'py-3', 'text-lg'];
        sizeClasses.forEach(cls => this.removeClass(cls));
        
        // Agregar nuevas clases según el tamaño
        const sizeMap = {
          'small': ['px-3', 'py-1', 'text-sm'],
          'medium': ['px-6', 'py-2'],
          'large': ['px-8', 'py-3', 'text-lg']
        };
        
        if (size && sizeMap[size]) {
          sizeMap[size].forEach(cls => this.addClass(cls));
        }
      },
      handleFullWidthChange() {
        const fullWidth = this.get('full-width');
        if (fullWidth) {
          this.addClass('w-full');
          this.addClass('block');
          this.addClass('text-center');
        } else {
          this.removeClass('w-full');
          this.removeClass('block');
          this.removeClass('text-center');
        }
      }
    }
  });
  
  editor.DomComponents.addType('link', {
    model: {
      defaults: {
        name: 'Enlace',
        icon: '<i class="fa fa-link"></i>',
        editable: true
      }
    }
  });
  
  editor.DomComponents.addType('divider', {
    model: {
      defaults: {
        name: 'Divisor',
        icon: '<i class="fa fa-minus"></i>'
      }
    }
  });

  // Ocultar indicador de carga y mostrar editor
  const loadingIndicator = document.getElementById('loading-indicator');
  const editorContainer = document.getElementById('gjs');

  if (loadingIndicator) {
    loadingIndicator.style.display = 'none';
  }
  if (editorContainer) {
    editorContainer.style.display = 'block';
  }

  // Inyectar estilos en el canvas para bloquear iframes de contenido
  editor.on('load', function() {
    console.log('🎨 Editor cargado, inyectando estilos para iframes...');
    
    // Obtener el canvas frame
    const canvasFrame = editor.Canvas.getFrameEl();
    if (canvasFrame && canvasFrame.contentDocument) {
      const frameDoc = canvasFrame.contentDocument;
      
      // Crear e inyectar estilos en el head del iframe del canvas
      let styleEl = frameDoc.getElementById('iframe-blocker-styles');
      if (!styleEl) {
        styleEl = frameDoc.createElement('style');
        styleEl.id = 'iframe-blocker-styles';
        styleEl.textContent = `
          /* Bloquear eventos de clic en todos los iframes dentro del canvas */
          iframe {
            pointer-events: none !important;
          }
          
          /* Permitir hover en el contenedor de YouTube */
          [data-gjs-type="youtube-video"] {
            cursor: pointer !important;
          }
          
          .youtube-container {
            cursor: pointer !important;
          }
        `;
        frameDoc.head.appendChild(styleEl);
        console.log('✅ Estilos inyectados en el canvas para bloquear iframes');
      }
    }
  });

  // Agregar comandos personalizados
  Object.keys(editorCommands).forEach(command => {
    editor.Commands.add(command, editorCommands[command]);
  });

  // Flag para saber si estamos cargando contenido existente
  let isLoadingContent = true;
  
  // Desactivar el flag después de la carga inicial (2 segundos)
  setTimeout(() => {
    isLoadingContent = false;
    console.log('✅ Carga inicial completada, actualizaciones de layout habilitadas');
  }, 2000);

  // Evento para detectar cuando se suelta un componente en el canvas
  editor.on('block:drag:stop', function(component) {
    console.log('📦 Componente añadido al canvas');
    if (component && component.get) {
      console.log('   Tipo:', component.get('type'));
      console.log('   Nombre:', component.get('name'));
      console.log('   Selectable:', component.get('selectable'));
    }
  });

  // Función para asegurar que los estilos de bloqueo de iframe estén inyectados
  function ensureIframeBlockerStyles() {
    const canvasFrame = editor.Canvas.getFrameEl();
    if (canvasFrame && canvasFrame.contentDocument) {
      const frameDoc = canvasFrame.contentDocument;
      
      let styleEl = frameDoc.getElementById('iframe-blocker-styles');
      if (!styleEl) {
        styleEl = frameDoc.createElement('style');
        styleEl.id = 'iframe-blocker-styles';
        styleEl.textContent = `
          iframe {
            pointer-events: none !important;
          }
          [data-gjs-type="youtube-video"] {
            cursor: pointer !important;
          }
          .youtube-container {
            cursor: pointer !important;
          }
        `;
        frameDoc.head.appendChild(styleEl);
        console.log('✅ Estilos de bloqueo de iframe re-inyectados');
      }
    }
  }

  // Configurar eventos del editor
  editor.on('component:add', function (component) {
    console.log('➕ component:add disparado para:', {
      tipo: component.get('type'),
      nombre: component.get('name'),
      selectable: component.get('selectable'),
      hoverable: component.get('hoverable')
    });
    
    // Asegurar que los estilos de bloqueo de iframe estén presentes
    if (component.get('type') === 'youtube-video') {
      setTimeout(ensureIframeBlockerStyles, 100);
    }
    
    // Generar ID único para widgets que necesitan estilos independientes
    const widgetTypes = ['button', 'image', 'heading', 'paragraph', 'text', 'link', 'divider', 'icon', 'icon-box', 'youtube-video'];
    const componentType = component.get('type');
    
    if (widgetTypes.includes(componentType) || componentType === 'default') {
      // Verificar si el componente ya tiene un ID único
      let compId = component.getId();
      if (!compId || compId.startsWith('i')) {
        // Generar un ID único basado en el tipo y timestamp
        const timestamp = Date.now();
        const random = Math.floor(Math.random() * 1000);
        const widgetName = component.get('name') || componentType || 'widget';
        const uniqueId = `${widgetName.toLowerCase().replace(/\s+/g, '-')}-${timestamp}-${random}`;
        component.setId(uniqueId);
      }
    }
    
    // Si es un bloque de productos, mostrar placeholder
    if (component.get('type') === 'products-list' ||
      component.get('attributes').class === 'gjs-block-products') {
      setTimeout(showProductsPlaceholder, 100);
    }

    // Si es un bloque de navbar, verificar si la tienda virtual está habilitada
    if (component?.attributes?.tagName === 'nav') {
      console.log('navbar');
    }
    
    // Si el componente se agregó a una columna o contenedor, ocultar el placeholder
    // Solo hacer esto si NO estamos cargando contenido existente
    if (!isLoadingContent) {
      const parent = component.parent();
      if (parent) {
        const parentClasses = parent.getClasses();
        const isColumn = parentClasses.includes('column');
        const isContainer = parentClasses.includes('container-simple') || parent.get('type') === 'container';
        
        if (isColumn || isContainer) {
          // Buscar y remover el placeholder
          const placeholder = parent.components().models.find(c => 
            c.get('content')?.includes('Arrastra elementos aquí')
          );
          if (placeholder && parent.components().length > 1) {
            placeholder.remove();
            
            // Si es columna, remover borde punteado
            if (isColumn) {
              const currentClasses = parent.getClasses();
              const newClasses = currentClasses.filter(c => 
                !['border-2', 'border-dashed', 'border-gray-300', 'flex', 'items-center', 'justify-center'].includes(c)
              );
              parent.setClass(newClasses.join(' '));
            }
            
            // Si es contenedor simple, remover borde punteado también
            if (isContainer) {
              const currentClasses = parent.getClasses();
              const newClasses = currentClasses.filter(c => 
                !['border-2', 'border-dashed', 'border-gray-300'].includes(c)
              );
              parent.setClass(newClasses.join(' '));
            }
          }
        }
      }
    }
  });
  
  // Evento cuando cambia un trait (propiedad) de un componente
  // Cambiado a 'component:trait:change' para evitar ejecuciones innecesarias
  editor.on('component:trait:change', function(component) {
    // No actualizar layout durante la carga inicial para preservar contenido existente
    if (isLoadingContent) {
      return;
    }
    
    // Si es una sección, actualizar el layout de columnas
    if (component.get('tagName') === 'section') {
      updateSectionLayout(component);
    }
    
    // Si es un contenedor, actualizar el layout de columnas
    if (component.get('type') === 'container') {
      updateContainerLayout(component);
    }
  });

  // Función para actualizar el layout de columnas de una sección
  function updateSectionLayout(section) {
    const layout = section.getTrait('section-layout')?.getValue() || '1-column';
    const gap = section.getTrait('column-gap')?.getValue() || 'gap-6';
    const verticalAlign = section.getTrait('vertical-align')?.getValue() || 'items-start';
    const horizontalAlign = section.getTrait('horizontal-align')?.getValue() || 'justify-start';
    const contentWidth = section.getTrait('content-width')?.getValue() || 'container';
    
    // Buscar el contenedor interno de columnas
    const container = section.components().at(0);
    if (!container) return;
    
    const innerSection = container.components().at(0);
    if (!innerSection) return;
    
    // Actualizar clases del contenedor
    let containerClasses = `${contentWidth} mx-auto`;
    container.setClass(containerClasses);
    
    // Mapeo de layouts a clases de grid
    const layoutClasses = {
      '1-column': 'grid grid-cols-1',
      '2-columns': 'grid grid-cols-1 md:grid-cols-2',
      '2-columns-left': 'grid grid-cols-1 md:grid-cols-3',
      '2-columns-right': 'grid grid-cols-1 md:grid-cols-3',
      '3-columns': 'grid grid-cols-1 md:grid-cols-3',
      '4-columns': 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4',
      '3-columns-center': 'grid grid-cols-1 md:grid-cols-4'
    };
    
    // Aplicar clases de layout
    let gridClasses = `section-inner ${layoutClasses[layout]} ${gap} ${verticalAlign} ${horizontalAlign}`;
    innerSection.setClass(gridClasses);
    
    // Actualizar el número de columnas según el layout
    const currentColumns = innerSection.components().length;
    const targetColumns = getColumnCount(layout);
    
    if (currentColumns < targetColumns) {
      // Agregar columnas faltantes
      for (let i = currentColumns; i < targetColumns; i++) {
        innerSection.append({
          type: 'column',
          tagName: 'div',
          name: `Columna ${i + 1}`,
          attributes: { 
            class: `${getColumnClass(layout, i)} min-h-[100px] border-2 border-dashed border-gray-300 rounded-lg p-4 flex items-center justify-center`,
            'data-gjs-droppable': 'true',
            'data-gjs-draggable': 'false',
            'data-gjs-name': `Columna ${i + 1}`
          },
          droppable: true,
          components: [
            {
              type: 'text',
              tagName: 'div',
              name: 'Placeholder',
              content: `↓ Arrastra elementos aquí (Columna ${i + 1}) ↓`,
              attributes: { 
                class: 'text-gray-400 text-sm pointer-events-none',
                'data-gjs-type': 'text',
                'data-gjs-editable': 'false',
                'data-gjs-name': 'Placeholder'
              }
            }
          ]
        });
      }
    } else if (currentColumns > targetColumns) {
      // Remover columnas extra
      const columnsToRemove = currentColumns - targetColumns;
      for (let i = 0; i < columnsToRemove; i++) {
        const lastColumn = innerSection.components().at(currentColumns - 1 - i);
        if (lastColumn) lastColumn.remove();
      }
    }
    
    // Actualizar clases de columnas individuales
    innerSection.components().forEach((column, index) => {
      const baseClass = getColumnClass(layout, index);
      // Verificar si la columna tiene contenido más allá del placeholder
      const hasContent = column.components().length > 1 || 
                        (column.components().length === 1 && 
                         !column.components().at(0)?.get('content')?.includes('Arrastra elementos aquí'));
      
      // Si tiene contenido, remover el borde punteado, si no, mantenerlo
      if (hasContent) {
        column.setClass(`${baseClass} min-h-[100px] p-4`);
        // Ocultar el placeholder si existe
        const placeholder = column.components().models.find(c => 
          c.get('content')?.includes('Arrastra elementos aquí')
        );
        if (placeholder) {
          placeholder.remove();
        }
      } else {
        column.setClass(`${baseClass} min-h-[100px] border-2 border-dashed border-gray-300 rounded-lg p-4 flex items-center justify-center`);
      }
    });
  }
  
  // Función para obtener el número de columnas según el layout
  function getColumnCount(layout) {
    const columnCounts = {
      '1-column': 1,
      '2-columns': 2,
      '2-columns-left': 2,
      '2-columns-right': 2,
      '3-columns': 3,
      '4-columns': 4,
      '3-columns-center': 3
    };
    return columnCounts[layout] || 1;
  }
  
  // Función para obtener la clase CSS de cada columna según el layout
  function getColumnClass(layout, index) {
    const columnClasses = {
      '1-column': 'column',
      '2-columns': 'column',
      '2-columns-left': index === 0 ? 'column md:col-span-1' : 'column md:col-span-2',
      '2-columns-right': index === 0 ? 'column md:col-span-2' : 'column md:col-span-1',
      '3-columns': 'column',
      '4-columns': 'column',
      '3-columns-center': index === 1 ? 'column md:col-span-2' : 'column md:col-span-1'
    };
    return columnClasses[layout] || 'column';
  }

  // Función para actualizar el layout de columnas de un contenedor
  function updateContainerLayout(container) {
    const layout = container.get('container-layout') || '1-column';
    const gap = container.get('column-gap') || 'gap-6';
    const verticalAlign = container.get('vertical-align') || 'items-start';
    const horizontalAlign = container.get('horizontal-align') || 'justify-start';
    
    // Buscar el grid interno de columnas
    const innerSection = container.components().at(0);
    if (!innerSection) return;
    
    // Mapeo de layouts a clases de grid
    const layoutClasses = {
      '1-column': 'grid grid-cols-1',
      '2-columns': 'grid grid-cols-1 md:grid-cols-2',
      '2-columns-left': 'grid grid-cols-1 md:grid-cols-3',
      '2-columns-right': 'grid grid-cols-1 md:grid-cols-3',
      '3-columns': 'grid grid-cols-1 md:grid-cols-3',
      '4-columns': 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4',
      '3-columns-center': 'grid grid-cols-1 md:grid-cols-4'
    };
    
    // Aplicar clases de layout
    let gridClasses = `section-inner ${layoutClasses[layout]} ${gap} ${verticalAlign} ${horizontalAlign}`;
    innerSection.setClass(gridClasses);
    
    // Actualizar el número de columnas según el layout
    const currentColumns = innerSection.components().length;
    const targetColumns = getColumnCount(layout);
    
    if (currentColumns < targetColumns) {
      // Agregar columnas faltantes
      for (let i = currentColumns; i < targetColumns; i++) {
        innerSection.append({
          type: 'column',
          tagName: 'div',
          name: `Columna ${i + 1}`,
          attributes: { 
            class: `${getColumnClass(layout, i)} min-h-[100px] border-2 border-dashed border-gray-300 rounded-lg p-4 flex items-center justify-center`,
            'data-gjs-droppable': 'true',
            'data-gjs-draggable': 'false',
            'data-gjs-name': `Columna ${i + 1}`
          },
          droppable: true,
          components: [
            {
              type: 'text',
              tagName: 'div',
              name: 'Placeholder',
              content: `↓ Arrastra elementos aquí (Columna ${i + 1}) ↓`,
              attributes: { 
                class: 'text-gray-400 text-sm pointer-events-none',
                'data-gjs-type': 'text',
                'data-gjs-editable': 'false',
                'data-gjs-name': 'Placeholder'
              }
            }
          ]
        });
      }
    } else if (currentColumns > targetColumns) {
      // Remover columnas extra
      const columnsToRemove = currentColumns - targetColumns;
      for (let i = 0; i < columnsToRemove; i++) {
        const lastColumn = innerSection.components().at(currentColumns - 1 - i);
        if (lastColumn) lastColumn.remove();
      }
    }
    
    // Actualizar clases de columnas individuales
    innerSection.components().forEach((column, index) => {
      const baseClass = getColumnClass(layout, index);
      // Verificar si la columna tiene contenido más allá del placeholder
      const hasContent = column.components().length > 1 || 
                        (column.components().length === 1 && 
                         !column.components().at(0)?.get('content')?.includes('Arrastra elementos aquí'));
      
      // Si tiene contenido, remover el borde punteado, si no, mantenerlo
      if (hasContent) {
        column.setClass(`${baseClass} min-h-[100px] p-4`);
        // Ocultar el placeholder si existe
        const placeholder = column.components().models.find(c => 
          c.get('content')?.includes('Arrastra elementos aquí')
        );
        if (placeholder) {
          placeholder.remove();
        }
      } else {
        column.setClass(`${baseClass} min-h-[100px] border-2 border-dashed border-gray-300 rounded-lg p-4 flex items-center justify-center`);
      }
    });
  }
  
  // Hacer la función disponible globalmente para los manejadores de traits
  window.updateContainerLayout = updateContainerLayout;

  // Evento cuando se hace hover sobre un componente
  editor.on('component:hover', function (component) {
    // Asegurarse de que el componente tenga un nombre descriptivo
    if (!component.get('name') || component.get('name') === 'Div' || component.get('name') === 'Default') {
      const type = component.get('type');
      const tagName = component.get('tagName');
      
      // Asignar nombres descriptivos basados en el tipo o tagName
      const nameMap = {
        'text': 'Texto',
        'image': 'Imagen',
        'button': 'Botón',
        'link': 'Enlace',
        'heading': 'Título',
        'paragraph': 'Párrafo',
        'divider': 'Divisor',
        'section': 'Sección',
        'container': 'Contenedor',
        'column': 'Columna',
        'icon': 'Icono',
        'icon-box': 'Caja de Icono',
        'youtube-video': 'YouTube',
        'carousel': 'Carrusel',
        'gallery': 'Galería'
      };
      
      const tagNameMap = {
        'h1': 'Título H1',
        'h2': 'Título H2',
        'h3': 'Título H3',
        'h4': 'Título H4',
        'h5': 'Título H5',
        'h6': 'Título H6',
        'p': 'Párrafo',
        'a': 'Enlace',
        'img': 'Imagen',
        'button': 'Botón',
        'section': 'Sección',
        'nav': 'Navegación',
        'footer': 'Footer',
        'header': 'Header',
        'form': 'Formulario',
        'input': 'Campo de Entrada',
        'textarea': 'Área de Texto',
        'label': 'Etiqueta',
        'hr': 'Divisor'
      };
      
      const newName = nameMap[type] || tagNameMap[tagName] || (tagName ? tagName.toUpperCase() : 'Elemento');
      component.set('name', newName);
    }
  });
  
  // Evento para forzar selección de carrusel y galería cuando se detecte
  editor.on('component:add', function (component) {
    if (component.get('type') === 'carousel') {
      console.log('🎠 Carrusel detectado, configurando selección...');
      
      // Forzar que sea seleccionable
      component.set({
        selectable: true,
        hoverable: true,
        editable: true
      });
      
      // Agregar evento de clic después de un breve delay
      setTimeout(() => {
        if (component.view && component.view.el) {
          component.view.el.addEventListener('click', (e) => {
            e.stopPropagation();
            console.log('🖱️ Clic en carrusel - seleccionando');
            editor.select(component);
          });
          component.view.el.style.cursor = 'pointer';
          console.log('✅ Evento de clic agregado al carrusel');
        }
      }, 100);
    }
    
    if (component.get('type') === 'gallery') {
      console.log('🖼️ Galería detectada, configurando selección...');
      
      // Forzar que sea seleccionable
      component.set({
        selectable: true,
        hoverable: true,
        editable: true
      });
      
      // Agregar evento de clic después de un breve delay
      setTimeout(() => {
        if (component.view && component.view.el) {
          component.view.el.addEventListener('click', (e) => {
            e.stopPropagation();
            console.log('🖱️ Clic en galería - seleccionando');
            editor.select(component);
          });
          component.view.el.style.cursor = 'pointer';
          console.log('✅ Evento de clic agregado a la galería');
        }
      }, 100);
    }
  });

  // Evento cuando se selecciona un componente
  editor.on('component:selected', function (component) {
    console.log('🎯 COMPONENTE SELECCIONADO:', {
      tipo: component.get('type'),
      nombre: component.get('name'),
      tagName: component.get('tagName'),
      id: component.getId(),
      classes: component.getClasses(),
      attributes: component.getAttributes(),
      traits: component.get('traits'),
      cantidadTraits: component.get('traits')?.length || 0
    });
    
    // Debug específico para carrusel
    if (component.get('type') === 'carousel') {
      console.log('🎠 CARRUSEL SELECCIONADO - Usando TraitManager estándar...');
      console.log('📋 Traits actuales:', component.get('traits'));
      console.log('📋 getTraits() disponible:', typeof component.getTraits);
      
      // Usar el TraitManager estándar de GrapesJS
      setTimeout(() => {
        if (editor.TraitManager) {
          editor.TraitManager.setTarget(component);
          editor.TraitManager.render();
          console.log('🔄 TraitManager actualizado para Carrusel');
          
          // Verificar si los traits se renderizaron
          const traitsInContainer = document.querySelectorAll('.traits-container .gjs-trt-trait');
          console.log('📋 Traits renderizados:', traitsInContainer.length);
        }
      }, 100);
    }
    
    // Asegurarse de que el componente tenga un nombre descriptivo
    if (!component.get('name') || component.get('name') === 'Div' || component.get('name') === 'Default') {
      const type = component.get('type');
      const tagName = component.get('tagName');
      
      const nameMap = {
        'text': 'Texto',
        'image': 'Imagen',
        'button': 'Botón',
        'link': 'Enlace',
        'heading': 'Título',
        'paragraph': 'Párrafo',
        'divider': 'Divisor',
        'section': 'Sección',
        'container': 'Contenedor',
        'column': 'Columna',
        'icon': 'Icono',
        'icon-box': 'Caja de Icono',
        'youtube-video': 'YouTube',
        'carousel': 'Carrusel',
        'gallery': 'Galería'
      };
      
      const tagNameMap = {
        'h1': 'Título H1',
        'h2': 'Título H2',
        'h3': 'Título H3',
        'h4': 'Título H4',
        'h5': 'Título H5',
        'h6': 'Título H6',
        'p': 'Párrafo',
        'a': 'Enlace',
        'img': 'Imagen',
        'button': 'Botón',
        'section': 'Sección',
        'nav': 'Navegación',
        'footer': 'Footer',
        'header': 'Header',
        'form': 'Formulario',
        'input': 'Campo de Entrada',
        'textarea': 'Área de Texto',
        'label': 'Etiqueta',
        'hr': 'Divisor'
      };
      
      const newName = nameMap[type] || tagNameMap[tagName] || (tagName ? tagName.toUpperCase() : 'Elemento');
      component.set('name', newName);
    }
    
    // Debug para componentes especiales
    const componentType = component.get('type');
    
    // YouTube
    if (componentType === 'youtube-video') {
      console.log('📺 Componente de YouTube seleccionado:', {
        tipo: componentType,
        nombre: component.get('name'),
        traits: component.get('traits'),
        cantidadTraits: component.get('traits')?.length || 0,
        seleccionable: component.get('selectable'),
        removable: component.get('removable'),
        draggable: component.get('draggable')
      });
      
      // Forzar la actualización del TraitManager para YouTube
      setTimeout(() => {
        if (editor.TraitManager) {
          editor.TraitManager.render();
          console.log('🔄 TraitManager actualizado para YouTube');
          
          // Verificar si los traits se renderizaron
          const traitsInContainer = document.querySelectorAll('.traits-container .gjs-trt-trait');
          console.log('📋 Traits renderizados:', traitsInContainer.length);
        }
      }, 100);
    }
    
    // Imagen
    if (componentType === 'image') {
      console.log('🖼️ Componente de Imagen seleccionado:', {
        tipo: componentType,
        nombre: component.get('name'),
        src: component.get('src'),
        alt: component.get('alt'),
        traits: component.get('traits'),
        cantidadTraits: component.get('traits')?.length || 0
      });
      
      // Forzar la actualización del TraitManager para Imagen
      setTimeout(() => {
        if (editor.TraitManager) {
          editor.TraitManager.render();
          console.log('🔄 TraitManager actualizado para Imagen');
          
          // Verificar si los traits se renderizaron
          const traitsInContainer = document.querySelectorAll('.traits-container .gjs-trt-trait');
          console.log('📋 Traits renderizados:', traitsInContainer.length);
        }
      }, 100);
    }
    
    // Carrusel
    if (componentType === 'carousel') {
      console.log('🎠 Componente de Carrusel seleccionado:', {
        tipo: componentType,
        nombre: component.get('name'),
        traits: component.get('traits'),
        cantidadTraits: component.get('traits')?.length || 0
      });
      
      // Para carrusel, NO usar el TraitManager estándar para evitar conflictos
      // El sistema personalizado ya se ejecutó arriba
      console.log('🎠 Carrusel: Saltando TraitManager estándar para evitar conflictos con sistema personalizado');
    }
    
    // Galería
    if (componentType === 'gallery') {
      console.log('🖼️ Componente de Galería seleccionado:', {
        tipo: componentType,
        nombre: component.get('name'),
        traits: component.get('traits'),
        cantidadTraits: component.get('traits')?.length || 0
      });
      
      // Sincronizar URLs si el componente tiene el método
      if (component.syncImageUrls) {
        component.syncImageUrls();
      }
      
      // Forzar la actualización del TraitManager para Galería
      setTimeout(() => {
        if (editor.TraitManager) {
          editor.TraitManager.render();
          console.log('🔄 TraitManager actualizado para Galería');
          
          const traitsInContainer = document.querySelectorAll('.traits-container .gjs-trt-trait');
          console.log('📋 Traits renderizados:', traitsInContainer.length);
          
          // Verificar si aparecieron los campos de imagen
          const imageFields = document.querySelectorAll('.traits-container input[placeholder*="imagen"]');
          console.log('🖼️ Campos de imagen encontrados:', imageFields.length);
        }
      }, 100);
    }
    
    // Cambiar automáticamente al panel de Propiedades
    const traitsTab = document.querySelector('[data-panel="traits"]');
    if (traitsTab && !traitsTab.classList.contains('active')) {
      traitsTab.click();
    }
    
    // Ocultar mensaje de "No hay elemento seleccionado"
    const noWidgetMsg = document.getElementById('no-widget-selected');
    if (noWidgetMsg) {
      noWidgetMsg.style.display = 'none';
    }
    
    // Mostrar contenedor de traits
    const traitsContainer = document.querySelector('.traits-container');
    if (traitsContainer) {
      traitsContainer.style.display = 'block';
    }
    
    // Forzar actualización del TraitManager para todos los componentes
    setTimeout(() => {
      if (editor.TraitManager) {
        editor.TraitManager.render();
      }
    }, 50);
    
    // Configurar el selector para usar el ID del componente (estilos únicos)
    const widgetTypes = ['button', 'image', 'heading', 'paragraph', 'text', 'link', 'divider', 'icon', 'icon-box', 'section', 'container', 'column', 'youtube-video'];
    
    // Obtener selectores actuales
    const currentSelectors = component.getSelectors ? component.getSelectors() : null;
    const currentSelectorsCount = currentSelectors ? currentSelectors.length : 0;
    
    console.log('🔍 Componente seleccionado:', {
      tipo: componentType,
      id: component.getId(),
      cantidadSelectores: currentSelectorsCount,
      selectoresActuales: currentSelectors?.map(s => ({
        name: s.get('name'),
        type: s.get('type')
      }))
    });
    
    //Asegurar que el componente tenga un ID único
    let componentId = component.getId();
    
    // Si el componente no tiene ID o es autogenerado, crear uno personalizado
    if (!componentId || componentId.startsWith('i')) {
      const customId = `${componentType || 'element'}-${Date.now()}-${Math.floor(Math.random() * 1000)}`;
      component.addAttributes({ id: customId });
      componentId = customId;
      console.log('🆔 ID personalizado asignado:', customId);
    }
    
    // Intentar configurar selectores solo si el componente lo soporta
    if (component.setSelectors && typeof component.setSelectors === 'function') {
      if (widgetTypes.includes(componentType) || componentType === 'default') {
        const sm = editor.SelectorManager;
        
        try {
          // Crear un selector de ID
          let idSelector = sm.get(`#${componentId}`);
          if (!idSelector) {
            idSelector = sm.add({ name: componentId, type: 2 }); // type: 2 = ID
          }
          
          // FORZAR el uso SOLO del selector de ID (limpiar todos los demás)
          component.setSelectors([idSelector]);
          
          console.log('✅ Selector de ID configurado:', {
            componentId: componentId,
            selectorName: idSelector.get('name'),
            selectorType: idSelector.get('type'),
            selectoresAnteriores: currentSelectorsCount,
            selectoresNuevos: component.getSelectors().length
          });
        } catch (error) {
          console.error('❌ Error al configurar selectores:', error);
        }
      }
    } else {
      // Para componentes que no soportan setSelectors (como links/buttons)
      // Forzar que los estilos se apliquen mediante reglas CSS directas con su ID
      console.log('ℹ️ Componente sin setSelectors, usando ID para estilos:', {
        tipo: componentType,
        id: componentId,
        cantidadSelectores: currentSelectorsCount
      });
      
      // Configurar el StyleManager para usar el ID del componente
      const sm = editor.StyleManager;
      const rule = editor.Css.getRule(`#${componentId}`);
      if (!rule) {
        editor.Css.setRule(`#${componentId}`, {});
      }
    }
    
    // Refrescar el StyleManager para mostrar los estilos actuales del componente
    // Esto SIEMPRE debe ejecutarse para mostrar el panel de estilos
    if (editor.StyleManager) {
      editor.StyleManager.render();
      console.log('🔄 StyleManager actualizado para el componente');
    }

    // Forzar actualización del StyleManager cuando se selecciona un componente
    setTimeout(() => {
      if (editor.StyleManager) {
        // Forzar renderizado completo del StyleManager
        editor.StyleManager.render();
        
        // Obtener los contenedores
        const stylesContainer = document.querySelector('.styles-container');
        const stylesContainerWidget = document.querySelector('.styles-container-widget');
        
        console.log('📋 Contenedores encontrados:', {
          stylesContainer: !!stylesContainer,
          stylesContainerWidget: !!stylesContainerWidget
        });
        
        if (stylesContainer && stylesContainerWidget) {
          // Esperar a que el StyleManager se haya renderizado completamente
          setTimeout(() => {
            // Buscar el contenedor completo del StyleManager
            const smContainer = stylesContainer.querySelector('.gjs-sm-sectors') || 
                               stylesContainer.querySelector('[data-gjs-type="sectors"]') ||
                               stylesContainer.firstElementChild;
            
            console.log('🔍 Buscando StyleManager en .styles-container:', !!smContainer);
            
            if (smContainer) {
              const sectorsCount = smContainer.querySelectorAll('.gjs-sm-sector').length;
              console.log('✅ StyleManager renderizado con', sectorsCount, 'sectores');
              
              // Limpiar el contenedor de widgets
              stylesContainerWidget.innerHTML = '';
              
              // MOVER (no clonar) el contenedor completo para mantener toda la funcionalidad
              stylesContainerWidget.appendChild(smContainer);
              
              console.log('✅ StyleManager movido al contenedor visible con funcionalidad completa');
            } else {
              console.warn('⚠️ No se encontró el StyleManager en .styles-container');
              console.log('Contenido de .styles-container:', stylesContainer.innerHTML.substring(0, 200));
            }
          }, 200);
        } else {
          console.error('❌ No se encontraron los contenedores necesarios');
        }
      }
    }, 150);
  });

  // Evento cuando se deselecciona un componente
  editor.on('component:deselected', function (component) {
    // Mostrar mensaje de "No hay elemento seleccionado" solo si no hay nada seleccionado
    setTimeout(() => {
      const selected = editor.getSelected();
      if (!selected) {
        const noWidgetMsg = document.getElementById('no-widget-selected');
        const traitsContainer = document.querySelector('.traits-container');
        if (noWidgetMsg) {
          noWidgetMsg.style.display = 'flex';
        }
        if (traitsContainer) {
          traitsContainer.style.display = 'none';
        }
      }
    }, 50);
  });
  
  // === EVENTOS PARA RASTREAR CAMBIOS DE ESTILOS ===
  
  // Evento cuando cambia cualquier propiedad de estilo (informativo solamente)
  editor.on('styleable:change', function(property, value) {
    const selected = editor.getSelected();
    const componentId = selected?.getId();
    
    // Solo log informativo, la aplicación real se hace en el listener de change:value
    console.log('🎨 EVENTO ESTILO:', {
      propiedad: property.get ? property.get('property') : 'desconocido',
      valor: value,
      componente: selected?.get('type'),
      componenteId: componentId
    });
  });
  
  // Evento cuando se actualiza un componente (incluye cambios de estilo)
  editor.on('component:update', function(component) {
    const componentType = component.get('type');
    const componentId = component.getId();
    
    console.log('🔄 COMPONENTE ACTUALIZADO:', {
      id: componentId,
      tipo: componentType,
      estilos: component.getStyle(),
      atributos: component.getAttributes()
    });
  });
  
  // Evento cuando cambia el estilo de un componente específico
  editor.on('component:styleUpdate', function(component) {
    const componentId = component.getId();
    const styles = component.getStyle();
    
    console.log('✨ ESTILO ACTUALIZADO EN COMPONENTE:', {
      id: componentId,
      tipo: component.get('type'),
      estilosAplicados: styles
    });
    
    // Verificar que el CSS se haya generado correctamente
    setTimeout(() => {
      const css = editor.getCss();
      const cssForComponent = css.match(new RegExp(`#${componentId}[^{]*{[^}]*}`, 'g'));
      
      if (cssForComponent) {
        console.log('✅ CSS GENERADO PARA EL COMPONENTE:', cssForComponent);
      } else {
        console.warn('⚠️ No se encontró CSS para el componente #' + componentId);
        console.log('📄 CSS completo:', css.substring(0, 500));
      }
    }, 100);
  });
  
  // Evento cuando se añade una regla CSS
  editor.on('style:custom', function(props) {
    console.log('📝 REGLA CSS AÑADIDA:', props);
  });
  
  // Listener para detectar cambios en el StyleManager
  editor.on('style:target', function(target) {
    console.log('🎯 TARGET DE ESTILOS CAMBIADO:', {
      target: target,
      selector: target?.getSelectors?.().map(s => s.get('name'))
    });
  });
  
  // Listener para cambios en las propiedades del StyleManager
  try {
    const sectors = editor.StyleManager.getSectors();
    sectors.each(sector => {
      const properties = sector.get('properties');
      if (properties) {
        properties.each(property => {
          property.on('change:value', function() {
            const selected = editor.getSelected();
            if (!selected) return;
            
            const selectors = selected.getSelectors ? selected.getSelectors() : null;
            const componentId = selected.getId();
            const propertyName = property.get('property');
            const propertyValue = property.getValue();
            
            const selectorDetails = selectors?.map(s => ({
              name: s.get('name'),
              type: s.get('type'),
              label: s.get('label')
            }));
            
            console.log('💅 PROPIEDAD DE ESTILO MODIFICADA:', {
              propiedad: propertyName,
              valorNuevo: propertyValue,
              componente: selected.get('type'),
              componenteId: componentId,
              cantidadSelectores: selectors?.length || 0,
              selectoresDetallados: selectorDetails,
              estilosActuales: selected.getStyle ? selected.getStyle() : {}
            });
            
            // FORZAR APLICACIÓN DEL ESTILO DIRECTAMENTE AL CSS CON EL ID  
            // Usar !important para sobrescribir estilos de Tailwind
            if (componentId && propertyName && propertyValue) {
              try {
                // Obtener o crear la regla CSS para este ID
                let cssRule = editor.Css.getRule(`#${componentId}`);
                if (!cssRule) {
                  cssRule = editor.Css.setRule(`#${componentId}`, {});
                }
                
                // Aplicar la propiedad directamente a la regla CSS
                const currentStyles = cssRule.getStyle() || {};
                
                // Si es un valor numérico sin unidad y es una propiedad de tamaño, agregar px
                let finalValue = propertyValue;
                const sizeProperties = ['margin', 'margin-top', 'margin-right', 'margin-bottom', 'margin-left', 
                                       'padding', 'padding-top', 'padding-right', 'padding-bottom', 'padding-left',
                                       'width', 'height', 'font-size', 'border-width'];
                
                if (sizeProperties.includes(propertyName) && !isNaN(propertyValue) && propertyValue !== '') {
                  finalValue = `${propertyValue}px`;
                }
                
                // NOTA: NO agregar !important aquí porque GrapeJS lo remueve al hacer getCss()
                // En su lugar, lo agregaremos al guardar
                currentStyles[propertyName] = finalValue;
                cssRule.setStyle(currentStyles);
                
                // TAMBIÉN aplicar el estilo como inline para asegurar que se vea en el editor
                // y para aumentar la especificidad en la vista pública
                try {
                  const componentModel = editor.DomComponents.getWrapper().find(`#${componentId}`)[0];
                  if (componentModel && componentModel.view && componentModel.view.el) {
                    const camelProp = propertyName.replace(/-([a-z])/g, (g) => g[1].toUpperCase());
                    componentModel.view.el.style[camelProp] = finalValue;
                    console.log('✅ Estilo aplicado como inline también:', {
                      componente: componentId,
                      propiedad: propertyName,
                      valor: finalValue
                    });
                  }
                } catch (inlineError) {
                  console.warn('⚠️ No se pudo aplicar estilo inline:', inlineError);
                }
                
                const cssForComponent = editor.getCss().match(new RegExp(`#${componentId.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')}[^{]*\\{[^}]*\\}`, 'g'));
                
                console.log('✅ ESTILO FORZADO AL CSS:', {
                  selector: `#${componentId}`,
                  propiedad: propertyName,
                  valorOriginal: propertyValue,
                  valorFinal: finalValue,
                  cssDelComponente: cssForComponent ? cssForComponent[0] : 'No encontrado'
                });
                
                // Log adicional para debugging
                if (cssForComponent) {
                  console.log('📋 CSS completo del botón:', cssForComponent[0]);
                }
                
                // Forzar actualización del canvas
                editor.trigger('change:canvasOffset');
              } catch (error) {
                console.error('❌ Error al forzar estilo al CSS:', error);
              }
            }
            
            // Si hay múltiples selectores y soporta setSelectors, limpiar
            if (selectors && selectors.length > 1 && selected.setSelectors && typeof selected.setSelectors === 'function') {
              console.warn('⚠️ Componente tiene múltiples selectores, limpiando...');
              const sm = editor.SelectorManager;
              
              try {
                let idSelector = sm.get(`#${componentId}`);
                if (!idSelector) {
                  idSelector = sm.add({ name: componentId, type: 2 });
                }
                
                selected.setSelectors([idSelector]);
                console.log('✅ Selectores limpiados');
              } catch (error) {
                console.error('❌ Error al limpiar selectores:', error);
              }
            }
          });
        });
      }
    });
    console.log('✅ Listeners de propiedades de estilo configurados');
  } catch (error) {
    console.warn('⚠️ No se pudieron configurar los listeners de propiedades:', error);
  }

  // Cargar contenido existente si existe
  const existingHtml = document.getElementById('page-html-content')?.value;
  const existingCss = document.getElementById('page-css-content')?.value;

  // Función para decodificar entidades HTML
  function decodeHtml(html) {
    const txt = document.createElement('textarea');
    txt.innerHTML = html;
    return txt.value;
  }

  if (existingHtml && existingCss) {
    editor.setComponents(decodeHtml(existingHtml));
    editor.setStyle(decodeHtml(existingCss));
  } else if (existingHtml) {
    editor.setComponents(decodeHtml(existingHtml));
  }
  
  // Función para asignar nombres descriptivos a componentes existentes
  function assignDescriptiveNames() {
    try {
      const allComponents = editor.DomComponents.getWrapper().find('*');
      
      allComponents.forEach(component => {
        const currentName = component.get('name');
        if (!currentName || currentName === 'Div' || currentName === 'Default' || currentName === 'Box') {
          const type = component.get('type');
          const tagName = component.get('tagName');
          
          const nameMap = {
            'text': 'Texto',
            'image': 'Imagen',
            'button': 'Botón',
            'link': 'Enlace',
            'heading': 'Título',
            'paragraph': 'Párrafo',
            'divider': 'Divisor',
            'section': 'Sección',
            'container': 'Contenedor',
            'column': 'Columna',
            'icon': 'Icono',
            'icon-box': 'Caja de Icono',
            'youtube-video': 'YouTube'
          };
          
          const tagNameMap = {
            'h1': 'Título H1',
            'h2': 'Título H2',
            'h3': 'Título H3',
            'h4': 'Título H4',
            'h5': 'Título H5',
            'h6': 'Título H6',
            'p': 'Párrafo',
            'a': 'Enlace',
            'img': 'Imagen',
            'button': 'Botón',
            'section': 'Sección',
            'nav': 'Navegación',
            'footer': 'Footer',
            'header': 'Header',
            'form': 'Formulario',
            'input': 'Campo de Entrada',
            'textarea': 'Área de Texto',
            'label': 'Etiqueta',
            'hr': 'Divisor',
            'div': 'Contenedor'
          };
          
          const newName = nameMap[type] || tagNameMap[tagName] || (tagName ? tagName.toUpperCase() : 'Elemento');
          component.set('name', newName);
        }
      });
      
      // Actualizar Layer Manager
      if (editor.LayerManager) {
        editor.LayerManager.render();
      }
      
      console.log('✅ Nombres descriptivos asignados a todos los componentes');
    } catch (error) {
      console.error('❌ Error asignando nombres descriptivos:', error);
    }
  }
  
  // Ejecutar después de cargar el contenido
  setTimeout(assignDescriptiveNames, 500);

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

  // Función para agregar !important a los estilos de IDs personalizados
  function addImportantToCustomIds(css) {
    console.log('🔧 PROCESANDO CSS PARA AGREGAR !IMPORTANT');
    console.log('📥 CSS Original length:', css.length);
    
    // Buscar todas las reglas CSS de IDs personalizados (formato: tipo-timestamp-random o element-timestamp-random)
    const regex = /#([a-z\-]+-\d+(?:-\d+)?)\s*\{([^}]+)\}/g;
    
    let modifiedCss = css.replace(regex, function(match, id, styles) {
      console.log(`🎯 Procesando ID: #${id}`);
      console.log(`  Estilos originales: ${styles.substring(0, 200)}`);
      
      // Dividir los estilos en propiedades individuales
      const properties = styles.split(';').map(prop => prop.trim()).filter(prop => prop);
      
      // Agregar !important a cada propiedad que no lo tenga
      const importantProps = properties.map(prop => {
        if (!prop.includes('!important') && prop.includes(':')) {
          const [property, ...valueParts] = prop.split(':');
          const value = valueParts.join(':').trim(); // Por si el valor tiene ':'
          const newProp = `${property.trim()}:${value} !important`;
          console.log(`    ✅ ${property.trim()}: ${value} → ${value} !important`);
          return newProp;
        }
        return prop;
      });
      
      const result = `#${id}{${importantProps.join(';')};}`;
      console.log(`  📤 Estilos modificados: ${result.substring(0, 200)}`);
      return result;
    });
    
    console.log('📤 CSS Modificado length:', modifiedCss.length);
    console.log('✨ Total de reglas procesadas:', (modifiedCss.match(regex) || []).length);
    
    return modifiedCss;
  }
  
  // Configurar botón de guardar
  document.getElementById('save-btn')?.addEventListener('click', function () {
    // Antes de obtener el HTML, asegurar que todos los componentes con estilos personalizados
    // tengan sus estilos aplicados como inline
    console.log('🔄 SINCRONIZANDO ESTILOS ANTES DE GUARDAR...');
    const allComponents = editor.DomComponents.getWrapper().find('*');
    let componentsWithStyles = 0;
    
    allComponents.forEach(comp => {
      const compId = comp.getId();
      // Solo procesar componentes con IDs personalizados (formato: tipo-timestamp-random)
      if (compId && compId.match(/^[a-z\-]+-\d+(?:-\d+)?$/)) {
        const cssRule = editor.Css.getRule(`#${compId}`);
        if (cssRule) {
          const styles = cssRule.getStyle();
          if (styles && Object.keys(styles).length > 0) {
            // Aplicar cada estilo como inline
            comp.addStyle(styles);
            componentsWithStyles++;
            console.log(`  ✅ Estilos sincronizados para #${compId}:`, Object.keys(styles));
          }
        }
      }
    });
    
    console.log(`✨ Total de componentes con estilos sincronizados: ${componentsWithStyles}`);
    
    const htmlContent = editor.getHtml();
    let cssContent = editor.getCss();
    
    console.log('💾 GUARDANDO PÁGINA:');
    console.log('📄 HTML (primeros 1000 chars):', htmlContent.substring(0, 1000));
    console.log('🎨 CSS ORIGINAL:', cssContent);
    
    // Verificar IDs personalizados en el CSS
    const customIDs = cssContent.match(/#[a-z\-]+-\d+(?:-\d+)?/g);
    console.log('🆔 IDs personalizados encontrados en CSS:', customIDs);
    
    // Verificar estilos inline en el HTML
    const inlineStylesCount = (htmlContent.match(/style="/g) || []).length;
    console.log('🎨 Componentes con estilos inline en HTML:', inlineStylesCount);
    
    // Verificar si hay iframes de YouTube en el HTML
    const youtubeIframes = htmlContent.match(/<iframe[^>]*youtube[^>]*>/gi);
    if (youtubeIframes) {
      console.log('📺 YouTube iframes encontrados:', youtubeIframes.length);
      youtubeIframes.forEach((iframe, index) => {
        console.log(`  ${index + 1}. ${iframe}`);
      });
    } else {
      console.log('⚠️ NO se encontraron iframes de YouTube en el HTML');
    }
    
    // Buscar el contenedor específico en el HTML
    const containerMatch = htmlContent.match(/id="element-1761617610642-720"[^>]*>/);
    if (containerMatch) {
      console.log('🔍 Contenedor encontrado en HTML:', containerMatch[0]);
      const hasInlineStyle = containerMatch[0].includes('style=');
      console.log('  ✅ Tiene estilos inline:', hasInlineStyle);
    }
    
    // Agregar !important a los estilos de IDs personalizados
    cssContent = addImportantToCustomIds(cssContent);
    
    console.log('🎨 CSS CON !IMPORTANT:', cssContent);
    console.log('📊 Total CSS caracteres:', cssContent.length);

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
// Funciones globales para editar y eliminar imágenes del carrusel
window.editImage = function(slideNum) {
  console.log('🖼️ Editando imagen del slide:', slideNum);
  
  const editor = window.editor;
  if (!editor) {
    console.error('❌ Editor no disponible');
    return;
  }
  
  const component = editor.getSelected();
  if (!component) {
    console.error('❌ No hay componente seleccionado');
    return;
  }
  
  // Abrir el Asset Manager
  const am = editor.AssetManager;
  const modal = editor.Modal;
  
  // Configurar el callback cuando se seleccione una imagen
  am.onClick((asset) => {
    const newSrc = asset.get('src');
    console.log('🎠 Nueva imagen seleccionada para slide', slideNum, ':', newSrc);
    
    // Encontrar el contenedor del carrusel
    const carouselContainer = component.view.el.querySelector('.carousel-container') || 
                            component.view.el.querySelector('.carousel') || 
                            component.view.el;
    
    // Buscar la imagen específica del slide
    const existingImages = carouselContainer.querySelectorAll('.carousel-slide img') || 
                         carouselContainer.querySelectorAll('img') ||
                         [];
    
    if (existingImages[slideNum - 1]) {
      // Actualizar la imagen existente
      existingImages[slideNum - 1].src = newSrc;
      existingImages[slideNum - 1].setAttribute('src', newSrc);
      
      // Guardar en el componente
      component.set(`slide-${slideNum}`, newSrc);
      
      console.log(`✅ Slide ${slideNum} actualizado con nueva imagen`);
    } else {
      console.error(`❌ No se encontró el slide ${slideNum}`);
    }
    
    // Cerrar el modal
    modal.close();
    
    // Actualizar traits personalizados para mostrar la nueva imagen
    if (window.renderCustomTraits) {
      window.renderCustomTraits(component);
    }
  });
  
  // Mostrar el Asset Manager en un modal
  modal.setTitle(`Editar Imagen del Slide ${slideNum}`)
    .setContent(am.render())
    .open();
};

window.deleteImage = function(slideNum) {
  console.log('🗑️ Eliminando imagen del slide:', slideNum);
  
  // Confirmar eliminación
  if (!confirm(`¿Estás seguro de que quieres eliminar la imagen del slide ${slideNum}?`)) {
    return;
  }
  
  const editor = window.editor;
  if (!editor) {
    console.error('❌ Editor no disponible');
    return;
  }
  
  const component = editor.getSelected();
  if (!component) {
    console.error('❌ No hay componente seleccionado');
    return;
  }
  
  // Encontrar el contenedor del carrusel
  const carouselContainer = component.view.el.querySelector('.carousel-container') || 
                          component.view.el.querySelector('.carousel') || 
                          component.view.el;
  
  // Buscar la imagen específica del slide
  const existingImages = carouselContainer.querySelectorAll('.carousel-slide img') || 
                       carouselContainer.querySelectorAll('img') ||
                       [];
  
  if (existingImages[slideNum - 1]) {
    // Reemplazar con imagen placeholder
    const placeholderSrc = `https://via.placeholder.com/800x400?text=Slide+${slideNum}`;
    existingImages[slideNum - 1].src = placeholderSrc;
    existingImages[slideNum - 1].setAttribute('src', placeholderSrc);
    
    // Limpiar del componente
    component.unset(`slide-${slideNum}`);
    
    console.log(`✅ Slide ${slideNum} eliminado (reemplazado con placeholder)`);
  } else {
    console.error(`❌ No se encontró el slide ${slideNum}`);
  }
  
  // Actualizar traits personalizados para ocultar la imagen eliminada
  if (window.renderCustomTraits) {
    window.renderCustomTraits(component);
  }
};

window.initializeEditor = initializeEditor;
window.showProductsPlaceholder = showProductsPlaceholder;
window.initializeManagers = initializeManagers;