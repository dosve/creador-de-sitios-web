// Helpers para paneles y UI

/**
 * Oculta el indicador de carga y muestra el editor
 */
export function showEditorUI() {
  const loadingIndicator = document.getElementById('loading-indicator');
  const editorContainer = document.getElementById('gjs');
  if (loadingIndicator) loadingIndicator.style.display = 'none';
  if (editorContainer) editorContainer.style.display = 'block';
}

/**
 * Limpia paneles vacíos o sin contenido
 */
export function cleanEmptyPanels() {
  setTimeout(() => {
    const blocks = document.querySelectorAll('.gjs-block');
    blocks.forEach(block => {
      const label = block.querySelector('.gjs-block-label');
      const hasVisibleContent = label && label.textContent.trim().length > 0;
      const hasIcon = block.querySelector('svg, img, .gjs-block-svg');
      if (!hasVisibleContent && !hasIcon) {
        block.style.display = 'none';
      }
    });
  }, 1000);
}
