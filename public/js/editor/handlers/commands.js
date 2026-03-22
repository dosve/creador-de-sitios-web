
/**
 * Registra comandos personalizados en el editor
 * @param {object} editor - Instancia de GrapesJS
 */
export function registerEditorCommands(editor) {
  // Comando: set-device-desktop
  editor.Commands.add('set-device-desktop', {
    run(editor) {
      editor.setDevice('Desktop');
      setTimeout(() => {
        if (typeof window.updateTraitLabelsForDevice === 'function') {
          window.updateTraitLabelsForDevice(editor);
        }
        const selected = editor.getSelected();
        if (selected && editor.TraitManager) {
          editor.TraitManager.render();
          setTimeout(() => {
            if (typeof window.updateTraitLabelsForDevice === 'function') {
              window.updateTraitLabelsForDevice(editor);
            }
          }, 100);
        }
      }, 100);
    }
  });
  // Comando: set-device-tablet
  editor.Commands.add('set-device-tablet', {
    run(editor) {
      editor.setDevice('Tablet');
      setTimeout(() => {
        if (typeof window.updateTraitLabelsForDevice === 'function') {
          window.updateTraitLabelsForDevice(editor);
        }
        const selected = editor.getSelected();
        if (selected && editor.TraitManager) {
          editor.TraitManager.render();
          setTimeout(() => {
            if (typeof window.updateTraitLabelsForDevice === 'function') {
              window.updateTraitLabelsForDevice(editor);
            }
          }, 100);
        }
      }, 100);
    }
  });
  // Comando: set-device-mobile
  editor.Commands.add('set-device-mobile', {
    run(editor) {
      editor.setDevice('Mobile');
      setTimeout(() => {
        if (typeof window.updateTraitLabelsForDevice === 'function') {
          window.updateTraitLabelsForDevice(editor);
        }
        const selected = editor.getSelected();
        if (selected && editor.TraitManager) {
          editor.TraitManager.render();
          setTimeout(() => {
            if (typeof window.updateTraitLabelsForDevice === 'function') {
              window.updateTraitLabelsForDevice(editor);
            }
          }, 100);
        }
      }, 100);
    }
  });
  // Comando: sw-visibility
  editor.Commands.add('sw-visibility', {
    run(editor) {
      const canvas = editor.Canvas;
      const canvasEl = canvas.getElement();
      const toggleClass = 'gjs-hide-offsets';
      if (canvasEl.classList.contains(toggleClass)) {
        canvasEl.classList.remove(toggleClass);
      } else {
        canvasEl.classList.add(toggleClass);
      }
    }
  });
  // Comando: export-template
  editor.Commands.add('export-template', {
    run(editor) {
      const htmlContent = editor.getHtml();
      const cssContent = editor.getCss();
      const blob = new Blob([`<!DOCTYPE html>\n<html lang="es">\n<head>\n    <meta charset="UTF-8">\n    <meta name="viewport" content="width=device-width, initial-scale=1.0">\n    <title>Template Exportado</title>\n    <script src="https://cdn.tailwindcss.com"></script>\n    <style>${cssContent}</style>\n</head>\n<body>\n${htmlContent}\n</body>\n</html>`], { type: 'text/html' });
      const url = URL.createObjectURL(blob);
      const a = document.createElement('a');
      a.href = url;
      a.download = 'template.html';
      document.body.appendChild(a);
      a.click();
      document.body.removeChild(a);
      URL.revokeObjectURL(url);
    }
  });
}
