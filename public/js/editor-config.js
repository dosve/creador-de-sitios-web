// Configuración del Editor GrapeJS
// Este archivo contiene toda la configuración y funcionalidades del editor
// NOTA: Algunos módulos se han movido a editor-modules/ para mejor organización

// Configuración principal de GrapeJS
// Si existe el módulo EditorConfig, usarlo; si no, usar configuración inline
const editorConfig = (typeof EditorConfig !== 'undefined' && EditorConfig.getConfig)
  ? EditorConfig.getConfig()
  : {
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
// Si existe el módulo EditorCommands, usarlo; si no, usar comandos inline
const editorCommands = (typeof EditorCommands !== 'undefined' && EditorCommands.getCommands)
  ? EditorCommands.getCommands()
  : {
    'set-device-desktop': {
      run: editor => {
        editor.setDevice('Desktop');
        // Actualizar etiquetas de traits después de cambiar dispositivo
        setTimeout(() => {
          if (typeof window.updateTraitLabelsForDevice === 'function') {
            window.updateTraitLabelsForDevice();
          }
          // Actualizar TraitManager si hay un componente seleccionado
          const selected = editor.getSelected();
          if (selected && editor.TraitManager) {
            editor.TraitManager.render();
            setTimeout(() => {
              if (typeof window.updateTraitLabelsForDevice === 'function') {
                window.updateTraitLabelsForDevice();
              }
            }, 100);
          }
        }, 100);
      }
    },
    'set-device-tablet': {
      run: editor => {
        editor.setDevice('Tablet');
        // Actualizar etiquetas de traits después de cambiar dispositivo
        setTimeout(() => {
          if (typeof window.updateTraitLabelsForDevice === 'function') {
            window.updateTraitLabelsForDevice();
          }
          // Actualizar TraitManager si hay un componente seleccionado
          const selected = editor.getSelected();
          if (selected && editor.TraitManager) {
            editor.TraitManager.render();
            setTimeout(() => {
              if (typeof window.updateTraitLabelsForDevice === 'function') {
                window.updateTraitLabelsForDevice();
              }
            }, 100);
          }
        }, 100);
      }
    },
    'set-device-mobile': {
      run: editor => {
        editor.setDevice('Mobile');
        // Actualizar etiquetas de traits después de cambiar dispositivo
        setTimeout(() => {
          if (typeof window.updateTraitLabelsForDevice === 'function') {
            window.updateTraitLabelsForDevice();
          }
          // Actualizar TraitManager si hay un componente seleccionado
          const selected = editor.getSelected();
          if (selected && editor.TraitManager) {
            editor.TraitManager.render();
            setTimeout(() => {
              if (typeof window.updateTraitLabelsForDevice === 'function') {
                window.updateTraitLabelsForDevice();
              }
            }, 100);
          }
        }, 100);
      }
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
// Si existe el módulo EditorUtils, usarlo; si no, usar función inline
function showProductsPlaceholder() {
  if (typeof EditorUtils !== 'undefined' && EditorUtils.showProductsPlaceholder) {
    return EditorUtils.showProductsPlaceholder();
  }

  // Fallback inline

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
// Si existe el módulo EditorUtils, usarlo; si no, usar función inline
function handleSectorClick(e) {
  if (typeof EditorUtils !== 'undefined' && EditorUtils.handleSectorClick) {
    return EditorUtils.handleSectorClick(e);
  }

  // Fallback inline
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
  window.forceTraitManagerUpdate = function (component) {
    if (editor.TraitManager) {
      // Obtener el componente seleccionado si no se proporciona uno
      const targetComponent = component || editor.getSelected();

      if (targetComponent) {
        // Si es un carrusel, usar solo el sistema personalizado
        if (targetComponent.get('type') === 'carousel') {
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

        // Actualizar etiquetas de propiedades según el dispositivo activo
        if (typeof window.updateTraitLabelsForDevice === 'function') {
          window.updateTraitLabelsForDevice();
        }

        // Verificar si se renderizaron todos los traits
        setTimeout(() => {
          const traitsInContainer = document.querySelectorAll('.traits-container .gjs-trt-trait');

          if (traitsInContainer.length === 0) {
            // Usar el sistema de traits personalizado
            window.renderCustomTraits(targetComponent);
          } else {
            // Actualizar etiquetas después del renderizado
            if (typeof window.updateTraitLabelsForDevice === 'function') {
              window.updateTraitLabelsForDevice();
            }
          }
        }, 200);
      }
    }
  };

  // Función para actualizar las etiquetas de traits según el dispositivo activo
  window.updateTraitLabelsForDevice = function () {
    if (!editor || !editor.getDevice) return;

    const currentDevice = editor.getDevice();
    const traitsContainer = document.querySelector('.traits-container');
    if (!traitsContainer) return;

    // Mapeo de dispositivos a etiquetas
    const deviceLabels = {
      'Desktop': 'Desktop',
      'Tablet': 'Tablet',
      'Mobile': 'Mobile'
    };

    const deviceName = deviceLabels[currentDevice] || 'Desktop';

    // Agregar o actualizar indicador de dispositivo activo en el panel de propiedades
    let deviceIndicator = document.querySelector('.device-indicator');
    if (!deviceIndicator) {
      deviceIndicator = document.createElement('div');
      deviceIndicator.className = 'p-2 mb-3 border border-blue-200 rounded-md device-indicator bg-blue-50';
      deviceIndicator.style.fontSize = '0.75rem';
      traitsContainer.insertBefore(deviceIndicator, traitsContainer.firstChild);
    }

    const deviceIcons = {
      'Desktop': '🖥️',
      'Tablet': '📱',
      'Mobile': '📱'
    };

    deviceIndicator.innerHTML = `
      <div class="flex items-center gap-2">
        <span class="text-blue-600 font-semibold">${deviceIcons[deviceName] || '🖥️'} Editando: ${deviceName}</span>
        <span class="text-gray-500 text-xs">Las propiedades marcadas con (${deviceName}) se aplicarán a este dispositivo</span>
      </div>
    `;

    // Buscar todas las etiquetas de traits y actualizar las que sean específicas de dispositivo
    const traitLabels = traitsContainer.querySelectorAll('.gjs-trt-label');
    traitLabels.forEach(label => {
      const labelText = label.textContent || '';

      // Si la etiqueta contiene información de dispositivo, resaltarla
      if (labelText.includes('(Desktop)') || labelText.includes('(Tablet)') || labelText.includes('(Mobile)')) {
        // Remover clases de resaltado anteriores
        label.classList.remove('font-bold', 'text-blue-600', 'bg-blue-50', 'px-2', 'py-1', 'rounded');

        // Resaltar la etiqueta del dispositivo activo
        if (labelText.includes(`(${deviceName})`)) {
          label.classList.add('font-bold', 'text-blue-600', 'bg-blue-50', 'px-2', 'py-1', 'rounded');
        }
      }
    });
  };

  // Sistema de traits personalizado
  window.renderCustomTraits = function (component) {
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

    // ✅ CRÍTICO: Función auxiliar para convertir objetos de Backbone a objetos planos
    const convertTraitToPlain = (trait) => {
      // Si es un objeto de Backbone, convertir a objeto plano
      if (trait && trait.get && typeof trait.get === 'function') {
        // Intentar usar toJSON primero
        if (trait.toJSON && typeof trait.toJSON === 'function') {
          const json = trait.toJSON();
          // Asegurar que type esté presente
          if (!json.type && trait.get('type')) {
            json.type = trait.get('type');
          }
          return json;
        }
        // Si no tiene toJSON, construir manualmente
        const plain = {};
        // Obtener todas las propiedades comunes
        ['type', 'name', 'label', 'placeholder', 'options', 'text', 'command', 'content', 'changeProp'].forEach(prop => {
          const value = trait.get(prop);
          if (value !== undefined && value !== null) {
            plain[prop] = value;
          }
        });
        // Agregar cualquier otro atributo
        if (trait.attributes) {
          Object.assign(plain, trait.attributes);
        }
        return plain;
      }
      // Si ya es un objeto plano, retornarlo tal cual
      return trait;
    };

    if (component.getTraits && typeof component.getTraits === 'function') {
      const traitsCollection = component.getTraits();
      // ✅ CRÍTICO: Convertir objetos de Backbone a objetos planos
      if (traitsCollection) {
        // Si es una colección de Backbone
        if (traitsCollection.toJSON && typeof traitsCollection.toJSON === 'function') {
          traits = traitsCollection.toJSON();
        } else if (traitsCollection.length !== undefined) {
          // Si tiene length, es iterable
          traits = Array.from(traitsCollection).map(convertTraitToPlain);
        } else if (Array.isArray(traitsCollection)) {
          traits = traitsCollection.map(convertTraitToPlain);
        } else {
          traits = [convertTraitToPlain(traitsCollection)];
        }
      }
    } else if (component.get('traits')) {
      const traitsCollection = component.get('traits');
      // Si es una colección de Backbone, convertir a JSON
      if (traitsCollection.toJSON && typeof traitsCollection.toJSON === 'function') {
        traits = traitsCollection.toJSON();
      } else if (Array.isArray(traitsCollection)) {
        // Si es un array, convertir cada elemento si es necesario
        traits = traitsCollection.map(convertTraitToPlain);
      } else {
        traits = [convertTraitToPlain(traitsCollection)];
      }
    }

    console.log('📋 Traits a renderizar:', traits.length);

    if (traits.length === 0) {
      traitsContainer.innerHTML = '<div class="text-gray-500 text-sm p-4">No hay propiedades disponibles</div>';
      return;
    }

    // Renderizar cada trait
    // ✅ CRÍTICO: Filtrar y convertir traits antes de renderizar
    traits.forEach(trait => {
      // Si el trait es un objeto de Backbone, convertirlo a objeto plano
      if (trait && trait.get && typeof trait.get === 'function') {
        trait = trait.toJSON ? trait.toJSON() : {
          type: trait.get('type'),
          name: trait.get('name'),
          label: trait.get('label'),
          placeholder: trait.get('placeholder'),
          options: trait.get('options'),
          text: trait.get('text'),
          command: trait.get('command'),
          content: trait.get('content'),
          changeProp: trait.get('changeProp'),
          ...trait.attributes
        };
      }

      // Validar que el trait tenga type definido
      if (!trait || !trait.type) {
        console.warn('⚠️ Trait sin type definido, omitiendo:', trait);
        return; // Saltar este trait
      }

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

  // ✅ Funciones editImage y deleteImage movidas a módulo: editor-modules/carousel-utils.js

  // Función para crear elementos de trait
  function createTraitElement(trait, component) {
    // ✅ CRÍTICO: Validar que el trait tenga type definido
    if (!trait || !trait.type) {
      console.warn('⚠️ createTraitElement: Trait sin type definido:', trait);
      return null;
    }

    const container = document.createElement('div');
    container.className = 'gjs-trt-trait custom-trait';
    container.setAttribute('data-trait-name', trait.name || '');

    const label = document.createElement('label');
    label.className = 'gjs-trt-label';
    label.textContent = trait.label || trait.name || 'Sin nombre';
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
      // ✅ CRÍTICO: Para traits de texto, usar { silent: true } durante la edición
      // y solo disparar el evento completo cuando se pierde el foco o se presiona Enter
      if (trait.type === 'text' && trait.name === 'heading-text') {
        // Listener para cambios en tiempo real (silent para evitar re-renderizado)
        input.addEventListener('input', (e) => {
          const value = e.target.value;
          // Usar { silent: true } para evitar que se dispare updateText() durante la edición
          component.set(trait.name, value, { silent: true });
        });

        // Listener para cuando se presiona Enter o se pierde el foco (actualizar completamente)
        const handleFinalUpdate = (e) => {
          const value = e.target.value;
          // Usar { silent: false } solo cuando se termina de editar
          component.set(trait.name, value, { silent: false });
          console.log(`✅ Trait actualizado (final): ${trait.name} = ${value}`);

          // Ejecutar onUpdate si existe
          if (trait.onUpdate && typeof trait.onUpdate === 'function') {
            trait.onUpdate(value, component);
          }
        };

        input.addEventListener('blur', handleFinalUpdate);
        input.addEventListener('keydown', (e) => {
          if (e.key === 'Enter') {
            e.preventDefault();
            input.blur(); // Esto disparará el evento blur que actualizará el componente
          }
        });
      } else {
        // Para otros tipos de traits, usar el comportamiento normal
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

}

// Inicialización del editor
function initializeEditor() {
  // Configurar bloques directamente desde los archivos Blade
  editorConfig.blockManager.blocks = window.editorBlocks || [];

  // Inicializar el editor
  const editor = grapesjs.init(editorConfig);

  // Hacer el editor disponible globalmente
  window.editor = editor;

  // ✅ Registrar trait personalizado para textarea
  if (editor.TraitManager) {
    editor.TraitManager.addType('textarea', {
      events: {
        'keyup': 'onChange',
      },
      onUpdate: function ({ elInput, component }) {
        elInput.value = component.get(this.attributes.name);
      },
      onEvent: function ({ elInput, component, event }) {
        const value = elInput.value;
        component.set(this.attributes.name, value);
      },
      createInput: function ({ trait }) {
        const el = document.createElement('textarea');
        el.className = 'gjs-trt-textarea';
        el.placeholder = trait.placeholder || '';
        el.rows = trait.rows || 4;
        return el;
      }
    });
  }

  // ✅ Registrar todos los componentes modulares después de inicializar el editor
  // Todos los componentes están ahora en editor-modules/components/
  const componentsToRegister = [
    'Image', 'Container', 'Heading', 'Paragraph', 'Button', 'Text',
    'Link', 'Divider', 'Separator', 'Table', 'HtmlCode', 'Spacer', 'Alert',
    'Icon', 'IconBox', 'IconList', 'StarRating', 'Quote', 'Code', 'Preformatted', 'Verse',
    'Toggle', 'Tabs', 'Accordion',
    'Carousel', 'Gallery', 'Video', 'GoogleMaps',
    'ImageBoxAdvanced', 'BackgroundImage', 'BackgroundColor', 'File', 'Audio', 'CounterAnimated',
    'SectionInner', 'Column'
  ];

  componentsToRegister.forEach(componentName => {
    const registerFn = window[`register${componentName}Component`];
    if (typeof registerFn === 'function') {
      console.log(`✅ [Editor] Registrando componente: ${componentName}`);
      registerFn(editor);

      // Verificar que se registró correctamente
      if (componentName === 'Toggle') {
        const toggleType = editor.DomComponents.getType('toggle');
        if (toggleType) {
          console.log('✅ [Editor] Componente toggle registrado correctamente en GrapesJS');
        } else {
          console.error('❌ [Editor] Componente toggle NO se registró en GrapesJS');
        }
      }
    } else {
      console.warn(`⚠️ [Editor] Función register${componentName}Component no encontrada`);
    }
  });

  // ✅ Todos los componentes duplicados eliminados - ahora están en módulos separados

  // Configuración de comandos del editor

  // Ocultar indicador de carga y mostrar editor
  const loadingIndicator = document.getElementById('loading-indicator');
  const editorContainer = document.getElementById('gjs');

  if (loadingIndicator) {
    loadingIndicator.style.display = 'none';
  }
  if (editorContainer) {
    editorContainer.style.display = 'block';
  }

  // Inyectar estilos y scripts en el canvas
  editor.on('load', function () {
    // ✅ CRÍTICO: Sincronizar Background Image después de cargar
    setTimeout(() => {
      const syncBackgroundImageAfterLoad = () => {
        const allComponents = editor.getComponents();
        const findBackgroundImage = (components) => {
          if (components && typeof components.forEach === 'function') {
            components.forEach((component) => {
              if (component && component.get && component.get('type') === 'background-image') {
                if (component.view && component.view.el) {
                  const titleEl = component.view.el.querySelector('h2');
                  const textEl = component.view.el.querySelector('p');
                  const buttonEl = component.view.el.querySelector('button, a');

                  if (titleEl) {
                    const domTitle = titleEl.textContent || titleEl.innerText || '';
                    if (domTitle.trim()) {
                      component.set('content-title', domTitle.trim(), { silent: false });
                    }
                  }

                  if (textEl) {
                    const domText = textEl.textContent || textEl.innerText || '';
                    if (domText.trim()) {
                      component.set('content-text', domText.trim(), { silent: false });
                    }
                  }

                  if (buttonEl) {
                    const domButtonText = buttonEl.textContent || buttonEl.innerText || '';
                    if (domButtonText.trim()) {
                      component.set('button-text', domButtonText.trim(), { silent: false });
                    }

                    const href = buttonEl.getAttribute('href');
                    if (href) {
                      component.set('button-link', href, { silent: false });
                    } else if (buttonEl.tagName === 'BUTTON') {
                      component.set('button-link', '#', { silent: false });
                    }
                  }

                  // Forzar actualización del TraitManager
                  setTimeout(() => {
                    if (editor.TraitManager) {
                      editor.TraitManager.render();
                    }
                  }, 200);
                }
              }

              if (component && component.components) {
                const childComponents = component.components();
                if (childComponents) {
                  findBackgroundImage(childComponents);
                }
              }
            });
          }
        };
        findBackgroundImage(allComponents);
      };

      syncBackgroundImageAfterLoad();
    }, 500);

    // Sincronizar todos los botones después de que el editor carga
    setTimeout(() => {
      const allComponents = editor.getComponents();

      // Función recursiva para encontrar todos los botones
      const findButtons = (components) => {
        // Usar el método correcto para iterar sobre componentes
        if (components && typeof components.forEach === 'function') {
          components.forEach((component) => {
            if (component && component.get && component.get('type') === 'button') {
              if (typeof component.syncInitialValues === 'function') {
                component.syncInitialValues();
                // Forzar actualización visual
                if (component.view && component.view.el) {
                  component.view.render();
                }
              }
            }
            // Buscar en componentes hijos
            if (component && component.components) {
              const childComponents = component.components();
              if (childComponents && childComponents.length > 0) {
                findButtons(childComponents);
              }
            }
          });
        } else if (components && components.length) {
          // Si es un array
          components.forEach((component) => {
            if (component && component.get && component.get('type') === 'button') {
              if (typeof component.syncInitialValues === 'function') {
                component.syncInitialValues();
                if (component.view && component.view.el) {
                  component.view.render();
                }
              }
            }
            if (component && component.components) {
              const childComponents = component.components();
              if (childComponents && childComponents.length > 0) {
                findButtons(childComponents);
              }
            }
          });
        }
      };

      findButtons(allComponents);

      // Función recursiva para encontrar todos los contenedores
      const findContainers = (components) => {
        if (!components) return;

        try {
          if (typeof components.each === 'function') {
            components.each((component) => {
              if (component && component.get && component.get('type') === 'container') {
                // Forzar actualización visual
                if (component.view && component.view.el) {
                  const el = component.view.el;
                  // Asegurar que tenga las clases básicas
                  if (!el.className.includes('container-flex')) {
                    el.classList.add('container-flex');
                  }
                  if (!el.className.includes('flex')) {
                    el.classList.add('flex');
                  }
                  component.view.render();
                }
              }
              if (component && component.components) {
                const childComponents = component.components();
                if (childComponents) {
                  findContainers(childComponents);
                }
              }
            });
          } else if (Array.isArray(components)) {
            components.forEach((component) => {
              if (component && component.get && component.get('type') === 'container') {
                if (component.view && component.view.el) {
                  const el = component.view.el;
                  if (!el.className.includes('container-flex')) {
                    el.classList.add('container-flex');
                  }
                  if (!el.className.includes('flex')) {
                    el.classList.add('flex');
                  }
                  component.view.render();
                }
              }
              if (component && component.components) {
                const childComponents = component.components();
                if (childComponents) {
                  findContainers(childComponents);
                }
              }
            });
          }
        } catch (error) {
          console.error('❌ Error en findContainers:', error);
        }
      };

      findContainers(allComponents);
    }, 500);

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
          [data-gjs-type="video"],
          [data-gjs-type="youtube-video"],
          [data-gjs-type="google-maps"] {
            cursor: pointer !important;
          }
          
          .youtube-container {
            cursor: pointer !important;
          }
          
          /* ✅ Eliminar espacio en blanco inferior del canvas */
          body {
            margin: 0 !important;
            padding: 0 !important;
            padding-bottom: 0 !important;
            margin-bottom: 0 !important;
            min-height: auto !important;
          }
          html {
            margin: 0 !important;
            padding: 0 !important;
            padding-bottom: 0 !important;
            margin-bottom: 0 !important;
          }
          
          /* ✅ OCULTAR badge "DIV" para componentes background-image */
          [data-gjs-type="background-image"] .gjs-badge,
          [data-gjs-type="background-image"] .gjs-badge-label {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
          }
          
          /* ✅ OCULTAR badge para toggle pero mantener toolbar visible */
          [data-gjs-type="toggle"] .gjs-badge,
          [data-gjs-type="toggle"] .gjs-badge-label {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
          }
          
          /* ✅ ASEGURAR que el toolbar sea visible para toggle */
          [data-gjs-type="toggle"] .gjs-toolbar,
          .toggle-container .gjs-toolbar,
          .gjs-selected[data-gjs-type="toggle"] ~ .gjs-toolbar,
          .gjs-toolbar[data-toolbar-toggle] {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            z-index: 9999 !important;
          }
          
          /* ✅ Asegurar que cualquier toolbar cerca de un toggle sea visible */
          .toggle-container + .gjs-toolbar,
          .toggle-container ~ .gjs-toolbar {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
          }
        `;
        frameDoc.head.appendChild(styleEl);
      }

      // Inyectar script de blog si hay un bloque de blog
      injectBlogScriptInCanvas(frameDoc);
    }
  });

  // Función para inyectar script de blog en el canvas
  function injectBlogScriptInCanvas(frameDoc) {
    // Verificar si hay un bloque de blog
    const hasBlogBlock = frameDoc.querySelector('#blog-posts-container') ||
      frameDoc.querySelector('[data-dynamic-blog="true"]');

    if (hasBlogBlock) {
      // Remover script anterior si existe para reinyectarlo
      const oldScript = frameDoc.getElementById('blog-script-injected');
      if (oldScript) {
        oldScript.remove();
      }
      console.log('📝 Bloque de blog detectado, inyectando script...');

      // Obtener el website ID de la variable global o del atributo data
      const websiteId = window.websiteId ||
        window.currentWebsiteId ||
        (frameDoc.querySelector('#blog-posts-container')?.dataset?.websiteId) ||
        (frameDoc.querySelector('[data-dynamic-blog="true"]')?.querySelector('[data-website-id]')?.dataset?.websiteId) ||
        null;

      console.log('🌐 Website ID para blog:', websiteId);

      if (!websiteId || websiteId === "" || websiteId === null) {
        console.log("⚠️ Website ID no válido o no encontrado");
        return;
      }

      // Crear el script
      const scriptEl = frameDoc.createElement('script');
      scriptEl.id = 'blog-script-injected';
      scriptEl.textContent = `
        (function() {
          console.log("📝 Script de blog inyectado en canvas");
          const websiteId = "${websiteId}";
          
          if (!websiteId || websiteId === "" || websiteId === "null") {
            console.log("⚠️ Website ID no válido:", websiteId);
            return;
          }
          
          // Función para cargar posts
          function loadBlogPosts() {
            const container = document.querySelector('#blog-posts-container') || 
                             document.querySelector('[data-dynamic-blog="true"] .grid');
            
            if (!container) {
              console.log("❌ No se encontró contenedor de blog");
              return;
            }
            
            console.log("📝 Cargando posts del blog para website ID:", websiteId);
            
            fetch('/api/websites/' + websiteId + '/blog-posts?page=1&per_page=6', {
              method: 'GET',
              headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
              }
            })
            .then(response => response.json())
            .then(data => {
              console.log("📝 Posts recibidos:", data);
              
              if (data && data.data && data.data.length > 0) {
                // Limpiar contenido de ejemplo
                container.innerHTML = '';
                
                // Renderizar posts reales
                data.data.forEach(post => {
                  const postEl = document.createElement('article');
                  postEl.className = 'overflow-hidden transition-shadow bg-white rounded-lg shadow-lg hover:shadow-xl';
                  
                  const excerpt = post.excerpt || (post.content || '').substring(0, 150) + '...';
                  const publishDate = new Date(post.created_at || post.published_at).toLocaleDateString('es-ES', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                  });
                  
                  postEl.innerHTML = \`
                    <div class="w-full h-48 bg-gradient-to-br from-blue-100 to-purple-100 flex items-center justify-center">
                      \${post.category ? '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mb-2">' + post.category.name + '</span>' : ''}
                    </div>
                    <div class="p-6">
                      <div class="flex items-center text-sm text-gray-500 mb-2">
                        <span>\${publishDate}</span>
                        <span class="mx-2">•</span>
                        <span>\${Math.ceil((post.content || '').split(/\\s+/).length / 200)} min lectura</span>
                      </div>
                      <h3 class="text-xl font-bold text-gray-900 mb-2 hover:text-blue-600 cursor-pointer">\${post.title || 'Sin título'}</h3>
                      <p class="text-gray-600 mb-4">\${excerpt}</p>
                      <div class="flex items-center justify-between mt-4">
                        <div class="flex items-center">
                          <div class="w-6 h-6 bg-gray-300 rounded-full mr-2"></div>
                          <span class="text-sm text-gray-600">Autor</span>
                        </div>
                        <a href="#" class="text-blue-600 hover:text-blue-800 text-sm">Leer más →</a>
                      </div>
                    </div>
                  \`;
                  
                  container.appendChild(postEl);
                });
                
                console.log("✅ Posts del blog renderizados correctamente");
              } else {
                console.log("⚠️ No se encontraron posts del blog");
              }
            })
            .catch(error => {
              console.error("❌ Error al cargar posts del blog:", error);
            });
          }
          
          // Cargar posts después de un pequeño delay
          setTimeout(loadBlogPosts, 500);
        })();
      `;

      frameDoc.body.appendChild(scriptEl);
      console.log('✅ Script de blog inyectado en canvas');
    }
  }

  // También inyectar cuando se actualiza el canvas o se agrega un componente
  editor.on('update', function () {
    setTimeout(() => {
      const canvasFrame = editor.Canvas.getFrameEl();
      if (canvasFrame && canvasFrame.contentDocument) {
        const frameDoc = canvasFrame.contentDocument;
        injectBlogScriptInCanvas(frameDoc);
      }
    }, 300);
  });

  // Inyectar cuando se agrega un componente (para detectar bloques de blog agregados)
  editor.on('component:add', function () {
    setTimeout(() => {
      const canvasFrame = editor.Canvas.getFrameEl();
      if (canvasFrame && canvasFrame.contentDocument) {
        const frameDoc = canvasFrame.contentDocument;
        injectBlogScriptInCanvas(frameDoc);
      }
    }, 500);
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
  }, 2000);

  // Evento para detectar cuando se suelta un componente en el canvas
  editor.on('block:drag:stop', function (component) {
    console.log('📦 Componente añadido al canvas');
    if (component && component.get) {
      console.log('   Tipo:', component.get('type'));
      console.log('   Nombre:', component.get('name'));
      console.log('   Selectable:', component.get('selectable'));

      // ✅ Si es un componente de imagen, asegurar que tenga los traits correctos
      if (component.get('type') === 'image') {
        console.log('🖼️ Componente de imagen agregado desde bloque, verificando traits...');

        setTimeout(() => {
          const imageComponentType = editor.DomComponents.getType('image');
          if (imageComponentType && imageComponentType.model && imageComponentType.model.defaults && imageComponentType.model.defaults.traits) {
            const registeredTraits = imageComponentType.model.defaults.traits;

            // Establecer los traits desde el componente registrado
            component.set('traits', registeredTraits, { silent: false });
            console.log('✅ Traits del componente de imagen actualizados desde el componente registrado');

            // Seleccionar el componente para que se muestren los traits
            editor.select(component);
          }
        }, 100);
      }

      // ✅ Si es un componente de contenedor, asegurar que tenga los traits correctos
      if (component.get('type') === 'container') {
        console.log('📦 Componente de contenedor agregado desde bloque, verificando traits...');

        setTimeout(() => {
          const containerComponentType = editor.DomComponents.getType('container');
          if (containerComponentType && containerComponentType.model && containerComponentType.model.defaults && containerComponentType.model.defaults.traits) {
            const registeredTraits = containerComponentType.model.defaults.traits;

            // Establecer los traits desde el componente registrado
            component.set('traits', registeredTraits, { silent: false });
            console.log('✅ Traits del componente de contenedor actualizados desde el componente registrado');

            // Seleccionar el componente para que se muestren los traits
            editor.select(component);
          }
        }, 100);
      }
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
          [data-gjs-type="video"],
          [data-gjs-type="youtube-video"],
          [data-gjs-type="google-maps"] {
            cursor: pointer !important;
          }
          .youtube-container {
            cursor: pointer !important;
          }
          
          /* ✅ Eliminar espacio en blanco inferior del canvas */
          body {
            margin: 0 !important;
            padding: 0 !important;
            padding-bottom: 0 !important;
            margin-bottom: 0 !important;
            min-height: auto !important;
          }
          html {
            margin: 0 !important;
            padding: 0 !important;
            padding-bottom: 0 !important;
            margin-bottom: 0 !important;
          }
          
          /* ✅ OCULTAR badge "DIV" para componentes background-image */
          [data-gjs-type="background-image"] .gjs-badge,
          [data-gjs-type="background-image"] .gjs-badge-label {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
          }
          
          /* ✅ OCULTAR badge para toggle pero mantener toolbar visible */
          [data-gjs-type="toggle"] .gjs-badge,
          [data-gjs-type="toggle"] .gjs-badge-label {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
          }
          
          /* ✅ ASEGURAR que el toolbar sea visible para toggle */
          [data-gjs-type="toggle"] .gjs-toolbar,
          .toggle-container .gjs-toolbar,
          .gjs-selected[data-gjs-type="toggle"] ~ .gjs-toolbar,
          .gjs-toolbar[data-toolbar-toggle] {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            z-index: 9999 !important;
          }
          
          /* ✅ Asegurar que cualquier toolbar cerca de un toggle sea visible */
          .toggle-container + .gjs-toolbar,
          .toggle-container ~ .gjs-toolbar {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
          }
        `;
        frameDoc.head.appendChild(styleEl);
        console.log('✅ Estilos de bloqueo de iframe re-inyectados');
      }
    }
  }

  // Configurar eventos del editor
  editor.on('component:add', function (component) {

    // Sincronizar botones cuando se agregan (SOLO para componentes tipo 'button', NO para toggles o botones dentro de toggles)
    if (component.get('type') === 'button') {
      // ✅ NO aplicar a botones que están dentro de un toggle
      const parent = component.parent();
      if (parent && parent.get && parent.get('type') === 'toggle') {
        console.log('⚠️ [Editor] Ignorando preservación de clases para botón dentro de toggle');
        return;
      }
      setTimeout(() => {
        if (typeof component.syncInitialValues === 'function') {
          component.syncInitialValues();
          // Forzar actualización visual y preservar clases
          if (component.view && component.view.el) {
            component.view.render();
            // Preservar clases después del render
            setTimeout(() => {
              if (component.view && component.view.el) {
                const savedClasses = component.getAttributes().class;
                if (savedClasses) {
                  component.view.el.className = savedClasses;
                  component.setAttributes({ class: savedClasses });
                  console.log('✅ Clases preservadas después de agregar botón:', savedClasses);
                }
              }
            }, 100);
          }
        }
      }, 200);
    }

    // Sincronizar contenedores cuando se agregan
    if (component.get('type') === 'container') {
      setTimeout(() => {
        if (component.view && component.view.el) {
          const el = component.view.el;
          // Asegurar que tenga las clases básicas
          if (!el.className.includes('container-flex')) {
            el.classList.add('container-flex');
          }
          if (!el.className.includes('flex')) {
            el.classList.add('flex');
          }
          // Actualizar atributos en el modelo
          const currentClass = el.className;
          component.setAttributes({ class: currentClass });
          component.view.render();
          console.log('✅ Contenedor inicializado con clases:', currentClass);
        }
      }, 200);
    }

    // ✅ El manejo de imágenes se hace completamente en el componente image.js
    // No es necesario duplicar código aquí - el componente image.js maneja:
    // - Inicialización con imagen por defecto
    // - Doble clic para abrir galería
    // - Actualización de imagen desde galería
    // - Sincronización de src

    // Asegurar que los estilos de bloqueo de iframe estén presentes
    if (component.get('type') === 'video' || component.get('type') === 'youtube-video' || component.get('type') === 'google-maps') {
      setTimeout(ensureIframeBlockerStyles, 100);
    }

    // Generar ID único para widgets que necesitan estilos independientes
    const widgetTypes = ['button', 'image', 'heading', 'paragraph', 'text', 'link', 'divider', 'icon', 'icon-box', 'video', 'youtube-video', 'google-maps', 'image-box-advanced', 'background-image', 'file', 'audio', 'carousel'];
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

    // ✅ Si el componente se agregó a un contenedor, ocultar el placeholder
    // Solo hacer esto si NO estamos cargando contenido existente
    if (!isLoadingContent) {
      const removePlaceholderFromContainer = (container) => {
        if (!container || !container.components) return;

        try {
          const components = container.components();
          if (!components) return;

          // Buscar el placeholder
          let placeholder = null;
          let componentCount = 0;

          if (components.models) {
            components.models.forEach((c) => {
              componentCount++;
              const content = c.get('content') || '';
              const name = c.get('name') || '';
              const type = c.get('type') || '';

              // Detectar placeholder por nombre, contenido o tipo
              if (name === 'Placeholder' ||
                content.includes('Arrastra elementos aquí') ||
                (type === 'text' && content.includes('↓'))) {
                placeholder = c;
              }
            });
          } else if (typeof components.each === 'function') {
            components.each((c) => {
              componentCount++;
              if (!placeholder) {
                const content = c.get('content') || '';
                const name = c.get('name') || '';
                const type = c.get('type') || '';

                if (name === 'Placeholder' ||
                  content.includes('Arrastra elementos aquí') ||
                  (type === 'text' && content.includes('↓'))) {
                  placeholder = c;
                }
              }
            });
          } else if (Array.isArray(components)) {
            componentCount = components.length;
            placeholder = components.find(c => {
              const content = c.get ? c.get('content') || '' : '';
              const name = c.get ? c.get('name') || '' : '';
              const type = c.get ? c.get('type') || '' : '';
              return name === 'Placeholder' ||
                content.includes('Arrastra elementos aquí') ||
                (type === 'text' && content.includes('↓'));
            });
          }

          // Remover el placeholder si existe y hay más de un componente (el placeholder + el nuevo)
          if (placeholder && componentCount > 1) {
            placeholder.remove();
            console.log('✅ Placeholder eliminado del contenedor');
            return true;
          }
        } catch (error) {
          console.error('❌ Error al eliminar placeholder:', error);
        }
        return false;
      };

      const parent = component.parent();
      if (parent) {
        const parentType = parent.get('type');
        const parentClasses = parent.getClasses() || [];
        const isColumn = parentClasses.includes('column');
        const isContainer = parentType === 'container' || parentClasses.includes('container-simple') || parentClasses.includes('container-flex');

        if (isColumn || isContainer) {
          // ✅ Remover placeholder del contenedor padre (múltiples intentos para asegurar)
          const tryRemovePlaceholder = () => {
            const removed = removePlaceholderFromContainer(parent);
            if (!removed) {
              // Si no se removió, intentar de nuevo
              setTimeout(() => removePlaceholderFromContainer(parent), 50);
            }
          };

          tryRemovePlaceholder();
          setTimeout(tryRemovePlaceholder, 100);
          setTimeout(tryRemovePlaceholder, 300);
        }

        // También verificar el abuelo (por si el componente está dentro de otro)
        const grandParent = parent.parent();
        if (grandParent) {
          const grandParentType = grandParent.get('type');
          const grandParentClasses = grandParent.getClasses() || [];
          const isGrandParentContainer = grandParentType === 'container' ||
            grandParentClasses.includes('container-simple') ||
            grandParentClasses.includes('container-flex');

          if (isGrandParentContainer) {
            setTimeout(() => {
              removePlaceholderFromContainer(grandParent);
            }, 150);
          }
        }
      }

      // Buscar en todos los contenedores del editor
      setTimeout(() => {
        const allComponents = editor.getComponents();
        const findAndCleanContainers = (components) => {
          if (!components) return;

          try {
            if (typeof components.each === 'function') {
              components.each((c) => {
                if (c.get('type') === 'container') {
                  removePlaceholderFromContainer(c);
                }
                if (c.components) {
                  findAndCleanContainers(c.components());
                }
              });
            } else if (Array.isArray(components)) {
              components.forEach((c) => {
                if (c.get && c.get('type') === 'container') {
                  removePlaceholderFromContainer(c);
                }
                if (c.components) {
                  findAndCleanContainers(c.components());
                }
              });
            }
          } catch (error) {
            console.error('❌ Error en findAndCleanContainers:', error);
          }
        };

        findAndCleanContainers(allComponents);
      }, 200);

      // Código original para columnas (mantener compatibilidad)
      if (parent) {
        const parentClasses = parent.getClasses();
        const isColumn = parentClasses.includes('column');

        if (isColumn) {
          // ✅ Buscar y remover el placeholder (método mejorado)
          const removeColumnPlaceholder = () => {
            try {
              const components = parent.components();
              if (!components) return;

              let placeholder = null;
              let componentCount = 0;

              if (components.models) {
                components.models.forEach((c) => {
                  componentCount++;
                  const content = (c.get('content') || '').toString();
                  const name = (c.get('name') || '').toString();

                  if (name === 'Placeholder' ||
                    content.includes('Arrastra elementos aquí') ||
                    content.includes('↓ Arrastra')) {
                    placeholder = c;
                  }
                });
              }

              if (placeholder && componentCount > 1) {
                placeholder.remove();
                // También eliminar desde el DOM
                if (placeholder.view && placeholder.view.el) {
                  setTimeout(() => {
                    if (placeholder.view && placeholder.view.el && placeholder.view.el.parentNode) {
                      placeholder.view.el.remove();
                    }
                  }, 50);
                }
                console.log('✅ Placeholder eliminado de columna');

                // Si es columna, remover borde punteado
                const currentClasses = parent.getClasses();
                const newClasses = currentClasses.filter(c =>
                  !['border-2', 'border-dashed', 'border-gray-300', 'flex', 'items-center', 'justify-center'].includes(c)
                );
                parent.setClass(newClasses.join(' '));
              }
            } catch (error) {
              console.error('❌ Error al eliminar placeholder de columna:', error);
            }
          };

          // Ejecutar múltiples veces para asegurar
          removeColumnPlaceholder();
          setTimeout(removeColumnPlaceholder, 100);
          setTimeout(removeColumnPlaceholder, 300);
        }
      }
    }
  });

  // ✅ Listener adicional para eliminar placeholder cuando se agregan componentes
  editor.on('component:add', function (component) {
    // Esperar un momento para que el componente se agregue completamente
    setTimeout(() => {
      const parent = component.parent();
      if (parent) {
        const parentType = parent.get('type');
        const parentClasses = parent.getClasses() || [];
        const isContainer = parentType === 'container' ||
          parentClasses.includes('container-simple') ||
          parentClasses.includes('container-flex');

        if (isContainer) {
          const components = parent.components();
          if (components) {
            let placeholder = null;
            let componentCount = 0;

            // Buscar placeholder
            if (components.models) {
              components.models.forEach((c) => {
                componentCount++;
                const content = (c.get('content') || '').toString();
                const name = (c.get('name') || '').toString();

                if (name === 'Placeholder' ||
                  content.includes('Arrastra elementos aquí') ||
                  content.includes('↓ Arrastra')) {
                  placeholder = c;
                }
              });
            }

            // Eliminar si hay más de un componente
            if (placeholder && componentCount > 1) {
              try {
                placeholder.remove();
                // También desde el DOM
                if (placeholder.view && placeholder.view.el) {
                  placeholder.view.el.remove();
                }
                console.log('✅ Placeholder eliminado (listener adicional)');
              } catch (error) {
                console.error('❌ Error:', error);
              }
            }
          }
        }
      }
    }, 150);
  });

  // ✅ Listener adicional para eliminar placeholder cuando se agregan componentes a contenedores
  editor.on('component:add', function (component) {
    // Esperar un momento para que el componente se agregue completamente
    setTimeout(() => {
      try {
        const parent = component.parent();
        if (parent) {
          const parentType = parent.get('type');
          const parentClasses = parent.getClasses() || [];
          const isContainer = parentType === 'container' ||
            parentClasses.includes('container-simple') ||
            parentClasses.includes('container-flex');

          if (isContainer) {
            const components = parent.components();
            if (components) {
              let placeholder = null;
              let componentCount = 0;

              // Buscar placeholder en diferentes formatos
              if (components.models) {
                components.models.forEach((c) => {
                  componentCount++;
                  const content = (c.get('content') || '').toString();
                  const name = (c.get('name') || '').toString();

                  if (name === 'Placeholder' ||
                    content.includes('Arrastra elementos aquí') ||
                    content.includes('↓ Arrastra')) {
                    placeholder = c;
                  }
                });
              } else if (typeof components.each === 'function') {
                components.each((c) => {
                  componentCount++;
                  if (!placeholder) {
                    const content = (c.get('content') || '').toString();
                    const name = (c.get('name') || '').toString();

                    if (name === 'Placeholder' ||
                      content.includes('Arrastra elementos aquí') ||
                      content.includes('↓ Arrastra')) {
                      placeholder = c;
                    }
                  }
                });
              }

              // Eliminar si hay más de un componente
              if (placeholder && componentCount > 1) {
                try {
                  placeholder.remove();
                  // También desde el DOM
                  if (placeholder.view && placeholder.view.el) {
                    setTimeout(() => {
                      if (placeholder.view && placeholder.view.el && placeholder.view.el.parentNode) {
                        placeholder.view.el.remove();
                      }
                    }, 50);
                  }
                  console.log('✅ Placeholder eliminado del contenedor (listener adicional, componentes:', componentCount, ')');
                } catch (error) {
                  console.error('❌ Error al eliminar placeholder:', error);
                }
              }
            }
          }
        }
      } catch (error) {
        console.error('❌ Error en listener de placeholder:', error);
      }
    }, 200);
  });

  // Evento cuando cambia un trait (propiedad) de un componente
  // Cambiado a 'component:trait:change' para evitar ejecuciones innecesarias
  editor.on('component:trait:change', function (component) {
    // Si es el bloque de formulario y cambió el form-id, actualizar el atributo
    const componentType = component.get('type');
    if (componentType === 'form-dynamic' || component.get('attributes')?.class === 'gjs-block-form') {
      const formId = component.get('traits').find(t => t.get('name') === 'form-id')?.get('value') || '';

      // Actualizar el atributo data-form-id en el componente
      component.addAttributes({ 'data-form-id': formId });

      // Actualizar el contenido del placeholder si existe
      const viewEl = component.view && component.view.el;
      if (viewEl) {
        const placeholderEl = viewEl.querySelector('#form-placeholder');
        if (placeholderEl && formId) {
          placeholderEl.innerHTML = `
            <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <p class="text-gray-600">Formulario seleccionado (ID: ${formId})</p>
            <p class="text-sm text-gray-500 mt-2">El formulario se mostrará en la vista previa</p>
          `;
        }
      }
    }
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
        'video': 'Video',
        'youtube-video': 'YouTube',
        'google-maps': 'Google Maps',
        'image-box-advanced': 'Caja de Imagen Avanzada',
        'background-image': 'Imagen de Fondo',
        'file': 'Archivo',
        'audio': 'Reproductor de Audio',
        'carousel': 'Carrusel',
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
      // Usar silent: true para evitar actualizar la vista del Layer Manager si no está lista
      // Esto previene el error "Cannot set properties of null (setting 'innerText')"
      try {
        component.set('name', newName, { silent: true });
        // Si el Layer Manager está disponible y el panel está visible, actualizar la vista
        if (editor.LayerManager) {
          const layersPanel = document.getElementById('layers-panel');
          if (layersPanel && !layersPanel.classList.contains('hidden')) {
            // Forzar actualización solo si el panel está visible
            setTimeout(() => {
              try {
                editor.LayerManager.render();
              } catch (renderError) {
                // Ignorar errores de renderizado si el panel no está listo
                console.debug('Layer Manager no listo para renderizar:', renderError);
              }
            }, 0);
          }
        }
      } catch (error) {
        // Si hay un error, simplemente ignorarlo para evitar romper el flujo
        console.debug('Error al establecer nombre del componente:', error);
      }
    }
  });

  // Evento para forzar selección de carrusel, galería y toggle cuando se detecte
  editor.on('component:add', function (component) {
    const componentType = component.get('type');
    console.log('📦 [Editor] Componente agregado:', componentType);

    if (componentType === 'toggle') {
      console.log('🔄 [Editor] Toggle detectado, configurando selección...');

      // Verificar que el componente esté registrado correctamente
      const toggleType = editor.DomComponents.getType('toggle');
      if (!toggleType) {
        console.error('❌ [Editor] Componente toggle NO está registrado en GrapesJS!');
        // Intentar registrar ahora
        if (window.registerToggleComponent) {
          console.log('🔄 [Editor] Intentando registrar toggle ahora...');
          window.registerToggleComponent(editor);
        }
      } else {
        console.log('✅ [Editor] Componente toggle está registrado correctamente');
      }

      // Forzar que sea seleccionable (GrapesJS generará toolbar automáticamente)
      component.set({
        draggable: true,
        selectable: true,
        hoverable: true,
        removable: true,
        // ✅ NO establecer toolbar - GrapesJS lo generará automáticamente
        highlightable: true,
        badgable: true,
        layerable: true
      });

      console.log('✅ [Editor] Propiedades del toggle configuradas:', {
        selectable: component.get('selectable'),
        removable: component.get('removable'),
        toolbar: component.get('toolbar')
      });

      // Agregar evento de clic después de un breve delay
      setTimeout(() => {
        if (component.view && component.view.el) {
          const el = component.view.el;
          console.log('🔧 [Editor] Configurando elemento DOM del toggle:', el);

          // Asegurar que el contenedor sea seleccionable
          el.setAttribute('data-gjs-selectable', 'true');
          el.setAttribute('data-gjs-removable', 'true');
          el.setAttribute('data-gjs-highlightable', 'true');
          el.setAttribute('data-gjs-hoverable', 'true');
          el.setAttribute('data-gjs-badgable', 'true');

          // Asegurar propiedades del modelo nuevamente (igual que Carousel)
          component.set({
            draggable: true,
            selectable: true,
            removable: true,
            // ✅ NO establecer toolbar - GrapesJS lo generará automáticamente
            highlightable: true,
            hoverable: true,
            badgable: true,
            layerable: true
          });

          // ✅ NO agregar listeners personalizados - dejar que GrapesJS maneje todo naturalmente
          // Solo asegurar estilos básicos
          el.style.cursor = 'pointer';
          el.style.position = 'relative';

          console.log('✅ [Editor] Toggle configurado - sin listeners personalizados');
        } else {
          console.error('❌ [Editor] No se encontró elemento DOM del toggle');
        }
      }, 300);
    }

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

  // ✅ Asegurar que los componentes toggle muestren el toolbar cuando se seleccionan
  editor.on('component:selected', function (component) {
    if (!component) return;

    const componentType = component.get('type');
    console.log('🎯 [Editor] Componente seleccionado:', componentType);

    // ✅ CRÍTICO: Si es background-image, asegurar que tenga todas las propiedades necesarias
    if (componentType === 'background-image') {
      console.log('🔄 [Editor] Background Image seleccionado, asegurando propiedades...');

      // Forzar propiedades para asegurar que el toolbar aparezca
      component.set({
        draggable: true,
        selectable: true,
        removable: true,
        toolbar: true,
        highlightable: true,
        hoverable: true,
        badgable: true,
        layerable: true,
        copyable: true
      }, { silent: false });
    }

    // ✅ CRÍTICO: Si es background-color, asegurar que tenga todas las propiedades necesarias
    if (componentType === 'background-color') {
      console.log('🔄 [Editor] Background Color seleccionado, asegurando propiedades...');

      // Forzar propiedades para asegurar que el toolbar aparezca INMEDIATAMENTE
      component.set({
        draggable: true,
        selectable: true,
        removable: true,
        toolbar: true,
        highlightable: true,
        hoverable: true,
        badgable: true,
        layerable: true,
        copyable: true
      }, { silent: false });

      console.log('✅ [Editor] Propiedades del background-color actualizadas:', {
        selectable: component.get('selectable'),
        removable: component.get('removable'),
        draggable: component.get('draggable'),
        toolbar: component.get('toolbar'),
        badgable: component.get('badgable'),
        layerable: component.get('layerable')
      });

      // Asegurar atributos en el DOM INMEDIATAMENTE
      if (component.view && component.view.el) {
        const el = component.view.el;
        el.setAttribute('data-gjs-selectable', 'true');
        el.setAttribute('data-gjs-removable', 'true');
        el.setAttribute('data-gjs-draggable', 'true');
        el.setAttribute('data-gjs-droppable', 'true');
        el.setAttribute('data-gjs-highlightable', 'true');
        el.setAttribute('data-gjs-toolbar', 'true');
        el.setAttribute('data-gjs-layerable', 'true');
        el.setAttribute('data-gjs-copyable', 'true');
        el.setAttribute('data-gjs-badgable', 'true');
        el.setAttribute('data-gjs-hoverable', 'true');
        el.setAttribute('data-gjs-name', 'Color de Fondo');

        console.log('✅ [Editor] Atributos DOM del background-color configurados');

        // ✅ Verificar el toolbar INMEDIATAMENTE y luego con delay
        // Función para verificar y crear toolbar
        const checkAndCreateToolbar = () => {
          const canvasFrame = editor.Canvas.getFrameEl();
          const canvasView = editor.Canvas.getCanvasView();

          if (!canvasFrame || !canvasFrame.contentDocument) {
            return;
          }

          const frameDoc = canvasFrame.contentDocument;
          const frameBody = frameDoc.body || frameDoc.documentElement;

          // Buscar toolbar en múltiples lugares
          let toolbar = frameDoc.querySelector('.gjs-toolbar');
          if (!toolbar && frameBody) {
            toolbar = frameBody.querySelector('.gjs-toolbar');
          }

          // Buscar también en el contenedor del canvas
          if (canvasView && canvasView.el) {
            const canvasEl = canvasView.el;
            if (!toolbar) {
              toolbar = canvasEl.querySelector('.gjs-toolbar');
            }
          }

          // Buscar en el documento principal también
          if (!toolbar) {
            toolbar = document.querySelector('.gjs-toolbar');
          }

          if (toolbar) {
            const toolbarItems = toolbar.querySelectorAll('.gjs-toolbar-item');

            // Solo crear botón manual si el toolbar está completamente vacío
            // Si GrapesJS ya generó botones, NO crear botón manual para evitar duplicados
            if (toolbarItems.length === 0) {
              // El toolbar está completamente vacío, crear botón manual como último recurso
              try {
                const deleteBtn = frameDoc.createElement('div');
                deleteBtn.className = 'gjs-toolbar-item';
                deleteBtn.innerHTML = '<i class="fa fa-trash"></i>';
                deleteBtn.title = 'Eliminar';
                deleteBtn.setAttribute('data-toolbar-action', 'delete');
                deleteBtn.style.cursor = 'pointer';
                deleteBtn.style.display = 'flex';
                deleteBtn.style.alignItems = 'center';
                deleteBtn.style.justifyContent = 'center';
                deleteBtn.style.padding = '5px';
                deleteBtn.style.color = '#fff';
                deleteBtn.style.backgroundColor = '#dc3545';
                deleteBtn.style.borderRadius = '3px';
                deleteBtn.style.margin = '0 2px';
                deleteBtn.style.minWidth = '30px';
                deleteBtn.style.minHeight = '30px';
                deleteBtn.addEventListener('click', (e) => {
                  e.stopPropagation();
                  e.preventDefault();
                  if (component) {
                    console.log('🗑️ [Editor] Eliminando componente background-color');
                    component.remove();
                    editor.select(null);
                  }
                });

                toolbar.appendChild(deleteBtn);
                toolbar.style.display = 'block';
                toolbar.style.visibility = 'visible';
                console.log('✅ [Editor] Botón de eliminar creado manualmente para background-color (toolbar vacío)');
              } catch (error) {
                console.error('❌ [Editor] Error al crear botón manual para background-color:', error);
              }
            } else {
              // El toolbar tiene botones, solo asegurar que sea visible
              // NO crear botón manual si ya hay botones (GrapesJS ya los generó)
              toolbar.style.display = 'block';
              toolbar.style.visibility = 'visible';
              console.log('✅ [Editor] Toolbar ya tiene', toolbarItems.length, 'botones - no crear botón manual duplicado');
            }
          }
        };

        // Ejecutar inmediatamente
        checkAndCreateToolbar();

        // También ejecutar con delays para asegurar que aparezca
        setTimeout(() => {
          checkAndCreateToolbar();

          // Forzar actualización del canvas view
          const canvasView = editor.Canvas.getCanvasView();
          if (canvasView) {
            if (canvasView.updateSelected) {
              canvasView.updateSelected();
            }
            if (canvasView.updateToolbar && typeof canvasView.updateToolbar === 'function') {
              canvasView.updateToolbar();
            }
            if (canvasView.toolbar && typeof canvasView.toolbar.render === 'function') {
              canvasView.toolbar.render(component);
            }
          }

          // Verificar nuevamente después de un delay más largo
          setTimeout(() => {
            checkAndCreateToolbar();
          }, 200);
        }, 50);
      }
    }

    // ✅ CRÍTICO: Si es background-image, asegurar que tenga todas las propiedades necesarias
    if (componentType === 'background-image') {

      console.log('✅ [Editor] Propiedades del background-image actualizadas:', {
        selectable: component.get('selectable'),
        removable: component.get('removable'),
        draggable: component.get('draggable'),
        toolbar: component.get('toolbar'),
        badgable: component.get('badgable'),
        layerable: component.get('layerable')
      });

      // Asegurar atributos en el DOM
      if (component.view && component.view.el) {
        const el = component.view.el;
        el.setAttribute('data-gjs-selectable', 'true');
        el.setAttribute('data-gjs-removable', 'true');
        el.setAttribute('data-gjs-draggable', 'true');
        el.setAttribute('data-gjs-droppable', 'true');
        el.setAttribute('data-gjs-highlightable', 'true');
        el.setAttribute('data-gjs-toolbar', 'true');
        el.setAttribute('data-gjs-layerable', 'true');
        el.setAttribute('data-gjs-copyable', 'true');
        el.setAttribute('data-gjs-badgable', 'true');
        el.setAttribute('data-gjs-hoverable', 'true');

        console.log('✅ [Editor] Atributos DOM del background-image configurados');

        // ✅ Verificar el toolbar en múltiples ubicaciones
        setTimeout(() => {
          const canvasFrame = editor.Canvas.getFrameEl();
          if (canvasFrame && canvasFrame.contentDocument) {
            const frameDoc = canvasFrame.contentDocument;
            const frameBody = frameDoc.body || frameDoc.documentElement;

            // Buscar toolbar en múltiples lugares
            let toolbar = frameDoc.querySelector('.gjs-toolbar');
            if (!toolbar && frameBody) {
              toolbar = frameBody.querySelector('.gjs-toolbar');
            }

            // Buscar también en el contenedor del canvas
            const canvasView = editor.Canvas.getCanvasView();
            if (canvasView && canvasView.el) {
              const canvasEl = canvasView.el;
              if (!toolbar) {
                toolbar = canvasEl.querySelector('.gjs-toolbar');
              }
            }

            // Buscar en el documento principal también
            if (!toolbar) {
              toolbar = document.querySelector('.gjs-toolbar');
            }

            console.log('🔍 [Editor] Toolbar verificado en frame:', frameDoc.querySelector('.gjs-toolbar'));
            console.log('🔍 [Editor] Toolbar verificado en canvasView:', canvasView && canvasView.el ? canvasView.el.querySelector('.gjs-toolbar') : 'canvasView no disponible');
            console.log('🔍 [Editor] Toolbar encontrado final:', toolbar);

            if (toolbar) {
              const toolbarItems = toolbar.querySelectorAll('.gjs-toolbar-item');
              console.log('✅ [Editor] Toolbar encontrado con', toolbarItems.length, 'items');

              // ✅ CRÍTICO: Si el toolbar está vacío o oculto, forzar su actualización
              if (toolbarItems.length === 0 || toolbar.style.display === 'none') {
                console.log('🔄 [Editor] Toolbar vacío u oculto - forzando actualización...');

                // Forzar que sea visible PRIMERO
                toolbar.style.display = 'block';
                toolbar.style.visibility = 'visible';
                toolbar.style.opacity = '1';
                toolbar.removeAttribute('style');
                toolbar.setAttribute('style', 'pointer-events: all; display: block !important; visibility: visible !important; opacity: 1 !important;');

                // Asegurar que el componente tenga las propiedades ANTES de actualizar el toolbar
                component.set({
                  selectable: true,
                  removable: true,
                  toolbar: true,
                  highlightable: true,
                  hoverable: true,
                  badgable: true,
                  layerable: true,
                  draggable: true,
                  copyable: true
                }, { silent: false });

                // Forzar update del canvas view para que renderice el toolbar con los botones
                if (canvasView) {
                  // Actualizar la selección en el canvas view
                  if (canvasView.updateSelected) {
                    canvasView.updateSelected();
                  }

                  // Método 3: Intentar forzar el render del toolbar accediendo a canvasView.toolbarEl
                  if (canvasView.toolbarEl) {
                    console.log('✅ [Editor] canvasView.toolbarEl encontrado');
                    canvasView.toolbarEl.style.display = 'block';
                    canvasView.toolbarEl.style.visibility = 'visible';
                  }

                  // Método 4: Forzar render del toolbar accediendo al CanvasView
                  if (canvasView.toolbar && typeof canvasView.toolbar.render === 'function') {
                    console.log('✅ [Editor] canvasView.toolbar.render encontrado, ejecutando...');
                    canvasView.toolbar.render(component);
                  }

                  // Método 5: Intentar usar el método de GrapesJS para actualizar el toolbar
                  if (canvasView.updateToolbar && typeof canvasView.updateToolbar === 'function') {
                    console.log('✅ [Editor] canvasView.updateToolbar encontrado, ejecutando...');
                    canvasView.updateToolbar();
                  }

                  // Método 6: También intentar usar el método showToolbar si existe
                  if (canvasView.showToolbar && typeof canvasView.showToolbar === 'function') {
                    console.log('✅ [Editor] canvasView.showToolbar encontrado, ejecutando...');
                    canvasView.showToolbar(component);
                  }

                  // Método 7: Trigger del evento component:toolbar:render si existe
                  if (component.trigger) {
                    component.trigger('component:toolbar:render');
                    component.trigger('toolbar:render');
                  }

                  // Método 8: Forzar refresh completo del canvas
                  editor.refresh();
                }

                // Verificar después de un delay
                setTimeout(() => {
                  const newToolbar = canvasView && canvasView.el ? canvasView.el.querySelector('.gjs-toolbar') : null;
                  if (newToolbar) {
                    const newItems = newToolbar.querySelectorAll('.gjs-toolbar-item');
                    console.log('🔍 [Editor] Toolbar después de actualización:', newItems.length, 'items');

                    if (newItems.length === 0) {
                      console.warn('⚠️ [Editor] Toolbar sigue vacío - creando botones manualmente...');

                      // ✅ Crear botones del toolbar manualmente si GrapesJS no los genera
                      try {
                        const deleteBtn = document.createElement('div');
                        deleteBtn.className = 'gjs-toolbar-item';
                        deleteBtn.innerHTML = '<i class="fa fa-trash"></i>';
                        deleteBtn.title = 'Eliminar';
                        deleteBtn.style.cursor = 'pointer';
                        deleteBtn.addEventListener('click', (e) => {
                          e.stopPropagation();
                          if (component) {
                            component.remove();
                            editor.select(null);
                          }
                        });

                        newToolbar.appendChild(deleteBtn);
                        console.log('✅ [Editor] Botón de eliminar creado manualmente');
                      } catch (error) {
                        console.error('❌ [Editor] Error al crear botón manual:', error);
                      }
                    } else {
                      console.log('✅ [Editor] Toolbar ahora tiene', newItems.length, 'items');
                    }
                  }
                }, 300);
              }

              // Verificar que sea visible
              if (toolbar.style.display === 'none' || toolbar.style.visibility === 'hidden') {
                toolbar.style.display = 'block';
                toolbar.style.visibility = 'visible';
              }
            } else {
              console.warn('⚠️ [Editor] Toolbar no encontrado para background-image');
            }
          }
        }, 100);
      }
    }

    // Si es un toggle, asegurar que tenga todas las propiedades necesarias
    if (componentType === 'toggle') {
      console.log('🔄 [Editor] Toggle seleccionado, asegurando propiedades...');

      // Forzar propiedades para asegurar que el toolbar aparezca (igual que Carousel)
      component.set({
        draggable: true,
        selectable: true,
        removable: true,
        toolbar: true,
        highlightable: true,
        hoverable: true,
        badgable: true,
        layerable: true     // ✅ Agregar layerable
      }, { silent: false });

      console.log('✅ [Editor] Propiedades del toggle actualizadas:', {
        selectable: component.get('selectable'),
        removable: component.get('removable'),
        draggable: component.get('draggable'),
        badgable: component.get('badgable'),
        layerable: component.get('layerable')
      });

      // Asegurar atributos en el DOM
      if (component.view && component.view.el) {
        const el = component.view.el;
        el.setAttribute('data-gjs-selectable', 'true');
        el.setAttribute('data-gjs-removable', 'true');
        el.setAttribute('data-gjs-highlightable', 'true');
        el.setAttribute('data-gjs-badgable', 'true');
        el.setAttribute('data-gjs-hoverable', 'true');
        el.style.outline = '2px solid #3b82f6';

        console.log('✅ [Editor] Atributos DOM del toggle configurados');

        // ✅ Verificar el toolbar en múltiples ubicaciones
        setTimeout(() => {
          const canvasFrame = editor.Canvas.getFrameEl();
          if (canvasFrame && canvasFrame.contentDocument) {
            const frameDoc = canvasFrame.contentDocument;
            const frameBody = frameDoc.body || frameDoc.documentElement;

            // Buscar toolbar en múltiples lugares
            let toolbar = frameDoc.querySelector('.gjs-toolbar');
            if (!toolbar && frameBody) {
              toolbar = frameBody.querySelector('.gjs-toolbar');
            }

            // Buscar también en el contenedor del canvas
            const canvasView = editor.Canvas.getCanvasView();
            if (canvasView && canvasView.el) {
              const canvasEl = canvasView.el;
              if (!toolbar) {
                toolbar = canvasEl.querySelector('.gjs-toolbar');
              }
            }

            // Buscar en el documento principal también
            if (!toolbar) {
              toolbar = document.querySelector('.gjs-toolbar');
            }

            console.log('🔍 [Editor] Toolbar verificado en frame:', frameDoc.querySelector('.gjs-toolbar'));
            console.log('🔍 [Editor] Toolbar verificado en canvasView:', canvasView && canvasView.el ? canvasView.el.querySelector('.gjs-toolbar') : 'canvasView no disponible');
            console.log('🔍 [Editor] Toolbar encontrado final:', toolbar);

            if (toolbar) {
              const toolbarItems = toolbar.querySelectorAll('.gjs-toolbar-item');
              console.log('✅ [Editor] Toolbar encontrado con', toolbarItems.length, 'items');

              // ✅ CRÍTICO: Si el toolbar está vacío o oculto, forzar su actualización
              if (toolbarItems.length === 0 || toolbar.style.display === 'none') {
                console.log('🔄 [Editor] Toolbar vacío u oculto - forzando actualización...');

                // Forzar que sea visible PRIMERO
                toolbar.style.display = 'block';
                toolbar.style.visibility = 'visible';
                toolbar.style.opacity = '1';
                toolbar.removeAttribute('style');
                toolbar.setAttribute('style', 'pointer-events: all; display: block !important; visibility: visible !important; opacity: 1 !important;');

                // Asegurar que el componente tenga las propiedades ANTES de actualizar el toolbar
                component.set({
                  selectable: true,
                  removable: true,
                  // ✅ NO establecer toolbar - GrapesJS lo generará automáticamente
                  highlightable: true,
                  hoverable: true,
                  badgable: true,
                  layerable: true,
                  draggable: true
                }, { silent: false });

                // Forzar update del canvas view para que renderice el toolbar con los botones
                const canvasView = editor.Canvas.getCanvasView();
                if (canvasView) {
                  // Actualizar la selección en el canvas view
                  if (canvasView.updateSelected) {
                    canvasView.updateSelected();
                  }

                  // Intentar acceder al toolbar de GrapesJS y forzar su renderizado
                  // El toolbar está en el CanvasView

                  // Método 1: Intentar acceder directamente al toolbar manager de GrapesJS
                  if (editor.Toolbar) {
                    console.log('✅ [Editor] Editor.Toolbar encontrado, forzando render...');
                    // El Toolbar de GrapesJS puede tener un método para renderizar
                  }

                  // Método 2: Forzar render accediendo a través del Canvas
                  if (editor.Canvas && editor.Canvas.getToolbarEl) {
                    const toolbarEl = editor.Canvas.getToolbarEl();
                    if (toolbarEl) {
                      console.log('✅ [Editor] Toolbar element encontrado vía Canvas.getToolbarEl()');
                    }
                  }

                  // Método 3: Intentar forzar el render del toolbar accediendo a canvasView.toolbarEl
                  if (canvasView.toolbarEl) {
                    console.log('✅ [Editor] canvasView.toolbarEl encontrado');
                    // No limpiar, solo forzar que sea visible
                    canvasView.toolbarEl.style.display = 'block';
                    canvasView.toolbarEl.style.visibility = 'visible';
                  }

                  // Método 4: Forzar render del toolbar accediendo al CanvasView
                  if (canvasView.toolbar && typeof canvasView.toolbar.render === 'function') {
                    console.log('✅ [Editor] canvasView.toolbar.render encontrado, ejecutando...');
                    canvasView.toolbar.render(component);
                  }

                  // Método 5: Intentar usar el método de GrapesJS para actualizar el toolbar
                  if (canvasView.updateToolbar && typeof canvasView.updateToolbar === 'function') {
                    console.log('✅ [Editor] canvasView.updateToolbar encontrado, ejecutando...');
                    canvasView.updateToolbar();
                  }

                  // Método 6: También intentar usar el método showToolbar si existe
                  if (canvasView.showToolbar && typeof canvasView.showToolbar === 'function') {
                    console.log('✅ [Editor] canvasView.showToolbar encontrado, ejecutando...');
                    canvasView.showToolbar(component);
                  }

                  // Método 7: Trigger del evento component:toolbar:render si existe
                  if (component.trigger) {
                    component.trigger('component:toolbar:render');
                    component.trigger('toolbar:render');
                  }

                  // Método 8: Forzar refresh completo del canvas (usar refresh, no updateCanvas)
                  editor.refresh();
                }

                // ✅ NO re-seleccionar para evitar loops infinitos
                // En su lugar, solo verificar una vez más después de un delay
                setTimeout(() => {
                  const newToolbar = canvasView && canvasView.el ? canvasView.el.querySelector('.gjs-toolbar') : null;
                  if (newToolbar) {
                    const newItems = newToolbar.querySelectorAll('.gjs-toolbar-item');
                    console.log('🔍 [Editor] Toolbar después de actualización:', newItems.length, 'items');

                    if (newItems.length === 0) {
                      console.warn('⚠️ [Editor] Toolbar sigue vacío - creando botones manualmente...');

                      // ✅ Crear botones del toolbar manualmente si GrapesJS no los genera
                      try {
                        const deleteBtn = document.createElement('div');
                        deleteBtn.className = 'gjs-toolbar-item';
                        deleteBtn.innerHTML = '<i class="fa fa-trash"></i>';
                        deleteBtn.title = 'Eliminar';
                        deleteBtn.style.cursor = 'pointer';
                        deleteBtn.addEventListener('click', (e) => {
                          e.stopPropagation();
                          if (component) {
                            component.remove();
                            editor.select(null);
                          }
                        });

                        toolbar.appendChild(deleteBtn);
                        console.log('✅ [Editor] Botón de eliminar creado manualmente');
                      } catch (error) {
                        console.error('❌ [Editor] Error al crear botón manual:', error);
                      }
                    } else {
                      console.log('✅ [Editor] Toolbar ahora tiene', newItems.length, 'items');
                    }
                  }
                }, 300);
              }

              // Verificar que sea visible
              const style = window.getComputedStyle(toolbar);
              console.log('🔍 [Editor] Toolbar estilo:', {
                display: style.display,
                visibility: style.visibility,
                opacity: style.opacity
              });
            } else {
              console.warn('⚠️ [Editor] Toolbar NO encontrado en ningún lugar');
              console.log('🔍 [Editor] Propiedades del componente:', {
                selectable: component.get('selectable'),
                removable: component.get('removable'),
                draggable: component.get('draggable'),
                badgable: component.get('badgable'),
                layerable: component.get('layerable')
              });

              // ✅ Intentar forzar creación del toolbar de múltiples formas
              console.log('🔄 [Editor] Intentando forzar creación del toolbar...');

              // Método 1: Actualizar canvas
              editor.refresh();

              // Método 2: Forzar actualización del canvas view
              if (canvasView) {
                if (canvasView.updateSelected) {
                  canvasView.updateSelected();
                }

                // Forzar re-render del canvas view
                if (canvasView.updateCanvas) {
                  canvasView.updateCanvas();
                }

                // Intentar trigger del evento de selección
                if (canvasView.trigger) {
                  canvasView.trigger('component:select', component);
                }
              }

              // Método 3: Ejecutar comando de toolbar si existe
              if (editor.Commands && editor.Commands.has('core:component-toolbar')) {
                try {
                  editor.Commands.run('core:component-toolbar');
                  console.log('✅ [Editor] Comando core:component-toolbar ejecutado');
                } catch (e) {
                  console.log('⚠️ [Editor] No se pudo ejecutar core:component-toolbar:', e);
                }
              }

              // Método 4: Deseleccionar y volver a seleccionar para forzar render
              setTimeout(() => {
                editor.select(null);
                setTimeout(() => {
                  editor.select(component);

                  // Buscar nuevamente después de re-seleccionar
                  setTimeout(() => {
                    toolbar = frameDoc.querySelector('.gjs-toolbar') ||
                      (frameBody ? frameBody.querySelector('.gjs-toolbar') : null) ||
                      (canvasView && canvasView.el ? canvasView.el.querySelector('.gjs-toolbar') : null);

                    if (toolbar) {
                      console.log('✅ [Editor] Toolbar encontrado después de re-seleccionar');

                      // Asegurar visibilidad
                      toolbar.style.display = 'block';
                      toolbar.style.visibility = 'visible';
                      toolbar.style.opacity = '1';
                    } else {
                      console.error('❌ [Editor] Toolbar AÚN NO encontrado después de todos los intentos');
                    }
                  }, 150);
                }, 50);
              }, 100);
            }
          }
        }, 600);
      }
    }
  });

  // Cargar formularios cuando se selecciona el bloque de formulario
  editor.on('component:selected', function (component) {
    // ✅ Actualizar formulario para componentes Verse, Code, Paragraph y Heading cuando se seleccionan
    let componentType = component.get('type');

    if (componentType === 'verse') {
      console.log('🎯 [Editor] Componente Verse seleccionado');

      // ✅ CRÍTICO: Sincronizar el modelo ANTES de que se renderice el TraitManager
      // Esto es lo que hace BackgroundImage - sincroniza primero, luego GrapesJS renderiza con los valores correctos
      if (component.syncContentFromDOM && typeof component.syncContentFromDOM === 'function') {
        // Sincronizar inmediatamente (sin setTimeout) para que el modelo tenga los valores antes del render
        component.syncContentFromDOM();

        // Forzar re-render del TraitManager después de sincronizar
        setTimeout(() => {
          if (editor.TraitManager && editor.TraitManager.render) {
            editor.TraitManager.render();
            console.log('✅ [Editor] TraitManager re-renderizado para Verse');

            // ✅ CRÍTICO: Forzar actualización de los inputs después del render
            // Usar múltiples intentos porque el render puede tardar
            const updateVerseInputs = (attempt = 1) => {
              const modelContent = component.get('verse-content') || '';
              const modelAuthor = component.get('verse-author') || '';

              // Buscar inputs con múltiples selectores
              const contentInput = document.querySelector('textarea[name="verse-content"]') ||
                document.querySelector('.traits-container textarea[data-name="verse-content"]') ||
                document.querySelector('.gjs-trt-trait[data-trait-name="verse-content"] textarea') ||
                document.querySelector('.gjs-trt-trait textarea');
              const authorInput = document.querySelector('input[name="verse-author"]') ||
                document.querySelector('.traits-container input[data-name="verse-author"]') ||
                document.querySelector('.gjs-trt-trait[data-trait-name="verse-author"] input') ||
                document.querySelector('.gjs-trt-trait input[type="text"]');

              console.log(`🔍 [Editor] Intento ${attempt} - Inputs encontrados:`, {
                content: !!contentInput,
                author: !!authorInput,
                contentValue: contentInput ? contentInput.value.substring(0, 30) : 'N/A',
                modelContent: modelContent.substring(0, 30)
              });

              if (contentInput) {
                if (contentInput.value !== modelContent) {
                  contentInput.value = modelContent;
                  // Disparar eventos para que GrapesJS lo detecte
                  contentInput.dispatchEvent(new Event('input', { bubbles: true }));
                  contentInput.dispatchEvent(new Event('change', { bubbles: true }));
                  console.log('✅ [Editor] Input de contenido Verse actualizado manualmente');
                } else {
                  console.log('ℹ️ [Editor] Input de contenido Verse ya tiene el valor correcto');
                }
              } else if (attempt < 5) {
                console.warn(`⚠️ [Editor] No se encontró input de contenido Verse, reintentando...`);
                setTimeout(() => updateVerseInputs(attempt + 1), 100);
                return;
              } else {
                console.warn('⚠️ [Editor] No se encontró input de contenido Verse después de 5 intentos');
              }

              if (authorInput) {
                if (authorInput.value !== modelAuthor) {
                  authorInput.value = modelAuthor;
                  // Disparar eventos para que GrapesJS lo detecte
                  authorInput.dispatchEvent(new Event('input', { bubbles: true }));
                  authorInput.dispatchEvent(new Event('change', { bubbles: true }));
                  console.log('✅ [Editor] Input de autor Verse actualizado manualmente');
                } else {
                  console.log('ℹ️ [Editor] Input de autor Verse ya tiene el valor correcto');
                }
              } else if (attempt < 5) {
                console.warn(`⚠️ [Editor] No se encontró input de autor Verse, reintentando...`);
                setTimeout(() => updateVerseInputs(attempt + 1), 100);
                return;
              } else {
                console.warn('⚠️ [Editor] No se encontró input de autor Verse después de 5 intentos');
              }
            };

            setTimeout(() => updateVerseInputs(1), 200);
          }
        }, 50);
      }
    }

    if (componentType === 'code') {
      console.log('🎯 [Editor] Componente Code seleccionado');

      // ✅ CRÍTICO: Sincronizar el modelo ANTES de que se renderice el TraitManager
      // Esto es lo que hace BackgroundImage - sincroniza primero, luego GrapesJS renderiza con los valores correctos
      if (component.syncContentFromDOM && typeof component.syncContentFromDOM === 'function') {
        // Sincronizar inmediatamente (sin setTimeout) para que el modelo tenga los valores antes del render
        component.syncContentFromDOM();

        // Forzar re-render del TraitManager después de sincronizar
        setTimeout(() => {
          if (editor.TraitManager && editor.TraitManager.render) {
            editor.TraitManager.render();
            console.log('✅ [Editor] TraitManager re-renderizado para Code');

            // ✅ CRÍTICO: Forzar actualización de los inputs después del render
            const updateCodeInputs = (attempt = 1) => {
              const modelContent = component.get('code-content') || '';

              const contentInput = document.querySelector('textarea[name="code-content"]') ||
                document.querySelector('.traits-container textarea[data-name="code-content"]') ||
                document.querySelector('.gjs-trt-trait[data-trait-name="code-content"] textarea') ||
                document.querySelector('.gjs-trt-trait textarea');

              console.log(`🔍 [Editor] Intento ${attempt} - Input Code encontrado:`, {
                found: !!contentInput,
                currentValue: contentInput ? contentInput.value.substring(0, 30) : 'N/A',
                modelContent: modelContent.substring(0, 30)
              });

              if (contentInput) {
                if (contentInput.value !== modelContent) {
                  contentInput.value = modelContent;
                  // Disparar eventos para que GrapesJS lo detecte
                  contentInput.dispatchEvent(new Event('input', { bubbles: true }));
                  contentInput.dispatchEvent(new Event('change', { bubbles: true }));
                  console.log('✅ [Editor] Input de contenido Code actualizado manualmente');
                } else {
                  console.log('ℹ️ [Editor] Input de contenido Code ya tiene el valor correcto');
                }
              } else if (attempt < 5) {
                console.warn(`⚠️ [Editor] No se encontró input de contenido Code, reintentando...`);
                setTimeout(() => updateCodeInputs(attempt + 1), 100);
              } else {
                console.warn('⚠️ [Editor] No se encontró input de contenido Code después de 5 intentos');
              }
            };

            setTimeout(() => updateCodeInputs(1), 200);
          }
        }, 50);
      }
    }

    if (componentType === 'paragraph') {
      console.log('🎯 [Editor] Componente Paragraph seleccionado');

      // ✅ CRÍTICO: Sincronizar el modelo ANTES de que se renderice el TraitManager
      if (component.syncContentFromDOM && typeof component.syncContentFromDOM === 'function') {
        // Sincronizar inmediatamente (sin setTimeout) para que el modelo tenga los valores antes del render
        component.syncContentFromDOM();

        // Forzar re-render del TraitManager después de sincronizar
        setTimeout(() => {
          if (editor.TraitManager && editor.TraitManager.render) {
            editor.TraitManager.render();
            console.log('✅ [Editor] TraitManager re-renderizado para Paragraph');

            // ✅ CRÍTICO: Forzar actualización de los inputs después del render
            const updateParagraphInputs = (attempt = 1) => {
              const modelText = component.get('paragraph-text') || '';

              const textInput = document.querySelector('input[name="paragraph-text"]') ||
                document.querySelector('.traits-container input[data-name="paragraph-text"]') ||
                document.querySelector('.gjs-trt-trait[data-trait-name="paragraph-text"] input') ||
                document.querySelector('.gjs-trt-trait input[type="text"]');

              console.log(`🔍 [Editor] Intento ${attempt} - Input Paragraph encontrado:`, {
                found: !!textInput,
                currentValue: textInput ? textInput.value.substring(0, 30) : 'N/A',
                modelText: modelText.substring(0, 30)
              });

              if (textInput) {
                if (textInput.value !== modelText) {
                  textInput.value = modelText;
                  // Disparar eventos para que GrapesJS lo detecte
                  textInput.dispatchEvent(new Event('input', { bubbles: true }));
                  textInput.dispatchEvent(new Event('change', { bubbles: true }));
                  console.log('✅ [Editor] Input de texto Paragraph actualizado manualmente');
                } else {
                  console.log('ℹ️ [Editor] Input de texto Paragraph ya tiene el valor correcto');
                }
              } else if (attempt < 5) {
                console.warn(`⚠️ [Editor] No se encontró input de texto Paragraph, reintentando...`);
                setTimeout(() => updateParagraphInputs(attempt + 1), 100);
              } else {
                console.warn('⚠️ [Editor] No se encontró input de texto Paragraph después de 5 intentos');
              }
            };

            setTimeout(() => updateParagraphInputs(1), 200);
          }
        }, 50);
      }
    }

    if (componentType === 'heading') {
      console.log('🎯 [Editor] Componente Heading seleccionado');

      // ✅ CRÍTICO: Sincronizar el modelo ANTES de que se renderice el TraitManager
      if (component.syncContentFromDOM && typeof component.syncContentFromDOM === 'function') {
        // Sincronizar inmediatamente (sin setTimeout) para que el modelo tenga los valores antes del render
        component.syncContentFromDOM();

        // Forzar re-render del TraitManager después de sincronizar
        setTimeout(() => {
          if (editor.TraitManager && editor.TraitManager.render) {
            editor.TraitManager.render();
            console.log('✅ [Editor] TraitManager re-renderizado para Heading');

            // ✅ CRÍTICO: Forzar actualización de los inputs después del render
            const updateHeadingInputs = (attempt = 1) => {
              const modelText = component.get('heading-text') || '';

              const textInput = document.querySelector('input[name="heading-text"]') ||
                document.querySelector('.traits-container input[data-name="heading-text"]') ||
                document.querySelector('.gjs-trt-trait[data-trait-name="heading-text"] input') ||
                document.querySelector('.gjs-trt-trait input[type="text"]');

              console.log(`🔍 [Editor] Intento ${attempt} - Input Heading encontrado:`, {
                found: !!textInput,
                currentValue: textInput ? textInput.value.substring(0, 30) : 'N/A',
                modelText: modelText.substring(0, 30)
              });

              if (textInput) {
                if (textInput.value !== modelText) {
                  textInput.value = modelText;
                  // Disparar eventos para que GrapesJS lo detecte
                  textInput.dispatchEvent(new Event('input', { bubbles: true }));
                  textInput.dispatchEvent(new Event('change', { bubbles: true }));
                  console.log('✅ [Editor] Input de texto Heading actualizado manualmente');
                } else {
                  console.log('ℹ️ [Editor] Input de texto Heading ya tiene el valor correcto');
                }
              } else if (attempt < 5) {
                console.warn(`⚠️ [Editor] No se encontró input de texto Heading, reintentando...`);
                setTimeout(() => updateHeadingInputs(attempt + 1), 100);
              } else {
                console.warn('⚠️ [Editor] No se encontró input de texto Heading después de 5 intentos');
              }
            };

            setTimeout(() => updateHeadingInputs(1), 200);
          }
        }, 50);
      }
    }

    // Continuar con el código original...
    // Forzar actualización del TraitManager para componentes refactorizados
    componentType = component.get('type'); // Reutilizar la variable ya declarada
    const refactoredComponents = ['text', 'heading', 'paragraph', 'button', 'container', 'image'];

    if (refactoredComponents.includes(componentType)) {
      console.log('🔄 Componente refactorizado seleccionado:', componentType);

      // Sincronizar contenedores cuando se seleccionan
      if (componentType === 'container') {
        setTimeout(() => {
          if (component.view && component.view.el) {
            const el = component.view.el;
            // Asegurar que tenga las clases básicas
            if (!el.className.includes('container-flex')) {
              el.classList.add('container-flex');
            }
            if (!el.className.includes('flex')) {
              el.classList.add('flex');
            }
            // Actualizar atributos en el modelo
            const currentClass = el.className;
            component.setAttributes({ class: currentClass });
            console.log('✅ Contenedor sincronizado:', currentClass);
          }
        }, 50);
      }

      // ✅ El manejo de imágenes se hace completamente en el componente image.js
      // No es necesario duplicar código aquí - el componente image.js maneja:
      // - Inicialización con imagen por defecto
      // - Doble clic para abrir galería
      // - Actualización de imagen desde galería
      // - Sincronización de src

      // Si el componente tiene un método de sincronización, ejecutarlo
      if (componentType === 'button') {
        console.log('🔍 Verificando método syncInitialValues en botón...');
        console.log('🔍 syncInitialValues existe?', typeof component.syncInitialValues);
        console.log('🔍 Componente completo:', component);

        if (typeof component.syncInitialValues === 'function') {
          console.log('🔄 Sincronizando botón desde component:selected...');
          try {
            // Ejecutar sincronización inmediatamente
            component.syncInitialValues();
            console.log('✅ syncInitialValues ejecutado');
          } catch (error) {
            console.error('❌ Error ejecutando syncInitialValues:', error);
          }

          // Forzar actualización del TraitManager después de sincronizar
          setTimeout(() => {
            if (editor.TraitManager) {
              // Establecer el componente como target (método compatible)
              if (typeof editor.TraitManager.setTarget === 'function') {
                editor.TraitManager.setTarget(component);
              } else {
                editor.TraitManager.component = component;
              }

              // Forzar actualización de todos los traits del botón
              const buttonTraits = ['button-text', 'button-href', 'button-target', 'button-style', 'button-size', 'button-width', 'button-align', 'button-radius'];
              console.log('🔄 Actualizando traits del botón...');
              buttonTraits.forEach(traitName => {
                const value = component.get(traitName);
                console.log(`  - ${traitName}:`, value);
                if (value !== undefined && value !== null && value !== '') {
                  // Establecer el valor en el modelo
                  component.set(traitName, value, { silent: false });
                  // Forzar actualización del trait
                  component.trigger(`change:${traitName}`, component, value);
                  console.log(`✅ Trait ${traitName} establecido:`, value);
                }
              });

              // Renderizar el TraitManager
              editor.TraitManager.render();
              console.log('✅ TraitManager actualizado');
            }
          }, 200);
        } else {
          console.warn('⚠️ syncInitialValues no es una función, intentando sincronización manual...');
          // Sincronización manual si el método no está disponible
          if (component.view && component.view.el) {
            const el = component.view.el;
            const classList = (el.className || '').split(' ').filter(c => c.trim());
            const textContent = el.textContent || el.innerText || '';

            console.log('📝 Sincronización manual - Texto:', textContent);
            console.log('📝 Sincronización manual - Clases:', classList);

            if (textContent.trim()) {
              component.set('button-text', textContent.trim(), { silent: false });
              console.log('✅ Texto establecido:', textContent.trim());
            } else {
              component.set('button-text', '', { silent: false });
              console.log('ℹ️ Sin texto, estableciendo vacío');
            }

            const href = el.getAttribute('href') || '#';
            component.set('button-href', href, { silent: false });
            console.log('✅ Href establecido:', href);

            const target = el.getAttribute('target') || '_self';
            component.set('button-target', target, { silent: false });
            console.log('✅ Target establecido:', target);

            // Detectar estilo - buscar cualquier bg-color y hover:bg-color
            const styleOptions = [
              { value: 'bg-blue-600 hover:bg-blue-700', color: 'blue' },
              { value: 'bg-gray-600 hover:bg-gray-700', color: 'gray' },
              { value: 'bg-green-600 hover:bg-green-700', color: 'green' },
              { value: 'bg-red-600 hover:bg-red-700', color: 'red' },
              { value: 'bg-yellow-600 hover:bg-yellow-700', color: 'yellow' },
              { value: 'bg-purple-600 hover:bg-purple-700', color: 'purple' },
              { value: 'bg-pink-600 hover:bg-pink-700', color: 'pink' }
            ];

            // Buscar cualquier clase bg-color-XXX
            const bgClass = classList.find(c => c.match(/^bg-(blue|gray|green|red|yellow|purple|pink)-\d+$/));
            if (bgClass) {
              const colorMatch = bgClass.match(/^bg-(\w+)-\d+$/);
              if (colorMatch) {
                const color = colorMatch[1];
                const styleMatch = styleOptions.find(opt => opt.color === color);
                if (styleMatch) {
                  component.set('button-style', styleMatch.value, { silent: false });
                  console.log('✅ Estilo detectado:', styleMatch.value, '(basado en:', bgClass, ')');
                }
              }
            }

            // Detectar tamaño
            const sizeOptions = [
              { value: 'px-4 py-2 text-sm', px: 'px-4', py: 'py-2', text: 'text-sm' },
              { value: 'px-6 py-2 text-base', px: 'px-6', py: 'py-2', text: 'text-base' },
              { value: 'px-8 py-3 text-lg', px: 'px-8', py: 'py-3', text: 'text-lg' },
              { value: 'px-10 py-4 text-xl', px: 'px-10', py: 'py-4', text: 'text-xl' }
            ];
            let sizeMatch = sizeOptions.find(opt =>
              classList.includes(opt.px) && classList.includes(opt.py) && classList.includes(opt.text)
            );
            if (!sizeMatch) {
              const textSizeClass = classList.find(c => ['text-sm', 'text-base', 'text-lg', 'text-xl'].includes(c));
              if (textSizeClass) {
                sizeMatch = sizeOptions.find(opt => opt.text === textSizeClass);
              }
            }
            if (sizeMatch) {
              component.set('button-size', sizeMatch.value, { silent: false });
              console.log('✅ Tamaño detectado:', sizeMatch.value);
            }

            // Detectar ancho
            const widthClasses = ['w-auto', 'w-full', 'w-24', 'w-32', 'w-40', 'w-48', 'w-64', 'w-1/2', 'w-1/3', 'w-2/3', 'w-3/4'];
            const widthMatch = classList.find(c => widthClasses.includes(c));
            if (widthMatch) {
              component.set('button-width', widthMatch, { silent: false });
              console.log('✅ Ancho detectado:', widthMatch);
            } else {
              // Si no hay ancho específico, dejar vacío
              component.set('button-width', '', { silent: false });
              console.log('ℹ️ Sin ancho específico, usando automático');
            }

            // Detectar alineación
            if (classList.includes('mx-auto')) {
              component.set('button-align', 'block mx-auto', { silent: false });
              console.log('✅ Alineación detectada: Centrado');
            } else if (classList.includes('ml-auto')) {
              component.set('button-align', 'block ml-auto', { silent: false });
              console.log('✅ Alineación detectada: Derecha');
            } else if (classList.includes('mr-auto')) {
              component.set('button-align', 'block mr-auto', { silent: false });
              console.log('✅ Alineación detectada: Izquierda');
            } else {
              component.set('button-align', '', { silent: false });
              console.log('ℹ️ Sin alineación específica');
            }

            // Detectar bordes redondeados
            const radiusOptions = [
              { value: 'rounded-none', class: 'rounded-none' },
              { value: 'rounded', class: 'rounded' },
              { value: 'rounded-md', class: 'rounded-md' },
              { value: 'rounded-lg', class: 'rounded-lg' },
              { value: 'rounded-full', class: 'rounded-full' }
            ];
            const radiusMatch = radiusOptions.find(opt => classList.includes(opt.class));
            if (radiusMatch) {
              component.set('button-radius', radiusMatch.value, { silent: false });
              console.log('✅ Radio detectado:', radiusMatch.value);
            } else {
              // Si no hay radio específico, usar rounded-md por defecto
              component.set('button-radius', 'rounded-md', { silent: false });
              console.log('ℹ️ Sin radio específico, usando rounded-md');
            }

            // Forzar actualización del TraitManager después de establecer todos los valores
            setTimeout(() => {
              if (editor.TraitManager) {
                console.log('🔄 Renderizando TraitManager con valores sincronizados...');

                // Verificar que los valores se establecieron correctamente
                const buttonTraits = ['button-text', 'button-href', 'button-target', 'button-style', 'button-size', 'button-width', 'button-align', 'button-radius'];
                console.log('📋 Valores establecidos en el modelo:');
                buttonTraits.forEach(traitName => {
                  const value = component.get(traitName);
                  console.log(`  - ${traitName}:`, value);
                });

                // Usar el método correcto para establecer el target
                if (typeof editor.TraitManager.setTarget === 'function') {
                  editor.TraitManager.setTarget(component);
                } else {
                  // Método alternativo: establecer el componente directamente
                  editor.TraitManager.component = component;
                }

                // Asegurar que los traits estén definidos en el modelo
                const currentTraits = component.get('traits') || [];
                console.log('📋 Traits actuales en el modelo:', currentTraits.length);

                // Si no hay 8 traits, forzar la actualización de los traits desde defaults
                if (currentTraits.length < 8) {
                  console.log('⚠️ Faltan traits, forzando actualización desde defaults...');
                  // Obtener los traits desde el tipo de componente
                  const componentType = editor.DomComponents.getType('button');
                  if (componentType && componentType.model && componentType.model.defaults && componentType.model.defaults.traits) {
                    component.set('traits', componentType.model.defaults.traits, { silent: false });
                    console.log('✅ Traits actualizados desde defaults');
                  }
                }

                // Forzar actualización de los traits antes de renderizar
                buttonTraits.forEach(traitName => {
                  const value = component.get(traitName);
                  if (value !== undefined) {
                    // Asegurar que el valor esté en el modelo
                    component.set(traitName, value, { silent: false });
                  }
                });

                // Renderizar el TraitManager
                editor.TraitManager.render();

                // Verificar cuántos traits se renderizaron
                setTimeout(() => {
                  const traitsRendered = document.querySelectorAll('.traits-container .gjs-trt-trait').length;
                  console.log(`✅ TraitManager actualizado (sincronización manual) - Traits renderizados: ${traitsRendered}`);
                }, 100);
              }
            }, 200);
          }
        }
      }

      // Asegurar que el TraitManager se actualice
      setTimeout(() => {
        if (editor.TraitManager) {
          // Intentar usar setTarget si está disponible
          if (typeof editor.TraitManager.setTarget === 'function') {
            editor.TraitManager.setTarget(component);
          }

          // Forzar renderizado
          editor.TraitManager.render();

          // Verificar que se renderizaron los traits
          setTimeout(() => {
            const traitsInContainer = document.querySelectorAll('.traits-container .gjs-trt-trait');
            console.log('📋 Traits renderizados:', traitsInContainer.length);

            if (traitsInContainer.length === 0) {
              console.warn('⚠️ No se renderizaron traits, intentando método alternativo...');

              // Método alternativo: forzar actualización del componente
              component.trigger('change:traits');
              component.trigger('change:attributes');

              // Re-renderizar
              editor.TraitManager.render();

              // Si aún no funciona, usar el sistema personalizado
              setTimeout(() => {
                const traitsStillEmpty = document.querySelectorAll('.traits-container .gjs-trt-trait').length === 0;
                if (traitsStillEmpty && window.renderCustomTraits) {
                  console.log('🔄 Usando sistema de traits personalizado...');
                  window.renderCustomTraits(component);
                }
              }, 300);
            }
          }, 200);
        }
      }, 100);
    }

    // Si es el bloque de formulario, cargar formularios disponibles
    const isFormBlock = component.get('type') === 'form-dynamic' || component.get('attributes')?.class === 'gjs-block-form';
    if (isFormBlock) {
      console.log('📋 Bloque de formulario seleccionado, cargando formularios disponibles...');

      const websiteId = window.websiteId;
      if (websiteId) {
        // Obtener formularios del website
        fetch(`/creator/api/websites/${websiteId}/forms`, {
          method: 'GET',
          headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          }
        })
          .then(response => response.json())
          .then(data => {
            if (data && data.data) {
              // Encontrar el trait de form-id y actualizar sus opciones
              const traits = component.get('traits');
              const formIdTrait = traits.find(t => t.get('name') === 'form-id');

              if (formIdTrait) {
                // Crear opciones desde los formularios
                const options = [
                  { value: '', name: '-- Selecciona un formulario --' }
                ];

                data.data.forEach(form => {
                  options.push({
                    value: form.id.toString(),
                    name: form.name || form.slug
                  });
                });

                formIdTrait.set('options', options);

                // Forzar renderizado del TraitManager
                if (editor.TraitManager) {
                  editor.TraitManager.render();
                }
              }
            }
          })
          .catch(error => {
            console.error('❌ Error al cargar formularios:', error);
          });
      }
    }

    // Debug específico para carrusel
    if (component.get('type') === 'carousel') {
      // El TraitManager se actualiza automáticamente cuando se selecciona un componente
      // No es necesario llamar a setTarget manualmente
      setTimeout(() => {
        if (editor.TraitManager) {
          editor.TraitManager.render();
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
        'video': 'Video',
        'youtube-video': 'YouTube',
        'google-maps': 'Google Maps',
        'image-box-advanced': 'Caja de Imagen Avanzada',
        'background-image': 'Imagen de Fondo',
        'file': 'Archivo',
        'audio': 'Reproductor de Audio',
        'carousel': 'Carrusel',
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
    // YouTube
    if (componentType === 'youtube-video') {
      // Forzar la actualización del TraitManager para YouTube
      setTimeout(() => {
        if (editor.TraitManager) {
          editor.TraitManager.render();
        }
      }, 100);
    }

    // Imagen
    if (componentType === 'image') {
      // Log deshabilitado para reducir ruido en consola
      // console.log('🖼️ Componente de Imagen seleccionado:', {
      //   tipo: componentType,
      //   nombre: component.get('name'),
      //   src: component.get('src'),
      //   alt: component.get('alt'),
      //   traits: component.get('traits'),
      //   cantidadTraits: component.get('traits')?.length || 0
      // });

      // Forzar la actualización del TraitManager para Imagen
      setTimeout(() => {
        if (editor.TraitManager) {
          editor.TraitManager.render();
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
      // Sincronizar URLs si el componente tiene el método
      if (component.syncImageUrls) {
        component.syncImageUrls();
      }

      // Forzar la actualización del TraitManager para Galería
      setTimeout(() => {
        if (editor.TraitManager) {
          editor.TraitManager.render();
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
    const widgetTypes = ['button', 'image', 'heading', 'paragraph', 'text', 'link', 'divider', 'icon', 'icon-box', 'section', 'container', 'column', 'video', 'youtube-video', 'google-maps'];

    // Obtener selectores actuales
    const currentSelectors = component.getSelectors ? component.getSelectors() : null;
    const currentSelectorsCount = currentSelectors ? currentSelectors.length : 0;

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
    }

    // Forzar actualización del StyleManager cuando se selecciona un componente
    setTimeout(() => {
      if (editor.StyleManager) {
        // Forzar renderizado completo del StyleManager
        editor.StyleManager.render();

        // Obtener los contenedores
        const stylesContainer = document.querySelector('.styles-container');
        const stylesContainerWidget = document.querySelector('.styles-container-widget');


        if (stylesContainer && stylesContainerWidget) {
          // Esperar a que el StyleManager se haya renderizado completamente
          setTimeout(() => {
            // Buscar el contenedor completo del StyleManager
            const smContainer = stylesContainer.querySelector('.gjs-sm-sectors') ||
              stylesContainer.querySelector('[data-gjs-type="sectors"]') ||
              stylesContainer.firstElementChild;


            if (smContainer) {
              const sectorsCount = smContainer.querySelectorAll('.gjs-sm-sector').length;

              // Limpiar el contenedor de widgets
              stylesContainerWidget.innerHTML = '';

              // MOVER (no clonar) el contenedor completo para mantener toda la funcionalidad
              stylesContainerWidget.appendChild(smContainer);

            } else {
              // StyleManager no encontrado (log removido)
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
  // Evento cuando se actualiza un componente (incluye cambios de estilo)
  // Log deshabilitado para reducir ruido en consola
  // editor.on('component:update', function(component) {
  //   const componentType = component.get('type');
  //   const componentId = component.getId();
  //   console.log('🔄 COMPONENTE ACTUALIZADO:', {
  //     id: componentId,
  //     tipo: componentType,
  //     estilos: component.getStyle(),
  //     atributos: component.getAttributes()
  //   });
  // });

  // Evento cuando cambia el estilo de un componente específico
  editor.on('component:styleUpdate', function (component) {
    const componentId = component.getId();
    const styles = component.getStyle();

    // CSS se genera automáticamente por GrapesJS
  });

  // Evento cuando se añade una regla CSS
  // Log deshabilitado para reducir ruido en consola
  // editor.on('style:custom', function(props) {
  //   console.log('📝 REGLA CSS AÑADIDA:', props);
  // });

  // Listener para detectar cambios en el StyleManager
  // Log deshabilitado para reducir ruido en consola
  // editor.on('style:target', function(target) {
  //   console.log('🎯 TARGET DE ESTILOS CAMBIADO:', {
  //     target: target,
  //     selector: target?.getSelectors?.().map(s => s.get('name'))
  //   });
  // });

  // Listener para cambios en las propiedades del StyleManager
  try {
    const sectors = editor.StyleManager.getSectors();
    sectors.each(sector => {
      const properties = sector.get('properties');
      if (properties) {
        properties.each(property => {
          property.on('change:value', function () {
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

            // Log deshabilitado para reducir ruido en consola
            // console.log('💅 PROPIEDAD DE ESTILO MODIFICADA:', {
            //   propiedad: propertyName,
            //   valorNuevo: propertyValue,
            //   componente: selected.get('type'),
            //   componenteId: componentId,
            //   cantidadSelectores: selectors?.length || 0,
            //   selectoresDetallados: selectorDetails,
            //   estilosActuales: selected.getStyle ? selected.getStyle() : {}
            // });

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
                    // Log deshabilitado para reducir ruido en consola
                    // console.log('✅ Estilo aplicado como inline también:', {
                    //   componente: componentId,
                    //   propiedad: propertyName,
                    //   valor: finalValue
                    // });
                  }
                } catch (inlineError) {
                  console.warn('⚠️ No se pudo aplicar estilo inline:', inlineError);
                }

                // Logs deshabilitados para reducir ruido en consola
                // const cssForComponent = editor.getCss().match(new RegExp(`#${componentId.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')}[^{]*\\{[^}]*\\}`, 'g'));
                // console.log('✅ ESTILO FORZADO AL CSS:', {
                //   selector: `#${componentId}`,
                //   propiedad: propertyName,
                //   valorOriginal: propertyValue,
                //   valorFinal: finalValue,
                //   cssDelComponente: cssForComponent ? cssForComponent[0] : 'No encontrado'
                // });
                // if (cssForComponent) {
                //   console.log('📋 CSS completo del botón:', cssForComponent[0]);
                // }

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

  // Sincronizar imágenes después de cargar el contenido
  if (typeof ImageSync !== 'undefined' && ImageSync.syncAfterLoad) {
    ImageSync.syncAfterLoad(editor);
  } else {
    // Fallback si el módulo no está cargado
    setTimeout(() => {
      const imageComponents = editor.DomComponents.getWrapper().find('*').filter(comp => {
        const type = comp.get('type');
        const tagName = comp.get('tagName');
        return type === 'image' || tagName === 'img';
      });

      imageComponents.forEach(imgComp => {
        const currentSrc = imgComp.getAttributes().src;
        if (currentSrc && currentSrc.trim() && currentSrc !== 'undefined') {
          if (imgComp.get('image-src') !== currentSrc) {
            imgComp.set('image-src', currentSrc.trim(), { silent: true });
          }
        }
      });
    }, 500);
  }

  // ✅ CRÍTICO: Sincronizar Background Image después de cargar contenido
  setTimeout(() => {
    const syncBackgroundImageAfterInit = () => {
      const allComponents = editor.getComponents();
      const findBackgroundImage = (components) => {
        if (components && typeof components.forEach === 'function') {
          components.forEach((component) => {
            if (component && component.get && component.get('type') === 'background-image') {
              if (component.view && component.view.el) {
                const titleEl = component.view.el.querySelector('h2');
                const textEl = component.view.el.querySelector('p');
                const buttonEl = component.view.el.querySelector('button, a');

                if (titleEl) {
                  const domTitle = titleEl.textContent || titleEl.innerText || '';
                  if (domTitle.trim()) {
                    component.set('content-title', domTitle.trim(), { silent: false });
                  }
                }

                if (textEl) {
                  const domText = textEl.textContent || textEl.innerText || '';
                  if (domText.trim()) {
                    component.set('content-text', domText.trim(), { silent: false });
                  }
                }

                if (buttonEl) {
                  const domButtonText = buttonEl.textContent || buttonEl.innerText || '';
                  if (domButtonText.trim()) {
                    component.set('button-text', domButtonText.trim(), { silent: false });
                  }

                  const href = buttonEl.getAttribute('href');
                  if (href) {
                    component.set('button-link', href, { silent: false });
                  } else if (buttonEl.tagName === 'BUTTON') {
                    component.set('button-link', '#', { silent: false });
                  }
                }

                // Forzar actualización del TraitManager
                setTimeout(() => {
                  if (editor.TraitManager) {
                    editor.TraitManager.render();
                  }
                }, 100);
              }
            }

            if (component && component.components) {
              const childComponents = component.components();
              if (childComponents) {
                findBackgroundImage(childComponents);
              }
            }
          });
        }
      };
      findBackgroundImage(allComponents);
    };

    syncBackgroundImageAfterInit();
  }, 1000);

  // Función para asignar nombres descriptivos a componentes existentes
  function assignDescriptiveNames() {
    try {
      const allComponents = editor.DomComponents.getWrapper().find('*');

      allComponents.forEach(component => {
        // ✅ CRÍTICO: Validar que el componente existe y tiene el método get
        if (!component || typeof component.get !== 'function') {
          return; // Saltar componentes inválidos
        }

        try {
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
            // ✅ CRÍTICO: Usar { silent: true } para evitar que la actualización del nombre dispare
            // una re-renderización inmediata del LayerManager, que podría estar oculto o no inicializado
            component.set('name', newName, { silent: true });
          }
        } catch (componentError) {
          // Ignorar errores individuales de componentes para continuar con los demás
          console.debug('Error procesando componente individual:', componentError);
        }
      });

      // Actualizar Layer Manager solo una vez al final
      if (editor.LayerManager) {
        // Usar setTimeout para asegurar que se ejecute después de todas las actualizaciones
        setTimeout(() => {
          try {
            editor.LayerManager.render();
          } catch (renderError) {
            console.debug('Error renderizando Layer Manager:', renderError);
          }
        }, 100);
      }

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

  // Listener para cambios de dispositivo - actualizar etiquetas de traits
  editor.on('change:device', function () {
    setTimeout(() => {
      if (typeof window.updateTraitLabelsForDevice === 'function') {
        window.updateTraitLabelsForDevice();
      }
    }, 150);
  });

  // Listener para cuando se selecciona un componente - actualizar etiquetas
  editor.on('component:selected', function (component) {
    // ✅ Asegurar que los traits del componente de imagen se apliquen correctamente
    if (component && component.get('type') === 'image') {
      console.log('🖼️ Componente de imagen seleccionado, verificando traits...');

      // Obtener los traits del componente registrado
      const imageComponentType = editor.DomComponents.getType('image');
      if (imageComponentType && imageComponentType.model && imageComponentType.model.defaults && imageComponentType.model.defaults.traits) {
        const registeredTraits = imageComponentType.model.defaults.traits;

        // Verificar si el componente tiene los traits correctos
        const currentTraits = component.get('traits') || [];
        const hasButtonTrait = currentTraits.some(t => {
          const traitName = typeof t === 'object' && t.name ? t.name : (typeof t === 'string' ? t : null);
          return traitName === 'select-image-gallery';
        });

        // Si no tiene el botón, forzar la actualización de los traits
        if (!hasButtonTrait && registeredTraits.length > 0) {
          console.log('⚠️ El componente de imagen no tiene el botón de galería, actualizando traits...');

          // Establecer los traits desde el componente registrado
          component.set('traits', registeredTraits, { silent: false });

          // Forzar actualización del TraitManager
          setTimeout(() => {
            if (editor.TraitManager) {
              if (typeof editor.TraitManager.setTarget === 'function') {
                editor.TraitManager.setTarget(component);
              }
              editor.TraitManager.render();

              // Verificar que se renderizó el botón
              setTimeout(() => {
                const buttonTrait = document.querySelector('.traits-container [data-trait-name="select-image-gallery"]');
                if (buttonTrait) {
                  console.log('✅ Botón de galería renderizado correctamente');
                } else {
                  console.warn('⚠️ El botón de galería no se renderizó, intentando método alternativo...');
                  // Intentar renderizar nuevamente
                  editor.TraitManager.render();
                }
              }, 100);
            }
          }, 150);
        } else {
          console.log('✅ El componente de imagen ya tiene los traits correctos');
        }
      }
    }

    // ✅ Asegurar que los traits del componente de contenedor se apliquen correctamente
    if (component && component.get('type') === 'container') {
      console.log('📦 Componente de contenedor seleccionado, verificando traits...');

      // Obtener los traits del componente registrado
      const containerComponentType = editor.DomComponents.getType('container');
      if (containerComponentType && containerComponentType.model && containerComponentType.model.defaults && containerComponentType.model.defaults.traits) {
        const registeredTraits = containerComponentType.model.defaults.traits;

        // Verificar si el componente tiene los traits correctos
        const currentTraits = component.get('traits') || [];
        const hasLayoutModeTrait = currentTraits.some(t => {
          const traitName = typeof t === 'object' && t.name ? t.name : (typeof t === 'string' ? t : null);
          return traitName === 'container-layout-mode';
        });

        // Si no tiene el trait de modo de layout, forzar la actualización de los traits
        if (!hasLayoutModeTrait && registeredTraits.length > 0) {
          console.log('⚠️ El componente de contenedor no tiene todos los traits, actualizando...');

          // Establecer los traits desde el componente registrado
          component.set('traits', registeredTraits, { silent: false });

          // Forzar actualización del TraitManager
          setTimeout(() => {
            if (editor.TraitManager) {
              if (typeof editor.TraitManager.setTarget === 'function') {
                editor.TraitManager.setTarget(component);
              }
              editor.TraitManager.render();

              // Verificar que se renderizaron los traits
              setTimeout(() => {
                const traitsRendered = document.querySelectorAll('.traits-container .gjs-trt-trait').length;
                if (traitsRendered >= 10) {
                  console.log('✅ Traits del contenedor renderizados correctamente:', traitsRendered);
                } else {
                  console.warn('⚠️ No se renderizaron todos los traits, intentando método alternativo...');
                  // Intentar renderizar nuevamente
                  editor.TraitManager.render();
                }
              }, 100);
            }
          }, 150);
        } else {
          console.log('✅ El componente de contenedor ya tiene los traits correctos');
        }
      }
    }

    setTimeout(() => {
      if (typeof window.updateTraitLabelsForDevice === 'function') {
        window.updateTraitLabelsForDevice();
      }
    }, 200);
  });

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
    // Buscar todas las reglas CSS de IDs personalizados (formato: tipo-timestamp-random o element-timestamp-random)
    const regex = /#([a-z\-]+-\d+(?:-\d+)?)\s*\{([^}]+)\}/g;

    let modifiedCss = css.replace(regex, function (match, id, styles) {
      // Dividir los estilos en propiedades individuales
      const properties = styles.split(';').map(prop => prop.trim()).filter(prop => prop);

      // Agregar !important a cada propiedad que no lo tenga
      const importantProps = properties.map(prop => {
        if (!prop.includes('!important') && prop.includes(':')) {
          const [property, ...valueParts] = prop.split(':');
          const value = valueParts.join(':').trim(); // Por si el valor tiene ':'
          const newProp = `${property.trim()}:${value} !important`;
          return newProp;
        }
        return prop;
      });

      const result = `#${id}{${importantProps.join(';')};}`;
      return result;
    });

    return modifiedCss;
  }

  // Configurar botón de guardar
  document.getElementById('save-btn')?.addEventListener('click', function () {
    // Antes de obtener el HTML, asegurar que todos los componentes con estilos personalizados
    // tengan sus estilos aplicados como inline
    const allComponents = editor.DomComponents.getWrapper().find('*');

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
          }
        }
      }
    });

    // SINCRONIZAR IMAGENES: Usar módulo de sincronización
    if (typeof ImageSync !== 'undefined' && ImageSync.syncBeforeSave) {
      ImageSync.syncBeforeSave(editor);
    } else {
      // Fallback si el módulo no está cargado
      console.log('⚠️ ImageSync no disponible, usando fallback');
      const imageComponents = allComponents.filter(comp => {
        const type = comp.get('type');
        const tagName = comp.get('tagName');
        return type === 'image' || tagName === 'img';
      });

      imageComponents.forEach(imgComp => {
        const imageSrc = imgComp.get('image-src');
        const currentSrc = imgComp.getAttributes().src;
        const defaultImageSrc = '/images/default-image.jpg';

        let finalSrc;
        if (imageSrc && imageSrc.trim() && imageSrc !== 'undefined' && imageSrc !== defaultImageSrc) {
          finalSrc = imageSrc.trim();
        } else if (currentSrc && currentSrc.trim() && currentSrc !== 'undefined' && currentSrc !== defaultImageSrc) {
          finalSrc = currentSrc.trim();
        } else {
          finalSrc = defaultImageSrc;
        }

        // ✅ Actualizar atributos del modelo
        imgComp.setAttributes({ src: finalSrc });

        // ✅ Actualizar el DOM directamente
        if (imgComp.view && imgComp.view.el) {
          imgComp.view.el.src = finalSrc;
          imgComp.view.el.setAttribute('src', finalSrc);
        }

        // ✅ Sincronizar image-src
        if (imgComp.get('image-src') !== finalSrc) {
          imgComp.set('image-src', finalSrc, { silent: true });
        }

        // ✅ Forzar renderizado
        if (imgComp.view) {
          imgComp.view.render();
        }
      });
    }

    // ✅ Esperar un momento para que ImageSync procese todos los cambios antes de obtener el HTML
    setTimeout(() => {
      // ✅ CRÍTICO: Sincronizar imágenes de Image Box Advanced antes de guardar
      const syncImageBoxAdvancedBeforeSave = () => {
        const allComponents = editor.getComponents();
        const findImageBoxAdvanced = (components) => {
          if (components && typeof components.forEach === 'function') {
            components.forEach((component) => {
              if (component && component.get && component.get('type') === 'image-box-advanced') {
                const imageUrl = component.get('image-url');
                const defaultImageUrl = '/images/default-image.jpg';

                // Forzar actualización del componente img interno
                if (typeof component.updateImage === 'function') {
                  component.updateImage();
                }

                // Asegurar que el componente img tenga el src correcto
                const findImage = (comp) => {
                  if (comp.get('tagName') === 'img') {
                    return comp;
                  }
                  let found = null;
                  comp.components().each(child => {
                    if (!found) {
                      found = findImage(child);
                    }
                  });
                  return found;
                };

                const imgComponent = findImage(component);
                if (imgComponent) {
                  const finalSrc = (imageUrl && imageUrl !== defaultImageUrl) ? imageUrl : defaultImageUrl;

                  // Actualizar atributos del modelo
                  imgComponent.setAttributes({ src: finalSrc });

                  // Actualizar modelo
                  if (imgComponent.get('src') !== finalSrc) {
                    imgComponent.set('src', finalSrc, { silent: true });
                  }

                  // Actualizar DOM
                  if (imgComponent.view && imgComponent.view.el) {
                    imgComponent.view.el.src = finalSrc;
                    imgComponent.view.el.setAttribute('src', finalSrc);
                  }

                  // Actualizar también el DOM del contenedor
                  if (component.view && component.view.el) {
                    const img = component.view.el.querySelector('img');
                    if (img) {
                      img.src = finalSrc;
                      img.setAttribute('src', finalSrc);
                    }
                  }
                }
              }

              if (component && component.components) {
                const childComponents = component.components();
                if (childComponents) {
                  findImageBoxAdvanced(childComponents);
                }
              }
            });
          }
        };

        findImageBoxAdvanced(allComponents);
      };

      // Sincronizar antes de obtener el HTML
      syncImageBoxAdvancedBeforeSave();

      // ✅ CRÍTICO: Sincronizar Background Image antes de guardar
      const syncBackgroundImageBeforeSave = () => {
        console.log('💾 [Save] syncBackgroundImageBeforeSave() llamado');
        const allComponents = editor.getComponents();
        const findBackgroundImage = (components) => {
          if (components && typeof components.forEach === 'function') {
            components.forEach((component) => {
              if (component && component.get && component.get('type') === 'background-image') {
                console.log('✅ [Save] Background Image encontrado, sincronizando...');
                // Asegurar que los valores de los traits estén sincronizados con el DOM
                if (component.view && component.view.el) {
                  console.log('✅ [Save] view.el encontrado para Background Image');
                  const titleEl = component.view.el.querySelector('h2');
                  const textEl = component.view.el.querySelector('p');
                  const buttonEl = component.view.el.querySelector('button, a');

                  console.log('🔍 [Save] Elementos encontrados:', {
                    titleEl: !!titleEl,
                    textEl: !!textEl,
                    buttonEl: !!buttonEl
                  });

                  // ✅ CRÍTICO: Primero obtener el valor del modelo (puede estar más actualizado que el DOM)
                  const modelTitle = component.get('content-title');
                  const modelText = component.get('content-text');
                  const modelButtonText = component.get('button-text');
                  const modelButtonLink = component.get('button-link');

                  console.log('📊 [Save] Valores del modelo:', {
                    title: modelTitle,
                    text: modelText,
                    buttonText: modelButtonText,
                    buttonLink: modelButtonLink
                  });

                  // Sincronizar título - PRIORIDAD AL MODELO
                  const titleText = modelTitle || (titleEl ? (titleEl.textContent || titleEl.innerText || '') : '');
                  console.log('📝 [Save] Título final a usar:', titleText);
                  if (titleText && titleText.trim()) {
                    component.set('content-title', titleText.trim(), { silent: true });
                    console.log('✅ [Save] Título sincronizado en modelo');
                    // Asegurar que el componente h2 tenga el contenido correcto
                    const findTitle = (comp) => {
                      if (comp.get('tagName') === 'h2') return comp;
                      let found = null;
                      comp.components().each(child => {
                        if (!found) found = findTitle(child);
                      });
                      return found;
                    };
                    const titleComponent = findTitle(component);
                    if (titleComponent) {
                      titleComponent.set('content', titleText.trim());
                      console.log('✅ [Save] Componente h2 actualizado con:', titleText.trim());
                      // Actualizar también el DOM directamente
                      if (titleComponent.view && titleComponent.view.el) {
                        titleComponent.view.el.textContent = titleText.trim();
                      }
                    }
                    // Actualizar también el DOM del contenedor
                    if (titleEl) {
                      titleEl.textContent = titleText.trim();
                    }
                  }

                  // Sincronizar texto - PRIORIDAD AL MODELO
                  const textContent = modelText || (textEl ? (textEl.textContent || textEl.innerText || '') : '');
                  console.log('📝 [Save] Texto final a usar:', textContent);
                  if (textContent && textContent.trim()) {
                    component.set('content-text', textContent.trim(), { silent: true });
                    console.log('✅ [Save] Texto sincronizado en modelo');
                    const findText = (comp) => {
                      if (comp.get('tagName') === 'p') return comp;
                      let found = null;
                      comp.components().each(child => {
                        if (!found) found = findText(child);
                      });
                      return found;
                    };
                    const textComponent = findText(component);
                    if (textComponent) {
                      textComponent.set('content', textContent.trim());
                      console.log('✅ [Save] Componente p actualizado con:', textContent.trim());
                      // Actualizar también el DOM directamente
                      if (textComponent.view && textComponent.view.el) {
                        textComponent.view.el.textContent = textContent.trim();
                      }
                    } else {
                      console.warn('⚠️ [Save] No se encontró componente p');
                    }
                    // Actualizar también el DOM del contenedor
                    if (textEl) {
                      textEl.textContent = textContent.trim();
                    }
                  }

                  // Sincronizar botón - PRIORIDAD AL MODELO
                  const buttonText = modelButtonText || (buttonEl ? (buttonEl.textContent || buttonEl.innerText || '') : '');
                  const buttonLink = modelButtonLink || (buttonEl ? (buttonEl.getAttribute('href') || '#') : '#');
                  console.log('📝 [Save] Botón texto final a usar:', buttonText);
                  console.log('📝 [Save] Botón href final a usar:', buttonLink);

                  if (buttonText && buttonText.trim()) {
                    component.set('button-text', buttonText.trim(), { silent: true });
                    component.set('button-link', buttonLink, { silent: true });
                    console.log('✅ [Save] Botón sincronizado en modelo');
                    const findButton = (comp) => {
                      if (comp.get('tagName') === 'button' || comp.get('tagName') === 'a') return comp;
                      let found = null;
                      comp.components().each(child => {
                        if (!found) found = findButton(child);
                      });
                      return found;
                    };
                    const buttonComponent = findButton(component);
                    if (buttonComponent) {
                      buttonComponent.set('content', buttonText.trim());
                      console.log('✅ [Save] Componente button/a actualizado con:', buttonText.trim());

                      // Manejar conversión entre button y a según el enlace
                      if (buttonLink && buttonLink !== '#' && buttonLink.trim() !== '') {
                        if (buttonComponent.get('tagName') === 'button') {
                          buttonComponent.set('tagName', 'a');
                          buttonComponent.setAttributes({
                            ...buttonComponent.getAttributes(),
                            href: buttonLink
                          });
                          console.log('✅ [Save] Botón convertido a enlace con href:', buttonLink);
                        } else {
                          buttonComponent.setAttributes({
                            ...buttonComponent.getAttributes(),
                            href: buttonLink
                          });
                          console.log('✅ [Save] Enlace actualizado con href:', buttonLink);
                        }
                      } else {
                        if (buttonComponent.get('tagName') === 'a') {
                          buttonComponent.set('tagName', 'button');
                          const attrs = buttonComponent.getAttributes();
                          delete attrs.href;
                          buttonComponent.setAttributes(attrs);
                          console.log('✅ [Save] Enlace convertido a botón');
                        }
                      }

                      // Actualizar también el DOM directamente
                      if (buttonComponent.view && buttonComponent.view.el) {
                        buttonComponent.view.el.textContent = buttonText.trim();
                        if (buttonLink && buttonLink !== '#' && buttonLink.trim() !== '') {
                          if (buttonComponent.view.el.tagName === 'BUTTON') {
                            const newLink = document.createElement('a');
                            newLink.href = buttonLink;
                            newLink.className = buttonComponent.view.el.className;
                            newLink.textContent = buttonText.trim();
                            buttonComponent.view.el.parentNode.replaceChild(newLink, buttonComponent.view.el);
                            buttonComponent.view.el = newLink;
                          } else {
                            buttonComponent.view.el.setAttribute('href', buttonLink);
                          }
                        } else {
                          if (buttonComponent.view.el.tagName === 'A') {
                            const newButton = document.createElement('button');
                            newButton.className = buttonComponent.view.el.className;
                            newButton.textContent = buttonText.trim();
                            buttonComponent.view.el.parentNode.replaceChild(newButton, buttonComponent.view.el);
                            buttonComponent.view.el = newButton;
                          }
                        }
                      }
                    } else {
                      console.warn('⚠️ [Save] No se encontró componente button/a');
                    }

                    // Actualizar también el DOM del contenedor
                    if (buttonEl) {
                      buttonEl.textContent = buttonText.trim();
                      if (buttonLink && buttonLink !== '#' && buttonLink.trim() !== '') {
                        if (buttonEl.tagName === 'BUTTON') {
                          const newLink = document.createElement('a');
                          newLink.href = buttonLink;
                          newLink.className = buttonEl.className;
                          newLink.textContent = buttonText.trim();
                          buttonEl.parentNode.replaceChild(newLink, buttonEl);
                        } else {
                          buttonEl.setAttribute('href', buttonLink);
                        }
                      } else {
                        if (buttonEl.tagName === 'A') {
                          const newButton = document.createElement('button');
                          newButton.className = buttonEl.className;
                          newButton.textContent = buttonText.trim();
                          buttonEl.parentNode.replaceChild(newButton, buttonEl);
                        }
                      }
                    }
                  }

                  // Verificar valores finales antes de guardar
                  console.log('📊 [Save] Valores finales en modelo antes de guardar:', {
                    'content-title': component.get('content-title'),
                    'content-text': component.get('content-text'),
                    'button-text': component.get('button-text'),
                    'button-link': component.get('button-link')
                  });
                } else {
                  console.warn('⚠️ [Save] view.el no disponible para Background Image');
                }
              }

              if (component && component.components) {
                const childComponents = component.components();
                if (childComponents) {
                  findBackgroundImage(childComponents);
                }
              }
            });
          }
        };
        findBackgroundImage(allComponents);
      };

      syncBackgroundImageBeforeSave();

      const htmlContent = editor.getHtml();
      let cssContent = editor.getCss();

      // Agregar !important a los estilos de IDs personalizados
      cssContent = addImportantToCustomIds(cssContent);

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
            // Marcar como guardado - actualizar estado global de cambios sin guardar
            if (typeof window.markAsSaved === 'function') {
              window.markAsSaved();
            }

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
    }, 150);
  });

  return editor;
}

// Exportar funciones para uso global
// Funciones globales para editar y eliminar imágenes del carrusel
// ✅ Funciones editImage y deleteImage movidas a módulo: editor-modules/carousel-utils.js

window.initializeEditor = initializeEditor;
window.showProductsPlaceholder = showProductsPlaceholder;
window.initializeManagers = initializeManagers;