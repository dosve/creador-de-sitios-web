// Módulo del Componente Column
// Componente para columna dentro de un grid

(function() {
  'use strict';
  
  function registerColumnComponent(editor) {
    if (!editor || !editor.DomComponents) {
      console.warn('⚠️ Editor no disponible para registrar componente Column');
      return;
    }
    
    editor.DomComponents.addType('column', {
      model: {
        defaults: {
          name: 'Columna',
          icon: '<i class="fa fa-square"></i>',
          droppable: true
        }
      }
    });
    
  }
  
  if (typeof window !== 'undefined' && window.editor) {
    registerColumnComponent(window.editor);
  } else {
    const checkEditor = setInterval(() => {
      if (typeof window !== 'undefined' && window.editor) {
        registerColumnComponent(window.editor);
        clearInterval(checkEditor);
      }
    }, 100);
    
    setTimeout(() => {
      clearInterval(checkEditor);
    }, 10000);
  }
  
  if (typeof window !== 'undefined') {
    window.registerColumnComponent = registerColumnComponent;
  }
})();
