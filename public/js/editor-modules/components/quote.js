// Módulo del Componente Quote
// Componente de cita/quote estilo Elementor con traits y protección

(function() {
  'use strict';
  
  function registerQuoteComponent(editor) {
    if (!editor || !editor.DomComponents) {
      console.warn('⚠️ Editor no disponible para registrar componente Quote');
      return;
    }
    
    editor.DomComponents.addType('quote', {
      isComponent: (el) => {
        if (!el || typeof el !== 'object' || !el.nodeType) {
          return false;
        }
        
        if (el.tagName === 'BLOCKQUOTE' || (el.classList && el.classList.contains('quote-container'))) {
          return { type: 'quote' };
        }
        if (el.tagName === 'DIV' && el.querySelector && typeof el.querySelector === 'function' && 
            el.querySelector('blockquote')) {
          return { type: 'quote' };
        }
        return false;
      },
      model: {
        defaults: {
          name: 'Cita',
          tagName: 'blockquote',
          editable: false,
          droppable: false,
          removable: true,
          selectable: true,
          hoverable: true,
          highlightable: true,
          badgable: false,
          attributes: {
            class: 'quote-container',
            'data-gjs-type': 'quote',
            'data-gjs-name': 'Cita',
            'data-gjs-editable': 'false',
            'data-gjs-highlightable': 'true'
          },
          'quote-text': 'Esta es una cita inspiradora o importante que quieres destacar en tu contenido.',
          'quote-author': 'Autor de la Cita',
          'quote-style': 'simple',
          'quote-accent-color': '#3b82f6',
          traits: [
            {
              type: 'textarea',
              name: 'quote-text',
              label: 'Texto de la Cita',
              placeholder: 'Texto de la cita...',
              rows: 3,
              changeProp: 1
            },
            {
              type: 'text',
              name: 'quote-author',
              label: 'Autor',
              placeholder: 'Autor de la Cita',
              changeProp: 1
            },
            {
              type: 'select',
              name: 'quote-style',
              label: 'Estilo',
              changeProp: 1,
              options: [
                { value: 'simple', name: 'Simple' },
                { value: 'bordered', name: 'Con Borde' },
                { value: 'boxed', name: 'Caja' }
              ]
            },
            {
              type: 'color',
              name: 'quote-accent-color',
              label: 'Color de Acento',
              changeProp: 1,
              placeholder: '#3b82f6'
            }
          ]
        },
        init() {
          this.on('change:quote-text', this.updateText, this);
          this.on('change:quote-author', this.updateAuthor, this);
          this.on('change:quote-style', this.updateStyle, this);
          this.on('change:quote-accent-color', this.updateColor, this);
          
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
                    tagName !== 'blockquote' && tagName !== 'footer')) {
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
        getStyleClasses(style, accentColor) {
          const styles = {
            simple: {
              classes: 'border-l-4 pl-4 py-2 my-4 italic',
              style: 'border-color: ' + accentColor + ';'
            },
            bordered: {
              classes: 'border-l-4 pl-6 py-4 my-4 italic bg-gray-50 rounded-r-lg',
              style: 'border-color: ' + accentColor + ';'
            },
            boxed: {
              classes: 'border-2 pl-6 py-4 my-4 italic bg-gray-50 rounded-lg',
              style: 'border-color: ' + accentColor + ';'
            }
          };
          return styles[style] || styles.simple;
        },
        updateText() {
          const text = this.get('quote-text') || '';
          
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          const textEl = el.querySelector('.quote-text') || el.querySelector('p');
          
          if (textEl) {
            textEl.textContent = text;
          }
          
          this.view.render();
        },
        updateAuthor() {
          const author = this.get('quote-author') || '';
          
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          const authorEl = el.querySelector('.quote-author') || el.querySelector('footer');
          
          if (authorEl) {
            authorEl.textContent = '— ' + author;
          }
          
          this.view.render();
        },
        updateStyle() {
          if (!this.view || !this.view.el) return;
          this.renderQuote();
          this.view.render();
        },
        updateColor() {
          if (!this.view || !this.view.el) return;
          this.renderQuote();
          this.view.render();
        },
        renderQuote() {
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          const style = this.get('quote-style') || 'simple';
          const accentColor = this.get('quote-accent-color') || '#3b82f6';
          const text = this.get('quote-text') || 'Esta es una cita inspiradora o importante que quieres destacar en tu contenido.';
          const author = this.get('quote-author') || 'Autor de la Cita';
          const styleInfo = this.getStyleClasses(style, accentColor);
          
          el.className = styleInfo.classes + ' italic';
          el.style.cssText = styleInfo.style;
          el.setAttribute('data-gjs-editable', 'false');
          el.setAttribute('data-gjs-selectable', 'false');
          
          let textEl = el.querySelector('.quote-text') || el.querySelector('p');
          if (!textEl) {
            textEl = document.createElement('p');
            textEl.className = 'quote-text text-lg text-gray-700';
            textEl.setAttribute('data-gjs-editable', 'false');
            textEl.setAttribute('data-gjs-selectable', 'false');
            textEl.setAttribute('contenteditable', 'false');
            el.appendChild(textEl);
          }
          textEl.textContent = text;
          
          let authorEl = el.querySelector('.quote-author') || el.querySelector('footer');
          if (!authorEl) {
            authorEl = document.createElement('footer');
            authorEl.className = 'quote-author mt-2 text-sm text-gray-600';
            authorEl.setAttribute('data-gjs-editable', 'false');
            authorEl.setAttribute('data-gjs-selectable', 'false');
            authorEl.setAttribute('contenteditable', 'false');
            el.appendChild(authorEl);
          }
          authorEl.textContent = '— ' + author;
        },
        toHTML() {
          const tagName = this.get('tagName') || 'blockquote';
          const attrs = this.getAttributes();
          let attrsArray = [];
          for (let key in attrs) {
            if (attrs.hasOwnProperty(key) && key !== 'content' && key !== 'class') {
              const val = attrs[key];
              attrsArray.push(`${key}="${String(val).replace(/"/g, '&quot;')}"`);
            }
          }
          const attrsStr = attrsArray.join(' ');
          
          const style = this.get('quote-style') || 'simple';
          const accentColor = this.get('quote-accent-color') || '#3b82f6';
          const text = this.get('quote-text') || '';
          const author = this.get('quote-author') || '';
          const styleInfo = this.getStyleClasses(style, accentColor);
          
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
          innerHTML += '<p class="quote-text text-lg text-gray-700">' + escapeHtml(text) + '</p>';
          if (author) {
            innerHTML += '<footer class="quote-author mt-2 text-sm text-gray-600">— ' + escapeHtml(author) + '</footer>';
          }
          
          const finalHTML = '<' + tagName + ' class="' + styleInfo.classes + ' italic" style="' + styleInfo.style + '"' + (attrsStr ? ' ' + attrsStr : '') + '>' + innerHTML + '</' + tagName + '>';
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
          
          component.renderQuote();
          
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
          
          this._quoteObserver = observer;
        },
        onRemove() {
          if (this._quoteObserver) {
            this._quoteObserver.disconnect();
          }
        }
      }
    });
    
  }
  
  if (typeof window !== 'undefined' && window.editor) {
    registerQuoteComponent(window.editor);
  }
  
  if (typeof window !== 'undefined') {
    window.registerQuoteComponent = registerQuoteComponent;
  }
})();
