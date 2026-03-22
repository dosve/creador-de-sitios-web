// Inicialización avanzada del editor y managers

/**
 * Inicializa el editor y managers avanzados
 * @param {object} editorConfig - Configuración del editor
 */
export function initializeEditorAdvanced(editorConfig) {
  const editor = grapesjs.init(editorConfig);
  window.editor = editor;
  window.__editorInitialized = true;
  window.__hasUserEdits = false;
  window.__isEditorLoading = true;
  return editor;
}

/**
 * Inicializa managers manualmente
 * @param {object} editor - Instancia de GrapesJS
 */
export function initializeManagers(editor) {
  if (!editor) return;
  // StyleManager
  if (editor.StyleManager) {
    try {
      editor.StyleManager.render();
      setTimeout(() => {
        const styleContainer = document.querySelector('.styles-container');
        if (styleContainer) {
          styleContainer.removeEventListener('click', handleSectorClick);
          styleContainer.addEventListener('click', handleSectorClick);
        }
      }, 100);
    } catch (error) {}
  }
  // TraitManager
  if (editor.TraitManager) {
    try {
      editor.TraitManager.render();
    } catch (error) {}
  }
  // LayerManager
  if (editor.LayerManager) {
    try {
      const components = editor.getComponents();
      if (components && components.length > 0) {
        components.forEach((component, index) => {
          if (!component || !component.get) {
            components.remove(component);
          }
        });
      }
      editor.LayerManager.render();
    } catch (error) {}
  }
}
