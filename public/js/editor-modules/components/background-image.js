// Módulo del Componente Background Image
// Componente de sección con imagen de fondo y contenido superpuesto

(function() {
  'use strict';
  
  function registerBackgroundImageComponent(editor) {
    if (!editor || !editor.DomComponents) {
      return;
    }
    
    editor.DomComponents.addType('background-image', {
      isComponent: (el) => {
        if (el.tagName === 'DIV' && (
          el.classList.contains('background-image-section') ||
          el.getAttribute('data-gjs-type') === 'background-image'
        )) {
          return { type: 'background-image' };
        }
        return false;
      },
      model: {
        defaults: {
          name: 'Imagen de Fondo',
          draggable: true,
          droppable: true,  // ✅ PERMITIDO: Acepta contenido hijo
          selectable: true,
          editable: false,   // ✅ BLOQUEADO: No edición directa del contenedor
          removable: true,
          copyable: true,
          badgable: false,  // ✅ OCULTO: No mostrar badge "DIV"
          stylable: true,
          highlightable: true,
          toolbar: true,    // ✅ PERMITIDO: Mostrar toolbar con controles de eliminación
          resizable: false,
          layerable: true,
          attributes: {
            'data-gjs-type': 'background-image',
            'data-gjs-name': 'Imagen de Fondo',
            'data-gjs-editable': 'false',
            'data-gjs-badgable': 'false'  // ✅ OCULTO: No mostrar badge
          },
          'background-image-url': '/images/default-image.jpg',
          'overlay-opacity': '50',
          'height': '384',  // h-96 = 384px
          'content-title': 'Contenido sobre Imagen',
          'content-text': 'Texto superpuesto sobre la imagen de fondo',
          'button-text': 'Botón de Acción',
          'button-link': '#',
          'title-color': '#ffffff',
          'text-color': '#ffffff',
          'button-bg-color': '#ffffff',
          'button-text-color': '#111827',
          traits: [
            {
              type: 'button',
              name: 'select-background-image',
              label: '📁 Seleccionar Imagen de Fondo',
              text: 'Abrir Galería de Imágenes',
              full: true,
              command: (editor) => {
                const component = editor.getSelected();
                if (component && component.get('type') === 'background-image') {
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
                      } else {
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
                          component.set('background-image-url', newSrc, { silent: false });
                          component.updateBackgroundImage();
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
                      
                    })
                    .catch(error => {
                      am.onClick((asset) => {
                        let newSrc = asset.get('src') || asset.get('url') || asset.src || asset.url;
                        if (newSrc && component) {
                          component.set('background-image-url', newSrc, { silent: false });
                          component.updateBackgroundImage();
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
              name: 'background-image-url',
              label: 'URL de Imagen de Fondo',
              placeholder: '/images/default-image.jpg',
              changeProp: 1
            },
            {
              type: 'select',
              name: 'overlay-opacity',
              label: 'Opacidad del Overlay',
              changeProp: 1,
              options: [
                { value: '0', name: 'Sin Overlay (0%)' },
                { value: '25', name: 'Claro (25%)' },
                { value: '50', name: 'Medio (50%)' },
                { value: '75', name: 'Oscuro (75%)' },
                { value: '100', name: 'Muy Oscuro (100%)' }
              ]
            },
            {
              type: 'text',
              name: 'height',
              label: 'Altura (px)',
              placeholder: '384',
              changeProp: 1
            },
            {
              type: 'text',
              name: 'content-title',
              label: 'Título',
              placeholder: 'Contenido sobre Imagen',
              changeProp: 1
            },
            {
              type: 'text',
              name: 'content-text',
              label: 'Texto',
              placeholder: 'Texto superpuesto sobre la imagen de fondo',
              changeProp: 1
            },
            {
              type: 'text',
              name: 'button-text',
              label: 'Texto del Botón',
              placeholder: 'Botón de Acción',
              changeProp: 1
            },
            {
              type: 'text',
              name: 'button-link',
              label: 'Enlace del Botón',
              placeholder: '#',
              changeProp: 1
            },
            {
              type: 'color',
              name: 'title-color',
              label: 'Color del Título',
              changeProp: 1
            },
            {
              type: 'color',
              name: 'text-color',
              label: 'Color del Texto',
              changeProp: 1
            },
            {
              type: 'color',
              name: 'button-bg-color',
              label: 'Color de Fondo del Botón',
              changeProp: 1
            },
            {
              type: 'color',
              name: 'button-text-color',
              label: 'Color del Texto del Botón',
              changeProp: 1
            }
          ]
        },
        init() {
          
          this.on('change:background-image-url', this.updateBackgroundImage, this);
          this.on('change:overlay-opacity', this.updateOverlay, this);
          this.on('change:height', this.updateHeight, this);
          this.on('change:content-title', this.updateTitle, this);
          this.on('change:content-text', this.updateText, this);
          this.on('change:button-text', this.updateButtonText, this);
          this.on('change:button-link', this.updateButtonLink, this);
          this.on('change:title-color', this.updateTitleColor, this);
          this.on('change:text-color', this.updateTextColor, this);
          this.on('change:button-bg-color', this.updateButtonBgColor, this);
          this.on('change:button-text-color', this.updateButtonTextColor, this);
          
          // ✅ CRÍTICO: Sincronizar valores iniciales desde el DOM siempre
          // Esto asegura que los valores guardados se carguen correctamente
          const syncInitialValues = () => {
            if (this.view && this.view.el) {
              const titleEl = this.view.el.querySelector('h2');
              const textEl = this.view.el.querySelector('p');
              const buttonEl = this.view.el.querySelector('button, a');
              
              // Siempre sincronizar desde el DOM (prioridad al HTML guardado)
              if (titleEl) {
                const domTitle = titleEl.textContent || titleEl.innerText || '';
                if (domTitle.trim()) {
                  this.set('content-title', domTitle.trim(), { silent: true });
                }
              }
              
              if (textEl) {
                const domText = textEl.textContent || textEl.innerText || '';
                if (domText.trim()) {
                  this.set('content-text', domText.trim(), { silent: true });
                }
              }
              
              if (buttonEl) {
                const domButtonText = buttonEl.textContent || buttonEl.innerText || '';
                if (domButtonText.trim()) {
                  this.set('button-text', domButtonText.trim(), { silent: true });
                }
                
                const href = buttonEl.getAttribute('href');
                if (href) {
                  this.set('button-link', href, { silent: true });
                } else if (buttonEl.tagName === 'BUTTON') {
                  this.set('button-link', '#', { silent: true });
                }
              }
              
              // Aplicar colores desde el modelo al DOM
              if (titleEl) {
                const titleColor = this.get('title-color') || '#ffffff';
                titleEl.style.setProperty('color', titleColor, 'important');
              }
              
              if (textEl) {
                const textColor = this.get('text-color') || '#ffffff';
                textEl.style.setProperty('color', textColor, 'important');
              }
              
              if (buttonEl) {
                const buttonBgColor = this.get('button-bg-color') || '#ffffff';
                const buttonTextColor = this.get('button-text-color') || '#111827';
                buttonEl.style.setProperty('background-color', buttonBgColor, 'important');
                buttonEl.style.setProperty('color', buttonTextColor, 'important');
              }
            }
          };
          
          // Sincronizar inmediatamente y después de renderizar
          syncInitialValues();
          setTimeout(syncInitialValues, 100);
          setTimeout(syncInitialValues, 300);
          setTimeout(syncInitialValues, 500); // Sincronizar después de que todo esté cargado
          
          // También sincronizar cuando se monta el componente
          this.on('component:mount', syncInitialValues);
          this.on('component:update', syncInitialValues);
          
          // Sincronizar cuando se renderiza la vista
          if (this.view) {
            this.view.on('render', syncInitialValues);
          }
          
          // Aplicar colores iniciales después de un breve delay
          setTimeout(() => {
            if (this.view && this.view.el) {
              const titleEl = this.view.el.querySelector('h2');
              const textEl = this.view.el.querySelector('p');
              const buttonEl = this.view.el.querySelector('button, a');
              
              if (titleEl) {
                const titleColor = this.get('title-color') || '#ffffff';
                titleEl.style.setProperty('color', titleColor, 'important');
              }
              
              if (textEl) {
                const textColor = this.get('text-color') || '#ffffff';
                textEl.style.setProperty('color', textColor, 'important');
              }
              
              if (buttonEl) {
                const buttonBgColor = this.get('button-bg-color') || '#ffffff';
                const buttonTextColor = this.get('button-text-color') || '#111827';
                buttonEl.style.setProperty('background-color', buttonBgColor, 'important');
                buttonEl.style.setProperty('color', buttonTextColor, 'important');
              }
            }
          }, 600);
          
          // ✅ DEBUG: CÓDIGO DE PROTECCIÓN COMENTADO PARA IDENTIFICAR EL PROBLEMA
          // ✅ CRÍTICO: Proteger TODOS los elementos internos - NO edición directa
          // TODO debe modificarse desde las propiedades, NADA directamente en el canvas
          // ✅ IMPORTANTE: El componente principal (this) NO se protege aquí, solo sus hijos
          /*
          const protectElements = () => {
            // Evitar ejecución múltiple simultánea
            if (this._isProtectingInit) return;
            this._isProtectingInit = true;
            
            // ✅ Asegurar que el componente principal mantenga removable: true
            this.set('removable', true);
            
            const protectRecursive = (component) => {
              // ✅ Verificar que no sea el componente principal
              if (component === this) {
                return; // No proteger el componente principal
              }
              
              // Proteger el componente actual completamente (solo elementos hijos)
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
                'data-gjs-removable': 'false',
                'contenteditable': 'false'
              });
              
              // Proteger recursivamente todos los hijos
              component.components().each(grandchild => {
                protectRecursive(grandchild);
              });
            };
            
            // ✅ Solo proteger los hijos, no el componente principal
            this.components().each(child => {
              protectRecursive(child);
            });
            
            setTimeout(() => {
              this._isProtectingInit = false;
            }, 50);
          };
          
          setTimeout(protectElements, 100);
          this.on('component:mount', protectElements);
          this.on('component:add', () => {
            setTimeout(protectElements, 100);
          });
          */
          
          // ✅ DEBUG: Asegurar que el componente principal mantenga removable: true (sin protección)
          this.set('removable', true);
        },
        updateBackgroundImage() {
          const imageUrl = this.get('background-image-url') || '/images/default-image.jpg';
          
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          
          // Actualizar el estilo background-image
          el.style.backgroundImage = `url('${imageUrl}')`;
          el.setAttribute('style', el.getAttribute('style') || '');
          
          // Actualizar también usando setStyle de GrapesJS
          const currentStyle = this.getStyle() || {};
          this.setStyle({
            ...currentStyle,
            'background-image': `url('${imageUrl}')`
          });
        },
        updateOverlay() {
          const opacity = this.get('overlay-opacity') || '50';
          
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          const overlay = el.querySelector('.absolute.inset-0.bg-black');
          
          if (overlay) {
            const opacityValue = parseInt(opacity) / 100;
            overlay.style.backgroundColor = `rgba(0, 0, 0, ${opacityValue})`;
            overlay.className = `absolute inset-0 bg-black`;
            overlay.style.opacity = opacityValue.toString();
            
            // Actualizar también en el modelo de GrapesJS
            const findOverlay = (component) => {
              if (component.get('tagName') === 'div' && 
                  component.getAttributes().class?.includes('absolute') &&
                  component.getAttributes().class?.includes('inset-0')) {
                return component;
              }
              let found = null;
              component.components().each(child => {
                if (!found) {
                  found = findOverlay(child);
                }
              });
              return found;
            };
            
            const overlayComponent = findOverlay(this);
            if (overlayComponent) {
              overlayComponent.setStyle({
                backgroundColor: `rgba(0, 0, 0, ${opacityValue})`,
                opacity: opacityValue.toString()
              });
            }
          }
        },
        updateHeight() {
          const height = this.get('height') || '384';
          const heightPx = `${height}px`;
          console.log('📏 Actualizando altura:', heightPx);
          
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          el.style.height = heightPx;
          
          // Actualizar también usando setStyle de GrapesJS
          const currentStyle = this.getStyle() || {};
          this.setStyle({
            ...currentStyle,
            height: heightPx
          });
        },
        updateTitle() {
          const title = this.get('content-title') || 'Contenido sobre Imagen';
          
          // Buscar el componente h2
          const findTitle = (component) => {
            if (component.get('tagName') === 'h2') {
              return component;
            }
            let found = null;
            component.components().each(child => {
              if (!found) {
                found = findTitle(child);
              }
            });
            return found;
          };
          
          const titleComponent = findTitle(this);
          if (titleComponent) {
            console.log('✅ [BackgroundImage] Componente h2 encontrado, actualizando');
            titleComponent.set('content', title);
            if (titleComponent.view && titleComponent.view.el) {
              titleComponent.view.el.textContent = title;
              console.log('✅ [BackgroundImage] DOM del componente h2 actualizado');
            }
          } else {
            console.warn('⚠️ [BackgroundImage] No se encontró componente h2');
          }
          
          // Actualizar también en el DOM directamente
          if (this.view && this.view.el) {
            const titleEl = this.view.el.querySelector('h2');
            if (titleEl) {
              titleEl.textContent = title;
              console.log('✅ [BackgroundImage] DOM h2 actualizado directamente');
            } else {
              console.warn('⚠️ [BackgroundImage] No se encontró h2 en el DOM');
            }
          } else {
            console.warn('⚠️ [BackgroundImage] view.el no disponible en updateTitle');
          }
        },
        updateText() {
          const text = this.get('content-text') || 'Texto superpuesto sobre la imagen de fondo';
          
          // Buscar el componente p
          const findText = (component) => {
            if (component.get('tagName') === 'p') {
              return component;
            }
            let found = null;
            component.components().each(child => {
              if (!found) {
                found = findText(child);
              }
            });
            return found;
          };
          
          const textComponent = findText(this);
          if (textComponent) {
            textComponent.set('content', text);
            if (textComponent.view && textComponent.view.el) {
              textComponent.view.el.textContent = text;
            }
          }
          
          // Actualizar también en el DOM directamente
          if (this.view && this.view.el) {
            const textEl = this.view.el.querySelector('p');
            if (textEl) {
              textEl.textContent = text;
            }
          }
        },
        updateButtonText() {
          const buttonText = this.get('button-text') || 'Botón de Acción';
          
          // Buscar el componente button
          const findButton = (component) => {
            if (component.get('tagName') === 'button' || component.get('tagName') === 'a') {
              return component;
            }
            let found = null;
            component.components().each(child => {
              if (!found) {
                found = findButton(child);
              }
            });
            return found;
          };
          
          const buttonComponent = findButton(this);
          if (buttonComponent) {
            buttonComponent.set('content', buttonText);
            if (buttonComponent.view && buttonComponent.view.el) {
              buttonComponent.view.el.textContent = buttonText;
            }
          }
          
          // Actualizar también en el DOM directamente
          if (this.view && this.view.el) {
            const buttonEl = this.view.el.querySelector('button, a');
            if (buttonEl) {
              buttonEl.textContent = buttonText;
            }
          }
        },
        updateButtonLink() {
          const buttonLink = this.get('button-link') || '#';
          
          // Buscar el componente button o a
          const findButton = (component) => {
            if (component.get('tagName') === 'button' || component.get('tagName') === 'a') {
              return component;
            }
            let found = null;
            component.components().each(child => {
              if (!found) {
                found = findButton(child);
              }
            });
            return found;
          };
          
          const buttonComponent = findButton(this);
          if (buttonComponent) {
            // Si tiene enlace válido, convertir a <a>, si no, mantener como <button>
            if (buttonLink && buttonLink !== '#' && buttonLink.trim() !== '') {
              // Si es button, convertirlo a <a>
              if (buttonComponent.get('tagName') === 'button') {
                const classes = buttonComponent.getAttributes().class || '';
                const text = buttonComponent.get('content') || buttonComponent.view?.el?.textContent || '';
                buttonComponent.set('tagName', 'a');
                buttonComponent.setAttributes({
                  ...buttonComponent.getAttributes(),
                  href: buttonLink,
                  class: classes
                });
                buttonComponent.set('content', text);
              } else {
                // Ya es un <a>, solo actualizar href
                buttonComponent.setAttributes({
                  ...buttonComponent.getAttributes(),
                  href: buttonLink
                });
              }
            } else {
              // Si no tiene enlace válido, convertir a <button>
              if (buttonComponent.get('tagName') === 'a') {
                const classes = buttonComponent.getAttributes().class || '';
                const text = buttonComponent.get('content') || buttonComponent.view?.el?.textContent || '';
                buttonComponent.set('tagName', 'button');
                const newAttrs = { ...buttonComponent.getAttributes() };
                delete newAttrs.href;
                buttonComponent.setAttributes({
                  ...newAttrs,
                  class: classes
                });
                buttonComponent.set('content', text);
              }
            }
            
            // Actualizar DOM
            if (buttonComponent.view && buttonComponent.view.el) {
              if (buttonLink && buttonLink !== '#' && buttonLink.trim() !== '') {
                if (buttonComponent.view.el.tagName === 'BUTTON') {
                  // Convertir button a link
                  const newLink = document.createElement('a');
                  newLink.href = buttonLink;
                  newLink.className = buttonComponent.view.el.className;
                  newLink.textContent = buttonComponent.view.el.textContent;
                  buttonComponent.view.el.parentNode.replaceChild(newLink, buttonComponent.view.el);
                  buttonComponent.view.el = newLink;
                } else {
                  buttonComponent.view.el.setAttribute('href', buttonLink);
                }
              } else {
                if (buttonComponent.view.el.tagName === 'A') {
                  // Convertir link a button
                  const newButton = document.createElement('button');
                  newButton.className = buttonComponent.view.el.className;
                  newButton.textContent = buttonComponent.view.el.textContent;
                  buttonComponent.view.el.parentNode.replaceChild(newButton, buttonComponent.view.el);
                  buttonComponent.view.el = newButton;
                }
              }
            }
          }
          
          // Actualizar también en el DOM directamente
          if (this.view && this.view.el) {
            const buttonEl = this.view.el.querySelector('button, a');
            if (buttonEl) {
              if (buttonLink && buttonLink !== '#' && buttonLink.trim() !== '') {
                if (buttonEl.tagName === 'BUTTON') {
                  // Convertir button a link
                  const newLink = document.createElement('a');
                  newLink.href = buttonLink;
                  newLink.className = buttonEl.className;
                  newLink.textContent = buttonEl.textContent;
                  buttonEl.parentNode.replaceChild(newLink, buttonEl);
                } else {
                  buttonEl.setAttribute('href', buttonLink);
                }
              } else {
                if (buttonEl.tagName === 'A') {
                  // Convertir link a button
                  const newButton = document.createElement('button');
                  newButton.className = buttonEl.className;
                  newButton.textContent = buttonEl.textContent;
                  buttonEl.parentNode.replaceChild(newButton, buttonEl);
                }
              }
            }
          }
        },
        updateTitleColor() {
          const color = this.get('title-color') || '#ffffff';
          
          // Buscar el componente h2
          const findTitle = (component) => {
            if (component.get('tagName') === 'h2') {
              return component;
            }
            let found = null;
            component.components().each(child => {
              if (!found) {
                found = findTitle(child);
              }
            });
            return found;
          };
          
          const titleComponent = findTitle(this);
          if (titleComponent) {
            titleComponent.setStyle({ color: color });
            if (titleComponent.view && titleComponent.view.el) {
              titleComponent.view.el.style.setProperty('color', color, 'important');
            }
          }
          
          // Actualizar también en el DOM directamente con !important
          if (this.view && this.view.el) {
            const titleEl = this.view.el.querySelector('h2');
            if (titleEl) {
              titleEl.style.setProperty('color', color, 'important');
            }
          }
          
          // Actualizar en el iframe del canvas
          const editor = this.em;
          if (editor && editor.Canvas) {
            const canvas = editor.Canvas;
            const frame = canvas.getFrameEl();
            if (frame && frame.contentDocument) {
              const frameDoc = frame.contentDocument;
              const frameTitleEl = frameDoc.querySelector('h2');
              if (frameTitleEl) {
                frameTitleEl.style.setProperty('color', color, 'important');
              }
            }
          }
          
          // Forzar re-renderizado
          if (this.view) {
            this.view.render();
          }
        },
        updateTextColor() {
          const color = this.get('text-color') || '#ffffff';
          
          // Buscar el componente p
          const findText = (component) => {
            if (component.get('tagName') === 'p') {
              return component;
            }
            let found = null;
            component.components().each(child => {
              if (!found) {
                found = findText(child);
              }
            });
            return found;
          };
          
          const textComponent = findText(this);
          if (textComponent) {
            textComponent.setStyle({ color: color });
            if (textComponent.view && textComponent.view.el) {
              textComponent.view.el.style.color = color;
            }
          }
          
          // Actualizar también en el DOM directamente
          if (this.view && this.view.el) {
            const textEl = this.view.el.querySelector('p');
            if (textEl) {
              textEl.style.color = color;
            }
          }
        },
        updateButtonBgColor() {
          const color = this.get('button-bg-color') || '#ffffff';
          console.log('🎨 [BackgroundImage] updateButtonBgColor() llamado con:', color);
          
          // Buscar el componente button o a
          const findButton = (component) => {
            if (component.get('tagName') === 'button' || component.get('tagName') === 'a') {
              return component;
            }
            let found = null;
            component.components().each(child => {
              if (!found) {
                found = findButton(child);
              }
            });
            return found;
          };
          
          const buttonComponent = findButton(this);
          if (buttonComponent) {
            buttonComponent.setStyle({ 'background-color': color });
            if (buttonComponent.view && buttonComponent.view.el) {
              buttonComponent.view.el.style.setProperty('background-color', color, 'important');
            }
          }
          
          // Actualizar también en el DOM directamente con !important
          if (this.view && this.view.el) {
            const buttonEl = this.view.el.querySelector('button, a');
            if (buttonEl) {
              buttonEl.style.setProperty('background-color', color, 'important');
            }
          }
          
          // Actualizar en el iframe del canvas
          const editor = this.em;
          if (editor && editor.Canvas) {
            const canvas = editor.Canvas;
            const frame = canvas.getFrameEl();
            if (frame && frame.contentDocument) {
              const frameDoc = frame.contentDocument;
              const frameButtonEl = frameDoc.querySelector('button, a');
              if (frameButtonEl) {
                frameButtonEl.style.setProperty('background-color', color, 'important');
              }
            }
          }
          
          // Forzar re-renderizado
          if (this.view) {
            this.view.render();
          }
        },
        updateButtonTextColor() {
          const color = this.get('button-text-color') || '#111827';
          
          // Buscar el componente button o a
          const findButton = (component) => {
            if (component.get('tagName') === 'button' || component.get('tagName') === 'a') {
              return component;
            }
            let found = null;
            component.components().each(child => {
              if (!found) {
                found = findButton(child);
              }
            });
            return found;
          };
          
          const buttonComponent = findButton(this);
          if (buttonComponent) {
            buttonComponent.setStyle({ color: color });
            if (buttonComponent.view && buttonComponent.view.el) {
              buttonComponent.view.el.style.setProperty('color', color, 'important');
            }
          }
          
          // Actualizar también en el DOM directamente con !important
          if (this.view && this.view.el) {
            const buttonEl = this.view.el.querySelector('button, a');
            if (buttonEl) {
              buttonEl.style.setProperty('color', color, 'important');
            }
          }
          
          // Actualizar en el iframe del canvas
          const editor = this.em;
          if (editor && editor.Canvas) {
            const canvas = editor.Canvas;
            const frame = canvas.getFrameEl();
            if (frame && frame.contentDocument) {
              const frameDoc = frame.contentDocument;
              const frameButtonEl = frameDoc.querySelector('button, a');
              if (frameButtonEl) {
                frameButtonEl.style.setProperty('color', color, 'important');
              }
            }
          }
          
          // Forzar re-renderizado
          if (this.view) {
            this.view.render();
          }
        },
        // ✅ CRÍTICO: Método toHTML() para sincronizar valores antes de guardar
        toHTML() {
          console.log('💾 [BackgroundImage] toHTML() llamado - sincronizando antes de guardar');
          
          // ✅ CRÍTICO: Asegurar que los componentes internos existan antes de serializar
          // Si no existen, crearlos desde el modelo
          const ensureInternalComponents = () => {
            const findTitle = (comp) => {
              if (comp.get('tagName') === 'h2') return comp;
              let found = null;
              comp.components().each(child => {
                if (!found) found = findTitle(child);
              });
              return found;
            };
            
            const findText = (comp) => {
              if (comp.get('tagName') === 'p') return comp;
              let found = null;
              comp.components().each(child => {
                if (!found) found = findText(child);
              });
              return found;
            };
            
            const findButton = (comp) => {
              if (comp.get('tagName') === 'button' || comp.get('tagName') === 'a') return comp;
              let found = null;
              comp.components().each(child => {
                if (!found) found = findButton(child);
              });
              return found;
            };
            
            // Buscar el contenedor de contenido (relative z-10)
            const findContentContainer = (comp) => {
              const attrs = comp.getAttributes();
              const classes = attrs.class || '';
              if (comp.get('tagName') === 'div' && classes.includes('relative') && classes.includes('z-10')) {
                return comp;
              }
              let found = null;
              comp.components().each(child => {
                if (!found) found = findContentContainer(child);
              });
              return found;
            };
            
            const contentContainer = findContentContainer(this);
            if (!contentContainer) {
              return;
            }
            
            // Verificar y crear título si no existe
            let titleComponent = findTitle(this);
            if (!titleComponent) {
              const innerContainer = contentContainer.components().models[0];
              if (innerContainer) {
                titleComponent = innerContainer.components().add({
                  tagName: 'h2',
                  attributes: {
                    class: 'text-3xl font-bold mb-4',
                    'data-gjs-editable': 'false',
                    'data-gjs-selectable': 'false',
                    'contenteditable': 'false'
                  },
                  content: this.get('content-title') || 'Contenido sobre Imagen'
                });
              }
            }
            
            // Verificar y crear texto si no existe
            let textComponent = findText(this);
            if (!textComponent) {
              const innerContainer = contentContainer.components().models[0];
              if (innerContainer) {
                textComponent = innerContainer.components().add({
                  tagName: 'p',
                  attributes: {
                    class: 'text-lg mb-6',
                    'data-gjs-editable': 'false',
                    'data-gjs-selectable': 'false',
                    'contenteditable': 'false'
                  },
                  content: this.get('content-text') || 'Texto superpuesto sobre la imagen de fondo'
                });
              }
            }
            
            // Verificar y crear botón si no existe
            let buttonComponent = findButton(this);
            if (!buttonComponent) {
              const innerContainer = contentContainer.components().models[0];
              if (innerContainer) {
                const buttonLink = this.get('button-link') || '#';
                const isLink = buttonLink && buttonLink !== '#' && buttonLink.trim() !== '';
                buttonComponent = innerContainer.components().add({
                  tagName: isLink ? 'a' : 'button',
                  attributes: {
                    class: 'bg-white text-gray-900 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100',
                    'data-gjs-editable': 'false',
                    'data-gjs-selectable': 'false',
                    'contenteditable': 'false',
                    ...(isLink ? { href: buttonLink } : {})
                  },
                  content: this.get('button-text') || 'Botón de Acción'
                });
              }
            }
          };
          
          ensureInternalComponents();
          
          // Obtener valores del modelo (prioridad a los valores del usuario)
          const modelTitle = this.get('content-title') || 'Contenido sobre Imagen';
          const modelText = this.get('content-text') || 'Texto superpuesto sobre la imagen de fondo';
          const modelButtonText = this.get('button-text') || 'Botón de Acción';
          const modelButtonLink = this.get('button-link') || '#';
          
          // Buscar y actualizar componentes internos
          const findTitle = (comp) => {
            if (comp.get('tagName') === 'h2') return comp;
            let found = null;
            comp.components().each(child => {
              if (!found) found = findTitle(child);
            });
            return found;
          };
          
          const findText = (comp) => {
            if (comp.get('tagName') === 'p') return comp;
            let found = null;
            comp.components().each(child => {
              if (!found) found = findText(child);
            });
            return found;
          };
          
          const findButton = (comp) => {
            if (comp.get('tagName') === 'button' || comp.get('tagName') === 'a') return comp;
            let found = null;
            comp.components().each(child => {
              if (!found) found = findButton(child);
            });
            return found;
          };
          
          // Obtener valores de colores del modelo
          const modelTitleColor = this.get('title-color') || '#ffffff';
          const modelTextColor = this.get('text-color') || '#ffffff';
          const modelButtonBgColor = this.get('button-bg-color') || '#ffffff';
          const modelButtonTextColor = this.get('button-text-color') || '#111827';
          
          // Actualizar título
          const titleComponent = findTitle(this);
          if (titleComponent) {
            titleComponent.set('content', modelTitle);
            titleComponent.setStyle({ color: modelTitleColor });
            if (titleComponent.view && titleComponent.view.el) {
              titleComponent.view.el.textContent = modelTitle;
              titleComponent.view.el.style.color = modelTitleColor;
            }
          }
          
          // Actualizar texto
          const textComponent = findText(this);
          if (textComponent) {
            textComponent.set('content', modelText);
            textComponent.setStyle({ color: modelTextColor });
            if (textComponent.view && textComponent.view.el) {
              textComponent.view.el.textContent = modelText;
              textComponent.view.el.style.color = modelTextColor;
            }
          }
          
          // Actualizar botón
          const buttonComponent = findButton(this);
          if (buttonComponent) {
            buttonComponent.set('content', modelButtonText);
            buttonComponent.setStyle({ 
              'background-color': modelButtonBgColor,
              color: modelButtonTextColor
            });
            if (buttonComponent.view && buttonComponent.view.el) {
              buttonComponent.view.el.textContent = modelButtonText;
              buttonComponent.view.el.style.backgroundColor = modelButtonBgColor;
              buttonComponent.view.el.style.color = modelButtonTextColor;
            }
            
            // Manejar conversión entre button y a según el enlace
            if (modelButtonLink && modelButtonLink !== '#' && modelButtonLink.trim() !== '') {
              if (buttonComponent.get('tagName') === 'button') {
                buttonComponent.set('tagName', 'a');
                buttonComponent.setAttributes({
                  ...buttonComponent.getAttributes(),
                  href: modelButtonLink
                });
                if (buttonComponent.view && buttonComponent.view.el) {
                  const newLink = document.createElement('a');
                  newLink.href = modelButtonLink;
                  newLink.className = buttonComponent.view.el.className;
                  newLink.textContent = modelButtonText;
                  buttonComponent.view.el.parentNode.replaceChild(newLink, buttonComponent.view.el);
                  buttonComponent.view.el = newLink;
                }
              } else {
                buttonComponent.setAttributes({
                  ...buttonComponent.getAttributes(),
                  href: modelButtonLink
                });
                if (buttonComponent.view && buttonComponent.view.el) {
                  buttonComponent.view.el.setAttribute('href', modelButtonLink);
                }
              }
            } else {
              if (buttonComponent.get('tagName') === 'a') {
                buttonComponent.set('tagName', 'button');
                const attrs = buttonComponent.getAttributes();
                delete attrs.href;
                buttonComponent.setAttributes(attrs);
                if (buttonComponent.view && buttonComponent.view.el) {
                  const newButton = document.createElement('button');
                  newButton.className = buttonComponent.view.el.className;
                  newButton.textContent = modelButtonText;
                  buttonComponent.view.el.parentNode.replaceChild(newButton, buttonComponent.view.el);
                  buttonComponent.view.el = newButton;
                }
              }
            }
          }
          
          // Actualizar también el DOM directamente
          if (this.view && this.view.el) {
            const titleEl = this.view.el.querySelector('h2');
            const textEl = this.view.el.querySelector('p');
            const buttonEl = this.view.el.querySelector('button, a');
            
            if (titleEl) {
              titleEl.textContent = modelTitle;
              titleEl.style.color = modelTitleColor;
            }
            if (textEl) {
              textEl.textContent = modelText;
              textEl.style.color = modelTextColor;
            }
            if (buttonEl) {
              buttonEl.textContent = modelButtonText;
              buttonEl.style.backgroundColor = modelButtonBgColor;
              buttonEl.style.color = modelButtonTextColor;
              if (modelButtonLink && modelButtonLink !== '#' && modelButtonLink.trim() !== '') {
                if (buttonEl.tagName === 'BUTTON') {
                  const newLink = document.createElement('a');
                  newLink.href = modelButtonLink;
                  newLink.className = buttonEl.className;
                  newLink.textContent = modelButtonText;
                  buttonEl.parentNode.replaceChild(newLink, buttonEl);
                } else {
                  buttonEl.setAttribute('href', modelButtonLink);
                }
              } else {
                if (buttonEl.tagName === 'A') {
                  const newButton = document.createElement('button');
                  newButton.className = buttonEl.className;
                  newButton.textContent = modelButtonText;
                  buttonEl.parentNode.replaceChild(newButton, buttonEl);
                }
              }
            }
          }
          
          // ✅ CRÍTICO: Construir HTML manualmente para asegurar que los valores se guarden correctamente
          // Similar a image-box-advanced.js
          const tagName = this.get('tagName') || 'div';
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
          
          // Construir innerHTML manualmente - RECURSIVO para manejar estructura anidada
          let innerHTML = '';
          const components = this.components();
          
          // Función recursiva para renderizar componentes y sus hijos
          const renderComponent = (comp, depth = 0) => {
            if (!comp) {
              return '';
            }
            
            const compTagName = comp.get('tagName') || 'div';
            const compType = comp.get('type');
            let compAttrs = comp.getAttributes();
            let compContent = '';
            
            // Asegurar que los componentes internos tengan los valores correctos ANTES de renderizar
            if (compTagName === 'h2') {
              comp.set('content', modelTitle);
              compContent = modelTitle;
              compAttrs = comp.getAttributes();
            } else if (compTagName === 'p') {
              comp.set('content', modelText);
              compContent = modelText;
              compAttrs = comp.getAttributes();
            } else if (compTagName === 'button' || compTagName === 'a') {
              comp.set('content', modelButtonText);
              compContent = modelButtonText;
              if (modelButtonLink && modelButtonLink !== '#' && modelButtonLink.trim() !== '') {
                if (compTagName === 'button') {
                  comp.set('tagName', 'a');
                  compAttrs = { ...compAttrs, href: modelButtonLink };
                  comp.setAttributes(compAttrs);
                } else {
                  compAttrs = { ...compAttrs, href: modelButtonLink };
                  comp.setAttributes(compAttrs);
                }
              } else {
                if (compTagName === 'a') {
                  comp.set('tagName', 'button');
                  compAttrs = { ...compAttrs };
                  delete compAttrs.href;
                  comp.setAttributes(compAttrs);
                }
              }
              compAttrs = comp.getAttributes();
            } else {
              // Para otros componentes (divs, etc.), renderizar hijos recursivamente
              const compChildren = comp.components();
              if (compChildren && compChildren.length > 0) {
                compChildren.forEach(child => {
                  compContent += renderComponent(child, depth + 1);
                });
              } else {
                // Si no tiene hijos, usar el contenido del componente
                compContent = comp.get('content') || '';
              }
            }
            
            // Construir atributos del componente
            let compAttrsArray = [];
            for (let key in compAttrs) {
              if (compAttrs.hasOwnProperty(key) && compAttrs[key] !== null && compAttrs[key] !== undefined && compAttrs[key] !== '') {
                const value = String(compAttrs[key]).replace(/"/g, '&quot;');
                compAttrsArray.push(`${key}="${value}"`);
              }
            }
            
            // Agregar estilos inline para los colores
            let styleAttrs = [];
            if (compTagName === 'h2') {
              const titleColor = this.get('title-color') || '#ffffff';
              styleAttrs.push(`color: ${titleColor}`);
            } else if (compTagName === 'p') {
              const textColor = this.get('text-color') || '#ffffff';
              styleAttrs.push(`color: ${textColor}`);
            } else if (compTagName === 'button' || compTagName === 'a') {
              const buttonBgColor = this.get('button-bg-color') || '#ffffff';
              const buttonTextColor = this.get('button-text-color') || '#111827';
              styleAttrs.push(`background-color: ${buttonBgColor}`);
              styleAttrs.push(`color: ${buttonTextColor}`);
            }
            
            // Obtener estilos existentes del componente
            const compStyles = comp.getStyle() || {};
            for (let key in compStyles) {
              if (compStyles.hasOwnProperty(key) && compStyles[key]) {
                styleAttrs.push(`${key}: ${compStyles[key]}`);
              }
            }
            
            if (styleAttrs.length > 0) {
              compAttrsArray.push(`style="${styleAttrs.join('; ')}"`);
            }
            
            const compAttrsStr = compAttrsArray.join(' ');
            
            // Elementos void (sin cierre)
            const voidElements = ['img', 'br', 'hr', 'input', 'meta', 'link', 'area', 'base', 'col', 'embed', 'source', 'track', 'wbr'];
            const result = voidElements.includes(compTagName.toLowerCase()) 
              ? `<${compTagName}${compAttrsStr ? ' ' + compAttrsStr : ''} />`
              : `<${compTagName}${compAttrsStr ? ' ' + compAttrsStr : ''}>${compContent}</${compTagName}>`;
            
            return result;
          };
          
          if (components && components.length > 0) {
            components.forEach(comp => {
              innerHTML += renderComponent(comp);
            });
          }
          
          // Construir y retornar el HTML final
          const finalHTML = `<${tagName}${attrsStr ? ' ' + attrsStr : ''}>${innerHTML}</${tagName}>`;
          
          return finalHTML;
        }
      },
      view: {
        onRender() {
          const el = this.el;
          
          // ✅ CRÍTICO: Sincronizar valores desde el DOM cuando se renderiza
          // Esto asegura que los valores guardados se carguen correctamente
          const component = this.model;
          if (component) {
            let titleEl = el.querySelector('h2');
            let textEl = el.querySelector('p');
            let buttonEl = el.querySelector('button, a');
            
            // ✅ CRÍTICO: Si los elementos no existen, crearlos desde el modelo
            const findContentContainer = () => {
              const containers = el.querySelectorAll('.relative.z-10');
              if (containers.length > 0) {
                const innerDiv = containers[0].querySelector('div');
                return innerDiv || containers[0];
              }
              return null;
            };
            
            const contentContainer = findContentContainer();
            
            if (!titleEl && contentContainer) {
              const modelTitle = component.get('content-title') || 'Contenido sobre Imagen';
              const titleColor = component.get('title-color') || '#ffffff';
              titleEl = document.createElement('h2');
              titleEl.className = 'text-3xl font-bold mb-4';
              titleEl.textContent = modelTitle;
              titleEl.style.setProperty('color', titleColor, 'important');
              titleEl.setAttribute('data-gjs-editable', 'false');
              titleEl.setAttribute('data-gjs-selectable', 'false');
              titleEl.setAttribute('contenteditable', 'false');
              contentContainer.appendChild(titleEl);
            }

            if (!textEl && contentContainer) {
              const modelText = component.get('content-text') || 'Texto superpuesto sobre la imagen de fondo';
              const textColor = component.get('text-color') || '#ffffff';
              textEl = document.createElement('p');
              textEl.className = 'text-lg mb-6';
              textEl.textContent = modelText;
              textEl.style.setProperty('color', textColor, 'important');
              textEl.setAttribute('data-gjs-editable', 'false');
              textEl.setAttribute('data-gjs-selectable', 'false');
              textEl.setAttribute('contenteditable', 'false');
              contentContainer.appendChild(textEl);
            }

            if (!buttonEl && contentContainer) {
              const modelButtonText = component.get('button-text') || 'Botón de Acción';
              const modelButtonLink = component.get('button-link') || '#';
              const buttonBgColor = component.get('button-bg-color') || '#ffffff';
              const buttonTextColor = component.get('button-text-color') || '#111827';
              const isLink = modelButtonLink && modelButtonLink !== '#' && modelButtonLink.trim() !== '';
              buttonEl = document.createElement(isLink ? 'a' : 'button');
              buttonEl.className = 'px-6 py-3 rounded-lg font-semibold hover:bg-gray-100';
              buttonEl.textContent = modelButtonText;
              buttonEl.style.setProperty('background-color', buttonBgColor, 'important');
              buttonEl.style.setProperty('color', buttonTextColor, 'important');
              buttonEl.setAttribute('data-gjs-editable', 'false');
              buttonEl.setAttribute('data-gjs-selectable', 'false');
              buttonEl.setAttribute('contenteditable', 'false');
              if (isLink) {
                buttonEl.setAttribute('href', modelButtonLink);
              }
              contentContainer.appendChild(buttonEl);
            }
            
            // Ahora sincronizar desde el DOM (que ahora debería tener los elementos)
            titleEl = el.querySelector('h2');
            textEl = el.querySelector('p');
            buttonEl = el.querySelector('button, a');
            
            if (titleEl) {
              const domTitle = titleEl.textContent || titleEl.innerText || '';
              if (domTitle.trim()) {
                component.set('content-title', domTitle.trim(), { silent: true });
              }
              // Aplicar color del título desde el modelo
              const titleColor = component.get('title-color') || '#ffffff';
              titleEl.style.setProperty('color', titleColor, 'important');
            }
            
            if (textEl) {
              const domText = textEl.textContent || textEl.innerText || '';
              if (domText.trim()) {
                component.set('content-text', domText.trim(), { silent: true });
              }
              // Aplicar color del texto desde el modelo
              const textColor = component.get('text-color') || '#ffffff';
              textEl.style.setProperty('color', textColor, 'important');
            }
            
            if (buttonEl) {
              const domButtonText = buttonEl.textContent || buttonEl.innerText || '';
              if (domButtonText.trim()) {
                component.set('button-text', domButtonText.trim(), { silent: true });
              }
              
              const href = buttonEl.getAttribute('href');
              if (href) {
                component.set('button-link', href, { silent: true });
              } else if (buttonEl.tagName === 'BUTTON') {
                component.set('button-link', '#', { silent: true });
              }
              
              // Aplicar colores del botón desde el modelo
              const buttonBgColor = component.get('button-bg-color') || '#ffffff';
              const buttonTextColor = component.get('button-text-color') || '#111827';
              buttonEl.style.setProperty('background-color', buttonBgColor, 'important');
              buttonEl.style.setProperty('color', buttonTextColor, 'important');
            }
          }
          
          // ✅ BANDERA: Evitar bucles infinitos en el observer
          if (this._isProtecting) return;
          this._isProtecting = true;

          // ✅ OCULTO: Ocultar badge "DIV" del componente
          el.setAttribute('data-gjs-badgable', 'false');
          el.setAttribute('data-gjs-badge', 'false');
          
          // Proteger el contenedor principal completamente
          // ✅ IMPORTANTE: NO establecer data-gjs-removable aquí para permitir eliminación
          el.setAttribute('contenteditable', 'false');
          el.setAttribute('data-gjs-editable', 'false');
          el.setAttribute('data-gjs-selectable', 'true'); // ✅ PERMITIDO: Se puede seleccionar para propiedades
          el.setAttribute('data-gjs-draggable', 'true');
          el.setAttribute('data-gjs-droppable', 'true');
          el.setAttribute('data-gjs-highlightable', 'true'); // ✅ CRÍTICO: Necesario para mostrar el toolbar
          el.setAttribute('data-gjs-toolbar', 'true'); // ✅ CRÍTICO: Asegurar que el toolbar se muestre
          el.setAttribute('data-gjs-layerable', 'true'); // ✅ CRÍTICO: Necesario para mostrar controles en el toolbar
          el.setAttribute('data-gjs-copyable', 'true'); // ✅ CRÍTICO: Necesario para mostrar controles en el toolbar
          // ✅ CRÍTICO: Asegurar que el componente principal sea eliminable
          // No establecer data-gjs-removable para que use el valor del modelo (removable: true)
          if (el.hasAttribute('data-gjs-removable')) {
            el.removeAttribute('data-gjs-removable');
          }
          
          // ✅ DEBUG: CÓDIGO DE PROTECCIÓN COMENTADO PARA IDENTIFICAR EL PROBLEMA
          // ✅ CRÍTICO: Proteger TODOS los elementos internos recursivamente
          // NO se puede editar nada directamente, TODO desde propiedades
          // ✅ IMPORTANTE: Solo proteger elementos hijos, NO el contenedor principal
          /*
          const protectAllElements = (container) => {
            if (!container || this._isProtecting === false) return;
            
            // ✅ Solo proteger elementos hijos, no el contenedor principal
            const allElements = container.querySelectorAll('*');
            allElements.forEach(element => {
              // ✅ Verificar que no sea el contenedor principal
              if (element === container) {
                return; // No proteger el contenedor principal
              }
              
              // Solo modificar si realmente necesita protección
              if (element.getAttribute('contenteditable') !== 'false') {
                element.setAttribute('contenteditable', 'false');
              }
              if (element.getAttribute('data-gjs-editable') !== 'false') {
                element.setAttribute('data-gjs-editable', 'false');
              }
              if (element.getAttribute('data-gjs-selectable') !== 'false') {
                element.setAttribute('data-gjs-selectable', 'false');
              }
              if (element.getAttribute('data-gjs-draggable') !== 'false') {
                element.setAttribute('data-gjs-draggable', 'false');
              }
              if (element.getAttribute('data-gjs-removable') !== 'false') {
                element.setAttribute('data-gjs-removable', 'false');
              }
              if (element.getAttribute('data-gjs-droppable') !== 'false') {
                element.setAttribute('data-gjs-droppable', 'false');
              }
              if (element.getAttribute('data-gjs-badgable') !== 'false') {
                element.setAttribute('data-gjs-badgable', 'false');
              }
            });
            
            // ✅ NO proteger el contenedor mismo con removable
            // Solo proteger otras propiedades si es necesario
            if (container !== el) {
              // Solo si no es el contenedor principal
              if (container.getAttribute('contenteditable') !== 'false') {
                container.setAttribute('contenteditable', 'false');
              }
              if (container.getAttribute('data-gjs-editable') !== 'false') {
                container.setAttribute('data-gjs-editable', 'false');
              }
              if (container.getAttribute('data-gjs-badgable') !== 'false') {
                container.setAttribute('data-gjs-badgable', 'false');
              }
            }
          };
          
          protectAllElements(el);
          */
          
          // Observar cambios en el DOM SOLO para nuevos elementos (childList)
          // NO observar cambios en atributos para evitar bucles infinitos
          const observer = new MutationObserver((mutations) => {
            // Solo procesar si hay nuevos elementos agregados
            const hasNewChildren = mutations.some(mutation => 
              mutation.type === 'childList' && mutation.addedNodes.length > 0
            );
            
            if (hasNewChildren && !this._isProtecting) {
              this._isProtecting = true;
              // ✅ Asegurar que el componente principal mantenga removable: true
              this.model.set('removable', true);
              // ✅ Asegurar que el contenedor principal no tenga data-gjs-removable
              if (el.hasAttribute('data-gjs-removable')) {
                el.removeAttribute('data-gjs-removable');
              }
              // ✅ Asegurar que los atributos del toolbar se mantengan
              el.setAttribute('data-gjs-selectable', 'true');
              el.setAttribute('data-gjs-highlightable', 'true');
              el.setAttribute('data-gjs-toolbar', 'true');
              el.setAttribute('data-gjs-layerable', 'true');
              el.setAttribute('data-gjs-copyable', 'true');
              // ✅ DEBUG: Código de protección comentado
              // protectAllElements(el);
              el.setAttribute('data-gjs-badgable', 'false');
              el.setAttribute('data-gjs-badge', 'false');
              setTimeout(() => {
                this._isProtecting = false;
              }, 50);
            }
          });
          
          observer.observe(el, {
            childList: true,
            subtree: true,
            attributes: false  // ✅ CRÍTICO: NO observar cambios en atributos
          });
          
          this._backgroundImageObserver = observer;
          
          // Liberar la bandera después de un momento
          setTimeout(() => {
            this._isProtecting = false;
          }, 200);
          
        },
        onRemove() {
          if (this._backgroundImageObserver) {
            this._backgroundImageObserver.disconnect();
          }
        }
      }
    });
    
  }
  
  if (typeof window !== 'undefined' && window.editor) {
    registerBackgroundImageComponent(window.editor);
  } else {
    const checkEditor = setInterval(() => {
      if (typeof window !== 'undefined' && window.editor) {
        registerBackgroundImageComponent(window.editor);
        clearInterval(checkEditor);
      }
    }, 100);
    
    setTimeout(() => {
      clearInterval(checkEditor);
    }, 10000);
  }
  
  if (typeof window !== 'undefined') {
    window.registerBackgroundImageComponent = registerBackgroundImageComponent;
  }
})();
