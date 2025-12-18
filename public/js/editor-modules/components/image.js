// Módulo del Componente Image
// Componente de imagen con galería y sincronización completa

(function() {
  'use strict';
  
  // Función para registrar el componente Image
  function registerImageComponent(editor) {
    if (!editor || !editor.DomComponents) {
      console.warn('⚠️ Editor no disponible para registrar componente Image');
      return;
    }
    
    editor.DomComponents.addType('image', {
      isComponent: (el) => {
        if (el.tagName === 'IMG') {
          return { type: 'image' };
        }
        return false;
      },
      model: {
        defaults: {
          name: 'Imagen',
          tagName: 'img',
          editable: false,
          droppable: false,
          removable: true,
          selectable: true,
          attributes: {
            class: 'image-component max-w-full h-auto rounded-lg',
            'data-gjs-name': 'Imagen',
            'data-gjs-editable': 'false'
          },
          traits: [
            {
              type: 'button',
              name: 'select-image-gallery',
              label: '📁 Seleccionar desde Galería',
              text: 'Abrir Galería de Imágenes',
              full: true,
              command: (editor) => {
                const component = editor.getSelected();
                if (component && component.get('type') === 'image') {
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
                        
                        // Validar que newSrc sea válido
                        if (!newSrc || typeof newSrc !== 'string' || newSrc.trim() === '') {
                          console.warn('⚠️ URL de imagen inválida:', newSrc);
                          return;
                        }
                        
                        if (newSrc && component) {
                          // ✅ 1. Actualizar image-src en el modelo
                          component.set('image-src', newSrc, { silent: false });
                          
                          // ✅ 2. Actualizar atributo src en el modelo
                          component.setAttributes({ src: newSrc });
                          
                          // ✅ 3. Actualizar el DOM directamente (CRÍTICO para guardar)
                          if (component.view && component.view.el) {
                            const el = component.view.el;
                            el.src = newSrc;
                            el.setAttribute('src', newSrc);
                            
                            // Verificar y forzar actualización después de un momento
                            setTimeout(() => {
                              if (el.src !== newSrc) {
                                el.src = newSrc;
                                el.setAttribute('src', newSrc);
                              }
                            }, 50);
                          }
                          
                          // ✅ 4. Llamar a updateSrc si existe para sincronización completa
                          if (typeof component.updateSrc === 'function') {
                            component.updateSrc();
                          }
                          
                          // ✅ 5. Forzar renderizado
                          if (component.view) {
                            component.view.render();
                          }
                          
                          // ✅ 6. Disparar eventos
                          component.trigger('change:image-src');
                          component.trigger('change:attributes');
                          
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
                          component.set('image-src', newSrc, { silent: false });
                          component.setAttributes({ src: newSrc });
                          if (component.view && component.view.el) {
                            const el = component.view.el;
                            el.src = newSrc;
                            el.setAttribute('src', newSrc);
                            setTimeout(() => {
                              if (el.src !== newSrc) {
                                el.src = newSrc;
                                el.setAttribute('src', newSrc);
                              }
                            }, 50);
                          }
                          if (component.view) {
                            component.view.render();
                          }
                          component.trigger('change:image-src');
                          component.trigger('change:attributes');
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
              name: 'image-src',
              label: 'URL de la Imagen',
              placeholder: 'https://ejemplo.com/imagen.jpg',
              changeProp: 1
            },
            {
              type: 'text',
              name: 'image-alt',
              label: 'Texto Alternativo',
              placeholder: 'Descripción de la imagen',
              changeProp: 1
            },
            {
              type: 'text',
              name: 'image-title',
              label: 'Título (Tooltip)',
              placeholder: 'Aparece al pasar el cursor',
              changeProp: 1
            },
            {
              type: 'select',
              name: 'image-width',
              label: 'Ancho',
              changeProp: 1,
              options: [
                { value: 'w-auto', name: 'Automático' },
                { value: 'w-full', name: 'Ancho Completo (100%)' },
                { value: 'w-1/2', name: 'Medio (50%)' },
                { value: 'w-1/3', name: 'Un Tercio (33%)' },
                { value: 'w-1/4', name: 'Un Cuarto (25%)' },
                { value: 'w-64', name: '256px' },
                { value: 'w-48', name: '192px' },
                { value: 'w-32', name: '128px' }
              ]
            },
            {
              type: 'select',
              name: 'image-align',
              label: 'Alineación',
              changeProp: 1,
              options: [
                { value: '', name: 'Por Defecto' },
                { value: 'mx-auto', name: 'Centro' },
                { value: 'ml-auto', name: 'Derecha' },
                { value: 'mr-auto', name: 'Izquierda' }
              ]
            },
            {
              type: 'select',
              name: 'image-radius',
              label: 'Bordes Redondeados',
              changeProp: 1,
              options: [
                { value: 'rounded-none', name: 'Sin Redondeo' },
                { value: 'rounded-sm', name: 'Pequeño' },
                { value: 'rounded', name: 'Normal' },
                { value: 'rounded-md', name: 'Mediano' },
                { value: 'rounded-lg', name: 'Grande' },
                { value: 'rounded-xl', name: 'Extra Grande' },
                { value: 'rounded-full', name: 'Circular' }
              ]
            },
            {
              type: 'select',
              name: 'image-object-fit',
              label: 'Ajuste de Imagen',
              changeProp: 1,
              options: [
                { value: 'object-contain', name: 'Contener (Sin recortar)' },
                { value: 'object-cover', name: 'Cubrir (Recortar)' },
                { value: 'object-fill', name: 'Llenar' },
                { value: 'object-none', name: 'Sin Ajuste' },
                { value: 'object-scale-down', name: 'Reducir' }
              ]
            },
            {
              type: 'select',
              name: 'image-loading',
              label: 'Carga de Imagen',
              changeProp: 1,
              options: [
                { value: '', name: 'Por Defecto' },
                { value: 'lazy', name: 'Lazy (Diferida)' },
                { value: 'eager', name: 'Eager (Inmediata)' }
              ]
            }
          ]
        },
        toHTML() {
          // ✅ CRÍTICO: Sobrescribir toHTML para asegurar que use el src correcto al serializar
          const imageSrc = this.get('image-src');
          const attrsSrc = this.getAttributes().src;
          const domSrc = this.view && this.view.el ? this.view.el.src : null;
          const defaultImageSrc = '/images/default-image.jpg';
          
          // Determinar el src final: priorizar image-src, luego DOM, luego attrs, luego default
          let finalSrc;
          if (imageSrc && imageSrc.trim() && imageSrc !== 'undefined' && imageSrc !== defaultImageSrc && imageSrc !== '' && imageSrc !== 'null') {
            finalSrc = imageSrc.trim();
          } else if (domSrc && domSrc.trim() && domSrc !== 'undefined' && domSrc !== defaultImageSrc && domSrc !== '' && domSrc !== 'null') {
            finalSrc = domSrc.trim();
          } else if (attrsSrc && attrsSrc.trim() && attrsSrc !== 'undefined' && attrsSrc !== defaultImageSrc && attrsSrc !== '' && attrsSrc !== 'null') {
            finalSrc = attrsSrc.trim();
          } else {
            finalSrc = defaultImageSrc;
          }
          
          // ✅ CRÍTICO: Asegurar que el modelo tenga el src correcto ANTES de serializar
          const currentAttrs = this.getAttributes();
          if (currentAttrs.src !== finalSrc) {
            currentAttrs.src = finalSrc;
            this.setAttributes(currentAttrs);
          }
          
          // Obtener el HTML usando el método por defecto de GrapeJS
          // Primero obtener el HTML base
          const tagName = this.get('tagName') || 'img';
          const attrs = this.getAttributes();
          
          // Construir atributos como string
          let attrsArray = [];
          for (let key in attrs) {
            if (attrs.hasOwnProperty(key) && attrs[key] !== null && attrs[key] !== undefined && attrs[key] !== '') {
              const value = String(attrs[key]).replace(/"/g, '&quot;');
              attrsArray.push(`${key}="${value}"`);
            }
          }
          
          const attrsStr = attrsArray.join(' ');
          
          // Retornar el HTML con el src correcto
          return `<${tagName}${attrsStr ? ' ' + attrsStr : ''} />`;
        },
        init() {
          const defaultImageSrc = '/images/default-image.jpg';
          
          const attrs = this.getAttributes();
          const currentSrc = attrs.src || '';
          // Validar y asignar imagen por defecto si es necesario
          if (!currentSrc || currentSrc.trim() === '' || currentSrc === 'undefined' || currentSrc === 'null') {
            this.setAttributes({ src: defaultImageSrc });
            this.set('image-src', defaultImageSrc, { silent: true });
          }
          
          const syncInitialValues = () => {
            if (this.view && this.view.el) {
              const el = this.view.el;
              const attrs = this.getAttributes();
              
              const imageSrc = this.get('image-src');
              const currentSrc = attrs.src || el.src || '';
              
              if (!el.className.includes('image-component')) {
                el.classList.add('image-component');
              }
              if (!el.className.includes('max-w-full')) {
                el.classList.add('max-w-full');
              }
              if (!el.className.includes('h-auto')) {
                el.classList.add('h-auto');
              }
              
              let finalSrc;
              if (imageSrc && imageSrc.trim() && imageSrc !== 'undefined' && imageSrc !== defaultImageSrc) {
                finalSrc = imageSrc.trim();
                if (el.src !== finalSrc) {
                  el.src = finalSrc;
                }
                if (attrs.src !== finalSrc) {
                  this.setAttributes({ src: finalSrc });
                }
              } else if (currentSrc && currentSrc.trim() && currentSrc !== 'undefined' && currentSrc !== defaultImageSrc) {
                finalSrc = currentSrc.trim();
                if (el.src !== finalSrc) {
                  el.src = finalSrc;
                }
                this.set('image-src', finalSrc, { silent: true });
              } else {
                finalSrc = defaultImageSrc;
                if (el.src !== finalSrc) {
                  el.src = finalSrc;
                }
                if (attrs.src !== finalSrc) {
                  this.setAttributes({ src: finalSrc });
                }
                if (!imageSrc || imageSrc === defaultImageSrc) {
                  this.set('image-src', finalSrc, { silent: true });
                }
              }
              
              if (attrs.alt || el.alt) {
                this.set('image-alt', attrs.alt || el.alt, { silent: true });
              }
              
              if (attrs.title || el.title) {
                this.set('image-title', attrs.title || el.title, { silent: true });
              }
              
              const classList = (el.className || '').split(' ').filter(c => c.trim());
              const widthMatch = classList.find(c => c.match(/^w-(auto|full|1\/2|1\/3|1\/4|64|48|32)$/));
              if (widthMatch) {
                this.set('image-width', widthMatch, { silent: true });
              }
              
              const alignMatch = classList.find(c => c.match(/^(mx-auto|ml-auto|mr-auto)$/));
              if (alignMatch) {
                this.set('image-align', alignMatch, { silent: true });
              }
              
              const radiusMatch = classList.find(c => c.match(/^rounded(-(none|sm|md|lg|xl|full))?$/));
              if (radiusMatch) {
                this.set('image-radius', radiusMatch, { silent: true });
              }
              
              const objectFitMatch = classList.find(c => c.match(/^object-(contain|cover|fill|none|scale-down)$/));
              if (objectFitMatch) {
                this.set('image-object-fit', objectFitMatch, { silent: true });
              }
              
              if (attrs.loading || el.loading) {
                this.set('image-loading', attrs.loading || el.loading, { silent: true });
              }
            }
          };
          
          setTimeout(syncInitialValues, 50);
          setTimeout(syncInitialValues, 200);
          this.on('component:mount', syncInitialValues);
          this.on('component:selected', syncInitialValues);
          this.on('component:update', syncInitialValues);
          
          this.on('component:mount', () => {
            setTimeout(() => {
              if (this.view && this.view.el) {
                const el = this.view.el;
                const attrs = this.getAttributes();
                const imageSrc = this.get('image-src');
                const src = (imageSrc && imageSrc.trim() && imageSrc !== 'undefined' && imageSrc !== defaultImageSrc)
                  ? imageSrc.trim()
                  : (attrs.src && attrs.src.trim() && attrs.src !== 'undefined' && attrs.src !== defaultImageSrc)
                    ? attrs.src.trim()
                    : defaultImageSrc;
                if (el.src !== src) {
                  el.src = src;
                  el.setAttribute('src', src);
                }
              }
            }, 100);
          });
          
          const addDoubleClickHandler = () => {
            if (this.view && this.view.el) {
              const el = this.view.el;
              
              if (el._doubleClickHandler) {
                el.removeEventListener('dblclick', el._doubleClickHandler);
              }
              
              const doubleClickHandler = (e) => {
                e.preventDefault();
                e.stopPropagation();
                
                const am = editor.AssetManager;
                const modal = editor.Modal;
                const currentComponent = editor.getSelected() || this;
                
                if (!currentComponent || currentComponent.get('type') !== 'image') {
                  console.warn('⚠️ No se encontró un componente de imagen seleccionado');
                  return;
                }
                
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
                      
                      // Validar que newSrc sea válido
                      if (!newSrc || typeof newSrc !== 'string' || newSrc.trim() === '') {
                        console.warn('⚠️ URL de imagen inválida:', newSrc);
                        return;
                      }
                      
                      if (newSrc && currentComponent) {
                        // ✅ 1. Actualizar image-src en el modelo
                        currentComponent.set('image-src', newSrc, { silent: false });
                        
                        // ✅ 2. Actualizar atributo src en el modelo
                        currentComponent.setAttributes({ src: newSrc });
                        
                        // ✅ 3. Actualizar el DOM directamente (CRÍTICO para guardar)
                        if (currentComponent.view && currentComponent.view.el) {
                          const el = currentComponent.view.el;
                          el.src = newSrc;
                          el.setAttribute('src', newSrc);
                        }
                        
                        // ✅ 4. Llamar a updateSrc si existe para sincronización completa
                        if (typeof currentComponent.updateSrc === 'function') {
                          currentComponent.updateSrc();
                        }
                        
                        // ✅ 5. Forzar renderizado
                        if (currentComponent.view) {
                          currentComponent.view.render();
                          currentComponent.trigger('change:image-src');
                          currentComponent.trigger('change:attributes');
                        }
                        
                        // ✅ 6. Verificar y forzar actualización después de un momento
                        setTimeout(() => {
                          if (currentComponent.view && currentComponent.view.el) {
                            const el = currentComponent.view.el;
                            if (el.src !== newSrc) {
                              el.src = newSrc;
                              el.setAttribute('src', newSrc);
                            }
                          }
                        }, 100);
                        
                        modal.close();
                        
                        setTimeout(() => {
                          if (editor.TraitManager) {
                            editor.TraitManager.render();
                          }
                        }, 150);
                      } else {
                        console.warn('⚠️ No se pudo obtener el src o el componente no está disponible');
                      }
                    };
                    
                    am.onClick(onClickHandler);
                    
                    modal.setTitle('Seleccionar Imagen desde Galería')
                      .setContent(am.render())
                      .open();
                  })
                  .catch(error => {
                    console.error('❌ Error al cargar imágenes desde la biblioteca:', error);
                    
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
                      
                      // Validar que newSrc sea válido
                      if (!newSrc || typeof newSrc !== 'string' || newSrc.trim() === '') {
                        console.warn('⚠️ URL de imagen inválida:', newSrc);
                        return;
                      }
                      
                      if (newSrc && currentComponent) {
                        // ✅ 1. Actualizar image-src en el modelo
                        currentComponent.set('image-src', newSrc, { silent: false });
                        
                        // ✅ 2. Actualizar atributo src en el modelo
                        currentComponent.setAttributes({ src: newSrc });
                        
                        // ✅ 3. Actualizar el DOM directamente (CRÍTICO para guardar)
                        if (currentComponent.view && currentComponent.view.el) {
                          const el = currentComponent.view.el;
                          el.src = newSrc;
                          el.setAttribute('src', newSrc);
                        }
                        
                        // ✅ 4. Llamar a updateSrc si existe
                        if (typeof currentComponent.updateSrc === 'function') {
                          currentComponent.updateSrc();
                        }
                        
                        // ✅ 5. Forzar renderizado
                        if (currentComponent.view) {
                          currentComponent.view.render();
                        }
                        
                        // ✅ 6. Disparar eventos
                        currentComponent.trigger('change:image-src');
                        currentComponent.trigger('change:attributes');
                        
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
                  });
              };
              
              el._doubleClickHandler = doubleClickHandler;
              el.addEventListener('dblclick', doubleClickHandler);
              el.style.cursor = 'pointer';
              el.title = 'Doble clic para cambiar imagen';
            }
          };
          
          this.on('component:mount', () => {
            setTimeout(addDoubleClickHandler, 200);
          });
          this.on('component:selected', () => {
            setTimeout(addDoubleClickHandler, 100);
          });
          
          this.on('change:image-src', this.updateSrc, this);
          this.on('change:image-alt', this.updateAlt, this);
          this.on('change:image-title', this.updateTitle, this);
          this.on('change:image-width', this.updateWidth, this);
          this.on('change:image-align', this.updateAlign, this);
          this.on('change:image-radius', this.updateRadius, this);
          this.on('change:image-object-fit', this.updateObjectFit, this);
          this.on('change:image-loading', this.updateLoading, this);
        },
        updateSrc() {
          const defaultImageSrc = '/images/default-image.jpg';
          const imageSrc = this.get('image-src');
          const currentAttrs = this.getAttributes();
          const currentSrc = currentAttrs.src;
          
          let finalSrc;
          if (imageSrc && imageSrc.trim() && imageSrc !== 'undefined' && imageSrc !== defaultImageSrc) {
            finalSrc = imageSrc.trim();
          } else if (currentSrc && currentSrc.trim() && currentSrc !== 'undefined' && currentSrc !== defaultImageSrc) {
            finalSrc = currentSrc.trim();
            if (!imageSrc || imageSrc === defaultImageSrc) {
              this.set('image-src', finalSrc, { silent: true });
            }
          } else {
            finalSrc = defaultImageSrc;
          }
          
          // Validar que finalSrc sea válido
          if (!finalSrc || typeof finalSrc !== 'string' || finalSrc.trim() === '' || finalSrc === 'null') {
            finalSrc = defaultImageSrc;
          }
          
          // ✅ CRÍTICO: Actualizar atributos del modelo PRIMERO
          this.setAttributes({ src: finalSrc });
          
          // ✅ CRÍTICO: Sincronizar image-src
          if (finalSrc !== defaultImageSrc && this.get('image-src') !== finalSrc) {
            this.set('image-src', finalSrc, { silent: true });
          }
          
          // ✅ CRÍTICO: Actualizar el DOM directamente (getHtml() lee del DOM)
          if (this.view && this.view.el) {
            const el = this.view.el;
            
            // Forzar actualización del src en el DOM
            el.src = finalSrc;
            el.setAttribute('src', finalSrc);
            
            // Verificar y forzar nuevamente después de un momento
            setTimeout(() => {
              if (el.src !== finalSrc) {
                el.src = finalSrc;
                el.setAttribute('src', finalSrc);
              }
            }, 50);
          } else {
            console.warn('⚠️ No se encontró view.el en updateSrc');
          }
        },
        updateAlt() {
          const alt = this.get('image-alt') || '';
          if (this.view && this.view.el) {
            const el = this.view.el;
            el.alt = alt;
            this.setAttributes({ alt: alt });
          }
        },
        updateTitle() {
          const title = this.get('image-title') || '';
          if (this.view && this.view.el) {
            const el = this.view.el;
            el.title = title;
            this.setAttributes({ title: title });
          }
        },
        updateWidth() {
          const width = this.get('image-width') || 'w-auto';
          if (this.view && this.view.el) {
            const el = this.view.el;
            const currentAttrs = this.getAttributes();
            let currentClass = currentAttrs.class || el.className || '';
            if (!currentClass.includes('image-component')) {
              currentClass = (currentClass + ' image-component').trim();
            }
            if (!currentClass.includes('max-w-full')) {
              currentClass = (currentClass + ' max-w-full').trim();
            }
            if (!currentClass.includes('h-auto')) {
              currentClass = (currentClass + ' h-auto').trim();
            }
            currentClass = currentClass.replace(/w-(auto|full|1\/2|1\/3|1\/4|64|48|32)/g, '').trim();
            currentClass = (currentClass + ' ' + width).trim();
            currentClass = currentClass.replace(/\s+/g, ' ');
            el.className = currentClass;
            this.setAttributes({ class: currentClass });
          }
        },
        updateAlign() {
          const align = this.get('image-align') || '';
          if (this.view && this.view.el) {
            const el = this.view.el;
            const currentAttrs = this.getAttributes();
            let currentClass = currentAttrs.class || el.className || '';
            if (!currentClass.includes('image-component')) {
              currentClass = (currentClass + ' image-component').trim();
            }
            currentClass = currentClass.replace(/mx-auto|ml-auto|mr-auto/g, '').trim();
            if (align) {
              currentClass = (currentClass + ' ' + align).trim();
            }
            currentClass = currentClass.replace(/\s+/g, ' ');
            el.className = currentClass;
            this.setAttributes({ class: currentClass });
          }
        },
        updateRadius() {
          const radius = this.get('image-radius') || 'rounded-lg';
          if (this.view && this.view.el) {
            const el = this.view.el;
            const currentAttrs = this.getAttributes();
            let currentClass = currentAttrs.class || el.className || '';
            if (!currentClass.includes('image-component')) {
              currentClass = (currentClass + ' image-component').trim();
            }
            currentClass = currentClass.replace(/rounded(-(none|sm|md|lg|xl|full))?/g, '').trim();
            currentClass = (currentClass + ' ' + radius).trim();
            currentClass = currentClass.replace(/\s+/g, ' ');
            el.className = currentClass;
            this.setAttributes({ class: currentClass });
          }
        },
        updateObjectFit() {
          const objectFit = this.get('image-object-fit') || '';
          if (this.view && this.view.el) {
            const el = this.view.el;
            const currentAttrs = this.getAttributes();
            let currentClass = currentAttrs.class || el.className || '';
            if (!currentClass.includes('image-component')) {
              currentClass = (currentClass + ' image-component').trim();
            }
            currentClass = currentClass.replace(/object-(contain|cover|fill|none|scale-down)/g, '').trim();
            if (objectFit) {
              currentClass = (currentClass + ' ' + objectFit).trim();
            }
            currentClass = currentClass.replace(/\s+/g, ' ');
            el.className = currentClass;
            this.setAttributes({ class: currentClass });
          }
        },
        updateLoading() {
          const loading = this.get('image-loading') || '';
          if (this.view && this.view.el) {
            const el = this.view.el;
            if (loading) {
              el.loading = loading;
              this.setAttributes({ loading: loading });
            } else {
              el.removeAttribute('loading');
              const attrs = this.getAttributes();
              delete attrs.loading;
              this.setAttributes(attrs);
            }
          }
        }
      }
    });
    
  }
  
  // Auto-registrar cuando el editor esté disponible
  if (typeof window !== 'undefined' && window.editor) {
    registerImageComponent(window.editor);
  } else {
    // Esperar a que el editor esté disponible
    const checkEditor = setInterval(() => {
      if (typeof window !== 'undefined' && window.editor) {
        registerImageComponent(window.editor);
        clearInterval(checkEditor);
      }
    }, 100);
    
    // Timeout de seguridad (10 segundos)
    setTimeout(() => {
      clearInterval(checkEditor);
    }, 10000);
  }
  
  // Exportar función para registro manual
  if (typeof window !== 'undefined') {
    window.registerImageComponent = registerImageComponent;
  }
})();
