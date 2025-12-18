// Módulo del Componente Tabs
// Componente de pestañas estilo Elementor con traits y protección

(function() {
  'use strict';
  
  function registerTabsComponent(editor) {
    if (!editor || !editor.DomComponents) {
      console.warn('⚠️ Editor no disponible para registrar componente Tabs');
      return;
    }
    
    editor.DomComponents.addType('tabs', {
      isComponent: (el) => {
        // Verificar que el sea un elemento DOM válido
        if (!el || typeof el !== 'object' || !el.nodeType) {
          return false;
        }
        
        if (el.classList && el.classList.contains('tabs-container')) {
          return { type: 'tabs' };
        }
        if (el.tagName === 'DIV' && el.querySelector && typeof el.querySelector === 'function' && el.querySelector('.tabs-container')) {
          return { type: 'tabs' };
        }
        return false;
      },
      model: {
        defaults: {
          name: 'Pestañas',
          tagName: 'div',
          editable: false,
          droppable: false,
          removable: true,
          selectable: true,
          badgable: false,
          attributes: {
            class: 'py-8 tabs-container',
            'data-gjs-type': 'tabs',
            'data-gjs-name': 'Pestañas',
            'data-gjs-editable': 'false'
          },
          'tabs-count': 3,
          'tabs-data': [
            { title: 'Pestaña 1', content: 'Contenido de la Pestaña 1' },
            { title: 'Pestaña 2', content: 'Contenido de la Pestaña 2' },
            { title: 'Pestaña 3', content: 'Contenido de la Pestaña 3' }
          ],
          traits: [
            {
              type: 'number',
              name: 'tabs-count',
              label: 'Número de Pestañas',
              min: 2,
              max: 10,
              changeProp: 1
            },
            {
              type: 'button',
              name: 'tabs-manage',
              label: 'Gestionar Pestañas',
              text: 'Editar Pestañas',
              command: (editor) => {
                if (!editor) return;
                const component = editor.getSelected();
                if (!component || component.get('type') !== 'tabs') return;
                
                const tabsData = component.get('tabs-data') || [];
                const count = parseInt(component.get('tabs-count')) || 3;
                
                // Asegurar que tenemos suficientes datos
                let currentTabs = [...tabsData];
                while (currentTabs.length < count) {
                  currentTabs.push({
                    title: `Pestaña ${currentTabs.length + 1}`,
                    content: `Contenido de la Pestaña ${currentTabs.length + 1}`
                  });
                }
                
                // Crear modal
                const modal = document.createElement('div');
                modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
                modal.style.zIndex = '10000';
                
                const modalContent = document.createElement('div');
                modalContent.className = 'bg-white rounded-lg p-6 max-w-2xl w-full max-h-[90vh] overflow-y-auto';
                
                const title = document.createElement('h3');
                title.className = 'text-xl font-bold mb-4';
                title.textContent = 'Gestionar Pestañas';
                modalContent.appendChild(title);
                
                const tabsContainer = document.createElement('div');
                tabsContainer.className = 'space-y-4';
                
                // Función para renderizar las pestañas
                const renderTabs = () => {
                  tabsContainer.innerHTML = '';
                  
                  currentTabs.forEach((tab, index) => {
                    const tabDiv = document.createElement('div');
                    tabDiv.className = 'border border-gray-300 rounded p-4';
                    tabDiv.setAttribute('data-tab-index', index);
                    
                    // Header con controles
                    const headerDiv = document.createElement('div');
                    headerDiv.className = 'flex justify-between items-center mb-2';
                    
                    const tabLabel = document.createElement('label');
                    tabLabel.className = 'block text-sm font-medium';
                    tabLabel.textContent = `Pestaña ${index + 1}`;
                    
                    const controlsDiv = document.createElement('div');
                    controlsDiv.className = 'flex gap-2';
                    
                    // Botón subir
                    const upBtn = document.createElement('button');
                    upBtn.type = 'button';
                    upBtn.className = 'px-2 py-1 text-xs bg-gray-200 hover:bg-gray-300 rounded';
                    upBtn.innerHTML = '↑';
                    upBtn.title = 'Mover arriba';
                    upBtn.disabled = index === 0;
                    upBtn.addEventListener('click', () => {
                      if (index > 0) {
                        [currentTabs[index], currentTabs[index - 1]] = [currentTabs[index - 1], currentTabs[index]];
                        renderTabs();
                      }
                    });
                    
                    // Botón bajar
                    const downBtn = document.createElement('button');
                    downBtn.type = 'button';
                    downBtn.className = 'px-2 py-1 text-xs bg-gray-200 hover:bg-gray-300 rounded';
                    downBtn.innerHTML = '↓';
                    downBtn.title = 'Mover abajo';
                    downBtn.disabled = index === currentTabs.length - 1;
                    downBtn.addEventListener('click', () => {
                      if (index < currentTabs.length - 1) {
                        [currentTabs[index], currentTabs[index + 1]] = [currentTabs[index + 1], currentTabs[index]];
                        renderTabs();
                      }
                    });
                    
                    // Botón eliminar
                    const deleteBtn = document.createElement('button');
                    deleteBtn.type = 'button';
                    deleteBtn.className = 'px-2 py-1 text-xs bg-red-200 hover:bg-red-300 text-red-800 rounded';
                    deleteBtn.innerHTML = '✕';
                    deleteBtn.title = 'Eliminar';
                    deleteBtn.disabled = currentTabs.length <= 1;
                    deleteBtn.addEventListener('click', () => {
                      if (currentTabs.length > 1) {
                        currentTabs.splice(index, 1);
                        renderTabs();
                      }
                    });
                    
                    controlsDiv.appendChild(upBtn);
                    controlsDiv.appendChild(downBtn);
                    controlsDiv.appendChild(deleteBtn);
                    headerDiv.appendChild(tabLabel);
                    headerDiv.appendChild(controlsDiv);
                    
                    const titleInput = document.createElement('input');
                    titleInput.type = 'text';
                    titleInput.className = 'w-full px-3 py-2 border border-gray-300 rounded mb-2';
                    titleInput.placeholder = 'Título de la pestaña';
                    titleInput.value = tab.title || '';
                    titleInput.addEventListener('input', (e) => {
                      currentTabs[index].title = e.target.value;
                    });
                    
                    const contentTextarea = document.createElement('textarea');
                    contentTextarea.className = 'w-full px-3 py-2 border border-gray-300 rounded';
                    contentTextarea.placeholder = 'Contenido de la pestaña';
                    contentTextarea.rows = 3;
                    contentTextarea.value = tab.content || '';
                    contentTextarea.addEventListener('input', (e) => {
                      currentTabs[index].content = e.target.value;
                    });
                    
                    tabDiv.appendChild(headerDiv);
                    tabDiv.appendChild(titleInput);
                    tabDiv.appendChild(contentTextarea);
                    tabsContainer.appendChild(tabDiv);
                  });
                };
                
                renderTabs();
                
                modalContent.appendChild(tabsContainer);
                
                // Botón agregar
                const addBtnDiv = document.createElement('div');
                addBtnDiv.className = 'mt-4 mb-2';
                const addBtn = document.createElement('button');
                addBtn.type = 'button';
                addBtn.className = 'px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700';
                addBtn.textContent = '+ Agregar Pestaña';
                addBtn.addEventListener('click', () => {
                  currentTabs.push({
                    title: `Pestaña ${currentTabs.length + 1}`,
                    content: ''
                  });
                  renderTabs();
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
                  // Actualizar el número de pestañas si es necesario
                  if (currentTabs.length !== parseInt(component.get('tabs-count'))) {
                    component.set('tabs-count', currentTabs.length, { silent: true });
                  }
                  
                  // Actualizar los datos
                  component.set('tabs-data', currentTabs, { silent: true });
                  
                  // Cerrar modal primero
                  document.body.removeChild(modal);
                  
                  // Forzar actualización después de cerrar el modal
                  setTimeout(() => {
                    // Actualizar directamente el DOM sin pasar por updateTabs para evitar bucles
                    if (component.view && component.view.el) {
                      component.renderTabs(component.view.el, currentTabs);
                    }
                    
                    // También actualizar en el iframe del canvas
                    if (window.editor && window.editor.Canvas) {
                      const iframe = window.editor.Canvas.getFrameEl();
                      if (iframe && iframe.contentDocument) {
                        const iframeEl = iframe.contentDocument.querySelector(`[data-gjs-type="tabs"]`);
                        if (iframeEl && component.renderTabs) {
                          component.renderTabs(iframeEl, currentTabs);
                        }
                      }
                      // Forzar actualización del componente
                      window.editor.trigger('component:update', component);
                    }
                    
                    // Re-renderizar la vista
                    if (component.view && component.view.render) {
                      component.view.render();
                    }
                  }, 100);
                });
                
                buttonsDiv.appendChild(cancelBtn);
                buttonsDiv.appendChild(saveBtn);
                modalContent.appendChild(buttonsDiv);
                
                modal.appendChild(modalContent);
                modal.addEventListener('click', (e) => {
                  if (e.target === modal) {
                    document.body.removeChild(modal);
                  }
                });
                
                document.body.appendChild(modal);
              }
            }
          ]
        },
        init() {
          this.on('change:tabs-count', this.updateTabs, this);
          this.on('change:tabs-data', this.updateTabs, this);
          
          // Proteger TODOS los elementos internos
          const protectElements = () => {
            try {
              const protectRecursive = (component) => {
                // Verificar que el componente sea válido y tenga los métodos necesarios
                if (!component || typeof component.set !== 'function' || typeof component.get !== 'function') {
                  return;
                }
                
                try {
                  // No proteger componentes de imagen u otros tipos especiales que tienen métodos específicos
                  const componentType = component.get('type');
                  if (componentType === 'image' || componentType === 'video' || componentType === 'link' || 
                      componentType === 'button' || componentType === 'text' || componentType === 'heading' ||
                      componentType === 'paragraph') {
                    return;
                  }
                  
                  // Solo proteger elementos que son parte directa de nuestro componente (div, span, p, etc.)
                  const tagName = component.get('tagName');
                  if (!tagName || (tagName !== 'div' && tagName !== 'span' && tagName !== 'p' && 
                      tagName !== 'h1' && tagName !== 'h2' && tagName !== 'h3' && tagName !== 'h4' && 
                      tagName !== 'h5' && tagName !== 'h6' && tagName !== 'button' && tagName !== 'nav' &&
                      tagName !== 'section' && tagName !== 'article')) {
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
                  
                  // NO proteger recursivamente para evitar problemas con componentes internos
                  // Solo proteger el nivel directo
                } catch (e) {
                  // Ignorar errores al proteger componentes individuales
                }
              };
              
              if (this.components && typeof this.components === 'function') {
                try {
                  this.components().each(child => {
                    if (child) {
                      protectRecursive(child);
                    }
                  });
                } catch (e) {
                  // Ignorar errores al iterar componentes
                }
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
        updateTabs() {
          const count = parseInt(this.get('tabs-count')) || 3;
          let tabsData = this.get('tabs-data') || [];
          
          // Crear una copia para no modificar el array original
          tabsData = [...tabsData];
          
          // Asegurar que tenemos suficientes datos
          while (tabsData.length < count) {
            tabsData.push({
              title: `Pestaña ${tabsData.length + 1}`,
              content: `Contenido de la Pestaña ${tabsData.length + 1}`
            });
          }
          
          // Reducir si hay demasiados
          if (tabsData.length > count) {
            tabsData.splice(count);
          }
          
          // Solo actualizar si hay cambios (usar silent: true para evitar bucles)
          const currentData = this.get('tabs-data') || [];
          const hasChanges = JSON.stringify(currentData) !== JSON.stringify(tabsData);
          
          if (hasChanges) {
            this.set('tabs-data', tabsData, { silent: true });
          }
          
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          
          // Renderizar las tabs
          this.renderTabs(el, tabsData);
          
          // También actualizar en el iframe del canvas si existe
          try {
            if (window.editor && window.editor.Canvas) {
              const iframe = window.editor.Canvas.getFrameEl();
              if (iframe && iframe.contentDocument) {
                const iframeEl = iframe.contentDocument.querySelector(`[data-gjs-type="tabs"]`);
                if (iframeEl) {
                  this.renderTabs(iframeEl, tabsData);
                }
              }
            }
          } catch (e) {
            console.warn('⚠️ No se pudo actualizar iframe:', e);
          }
          
          // Forzar re-renderizado
          if (this.view.render) {
            setTimeout(() => {
              this.view.render();
            }, 50);
          }
        },
        toHTML() {
          console.log('💾 [Tabs] toHTML() llamado - serializando componente');
          
          const tabsData = this.get('tabs-data') || [];
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
          
          // Construir el HTML de las pestañas
          let innerHTML = '';
          
          if (tabsData && tabsData.length > 0) {
            // Generar un ID único para este componente
            const tabsId = 'tabs-' + Date.now() + '-' + Math.random().toString(36).substr(2, 9);
            
            innerHTML += '<div class="container px-4 mx-auto">';
            
            // Navegación de pestañas
            innerHTML += '<div class="border-b border-gray-200">';
            innerHTML += `<nav class="flex -mb-px space-x-8" data-tabs-id="${tabsId}">`;
            
            tabsData.forEach((tab, index) => {
              const activeClass = index === 0 
                ? 'px-1 py-2 text-sm font-medium text-blue-600 border-b-2 border-blue-500'
                : 'px-1 py-2 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-700';
              const title = (tab.title || `Pestaña ${index + 1}`).replace(/"/g, '&quot;');
              innerHTML += `<button class="${activeClass} tab-button" data-tab-index="${index}" data-tabs-id="${tabsId}" data-gjs-editable="false" data-gjs-selectable="false" contenteditable="false">${title}</button>`;
            });
            
            innerHTML += '</nav>';
            innerHTML += '</div>';
            
            // Contenido de pestañas
            innerHTML += '<div class="mt-6">';
            innerHTML += `<div class="tabs-content-container" data-tabs-id="${tabsId}">`;
            
            tabsData.forEach((tab, index) => {
              const title = (tab.title || `Pestaña ${index + 1}`).replace(/"/g, '&quot;');
              const content = (tab.content || '').replace(/"/g, '&quot;');
              const hiddenClass = index === 0 ? '' : 'hidden';
              
              innerHTML += `<div class="tab-content ${hiddenClass}" data-tab-index="${index}" data-tabs-id="${tabsId}">`;
              innerHTML += `<h3 class="mb-4 text-lg font-medium text-gray-900" data-gjs-editable="false" data-gjs-selectable="false" contenteditable="false">Contenido de la ${title}</h3>`;
              innerHTML += `<p class="text-gray-600" data-gjs-editable="false" data-gjs-selectable="false" contenteditable="false">${content}</p>`;
              innerHTML += '</div>';
            });
            
            innerHTML += '</div>';
            innerHTML += '</div>';
            innerHTML += '</div>';
            
            // Agregar JavaScript para la funcionalidad de cambio de pestañas
            // Agregar JavaScript inline para funcionalidad en la página final
            innerHTML += '<script>';
            innerHTML += '(function() {';
            innerHTML += '  const tabsId = "' + tabsId + '";';
            innerHTML += '  function initTabs() {';
            innerHTML += '    const nav = document.querySelector("[data-tabs-id=\\"" + tabsId + "\\"]");';
            innerHTML += '    const contentContainer = document.querySelector(".tabs-content-container[data-tabs-id=\\"" + tabsId + "\\"]");';
            innerHTML += '    if (nav && contentContainer) {';
            innerHTML += '      const buttons = nav.querySelectorAll(".tab-button[data-tabs-id=\\"" + tabsId + "\\"]");';
            innerHTML += '      buttons.forEach(function(button) {';
            innerHTML += '        button.addEventListener("click", function(e) {';
            innerHTML += '          e.preventDefault();';
            innerHTML += '          const tabIndex = parseInt(this.getAttribute("data-tab-index"));';
            innerHTML += '          buttons.forEach(function(btn) {';
            innerHTML += '            btn.classList.remove("text-blue-600", "border-blue-500");';
            innerHTML += '            btn.classList.add("text-gray-500", "border-transparent");';
            innerHTML += '          });';
            innerHTML += '          this.classList.remove("text-gray-500", "border-transparent");';
            innerHTML += '          this.classList.add("text-blue-600", "border-blue-500");';
            innerHTML += '          const contents = contentContainer.querySelectorAll(".tab-content");';
            innerHTML += '          contents.forEach(function(content) {';
            innerHTML += '            content.classList.add("hidden");';
            innerHTML += '          });';
            innerHTML += '          const targetContent = contentContainer.querySelector(".tab-content[data-tab-index=\\"" + tabIndex + "\\"]");';
            innerHTML += '          if (targetContent) {';
            innerHTML += '            targetContent.classList.remove("hidden");';
            innerHTML += '          }';
            innerHTML += '        });';
            innerHTML += '      });';
            innerHTML += '    }';
            innerHTML += '  }';
            innerHTML += '  if (document.readyState === "loading") {';
            innerHTML += '    document.addEventListener("DOMContentLoaded", initTabs);';
            innerHTML += '  } else {';
            innerHTML += '    initTabs();';
            innerHTML += '  }';
            innerHTML += '})();';
            innerHTML += '</script>';
          }
          
          const finalHTML = `<${tagName}${attrsStr ? ' ' + attrsStr : ''}>${innerHTML}</${tagName}>`;
          
          console.log('✅ [Tabs] toHTML - HTML generado (primeros 200 chars):', finalHTML.substring(0, 200));
          
          return finalHTML;
        },
        renderTabs(container, tabsData) {
          if (!container) return;
          
          // Generar un ID único para este componente
          const tabsId = 'tabs-' + Date.now() + '-' + Math.random().toString(36).substr(2, 9);
          
          // Limpiar contenido existente
          const existingContainer = container.querySelector('.container');
          if (existingContainer) {
            existingContainer.remove();
          }
          
          // Si no hay datos, no renderizar
          if (!tabsData || tabsData.length === 0) {
            return;
          }
          
          // Crear contenedor principal
          const mainContainer = document.createElement('div');
          mainContainer.className = 'container px-4 mx-auto';
          mainContainer.setAttribute('data-gjs-editable', 'false');
          mainContainer.setAttribute('data-gjs-selectable', 'false');
          
          // Crear navegación de pestañas
          const navContainer = document.createElement('div');
          navContainer.className = 'border-b border-gray-200';
          navContainer.setAttribute('data-gjs-editable', 'false');
          navContainer.setAttribute('data-gjs-selectable', 'false');
          
          const nav = document.createElement('nav');
          nav.className = 'flex -mb-px space-x-8';
          nav.setAttribute('data-gjs-editable', 'false');
          nav.setAttribute('data-gjs-selectable', 'false');
          nav.setAttribute('data-tabs-id', tabsId);
          
          tabsData.forEach((tab, index) => {
            const button = document.createElement('button');
            button.className = index === 0 
              ? 'px-1 py-2 text-sm font-medium text-blue-600 border-b-2 border-blue-500 tab-button'
              : 'px-1 py-2 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-700 tab-button';
            button.setAttribute('data-gjs-editable', 'false');
            button.setAttribute('data-gjs-selectable', 'false');
            button.setAttribute('contenteditable', 'false');
            button.setAttribute('data-tab-index', index);
            button.setAttribute('data-tabs-id', tabsId);
            button.textContent = tab.title || `Pestaña ${index + 1}`;
            
            // Agregar event listener para cambio de pestañas
            button.addEventListener('click', function(e) {
              e.preventDefault();
              e.stopPropagation();
              
              const clickedButton = this;
              const tabIndex = parseInt(clickedButton.getAttribute('data-tab-index'));
              const tabsContainer = container.querySelector(`.tabs-content-container[data-tabs-id="${tabsId}"]`);
              
              if (tabsContainer) {
                // Remover clase activa de todos los botones
                const allButtons = nav.querySelectorAll('.tab-button');
                allButtons.forEach(btn => {
                  btn.classList.remove('text-blue-600', 'border-blue-500');
                  btn.classList.add('text-gray-500', 'border-transparent');
                });
                
                // Agregar clase activa al botón clickeado
                clickedButton.classList.remove('text-gray-500', 'border-transparent');
                clickedButton.classList.add('text-blue-600', 'border-blue-500');
                
                // Ocultar todos los contenidos
                const allContents = tabsContainer.querySelectorAll('.tab-content');
                allContents.forEach(content => {
                  content.classList.add('hidden');
                });
                
                // Mostrar el contenido correspondiente
                const targetContent = tabsContainer.querySelector(`.tab-content[data-tab-index="${tabIndex}"]`);
                if (targetContent) {
                  targetContent.classList.remove('hidden');
                }
              }
            });
            
            nav.appendChild(button);
          });
          
          navContainer.appendChild(nav);
          mainContainer.appendChild(navContainer);
          
          // Crear contenido de pestañas
          const contentContainer = document.createElement('div');
          contentContainer.className = 'mt-6';
          contentContainer.setAttribute('data-gjs-editable', 'false');
          contentContainer.setAttribute('data-gjs-selectable', 'false');
          
          const tabsContentContainer = document.createElement('div');
          tabsContentContainer.className = 'tabs-content-container';
          tabsContentContainer.setAttribute('data-gjs-editable', 'false');
          tabsContentContainer.setAttribute('data-gjs-selectable', 'false');
          tabsContentContainer.setAttribute('data-tabs-id', tabsId);
          
          // Crear contenido para cada pestaña
          tabsData.forEach((tab, index) => {
            const tabContent = document.createElement('div');
            tabContent.className = index === 0 ? 'tab-content' : 'tab-content hidden';
            tabContent.setAttribute('data-gjs-editable', 'false');
            tabContent.setAttribute('data-gjs-selectable', 'false');
            tabContent.setAttribute('data-tab-index', index);
            tabContent.setAttribute('data-tabs-id', tabsId);
            
            const h3 = document.createElement('h3');
            h3.className = 'mb-4 text-lg font-medium text-gray-900';
            h3.setAttribute('data-gjs-editable', 'false');
            h3.setAttribute('data-gjs-selectable', 'false');
            h3.setAttribute('contenteditable', 'false');
            h3.textContent = `Contenido de la ${tab.title || `Pestaña ${index + 1}`}`;
            
            const p = document.createElement('p');
            p.className = 'text-gray-600';
            p.setAttribute('data-gjs-editable', 'false');
            p.setAttribute('data-gjs-selectable', 'false');
            p.setAttribute('contenteditable', 'false');
            p.textContent = tab.content || '';
            
            tabContent.appendChild(h3);
            tabContent.appendChild(p);
            tabsContentContainer.appendChild(tabContent);
          });
          
          contentContainer.appendChild(tabsContentContainer);
          mainContainer.appendChild(contentContainer);
          container.appendChild(mainContainer);
        }
      },
      view: {
        onRender() {
          const el = this.el;
          const component = this.model;
          
          // Proteger el contenedor principal
          el.setAttribute('contenteditable', 'false');
          el.setAttribute('data-gjs-editable', 'false');
          
          // Obtener datos de pestañas
          const tabsCount = parseInt(component.get('tabs-count')) || 3;
          let tabsData = component.get('tabs-data') || [];
          
          // Inicializar datos si no existen
          if (!tabsData || tabsData.length === 0) {
            tabsData = [];
            for (let i = 0; i < tabsCount; i++) {
              tabsData.push({
                title: `Pestaña ${i + 1}`,
                content: `Contenido de la Pestaña ${i + 1}`
              });
            }
            component.set('tabs-data', tabsData);
          }
          
          // Renderizar pestañas
          component.renderTabs(el, tabsData);
          
          // Agregar event listeners usando delegación de eventos (más robusto)
          setTimeout(() => {
            const tabsId = el.querySelector('[data-tabs-id]')?.getAttribute('data-tabs-id');
            if (tabsId) {
              const nav = el.querySelector(`[data-tabs-id="${tabsId}"]`);
              const tabsContainer = el.querySelector(`.tabs-content-container[data-tabs-id="${tabsId}"]`);
              
              if (nav && tabsContainer) {
                // Usar delegación de eventos en el nav
                nav.addEventListener('click', function(e) {
                  const button = e.target.closest('.tab-button');
                  if (!button) return;
                  
                  e.preventDefault();
                  e.stopPropagation();
                  
                  const tabIndex = parseInt(button.getAttribute('data-tab-index'));
                  const allButtons = nav.querySelectorAll('.tab-button');
                  
                  // Remover clase activa de todos los botones
                  allButtons.forEach(btn => {
                    btn.classList.remove('text-blue-600', 'border-blue-500');
                    btn.classList.add('text-gray-500', 'border-transparent');
                  });
                  
                  // Agregar clase activa al botón clickeado
                  button.classList.remove('text-gray-500', 'border-transparent');
                  button.classList.add('text-blue-600', 'border-blue-500');
                  
                  // Ocultar todos los contenidos
                  const allContents = tabsContainer.querySelectorAll('.tab-content');
                  allContents.forEach(content => {
                    content.classList.add('hidden');
                  });
                  
                  // Mostrar el contenido correspondiente
                  const targetContent = tabsContainer.querySelector(`.tab-content[data-tab-index="${tabIndex}"]`);
                  if (targetContent) {
                    targetContent.classList.remove('hidden');
                  }
                });
              }
            }
          }, 300);
          
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
          
          this._tabsObserver = observer;
        },
        onRemove() {
          if (this._tabsObserver) {
            this._tabsObserver.disconnect();
          }
        }
      }
    });
    
  }
  
  // Auto-registrar si el editor está disponible
  if (typeof window !== 'undefined' && window.editor) {
    registerTabsComponent(window.editor);
  }
  
  // Exportar para registro manual
  if (typeof window !== 'undefined') {
    window.registerTabsComponent = registerTabsComponent;
  }
})();
