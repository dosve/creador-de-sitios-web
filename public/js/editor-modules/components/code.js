// Módulo del Componente Code
// Componente de código estilo Elementor con traits y protección

(function() {
  'use strict';
  
  function registerCodeComponent(editor) {
    if (!editor || !editor.DomComponents) {
      return;
    }
    
    editor.DomComponents.addType('code', {
      isComponent: (el) => {
        if (!el || typeof el !== 'object' || !el.nodeType) {
          return false;
        }
        
        // Detectar por tagName PRE
        if (el.tagName === 'PRE') {
          // Verificar si tiene el atributo data-gjs-type
          if (el.getAttribute && el.getAttribute('data-gjs-type') === 'code') {
            return { type: 'code' };
          }
          
          // Verificar si contiene un elemento code
          if (el.querySelector && typeof el.querySelector === 'function' && el.querySelector('code')) {
            return { type: 'code' };
          }
          
          // Verificar si tiene las clases característicos
          if (el.classList && el.classList.contains('code-container')) {
            return { type: 'code' };
          }
          
          // Verificar si tiene estilos inline característicos (fondo oscuro)
          const bgColor = el.style.backgroundColor;
          if (bgColor && (bgColor === 'rgb(17, 24, 39)' || bgColor === '#111827' || 
              bgColor.includes('17, 24, 39') || bgColor.includes('111827'))) {
            return { type: 'code' };
          }
          
          // Si es un PRE con contenido de código (tiene texto y parece código)
          if (el.textContent && el.textContent.trim() && 
              (el.querySelector('code') || el.className.includes('bg-gray-900') || 
               el.className.includes('code') || el.style.fontFamily === 'monospace')) {
            return { type: 'code' };
          }
        }
        
        // Detectar por clase
        if (el.classList && el.classList.contains('code-container')) {
          return { type: 'code' };
        }
        
        // Detectar por estructura (pre code)
        if (el.tagName === 'DIV' && el.querySelector && typeof el.querySelector === 'function' && 
            el.querySelector('pre code')) {
          return { type: 'code' };
        }
        
        return false;
      },
      model: {
        defaults: {
          name: 'Código',
          tagName: 'pre',
          editable: false,
          droppable: false,
          removable: true,
          selectable: true,
          hoverable: true,
          highlightable: true,
          badgable: false,
          attributes: {
            class: 'code-container',
            'data-gjs-type': 'code',
            'data-gjs-name': 'Código',
            'data-gjs-editable': 'false',
            'data-gjs-highlightable': 'true'
          },
          'code-content': '// Código de ejemplo\nfunction ejemplo() {\n  return "Hola mundo";\n}',
          traits: [
            {
              type: 'textarea',
              name: 'code-content',
              label: 'Código',
              placeholder: 'Escribe tu código aquí...',
              rows: 8,
              changeProp: 1
            }
          ]
        },
        init() {
          this.on('change:code-content', this.updateContent, this);
          
          // Sincronizar contenido desde el DOM cuando se carga desde HTML guardado
          this.syncContentFromDOM = () => {
            try {
              if (this.view && this.view.el) {
                const el = this.view.el;
                const codeEl = el.querySelector('code');
                
                if (codeEl && codeEl.textContent) {
                  const domContent = codeEl.textContent.trim();
                  const modelContent = this.get('code-content') || '';
                  
                  // ✅ CRÍTICO: Siempre actualizar el modelo con silent: false para forzar actualización del TraitManager
                  // Esto asegura que los inputs del formulario se actualicen incluso si el contenido ya está sincronizado
                  if (domContent) {
                    this.set('code-content', domContent, { silent: false });
                  } else if (modelContent) {
                    // Si no hay contenido en DOM pero sí en modelo, forzar actualización del formulario
                    this.set('code-content', modelContent, { silent: false });
                  }
                } else if (el.textContent && el.textContent.trim()) {
                  // Si no hay elemento code pero hay texto directo en el pre
                  const domContent = el.textContent.trim();
                  const modelContent = this.get('code-content') || '';
                  
                  if (domContent && domContent !== modelContent) {
                    this.set('code-content', domContent, { silent: false });
                  }
                }
              }
            } catch (e) {
              // Error al sincronizar contenido desde DOM
            }
          };
          
          // Intentar sincronizar cuando el componente se monta (cuando se carga desde HTML)
          this.on('component:mount', () => {
            console.log('🔄 [Code] Componente montado, sincronizando contenido desde DOM...');
            setTimeout(() => {
              if (this.syncContentFromDOM && typeof this.syncContentFromDOM === 'function') {
                this.syncContentFromDOM();
              }
            }, 200);
          });
          
          // Sincronizar también cuando el componente se selecciona (para actualizar el formulario)
          // ✅ La actualización manual de inputs se maneja en editor-config.js para evitar duplicación
          this.on('component:selected', () => {
            console.log('🎯 [Code] Componente seleccionado, sincronizando contenido desde DOM...');
            
            // Sincronizar desde DOM inmediatamente (sin setTimeout) para que el modelo tenga los valores antes del render
            // El editor-config.js se encargará de re-renderizar el TraitManager y actualizar los inputs
            if (this.syncContentFromDOM && typeof this.syncContentFromDOM === 'function') {
              this.syncContentFromDOM();
            }
          });
          
          // Código anterior comentado - ya no es necesario actualizar inputs manualmente
          /*
          this.on('component:selected', () => {
            console.log('🎯 [Code] Componente seleccionado, sincronizando contenido desde DOM...');
            
            // Sincronizar desde DOM primero
            setTimeout(() => {
              if (this.syncContentFromDOM && typeof this.syncContentFromDOM === 'function') {
                this.syncContentFromDOM();
              }
            }, 50);
            
            // Actualizar el formulario después de que se renderice
            // Usar múltiples intentos con diferentes selectores
            const updateFormInputs = (attempt = 1) => {
              console.log(`🔄 [Code] Actualizando formulario (intento ${attempt})...`);
              
              // Buscar el input del formulario con múltiples selectores
              let contentInput = document.querySelector('textarea[name="code-content"]') ||
                                document.querySelector('.traits-container textarea[data-name="code-content"]') ||
                                document.querySelector('.gjs-trt-trait textarea[data-name="code-content"]') ||
                                document.querySelector('.traits-container textarea');
              
              // Si no se encuentra, buscar por posición (primer textarea)
              if (!contentInput) {
                const allTextareas = document.querySelectorAll('.traits-container textarea, .gjs-trt-trait textarea');
                if (allTextareas.length > 0) {
                  contentInput = allTextareas[0];
                  console.log('🔍 [Code] Encontrado textarea por posición');
                }
              }
              
              console.log('🔍 [Code] Input encontrado:', !!contentInput, 'intento:', attempt);
              
              const finalContent = this.get('code-content') || '';
              
              if (contentInput) {
                contentInput.value = finalContent;
                console.log('✅ [Code] Input de contenido actualizado con:', finalContent.substring(0, 50));
                
                // Disparar eventos para que GrapesJS lo detecte
                contentInput.dispatchEvent(new Event('change', { bubbles: true }));
                contentInput.dispatchEvent(new Event('input', { bubbles: true }));
                
                // Verificar que el valor se estableció correctamente
                setTimeout(() => {
                  const verifyInput = contentInput || document.querySelector('textarea[name="code-content"]') || 
                                     document.querySelector('.traits-container textarea');
                  if (verifyInput) {
                    console.log('✅ [Code] Verificación - Input tiene:', verifyInput.value.substring(0, 50));
                  }
                }, 100);
              } else if (attempt < 5) {
                console.warn(`⚠️ [Code] No se encontró el input de contenido, reintentando en 200ms...`);
                setTimeout(() => updateFormInputs(attempt + 1), 200);
              } else {
                console.warn('⚠️ [Code] No se encontró el input de contenido después de 5 intentos');
              }
            };
            
            // Iniciar actualización después de un delay para que se rendericen los inputs
            setTimeout(() => updateFormInputs(1), 300);
          });
          */
          
          // También sincronizar cuando se actualiza el componente
          this.on('change', () => {
            setTimeout(() => {
              if (this.syncContentFromDOM && typeof this.syncContentFromDOM === 'function') {
                this.syncContentFromDOM();
              }
            }, 50);
          });
          
          const protectElements = () => {
            const protectRecursive = (component) => {
              if (!component || typeof component.set !== 'function' || typeof component.get !== 'function') {
                return;
              }
              
              try {
                const componentType = component.get('type');
                if (componentType === 'image' || componentType === 'video' || componentType === 'link' || 
                    componentType === 'button' || componentType === 'text' || componentType === 'heading' ||
                    componentType === 'paragraph') {
                  return;
                }
                
                const tagName = component.get('tagName');
                if (!tagName || (tagName !== 'div' && tagName !== 'span' && tagName !== 'p' && 
                    tagName !== 'h1' && tagName !== 'h2' && tagName !== 'h3' && tagName !== 'h4' && 
                    tagName !== 'h5' && tagName !== 'h6' && tagName !== 'button' && tagName !== 'nav' &&
                    tagName !== 'section' && tagName !== 'article' && tagName !== 'svg' && tagName !== 'path' &&
                    tagName !== 'pre' && tagName !== 'code')) {
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
          const content = this.get('code-content') || '';
          
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          const codeEl = el.querySelector('code');
          
          // Asegurar estilos de contraste
          el.style.setProperty('background-color', '#111827', 'important');
          el.style.setProperty('color', '#f3f4f6', 'important');
          
          if (codeEl) {
            codeEl.textContent = content;
            codeEl.style.setProperty('color', '#f3f4f6', 'important');
            codeEl.style.setProperty('background-color', 'transparent', 'important');
          } else {
            el.textContent = content;
          }
          
          this.view.render();
        },
        toHTML() {
          const tagName = this.get('tagName') || 'pre';
          const attrs = this.getAttributes();
          let attrsArray = [];
          for (let key in attrs) {
            if (attrs.hasOwnProperty(key) && key !== 'content' && key !== 'class') {
              const val = attrs[key];
              attrsArray.push(`${key}="${String(val).replace(/"/g, '&quot;')}"`);
            }
          }
          const attrsStr = attrsArray.join(' ');
          
          const content = this.get('code-content') || '';
          
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
          
          const innerHTML = '<code class="text-sm" style="color: #f3f4f6 !important; font-size: 0.875rem; font-family: monospace; background-color: transparent;">' + escapeHtml(content) + '</code>';
          
          const finalHTML = '<' + tagName + ' class="bg-gray-900 text-gray-100 p-4 rounded-lg overflow-x-auto" style="background-color: #111827 !important; color: #f3f4f6 !important; padding: 1rem; border-radius: 0.5rem; overflow-x: auto; font-family: monospace !important;"' + (attrsStr ? ' ' + attrsStr : '') + '>' + innerHTML + '</' + tagName + '>';
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
          
          // Aplicar estilos inline para garantizar contraste
          el.className = 'bg-gray-900 text-gray-100 p-4 rounded-lg overflow-x-auto';
          el.style.setProperty('background-color', '#111827', 'important');
          el.style.setProperty('color', '#f3f4f6', 'important');
          el.style.setProperty('padding', '1rem', 'important');
          el.style.setProperty('border-radius', '0.5rem', 'important');
          el.style.setProperty('overflow-x', 'auto', 'important');
          el.style.setProperty('font-family', 'monospace', 'important');
          
          let codeEl = el.querySelector('code');
          if (!codeEl) {
            codeEl = document.createElement('code');
            codeEl.className = 'text-sm';
            codeEl.setAttribute('data-gjs-editable', 'false');
            codeEl.setAttribute('data-gjs-selectable', 'false');
            codeEl.setAttribute('contenteditable', 'false');
            el.appendChild(codeEl);
          }
          
          // Aplicar estilos inline al elemento code también
          codeEl.style.setProperty('color', '#f3f4f6', 'important');
          codeEl.style.setProperty('font-size', '0.875rem', 'important');
          codeEl.style.setProperty('font-family', 'monospace', 'important');
          codeEl.style.setProperty('background-color', 'transparent', 'important');
          
          // Sincronizar contenido desde DOM si existe (cuando se carga desde HTML guardado)
          let content = component.get('code-content') || '';
          
          // Si el elemento code ya tiene contenido, usarlo (cargado desde HTML)
          if (codeEl && codeEl.textContent && codeEl.textContent.trim()) {
            const domContent = codeEl.textContent.trim();
            // Si el contenido del DOM es diferente o el modelo está vacío, actualizar el modelo
            if (domContent !== content || !content || !content.trim()) {
              content = domContent;
              component.set('code-content', content, { silent: true });
            }
          } else if (el.textContent && el.textContent.trim() && (!codeEl || !codeEl.textContent)) {
            // Si no hay elemento code pero el pre tiene texto directo
            const domContent = el.textContent.trim();
            if (domContent !== content || !content || !content.trim()) {
              content = domContent;
              component.set('code-content', content, { silent: true });
              // Crear el elemento code si no existe
              if (!codeEl) {
                codeEl = document.createElement('code');
                codeEl.className = 'text-sm';
                codeEl.setAttribute('data-gjs-editable', 'false');
                codeEl.setAttribute('data-gjs-selectable', 'false');
                codeEl.setAttribute('contenteditable', 'false');
                el.innerHTML = '';
                el.appendChild(codeEl);
                codeEl.style.setProperty('color', '#f3f4f6', 'important');
                codeEl.style.setProperty('font-size', '0.875rem', 'important');
                codeEl.style.setProperty('font-family', 'monospace', 'important');
                codeEl.style.setProperty('background-color', 'transparent', 'important');
              }
            }
          }
          
          // Si no hay contenido ni en el modelo ni en el DOM, usar el valor por defecto
          if (!content || !content.trim()) {
            content = '// Código de ejemplo\nfunction ejemplo() {\n  return "Hola mundo";\n}';
          }
          
          if (codeEl) {
            codeEl.textContent = content;
          } else {
            el.textContent = content;
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
            });
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
            attributes: false
          });
          
          this._codeObserver = observer;
          
          // Sincronizar contenido desde DOM después de un breve delay para asegurar que el DOM esté listo
          setTimeout(() => {
            if (component.syncContentFromDOM && typeof component.syncContentFromDOM === 'function') {
              component.syncContentFromDOM();
            }
          }, 200);
        },
        onRemove() {
          if (this._codeObserver) {
            this._codeObserver.disconnect();
          }
        }
      }
    });
    
  }
  
  if (typeof window !== 'undefined' && window.editor) {
    registerCodeComponent(window.editor);
  }
  
  if (typeof window !== 'undefined') {
    window.registerCodeComponent = registerCodeComponent;
  }
})();
