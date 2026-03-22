// Lógica de overlays y sincronización visual para GrapesJS

/**
 * Aplica estilos de overlay al canvas del editor
 * @param {object} editor - Instancia de GrapesJS
 */
export function applyOverlayStylesToCanvas(editor) {
  const frameEl = editor.Canvas.getFrameEl();
  const doc = frameEl && frameEl.contentDocument;
  if (!doc) return;
  const wrapper = editor.DomComponents.getWrapper();
  if (wrapper) {
    const containers = wrapper.find('*').filter(c => c.get('type') === 'container');
    containers.forEach(c => {
      if (typeof c.updateBackground === 'function') {
        c.updateBackground();
      }
    });
  }
  const css = window.collectOverlayCSS ? window.collectOverlayCSS(editor) : '';
  if (!css) return;
  let styleTag = doc.getElementById('overlay-styles');
  if (!styleTag) {
    styleTag = doc.createElement('style');
    styleTag.id = 'overlay-styles';
    doc.head.appendChild(styleTag);
  }
  styleTag.textContent = css;
}
