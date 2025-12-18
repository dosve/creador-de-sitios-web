// Módulo del Componente Counter Animated
// Componente de contador animado estilo Elementor con traits y protección

(function() {
  'use strict';
  
  function registerCounterAnimatedComponent(editor) {
    if (!editor || !editor.DomComponents) {
      console.warn('⚠️ Editor no disponible para registrar componente CounterAnimated');
      return;
    }
    
    editor.DomComponents.addType('counter-animated', {
      isComponent: (el) => {
        // Verificar que el sea un elemento DOM válido
        if (!el || typeof el !== 'object' || !el.nodeType) {
          return false;
        }
        
        if (el.classList && el.classList.contains('counter-container')) {
          return { type: 'counter-animated' };
        }
        if (el.tagName === 'DIV' && el.querySelector && typeof el.querySelector === 'function' && 
            (el.querySelector('.counter-block') || el.querySelector('.counter-number'))) {
          return { type: 'counter-animated' };
        }
        return false;
      },
      model: {
        defaults: {
          name: 'Contador Animado',
          tagName: 'div',
          editable: false,
          droppable: false,
          removable: true,
          selectable: true,
          hoverable: true,
          highlightable: true,
          badgable: false,
          attributes: {
            class: 'counter-container',
            'data-gjs-type': 'counter-animated',
            'data-gjs-name': 'Contador Animado',
            'data-gjs-editable': 'false',
            'data-gjs-highlightable': 'true'
          },
          'counter-target': 1000,
          'counter-prefix': '',
          'counter-suffix': '+',
          'counter-label': 'Clientes Satisfechos',
          'counter-duration': 2000,
          'counter-icon-type': 'chart',
          'counter-icon-color': '#2563eb',
          'counter-icon-bg-color': '#dbeafe',
          traits: [
            {
              type: 'number',
              name: 'counter-target',
              label: 'Número Objetivo',
              changeProp: 1,
              placeholder: '1000',
              min: 0,
              step: 1
            },
            {
              type: 'text',
              name: 'counter-prefix',
              label: 'Prefijo',
              changeProp: 1,
              placeholder: '$'
            },
            {
              type: 'text',
              name: 'counter-suffix',
              label: 'Sufijo',
              changeProp: 1,
              placeholder: '+'
            },
            {
              type: 'text',
              name: 'counter-label',
              label: 'Etiqueta',
              changeProp: 1,
              placeholder: 'Clientes Satisfechos'
            },
            {
              type: 'select',
              name: 'counter-duration',
              label: 'Duración de Animación',
              changeProp: 1,
              options: [
                { value: '1000', name: '1 segundo' },
                { value: '2000', name: '2 segundos' },
                { value: '3000', name: '3 segundos' },
                { value: '4000', name: '4 segundos' },
                { value: '5000', name: '5 segundos' }
              ]
            },
            {
              type: 'select',
              name: 'counter-icon-type',
              label: 'Tipo de Icono',
              changeProp: 1,
              options: [
                { value: 'chart', name: 'Gráfico' },
                { value: 'users', name: 'Usuarios' },
                { value: 'star', name: 'Estrella' },
                { value: 'heart', name: 'Corazón' },
                { value: 'check', name: 'Check' },
                { value: 'shield', name: 'Escudo' },
                { value: 'clock', name: 'Reloj' },
                { value: 'globe', name: 'Globo' },
                { value: 'rocket', name: 'Cohete' },
                { value: 'lightning', name: 'Rayo' }
              ]
            },
            {
              type: 'color',
              name: 'counter-icon-color',
              label: 'Color del Icono',
              changeProp: 1,
              placeholder: '#2563eb'
            },
            {
              type: 'color',
              name: 'counter-icon-bg-color',
              label: 'Color de Fondo del Icono',
              changeProp: 1,
              placeholder: '#dbeafe'
            }
          ]
        },
        init() {
          this.on('change:counter-target', this.updateCounter, this);
          this.on('change:counter-prefix', this.updateCounter, this);
          this.on('change:counter-suffix', this.updateCounter, this);
          this.on('change:counter-label', this.updateLabel, this);
          this.on('change:counter-duration', this.updateCounter, this);
          this.on('change:counter-icon-type', this.updateIcon, this);
          this.on('change:counter-icon-color', this.updateIconColors, this);
          this.on('change:counter-icon-bg-color', this.updateIconColors, this);
          
          // Proteger TODOS los elementos internos
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
                // Ignorar errores al proteger componentes individuales
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
              // Ignorar errores generales de protección
            }
          };
          
          setTimeout(protectElements, 100);
          this.on('component:mount', protectElements);
          this.on('component:add', () => {
            setTimeout(protectElements, 100);
          });
        },
        getIconPath(type) {
          const icons = {
            chart: 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
            users: 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
            star: 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z',
            heart: 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z',
            check: 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
            shield: 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
            clock: 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
            globe: 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
            rocket: 'M13 10V3L4 14h7v7l9-11h-7z',
            lightning: 'M13 10V3L4 14h7v7l9-11h-7z'
          };
          return icons[type] || icons.chart;
        },
        updateCounter() {
          if (!this.view || !this.view.el) return;
          
          const target = this.get('counter-target') || 1000;
          const prefix = this.get('counter-prefix') || '';
          const suffix = this.get('counter-suffix') || '';
          
          const el = this.view.el;
          const counterNumber = el.querySelector('.counter-number');
          const valueSpan = el.querySelector('.counter-value');
          const prefixSpan = el.querySelector('.counter-prefix');
          const suffixSpan = el.querySelector('.counter-suffix');
          
          if (counterNumber) {
            counterNumber.setAttribute('data-target', target);
          }
          
          if (valueSpan) {
            valueSpan.textContent = target;
          }
          
          if (prefixSpan) {
            prefixSpan.textContent = prefix;
            prefixSpan.style.display = prefix ? 'inline' : 'none';
          }
          
          if (suffixSpan) {
            suffixSpan.textContent = suffix;
            suffixSpan.style.display = suffix ? 'inline' : 'none';
          }
          
          this.view.render();
        },
        updateLabel() {
          const label = this.get('counter-label') || '';
          
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          const labelEl = el.querySelector('.counter-label');
          
          if (labelEl) {
            labelEl.textContent = label;
          }
          
          this.view.render();
        },
        updateIcon() {
          if (!this.view || !this.view.el) return;
          
          const type = this.get('counter-icon-type') || 'chart';
          const iconPath = this.getIconPath(type);
          
          const el = this.view.el;
          const iconSvg = el.querySelector('.counter-icon svg path');
          
          if (iconSvg) {
            iconSvg.setAttribute('d', iconPath);
          }
          
          this.view.render();
        },
        updateIconColors() {
          if (!this.view || !this.view.el) return;
          
          const color = this.get('counter-icon-color') || '#2563eb';
          const bgColor = this.get('counter-icon-bg-color') || '#dbeafe';
          
          const el = this.view.el;
          const iconWrapper = el.querySelector('.counter-icon');
          const iconSvg = el.querySelector('.counter-icon svg');
          
          if (iconWrapper) {
            iconWrapper.style.setProperty('background-color', bgColor, 'important');
          }
          
          if (iconSvg) {
            iconSvg.style.setProperty('color', color, 'important');
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
          
          const target = this.get('counter-target') || 1000;
          const prefix = this.get('counter-prefix') || '';
          const suffix = this.get('counter-suffix') || '';
          const label = this.get('counter-label') || 'Clientes Satisfechos';
          const duration = parseInt(this.get('counter-duration')) || 2000;
          const iconType = this.get('counter-icon-type') || 'chart';
          const iconColor = this.get('counter-icon-color') || '#2563eb';
          const iconBgColor = this.get('counter-icon-bg-color') || '#dbeafe';
          const iconPath = this.getIconPath(iconType);
          
          // Escapar HTML
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
          
          // Generar ID único para este contador
          const counterId = 'counter-' + Date.now() + '-' + Math.random().toString(36).substr(2, 9);
          
          let innerHTML = '';
          innerHTML += '<div class="counter-block text-center p-6">';
          
          // Icono
          innerHTML += '<div class="counter-icon inline-flex items-center justify-center w-20 h-20 mb-4 rounded-full" style="background-color: ' + iconBgColor + ';">';
          innerHTML += '<svg class="w-10 h-10" style="color: ' + iconColor + ';" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
          innerHTML += '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="' + iconPath + '"></path>';
          innerHTML += '</svg>';
          innerHTML += '</div>';
          
          // Número con prefijo y sufijo
          innerHTML += '<div class="counter-number text-4xl font-bold text-gray-900 mb-2" data-counter-id="' + counterId + '" data-target="' + target + '">';
          if (prefix) {
            innerHTML += '<span class="counter-prefix">' + escapeHtml(prefix) + '</span>';
          }
          innerHTML += '<span class="counter-value">' + target + '</span>';
          if (suffix) {
            innerHTML += '<span class="counter-suffix text-blue-600">' + escapeHtml(suffix) + '</span>';
          }
          innerHTML += '</div>';
          
          // Etiqueta
          innerHTML += '<p class="counter-label text-gray-600">' + escapeHtml(label) + '</p>';
          innerHTML += '</div>';
          
          // JavaScript para la animación en la página final
          innerHTML += '<script>';
          innerHTML += '(function() {';
          innerHTML += '  function initCounter() {';
          innerHTML += '    const counterEl = document.querySelector(\'[data-counter-id="' + counterId + '"]\');';
          innerHTML += '    if (!counterEl || counterEl.dataset.animated) return;';
          innerHTML += '    counterEl.dataset.animated = \'true\';';
          innerHTML += '    ';
          innerHTML += '    const target = parseInt(counterEl.getAttribute(\'data-target\')) || 0;';
          innerHTML += '    const duration = ' + duration + ';';
          innerHTML += '    const increment = target / (duration / 16);';
          innerHTML += '    let current = 0;';
          innerHTML += '    ';
          innerHTML += '    const observer = new IntersectionObserver(function(entries) {';
          innerHTML += '      entries.forEach(function(entry) {';
          innerHTML += '        if (entry.isIntersecting) {';
          innerHTML += '          const valueSpan = counterEl.querySelector(\'.counter-value\');';
          innerHTML += '          ';
          innerHTML += '          function animate() {';
          innerHTML += '            current += increment;';
          innerHTML += '            if (current < target) {';
          innerHTML += '              if (valueSpan) {';
          innerHTML += '                valueSpan.textContent = Math.floor(current);';
          innerHTML += '              }';
          innerHTML += '              requestAnimationFrame(animate);';
          innerHTML += '            } else {';
          innerHTML += '              if (valueSpan) {';
          innerHTML += '                valueSpan.textContent = target;';
          innerHTML += '              }';
          innerHTML += '            }';
          innerHTML += '          }';
          innerHTML += '          ';
          innerHTML += '          animate();';
          innerHTML += '          observer.unobserve(counterEl);';
          innerHTML += '        }';
          innerHTML += '      });';
          innerHTML += '    }, { threshold: 0.5 });';
          innerHTML += '    ';
          innerHTML += '    observer.observe(counterEl);';
          innerHTML += '  }';
          innerHTML += '  ';
          innerHTML += '  if (document.readyState === \'loading\') {';
          innerHTML += '    document.addEventListener(\'DOMContentLoaded\', initCounter);';
          innerHTML += '  } else {';
          innerHTML += '    initCounter();';
          innerHTML += '  }';
          innerHTML += '})();';
          innerHTML += '</script>';
          
          const finalHTML = '<' + tagName + (attrsStr ? ' ' + attrsStr : '') + '>' + innerHTML + '</' + tagName + '>';
          return finalHTML;
        }
      },
      view: {
        onRender() {
          const el = this.el;
          const component = this.model;
          
          // Proteger el contenedor principal pero mantenerlo seleccionable
          el.setAttribute('contenteditable', 'false');
          el.setAttribute('data-gjs-editable', 'false');
          el.setAttribute('data-gjs-selectable', 'true');
          el.setAttribute('data-gjs-highlightable', 'true');
          el.setAttribute('data-gjs-hoverable', 'true');
          
          // Asegurar estructura del contador
          let counterBlock = el.querySelector('.counter-block');
          
          if (!counterBlock) {
            const target = component.get('counter-target') || 1000;
            const prefix = component.get('counter-prefix') || '';
            const suffix = component.get('counter-suffix') || '+';
            const label = component.get('counter-label') || 'Clientes Satisfechos';
            const iconType = component.get('counter-icon-type') || 'chart';
            const iconColor = component.get('counter-icon-color') || '#2563eb';
            const iconBgColor = component.get('counter-icon-bg-color') || '#dbeafe';
            const iconPath = component.getIconPath(iconType);
            
            counterBlock = document.createElement('div');
            counterBlock.className = 'counter-block text-center p-6';
            counterBlock.setAttribute('data-gjs-editable', 'false');
            counterBlock.setAttribute('data-gjs-selectable', 'false');
            
            // Icono
            const iconWrapper = document.createElement('div');
            iconWrapper.className = 'counter-icon inline-flex items-center justify-center w-20 h-20 mb-4 rounded-full';
            iconWrapper.style.setProperty('background-color', iconBgColor, 'important');
            iconWrapper.setAttribute('data-gjs-editable', 'false');
            iconWrapper.setAttribute('data-gjs-selectable', 'false');
            
            const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
            svg.setAttribute('class', 'w-10 h-10');
            svg.style.setProperty('color', iconColor, 'important');
            svg.setAttribute('fill', 'none');
            svg.setAttribute('stroke', 'currentColor');
            svg.setAttribute('viewBox', '0 0 24 24');
            svg.setAttribute('data-gjs-editable', 'false');
            svg.setAttribute('data-gjs-selectable', 'false');
            
            const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
            path.setAttribute('stroke-linecap', 'round');
            path.setAttribute('stroke-linejoin', 'round');
            path.setAttribute('stroke-width', '2');
            path.setAttribute('d', iconPath);
            path.setAttribute('data-gjs-editable', 'false');
            path.setAttribute('data-gjs-selectable', 'false');
            
            svg.appendChild(path);
            iconWrapper.appendChild(svg);
            
            // Número
            const counterNumber = document.createElement('div');
            counterNumber.className = 'counter-number text-4xl font-bold text-gray-900 mb-2';
            counterNumber.setAttribute('data-target', target);
            counterNumber.setAttribute('data-gjs-editable', 'false');
            counterNumber.setAttribute('data-gjs-selectable', 'false');
            
            if (prefix) {
              const prefixSpan = document.createElement('span');
              prefixSpan.className = 'counter-prefix';
              prefixSpan.setAttribute('data-gjs-editable', 'false');
              prefixSpan.setAttribute('data-gjs-selectable', 'false');
              prefixSpan.setAttribute('contenteditable', 'false');
              prefixSpan.textContent = prefix;
              counterNumber.appendChild(prefixSpan);
            }
            
            const valueSpan = document.createElement('span');
            valueSpan.className = 'counter-value';
            valueSpan.setAttribute('data-gjs-editable', 'false');
            valueSpan.setAttribute('data-gjs-selectable', 'false');
            valueSpan.setAttribute('contenteditable', 'false');
            valueSpan.textContent = target;
            counterNumber.appendChild(valueSpan);
            
            if (suffix) {
              const suffixSpan = document.createElement('span');
              suffixSpan.className = 'counter-suffix text-blue-600';
              suffixSpan.setAttribute('data-gjs-editable', 'false');
              suffixSpan.setAttribute('data-gjs-selectable', 'false');
              suffixSpan.setAttribute('contenteditable', 'false');
              suffixSpan.textContent = suffix;
              counterNumber.appendChild(suffixSpan);
            }
            
            // Etiqueta
            const labelEl = document.createElement('p');
            labelEl.className = 'counter-label text-gray-600';
            labelEl.setAttribute('data-gjs-editable', 'false');
            labelEl.setAttribute('data-gjs-selectable', 'false');
            labelEl.setAttribute('contenteditable', 'false');
            labelEl.textContent = label;
            
            counterBlock.appendChild(iconWrapper);
            counterBlock.appendChild(counterNumber);
            counterBlock.appendChild(labelEl);
            el.appendChild(counterBlock);
          }
          
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
          
          this._counterObserver = observer;
        },
        onRemove() {
          if (this._counterObserver) {
            this._counterObserver.disconnect();
          }
        }
      }
    });
    
  }
  
  // Auto-registrar si el editor está disponible
  if (typeof window !== 'undefined' && window.editor) {
    registerCounterAnimatedComponent(window.editor);
  }
  
  // Exportar para registro manual
  if (typeof window !== 'undefined') {
    window.registerCounterAnimatedComponent = registerCounterAnimatedComponent;
  }
})();
