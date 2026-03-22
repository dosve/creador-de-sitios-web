// UI helpers for editor

/**
 * Oculta el indicador de carga y muestra el editor
 */
export function showEditorUI() {
  const loadingIndicator = document.getElementById('loading-indicator');
  const editorContainer = document.getElementById('gjs');
  if (loadingIndicator) loadingIndicator.style.display = 'none';
  if (editorContainer) editorContainer.style.display = 'block';
}
