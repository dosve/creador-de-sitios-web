// Módulo del Componente Accordion
// Componente de acordeón estilo Elementor con traits y protección

(function() {
  'use strict';
  
  function registerAccordionComponent(editor) {
    if (!editor || !editor.DomComponents) {
      console.warn('⚠️ Editor no disponible para registrar componente Accordion');
      return;
    }
    
    editor.DomComponents.addType('accordion', {
      isComponent: (el) => {
        // Verificar que el sea un elemento DOM válido
        if (!el || typeof el !== 'object' || !el.nodeType) {
          return false;
        }
        
        if (el.classList && el.classList.contains('accordion')) {
          return { type: 'accordion' };
        }
        if (el.tagName === 'DIV' && el.querySelector && typeof el.querySelector === 'function' && el.querySelector('.accordion')) {
          return { type: 'accordion' };
        }
        return false;
      },
      model: {
        defaults: {
          name: 'Acordeón',
          tagName: 'div',
          editable: false,
          droppable: false,
          removable: true,
          selectable: true,
          badgable: false,
          attributes: {
            class: 'py-8 accordion',
            'data-gjs-type': 'accordion',
            'data-gjs-name': 'Acordeón',
            'data-gjs-editable': 'false'
          },
          'accordion-title': 'Preguntas Frecuentes',
          'accordion-count': 3,
          'accordion-items': [
            { question: '¿Cómo funciona el servicio?', answer: 'Nuestro servicio es muy fácil de usar. Solo necesitas registrarte y seguir los pasos del tutorial.' },
            { question: '¿Qué métodos de pago aceptan?', answer: 'Aceptamos tarjetas de crédito, débito, PayPal y transferencias bancarias.' },
            { question: '¿Puedo cancelar mi suscripción?', answer: 'Sí, puedes cancelar tu suscripción en cualquier momento desde tu panel de control.' }
          ],
          traits: [
            {
              type: 'text',
              name: 'accordion-title',
              label: 'Título del Acordeón',
              placeholder: 'Preguntas Frecuentes',
              changeProp: 1
            },
            {
              type: 'number',
              name: 'accordion-count',
              label: 'Número de Items',
              min: 1,
              max: 10,
              changeProp: 1
            },
            {
              type: 'button',
              name: 'accordion-manage',
              label: 'Gestionar Items',
              text: 'Editar Items',
              command: (editor) => {
                if (!editor) return;
                const component = editor.getSelected();
                if (!component || component.get('type') !== 'accordion') return;
                
                const items = component.get('accordion-items') || [];
                const count = parseInt(component.get('accordion-count')) || 3;
                
                // Asegurar que tenemos suficientes items
                let currentItems = [...items];
                while (currentItems.length < count) {
                  currentItems.push({
                    question: `¿Pregunta ${currentItems.length + 1}?`,
                    answer: `Respuesta ${currentItems.length + 1}`
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
                title.textContent = 'Gestionar Items del Acordeón';
                modalContent.appendChild(title);
                
                const itemsContainer = document.createElement('div');
                itemsContainer.className = 'space-y-4';
                
                // Función para renderizar los items
                const renderItems = () => {
                  itemsContainer.innerHTML = '';
                  
                  currentItems.forEach((item, index) => {
                    const itemDiv = document.createElement('div');
                    itemDiv.className = 'border border-gray-300 rounded p-4';
                    itemDiv.setAttribute('data-item-index', index);
                    
                    // Header con controles
                    const headerDiv = document.createElement('div');
                    headerDiv.className = 'flex justify-between items-center mb-2';
                    
                    const itemLabel = document.createElement('label');
                    itemLabel.className = 'block text-sm font-medium';
                    itemLabel.textContent = `Item ${index + 1}`;
                    
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
                        [currentItems[index], currentItems[index - 1]] = [currentItems[index - 1], currentItems[index]];
                        renderItems();
                      }
                    });
                    
                    // Botón bajar
                    const downBtn = document.createElement('button');
                    downBtn.type = 'button';
                    downBtn.className = 'px-2 py-1 text-xs bg-gray-200 hover:bg-gray-300 rounded';
                    downBtn.innerHTML = '↓';
                    downBtn.title = 'Mover abajo';
                    downBtn.disabled = index === currentItems.length - 1;
                    downBtn.addEventListener('click', () => {
                      if (index < currentItems.length - 1) {
                        [currentItems[index], currentItems[index + 1]] = [currentItems[index + 1], currentItems[index]];
                        renderItems();
                      }
                    });
                    
                    // Botón eliminar
                    const deleteBtn = document.createElement('button');
                    deleteBtn.type = 'button';
                    deleteBtn.className = 'px-2 py-1 text-xs bg-red-200 hover:bg-red-300 text-red-800 rounded';
                    deleteBtn.innerHTML = '✕';
                    deleteBtn.title = 'Eliminar';
                    deleteBtn.disabled = currentItems.length <= 1;
                    deleteBtn.addEventListener('click', () => {
                      if (currentItems.length > 1) {
                        currentItems.splice(index, 1);
                        renderItems();
                      }
                    });
                    
                    controlsDiv.appendChild(upBtn);
                    controlsDiv.appendChild(downBtn);
                    controlsDiv.appendChild(deleteBtn);
                    headerDiv.appendChild(itemLabel);
                    headerDiv.appendChild(controlsDiv);
                    
                    const questionInput = document.createElement('input');
                    questionInput.type = 'text';
                    questionInput.className = 'w-full px-3 py-2 border border-gray-300 rounded mb-2';
                    questionInput.placeholder = 'Pregunta';
                    questionInput.value = item.question || '';
                    questionInput.addEventListener('input', (e) => {
                      currentItems[index].question = e.target.value;
                    });
                    
                    const answerTextarea = document.createElement('textarea');
                    answerTextarea.className = 'w-full px-3 py-2 border border-gray-300 rounded';
                    answerTextarea.placeholder = 'Respuesta';
                    answerTextarea.rows = 3;
                    answerTextarea.value = item.answer || '';
                    answerTextarea.addEventListener('input', (e) => {
                      currentItems[index].answer = e.target.value;
                    });
                    
                    itemDiv.appendChild(headerDiv);
                    itemDiv.appendChild(questionInput);
                    itemDiv.appendChild(answerTextarea);
                    itemsContainer.appendChild(itemDiv);
                  });
                };
                
                renderItems();
                
                modalContent.appendChild(itemsContainer);
                
                // Botón agregar
                const addBtnDiv = document.createElement('div');
                addBtnDiv.className = 'mt-4 mb-2';
                const addBtn = document.createElement('button');
                addBtn.type = 'button';
                addBtn.className = 'px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700';
                addBtn.textContent = '+ Agregar Item';
                addBtn.addEventListener('click', () => {
                  currentItems.push({
                    question: `¿Pregunta ${currentItems.length + 1}?`,
                    answer: `Respuesta ${currentItems.length + 1}`
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
                  // Actualizar los datos
                  component.set('accordion-items', currentItems, { silent: true });
                  
                  // Cerrar modal primero
                  document.body.removeChild(modal);
                  
                  // Forzar actualización después de cerrar el modal
                  setTimeout(() => {
                    // Actualizar directamente el DOM sin pasar por updateItems para evitar bucles
                    if (component.view && component.view.el) {
                      component.renderItems(component.view.el, currentItems);
                    }
                    
                    // También actualizar en el iframe del canvas
                    if (window.editor && window.editor.Canvas) {
                      const iframe = window.editor.Canvas.getFrameEl();
                      if (iframe && iframe.contentDocument) {
                        const iframeEl = iframe.contentDocument.querySelector(`[data-gjs-type="accordion"]`);
                        if (iframeEl && component.renderItems) {
                          component.renderItems(iframeEl, currentItems);
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
          this.on('change:accordion-title', this.updateTitle, this);
          this.on('change:accordion-count', this.updateItems, this);
          
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
        updateTitle() {
          const title = this.get('accordion-title') || 'Preguntas Frecuentes';
          
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          const titleH2 = el.querySelector('h2');
          
          if (titleH2) {
            titleH2.textContent = title;
          }
          
          this.view.render();
        },
        updateItems() {
          const count = parseInt(this.get('accordion-count')) || 3;
          let items = this.get('accordion-items') || [];
          
          // Asegurar que tenemos suficientes items
          while (items.length < count) {
            items.push({
              question: `¿Pregunta ${items.length + 1}?`,
              answer: `Respuesta ${items.length + 1}`
            });
          }
          
          // Reducir si hay demasiados
          if (items.length > count) {
            items.splice(count);
          }
          
          this.set('accordion-items', items);
          
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          this.renderItems(el, items);
          
          this.view.render();
        },
        renderItems(container, items) {
          // Buscar o crear contenedor de items
          let itemsContainer = container.querySelector('.space-y-4');
          
          if (!itemsContainer) {
            // Crear estructura si no existe
            const mainContainer = container.querySelector('.container') || document.createElement('div');
            if (!container.querySelector('.container')) {
              mainContainer.className = 'container max-w-4xl px-4 mx-auto';
              mainContainer.setAttribute('data-gjs-editable', 'false');
              mainContainer.setAttribute('data-gjs-selectable', 'false');
              
              const titleH2 = document.createElement('h2');
              titleH2.className = 'mb-8 text-3xl font-bold text-center';
              titleH2.setAttribute('data-gjs-editable', 'false');
              titleH2.setAttribute('data-gjs-selectable', 'false');
              titleH2.setAttribute('contenteditable', 'false');
              titleH2.textContent = this.get('accordion-title') || 'Preguntas Frecuentes';
              
              itemsContainer = document.createElement('div');
              itemsContainer.className = 'space-y-4';
              itemsContainer.setAttribute('data-gjs-editable', 'false');
              itemsContainer.setAttribute('data-gjs-selectable', 'false');
              
              mainContainer.appendChild(titleH2);
              mainContainer.appendChild(itemsContainer);
              container.appendChild(mainContainer);
            } else {
              itemsContainer = mainContainer.querySelector('.space-y-4');
              if (!itemsContainer) {
                itemsContainer = document.createElement('div');
                itemsContainer.className = 'space-y-4';
                itemsContainer.setAttribute('data-gjs-editable', 'false');
                itemsContainer.setAttribute('data-gjs-selectable', 'false');
                mainContainer.appendChild(itemsContainer);
              }
            }
          }
          
          // Limpiar items existentes
          itemsContainer.innerHTML = '';
          
          // Crear items
          items.forEach((item, index) => {
            const itemDiv = document.createElement('div');
            itemDiv.className = 'border border-gray-200 rounded-lg';
            itemDiv.setAttribute('data-gjs-editable', 'false');
            itemDiv.setAttribute('data-gjs-selectable', 'false');
            
            const button = document.createElement('button');
            button.className = 'flex items-center justify-between w-full px-6 py-4 font-medium text-left accordion-button';
            button.setAttribute('data-gjs-editable', 'false');
            button.setAttribute('data-gjs-selectable', 'false');
            button.setAttribute('contenteditable', 'false');
            button.setAttribute('data-accordion-index', index);
            button.type = 'button';
            
            const questionSpan = document.createElement('span');
            questionSpan.setAttribute('data-gjs-editable', 'false');
            questionSpan.setAttribute('data-gjs-selectable', 'false');
            questionSpan.setAttribute('contenteditable', 'false');
            questionSpan.textContent = item.question;
            
            const iconSpan = document.createElement('span');
            iconSpan.className = 'accordion-icon';
            iconSpan.setAttribute('data-gjs-editable', 'false');
            iconSpan.setAttribute('data-gjs-selectable', 'false');
            iconSpan.setAttribute('contenteditable', 'false');
            iconSpan.textContent = index === 0 ? '−' : '+';
            
            button.appendChild(questionSpan);
            button.appendChild(iconSpan);
            
            const answerDiv = document.createElement('div');
            answerDiv.className = index === 0 ? 'px-6 pb-4 text-gray-600 accordion-content' : 'hidden px-6 pb-4 text-gray-600 accordion-content';
            answerDiv.setAttribute('data-gjs-editable', 'false');
            answerDiv.setAttribute('data-gjs-selectable', 'false');
            answerDiv.setAttribute('contenteditable', 'false');
            answerDiv.setAttribute('data-accordion-index', index);
            answerDiv.textContent = item.answer;
            
            // Agregar event listener para toggle del acordeón
            button.addEventListener('click', function(e) {
              e.preventDefault();
              e.stopPropagation();
              
              const clickedButton = this;
              const accordionIndex = parseInt(clickedButton.getAttribute('data-accordion-index'));
              const targetContent = clickedButton.nextElementSibling;
              const icon = clickedButton.querySelector('.accordion-icon');
              
              if (targetContent && targetContent.classList.contains('accordion-content')) {
                // Toggle del contenido
                if (targetContent.classList.contains('hidden')) {
                  targetContent.classList.remove('hidden');
                  if (icon) icon.textContent = '−';
                } else {
                  targetContent.classList.add('hidden');
                  if (icon) icon.textContent = '+';
                }
              }
            });
            
            itemDiv.appendChild(button);
            itemDiv.appendChild(answerDiv);
            itemsContainer.appendChild(itemDiv);
          });
        },
        toHTML() {
          console.log('💾 [Accordion] toHTML() llamado - serializando componente');
          
          const items = this.get('accordion-items') || [];
          const title = this.get('accordion-title') || 'Preguntas Frecuentes';
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
          
          // Construir el HTML del acordeón
          let innerHTML = '';
          
          innerHTML += '<div class="container max-w-4xl px-4 mx-auto">';
          innerHTML += `<h2 class="mb-8 text-3xl font-bold text-center" data-gjs-editable="false" data-gjs-selectable="false" contenteditable="false">${title.replace(/"/g, '&quot;')}</h2>`;
          innerHTML += '<div class="space-y-4">';
          
          items.forEach((item, index) => {
            const question = (item.question || `¿Pregunta ${index + 1}?`).replace(/"/g, '&quot;');
            const answer = (item.answer || '').replace(/"/g, '&quot;');
            const hiddenClass = index === 0 ? '' : 'hidden';
            
            innerHTML += '<div class="border border-gray-200 rounded-lg">';
            innerHTML += `<button class="flex items-center justify-between w-full px-6 py-4 font-medium text-left accordion-button" data-gjs-editable="false" data-gjs-selectable="false" contenteditable="false">`;
            innerHTML += `<span data-gjs-editable="false" data-gjs-selectable="false" contenteditable="false">${question}</span>`;
            innerHTML += `<span class="accordion-icon" data-gjs-editable="false" data-gjs-selectable="false" contenteditable="false">${index === 0 ? '−' : '+'}</span>`;
            innerHTML += '</button>';
            innerHTML += `<div class="${hiddenClass} px-6 pb-4 text-gray-600 accordion-content" data-gjs-editable="false" data-gjs-selectable="false" contenteditable="false">${answer}</div>`;
            innerHTML += '</div>';
          });
          
          innerHTML += '</div>';
          innerHTML += '</div>';
          
          // Agregar JavaScript inline para funcionalidad en la página final
          innerHTML += '<script>';
          innerHTML += '(function() {';
          innerHTML += '  function initAccordion() {';
          innerHTML += '    const buttons = document.querySelectorAll(".accordion-button");';
          innerHTML += '    buttons.forEach(function(button) {';
          innerHTML += '      button.addEventListener("click", function(e) {';
          innerHTML += '        e.preventDefault();';
          innerHTML += '        const content = this.nextElementSibling;';
          innerHTML += '        const icon = this.querySelector(".accordion-icon");';
          innerHTML += '        if (content && content.classList.contains("accordion-content")) {';
          innerHTML += '          if (content.classList.contains("hidden")) {';
          innerHTML += '            content.classList.remove("hidden");';
          innerHTML += '            if (icon) icon.textContent = "−";';
          innerHTML += '          } else {';
          innerHTML += '            content.classList.add("hidden");';
          innerHTML += '            if (icon) icon.textContent = "+";';
          innerHTML += '          }';
          innerHTML += '        }';
          innerHTML += '      });';
          innerHTML += '    });';
          innerHTML += '  }';
          innerHTML += '  if (document.readyState === "loading") {';
          innerHTML += '    document.addEventListener("DOMContentLoaded", initAccordion);';
          innerHTML += '  } else {';
          innerHTML += '    initAccordion();';
          innerHTML += '  }';
          innerHTML += '})();';
          innerHTML += '</script>';
          
          const finalHTML = `<${tagName}${attrsStr ? ' ' + attrsStr : ''}>${innerHTML}</${tagName}>`;
          
          console.log('✅ [Accordion] toHTML - HTML generado (primeros 200 chars):', finalHTML.substring(0, 200));
          
          return finalHTML;
        }
      },
      view: {
        onRender() {
          const el = this.el;
          const component = this.model;
          
          // Proteger el contenedor principal
          el.setAttribute('contenteditable', 'false');
          el.setAttribute('data-gjs-editable', 'false');
          
          // Obtener datos
          const count = parseInt(component.get('accordion-count')) || 3;
          let items = component.get('accordion-items') || [];
          
          // Inicializar items si no existen
          if (!items || items.length === 0) {
            items = [];
            for (let i = 0; i < count; i++) {
              items.push({
                question: `¿Pregunta ${i + 1}?`,
                answer: `Respuesta ${i + 1}`
              });
            }
            component.set('accordion-items', items);
          }
          
          // Renderizar items
          component.renderItems(el, items);
          
          // Agregar event listeners usando delegación de eventos (más robusto)
          setTimeout(() => {
            // Usar delegación de eventos en el contenedor principal
            el.addEventListener('click', function(e) {
              const button = e.target.closest('.accordion-button');
              if (!button) return;
              
              e.preventDefault();
              e.stopPropagation();
              
              const content = button.nextElementSibling;
              const icon = button.querySelector('.accordion-icon');
              
              if (content && content.classList.contains('accordion-content')) {
                // Toggle del contenido
                if (content.classList.contains('hidden')) {
                  content.classList.remove('hidden');
                  if (icon) icon.textContent = '−';
                } else {
                  content.classList.add('hidden');
                  if (icon) icon.textContent = '+';
                }
              }
            });
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
          
          this._accordionObserver = observer;
        },
        onRemove() {
          if (this._accordionObserver) {
            this._accordionObserver.disconnect();
          }
        }
      }
    });
    
  }
  
  // Auto-registrar si el editor está disponible
  if (typeof window !== 'undefined' && window.editor) {
    registerAccordionComponent(window.editor);
  }
  
  // Exportar para registro manual
  if (typeof window !== 'undefined') {
    window.registerAccordionComponent = registerAccordionComponent;
  }
})();
