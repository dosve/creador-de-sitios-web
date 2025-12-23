// Módulo del Componente List Unordered (ul)
// Componente de lista no ordenada con opciones de estilo

(function() {
  'use strict';
  
  function registerListUnorderedComponent(editor) {
    if (!editor || !editor.DomComponents) {
      console.warn('⚠️ Editor no disponible para registrar componente List Unordered');
      return;
    }
    
    editor.DomComponents.addType('unordered-list', {
      isComponent: (el) => {
        if (el.classList && el.classList.contains('list-component')) {
          return { type: 'unordered-list' };
        }
        if (el.tagName === 'UL') {
          return { type: 'unordered-list' };
        }
        return false;
      },
      model: {
        defaults: {
          name: 'Lista No Ordenada',
          tagName: 'ul',
          editable: false,
          droppable: true,
          removable: true,
          selectable: true,
          attributes: {
            class: 'list-component list-disc list-inside space-y-2 mb-4',
            'data-gjs-name': 'Lista No Ordenada',
            'data-gjs-editable': 'false'
          },
          traits: [
            {
              type: 'select',
              name: 'list-style',
              label: 'Estilo de Viñeta',
              changeProp: 1,
              options: [
                { value: 'list-disc', name: 'Círculo (Disc)' },
                { value: 'list-circle', name: 'Círculo Vacío (Circle)' },
                { value: 'list-square', name: 'Cuadrado (Square)' },
                { value: 'list-none', name: 'Sin Viñeta' }
              ]
            },
            {
              type: 'select',
              name: 'list-position',
              label: 'Posición de Viñeta',
              changeProp: 1,
              options: [
                { value: 'list-inside', name: 'Dentro' },
                { value: 'list-outside', name: 'Fuera' }
              ]
            },
            {
              type: 'select',
              name: 'list-spacing',
              label: 'Espaciado entre Elementos',
              changeProp: 1,
              options: [
                { value: 'space-y-1', name: 'Muy Pequeño (4px)' },
                { value: 'space-y-2', name: 'Pequeño (8px)' },
                { value: 'space-y-3', name: 'Mediano (12px)' },
                { value: 'space-y-4', name: 'Grande (16px)' },
                { value: 'space-y-6', name: 'Extra Grande (24px)' }
              ]
            },
            {
              type: 'select',
              name: 'list-margin',
              label: 'Espaciado Inferior',
              changeProp: 1,
              options: [
                { value: 'mb-0', name: 'Sin Espaciado' },
                { value: 'mb-2', name: 'Pequeño (8px)' },
                { value: 'mb-4', name: 'Normal (16px)' },
                { value: 'mb-6', name: 'Grande (24px)' },
                { value: 'mb-8', name: 'Extra Grande (32px)' }
              ]
            }
          ]
        },
        init() {
          this.on('change:list-style', this.updateStyle, this);
          this.on('change:list-position', this.updatePosition, this);
          this.on('change:list-spacing', this.updateSpacing, this);
          this.on('change:list-margin', this.updateMargin, this);
        },
        updateStyle() {
          const style = this.get('list-style') || 'list-disc';
          if (this.view && this.view.el) {
            const el = this.view.el;
            const currentAttrs = this.getAttributes();
            let currentClass = currentAttrs.class || el.className || '';
            currentClass = currentClass.replace(/list-(disc|circle|square|none)/g, '').trim();
            currentClass = (currentClass + ' ' + style).trim().replace(/\s+/g, ' ');
            el.className = currentClass;
            this.setAttributes({ class: currentClass });
          }
        },
        updatePosition() {
          const position = this.get('list-position') || 'list-inside';
          if (this.view && this.view.el) {
            const el = this.view.el;
            const currentAttrs = this.getAttributes();
            let currentClass = currentAttrs.class || el.className || '';
            currentClass = currentClass.replace(/list-(inside|outside)/g, '').trim();
            currentClass = (currentClass + ' ' + position).trim().replace(/\s+/g, ' ');
            el.className = currentClass;
            this.setAttributes({ class: currentClass });
          }
        },
        updateSpacing() {
          const spacing = this.get('list-spacing') || 'space-y-2';
          if (this.view && this.view.el) {
            const el = this.view.el;
            const currentAttrs = this.getAttributes();
            let currentClass = currentAttrs.class || el.className || '';
            currentClass = currentClass.replace(/space-y-[1-6]/g, '').trim();
            currentClass = (currentClass + ' ' + spacing).trim().replace(/\s+/g, ' ');
            el.className = currentClass;
            this.setAttributes({ class: currentClass });
          }
        },
        updateMargin() {
          const margin = this.get('list-margin') || 'mb-4';
          if (this.view && this.view.el) {
            const el = this.view.el;
            const currentAttrs = this.getAttributes();
            let currentClass = currentAttrs.class || el.className || '';
            currentClass = currentClass.replace(/mb-[0-8]/g, '').trim();
            currentClass = (currentClass + ' ' + margin).trim().replace(/\s+/g, ' ');
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
    registerListUnorderedComponent(window.editor);
  } else {
    const checkEditor = setInterval(() => {
      if (typeof window !== 'undefined' && window.editor) {
        registerListUnorderedComponent(window.editor);
        clearInterval(checkEditor);
      }
    }, 100);
    
    setTimeout(() => {
      clearInterval(checkEditor);
    }, 10000);
  }
  
  if (typeof window !== 'undefined') {
    window.registerListUnorderedComponent = registerListUnorderedComponent;
  }
})();

