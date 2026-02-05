// Módulo del Componente Container
// Contenedor flexible estilo Elementor con sistema de layout

(function() {
  'use strict';
  
  function registerContainerComponent(editor) {
    if (!editor || !editor.DomComponents) {
      console.warn('⚠️ Editor no disponible para registrar componente Container');
      return;
    }
    
    editor.DomComponents.addType('container', {
      isComponent: (el) => {
        if (el.classList && el.classList.contains('container-flex')) {
          return { type: 'container' };
        }
        return false;
      },
      model: {
        defaults: {
          name: 'Contenedor',
          tagName: 'div',
          editable: false,
          droppable: true,
          removable: true,
          selectable: true,
          'container-layout-mode': 'flex', // Valor por defecto
          'container-children-responsive': 'auto', // Valor por defecto para hijos responsive
          'container-direction': 'flex-col', // Por defecto: columna vertical (uno por ancho)
          attributes: {
            class: 'container-flex flex flex-col gap-4 p-6 min-h-[200px] rounded-lg',
            'data-gjs-name': 'Contenedor',
            'data-gjs-editable': 'false'
          },
          traits: [
            {
              type: 'select',
              name: 'container-layout-mode',
              label: 'Modo de Distribución',
              changeProp: 1,
              options: [
                { value: 'flex', name: 'Flexible (Flexbox)' },
                { value: 'grid-equal', name: 'Columnas Equitativas (Grid)' }
              ]
            },
            {
              type: 'select',
              name: 'container-direction',
              label: 'Dirección (Desktop)',
              changeProp: 1,
              options: [
                { value: 'flex-row', name: 'Horizontal (Fila)' },
                { value: 'flex-col', name: 'Vertical (Columna)' },
                { value: 'flex-row-reverse', name: 'Horizontal Invertido' },
                { value: 'flex-col-reverse', name: 'Vertical Invertido' }
              ]
            },
            {
              type: 'select',
              name: 'container-direction-tablet',
              label: 'Dirección (Tablet)',
              changeProp: 1,
              options: [
                { value: '', name: 'Heredar de Desktop' },
                { value: 'md:flex-row', name: 'Horizontal (Fila)' },
                { value: 'md:flex-col', name: 'Vertical (Columna)' },
                { value: 'md:flex-row-reverse', name: 'Horizontal Invertido' },
                { value: 'md:flex-col-reverse', name: 'Vertical Invertido' }
              ]
            },
            {
              type: 'select',
              name: 'container-direction-mobile',
              label: 'Dirección (Mobile)',
              changeProp: 1,
              options: [
                { value: '', name: 'Heredar de Desktop' },
                { value: 'flex-col', name: 'Vertical (Columna) - Recomendado' },
                { value: 'flex-row', name: 'Horizontal (Fila)' },
                { value: 'flex-col-reverse', name: 'Vertical Invertido' },
                { value: 'flex-row-reverse', name: 'Horizontal Invertido' }
              ]
            },
            {
              type: 'select',
              name: 'container-wrap',
              label: 'Ajuste de Línea',
              changeProp: 1,
              options: [
                { value: 'flex-wrap', name: 'Envolver (Wrap)' },
                { value: 'flex-nowrap', name: 'Sin Envolver (No Wrap)' },
                { value: 'flex-wrap-reverse', name: 'Envolver Invertido' }
              ]
            },
            {
              type: 'select',
              name: 'container-justify',
              label: 'Alineación Horizontal',
              changeProp: 1,
              options: [
                { value: 'justify-start', name: 'Inicio' },
                { value: 'justify-center', name: 'Centro' },
                { value: 'justify-end', name: 'Final' },
                { value: 'justify-between', name: 'Espacio Entre' },
                { value: 'justify-around', name: 'Espacio Alrededor' },
                { value: 'justify-evenly', name: 'Espacio Uniforme' }
              ]
            },
            {
              type: 'select',
              name: 'container-align',
              label: 'Alineación Vertical',
              changeProp: 1,
              options: [
                { value: 'items-start', name: 'Inicio' },
                { value: 'items-center', name: 'Centro' },
                { value: 'items-end', name: 'Final' },
                { value: 'items-stretch', name: 'Estirar' },
                { value: 'items-baseline', name: 'Línea Base' }
              ]
            },
            {
              type: 'select',
              name: 'container-gap',
              label: 'Espacio entre Elementos',
              changeProp: 1,
              options: [
                { value: 'gap-0', name: 'Sin Espacio' },
                { value: 'gap-1', name: 'Muy Pequeño (4px)' },
                { value: 'gap-2', name: 'Pequeño (8px)' },
                { value: 'gap-4', name: 'Normal (16px)' },
                { value: 'gap-6', name: 'Mediano (24px)' },
                { value: 'gap-8', name: 'Grande (32px)' },
                { value: 'gap-12', name: 'Extra Grande (48px)' }
              ]
            },
            {
              type: 'select',
              name: 'container-width',
              label: 'Ancho del Contenedor',
              changeProp: 1,
              options: [
                { value: 'w-full', name: 'Ancho Completo (100%)' },
                { value: 'w-auto', name: 'Automático' },
                { value: 'container', name: 'Contenedor Responsive' },
                { value: 'max-w-7xl', name: 'Muy Ancho (1280px)' },
                { value: 'max-w-6xl', name: 'Ancho (1152px)' },
                { value: 'max-w-4xl', name: 'Mediano (896px)' },
                { value: 'max-w-2xl', name: 'Pequeño (672px)' },
                { value: 'max-w-xl', name: 'Extra Pequeño (576px)' }
              ]
            },
            {
              type: 'select',
              name: 'container-padding',
              label: 'Espaciado Interno',
              changeProp: 1,
              options: [
                { value: 'p-0', name: 'Sin Espaciado' },
                { value: 'p-2', name: 'Muy Pequeño (8px)' },
                { value: 'p-4', name: 'Pequeño (16px)' },
                { value: 'p-6', name: 'Normal (24px)' },
                { value: 'p-8', name: 'Grande (32px)' },
                { value: 'p-12', name: 'Extra Grande (48px)' }
              ]
            },
            {
              type: 'select',
              name: 'container-margin',
              label: 'Margen Externo',
              changeProp: 1,
              options: [
                { value: '', name: 'Sin Margen' },
                { value: 'mx-auto', name: 'Centrado Horizontal' },
                { value: 'm-0', name: 'Sin Margen' },
                { value: 'm-4', name: 'Pequeño (16px)' },
                { value: 'm-8', name: 'Mediano (32px)' },
                { value: 'm-12', name: 'Grande (48px)' }
              ]
            },
            {
              type: 'select',
              name: 'container-children-responsive',
              label: 'Hijos Responsive',
              changeProp: 1,
              options: [
                { value: 'auto', name: 'Automático (Según layout)' },
                { value: 'full-width', name: 'Ancho Completo en Móvil' },
                { value: 'equal-responsive', name: 'Equitativos Responsive' }
              ]
            }
          ]
        },
        init() {
          // Asegurar que el valor por defecto esté establecido
          if (!this.get('container-layout-mode')) {
            this.set('container-layout-mode', 'flex', { silent: true });
          }
          
          const syncInitialValues = () => {
            if (this.view && this.view.el) {
              const el = this.view.el;
              const classList = (el.className || '').split(' ').filter(c => c.trim());
              
              if (!classList.includes('container-flex')) {
                el.classList.add('container-flex');
              }
              // Detectar modo de layout
              const isGrid = classList.includes('grid');
              const isFlex = classList.includes('flex');
              const layoutMode = isGrid ? 'grid-equal' : (isFlex ? 'flex' : 'flex');
              // Establecer sin silent para que el TraitManager lo detecte
              const currentMode = this.get('container-layout-mode');
              if (currentMode !== layoutMode) {
                this.set('container-layout-mode', layoutMode, { silent: false });
              } else if (!currentMode) {
                // Si no tiene valor, establecer el por defecto
                this.set('container-layout-mode', 'flex', { silent: false });
              }
              
              if (!isGrid && !isFlex) {
                el.classList.add('flex');
              }
              
              // Detectar dirección - buscar tanto clases directas como responsive
              const directionMatch = classList.find(c => c.match(/^flex-(row|col)(-reverse)?$/));
              const mdDirectionMatch = classList.find(c => c.match(/^md:flex-(row|col)(-reverse)?$/));
              
              // flex-col + md:flex-row: móvil columna, desktop fila. Guardar desktop como dirección
              // para que updateDirection reconstruya flex-col + md:flex-row y no se descuadre al cargar.
              if (directionMatch && mdDirectionMatch) {
                const base = directionMatch;
                const desktop = mdDirectionMatch.replace('md:', '');
                if ((base === 'flex-col' || base === 'flex-col-reverse') && (desktop === 'flex-row' || desktop === 'flex-row-reverse')) {
                  this.set('container-direction', desktop, { silent: true });
                } else {
                  this.set('container-direction', directionMatch, { silent: true });
                }
              } else if (directionMatch) {
                // Si hay una clase directa (sin breakpoint), establecerla como dirección desktop
                this.set('container-direction', directionMatch, { silent: true });
                
                // Si la clase directa es flex-row, convertir INMEDIATAMENTE a mobile-first
                if (directionMatch === 'flex-row' || directionMatch === 'flex-row-reverse') {
                  // Remover flex-row del elemento directamente
                  el.classList.remove('flex-row', 'flex-row-reverse');
                  // Agregar flex-col inmediatamente
                  if (!el.classList.contains('flex-col') && !el.classList.contains('flex-col-reverse')) {
                    el.classList.add('flex-col');
                  }
                  // Agregar md:flex-row para desktop
                  const desktopDir = directionMatch.replace('flex-', 'md:flex-');
                  if (!el.classList.contains(desktopDir)) {
                    el.classList.add(desktopDir);
                  }
                  // Actualizar atributos
                  this.setAttributes({ class: el.className });
                  
                  // También forzar actualización de dirección después de sincronizar
                  setTimeout(() => {
                    this.updateDirection();
                  }, 150);
                }
              } else if (mdDirectionMatch) {
                // Si solo hay clase responsive, extraer la dirección base
                const baseDirection = mdDirectionMatch.replace('md:', '');
                this.set('container-direction', baseDirection, { silent: true });
                
                // Si es md:flex-row, asegurar que haya flex-col en móvil
                if (mdDirectionMatch.startsWith('md:flex-row')) {
                  if (!el.classList.contains('flex-col') && !el.classList.contains('flex-col-reverse')) {
                    el.classList.add('flex-col');
                    this.setAttributes({ class: el.className });
                  }
                }
              } else {
                // Si no hay ninguna dirección, pero el elemento tiene 'flex', aplicar mobile-first por defecto
                if (classList.includes('flex') && !classList.some(c => c.match(/^flex-(row|col)(-reverse)?$/) || c.match(/^md:flex-(row|col)(-reverse)?$/))) {
                  // Aplicar flex-col por defecto
                  if (!el.classList.contains('flex-col')) {
                    el.classList.add('flex-col');
                    this.setAttributes({ class: el.className });
                  }
                }
              }
              
              const wrapMatch = classList.find(c => c.match(/^flex-(wrap|nowrap)(-reverse)?$/));
              if (wrapMatch) {
                this.set('container-wrap', wrapMatch, { silent: true });
              }
              
              const justifyMatch = classList.find(c => c.match(/^justify-(start|center|end|between|around|evenly)$/));
              if (justifyMatch) {
                this.set('container-justify', justifyMatch, { silent: true });
              }
              
              const alignMatch = classList.find(c => c.match(/^items-(start|center|end|stretch|baseline)$/));
              if (alignMatch) {
                this.set('container-align', alignMatch, { silent: true });
              }
              
              const gapMatch = classList.find(c => c.match(/^gap-[0-9]+$/));
              if (gapMatch) {
                this.set('container-gap', gapMatch, { silent: true });
              }
              
              const widthMatch = classList.find(c => c.match(/^(w-(full|auto)|container|max-w-(7xl|6xl|4xl|2xl|xl))$/));
              if (widthMatch) {
                this.set('container-width', widthMatch, { silent: true });
              }
              
              const paddingMatch = classList.find(c => c.match(/^p-[0-9]+$/));
              if (paddingMatch) {
                this.set('container-padding', paddingMatch, { silent: true });
              }
              
              const marginMatch = classList.find(c => c.match(/^(mx-auto|m-[0-9]+)$/));
              if (marginMatch) {
                this.set('container-margin', marginMatch, { silent: true });
              }
            }
          };
          
          setTimeout(() => {
            syncInitialValues();
            // Aplicar dirección con comportamiento mobile-first después de sincronizar
            setTimeout(() => {
              this.updateDirection();
              // Si el modo es grid-equal, aplicar el layout
              if (this.get('container-layout-mode') === 'grid-equal') {
                setTimeout(() => {
                  this.updateLayoutMode();
                }, 50);
              } else {
                // En modo flex, actualizar layout y hijos responsive después de inicializar
                setTimeout(() => {
                  this.updateLayoutMode();
                  this.updateChildrenResponsive();
                }, 100);
              }
            }, 50);
          }, 100);
          this.on('component:mount', () => {
            syncInitialValues();
            // Aplicar dirección con comportamiento mobile-first después de sincronizar
            setTimeout(() => {
              this.updateDirection();
              if (this.get('container-layout-mode') === 'grid-equal') {
                setTimeout(() => this.updateLayoutMode(), 50);
              } else {
                // En modo flex, actualizar layout y hijos responsive después de montar
                setTimeout(() => {
                  this.updateLayoutMode();
                  this.updateChildrenResponsive();
                }, 100);
              }
            }, 50);
          });
          this.on('component:selected', () => {
            syncInitialValues();
            // Aplicar dirección con comportamiento mobile-first después de sincronizar
            setTimeout(() => {
              this.updateDirection();
              if (this.get('container-layout-mode') === 'grid-equal') {
                setTimeout(() => this.updateLayoutMode(), 50);
              } else {
                // En modo flex, actualizar layout y hijos responsive
                setTimeout(() => {
                  this.updateLayoutMode();
                  this.updateChildrenResponsive();
                }, 100);
              }
            }, 50);
          });
          
          // Listener para cambios en layout mode - debe ejecutarse inmediatamente
          this.on('change:container-layout-mode', () => {
            setTimeout(() => {
              this.updateLayoutMode();
            }, 50);
          });
          
          // Listener para mantener los estilos de grid después de que GrapesJS los procese
          this.on('change:style', () => {
            if (this.get('container-layout-mode') === 'grid-equal') {
              const gridCols = this.get('grid-template-cols');
              const childCount = this.get('grid-columns-count');
              if (gridCols && childCount && this.view && this.view.el) {
                const el = this.view.el;
                // Re-aplicar los estilos de grid si fueron removidos
                setTimeout(() => {
                  const currentCols = window.getComputedStyle(el).gridTemplateColumns;
                  if (!currentCols.includes('repeat') && !currentCols.includes('fr')) {
                    
                    // Re-aplicar usando CSS rule
                    if (window.editor && window.editor.Css) {
                      const componentId = this.getId();
                      if (componentId) {
                        let cssRule = window.editor.Css.getRule(`#${componentId}`);
                        if (!cssRule) {
                          cssRule = window.editor.Css.setRule(`#${componentId}`, {});
                        }
                        const currentStyles = cssRule.getStyle() || {};
                        currentStyles['display'] = 'grid';
                        currentStyles['grid-template-columns'] = gridCols;
                        currentStyles['grid-auto-rows'] = 'auto';
                        currentStyles['grid-auto-flow'] = 'row';
                        cssRule.setStyle(currentStyles);
                      }
                    }
                    
                    // También usar addStyle si está disponible
                    if (typeof this.addStyle === 'function') {
                      this.addStyle({
                        'display': 'grid',
                        'grid-template-columns': gridCols,
                        'grid-auto-rows': 'auto',
                        'grid-auto-flow': 'row'
                      });
                    }
                    
                    el.style.setProperty('display', 'grid', 'important');
                    el.style.setProperty('grid-template-columns', gridCols, 'important');
                    el.style.setProperty('grid-auto-rows', 'auto', 'important');
                    el.style.setProperty('grid-auto-flow', 'row', 'important');
                  }
                }, 50);
              }
            }
          });
          
          this.on('change:container-direction', () => {
            this.updateDirection();
            // Actualizar hijos cuando cambie la dirección
            setTimeout(() => {
              if (this.get('container-layout-mode') === 'flex') {
                this.updateLayoutMode();
              }
            }, 50);
          });
          this.on('change:container-direction-tablet', () => {
            this.updateDirection();
            setTimeout(() => {
              if (this.get('container-layout-mode') === 'flex') {
                this.updateLayoutMode();
              }
            }, 50);
          });
          this.on('change:container-direction-mobile', () => {
            this.updateDirection();
            setTimeout(() => {
              if (this.get('container-layout-mode') === 'flex') {
                this.updateLayoutMode();
              }
            }, 50);
          });
          this.on('change:container-wrap', this.updateWrap, this);
          this.on('change:container-justify', this.updateJustify, this);
          this.on('change:container-align', this.updateAlign, this);
          this.on('change:container-gap', () => {
            // Si está en modo grid, actualizar también el layout
            if (this.get('container-layout-mode') === 'grid-equal') {
              setTimeout(() => this.updateLayoutMode(), 50);
            } else {
              this.updateGap();
            }
          });
          this.on('change:container-width', this.updateWidth, this);
          this.on('change:container-padding', this.updatePadding, this);
          this.on('change:container-margin', this.updateMargin, this);
          this.on('change:container-children-responsive', () => {
            // Actualizar layout cuando cambie el modo responsive
            setTimeout(() => {
              this.updateLayoutMode();
            }, 50);
          });
          
          // Escuchar cambios en los hijos para actualizar grid si es necesario
          this.on('component:add', () => {
            setTimeout(() => {
              // Actualizar layout para aplicar clases responsive a todos los hijos
              this.updateLayoutMode();
              // Forzar actualización de hijos después de un pequeño delay
              setTimeout(() => {
                this.updateChildrenResponsive();
              }, 100);
            }, 200);
          });
          
          this.on('component:remove', () => {
            setTimeout(() => {
              // Actualizar layout para aplicar clases responsive a los hijos restantes
              this.updateLayoutMode();
              // Forzar actualización de hijos después de un pequeño delay
              setTimeout(() => {
                this.updateChildrenResponsive();
              }, 100);
            }, 200);
          });
          
          // Escuchar cuando los hijos se monten para aplicar clases responsive
          this.on('component:mount', () => {
            setTimeout(() => {
              this.updateChildrenResponsive();
            }, 300);
          });
          
          // Listener para cambios de dispositivo - actualizar dirección cuando cambie el modo
          if (window.editor) {
            window.editor.on('change:device', () => {
              // Cuando cambia el dispositivo, actualizar la dirección para asegurar mobile-first
              setTimeout(() => {
                if (this.get('container-layout-mode') === 'flex') {
                  this.updateDirection();
                  this.updateLayoutMode();
                  this.updateChildrenResponsive();
                }
              }, 100);
            });
            
            window.editor.on('component:update', (component) => {
              if (component === this && this.get('container-layout-mode') === 'grid-equal') {
                setTimeout(() => {
                  const gridCols = this.get('grid-template-cols');
                  if (gridCols && this.view && this.view.el) {
                    const el = this.view.el;
                    const currentCols = window.getComputedStyle(el).gridTemplateColumns;
                    if (!currentCols.includes('repeat') && !currentCols.includes('fr')) {
                      // Re-aplicar usando CSS rule
                      if (window.editor && window.editor.Css) {
                        const componentId = this.getId();
                        if (componentId) {
                          let cssRule = window.editor.Css.getRule(`#${componentId}`);
                          if (!cssRule) {
                            cssRule = window.editor.Css.setRule(`#${componentId}`, {});
                          }
                          const currentStyles = cssRule.getStyle() || {};
                          currentStyles['display'] = 'grid';
                          currentStyles['grid-template-columns'] = gridCols;
                          currentStyles['grid-auto-rows'] = 'auto';
                          currentStyles['grid-auto-flow'] = 'row';
                          cssRule.setStyle(currentStyles);
                        }
                      }
                      
                      // También usar addStyle si está disponible
                      if (typeof this.addStyle === 'function') {
                        this.addStyle({
                          'display': 'grid',
                          'grid-template-columns': gridCols,
                          'grid-auto-rows': 'auto',
                          'grid-auto-flow': 'row'
                        });
                      }
                    }
                  }
                }, 100);
              }
            });
          }
        },
        updateLayoutMode() {
          const layoutMode = this.get('container-layout-mode') || 'flex';
          
          if (!this.view || !this.view.el) {
            console.warn('⚠️ No hay vista o elemento disponible');
            return;
          }
          
          const el = this.view.el;
          const currentAttrs = this.getAttributes();
          let currentClass = currentAttrs.class || el.className || '';
          const classList = currentClass.split(' ').filter(c => c.trim());
          
          // Remover TODAS las clases de grid y flex existentes de forma segura
          // Incluyendo todas las variantes de Tailwind (grid-cols-1, grid-cols-2, md:grid-cols-*, etc.)
          const filteredClasses = classList.filter(cls => {
            return !cls.match(/^(grid|flex|grid-cols-|md:grid-cols-|lg:grid-cols-|xl:grid-cols-|sm:grid-cols-|flex-(row|col))/);
          });
          classList.length = 0;
          classList.push(...filteredClasses);
          
          if (layoutMode === 'grid-equal') {
            // Modo Grid: columnas equitativas
            classList.push('grid');
            
            // Remover todas las clases de flex-direction ya que grid no las usa
            for (let i = classList.length - 1; i >= 0; i--) {
              if (classList[i].match(/^flex-(row|col)(-reverse)?$/)) {
                classList.splice(i, 1);
              }
            }
            
            // Función para aplicar grid
            const applyGrid = () => {
              // Obtener hijos usando el modelo de GrapesJS para contar correctamente
              const components = this.components();
              const childCount = components.length;
              const responsiveMode = this.get('container-children-responsive') || 'auto';
              
              if (childCount > 0) {
                // Si el modo responsive está activado, usar clases de Tailwind
                if (responsiveMode === 'full-width' || responsiveMode === 'equal-responsive') {
                  // Remover clases de grid-cols anteriores
                  const gridColsToRemove = [];
                  Array.from(el.classList).forEach(cls => {
                    if (cls.match(/grid-cols-|md:grid-cols-|lg:grid-cols-|xl:grid-cols-|sm:grid-cols-/)) {
                      gridColsToRemove.push(cls);
                    }
                  });
                  gridColsToRemove.forEach(cls => el.classList.remove(cls));
                  
                  // Aplicar clases responsive de grid según número de hijos
                  if (childCount === 2) {
                    classList.push('grid-cols-1', 'md:grid-cols-2');
                  } else if (childCount === 3) {
                    classList.push('grid-cols-1', 'md:grid-cols-2', 'lg:grid-cols-3');
                  } else if (childCount === 4) {
                    classList.push('grid-cols-1', 'md:grid-cols-2', 'lg:grid-cols-4');
                  } else if (childCount > 4) {
                    classList.push('grid-cols-1', 'md:grid-cols-2', 'lg:grid-cols-3', 'xl:grid-cols-4');
                  }
                  
                  // No usar grid-template-columns inline si usamos clases de Tailwind
                  // Solo aplicar gap
                  const gap = this.get('container-gap') || 'gap-4';
                  if (!classList.some(c => c.startsWith('gap-'))) {
                    classList.push(gap);
                  }
                  
                  // Aplicar clases responsive a los hijos
                  components.forEach((component, index) => {
                    const childEl = component.view ? component.view.el : null;
                    if (!childEl) return;
                    
                    // Remover clases de width anteriores
                    if (childEl.classList) {
                      const classesToRemove = [
                        'w-full', 'w-auto', 'w-1/2', 'w-1/3', 'w-1/4', 'w-2/3', 'w-3/4',
                        'md:w-full', 'md:w-1/2', 'md:w-1/3', 'md:w-1/4', 'md:w-2/3', 'md:w-3/4',
                        'lg:w-full', 'lg:w-1/2', 'lg:w-1/3', 'lg:w-1/4', 'lg:w-2/3', 'lg:w-3/4',
                        'xl:w-full', 'xl:w-1/2', 'xl:w-1/3', 'xl:w-1/4', 'xl:w-2/3', 'xl:w-3/4',
                        'sm:w-full', 'sm:w-1/2', 'sm:w-1/3', 'sm:w-1/4', 'sm:w-2/3', 'sm:w-3/4'
                      ];
                      classesToRemove.forEach(cls => childEl.classList.remove(cls));
                    }
                    
                    // Limpiar estilos inline de width
                    childEl.style.removeProperty('width');
                    childEl.style.removeProperty('max-width');
                    childEl.style.removeProperty('min-width');
                    childEl.style.removeProperty('flex');
                    childEl.style.removeProperty('flex-grow');
                    childEl.style.removeProperty('flex-shrink');
                    childEl.style.removeProperty('flex-basis');
                    childEl.style.removeProperty('display');
                    
                    childEl.style.setProperty('box-sizing', 'border-box', 'important');
                    childEl.setAttribute('data-grid-item', 'true');
                  });
                  
                  // Aplicar clases actualizadas
                  const newClass = classList.filter(c => c).join(' ').replace(/\s+/g, ' ').trim();
                  el.className = newClass;
                  this.setAttributes({ class: newClass });
                  
                  // Limpiar estilos inline de grid ya que usamos clases de Tailwind
                  el.style.removeProperty('display');
                  el.style.removeProperty('grid-template-columns');
                  el.style.removeProperty('grid-auto-rows');
                  el.style.removeProperty('grid-auto-flow');
                  
                  return; // Salir temprano si usamos clases de Tailwind
                }
                
                // Modo automático: usar grid-template-columns inline (comportamiento original)
                // CRÍTICO: Remover TODAS las clases de grid-cols-* de Tailwind que puedan interferir
                const classesToRemove = [];
                Array.from(el.classList).forEach(cls => {
                  if (cls.match(/grid-cols-|md:grid-cols-|lg:grid-cols-|xl:grid-cols-|sm:grid-cols-/)) {
                    classesToRemove.push(cls);
                  }
                });
                classesToRemove.forEach(cls => el.classList.remove(cls));
                if (classesToRemove.length > 0) {
                  console.log(`🗑️ Clases removidas: ${classesToRemove.join(', ')}`);
                }
                
                // Guardar la configuración del grid en el modelo para persistencia
                const gridColsValue = `repeat(${childCount}, 1fr)`;
                this.set('grid-columns-count', childCount, { silent: true });
                this.set('grid-template-cols', gridColsValue, { silent: true });
                
                // CRÍTICO: Guardar estilos usando el sistema de CSS de GrapesJS para persistencia
                if (window.editor && window.editor.Css) {
                  let componentId = this.getId();
                  
                  // Si no tiene ID, crear uno
                  if (!componentId || componentId.startsWith('i')) {
                    componentId = `container-${Date.now()}-${Math.floor(Math.random() * 1000)}`;
                    this.addAttributes({ id: componentId });
                  }
                  
                  if (componentId) {
                    let cssRule = window.editor.Css.getRule(`#${componentId}`);
                    if (!cssRule) {
                      cssRule = window.editor.Css.setRule(`#${componentId}`, {});
                    }
                    const currentStyles = cssRule.getStyle() || {};
                    currentStyles['display'] = 'grid';
                    currentStyles['grid-template-columns'] = gridColsValue;
                    currentStyles['grid-auto-rows'] = 'auto';
                    currentStyles['grid-auto-flow'] = 'row';
                    cssRule.setStyle(currentStyles);
                  }
                }
                
                // También usar addStyle si está disponible
                if (typeof this.addStyle === 'function') {
                  this.addStyle({
                    'display': 'grid',
                    'grid-template-columns': gridColsValue,
                    'grid-auto-rows': 'auto',
                    'grid-auto-flow': 'row'
                  });
                }
                
                // Aplicar como inline para que se vea inmediatamente
                el.style.setProperty('display', 'grid', 'important');
                el.style.setProperty('grid-template-columns', gridColsValue, 'important');
                el.style.setProperty('grid-auto-rows', 'auto', 'important');
                el.style.setProperty('grid-auto-flow', 'row', 'important');
                
                // Asegurar que gap esté configurado
                const gap = this.get('container-gap') || 'gap-4';
                if (!classList.some(c => c.startsWith('gap-'))) {
                  classList.push(gap);
                }
                
                // Aplicar estilos a los hijos (modo automático - grid se encarga del layout)
                components.forEach((component, index) => {
                  const childEl = component.view ? component.view.el : null;
                  if (!childEl) return;
                  
                  // Remover clases de flex y width de los hijos
                  if (childEl.classList) {
                    const classesToRemove = ['flex-1', 'flex-grow', 'flex-shrink', 'flex-basis-auto', 
                      'w-full', 'w-auto', 'w-1/2', 'w-1/3', 'w-1/4', 'w-2/3', 'w-3/4',
                      'md:w-full', 'md:w-1/2', 'md:w-1/3', 'md:w-1/4', 'md:w-2/3', 'md:w-3/4',
                      'lg:w-full', 'lg:w-1/2', 'lg:w-1/3', 'lg:w-1/4', 'lg:w-2/3', 'lg:w-3/4',
                      'xl:w-full', 'xl:w-1/2', 'xl:w-1/3', 'xl:w-1/4', 'xl:w-2/3', 'xl:w-3/4',
                      'sm:w-full', 'sm:w-1/2', 'sm:w-1/3', 'sm:w-1/4', 'sm:w-2/3', 'sm:w-3/4'];
                    classesToRemove.forEach(cls => childEl.classList.remove(cls));
                  }
                  
                  // Limpiar estilos inline relacionados con width, flex y display
                  childEl.style.setProperty('width', 'auto', 'important');
                  childEl.style.setProperty('max-width', 'none', 'important');
                  childEl.style.setProperty('min-width', '0', 'important');
                  childEl.style.setProperty('flex', 'none', 'important');
                  childEl.style.setProperty('flex-grow', '0', 'important');
                  childEl.style.setProperty('flex-shrink', '0', 'important');
                  childEl.style.setProperty('flex-basis', 'auto', 'important');
                  
                  // Asegurar que no tenga display block
                  const computedDisplay = window.getComputedStyle(childEl).display;
                  if (computedDisplay === 'block') {
                    childEl.style.setProperty('display', 'inline-block', 'important');
                  }
                  
                  childEl.style.setProperty('box-sizing', 'border-box', 'important');
                  childEl.style.setProperty('overflow', 'visible', 'important');
                  childEl.setAttribute('data-grid-item', 'true');
                });
              } else {
                // Si no hay hijos, usar auto-fill para columnas responsivas
                el.style.setProperty('display', 'grid', 'important');
                el.style.setProperty('grid-template-columns', 'repeat(auto-fill, minmax(200px, 1fr))', 'important');
                el.style.setProperty('grid-auto-rows', 'auto', 'important');
                el.style.setProperty('grid-auto-flow', 'row', 'important');
              }
              
              // Aplicar clases actualizadas
              const newClass = classList.filter(c => c).join(' ').replace(/\s+/g, ' ').trim();
              el.className = newClass;
              this.setAttributes({ class: newClass });
              
              // Forzar recálculo del layout
              void el.offsetHeight; // Trigger reflow
              
              // Verificar después del reflow
              setTimeout(() => {
                const computedDisplay = window.getComputedStyle(el).display;
                const computedGridCols = window.getComputedStyle(el).gridTemplateColumns;
                
                // Verificar si el grid se aplicó correctamente
                if (computedDisplay !== 'grid') {
                  el.style.setProperty('display', 'grid', 'important');
                }
                
                // Si el grid-template-columns no tiene el formato correcto, forzarlo
                if (!computedGridCols.includes('repeat') && !computedGridCols.includes('fr')) {
                  const childCount = this.components().length;
                  el.style.setProperty('grid-template-columns', `repeat(${childCount}, 1fr)`, 'important');
                }
              }, 100);
            };
            
            // Aplicar grid inmediatamente y también después de un pequeño delay para asegurar
            applyGrid();
            setTimeout(applyGrid, 100);
            setTimeout(applyGrid, 300);
            
          } else {
            // Modo Flex: contenedores flexibles
            classList.push('flex');
            
            // Limpiar estilos de grid del modelo
            if (window.editor && window.editor.Css) {
              const componentId = this.getId();
              if (componentId) {
                const cssRule = window.editor.Css.getRule(`#${componentId}`);
                if (cssRule) {
                  const currentStyles = cssRule.getStyle() || {};
                  delete currentStyles['display'];
                  delete currentStyles['grid-template-columns'];
                  delete currentStyles['grid-auto-rows'];
                  delete currentStyles['grid-auto-flow'];
                  cssRule.setStyle(currentStyles);
                }
              }
            }
            
            // Limpiar usando setStyle si está disponible
            if (typeof this.setStyle === 'function') {
              const currentStyles = this.getStyle() || {};
              delete currentStyles['display'];
              delete currentStyles['grid-template-columns'];
              delete currentStyles['grid-auto-rows'];
              delete currentStyles['grid-auto-flow'];
              this.setStyle(currentStyles);
            }
            
            this.set('grid-columns-count', null, { silent: true });
            this.set('grid-template-cols', null, { silent: true });
            
            // Remover estilos inline de grid
            el.style.removeProperty('grid-template-columns');
            el.style.removeProperty('grid-auto-rows');
            el.style.removeProperty('grid-auto-flow');
            el.style.removeProperty('display');
            
            // Aplicar estilos responsive a los hijos (estilo Elementor)
            const components = this.components();
            const responsiveMode = this.get('container-children-responsive') || 'auto';
            const childCount = components.length;
            const directionMobile = this.get('container-direction-mobile') || '';
            const direction = this.get('container-direction') || 'flex-col'; // Por defecto: columna
            
            // Detectar si el contenedor está en columna
            const isColumnOnDesktop = direction === 'flex-col' || direction === 'flex-col-reverse';
            // En móvil, por defecto siempre se apilan verticalmente (flex-col) a menos que se especifique otra dirección
            const isColumnOnMobile = directionMobile === 'flex-col' || 
                                    directionMobile === 'flex-col-reverse' ||
                                    (directionMobile === ''); // Por defecto, móvil usa flex-col
            const isRowOnDesktop = direction === 'flex-row' || direction === 'flex-row-reverse';
            
            components.forEach((component, index) => {
              const childEl = component.view ? component.view.el : null;
              if (!childEl || !childEl.classList) return;
              
              // Remover clases responsive anteriores
              const classesToRemove = [
                'flex-1', 'flex-grow', 'flex-shrink', 'flex-basis-auto',
                'w-full', 'w-auto', 'w-1/2', 'w-1/3', 'w-1/4', 'w-2/3', 'w-3/4',
                'md:w-full', 'md:w-1/2', 'md:w-1/3', 'md:w-1/4', 'md:w-2/3', 'md:w-3/4',
                'lg:w-full', 'lg:w-1/2', 'lg:w-1/3', 'lg:w-1/4', 'lg:w-2/3', 'lg:w-3/4',
                'xl:w-full', 'xl:w-1/2', 'xl:w-1/3', 'xl:w-1/4', 'xl:w-2/3', 'xl:w-3/4',
                'sm:w-full', 'sm:w-1/2', 'sm:w-1/3', 'sm:w-1/4', 'sm:w-2/3', 'sm:w-3/4',
                'md:flex-1', 'lg:flex-1', 'xl:flex-1'
              ];
              classesToRemove.forEach(cls => childEl.classList.remove(cls));
              
              // SIEMPRE aplicar w-full en móvil (por defecto responsive)
              // Tailwind es mobile-first, así que w-full se aplica desde móvil
              childEl.classList.add('w-full');
              
              // Aplicar clases responsive según el modo (estilo Elementor)
              if (responsiveMode === 'full-width') {
                // En desktop: si está en fila, usar flex-1; si está en columna, mantener w-full
                if (isRowOnDesktop) {
                  childEl.classList.add('md:flex-1');
                }
                // Si está en columna, ya tiene w-full aplicado
              } else if (responsiveMode === 'equal-responsive') {
                // En desktop: distribución equitativa según número de hijos (solo si está en fila)
                if (isRowOnDesktop) {
                  if (childCount === 2) {
                    childEl.classList.add('md:w-1/2');
                  } else if (childCount === 3) {
                    childEl.classList.add('md:w-1/2', 'lg:w-1/3');
                  } else if (childCount === 4) {
                    childEl.classList.add('md:w-1/2', 'lg:w-1/4');
                  } else if (childCount > 4) {
                    // Para más de 4 hijos, usar distribución flexible
                    childEl.classList.add('md:w-1/2', 'lg:w-1/3', 'xl:w-1/4');
                  }
                }
                // Si está en columna, ya tiene w-full aplicado
              } else {
                // Modo automático: SIEMPRE w-full en móvil
                // En desktop: si está en fila, usar flex-1; si está en columna, mantener w-full
                if (isRowOnDesktop) {
                  childEl.classList.add('md:flex-1');
                }
                // Si está en columna, ya tiene w-full aplicado
              }
              
              // Remover estilos inline de width
              childEl.style.removeProperty('width');
              childEl.style.removeProperty('max-width');
              childEl.style.removeProperty('min-width');
              childEl.removeAttribute('data-grid-item');
            });
            
            const newClass = classList.filter(c => c).join(' ').replace(/\s+/g, ' ').trim();
            el.className = newClass;
            this.setAttributes({ class: newClass });
            
            // Forzar actualización de hijos responsive después de actualizar el layout
            setTimeout(() => {
              this.updateChildrenResponsive();
            }, 50);
          }
        },
        updateDirection() {
          const layoutMode = this.get('container-layout-mode') || 'flex';
          // Solo aplicar dirección si está en modo flex
          if (layoutMode === 'flex') {
            if (this.view && this.view.el) {
              const el = this.view.el;
              const currentAttrs = this.getAttributes();
              let currentClass = currentAttrs.class || el.className || '';
              if (!currentClass.includes('flex')) {
                currentClass = (currentClass + ' flex').trim();
              }
              
              // Remover todas las clases de dirección (incluyendo responsive)
              // Primero convertir a array, filtrar, y luego volver a string para evitar espacios dobles
              const classArray = currentClass.split(/\s+/).filter(c => {
                return c.trim() && 
                       !c.match(/^flex-(row|col)(-reverse)?$/) &&
                       !c.match(/^md:flex-(row|col)(-reverse)?$/) &&
                       !c.match(/^lg:flex-(row|col)(-reverse)?$/) &&
                       !c.match(/^xl:flex-(row|col)(-reverse)?$/) &&
                       !c.match(/^sm:flex-(row|col)(-reverse)?$/);
              });
              currentClass = classArray.join(' ').trim();
              
              // Obtener direcciones por dispositivo
              const direction = this.get('container-direction') || 'flex-col'; // Por defecto: columna
              const directionTablet = this.get('container-direction-tablet') || '';
              const directionMobile = this.get('container-direction-mobile') || '';
              
              // Aplicar lógica responsive estilo Elementor con enfoque mobile-first
              // Por defecto, en móvil los hijos se apilan verticalmente (flex-col)
              if (directionMobile) {
                // Mobile-first: aplicar dirección mobile como base
                currentClass = (currentClass + ' ' + directionMobile).trim();
                
                // Si tablet tiene dirección, aplicarla
                if (directionTablet) {
                  currentClass = (currentClass + ' ' + directionTablet).trim();
                } else if (direction !== directionMobile) {
                  // Si tablet no tiene dirección pero desktop es diferente, aplicar desktop en md
                  const desktopDir = direction.replace('flex-', 'md:flex-');
                  currentClass = (currentClass + ' ' + desktopDir).trim();
                }
              } else {
                // Sin dirección mobile específica: SIEMPRE usar mobile-first
                // Por defecto, móvil SIEMPRE usa flex-col (apilado vertical - uno encima del otro)
                // IMPORTANTE: flex-col se aplica directamente sin breakpoint para que funcione en móvil
                currentClass = (currentClass + ' flex-col').trim();
                
                // Si tablet tiene dirección, aplicarla
                if (directionTablet) {
                  currentClass = (currentClass + ' ' + directionTablet).trim();
                } else {
                  // Si desktop está en fila, aplicar md:flex-row para desktop
                  const isRowOnDesktop = direction === 'flex-row' || direction === 'flex-row-reverse';
                  if (isRowOnDesktop) {
                    const desktopDir = direction.replace('flex-', 'md:flex-');
                    currentClass = (currentClass + ' ' + desktopDir).trim();
                  } else {
                    // Si desktop también está en columna, mantener flex-col (ya aplicado)
                    // No necesitamos agregar nada más
                  }
                }
              }
              
              // Limpiar espacios múltiples y clases vacías
              const finalClassArray = currentClass.split(/\s+/).filter(c => c.trim() && c !== 'md:' && c !== 'lg:' && c !== 'xl:' && c !== 'sm:');
              
              // IMPORTANTE: Asegurar que flex-col esté ANTES de cualquier md:flex-row
              // Reordenar clases para que flex-col esté primero
              const flexColIndex = finalClassArray.findIndex(c => c === 'flex-col' || c === 'flex-col-reverse');
              const mdFlexRowIndex = finalClassArray.findIndex(c => c.startsWith('md:flex-row'));
              
              if (flexColIndex !== -1 && mdFlexRowIndex !== -1 && flexColIndex > mdFlexRowIndex) {
                // Mover flex-col antes de md:flex-row
                const flexCol = finalClassArray[flexColIndex];
                finalClassArray.splice(flexColIndex, 1);
                finalClassArray.splice(mdFlexRowIndex, 0, flexCol);
              }
              
              currentClass = finalClassArray.join(' ').trim();
              
              // Remover estilos inline de flex-direction que puedan interferir
              el.style.removeProperty('flex-direction');
              
              // Forzar aplicación de clases directamente en el elemento
              el.className = currentClass;
              this.setAttributes({ class: currentClass });
              
              // Asegurar que flex-col esté aplicado (forzar si es necesario)
              if (!directionMobile) {
                // Si no hay dirección móvil específica, forzar flex-col
                // Remover cualquier flex-row directo primero
                el.classList.remove('flex-row', 'flex-row-reverse');
                
                // Asegurar que flex-col esté presente directamente (sin breakpoint)
                // Y que esté ANTES de cualquier md:flex-row
                if (!el.classList.contains('flex-col') && !el.classList.contains('flex-col-reverse')) {
                  // Insertar flex-col al principio de las clases de flex
                  const classList = Array.from(el.classList);
                  const flexIndex = classList.findIndex(c => c.startsWith('flex-') || c.startsWith('md:flex-'));
                  if (flexIndex !== -1) {
                    classList.splice(flexIndex, 0, 'flex-col');
                  } else {
                    classList.push('flex-col');
                  }
                  el.className = classList.join(' ');
                  this.setAttributes({ class: el.className });
                } else {
                  // Si ya existe flex-col, asegurarse de que esté antes de md:flex-row
                  const classList = Array.from(el.classList);
                  const flexCol = classList.find(c => c === 'flex-col' || c === 'flex-col-reverse');
                  const mdFlexRow = classList.find(c => c.startsWith('md:flex-row'));
                  
                  if (flexCol && mdFlexRow) {
                    const flexColIndex = classList.indexOf(flexCol);
                    const mdFlexRowIndex = classList.indexOf(mdFlexRow);
                    
                    if (flexColIndex > mdFlexRowIndex) {
                      classList.splice(flexColIndex, 1);
                      classList.splice(mdFlexRowIndex, 0, flexCol);
                      el.className = classList.join(' ');
                      this.setAttributes({ class: el.className });
                    }
                  }
                }
              }
              
              // Limpiar cualquier clase mal formada que pueda haber quedado
              const cleanClasses = Array.from(el.classList).filter(c => c && c.trim() && c !== 'md:' && c !== 'lg:' && c !== 'xl:' && c !== 'sm:');
              el.className = cleanClasses.join(' ');
              this.setAttributes({ class: el.className });
            }
          }
        },
        updateWrap() {
          const wrap = this.get('container-wrap') || 'flex-wrap';
          if (this.view && this.view.el) {
            const el = this.view.el;
            const currentAttrs = this.getAttributes();
            let currentClass = currentAttrs.class || el.className || '';
            if (!currentClass.includes('flex')) {
              currentClass = (currentClass + ' flex').trim();
            }
            currentClass = currentClass.replace(/flex-(wrap|nowrap)(-reverse)?/g, '').trim();
            currentClass = (currentClass + ' ' + wrap).trim();
            currentClass = currentClass.replace(/\s+/g, ' ');
            el.className = currentClass;
            this.setAttributes({ class: currentClass });
          }
        },
        updateJustify() {
          const justify = this.get('container-justify') || 'justify-start';
          if (this.view && this.view.el) {
            const el = this.view.el;
            const currentAttrs = this.getAttributes();
            let currentClass = currentAttrs.class || el.className || '';
            if (!currentClass.includes('flex')) {
              currentClass = (currentClass + ' flex').trim();
            }
            currentClass = currentClass.replace(/justify-(start|center|end|between|around|evenly)/g, '').trim();
            currentClass = (currentClass + ' ' + justify).trim();
            currentClass = currentClass.replace(/\s+/g, ' ');
            el.className = currentClass;
            this.setAttributes({ class: currentClass });
          }
        },
        updateAlign() {
          const align = this.get('container-align') || 'items-start';
          if (this.view && this.view.el) {
            const el = this.view.el;
            const currentAttrs = this.getAttributes();
            let currentClass = currentAttrs.class || el.className || '';
            if (!currentClass.includes('flex')) {
              currentClass = (currentClass + ' flex').trim();
            }
            currentClass = currentClass.replace(/items-(start|center|end|stretch|baseline)/g, '').trim();
            currentClass = (currentClass + ' ' + align).trim();
            currentClass = currentClass.replace(/\s+/g, ' ');
            el.className = currentClass;
            this.setAttributes({ class: currentClass });
          }
        },
        updateGap() {
          const gap = this.get('container-gap') || 'gap-4';
          const layoutMode = this.get('container-layout-mode') || 'flex';
          
          if (this.view && this.view.el) {
            const el = this.view.el;
            const currentAttrs = this.getAttributes();
            let currentClass = currentAttrs.class || el.className || '';
            
            // Remover gap anterior
            currentClass = currentClass.replace(/gap-[0-9]+/g, '').trim();
            
            // Agregar nuevo gap
            currentClass = (currentClass + ' ' + gap).trim();
            currentClass = currentClass.replace(/\s+/g, ' ');
            
            el.className = currentClass;
            this.setAttributes({ class: currentClass });
          }
        },
        updateWidth() {
          const width = this.get('container-width') || 'w-full';
          if (this.view && this.view.el) {
            const el = this.view.el;
            const currentAttrs = this.getAttributes();
            let currentClass = currentAttrs.class || el.className || '';
            if (!currentClass.includes('flex')) {
              currentClass = (currentClass + ' flex').trim();
            }
            currentClass = currentClass.replace(/w-(full|auto)|container|max-w-(7xl|6xl|4xl|2xl|xl)/g, '').trim();
            if (width) {
              currentClass = (currentClass + ' ' + width).trim();
            }
            currentClass = currentClass.replace(/\s+/g, ' ');
            el.className = currentClass;
            this.setAttributes({ class: currentClass });
          }
        },
        updatePadding() {
          const padding = this.get('container-padding') || 'p-6';
          if (this.view && this.view.el) {
            const el = this.view.el;
            const currentAttrs = this.getAttributes();
            let currentClass = currentAttrs.class || el.className || '';
            if (!currentClass.includes('flex')) {
              currentClass = (currentClass + ' flex').trim();
            }
            currentClass = currentClass.replace(/p-[0-9]+/g, '').trim();
            currentClass = (currentClass + ' ' + padding).trim();
            currentClass = currentClass.replace(/\s+/g, ' ');
            el.className = currentClass;
            this.setAttributes({ class: currentClass });
          }
        },
        updateMargin() {
          const margin = this.get('container-margin') || '';
          if (this.view && this.view.el) {
            const el = this.view.el;
            const currentAttrs = this.getAttributes();
            let currentClass = currentAttrs.class || el.className || '';
            if (!currentClass.includes('flex')) {
              currentClass = (currentClass + ' flex').trim();
            }
            currentClass = currentClass.replace(/mx-auto|m-[0-9]+/g, '').trim();
            if (margin) {
              currentClass = (currentClass + ' ' + margin).trim();
            }
            currentClass = currentClass.replace(/\s+/g, ' ');
            el.className = currentClass;
            this.setAttributes({ class: currentClass });
          }
        },
        updateChildrenResponsive() {
          // Función auxiliar para actualizar clases responsive de los hijos
          const layoutMode = this.get('container-layout-mode') || 'flex';
          if (layoutMode !== 'flex') return; // Solo para modo flex
          
          if (!this.view || !this.view.el) return;
          
          const components = this.components();
          const responsiveMode = this.get('container-children-responsive') || 'auto';
          const childCount = components.length;
          const directionMobile = this.get('container-direction-mobile') || '';
          const direction = this.get('container-direction') || 'flex-col'; // Por defecto: columna
          
          // Detectar si el contenedor está en columna
          const isColumnOnDesktop = direction === 'flex-col' || direction === 'flex-col-reverse';
          // En móvil, por defecto siempre se apilan verticalmente (flex-col) a menos que se especifique otra dirección
          const isColumnOnMobile = directionMobile === 'flex-col' || 
                                  directionMobile === 'flex-col-reverse' ||
                                  (directionMobile === ''); // Por defecto, móvil usa flex-col
          const isRowOnDesktop = direction === 'flex-row' || direction === 'flex-row-reverse';
          
          components.forEach((component, index) => {
            const childEl = component.view ? component.view.el : null;
            if (!childEl || !childEl.classList) return;
            
            // Remover clases responsive anteriores
            const classesToRemove = [
              'flex-1', 'flex-grow', 'flex-shrink', 'flex-basis-auto',
              'w-full', 'w-auto', 'w-1/2', 'w-1/3', 'w-1/4', 'w-2/3', 'w-3/4',
              'md:w-full', 'md:w-1/2', 'md:w-1/3', 'md:w-1/4', 'md:w-2/3', 'md:w-3/4',
              'lg:w-full', 'lg:w-1/2', 'lg:w-1/3', 'lg:w-1/4', 'lg:w-2/3', 'lg:w-3/4',
              'xl:w-full', 'xl:w-1/2', 'xl:w-1/3', 'xl:w-1/4', 'xl:w-2/3', 'xl:w-3/4',
              'sm:w-full', 'sm:w-1/2', 'sm:w-1/3', 'sm:w-1/4', 'sm:w-2/3', 'sm:w-3/4',
              'md:flex-1', 'lg:flex-1', 'xl:flex-1'
            ];
            classesToRemove.forEach(cls => childEl.classList.remove(cls));
            
            // SIEMPRE aplicar w-full en móvil (por defecto responsive)
            // Tailwind es mobile-first, así que w-full se aplica desde móvil
            childEl.classList.add('w-full');
            
            // Aplicar clases responsive según el modo (estilo Elementor)
            if (responsiveMode === 'full-width') {
              // En desktop: si está en fila, usar flex-1; si está en columna, mantener w-full
              if (isRowOnDesktop) {
                childEl.classList.add('md:flex-1');
              }
              // Si está en columna, ya tiene w-full aplicado
            } else if (responsiveMode === 'equal-responsive') {
              // En desktop: distribución equitativa según número de hijos (solo si está en fila)
              if (isRowOnDesktop) {
                if (childCount === 2) {
                  childEl.classList.add('md:w-1/2');
                } else if (childCount === 3) {
                  childEl.classList.add('md:w-1/2', 'lg:w-1/3');
                } else if (childCount === 4) {
                  childEl.classList.add('md:w-1/2', 'lg:w-1/4');
                } else if (childCount > 4) {
                  // Para más de 4 hijos, usar distribución flexible
                  childEl.classList.add('md:w-1/2', 'lg:w-1/3', 'xl:w-1/4');
                }
              }
              // Si está en columna, ya tiene w-full aplicado
            } else {
              // Modo automático: SIEMPRE w-full en móvil
              // En desktop: si está en fila, usar flex-1; si está en columna, mantener w-full
              if (isRowOnDesktop) {
                childEl.classList.add('md:flex-1');
              }
              // Si está en columna, ya tiene w-full aplicado
            }
            
            // Remover estilos inline de width para que las clases de Tailwind funcionen
            childEl.style.removeProperty('width');
            childEl.style.removeProperty('max-width');
            childEl.style.removeProperty('min-width');
          });
        }
      }
    });
    
  }
  
  if (typeof window !== 'undefined' && window.editor) {
    registerContainerComponent(window.editor);
  } else {
    const checkEditor = setInterval(() => {
      if (typeof window !== 'undefined' && window.editor) {
        registerContainerComponent(window.editor);
        clearInterval(checkEditor);
      }
    }, 100);
    
    setTimeout(() => {
      clearInterval(checkEditor);
    }, 10000);
  }
  
  if (typeof window !== 'undefined') {
    window.registerContainerComponent = registerContainerComponent;
  }
})();
