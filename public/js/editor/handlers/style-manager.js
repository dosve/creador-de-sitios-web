
/**
 * Inicializa y renderiza el StyleManager del editor.
 * Debe llamarse después de la inicialización del editor.
 * @param {object} editor - Instancia de GrapesJS editor
 */
export function initializeStyleManager(editor) {
  if (!editor || !editor.StyleManager) {
    console.warn('⚠️ StyleManager no disponible');
    return;
  }
  try {
    editor.StyleManager.render();
    // Agregar event listeners después del renderizado
    setTimeout(() => {
      const styleContainer = document.querySelector('.styles-container');
      if (styleContainer) {
        // Remover listeners anteriores si existen
        styleContainer.removeEventListener('click', handleSectorClick);
        // Agregar nuevo listener
        styleContainer.addEventListener('click', handleSectorClick);
      }
    }, 100);
  } catch (error) {
    console.error('❌ Error renderizando StyleManager:', error);
  }
}

/**
 * Handler para clic en sectores del StyleManager
 * @param {Event} e
 */
export function handleSectorClick(e) {
  const sectorTitle = e.target.closest('.gjs-sm-title');
  if (sectorTitle) {
    const sector = sectorTitle.closest('.gjs-sm-sector');
    if (sector) {
      // Toggle del estado del sector
      if (sector.classList.contains('gjs-sm-open')) {
        sector.classList.remove('gjs-sm-open');
      } else {
        sector.classList.add('gjs-sm-open');
      }
    }
  }
}
