// Módulo del Componente Star Rating
// Componente de calificación con estrellas estilo Elementor con traits y protección

(function() {
  'use strict';
  
  function registerStarRatingComponent(editor) {
    if (!editor || !editor.DomComponents) {
      console.warn('⚠️ Editor no disponible para registrar componente StarRating');
      return;
    }
    
    editor.DomComponents.addType('star-rating', {
      isComponent: (el) => {
        if (!el || typeof el !== 'object' || !el.nodeType) {
          return false;
        }
        
        if (el.classList && el.classList.contains('star-rating-container')) {
          return { type: 'star-rating' };
        }
        if (el.tagName === 'DIV' && el.querySelector && typeof el.querySelector === 'function' && 
            el.querySelector('.star-rating')) {
          return { type: 'star-rating' };
        }
        return false;
      },
      model: {
        defaults: {
          name: 'Calificación con Estrellas',
          tagName: 'div',
          editable: false,
          droppable: false,
          removable: true,
          selectable: true,
          hoverable: true,
          highlightable: true,
          badgable: false,
          attributes: {
            class: 'star-rating-container',
            'data-gjs-type': 'star-rating',
            'data-gjs-name': 'Calificación con Estrellas',
            'data-gjs-editable': 'false',
            'data-gjs-highlightable': 'true'
          },
          'star-rating-value': 5,
          'star-rating-size': 'medium',
          'star-rating-color': '#fbbf24',
          traits: [
            {
              type: 'select',
              name: 'star-rating-value',
              label: 'Calificación',
              changeProp: 1,
              options: [
                { value: '5', name: '5 Estrellas' },
                { value: '4.5', name: '4.5 Estrellas' },
                { value: '4', name: '4 Estrellas' },
                { value: '3.5', name: '3.5 Estrellas' },
                { value: '3', name: '3 Estrellas' },
                { value: '2.5', name: '2.5 Estrellas' },
                { value: '2', name: '2 Estrellas' },
                { value: '1.5', name: '1.5 Estrellas' },
                { value: '1', name: '1 Estrella' }
              ]
            },
            {
              type: 'select',
              name: 'star-rating-size',
              label: 'Tamaño',
              changeProp: 1,
              options: [
                { value: 'small', name: 'Pequeño' },
                { value: 'medium', name: 'Mediano' },
                { value: 'large', name: 'Grande' }
              ]
            },
            {
              type: 'color',
              name: 'star-rating-color',
              label: 'Color de Estrellas',
              changeProp: 1,
              placeholder: '#fbbf24'
            }
          ]
        },
        init() {
          this.on('change:star-rating-value', this.updateRating, this);
          this.on('change:star-rating-size', this.updateSize, this);
          this.on('change:star-rating-color', this.updateColor, this);
          
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
        getSizeClass(size) {
          const sizes = {
            small: 'text-lg',
            medium: 'text-2xl',
            large: 'text-4xl'
          };
          return sizes[size] || sizes.medium;
        },
        updateRating() {
          if (!this.view || !this.view.el) return;
          this.renderStars();
          this.view.render();
        },
        updateSize() {
          if (!this.view || !this.view.el) return;
          this.renderStars();
          this.view.render();
        },
        updateColor() {
          if (!this.view || !this.view.el) return;
          this.renderStars();
          this.view.render();
        },
        renderStars() {
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          let starRating = el.querySelector('.star-rating');
          
          if (!starRating) {
            starRating = document.createElement('div');
            starRating.className = 'star-rating flex items-center p-4';
            starRating.setAttribute('data-gjs-editable', 'false');
            starRating.setAttribute('data-gjs-selectable', 'false');
            el.appendChild(starRating);
          }
          
          const value = parseFloat(this.get('star-rating-value')) || 5;
          const size = this.get('star-rating-size') || 'medium';
          const color = this.get('star-rating-color') || '#fbbf24';
          const sizeClass = this.getSizeClass(size);
          
          starRating.innerHTML = '';
          
          const starsDiv = document.createElement('div');
          starsDiv.className = 'flex ' + sizeClass + ' mr-2';
          starsDiv.style.setProperty('color', color, 'important');
          starsDiv.setAttribute('data-gjs-editable', 'false');
          starsDiv.setAttribute('data-gjs-selectable', 'false');
          
          for (let i = 1; i <= 5; i++) {
            const starSpan = document.createElement('span');
            if (i <= Math.floor(value)) {
              starSpan.textContent = '★';
            } else if (i - 0.5 <= value) {
              starSpan.textContent = '☆';
            } else {
              starSpan.textContent = '☆';
              starSpan.style.opacity = '0.3';
            }
            starSpan.setAttribute('data-gjs-editable', 'false');
            starSpan.setAttribute('data-gjs-selectable', 'false');
            starsDiv.appendChild(starSpan);
          }
          
          const textSpan = document.createElement('span');
          textSpan.className = 'text-sm text-gray-600';
          textSpan.setAttribute('data-gjs-editable', 'false');
          textSpan.setAttribute('data-gjs-selectable', 'false');
          textSpan.setAttribute('contenteditable', 'false');
          textSpan.textContent = '(' + value + ' de 5)';
          
          starRating.appendChild(starsDiv);
          starRating.appendChild(textSpan);
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
          
          const value = parseFloat(this.get('star-rating-value')) || 5;
          const size = this.get('star-rating-size') || 'medium';
          const color = this.get('star-rating-color') || '#fbbf24';
          const sizeClass = this.getSizeClass(size);
          
          let innerHTML = '';
          innerHTML += '<div class="star-rating flex items-center p-4">';
          innerHTML += '<div class="flex ' + sizeClass + ' mr-2" style="color: ' + color + ';">';
          
          for (let i = 1; i <= 5; i++) {
            if (i <= Math.floor(value)) {
              innerHTML += '<span>★</span>';
            } else if (i - 0.5 <= value) {
              innerHTML += '<span>☆</span>';
            } else {
              innerHTML += '<span style="opacity: 0.3;">☆</span>';
            }
          }
          
          innerHTML += '</div>';
          innerHTML += '<span class="text-sm text-gray-600">(' + value + ' de 5)</span>';
          innerHTML += '</div>';
          
          const finalHTML = '<' + tagName + (attrsStr ? ' ' + attrsStr : '') + '>' + innerHTML + '</' + tagName + '>';
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
          
          component.renderStars();
          
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
          
          this._starRatingObserver = observer;
        },
        onRemove() {
          if (this._starRatingObserver) {
            this._starRatingObserver.disconnect();
          }
        }
      }
    });
    
  }
  
  if (typeof window !== 'undefined' && window.editor) {
    registerStarRatingComponent(window.editor);
  }
  
  if (typeof window !== 'undefined') {
    window.registerStarRatingComponent = registerStarRatingComponent;
  }
})();
