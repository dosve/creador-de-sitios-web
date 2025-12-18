// Módulo del Componente Link
// Componente de enlace estilo Elementor con traits y protección

(function() {
  'use strict';
  
  function registerLinkComponent(editor) {
    if (!editor || !editor.DomComponents) {
      console.warn('⚠️ Editor no disponible para registrar componente Link');
      return;
    }
    
    editor.DomComponents.addType('link', {
      isComponent: (el) => {
        if (el.classList && el.classList.contains('link-component')) {
          return { type: 'link' };
        }
        if (el.tagName === 'A' && !el.classList.contains('button-component')) {
          return { type: 'link' };
        }
        return false;
      },
      model: {
        defaults: {
          name: 'Enlace',
          tagName: 'a',
          editable: false,
          droppable: false,
          removable: true,
          selectable: true,
          attributes: {
            href: '#',
            class: 'link-component text-blue-600 underline hover:text-blue-800',
            'data-gjs-name': 'Enlace',
            'data-gjs-editable': 'false'
          },
          traits: [
            {
              type: 'text',
              name: 'link-text',
              label: 'Texto del Enlace',
              changeProp: 1,
              placeholder: 'Ingresa el texto del enlace'
            },
            {
              type: 'text',
              name: 'link-href',
              label: 'URL del Enlace',
              changeProp: 1,
              placeholder: 'https://ejemplo.com'
            },
            {
              type: 'select',
              name: 'link-target',
              label: 'Destino',
              changeProp: 1,
              options: [
                { value: '_self', name: 'Misma Ventana' },
                { value: '_blank', name: 'Nueva Ventana/Pestaña' },
                { value: '_parent', name: 'Marco Padre' },
                { value: '_top', name: 'Ventana Superior' }
              ]
            },
            {
              type: 'select',
              name: 'link-rel',
              label: 'Relación',
              changeProp: 1,
              options: [
                { value: '', name: 'Ninguna' },
                { value: 'nofollow', name: 'No Seguir (nofollow)' },
                { value: 'noopener', name: 'No Abridor (noopener)' },
                { value: 'noreferrer', name: 'No Referencia (noreferrer)' },
                { value: 'nofollow noopener', name: 'No Seguir + No Abridor' }
              ]
            },
            {
              type: 'text',
              name: 'link-title',
              label: 'Título (Tooltip)',
              changeProp: 1,
              placeholder: 'Aparece al pasar el cursor'
            },
            {
              type: 'select',
              name: 'link-style',
              label: 'Estilo del Enlace',
              changeProp: 1,
              options: [
                { value: 'text-blue-600 underline hover:text-blue-800', name: 'Subrayado Azul' },
                { value: 'text-gray-600 underline hover:text-gray-800', name: 'Subrayado Gris' },
                { value: 'text-green-600 underline hover:text-green-800', name: 'Subrayado Verde' },
                { value: 'text-blue-600 no-underline hover:text-blue-800', name: 'Sin Subrayado Azul' },
                { value: 'text-gray-600 no-underline hover:text-gray-800', name: 'Sin Subrayado Gris' }
              ]
            },
            {
              type: 'select',
              name: 'link-size',
              label: 'Tamaño del Texto',
              changeProp: 1,
              options: [
                { value: 'text-sm', name: 'Pequeño (14px)' },
                { value: 'text-base', name: 'Normal (16px)' },
                { value: 'text-lg', name: 'Grande (18px)' },
                { value: 'text-xl', name: 'Extra Grande (20px)' }
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
                this.set('link-text', textContent.trim(), { silent: true });
              }
              
              const href = el.getAttribute('href') || '#';
              if (href !== '#') {
                this.set('link-href', href, { silent: true });
              }
              
              const target = el.getAttribute('target') || '_self';
              this.set('link-target', target, { silent: true });
              
              const rel = el.getAttribute('rel') || '';
              if (rel) {
                this.set('link-rel', rel, { silent: true });
              }
              
              const title = el.getAttribute('title') || '';
              if (title) {
                this.set('link-title', title, { silent: true });
              }
              
              const classList = (el.className || '').split(' ').filter(c => c.trim());
              const styleMatch = classList.find(c => 
                c.includes('text-') && (c.includes('blue') || c.includes('gray') || c.includes('green'))
              );
              if (styleMatch) {
                const hasUnderline = classList.includes('underline');
                const hasNoUnderline = classList.includes('no-underline');
                let styleValue = styleMatch;
                if (hasUnderline) {
                  styleValue += ' underline';
                } else if (hasNoUnderline) {
                  styleValue += ' no-underline';
                }
                const hoverMatch = classList.find(c => c.startsWith('hover:text-'));
                if (hoverMatch) {
                  styleValue += ' ' + hoverMatch;
                }
                this.set('link-style', styleValue, { silent: true });
              }
              
              const sizeMatch = classList.find(c => ['text-sm', 'text-base', 'text-lg', 'text-xl'].includes(c));
              if (sizeMatch) {
                this.set('link-size', sizeMatch, { silent: true });
              }
            }
          };
          
          setTimeout(syncInitialValues, 100);
          this.on('component:mount', syncInitialValues);
          this.on('component:selected', syncInitialValues);
          
          this.on('change:link-text', this.updateText, this);
          this.on('change:link-href', this.updateHref, this);
          this.on('change:link-target', this.updateTarget, this);
          this.on('change:link-rel', this.updateRel, this);
          this.on('change:link-title', this.updateTitle, this);
          this.on('change:link-style', this.updateStyle, this);
          this.on('change:link-size', this.updateSize, this);
        },
        updateText() {
          const text = this.get('link-text') || 'Enlace de ejemplo';
          if (this.view && this.view.el) {
            this.view.el.textContent = text;
            this.set('content', text);
          }
        },
        updateHref() {
          const href = this.get('link-href') || '#';
          if (this.view && this.view.el) {
            this.view.el.setAttribute('href', href);
            this.addAttributes({ href: href });
          }
        },
        updateTarget() {
          const target = this.get('link-target') || '_self';
          if (this.view && this.view.el) {
            this.view.el.setAttribute('target', target);
            this.addAttributes({ target: target });
          }
        },
        updateRel() {
          const rel = this.get('link-rel') || '';
          if (this.view && this.view.el) {
            if (rel) {
              this.view.el.setAttribute('rel', rel);
              this.addAttributes({ rel: rel });
            } else {
              this.view.el.removeAttribute('rel');
              const attrs = this.getAttributes();
              delete attrs.rel;
              this.setAttributes(attrs);
            }
          }
        },
        updateTitle() {
          const title = this.get('link-title') || '';
          if (this.view && this.view.el) {
            if (title) {
              this.view.el.setAttribute('title', title);
              this.addAttributes({ title: title });
            } else {
              this.view.el.removeAttribute('title');
              const attrs = this.getAttributes();
              delete attrs.title;
              this.setAttributes(attrs);
            }
          }
        },
        updateStyle() {
          const style = this.get('link-style') || 'text-blue-600 underline hover:text-blue-800';
          if (this.view && this.view.el) {
            const el = this.view.el;
            const currentAttrs = this.getAttributes();
            let currentClass = currentAttrs.class || el.className || '';
            
            // Remover estilos anteriores
            currentClass = currentClass.replace(/text-(blue|gray|green)-\d+/g, '').trim();
            currentClass = currentClass.replace(/underline|no-underline/g, '').trim();
            currentClass = currentClass.replace(/hover:text-(blue|gray|green)-\d+/g, '').trim();
            
            // Agregar nuevo estilo
            currentClass = (currentClass + ' ' + style).trim().replace(/\s+/g, ' ');
            
            el.className = currentClass;
            this.setAttributes({ class: currentClass });
          }
        },
        updateSize() {
          const size = this.get('link-size') || 'text-base';
          if (this.view && this.view.el) {
            const el = this.view.el;
            const currentAttrs = this.getAttributes();
            let currentClass = currentAttrs.class || el.className || '';
            
            // Remover tamaños anteriores
            currentClass = currentClass.replace(/text-(sm|base|lg|xl)/g, '').trim();
            
            // Agregar nuevo tamaño
            currentClass = (currentClass + ' ' + size).trim().replace(/\s+/g, ' ');
            
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
    registerLinkComponent(window.editor);
  } else {
    const checkEditor = setInterval(() => {
      if (typeof window !== 'undefined' && window.editor) {
        registerLinkComponent(window.editor);
        clearInterval(checkEditor);
      }
    }, 100);
    
    setTimeout(() => {
      clearInterval(checkEditor);
    }, 10000);
  }
  
  if (typeof window !== 'undefined') {
    window.registerLinkComponent = registerLinkComponent;
  }
})();
