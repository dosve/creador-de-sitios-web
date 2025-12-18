// Módulo del Componente HTML Code
// Componente de código HTML/CSS/JavaScript personalizado estilo Elementor con traits y protección

(function() {
  'use strict';
  
  function registerHtmlCodeComponent(editor) {
    if (!editor || !editor.DomComponents) {
      console.warn('⚠️ Editor no disponible para registrar componente HTML Code');
      return;
    }
    
    editor.DomComponents.addType('html-code', {
      isComponent: (el) => {
        // Verificar que el sea un elemento DOM válido
        if (!el || typeof el !== 'object' || !el.nodeType) {
          return false;
        }
        
        if (el.classList && el.classList.contains('custom-html-block')) {
          return { type: 'html-code' };
        }
        if (el.tagName === 'DIV' && el.querySelector && typeof el.querySelector === 'function' && el.querySelector('.custom-html-block')) {
          return { type: 'html-code' };
        }
        return false;
      },
      model: {
        defaults: {
          name: 'Código HTML',
          tagName: 'div',
          editable: false,
          droppable: false,
          removable: true,
          selectable: true,
          badgable: false,
          attributes: {
            class: 'custom-html-block p-4 bg-white border-2 border-dashed border-gray-300 rounded-lg',
            'data-gjs-type': 'html-code',
            'data-gjs-name': 'Código HTML',
            'data-gjs-editable': 'false',
            style: 'background-color: #ffffff !important; border-color: #d1d5db !important;'
          },
          'html-content': '',
          'css-content': '',
          'js-content': '',
          traits: [
            {
              type: 'textarea',
              name: 'html-content',
              label: 'Código HTML',
              placeholder: '<div>Tu código HTML aquí</div>',
              rows: 6,
              changeProp: 1
            },
            {
              type: 'textarea',
              name: 'css-content',
              label: 'CSS (opcional)',
              placeholder: '.tu-clase { color: red; }',
              rows: 4,
              changeProp: 1
            },
            {
              type: 'textarea',
              name: 'js-content',
              label: 'JavaScript (opcional)',
              placeholder: 'console.log("Hola");',
              rows: 4,
              changeProp: 1
            }
          ]
        },
        init() {
          this.on('change:html-content', this.updateContent, this);
          this.on('change:css-content', this.updateContent, this);
          this.on('change:js-content', this.updateContent, this);
          
          // Proteger TODOS los elementos internos - NO edición directa
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
                'data-gjs-removable': 'false',
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
        updateContent() {
          const htmlContent = this.get('html-content') || '';
          const cssContent = this.get('css-content') || '';
          const jsContent = this.get('js-content') || '';
          
          console.log('💻 Actualizando contenido HTML Code:', { 
            html: htmlContent.substring(0, 50), 
            css: cssContent.substring(0, 50), 
            js: jsContent.substring(0, 50) 
          });
          
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          
          // Si hay contenido, crear un contenedor para renderizarlo
          if (htmlContent.trim() || cssContent.trim() || jsContent.trim()) {
            // Buscar o crear contenedor de preview
            let previewContainer = el.querySelector('.html-code-preview');
            
            if (!previewContainer) {
              // Remover elementos de placeholder si existen
              const placeholder = el.querySelector('.flex.items-center.justify-center');
              const placeholderText = el.querySelector('.mt-2.text-xs');
              if (placeholder) placeholder.remove();
              if (placeholderText) placeholderText.remove();
              
              // Crear contenedor de preview
              previewContainer = document.createElement('div');
              previewContainer.className = 'html-code-preview mt-4';
              previewContainer.setAttribute('data-gjs-editable', 'false');
              previewContainer.setAttribute('data-gjs-selectable', 'false');
              previewContainer.setAttribute('contenteditable', 'false');
              el.appendChild(previewContainer);
            }
            
            // Limpiar preview anterior
            previewContainer.innerHTML = '';
            
            // Agregar CSS si existe
            if (cssContent.trim()) {
              const style = document.createElement('style');
              style.textContent = cssContent;
              style.setAttribute('data-gjs-editable', 'false');
              style.setAttribute('data-gjs-selectable', 'false');
              previewContainer.appendChild(style);
            }
            
            // Agregar HTML si existe
            if (htmlContent.trim()) {
              const tempDiv = document.createElement('div');
              tempDiv.innerHTML = htmlContent;
              
              // Proteger todos los elementos del HTML insertado
              const allElements = tempDiv.querySelectorAll('*');
              allElements.forEach(element => {
                element.setAttribute('data-gjs-editable', 'false');
                element.setAttribute('data-gjs-selectable', 'false');
                element.setAttribute('data-gjs-draggable', 'false');
                element.setAttribute('data-gjs-droppable', 'false');
                element.setAttribute('data-gjs-removable', 'false');
                element.setAttribute('contenteditable', 'false');
              });
              
              previewContainer.appendChild(tempDiv);
            }
            
            // Agregar JavaScript si existe
            if (jsContent.trim()) {
              const script = document.createElement('script');
              script.textContent = jsContent;
              script.setAttribute('data-gjs-editable', 'false');
              script.setAttribute('data-gjs-selectable', 'false');
              previewContainer.appendChild(script);
            }
          } else {
            // Si no hay contenido, mostrar placeholder
            const previewContainer = el.querySelector('.html-code-preview');
            if (previewContainer) {
              previewContainer.remove();
            }
            
            // Asegurar que existe el placeholder
            if (!el.querySelector('.flex.items-center.justify-center')) {
              const placeholderDiv = document.createElement('div');
              placeholderDiv.className = 'flex items-center justify-center text-gray-500';
              placeholderDiv.setAttribute('data-gjs-editable', 'false');
              placeholderDiv.setAttribute('data-gjs-selectable', 'false');
              placeholderDiv.setAttribute('contenteditable', 'false');
              
              const svg = document.createElement('svg');
              svg.className = 'w-8 h-8 mr-2';
              svg.setAttribute('fill', 'none');
              svg.setAttribute('stroke', 'currentColor');
              svg.setAttribute('viewBox', '0 0 24 24');
              svg.setAttribute('data-gjs-editable', 'false');
              svg.setAttribute('data-gjs-selectable', 'false');
              
              const path = document.createElement('path');
              path.setAttribute('stroke-linecap', 'round');
              path.setAttribute('stroke-linejoin', 'round');
              path.setAttribute('stroke-width', '2');
              path.setAttribute('d', 'M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4');
              path.setAttribute('data-gjs-editable', 'false');
              path.setAttribute('data-gjs-selectable', 'false');
              svg.appendChild(path);
              
              const span = document.createElement('span');
              span.className = 'text-sm font-medium';
              span.setAttribute('data-gjs-editable', 'false');
              span.setAttribute('data-gjs-selectable', 'false');
              span.textContent = 'Bloque de Código HTML/CSS/JavaScript';
              
              placeholderDiv.appendChild(svg);
              placeholderDiv.appendChild(span);
              el.appendChild(placeholderDiv);
              
              const placeholderText = document.createElement('p');
              placeholderText.className = 'mt-2 text-xs text-center text-gray-400';
              placeholderText.setAttribute('data-gjs-editable', 'false');
              placeholderText.setAttribute('data-gjs-selectable', 'false');
              placeholderText.textContent = 'Haz clic para editar el código personalizado';
              el.appendChild(placeholderText);
            }
          }
        },
        toHTML() {
          console.log('💾 [HtmlCode] toHTML() llamado - serializando componente');
          
          const htmlContent = this.get('html-content') || '';
          const cssContent = this.get('css-content') || '';
          const jsContent = this.get('js-content') || '';
          
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
          
          // Construir el contenido HTML final
          let innerHTML = '';
          
          // Agregar CSS si existe
          if (cssContent.trim()) {
            innerHTML += `<style>${cssContent}</style>`;
          }
          
          // Agregar HTML si existe
          if (htmlContent.trim()) {
            innerHTML += htmlContent;
          }
          
          // Agregar JavaScript si existe
          if (jsContent.trim()) {
            innerHTML += `<script>${jsContent}</script>`;
          }
          
          // Si no hay contenido, mantener la estructura del placeholder
          if (!innerHTML.trim()) {
            innerHTML = `
              <div class="flex items-center justify-center text-gray-500" data-gjs-editable="false" data-gjs-selectable="false" contenteditable="false">
                <svg class="w-8 h-8 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" data-gjs-editable="false" data-gjs-selectable="false">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" data-gjs-editable="false" data-gjs-selectable="false"></path>
                </svg>
                <span class="text-sm font-medium" data-gjs-editable="false" data-gjs-selectable="false">Bloque de Código HTML/CSS/JavaScript</span>
              </div>
              <p class="mt-2 text-xs text-center text-gray-400" data-gjs-editable="false" data-gjs-selectable="false">Haz clic para editar el código personalizado</p>
            `;
          }
          
          const finalHTML = `<${tagName}${attrsStr ? ' ' + attrsStr : ''}>${innerHTML}</${tagName}>`;
          
          console.log('✅ [HtmlCode] toHTML - HTML generado (primeros 200 chars):', finalHTML.substring(0, 200));
          
          return finalHTML;
        }
      },
      view: {
        onRender() {
          const el = this.el;
          console.log('💻 Vista de HTML Code renderizada');
          
          // Proteger el contenedor principal
          el.setAttribute('contenteditable', 'false');
          el.setAttribute('data-gjs-editable', 'false');
          
          // Asegurar fondo claro y contraste adecuado
          el.style.setProperty('background-color', '#ffffff', 'important');
          el.style.setProperty('border-color', '#d1d5db', 'important');
          el.style.setProperty('color', '#1f2937', 'important');
          
          // Proteger TODOS los elementos internos
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
          
          // Aplicar contenido inicial si existe
          const component = this.model;
          const htmlContent = component.get('html-content') || '';
          const cssContent = component.get('css-content') || '';
          const jsContent = component.get('js-content') || '';
          
          if (htmlContent.trim() || cssContent.trim() || jsContent.trim()) {
            // Si hay contenido, actualizar
            component.updateContent();
          }
          
          // Observar cambios en el DOM
          const observer = new MutationObserver(() => {
            protectAllElements(el);
          });
          
          observer.observe(el, {
            childList: true,
            subtree: true
          });
          
          this._htmlCodeObserver = observer;
          
          console.log('✅ Vista de HTML Code lista');
        },
        onRemove() {
          if (this._htmlCodeObserver) {
            this._htmlCodeObserver.disconnect();
          }
        }
      }
    });
    
  }
  
  // Auto-registrar si el editor está disponible
  if (typeof window !== 'undefined' && window.editor) {
    registerHtmlCodeComponent(window.editor);
  }
  
  // Exportar para registro manual
  if (typeof window !== 'undefined') {
    window.registerHtmlCodeComponent = registerHtmlCodeComponent;
  }
})();
