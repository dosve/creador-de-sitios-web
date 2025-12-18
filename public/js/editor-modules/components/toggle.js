// Módulo del Componente Toggle
// Componente de toggle/accordion simple estilo Elementor con traits y protección

(function() {
  'use strict';
  
  function registerToggleComponent(editor) {
    if (!editor || !editor.DomComponents) {
      console.error('❌ [Toggle] Editor o DomComponents no disponible');
      return;
    }
    
    console.log('🔄 [Toggle] Registrando componente toggle en GrapesJS...');
    
    editor.DomComponents.addType('toggle', {
      isComponent: (el) => {
        // Verificar que el sea un elemento DOM válido
        if (!el || typeof el !== 'object' || !el.nodeType) {
          return false;
        }
        
        // Verificar por clase toggle-container (más específico primero)
        if (el.classList && el.classList.contains('toggle-container')) {
          return { type: 'toggle' };
        }
        
        // Verificar por atributo data-gjs-type
        if (el.getAttribute && el.getAttribute('data-gjs-type') === 'toggle') {
          return { type: 'toggle' };
        }
        
        // Verificar si contiene un toggle-button
        if (el.tagName === 'DIV' && el.querySelector && typeof el.querySelector === 'function' && el.querySelector('.toggle-button')) {
          return { type: 'toggle' };
        }
        
        return false;
      },
      model: {
        defaults: {
          name: 'Toggle',
          tagName: 'div',
          draggable: true,
          editable: false,     // ✅ BLOQUEADO: No edición directa
          droppable: false,    // ✅ BLOQUEADO: No aceptar componentes hijos
          removable: true,
          selectable: true,
          hoverable: true,
          highlightable: true,
          badgable: true,
          // ✅ NO establecer toolbar explícitamente - dejar que GrapesJS lo genere automáticamente
          // basándose en removable: true, draggable: true, etc.
          layerable: true,
          attributes: {
            class: 'toggle-container',
            'data-gjs-type': 'toggle',
            'data-gjs-name': 'Toggle',
            'data-gjs-editable': 'false',
            'data-gjs-highlightable': 'true'
          },
          'toggle-title': 'Haz clic para expandir',
          'toggle-content': 'Este es el contenido que se muestra cuando se expande el toggle. Puedes agregar cualquier contenido aquí.',
          'initially-open': false,
          traits: [
            {
              type: 'text',
              name: 'toggle-title',
              label: 'Título del Toggle',
              placeholder: 'Haz clic para expandir',
              changeProp: 1  // ✅ CRÍTICO: changeProp: 1 dispara el evento change:toggle-title
            },
            {
              type: 'textarea',
              name: 'toggle-content',
              label: 'Contenido',
              placeholder: 'Contenido del toggle...',
              rows: 4,
              changeProp: 1  // ✅ CRÍTICO: changeProp: 1 dispara el evento change:toggle-content
            },
            {
              type: 'checkbox',
              name: 'initially-open',
              label: 'Abierto Inicialmente',
              changeProp: 1
            }
          ]
        },
        init() {
          this.on('change:toggle-title', this.updateTitle, this);
          this.on('change:toggle-content', this.updateContent, this);
          this.on('change:initially-open', this.updateInitialState, this);
          
          // ✅ CRÍTICO: Eliminar componentes hijos no deseados primero
          // La estructura HTML se crea en onRender(), NO como componentes de GrapesJS
          const cleanupComponents = () => {
            try {
              if (this.components && typeof this.components === 'function') {
                const children = this.components();
                if (children && children.length > 0) {
                  const toRemove = [];
                  children.each((child) => {
                    if (child && child.get) {
                      const childType = child.get('type');
                      const childTag = child.get('tagName');
                      // Eliminar componentes internos que NO deberían ser componentes de GrapesJS
                      // (button, span, p, textnode, etc.) - solo deben ser HTML
                      if (childType === 'button' || childType === 'textnode' || 
                          childType === 'text' || childTag === 'button' || 
                          childTag === 'span' || childTag === 'p') {
                        toRemove.push(child);
                      }
                    }
                  });
                  toRemove.forEach(child => {
                    try {
                      child.remove();
                    } catch (e) {
                      console.warn('⚠️ [Toggle] Error al eliminar componente hijo:', e);
                    }
                  });
                }
              }
            } catch (e) {
              console.warn('⚠️ [Toggle] Error al limpiar componentes hijos:', e);
            }
          };
          
          // ✅ CRÍTICO: Proteger TODOS los componentes internos - NO edición directa
          // TODO debe modificarse desde las propiedades (traits), NADA directamente en el canvas
          const protectElements = () => {
            // Evitar ejecución múltiple simultánea
            if (this._isProtectingInit) return;
            this._isProtectingInit = true;
            
            // Primero limpiar componentes no deseados
            cleanupComponents();
            
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
              
              // Usar setAttributes en lugar de addAttributes para evitar conflictos
              // IMPORTANTE: Agregar try-catch para evitar errores con componentes especiales (imágenes, etc.)
              try {
                const currentAttrs = component.getAttributes() || {};
                component.setAttributes({
                  ...currentAttrs,
                  'data-gjs-editable': 'false',
                  'data-gjs-selectable': 'false',
                  'data-gjs-draggable': 'false',
                  'data-gjs-droppable': 'false',
                  'data-gjs-removable': 'false',
                  'contenteditable': 'false'
                });
              } catch (error) {
                // Ignorar errores al proteger elementos especiales (puede ocurrir con componentes de imagen)
                console.warn('⚠️ [Toggle] Error al proteger atributos de componente:', error);
              }
              
              // Proteger recursivamente todos los hijos
              component.components().each(grandchild => {
                protectRecursive(grandchild);
              });
            };
            
            // Proteger todos los componentes hijos del toggle (si quedan algunos)
            this.components().each(child => {
              protectRecursive(child);
            });
            
            setTimeout(() => {
              this._isProtectingInit = false;
            }, 50);
          };
          
          // Limpiar y proteger inmediatamente y también cuando se agreguen nuevos componentes
          setTimeout(() => {
            cleanupComponents();
            protectElements();
          }, 100);
          this.on('component:mount', () => {
            setTimeout(() => {
              cleanupComponents();
              protectElements();
            }, 100);
          });
          this.on('component:add', () => {
            setTimeout(() => {
              cleanupComponents();
              protectElements();
            }, 100);
          });
        },
        updateTitle() {
          const title = this.get('toggle-title') || 'Haz clic para expandir';
          
          console.log('🔄 [Toggle] updateTitle llamado:', title);
          
          // Actualizar usando el frame del canvas
          const editor = window.editor;
          if (!editor || !this.view || !this.view.el) {
            console.warn('⚠️ [Toggle] No hay editor, view o elemento para actualizar título');
            return;
          }
          
          // Buscar el elemento en el frame del canvas
          const canvasFrame = editor.Canvas.getFrameEl();
          if (!canvasFrame || !canvasFrame.contentDocument) {
            console.warn('⚠️ [Toggle] No se puede acceder al frame del canvas');
            return;
          }
          
          const frameDoc = canvasFrame.contentDocument;
          
          // ✅ Usar directamente el elemento del view si está en el frame
          // El view.el debería ser el mismo elemento en el frame
          let el = this.view.el;
          
          // Si el elemento no está en el frame, buscar por ID
          if (!frameDoc.contains(el) && el.id) {
            el = frameDoc.getElementById(el.id);
          }
          
          // Si aún no se encuentra, buscar por data-gjs-type y posición
          if (!el || !frameDoc.contains(el)) {
            const allToggles = frameDoc.querySelectorAll('[data-gjs-type="toggle"]');
            // Si solo hay un toggle, usar ese
            if (allToggles.length === 1) {
              el = allToggles[0];
            } else if (allToggles.length > 1) {
              // Si hay múltiples, usar el más reciente (último)
              el = allToggles[allToggles.length - 1];
            }
          }
          
          if (!el) {
            console.warn('⚠️ [Toggle] No se pudo encontrar el elemento toggle en el frame');
            return;
          }
          
          // Buscar el título dentro del botón
          const button = el.querySelector('.toggle-button');
          if (button) {
            const titleSpan = button.querySelector('.toggle-title-text');
            if (titleSpan) {
              titleSpan.textContent = title;
              console.log('✅ [Toggle] Título actualizado en DOM:', title);
            } else {
              // Buscar cualquier span dentro del botón que tenga texto
              const spans = button.querySelectorAll('span');
              if (spans.length > 0) {
                // El primer span suele ser el título
                spans[0].textContent = title;
                console.log('✅ [Toggle] Título actualizado en primer span del botón');
              } else {
                console.warn('⚠️ [Toggle] No se encontró ningún span dentro del botón. Botón:', button);
              }
            }
          } else {
            console.warn('⚠️ [Toggle] No se encontró .toggle-button. Elemento:', el);
          }
        },
        updateContent() {
          const content = this.get('toggle-content');
          const contentValue = (content !== undefined && content !== null) ? String(content) : '';
          
          console.log('🔄 [Toggle] updateContent llamado. Valor:', content, 'String:', contentValue);
          
          // Actualizar usando el frame del canvas
          const editor = window.editor;
          if (!editor || !this.view || !this.view.el) {
            console.warn('⚠️ [Toggle] No hay editor, view o elemento para actualizar contenido');
            return;
          }
          
          // Buscar el elemento en el frame del canvas
          const canvasFrame = editor.Canvas.getFrameEl();
          if (!canvasFrame || !canvasFrame.contentDocument) {
            console.warn('⚠️ [Toggle] No se puede acceder al frame del canvas');
            return;
          }
          
          const frameDoc = canvasFrame.contentDocument;
          
          // ✅ Usar directamente el elemento del view si está en el frame
          let el = this.view.el;
          
          // Si el elemento no está en el frame, buscar por ID
          if (!frameDoc.contains(el) && el.id) {
            el = frameDoc.getElementById(el.id);
          }
          
          // Si aún no se encuentra, buscar por data-gjs-type
          if (!el || !frameDoc.contains(el)) {
            const allToggles = frameDoc.querySelectorAll('[data-gjs-type="toggle"]');
            if (allToggles.length === 1) {
              el = allToggles[0];
            } else if (allToggles.length > 1) {
              // Usar el más reciente (último)
              el = allToggles[allToggles.length - 1];
            }
          }
          
          if (!el) {
            console.warn('⚠️ [Toggle] No se pudo encontrar el elemento toggle en el frame para actualizar contenido');
            return;
          }
          
          const contentDiv = el.querySelector('.toggle-content');
          
          if (contentDiv) {
            let contentP = contentDiv.querySelector('p');
            if (!contentP) {
              contentP = frameDoc.createElement('p');
              contentP.className = 'text-gray-700';
              contentP.setAttribute('data-gjs-editable', 'false');
              contentP.setAttribute('data-gjs-selectable', 'false');
              contentP.setAttribute('contenteditable', 'false');
              contentDiv.appendChild(contentP);
            }
            contentP.textContent = contentValue;
            console.log('✅ [Toggle] Contenido actualizado en DOM:', contentValue);
          } else {
            console.warn('⚠️ [Toggle] No se encontró .toggle-content en:', el);
          }
        },
        updateInitialState() {
          const isOpen = this.get('initially-open') || false;
          
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          const contentDiv = el.querySelector('.toggle-content');
          const button = el.querySelector('.toggle-button');
          const svg = button ? button.querySelector('svg') : null;
          
          if (contentDiv && button) {
            if (isOpen) {
              contentDiv.classList.remove('hidden');
              if (svg) {
                const currentClass = svg.getAttribute('class') || '';
                if (!currentClass.includes('rotate-180')) {
                  svg.setAttribute('class', currentClass + ' rotate-180');
                }
              }
            } else {
              contentDiv.classList.add('hidden');
              if (svg) {
                const currentClass = svg.getAttribute('class') || '';
                svg.setAttribute('class', currentClass.replace('rotate-180', '').trim());
              }
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
          
          const title = this.get('toggle-title') || 'Haz clic para expandir';
          const content = this.get('toggle-content') || '';
          const isOpen = this.get('initially-open') || false;
          
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
          innerHTML += '<button type="button" class="toggle-button w-full flex justify-between items-center p-4 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">';
          innerHTML += `<span class="toggle-title-text font-medium text-gray-900">${escapeHtml(title)}</span>`;
          innerHTML += '<svg class="w-5 h-5 text-gray-500 transform transition-transform' + (isOpen ? ' rotate-180' : '') + '" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
          innerHTML += '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>';
          innerHTML += '</svg>';
          innerHTML += '</button>';
          innerHTML += '<div class="toggle-content p-4 bg-gray-50 border border-t-0 border-gray-200 rounded-b-lg' + (isOpen ? '' : ' hidden') + '">';
          innerHTML += `<p class="text-gray-700">${escapeHtml(content)}</p>`;
          innerHTML += '</div>';
          
          // JavaScript para la interacción en la página final
          innerHTML += '<script>';
          innerHTML += '(function() {';
          innerHTML += '  function initToggle() {';
          innerHTML += '    const buttons = document.querySelectorAll(\'.toggle-button\');';
          innerHTML += '    buttons.forEach(function(button) {';
          innerHTML += '      if (button.dataset.toggleInitialized) return;';
          innerHTML += '      button.dataset.toggleInitialized = \'true\';';
          innerHTML += '      button.addEventListener(\'click\', function(e) {';
          innerHTML += '        e.preventDefault();';
          innerHTML += '        const content = this.nextElementSibling;';
          innerHTML += '        const svg = this.querySelector(\'svg\');';
          innerHTML += '        if (content && content.classList.contains(\'toggle-content\')) {';
          innerHTML += '          const isHidden = content.classList.contains(\'hidden\');';
          innerHTML += '          if (isHidden) {';
          innerHTML += '            content.classList.remove(\'hidden\');';
          innerHTML += '            if (svg) {';
          innerHTML += '              const currentClass = svg.getAttribute(\'class\') || \'\';';
          innerHTML += '              if (currentClass.indexOf(\'rotate-180\') === -1) {';
          innerHTML += '                svg.setAttribute(\'class\', currentClass + \' rotate-180\');';
          innerHTML += '              }';
          innerHTML += '            }';
          innerHTML += '          } else {';
          innerHTML += '            content.classList.add(\'hidden\');';
          innerHTML += '            if (svg) {';
          innerHTML += '              const currentClass = svg.getAttribute(\'class\') || \'\';';
          innerHTML += '              svg.setAttribute(\'class\', currentClass.replace(\'rotate-180\', \'\').trim());';
          innerHTML += '            }';
          innerHTML += '          }';
          innerHTML += '        }';
          innerHTML += '      });';
          innerHTML += '    });';
          innerHTML += '  }';
          innerHTML += '  if (document.readyState === \'loading\') {';
          innerHTML += '    document.addEventListener(\'DOMContentLoaded\', initToggle);';
          innerHTML += '  } else {';
          innerHTML += '    initToggle();';
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
          const editor = window.editor || (component.collection && component.collection.editor);
          
          console.log('🔄 [Toggle] Vista renderizada');
          
          // Proteger el contenedor
          if (el) {
            el.style.cursor = 'pointer';
            el.setAttribute('contenteditable', 'false');
            el.setAttribute('data-gjs-editable', 'false');
          }
          
          // ✅ Verificar y asegurar estructura inmediatamente
          let button = el.querySelector('.toggle-button');
          let contentDiv = el.querySelector('.toggle-content');
          
          // Si falta estructura, crearla inmediatamente (la estructura debería venir del bloque)
          if (!button) {
            console.log('⚠️ [Toggle] Botón no encontrado, creando...');
            button = document.createElement('button');
            button.className = 'toggle-button w-full flex justify-between items-center p-4 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors';
            button.type = 'button';
            button.setAttribute('data-gjs-editable', 'false');
            button.setAttribute('data-gjs-selectable', 'false');
            button.setAttribute('data-gjs-draggable', 'false');
            button.setAttribute('data-gjs-removable', 'false');
            button.setAttribute('contenteditable', 'false');
            
            const titleSpan = document.createElement('span');
            titleSpan.className = 'toggle-title-text font-medium text-gray-900';
            titleSpan.textContent = component.get('toggle-title') || 'Haz clic para expandir';
            
            const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
            svg.setAttribute('class', 'w-5 h-5 text-gray-500 transform transition-transform');
            svg.setAttribute('fill', 'none');
            svg.setAttribute('stroke', 'currentColor');
            svg.setAttribute('viewBox', '0 0 24 24');
            
            const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
            path.setAttribute('stroke-linecap', 'round');
            path.setAttribute('stroke-linejoin', 'round');
            path.setAttribute('stroke-width', '2');
            path.setAttribute('d', 'M19 9l-7 7-7-7');
            svg.appendChild(path);
            
            button.appendChild(titleSpan);
            button.appendChild(svg);
            el.appendChild(button);
          }
          
          if (!contentDiv) {
            console.log('⚠️ [Toggle] ContentDiv no encontrado, creando...');
            contentDiv = document.createElement('div');
            contentDiv.className = 'toggle-content p-4 bg-gray-50 border border-t-0 border-gray-200 rounded-b-lg hidden';
            contentDiv.setAttribute('data-gjs-editable', 'false');
            contentDiv.setAttribute('data-gjs-selectable', 'false');
            contentDiv.setAttribute('contenteditable', 'false');
            
            const contentP = document.createElement('p');
            contentP.className = 'text-gray-700';
            contentP.textContent = component.get('toggle-content') || 'Este es el contenido que se muestra cuando se expande el toggle.';
            
            contentDiv.appendChild(contentP);
            el.appendChild(contentDiv);
          }
          
          // ✅ Aplicar estado inicial
          if (button && contentDiv) {
            const isOpen = component.get('initially-open') || false;
            if (isOpen) {
              contentDiv.classList.remove('hidden');
              const svg = button.querySelector('svg');
              if (svg) {
                svg.classList.add('rotate-180');
              }
            } else {
              contentDiv.classList.add('hidden');
            }
          }
          
          // ✅ Proteger elementos y limpiar clases después de un delay
          setTimeout(() => {
            // Actualizar referencias
            button = el.querySelector('.toggle-button');
            contentDiv = el.querySelector('.toggle-content');
            
            // ✅ Función para limpiar clases del botón
            const cleanButtonClasses = (btn) => {
              if (!btn) return;
              
              const currentClasses = btn.className.split(' ').filter(cls => cls.trim());
              const darkClasses = ['bg-gray-600', 'bg-gray-700', 'hover:bg-gray-700', 'hover:bg-gray-600'];
              const hasDarkClasses = darkClasses.some(darkClass => currentClasses.includes(darkClass));
              
              if (hasDarkClasses) {
                const filteredClasses = currentClasses.filter(cls => !darkClasses.includes(cls));
                if (!filteredClasses.includes('bg-white')) filteredClasses.push('bg-white');
                if (!filteredClasses.includes('hover:bg-gray-50')) filteredClasses.push('hover:bg-gray-50');
                btn.className = filteredClasses.join(' ');
              }
            };
            
            // Proteger y limpiar botón si existe
            if (button) {
              button.setAttribute('data-gjs-selectable', 'false');
              button.setAttribute('data-gjs-editable', 'false');
              button.setAttribute('data-gjs-draggable', 'false');
              button.setAttribute('data-gjs-removable', 'false');
              cleanButtonClasses(button);
            }
            
            // ✅ Proteger TODOS los elementos DOM internos
            const protectAllElements = (container) => {
              if (!container) return;
              const allElements = container.querySelectorAll('*');
              allElements.forEach(element => {
                if (element === el) return;
                element.setAttribute('contenteditable', 'false');
                element.setAttribute('data-gjs-editable', 'false');
                element.setAttribute('data-gjs-selectable', 'false');
                element.setAttribute('data-gjs-draggable', 'false');
                element.setAttribute('data-gjs-droppable', 'false');
                element.setAttribute('data-gjs-removable', 'false');
              });
            };
            
            protectAllElements(el);
          }, 100);
        },
        onRemove() {
          if (this._toggleObserver) {
            this._toggleObserver.disconnect();
          }
          if (this._buttonObserver) {
            this._buttonObserver.disconnect();
          }
        }
      }
    });
    
    // Verificar que se registró correctamente
    const registeredType = editor.DomComponents.getType('toggle');
    if (registeredType) {
      console.log('✅ [Toggle] Componente toggle registrado exitosamente en GrapesJS');
    } else {
      console.error('❌ [Toggle] ERROR: Componente toggle NO se pudo registrar en GrapesJS');
    }
  }
  
  // Exportar para registro manual (SIEMPRE)
  if (typeof window !== 'undefined') {
    window.registerToggleComponent = registerToggleComponent;
    console.log('✅ [Toggle] Función registerToggleComponent exportada');
  }
  
  // Auto-registrar si el editor ya está disponible
  if (typeof window !== 'undefined' && window.editor) {
    console.log('✅ [Toggle] Editor disponible, registrando componente...');
    registerToggleComponent(window.editor);
    console.log('✅ [Toggle] Componente toggle registrado');
  }
})();
