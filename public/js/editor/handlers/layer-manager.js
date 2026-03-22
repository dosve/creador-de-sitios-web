// LayerManager handler module

/**
 * Inicializa y renderiza el LayerManager del editor.
 * @param {object} editor - Instancia de GrapesJS editor
 */
export function initializeLayerManager(editor) {
  if (!editor || !editor.LayerManager) {
    console.warn('⚠️ LayerManager no disponible');
    return;
  }
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
  } catch (error) {
    console.error('❌ Error renderizando LayerManager:', error);
  }
}
