// Lógica de drag & drop para el editor

export function initDragDrop(editor) {
  // Variables para el estado de drag
  let isDraggingBlock = false;
  let lastHoveredElement = null;

  // Detectar cuando comienza el drag de un bloque
  editor.on('block:drag:start', function () {
    isDraggingBlock = true;
  });

  // Detectar cuando termina el drag
  editor.on('block:drag:stop', function () {
    isDraggingBlock = false;
    // Limpiar clases temporales
    if (lastHoveredElement) {
      lastHoveredElement.classList.remove('gjs-droppable-active');
      lastHoveredElement = null;
    }
  });

  // Agregar listeners al canvas para detectar dragover y mouseover
  setTimeout(() => {
    const canvasFrame = editor.Canvas.getFrameEl();
    if (canvasFrame && canvasFrame.contentDocument) {
      const frameDoc = canvasFrame.contentDocument;
      const handleDragOver = (e) => {
        if (!isDraggingBlock) return;
        const target = e.target;
        if (!target) return;
        // Buscar el elemento contenedor más cercano
        const findContainerElement = (el) => {
          if (!el) return null;
          const isContainer = el.classList && (
            el.classList.contains('container-flex') ||
            el.getAttribute('data-gjs-type') === 'container'
          );
          if (isContainer && el.getAttribute('data-gjs-droppable') === 'true') {
            return el;
          }
          return findContainerElement(el.parentElement);
        };
        const containerEl = findContainerElement(target);
        if (containerEl) {
          if (lastHoveredElement && lastHoveredElement !== containerEl) {
            lastHoveredElement.classList.remove('gjs-droppable-active');
          }
          containerEl.classList.add('gjs-droppable-active');
          lastHoveredElement = containerEl;
        }
      };
      // Listeners para dragover y mouseover
      if (frameDoc.body) {
        frameDoc.body.addEventListener('dragover', handleDragOver, true);
        frameDoc.body.addEventListener('mouseover', handleDragOver, true);
      }
    }
  }, 500);
}
