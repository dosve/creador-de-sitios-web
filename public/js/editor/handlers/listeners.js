// Listeners y eventos globales del editor

/**
 * Registra listeners globales en el editor
 * @param {object} editor - Instancia de GrapesJS
 */
export function registerGlobalListeners(editor) {
  if (!editor) return;
  // Cambios del usuario
  const markUserEdits = () => {
    if (window.__isEditorLoading) return;
    window.__hasUserEdits = true;
  };
  editor.on('component:add', markUserEdits);
  editor.on('component:update', markUserEdits);
  editor.on('component:styleUpdate', markUserEdits);
  editor.on('component:change:attributes', markUserEdits);
  // Fin de carga
  editor.on('load', () => {
    setTimeout(() => {
      window.__isEditorLoading = false;
    }, 300);
  });
  // Listener para componentes seleccionados
  editor.on('component:selected', (component) => {
    if (!component || typeof component.get !== 'function') return;
    // Actualizar StyleManager y TraitManager
    setTimeout(() => {
      if (editor.StyleManager) {
        try { editor.StyleManager.render(); } catch (error) {}
      }
      if (editor.TraitManager) {
        try { editor.TraitManager.render(); } catch (error) {}
      }
    }, 100);
  });
}
