// Módulo de Configuración del Editor
// Contiene la configuración principal de GrapeJS

const EditorConfig = {
  getConfig: function() {
    return {
      container: '#gjs',
      height: '100%',
      width: '100%',
      storageManager: false,
      undoManager: true,
      assetManager: {
        upload: false,
        uploadText: 'Arrastra archivos aquí o haz clic para subir',
        addBtnText: 'Agregar imagen',
        assets: [
          'https://images.unsplash.com/photo-1506748686214-e9df14d4d9d0?w=800',
          'https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=800',
          'https://images.unsplash.com/photo-1501594907352-04cda38ebc29?w=800',
          'https://images.unsplash.com/photo-1518173946687-a4c8892bbd9f?w=800',
          'https://images.unsplash.com/photo-1511593358241-7eea1f3c84e5?w=800',
          'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800'
        ],
        modalTitle: 'Seleccionar Imagen',
        multiUpload: false
      },
      layerManager: {
        appendTo: '.layers-container',
        showWrapper: false,
        sortable: true,
        hidable: true
      },
      traitManager: {
        appendTo: '.traits-container',
        textareaAutoResize: true,
      },
      selectorManager: {
        componentFirst: true,
        custom: true
      },
      styleManager: {
        appendTo: '.styles-container',
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
      allowScripts: 1,
      showOffsets: 1,
      showOffsetsSelected: 1,
      noticeOnUnload: 0,
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
  }
};
