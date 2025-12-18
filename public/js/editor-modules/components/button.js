// Módulo del Componente Button
// Componente de botón con múltiples estilos y opciones

(function() {
  'use strict';
  
  function registerButtonComponent(editor) {
    if (!editor || !editor.DomComponents) {
      console.warn('⚠️ Editor no disponible para registrar componente Button');
      return;
    }
    
    editor.DomComponents.addType('button', {
      isComponent: (el) => {
        if (el.classList && el.classList.contains('button-component')) {
          return { type: 'button' };
        }
        if ((el.tagName === 'A' || el.tagName === 'BUTTON') && el.classList.contains('button')) {
          return { type: 'button' };
        }
        return false;
      },
      model: {
        defaults: {
          name: 'Botón',
          tagName: 'a',
          editable: false,
          droppable: false,
          removable: true,
          selectable: true,
          attributes: {
            class: 'button-component inline-block px-6 py-2 text-white transition-colors bg-blue-600 rounded-md hover:bg-blue-700 font-medium',
            href: '#',
            target: '_self',
            'data-gjs-name': 'Botón',
            'data-gjs-editable': 'false'
          },
          traits: [
            {
              type: 'text',
              name: 'button-text',
              label: 'Texto del Botón',
              changeProp: 1,
              placeholder: 'Ingresa el texto del botón'
            },
            {
              type: 'text',
              name: 'button-href',
              label: 'Enlace URL',
              changeProp: 1,
              placeholder: 'https://ejemplo.com'
            },
            {
              type: 'select',
              name: 'button-target',
              label: 'Abrir Enlace',
              changeProp: 1,
              options: [
                { value: '_self', name: 'Misma Ventana' },
                { value: '_blank', name: 'Nueva Ventana/Pestaña' }
              ]
            },
            {
              type: 'select',
              name: 'button-style',
              label: 'Estilo del Botón',
              changeProp: 1,
              options: [
                { value: 'bg-blue-600 hover:bg-blue-700', name: 'Principal (Azul)' },
                { value: 'bg-gray-600 hover:bg-gray-700', name: 'Secundario (Gris)' },
                { value: 'bg-green-600 hover:bg-green-700', name: 'Éxito (Verde)' },
                { value: 'bg-red-600 hover:bg-red-700', name: 'Peligro (Rojo)' },
                { value: 'bg-yellow-600 hover:bg-yellow-700', name: 'Advertencia (Amarillo)' },
                { value: 'bg-purple-600 hover:bg-purple-700', name: 'Morado' },
                { value: 'bg-pink-600 hover:bg-pink-700', name: 'Rosa' }
              ]
            },
            {
              type: 'select',
              name: 'button-size',
              label: 'Tamaño del Botón',
              changeProp: 1,
              options: [
                { value: 'px-4 py-2 text-sm', name: 'Pequeño' },
                { value: 'px-6 py-2 text-base', name: 'Mediano' },
                { value: 'px-8 py-3 text-lg', name: 'Grande' },
                { value: 'px-10 py-4 text-xl', name: 'Extra Grande' }
              ]
            },
            {
              type: 'select',
              name: 'button-width',
              label: 'Ancho del Botón',
              changeProp: 1,
              options: [
                { value: '', name: 'Automático (Según contenido)' },
                { value: 'w-auto', name: 'Automático' },
                { value: 'w-24', name: 'Muy Pequeño (96px)' },
                { value: 'w-32', name: 'Pequeño (128px)' },
                { value: 'w-40', name: 'Mediano (160px)' },
                { value: 'w-48', name: 'Grande (192px)' },
                { value: 'w-64', name: 'Extra Grande (256px)' },
                { value: 'w-full', name: 'Ancho Completo (100%)' },
                { value: 'w-1/2', name: 'Mitad (50%)' },
                { value: 'w-1/3', name: 'Un Tercio (33%)' },
                { value: 'w-2/3', name: 'Dos Tercios (67%)' },
                { value: 'w-3/4', name: 'Tres Cuartos (75%)' }
              ]
            },
            {
              type: 'select',
              name: 'button-align',
              label: 'Alineación',
              changeProp: 1,
              options: [
                { value: '', name: 'Por Defecto' },
                { value: 'block mx-auto', name: 'Centrado' },
                { value: 'block ml-auto', name: 'Derecha' },
                { value: 'block mr-auto', name: 'Izquierda' }
              ]
            },
            {
              type: 'select',
              name: 'button-radius',
              label: 'Bordes Redondeados',
              changeProp: 1,
              options: [
                { value: 'rounded-none', name: 'Sin Redondeo' },
                { value: 'rounded', name: 'Pequeño' },
                { value: 'rounded-md', name: 'Mediano' },
                { value: 'rounded-lg', name: 'Grande' },
                { value: 'rounded-full', name: 'Completo (Píldora)' }
              ]
            }
          ]
        },
        init() {
          this.syncInitialValues = () => {
            if (!this.view || !this.view.el) {
              return;
            }
            
            const el = this.view.el;
            const classList = (el.className || '').split(' ').filter(c => c.trim());
            
            if (!classList.includes('button-component')) {
              el.classList.add('button-component');
            }
            if (!classList.includes('text-center')) {
              el.classList.add('text-center');
              const currentAttrs = this.getAttributes();
              let currentClass = currentAttrs.class || el.className || '';
              if (!currentClass.includes('text-center')) {
                currentClass = (currentClass + ' text-center').trim();
                this.setAttributes({ class: currentClass });
              }
            }
            
            const textContent = el.textContent || el.innerText || '';
            if (textContent.trim()) {
              this.set('button-text', textContent.trim(), { silent: false });
            }
            
            const href = el.getAttribute('href') || '#';
            this.set('button-href', href, { silent: false });
            
            const target = el.getAttribute('target') || '_self';
            this.set('button-target', target, { silent: false });
            
            const styleOptions = [
              { value: 'bg-blue-600 hover:bg-blue-700', color: 'blue', pattern: /bg-blue-\d+/ },
              { value: 'bg-gray-600 hover:bg-gray-700', color: 'gray', pattern: /bg-gray-\d+/ },
              { value: 'bg-green-600 hover:bg-green-700', color: 'green', pattern: /bg-green-\d+/ },
              { value: 'bg-red-600 hover:bg-red-700', color: 'red', pattern: /bg-red-\d+/ },
              { value: 'bg-yellow-600 hover:bg-yellow-700', color: 'yellow', pattern: /bg-yellow-\d+/ },
              { value: 'bg-purple-600 hover:bg-purple-700', color: 'purple', pattern: /bg-purple-\d+/ },
              { value: 'bg-pink-600 hover:bg-pink-700', color: 'pink', pattern: /bg-pink-\d+/ }
            ];
            
            let styleMatch = styleOptions.find(opt => {
              const bgClass = classList.find(c => c.match(opt.pattern));
              const hoverClass = classList.find(c => c.match(new RegExp(`hover:bg-${opt.color}-\\d+`)));
              return bgClass && hoverClass;
            });
            
            if (!styleMatch) {
              const bgClass = classList.find(c => c.match(/^bg-(blue|gray|green|red|yellow|purple|pink)-\d+$/));
              if (bgClass) {
                const colorMatch = bgClass.match(/^bg-(\w+)-\d+$/);
                if (colorMatch) {
                  const color = colorMatch[1];
                  styleMatch = styleOptions.find(opt => opt.color === color);
                }
              }
            }
            if (styleMatch) {
              this.set('button-style', styleMatch.value, { silent: false });
            }
            
            const sizeOptions = [
              { value: 'px-4 py-2 text-sm', px: 'px-4', py: 'py-2', text: 'text-sm' },
              { value: 'px-6 py-2 text-base', px: 'px-6', py: 'py-2', text: 'text-base' },
              { value: 'px-8 py-3 text-lg', px: 'px-8', py: 'py-3', text: 'text-lg' },
              { value: 'px-10 py-4 text-xl', px: 'px-10', py: 'py-4', text: 'text-xl' }
            ];
            
            let sizeMatch = sizeOptions.find(opt => 
              classList.includes(opt.px) && classList.includes(opt.py) && classList.includes(opt.text)
            );
            
            if (!sizeMatch) {
              const textSizeClass = classList.find(c => ['text-sm', 'text-base', 'text-lg', 'text-xl'].includes(c));
              if (textSizeClass) {
                sizeMatch = sizeOptions.find(opt => opt.text === textSizeClass);
              }
            }
            if (sizeMatch) {
              this.set('button-size', sizeMatch.value, { silent: false });
            }
            
            const widthClasses = ['w-auto', 'w-full', 'w-24', 'w-32', 'w-40', 'w-48', 'w-64', 'w-1/2', 'w-1/3', 'w-2/3', 'w-3/4'];
            const widthMatch = classList.find(c => widthClasses.includes(c));
            if (widthMatch) {
              this.set('button-width', widthMatch, { silent: false });
            } else {
              this.set('button-width', '', { silent: false });
            }
            
            if (classList.includes('mx-auto')) {
              this.set('button-align', 'block mx-auto', { silent: false });
            } else if (classList.includes('ml-auto')) {
              this.set('button-align', 'block ml-auto', { silent: false });
            } else if (classList.includes('mr-auto')) {
              this.set('button-align', 'block mr-auto', { silent: false });
            }
            
            const radiusOptions = [
              { value: 'rounded-none', class: 'rounded-none' },
              { value: 'rounded', class: 'rounded' },
              { value: 'rounded-md', class: 'rounded-md' },
              { value: 'rounded-lg', class: 'rounded-lg' },
              { value: 'rounded-full', class: 'rounded-full' }
            ];
            const radiusMatch = radiusOptions.find(opt => classList.includes(opt.class));
            if (radiusMatch) {
              this.set('button-radius', radiusMatch.value, { silent: false });
            }
          };
          
          let syncInProgress = false;
          const syncAndUpdate = () => {
            if (syncInProgress) {
              return;
            }
            syncInProgress = true;
            
            this.syncInitialValues();
            
            setTimeout(() => {
              if (window.editor && window.editor.TraitManager) {
                if (typeof window.editor.TraitManager.setTarget === 'function') {
                  window.editor.TraitManager.setTarget(this);
                } else {
                  window.editor.TraitManager.component = this;
                }
                window.editor.TraitManager.render();
              }
              syncInProgress = false;
            }, 50);
          };
          
          this.on('component:mount', () => {
            setTimeout(syncAndUpdate, 100);
          });
          
          let updateSyncDone = false;
          this.on('component:update', () => {
            if (!updateSyncDone) {
              updateSyncDone = true;
              setTimeout(() => {
                syncAndUpdate();
                setTimeout(() => {
                  if (this.view && this.view.el) {
                    const savedClasses = this.getAttributes().class;
                    if (savedClasses) {
                      this.view.el.className = savedClasses;
                      this.setAttributes({ class: savedClasses });
                    }
                  }
                  updateSyncDone = false;
                }, 100);
              }, 150);
            }
          });
          
          this.on('component:selected', () => {
            setTimeout(syncAndUpdate, 50);
          });
          
          setTimeout(() => {
            if (this.view && this.view.el) {
              syncAndUpdate();
              setTimeout(() => {
                if (this.view && this.view.el) {
                  const savedClasses = this.getAttributes().class;
                  if (savedClasses) {
                    this.view.el.className = savedClasses;
                    this.setAttributes({ class: savedClasses });
                  }
                }
              }, 200);
            }
          }, 300);
          
          this.on('change:button-text', this.updateText, this);
          this.on('change:button-href', this.updateHref, this);
          this.on('change:button-target', this.updateTarget, this);
          this.on('change:button-style', this.updateStyle, this);
          this.on('change:button-size', this.updateSize, this);
          this.on('change:button-width', this.updateWidth, this);
          this.on('change:button-align', this.updateAlign, this);
          this.on('change:button-radius', this.updateRadius, this);
        },
        updateText() {
          const text = this.get('button-text') || '';
          if (this.view && this.view.el) {
            this.view.el.textContent = text;
            this.components(text);
            if (this.get('content') !== undefined) {
              this.set('content', text);
            }
            const currentAttrs = this.getAttributes();
            let currentClass = currentAttrs.class || this.view.el.className || '';
            if (!currentClass.includes('text-center')) {
              currentClass = (currentClass + ' text-center').trim();
              this.view.el.className = currentClass;
              this.setAttributes({ class: currentClass });
            }
          }
        },
        updateHref() {
          const href = this.get('button-href') || '#';
          if (this.view && this.view.el) {
            this.view.el.setAttribute('href', href);
            this.addAttributes({ href: href });
          }
        },
        updateTarget() {
          const target = this.get('button-target') || '_self';
          if (this.view && this.view.el) {
            this.view.el.setAttribute('target', target);
            this.addAttributes({ target: target });
          }
        },
        updateStyle() {
          const style = this.get('button-style') || 'bg-blue-600 hover:bg-blue-700';
          if (this.view && this.view.el) {
            const el = this.view.el;
            const currentAttrs = this.getAttributes();
            let currentClass = currentAttrs.class || el.className || '';
            currentClass = currentClass.replace(/bg-\w+-\d+ hover:bg-\w+-\d+/g, '').trim();
            const styleClasses = style.split(' ');
            styleClasses.forEach(cls => {
              if (cls) currentClass = (currentClass + ' ' + cls).trim();
            });
            currentClass = currentClass.replace(/\s+/g, ' ');
            el.className = currentClass;
            this.setAttributes({ class: currentClass });
          }
        },
        updateSize() {
          const size = this.get('button-size') || 'px-6 py-2 text-base';
          if (this.view && this.view.el) {
            const el = this.view.el;
            const currentAttrs = this.getAttributes();
            let currentClass = currentAttrs.class || el.className || '';
            currentClass = currentClass.replace(/px-\d+ py-\d+ text-(sm|base|lg|xl)/g, '').trim();
            const sizeClasses = size.split(' ');
            sizeClasses.forEach(cls => {
              if (cls) currentClass = (currentClass + ' ' + cls).trim();
            });
            if (!currentClass.includes('text-center')) {
              currentClass = (currentClass + ' text-center').trim();
            }
            currentClass = currentClass.replace(/\s+/g, ' ');
            el.className = currentClass;
            this.setAttributes({ class: currentClass });
          }
        },
        updateWidth() {
          const width = this.get('button-width') || '';
          if (this.view && this.view.el) {
            const el = this.view.el;
            const currentAttrs = this.getAttributes();
            let currentClass = currentAttrs.class || el.className || '';
            currentClass = currentClass.replace(/\bw-(auto|full|24|32|40|48|64|1\/2|1\/3|2\/3|3\/4)\b/g, '').trim();
            if (width) {
              currentClass = (currentClass + ' ' + width).trim();
            }
            currentClass = currentClass.replace(/\s+/g, ' ');
            el.className = currentClass;
            this.setAttributes({ class: currentClass });
          }
        },
        updateAlign() {
          const align = this.get('button-align') || '';
          if (this.view && this.view.el) {
            const el = this.view.el;
            const currentAttrs = this.getAttributes();
            let currentClass = currentAttrs.class || el.className || '';
            currentClass = currentClass.replace(/block (mx-auto|ml-auto|mr-auto)/g, '').trim();
            if (align) {
              const alignClasses = align.split(' ');
              alignClasses.forEach(cls => {
                if (cls) currentClass = (currentClass + ' ' + cls).trim();
              });
            }
            if (!currentClass.includes('text-center')) {
              currentClass = (currentClass + ' text-center').trim();
            }
            currentClass = currentClass.replace(/\s+/g, ' ');
            el.className = currentClass;
            this.setAttributes({ class: currentClass });
          }
        },
        updateRadius() {
          const radius = this.get('button-radius') || 'rounded-md';
          if (this.view && this.view.el) {
            const el = this.view.el;
            const currentAttrs = this.getAttributes();
            let currentClass = currentAttrs.class || el.className || '';
            currentClass = currentClass.replace(/rounded-(none|md|lg|full)/g, '').trim();
            currentClass = currentClass.replace(/rounded /g, '').trim();
            currentClass = (currentClass + ' ' + radius).trim();
            if (!currentClass.includes('text-center')) {
              currentClass = (currentClass + ' text-center').trim();
            }
            currentClass = currentClass.replace(/\s+/g, ' ');
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
    registerButtonComponent(window.editor);
  } else {
    const checkEditor = setInterval(() => {
      if (typeof window !== 'undefined' && window.editor) {
        registerButtonComponent(window.editor);
        clearInterval(checkEditor);
      }
    }, 100);
    
    setTimeout(() => {
      clearInterval(checkEditor);
    }, 10000);
  }
  
  if (typeof window !== 'undefined') {
    window.registerButtonComponent = registerButtonComponent;
  }
})();
