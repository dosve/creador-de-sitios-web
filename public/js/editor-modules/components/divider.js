// Módulo del Componente Divider
// Componente de divisor estilo Elementor con traits y protección

(function() {
  'use strict';
  
  function registerDividerComponent(editor) {
    if (!editor || !editor.DomComponents) {
      console.warn('⚠️ Editor no disponible para registrar componente Divider');
      return;
    }
    
    editor.DomComponents.addType('divider', {
      isComponent: (el) => {
        if (el.classList && el.classList.contains('divider-component')) {
          return { type: 'divider' };
        }
        if (el.tagName === 'HR') {
          return { type: 'divider' };
        }
        return false;
      },
      model: {
        defaults: {
          name: 'Divisor',
          tagName: 'hr',
          editable: false,
          droppable: false,
          removable: true,
          selectable: true,
          attributes: {
            class: 'divider-component border-t border-gray-300 my-4 w-full',
            'data-gjs-name': 'Divisor',
            'data-gjs-editable': 'false'
          },
          traits: [
            {
              type: 'select',
              name: 'divider-style',
              label: 'Estilo del Divisor',
              changeProp: 1,
              options: [
                { value: 'border-t border-gray-300', name: 'Línea Sólida Gris' },
                { value: 'border-t-2 border-gray-400', name: 'Línea Gruesa Gris' },
                { value: 'border-t border-blue-500', name: 'Línea Azul' },
                { value: 'border-t-2 border-blue-600', name: 'Línea Gruesa Azul' },
                { value: 'border-t border-dashed border-gray-300', name: 'Línea Discontinua' },
                { value: 'border-t border-dotted border-gray-300', name: 'Línea Punteada' }
              ]
            },
            {
              type: 'select',
              name: 'divider-width',
              label: 'Ancho',
              changeProp: 1,
              options: [
                { value: 'w-full', name: 'Completo (100%)' },
                { value: 'w-3/4', name: '75%' },
                { value: 'w-1/2', name: '50%' },
                { value: 'w-1/4', name: '25%' },
                { value: 'w-64', name: '256px' },
                { value: 'w-48', name: '192px' }
              ]
            },
            {
              type: 'select',
              name: 'divider-align',
              label: 'Alineación',
              changeProp: 1,
              options: [
                { value: 'mx-0', name: 'Izquierda' },
                { value: 'mx-auto', name: 'Centro' },
                { value: 'ml-auto mr-0', name: 'Derecha' }
              ]
            },
            {
              type: 'select',
              name: 'divider-spacing',
              label: 'Espaciado Vertical',
              changeProp: 1,
              options: [
                { value: 'my-0', name: 'Sin Espaciado' },
                { value: 'my-2', name: 'Pequeño (8px)' },
                { value: 'my-4', name: 'Normal (16px)' },
                { value: 'my-8', name: 'Grande (32px)' },
                { value: 'my-16', name: 'Muy Grande (64px)' }
              ]
            }
          ]
        },
        init() {
          const syncInitialValues = () => {
            if (this.view && this.view.el) {
              const el = this.view.el;
              const classList = (el.className || '').split(' ').filter(c => c.trim());
              
              // Detectar estilo
              const styleMatch = classList.find(c => 
                c.includes('border-') && (c.includes('gray') || c.includes('blue') || c.includes('dashed') || c.includes('dotted'))
              );
              if (styleMatch) {
                const borderWidth = classList.find(c => c === 'border-t-2') ? 'border-t-2' : 'border-t';
                const borderStyle = classList.find(c => c.includes('dashed')) ? 'border-dashed' : 
                                   classList.find(c => c.includes('dotted')) ? 'border-dotted' : '';
                const borderColor = classList.find(c => c.includes('border-gray')) ? 
                                   (borderWidth === 'border-t-2' ? 'border-gray-400' : 'border-gray-300') :
                                   classList.find(c => c.includes('border-blue')) ?
                                   (borderWidth === 'border-t-2' ? 'border-blue-600' : 'border-blue-500') : 
                                   'border-gray-300';
                const styleValue = `${borderWidth} ${borderColor} ${borderStyle}`.trim();
                this.set('divider-style', styleValue, { silent: true });
              }
              
              // Detectar ancho
              const widthMatch = classList.find(c => 
                ['w-full', 'w-3/4', 'w-1/2', 'w-1/4', 'w-64', 'w-48'].includes(c)
              );
              if (widthMatch) {
                this.set('divider-width', widthMatch, { silent: true });
              }
              
              // Detectar alineación
              const alignMatch = classList.find(c => 
                ['mx-0', 'mx-auto', 'ml-auto'].includes(c)
              );
              if (alignMatch) {
                const mrMatch = classList.find(c => c === 'mr-0');
                if (alignMatch === 'ml-auto' && mrMatch) {
                  this.set('divider-align', 'ml-auto mr-0', { silent: true });
                } else {
                  this.set('divider-align', alignMatch, { silent: true });
                }
              }
              
              // Detectar espaciado
              const spacingMatch = classList.find(c => 
                ['my-0', 'my-2', 'my-4', 'my-8', 'my-16'].includes(c)
              );
              if (spacingMatch) {
                this.set('divider-spacing', spacingMatch, { silent: true });
              }
            }
          };
          
          setTimeout(syncInitialValues, 100);
          this.on('component:mount', syncInitialValues);
          this.on('component:selected', syncInitialValues);
          
          this.on('change:divider-style', this.updateStyle, this);
          this.on('change:divider-width', this.updateWidth, this);
          this.on('change:divider-align', this.updateAlign, this);
          this.on('change:divider-spacing', this.updateSpacing, this);
        },
        updateStyle() {
          const style = this.get('divider-style') || 'border-t border-gray-300';
          if (this.view && this.view.el) {
            const el = this.view.el;
            const currentAttrs = this.getAttributes();
            let currentClass = currentAttrs.class || el.className || '';
            
            // Remover estilos de borde anteriores
            currentClass = currentClass.replace(/border-t(-2)?/g, '').trim();
            currentClass = currentClass.replace(/border-(gray|blue)-\d+/g, '').trim();
            currentClass = currentClass.replace(/border-(dashed|dotted)/g, '').trim();
            
            // Agregar nuevo estilo
            currentClass = (currentClass + ' ' + style).trim().replace(/\s+/g, ' ');
            
            el.className = currentClass;
            this.setAttributes({ class: currentClass });
          }
        },
        updateWidth() {
          const width = this.get('divider-width') || 'w-full';
          if (this.view && this.view.el) {
            const el = this.view.el;
            const currentAttrs = this.getAttributes();
            let currentClass = currentAttrs.class || el.className || '';
            
            // Remover anchos anteriores
            currentClass = currentClass.replace(/w-(full|3\/4|1\/2|1\/4|64|48)/g, '').trim();
            
            // Agregar nuevo ancho
            currentClass = (currentClass + ' ' + width).trim().replace(/\s+/g, ' ');
            
            el.className = currentClass;
            this.setAttributes({ class: currentClass });
          }
        },
        updateAlign() {
          const align = this.get('divider-align') || 'mx-0';
          if (this.view && this.view.el) {
            const el = this.view.el;
            const currentAttrs = this.getAttributes();
            let currentClass = currentAttrs.class || el.className || '';
            
            // Remover alineaciones anteriores
            currentClass = currentClass.replace(/mx-(0|auto)/g, '').trim();
            currentClass = currentClass.replace(/ml-auto|mr-0/g, '').trim();
            
            // Agregar nueva alineación
            const alignClasses = align.split(' ');
            alignClasses.forEach(cls => {
              if (cls) {
                currentClass = (currentClass + ' ' + cls).trim();
              }
            });
            currentClass = currentClass.replace(/\s+/g, ' ');
            
            el.className = currentClass;
            this.setAttributes({ class: currentClass });
          }
        },
        updateSpacing() {
          const spacing = this.get('divider-spacing') || 'my-4';
          if (this.view && this.view.el) {
            const el = this.view.el;
            const currentAttrs = this.getAttributes();
            let currentClass = currentAttrs.class || el.className || '';
            
            // Remover espaciados anteriores
            currentClass = currentClass.replace(/my-(0|2|4|8|16)/g, '').trim();
            
            // Agregar nuevo espaciado
            currentClass = (currentClass + ' ' + spacing).trim().replace(/\s+/g, ' ');
            
            el.className = currentClass;
            this.setAttributes({ class: currentClass });
          }
        }
      },
      view: {
        onRender() {
          if (this.el) {
            this.el.setAttribute('contenteditable', 'false');
            this.el.setAttribute('data-gjs-editable', 'false');
          }
        }
      }
    });
    
  }
  
  if (typeof window !== 'undefined' && window.editor) {
    registerDividerComponent(window.editor);
  } else {
    const checkEditor = setInterval(() => {
      if (typeof window !== 'undefined' && window.editor) {
        registerDividerComponent(window.editor);
        clearInterval(checkEditor);
      }
    }, 100);
    
    setTimeout(() => {
      clearInterval(checkEditor);
    }, 10000);
  }
  
  if (typeof window !== 'undefined') {
    window.registerDividerComponent = registerDividerComponent;
  }
})();
