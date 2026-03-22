/**
 * Marca cambios del usuario en el editor
 * @param {object} editor
 */
export function markUserEdits(editor) {
  if (window.__isEditorLoading) return;
  window.__hasUserEdits = true;
}

/**
 * Corrige clases responsive de contenedores
 * @param {object} editor
 * @param {object} options
 */
export function fixContainerResponsiveClasses(editor, options = {}) {
  // Lógica de corrección (placeholder)
  // ...
  return true;
}
