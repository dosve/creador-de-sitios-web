// Módulo del Componente Spacer
// Componente de espaciador estilo Elementor con traits y protección

(function() {
  'use strict';
  
  function registerSpacerComponent(editor) {
    if (!editor || !editor.DomComponents) {
      console.warn('⚠️ Editor no disponible para registrar componente Spacer');
      return;
    }
    
    editor.DomComponents.addType('spacer', {
      isComponent: (el) => {
        // Verificar que el sea un elemento DOM válido
        if (!el || typeof el !== 'object' || !el.nodeType) {
          return false;
        }
        
        if (el.classList && el.classList.contains('spacer-container')) {
          return { type: 'spacer' };
        }
        if (el.tagName === 'DIV' && el.querySelector && typeof el.querySelector === 'function' && el.querySelector('.spacer-container')) {
          return { type: 'spacer' };
        }
        return false;
      },
      model: {
        defaults: {
          name: 'Espaciador',
          tagName: 'div',
          editable: false,
          droppable: false,
          removable: true,
          selectable: true,
          badgable: false,
          attributes: {
            class: 'spacer-container',
            'data-gjs-type': 'spacer',
            'data-gjs-name': 'Espaciador',
            'data-gjs-editable': 'false'
          },
          'spacer-height': '64px', // h-16 por defecto
          traits: [
            {
              type: 'select',
              name: 'spacer-height',
              label: 'Altura',
              changeProp: 1,
              options: [
                { value: '20px', name: '20px - Muy Pequeño' },
                { value: '30px', name: '30px - Pequeño' },
                { value: '50px', name: '50px - Mediano' },
                { value: '64px', name: '64px - Normal' },
                { value: '80px', name: '80px - Grande' },
                { value: '100px', name: '100px - Muy Grande' },
                { value: '150px', name: '150px - Extra Grande' },
                { value: '200px', name: '200px - Muy Extra Grande' }
              ]
            }
          ]
        },
        init() {
          this.on('change:spacer-height', this.updateHeight, this);
          
          // Proteger TODOS los elementos internos
          const protectElements = () => {
            const protectRecursive = (component) => {
              component.set({
                selectable: false,
                hoverable: false,
                draggable: false,
                editable: false,
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
        updateHeight() {
          const height = this.get('spacer-height') || '64px';
          
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          const spacerDiv = el.querySelector('.spacer-element') || el;
          
          // Aplicar altura directamente al elemento
          spacerDiv.style.setProperty('height', height, 'important');
          spacerDiv.style.setProperty('min-height', height, 'important');
          
          // También aplicar al iframe si existe
          try {
            const iframe = editor.Canvas.getFrameEl();
            if (iframe && iframe.contentDocument) {
              const iframeEl = iframe.contentDocument.querySelector(`[data-gjs-type="spacer"]`);
              if (iframeEl) {
                const iframeSpacer = iframeEl.querySelector('.spacer-element') || iframeEl;
                iframeSpacer.style.setProperty('height', height, 'important');
                iframeSpacer.style.setProperty('min-height', height, 'important');
              }
            }
          } catch (e) {
            // Ignorar errores de iframe
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
          
          const height = this.get('spacer-height') || '64px';
          
          // Crear el HTML del espaciador con la altura aplicada
          let innerHTML = '';
          innerHTML += '<div class="spacer-element" style="height: ' + height + '; min-height: ' + height + '; width: 100%; display: block;"></div>';
          
          const finalHTML = '<' + tagName + (attrsStr ? ' ' + attrsStr : '') + '>' + innerHTML + '</' + tagName + '>';
          return finalHTML;
        }
      },
      view: {
        onRender() {
          const el = this.el;
          
          // Proteger el contenedor principal
          el.setAttribute('contenteditable', 'false');
          el.setAttribute('data-gjs-editable', 'false');
          
          // Crear o actualizar el elemento espaciador
          let spacerElement = el.querySelector('.spacer-element');
          if (!spacerElement) {
            spacerElement = document.createElement('div');
            spacerElement.className = 'spacer-element bg-gray-100 border-2 border-dashed border-gray-300 rounded flex items-center justify-center';
            spacerElement.setAttribute('data-gjs-editable', 'false');
            spacerElement.setAttribute('data-gjs-selectable', 'false');
            spacerElement.setAttribute('contenteditable', 'false');
            
            const label = document.createElement('span');
            label.className = 'text-gray-500 text-sm';
            label.setAttribute('data-gjs-editable', 'false');
            label.setAttribute('data-gjs-selectable', 'false');
            label.setAttribute('contenteditable', 'false');
            label.textContent = 'Espaciador';
            spacerElement.appendChild(label);
            
            el.appendChild(spacerElement);
          }
          
          // Aplicar altura inicial
          const component = this.model;
          const height = component.get('spacer-height') || '64px';
          spacerElement.style.setProperty('height', height, 'important');
          spacerElement.style.setProperty('min-height', height, 'important');
          spacerElement.style.setProperty('width', '100%', 'important');
          spacerElement.style.setProperty('display', 'block', 'important');
          
          // Proteger todos los elementos internos
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
          
          // Observar cambios en el DOM SOLO para nuevos elementos (childList)
          // NO observar cambios en atributos para evitar bucles infinitos
          let isProtecting = false;
          const observer = new MutationObserver((mutations) => {
            // Solo procesar si hay nuevos elementos agregados
            const hasNewChildren = mutations.some(mutation => 
              mutation.type === 'childList' && mutation.addedNodes.length > 0
            );
            
            if (hasNewChildren && !isProtecting) {
              isProtecting = true;
              protectAllElements(el);
              // Re-aplicar altura si se pierde
              const currentHeight = component.get('spacer-height') || '64px';
              if (spacerElement) {
                spacerElement.style.setProperty('height', currentHeight, 'important');
                spacerElement.style.setProperty('min-height', currentHeight, 'important');
              }
              setTimeout(() => {
                isProtecting = false;
              }, 50);
            }
          });
          
          observer.observe(el, {
            childList: true,
            subtree: true,
            attributes: false  // ✅ CRÍTICO: NO observar cambios en atributos
          });
          
          this._spacerObserver = observer;
        },
        onRemove() {
          if (this._spacerObserver) {
            this._spacerObserver.disconnect();
          }
        }
      }
    });
    
  }
  
  // Auto-registrar si el editor está disponible
  if (typeof window !== 'undefined' && window.editor) {
    registerSpacerComponent(window.editor);
  }
  
  // Exportar para registro manual
  if (typeof window !== 'undefined') {
    window.registerSpacerComponent = registerSpacerComponent;
  }
})();
