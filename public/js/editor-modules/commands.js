// Módulo de Comandos del Editor
// Contiene los comandos personalizados de GrapeJS

const EditorCommands = {
  getCommands: function() {
    return {
      'set-device-desktop': {
        run: editor => editor.setDevice('Desktop')
      },
      'set-device-tablet': {
        run: editor => editor.setDevice('Tablet')
      },
      'set-device-mobile': {
        run: editor => editor.setDevice('Mobile')
      },
      'sw-visibility': {
        run: editor => {
          const canvas = editor.Canvas;
          const canvasEl = canvas.getElement();
          const toggleClass = 'gjs-hide-offsets';

          if (canvasEl.classList.contains(toggleClass)) {
            canvasEl.classList.remove(toggleClass);
          } else {
            canvasEl.classList.add(toggleClass);
          }
        }
      },
      'export-template': {
        run: editor => {
          const htmlContent = editor.getHtml();
          const cssContent = editor.getCss();

          const blob = new Blob([`<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Template Exportado</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>${cssContent}</style>
</head>
<body>
${htmlContent}
</body>
</html>`], { type: 'text/html' });

          const url = URL.createObjectURL(blob);
          const a = document.createElement('a');
          a.href = url;
          a.download = 'template.html';
          document.body.appendChild(a);
          a.click();
          document.body.removeChild(a);
          URL.revokeObjectURL(url);
        }
      }
    };
  }
};
