// Módulo del Componente Alert
// Componente unificado de alerta estilo Elementor con traits y protección

(function() {
  'use strict';
  
  function registerAlertComponent(editor) {
    if (!editor || !editor.DomComponents) {
      console.warn('⚠️ Editor no disponible para registrar componente Alert');
      return;
    }
    
    editor.DomComponents.addType('alert', {
      isComponent: (el) => {
        // Verificar que el sea un elemento DOM válido
        if (!el || typeof el !== 'object' || !el.nodeType) {
          return false;
        }
        
        if (el.classList && el.classList.contains('alert-container')) {
          return { type: 'alert' };
        }
        if (el.tagName === 'DIV' && el.querySelector && typeof el.querySelector === 'function' && el.querySelector('.alert')) {
          return { type: 'alert' };
        }
        return false;
      },
      model: {
        defaults: {
          name: 'Alerta',
          tagName: 'div',
          editable: false,
          droppable: false,
          removable: true,
          selectable: true,
          hoverable: true,
          highlightable: true,
          badgable: false,
          attributes: {
            class: 'alert-container',
            'data-gjs-type': 'alert',
            'data-gjs-name': 'Alerta',
            'data-gjs-editable': 'false',
            'data-gjs-highlightable': 'true'
          },
          'alert-type': 'info',
          'alert-title': 'Título de la Alerta',
          'alert-message': 'Este es un mensaje informativo. Puedes cambiar el estilo y el contenido.',
          'alert-dismissible': true,
          traits: [
            {
              type: 'select',
              name: 'alert-type',
              label: 'Tipo de Alerta',
              changeProp: 1,
              options: [
                { value: 'info', name: 'Información (Azul)' },
                { value: 'success', name: 'Éxito (Verde)' },
                { value: 'warning', name: 'Advertencia (Amarillo)' },
                { value: 'error', name: 'Error (Rojo)' }
              ]
            },
            {
              type: 'text',
              name: 'alert-title',
              label: 'Título',
              placeholder: 'Título de la Alerta',
              changeProp: 1
            },
            {
              type: 'textarea',
              name: 'alert-message',
              label: 'Mensaje',
              placeholder: 'Mensaje de la alerta...',
              rows: 3,
              changeProp: 1
            },
            {
              type: 'checkbox',
              name: 'alert-dismissible',
              label: 'Cerrable',
              changeProp: 1
            }
          ]
        },
        init() {
          this.on('change:alert-type', this.updateType, this);
          this.on('change:alert-title', this.updateTitle, this);
          this.on('change:alert-message', this.updateMessage, this);
          this.on('change:alert-dismissible', this.updateDismissible, this);
          
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
        getAlertStyles(type) {
          const styles = {
            info: {
              bg: 'bg-blue-50',
              border: 'border-blue-500',
              iconColor: 'text-blue-500',
              titleColor: 'text-blue-800',
              messageColor: 'text-blue-700',
              iconPath: 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
            },
            success: {
              bg: 'bg-green-50',
              border: 'border-green-500',
              iconColor: 'text-green-500',
              titleColor: 'text-green-800',
              messageColor: 'text-green-700',
              iconPath: 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'
            },
            warning: {
              bg: 'bg-yellow-50',
              border: 'border-yellow-500',
              iconColor: 'text-yellow-500',
              titleColor: 'text-yellow-800',
              messageColor: 'text-yellow-700',
              iconPath: 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'
            },
            error: {
              bg: 'bg-red-50',
              border: 'border-red-500',
              iconColor: 'text-red-500',
              titleColor: 'text-red-800',
              messageColor: 'text-red-700',
              iconPath: 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z'
            }
          };
          return styles[type] || styles.info;
        },
        updateType() {
          const type = this.get('alert-type') || 'info';
          
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          const alertDiv = el.querySelector('.alert');
          
          if (alertDiv) {
            const styles = this.getAlertStyles(type);
            
            // Actualizar clases
            alertDiv.className = `alert ${styles.bg} border-l-4 ${styles.border} p-4 rounded-lg`;
            
            // Actualizar icono
            const iconSvg = alertDiv.querySelector('svg');
            if (iconSvg) {
              iconSvg.className = `w-6 h-6 ${styles.iconColor}`;
              const path = iconSvg.querySelector('path');
              if (path) {
                path.setAttribute('d', styles.iconPath);
              }
            }
            
            // Actualizar colores del título y mensaje
            const titleEl = alertDiv.querySelector('.alert-title');
            if (titleEl) {
              titleEl.className = `text-sm font-medium ${styles.titleColor}`;
            }
            
            const messageEl = alertDiv.querySelector('.alert-message');
            if (messageEl) {
              messageEl.className = `mt-1 text-sm ${styles.messageColor}`;
            }
            
            // Actualizar color del botón de cerrar si existe
            const closeBtn = alertDiv.querySelector('.alert-close-btn');
            if (closeBtn) {
              const closeSvg = closeBtn.querySelector('svg');
              if (closeSvg) {
                closeSvg.className = `w-5 h-5 ${styles.iconColor} hover:opacity-75`;
              }
            }
          }
          
          this.view.render();
        },
        updateTitle() {
          const title = this.get('alert-title') || 'Título de la Alerta';
          
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          const titleEl = el.querySelector('.alert-title');
          
          if (titleEl) {
            titleEl.textContent = title;
          }
          
          this.view.render();
        },
        updateMessage() {
          const message = this.get('alert-message') || '';
          
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          const messageEl = el.querySelector('.alert-message');
          
          if (messageEl) {
            messageEl.textContent = message;
          }
          
          this.view.render();
        },
        updateDismissible() {
          const dismissible = this.get('alert-dismissible') !== false;
          
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          const alertDiv = el.querySelector('.alert');
          
          if (alertDiv) {
            const closeBtn = alertDiv.querySelector('.alert-close-btn');
            
            if (dismissible && !closeBtn) {
              // Crear botón de cerrar
              const button = document.createElement('button');
              button.className = 'alert-close-btn flex-shrink-0 ml-3';
              button.setAttribute('data-gjs-editable', 'false');
              button.setAttribute('data-gjs-selectable', 'false');
              button.setAttribute('contenteditable', 'false');
              button.type = 'button';
              
              const type = this.get('alert-type') || 'info';
              const styles = this.getAlertStyles(type);
              
              const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
              svg.setAttribute('class', `w-5 h-5 ${styles.iconColor} hover:opacity-75`);
              svg.setAttribute('fill', 'none');
              svg.setAttribute('stroke', 'currentColor');
              svg.setAttribute('viewBox', '0 0 24 24');
              
              const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
              path.setAttribute('stroke-linecap', 'round');
              path.setAttribute('stroke-linejoin', 'round');
              path.setAttribute('stroke-width', '2');
              path.setAttribute('d', 'M6 18L18 6M6 6l12 12');
              
              svg.appendChild(path);
              button.appendChild(svg);
              
              const flexDiv = alertDiv.querySelector('.flex.items-start');
              if (flexDiv) {
                flexDiv.appendChild(button);
              }
            } else if (!dismissible && closeBtn) {
              closeBtn.remove();
            }
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
          
          const type = this.get('alert-type') || 'info';
          const title = this.get('alert-title') || 'Título de la Alerta';
          const message = this.get('alert-message') || '';
          const dismissible = this.get('alert-dismissible') !== false;
          
          const styles = this.getAlertStyles(type);
          
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
          
          let innerHTML = '';
          innerHTML += '<div class="alert ' + styles.bg + ' border-l-4 ' + styles.border + ' p-4 rounded-lg" role="alert">';
          innerHTML += '<div class="flex items-start">';
          innerHTML += '<div class="flex-shrink-0">';
          innerHTML += '<svg class="w-6 h-6 ' + styles.iconColor + '" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
          innerHTML += '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="' + styles.iconPath + '"></path>';
          innerHTML += '</svg>';
          innerHTML += '</div>';
          innerHTML += '<div class="ml-3 flex-1">';
          innerHTML += '<h3 class="alert-title text-sm font-medium ' + styles.titleColor + '">' + escapeHtml(title) + '</h3>';
          innerHTML += '<p class="alert-message mt-1 text-sm ' + styles.messageColor + '">' + escapeHtml(message) + '</p>';
          innerHTML += '</div>';
          
          if (dismissible) {
            innerHTML += '<button type="button" class="alert-close-btn flex-shrink-0 ml-3" onclick="this.closest(\'.alert\').remove()">';
            innerHTML += '<svg class="w-5 h-5 ' + styles.iconColor + ' hover:opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
            innerHTML += '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>';
            innerHTML += '</svg>';
            innerHTML += '</button>';
          }
          
          innerHTML += '</div>';
          innerHTML += '</div>';
          
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
          
          // Asegurar estructura de la alerta
          let alertDiv = el.querySelector('.alert');
          
          if (!alertDiv) {
            const type = component.get('alert-type') || 'info';
            const title = component.get('alert-title') || 'Título de la Alerta';
            const message = component.get('alert-message') || 'Este es un mensaje informativo.';
            const dismissible = component.get('alert-dismissible') !== false;
            
            const styles = component.getAlertStyles(type);
            
            alertDiv = document.createElement('div');
            alertDiv.className = `alert ${styles.bg} border-l-4 ${styles.border} p-4 rounded-lg`;
            alertDiv.setAttribute('role', 'alert');
            alertDiv.setAttribute('data-gjs-editable', 'false');
            alertDiv.setAttribute('data-gjs-selectable', 'false');
            
            const flexDiv = document.createElement('div');
            flexDiv.className = 'flex items-start';
            flexDiv.setAttribute('data-gjs-editable', 'false');
            flexDiv.setAttribute('data-gjs-selectable', 'false');
            
            // Icono
            const iconDiv = document.createElement('div');
            iconDiv.className = 'flex-shrink-0';
            iconDiv.setAttribute('data-gjs-editable', 'false');
            iconDiv.setAttribute('data-gjs-selectable', 'false');
            
            const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
            svg.setAttribute('class', `w-6 h-6 ${styles.iconColor}`);
            svg.setAttribute('fill', 'none');
            svg.setAttribute('stroke', 'currentColor');
            svg.setAttribute('viewBox', '0 0 24 24');
            svg.setAttribute('data-gjs-editable', 'false');
            svg.setAttribute('data-gjs-selectable', 'false');
            
            const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
            path.setAttribute('stroke-linecap', 'round');
            path.setAttribute('stroke-linejoin', 'round');
            path.setAttribute('stroke-width', '2');
            path.setAttribute('d', styles.iconPath);
            path.setAttribute('data-gjs-editable', 'false');
            path.setAttribute('data-gjs-selectable', 'false');
            
            svg.appendChild(path);
            iconDiv.appendChild(svg);
            
            // Contenido
            const contentDiv = document.createElement('div');
            contentDiv.className = 'ml-3 flex-1';
            contentDiv.setAttribute('data-gjs-editable', 'false');
            contentDiv.setAttribute('data-gjs-selectable', 'false');
            
            const titleEl = document.createElement('h3');
            titleEl.className = `alert-title text-sm font-medium ${styles.titleColor}`;
            titleEl.setAttribute('data-gjs-editable', 'false');
            titleEl.setAttribute('data-gjs-selectable', 'false');
            titleEl.setAttribute('contenteditable', 'false');
            titleEl.textContent = title;
            
            const messageEl = document.createElement('p');
            messageEl.className = `alert-message mt-1 text-sm ${styles.messageColor}`;
            messageEl.setAttribute('data-gjs-editable', 'false');
            messageEl.setAttribute('data-gjs-selectable', 'false');
            messageEl.setAttribute('contenteditable', 'false');
            messageEl.textContent = message;
            
            contentDiv.appendChild(titleEl);
            contentDiv.appendChild(messageEl);
            
            flexDiv.appendChild(iconDiv);
            flexDiv.appendChild(contentDiv);
            
            // Botón de cerrar si es cerrable
            if (dismissible) {
              const button = document.createElement('button');
              button.className = 'alert-close-btn flex-shrink-0 ml-3';
              button.setAttribute('data-gjs-editable', 'false');
              button.setAttribute('data-gjs-selectable', 'false');
              button.setAttribute('contenteditable', 'false');
              button.type = 'button';
              
              const closeSvg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
              closeSvg.setAttribute('class', `w-5 h-5 ${styles.iconColor} hover:opacity-75`);
              closeSvg.setAttribute('fill', 'none');
              closeSvg.setAttribute('stroke', 'currentColor');
              closeSvg.setAttribute('viewBox', '0 0 24 24');
              closeSvg.setAttribute('data-gjs-editable', 'false');
              closeSvg.setAttribute('data-gjs-selectable', 'false');
              
              const closePath = document.createElementNS('http://www.w3.org/2000/svg', 'path');
              closePath.setAttribute('stroke-linecap', 'round');
              closePath.setAttribute('stroke-linejoin', 'round');
              closePath.setAttribute('stroke-width', '2');
              closePath.setAttribute('d', 'M6 18L18 6M6 6l12 12');
              closePath.setAttribute('data-gjs-editable', 'false');
              closePath.setAttribute('data-gjs-selectable', 'false');
              
              closeSvg.appendChild(closePath);
              button.appendChild(closeSvg);
              flexDiv.appendChild(button);
            }
            
            alertDiv.appendChild(flexDiv);
            el.appendChild(alertDiv);
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
          
          this._alertObserver = observer;
        },
        onRemove() {
          if (this._alertObserver) {
            this._alertObserver.disconnect();
          }
        }
      }
    });
    
  }
  
  // Auto-registrar si el editor está disponible
  if (typeof window !== 'undefined' && window.editor) {
    registerAlertComponent(window.editor);
  }
  
  // Exportar para registro manual
  if (typeof window !== 'undefined') {
    window.registerAlertComponent = registerAlertComponent;
  }
})();
