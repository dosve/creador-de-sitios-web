// Módulo del Componente Paragraph
// Componente de párrafo con opciones de estilo

(function() {
  'use strict';
  
  function registerParagraphComponent(editor) {
    if (!editor || !editor.DomComponents) {
      console.warn('⚠️ Editor no disponible para registrar componente Paragraph');
      return;
    }
    
    editor.DomComponents.addType('paragraph', {
      isComponent: (el) => {
        if (el.classList && el.classList.contains('paragraph-component')) {
          return { type: 'paragraph' };
        }
        if (el.tagName === 'P') {
          return { type: 'paragraph' };
        }
        return false;
      },
      model: {
        defaults: {
          name: 'Párrafo',
          tagName: 'p',
          editable: false,
          droppable: false,
          removable: true,
          selectable: true,
          attributes: {
            class: 'paragraph-component leading-relaxed text-gray-700 mb-4',
            'data-gjs-name': 'Párrafo',
            'data-gjs-editable': 'false'
          },
          traits: [
            {
              type: 'text',
              name: 'paragraph-text',
              label: 'Texto del Párrafo',
              changeProp: 1,
              placeholder: 'Ingresa el texto del párrafo aquí'
            },
            {
              type: 'select',
              name: 'paragraph-size',
              label: 'Tamaño del Texto',
              changeProp: 1,
              options: [
                { value: 'text-sm', name: 'Pequeño (14px)' },
                { value: 'text-base', name: 'Normal (16px)' },
                { value: 'text-lg', name: 'Grande (18px)' },
                { value: 'text-xl', name: 'Extra Grande (20px)' }
              ]
            },
            {
              type: 'select',
              name: 'paragraph-color',
              label: 'Color del Texto',
              changeProp: 1,
              options: [
                { value: 'text-gray-700', name: 'Gris Oscuro' },
                { value: 'text-gray-600', name: 'Gris Medio' },
                { value: 'text-gray-900', name: 'Negro' },
                { value: 'text-blue-600', name: 'Azul' },
                { value: 'text-green-600', name: 'Verde' }
              ]
            },
            {
              type: 'select',
              name: 'paragraph-align',
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
              name: 'paragraph-line-height',
              label: 'Altura de Línea',
              changeProp: 1,
              options: [
                { value: 'leading-tight', name: 'Ajustada' },
                { value: 'leading-normal', name: 'Normal' },
                { value: 'leading-relaxed', name: 'Relajada' },
                { value: 'leading-loose', name: 'Suelta' }
              ]
            },
            {
              type: 'select',
              name: 'paragraph-margin',
              label: 'Espaciado Inferior',
              changeProp: 1,
              options: [
                { value: 'mb-0', name: 'Sin Espaciado' },
                { value: 'mb-2', name: 'Pequeño (8px)' },
                { value: 'mb-4', name: 'Normal (16px)' },
                { value: 'mb-6', name: 'Grande (24px)' }
              ]
            }
          ]
        },
        init() {
          // Sincronizar contenido desde el DOM cuando se carga desde HTML guardado
          this.syncContentFromDOM = () => {
            try {
              if (this.view && this.view.el) {
                const el = this.view.el;
                const textContent = el.textContent || el.innerText || '';
                const modelText = this.get('paragraph-text') || '';
                
                // ✅ CRÍTICO: Siempre actualizar el modelo con silent: false para forzar actualización del TraitManager
                // Esto asegura que los inputs del formulario se actualicen incluso si el contenido ya está sincronizado
                if (textContent.trim()) {
                  console.log('🔄 [Paragraph] Actualizando paragraph-text en modelo (forzando actualización)...');
                  this.set('paragraph-text', textContent.trim(), { silent: false });
                  console.log('✅ [Paragraph] Contenido sincronizado desde DOM:', textContent.trim().substring(0, 50));
                } else if (modelText) {
                  // Si no hay contenido en DOM pero sí en modelo, forzar actualización del formulario
                  console.log('ℹ️ [Paragraph] No hay contenido en DOM, forzando actualización del formulario con valor del modelo');
                  this.set('paragraph-text', modelText, { silent: false });
                }
                
                const classList = el.className.split(' ');
                const sizeMatch = classList.find(c => ['text-sm', 'text-base', 'text-lg', 'text-xl'].includes(c));
                if (sizeMatch) {
                  const currentSize = this.get('paragraph-size');
                  if (sizeMatch !== currentSize) {
                    this.set('paragraph-size', sizeMatch, { silent: false });
                  }
                }
                
                const colorMatch = classList.find(c => c.startsWith('text-') && ['gray', 'blue', 'green'].some(col => c.includes(col)));
                if (colorMatch) {
                  const currentColor = this.get('paragraph-color');
                  if (colorMatch !== currentColor) {
                    this.set('paragraph-color', colorMatch, { silent: false });
                  }
                }
                
                const alignMatch = classList.find(c => ['text-left', 'text-center', 'text-right', 'text-justify'].includes(c));
                if (alignMatch) {
                  const currentAlign = this.get('paragraph-align');
                  if (alignMatch !== currentAlign) {
                    this.set('paragraph-align', alignMatch, { silent: false });
                  }
                }
                
                const lineHeightMatch = classList.find(c => ['leading-tight', 'leading-normal', 'leading-relaxed', 'leading-loose'].includes(c));
                if (lineHeightMatch) {
                  const currentLineHeight = this.get('paragraph-line-height');
                  if (lineHeightMatch !== currentLineHeight) {
                    this.set('paragraph-line-height', lineHeightMatch, { silent: false });
                  }
                }
                
                const marginMatch = classList.find(c => ['mb-0', 'mb-2', 'mb-4', 'mb-6'].includes(c));
                if (marginMatch) {
                  const currentMargin = this.get('paragraph-margin');
                  if (marginMatch !== currentMargin) {
                    this.set('paragraph-margin', marginMatch, { silent: false });
                  }
                }
              } else {
                console.warn('⚠️ [Paragraph] view.el no disponible para sincronizar');
              }
            } catch (e) {
              console.warn('⚠️ [Paragraph] Error al sincronizar contenido desde DOM:', e);
            }
          };
          
          const syncInitialValues = () => {
            if (this.view && this.view.el) {
              const el = this.view.el;
              const textContent = el.textContent || el.innerText || '';
              if (textContent.trim()) {
                this.set('paragraph-text', textContent.trim(), { silent: true });
              }
              
              const classList = el.className.split(' ');
              const sizeMatch = classList.find(c => ['text-sm', 'text-base', 'text-lg', 'text-xl'].includes(c));
              if (sizeMatch) this.set('paragraph-size', sizeMatch, { silent: true });
              
              const colorMatch = classList.find(c => c.startsWith('text-') && ['gray', 'blue', 'green'].some(col => c.includes(col)));
              if (colorMatch) this.set('paragraph-color', colorMatch, { silent: true });
              
              const alignMatch = classList.find(c => ['text-left', 'text-center', 'text-right', 'text-justify'].includes(c));
              if (alignMatch) this.set('paragraph-align', alignMatch, { silent: true });
              
              const lineHeightMatch = classList.find(c => ['leading-tight', 'leading-normal', 'leading-relaxed', 'leading-loose'].includes(c));
              if (lineHeightMatch) this.set('paragraph-line-height', lineHeightMatch, { silent: true });
              
              const marginMatch = classList.find(c => ['mb-0', 'mb-2', 'mb-4', 'mb-6'].includes(c));
              if (marginMatch) this.set('paragraph-margin', marginMatch, { silent: true });
            }
          };
          
          setTimeout(syncInitialValues, 100);
          this.on('component:mount', syncInitialValues);
          
          // ✅ CRÍTICO: Sincronizar cuando el componente se selecciona (para actualizar el formulario)
          // ✅ La actualización manual de inputs se maneja en editor-config.js para evitar duplicación
          this.on('component:selected', () => {
            console.log('🎯 [Paragraph] Componente seleccionado, sincronizando contenido desde DOM...');
            
            // Sincronizar desde DOM inmediatamente (sin setTimeout) para que el modelo tenga los valores antes del render
            // El editor-config.js se encargará de re-renderizar el TraitManager y actualizar los inputs
            if (this.syncContentFromDOM && typeof this.syncContentFromDOM === 'function') {
              this.syncContentFromDOM();
            }
          });
          
          this.on('change:paragraph-text', this.updateText, this);
          this.on('change:paragraph-size', this.updateSize, this);
          this.on('change:paragraph-color', this.updateColor, this);
          this.on('change:paragraph-align', this.updateAlign, this);
          this.on('change:paragraph-line-height', this.updateLineHeight, this);
          this.on('change:paragraph-margin', this.updateMargin, this);
        },
        updateText() {
          const text = this.get('paragraph-text') || '';
          if (this.view && this.view.el) {
            this.view.el.textContent = text;
            this.components(text);
          }
        },
        updateSize() {
          const size = this.get('paragraph-size') || 'text-base';
          if (this.view && this.view.el) {
            const el = this.view.el;
            const currentAttrs = this.getAttributes();
            let currentClass = currentAttrs.class || el.className || '';
            currentClass = currentClass.replace(/text-(sm|base|lg|xl)/g, '').trim();
            currentClass = (currentClass + ' ' + size).trim().replace(/\s+/g, ' ');
            el.className = currentClass;
            this.setAttributes({ class: currentClass });
          }
        },
        updateColor() {
          const color = this.get('paragraph-color') || 'text-gray-700';
          if (this.view && this.view.el) {
            const el = this.view.el;
            const currentAttrs = this.getAttributes();
            let currentClass = currentAttrs.class || el.className || '';
            currentClass = currentClass.replace(/text-(gray|blue|green)-\d+/g, '').trim();
            currentClass = currentClass.replace(/text-(gray|blue|green)/g, '').trim();
            currentClass = (currentClass + ' ' + color).trim().replace(/\s+/g, ' ');
            el.className = currentClass;
            this.setAttributes({ class: currentClass });
          }
        },
        updateAlign() {
          const align = this.get('paragraph-align') || 'text-left';
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
        updateLineHeight() {
          const lineHeight = this.get('paragraph-line-height') || 'leading-relaxed';
          if (this.view && this.view.el) {
            const el = this.view.el;
            const currentAttrs = this.getAttributes();
            let currentClass = currentAttrs.class || el.className || '';
            currentClass = currentClass.replace(/leading-(tight|normal|relaxed|loose)/g, '').trim();
            currentClass = (currentClass + ' ' + lineHeight).trim().replace(/\s+/g, ' ');
            el.className = currentClass;
            this.setAttributes({ class: currentClass });
          }
        },
        updateMargin() {
          const margin = this.get('paragraph-margin') || 'mb-4';
          if (this.view && this.view.el) {
            const el = this.view.el;
            const currentAttrs = this.getAttributes();
            let currentClass = currentAttrs.class || el.className || '';
            currentClass = currentClass.replace(/mb-[0-6]/g, '').trim();
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
    registerParagraphComponent(window.editor);
  } else {
    const checkEditor = setInterval(() => {
      if (typeof window !== 'undefined' && window.editor) {
        registerParagraphComponent(window.editor);
        clearInterval(checkEditor);
      }
    }, 100);
    
    setTimeout(() => {
      clearInterval(checkEditor);
    }, 10000);
  }
  
  if (typeof window !== 'undefined') {
    window.registerParagraphComponent = registerParagraphComponent;
  }
})();
