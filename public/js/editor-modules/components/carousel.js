// Módulo del Componente Carousel
// Componente de carrusel con galería de imágenes

(function() {
  'use strict';
  
  function registerCarouselComponent(editor) {
    if (!editor || !editor.DomComponents) {
      console.warn('⚠️ Editor no disponible para registrar componente Carousel');
      return;
    }
    
    editor.DomComponents.addType('carousel', {
      isComponent: (el) => {
        if (el.classList && el.classList.contains('carousel-container')) {
          return { type: 'carousel' };
        }
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
          droppable: false,  // ✅ BLOQUEADO: No acepta hijos directamente
          selectable: true,
          hoverable: true,
          editable: false,   // ✅ BLOQUEADO: No edición directa
          removable: true,
          layerable: true,
          highlightable: true,
          badgable: true,
          toolbar: true,
          attributes: {
            class: 'carousel-container',
            'data-gjs-name': 'Carrusel',
            'data-gjs-editable': 'false'
          }
        },
        getTraits() {
          
          return [
            {
              type: 'button',
              name: 'open-gallery',
              label: '🖼️ Galería de Imágenes',
              text: 'Abrir galería para seleccionar o cargar imágenes',
              full: true,
              command: (editor) => {
                const component = editor.getSelected();
                if (component && component.get('type') === 'carousel') {
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
                          console.log('🎠 Imagen seleccionada para carrusel:', newSrc);
                          
                          const carouselContainer = component.view.el.querySelector('.carousel-container') || 
                                                  component.view.el.querySelector('.carousel') || 
                                                  component.view.el;
                          
                          const existingImages = carouselContainer.querySelectorAll('.carousel-slide img') || 
                                               carouselContainer.querySelectorAll('img') ||
                                               [];
                          
                          let targetSlide = null;
                          let slideIndex = 1;
                          
                          for (let i = 0; i < existingImages.length; i++) {
                            if (existingImages[i].src.includes('placeholder') || existingImages[i].src.includes('via.placeholder') || existingImages[i].src.includes('default-image')) {
                              targetSlide = existingImages[i];
                              slideIndex = i + 1;
                              break;
                            }
                          }
                          
                          if (!targetSlide && existingImages.length > 0) {
                            targetSlide = existingImages[0];
                            slideIndex = 1;
                          }
                          
                          if (targetSlide) {
                            targetSlide.src = newSrc;
                            targetSlide.setAttribute('src', newSrc);
                            component.set(`slide-${slideIndex}`, newSrc);
                            console.log(`✅ Slide ${slideIndex} actualizado con nueva imagen`);
                          } else {
                            const newSlide = document.createElement('div');
                            newSlide.className = 'carousel-slide';
                            newSlide.innerHTML = `
                              <img src="${newSrc}" 
                                   alt="Slide 1" 
                                   style="width: 100%; height: 300px; object-fit: cover;">
                            `;
                            carouselContainer.appendChild(newSlide);
                            component.set('slide-1', newSrc);
                            component.set('slides', 1);
                            console.log(`✅ Primer slide creado con imagen`);
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
                          const carouselContainer = component.view.el.querySelector('.carousel-container') || 
                                                  component.view.el.querySelector('.carousel') || 
                                                  component.view.el;
                          const existingImages = carouselContainer.querySelectorAll('.carousel-slide img') || [];
                          if (existingImages[0]) {
                            existingImages[0].src = newSrc;
                            existingImages[0].setAttribute('src', newSrc);
                            component.set('slide-1', newSrc);
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
          
          if (!this.get('slides')) {
            this.set('slides', 3);
          }
          
          setTimeout(() => {
            const carouselContainer = this.view?.el?.querySelector('.carousel-container') || 
                                     this.view?.el?.querySelector('.carousel') || 
                                     this.view?.el;
            
            if (carouselContainer) {
              const existingSlides = carouselContainer.querySelectorAll('.carousel-slide');
              const expectedSlides = this.get('slides') || 3;
              
              console.log(`🔍 Slides existentes: ${existingSlides.length}, esperados: ${expectedSlides}`);
              
              for (let i = existingSlides.length; i < expectedSlides; i++) {
                const slideNum = i + 1;
                const newSlide = document.createElement('div');
                newSlide.className = 'carousel-slide';
                // Usar imagen local en lugar de via.placeholder.com
                const defaultImageUrl = '/images/default-image.jpg';
                
                newSlide.innerHTML = `
                  <img src="${defaultImageUrl}" 
                       alt="Slide ${slideNum}" 
                       style="width: 100%; height: 300px; object-fit: cover;">
                `;
                carouselContainer.appendChild(newSlide);
                console.log(`✅ Slide ${slideNum} creado (placeholder)`);
              }
            }
          }, 200);
          
          // Función para proteger TODOS los elementos internos del carrusel - NO edición directa
          const protectCarouselElements = (component = this) => {
            const protectRecursive = (comp) => {
              // Proteger el componente actual completamente
              comp.set({
                selectable: false,
                hoverable: false,
                draggable: false,
                editable: false,  // ✅ BLOQUEADO: No edición directa
                removable: false,
                droppable: false,
                layerable: false
              });
              comp.addAttributes({
                'data-gjs-editable': 'false',
                'data-gjs-selectable': 'false',
                'data-gjs-draggable': 'false',
                'data-gjs-droppable': 'false',
                'contenteditable': 'false'
              });
              
              // Proteger recursivamente todos los hijos
              comp.components().each(grandchild => {
                protectRecursive(grandchild);
              });
            };
            
            component.components().each(child => {
              protectRecursive(child);
            });
            
          };
          
          setTimeout(protectCarouselElements, 100);
          this.on('component:mount', protectCarouselElements);
          this.on('component:add', () => {
            setTimeout(protectCarouselElements, 100);
          });
          
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
            
            if (window.editor && window.editor.TraitManager) {
              window.editor.TraitManager.render();
              console.log('🔄 TraitManager actualizado');
            }
          };
          
          const forceTraitManagerUpdate = () => {
            if (window.editor && window.editor.TraitManager) {
              console.log('🔄 Forzando actualización del TraitManager para carrusel...');
              
              const traitsContainer = document.querySelector('.traits-container');
              if (traitsContainer) {
                traitsContainer.innerHTML = '';
              }
              
              const selectedComponent = window.editor.getSelected();
              if (selectedComponent) {
                console.log('🎯 Componente seleccionado para TraitManager:', selectedComponent.get('type'));
                
                if (window.editor.TraitManager.collection) {
                  window.editor.TraitManager.collection.reset();
                }
                
                window.editor.TraitManager.render();
                
                setTimeout(() => {
                  const traitsInContainer = document.querySelectorAll('.traits-container .gjs-trt-trait');
                  
                  if (traitsInContainer.length < 8) {
                    console.log('⚠️ Aún no se muestran todos los traits, intentando método alternativo...');
                    
                    selectedComponent.trigger('change:traits');
                    selectedComponent.trigger('change:attributes');
                    
                    window.editor.TraitManager.render();
                    
                    setTimeout(() => {
                      const finalTraits = document.querySelectorAll('.traits-container .gjs-trt-trait');
                    }, 100);
                  }
                }, 200);
              } else {
                console.warn('⚠️ No hay componente seleccionado para actualizar TraitManager');
              }
            }
          };
          
          this.forceTraitManagerUpdate = forceTraitManagerUpdate;
          
          setTimeout(syncSlideUrls, 200);
          this.on('component:mount', () => setTimeout(syncSlideUrls, 100));
          
          this.on('change:slide-1', this.handleSlideChange);
          this.on('change:slide-2', this.handleSlideChange);
          this.on('change:slide-3', this.handleSlideChange);
          
          this.on('change:autoplay', this.handleAutoplayChange);
          this.on('change:transition-speed', this.handleTransitionChange);
          this.on('change:show-controls', this.handleShowControlsChange);
          this.on('change:show-indicators', this.handleShowIndicatorsChange);
          
          console.log('✅ Componente Carrusel inicializado');
        },
        updateTraits() {
          console.log('🔄 Forzando actualización de traits del carrusel...');
          
          if (window.editor && window.editor.TraitManager) {
            try {
              window.editor.TraitManager.render();
              this.trigger('change:traits');
              console.log('✅ Traits del carrusel actualizados');
            } catch (error) {
              console.log('⚠️ Error actualizando traits:', error);
              window.editor.TraitManager.render();
            }
          }
        },
        view: {
          onRender() {
            console.log('🎠 Vista de carrusel renderizada');
            
            this.el.addEventListener('click', (e) => {
              e.stopPropagation();
              console.log('🖱️ Clic detectado en carrusel - forzando selección');
              editor.select(this.model);
            });
            
            this.el.style.cursor = 'pointer';
          }
        },
        handleSlideChange(component, value, options) {
          console.log('🎠 Cambio en slide detectado');
          
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
      },
      view: {
        onRender() {
          if (this.el) {
            // Proteger el contenedor principal
            this.el.setAttribute('contenteditable', 'false');
            this.el.setAttribute('data-gjs-editable', 'false');
            
            // Proteger TODOS los elementos internos - NO edición directa
            const protectElements = (el) => {
              if (!el) return;
              
              // Proteger TODOS los elementos (imágenes, slides, contenedores, botones, etc.)
              const allElements = el.querySelectorAll('*');
              allElements.forEach(element => {
                element.setAttribute('contenteditable', 'false');
                element.setAttribute('data-gjs-editable', 'false');
                element.setAttribute('data-gjs-selectable', 'false');
                element.setAttribute('data-gjs-draggable', 'false');
                element.setAttribute('data-gjs-droppable', 'false');
              });
              
              // También proteger el contenedor mismo
              el.setAttribute('contenteditable', 'false');
              el.setAttribute('data-gjs-editable', 'false');
            };
            
            protectElements(this.el);
            
            // Observar cambios en el DOM para proteger nuevos elementos
            const observer = new MutationObserver(() => {
              protectElements(this.el);
            });
            
            observer.observe(this.el, {
              childList: true,
              subtree: true
            });
            
            // Guardar observer para limpiarlo después
            this._carouselObserver = observer;
          }
        },
        onRemove() {
          // Limpiar observer cuando se remueve el componente
          if (this._carouselObserver) {
            this._carouselObserver.disconnect();
          }
        }
      }
    });
    
  }
  
  if (typeof window !== 'undefined' && window.editor) {
    registerCarouselComponent(window.editor);
  } else {
    const checkEditor = setInterval(() => {
      if (typeof window !== 'undefined' && window.editor) {
        registerCarouselComponent(window.editor);
        clearInterval(checkEditor);
      }
    }, 100);
    
    setTimeout(() => {
      clearInterval(checkEditor);
    }, 10000);
  }
  
  if (typeof window !== 'undefined') {
    window.registerCarouselComponent = registerCarouselComponent;
  }
})();
