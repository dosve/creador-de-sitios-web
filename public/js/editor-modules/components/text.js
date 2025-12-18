// Módulo del Componente Text
// Componente de texto genérico con opciones de estilo

(function() {
  'use strict';
  
  function registerTextComponent(editor) {
    if (!editor || !editor.DomComponents) {
      console.warn('⚠️ Editor no disponible para registrar componente Text');
      return;
    }
    
    editor.DomComponents.addType('text', {
      isComponent: (el) => {
        // Verificar que el sea un elemento DOM válido
        if (!el || typeof el !== 'object' || !el.nodeType) {
          return false;
        }
        
        if (el.classList && el.classList.contains('text-component')) {
          return { type: 'text' };
        }
        if (el.tagName === 'DIV' && el.textContent && el.querySelector && typeof el.querySelector === 'function' && !el.querySelector('img, video, iframe')) {
          return { type: 'text' };
        }
        return false;
      },
      model: {
        defaults: {
          name: 'Texto',
          tagName: 'div',
          editable: false,
          droppable: false,
          removable: true,
          selectable: true,
          attributes: {
            class: 'text-component p-4 text-gray-700',
            'data-gjs-name': 'Texto',
            'data-gjs-editable': 'false'
          },
          traits: [
            {
              type: 'text',
              name: 'text-content',
              label: 'Contenido de Texto',
              changeProp: 1,
              placeholder: 'Ingresa el texto aquí'
            },
            {
              type: 'select',
              name: 'text-size',
              label: 'Tamaño del Texto',
              changeProp: 1,
              options: [
                { value: 'text-xs', name: 'Extra Pequeño (12px)' },
                { value: 'text-sm', name: 'Pequeño (14px)' },
                { value: 'text-base', name: 'Normal (16px)' },
                { value: 'text-lg', name: 'Grande (18px)' },
                { value: 'text-xl', name: 'Extra Grande (20px)' },
                { value: 'text-2xl', name: '2XL (24px)' },
                { value: 'text-3xl', name: '3XL (30px)' }
              ]
            },
            {
              type: 'select',
              name: 'text-color',
              label: 'Color del Texto',
              changeProp: 1,
              options: [
                { value: 'text-gray-700', name: 'Gris Oscuro' },
                { value: 'text-gray-900', name: 'Negro' },
                { value: 'text-blue-600', name: 'Azul' },
                { value: 'text-green-600', name: 'Verde' },
                { value: 'text-red-600', name: 'Rojo' },
                { value: 'text-purple-600', name: 'Morado' },
                { value: 'text-white', name: 'Blanco' }
              ]
            },
            {
              type: 'select',
              name: 'text-align',
              label: 'Alineación',
              changeProp: 1,
              options: [
                { value: 'text-left', name: 'Izquierda' },
                { value: 'text-center', name: 'Centro' },
                { value: 'text-right', name: 'Derecha' },
                { value: 'text-justify', name: 'Justificado' }
              ]
            },
            {
              type: 'select',
              name: 'text-weight',
              label: 'Grosor de Fuente',
              changeProp: 1,
              options: [
                { value: 'font-normal', name: 'Normal' },
                { value: 'font-medium', name: 'Medio' },
                { value: 'font-semibold', name: 'Semi Negrita' },
                { value: 'font-bold', name: 'Negrita' }
              ]
            },
            {
              type: 'select',
              name: 'text-padding',
              label: 'Espaciado Interno',
              changeProp: 1,
              options: [
                { value: 'p-0', name: 'Sin Espaciado' },
                { value: 'p-2', name: 'Pequeño (8px)' },
                { value: 'p-4', name: 'Normal (16px)' },
                { value: 'p-6', name: 'Grande (24px)' },
                { value: 'p-8', name: 'Extra Grande (32px)' }
              ]
            }
          ]
        },
        init() {
          const syncInitialValues = () => {
            if (this.view && this.view.el) {
              const el = this.view.el;
              
              const textContent = el.textContent || el.innerText || '';
              if (textContent.trim()) {
                this.set('text-content', textContent.trim(), { silent: true });
              }
              
              const classList = el.className.split(' ');
              
              const sizeMatch = classList.find(c => c.startsWith('text-') && ['xs', 'sm', 'base', 'lg', 'xl', '2xl', '3xl'].some(s => c.includes(s)));
              if (sizeMatch) {
                this.set('text-size', sizeMatch, { silent: true });
              }
              
              const colorMatch = classList.find(c => c.startsWith('text-') && ['gray', 'blue', 'green', 'red', 'purple', 'white'].some(col => c.includes(col)));
              if (colorMatch) {
                this.set('text-color', colorMatch, { silent: true });
              }
              
              const alignMatch = classList.find(c => ['text-left', 'text-center', 'text-right', 'text-justify'].includes(c));
              if (alignMatch) {
                this.set('text-align', alignMatch, { silent: true });
              }
              
              const weightMatch = classList.find(c => ['font-normal', 'font-medium', 'font-semibold', 'font-bold'].includes(c));
              if (weightMatch) {
                this.set('text-weight', weightMatch, { silent: true });
              }
              
              const paddingMatch = classList.find(c => ['p-0', 'p-2', 'p-4', 'p-6', 'p-8'].includes(c));
              if (paddingMatch) {
                this.set('text-padding', paddingMatch, { silent: true });
              }
            }
          };
          
          setTimeout(syncInitialValues, 100);
          this.on('component:mount', syncInitialValues);
          
          this.on('change:text-content', this.updateContent, this);
          this.on('change:text-size', this.updateSize, this);
          this.on('change:text-color', this.updateColor, this);
          this.on('change:text-align', this.updateAlign, this);
          this.on('change:text-weight', this.updateWeight, this);
          this.on('change:text-padding', this.updatePadding, this);
        },
        updateContent() {
          const content = this.get('text-content') || '';
          if (this.view && this.view.el) {
            this.view.el.textContent = content;
            this.components(content);
          }
        },
        updateSize() {
          const size = this.get('text-size') || 'text-base';
          if (this.view && this.view.el) {
            const el = this.view.el;
            const currentAttrs = this.getAttributes();
            let currentClass = currentAttrs.class || el.className || '';
            currentClass = currentClass.replace(/text-(xs|sm|base|lg|xl|2xl|3xl)/g, '').trim();
            currentClass = (currentClass + ' ' + size).trim().replace(/\s+/g, ' ');
            el.className = currentClass;
            this.setAttributes({ class: currentClass });
          }
        },
        updateColor() {
          const color = this.get('text-color') || 'text-gray-700';
          if (this.view && this.view.el) {
            const el = this.view.el;
            const currentAttrs = this.getAttributes();
            let currentClass = currentAttrs.class || el.className || '';
            currentClass = currentClass.replace(/text-(gray|blue|green|red|purple|white)-\d+/g, '').trim();
            currentClass = currentClass.replace(/text-(gray|blue|green|red|purple|white)/g, '').trim();
            currentClass = (currentClass + ' ' + color).trim().replace(/\s+/g, ' ');
            el.className = currentClass;
            this.setAttributes({ class: currentClass });
          }
        },
        updateAlign() {
          const align = this.get('text-align') || 'text-left';
          if (this.view && this.view.el) {
            const el = this.view.el;
            const currentAttrs = this.getAttributes();
            let currentClass = currentAttrs.class || el.className || '';
            currentClass = currentClass.replace(/text-(left|center|right|justify)/g, '').trim();
            currentClass = (currentClass + ' ' + align).trim().replace(/\s+/g, ' ');
            el.className = currentClass;
            this.setAttributes({ class: currentClass });
          }
        },
        updateWeight() {
          const weight = this.get('text-weight') || 'font-normal';
          if (this.view && this.view.el) {
            const el = this.view.el;
            const currentAttrs = this.getAttributes();
            let currentClass = currentAttrs.class || el.className || '';
            currentClass = currentClass.replace(/font-(normal|medium|semibold|bold)/g, '').trim();
            currentClass = (currentClass + ' ' + weight).trim().replace(/\s+/g, ' ');
            el.className = currentClass;
            this.setAttributes({ class: currentClass });
          }
        },
        updatePadding() {
          const padding = this.get('text-padding') || 'p-4';
          if (this.view && this.view.el) {
            const el = this.view.el;
            const currentAttrs = this.getAttributes();
            let currentClass = currentAttrs.class || el.className || '';
            currentClass = currentClass.replace(/p-[0-8]/g, '').trim();
            currentClass = (currentClass + ' ' + padding).trim().replace(/\s+/g, ' ');
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
    registerTextComponent(window.editor);
  } else {
    const checkEditor = setInterval(() => {
      if (typeof window !== 'undefined' && window.editor) {
        registerTextComponent(window.editor);
        clearInterval(checkEditor);
      }
    }, 100);
    
    setTimeout(() => {
      clearInterval(checkEditor);
    }, 10000);
  }
  
  if (typeof window !== 'undefined') {
    window.registerTextComponent = registerTextComponent;
  }
})();
