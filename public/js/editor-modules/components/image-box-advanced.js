// Módulo del Componente Image Box Advanced
// Componente de caja de imagen avanzada con overlay y efectos hover

(function() {
  'use strict';
  
  function registerImageBoxAdvancedComponent(editor) {
    if (!editor || !editor.DomComponents) {
      return;
    }
    
    editor.DomComponents.addType('image-box-advanced', {
      isComponent: (el) => {
        if (el.tagName === 'DIV' && (
          el.classList.contains('image-box') ||
          el.getAttribute('data-gjs-type') === 'image-box-advanced'
        )) {
          return { type: 'image-box-advanced' };
        }
        return false;
      },
      model: {
        defaults: {
          name: 'Caja de Imagen Avanzada',
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
            'data-gjs-type': 'image-box-advanced',
            'data-gjs-name': 'Caja de Imagen Avanzada',
            'data-gjs-editable': 'false'
          },
          'image-url': '/images/default-image.jpg',
          'overlay-style': 'gradient',
          'link-url': '',
          'title': 'Título de la Imagen',
          'description': 'Descripción que aparece al hacer hover sobre la imagen.',
          traits: [
            {
              type: 'button',
              name: 'select-image',
              label: '📁 Seleccionar Imagen',
              text: 'Abrir Galería de Imágenes',
              full: true,
              command: (editor) => {
                const component = editor.getSelected();
                if (component && component.get('type') === 'image-box-advanced') {
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
                        
                        // Validar que newSrc sea válido
                        if (!newSrc || typeof newSrc !== 'string' || newSrc.trim() === '') {
                          return;
                        }
                        
                        if (newSrc && component) {
                          // ✅ 1. Actualizar image-url en el modelo (igual que image.js)
                          component.set('image-url', newSrc, { silent: false });
                          
                          // ✅ 2. Actualizar atributo src en el modelo del componente img interno
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
                            // ✅ CRÍTICO: Actualizar atributo src en el modelo (igual que image.js)
                            imgComponent.setAttributes({ src: newSrc });
                            
                            // ✅ CRÍTICO: Actualizar también el modelo del componente img
                            if (imgComponent.get('src') !== newSrc) {
                              imgComponent.set('src', newSrc, { silent: true });
                            }
                            
                            // ✅ 3. Actualizar el DOM directamente (CRÍTICO para guardar - igual que image.js)
                            if (imgComponent.view && imgComponent.view.el) {
                              const imgEl = imgComponent.view.el;
                              imgEl.src = newSrc;
                              imgEl.setAttribute('src', newSrc);
                              
                              // Verificar y forzar actualización después de un momento
                              setTimeout(() => {
                                if (imgEl.src !== newSrc) {
                                  imgEl.src = newSrc;
                                  imgEl.setAttribute('src', newSrc);
                                }
                              }, 50);
                            }
                          }
                          
                          // ✅ 4. Actualizar también el DOM del contenedor principal
                          if (component.view && component.view.el) {
                            const el = component.view.el;
                            const img = el.querySelector('img');
                            
                            if (img) {
                              img.src = newSrc;
                              img.setAttribute('src', newSrc);
                            }
                          }
                          
                          // ✅ 5. Llamar a updateImage si existe para sincronización completa
                          if (typeof component.updateImage === 'function') {
                            component.updateImage();
                          }
                          
                          // ✅ 6. Forzar renderizado
                          if (component.view) {
                            component.view.render();
                          }
                          
                          // ✅ 7. Disparar eventos (igual que image.js)
                          component.trigger('change:image-url');
                          component.trigger('change:attributes');
                          if (imgComponent) {
                            imgComponent.trigger('change:src');
                            imgComponent.trigger('change:attributes');
                          }
                          
                          // ✅ 8. CRÍTICO: Verificar y forzar actualización final antes de cerrar
                          setTimeout(() => {
                            if (imgComponent && imgComponent.view && imgComponent.view.el) {
                              const imgEl = imgComponent.view.el;
                              if (imgEl.src !== newSrc) {
                                imgEl.src = newSrc;
                                imgEl.setAttribute('src', newSrc);
                              }
                            }
                          }, 100);
                          
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
                          console.log('📸 Imagen seleccionada:', newSrc);
                          
                          // ✅ 1. Actualizar image-url en el modelo
                          component.set('image-url', newSrc, { silent: false });
                          
                          // ✅ 2. Actualizar el DOM directamente (CRÍTICO para guardar)
                          if (component.view && component.view.el) {
                            const el = component.view.el;
                            const img = el.querySelector('img');
                            
                            if (img) {
                              img.src = newSrc;
                              img.setAttribute('src', newSrc);
                              
                              // Verificar y forzar actualización después de un momento
                              setTimeout(() => {
                                if (img.src !== newSrc) {
                                  img.src = newSrc;
                                  img.setAttribute('src', newSrc);
                                }
                              }, 50);
                            }
                          }
                          
                          // ✅ 3. Actualizar también en el modelo de GrapesJS (componente img)
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
                            imgComponent.setAttributes({ src: newSrc });
                            // ✅ CRÍTICO: También actualizar el modelo del componente img
                            if (imgComponent.get('src') !== newSrc) {
                              imgComponent.set('src', newSrc, { silent: true });
                            }
                            // Actualizar también el DOM del componente img
                            if (imgComponent.view && imgComponent.view.el) {
                              imgComponent.view.el.src = newSrc;
                              imgComponent.view.el.setAttribute('src', newSrc);
                            }
                          }
                          
                          // ✅ 4. Llamar a updateImage si existe para sincronización completa
                          if (typeof component.updateImage === 'function') {
                            component.updateImage();
                          }
                          
                          // ✅ 5. Forzar renderizado
                          if (component.view) {
                            component.view.render();
                          }
                          
                          // ✅ 6. Disparar eventos
                          component.trigger('change:image-url');
                          component.trigger('change:attributes');
                          
                          // ✅ 7. CRÍTICO: Forzar actualización del componente img antes de cerrar
                          setTimeout(() => {
                            if (imgComponent && imgComponent.view && imgComponent.view.el) {
                              const imgEl = imgComponent.view.el;
                              if (imgEl.src !== newSrc) {
                                imgEl.src = newSrc;
                                imgEl.setAttribute('src', newSrc);
                              }
                            }
                          }, 100);
                          
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
              name: 'image-url',
              label: 'URL de Imagen',
              placeholder: '/images/default-image.jpg',
              changeProp: 1
            },
            {
              type: 'text',
              name: 'title',
              label: 'Título',
              placeholder: 'Título de la Imagen',
              changeProp: 1
            },
            {
              type: 'text',
              name: 'description',
              label: 'Descripción',
              placeholder: 'Descripción que aparece al hacer hover',
              changeProp: 1
            },
            {
              type: 'select',
              name: 'overlay-style',
              label: 'Estilo de Overlay',
              changeProp: 1,
              options: [
                { value: 'gradient', name: 'Gradiente' },
                { value: 'solid', name: 'Sólido' },
                { value: 'none', name: 'Sin Overlay' }
              ]
            },
            {
              type: 'text',
              name: 'link-url',
              label: 'Enlace (opcional)',
              placeholder: 'https://ejemplo.com',
              changeProp: 1
            }
          ]
        },
        init() {
          
          // Sincronizar valor inicial desde el DOM si existe (igual que componente image)
          const syncInitialValues = () => {
            if (this.view && this.view.el) {
              const img = this.view.el.querySelector('img');
              if (img) {
                const currentSrc = img.src || img.getAttribute('src');
                const imageUrl = this.get('image-url');
                const defaultImageUrl = '/images/default-image.jpg';
                
                // Si hay una imagen en el DOM que no sea la default, sincronizarla
                if (currentSrc && currentSrc !== defaultImageUrl && !currentSrc.includes('default-image.jpg')) {
                  if (!imageUrl || imageUrl === defaultImageUrl) {
                    this.set('image-url', currentSrc, { silent: true });
                  }
                }
              }
            }
          };
          
          setTimeout(syncInitialValues, 50);
          setTimeout(syncInitialValues, 200);
          this.on('component:mount', syncInitialValues);
          this.on('component:selected', syncInitialValues);
          this.on('component:update', syncInitialValues);
          
          // Asegurar que la imagen se muestre correctamente al montar
          this.on('component:mount', () => {
            setTimeout(() => {
              if (this.view && this.view.el) {
                const img = this.view.el.querySelector('img');
                if (img) {
                  const imageUrl = this.get('image-url');
                  const defaultImageUrl = '/images/default-image.jpg';
                  const finalSrc = (imageUrl && imageUrl.trim() && imageUrl !== 'undefined' && imageUrl !== defaultImageUrl)
                    ? imageUrl.trim()
                    : defaultImageUrl;
                  
                  if (img.src !== finalSrc) {
                    img.src = finalSrc;
                    img.setAttribute('src', finalSrc);
                  }
                }
              }
            }, 100);
          });
          
          this.on('change:image-url', this.updateImage, this);
          this.on('change:title', this.updateTitle, this);
          this.on('change:description', this.updateDescription, this);
          this.on('change:overlay-style', this.updateOverlay, this);
          this.on('change:link-url', this.updateLink, this);
          
          // Proteger TODOS los elementos internos - NO edición directa
          // Los textos se editan desde traits, no directamente
          const protectElements = () => {
            const protectRecursive = (component) => {
              // Proteger el componente actual completamente
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
        updateImage() {
          const defaultImageUrl = '/images/default-image.jpg';
          const imageUrl = this.get('image-url');
          
          // Determinar el src final: priorizar image-url, luego DOM, luego default
          let finalSrc = null;
          
          if (imageUrl && imageUrl.trim() && imageUrl !== 'undefined' && imageUrl !== defaultImageUrl) {
            finalSrc = imageUrl.trim();
          } else if (this.view && this.view.el) {
            const img = this.view.el.querySelector('img');
            if (img && img.src && !img.src.includes('default-image.jpg')) {
              finalSrc = img.src || img.getAttribute('src');
            }
          }
          
          if (!finalSrc || finalSrc === 'undefined') {
            finalSrc = defaultImageUrl;
          }
          
          if (!this.view || !this.view.el) {
            return;
          }
          
          const el = this.view.el;
          const img = el.querySelector('img');
          
          if (!img) {
            return;
          }
          
          // ✅ CRÍTICO: Actualizar el DOM directamente
          if (img.src !== finalSrc) {
            img.src = finalSrc;
            img.setAttribute('src', finalSrc);
          }
          
          // ✅ CRÍTICO: Sincronizar image-url en el modelo
          if (finalSrc !== defaultImageUrl && this.get('image-url') !== finalSrc) {
            this.set('image-url', finalSrc, { silent: true });
          }
          
          // Actualizar también en el modelo de GrapesJS (componente img)
          const findImageComponent = (component) => {
            if (component.get('tagName') === 'img') {
              return component;
            }
            let found = null;
            component.components().each(child => {
              if (!found) {
                found = findImageComponent(child);
              }
            });
            return found;
          };
          
          const imgComponent = findImageComponent(this);
          if (imgComponent) {
            imgComponent.setAttributes({ src: finalSrc });
            // ✅ CRÍTICO: También actualizar el modelo del componente img
            if (imgComponent.get('src') !== finalSrc) {
              imgComponent.set('src', finalSrc, { silent: true });
            }
          }
        },
        toHTML() {
          // ✅ CRÍTICO: Seguir el mismo patrón que image.js - interceptar y corregir HTML generado
          const imageUrl = this.get('image-url');
          const defaultImageUrl = '/images/default-image.jpg';
          const linkUrl = this.get('link-url') || '';
          
          // Determinar el src final: priorizar image-url, luego DOM, luego default (igual que image.js)
          let finalSrc = null;
          
          if (imageUrl && imageUrl.trim() && imageUrl !== 'undefined' && imageUrl !== defaultImageUrl && imageUrl !== '' && imageUrl !== 'null') {
            finalSrc = imageUrl.trim();
          } else if (this.view && this.view.el) {
            const img = this.view.el.querySelector('img');
            if (img) {
              const domSrc = img.src || img.getAttribute('src');
              if (domSrc && domSrc.trim() && domSrc !== 'undefined' && domSrc !== defaultImageUrl && domSrc !== '' && domSrc !== 'null') {
                finalSrc = domSrc.trim();
              }
            }
          }
          
          if (!finalSrc || finalSrc === 'undefined' || finalSrc === 'null') {
            finalSrc = defaultImageUrl;
          }
          
          // ✅ CRÍTICO: Asegurar que el componente img tenga el src correcto ANTES de serializar
          const findImageComponent = (component) => {
            if (component.get('tagName') === 'img') {
              return component;
            }
            let found = null;
            component.components().each(child => {
              if (!found) {
                found = findImageComponent(child);
              }
            });
            return found;
          };
          
          const imgComponent = findImageComponent(this);
          if (imgComponent) {
            // Actualizar el atributo src del componente img (igual que image.js)
            const currentAttrs = imgComponent.getAttributes();
            if (currentAttrs.src !== finalSrc) {
              currentAttrs.src = finalSrc;
              imgComponent.setAttributes(currentAttrs);
            }
            
            // También actualizar en el modelo
            if (imgComponent.get('src') !== finalSrc) {
              imgComponent.set('src', finalSrc, { silent: true });
            }
            
            // Actualizar el DOM directamente (CRÍTICO - igual que image.js)
            if (imgComponent.view && imgComponent.view.el) {
              imgComponent.view.el.src = finalSrc;
              imgComponent.view.el.setAttribute('src', finalSrc);
            }
          }
          
          // Actualizar también el modelo principal
          if (this.get('image-url') !== finalSrc && finalSrc !== defaultImageUrl) {
            this.set('image-url', finalSrc, { silent: true });
          }
          
          // ✅ CRÍTICO: Forzar actualización del DOM antes de serializar
          if (this.view && this.view.el) {
            const img = this.view.el.querySelector('img');
            if (img) {
              if (img.src !== finalSrc) {
                img.src = finalSrc;
                img.setAttribute('src', finalSrc);
              }
            }
          }
          
          // ✅ CRÍTICO: Usar getInnerHTML() para evitar recursión infinita
          // En lugar de llamar a __super__.toHTML(), construimos el HTML manualmente
          const tagName = linkUrl && linkUrl.trim() ? 'a' : (this.get('tagName') || 'div');
          const attrs = this.getAttributes();
          
          // Agregar href si hay enlace
          if (linkUrl && linkUrl.trim()) {
            attrs.href = linkUrl;
          }
          
          // Construir atributos como string
          let attrsArray = [];
          for (let key in attrs) {
            if (attrs.hasOwnProperty(key) && attrs[key] !== null && attrs[key] !== undefined && attrs[key] !== '') {
              const value = String(attrs[key]).replace(/"/g, '&quot;');
              attrsArray.push(`${key}="${value}"`);
            }
          }
          
          const attrsStr = attrsArray.join(' ');
          
          // ✅ CRÍTICO: Construir HTML manualmente para evitar recursión infinita
          // NO usar getInnerHTML() ni toHTML() en hijos para evitar recursión
          let innerHTML = '';
          const components = this.components();
          
          if (components && components.length > 0) {
            // Serializar cada componente hijo manualmente SIN llamar a toHTML()
            components.forEach(comp => {
              const compTagName = comp.get('tagName') || 'div';
              const compAttrs = comp.getAttributes();
              
              // Para el componente img, asegurar que tenga el src correcto
              if (compTagName === 'img') {
                compAttrs.src = finalSrc;
                comp.setAttributes(compAttrs);
              }
              
              // Construir atributos como string
              const compAttrsArray = [];
              for (let key in compAttrs) {
                if (compAttrs.hasOwnProperty(key) && compAttrs[key] !== null && compAttrs[key] !== undefined && compAttrs[key] !== '') {
                  const value = String(compAttrs[key]).replace(/"/g, '&quot;');
                  compAttrsArray.push(`${key}="${value}"`);
                }
              }
              
              const compAttrsStr = compAttrsArray.join(' ');
              
              // Obtener contenido del componente (texto o hijos)
              let compContent = '';
              const compChildren = comp.components();
              
              if (compChildren && compChildren.length > 0) {
                // Si tiene hijos, serializarlos también manualmente
                compChildren.forEach(child => {
                  const childTagName = child.get('tagName') || 'div';
                  const childAttrs = child.getAttributes();
                  const childAttrsArray = [];
                  
                  for (let key in childAttrs) {
                    if (childAttrs.hasOwnProperty(key) && childAttrs[key] !== null && childAttrs[key] !== undefined && childAttrs[key] !== '') {
                      const value = String(childAttrs[key]).replace(/"/g, '&quot;');
                      childAttrsArray.push(`${key}="${value}"`);
                    }
                  }
                  
                  const childAttrsStr = childAttrsArray.join(' ');
                  const childContent = child.get('content') || '';
                  const childChildren = child.components();
                  
                  if (childChildren && childChildren.length > 0) {
                    // Si el hijo tiene hijos, serializarlos también
                    let childInnerHTML = '';
                    childChildren.forEach(grandchild => {
                      const grandchildTagName = grandchild.get('tagName') || 'div';
                      const grandchildAttrs = grandchild.getAttributes();
                      const grandchildAttrsArray = [];
                      
                      for (let key in grandchildAttrs) {
                        if (grandchildAttrs.hasOwnProperty(key) && grandchildAttrs[key] !== null && grandchildAttrs[key] !== undefined && grandchildAttrs[key] !== '') {
                          const value = String(grandchildAttrs[key]).replace(/"/g, '&quot;');
                          grandchildAttrsArray.push(`${key}="${value}"`);
                        }
                      }
                      
                      const grandchildAttrsStr = grandchildAttrsArray.join(' ');
                      const grandchildContent = grandchild.get('content') || '';
                      childInnerHTML += `<${grandchildTagName}${grandchildAttrsStr ? ' ' + grandchildAttrsStr : ''}>${grandchildContent}</${grandchildTagName}>`;
                    });
                    compContent += `<${childTagName}${childAttrsStr ? ' ' + childAttrsStr : ''}>${childInnerHTML}</${childTagName}>`;
                  } else {
                    compContent += `<${childTagName}${childAttrsStr ? ' ' + childAttrsStr : ''}>${childContent}</${childTagName}>`;
                  }
                });
              } else {
                // Si no tiene hijos, usar el contenido del componente
                compContent = comp.get('content') || '';
              }
              
              // Determinar si es un elemento auto-cerrado o no
              const voidElements = ['img', 'br', 'hr', 'input', 'meta', 'link', 'area', 'base', 'col', 'embed', 'source', 'track', 'wbr'];
              if (voidElements.includes(compTagName.toLowerCase())) {
                innerHTML += `<${compTagName}${compAttrsStr ? ' ' + compAttrsStr : ''} />`;
              } else {
                innerHTML += `<${compTagName}${compAttrsStr ? ' ' + compAttrsStr : ''}>${compContent}</${compTagName}>`;
              }
            });
          }
          
          // ✅ CRÍTICO: Reemplazar el src en el HTML interno si no coincide
          if (innerHTML && !innerHTML.includes(`src="${finalSrc}"`) && !innerHTML.includes(`src='${finalSrc}'`)) {
            const imgRegex = /<img([^>]*?)src=["']([^"']+)["']([^>]*?)>/gi;
            innerHTML = innerHTML.replace(imgRegex, (match, before, currentSrc, after) => {
              if (currentSrc !== finalSrc) {
                return `<img${before}src="${finalSrc}"${after}>`;
              }
              return match;
            });
            
            // Si aún no se encontró, intentar otro patrón
            if (!innerHTML.includes(`src="${finalSrc}"`) && !innerHTML.includes(`src='${finalSrc}'`)) {
              const altImgRegex = /<img([^>]*?)>/gi;
              innerHTML = innerHTML.replace(altImgRegex, (match) => {
                const srcMatch = match.match(/src=["']([^"']+)["']/);
                if (srcMatch && srcMatch[1] !== finalSrc) {
                  return match.replace(/src=["'][^"']+["']/, `src="${finalSrc}"`);
                }
                if (!srcMatch) {
                  return match.replace(/>$/, ` src="${finalSrc}">`);
                }
                return match;
              });
            }
          }
          
          // Construir y retornar el HTML completo
          return `<${tagName}${attrsStr ? ' ' + attrsStr : ''}>${innerHTML}</${tagName}>`;
        },
        updateTitle() {
          const title = this.get('title') || 'Título de la Imagen';
          
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          const titleEl = el.querySelector('h3');
          
          if (titleEl) {
            titleEl.textContent = title;
            
            // Actualizar también en el modelo de GrapesJS
            const findTitle = (component) => {
              if (component.get('tagName') === 'h3') {
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
              titleComponent.set('content', title);
            }
          }
        },
        updateDescription() {
          const description = this.get('description') || '';
          
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          const descEl = el.querySelector('p');
          
          if (descEl) {
            descEl.textContent = description;
            
            // Actualizar también en el modelo de GrapesJS
            const findDesc = (component) => {
              if (component.get('tagName') === 'p') {
                return component;
              }
              let found = null;
              component.components().each(child => {
                if (!found) {
                  found = findDesc(child);
                }
              });
              return found;
            };
            
            const descComponent = findDesc(this);
            if (descComponent) {
              descComponent.set('content', description);
            }
          }
        },
        updateOverlay() {
          const overlayStyle = this.get('overlay-style') || 'gradient';
          console.log('🎨 Actualizando estilo de overlay:', overlayStyle);
          
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          const overlay = el.querySelector('.absolute.inset-0');
          
          if (overlay) {
            overlay.className = 'absolute inset-0 transition-opacity duration-300';
            
            if (overlayStyle === 'gradient') {
              overlay.classList.add('bg-gradient-to-t', 'from-black', 'via-transparent', 'to-transparent');
              overlay.classList.add('opacity-0', 'group-hover:opacity-100');
            } else if (overlayStyle === 'solid') {
              overlay.classList.add('bg-black', 'bg-opacity-50');
              overlay.classList.add('opacity-0', 'group-hover:opacity-100');
            } else {
              overlay.style.display = 'none';
            }
            
            // ✅ CRÍTICO: En el editor, hacer visible el overlay siempre
            // Remover opacity-0 y aplicar opacidad con !important
            overlay.classList.remove('opacity-0');
            if (overlayStyle !== 'none') {
              overlay.style.setProperty('opacity', '1', 'important');
            }
          }
        },
        updateLink() {
          const linkUrl = this.get('link-url') || '';
          console.log('🔗 Actualizando enlace:', linkUrl);
          
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          
          // ✅ En lugar de reemplazar el elemento, solo actualizar atributos
          // Si hay enlace, cambiar tagName a 'a' en el modelo de GrapesJS
          if (linkUrl && linkUrl.trim()) {
            // Si no es un enlace aún, actualizar el atributo href
            if (el.tagName === 'A') {
              el.href = linkUrl;
              el.setAttribute('href', linkUrl);
            } else {
              // Si es div, actualizar el modelo de GrapesJS para que sea 'a'
              const currentAttrs = this.getAttributes();
              currentAttrs.href = linkUrl;
              this.setAttributes(currentAttrs);
              
              // Actualizar tagName en el modelo
              this.set('tagName', 'a', { silent: false });
              
              console.log('✅ Elemento convertido a enlace');
            }
          } else {
            // Si no hay enlace, asegurar que sea div
            const currentAttrs = this.getAttributes();
            delete currentAttrs.href;
            this.setAttributes(currentAttrs);
            
            // Actualizar tagName en el modelo
            this.set('tagName', 'div', { silent: false });
            
            console.log('✅ Elemento convertido a div');
          }
        }
      },
      view: {
        onRender() {
          const el = this.el;

          // Proteger el contenedor principal
          el.setAttribute('contenteditable', 'false');
          el.setAttribute('data-gjs-editable', 'false');
          
          // ✅ CRÍTICO: Hacer visible el overlay en el editor
          // El overlay tiene opacity-0 por defecto y solo se muestra en hover
          // En el editor, lo hacemos visible siempre para poder ver el contenido
          const overlay = el.querySelector('.absolute.inset-0');
          if (overlay) {
            // Remover opacity-0 para que sea visible en el editor
            overlay.classList.remove('opacity-0');
            // Aplicar opacidad directamente en el editor con !important
            overlay.style.setProperty('opacity', '1', 'important');
          }
          
          // ✅ Asegurar que el contenedor principal tenga w-full
          if (!el.classList.contains('w-full')) {
            el.classList.add('w-full');
          }
          
          // ✅ Agregar cursor pointer si hay enlace
          const linkUrl = this.model.get('link-url') || '';
          if (linkUrl && linkUrl.trim()) {
            if (!el.classList.contains('cursor-pointer')) {
              el.classList.add('cursor-pointer');
            }
            el.style.cursor = 'pointer';
          } else {
            el.classList.remove('cursor-pointer');
            el.style.cursor = 'default';
          }
          
          // ✅ Asegurar que la imagen tenga las clases correctas para mantener aspect ratio
          const img = el.querySelector('img');
          if (img) {
            // Remover h-64 si existe y asegurar h-auto max-h-96
            img.classList.remove('h-64');
            if (!img.classList.contains('h-auto')) {
              img.classList.add('h-auto');
            }
            if (!img.classList.contains('max-h-96')) {
              img.classList.add('max-h-96');
            }
            // Asegurar que object-cover esté presente
            if (!img.classList.contains('object-cover')) {
              img.classList.add('object-cover');
            }
            // Asegurar que w-full esté presente
            if (!img.classList.contains('w-full')) {
              img.classList.add('w-full');
            }
          }
          
          // Proteger TODOS los elementos internos - NO edición directa
          const protectElements = (container) => {
            if (!container) return;
            
            // Proteger TODOS los elementos (imágenes, textos, overlay, etc.)
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
            // Re-aplicar w-full al contenedor
            if (!el.classList.contains('w-full')) {
              el.classList.add('w-full');
            }
            // Re-aplicar clases de imagen si se agregan nuevos elementos
            const img = el.querySelector('img');
            if (img) {
              img.classList.remove('h-64');
              if (!img.classList.contains('h-auto')) {
                img.classList.add('h-auto');
              }
              if (!img.classList.contains('max-h-96')) {
                img.classList.add('max-h-96');
              }
              if (!img.classList.contains('w-full')) {
                img.classList.add('w-full');
              }
            }
            // Re-aplicar opacidad del overlay si se pierde
            const overlay = el.querySelector('.absolute.inset-0');
            if (overlay) {
              overlay.classList.remove('opacity-0');
              overlay.style.setProperty('opacity', '1', 'important');
            }
          });
          
          observer.observe(el, {
            childList: true,
            subtree: true
          });
          
          this._imageBoxObserver = observer;
          
        },
        onRemove() {
          if (this._imageBoxObserver) {
            this._imageBoxObserver.disconnect();
          }
        }
      }
    });
    
  }
  
  if (typeof window !== 'undefined' && window.editor) {
    registerImageBoxAdvancedComponent(window.editor);
  } else {
    const checkEditor = setInterval(() => {
      if (typeof window !== 'undefined' && window.editor) {
        registerImageBoxAdvancedComponent(window.editor);
        clearInterval(checkEditor);
      }
    }, 100);
    
    setTimeout(() => {
      clearInterval(checkEditor);
    }, 10000);
  }
  
  if (typeof window !== 'undefined') {
    window.registerImageBoxAdvancedComponent = registerImageBoxAdvancedComponent;
  }
})();
