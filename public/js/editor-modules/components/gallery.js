// Módulo del Componente Gallery
// Componente de galería de imágenes con grid

(function() {
  'use strict';
  
  function registerGalleryComponent(editor) {
    if (!editor || !editor.DomComponents) {
      console.warn('⚠️ Editor no disponible para registrar componente Gallery');
      return;
    }
    
    editor.DomComponents.addType('gallery', {
      isComponent: (el) => {
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
          droppable: false,  // ✅ BLOQUEADO: No acepta hijos directamente
          selectable: true,
          hoverable: true,
          editable: false,    // ✅ BLOQUEADO: No edición directa
          removable: true,
          layerable: true,
          highlightable: true,
          badgable: true,
          toolbar: true,
          attributes: {
            class: 'gallery',
            'data-gjs-name': 'Galería',
            'data-gjs-editable': 'false'
          },
          'image-1': '',
          'image-2': '',
          'image-3': '',
          'image-4': '',
          'columns': '4',
          'gap': '4',
          'hover-effect': true,
          'lightbox': false,
          style: {
            'position': 'relative',
            'cursor': 'pointer',
            'outline': '2px dashed transparent',
            'transition': 'outline 0.2s ease'
          }
        },
        getTraits() {
          return [
            {
              type: 'button',
              name: 'load-images',
              label: '📁 Cargar Imágenes',
              text: 'Seleccionar imágenes de la galería',
              full: true,
              command: (editor) => {
                const component = editor.getSelected();
                if (component && component.get('type') === 'gallery') {
                  const am = editor.AssetManager;
                  const modal = editor.Modal;
                  
                  fetch('/creator/media/api/list')
                    .then(response => response.json())
                    .then(data => {
                      if (data.success && data.files && data.files.length > 0) {
                        am.getAll().reset();
                        data.files.forEach(file => {
                          am.add({
                            type: 'image',
                            src: file.url,
                            name: file.filename,
                            alt: file.alt_text || file.filename
                          });
                        });
                        console.log('✅ Imágenes cargadas desde biblioteca:', data.files.length);
                      } else {
                        console.warn('⚠️ No se encontraron imágenes en la biblioteca');
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
                          console.log('🖼️ Imagen seleccionada para galería:', newSrc);
                          
                          const images = component.view.el.querySelectorAll('.grid img');
                          let targetIndex = 0;
                          
                          for (let i = 0; i < images.length; i++) {
                            if (images[i].src.includes('placeholder') || !images[i].src || images[i].src.includes('default-image')) {
                              targetIndex = i;
                              break;
                            }
                          }
                          
                          if (images[targetIndex]) {
                            images[targetIndex].src = newSrc;
                            images[targetIndex].setAttribute('src', newSrc);
                            const imageNum = targetIndex + 1;
                            component.set(`image-${imageNum}`, newSrc);
                            console.log(`✅ Imagen ${imageNum} actualizada`);
                          }
                          
                          modal.close();
                          setTimeout(() => {
                            if (editor.TraitManager) {
                              editor.TraitManager.render();
                            }
                          }, 150);
                        }
                      };
                      
                      am.onClick(onClickHandler);
                      modal.setTitle('Seleccionar Imagen desde Galería')
                        .setContent(am.render())
                        .open();
                      
                      console.log('✅ Galería de imágenes abierta');
                    })
                    .catch(error => {
                      console.error('❌ Error al cargar imágenes desde la biblioteca:', error);
                      am.onClick((asset) => {
                        let newSrc = asset.get('src') || asset.get('url') || asset.src || asset.url;
                        if (newSrc && component) {
                          const images = component.view.el.querySelectorAll('.grid img');
                          if (images[0]) {
                            images[0].src = newSrc;
                            images[0].setAttribute('src', newSrc);
                            component.set('image-1', newSrc);
                          }
                          modal.close();
                          setTimeout(() => {
                            if (editor.TraitManager) {
                              editor.TraitManager.render();
                            }
                          }, 150);
                        }
                      });
                      modal.setTitle('Seleccionar Imagen desde Galería')
                        .setContent(am.render())
                        .open();
                    });
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
          console.log('📋 Tipo de componente:', this.get('type'));
          
          this.on('change:image-1', this.handleImageChange);
          this.on('change:image-2', this.handleImageChange);
          this.on('change:image-3', this.handleImageChange);
          this.on('change:image-4', this.handleImageChange);
          
          this.on('change:columns', this.handleColumnsChange);
          this.on('change:gap', this.handleGapChange);
          this.on('change:hover-effect', this.handleHoverEffectChange);
          
          // Función para proteger elementos internos
          const protectGalleryElements = () => {
            this.components().each(child => {
              // Proteger imágenes
              if (child.get('tagName') === 'img') {
                child.set({
                  selectable: false,
                  hoverable: false,
                  draggable: false,
                  editable: false,
                  removable: false,
                  layerable: false
                });
                child.addAttributes({
                  'data-gjs-editable': 'false',
                  'data-gjs-selectable': 'false',
                  'data-gjs-draggable': 'false'
                });
              }
              
              // Proteger contenedores grid
              if (child.get('tagName') === 'div' && 
                  (child.getAttributes().class?.includes('grid') || 
                   child.view?.el?.classList?.contains('grid'))) {
                child.set({
                  editable: false,
                  droppable: false
                });
                child.addAttributes({
                  'data-gjs-editable': 'false',
                  'data-gjs-droppable': 'false'
                });
              }
              
              // Recursivamente proteger hijos
              if (child.components().length > 0) {
                child.components().each(grandchild => {
                  if (grandchild.get('tagName') === 'img') {
                    grandchild.set({
                      selectable: false,
                      hoverable: false,
                      draggable: false,
                      editable: false,
                      removable: false
                    });
                  }
                });
              }
            });
          };
          
          setTimeout(() => {
            this.syncImageUrls();
            protectGalleryElements();
          }, 300);
          
          this.on('component:mount', protectGalleryElements);
          this.on('component:add', () => {
            setTimeout(protectGalleryElements, 100);
          });
          
          console.log('✅ Componente Galería inicializado');
        },
        view: {
          onRender() {
            
            // Proteger el contenedor principal
            this.el.setAttribute('contenteditable', 'false');
            this.el.setAttribute('data-gjs-editable', 'false');
            
            this.el.style.position = 'relative';
            this.el.style.cursor = 'pointer';
            this.el.style.outline = '2px dashed transparent';
            this.el.style.transition = 'outline 0.2s ease';
            
            // Proteger elementos internos
            const protectElements = (el) => {
              if (!el) return;
              
              // Proteger imágenes
              const images = el.querySelectorAll('img');
              images.forEach(img => {
                img.setAttribute('contenteditable', 'false');
                img.setAttribute('data-gjs-editable', 'false');
                img.setAttribute('data-gjs-selectable', 'false');
                img.setAttribute('data-gjs-draggable', 'false');
              });
              
              // Proteger contenedores grid
              const grids = el.querySelectorAll('.grid');
              grids.forEach(grid => {
                grid.setAttribute('contenteditable', 'false');
                grid.setAttribute('data-gjs-editable', 'false');
                grid.setAttribute('data-gjs-droppable', 'false');
              });
            };
            
            protectElements(this.el);
            
            // Observar cambios en el DOM
            const observer = new MutationObserver(() => {
              protectElements(this.el);
            });
            
            observer.observe(this.el, {
              childList: true,
              subtree: true
            });
            
            this._galleryObserver = observer;
            
            this.el.addEventListener('click', (e) => {
              e.stopPropagation();
              e.preventDefault();
              console.log('🖱️ Clic detectado en galería - forzando selección');
              editor.select(this.model);
              return false;
            });
            
            this.el.addEventListener('mouseover', (e) => {
              this.el.style.outline = '2px dashed #3b82f6';
            });
            
            this.el.addEventListener('mouseout', (e) => {
              this.el.style.outline = '2px dashed transparent';
            });
            
            this.el.setAttribute('data-gjs-selectable', 'true');
            this.el.setAttribute('data-gjs-hoverable', 'true');
          },
          onRemove() {
            if (this._galleryObserver) {
              this._galleryObserver.disconnect();
            }
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
            grid.classList.remove('grid-cols-2', 'grid-cols-3', 'grid-cols-4', 'grid-cols-5', 'grid-cols-6');
            grid.classList.add(`grid-cols-${columns}`);
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
    
  }
  
  if (typeof window !== 'undefined' && window.editor) {
    registerGalleryComponent(window.editor);
  } else {
    const checkEditor = setInterval(() => {
      if (typeof window !== 'undefined' && window.editor) {
        registerGalleryComponent(window.editor);
        clearInterval(checkEditor);
      }
    }, 100);
    
    setTimeout(() => {
      clearInterval(checkEditor);
    }, 10000);
  }
  
  if (typeof window !== 'undefined') {
    window.registerGalleryComponent = registerGalleryComponent;
  }
})();
