// Módulo del Componente Verse
// Componente de verso estilo Elementor con traits y protección

(function() {
  'use strict';
  
  function registerVerseComponent(editor) {
    if (!editor || !editor.DomComponents) {
      console.warn('⚠️ Editor no disponible para registrar componente Verse');
      return;
    }
    
    editor.DomComponents.addType('verse', {
      isComponent: (el) => {
        if (!el || typeof el !== 'object' || !el.nodeType) {
          return false;
        }
        
        // Detectar por clase verse-container
        if (el.classList && el.classList.contains('verse-container')) {
          return { type: 'verse' };
        }
        
        // Detectar por atributo data-gjs-type
        if (el.getAttribute && el.getAttribute('data-gjs-type') === 'verse') {
          return { type: 'verse' };
        }
        
        // Detectar por estructura cuando se carga desde HTML guardado
        if (el.tagName === 'DIV' && el.querySelector && typeof el.querySelector === 'function') {
          // Si tiene la clase o contiene elementos con estructura de verso
          if (el.classList && (el.classList.contains('verse-container') || 
              el.querySelector('.verse-content') || 
              (el.className && el.className.includes('verse-container')))) {
            return { type: 'verse' };
          }
        }
        
        return false;
      },
      model: {
        defaults: {
          name: 'Verso',
          tagName: 'div',
          editable: false,
          droppable: false,
          removable: true,
          selectable: true,
          hoverable: true,
          highlightable: true,
          badgable: false,
          attributes: {
            class: 'verse-container',
            'data-gjs-type': 'verse',
            'data-gjs-name': 'Verso',
            'data-gjs-editable': 'false',
            'data-gjs-highlightable': 'true'
          },
          'verse-content': 'Este es un verso\nque mantiene el formato\ny la estructura poética',
          'verse-author': 'Autor del verso',
          traits: [
            {
              type: 'textarea',
              name: 'verse-content',
              label: 'Contenido del Verso',
              placeholder: 'Escribe el verso aquí...',
              rows: 6,
              changeProp: 1
            },
            {
              type: 'text',
              name: 'verse-author',
              label: 'Autor',
              placeholder: 'Autor del verso',
              changeProp: 1
            }
          ]
        },
        init() {
          this.on('change:verse-content', this.updateContent, this);
          this.on('change:verse-author', this.updateAuthor, this);
          
          // Sincronizar contenido desde el DOM cuando se carga desde HTML guardado
          this.syncContentFromDOM = () => {
            try {
              if (this.view && this.view.el) {
                const el = this.view.el;
                
                // Intentar encontrar el contenedor de contenido
                let contentDiv = el.querySelector('.verse-content');
                
                // Si no existe, buscar párrafos directamente en el contenedor
                if (!contentDiv) {
                  const allParagraphs = el.querySelectorAll('p');
                  if (allParagraphs.length > 0) {
                    // Crear un div temporal para extraer el contenido
                    contentDiv = el;
                  }
                }
                
                if (contentDiv) {
                  // Extraer el contenido de los párrafos
                  const paragraphs = contentDiv.querySelectorAll('p:not(.verse-author)');
                  let lines = [];
                  
                  if (paragraphs.length > 0) {
                    lines = Array.from(paragraphs).map(p => p.textContent.trim()).filter(text => text && !text.startsWith('—'));
                  } else {
                    // Si no hay párrafos, intentar extraer del texto directo
                    const textContent = contentDiv.textContent || el.textContent || '';
                    if (textContent) {
                      lines = textContent.split('\n').map(line => line.trim()).filter(line => line && !line.startsWith('—'));
                    }
                  }
                  
                  const domContent = lines.join('\n');
                  
                  // Extraer el autor
                  let authorEl = el.querySelector('.verse-author');
                  if (!authorEl) {
                    // Buscar cualquier párrafo que empiece con "—"
                    const allP = el.querySelectorAll('p');
                    for (let p of allP) {
                      if (p.textContent && p.textContent.trim().startsWith('—')) {
                        authorEl = p;
                        break;
                      }
                    }
                  }
                  
                  const domAuthor = authorEl ? authorEl.textContent.replace(/^—\s*/, '').trim() : '';
                  
                  const modelContent = this.get('verse-content') || '';
                  const modelAuthor = this.get('verse-author') || '';
                  
                  // ✅ CRÍTICO: Siempre actualizar el modelo con silent: false para forzar actualización del TraitManager
                  // Esto asegura que los inputs del formulario se actualicen incluso si el contenido ya está sincronizado
                  if (domContent) {
                    this.set('verse-content', domContent, { silent: false });
                  } else if (modelContent) {
                    // Si no hay contenido en DOM pero sí en modelo, forzar actualización del formulario
                    this.set('verse-content', modelContent, { silent: false });
                  }
                  
                  if (domAuthor) {
                    this.set('verse-author', domAuthor, { silent: false });
                  } else if (modelAuthor) {
                    // Si no hay autor en DOM pero sí en modelo, forzar actualización del formulario
                    this.set('verse-author', modelAuthor, { silent: false });
                  }
                }
              }
            } catch (e) {
              // Error al sincronizar contenido desde DOM
            }
          };
          
          // Intentar sincronizar cuando el componente se monta (cuando se carga desde HTML)
          this.on('component:mount', () => {
            setTimeout(() => {
              if (this.syncContentFromDOM && typeof this.syncContentFromDOM === 'function') {
                this.syncContentFromDOM();
              }
            }, 300);
          });
          
          // Sincronizar también cuando el componente se selecciona (para actualizar el formulario)
          // ✅ La actualización manual de inputs se maneja en editor-core.js y módulos migrados para evitar duplicación
          this.on('component:selected', () => {
            // Sincronizar desde DOM inmediatamente (sin setTimeout) para que el modelo tenga los valores antes del render
            // El editor-core.js y módulos migrados se encargan de re-renderizar el TraitManager y actualizar los inputs
            if (this.syncContentFromDOM && typeof this.syncContentFromDOM === 'function') {
              this.syncContentFromDOM();
            }
          });
          
          // Código anterior comentado - ya no es necesario actualizar inputs manualmente
          /*
          this.on('component:selected', () => {
            console.log('🎯 [Verse] ===== COMPONENTE SELECCIONADO =====');
            console.log('🔍 [Verse] Estado del modelo al seleccionar:', {
              'verse-content': this.get('verse-content'),
              'verse-author': this.get('verse-author')
            });
            
            const modelContent = this.get('verse-content') || '';
            const modelAuthor = this.get('verse-author') || '';
            
            // Sincronizar desde DOM primero
            setTimeout(() => {
              if (this.syncContentFromDOM && typeof this.syncContentFromDOM === 'function') {
                this.syncContentFromDOM();
              }
            }, 50);
            
            // Actualizar el formulario después de que se renderice
            // Usar múltiples intentos con diferentes selectores
            const updateFormInputs = (attempt = 1) => {
              console.log(`🔄 [Verse] Actualizando formulario (intento ${attempt})...`);
              
              // Buscar los inputs del formulario con múltiples selectores
              let contentInput = document.querySelector('textarea[name="verse-content"]') ||
                                document.querySelector('.traits-container textarea[data-name="verse-content"]') ||
                                document.querySelector('.gjs-trt-trait textarea[data-name="verse-content"]') ||
                                document.querySelector('.traits-container textarea');
              
              let authorInput = document.querySelector('input[name="verse-author"]') ||
                               document.querySelector('.traits-container input[data-name="verse-author"]') ||
                               document.querySelector('.gjs-trt-trait input[data-name="verse-author"]') ||
                               document.querySelector('.traits-container input[type="text"]');
              
              // Si no se encuentran, buscar por posición (primer textarea, segundo input)
              if (!contentInput) {
                const allTextareas = document.querySelectorAll('.traits-container textarea, .gjs-trt-trait textarea');
                if (allTextareas.length > 0) {
                  contentInput = allTextareas[0];
                  console.log('🔍 [Verse] Encontrado textarea por posición');
                }
              }
              
              if (!authorInput) {
                const allInputs = document.querySelectorAll('.traits-container input[type="text"], .gjs-trt-trait input[type="text"]');
                if (allInputs.length > 0) {
                  // Buscar el input que no sea el primero (si hay múltiples)
                  authorInput = allInputs[allInputs.length > 1 ? 1 : 0];
                  console.log('🔍 [Verse] Encontrado input por posición');
                }
              }
              
              console.log('🔍 [Verse] Inputs encontrados:', {
                content: !!contentInput,
                author: !!authorInput,
                attempt: attempt
              });
              
              const finalContent = this.get('verse-content') || '';
              const finalAuthor = this.get('verse-author') || '';
              
              if (contentInput) {
                contentInput.value = finalContent;
                console.log('✅ [Verse] Input de contenido actualizado con:', finalContent.substring(0, 50));
                
                // Disparar eventos para que GrapesJS lo detecte
                contentInput.dispatchEvent(new Event('change', { bubbles: true }));
                contentInput.dispatchEvent(new Event('input', { bubbles: true }));
              } else if (attempt < 5) {
                console.warn(`⚠️ [Verse] No se encontró el input de contenido, reintentando en 200ms...`);
                setTimeout(() => updateFormInputs(attempt + 1), 200);
                return;
              } else {
                console.warn('⚠️ [Verse] No se encontró el input de contenido después de 5 intentos');
              }
              
              if (authorInput) {
                authorInput.value = finalAuthor;
                console.log('✅ [Verse] Input de autor actualizado con:', finalAuthor);
                
                // Disparar eventos para que GrapesJS lo detecte
                authorInput.dispatchEvent(new Event('change', { bubbles: true }));
                authorInput.dispatchEvent(new Event('input', { bubbles: true }));
              } else if (attempt < 5) {
                console.warn(`⚠️ [Verse] No se encontró el input de autor, reintentando en 200ms...`);
                setTimeout(() => updateFormInputs(attempt + 1), 200);
                return;
              } else {
                console.warn('⚠️ [Verse] No se encontró el input de autor después de 5 intentos');
              }
              
              // Si encontramos al menos uno, verificar
              if (contentInput || authorInput) {
                setTimeout(() => {
                  const verifyContent = contentInput || document.querySelector('textarea[name="verse-content"]') || 
                                       document.querySelector('.traits-container textarea');
                  const verifyAuthor = authorInput || document.querySelector('input[name="verse-author"]') || 
                                      document.querySelector('.traits-container input[type="text"]');
                  
                  if (verifyContent) {
                    console.log('✅ [Verse] Verificación - Input de contenido tiene:', verifyContent.value.substring(0, 50));
                  }
                  if (verifyAuthor) {
                    console.log('✅ [Verse] Verificación - Input de autor tiene:', verifyAuthor.value);
                  }
                }, 100);
              }
            };
            
            // Iniciar actualización después de un delay para que se rendericen los inputs
            setTimeout(() => updateFormInputs(1), 300);
          });
          */
          
          const protectElements = () => {
            // ✅ CRÍTICO: Eliminar componentes hijos no deseados primero
            try {
              if (this.components && typeof this.components === 'function') {
                const children = this.components();
                if (children && children.length > 0) {
                  children.each((child) => {
                    if (child && child.get) {
                      const childType = child.get('type');
                      const childTag = child.get('tagName');
                      // Eliminar componentes de texto, párrafo, etc. que no deberían estar aquí
                      if (childType === 'text' || childType === 'paragraph' || 
                          childType === 'heading' || childTag === 'p' || childTag === 'span') {
                        child.remove();
                      }
                    }
                  });
                }
              }
            } catch (e) {
              console.warn('⚠️ [Verse] Error al eliminar componentes hijos en protectElements:', e);
            }
            
            const protectRecursive = (component) => {
              if (!component || typeof component.set !== 'function' || typeof component.get !== 'function') {
                return;
              }
              
              try {
                const componentType = component.get('type');
                // NO proteger componentes de texto/párrafo - eliminarlos en su lugar
                if (componentType === 'text' || componentType === 'paragraph' || 
                    componentType === 'heading') {
                  component.remove();
                  return;
                }
                
                if (componentType === 'image' || componentType === 'video' || componentType === 'link' || 
                    componentType === 'button') {
                  return;
                }
                
                const tagName = component.get('tagName');
                if (!tagName || (tagName !== 'div' && tagName !== 'span' && tagName !== 'p' && 
                    tagName !== 'h1' && tagName !== 'h2' && tagName !== 'h3' && tagName !== 'h4' && 
                    tagName !== 'h5' && tagName !== 'h6' && tagName !== 'button' && tagName !== 'nav' &&
                    tagName !== 'section' && tagName !== 'article' && tagName !== 'svg' && tagName !== 'path')) {
                  return;
                }
                
                component.set({
                  selectable: false,
                  hoverable: false,
                  draggable: false,
                  editable: false,
                  removable: false,
                  droppable: false
                });
                
                if (typeof component.addAttributes === 'function') {
                  component.addAttributes({
                    'data-gjs-editable': 'false',
                    'data-gjs-selectable': 'false',
                    'data-gjs-draggable': 'false',
                    'data-gjs-droppable': 'false',
                    'data-gjs-removable': 'false',
                    'data-gjs-type': '',
                    'contenteditable': 'false'
                  });
                }
              } catch (e) {
                // Ignorar errores
              }
            };
            
            try {
              if (this.components && typeof this.components === 'function') {
                this.components().each(child => {
                  if (child) {
                    protectRecursive(child);
                  }
                });
              }
            } catch (e) {
              // Ignorar errores
            }
          };
          
          setTimeout(protectElements, 100);
          this.on('component:mount', protectElements);
          this.on('component:add', () => {
            setTimeout(protectElements, 100);
          });
        },
        updateContent() {
          const content = this.get('verse-content') || '';
          
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          const contentDiv = el.querySelector('.verse-content');
          
          if (contentDiv) {
            const lines = content.split('\n');
            contentDiv.innerHTML = '';
            lines.forEach(line => {
              const p = document.createElement('p');
              p.className = 'mb-4';
              p.textContent = line;
              p.setAttribute('data-gjs-editable', 'false');
              p.setAttribute('data-gjs-selectable', 'false');
              p.setAttribute('contenteditable', 'false');
              contentDiv.appendChild(p);
            });
          }
          
          this.view.render();
        },
        updateAuthor() {
          const author = this.get('verse-author') || '';
          
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          const authorEl = el.querySelector('.verse-author');
          
          if (authorEl) {
            authorEl.textContent = '— ' + author;
          }
          
          this.view.render();
        },
        toHTML() {
          const tagName = this.get('tagName') || 'div';
          const attrs = this.getAttributes();
          let attrsArray = [];
          for (let key in attrs) {
            if (attrs.hasOwnProperty(key) && key !== 'content') {
              const val = attrs[key];
              attrsArray.push(`${key}="${String(val).replace(/"/g, '&quot;')}"`);
            }
          }
          const attrsStr = attrsArray.join(' ');
          
          const content = this.get('verse-content') || '';
          const author = this.get('verse-author') || '';
          
          const escapeHtml = (text) => {
            if (!text) return '';
            const map = {
              '&': '&amp;',
              '<': '&lt;',
              '>': '&gt;',
              '"': '&quot;',
              "'": '&#039;'
            };
            return String(text).replace(/[&<>"']/g, m => map[m]);
          };
          
          let innerHTML = '';
          innerHTML += '<div class="text-center font-serif text-lg leading-relaxed text-gray-700">';
          
          const lines = content.split('\n');
          lines.forEach(line => {
            if (line.trim()) {
              innerHTML += '<p class="mb-4">' + escapeHtml(line) + '</p>';
            }
          });
          
          if (author) {
            innerHTML += '<p class="text-sm text-gray-500 italic">— ' + escapeHtml(author) + '</p>';
          }
          
          innerHTML += '</div>';
          
          const finalHTML = '<' + tagName + ' class="verse-container bg-gray-50 p-6 rounded-lg"' + (attrsStr ? ' ' + attrsStr : '') + '>' + innerHTML + '</' + tagName + '>';
          return finalHTML;
        }
      },
      view: {
        onRender() {
          const el = this.el;
          const component = this.model;
          
          el.setAttribute('contenteditable', 'false');
          el.setAttribute('data-gjs-editable', 'false');
          el.setAttribute('data-gjs-selectable', 'true');
          el.setAttribute('data-gjs-highlightable', 'true');
          el.setAttribute('data-gjs-hoverable', 'true');
          
          el.className = 'verse-container bg-gray-50 p-6 rounded-lg';
          
          // ✅ CRÍTICO: Sincronizar ANTES de hacer cualquier otra cosa
          // Verificar si ya existe contenido en el DOM (cargado desde HTML guardado)
          let contentDiv = el.querySelector('.verse-content');
          const hasExistingContent = contentDiv && contentDiv.querySelectorAll('p').length > 0;
          const allParagraphs = el.querySelectorAll('p');
          
          // Sincronizar contenido desde DOM si existe (cuando se carga desde HTML guardado)
          if (hasExistingContent || allParagraphs.length > 0) {
            if (component.syncContentFromDOM && typeof component.syncContentFromDOM === 'function') {
              component.syncContentFromDOM();
            }
          }
          
          // ✅ CRÍTICO: Eliminar cualquier componente hijo que GrapesJS haya creado automáticamente
          // Esto previene que los párrafos se detecten como componentes editables separados
          try {
            if (component.components && typeof component.components === 'function') {
              const children = component.components();
              if (children && children.length > 0) {
                children.each((child) => {
                  if (child && child.get) {
                    const childType = child.get('type');
                    const childTag = child.get('tagName');
                    // Eliminar componentes de texto, párrafo, etc. que no deberían estar aquí
                    if (childType === 'text' || childType === 'paragraph' || 
                        childType === 'heading' || childTag === 'p' || childTag === 'span') {
                      child.remove();
                    }
                  }
                });
              }
            }
          } catch (e) {
            // Error al eliminar componentes hijos
          }
          
          // Limpiar completamente el contenido y reconstruir desde el modelo
          el.innerHTML = '';
          
          // Crear el contenedor de contenido
          contentDiv = document.createElement('div');
          contentDiv.className = 'verse-content text-center font-serif text-lg leading-relaxed text-gray-700';
          contentDiv.setAttribute('data-gjs-editable', 'false');
          contentDiv.setAttribute('data-gjs-selectable', 'false');
          contentDiv.setAttribute('data-gjs-droppable', 'false');
          contentDiv.setAttribute('data-gjs-removable', 'false');
          contentDiv.setAttribute('data-gjs-type', '');
          contentDiv.setAttribute('data-gjs-draggable', 'false');
          contentDiv.setAttribute('data-gjs-badgable', 'false');
          contentDiv.setAttribute('contenteditable', 'false');
          el.appendChild(contentDiv);
          
          // Reconstruir el contenido desde el modelo
          const content = component.get('verse-content') || '';
          const lines = content.split('\n');
          lines.forEach(line => {
            if (line.trim()) {
              const p = document.createElement('p');
              p.className = 'mb-4';
              p.textContent = line;
              p.setAttribute('data-gjs-editable', 'false');
              p.setAttribute('data-gjs-selectable', 'false');
              p.setAttribute('data-gjs-droppable', 'false');
              p.setAttribute('data-gjs-removable', 'false');
              p.setAttribute('data-gjs-draggable', 'false');
              p.setAttribute('data-gjs-badgable', 'false');
              p.setAttribute('data-gjs-type', '');
              p.setAttribute('data-gjs-hoverable', 'false');
              p.setAttribute('contenteditable', 'false');
              // Prevenir que GrapesJS detecte este elemento como componente editable
              p.style.setProperty('pointer-events', 'none', 'important');
              contentDiv.appendChild(p);
            }
          });
          
          // Agregar el autor
          const author = component.get('verse-author') || '';
          if (author) {
            const authorEl = document.createElement('p');
            authorEl.className = 'verse-author text-sm text-gray-500 italic text-center';
            authorEl.setAttribute('data-gjs-editable', 'false');
            authorEl.setAttribute('data-gjs-selectable', 'false');
            authorEl.setAttribute('data-gjs-droppable', 'false');
            authorEl.setAttribute('data-gjs-removable', 'false');
            authorEl.setAttribute('data-gjs-type', '');
            authorEl.setAttribute('contenteditable', 'false');
            authorEl.textContent = '— ' + author;
            el.appendChild(authorEl);
          }
          
          const protectAllElements = (container) => {
            if (!container) return;
            const allElements = container.querySelectorAll('*');
            allElements.forEach(element => {
              element.setAttribute('contenteditable', 'false');
              element.setAttribute('data-gjs-editable', 'false');
              element.setAttribute('data-gjs-selectable', 'false');
              element.setAttribute('data-gjs-draggable', 'false');
              element.setAttribute('data-gjs-droppable', 'false');
              element.setAttribute('data-gjs-removable', 'false');
              element.setAttribute('data-gjs-badgable', 'false');
              element.setAttribute('data-gjs-hoverable', 'false');
              element.setAttribute('data-gjs-type', ''); // Prevenir detección como componente
              // Prevenir interacción directa
              element.style.setProperty('pointer-events', 'none', 'important');
              
              // También proteger el contenedor de contenido
              if (element.classList && element.classList.contains('verse-content')) {
                element.style.setProperty('pointer-events', 'auto', 'important');
              }
            });
            
            // El contenedor principal debe ser seleccionable, pero no editable
            container.style.setProperty('pointer-events', 'auto', 'important');
          };
          
          protectAllElements(el);
          
          let isProtecting = false;
          const observer = new MutationObserver((mutations) => {
            const hasNewChildren = mutations.some(mutation => 
              mutation.type === 'childList' && mutation.addedNodes.length > 0
            );
            
            if (hasNewChildren && !isProtecting) {
              isProtecting = true;
              protectAllElements(el);
              setTimeout(() => {
                isProtecting = false;
              }, 50);
            }
          });
          
          observer.observe(el, {
            childList: true,
            subtree: true,
            attributes: true, // Observar cambios en atributos para proteger continuamente
            attributeFilter: ['contenteditable', 'data-gjs-editable', 'data-gjs-selectable', 'data-gjs-type']
          });
          
          this._verseObserver = observer;
          
          // Sincronizar contenido desde DOM después de un breve delay para asegurar que el DOM esté listo
          setTimeout(() => {
            // Eliminar componentes hijos no deseados nuevamente después del render
            try {
              if (component.components && typeof component.components === 'function') {
                const children = component.components();
                if (children && children.length > 0) {
                  children.each((child) => {
                    if (child && child.get) {
                      const childType = child.get('type');
                      const childTag = child.get('tagName');
                      if (childType === 'text' || childType === 'paragraph' || 
                          childType === 'heading' || childTag === 'p' || childTag === 'span') {
                        child.remove();
                      }
                    }
                  });
                }
              }
            } catch (e) {
              // Error al eliminar componentes hijos después del render
            }
            
            if (component.syncContentFromDOM && typeof component.syncContentFromDOM === 'function') {
              component.syncContentFromDOM();
            }
            
            // Si el componente está seleccionado, actualizar el TraitManager
            if (window.editor && window.editor.getSelected && window.editor.getSelected() === component) {
              setTimeout(() => {
                if (window.editor.TraitManager && window.editor.TraitManager.render) {
                  window.editor.TraitManager.render();
                }
              }, 100);
            }
          }, 200);
        },
        onRemove() {
          if (this._verseObserver) {
            this._verseObserver.disconnect();
          }
        }
      }
    });
    
  }
  
  if (typeof window !== 'undefined' && window.editor) {
    registerVerseComponent(window.editor);
  }
  
  if (typeof window !== 'undefined') {
    window.registerVerseComponent = registerVerseComponent;
  }
})();
