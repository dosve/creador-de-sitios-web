// Módulo del Componente Preformatted
// Componente de texto preformateado estilo Elementor con traits y protección

(function() {
  'use strict';
  
  function registerPreformattedComponent(editor) {
    if (!editor || !editor.DomComponents) {
      console.warn('⚠️ Editor no disponible para registrar componente Preformatted');
      return;
    }
    
    editor.DomComponents.addType('preformatted', {
      isComponent: (el) => {
        if (!el || typeof el !== 'object' || !el.nodeType) {
          return false;
        }
        
        if (el.tagName === 'PRE' && el.classList && el.classList.contains('preformatted-container')) {
          return { type: 'preformatted' };
        }
        if (el.tagName === 'PRE' && el.querySelector && typeof el.querySelector === 'function') {
          return { type: 'preformatted' };
        }
        return false;
      },
      model: {
        defaults: {
          name: 'Preformateado',
          tagName: 'pre',
          editable: false,
          droppable: false,
          removable: true,
          selectable: true,
          hoverable: true,
          highlightable: true,
          badgable: false,
          attributes: {
            class: 'preformatted-container',
            'data-gjs-type': 'preformatted',
            'data-gjs-name': 'Preformateado',
            'data-gjs-editable': 'false',
            'data-gjs-highlightable': 'true'
          },
          'preformatted-content': 'Texto preformateado\nque mantiene\nel formato original',
          traits: [
            {
              type: 'textarea',
              name: 'preformatted-content',
              label: 'Contenido',
              placeholder: 'Texto preformateado...',
              rows: 6,
              changeProp: 1
            }
          ]
        },
        init() {
          this.on('change:preformatted-content', this.updateContent, this);
          
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
                    tagName !== 'pre')) {
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
          const content = this.get('preformatted-content') || '';
          
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          el.textContent = content;
          
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
          
          const content = this.get('preformatted-content') || '';
          
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
          
          const finalHTML = '<' + tagName + ' class="bg-gray-100 p-4 rounded-lg font-mono text-sm whitespace-pre-wrap"' + (attrsStr ? ' ' + attrsStr : '') + '>' + escapeHtml(content) + '</' + tagName + '>';
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
          
          el.className = 'bg-gray-100 p-4 rounded-lg font-mono text-sm whitespace-pre-wrap';
          
          const content = component.get('preformatted-content') || 'Texto preformateado\nque mantiene\nel formato original';
          el.textContent = content;
          
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
          
          this._preformattedObserver = observer;
        },
        onRemove() {
          if (this._preformattedObserver) {
            this._preformattedObserver.disconnect();
          }
        }
      }
    });
    
  }
  
  if (typeof window !== 'undefined' && window.editor) {
    registerPreformattedComponent(window.editor);
  }
  
  if (typeof window !== 'undefined') {
    window.registerPreformattedComponent = registerPreformattedComponent;
  }
})();
