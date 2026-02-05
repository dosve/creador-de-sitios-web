// Módulo del Componente Column
// Componente para columna dentro de un grid con soporte responsivo completo
// IMPORTANTE: Por defecto es w-full en móvil y se adapta en desktop

(function() {
  'use strict';
  
  function registerColumnComponent(editor) {
    if (!editor || !editor.DomComponents) {
      console.warn('⚠️ Editor no disponible para registrar componente Column');
      return;
    }
    
    editor.DomComponents.addType('column', {
      isComponent: (el) => {
        if (el.classList && el.classList.contains('column-flex')) {
          return { type: 'column' };
        }
        return false;
      },
      model: {
        defaults: {
          name: 'Columna',
          tagName: 'div',
          icon: '<i class="fa fa-square"></i>',
          droppable: true,
          draggable: true,
          removable: true,
          selectable: true,
          'column-width-desktop': 'md:w-1/3',
          'column-width-mobile': 'w-full',
          attributes: {
            // ✅ IMPORTANTE: Siempre empezar con w-full (móvil), luego agregar md: para desktop
            class: 'column-flex flex flex-col w-full md:w-1/3 gap-4',
            'data-gjs-name': 'Columna',
          },
          traits: [
            {
              type: 'select',
              name: 'column-width-mobile',
              label: '📱 Ancho en Móvil',
              changeProp: 1,
              options: [
                { value: 'w-full', name: 'Ancho Completo (100%) - RECOMENDADO' },
                { value: 'w-auto', name: 'Automático' }
              ]
            },
            {
              type: 'select',
              name: 'column-width-desktop',
              label: '🖥️ Ancho en Desktop (md y superior)',
              changeProp: 1,
              options: [
                { value: 'md:w-full', name: 'Ancho Completo (100%)' },
                { value: 'md:w-auto', name: 'Automático' },
                { value: 'md:w-1/2', name: '50% (2 columnas)' },
                { value: 'md:w-1/3', name: '33.33% (3 columnas) - RECOMENDADO' },
                { value: 'md:w-1/4', name: '25% (4 columnas)' },
                { value: 'md:w-2/3', name: '66.66%' },
                { value: 'md:w-3/4', name: '75%' }
              ]
            },
            {
              type: 'select',
              name: 'column-width-lg',
              label: '💻 Ancho en Desktop Grande (lg)',
              changeProp: 1,
              options: [
                { value: '', name: 'Heredar de md' },
                { value: 'lg:w-full', name: 'Ancho Completo (100%)' },
                { value: 'lg:w-1/2', name: '50%' },
                { value: 'lg:w-1/3', name: '33.33%' },
                { value: 'lg:w-1/4', name: '25%' }
              ]
            }
          ]
        },
        init() {
          this.on('change:column-width-mobile', this.updateColumnClasses, this);
          this.on('change:column-width-desktop', this.updateColumnClasses, this);
          this.on('change:column-width-lg', this.updateColumnClasses, this);
          
          // Sincronizar valores iniciales
          setTimeout(() => {
            this.syncInitialValues();
          }, 100);
          
          this.on('component:mount', () => {
            this.syncInitialValues();
          });
        },
        syncInitialValues() {
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          const classList = el.className.split(' ').filter(c => c.trim());
          
          // Buscar clases de ancho móvil (sin prefijo)
          const mobileMatch = classList.find(c => c === 'w-full' || c === 'w-auto');
          if (mobileMatch) {
            this.set('column-width-mobile', mobileMatch, { silent: true });
          }
          
          // Buscar clases de ancho desktop (con prefijo md:)
          const desktopMatch = classList.find(c => c.match(/^md:w-/));
          if (desktopMatch) {
            this.set('column-width-desktop', desktopMatch, { silent: true });
          }
          
          // Buscar clases de ancho lg
          const lgMatch = classList.find(c => c.match(/^lg:w-/));
          if (lgMatch) {
            this.set('column-width-lg', lgMatch, { silent: true });
          }
        },
        updateColumnClasses() {
          if (!this.view || !this.view.el) return;
          
          const el = this.view.el;
          const currentClass = el.className;
          
          // Remover TODAS las clases de ancho previas (incluyendo responsivas)
          const classList = currentClass.split(/\s+/).filter(c => {
            return c && 
                   !c.match(/^w-/) && 
                   !c.match(/^md:w-/) && 
                   !c.match(/^lg:w-/) &&
                   !c.match(/^xl:w-/);
          });
          
          // Agregar clase de móvil (siempre necesaria como base)
          const mobileWidth = this.get('column-width-mobile') || 'w-full';
          classList.push(mobileWidth);
          
          // Agregar clase de desktop si está configurada
          const desktopWidth = this.get('column-width-desktop');
          if (desktopWidth) {
            classList.push(desktopWidth);
          }
          
          // Agregar clase de lg si está configurada
          const lgWidth = this.get('column-width-lg');
          if (lgWidth) {
            classList.push(lgWidth);
          }
          
          const newClass = classList.filter(c => c).join(' ').replace(/\s+/g, ' ').trim();
          
          el.className = newClass;
          this.setAttributes({ class: newClass });
          
          console.log('✅ [Column] Clases actualizadas:', newClass);
        }
      }
    });
    
  }
  
  if (typeof window !== 'undefined' && window.editor) {
    registerColumnComponent(window.editor);
  } else {
    const checkEditor = setInterval(() => {
      if (typeof window !== 'undefined' && window.editor) {
        registerColumnComponent(window.editor);
        clearInterval(checkEditor);
      }
    }, 100);
    
    setTimeout(() => {
      clearInterval(checkEditor);
    }, 10000);
  }
  
  if (typeof window !== 'undefined') {
    window.registerColumnComponent = registerColumnComponent;
  }
})();
