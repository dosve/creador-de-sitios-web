// Módulo del Componente File
// Componente de archivo descargable con icono y botón

(function() {
  'use strict';
  
  function registerFileComponent(editor) {
    if (!editor || !editor.DomComponents) {
      console.warn('⚠️ Editor no disponible para registrar componente File');
      return;
    }
    
    // Función para obtener el icono según la extensión del archivo
    const getFileIcon = (filename) => {
      if (!filename) return 'document';
      
      const ext = filename.split('.').pop()?.toLowerCase();
      
      const iconMap = {
        'pdf': 'pdf',
        'doc': 'word',
        'docx': 'word',
        'xls': 'excel',
        'xlsx': 'excel',
        'ppt': 'powerpoint',
        'pptx': 'powerpoint',
        'zip': 'archive',
        'rar': 'archive',
        'jpg': 'image',
        'jpeg': 'image',
        'png': 'image',
        'gif': 'image',
        'mp4': 'video',
        'mp3': 'audio'
      };
      
      return iconMap[ext] || 'document';
    };
    
    // Función para obtener el color del icono según el tipo
    const getIconColor = (iconType) => {
      const colorMap = {
        'pdf': 'red',
        'word': 'blue',
        'excel': 'green',
        'powerpoint': 'orange',
        'archive': 'purple',
        'image': 'pink',
        'video': 'indigo',
        'audio': 'yellow',
        'document': 'gray'
      };
      
      return colorMap[iconType] || 'gray';
    };
    
    // Función para formatear el tamaño del archivo
    const formatFileSize = (bytes) => {
      if (!bytes || bytes === 0) return '0 B';
      
      const k = 1024;
      const sizes = ['B', 'KB', 'MB', 'GB'];
      const i = Math.floor(Math.log(bytes) / Math.log(k));
      
      return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
    };
    
    editor.DomComponents.addType('file', {
      isComponent: (el) => {
        if (el.tagName === 'DIV' && (
          el.classList.contains('file-download') ||
          el.getAttribute('data-gjs-type') === 'file'
        )) {
          return { type: 'file' };
        }
        return false;
      },
      model: {
        defaults: {
          name: 'Archivo',
          draggable: true,
          droppable: false,
          selectable: true,
          editable: false,   // ✅ BLOQUEADO: No edición directa
          removable: true,
          copyable: true,
          badgable: true,
          stylable: true,
          highlightable: true,
          resizable: false,
          layerable: true,
          attributes: {
            'data-gjs-type': 'file',
            'data-gjs-name': 'Archivo',
            'data-gjs-editable': 'false'
          },
          'file-url': '',
          'file-name': 'documento.pdf',
          'file-size': '2.5',
          'file-size-unit': 'MB',
          'file-type': 'PDF',
          'button-text': 'Descargar',
          traits: [
            {
              type: 'button',
              name: 'select-file',
              label: '📁 Seleccionar Archivo',
              text: 'Abrir Galería de Archivos',
              full: true,
              command: (editor) => {
                const component = editor.getSelected();
                if (component && component.get('type') === 'file') {
                  const am = editor.AssetManager;
                  const modal = editor.Modal;
                  
                  fetch('/creator/media/api/list')
                    .then(response => response.json())
                    .then(data => {
                      if (data.success && data.files && data.files.length > 0) {
                        am.getAll().reset();
                        data.files.forEach(file => {
                          am.add({
                            type: 'file',
                            src: file.url,
                            name: file.filename,
                            size: file.size || null
                          });
                        });
                        console.log('✅ Archivos cargados desde biblioteca:', data.files.length);
                      } else {
                        console.warn('⚠️ No se encontraron archivos en la biblioteca');
                      }
                      
                      const onClickHandler = (asset) => {
                        let newSrc = null;
                        if (typeof asset.get === 'function') {
                          newSrc = asset.get('src') || asset.get('url');
                        }
                        if (!newSrc) {
                          newSrc = asset.src || asset.url || (asset.el && asset.el.src);
                        }
                        if (!newSrc && asset.attributes) {
                          newSrc = asset.attributes.src || asset.attributes.url;
                        }
                        
                        if (newSrc && component) {
                          // Extraer nombre de archivo de la URL si no está en el asset
                          let fileName = asset.get('name') || asset.get('filename') || '';
                          if (!fileName && newSrc) {
                            fileName = newSrc.split('/').pop().split('?')[0] || 'archivo';
                          }
                          if (!fileName) {
                            fileName = 'archivo';
                          }
                          
                          // Detectar tipo de archivo desde la extensión
                          const extension = fileName.split('.').pop()?.toLowerCase() || '';
                          const typeMap = {
                            'pdf': 'PDF',
                            'doc': 'DOC',
                            'docx': 'DOCX',
                            'xls': 'XLS',
                            'xlsx': 'XLSX',
                            'ppt': 'PPT',
                            'pptx': 'PPTX',
                            'zip': 'ZIP',
                            'rar': 'RAR',
                            'jpg': 'JPG',
                            'jpeg': 'JPG',
                            'png': 'PNG',
                            'gif': 'GIF',
                            'mp3': 'MP3',
                            'mp4': 'MP4',
                            'txt': 'TXT'
                          };
                          const fileType = typeMap[extension] || extension.toUpperCase() || 'PDF';
                          
                          const fileSize = asset.get('size') || asset.size || null;
                          
                          component.set('file-url', newSrc, { silent: false });
                          component.set('file-name', fileName, { silent: false });
                          component.set('file-type', fileType, { silent: false });
                          
                          if (fileSize) {
                            const formatted = formatFileSize(fileSize);
                            const parts = formatted.split(' ');
                            component.set('file-size', parts[0], { silent: false });
                            component.set('file-size-unit', parts[1] || 'B', { silent: false });
                          }
                          
                          // Actualizar el archivo (esto actualiza el href y download)
                          component.updateFile();
                          
                          modal.close();
                          setTimeout(() => {
                            if (editor.TraitManager) {
                              editor.TraitManager.render();
                            }
                          }, 150);
                        }
                      };
                      
                      am.onClick(onClickHandler);
                      modal.setTitle('Seleccionar Archivo desde Galería')
                        .setContent(am.render())
                        .open();
                      
                      console.log('✅ Galería de archivos abierta');
                    })
                    .catch(error => {
                      console.error('❌ Error al cargar archivos desde la biblioteca:', error);
                      am.onClick((asset) => {
                        let newSrc = asset.get('src') || asset.get('url') || asset.src || asset.url;
                        
                        // Extraer nombre de archivo de la URL si no está en el asset
                        let fileName = asset.get('name') || asset.get('filename') || '';
                        if (!fileName && newSrc) {
                          fileName = newSrc.split('/').pop().split('?')[0] || 'archivo';
                        }
                        if (!fileName) {
                          fileName = 'archivo';
                        }
                        
                        // Detectar tipo de archivo desde la extensión
                        const extension = fileName.split('.').pop()?.toLowerCase() || '';
                        const typeMap = {
                          'pdf': 'PDF',
                          'doc': 'DOC',
                          'docx': 'DOCX',
                          'xls': 'XLS',
                          'xlsx': 'XLSX',
                          'ppt': 'PPT',
                          'pptx': 'PPTX',
                          'zip': 'ZIP',
                          'rar': 'RAR',
                          'jpg': 'JPG',
                          'jpeg': 'JPG',
                          'png': 'PNG',
                          'gif': 'GIF',
                          'mp3': 'MP3',
                          'mp4': 'MP4',
                          'txt': 'TXT'
                        };
                        const fileType = typeMap[extension] || extension.toUpperCase() || 'PDF';
                        
                        const fileSize = asset.get('size') || asset.size || null;
                        
                        if (newSrc && component) {
                          component.set('file-url', newSrc, { silent: false });
                          component.set('file-name', fileName, { silent: false });
                          component.set('file-type', fileType, { silent: false });
                          
                          if (fileSize) {
                            const formatted = formatFileSize(fileSize);
                            const parts = formatted.split(' ');
                            component.set('file-size', parts[0], { silent: false });
                            component.set('file-size-unit', parts[1] || 'B', { silent: false });
                          }
                          
                          // Actualizar el archivo (esto actualiza el href y download)
                          component.updateFile();
                          
                          modal.close();
                          setTimeout(() => {
                            if (editor.TraitManager) {
                              editor.TraitManager.render();
                            }
                          }, 150);
                        }
                      });
                      modal.setTitle('Seleccionar Archivo desde Galería')
                        .setContent(am.render())
                        .open();
                    });
                }
              }
            },
            {
              type: 'text',
              name: 'file-url',
              label: 'URL del Archivo',
              placeholder: 'https://ejemplo.com/archivo.pdf',
              changeProp: 1
            },
            {
              type: 'text',
              name: 'file-name',
              label: 'Nombre del Archivo',
              placeholder: 'documento.pdf',
              changeProp: 1
            },
            {
              type: 'text',
              name: 'file-size',
              label: 'Tamaño (número)',
              placeholder: '2.5',
              changeProp: 1
            },
            {
              type: 'select',
              name: 'file-size-unit',
              label: 'Unidad de Tamaño',
              changeProp: 1,
              options: [
                { value: 'B', name: 'Bytes (B)' },
                { value: 'KB', name: 'Kilobytes (KB)' },
                { value: 'MB', name: 'Megabytes (MB)' },
                { value: 'GB', name: 'Gigabytes (GB)' }
              ]
            },
            {
              type: 'text',
              name: 'file-type',
              label: 'Tipo de Archivo',
              placeholder: 'PDF',
              changeProp: 1
            },
            {
              type: 'text',
              name: 'button-text',
              label: 'Texto del Botón',
              placeholder: 'Descargar',
              changeProp: 1
            }
          ]
        },
        init() {
          
          this.on('change:file-url', this.updateFile, this);
          this.on('change:file-name', this.updateFileName, this);
          this.on('change:file-size', this.updateFileSize, this);
          this.on('change:file-size-unit', this.updateFileSize, this);
          this.on('change:file-type', this.updateFileType, this);
          this.on('change:button-text', this.updateButtonText, this);
          
          // Proteger TODOS los elementos internos - NO edición directa
          const protectElements = () => {
            const protectRecursive = (component) => {
              // Proteger el componente actual
              component.set({
                selectable: false,
                hoverable: false,
                draggable: false,
                editable: false,  // ✅ BLOQUEADO: No edición directa
                removable: false,
                droppable: false
              });
              component.addAttributes({
                'data-gjs-editable': 'false',
                'data-gjs-selectable': 'false',
                'data-gjs-draggable': 'false',
                'data-gjs-droppable': 'false',
                'contenteditable': 'false'
              });
              
              // Proteger recursivamente todos los hijos
              component.components().each(grandchild => {
                protectRecursive(grandchild);
              });
            };
            
            this.components().each(child => {
              protectRecursive(child);
            });
            
          };
          
          setTimeout(protectElements, 100);
          this.on('component:mount', protectElements);
          this.on('component:add', () => {
            setTimeout(protectElements, 100);
          });
        },
        updateFile() {
          const fileUrl = this.get('file-url') || '';
          let fileName = this.get('file-name') || '';
          
          // Si no hay nombre de archivo, extraerlo de la URL
          if (!fileName && fileUrl) {
            fileName = fileUrl.split('/').pop().split('?')[0] || 'archivo';
            this.set('file-name', fileName, { silent: true });
          }
          
          // Si aún no hay nombre, usar un valor por defecto basado en la extensión
          if (!fileName) {
            fileName = 'documento.pdf';
          }
          
          // Detectar tipo de archivo desde la URL si no está definido
          if (fileUrl) {
            const extension = fileUrl.split('.').pop().toLowerCase().split('?')[0];
            const currentType = this.get('file-type') || '';
            if (!currentType || currentType === 'PDF') {
              // Detectar tipo desde extensión
              const typeMap = {
                'pdf': 'PDF',
                'doc': 'DOC',
                'docx': 'DOCX',
                'xls': 'XLS',
                'xlsx': 'XLSX',
                'ppt': 'PPT',
                'pptx': 'PPTX',
                'zip': 'ZIP',
                'rar': 'RAR',
                'jpg': 'JPG',
                'jpeg': 'JPG',
                'png': 'PNG',
                'gif': 'GIF',
                'mp3': 'MP3',
                'mp4': 'MP4',
                'txt': 'TXT'
              };
              const detectedType = typeMap[extension] || extension.toUpperCase();
              this.set('file-type', detectedType, { silent: true });
            }
          }
          
          console.log('📄 Actualizando archivo:', { fileUrl, fileName });
          
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          let button = el.querySelector('button') || el.querySelector('a');
          
          if (button && fileUrl) {
            // Si es botón, convertirlo a enlace
            if (button.tagName === 'BUTTON') {
              const link = document.createElement('a');
              link.href = fileUrl;
              link.className = button.className;
              link.textContent = button.textContent || button.innerText;
              link.setAttribute('download', fileName);
              link.setAttribute('target', '_blank');
              
              // Copiar todos los atributos del botón
              Array.from(button.attributes).forEach(attr => {
                if (attr.name !== 'type' && attr.name !== 'onclick') {
                  link.setAttribute(attr.name, attr.value);
                }
              });
              
              button.parentNode?.replaceChild(link, button);
              button = link; // Actualizar referencia
            } else {
              // Actualizar enlace existente
              button.href = fileUrl;
              button.setAttribute('download', fileName);
              button.setAttribute('target', '_blank');
              button.removeAttribute('onclick'); // Remover onclick si existe
            }
            
            // Asegurar que el href esté correctamente establecido
            if (button.href !== fileUrl) {
              button.setAttribute('href', fileUrl);
            }
            
            // Actualizar también el icono según el tipo de archivo
            this.updateFileIcon();
            
            // Forzar actualización en el modelo de GrapesJS
            const findLink = (component) => {
              if (component.get('tagName') === 'a' || component.get('tagName') === 'button') {
                return component;
              }
              let found = null;
              component.components().each(child => {
                if (!found) {
                  found = findLink(child);
                }
              });
              return found;
            };
            
            const linkComponent = findLink(this);
            if (linkComponent) {
              linkComponent.setAttributes({ 
                href: fileUrl,
                download: fileName,
                target: '_blank'
              });
            }
          }
        },
        updateFileName() {
          const fileName = this.get('file-name') || 'documento.pdf';
          console.log('📝 Actualizando nombre del archivo:', fileName);
          
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          const nameEl = el.querySelector('h3');
          
          if (nameEl) {
            nameEl.textContent = fileName;
            
            // Actualizar también en el modelo de GrapesJS
            const findName = (component) => {
              if (component.get('tagName') === 'h3') {
                return component;
              }
              let found = null;
              component.components().each(child => {
                if (!found) {
                  found = findName(child);
                }
              });
              return found;
            };
            
            const nameComponent = findName(this);
            if (nameComponent) {
              nameComponent.set('content', fileName);
            }
            
            // Actualizar el atributo download del botón/enlace
            const button = el.querySelector('button') || el.querySelector('a');
            if (button) {
              button.setAttribute('download', fileName);
            }
            
            // Actualizar icono según el nuevo nombre
            this.updateFileIcon();
          }
        },
        updateFileSize() {
          const size = this.get('file-size') || '2.5';
          const unit = this.get('file-size-unit') || 'MB';
          const fileType = this.get('file-type') || 'PDF';
          const sizeText = `${size} ${unit} • ${fileType}`;
          
          console.log('📏 Actualizando tamaño del archivo:', sizeText);
          
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          const sizeEl = el.querySelector('p.text-sm');
          
          if (sizeEl) {
            sizeEl.textContent = sizeText;
            
            // Actualizar también en el modelo de GrapesJS
            const findSize = (component) => {
              if (component.get('tagName') === 'p' && component.getAttributes().class?.includes('text-sm')) {
                return component;
              }
              let found = null;
              component.components().each(child => {
                if (!found) {
                  found = findSize(child);
                }
              });
              return found;
            };
            
            const sizeComponent = findSize(this);
            if (sizeComponent) {
              sizeComponent.set('content', sizeText);
            }
          }
        },
        updateFileType() {
          this.updateFileSize(); // El tipo se muestra junto con el tamaño
        },
        updateButtonText() {
          const buttonText = this.get('button-text') || 'Descargar';
          console.log('🔘 Actualizando texto del botón:', buttonText);
          
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          const button = el.querySelector('button') || el.querySelector('a');
          
          if (button) {
            button.textContent = buttonText;
          }
        },
        updateFileIcon() {
          const fileName = this.get('file-name') || 'documento.pdf';
          const iconType = getFileIcon(fileName);
          const iconColor = getIconColor(iconType);
          
          console.log('🎨 Actualizando icono del archivo:', { iconType, iconColor });
          
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          const iconContainer = el.querySelector('.w-12.h-12');
          
          if (iconContainer) {
            // Actualizar color de fondo según el tipo
            const colorClasses = {
              'red': 'bg-red-100',
              'blue': 'bg-blue-100',
              'green': 'bg-green-100',
              'orange': 'bg-orange-100',
              'purple': 'bg-purple-100',
              'pink': 'bg-pink-100',
              'indigo': 'bg-indigo-100',
              'yellow': 'bg-yellow-100',
              'gray': 'bg-gray-100'
            };
            
            const textColors = {
              'red': 'text-red-600',
              'blue': 'text-blue-600',
              'green': 'text-green-600',
              'orange': 'text-orange-600',
              'purple': 'text-purple-600',
              'pink': 'text-pink-600',
              'indigo': 'text-indigo-600',
              'yellow': 'text-yellow-600',
              'gray': 'text-gray-600'
            };
            
            // Remover clases de color anteriores
            Object.values(colorClasses).forEach(cls => iconContainer.classList.remove(cls));
            Object.values(textColors).forEach(cls => {
              const svg = iconContainer.querySelector('svg');
              if (svg) svg.classList.remove(cls);
            });
            
            // Agregar nuevas clases
            iconContainer.classList.add(colorClasses[iconColor] || 'bg-gray-100');
            const svg = iconContainer.querySelector('svg');
            if (svg) {
              svg.classList.add(textColors[iconColor] || 'text-gray-600');
            }
          }
        }
      },
      view: {
        onRender() {
          const el = this.el;

          // Proteger el contenedor principal
          el.setAttribute('contenteditable', 'false');
          el.setAttribute('data-gjs-editable', 'false');
          
          // Proteger TODOS los elementos internos - NO edición directa
          const protectElements = (container) => {
            if (!container) return;
            
            // Proteger TODOS los elementos (botones, enlaces, textos, iconos, etc.)
            const allElements = container.querySelectorAll('*');
            allElements.forEach(el => {
              el.setAttribute('contenteditable', 'false');
              el.setAttribute('data-gjs-editable', 'false');
              el.setAttribute('data-gjs-selectable', 'false');
              el.setAttribute('data-gjs-draggable', 'false');
              el.setAttribute('data-gjs-droppable', 'false');
            });
            
            // También proteger el contenedor mismo
            container.setAttribute('contenteditable', 'false');
            container.setAttribute('data-gjs-editable', 'false');
          };
          
          protectElements(el);
          
          // Observar cambios en el DOM
          const observer = new MutationObserver(() => {
            protectElements(el);
          });
          
          observer.observe(el, {
            childList: true,
            subtree: true
          });
          
          this._fileObserver = observer;
          
        },
        onRemove() {
          if (this._fileObserver) {
            this._fileObserver.disconnect();
          }
        }
      }
    });
    
  }
  
  if (typeof window !== 'undefined' && window.editor) {
    registerFileComponent(window.editor);
  } else {
    const checkEditor = setInterval(() => {
      if (typeof window !== 'undefined' && window.editor) {
        registerFileComponent(window.editor);
        clearInterval(checkEditor);
      }
    }, 100);
    
    setTimeout(() => {
      clearInterval(checkEditor);
    }, 10000);
  }
  
  if (typeof window !== 'undefined') {
    window.registerFileComponent = registerFileComponent;
  }
})();
