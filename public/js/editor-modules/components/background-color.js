// Módulo del Componente Background Color
// Componente de sección con color de fondo sólido y contenido superpuesto

(function () {
  'use strict';

  function registerBackgroundColorComponent(editor) {
    if (!editor || !editor.DomComponents) {
      return;
    }

    editor.DomComponents.addType('background-color', {
      isComponent: (el) => {
        if (el.tagName === 'DIV' && (
          el.classList.contains('background-color-section') ||
          el.getAttribute('data-gjs-type') === 'background-color'
        )) {
          return { type: 'background-color' };
        }
        return false;
      },
      model: {
        defaults: {
          name: 'Color de Fondo',
          draggable: true,
          droppable: true,
          selectable: true,
          editable: false,
          removable: true,
          copyable: true,
          badgable: true,
          stylable: true,
          highlightable: true,
          toolbar: true,
          resizable: false,
          layerable: true,
          attributes: {
            'data-gjs-type': 'background-color',
            'data-gjs-name': 'Color de Fondo',
            'data-gjs-editable': 'false',
            'data-gjs-removable': 'true',
            'data-gjs-badgable': 'true'
          },
          'background-color': '#2563eb',
          'height': '384',
          'content-title': 'Contenido sobre Color',
          'content-text': 'Texto superpuesto sobre el color de fondo',
          'button-text': 'Botón de Acción',
          'button-link': '#',
          'title-color': '#ffffff',
          'text-color': '#ffffff',
          'button-bg-color': '#ffffff',
          'button-text-color': '#111827',
          traits: [
            {
              type: 'color',
              name: 'background-color',
              label: 'Color de Fondo',
              changeProp: 1,
              placeholder: '#2563eb'
            },
            {
              type: 'text',
              name: 'height',
              label: 'Altura (px)',
              placeholder: '384',
              changeProp: 1
            },
            {
              type: 'text',
              name: 'content-title',
              label: 'Título',
              placeholder: 'Contenido sobre Color',
              changeProp: 1
            },
            {
              type: 'text',
              name: 'content-text',
              label: 'Texto',
              placeholder: 'Texto superpuesto sobre el color de fondo',
              changeProp: 1
            },
            {
              type: 'text',
              name: 'button-text',
              label: 'Texto del Botón',
              placeholder: 'Botón de Acción',
              changeProp: 1
            },
            {
              type: 'text',
              name: 'button-link',
              label: 'Enlace del Botón',
              placeholder: '#',
              changeProp: 1
            },
            {
              type: 'color',
              name: 'title-color',
              label: 'Color del Título',
              changeProp: 1
            },
            {
              type: 'color',
              name: 'text-color',
              label: 'Color del Texto',
              changeProp: 1
            },
            {
              type: 'color',
              name: 'button-bg-color',
              label: 'Color de Fondo del Botón',
              changeProp: 1
            },
            {
              type: 'color',
              name: 'button-text-color',
              label: 'Color del Texto del Botón',
              changeProp: 1
            }
          ]
        },
        init() {
          this.set('removable', true, { silent: true });

          // Flag para evitar actualizaciones múltiples simultáneas
          this._isUpdating = false;

          this.on('component:selected', () => {
            if (this._isUpdating) return;
            this._isUpdating = true;

            if (this.view && this.view.el) {
              const el = this.view.el;

              // Establecer propiedades una sola vez
              this.set({
                removable: true,
                selectable: true,
                draggable: true,
                droppable: true,
                highlightable: true,
                toolbar: true,
                layerable: true,
                copyable: true,
                badgable: true
              }, { silent: false });

              // Establecer atributos DOM una sola vez
              el.setAttribute('data-gjs-removable', 'true');
              el.setAttribute('data-gjs-selectable', 'true');
              el.setAttribute('data-gjs-draggable', 'true');
              el.setAttribute('data-gjs-droppable', 'true');
              el.setAttribute('data-gjs-highlightable', 'true');
              el.setAttribute('data-gjs-toolbar', 'true');
              el.setAttribute('data-gjs-layerable', 'true');
              el.setAttribute('data-gjs-copyable', 'true');
              el.setAttribute('data-gjs-badgable', 'true');
              el.setAttribute('data-gjs-name', 'Color de Fondo');
            }

            setTimeout(() => {
              this._isUpdating = false;
            }, 100);
          });

          this.on('component:mount', () => {
            // Configurar todas las propiedades inmediatamente cuando se monta
            this.set({
              removable: true,
              selectable: true,
              draggable: true,
              droppable: true,
              highlightable: true,
              toolbar: true,
              layerable: true,
              copyable: true,
              badgable: true
            }, { silent: false });

            if (this.view && this.view.el) {
              const el = this.view.el;
              el.setAttribute('data-gjs-removable', 'true');
              el.setAttribute('data-gjs-selectable', 'true');
              el.setAttribute('data-gjs-draggable', 'true');
              el.setAttribute('data-gjs-droppable', 'true');
              el.setAttribute('data-gjs-highlightable', 'true');
              el.setAttribute('data-gjs-toolbar', 'true');
              el.setAttribute('data-gjs-layerable', 'true');
              el.setAttribute('data-gjs-copyable', 'true');
              el.setAttribute('data-gjs-badgable', 'true');
              el.setAttribute('data-gjs-name', 'Color de Fondo');
            }
          });

          // También escuchar cuando se agrega al canvas
          this.on('component:add', () => {
            setTimeout(() => {
              this.set({
                removable: true,
                selectable: true,
                draggable: true,
                droppable: true,
                highlightable: true,
                toolbar: true,
                layerable: true,
                copyable: true,
                badgable: true
              }, { silent: false });

              if (this.view && this.view.el) {
                const el = this.view.el;
                el.setAttribute('data-gjs-removable', 'true');
                el.setAttribute('data-gjs-selectable', 'true');
                el.setAttribute('data-gjs-draggable', 'true');
                el.setAttribute('data-gjs-droppable', 'true');
                el.setAttribute('data-gjs-highlightable', 'true');
                el.setAttribute('data-gjs-toolbar', 'true');
                el.setAttribute('data-gjs-layerable', 'true');
                el.setAttribute('data-gjs-copyable', 'true');
                el.setAttribute('data-gjs-badgable', 'true');
                el.setAttribute('data-gjs-name', 'Color de Fondo');
              }
            }, 50);
          });

          this.on('change:background-color', this.updateBackgroundColor, this);
          this.on('change:height', this.updateHeight, this);
          this.on('change:content-title', this.updateTitle, this);
          this.on('change:content-text', this.updateText, this);
          this.on('change:button-text', this.updateButtonText, this);
          this.on('change:button-link', this.updateButtonLink, this);
          this.on('change:title-color', this.updateTitleColor, this);
          this.on('change:text-color', this.updateTextColor, this);
          this.on('change:button-bg-color', this.updateButtonBgColor, this);
          this.on('change:button-text-color', this.updateButtonTextColor, this);

          this.on('component:update', () => {
            if (this._isUpdating) return;

            if (this.view && this.view.el) {
              const titleEl = this.view.el.querySelector('h2');
              const textEl = this.view.el.querySelector('p');
              const buttonEl = this.view.el.querySelector('button, a');

              // Solo sincronizar si el elemento no está siendo editado
              if (titleEl && document.activeElement !== titleEl) {
                const titleText = titleEl.textContent || titleEl.innerText || '';
                if (titleText.trim() && titleText !== this.get('content-title')) {
                  this.set('content-title', titleText.trim(), { silent: true });
                }
              }

              if (textEl && document.activeElement !== textEl) {
                const textContent = textEl.textContent || textEl.innerText || '';
                if (textContent.trim() && textContent !== this.get('content-text')) {
                  this.set('content-text', textContent.trim(), { silent: true });
                }
              }

              if (buttonEl && document.activeElement !== buttonEl) {
                const buttonText = buttonEl.textContent || buttonEl.innerText || '';
                if (buttonText.trim() && buttonText !== this.get('button-text')) {
                  this.set('button-text', buttonText.trim(), { silent: true });
                }

                const href = buttonEl.getAttribute('href');
                if (href && href !== this.get('button-link')) {
                  this.set('button-link', href, { silent: true });
                }
              }
            }
          });

          const enableEditingOnChildren = () => {
            const findTitle = (comp) => {
              if (comp.get('tagName') === 'h2') return comp;
              let found = null;
              comp.components().each(child => {
                if (!found) found = findTitle(child);
              });
              return found;
            };

            const findText = (comp) => {
              if (comp.get('tagName') === 'p') return comp;
              let found = null;
              comp.components().each(child => {
                if (!found) found = findText(child);
              });
              return found;
            };

            const findButton = (comp) => {
              if (comp.get('tagName') === 'button' || comp.get('tagName') === 'a') return comp;
              let found = null;
              comp.components().each(child => {
                if (!found) found = findButton(child);
              });
              return found;
            };

            const titleComp = findTitle(this);
            if (titleComp) {
              titleComp.set({ editable: true, selectable: true });
              titleComp.addAttributes({ 'data-gjs-editable': 'true', 'data-gjs-selectable': 'true' });
            }

            const textComp = findText(this);
            if (textComp) {
              textComp.set({ editable: true, selectable: true });
              textComp.addAttributes({ 'data-gjs-editable': 'true', 'data-gjs-selectable': 'true' });
            }

            const buttonComp = findButton(this);
            if (buttonComp) {
              buttonComp.set({ editable: true, selectable: true });
              buttonComp.addAttributes({ 'data-gjs-editable': 'true', 'data-gjs-selectable': 'true' });
            }
          };

          setTimeout(enableEditingOnChildren, 100);
          this.on('component:mount', enableEditingOnChildren);

          // Función optimizada para sincronizar valores iniciales (solo una vez)
          const syncInitialValues = () => {
            if (this._isUpdating) return;

            if (this.view && this.view.el) {
              const titleEl = this.view.el.querySelector('h2');
              const textEl = this.view.el.querySelector('p');
              const buttonEl = this.view.el.querySelector('button, a');

              // Solo sincronizar desde DOM al modelo si no hay valores en el modelo
              if (titleEl && !this.get('content-title')) {
                const domTitle = titleEl.textContent || titleEl.innerText || '';
                if (domTitle.trim()) {
                  this.set('content-title', domTitle.trim(), { silent: true });
                }
              }

              if (textEl && !this.get('content-text')) {
                const domText = textEl.textContent || textEl.innerText || '';
                if (domText.trim()) {
                  this.set('content-text', domText.trim(), { silent: true });
                }
              }

              if (buttonEl && !this.get('button-text')) {
                const domButtonText = buttonEl.textContent || buttonEl.innerText || '';
                if (domButtonText.trim()) {
                  this.set('button-text', domButtonText.trim(), { silent: true });
                }

                const href = buttonEl.getAttribute('href');
                if (href) {
                  this.set('button-link', href, { silent: true });
                } else if (buttonEl.tagName === 'BUTTON') {
                  this.set('button-link', '#', { silent: true });
                }
              }

              // Aplicar colores desde el modelo al DOM
              if (titleEl) {
                const titleColor = this.get('title-color') || '#ffffff';
                titleEl.style.setProperty('color', titleColor, 'important');
              }

              if (textEl) {
                const textColor = this.get('text-color') || '#ffffff';
                textEl.style.setProperty('color', textColor, 'important');
              }

              if (buttonEl) {
                const buttonBgColor = this.get('button-bg-color') || '#ffffff';
                const buttonTextColor = this.get('button-text-color') || '#111827';
                buttonEl.style.setProperty('background-color', buttonBgColor, 'important');
                buttonEl.style.setProperty('color', buttonTextColor, 'important');
              }
            }
          };

          // Solo ejecutar una vez después del mount
          this.on('component:mount', () => {
            setTimeout(syncInitialValues, 200);
          });

          this.set('removable', true);
        },
        updateBackgroundColor() {
          const bgColor = this.get('background-color') || '#2563eb';

          if (!this.view || !this.view.el) return;

          const el = this.view.el;

          el.style.backgroundColor = bgColor;
          el.setAttribute('style', el.getAttribute('style') || '');

          const currentStyle = this.getStyle() || {};
          this.setStyle({
            ...currentStyle,
            'background-color': bgColor
          });
        },
        updateHeight() {
          const height = this.get('height') || '384';
          const heightPx = `${height}px`;

          if (!this.view || !this.view.el) return;

          const el = this.view.el;
          el.style.height = heightPx;

          const currentStyle = this.getStyle() || {};
          this.setStyle({
            ...currentStyle,
            height: heightPx
          });
        },
        updateTitle() {
          if (this._isUpdating) return;

          const title = this.get('content-title') || 'Contenido sobre Color';

          if (this.view && this.view.el) {
            const titleEl = this.view.el.querySelector('h2');
            if (titleEl) {
              // Evitar actualizar si está siendo editado
              const isEditing = document.activeElement === titleEl;
              if (isEditing) {
                return;
              }

              // Solo actualizar si el contenido es diferente
              if (titleEl.textContent === title) {
                return;
              }

              // Actualizar directamente en el DOM
              titleEl.textContent = title;
            }
          }
        },
        updateText() {
          if (this._isUpdating) return;

          const text = this.get('content-text') || 'Texto superpuesto sobre el color de fondo';

          if (this.view && this.view.el) {
            const textEl = this.view.el.querySelector('p');
            if (textEl) {
              // Evitar actualizar si está siendo editado
              const isEditing = document.activeElement === textEl;
              if (isEditing) {
                return;
              }

              // Solo actualizar si el contenido es diferente
              if (textEl.textContent === text) {
                return;
              }

              // Actualizar directamente en el DOM
              textEl.textContent = text;
            }
          }
        },
        updateButtonText() {
          const buttonText = this.get('button-text') || 'Botón de Acción';

          if (!this.view || !this.view.el) return;

          const el = this.view.el;
          const buttonEl = el.querySelector('button, a');

          if (buttonEl) {
            buttonEl.textContent = buttonText;
          }
        },
        updateButtonLink() {
          const link = this.get('button-link') || '#';

          if (!this.view || !this.view.el) return;

          const el = this.view.el;
          const buttonEl = el.querySelector('button, a');

          if (buttonEl) {
            if (link && link !== '#') {
              if (buttonEl.tagName === 'BUTTON') {
                const newLink = document.createElement('a');
                newLink.href = link;
                newLink.className = buttonEl.className;
                newLink.textContent = buttonEl.textContent;
                buttonEl.parentNode.replaceChild(newLink, buttonEl);
              } else {
                buttonEl.setAttribute('href', link);
              }
            } else {
              if (buttonEl.tagName === 'A') {
                const newButton = document.createElement('button');
                newButton.className = buttonEl.className;
                newButton.textContent = buttonEl.textContent;
                buttonEl.parentNode.replaceChild(newButton, buttonEl);
              }
            }
          }
        },
        updateTitleColor() {
          const color = this.get('title-color') || '#ffffff';

          if (!this.view || !this.view.el) return;

          const el = this.view.el;
          const titleEl = el.querySelector('h2');

          if (titleEl) {
            titleEl.style.setProperty('color', color, 'important');
          }
        },
        updateTextColor() {
          const color = this.get('text-color') || '#ffffff';

          if (!this.view || !this.view.el) return;

          const el = this.view.el;
          const textEl = el.querySelector('p');

          if (textEl) {
            textEl.style.setProperty('color', color, 'important');
          }
        },
        updateButtonBgColor() {
          const color = this.get('button-bg-color') || '#ffffff';

          if (!this.view || !this.view.el) return;

          const el = this.view.el;
          const buttonEl = el.querySelector('button, a');

          if (buttonEl) {
            buttonEl.style.setProperty('background-color', color, 'important');
          }
        },
        updateButtonTextColor() {
          const color = this.get('button-text-color') || '#111827';

          if (!this.view || !this.view.el) return;

          const el = this.view.el;
          const buttonEl = el.querySelector('button, a');

          if (buttonEl) {
            buttonEl.style.setProperty('color', color, 'important');
          }
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

          const bgColor = this.get('background-color') || '#2563eb';
          const height = this.get('height') || '384';
          const modelTitle = this.get('content-title') || 'Contenido sobre Color';
          const modelText = this.get('content-text') || 'Texto superpuesto sobre el color de fondo';
          const modelButtonText = this.get('button-text') || 'Botón de Acción';
          const modelButtonLink = this.get('button-link') || '#';
          const modelTitleColor = this.get('title-color') || '#ffffff';
          const modelTextColor = this.get('text-color') || '#ffffff';
          const modelButtonBgColor = this.get('button-bg-color') || '#ffffff';
          const modelButtonTextColor = this.get('button-text-color') || '#111827';

          let innerHTML = '';
          innerHTML += '<div class="relative z-10 flex flex-col items-center justify-center h-full">';
          innerHTML += '<div class="text-center">';
          innerHTML += `<h2 class="text-3xl font-bold mb-4" style="color: ${modelTitleColor};">${modelTitle}</h2>`;
          innerHTML += `<p class="text-lg mb-6" style="color: ${modelTextColor};">${modelText}</p>`;

          if (modelButtonLink && modelButtonLink !== '#' && modelButtonLink.trim() !== '') {
            innerHTML += `<a href="${modelButtonLink.replace(/"/g, '&quot;')}" class="px-6 py-3 rounded-lg font-semibold hover:bg-gray-100" style="background-color: ${modelButtonBgColor}; color: ${modelButtonTextColor};">${modelButtonText}</a>`;
          } else {
            innerHTML += `<button class="px-6 py-3 rounded-lg font-semibold hover:bg-gray-100" style="background-color: ${modelButtonBgColor}; color: ${modelButtonTextColor};">${modelButtonText}</button>`;
          }

          innerHTML += '</div>';
          innerHTML += '</div>';

          const styleAttr = `background-color: ${bgColor}; height: ${height}px;`;
          const finalHTML = `<${tagName}${attrsStr ? ' ' + attrsStr : ''} class="background-color-section relative rounded-lg overflow-hidden mb-8" style="${styleAttr}">${innerHTML}</${tagName}>`;
          return finalHTML;
        }
      },
      view: {
        onRender() {
          const el = this.el;
          const component = this.model;

          // Solo establecer atributos básicos si no están ya establecidos
          if (!el.hasAttribute('data-gjs-removable')) {
            component.set('removable', true);
            component.set('selectable', true);
            component.set('draggable', true);
            component.set('droppable', true);
            component.set('highlightable', true);
            component.set('toolbar', true);
            component.set('layerable', true);
            component.set('copyable', true);
            component.set('badgable', true);

            el.setAttribute('data-gjs-removable', 'true');
            el.setAttribute('data-gjs-selectable', 'true');
            el.setAttribute('data-gjs-draggable', 'true');
            el.setAttribute('data-gjs-droppable', 'true');
            el.setAttribute('data-gjs-highlightable', 'true');
            el.setAttribute('data-gjs-toolbar', 'true');
            el.setAttribute('data-gjs-layerable', 'true');
            el.setAttribute('data-gjs-copyable', 'true');
            el.setAttribute('data-gjs-badgable', 'true');
            el.setAttribute('data-gjs-name', 'Color de Fondo');

            component.setAttributes({
              'data-gjs-removable': 'true',
              'data-gjs-selectable': 'true',
              'data-gjs-draggable': 'true',
              'data-gjs-droppable': 'true',
              'data-gjs-highlightable': 'true',
              'data-gjs-toolbar': 'true',
              'data-gjs-layerable': 'true',
              'data-gjs-copyable': 'true',
              'data-gjs-badgable': 'true',
              'data-gjs-name': 'Color de Fondo'
            }, { silent: true });
          }

          // Solo inicializar elementos si no existen
          let titleEl = el.querySelector('h2');
          let textEl = el.querySelector('p');
          let buttonEl = el.querySelector('button, a');

          const findContentContainer = () => {
            const containers = el.querySelectorAll('.relative.z-10');
            if (containers.length > 0) {
              const innerDiv = containers[0].querySelector('div');
              return innerDiv || containers[0];
            }
            return null;
          };

          const contentContainer = findContentContainer();

          // Solo crear elementos si no existen
          if (!titleEl && contentContainer) {
            const modelTitle = component.get('content-title') || 'Contenido sobre Color';
            const titleColor = component.get('title-color') || '#ffffff';
            titleEl = document.createElement('h2');
            titleEl.className = 'text-3xl font-bold mb-4';
            titleEl.textContent = modelTitle;
            titleEl.style.setProperty('color', titleColor, 'important');
            titleEl.setAttribute('data-gjs-editable', 'true');
            titleEl.setAttribute('data-gjs-selectable', 'true');

            titleEl._inputListener = (e) => {
              const newTitle = e.target.textContent || e.target.innerText || '';
              component.set('content-title', newTitle.trim(), { silent: true });
            };

            titleEl._blurListener = (e) => {
              const newTitle = e.target.textContent || e.target.innerText || '';
              component.set('content-title', newTitle.trim(), { silent: false });
            };

            titleEl.addEventListener('input', titleEl._inputListener);
            titleEl.addEventListener('blur', titleEl._blurListener);

            contentContainer.appendChild(titleEl);
          }

          if (!textEl && contentContainer) {
            const modelText = component.get('content-text') || 'Texto superpuesto sobre el color de fondo';
            const textColor = component.get('text-color') || '#ffffff';
            textEl = document.createElement('p');
            textEl.className = 'text-lg mb-6';
            textEl.textContent = modelText;
            textEl.style.setProperty('color', textColor, 'important');
            textEl.setAttribute('data-gjs-editable', 'true');
            textEl.setAttribute('data-gjs-selectable', 'true');
            contentContainer.appendChild(textEl);
          }

          if (!buttonEl && contentContainer) {
            const modelButtonText = component.get('button-text') || 'Botón de Acción';
            const modelButtonLink = component.get('button-link') || '#';
            const buttonBgColor = component.get('button-bg-color') || '#ffffff';
            const buttonTextColor = component.get('button-text-color') || '#111827';
            const isLink = modelButtonLink && modelButtonLink !== '#' && modelButtonLink.trim() !== '';
            buttonEl = document.createElement(isLink ? 'a' : 'button');
            buttonEl.className = 'px-6 py-3 rounded-lg font-semibold hover:bg-gray-100';
            buttonEl.textContent = modelButtonText;
            buttonEl.style.setProperty('background-color', buttonBgColor, 'important');
            buttonEl.style.setProperty('color', buttonTextColor, 'important');
            buttonEl.setAttribute('data-gjs-editable', 'true');
            buttonEl.setAttribute('data-gjs-selectable', 'true');
            if (isLink) {
              buttonEl.setAttribute('href', modelButtonLink);
            }
            contentContainer.appendChild(buttonEl);
          }

          // Solo actualizar listeners si los elementos existen y no tienen listeners
          titleEl = el.querySelector('h2');
          textEl = el.querySelector('p');
          buttonEl = el.querySelector('button, a');

          if (titleEl && !titleEl._inputListener) {
            titleEl.setAttribute('data-gjs-editable', 'true');
            titleEl.setAttribute('data-gjs-selectable', 'true');
            titleEl.removeAttribute('contenteditable');

            titleEl._inputListener = (e) => {
              const newTitle = e.target.textContent || e.target.innerText || '';
              component.set('content-title', newTitle.trim(), { silent: true });
            };

            titleEl._blurListener = (e) => {
              const newTitle = e.target.textContent || e.target.innerText || '';
              component.set('content-title', newTitle.trim(), { silent: false });
            };

            titleEl.addEventListener('input', titleEl._inputListener);
            titleEl.addEventListener('blur', titleEl._blurListener);
          }

          if (textEl && !textEl._inputListener) {
            textEl.setAttribute('data-gjs-editable', 'true');
            textEl.setAttribute('data-gjs-selectable', 'true');
            textEl.removeAttribute('contenteditable');

            textEl._inputListener = (e) => {
              const newText = e.target.textContent || e.target.innerText || '';
              component.set('content-text', newText.trim(), { silent: true });
            };

            textEl._blurListener = (e) => {
              const newText = e.target.textContent || e.target.innerText || '';
              component.set('content-text', newText.trim(), { silent: false });
            };

            textEl.addEventListener('input', textEl._inputListener);
            textEl.addEventListener('blur', textEl._blurListener);
          }

          if (buttonEl && !buttonEl._inputListener) {
            buttonEl.setAttribute('data-gjs-editable', 'true');
            buttonEl.setAttribute('data-gjs-selectable', 'true');
            buttonEl.removeAttribute('contenteditable');

            buttonEl._inputListener = (e) => {
              const newButtonText = e.target.textContent || e.target.innerText || '';
              component.set('button-text', newButtonText.trim(), { silent: true });
            };

            buttonEl._blurListener = (e) => {
              const newButtonText = e.target.textContent || e.target.innerText || '';
              component.set('button-text', newButtonText.trim(), { silent: false });
            };

            buttonEl.addEventListener('input', buttonEl._inputListener);
            buttonEl.addEventListener('blur', buttonEl._blurListener);
          }

          el.setAttribute('contenteditable', 'false');
          el.setAttribute('data-gjs-editable', 'false');
        }
      }
    });

  }

  if (typeof window !== 'undefined' && window.editor) {
    registerBackgroundColorComponent(window.editor);
  } else {
    const checkEditor = setInterval(() => {
      if (typeof window !== 'undefined' && window.editor) {
        registerBackgroundColorComponent(window.editor);
        clearInterval(checkEditor);
      }
    }, 100);

    setTimeout(() => {
      clearInterval(checkEditor);
    }, 10000);
  }

  if (typeof window !== 'undefined') {
    window.registerBackgroundColorComponent = registerBackgroundColorComponent;
  }
})();

