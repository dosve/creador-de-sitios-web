// Módulo del Componente Section Inner
// Componente para contenedor de grid de columnas

(function() {
  'use strict';
  
  function registerSectionInnerComponent(editor) {
    if (!editor || !editor.DomComponents) {
      console.warn('⚠️ Editor no disponible para registrar componente Section Inner');
      return;
    }
    
    editor.DomComponents.addType('section-inner', {
      model: {
        defaults: {
          name: 'Grid de Columnas',
          icon: '<i class="fa fa-th"></i>',
          droppable: true
        }
      }
    });
    
  }
  
  if (typeof window !== 'undefined' && window.editor) {
    registerSectionInnerComponent(window.editor);
  } else {
    const checkEditor = setInterval(() => {
      if (typeof window !== 'undefined' && window.editor) {
        registerSectionInnerComponent(window.editor);
        clearInterval(checkEditor);
      }
    }, 100);
    
    setTimeout(() => {
      clearInterval(checkEditor);
    }, 10000);
  }
  
  if (typeof window !== 'undefined') {
    window.registerSectionInnerComponent = registerSectionInnerComponent;
  }
})();
