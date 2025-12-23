// Módulo del Componente Heading
// Componente de título (H1-H6) con múltiples opciones de estilo

(function () {
  'use strict';

  function registerHeadingComponent(editor) {
    if (!editor || !editor.DomComponents) {
      console.warn('⚠️ Editor no disponible para registrar componente Heading');
      return;
    }

    editor.DomComponents.addType('heading', {
      isComponent: (el) => {
        if (el.classList && el.classList.contains('heading-component')) {
          return { type: 'heading' };
        }
        if (['H1', 'H2', 'H3', 'H4', 'H5', 'H6'].includes(el.tagName)) {
          return { type: 'heading' };
        }
        return false;
      },
      model: {
        defaults: {
          name: 'Título',
          editable: false,
          droppable: false,
          removable: true,
          selectable: true,
          attributes: {
            class: 'heading-component text-2xl font-bold text-gray-900',
            'data-gjs-name': 'Título',
            'data-gjs-editable': 'false'
          },
          traits: [
            {
              type: 'text',
              name: 'heading-text',
              label: 'Texto del Título',
              changeProp: 1,
              placeholder: 'Ingresa el título aquí'
            },
            {
              type: 'select',
              name: 'heading-tag',
              label: 'Nivel de Título',
              changeProp: 1,
              options: [
                { value: 'h1', name: 'H1 (Más grande)' },
                { value: 'h2', name: 'H2' },
                { value: 'h3', name: 'H3' },
                { value: 'h4', name: 'H4' },
                { value: 'h5', name: 'H5' },
                { value: 'h6', name: 'H6 (Más pequeño)' }
              ]
            },
            {
              type: 'select',
              name: 'heading-size',
              label: 'Tamaño del Título',
              changeProp: 1,
              options: [
                { value: 'text-xl', name: 'XL (20px)' },
                { value: 'text-2xl', name: '2XL (24px)' },
                { value: 'text-3xl', name: '3XL (30px)' },
                { value: 'text-4xl', name: '4XL (36px)' },
                { value: 'text-5xl', name: '5XL (48px)' },
                { value: 'text-6xl', name: '6XL (60px)' }
              ]
            },
            {
              type: 'select',
              name: 'heading-color',
              label: 'Color del Título',
              changeProp: 1,
              options: [
                { value: 'text-gray-900', name: 'Negro' },
                { value: 'text-gray-700', name: 'Gris Oscuro' },
                { value: 'text-blue-600', name: 'Azul' },
                { value: 'text-green-600', name: 'Verde' },
                { value: 'text-red-600', name: 'Rojo' },
                { value: 'text-purple-600', name: 'Morado' },
                { value: 'text-white', name: 'Blanco' }
              ]
            },
            {
              type: 'select',
              name: 'heading-align',
              label: 'Alineación',
              changeProp: 1,
              options: [
                { value: 'text-left', name: 'Izquierda' },
                { value: 'text-center', name: 'Centro' },
                { value: 'text-right', name: 'Derecha' }
              ]
            },
            {
              type: 'select',
              name: 'heading-weight',
              label: 'Grosor de Fuente',
              changeProp: 1,
              options: [
                { value: 'font-normal', name: 'Normal' },
                { value: 'font-medium', name: 'Medio' },
                { value: 'font-semibold', name: 'Semi Negrita' },
                { value: 'font-bold', name: 'Negrita' },
                { value: 'font-extrabold', name: 'Extra Negrita' }
              ]
            },
            {
              type: 'select',
              name: 'heading-margin',
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
          // Sincronizar contenido desde el DOM cuando se carga desde HTML guardado
          this.syncContentFromDOM = () => {
            try {
              if (this.view && this.view.el) {
                const el = this.view.el;
                const textContent = el.textContent || el.innerText || '';
                const modelText = this.get('heading-text') || '';

                // ✅ CRÍTICO: Siempre actualizar el modelo con silent: false para forzar actualización del TraitManager
                // Esto asegura que los inputs del formulario se actualicen incluso si el contenido ya está sincronizado
                if (textContent.trim()) {
                  console.log('🔄 [Heading] Actualizando heading-text en modelo (forzando actualización)...');
                  this.set('heading-text', textContent.trim(), { silent: false });
                  console.log('✅ [Heading] Contenido sincronizado desde DOM:', textContent.trim().substring(0, 50));
                } else if (modelText) {
                  // Si no hay contenido en DOM pero sí en modelo, forzar actualización del formulario
                  console.log('ℹ️ [Heading] No hay contenido en DOM, forzando actualización del formulario con valor del modelo');
                  this.set('heading-text', modelText, { silent: false });
                }

                const tagName = el.tagName.toLowerCase();
                const currentTag = this.get('heading-tag');
                if (tagName !== currentTag) {
                  this.set('heading-tag', tagName, { silent: false });
                }

                const classList = el.className.split(' ');
                const sizeMatch = classList.find(c => c.startsWith('text-') && ['xl', '2xl', '3xl', '4xl', '5xl', '6xl'].some(s => c.includes(s)));
                if (sizeMatch) {
                  const currentSize = this.get('heading-size');
                  if (sizeMatch !== currentSize) {
                    this.set('heading-size', sizeMatch, { silent: false });
                  }
                }

                const colorMatch = classList.find(c => c.startsWith('text-') && ['gray', 'blue', 'green', 'red', 'purple', 'white'].some(col => c.includes(col)));
                if (colorMatch) {
                  const currentColor = this.get('heading-color');
                  if (colorMatch !== currentColor) {
                    this.set('heading-color', colorMatch, { silent: false });
                  }
                }

                const alignMatch = classList.find(c => ['text-left', 'text-center', 'text-right'].includes(c));
                if (alignMatch) {
                  const currentAlign = this.get('heading-align');
                  if (alignMatch !== currentAlign) {
                    this.set('heading-align', alignMatch, { silent: false });
                  }
                }

                const weightMatch = classList.find(c => ['font-normal', 'font-medium', 'font-semibold', 'font-bold', 'font-extrabold'].includes(c));
                if (weightMatch) {
                  const currentWeight = this.get('heading-weight');
                  if (weightMatch !== currentWeight) {
                    this.set('heading-weight', weightMatch, { silent: false });
                  }
                }

                const marginMatch = classList.find(c => ['mb-0', 'mb-2', 'mb-4', 'mb-6', 'mb-8'].includes(c));
                if (marginMatch) {
                  const currentMargin = this.get('heading-margin');
                  if (marginMatch !== currentMargin) {
                    this.set('heading-margin', marginMatch, { silent: false });
                  }
                }
              } else {
                console.warn('⚠️ [Heading] view.el no disponible para sincronizar');
              }
            } catch (e) {
              console.warn('⚠️ [Heading] Error al sincronizar contenido desde DOM:', e);
            }
          };

          const syncInitialValues = () => {
            if (this.view && this.view.el) {
              const el = this.view.el;
              const textContent = el.textContent || el.innerText || '';
              if (textContent.trim()) {
                this.set('heading-text', textContent.trim(), { silent: true });
              }
              const tagName = el.tagName.toLowerCase();
              this.set('heading-tag', tagName, { silent: true });

              const classList = el.className.split(' ');
              const sizeMatch = classList.find(c => c.startsWith('text-') && ['xl', '2xl', '3xl', '4xl', '5xl', '6xl'].some(s => c.includes(s)));
              if (sizeMatch) this.set('heading-size', sizeMatch, { silent: true });

              const colorMatch = classList.find(c => c.startsWith('text-') && ['gray', 'blue', 'green', 'red', 'purple', 'white'].some(col => c.includes(col)));
              if (colorMatch) this.set('heading-color', colorMatch, { silent: true });

              const alignMatch = classList.find(c => ['text-left', 'text-center', 'text-right'].includes(c));
              if (alignMatch) this.set('heading-align', alignMatch, { silent: true });

              const weightMatch = classList.find(c => ['font-normal', 'font-medium', 'font-semibold', 'font-bold', 'font-extrabold'].includes(c));
              if (weightMatch) this.set('heading-weight', weightMatch, { silent: true });

              const marginMatch = classList.find(c => ['mb-0', 'mb-2', 'mb-4', 'mb-6', 'mb-8'].includes(c));
              if (marginMatch) this.set('heading-margin', marginMatch, { silent: true });
            }
          };

          setTimeout(syncInitialValues, 100);
          this.on('component:mount', syncInitialValues);

          // ✅ CRÍTICO: Sincronizar cuando el componente se selecciona (para actualizar el formulario)
          // ✅ La actualización manual de inputs se maneja en editor-config.js para evitar duplicación
          this.on('component:selected', () => {
            console.log('🎯 [Heading] Componente seleccionado, sincronizando contenido desde DOM...');

            // Sincronizar desde DOM inmediatamente (sin setTimeout) para que el modelo tenga los valores antes del render
            // El editor-config.js se encargará de re-renderizar el TraitManager y actualizar los inputs
            if (this.syncContentFromDOM && typeof this.syncContentFromDOM === 'function') {
              this.syncContentFromDOM();
            }
          });

          // Inicializar valores por defecto si no existen
          if (!this.get('heading-margin')) {
            this.set('heading-margin', 'mb-0', { silent: true });
          }

          this.on('change:heading-text', this.updateText, this);
          this.on('change:heading-tag', this.updateTag, this);
          this.on('change:heading-size', this.updateSize, this);
          this.on('change:heading-color', this.updateColor, this);
          this.on('change:heading-align', this.updateAlign, this);
          this.on('change:heading-weight', this.updateWeight, this);
          this.on('change:heading-margin', this.updateMargin, this);
        },
        updateText() {
          const text = this.get('heading-text') || '';

          // ✅ CRÍTICO: Verificar si el usuario está editando actualmente el título
          // Si está editando, no actualizar el DOM para evitar que desaparezca
          if (this.view && this.view.el) {
            const el = this.view.el;

            // Verificar si el elemento tiene foco o está siendo editado
            const isEditing = document.activeElement === el ||
              el === document.querySelector('h1:focus, h2:focus, h3:focus, h4:focus, h5:focus, h6:focus') ||
              el.getAttribute('contenteditable') === 'true';

            if (isEditing) {
              // Si está siendo editado, no actualizar para evitar interferir
              console.log('⚠️ [Heading] Título está siendo editado, no actualizar DOM');
              return;
            }

            // Solo actualizar si el contenido es diferente para evitar bucles
            const currentText = el.textContent || el.innerText || '';
            if (currentText === text) {
              return; // Ya está actualizado, no hacer nada
            }

            // Actualizar el texto
            el.textContent = text;

            // Actualizar componentes y content solo si es necesario
            if (this.components && typeof this.components === 'function') {
              this.components(text);
            }
            if (this.get('content') !== undefined && this.get('content') !== text) {
              this.set('content', text, { silent: true });
            }
          }
        },
        updateTag() {
          const tag = this.get('heading-tag') || 'h2';
          if (this.view && this.view.el) {
            const currentAttrs = this.getAttributes();
            const currentClass = currentAttrs.class || this.view.el.className || '';
            const currentText = this.view.el.textContent || '';
            const newEl = document.createElement(tag);
            newEl.className = currentClass;
            newEl.textContent = currentText;
            newEl.setAttribute('data-gjs-name', 'Título');
            newEl.setAttribute('data-gjs-editable', 'false');
            this.view.el.parentNode.replaceChild(newEl, this.view.el);
            this.view.el = newEl;
            this.set('tagName', tag);
            this.setAttributes({
              class: currentClass,
              'data-gjs-name': 'Título',
              'data-gjs-editable': 'false'
            });
          }
        },
        updateSize() {
          const size = this.get('heading-size') || 'text-2xl';
          if (this.view && this.view.el) {
            const el = this.view.el;
            const currentAttrs = this.getAttributes();
            let currentClass = currentAttrs.class || el.className || '';
            currentClass = currentClass.replace(/text-(xl|2xl|3xl|4xl|5xl|6xl)/g, '').trim();
            currentClass = (currentClass + ' ' + size).trim().replace(/\s+/g, ' ');
            el.className = currentClass;
            this.setAttributes({ class: currentClass });
          }
        },
        updateColor() {
          const color = this.get('heading-color') || 'text-gray-900';
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
          const align = this.get('heading-align') || 'text-left';
          if (this.view && this.view.el) {
            const el = this.view.el;
            const currentAttrs = this.getAttributes();
            let currentClass = currentAttrs.class || el.className || '';
            currentClass = currentClass.replace(/text-(left|center|right)/g, '').trim();
            currentClass = (currentClass + ' ' + align).trim().replace(/\s+/g, ' ');
            el.className = currentClass;
            this.setAttributes({ class: currentClass });
          }
        },
        updateWeight() {
          const weight = this.get('heading-weight') || 'font-bold';
          if (this.view && this.view.el) {
            const el = this.view.el;
            const currentAttrs = this.getAttributes();
            let currentClass = currentAttrs.class || el.className || '';
            currentClass = currentClass.replace(/font-(normal|medium|semibold|bold|extrabold)/g, '').trim();
            currentClass = (currentClass + ' ' + weight).trim().replace(/\s+/g, ' ');
            el.className = currentClass;
            this.setAttributes({ class: currentClass });
          }
        },
        updateMargin() {
          const margin = this.get('heading-margin') || 'mb-0';
          if (this.view && this.view.el) {
            const el = this.view.el;
            const currentAttrs = this.getAttributes();
            let currentClass = currentAttrs.class || el.className || '';
            // Remover cualquier clase de margin existente
            currentClass = currentClass.replace(/mb-[0-8]/g, '').trim();
            // Solo agregar la clase de margin si no es mb-0 (sin espaciado)
            if (margin && margin !== 'mb-0') {
              currentClass = (currentClass + ' ' + margin).trim().replace(/\s+/g, ' ');
            }
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
    registerHeadingComponent(window.editor);
  } else {
    const checkEditor = setInterval(() => {
      if (typeof window !== 'undefined' && window.editor) {
        registerHeadingComponent(window.editor);
        clearInterval(checkEditor);
      }
    }, 100);

    setTimeout(() => {
      clearInterval(checkEditor);
    }, 10000);
  }

  if (typeof window !== 'undefined') {
    window.registerHeadingComponent = registerHeadingComponent;
  }
})();
