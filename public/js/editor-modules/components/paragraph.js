// Módulo del Componente Paragraph
// Componente de párrafo con opciones de estilo

(function () {
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
              type: 'color',
              name: 'paragraph-color',
              label: 'Color del Texto',
              changeProp: 1
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

                // ✅ CRÍTICO: Sincronizar color desde MÚLTIPLES FUENTES
                // Prioridad: 1) atributo data- 2) estilo inline 3) atributo style HTML
                let finalColor = null;
                
                // 1. Intentar obtener del atributo data-
                const dataColor = el.getAttribute('data-paragraph-color');
                if (dataColor && dataColor.startsWith('#')) {
                  finalColor = dataColor;
                  console.log('📥 [Paragraph] Color recuperado del atributo data-:', dataColor);
                }
                
                // 2. Si no hay atributo data-, intentar del estilo inline
                if (!finalColor) {
                  const inlineColor = el.style.color;
                  if (inlineColor) {
                    const hexColor = this.rgbToHex(inlineColor);
                    if (hexColor) {
                      finalColor = hexColor;
                      console.log('📥 [Paragraph] Color recuperado del estilo inline:', hexColor);
                    }
                  }
                }
                
                // 3. Si aún no hay color, intentar del atributo style HTML
                if (!finalColor) {
                  const styleAttr = el.getAttribute('style');
                  if (styleAttr && styleAttr.includes('color')) {
                    const colorMatch = styleAttr.match(/color:\s*([#\w(),-.\s]+)/i);
                    if (colorMatch) {
                      const colorValue = colorMatch[1].trim();
                      const hexColor = this.rgbToHex(colorValue);
                      if (hexColor) {
                        finalColor = hexColor;
                        console.log('📥 [Paragraph] Color recuperado del atributo style HTML:', hexColor);
                      }
                    }
                  }
                }
                
                // Aplicar el color encontrado
                if (finalColor) {
                  const currentColor = this.get('paragraph-color');
                  if (finalColor !== currentColor) {
                    this.set('paragraph-color', finalColor, { silent: false });
                    console.log('✅ [Paragraph] Color actualizado:', finalColor);
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

              // ✅ CRÍTICO: Sincronizar color desde MÚLTIPLES FUENTES
              // Prioridad: 1) atributo data- 2) estilo inline 3) estilos computados
              let finalColor = null;
              
              // 1. Intentar obtener del atributo data-
              const dataColor = el.getAttribute('data-paragraph-color');
              if (dataColor && dataColor.startsWith('#')) {
                finalColor = dataColor;
                console.log('📥 [Paragraph] Color recuperado del atributo data-:', dataColor);
              }
              
              // 2. Si no hay atributo data-, intentar del estilo inline
              if (!finalColor) {
                const inlineColor = el.style.color;
                if (inlineColor) {
                  const hexColor = this.rgbToHex(inlineColor);
                  if (hexColor) {
                    finalColor = hexColor;
                    console.log('📥 [Paragraph] Color recuperado del estilo inline:', hexColor);
                  }
                }
              }
              
              // 3. Si aún no hay color, intentar del estilo computado
              if (!finalColor) {
                const computedColor = window.getComputedStyle(el).color;
                if (computedColor) {
                  const hexColor = this.rgbToHex(computedColor);
                  if (hexColor) {
                    finalColor = hexColor;
                    console.log('📥 [Paragraph] Color recuperado del estilo computado:', hexColor);
                  }
                }
              }
              
              // Aplicar el color encontrado
              if (finalColor) {
                this.set('paragraph-color', finalColor, { silent: true });
                // ✅ CRÍTICO: Llamar updateColor() directamente ya que usamos silent: true
                this.updateColor();
              } else {
                // Usar color por defecto si no se encuentra nada
                this.set('paragraph-color', '#374151', { silent: true });
                // ✅ CRÍTICO: Llamar updateColor() directamente ya que usamos silent: true
                this.updateColor();
              }

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
        // Método auxiliar para convertir RGB a Hex
        rgbToHex(rgb) {
          if (!rgb) return null;
          if (rgb.startsWith('#')) return rgb;
          
          const result = rgb.match(/\d+/g);
          if (!result || result.length < 3) return null;
          
          const r = parseInt(result[0]);
          const g = parseInt(result[1]);
          const b = parseInt(result[2]);
          
          return '#' + ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1);
        },
        updateText() {
          const text = this.get('paragraph-text') || '';
          
          // ✅ CRÍTICO: Si el texto del modelo está vacío pero el DOM tiene contenido,
          // NO actualizar el DOM para evitar borrar el contenido existente
          if (this.view && this.view.el) {
            const el = this.view.el;
            const currentText = el.textContent || el.innerText || '';
            
            // Si el modelo tiene texto, actualizar el DOM
            if (text && text.trim()) {
              // Solo actualizar si es diferente para evitar bucles
              if (currentText !== text) {
                el.textContent = text;
                if (this.components && typeof this.components === 'function') {
                  this.components(text);
                }
              }
            } else if (!currentText || !currentText.trim()) {
              // Si tanto el modelo como el DOM están vacíos, está bien
              // No hacer nada
            } else {
              // Si el modelo está vacío pero el DOM tiene contenido,
              // sincronizar el modelo con el DOM en lugar de borrar el DOM
              console.log('⚠️ [Paragraph] Modelo vacío pero DOM tiene contenido, sincronizando modelo...');
              this.set('paragraph-text', currentText.trim(), { silent: true });
            }
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
          const color = this.get('paragraph-color') || '#374151';
          if (this.view && this.view.el) {
            const el = this.view.el;
            if (color && color.startsWith('#')) {
              // Aplicar color como estilo inline (persistente)
              el.style.setProperty('color', color, 'important');
              
              // ✅ CRÍTICO: También guardar en atributo data- para persistencia
              el.setAttribute('data-paragraph-color', color);
              
              console.log('🎨 [Paragraph] Color aplicado:', color);
              
              // ✅ Forzar guardado en modelo para que persista
              this.addStyle({ color: color });
            }
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
