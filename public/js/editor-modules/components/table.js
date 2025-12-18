// Módulo del Componente Table
// Componente de tabla estilo Elementor con traits y protección

(function() {
  'use strict';
  
  function registerTableComponent(editor) {
    if (!editor || !editor.DomComponents) {
      console.warn('⚠️ Editor no disponible para registrar componente Table');
      return;
    }
    
    editor.DomComponents.addType('table', {
      isComponent: (el) => {
        // Verificar que el sea un elemento DOM válido
        if (!el || typeof el !== 'object' || !el.nodeType) {
          return false;
        }
        
        if (el.tagName === 'TABLE') {
          return { type: 'table' };
        }
        
        if (el.querySelector && typeof el.querySelector === 'function' && el.querySelector('table')) {
          return { type: 'table' };
        }
        
        if (el.classList && el.classList.contains('table-container')) {
          return { type: 'table' };
        }
        
        return false;
      },
      model: {
        defaults: {
          name: 'Tabla',
          tagName: 'div',
          editable: false,
          droppable: false,
          removable: true,
          selectable: true,
          badgable: false,
          attributes: {
            class: 'table-container overflow-x-auto',
            'data-gjs-type': 'table',
            'data-gjs-name': 'Tabla',
            'data-gjs-editable': 'false'
          },
          'table-rows': 2,
          'table-cols': 3,
          'table-style': 'default',
          'table-header': true,
          traits: [
            {
              type: 'number',
              name: 'table-rows',
              label: 'Número de Filas',
              changeProp: 1,
              min: 1,
              max: 20,
              step: 1
            },
            {
              type: 'number',
              name: 'table-cols',
              label: 'Número de Columnas',
              changeProp: 1,
              min: 1,
              max: 10,
              step: 1
            },
            {
              type: 'checkbox',
              name: 'table-header',
              label: 'Mostrar Encabezado',
              changeProp: 1
            },
            {
              type: 'select',
              name: 'table-style',
              label: 'Estilo de la Tabla',
              changeProp: 1,
              options: [
                { value: 'default', name: 'Por Defecto' },
                { value: 'striped', name: 'Rayada (Zebra)' },
                { value: 'bordered', name: 'Con Bordes' },
                { value: 'minimal', name: 'Minimalista' }
              ]
            }
          ]
        },
        init() {
          this.on('change:table-rows', this.updateTable, this);
          this.on('change:table-cols', this.updateTable, this);
          this.on('change:table-header', this.updateTable, this);
          this.on('change:table-style', this.updateStyle, this);
          
          // Proteger TODOS los elementos internos - NO edición directa
          const protectElements = () => {
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
              component.addAttributes({
                'data-gjs-editable': 'false',
                'data-gjs-selectable': 'false',
                'data-gjs-draggable': 'false',
                'data-gjs-droppable': 'false',
                'data-gjs-removable': 'false',
                'contenteditable': 'false'
              });
              
              // Proteger recursivamente todos los hijos
              component.components().each(grandchild => {
                protectRecursive(grandchild);
              });
            };
            
            this.components().each(child => {
              protectRecursive(child);
            });
          };
          
          setTimeout(protectElements, 100);
          this.on('component:mount', protectElements);
          this.on('component:add', () => {
            setTimeout(protectElements, 100);
          });
        },
        updateTable() {
          const rows = parseInt(this.get('table-rows')) || 2;
          const cols = parseInt(this.get('table-cols')) || 3;
          const hasHeader = this.get('table-header') !== false;
          
          console.log('📊 Actualizando tabla:', { rows, cols, hasHeader });
          
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          let table = el.querySelector('table');
          
          if (!table) {
            // Crear tabla si no existe
            table = document.createElement('table');
            table.className = 'min-w-full bg-white border border-gray-200 rounded-lg';
            el.appendChild(table);
          }
          
          // Limpiar tabla existente
          table.innerHTML = '';
          
          // Crear encabezado si está habilitado
          if (hasHeader) {
            const thead = document.createElement('thead');
            thead.className = 'bg-gray-50';
            const headerRow = document.createElement('tr');
            
            for (let i = 0; i < cols; i++) {
              const th = document.createElement('th');
              th.className = 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider';
              th.setAttribute('data-gjs-editable', 'false');
              th.setAttribute('data-gjs-selectable', 'false');
              th.setAttribute('contenteditable', 'false');
              th.textContent = `Columna ${i + 1}`;
              headerRow.appendChild(th);
            }
            
            thead.appendChild(headerRow);
            table.appendChild(thead);
          }
          
          // Crear cuerpo de la tabla
          const tbody = document.createElement('tbody');
          tbody.className = 'divide-y divide-gray-200';
          
          for (let r = 0; r < rows; r++) {
            const tr = document.createElement('tr');
            
            for (let c = 0; c < cols; c++) {
              const td = document.createElement('td');
              td.className = 'px-6 py-4 whitespace-nowrap text-sm text-gray-500';
              td.setAttribute('data-gjs-editable', 'false');
              td.setAttribute('data-gjs-selectable', 'false');
              td.setAttribute('contenteditable', 'false');
              td.textContent = `Fila ${r + 1}, Col ${c + 1}`;
              tr.appendChild(td);
            }
            
            tbody.appendChild(tr);
          }
          
          table.appendChild(tbody);
          
          // Aplicar estilo
          this.updateStyle();
        },
        updateStyle() {
          const style = this.get('table-style') || 'default';
          console.log('🎨 Actualizando estilo de tabla:', style);
          
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          const table = el.querySelector('table');
          
          if (!table) return;
          
          // Remover estilos anteriores
          table.className = 'min-w-full bg-white rounded-lg';
          
          // Aplicar nuevo estilo
          switch(style) {
            case 'default':
              table.classList.add('border', 'border-gray-200');
              break;
            case 'striped':
              table.classList.add('border', 'border-gray-200');
              const tbody = table.querySelector('tbody');
              if (tbody) {
                const rows = tbody.querySelectorAll('tr');
                rows.forEach((row, index) => {
                  if (index % 2 === 0) {
                    row.classList.add('bg-gray-50');
                  } else {
                    row.classList.remove('bg-gray-50');
                  }
                });
              }
              break;
            case 'bordered':
              table.classList.add('border', 'border-gray-300');
              const allCells = table.querySelectorAll('th, td');
              allCells.forEach(cell => {
                cell.classList.add('border', 'border-gray-200');
              });
              break;
            case 'minimal':
              table.classList.remove('border', 'border-gray-200');
              break;
          }
        }
      },
      view: {
        onRender() {
          const el = this.el;
          console.log('📊 Vista de Table renderizada');
          
          // Proteger el contenedor principal
          el.setAttribute('contenteditable', 'false');
          el.setAttribute('data-gjs-editable', 'false');
          
          // Asegurar que existe la tabla
          let table = el.querySelector('table');
          if (!table) {
            // Si no existe, crear estructura inicial
            const component = this.model;
            const rows = parseInt(component.get('table-rows')) || 2;
            const cols = parseInt(component.get('table-cols')) || 3;
            const hasHeader = component.get('table-header') !== false;
            
            table = document.createElement('table');
            table.className = 'min-w-full bg-white border border-gray-200 rounded-lg';
            
            if (hasHeader) {
              const thead = document.createElement('thead');
              thead.className = 'bg-gray-50';
              const headerRow = document.createElement('tr');
              
              for (let i = 0; i < cols; i++) {
                const th = document.createElement('th');
                th.className = 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider';
                th.setAttribute('data-gjs-editable', 'false');
                th.setAttribute('data-gjs-selectable', 'false');
                th.setAttribute('contenteditable', 'false');
                th.textContent = `Columna ${i + 1}`;
                headerRow.appendChild(th);
              }
              
              thead.appendChild(headerRow);
              table.appendChild(thead);
            }
            
            const tbody = document.createElement('tbody');
            tbody.className = 'divide-y divide-gray-200';
            
            for (let r = 0; r < rows; r++) {
              const tr = document.createElement('tr');
              
              for (let c = 0; c < cols; c++) {
                const td = document.createElement('td');
                td.className = 'px-6 py-4 whitespace-nowrap text-sm text-gray-500';
                td.setAttribute('data-gjs-editable', 'false');
                td.setAttribute('data-gjs-selectable', 'false');
                td.setAttribute('contenteditable', 'false');
                td.textContent = `Fila ${r + 1}, Col ${c + 1}`;
                tr.appendChild(td);
              }
              
              tbody.appendChild(tr);
            }
            
            table.appendChild(tbody);
            el.appendChild(table);
          }
          
          // Proteger TODOS los elementos de la tabla
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
          
          // Observar cambios en el DOM
          const observer = new MutationObserver(() => {
            protectAllElements(el);
          });
          
          observer.observe(el, {
            childList: true,
            subtree: true
          });
          
          this._tableObserver = observer;
          
          console.log('✅ Vista de Table lista');
        },
        onRemove() {
          if (this._tableObserver) {
            this._tableObserver.disconnect();
          }
        }
      }
    });
    
  }
  
  // Auto-registrar si el editor está disponible
  if (typeof window !== 'undefined' && window.editor) {
    registerTableComponent(window.editor);
  }
  
  // Exportar para registro manual
  if (typeof window !== 'undefined') {
    window.registerTableComponent = registerTableComponent;
  }
})();
