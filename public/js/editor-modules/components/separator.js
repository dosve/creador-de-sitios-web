// Módulo del Componente Separator
// Componente de separador estilo Elementor con traits y protección

(function() {
  'use strict';
  
  function registerSeparatorComponent(editor) {
    if (!editor || !editor.DomComponents) {
      console.warn('⚠️ Editor no disponible para registrar componente Separator');
      return;
    }
    
    editor.DomComponents.addType('separator', {
      isComponent: (el) => {
        // Verificar que el sea un elemento DOM válido
        if (!el || typeof el !== 'object' || !el.nodeType) {
          return false;
        }
        
        if (el.classList && el.classList.contains('separator-container')) {
          return { type: 'separator' };
        }
        if (el.tagName === 'DIV' && el.querySelector && typeof el.querySelector === 'function' && el.querySelector('.separator-container')) {
          return { type: 'separator' };
        }
        return false;
      },
      model: {
        defaults: {
          name: 'Separador',
          tagName: 'div',
          editable: false,
          droppable: false,
          removable: true,
          selectable: true,
          badgable: false,
          attributes: {
            class: 'separator-container my-8',
            'data-gjs-type': 'separator',
            'data-gjs-name': 'Separador',
            'data-gjs-editable': 'false'
          },
          'separator-style': 'border-t-2 border-gray-300',
          'separator-width': 'w-full',
          'separator-align': 'mx-auto',
          'separator-spacing': 'my-8',
          traits: [
            {
              type: 'select',
              name: 'separator-style',
              label: 'Estilo del Separador',
              changeProp: 1,
              options: [
                { value: 'border-t-2 border-gray-300', name: 'Línea Gruesa Gris' },
                { value: 'border-t border-gray-300', name: 'Línea Sólida Gris' },
                { value: 'border-t-2 border-gray-400', name: 'Línea Muy Gruesa Gris' },
                { value: 'border-t-2 border-blue-500', name: 'Línea Gruesa Azul' },
                { value: 'border-t border-blue-500', name: 'Línea Azul' },
                { value: 'border-t-2 border-dashed border-gray-300', name: 'Línea Discontinua Gruesa' },
                { value: 'border-t border-dashed border-gray-300', name: 'Línea Discontinua' },
                { value: 'border-t-2 border-dotted border-gray-300', name: 'Línea Punteada Gruesa' },
                { value: 'border-t border-dotted border-gray-300', name: 'Línea Punteada' }
              ]
            },
            {
              type: 'select',
              name: 'separator-width',
              label: 'Ancho',
              changeProp: 1,
              options: [
                { value: 'w-full', name: 'Completo (100%)' },
                { value: 'w-3/4', name: 'Tres Cuartos (75%)' },
                { value: 'w-1/2', name: 'Mitad (50%)' },
                { value: 'w-1/3', name: 'Un Tercio (33%)' },
                { value: 'w-1/4', name: 'Un Cuarto (25%)' },
                { value: 'w-64', name: '256px' },
                { value: 'w-48', name: '192px' }
              ]
            },
            {
              type: 'select',
              name: 'separator-align',
              label: 'Alineación',
              changeProp: 1,
              options: [
                { value: 'mx-auto', name: 'Centro' },
                { value: 'ml-auto', name: 'Derecha' },
                { value: 'mr-auto', name: 'Izquierda' }
              ]
            },
            {
              type: 'select',
              name: 'separator-spacing',
              label: 'Espaciado Vertical',
              changeProp: 1,
              options: [
                { value: 'my-0', name: 'Sin Espaciado' },
                { value: 'my-2', name: 'Muy Pequeño (8px)' },
                { value: 'my-4', name: 'Pequeño (16px)' },
                { value: 'my-6', name: 'Normal (24px)' },
                { value: 'my-8', name: 'Grande (32px)' },
                { value: 'my-12', name: 'Muy Grande (48px)' },
                { value: 'my-16', name: 'Extra Grande (64px)' }
              ]
            }
          ]
        },
        init() {
          this.on('change:separator-style', this.updateStyle, this);
          this.on('change:separator-width', this.updateWidth, this);
          this.on('change:separator-align', this.updateAlign, this);
          this.on('change:separator-spacing', this.updateSpacing, this);
        },
        updateStyle() {
          const style = this.get('separator-style') || 'border-t-2 border-gray-300';
          console.log('🎨 Actualizando estilo del separador:', style);
          
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          const hr = el.querySelector('hr');
          
          if (hr) {
            // Remover todas las clases de estilo
            hr.className = hr.className
              .replace(/border-t(-\d+)?/g, '')
              .replace(/border-(gray|blue|red|green|purple)-\d+/g, '')
              .replace(/border-(dashed|dotted|solid)/g, '')
              .trim();
            
            // Agregar el nuevo estilo
            const styleClasses = style.split(' ');
            styleClasses.forEach(cls => {
              if (cls.trim()) {
                hr.classList.add(cls.trim());
              }
            });
          }
        },
        updateWidth() {
          const width = this.get('separator-width') || 'w-full';
          console.log('📏 Actualizando ancho del separador:', width);
          
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          const hr = el.querySelector('hr');
          
          if (hr) {
            // Remover todas las clases de ancho
            hr.className = hr.className
              .replace(/w-(full|auto|\d+|1\/2|1\/3|1\/4|2\/3|3\/4)/g, '')
              .trim();
            
            // Agregar el nuevo ancho
            hr.classList.add(width);
          }
        },
        updateAlign() {
          const align = this.get('separator-align') || 'mx-auto';
          console.log('📍 Actualizando alineación del separador:', align);
          
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          const hr = el.querySelector('hr');
          
          if (hr) {
            // Remover todas las clases de alineación
            hr.className = hr.className
              .replace(/m(x|l|r)-(auto|0)/g, '')
              .trim();
            
            // Agregar la nueva alineación
            hr.classList.add(align);
          }
        },
        updateSpacing() {
          const spacing = this.get('separator-spacing') || 'my-8';
          console.log('📐 Actualizando espaciado del separador:', spacing);
          
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          
          // Remover todas las clases de espaciado del contenedor
          el.className = el.className
            .replace(/m(y|x|t|b|r|l)-\d+/g, '')
            .trim();
          
          // Agregar el nuevo espaciado
          el.classList.add(spacing);
        }
      },
      view: {
        onRender() {
          const el = this.el;
          console.log('🎨 Vista de Separator renderizada');
          
          // Proteger el contenedor principal
          el.setAttribute('contenteditable', 'false');
          el.setAttribute('data-gjs-editable', 'false');
          
          // Asegurar que existe el hr dentro
          let hr = el.querySelector('hr');
          if (!hr) {
            hr = document.createElement('hr');
            hr.className = this.model.get('separator-style') || 'border-t-2 border-gray-300';
            hr.classList.add(this.model.get('separator-width') || 'w-full');
            hr.classList.add(this.model.get('separator-align') || 'mx-auto');
            el.appendChild(hr);
          }
          
          // Proteger el hr
          hr.setAttribute('contenteditable', 'false');
          hr.setAttribute('data-gjs-editable', 'false');
          hr.setAttribute('data-gjs-selectable', 'false');
          hr.setAttribute('data-gjs-draggable', 'false');
          hr.setAttribute('data-gjs-droppable', 'false');
          hr.setAttribute('data-gjs-removable', 'false');
          
          // Aplicar valores iniciales
          const style = this.model.get('separator-style') || 'border-t-2 border-gray-300';
          const width = this.model.get('separator-width') || 'w-full';
          const align = this.model.get('separator-align') || 'mx-auto';
          const spacing = this.model.get('separator-spacing') || 'my-8';
          
          // Limpiar y aplicar clases
          hr.className = `${style} ${width} ${align}`;
          el.className = `separator-container ${spacing}`;
          
          console.log('✅ Vista de Separator lista');
        }
      }
    });
    
  }
  
  // Auto-registrar si el editor está disponible
  if (typeof window !== 'undefined' && window.editor) {
    registerSeparatorComponent(window.editor);
  }
  
  // Exportar para registro manual
  if (typeof window !== 'undefined') {
    window.registerSeparatorComponent = registerSeparatorComponent;
  }
})();
