// Módulo del Componente Icon List
// Componente de lista con iconos estilo Elementor con traits y protección

(function() {
  'use strict';
  
  function registerIconListComponent(editor) {
    if (!editor || !editor.DomComponents) {
      console.warn('⚠️ Editor no disponible para registrar componente IconList');
      return;
    }
    
    editor.DomComponents.addType('icon-list', {
      isComponent: (el) => {
        if (!el || typeof el !== 'object' || !el.nodeType) {
          return false;
        }
        
        if (el.classList && el.classList.contains('icon-list-container')) {
          return { type: 'icon-list' };
        }
        if (el.tagName === 'DIV' && el.querySelector && typeof el.querySelector === 'function' && 
            el.querySelector('.icon-list')) {
          return { type: 'icon-list' };
        }
        return false;
      },
      model: {
        defaults: {
          name: 'Lista con Iconos',
          tagName: 'div',
          editable: false,
          droppable: false,
          removable: true,
          selectable: true,
          hoverable: true,
          highlightable: true,
          badgable: false,
          attributes: {
            class: 'icon-list-container',
            'data-gjs-type': 'icon-list',
            'data-gjs-name': 'Lista con Iconos',
            'data-gjs-editable': 'false',
            'data-gjs-highlightable': 'true'
          },
          'icon-list-items': JSON.stringify([
            { text: 'Primera característica o beneficio' },
            { text: 'Segunda característica o beneficio' },
            { text: 'Tercera característica o beneficio' },
            { text: 'Cuarta característica o beneficio' }
          ]),
          'icon-list-icon-type': 'check',
          'icon-list-color': '#10b981',
          'icon-list-spacing': 'normal',
          traits: [
            {
              type: 'button',
              name: 'icon-list-manage',
              label: 'Gestionar Items',
              text: 'Editar Items',
              command: 'trait:icon-list-manage',
              full: true
            },
            {
              type: 'select',
              name: 'icon-list-icon-type',
              label: 'Tipo de Icono',
              changeProp: 1,
              options: [
                { value: 'check', name: 'Check' },
                { value: 'star', name: 'Estrella' },
                { value: 'arrow', name: 'Flecha' },
                { value: 'dot', name: 'Punto' },
                { value: 'heart', name: 'Corazón' },
                { value: 'lightning', name: 'Rayo' }
              ]
            },
            {
              type: 'color',
              name: 'icon-list-color',
              label: 'Color de Iconos',
              changeProp: 1,
              placeholder: '#10b981'
            },
            {
              type: 'select',
              name: 'icon-list-spacing',
              label: 'Espaciado',
              changeProp: 1,
              options: [
                { value: 'compact', name: 'Compacto' },
                { value: 'normal', name: 'Normal' },
                { value: 'relaxed', name: 'Relajado' }
              ]
            }
          ]
        },
        init() {
          this.on('change:icon-list-items', this.updateItems, this);
          this.on('change:icon-list-icon-type', this.updateIconType, this);
          this.on('change:icon-list-color', this.updateColor, this);
          this.on('change:icon-list-spacing', this.updateSpacing, this);
          
          // Registrar comando para el botón de gestión
          if (editor.Commands) {
            editor.Commands.add('trait:icon-list-manage', {
              run: (editor, sender, options) => {
                this.openManageModal();
              }
            });
          }
          
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
        getIconPath(type) {
          const icons = {
            check: 'M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z',
            star: 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z',
            arrow: 'M9 5l7 7-7 7',
            dot: 'M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z',
            heart: 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z',
            lightning: 'M13 10V3L4 14h7v7l9-11h-7z'
          };
          return icons[type] || icons.check;
        },
        getSpacingClass(spacing) {
          const spacings = {
            compact: 'space-y-1',
            normal: 'space-y-3',
            relaxed: 'space-y-5'
          };
          return spacings[spacing] || spacings.normal;
        },
        updateItems() {
          if (!this.view || !this.view.el) return;
          this.renderItems();
          this.view.render();
        },
        updateIconType() {
          if (!this.view || !this.view.el) return;
          this.renderItems();
          this.view.render();
        },
        updateColor() {
          if (!this.view || !this.view.el) return;
          this.renderItems();
          this.view.render();
        },
        updateSpacing() {
          if (!this.view || !this.view.el) return;
          this.renderItems();
          this.view.render();
        },
        renderItems(container) {
          if (!container) {
            if (!this.view || !this.view.el) return;
            container = this.view.el;
          }
          
          const items = JSON.parse(this.get('icon-list-items') || '[]');
          const iconType = this.get('icon-list-icon-type') || 'check';
          const color = this.get('icon-list-color') || '#10b981';
          const spacing = this.get('icon-list-spacing') || 'normal';
          const spacingClass = this.getSpacingClass(spacing);
          const iconPath = this.getIconPath(iconType);
          
          let iconList = container.querySelector('.icon-list');
          if (!iconList) {
            iconList = document.createElement('div');
            iconList.className = 'icon-list ' + spacingClass + ' p-6';
            iconList.setAttribute('data-gjs-editable', 'false');
            iconList.setAttribute('data-gjs-selectable', 'false');
            container.appendChild(iconList);
          } else {
            iconList.className = 'icon-list ' + spacingClass + ' p-6';
          }
          
          iconList.innerHTML = '';
          
          items.forEach((item, index) => {
            const itemDiv = document.createElement('div');
            itemDiv.className = 'icon-list-item flex items-center';
            itemDiv.setAttribute('data-gjs-editable', 'false');
            itemDiv.setAttribute('data-gjs-selectable', 'false');
            
            const iconDiv = document.createElement('div');
            iconDiv.className = 'flex-shrink-0 w-6 h-6 mr-3';
            iconDiv.style.setProperty('color', color, 'important');
            iconDiv.setAttribute('data-gjs-editable', 'false');
            iconDiv.setAttribute('data-gjs-selectable', 'false');
            
            const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
            svg.setAttribute('fill', 'currentColor');
            svg.setAttribute('viewBox', '0 0 20 20');
            svg.setAttribute('data-gjs-editable', 'false');
            svg.setAttribute('data-gjs-selectable', 'false');
            
            const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
            if (iconType === 'check') {
              path.setAttribute('fill-rule', 'evenodd');
              path.setAttribute('d', iconPath);
              path.setAttribute('clip-rule', 'evenodd');
            } else {
              path.setAttribute('d', iconPath);
            }
            path.setAttribute('data-gjs-editable', 'false');
            path.setAttribute('data-gjs-selectable', 'false');
            
            svg.appendChild(path);
            iconDiv.appendChild(svg);
            
            const textSpan = document.createElement('span');
            textSpan.className = 'text-gray-700';
            textSpan.setAttribute('data-gjs-editable', 'false');
            textSpan.setAttribute('data-gjs-selectable', 'false');
            textSpan.setAttribute('contenteditable', 'false');
            textSpan.setAttribute('data-item-index', index);
            textSpan.textContent = item.text || '';
            
            itemDiv.appendChild(iconDiv);
            itemDiv.appendChild(textSpan);
            iconList.appendChild(itemDiv);
          });
        },
        openManageModal() {
          const component = this;
          let items = JSON.parse(component.get('icon-list-items') || '[]');
          if (!Array.isArray(items) || items.length === 0) {
            items = [
              { text: 'Primera característica o beneficio' },
              { text: 'Segunda característica o beneficio' },
              { text: 'Tercera característica o beneficio' },
              { text: 'Cuarta característica o beneficio' }
            ];
          }
          
          const modal = document.createElement('div');
          modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
          modal.style.zIndex = '10000';
          
          const modalContent = document.createElement('div');
          modalContent.className = 'bg-white rounded-lg p-6 max-w-2xl w-full max-h-[90vh] overflow-y-auto';
          
          const title = document.createElement('h3');
          title.className = 'text-xl font-bold mb-4';
          title.textContent = 'Gestionar Items de Lista';
          modalContent.appendChild(title);
          
          const itemsContainer = document.createElement('div');
          itemsContainer.className = 'space-y-4';
          
          const renderItems = () => {
            itemsContainer.innerHTML = '';
            
            items.forEach((item, index) => {
              const itemDiv = document.createElement('div');
              itemDiv.className = 'border border-gray-300 rounded p-4';
              itemDiv.setAttribute('data-item-index', index);
              
              const headerDiv = document.createElement('div');
              headerDiv.className = 'flex justify-between items-center mb-2';
              
              const itemLabel = document.createElement('label');
              itemLabel.className = 'block text-sm font-medium';
              itemLabel.textContent = `Item ${index + 1}`;
              
              const controlsDiv = document.createElement('div');
              controlsDiv.className = 'flex gap-2';
              
              const upBtn = document.createElement('button');
              upBtn.type = 'button';
              upBtn.className = 'px-2 py-1 text-xs bg-gray-200 hover:bg-gray-300 rounded';
              upBtn.innerHTML = '↑';
              upBtn.title = 'Mover arriba';
              upBtn.disabled = index === 0;
              upBtn.addEventListener('click', () => {
                if (index > 0) {
                  [items[index], items[index - 1]] = [items[index - 1], items[index]];
                  renderItems();
                }
              });
              
              const downBtn = document.createElement('button');
              downBtn.type = 'button';
              downBtn.className = 'px-2 py-1 text-xs bg-gray-200 hover:bg-gray-300 rounded';
              downBtn.innerHTML = '↓';
              downBtn.title = 'Mover abajo';
              downBtn.disabled = index === items.length - 1;
              downBtn.addEventListener('click', () => {
                if (index < items.length - 1) {
                  [items[index], items[index + 1]] = [items[index + 1], items[index]];
                  renderItems();
                }
              });
              
              const deleteBtn = document.createElement('button');
              deleteBtn.type = 'button';
              deleteBtn.className = 'px-2 py-1 text-xs bg-red-200 hover:bg-red-300 text-red-800 rounded';
              deleteBtn.innerHTML = '✕';
              deleteBtn.title = 'Eliminar';
              deleteBtn.disabled = items.length <= 1;
              deleteBtn.addEventListener('click', () => {
                if (items.length > 1) {
                  items.splice(index, 1);
                  renderItems();
                }
              });
              
              controlsDiv.appendChild(upBtn);
              controlsDiv.appendChild(downBtn);
              controlsDiv.appendChild(deleteBtn);
              headerDiv.appendChild(itemLabel);
              headerDiv.appendChild(controlsDiv);
              
              const textInput = document.createElement('input');
              textInput.type = 'text';
              textInput.className = 'w-full px-3 py-2 border border-gray-300 rounded';
              textInput.placeholder = 'Texto del item';
              textInput.value = item.text || '';
              textInput.addEventListener('input', (e) => {
                items[index].text = e.target.value;
              });
              
              itemDiv.appendChild(headerDiv);
              itemDiv.appendChild(textInput);
              itemsContainer.appendChild(itemDiv);
            });
          };
          
          renderItems();
          
          modalContent.appendChild(itemsContainer);
          
          const addBtnDiv = document.createElement('div');
          addBtnDiv.className = 'mt-4 mb-2';
          const addBtn = document.createElement('button');
          addBtn.type = 'button';
          addBtn.className = 'px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700';
          addBtn.textContent = '+ Agregar Item';
          addBtn.addEventListener('click', () => {
            items.push({
              text: `Item ${items.length + 1}`
            });
            renderItems();
          });
          addBtnDiv.appendChild(addBtn);
          modalContent.appendChild(addBtnDiv);
          
          const buttonsDiv = document.createElement('div');
          buttonsDiv.className = 'flex justify-end gap-2 mt-4';
          
          const cancelBtn = document.createElement('button');
          cancelBtn.className = 'px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300';
          cancelBtn.textContent = 'Cancelar';
          cancelBtn.addEventListener('click', () => {
            document.body.removeChild(modal);
          });
          
          const saveBtn = document.createElement('button');
          saveBtn.className = 'px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700';
          saveBtn.textContent = 'Guardar';
          saveBtn.addEventListener('click', () => {
            component.set('icon-list-items', JSON.stringify(items), { silent: true });
            document.body.removeChild(modal);
            
            setTimeout(() => {
              if (component.view && component.view.el) {
                component.renderItems(component.view.el);
              }
              
              try {
                if (window.editor && window.editor.Canvas) {
                  const iframe = window.editor.Canvas.getFrameEl();
                  if (iframe && iframe.contentDocument) {
                    const iframeEl = iframe.contentDocument.querySelector(`[data-gjs-type="icon-list"]`);
                    if (iframeEl) {
                      component.renderItems(iframeEl);
                    }
                  }
                }
              } catch (e) {
                console.warn('⚠️ No se pudo actualizar iframe:', e);
              }
              
              component.view.render();
            }, 50);
          });
          
          buttonsDiv.appendChild(cancelBtn);
          buttonsDiv.appendChild(saveBtn);
          modalContent.appendChild(buttonsDiv);
          
          modal.appendChild(modalContent);
          document.body.appendChild(modal);
          
          modal.addEventListener('click', (e) => {
            if (e.target === modal) {
              document.body.removeChild(modal);
            }
          });
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
          
          const items = JSON.parse(this.get('icon-list-items') || '[]');
          const iconType = this.get('icon-list-icon-type') || 'check';
          const color = this.get('icon-list-color') || '#10b981';
          const spacing = this.get('icon-list-spacing') || 'normal';
          const spacingClass = this.getSpacingClass(spacing);
          const iconPath = this.getIconPath(iconType);
          
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
          innerHTML += '<div class="icon-list ' + spacingClass + ' p-6">';
          
          items.forEach((item) => {
            innerHTML += '<div class="icon-list-item flex items-center">';
            innerHTML += '<div class="flex-shrink-0 w-6 h-6 mr-3" style="color: ' + color + ';">';
            innerHTML += '<svg fill="currentColor" viewBox="0 0 20 20">';
            if (iconType === 'check') {
              innerHTML += '<path fill-rule="evenodd" d="' + iconPath + '" clip-rule="evenodd"></path>';
            } else {
              innerHTML += '<path d="' + iconPath + '"></path>';
            }
            innerHTML += '</svg>';
            innerHTML += '</div>';
            innerHTML += '<span class="text-gray-700">' + escapeHtml(item.text || '') + '</span>';
            innerHTML += '</div>';
          });
          
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
          
          component.renderItems(el);
          
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
          
          this._iconListObserver = observer;
        },
        onRemove() {
          if (this._iconListObserver) {
            this._iconListObserver.disconnect();
          }
        }
      }
    });
    
  }
  
  if (typeof window !== 'undefined' && window.editor) {
    registerIconListComponent(window.editor);
  }
  
  if (typeof window !== 'undefined') {
    window.registerIconListComponent = registerIconListComponent;
  }
})();
