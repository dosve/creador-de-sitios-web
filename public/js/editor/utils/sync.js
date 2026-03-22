// Sincronización visual y helpers

/**
 * Sincroniza overlays, background-image, botones y contenedores tras cargar el editor
 * @param {object} editor - Instancia de GrapesJS
 */
export function syncOnEditorLoad(editor) {
  editor.on('load', function () {
    // Wrapper principal droppable
    const wrapper = editor.DomComponents.getWrapper();
    if (wrapper) {
      wrapper.set({ droppable: true, selectable: true, hoverable: true }, { silent: false });
      wrapper.addAttributes({ 'data-gjs-droppable': 'true' });
      if (wrapper.view && wrapper.view.el) {
        wrapper.view.el.setAttribute('data-gjs-droppable', 'true');
      }
    }
    // Canvas permite drop
    const frameEl = editor.Canvas.getFrameEl();
    if (frameEl && frameEl.contentDocument && frameEl.contentDocument.body) {
      frameEl.contentDocument.body.addEventListener('dragover', (e) => {
        if (e && typeof e.preventDefault === 'function') e.preventDefault();
      }, true);
    }
    // Reinyectar overlays
    setTimeout(() => applyOverlayStylesToCanvas(editor), 300);
    // Sincronizar background-image
    syncEditorComponents(editor);
    // Sincronizar botones
    setTimeout(() => {
      const allComponents = editor.getComponents();
      const findButtons = (components) => {
        if (components && typeof components.forEach === 'function') {
          components.forEach((component) => {
            if (component && component.get && component.get('type') === 'button') {
              if (typeof component.syncInitialValues === 'function') {
                component.syncInitialValues();
                if (component.view && component.view.el) component.view.render();
              }
            }
            if (component && component.components) {
              const childComponents = component.components();
              if (childComponents && childComponents.length > 0) findButtons(childComponents);
            }
          });
        }
      };
      findButtons(allComponents);
      // Sincronizar contenedores
      const findContainers = (components) => {
        if (!components) return;
        try {
          if (typeof components.each === 'function') {
            components.each((component) => {
              if (component && component.get && component.get('type') === 'container') {
                if (component.view && component.view.el) {
                  const el = component.view.el;
                  if (!el.className.includes('container-flex')) el.classList.add('container-flex');
                  if (!el.className.includes('flex')) el.classList.add('flex');
                }
              }
              if (component && component.components) {
                const childComponents = component.components();
                if (childComponents && childComponents.length > 0) findContainers(childComponents);
              }
            });
          }
        } catch (error) {}
      };
      findContainers(allComponents);
    }, 500);
  });
}

/**
 * Sincroniza botones, contenedores y background-image tras cargar el editor
 * @param {object} editor - Instancia de GrapesJS
 */
export function syncEditorComponents(editor) {
  if (!editor) return;
  // Sincronización de overlays
  setTimeout(() => {
    // Sincronizar background-image
    const allComponents = editor.getComponents();
    const findBackgroundImage = (components) => {
      if (components && typeof components.forEach === 'function') {
        components.forEach((component) => {
          if (component && component.get && component.get('type') === 'background-image') {
            if (component.view && component.view.el) {
              const titleEl = component.view.el.querySelector('h2');
              const textEl = component.view.el.querySelector('p');
              const buttonEl = component.view.el.querySelector('button, a');
              if (titleEl) component.set('content-title', titleEl.textContent.trim(), { silent: false });
              if (textEl) component.set('content-text', textEl.textContent.trim(), { silent: false });
              if (buttonEl) {
                component.set('button-text', buttonEl.textContent.trim(), { silent: false });
                const href = buttonEl.getAttribute('href');
                if (href) component.set('button-link', href, { silent: false });
                else if (buttonEl.tagName === 'BUTTON') component.set('button-link', '#', { silent: false });
              }
              setTimeout(() => { if (editor.TraitManager) editor.TraitManager.render(); }, 200);
            }
          }
          if (component && component.components) {
            const childComponents = component.components();
            if (childComponents) findBackgroundImage(childComponents);
          }
        });
      }
    };
    findBackgroundImage(allComponents);
  }, 500);
}

/**
 * Sincroniza inputs y sectores del StyleManager en paneles visibles
 * @param {object} editor - Instancia de GrapesJS
 */
export function syncStyleManagerPanel(editor) {
  setTimeout(() => {
    const stylesContainer = document.querySelector('.styles-container');
    const stylesContainerWidget = document.querySelector('.styles-container-widget');
    if (stylesContainer && stylesContainerWidget) {
      stylesContainerWidget.innerHTML = stylesContainer.innerHTML;
      const sectors = stylesContainerWidget.querySelectorAll('.gjs-sm-sector');
      sectors.forEach((sector, index) => {
        const header = sector.querySelector('.gjs-sm-sector-title, .gjs-sm-title');
        if (header) {
          header.style.cursor = 'pointer';
          header.addEventListener('click', function (e) {
            e.stopPropagation();
            const properties = sector.querySelector('.gjs-sm-properties');
            const caret = header.querySelector('.gjs-sm-sector-caret, .fa-caret-right, .fa-caret-down');
            if (properties) {
              const isCurrentlyHidden = properties.style.display === 'none' || window.getComputedStyle(properties).display === 'none';
              if (isCurrentlyHidden) {
                properties.style.setProperty('display', 'block', 'important');
              } else {
                properties.style.setProperty('display', 'none', 'important');
              }
              if (caret) {
                if (isCurrentlyHidden) {
                  caret.classList.remove('fa-caret-right');
                  caret.classList.add('fa-caret-down');
                } else {
                  caret.classList.remove('fa-caret-down');
                  caret.classList.add('fa-caret-right');
                }
              }
            }
          });
        }
      });
      const inputs = stylesContainerWidget.querySelectorAll('input, select, textarea');
      inputs.forEach(input => {
        ['input', 'change'].forEach(eventType => {
          input.addEventListener(eventType, function () {
            const propertyName = this.getAttribute('data-property') || this.name;
            if (propertyName) {
              const originalInput = stylesContainer.querySelector(`[data-property="${propertyName}"], [name="${propertyName}"]`);
              if (originalInput) {
                originalInput.value = this.value;
                const changeEvent = new Event('change', { bubbles: true });
                const inputEvent = new Event('input', { bubbles: true });
                originalInput.dispatchEvent(inputEvent);
                originalInput.dispatchEvent(changeEvent);
              }
            }
          });
        });
      });
    }
  }, 50);
}
