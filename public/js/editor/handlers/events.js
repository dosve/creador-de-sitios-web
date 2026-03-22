
/**
 * Registra eventos globales en el editor
 * @param {object} editor - Instancia de GrapesJS
 */
export function registerEditorEvents(editor) {
  // Evento: componente seleccionado
  editor.on('component:selected', (component) => {
    if (!component || typeof component.get !== 'function') return;
    const componentType = component.get('type');
    // Logging especial para containers
    if (componentType === 'container') {
      if (typeof component.updateVisibleTraitsForDevice === 'function') {
        component.updateVisibleTraitsForDevice();
      }
    }
    // Actualizar StyleManager y TraitManager
    setTimeout(() => {
      if (editor.StyleManager) {
        try {
          editor.StyleManager.render();
          const stylesContainer = document.querySelector('.styles-container');
          const stylesContainerWidget = document.querySelector('.styles-container-widget');
          if (stylesContainer && stylesContainerWidget) {
            stylesContainerWidget.innerHTML = stylesContainer.innerHTML;
          }
        } catch (error) {}
      }
      if (editor.TraitManager) {
        try {
          editor.TraitManager.render();
        } catch (error) {}
      }
    }, 100);
  });
  // Agrega aquí más eventos globales según tu lógica
}
